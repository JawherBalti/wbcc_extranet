<?php

require __DIR__ . '/../../vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Initialize PDF parser
$pdfParser = new Parser();

// DeepSeek API configuration
$apiKey = "sk-4c8f031dff7547afa82cd6234898ac1e"; // Replace with your key
$apiUrl = "https://api.deepseek.com/v1/chat/completions";

// Define your categories
$categories = ['factures', 'contrats', 'releves', 'plaquette', 'bordereau', 'delegation', 'devis', 'courriers', 'administratifs', 'cv'];

// Process PDF file
function analyzePDF($filePath, $pdfParser, $apiKey, $apiUrl, $categories) {
    try {
        // Step 1: Extract text from PDF
        $pdf = $pdfParser->parseFile($filePath);
        $text = $pdf->getText();
        
        // Truncate very long texts (DeepSeek has 128K token limit)
        $text = substr($text, 0, 100000); // ~100K characters

        // Step 2: Prepare the prompt
        $prompt = "Analyze this document and return JSON with:\n";
        $prompt .= "1. 'company' (extracted company name)\n";
        $prompt .= "2. 'type' (document type, must be one of: " . implode(', ', $categories) . ")\n";
        $prompt .= "3. 'confidence' (your confidence score 1-100)\n\n";
        $prompt .= "Document text:\n" . $text;

        // Step 3: Call DeepSeek API
        $data = [
            "model" => "deepseek-chat",
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ],
            "temperature" => 0.3, // Lower for more deterministic results
            "response_format" => ["type" => "json_object"] // Force JSON response
        ];

        $options = [
            "http" => [
                "header" => "Authorization: Bearer $apiKey\r\n" .
                            "Content-Type: application/json",
                "method" => "POST",
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($apiUrl, false, $context);

        if ($response === FALSE) {
            throw new Exception("API request failed");
        }

        $result = json_decode($response, true);
        $content = $result['choices'][0]['message']['content'];

        // Parse the JSON response
        $analysis = json_decode($content, true);
        
        // Validate the category
        if (isset($analysis['type']) && !in_array(strtolower($analysis['type']), $categories)) {
            $analysis['type'] = 'unknown';
        }

        return $analysis ?: ['error' => 'Failed to parse API response'];

    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Example usage
$pdfFile = "public/documents/trainingData/Xerox Scan_26052025134712_20250526134712.pdf";
$result = analyzePDF($pdfFile, $pdfParser, $apiKey, $apiUrl, $categories);

// Output results
header('Content-Type: application/json');
echo json_encode([
    'filename' => basename($pdfFile),
    'result' => $result
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// use OpenAI\Client;
// use Smalot\PdfParser\Parser;
// use OpenAI;

// $certPaths = [
//     'C:/xampp/apache/bin/cacert.pem',
//     'C:/xampp/php/cacert.pem',
//     __DIR__.'/cacert.pem' // Project root
// ];

// $validCertPath = null;
// foreach ($certPaths as $path) {
//     if (file_exists($path)) {
//         $validCertPath = $path;
//         break;
//     }
// }

// if (!$validCertPath) {
//     die("ERROR: Download cacert.pem from https://curl.se/ca/cacert.pem and place it in your project root.");
// }

// // Initialize OpenAI client
// // $openai = OpenAI::client('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'); // Replace with your key
// $openai = OpenAI::factory()
//     ->withApiKey('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')
//     ->withHttpClient(new \GuzzleHttp\Client([
//         'verify' => $validCertPath
//     ]))
//     ->make();
// // PDF Parser
// $pdfParser = new Parser();

// // Few-shot learning examples (adjust based on your documents)
// $fewShotExamples = [
//     // Factures
//     [
//         "text" => "Facture No: FAC-2023-456\nFournisseur: Cabinet BRUNO\nDate: 15/01/2023\nMontant: 1 250,00 € HT\nRéférence: PREST-789",
//         "output" => '{"company": "Cabinet BRUNO", "type": "factures", "date": "15/01/2023", "amount": 1250.00, "reference": "PREST-789"}'
//     ],
//     [
//         "text" => "WBCC ASSISTANCE\nFacture Proforma\nDate d'émission: 03/05/2024\nTotal TTC: 3 845,50 €",
//         "output" => '{"company": "WBCC ASSISTANCE", "type": "factures", "date": "03/05/2024", "amount": 3845.50}'
//     ],

//     // Contrats
//     [
//         "text" => "CONTRAT DE PRESTATION DE SERVICES\nEntre RELAIS HABITAT SYNDIC DE REDRESSEMENT (RHSE)\nDate d'effet: 01/09/2022\nDurée: 36 mois",
//         "output" => '{"company": "RELAIS HABITAT SYNDIC DE REDRESSEMENT (RHSE)", "type": "contrats", "date": "01/09/2022", "duree": "36 mois"}'
//     ],

//     // Relevés
//     [
//         "text" => "RELEVE DE COMPTE\nCabinet BRUNO\nPériode: Janvier 2024\nSolde: 8 420,00 €",
//         "output" => '{"company": "Cabinet BRUNO", "type": "releves", "periode": "Janvier 2024", "solde": 8420.00}'
//     ],

//     // Bordereaux
//     [
//         "text" => "BORDEREAU DE LIVRAISON\nWBCC ASSISTANCE\nN° Commande: CMD-45612\nDate: 22/11/2023",
//         "output" => '{"company": "WBCC ASSISTANCE", "type": "bordereau", "date": "22/11/2023", "commande": "CMD-45612"}'
//     ],

//     // Courriers
//     [
//         "text" => "OBJET: Résiliation de contrat\nRELAIS HABITAT SYNDIC DE REDRESSEMENT (RHSE)\nDate: 05/03/2024\nRéf: NOT-789456",
//         "output" => '{"company": "RELAIS HABITAT SYNDIC DE REDRESSEMENT (RHSE)", "type": "courriers", "date": "05/03/2024", "objet": "Résiliation de contrat"}'
//     ],

//     // Administratifs
//     [
//         "text" => "ATTESTATION ADMINISTRATIVE\nCabinet BRUNO\nN° SIRET: 12345678900012\nDate d'édition: 10/02/2024",
//         "output" => '{"company": "Cabinet BRUNO", "type": "administratifs", "date": "10/02/2024", "siret": "12345678900012"}'
//     ]
// ];

// // Process a single PDF
// function processPDF($filePath, $openai, $pdfParser, $fewShotExamples) {
//     // Extract text
//     try {
//         $pdf = $pdfParser->parseFile($filePath);
//         $text = $pdf->getText();
//         if (empty($text)) throw new Exception("No text extracted");
//     } catch (Exception $e) {
//         return ["error" => "PDF parsing failed: " . $e->getMessage()];
//     }

//     // Build few-shot prompt
//     $prompt = "Extract company name, document type ('factures', 'contrats', 'releves', 'plaquette', 'bordereau
// ', 'delegation', 'devis', 'courriers', 'administratifs', 'cv'...) and date.\n";
//     $prompt .= "Return JSON ONLY. Examples:\n";
//     foreach ($fewShotExamples as $example) {
//         $prompt .= "Text: " . $example['text'] . "\nOutput: " . $example['output'] . "\n\n";
//     }
//     $prompt .= "Now analyze this document:\nText: $text\nOutput:";

//     // Call GPT-3.5 (with error handling)
//     try {
//         $response = $openai->chat()->create([
//             'model' => 'gpt-3.5',
//             'messages' => [['role' => 'user', 'content' => $prompt]],
//             'temperature' => 0.3 // Reduce randomness for structured data
//         ]);
        
//         $result = $response->choices[0]->message->content;
//         return json_decode($result, true) ?: ["error" => "Invalid JSON response"];
//     } catch (Exception $e) {
//         return ["error" => "API call failed: " . $e->getMessage()];
//     }
// }

// // Batch processing with throttling (3 requests/second)
// function processBatch($pdfFiles, $openai, $pdfParser, $fewShotExamples) {
//     $results = [];
//     $delayMicroseconds = 333333; // ~3 requests/second (adjust as needed)

//     foreach ($pdfFiles as $file) {
//         $result = processPDF($file, $openai, $pdfParser, $fewShotExamples);
//         $results[basename($file)] = $result;
//         usleep($delayMicroseconds); // Rate limiting
//     }

//     return $results;
// }

// // --- Example Usage ---
// $pdfFiles = [
//     'public/documents/trainingData/Xerox Scan_01022021232151_20210201232151.pdf',
// ];


// // Process all PDFs
// $results = processBatch($pdfFiles, $openai, $pdfParser, $fewShotExamples);

// // Save results
// file_put_contents('results.json', json_encode($results, JSON_PRETTY_PRINT));
// echo "Processing complete. Results saved to results.json";
?>