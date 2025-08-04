<?php
namespace App\Libraries;

use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Tokenization\WordTokenizer;

class DocumentClassifier {
    private $classifier;
    private $vectorizer;
    private $transformer;
    public $doc_categories = [
    'factures' => [
        'patterns' => [
            '/FACTURE\s+D\'ÉLECTRICITÉ/i',
            '/N°[0-9]+\s*$/m',
            '/Total\s+(TTC|HT)/i',
            '/Montant\s+à\s+payer/i',
            '/Référence\s+client/i',
            '/Date\s+de\s+facturation/i',
            '/Invoice\s+No\.?/i'
        ],
        'keywords' => ['facture', 'invoice', 'payment', '€', 'montant']
    ],
    'courriers' => [
        'patterns' => [
            '/Objet\s*:/i',
            '/^From:\s*.+@.+\..+/im',
            '/^To:\s*.+@.+\..+/im',
            '/^Subject\s*:/im',
            '/^Date\s*:/im',
            '/Madame,\s*Monsieur,/i',
            '/Je vous prie d\'agréer/i',
            '/Cordialement,/i'
        ],
        'keywords' => ['email', 'courrier', 'lettre', 'objet']
    ],
    'contrats' => [
        'patterns' => [
            '/CONTRAT\s+DE/i',
            '/ENTRE\s+LES\s+SOUSSIGNÉS/i',
            '/CLAUSE\s+[IVXLCDM]+/i',
            '/Durée\s+du\s+contrat/i'
        ],
        'keywords' => ['contrat', 'agreement', 'signature', 'clause']
    ],
    'releves' => [
        'patterns' => [
            '/RELEVE\s+DE\s+COMPTE/i',
            '/SOLDE\s+PRECEDENT/i',
            '/MOUVEMENTS\s+DU\s+COMPTE/i',
            '/Date\s+Valeur\s+Libellé/i'
        ],
        'keywords' => ['releve', 'statement', 'compte', 'solde']
    ],
    'administratifs' => [
        'patterns' => [
            '/DECISION\s+ADMINISTRATIVE/i',
            '/ARRETE\s+MUNICIPAL/i',
            '/PROCES-VERBAL/i',
            '/DELIBERATION/i'
        ],
        'keywords' => ['administratif', 'decision', 'arrete', 'deliberation']
    ],
    // Add other categories similarly
];
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
        $this->classifier = new SVC(Kernel::RBF, 1.0, 3, 0.0, 0.0);
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->transformer = new TfIdfTransformer();
    }
    
    public function train(array $samples, array $labels, array $companies) {
        $this->vectorizer->fit($samples);
        $this->vectorizer->transform($samples);
        $this->transformer->fit($samples);
        $this->transformer->transform($samples);
        
        $this->classifier->train($samples, $labels);
        $this->companyPatterns = array_merge($this->companyPatterns, $this->learnCompanyPatterns($samples, $companies));
    }
    
    public function predict(string $text): string {
        // First check for specific patterns
        foreach ($this->doc_categories as $category => $config) {
            foreach ($config['patterns'] as $pattern) {
                if (preg_match($pattern, $text)) {
                    return $category;
                }
            }
        }

        // Then check for keywords
        $textLower = strtolower($text);
        foreach ($this->doc_categories as $category => $config) {
            foreach ($config['keywords'] as $keyword) {
                if (strpos($textLower, strtolower($keyword)) !== false) {
                    return $category;
                }
            }
        }

        // Fall back to ML classification
        $samples = [$text];
        $this->vectorizer->transform($samples);
        $this->transformer->transform($samples);
        
        $prediction = $this->classifier->predict($samples)[0];
        
        // Ensure prediction is one of our allowed categories
        return array_key_exists($prediction, $this->doc_categories) ? $prediction : 'administratifs';
    }

        public function predictCompany(string $text): string {
        foreach ($this->companyPatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }
        return 'Unknown';
    }
    
    private function learnCompanyPatterns(array $samples, array $companies): array {
        $patterns = [];
        foreach ($companies as $index => $company) {
            if (!empty($company) && !empty($samples[$index])) {
                $cleanCompany = preg_quote($company, '/');
                $patterns[] = '/\b' . $cleanCompany . '\b/i';
            }
        }
        return $patterns;
    }
    
    public function saveModel(string $path) {
        file_put_contents($path, serialize([
            'classifier' => $this->classifier,
            'vectorizer' => $this->vectorizer,
            'transformer' => $this->transformer
        ]));
    }
    
    public function loadModel(string $path) {
        if (!file_exists($path)) {
            throw new Exception("Model file not found at: $path");
        }
        $data = unserialize(file_get_contents($path));
        if ($data === false) {
            throw new Exception("Failed to unserialize model data");
        }
        $this->classifier = $data['classifier'];
        $this->vectorizer = $data['vectorizer'];
        $this->transformer = $data['transformer'];
    }
}