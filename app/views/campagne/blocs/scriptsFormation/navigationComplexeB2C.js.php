<script>
// ================== NAVIGATION COMPLEXE ET LOGIQUE MÉTIER B2C ==================

// Note: Les fonctions de base (showStep, updateNavigationButtons, updatePagination) 
// sont définies dans variablesGlobales.php pour éviter la duplication

// Initialisation
// Note: L'initialisation est gérée dans variablesGlobales.php pour éviter les conflits

// ================== LOGIQUE MÉTIER SPÉCIFIQUE B2C ==================

function goNextB2C() {
    console.log('=== goNextB2C called - currentStep:', currentStep, 'steps.length:', steps.length);
    
    if (currentStep === 0) {
        const val = document.querySelector('input[name="prospectB2C"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            $("#sous-question-0").attr("hidden", "hidden");
            showStep(1);
            return;
        } else {
            $("#sous-question-0").removeAttr("hidden");
            showStep(1);
            return;
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
            showStep(4);
            return;
        } else {
            showStep(3);
            return;
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
            showStep(4);
            return;
        } 
        else if (val.value == "rdv") {
            // RDV + FIN RDV
            return;
        } else {
            // Fin
            showStep(30);
            return;
        }
    }
    else if (currentStep === 4) {
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        const Autre = document.getElementById('Autre');

        if (! Proprietaire.checked  && ! Locataire.checked  && ! Autre.checked ) {
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
                showStep(6);
                return;
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
                    showStep(5);
                    return;
                }
                else{
                    showStep(7);
                    return;
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
            if(! Proprietaire.checked && ! Locataire.checked){
                showStep(31);
                return;
            }
            else{
                showStep(7);
                return;
            }
        } else {
            if(! Proprietaire.checked && ! Locataire.checked){
                showStep(30);
                return;
            }
            else{
                showStep(7);
                return;
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
            showStep(7);
            return;
        }
    }
    else if (currentStep === 9) {
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        const Autre = document.getElementById('Autre');

        if(! Proprietaire.checked && ! Locataire.checked && ! Autre.checked){
            showStep(4);
            return;
        }   
        else{
            if(Proprietaire.checked){
                const typeBienProprietaure = document.querySelector('input[name="typeBienProprietaure"]:checked');
                if(typeBienProprietaure.value == "Résidence principale en copropriété"){
                    showStep(10);
                    return;
                }
                else if(typeBienProprietaure.value == "Bien mis en location"){
                    showStep(16);
                    return;
                }
                else if(typeBienProprietaure.value == "Projet de vente"){
                    showStep(22);
                    return;
                }
                else{
                    showStep(4);
                    return;
                }
                
            }
            else if(Locataire.checked){
                showStep(28);
                return;
            }
            else{
                showStep(30);
                return;
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
            showStep(15);
            return;
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                showStep(28);
                return;
            }
            else{
                showStep(33);
                return;
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
                showStep(28);
                return;
            }
            else{
                showStep(30);
                return;
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
            showStep(21);
            return;
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                showStep(28);
                return;
            }
            else{
                showStep(33);
                return;
            }
        }
    }
    else if (currentStep === 21) {
        showStep(30);
        return;
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
                showStep(28);
                return;
            }
            else{
                showStep(30);
                return;
            }
        } else {
            const Locataire = document.getElementById('Locataire');
            if(Locataire.checked){
                showStep(28);
                return;
            }
            else{
                showStep(33);
                return;
            }
        }
    }
    else if (currentStep === 29) {
        showStep(33);
        return;
    }
    else if (currentStep === 31) {
        showStep(30);
        return;
    }
    else if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}
</script>
