<?php
class NERCompanyExtractor {
    private $companyKeywords = ['client', 'société', 'company', 'fournisseur', 'vendor'];
    private $legalForms = ['SA', 'SAS', 'SARL', 'GmbH', 'Inc', 'Ltd', 'LLC'];
    
    public function extractCompanies(string $text): array {
        $candidates = [];
        
        // Find potential company names near keywords
        foreach ($this->companyKeywords as $keyword) {
            if (preg_match_all('/' . $keyword . '[:]?\s*([^\n\r,.]+)/i', $text, $matches)) {
                    $candidates = array_merge($candidates, $matches[1]);
            }
        }
        
        // Find potential company names with legal forms
        $legalFormPattern = implode('|', array_map('preg_quote', $this->legalForms));
        if (preg_match_all("/\b([A-Z][a-zA-Z\s&]+)\s*(?:$legalFormPattern)\b/i", $text, $matches)) {
            $candidates = array_merge($candidates, $matches[1]);
        }
        
        // Clean and score candidates
        $scored = [];
        foreach ($candidates as $candidate) {
            $clean = $this->cleanCandidate($candidate);
            if ($this->isValidCompany($clean)) {
                $score = $this->scoreCompanyName($clean);
                $scored[$clean] = $score;
            }
        }
        
        arsort($scored);
        return array_keys($scored);
    }
    
    private function cleanCandidate(string $text): string {
        $text = preg_replace('/[^\w\s&.-]/u', '', $text);
        return trim($text);
    }
    
    private function isValidCompany(string $name): bool {
        return strlen($name) > 3 && 
               preg_match('/[A-Z]/', $name) && 
               !preg_match('/^\d+$/', $name);
    }
    
    private function scoreCompanyName(string $name): int {
        $score = 0;
        
        // Points for containing legal form abbreviations
        foreach ($this->legalForms as $form) {
            if (stripos($name, $form) !== false) {
                $score += 10;
            }
        }
        
        // Points for capitalization patterns
        if (preg_match('/^[A-Z]/', $name)) $score += 2;
        if (preg_match('/\b[A-Z][a-z]+\b/', $name)) $score += 3;
        
        // Points for length (not too short, not too long)
        $len = strlen($name);
        if ($len > 5 && $len < 50) $score += 2;
        
        return $score;
    }
}