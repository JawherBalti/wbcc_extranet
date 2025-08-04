<script>
// Fonctions pour la gestion des disponibilités RDV (spécifique B2C)

function msToTime(s) {
    var ms = s % 1000;
    s = (s - ms) / 1000;
    var secs = s % 60;
    s = (s - secs) / 60;
    var mins = s % 60;
    var hrs = (s - mins) / 60;
    return ("0" + hrs).slice(-2) + ':' + ("0" + mins).slice(-2);
}

function afficheBy10InTable() {
    var test = 0;
    var kD = k;
    first = k;
    $('#divTabDisponibilite').empty();
    var html = `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html += `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5) iColor++;
                    break;
                }
            }
            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2) iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $('#divTabDisponibilite').append(html);
    nbDispo = k - kD;
    
    // Gestion des clics sur les cellules
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
        
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
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
    var html = `<div class="font-weight-bold">
                    <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                </div>
                <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px">
                    <tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
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
                heureDebutRDV + " à " + heureFinRDV);
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
    var html = `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html += `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5) iColor++;
                    break;
                }
            }
            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2) iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $('#divTabDisponibilite2').append(html);
    nbDispo = k - kD;
    
    // Gestion des clics sur les cellules
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
        
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
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
    var html = `<div class="font-weight-bold">
                    <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                </div>
                <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px">
                    <tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
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
                heureDebutRDV + " à " + heureFinRDV);
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureRV').attr("value", heureDebutRDV);
            $('#divPriseRvRT-2').removeAttr("hidden");

            if (currentStep == 22) {
                const typeRencontre = document.querySelector('input[name="typeRencontre"]:checked');
                let typeRencontretext = "";
                if (!typeRencontre) {
                    // Gérer le cas où aucune option n'est sélectionnée
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

function htmlRDV1() {
    const htmlRDV = `<hr>
                <div class="col-md-12" id="divChargementDisponibilite" hidden>
                    <div class="font-weight-bold text-center text-success">
                        <span class="text-center">Chargement des disponibilités en cours...</span>
                    </div>
                </div>
                <div class="col-md-12" id="divChargementNotDisponibilite" hidden>
                    <div class="col-md-12 text-center">
                        <div class="font-weight-bold text-center text-danger">
                            <span class="text-center">Impossible de charger l'agenda, merci de réessayer en
                                cliquant sur ce bouton (Si cela persiste, contactez l'administrateur)</span>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <div class="pull-right page-item col-md-6 p-0 m-0"><a type="button"
                                class="text-center btn btn-success" onclick="onClickPrendreRvRT()">
                                Charger Agenda</a></div>
                    </div>
                </div>
                <div class="col-md-12" id="divPriseRvRT-1" hidden>
                    <div class="col-md-12 text-center" hidden>
                        <div class="font-weight-bold text-center">
                            <span class="text-center">Un rendez-vous ne peut pas être pris après le
                                '<?= date('d/m/Y', strtotime('+16 day'))  ?>', proposez de rappeler l'assuré
                                dans ce cas</span>
                        </div>
                    </div>
                    <div class="row mt-2 mb-2 ml-2">
                        <div class="col-md-12 row">
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: #d3ff78;"></div>
                                <div class="col-md-10">
                                    <span>Même Date & Même Heure</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: lightblue;"></div>
                                <div class="col-md-10">
                                    <span>Même Date mais Heure différente</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: #ffc020;"></div>
                                <div class="col-md-10">
                                    <span>Date différente</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: #FF4C4C;"></div>
                                <div class="col-md-10">
                                    <span>Expert Sans RDV</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="divTabDisponibilite"></div>
                    <div>
                        <div class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                            <div class="pull-left page-item col-md-6 p-0 m-0">
                                <div id="btnPrecedentRDV">
                                    <a type="button" class="text-center btn"
                                        style="background-color: grey;color:white"
                                        onclick="onClickPrecedentRDV()">Dispos Prec. << </a>
                                </div>
                            </div>
                            <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0">
                                <a type="button" class="text-center btn"
                                    style="background-color: grey;color:white"
                                    onclick="onClickSuivantRDV()">>> Dispos Suiv.</a>
                            </div>
                        </div>
                    </div>
                    <div id="divTabHoraire"></div>
                    <div class="col-md-12 text-center">
                        <div class="pull-right page-item col-md-6 p-0 m-0">
                            <a type="button" class="text-center btn btn-success"
                                onclick="onClickPrendreRvRT()">
                                Recharger Agenda</a>
                        </div>
                    </div>
                </div>`;
    return htmlRDV;
}
</script>
