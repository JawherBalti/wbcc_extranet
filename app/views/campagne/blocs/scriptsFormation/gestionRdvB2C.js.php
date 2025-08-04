<?php
/**
 * Gestion RDV spécifique B2C
 * Fonctions pour la prise de rendez-vous en contexte B2C
 */
?>
<script>
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

function onClickSiDsiponible(val) {
    if (val == "rdv") {
        if (hidePlaceRdv1) {
            dateRDV = "";
            document.getElementById('div-prise-rdv-bis').innerHTML = '';
            document.getElementById("div-prise-rdv").innerHTML = htmlRDV1();
            getDisponiblites();

            $("#div-prise-rdv").removeAttr("hidden");
            $("#divChargementDisponibilite").removeAttr("hidden");
            hidePlaceRdv1 = false;
            hidePlaceRdvbis = true;
        }
    } else {
        $("#div-prise-rdv").attr("hidden", "hidden");
        $("#divChargementDisponibilite").attr("hidden", "hidden");
        hidePlaceRdv1 = true;
        document.getElementById("div-prise-rdv").innerHTML = '';
    }
}

function onClickTypeRencontre(val) {
    if (val == "physique" || val == "Visioconférence") {
        $("#bloc-prise-rdv2-bis").removeAttr("hidden");
        if (val == "Visioconférence") {
            $("#imputLienVisioconference").removeAttr("hidden");
        } else {
            $("#imputLienVisioconference").attr("hidden", "hidden");
        }

        if (hidePlaceRdv2bis) {
            dateRDV = "";
            $("#sous-menu-recap").attr("hidden", "hidden");
            document.getElementById("div-prise-rdv2").innerHTML = "";
            const myHTML = htmlRDV2();
            document.getElementById("div-prise-rdv2-bis").innerHTML = myHTML;
            getDisponiblites2();
            $("#divChargementDisponibilite2").removeAttr("hidden");
            hidePlaceRdv2bis = false;
            hidePlaceRdv2 = true;
        }

    } else {
        $("#bloc-prise-rdv2-bis").attr("hidden", "hidden");
        $("#sous-menu-recap").attr("hidden", "hidden");
        $("#imputLienVisioconference").attr("hidden", "hidden");
        $("#divChargementDisponibilite2").attr("hidden", "hidden");
        hidePlaceRdv2bis = true;
        document.getElementById("div-prise-rdv2-bis").innerHTML = '';
    }
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
</script>
