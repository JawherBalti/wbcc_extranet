<script>
// Fonctions spécifiques à l'interface B2C

function onClickProspectB2C(val) {
    if (val == "oui") {
        $("#sous-question-0").attr("hidden", "hidden");
    } else {
        $("#sous-question-0").removeAttr("hidden");
    }
}

function onClickSiExistePartenaire(val) {
    if (val == "oui") {
        $("#sous-question-5").attr("hidden", "hidden");
    } else {
        $("#sous-question-5").removeAttr("hidden");
    }
}

function onClickSiRecommenderCb(val) {
    if (val == "oui") {
        $("#sous-question-7").removeAttr("hidden");
        $("#div-objections").attr("hidden", "hidden");

        $("#objection-1").attr("hidden", "hidden");
        $("#objection-2").attr("hidden", "hidden");
        $("#objection-3").attr("hidden", "hidden");
    } else if (val == "non") {
        $("#sous-question-7").attr("hidden", "hidden");
        $("#div-objections").attr("hidden", "hidden");

        $("#objection-1").attr("hidden", "hidden");
        $("#objection-2").attr("hidden", "hidden");
        $("#objection-3").attr("hidden", "hidden");
    } else if (val == "objection") {
        $("#sous-question-7").attr("hidden", "hidden");
        $("#div-objections").removeAttr("hidden");

        const valObjection = document.querySelector('input[name="objectionRecommanderCb"]:checked');
        if (valObjection) {
            if (valObjection.value == "Quel avantage concret pour nous ?") {
                $("#objection-1").removeAttr("hidden");
                $("#objection-2").attr("hidden", "hidden");
                $("#objection-3").attr("hidden", "hidden");
            } else if (valObjection.value == "Nous n'avons pas le temps de nous en occuper.") {
                $("#objection-2").removeAttr("hidden");
                $("#objection-1").attr("hidden", "hidden");
                $("#objection-3").attr("hidden", "hidden");
            } else if (valObjection.value == "Méfiance ou inconnu.") {
                $("#objection-3").removeAttr("hidden");
                $("#objection-1").attr("hidden", "hidden");
                $("#objection-2").attr("hidden", "hidden");
            }
        }
    }
}

function onClickObjectionRecommanderCb(val) {
    if (val == 1) {
        $("#objection-1").removeAttr("hidden");
        $("#objection-2").attr("hidden", "hidden");
        $("#objection-3").attr("hidden", "hidden");
    } else if (val == 2) {
        $("#objection-2").removeAttr("hidden");
        $("#objection-1").attr("hidden", "hidden");
        $("#objection-3").attr("hidden", "hidden");
    } else if (val == 3) {
        $("#objection-3").removeAttr("hidden");
        $("#objection-1").attr("hidden", "hidden");
        $("#objection-2").attr("hidden", "hidden");
    }
}

function onClickSiPersonneDecisionnaire(val) {
    if (val == "non") {
        $("#sous-question-8").removeAttr("hidden");
    } else {
        $("#sous-question-8").attr("hidden", "hidden");
    }
}

function onclickStautProspect(val) {
    const Proprietaire = document.getElementById('Proprietaire');
    const Locataire = document.getElementById('Locataire');
    const Autre = document.getElementById('Autre');

    if(Proprietaire.checked == true){
        $("#div-si-proprietaire").removeAttr("hidden");
    }
    else{
        $("#div-si-proprietaire").attr("hidden", "hidden");
    }
    
    if(Locataire.checked == true || Autre.checked == true){
        $("#div-si-locataire-autre").removeAttr("hidden");
    }
    else{
         $("#div-si-locataire-autre").attr("hidden", "hidden");
    }
}

function functionStatutProspect(isChecked) {
    if (isChecked) {
        $(`#statutProspect`).removeAttr('hidden');
    } else {
        $(`#statutProspect`).attr('hidden', '');
    }
}

function onClickSiContacBailleur(val) {
    if (val == "oui") {
        $("#div-has-contact-bailleur").removeAttr("hidden");
    } else {
        $("#div-has-contact-bailleur").attr("hidden", "hidden");
    }
}

function onClickCorrecteInfosProprietaire(val) {
    if (val == "oui") {
        $("#sous-question-6").attr("hidden", "hidden");
    } else {
        $("#sous-question-6").removeAttr("hidden");
    }
}

function selectTypebailleur(val) {
    if (val == "Propriétaire") {
        $("#div-type-bailleur-proprietaire").removeAttr("hidden");
        $("#div-type-bailleur-syndic").attr("hidden", "hidden");
    } else if(val == "Syndic") {
        $("#div-type-bailleur-syndic").removeAttr("hidden");
        $("#div-type-bailleur-proprietaire").attr("hidden", "hidden");
    }
    else{
        $("#div-type-bailleur-syndic").attr("hidden", "hidden");
        $("#div-type-bailleur-proprietaire").attr("hidden", "hidden");
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
