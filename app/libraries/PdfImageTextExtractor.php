<?php
namespace App\Libraries;

use Imagick;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Exception;

class PdfImageTextExtractor {
    public function extractTextFromPdfImages(string $pdfPath): string {
        try {
            // 1. Extract images from PDF
            $images = $this->extractImagesFromPdf($pdfPath);
            
            $fullText = '';
            
            // 2. Process each image with OCR
            foreach ($images as $imageData) {
                if (!empty($imageData)) {
                    $fullText .= $this->ocrImage($imageData) . "\n\n";
                }
            }
            
            return trim($fullText);
            
        } catch (Exception $e) {
            throw new Exception("PDF image text extraction failed: " . $e->getMessage());
        }
    }

    private function extractImagesFromPdf(string $pdfPath): array {
        $images = [];
        
        try {
            $imagick = new Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($pdfPath);
            
            foreach ($imagick as $page) {
                $page->setImageFormat('png');
                $images[] = $page->getImageBlob();
            }
            
            return $images;
            
        } catch (ImagickException $e) {
            throw new Exception("PDF to image conversion failed: " . $e->getMessage());
        }
    }

private function ocrImage(string $imageData): string {
    $tempImage = tempnam(sys_get_temp_dir(), 'ocr') . '.png';
    file_put_contents($tempImage, $imageData);
    
    try {
        // Explicitly set paths
        $tesseractCmd = '"C:\Programmes\Tesseract-OCR\tesseract"';
        $tessdataDir = '"C:\Programmes\Tesseract-OCR\tessdata"';
        
        $command = "$tesseractCmd \"$tempImage\" stdout -l fra --psm 6 --tessdata-dir $tessdataDir 2>&1";
        exec($command, $output, $returnCode);
        
        if ($returnCode !== 0) {
            throw new Exception("Tesseract error: " . implode("\n", $output));
        }
        
        return trim(implode("\n", $output));
        
    } finally {
        @unlink($tempImage);
    }
}
}