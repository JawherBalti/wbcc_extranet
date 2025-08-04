<?php
/**
 * Script pour les interactions avec les formulaires et objections
 * Gère les réponses aux questions, objections et sous-questions
 */
?>
<script>
// Gestion des responsables
function onClickResponsable(val) {
    if (val == "oui") {
        $("#sous-question-0").attr("hidden", "hidden");
    } else {
        $("#sous-question-0").removeAttr("hidden");
    }
}

// Gestion existence partenaire
function onClickSiExistePartenaire(val) {
    if (val == "oui") {
        $("#sous-question-5").attr("hidden", "hidden");
    } else {
        $("#sous-question-5").removeAttr("hidden");
    }
}

// Gestion recommandation CB
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

// Gestion objections recommandation CB
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

// Gestion personne décisionnaire
function onClickSiPersonneDecisionnaire(val) {
    if (val == "non") {
        $("#sous-question-8").removeAttr("hidden");
    } else {
        $("#sous-question-8").attr("hidden", "hidden");
    }
}

// Gestion du choix de signature PT
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
                }
            }
        }
    }
}

// Gestion des causes
function onClickCause(val, etat) {
    if (val.value == "Autre") {
        if (val.checked) {
            $(`#divAutreCause`).removeAttr('hidden');
        } else {
            $(`#divAutreCause`).attr('hidden', '');
        }
    }
}

// Fonction autre typologie
function functionAutreTypologie(isChecked) {
    if (isChecked) {
        $(`#autreTypologie`).removeAttr('hidden');
    } else {
        $(`#autreTypologie`).attr('hidden', '');
    }
}

// Fonction activité
function functionActivite(value) {
    if (value == "Autres") {
        $(`#autreActivite`).removeAttr('hidden');
    } else {
        $(`#autreActivite`).attr('hidden', '');
    }
}

// Fonction responsable
function ClickResponsable(val) {
    console.log(val);
}

// Gestion changement date TE
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
</script>
