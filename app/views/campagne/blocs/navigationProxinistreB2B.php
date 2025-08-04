<?php
/**
 * Bloc navigation pour production B2B Proxinistre
 * Intégration avec le système existant
 */
?>
<div class="buttons">
    <button type="button" class="btn-prev" onclick="goToPreviousSection()" id="prevBtn" style="display: none;">
        <i class="fas fa-arrow-left"></i> Précédent
    </button>
    <label for="" style="align-self: center; margin: 0 20px; font-size: 16px; font-weight: bold;">
        Étape <span id="currentSectionIndex" class="font-weight-bold">1</span> / <span id="totalSections">6</span>
    </label>
    <button type="button" class="btn-next" onclick="goToNextSection()" id="nextBtn">
        Suivant <i class="fas fa-arrow-right"></i>
    </button>
    <button type="button" class="btn-finish" onclick="finishProxinistreB2B()" id="finishBtn" style="display: none;">
        <i class="fas fa-check"></i> Terminer
    </button>
</div>

<script>
// Variables globales pour la navigation des sections principales
let currentMainSection = 0;
const mainSections = [
    'divBodyAccueil',
    'divBodyDoc', 
    'divBodyDSS',
    'divBodySD',
    'divBodyRvRT',
    'divBodyRvPerso'
];

function showMainSection(index) {
    if (index >= mainSections.length) { 
        index = mainSections.length - 1; 
    }
    if (index < 0) { 
        index = 0; 
    }
    
    currentMainSection = index;
    
    // Masquer toutes les sections principales (les div parents)
    mainSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });
    
    // Afficher la section actuelle
    const currentSection = document.getElementById(mainSections[currentMainSection]);
    if (currentSection) {
        currentSection.style.display = 'block';
        
        // Si la section a des sous-étapes internes (comme DSS, SD, etc.), afficher la première
        const subSteps = currentSection.querySelectorAll('.stepDSS, .stepSD, .stepRvRT, .stepRvPerso');
        if (subSteps.length > 0) {
            // Masquer toutes les sous-étapes de cette section
            subSteps.forEach(step => step.classList.remove('active'));
            // Afficher la première sous-étape
            subSteps[0].classList.add('active');
        }
    }
    
    // Mettre à jour les boutons de navigation
    updateMainNavigationButtons();
    
    // Mettre à jour l'index affiché
    document.getElementById('currentSectionIndex').textContent = currentMainSection + 1;
    document.getElementById('totalSections').textContent = mainSections.length;
}

function updateMainNavigationButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const finishBtn = document.getElementById('finishBtn');
    
    if (currentMainSection === 0) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'inline-block';
    }
    
    if (currentMainSection === mainSections.length - 1) {
        nextBtn.style.display = 'none';
        finishBtn.style.display = 'inline-block';
    } else {
        nextBtn.style.display = 'inline-block';
        finishBtn.style.display = 'none';
    }
}

function goToNextSection() {
    if (currentMainSection < mainSections.length - 1) {
        showMainSection(currentMainSection + 1);
    }
}

function goToPreviousSection() {
    if (currentMainSection > 0) {
        showMainSection(currentMainSection - 1);
    }
}

function finishProxinistreB2B() {
    if (confirm('Êtes-vous sûr de vouloir terminer cette campagne de production B2B ?')) {
        alert('Campagne de production B2B terminée !');
        // Ici vous pouvez ajouter la logique pour sauvegarder les données
    }
}

// Fonctions de compatibilité avec l'ancien système
function goNext(section) {
    goToNextSection();
}

function goBackScript(section) {
    goToPreviousSection();
}

function finish(section) {
    finishProxinistreB2B();
}

// Initialiser la navigation au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Attendre que le DOM soit complètement chargé
    setTimeout(() => {
        showMainSection(0);
    }, 100);
});
</script>
