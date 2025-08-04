<?php
require __DIR__.'/../../vendor/autoload.php';

use App\Libraries\DocumentPredictor;

try {
    if (!isset($_SERVER['argv'][1])) {
        throw new Exception("Please provide a PDF file path as argument");
    }
    
    $predictor = new DocumentPredictor();
    $result = $predictor->predictDocument($_SERVER['argv'][1]);
    
    echo "Category: " . $result['category'] . "\n";
    echo "Companies: " . implode(', ', $result['companies']) . "\n";
    echo "Text Sample: " . $result['text_sample'] . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}