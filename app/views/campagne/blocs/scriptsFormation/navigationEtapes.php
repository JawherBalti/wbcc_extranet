<?php
/**
 * Script pour la navigation entre étapes dans le formulaire de formation
 * Gère l'affichage, navigation et mise à jour des étapes
 */
?>
<script>
// Variables pour la navigation des étapes
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

// Gérer les références multiples
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

// Sélection radio via bouton
function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// Mise à jour des boutons de navigation
function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    nextBtn.classList.toggle("hidden", (currentStep == 24 || currentStep == 25 || currentStep == 5 || currentStep == 26));
    finishBtn.classList.toggle("hidden", (currentStep != 24 && currentStep != 25 && currentStep != 5 && currentStep != 26));

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = numQuestionScript;
    });
}

// Afficher une étape spécifique
function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;
    currentStep = index;
    steps[currentStep].classList.add("active");

    // Incrementer numQuestionScript selon l'étape
    if (currentStep == 4 || currentStep == 6 || currentStep == 7 || currentStep == 8 || 
        currentStep == 9 || currentStep == 10 || currentStep == 11 || currentStep == 20 || 
        currentStep == 21 || currentStep == 22 || currentStep == 23 || currentStep == 25 || 
        currentStep == 24 || currentStep == 5 || currentStep == 26) {
        numQuestionScript++;
    }
    updateButtons();
}

// Retour étape précédente
function goBackScript() {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    
    // Décrémenter numQuestionScript si nécessaire
    if (currentStep == 4 || currentStep == 6 || currentStep == 7 || currentStep == 8 || 
        currentStep == 9 || currentStep == 10 || currentStep == 11 || currentStep == 20 || 
        currentStep == 21 || currentStep == 22 || currentStep == 23 || currentStep == 25 || 
        currentStep == 24 || currentStep == 5 || currentStep == 26) {
        numQuestionScript--;
    }
    updateButtons();
}

// Gestion des sous-questions
function showSousQuestion(idSS, $show) {
    if ($show) {
        $(`#sous-question-${idSS}`).removeAttr('hidden');
    } else {
        $(`#sous-question-${idSS}`).attr('hidden', '');
    }
}
</script>
