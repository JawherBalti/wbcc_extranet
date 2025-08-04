<?php
namespace App\Libraries;

use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\FeatureExtraction\StopWords;

class CompanyRecognizer {
   private $vectorizer;
    private $transformer;
    private $classifier;
    private $companyPatterns = [
        '/société[:]?\s*(.+)/i',
        '/\b(WBCC\s*ASSISTANCE)\b/i',
        '/\b(WORLD\s*BUSINESS\s*CONTACT\s*CENTER)\b/i',
        '/\b(Cabinet)\b/i',
        '/\b(CABINET)\b/i',
        '/\b(BRUNO)\b/i',
        '/\b(CABINET\s*BRUNO)\b/i',
        '/\b(ABEILLE\s*ASSURANCES)\b/i',
        '/\b(RELAIS\s*HABITAT)\b/i',
        '/\b(RELAIS\s*HABITAT\s*SYNDIC\s*DE\s*REDRESSEMENT)\b/i',
        '/RHSR/i', // With context this likely means Relais Habitat Syndique de Redressement
    
    ];
    
    public function __construct() {
        $stopWords = new StopWords([
            'le', 'la', 'les', 'de', 'des', 'un', 'une', 'et', 'à', 'dans',
            'pour', 'au', 'aux', 'avec', 'sur', 'par', 'est', 'son', 'ses'
        ]);
        
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer(), $stopWords);
        $this->transformer = new TfIdfTransformer();
        $this->classifier = new SVC(Kernel::RBF, 0.5);
    }

    public function train(array $samples, array $labels): void {
        // First make a copy of samples since transform() works in-place
        $workingSamples = $samples;
        
        // Vectorize the text
        $this->vectorizer->fit($workingSamples);
        $this->vectorizer->transform($workingSamples);
        
        // Transform with TF-IDF
        $this->transformer->fit($workingSamples);
        $this->transformer->transform($workingSamples);
        
        // Train classifier
        $this->classifier->train($workingSamples, $labels);
        
        $this->learnPatternsFromData($samples, $labels);
    }
    
public function predictCompany(string $text): string {
    // First try exact matches from learned patterns
    foreach ($this->companyPatterns as $pattern) {
        if (preg_match($pattern, $text, $matches)) {
            $company = trim($matches[1] ?? $matches[0]);
            if ($this->isValidCompanyName($company)) {
                return $company;
            }
        }
    }
    
    // Then use ML prediction if available
    if ($this->classifier) {
        try {
            $vectorized = [$text];
            $this->vectorizer->transform($vectorized);
            $this->transformer->transform($vectorized);
            $prediction = $this->classifier->predict($vectorized);
            
            $company = $prediction[0] ?? 'Unknown';
            if ($this->isValidCompanyName($company)) {
                return $company;
            }
        } catch (Exception $e) {
            // Log error but continue
            error_log("ML prediction failed: " . $e->getMessage());
        }
    }
    
    // Final fallback - scan for potential company names
    return $this->findPotentialCompanyName($text) ?? 'Unknown';
}

private function findPotentialCompanyName(string $text): ?string {
    // Look for ALL CAPS or Capitalized multi-word phrases
    if (preg_match_all('/((?:[A-Z][a-zA-Z0-9&]+\s+){1,}[A-Z][a-zA-Z0-9&]+)/', $text, $matches)) {
        foreach ($matches[1] as $candidate) {
            if ($this->isValidCompanyName($candidate)) {
                return $candidate;
            }
        }
    }
    
    // Look for phrases before common suffixes
    if (preg_match_all('/([A-Z][a-zA-Z0-9& ]+?)\s+(?:SA|SAS|SARL|GmbH|Inc|Ltd|LLC)/', $text, $matches)) {
        foreach ($matches[1] as $candidate) {
            if ($this->isValidCompanyName($candidate)) {
                return trim($candidate);
            }
        }
    }
    
    return null;
}

    private function isValidCompanyName(string $name): bool {
        // Basic validation for company names
        return !empty($name) && 
               strlen($name) > 2 && 
               preg_match('/[a-zA-Z]/', $name);
    }
    
    
    private function learnPatternsFromData(array $samples, array $labels): void {
        $newPatterns = [];
        
        foreach ($samples as $index => $text) {
            $company = $labels[$index];
            if ($company !== 'Unknown' && $this->isValidCompanyName($company)) {
                $escaped = preg_quote($company, '/');
                $newPatterns[] = '/\b' . $escaped . '\b/i';
            }
        }
        
        $this->companyPatterns = array_merge($this->companyPatterns, array_unique($newPatterns));
    }
    
    private function findCompanyContext(string $text, string $company): ?string {
        $sentences = preg_split('/[.!?]\s+/', $text);
        
        foreach ($sentences as $sentence) {
            if (stripos($sentence, $company) !== false) {
                // Create a pattern from the sentence structure
                $pattern = preg_replace(
                    '/\b' . preg_quote($company, '/') . '\b/i', 
                    '(.+)', 
                    preg_quote(trim($sentence), '/')
                );
                return '/' . $pattern . '/i';
            }
        }
        
        return null;
    }
    
    
    private function looksLikeCompanyName(string $name): bool {
        // Basic checks for company name characteristics
        return preg_match('/\b(?:SA|SAS|SARL|GmbH|Inc|Ltd|LLC|Corp|Co)\b/i', $name) ||
               preg_match('/[A-Z][a-z]+(?:\s+[A-Z][a-z]+)*/', $name);
    }
    
    private function extractFromCommonPositions(string $text): string {
        // Check common positions where company names appear
        $lines = explode("\n", $text);
        
        // First few lines often contain company names
        foreach (array_slice($lines, 0, 5) as $line) {
            if ($this->looksLikeCompanyName($line)) {
                return trim($line);
            }
        }
        
        // Footer area might have company names
        foreach (array_slice($lines, -5) as $line) {
            if ($this->looksLikeCompanyName($line)) {
                return trim($line);
            }
        }
        
        return 'Unknown';
    }
    
    public function saveModel(string $path): void {
        file_put_contents($path, serialize([
            'vectorizer' => $this->vectorizer,
            'transformer' => $this->transformer,
            'classifier' => $this->classifier,
            'patterns' => $this->companyPatterns
        ]));
    }

    
public function loadModel(string $path): void {
        if (!file_exists($path)) {
            throw new \RuntimeException("Model file not found at: $path");
        }
        
        $data = unserialize(file_get_contents($path));
        if ($data === false) {
            throw new \RuntimeException("Failed to unserialize model data");
        }
        
        $this->vectorizer = $data['vectorizer'];
        $this->transformer = $data['transformer'];
        $this->classifier = $data['classifier'];
        $this->companyPatterns = $data['patterns'] ?? $this->companyPatterns;
    }
}