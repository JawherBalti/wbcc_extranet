<?php
/**
 * Bloc navigation pour formation
 * Variables attendues: $section (nom de la section actuelle)
 * Utilise les fonctions existantes goBackScript(), goNext(), finish()
 */
$sectionName = isset($section) ? $section : 'Formation';
?>
<div class="buttons">
    

    <button type="button" class="btn-prev" onclick="previousStep()" id="prevBtn" style="display: none;">
        <i class="fas fa-arrow-left"></i> Précédent
    </button>
    <label for="" style="align-self: center; margin: 0 20px; font-size: 16px; font-weight: bold;">
        Page <span id="indexPage" class="font-weight-bold"></span>
    </label>
    <button type="button" class="btn-next" onclick="nextStep()" id="nextBtn">
        Suivant <i class="fas fa-arrow-right"></i>
    </button>
    <button type="button" class="btn-finish" onclick="finishFormation()" id="finishBtn" style="display: none;">
        <i class="fas fa-check"></i> Terminer
    </button>
</div>

<script>
// Variables globales pour la navigation des étapes
let currentStep<?= $sectionName ?> = 0;
const steps<?= $sectionName ?> = document.querySelectorAll('.step');

function showStep<?= $sectionName ?>(n) {
    if (n >= steps<?= $sectionName ?>.length) { 
        currentStep<?= $sectionName ?> = steps<?= $sectionName ?>.length - 1; 
    }
    if (n < 0) { 
        currentStep<?= $sectionName ?> = 0; 
    }
    
    // Masquer toutes les étapes
    steps<?= $sectionName ?>.forEach(step => step.classList.remove('active'));
    
    // Afficher l'étape actuelle
    if (steps<?= $sectionName ?>[currentStep<?= $sectionName ?>]) {
        steps<?= $sectionName ?>[currentStep<?= $sectionName ?>].classList.add('active');
    }
    
    // Gérer les boutons de navigation
    updateNavigationButtons<?= $sectionName ?>();
}

function updateNavigationButtons<?= $sectionName ?>() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const finishBtn = document.getElementById('finishBtn');
    
    if (currentStep<?= $sectionName ?> === 0) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'inline-block';
    }
    
    if (currentStep<?= $sectionName ?> === steps<?= $sectionName ?>.length - 1) {
        nextBtn.style.display = 'none';
        finishBtn.style.display = 'inline-block';
    } else {
        nextBtn.style.display = 'inline-block';
        finishBtn.style.display = 'none';
    }
}

function nextStep() {
    if (currentStep<?= $sectionName ?> < steps<?= $sectionName ?>.length - 1) {
        currentStep<?= $sectionName ?>++;
        showStep<?= $sectionName ?>(currentStep<?= $sectionName ?>);
    }
}

function previousStep() {
    if (currentStep<?= $sectionName ?> > 0) {
        currentStep<?= $sectionName ?>--;
        showStep<?= $sectionName ?>(currentStep<?= $sectionName ?>);
    }
}

function finishFormation() {
    // Logique pour terminer la formation
    alert('Formation terminée !');
    // Ici vous pouvez ajouter la logique pour sauvegarder les données
}

// Initialiser la navigation au chargement
document.addEventListener('DOMContentLoaded', function() {
    showStep<?= $sectionName ?>(0);
});
</script>
