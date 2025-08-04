<?php if (!defined('URLROOT')) exit('Direct access denied.'); ?>
<script>
// Event handlers and form interaction functions for B2C
function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

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

function onClickChoixSignaturePT() {
    const rep = document.querySelector('input[name="raisonRefusSignature"]:checked');
    $(`#divPriseRdvPerso`).removeAttr('hidden');
    if (rep.value == "prefereDemander") {
        $(`#textPropositionHesitationSignature`).text(
            "Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. <br>Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, une fois votre échange réalisé."
        );
    } else {
        if (rep.value == "documentManquant") {
            $(`#textPropositionHesitationSignature`).text(
                "Oui effectivement, je note bien que certains documents vous manquent, c'est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. <br>Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
            );
        } else {
            if (rep.value == "signatureComplique") {
                $(`#textPropositionHesitationSignature`).text(
                    "Je comprends parfaitement. Soyez rassuré(e), c'est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                );
            } else {
                if (rep.value == "prendreConnaissance") {
                    $(`#textPropositionHesitationSignature`).text(
                        "Parfait, je vous remercie. Le rendez-vous téléphonique est confirmé. Je vous adresse dès maintenant notre documentation complète ainsi que la délégation de gestion par mail afin que vous puissiez en prendre connaissance avant notre échange.<b>Merci beaucoup pour votre aide et excellente journée !"
                    );
                } else {

                }
            }
        }
    }
}

function onClickCause(val, etat) {
    if (val.value == "Autre") {
        if (val.checked) {
            $(`#divAutreCause`).removeAttr('hidden');
        } else {
            $(`#divAutreCause`).attr('hidden', '');
        }
    }
}

function functionAutreTypologie(isChecked) {
    if (isChecked) {
        $(`#autreTypologie`).removeAttr('hidden');
    } else {
        $(`#autreTypologie`).attr('hidden', '');
    }
}

function functionActivite(value) {
    if (value == "Autres") {
        $(`#autreActivite`).removeAttr('hidden');
    } else {
        $(`#autreActivite`).attr('hidden', '');
    }
}

function changeDateTE() {
    if (document.getElementById('dateInconnu').checked) {
        $("#infosCom").removeAttr("hidden");
        $('#blockdateS').attr("hidden", "hidden");
        $("#dateS").val("");
        $("#timeS").val("");
    } else {
        $("#infosCom").attr("hidden", "hidden");
        $('#blockdateS').removeAttr("hidden");
        $("#dateConstat").val("");
        $("#anneeSurvenance").val("");
        $("#comDateInconnu").val("");
    }
}

function ClickResponsable(val) {
    console.log(val);
}

// Gestion des références et inputs synchronisés
$(document).ready(function() {
    refs.forEach(ref => {
        ref.addEventListener('input', (e) => {
            //update all other ref value
            refs.forEach(r => {
                if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                    r.value = ref.value;
                }
            });
        });
    });
});
</script>
