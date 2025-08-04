<?php
/**
 * Script pour les fonctions de navigation et sauvegarde
 * Gère la progression entre les étapes et la sauvegarde des données
 */
?>
<script>
// Navigation - fonction suivant
function goNext() {
    if (currentStep === 0) {
        const val = document.querySelector('input[name="responsable"]:checked');
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

    } else if (currentStep === 4) {
        var div = document.getElementById('place-date-heure-rdv');
        const val = document.querySelector('input[name="siDsiponible"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(6);
        } else {
            if (dateRDV == "") {
                $("#msgError").text("Veullez prendre le rendez-vous !");
                $('#errorOperation').modal('show');
            } else {
                div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                return showStep(5);
            }
        }
    } else if (currentStep === 6) {
        let activiteRadio = document.querySelector('input[name="activiteRadio"]:checked');
        if (activiteRadio) {
            let autreActivite = document.getElementById("autreActivite");
            if (activiteRadio.value == "Autres" && autreActivite.value == "") {
                $("#msgError").text("Veuillez saisir l'activité !");
                $('#errorOperation').modal('show');
                return;
            }
        } else {
            $("#msgError").text("Veuillez sélectionner au moins une activité !");
            $('#errorOperation').modal('show');
            return;
        }

        if (regionsChoosed.length == 0) {
            $("#msgError").text("Veuillez sélectionner au moins une région !");
            $('#errorOperation').modal('show');
            return;
        } else {
            let regionLibelles = '';
            regionsChoosed.forEach(reg => {
                regionLibelles += regionLibelles == '' ? reg[1] : ', ' + reg[1];
            });
            document.getElementById("place-regions").innerHTML = regionLibelles;
            return showStep(7);
        }
    } else if (currentStep === 7) {
        const val = document.querySelector('input[name="siExistePartenaire"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(8);
        } else {
            return showStep(9);
        }
    } else if (currentStep === 8) {
        const val = document.querySelector('input[name="siExistePartenaireRep"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(10);
        } else {
            return showStep(25); //FIN
        }
    } else if (currentStep === 9) {
        const val = document.querySelector('input[name="siRecommenderCb"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(10);
        } else if (val.value == "non") {
            return showStep(25); //FIN
        } else if (val.value == "objection") {
            const val2 = document.querySelector('input[name="objectionRecommanderCb"]:checked');
            if (!val2) {
                $("#msgError").text("Veuillez sélectionner une objection !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val2.value == "Quel avantage concret pour nous ?") {
                const val2 = document.querySelector('input[name="siAccepteSuiteQuelAvantage"]:checked');
                if (!val2) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val2.value == "oui") {
                    return showStep(10);
                } else {
                    return showStep(25); //FIN
                }
            } else if (val2.value == "Nous n'avons pas le temps de nous en occuper.") {
                const val = document.querySelector('input[name="siAccepteSuitePasTemps"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") {
                    return showStep(10);
                } else {
                    return showStep(25); //FIN
                }
            } else if (val2.value == "Méfiance ou inconnu.") {
                var div = document.getElementById('place-date-heure-rdv');
                const val = document.querySelector('input[name="siRDVMefianceInconnu"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "non") {
                    return showStep(10); //FIN
                } else {
                    if (dateRDV == "") {
                        $("#msgError").text("Veullez prendre le rendez-vous !");
                        $('#errorOperation').modal('show');
                    } else {
                        div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                        return showStep(5);
                    }
                }
            }
        }
    } else if (currentStep === 20) {
        var div = document.getElementById('place-date-heure-rdv');
        const val = document.querySelector('input[name="siDisponiblePoint"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(21);
        } else {
            if (dateRDV == "") {
                $("#msgError").text("Veullez prendre le rendez-vous !");
                $('#errorOperation').modal('show');
            } else {
                div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                return showStep(5); //Fin
            }
        }
    } else if (currentStep === 21) {
        const val = document.querySelector('input[name="siValideAujourdhui"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            return showStep(22);
        } else {
            return showStep(26); //FIN
        }
    } else if (currentStep === 22) {
        var div = document.getElementById('place-date-heure-rdv');
        const val = document.querySelector('input[name="typeRencontre"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "non") {
            return showStep(26); // Fin
        } else {
            if (dateRDV == "") {
                $("#msgError").text("Veullez prendre le rendez-vous !");
                $('#errorOperation').modal('show');
            } else {
                return showStep(23);
            }
        }
    } else if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}

// Sauvegarde partielle du script
function saveScriptPartiel(etape) {
    getInfoMail()
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let causes = formData.getAll('cause[]');
    let dommages = formData.getAll('dommages[]');
    let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
    formData.append('causes', causes);
    formData.append('dommages', dommages);
    formData.append('noteTextCampagne', noteTextCampagne);
    formData.append('idAuteur', "<?= $idAuteur ?>");
    formData.append('auteur', "<?= $auteur ?>");
    formData.append('etapeSauvegarde', etape);
    formData.append('emailDestinataire', document.querySelector('input[name="emailGerant"]').value);
    formData.append('subject', $('#objetMailEnvoiDoc').val());
    formData.append('bodyMessage', tinyMCE.get("bodyMailEnvoiDoc").getContent());

    const dataObject = Object.fromEntries(formData.entries());
    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveScriptPartiel`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        beforeSend: function() {
            if (etape == 'fin') {
                $("#msgLoading").text("Enregistrement en cours...");
                $("#loadingModal").modal("show");
            }
        },
        success: function(response) {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            
            if (etape == 'fin') {
                location.reload();
            }
        },
        error: function(response) {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("error");
        },
        complete: function() {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            if (opCree != null) {
                console.log("send code");
            }
        },
    });
}

// Finalisation
function finish() {
    saveScriptPartiel('fin');
}

// Initialisation des boutons au chargement
updateButtons();
</script>
