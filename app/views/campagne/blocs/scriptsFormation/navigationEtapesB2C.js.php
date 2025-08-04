<?php
/**
 * Navigation et gestion des étapes - B2C Formation Campagne
 * Logique spécifique aux chemins conditionnels B2C
 */
?>
<script>
function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    nextBtn.classList.toggle("hidden", (currentStep == 30 || currentStep == 36));
    finishBtn.classList.toggle("hidden", (currentStep != 30 && currentStep != 36));

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = numQuestionScript;
    });
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;
    currentStep = index;
    steps[currentStep].classList.add("active");

    if (currentStep == 4 || currentStep == 6 || currentStep == 7 || currentStep == 8 || 
        currentStep == 9 || currentStep == 10 || currentStep == 11 || currentStep == 20 || 
        currentStep == 21 || currentStep == 22 || currentStep == 23 || currentStep == 25 || 
        currentStep == 24 || currentStep == 5 || currentStep == 26) {
        numQuestionScript++;
    }
    updateButtons();
}

function goBackScript() {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");

    if (currentStep == 3 || currentStep == 4 || currentStep == 6 || currentStep == 7 || 
        currentStep == 8 || currentStep == 9 || currentStep == 10 || currentStep == 11 || 
        currentStep == 20 || currentStep == 21 || currentStep == 22 || currentStep == 24) {
        numQuestionScript--;
    }
    updateButtons();
}

function goNext() {
    if (currentStep === 0) {
        const val = document.querySelector('input[name="prospectB2C"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            $("#sous-question-0").attr("hidden", "hidden");
            return showStep(1);
        } else {
            $("#sous-question-0").removeAttr("hidden");
            return showStep(1);
        }
    }
    else if (currentStep === 2) {
        const val = document.querySelector('input[name="siDsiponible"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(4);
        } else {
            return showStep(3);
        }
    }
    else if (currentStep === 3) {
        const val = document.querySelector('input[name="siOccupe"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(4);
        } 
        else if (val.value == "rdv") {
            // RDV + FIN RDV
        } else {
            // Fin
            return showStep(30);
        }
    }
    else if (currentStep === 4) {
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        const Autre = document.getElementById('Autre');

        if (!Proprietaire.checked && !Locataire.checked && !Autre.checked) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (Proprietaire.checked) {
            const val2 = document.querySelector('input[name="typeBienProprietaure"]:checked');
            if (!val2) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            else{
                return showStep(6);
            }
        } 
        if(Locataire.checked || Autre.checked) {
            const val2 = document.querySelector('input[name="siContacBailleur"]:checked');
            if (!val2) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            else{
                if(Autre.checked){
                    return showStep(5);
                }
                else{
                    return showStep(7);
                }
            }
        }
    }
    else if (currentStep === 5) {
        const val = document.querySelector('input[name="siEnvisagerProjetImmobilier"]:checked');
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        else if (val.value == "oui") {
            if(!Proprietaire.checked && !Locataire.checked){
                return showStep(31);
            }
            else{
                return showStep(7);
            }
        } else {
            if(!Proprietaire.checked && !Locataire.checked){
                return showStep(30);
            }
            else{
                return showStep(7);
            }
        }
    }
    else if (currentStep === 6) {
        const val = document.querySelector('input[name="correcteInfosProprietaire"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        else{
            return showStep(7);
        }
    }
    else if (currentStep === 9) {
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        const Autre = document.getElementById('Autre');

        if(!Proprietaire.checked && !Locataire.checked && !Autre.checked){
            return showStep(4);
        }   
        else{
            if(Proprietaire.checked){
                const typeBienProprietaure = document.querySelector('input[name="typeBienProprietaure"]:checked');
                if(typeBienProprietaure.value == "Résidence principale en copropriété"){
                    return showStep(10);
                }
                else if(typeBienProprietaure.value == "Bien mis en location"){
                    return showStep(16);
                }
                else if(typeBienProprietaure.value == "Projet de vente"){
                    return showStep(22);
                }
                else{
                    return showStep(4);
                }
            }
            else if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(30);
            }
        }
    }
    else if (currentStep === 14) {
        const val = document.querySelector('input[name="rdvOuEtudeGratuite"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "Refus changement syndic") {
            return showStep(15);
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(33);
            }
        }
    }
    else if (currentStep === 15) {
        const val = document.querySelector('input[name="demandeConnaissanceAutreProspect"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        else{
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(30);
            }
        }
    }
    else if (currentStep === 20) {
        const val = document.querySelector('input[name="typeRencontre"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "non") {
            return showStep(21);
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(33);
            }
        }
    }
    else if (currentStep === 21) {
        return showStep(30);
    }
    else if (currentStep === 27) {
        const val = document.querySelector('input[name="siEstimationRDV"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "non") {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(30);
            }
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                return showStep(28);
            }
            else{
                return showStep(33);
            }
        }
    }
    else if (currentStep === 29) {
        return showStep(33);
    }
    else if (currentStep === 31) {
        return showStep(30);
    }
    else if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}

function finish() {
    saveScriptPartiel('fin');
}

updateButtons();
</script>
