<?php
/**
 * Bloc JavaScript - Variables globales et initialisation pour formation
 */
?>
<script>
// Variables globales pour la navigation
const steps = document.querySelectorAll(".step");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const finishBtn = document.getElementById("finishBtn");
const indexPage = document.getElementById('indexPage');
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
const history = [];
let opCree = null;
let signature = null;
$(`#numQuestionScript0`).text(1);
let siInterlocuteur = false;
const refs = document.querySelectorAll('[ref]');

// Variables pour les RDV
var rdv1Exst = true;
var divRDV1 = '';
var rdv1Position1 = 0;
var hidePlaceRdv1 = true,
    hidePlaceRdvbis = true;
var hidePlaceRdv2 = true,
    hidePlaceRdv2bis = true;

// Variables pour l'assistant territorial
let numPageTE = 0;
let nbPageTE = 4;
var regionsChoosed = [],
    departementChoosed = [];

// Gestion des références
refs.forEach(ref => {
    ref.addEventListener('input', (e) => {
        //update all other ref value
        refs.forEach(r => {
            if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                r.value = ref.value;
            }
        });
    });
});

// Fonction utilitaire pour sélectionner un radio button
function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// Fonction de mise à jour de la pagination
function updatePagination() {
    console.log('=== updatePagination called - currentStep:', currentStep, 'steps.length:', steps.length);
    if (typeof indexPage !== 'undefined' && indexPage) {
        const pageText = (currentStep + 1) + ' / ' + steps.length;
        indexPage.textContent = pageText;
        console.log('=== Pagination updated to:', pageText);
    } else {
        console.log('=== ERROR: indexPage element not found!');
    }
}

// Fonction globale pour afficher une étape
function showStep(n) {
    console.log('=== showStep called with:', n, 'Current step:', currentStep, 'Steps length:', steps.length);
    
    if (n >= steps.length) n = steps.length - 1;
    if (n < 0) n = 0;
    
    currentStep = n;
    
    // Masquer toutes les étapes
    steps.forEach(step => step.classList.remove('active'));
    
    // Afficher l'étape actuelle
    if (steps[currentStep]) {
        steps[currentStep].classList.add('active');
        console.log('=== Step', currentStep, 'is now active');
    } else {
        console.log('=== ERROR: Step', currentStep, 'not found!');
    }
    
    // Mettre à jour la navigation et la pagination
    updateNavigationButtons();
    updatePagination();
    console.log('=== Navigation updated for step:', currentStep);
}

// Fonction pour mettre à jour les boutons de navigation
function updateNavigationButtons() {
    if (typeof prevBtn !== 'undefined' && prevBtn) {
        prevBtn.classList.toggle('hidden', currentStep === 0);
    }
    if (typeof nextBtn !== 'undefined' && nextBtn) {
        nextBtn.classList.toggle('hidden', currentStep === steps.length - 1);
    }
    if (typeof finishBtn !== 'undefined' && finishBtn) {
        finishBtn.classList.toggle('hidden', currentStep !== steps.length - 1);
    }
}

// Fonction pour aller à l'étape précédente
function goBackScript() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

// Fonction pour aller à l'étape suivante (sans logique complexe)
function goNext() {
    console.log('goNext() called - Current step:', currentStep, 'Steps length:', steps.length);
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
        console.log('Moved to step:', currentStep);
    } else {
        console.log('Already at last step');
    }
}

// Fonction pour terminer la formation
function finish() {
    alert('Formation terminée !');
}

// Fonction de navigation simple (pour les cas sans logique complexe)
function goNextSimple() {
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== Variables globales: DOMContentLoaded - Steps count:', steps.length);
    console.log('=== Available elements:', {
        steps: steps.length,
        prevBtn: prevBtn ? 'found' : 'NOT FOUND',
        nextBtn: nextBtn ? 'found' : 'NOT FOUND', 
        finishBtn: finishBtn ? 'found' : 'NOT FOUND',
        indexPage: indexPage ? 'found' : 'NOT FOUND'
    });
    
    // Attendre un peu pour que tous les scripts soient chargés
    setTimeout(function() {
        console.log('=== Initializing navigation...');
        
        // Initialiser la pagination au démarrage
        updatePagination();
        
        // Mettre à jour les numéros de questions
        updateQuestionNumbers();
        
        // Afficher la première étape
        if (steps.length > 0) {
            console.log('=== Showing first step');
            showStep(0);
        } else {
            console.log('=== ERROR: No steps found!');
        }
    }, 100);
});

// Fonction pour mettre à jour les numéros de questions
function updateQuestionNumbers() {
    const questionNumbers = document.querySelectorAll('span[name="numQuestionScript"]');
    questionNumbers.forEach((span, index) => {
        span.textContent = index + 1;
    });
}
</script>
