<?php
namespace App\Libraries;

require __DIR__ . '/../../vendor/autoload.php';

use Exception;

class ModelTrainer {
    private $extractor;
    private $docClassifier;
    private $companyRecognizer;
    
    public function __construct() {
        $this->extractor = new PdfTextExtractor();
        $this->docClassifier = new DocumentClassifier();
        $this->companyRecognizer = new CompanyRecognizer(); // New component
    }
    
public function trainFromDirectory(string $baseDir = null) {
    $categories = ['factures', 'contrats', 'releves', 'plaquette', 'bordereau
', 'delegation', 'devis', 'courriers', 'administratifs'];
    $docSamples = [];
    $docLabels = [];
    $companySamples = [];
    $companyLabels = [];
    
    $baseDir = $baseDir ?? __DIR__ . '/../../public/documents/trainingData';
    
    foreach ($categories as $category) {
        $dir = __DIR__ . '/../../public/documents/trainingData';
        
        if (!is_dir($dir)) {
            echo "Warning: Category directory not found - $dir\n";
            continue;
        }
        
foreach (glob($dir . '/*.pdf') as $pdfFile) {
        try {
            $text = $this->extractor->extractTextFromPdf($pdfFile);
            $originalFilename = basename($pdfFile);
            
            // Extract company from content
            $companyFromText = $this->extractCompanyFromContent($text);
            $source = 'content';
            $companyFromImage = $this->extractor->extractTextFromPdfImages($pdfFile);
            $company = $companyFromImage;
            
            // Fallback to filename if needed
            if ($companyFromText === 'Unknown' || empty($companyFromText)) {
                // $companyFromImage = $this->extractor->extractTextFromPdfImages($pdfFile);
                $source = 'image';
            }
            if($companyFromImage === 'Unknown' || empty($companyFromImage)) {
                $company = $companyFromText;
            }
            // Debug output
            echo sprintf(
                "Processed: %s\nCompany: %s (from %s)\nText sample: %s\n\n",
                $originalFilename,
                $company,
                $source,
                substr($text, 0, 200) . '...'
            );
            
            $docSamples[] = $text;
            $docLabels[] = $this->mapFolderToCategory($category);
            $companySamples[] = $text;
            $companyLabels[] = $company;
            
        } catch (Exception $e) {
            echo "Error with $pdfFile: " . $e->getMessage() . "\n";
        }
    }
    }

    if (empty($docSamples)) {
        throw new Exception("No valid documents found for training");
    }

    // Train models
    $this->docClassifier->train($docSamples, $docLabels, $companyLabels);
    $this->companyRecognizer->train($companySamples, $companyLabels);
    
    $this->saveModels();
    
    echo sprintf(
        "Trained with %d documents and %d company references\n",
        count($docSamples),
        count(array_filter($companyLabels, fn($c) => $c !== 'Unknown'))
    );
}

private function extractCompanyFromContent(string $text): string {
    // Normalize text for better matching
    $text = preg_replace('/\s+/', ' ', $text);
    
    // Enhanced patterns with better matching
    $patterns = [
        // French patterns
        '/client\s*[:]?\s*([a-zA-Z0-9&][^\n\r,;]+)/i',
        '/société\s*[:]?\s*([a-zA-Z0-9&][^\n\r,;]+)/i',
        '/entre\s+([a-zA-Z0-9&][^\n\r]+?)\s+et/i',
        '/fournisseur\s*[:]?\s*([a-zA-Z0-9&][^\n\r,;]+)/i',
        '/à l\'attention de\s+([a-zA-Z0-9&][^\n\r,;]+)/i',
        
        // English patterns
        '/company\s*[:]?\s*([a-zA-Z0-9&][^\n\r,;]+)/i',
        '/vendor\s*[:]?\s*([a-zA-Z0-9&][^\n\r,;]+)/i',
        '/between\s+([a-zA-Z0-9&][^\n\r]+?)\s+and/i',
        '/for\s+([a-zA-Z0-9&][^\n\r,;]+)/i',
        
        // Legal entity patterns
        '/([A-Z][a-zA-Z0-9& \.-]+?(?:\s+SA|\s+SAS|\s+SARL|\s+GmbH|\s+Inc|\s+Ltd|\s+LLC))/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $text, $matches)) {
            $company = trim($matches[1]);
            // Basic cleanup
            $company = preg_replace('/^\W+|\W+$/', '', $company);
            if ($this->isValidCompanyName($company)) {
                return $company;
            }
        }
    }
    
    return 'Unknown';
}

private function isValidCompanyName(string $name): bool {
    $name = trim($name);
    if (empty($name)) return false;
    if (strlen($name) < 3) return false;
    
    // Should contain at least some letters and spaces/dots between words
    return preg_match('/[a-zA-Z]{2,}/', $name) && 
           preg_match('/^[\w\s&.,-]+$/u', $name);
}

    private function findCompanyContexts(string $text, string $company): array {
        $sentences = preg_split('/[.!?]\s+/', $text);
        $matches = [];
        
        foreach ($sentences as $sentence) {
            if (stripos($sentence, $company) !== false) {
                $matches[] = $sentence;
            }
        }
        
        return $matches ?: ["Client: $company"]; // Fallback pattern
    }

    private function saveModels(): void {
        $modelDir = __DIR__ . '/../../public/models/';
        if (!is_dir($modelDir)) {
            mkdir($modelDir, 0755, true);
        }
        
        $this->docClassifier->saveModel($modelDir . 'document_classifier.dat');
        $this->companyRecognizer->saveModel($modelDir . 'company_recognizer.dat');
    }

    private function extractCompanyFromFilename(string $filename): string {
        // Extract from filename pattern like "CompanyName_DocType_Date.pdf"
        if (preg_match('/^([^_]+)_/', basename($filename), $matches)) {
            return $matches[1];
        }
        return '';
    }
    
    private function mapFolderToCategory(string $folder): string {
        $mapping = [
            'factures' => 'factures',
            'contrats' => 'contrats',
            'releves' => 'releves',
            'plaquette' => 'plaquette',
            'bordereau' => 'bordereau',
            'delegation' => 'delegation',
            'devis' => 'devis',
            'courriers' => 'courriers',
            'administratifs' => 'administratifs'
        ];
        
        return $mapping[$folder] ?? 'administratifs';
    }
}

// Exécution seulement si appelé directement
if (isset($argv) && in_array(basename(__FILE__), $argv)) {
    try {
        $trainer = new ModelTrainer();
        $trainer->trainFromDirectory(__DIR__ . '/../../documents');
        echo "Entraînement terminé avec succès!\n";
    } catch (Exception $e) {
        echo "ERREUR: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Utilisation
try {
    $trainer = new ModelTrainer();
    $trainer->trainFromDirectory('documents'); // Chemin vers votre dossier de documents
    
    echo "Entraînement terminé avec succès!\n";
} catch (Exception $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
    exit(1);
}