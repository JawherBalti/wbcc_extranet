<?php if (!defined('URLROOT')) exit('Direct access denied.'); ?>
<script>
// RDV-related functions for B2C
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
                                <div class="col-md-2" style="background-color: #d3ff78;">

                                </div>
                                <div class="col-md-10">
                                    <span>Même Date & Même Heure</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: lightblue;">

                                </div>
                                <div class="col-md-10">
                                    <span>Même Date mais Heure différente</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: #ffc020;">

                                </div>
                                <div class="col-md-10">
                                    <span>Date différente</span>
                                </div>
                            </div>
                            <div class="col-md-3 row">
                                <div class="col-md-2" style="background-color: #FF4C4C;">

                                </div>
                                <div class="col-md-10">
                                    <span>Expert Sans RDV</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div id="divTabDisponibilite">

                    </div>
                    <div>
                        <div class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                            <div class="pull-left page-item col-md-6 p-0 m-0">
                                <div id="btnPrecedentRDV">
                                    <a type="button" class="text-center btn"
                                        style="background-color: grey;color:white"
                                        onclick="onClickPrecedentRDV()">Dispos Prec. << </a>
                                </div>
                            </div>
                            <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0"><a
                                    type="button" class="text-center btn"
                                    style="background-color: grey;color:white"
                                    onclick="onClickSuivantRDV()">>>
                                    Dispos Suiv.</a></div>
                        </div>
                    </div>
                    <div id="divTabHoraire">


                    </div>
                    <div class="mt-5 text-center">
                        <h4 class="text-center font-weight-bold" id="INFO_RDV"></h4>
                    </div>
                </div>`;
    return htmlRDV;
}

function htmlRDV2() {
    const htmlRDV = `<hr>
                        <div class="col-md-12" id="divChargementDisponibilite2" hidden>
                            <div class="font-weight-bold text-center text-success">
                                <span class="text-center">Chargement des disponibilités en cours...</span>
                            </div>
                        </div>
                        <div class="col-md-12" id="divChargementNotDisponibilite2" hidden>
                            <div class="col-md-12 text-center">
                                <div class="font-weight-bold text-center text-danger">
                                    <span class="text-center">Impossible de charger l'agenda, merci de réessayer en
                                        cliquant sur ce bouton (Si cela persiste, contactez l'administrateur)</span>

                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="pull-right page-item col-md-6 p-0 m-0"><a type="button"
                                        class="text-center btn btn-success" onclick="onClickPrendreRvRT2()">
                                        Charger Agenda</a></div>
                            </div>
                        </div>
                        <div class="col-md-12" id="divPriseRvRT-2" hidden>
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
                                        <div class="col-md-2" style="background-color: #d3ff78;">

                                        </div>
                                        <div class="col-md-10">
                                            <span>Même Date & Même Heure</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 row">
                                        <div class="col-md-2" style="background-color: lightblue;">

                                        </div>
                                        <div class="col-md-10">
                                            <span>Même Date mais Heure différente</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 row">
                                        <div class="col-md-2" style="background-color: #ffc020;">

                                        </div>
                                        <div class="col-md-10">
                                            <span>Date différente</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 row">
                                        <div class="col-md-2" style="background-color: #FF4C4C;">

                                        </div>
                                        <div class="col-md-10">
                                            <span>Expert Sans RDV</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="divTabDisponibilite2">

                            </div>
                            <div>
                                <div class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                    <div class="pull-left page-item col-md-6 p-0 m-0">
                                        <div id="btnPrecedentRDV2">
                                            <a type="button" class="text-center btn"
                                                style="background-color: grey;color:white"
                                                onclick="onClickPrecedentRDV2()">Dispos Prec. << </a>
                                        </div>
                                    </div>
                                    <div id="btnSuivantRDV2" class="pull-right page-item col-md-6 p-0 m-0"><a
                                            type="button" class="text-center btn"
                                            style="background-color: grey;color:white"
                                            onclick="onClickSuivantRDV2()">>>
                                            Dispos Suiv.</a></div>
                                </div>
                            </div>
                            <div id="divTabHoraire2">


                            </div>
                            <div class="mt-5 text-center">
                                <h4 class="text-center font-weight-bold" id="INFO_RDV2"></h4>
                            </div>
                        </div>`;
    return htmlRDV;
}

function onClickSiDisponiblePoint(val) {
    if (val == "oui") {
        $("#div-prise-rdv-bis").attr("hidden", "hidden");
        $("#divChargementDisponibilite").attr("hidden", "hidden");
        hidePlaceRdvbis = true;
        document.getElementById("div-prise-rdv-bis").innerHTML = '';
    } else {
        if (hidePlaceRdvbis) {
            dateRDV = "";
            document.getElementById('div-prise-rdv').innerHTML = '';
            document.getElementById("div-prise-rdv-bis").innerHTML = htmlRDV1();
            getDisponiblites();

            $("#div-prise-rdv-bis").removeAttr("hidden");
            $("#divChargementDisponibilite").removeAttr("hidden");
            hidePlaceRdvbis = false;
            hidePlaceRdv1 = true;
        }
    }
}

function onClickSiRDVMefianceInconnu(val) {
    if (val == "oui") {
        if (hidePlaceRdv2) {
            dateRDV = "";
            document.getElementById('div-prise-rdv2-bis').innerHTML = '';
            document.getElementById("div-prise-rdv2").innerHTML = htmlRDV2();
            getDisponiblites2();

            $("#div-prise-rdv2").removeAttr("hidden");
            $("#divChargementDisponibilite2").removeAttr("hidden");
            hidePlaceRdv2 = false;
            hidePlaceRdv2bis = true;
        }
    } else {
        $("#div-prise-rdv2").attr("hidden", "hidden");
        $("#divChargementDisponibilite2").attr("hidden", "hidden");
        hidePlaceRdv2 = true;
        document.getElementById("div-prise-rdv2").innerHTML = '';
    }
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

function changeValueAdr() {
    $('#etage').attr("value", $('#etage2').val());
    $('#porte').attr("value", $('#porte2').val());
    $('#lot').attr("value", $('#lot2').val());
    $('#batiment').attr("value", $('#batiment2').val());
    $('#libellePartieCommune').attr("value", $('#libellePartieCommune2').val());
    $('#cote').attr("value", $('#cote2').val());
}
</script>
