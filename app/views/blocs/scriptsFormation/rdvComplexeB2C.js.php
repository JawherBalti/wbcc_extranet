<?php
/**
 * Fonctions complexes de gestion RDV et calendrier B2C
 */
?>
<script>
// =====================
// GESTION RDV COMPLEXE
// =====================

function onClickPrendreRvRT(params) {
    let email = $('#emailContact').val();
    let adresse = $('#adresseImm').val();
    let idContact = $('#idContact').val();
    getDisponiblites();
}

function getDisponiblites() {
    let post = {
        codePostal: "",
        adresseRV: "",
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        idUser: <?= $idAuteur ?>,
        nomUserRV: "<?= $auteur ?>",
        organisateurs: []
    }
    $.ajax({
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=wbcc&origine=web&forcage=1`,
        type: 'POST',
        data: (post),
        dataType: "JSON",
        beforeSend: function() {
            $('#divChargementNotDisponibilite').attr("hidden", "hidden");
            $('#divChargementDisponibilite').removeAttr("hidden");
        },
        success: function(result) {
            console.log(result);
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            console.log('result dispos');
            console.log(result);
            $('#btnRvRT').attr("hidden", "hidden");
            if (result !== null && result != undefined) {
                if (result.length == 0) {
                    $('#notDisponibilite').removeAttr("hidden");
                } else {
                    tab = result;
                    taille = tab.length;
                    nbPageTotal = Math.ceil(tab.length / 10);
                    nbPage++;
                    afficheBy10InTable();
                    $('#divPriseRvRT-1').removeAttr("hidden");
                    if (nbPage == 1) {
                        $('#btnPrecedentRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnPrecedentRDV').removeAttr("hidden");
                    }
                    if (nbPage == nbPageTotal) {
                        $('#btnSuivantRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnSuivantRDV').removeAttr("hidden");
                    }
                }
            } else {
                $('#divChargementDisponibilite').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite').removeAttr("hidden");
            }
        },
        error: function(response) {
            $('#btnRvRT').removeAttr("hidden");
            $('#divPriseRvRT-1').attr("hidden", "hidden");
            $('#divPriseRvRT').attr("hidden", "hidden");
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 1000);
            console.log("Erreur")
            console.log(response)
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            $('#divChargementNotDisponibilite').removeAttr("hidden");
        }
    });
}

function getDisponiblites2() {
    let post = {
        adresseRV: $('#adresseImm').val(),
        codePostal: $('#cP').val(),
        ville: $('#ville').val(),
        batiment: "",
        etage: "",
        libelleRV: "",
        idUser: <?= $idAuteur ?>,
        nomUserRV: "<?= $auteur ?>",
        organisateurs: [{
            "id": 3,
            "nom": "Ben PADONOU"
        }, {
            "id": 162,
            "nom": "Narcisse DJOSSINOU"
        }]
    }
    $.ajax({
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=cb&origine=web&forcage=0`,
        type: 'POST',
        data: (post),
        dataType: "JSON",
        beforeSend: function() {
            $('#divChargementNotDisponibilite2').attr("hidden", "hidden");
            $('#divChargementDisponibilite2').removeAttr("hidden");
        },
        success: function(result) {
            console.log(result);
            $('#divChargementDisponibilite2').attr("hidden", "hidden");
            console.log('result dispos');
            console.log(result);
            $('#btnRvRT').attr("hidden", "hidden");
            if (result !== null && result != undefined) {
                if (result.length == 0) {
                    $('#notDisponibilite').removeAttr("hidden");
                } else {
                    tab = result;
                    taille = tab.length;
                    nbPageTotal = Math.ceil(tab.length / 10);
                    nbPage++;
                    afficheBy10InTable2();
                    $('#divPriseRvRT-2').removeAttr("hidden");
                    if (nbPage == 1) {
                        $('#btnPrecedentRDV2').attr("hidden", "hidden");
                    } else {
                        $('#btnPrecedentRDV2').removeAttr("hidden");
                    }
                    if (nbPage == nbPageTotal) {
                        $('#btnSuivantRDV2').attr("hidden", "hidden");
                    } else {
                        $('#btnSuivantRDV2').removeAttr("hidden");
                    }
                }
            } else {
                $('#divChargementDisponibilite2').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite2').removeAttr("hidden");
            }
        },
        error: function(response) {
            $('#btnRvRT').removeAttr("hidden");
            $('#divPriseRvRT-2').attr("hidden", "hidden");
            $('#divPriseRvRT').attr("hidden", "hidden");
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 1000);
            console.log("Erreur")
            console.log(response)
            $('#divChargementDisponibilite2').attr("hidden", "hidden");
            $('#divChargementNotDisponibilite2').removeAttr("hidden");
        }
    });
}

function onClickPrendreRvRT2(params) {
    let email = $('#emailContact').val();
    let adresse = $('#adresseImm').val();
    let idContact = $('#idContact').val();
    getDisponiblites2();
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
                }, 500)
                $("#msgError").text(
                    "(2)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                $("#loadingModal").modal("hide");
            },
        });
    } else {
        setTimeout(() => {
            $("#loadingModal").modal("hide");
        }, 500)
        $("#msgError").text("Veuillez remplir tous les champs !");
        $('#errorOperation').modal('show');
    }
}

function onClickSuivantRDV() {
    if (nbPage >= nbPageTotal) {
        alert("Plus de disponibiltés! veuillez forcer");
    } else {
        nbPage++;
        afficheBy10InTable();
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function onClickSuivantRDV2() {
    if (nbPage >= nbPageTotal) {
        alert("Plus de disponibiltés! veuillez forcer");
    } else {
        nbPage++;
        afficheBy10InTable2();
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV2').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV2').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV2').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV2').removeAttr("hidden");
    }
}

function onClickPrecedentRDV() {
    if (nbPage != 1) {
        iColor = ((nbPage - 1) * 2) - 2;
        nbPage--;
        k = k - nbDispo - 10;
        afficheBy10InTable();
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function onClickPrecedentRDV2() {
    if (nbPage != 1) {
        iColor = ((nbPage - 1) * 2) - 2;
        nbPage--;
        k = k - nbDispo - 10;
        afficheBy10InTable2();
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV2').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV2').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV2').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV2').removeAttr("hidden");
    }
}

function afficheBy10InTable() {
    var test = 0;
    var kD = k;
    first = k;
    $('#divTabDisponibilite').empty();
    var html =
        `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html +=
                    `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5)
                        iColor++;
                    break;
                }
            }

            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2)
                    iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $('#divTabDisponibilite').append(html);
    nbDispo = k - kD;

    //recuperer la valeur d4une cellule
    $(".tdClass").click(function() {
        $("#INFO_RDV").text("");
        $('#divPriseRvRT').attr("hidden", "hidden");
        $('#expertRV').attr("value", "");
        $('#idExpertRV').attr("value", "0");
        $('#dateRV').attr("value", "");
        $('#heureRV').attr("value", "");
        $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
        $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
        var item = $(this).closest("td").html();
        let nomCommercial = item.split("<br>")[0];
        let DATE_RV = item.split("<br>")[1];
        let HEURE_D = item.split("<br>")[2].split("-")[0];
        let HEURE_F = item.split("<br>")[2].split("-")[1];
        idCommercialRDV = item.split("<br>")[3].split("-")[1];
        let marge = item.split("<br>")[3].split("-")[2];
        let DUREE = item.split("<br>")[3].split("-")[3];
        //Nouveau tableau
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
        //TEST IF FIN + MARGE
        secondHF = (heure * 3600 + min * 60 + ((marge == "" || marge == null) ? 0 : marge * 60)) * 1000;
        horaires = [];
        for (var i = secondHD; i < secondHF - 6000; i = i + 1800000) {
            j = i + 1800000;
            time1 = msToTime(i);
            time2 = msToTime(j);
            if (j <= secondHF) {
                horaires.push(time1 + "-" + time2);
            }
        }
        nTaille = horaires.length;

        afficheNewTable(nomCommercial, DATE_RV, DUREE);
    });
}

function afficheNewTable(nomCommercial, date, duree) {
    $('#divTabHoraire').empty();
    var html =
        `<div class="font-weight-bold">
                                    <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                                </div>
            <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
    html += `<tr class="ntr" style="background-color: lightgray">`;
    for (var i = 0; i < nTaille; i++) {
        html += `<td class="ntdClass"  align="center" id="cel${i}" value="${i}"> ${horaires[i]} </td>`;
    }
    html += `</tr>`;
    html += `</table>`;
    $('#divTabHoraire').append(html);

    $(".ntdClass").click(function() {
        $(".ntr > td").css("background-color", "lightgray");
        $(this).closest("td").css("background-color", "#e74a3b");
        var item = $(this).closest("td").html();
        commercialRDV = nomCommercial;
        dateRDV = date;
        heureDebutRDV = item.split("-")[0];
        heureFinRDV = item.split("-")[1];
        let DUREE = duree;
        let HEURE_RV = item;
        if (idCommercialRDV != "0") {
            $("#INFO_RDV").text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " +
                heureDebutRDV +
                " à " + heureFinRDV);
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureRV').attr("value", heureDebutRDV);
            $('#divPriseRvRT').removeAttr("hidden");
        }
    });
}

function afficheBy10InTable2() {
    var test = 0;
    var kD = k;
    first = k;
    $('#divTabDisponibilite2').empty();
    var html =
        `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html +=
                    `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5)
                        iColor++;
                    break;
                }
            }

            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2)
                    iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $('#divTabDisponibilite2').append(html);
    nbDispo = k - kD;
    //recuperer la valeur d4une cellule
    $(".tdClass").click(function() {
        $("#INFO_RDV").text("");
        $('#divPriseRvRT').attr("hidden", "hidden");
        $('#expertRV').attr("value", "");
        $('#idExpertRV').attr("value", "0");
        $('#dateRV').attr("value", "");
        $('#heureRV').attr("value", "");
        $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
        $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
        var item = $(this).closest("td").html();
        let nomCommercial = item.split("<br>")[0];
        let DATE_RV = item.split("<br>")[1];
        let HEURE_D = item.split("<br>")[2].split("-")[0];
        let HEURE_F = item.split("<br>")[2].split("-")[1];
        idCommercialRDV = item.split("<br>")[3].split("-")[1];
        let marge = item.split("<br>")[3].split("-")[2];
        let DUREE = item.split("<br>")[3].split("-")[3];
        //Nouveau tableau
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
        //TEST IF FIN + MARGE
        secondHF = (heure * 3600 + min * 60 + ((marge == "" || marge == null) ? 0 : marge * 60)) * 1000;
        horaires = [];
        for (var i = secondHD; i < secondHF - 6000; i = i + 1800000) {
            j = i + 1800000;
            time1 = msToTime(i);
            time2 = msToTime(j);
            if (j <= secondHF) {
                horaires.push(time1 + "-" + time2);
            }
        }
        nTaille = horaires.length;

        afficheNewTable2(nomCommercial, DATE_RV, DUREE);
    });
}

function afficheNewTable2(nomCommercial, date, duree) {
    $('#divTabHoraire2').empty();
    var html =
        `<div class="font-weight-bold">
                                    <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                                </div>
            <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
    html += `<tr class="ntr" style="background-color: lightgray">`;
    for (var i = 0; i < nTaille; i++) {
        html += `<td class="ntdClass"  align="center" id="cel${i}" value="${i}"> ${horaires[i]} </td>`;
    }
    html += `</tr>`;
    html += `</table>`;
    $('#divTabHoraire2').append(html);

    $(".ntdClass").click(function() {
        $(".ntr > td").css("background-color", "lightgray");
        $(this).closest("td").css("background-color", "#e74a3b");
        var item = $(this).closest("td").html();
        commercialRDV = nomCommercial;
        dateRDV = date;
        heureDebutRDV = item.split("-")[0];
        heureFinRDV = item.split("-")[1];
        let DUREE = duree;
        let HEURE_RV = item;
        if (idCommercialRDV != "0") {
            $("#INFO_RDV2").text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " +
                heureDebutRDV +
                " à " + heureFinRDV);
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureRV').attr("value", heureDebutRDV);
            $('#divPriseRvRT-2').removeAttr("hidden");

            if (currentStep == 22) {
                const typeRencontre = document.querySelector('input[name="typeRencontre"]:checked');
                let typeRencontretext = "";
                if (!typeRencontre) {

                } else if (typeRencontre.value == "physique") {
                    typeRencontretext = "physique";
                } else if (typeRencontre.value == "Visioconférence") {
                    typeRencontretext = "visioconférence";
                }

                const maVar = document.getElementById('place-rdv');
                maVar.innerHTML = ` ${typeRencontretext} le ${dateRDV} de ${heureDebutRDV} à ${heureFinRDV}.`;
                $("#sous-menu-recap").removeAttr("hidden");
            }
        }
    });
}
</script>
