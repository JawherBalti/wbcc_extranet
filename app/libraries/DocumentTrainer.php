<?php
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;

class DocumentTrainer {
    private $samples = [];
    private $labels = [];
    private $vectorizer;
    private $transformer;
    
    public function __construct() {
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->transformer = new TfIdfTransformer();
    }
    
    public function addDocument(string $text, string $category) {
        $this->samples[] = $text;
        $this->labels[] = $category;
    }
    
    public function trainModel() {
        // Vectorisation des textes
        $this->vectorizer->fit($this->samples);
        $this->vectorizer->transform($this->samples);
        
        // Application du TF-IDF
        $this->transformer->fit($this->samples);
        $this->transformer->transform($this->samples);
        
        return new ArrayDataset($this->samples, $this->labels);
    }
}