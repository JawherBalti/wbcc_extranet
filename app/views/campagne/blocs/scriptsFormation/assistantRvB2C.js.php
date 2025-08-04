<script>
// ================== ASSISTANT RV B2C ==================
function onClickReprogrammerRvRT() {
    loadPageRV("suivant");
    $('#divFooterRV').removeAttr("hidden");
}

function loadPageRV(params) {
    let idOP = $('#idOP').val();
    let idApp = $('#idApp').val();
    let idImmeuble = $('#idImmeuble').val();
    let adresseImmeuble = $('#adresseImm').val();
    let idContact = $('#idContact').val()
    let etage = $('#etage').val();
    let porte = $('#porte').val();
    let tel = $('#telRV').val();
    let email = $('#emailRV').val();
    let textRV = $("#INFO_RDV").text();
    let libellePartieCommune = $('#libellePartieCommune').val()
    let cote = $('#cote').val()
    let typeSinistre = $('#typeSinistre').val();

    let verif = true;
    let text = "";
    //Vérif assurance
    if (params == "suivant") {
        if (numPageRV == "1") {
            if (tel == "" || email == "") {
                text = "Veuillez renseigner le numèro de téléphone et l'adresse Email !";
                verif = false;
            }
        } else {
            if (numPageRV == "2") {
                if (typeSinistre != "Partie commune exclusive" && (adresseImmeuble == "" || etage ==
                        "" || porte == "")) {
                    text = "Veuillez renseigner l'adresse, l'étage et le N° de porte !";
                    verif = false;
                }
                if (typeSinistre == "Partie commune exclusive" && (libellePartieCommune == "")) {
                    text = "Veuillez renseigner l'adresse et la localisation !";
                    verif = false;
                }
            } else {
                if (numPageRV == "3") {
                    if (textRV == "") {
                        text = "Veuillez choisir une disponibilité !";
                        verif = false;
                    }
                } else {

                }
            }
        }
    }

    if (verif) {
        console.log(numPageRV)
        //SI MEME RV
        let siMemeRV = $('.siMemeRV:checked').val();
        //SET TEL EMAIL
        $('#telContact').val(tel);
        $('#emailContact').val(email);
        $('#divRV' + numPageRV).attr("hidden", "hidden");
        if (params == 'suivant') {
            if (siMemeRV == "Oui") {
                $("#INFO_RDV").text("RDV à prendre pour " + $('#nomCommercialFuturRV').val() + " le " + $(
                        '#dateFuturRV').val() + " à partir de " +
                    $('#heureFuturRV').val());
                $('#expertRV').attr("value", $('#nomCommercialFuturRV').val());
                $('#idExpertRV').attr("value", $('#idCommercialFuturRV').val());
                $('#dateRV').attr("value", $('#dateFuturRV').val());
                $('#heureRV').attr("value", $('#heureFuturRV').val());
                numPageRV = 4;
            } else {
                if (numPageRV == "1") {
                    // addOrupdateContact('update');
                }
                if (numPageRV == "2") {
                    // AddOrEditImmeuble('editLot');
                }
                numPageRV++;

                if (numPageRV == "1") {
                    onClickPrendreRvRT();
                }
            }
        } else {
            if (siMemeRV == "Oui") {
                numPageRV = 0;
            } else {
                numPageRV--;
            }
        }
        console.log("after " + numPageRV);
        $('#divRV' + numPageRV).removeAttr("hidden");

        if (numPageRV == 0) {
            $('#btnRVPrec').attr("hidden", "hidden");
        } else {
            $('#btnRVPrec').removeAttr("hidden");
        }

        if (numPageRV == nbPageRV) {
            $('#btnRVSuiv').attr("hidden", "hidden");
            $('#btnRVTerminer').removeAttr("hidden");

        } else {
            $('#btnRVSuiv').removeAttr("hidden");
            $('#btnRVTerminer').attr("hidden", "hidden");
        }

    } else {
        $("#msgError").text(text);
        $('#errorOperation').modal('show');
    }
}

function onClickEnregistrerRV() {
    let expert = $('#expertRV').val();
    let idExpert = $('#idExpertRV').val();
    let idContact = $('#idContactRV').val();
    let date = $('#dateRV').val();
    let heure = $('#heureRV').val();
    let adresse = $('#adresseImm').val();
    let commentaire = $('#commentaireRV').val();
    
    if (idExpert != "0" && idContact != "0" && date != "" && heure != "" && adresse != "") {
        let post = [];
        post[0] = {
            idOpportunityF: $('#idOP').val(),
            numeroOP: $('#nameOP').val(),
            expert: expert,
            idExpert: idExpert,
            idContact: idContact,
            idContactGuidF: $('#numeroContactRV').val(),
            dateRV: date,
            heureDebut: heure,
            adresseRV: adresse,
            etage: $('#etage2').val(),
            porte: $('#porte2').val(),
            lot: $('#lot2').val(),
            batiment: $('#batiment2').val(),
            conclusion: commentaire,
            idUtilisateur: $('#idUtilisateur').val(),
            numeroAuteur: $('#numeroAuteur').val(),
            auteur: $('#auteur').val(),
            idRVGuid: "",
            idRV: "0",
            idAppGuid: $('#numeroApp').val(),
            idAppExtra: $('#idApp').val(),
            idAppConF: $('#idAppCon').val(),
            nomDO: $('#nomDO').val(),
            moyenTechnique: "",
            idCampagneF: "",
            typeRV: "RTP",
            cote: $('#cote2').val(),
            libellePartieCommune: $('#libellePartieCommune2').val(),
            typeLot: $('#typeLot').val()
        }

        $.ajax({
            url: `<?= URLROOT ?>/public/json/rendezVous.php?action=saveRVRT&sourceEnreg=interne`,
            type: 'POST',
            data: JSON.stringify(post),
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Validation de RDV RT en cours...");
                $("#loadingModal").modal("show");
            },
            success: function(response) {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500)
                if (response != "0") {
                    if (response == "2") {
                        $("#msgError").text(
                            "Cette disponibilité est invalide, veuillez choisir une autre !"
                        );
                        $('#errorOperation').modal('show');
                    } else {
                        $('#divPriseRvRT').attr("hidden", "hidden");
                        $('#btnRvRT').attr("hidden", "hidden");
                        $("#msgSuccess").text("Rendez-vous RT pris avec succés !");
                        $('#successOperation').modal('show');
                        closeActivity('Programmer le RT', 3);
                    }
                } else {
                    $("#msgError").text(
                        "(1)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !"
                    );
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response) {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);

                console.log("Erreur")
                console.log(response)
                $("#msgError").text(
                    "(2)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !"
                );
                $('#errorOperation').modal('show');
            },
            complete: function() {

            },
        });
    } else {
        $("#msgError").text(
            "Veuillez renseigner tous les champs obligatoires !"
        );
        $('#errorOperation').modal('show');
    }
}
</script>
