<?php

namespace App\Libraries;

use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;

class PdfTextExtractor {
    private $parser;
    
    public function __construct() {
        $this->parser = new Parser();
    }
    
 public function extractTextFromPdf(string $filePath): string {
        try {
            $pdf = $this->parser->parseFile($filePath);
            $text = $pdf->getText();
            
            // Add email markers if detected
            if ($this->isEmail($text)) {
                $text = "EMAIL_MARKER\n" . $text;
            }
            
            return $text;
        } catch (\Exception $e) {
            throw new \Exception("PDF text extraction failed: " . $e->getMessage());
        }
    }
    
    private function isEmail(string $text): bool {
        return preg_match('/^From:\s*.+@.+\..+/im', $text) 
            || preg_match('/^Subject:\s*.+/im', $text);
    }
    
    private function containsTargetText(string $text): bool {
        $targets = [
            'WBCC ASSISTANCE',
            'Relais Habitat Syndique de Redressement',
            'RHSR' // Abbreviation seen in your PDF
        ];
        
        foreach ($targets as $target) {
            if (stripos($text, $target) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
public function extractTextFromPdfImages(string $filePath): string {
    // Initialize with empty string
    $text = '';
    
    try {
        // 1. Convert PDF to images using Ghostscript
        $imagePaths = $this->convertPdfToImagesWithGhostscript($filePath);
        
        // 2. Process each image with Tesseract
        foreach ($imagePaths as $imagePath) {
            try {
                $pageText = (new TesseractOCR($imagePath))
                    ->lang('fra', 'eng')
                    ->psm(11)
                    ->oem(3)
                    ->config('preserve_interword_spaces', '1')
                    ->config('tessedit_char_blacklist', '0123456789')
                    ->config('tessedit_char_whitelist', 'ABCDEFGHIJKLMNOPQRSTUVWXYZÀÂÇÉÈÊËÎÏÔÙÛÜÝàâçéèêëîïôùûüý& -')
                    ->run();
                
                $text .= $pageText . "\n";
            } finally {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
        
        // 3. Extract companies from the combined text
        $companies = $this->extractPotentialCompanies($text);
        return implode("\n", array_unique($companies));
        
    } catch (\Exception $e) {
        // Return empty string if processing fails
        error_log("PDF processing failed: " . $e->getMessage());
        return '';
    }
}

private function convertPdfToImagesWithGhostscript(string $pdfPath): array {
    $tempDir = sys_get_temp_dir() . '/pdf_images_' . uniqid();
    mkdir($tempDir, 0755, true);
    
    $outputPattern = escapeshellarg("$tempDir/page-%03d.jpg");
    $pdfPath = escapeshellarg(realpath($pdfPath));
    
    exec("gswin64c -dNOPAUSE -sDEVICE=jpeg -r300 -o $outputPattern $pdfPath 2>&1", $output, $returnCode);
    
    if ($returnCode !== 0) {
        throw new \RuntimeException("Ghostscript failed: " . implode("\n", $output));
    }
    
    $images = glob("$tempDir/page-*.jpg");
    if (empty($images)) {
        throw new \RuntimeException("No images generated from PDF");
    }
    
    return $images;
}

private function cleanupTempDir(string $dir): void {
    if (is_dir($dir)) {
        array_map('unlink', glob("$dir/*"));
        rmdir($dir);
    }
}

private function extractPotentialCompanies(string $text): array {
    $companies = [];
    $patterns = [
        '/\b(WBCC\s*ASSISTANCE)\b/i',
        '/\b(WORLD\s*BUSINESS\s*CONTACT\s*CENTER)\b/i',
        '/\b(Cabinet)\b/i',
        '/\b(CABINET)\b/i',
        '/\b(BRUNO)\b/i',
        '/\b(CABINET\s*BRUNO)\b/i',
        '/\b(ABEILLE\s*ASSURANCES)\b/i',
        '/\b(RELAIS\s*HABITAT)\b/i',
        '/\b(RELAIS\s*HABITAT\s*SYNDIC\s*DE\s*REDRESSEMENT)\b/i',
        '/RHSR/i'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match_all($pattern, $text, $matches)) {
            foreach ($matches[1] as $match) {
                $company = trim(preg_replace('/[^\w\s&.-]/', '', $match));
                //Normalize company names
                if (preg_match('/bruno/i', $company)) {
                    $normalized = 'CABINET BRUNO';
                } elseif (preg_match('/relais/i', $company)) {
                    $normalized = 'RHSR';
                } elseif (preg_match('/WBCC|WORLD BUSINESS CONTACT CENTER/i', $company)) {
                    $normalized = 'WBCC';
                } elseif (preg_match('/RHSR/i', $company)) {
                   $normalized = 'Relais Habitat Syndique de Redressement';
                } else {
                    $normalized = $company;
                }
                if (strlen($normalized) > 3 && !in_array($normalized, $companies)) {
                    $companies[] = $normalized;
                }
            }        }
    }
    
    return array_unique(array_filter($companies));
}

// private function extractPotentialCompanies(string $text): array {
//     $companies = [];
//     $text = preg_replace('/\s+/', ' ', $text); // Normalize spaces

//     // Patterns for company names with capture groups
//         $patterns = [
//         // French patterns
//         // '/\b(?:société|client|fournisseur)[:\s]*(.+?)(?=\n|$)/i',
//         // '/\b(?:entreprise|compagnie)[:\s]*(.+?)(?=\n|$)/i',
//         // '/\b([A-Z][A-Z0-9&]+(?:\s+[A-Z][A-Z0-9&]+)+)\b/', // ALL CAPS names
//         // '/\b(?:pour|à l\'attention de)[:\s]*(.+?)(?=\n|$)/i',
        
//         // Legal entities
//         '/\b([A-Z][a-zA-Z0-9& \.-]+?(?:\s+SA|\s+SAS|\s+SARL|\s+GmbH|\s+Inc|\s+Ltd))\b/',
        
//         // Specific to your case
//         '/\b(WBCC\s*ASSISTANCE)\b/i',
//         '/\b(WORLD\s*BUSINESS\s*CONTACT\s*CENTER)\b/i',
//         '/\b(Cabinet)\b/i',
//         '/\b(CABINET)\b/i',
//         '/\b(BRUNO)\b/i',
//         '/\b(CABINET\s*BRUNO)\b/i',
//         '/\b(ABEILLE\s*ASSURANCES)\b/i',
//         '/\b(RELAIS\s*HABITAT)\b/i',
//         '/\b(RELAIS\s*HABITAT\s*SYNDIC\s*DE\s*REDRESSEMENT)\b/i',
//         '/RHSR/i', // With context this likely means Relais Habitat Syndique de Redressement
//     ];
//     foreach ($patterns as $pattern) {
//         if (preg_match_all($pattern, $text, $matches)) {
//             foreach ($matches[1] as $match) {
//                 $company = trim(preg_replace('/[^\w\s&.-]/', '', $match));
//                 //Normalize company names
//                 if (preg_match('/bruno/i', $company)) {
//                     $normalized = 'CABINET BRUNO';
//                 } elseif (preg_match('/relais/i', $company)) {
//                     $normalized = 'RHSE';
//                 } elseif (preg_match('/WBCC|WORLD BUSINESS CONTACT CENTER/i', $company)) {
//                     $normalized = 'WBCC';
//                 } elseif (preg_match('/RHSR/i', $company)) {
//                    $normalized = 'Relais Habitat Syndique de Redressement';
//                 } else {
//                     $normalized = $company;
//                 }
//                 if (strlen($normalized) > 3 && !in_array($normalized, $companies)) {
//                     $companies[] = $normalized;
//                 }
//             }
//         }
//     }
    
//     return $companies;
// }
}
// namespace App\Libraries;

// use Smalot\PdfParser\Parser;
// use thiagoalessio\TesseractOCR\TesseractOCR;
// use Imagick;

// class PdfTextExtractor 
// {
//     private $pdfParser;
    
//     public function __construct() 
//     {
//         $this->pdfParser = new Parser();
//     }

//     /**
//      * Extrait le texte d'un PDF, avec OCR si nécessaire
//      */
//     public function extractTextFromPdf(string $filePath): string 
//     {
//         if ($this->isSearchablePdf($filePath)) {
//             return $this->extractSearchableText($filePath);
//         }
//         return $this->extractTextViaOcr($filePath);
//     }

//     /**
//      * Vérifie si le PDF contient du texte extractible
//      */
//     private function isSearchablePdf(string $filePath): bool 
//     {
//         try {
//             $pdf = $this->pdfParser->parseFile($filePath);
//             $text = $pdf->getText();
//             return strlen(trim($text)) > 50;
//         } catch (\Exception $e) {
//             return false;
//         }
//     }

//     /**
//      * Extraction standard pour PDF avec texte
//      */
//     private function extractSearchableText(string $filePath): string 
//     {
//         $pdf = $this->pdfParser->parseFile($filePath);
//         return $pdf->getText();
//     }

//     /**
//      * Extraction par OCR pour PDF scannés
//      */
//     private function extractTextViaOcr(string $filePath): string {
//         $tempImagePath = sys_get_temp_dir() . '\\' . uniqid('ocr_') . '.png';
    
//         // Use absolute path to Ghostscript
//         $gsPath = '"C:\\Programmes\\gs\\gs10.05.1\\bin\\gswin64c"';
        
//         $command = $gsPath . ' -dSAFER -dBATCH -dNOPAUSE -sDEVICE=png16m -r300 ' .
//                 '-sOutputFile="' . $tempImagePath . '" "' . $filePath . '"';
        
//         exec($command, $output, $returnCode);
        
//         if ($returnCode !== 0) {
//             throw new Exception("PDF to image conversion failed. Command: $command");
//         }
//         try {
//             // Use Imagick to convert PDF to image
//             $imagick = new \Imagick();
//             $imagick->setResolution(300, 300); // High DPI for OCR
//             $imagick->readImage($filePath . '[0]'); // First page only
//             $imagick->setImageFormat('png');

//             $tempImagePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('ocr_') . '.png';
//             $imagick->writeImage($tempImagePath);
//             $imagick->clear();

//             // OCR with Tesseract
//             $ocr = new \TesseractOCR($tempImagePath);
//             $ocr->setLanguage('fra'); // French
//             $text = $ocr->run();

//             unlink($tempImagePath);
//             return $text;
//         } catch (\Exception $e) {
//             throw new \Exception("Imagick PDF processing failed: " . $e->getMessage());
//         }
//     }
// }

?>