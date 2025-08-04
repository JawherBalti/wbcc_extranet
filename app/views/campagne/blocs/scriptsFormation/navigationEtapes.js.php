<?php
/**
 * Bloc JavaScript - Navigation et gestion des étapes pour formation
 */
?>
<script>
function updateNavigationButtons() {
    if (typeof prevBtn === 'undefined' || typeof nextBtn === 'undefined' || typeof finishBtn === 'undefined') return;
    prevBtn.classList.toggle('hidden', currentStep === 0);
    nextBtn.classList.toggle('hidden', currentStep === steps.length - 1);
    finishBtn.classList.toggle('hidden', currentStep !== steps.length - 1);
}

function showStep(n) {
    if (n >= steps.length) currentStep = steps.length - 1;
    if (n < 0) currentStep = 0;
    steps.forEach(step => step.classList.remove('active'));
    if (steps[currentStep]) steps[currentStep].classList.add('active');
    updateNavigationButtons();
    updatePagination();
}

function goNext() {
    if (currentStep < steps.length - 1) {
        currentStep++;
        showStep(currentStep);
    }
}

function goBackScript() {
    if (currentStep > 0) {
        currentStep--;
        showStep(currentStep);
    }
}

function finish() {
    // Logique de fin de formation
    alert('Formation terminée !');
}

// Note: L'initialisation est gérée dans variablesGlobales.php pour éviter les conflits
</script>
