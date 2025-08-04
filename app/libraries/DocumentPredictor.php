<?php
namespace App\Libraries;

require __DIR__ . '/../../vendor/autoload.php';

use Exception;

class DocumentPredictor {
   private $extractor;
    private $classifier;
    private $companyRecognizer;
        
    public function __construct() {
        $this->extractor = new PdfTextExtractor();
        $this->classifier = new DocumentClassifier();
        $this->companyRecognizer = new CompanyRecognizer();

        // Load document classifier model
        $modelPath = realpath(__DIR__ . '/../../public/models/document_classifier.dat');
        if (!$modelPath) {
            throw new Exception("Document classifier model not found");
        }
        $this->classifier->loadModel($modelPath);
        
        // Load company recognizer model
        $companyModelPath = realpath(__DIR__ . '/../../public/models/company_recognizer.dat');
        if (!$companyModelPath) {
            throw new Exception("Company recognizer model not found");
        }
        $this->companyRecognizer->loadModel($companyModelPath);
    }
    
    public function predictDocument(string $filePath): array {
        $absolutePath = realpath($filePath);
        if (!$absolutePath) {
            throw new Exception("File not found: $filePath");
        }

        $text = $this->extractor->extractTextFromPdf($absolutePath);
        
        return [
            'file' => basename($absolutePath),
            'category' => $this->classifier->predict($text),
            'company' => $this->companyRecognizer->predictCompany($text),
            'text_sample' => substr($text, 0, 200) . '...'
        ];
    }

    private function extractCompanyFromText(string $text): string {
        $companyPatterns = [
            '/client[:\s]*([^\n\r]+)/i',
            '/société[:\s]*([^\n\r]+)/i',
            '/between (.+?) and/i'
        ];
        
        foreach ($companyPatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                return trim($matches[1]);
            }
        }
        
        return 'Unknown';
    }
}

//CLI Usage
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['argv'][0])) {
    if (!isset($_SERVER['argv'][1])) {
        echo "Usage: php " . basename(__FILE__) . " \"<path_to_pdf>\"\n";
        exit(1);
    }
    
    try {
        $predictor = new DocumentPredictor();
        $result = $predictor->predictDocument($_SERVER['argv'][1]);
        //$_SERVER['argv'][1] => path to document
        echo "File: " . $result['file'] . "\n";
        echo "Category: " . $result['category'] . "\n";
        echo "Company: " . $result['company'] . "\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}