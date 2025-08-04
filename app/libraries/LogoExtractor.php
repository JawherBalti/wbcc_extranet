<?php
namespace App\Libraries;

use Imagick;
use ImagickException;
use Smalot\PdfParser\Parser;
use Spatie\PdfToImage\Pdf;

class LogoExtractor {
    private $knownLogos = [
        'wbcc' => [
            'path' => __DIR__.'/../../public/logos/wbcc.png',
            'company' => 'wbcc'
        ],
        'relais habitat' => [
            'path' => __DIR__.'/../../public/logos/relais habitat.png',
            'company' => 'relais habitat'
        ],
        // Add more logos here
    ];
    
    public function extractLogoFromPdf(string $pdfPath): ?string {
        try {
            // 1. Extract header region
            $headerImage = $this->extractHeaderRegion($pdfPath);
            
            // 2. DEBUG: Save extracted header
            file_put_contents('debug_header.png', $headerImage);
            
            // 3. Find and match logo
            return $this->findLogoInImage($headerImage);
            
        } catch (Exception $e) {
            error_log('Logo extraction error: '.$e->getMessage());
            return null;
        }
    }

    private function extractHeaderRegion(string $pdfPath): string {
        try {
            $imagick = new Imagick();
            $imagick->setResolution(300, 300);
            $imagick->readImage($pdfPath.'[0]'); // First page only
            
            // Crop top 15% of page (adjust as needed)
            $height = $imagick->getImageHeight();
            $imagick->cropImage(
                $imagick->getImageWidth(),
                (int)($height * 0.15),
                0,
                0
            );
            
            $imagick->setImageFormat('png');
            return $imagick->getImageBlob();
            
        } catch (ImagickException $e) {
            throw new Exception("Header extraction failed: ".$e->getMessage());
        }
    }

    private function preprocessImage(string $imageData): string {
        try {
            $img = new Imagick();
            $img->readImageBlob($imageData);
            
            // 1. Remove text and keep graphical elements
            $img->transformImageColorspace(Imagick::COLORSPACE_GRAY);
            $img->blackThresholdImage('#999999');
            $img->whiteThresholdImage('#CCCCCC');
            $img->medianFilterImage(2);
            
            // 2. Enhance logo visibility
            $img->contrastImage(1);
            $img->normalizeImage();
            
            // 3. Find and isolate largest connected component (likely the logo)
            $img->connectedComponentsImage(8);
            
            return $img->getImageBlob();
            
        } catch (ImagickException $e) {
            throw new Exception("Image processing failed: ".$e->getMessage());
        }
    }

    private function matchLogo(string $imageData): ?string {
        try {
            $current = new Imagick();
            $current->readImageBlob($imageData);
            
            $bestMatch = null;
            $bestScore = 0;
            
            foreach ($this->knownLogos as $logo) {
                if (!file_exists($logo['path'])) continue;
                
                $known = new Imagick($logo['path']);
                
                // Position-aware comparison
                if ($this->compareAtPosition($current, $known, $logo['position'])) {
                    return $logo['company'];
                }
                
                // DEBUG: Save comparison
                $known->writeImage('compare_'.$logo['company'].'.png');
            }
            
            return $bestMatch;
            
        } catch (ImagickException $e) {
            error_log("Matching error: ".$e->getMessage());
            return null;
        }
    }

        private function findLogoInImage(string $imageData): ?string {
        try {
            $page = new Imagick();
            $page->readImageBlob($imageData);
            
            // Convert to grayscale for better matching
            $page->transformImageColorspace(Imagick::COLORSPACE_GRAY);
            
            $bestMatch = null;
            $bestScore = 0;
            
            foreach ($this->knownLogos as $logo) {
                if (!file_exists($logo['path'])) continue;
                
                $logoImg = new Imagick($logo['path']);
                $logoImg->transformImageColorspace(Imagick::COLORSPACE_GRAY);
                
                // Try different positions if specified
                if (isset($logo['position'])) {
                    $result = $this->compareAtPosition($page, $logoImg, $logo['position']);
                    if ($result['score'] > 0.8 && $result['score'] > $bestScore) {
                        $bestScore = $result['score'];
                        $bestMatch = $logo['company'];
                        
                        // DEBUG: Save successful match
                        $result['region']->writeImage('match_'.$logo['company'].'.png');
                    }
                }
            }
            
            return $bestMatch;
            
        } catch (ImagickException $e) {
            throw new Exception("Logo matching failed: ".$e->getMessage());
        }
    }

    private function compareAtPosition(Imagick $page, Imagick $logo, string $position): array {
        $width = $page->getImageWidth();
        $logoWidth = $logo->getImageWidth();
        $logoHeight = $logo->getImageHeight();
        
        // Determine search coordinates based on position hint
        switch ($position) {
            case 'top-right':
                $x = $width - $logoWidth - 20;
                $y = 20;
                break;
            case 'top-left':
                $x = 20;
                $y = 20;
                break;
            default:
                $x = 0;
                $y = 0;
        }
        
        // Extract region of interest
        $region = clone $page;
        $region->cropImage($logoWidth, $logoHeight, $x, $y);
        
        // Compare images
        $result = $region->compareImages($logo, Imagick::METRIC_NORMALIZEDCROSSCORRELATION);
        
        return [
            'score' => 1 - $result[1], // Convert to similarity score
            'region' => $result[0] // The comparison image
        ];
    }
    
    private function imageHash(string $imageData): string {
        try {
            $imagick = new Imagick();
            
            // Configure for consistent hashing
            $imagick->readImageBlob($imageData);
            $imagick->setResolution(300, 300);
            
            // Convert to grayscale and resize to 8x8
            $imagick->transformImageColorspace(Imagick::COLORSPACE_GRAY);
            $imagick->resizeImage(8, 8, Imagick::FILTER_LANCZOS, 1);
            $imagick->setImageFormat('png');
            
            // Calculate average pixel value
            $total = 0;
            $pixels = [];
            
            for ($y = 0; $y < 8; $y++) {
                for ($x = 0; $x < 8; $x++) {
                    $pixel = $imagick->getImagePixelColor($x, $y);
                    $color = $pixel->getColor();
                    $value = ($color['r'] + $color['g'] + $color['b']) / 3;
                    $pixels[] = $value;
                    $total += $value;
                }
            }
            
            $average = $total / 64;
            $hash = '';
            
            // Generate hash by comparing pixels to average
            foreach ($pixels as $value) {
                $hash .= ($value > $average) ? '1' : '0';
            }
            
            return $hash;
            
        } catch (ImagickException $e) {
            throw new ImagickException("Imagick hash generation failed: " . $e->getMessage());
        }
    }
    
    private function compareHashes(string $hash1, string $hash2): bool {
        if (strlen($hash1) !== strlen($hash2)) {
            return false;
        }
        
        $distance = 0;
        $length = strlen($hash1);
        
        for ($i = 0; $i < $length; $i++) {
            if ($hash1[$i] !== $hash2[$i]) {
                $distance++;
            }
        }
        
        // Consider matches with ≤10% difference
        return ($distance / $length) <= 0.1;
    }
}