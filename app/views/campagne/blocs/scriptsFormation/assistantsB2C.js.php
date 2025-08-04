<?php
/**
 * Assistants complexes B2C : Signature, RV, et fonctions spécialisées
 */
?>
<script>
// Variables pour les assistants
let iColor = 0;
let nbPage = 0;
let nbPageTotal = 0;
let k = 0;
let nbDispo = 0;
let horaires = [];
let nTaille = 0;
let commercialRDV = "";
let idCommercialRDV = "0";

// Fonctions utilitaires pour le temps
function msToTime(s) {
    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    var hrs = (s - mins) / 60;

    return String(hrs).padStart(2, '0') + ':' + String(mins).padStart(2, '0');
}

// =====================
// ASSISTANT SIGNATURE
// =====================
function loadPageSign(params) {
    let idOP = $('#idOP').val();
    let numPolice = $('#numPolice').val();
    let numSinistre = $('#numSinistre').val();
    let dateSinistre = $('#dateSinistre').val();
    let dateDebutContrat = $('#dateDebutContrat').val();
    let dateFinContrat = $('#dateFinContrat').val();
    let idCie = $('#idCie').val();
    let guidCie = $('#numeroCie').val();
    let nomCie = $('#nomCie').val();
    let adresse = $('#adresseCie').val();
    let ville = $('#villeCie').val();
    let codePostal = $('#codePostalCie').val();
    let email = $('#emailCie').val();
    let tel = $('#telCie').val();
    let idApp = $('#idApp').val();
    let idImmeuble = $('#idImmeuble').val();
    let adresseImmeuble = $('#adresseImm').val();
    let dateNaissance = $('#dateNaissance').val();
    let prenomSignataire = $('#prenomSignataire').val();
    let nomSignataire = $('#nomSignataire').val();
    let idSignataire = $('#idSignataire').val();
    let idContact = $('#idContact').val()
    let etage = $('#etage').val();
    let porte = $('#porte').val()
    let libellePartieCommune = $('#libellePartieCommune').val()
    let cote = $('#cote').val()
    let typeSinistre = $('#typeSinistre').val();
    let resultatActivityTE = $('#resultatActivityTE').val()
    let emailSign = $('#emailSign').val();
    let telSign = $('#telSign').val()
    let signature = $('#modeSignature').val()

    let verif = true;
    let text = "";

    if (params == "suivant") {
        if (numPageSign == "1") {
            if (typeSinistre != "Partie commune exclusive" && (dateNaissance == "" || prenomSignataire.trim() == "" ||
                    nomSignataire.trim() == "")) {
                if (dateNaissance == "") {
                    text = "Veuillez renseigner la date de naissance !";
                } else {
                    if (prenomSignataire.trim() == "") {
                        text = "Veuillez renseigner le prénom !";
                    } else {
                        if (nomSignataire.trim() == "") {
                            text = "Veuillez renseigner le nom !";
                        }
                    }
                }
                verif = false;
            }
        } else {
            if (numPageSign == "3") {
                if (nomCie == "") {
                    text = "Veuillez renseigner la compagnie d'assurance !";
                    verif = false;
                }
            } else {
                if (numPageSign == "4") {
                    if (numPolice == "" || dateDebutContrat == "" || dateFinContrat == "") {
                        text = "Veuillez renseigner les informations du contrat d'assurance !";
                        verif = false;
                    }
                } else {
                    if (numPageSign == "5") {
                        if (dateSinistre == "") {
                            text = "Veuillez renseigner la date du sinistre !";
                            verif = false;
                        }
                    } else {
                        if (numPageSign == "2") {
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
                            if (numPageSign == "7") {
                                if (emailSign == "" || telSign == "") {
                                    text = "Veuillez confirmer le numèro de téléphone et l'adresse email !";
                                    verif = false;
                                }
                            }
                        }
                    }
                }
            }
        }

        if (verif) {
            console.log("numPage " + numPageSign);
        }
    } else {
        $('#divCodeSign').attr("hidden", "hidden");
        $('#btnSignFinaliser').attr("hidden", "hidden");
    }

    if (verif) {
        $('#divSign' + numPageSign).attr("hidden", "hidden");
        if (params == 'suivant') {
            numPageSign++;
        } else {
            numPageSign--;
        }
        $('#divSign' + numPageSign).removeAttr("hidden");

        if (numPageSign == 0) {
            $('#btnSignPrec').attr("hidden", "hidden");
        } else {
            $('#btnSignPrec').removeAttr("hidden");
        }

        if (numPageSign == nbPageSign) {
            let btn = document.getElementById("btnSignTerminer");
            if (signature != null && signature != "") {
                btn.innerHTML =
                    `<a type="button" class="text-center btn btn-success" onclick="onClickTerminerAssistant()">Terminer</a>`;
            } else {
                btn.innerHTML =
                    `<a type="button" class="text-center btn btn-danger" onclick="onClickTerminerAssistant()">Suivant</a>`;
            }
            $('#btnSignSuiv').attr("hidden", "hidden");
            $('#btnSignTerminer').removeAttr("hidden");
        } else {
            $('#btnSignSuiv').removeAttr("hidden");
            $('#btnSignTerminer').attr("hidden", "hidden");
        }
    } else {
        $("#msgError").text(text);
        $('#errorOperation').modal('show');
    }
}

function onClickTerminerAssistant() {
    $("#msgLoading").text("Enregistrement en cours...");
    $('#loadingModal').modal('show');

    let emailSign = $('#emailSign').val();
    let telSign = $('#telSign').val()

    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    formData.append("connectedUser", `<?= json_encode($connectedUser) ?>`);
    const dataObject = Object.fromEntries(formData.entries());
    console.log(dataObject);

    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveOPAndGenerateDeleg`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        success: function(response) {
            if (response != "0") {
                opCree = response;
            }
        },
        error: function(response) {
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 500);
            $('#errorOperation').modal('show');
        },
        complete: function() {
            if (opCree != null) {
                console.log("send code");
                //Send Code
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/signature.php?action=sendCodeSignature`,
                    type: 'POST',
                    data: {
                        idOp: opCree.idOpportunity,
                        idDoc: opCree.delegationDoc.idDocument,
                        nomDoc: opCree.delegationDoc.nomDocument,
                        urlDoc: opCree.delegationDoc.urlDocument,
                        civilite: formData.get('civiliteGerant'),
                        prenom: formData.get('prenomSignataire'),
                        nom: formData.get('nomSignataire'),
                        email: emailSign,
                        tel: telSign,
                        type: "Email",
                        commentaire: "",
                        idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                        numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                        login: "",
                        auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $("#msgLoading").text("Génération de code et envoi en cours...");
                        $("#loadingModal").modal("show");
                        console.log("Before Send");
                    },
                    success: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("success ok code");
                        console.log(response1);
                        if (response1 != null && response1 !== undefined && response1 != {}) {
                            signature = response1;
                            $('#btnSignTerminer').attr("hidden", "hidden");
                            $('#divSign7').attr("hidden", "hidden");
                            $('#divCodeSign').removeAttr("hidden");
                            $('#btnSignFinaliser').removeAttr("hidden");
                        } else {
                            $("#msgError").text(
                                "(1)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur"
                            );
                            $('#errorOperation').modal('show');
                        }
                    },
                    error: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("ko");
                        console.log(response1);
                        $("#msgError").text(
                            "(2)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur"
                        );
                        $('#errorOperation').modal('show');
                    },
                    complete: function() {},
                });
            }
        },
    });
}

function onClickValidSignature() {
    let codeSaisi = $('#codeSign').val();
    let email = $('#emailSign').val();
    let tel = $('#telSign').val();
    let type = 'Email';
    if (signature != null) {
        if (signature.code != codeSaisi) {
            $("#msgError").text("Code erroné !!!");
            $('#errorOperation').modal('show');
        } else {
            //SIGNATURE
            $.ajax({
                url: `<?= URLROOT ?>/public/json/signature.php?action=signDocument`,
                type: 'POST',
                data: {
                    idOp: opCree.idOpportunity,
                    idDoc: opCree.delegationDoc.idDocument,
                    nomDoc: opCree.delegationDoc.nomDocument,
                    urlDoc: opCree.delegationDoc.urlDocument,
                    createDate: $('#createDateSign').val(),
                    civilite: $('#civiliteSign').val(),
                    prenom: $('#prenomSign').val(),
                    nom: $('#nomSign').val(),
                    idContact: $('#idContactSign').val(),
                    numeroContact: $('#numeroContactSign').val(),
                    email: email,
                    tel: tel,
                    type: type,
                    commentaire: "",
                    idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                    numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                    login: "",
                    auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`,
                    signature: signature
                },
                dataType: "JSON",
                beforeSend: function() {
                    $("#msgLoading").text("Signature en cours...");
                    $("#loadingModal").modal("show");
                },
                success: function(response) {
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    if (response != null && response != "" && response == "1") {
                        $("#msgSuccess").text("Délégation de gestion signée avec succés !");
                        $('#successOperation').modal('show');
                        closeActivity("Faire signer la délégation de gestion", 1);
                    } else {
                        $("#msgError").text(
                            "(1)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !"
                        );
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(response) {
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    $("#msgError").text(
                        "(2)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !"
                    );
                    $('#errorOperation').modal('show');
                },
                complete: function() {},
            });
        }
    } else {
        $("#msgError").text(
            "(3)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
        $('#errorOperation').modal('show');
    }
}

// =====================
// GESTION COMPAGNIE
// =====================
function onClickDeclareSinistre(params) {
    if (params == "oui") {
        $('#divNumSinistre').removeAttr("hidden");
    } else {
        $('#divNumSinistre').attr("hidden", "hidden");
    }
}

function AddOrEditCie() {
    let checkCie = $('.oneselectionCie:checkbox:checked').val().split(';')[0];
    console.log(checkCie)
    $.ajax({
        url: `<?= URLROOT ?>/public/json/company.php?action=find&id=${checkCie}`,
        type: 'GET',
        dataType: "JSON",
        success: function(response) {
            $('#idCie').attr("value", response.idCompany);
            $('#numeroCie').attr("value", response.numeroCompany);
            $('#nomCie').attr("value", response.name);
            $('#adresseCie').attr("value", response.businessLine1);
            $('#villeCie').attr("value", response.businessCity);
            $('#codePostalCie').attr("value", response.businessPostalCode);
            $('#telCie').attr("value", response.businessPhone);
            $('#emailCie').attr("value", response.email);
            $("#selectCompany").modal("hide");
            $("#btnAddCie").attr("onclick", "showModalCie('edit')");
            $("#iconeAddCie").attr("class", "fas fa-edit");
            $('#divInfosCie').removeAttr("hidden");
            $('#divInfosPasCie').attr("hidden", "hidden");
            $('#selectCompany').modal('hide');
        },
        error: function(response) {
            $('#selectCompany').modal('hide');
            $("#msgError").text("Erreur de choisir une compagnie");
            $('#errorOperation').modal('show');
        },
        complete: function() {},
    });
}

function showModalCie(action) {
    if (action == "edit") {
        $("#action").attr("value", "edit");
    } else {
        $("#action").attr("value", "add");
    }
    $("#selectCompany").modal("show");
}

function onChangeDateDebutContrat() {
    let deb = $('#dateDebutContrat').val();
    let date = new Date(deb);
    $('#dateFinContrat').attr("value", (date.getFullYear() + 1) + "-" + String(date.getMonth() + 1).padStart(2,
        '0') + "-" + String(date.getDate()).padStart(2, '0'));
}

// =====================
// ASSISTANT RV
// =====================
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
                }
            }
        }
    }

    if (verif) {
        console.log(numPageRV)
        let siMemeRV = $('.siMemeRV:checked').val();
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

function changeValueAdr() {
    $('#etage').attr("value", $('#etage2').val());
    $('#porte').attr("value", $('#porte2').val());
    $('#lot').attr("value", $('#lot2').val());
    $('#batiment').attr("value", $('#batiment2').val());
    $('#libellePartieCommune').attr("value", $('#libellePartieCommune2').val());
    $('#cote').attr("value", $('#cote2').val());
}
</script>
