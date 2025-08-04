<?php
namespace App\Libraries;

use Imagick;
use thiagoalessio\TesseractOCR\TesseractOCR;

class DocumentProcessor {
    private $knownCompanies = [
        'wbcc' => 'WBCC',
        'relais habitat' => 'Relais Habitat',
        'xerox' => 'Xerox Corporation'
    ];

    public function processDocument(string $pdfPath): array {
        $result = [
            'text' => '',
            'companies' => [],
            'primary_company' => null
        ];

        try {
            // 1. Extract text from PDF images
            $imageText = $this->extractTextFromPdfImages($pdfPath);
            $result['text'] = $imageText;

            // 2. Detect companies in extracted text
            $result['companies'] = $this->detectCompanies($imageText);
            $result['primary_company'] = $this->determinePrimaryCompany($result['companies']);

            return $result;

        } catch (\Exception $e) {
            throw new \Exception("Document processing failed: " . $e->getMessage());
        }
    }

    private function extractTextFromPdfImages(string $pdfPath): string {
        $text = '';
        try {
            $imagick = new Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($pdfPath);

            foreach ($imagick as $page) {
                $tempImage = tempnam(sys_get_temp_dir(), 'ocr') . '.png';
                $page->setImageFormat('png');
                $page->writeImage($tempImage);

                $pageText = (new TesseractOCR($tempImage))
                    ->lang('fra')
                    ->psm(6)
                    ->run();

                $text .= $pageText . "\n\n";
                unlink($tempImage);
            }

            return trim($text);

        } catch (\Exception $e) {
            throw new \Exception("Image text extraction failed: " . $e->getMessage());
        }
    }

    private function detectCompanies(string $text): array {
        $foundCompanies = [];
        $normalizedText = mb_strtolower($text);

        foreach ($this->knownCompanies as $key => $company) {
            // Match both the key (short name) and full company name
            if (preg_match('/\b' . preg_quote($key, '/') . '\b/i', $normalizedText) ||
                preg_match('/\b' . preg_quote(mb_strtolower($company), '/') . '\b/i', $normalizedText)) {
                $foundCompanies[] = $company;
            }
        }

        return array_unique($foundCompanies);
    }

    private function determinePrimaryCompany(array $companies): ?string {
        if (empty($companies)) {
            return null;
        }

        // Simple heuristic: return the first found company
        // You could implement more sophisticated logic here
        return $companies[0];
    }
}