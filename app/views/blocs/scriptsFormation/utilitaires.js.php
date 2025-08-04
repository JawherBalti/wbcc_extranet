<script>
// =====================
// UTILITAIRES ET GESTIONNAIRES D'EVENEMENTS
// =====================

const refs = document.querySelectorAll('[ref]');

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

function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

function onClickResponsable(val) {
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

function ClickResponsable(val) {
    console.log(val);
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

function onClickDeclareSinistre(params) {
    if (params == "oui") {
        $('#divNumSinistre').removeAttr("hidden");
    } else {
        $('#divNumSinistre').attr("hidden", "hidden");
    }
}

//onChangeTypeSin();
function onChangeTypeSin() {
    let id = "";
    const typeSinistre = document.getElementById('typeSinistre');
    let dommages = [];
    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts ?");
    if (typeSinistre.value == "autre") {
        dommages = [];
    } else {
        if (typeSinistre.value == "degatEaux") {
            $(`#textDommages`).text('Pouvez-vous me décrire les dommages liés aux dégats des eaux ?');
            dommages = ["Auréoles/taches visibles sur plafonds ou murs",
                "Cloques ou décollements de peinture ou de papier peint", "Parquet/plancher gondolé ou déformé",
                "Moquettes ou tapis détériorés ou tachés", "Mobilier gonflé, taché ou déformé",
                "Plinthes ou boiseries abîmées ou décollées",
                "Carrelage descellé ou joints abîmés",
                "Apparition de moisissures/champignons sur surfaces visibles",
                "Lambris ou revêtements décoratifs détériorés"
            ];
        } else {
            if (typeSinistre.value == "incendie") {
                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par l'incendie ?");
                dommages = ["Traces de fumée ou suie sur murs/plafonds",
                    "Mobilier partiellement brûlé nécessitant restauration",
                    "Sol (parquet, carrelage, moquette) brûlé ou taché",
                    "Portes/fenêtres déformées nécessitant remplacement",
                    "Revêtements muraux brûlés ou fortement salis",
                    "Façade extérieure noircie nécessitant nettoyage/peinture",
                    "Odeurs persistantes nécessitant traitement spécifique",
                    "Isolation intérieure détruite ou à remplacer", "Faux plafonds brûlés ou noircis à remplacer",
                    "Éléments décoratifs (rideaux, stores) endommagés"
                ];
            } else {
                if (typeSinistre.value == "brisGlace") {
                    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le bris de glace ?");
                    dommages = ["Vitrine commerciale endommagée", "Fenêtre ou baie vitrée endommagée",
                        "Porte vitrée brisée", "Miroir décoratif cassé",
                        "Verrière fissurée", "Cabine de douche brisée", "Mobilier vitré cassé",
                        "Étagère en verre cassée", "Plateau/table en verre fracturé",
                        "Garde-corps ou clôture en verre brisé"
                    ];
                } else {
                    if (typeSinistre.value == "vandalisme") {
                        $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vandalisme ?");
                        dommages = ["Murs ou vitrines tagués", "Dégradations portes/fenêtres",
                            "Dégradations mobilier urbain", "Dégradations équipements décoratifs",
                            "Enseigne commerciale taguée ou rayée", "Câbles coupés/endommagés",
                            "Sanitaires dégradés",
                            "Caméra surveillance détruite", "Clôtures/portails endommagés",
                            "Rideau métallique abîmé"
                        ];
                    } else {
                        if (typeSinistre.value == "evenementClimatique") {
                            $(`#textDommages`).text(
                                "Pouvez-vous me décrire les dégâts causés par l'événment climatique ?");
                            dommages = [];
                        } else {
                            if (typeSinistre.value == "vol") {
                                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vol ?");
                                $dommages = ["Porte/fenêtre fracturée", "Serrure endommagée ou forcée",
                                    "Mobilier ou éléments décoratifs détériorés",
                                    "Systèmes de sécurité/alarme dégradés", "Coffre-fort endommagé",
                                    "Vitrine fracturée", "Volets ou rideaux endommagés",
                                    "Documents sensibles endommagés"
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    dommages.push("Autre");
    let html = "";
    const dommagesCoches =
        '<?= $questScript ? $questScript->dommages : '' ?>' // <- récupéré depuis PHP ou du formulaire
    const domArray = dommagesCoches.split(";");

    dommages.forEach(element => {
        let isFuiteChecked = domArray.includes(element);
        html += `<div class="col-md-6 col-sm-6 text-left">
                                                    <input onclick='onClickDommage(this)' ${isFuiteChecked ? 'checked' : ''} type="checkbox" value="${element}"
                                                        name="dommages[]" class="dommages" >
                                                    <label> ${element}</label>
                                                </div>`;
    });
    document.getElementById("option-content").innerHTML = html;
}

function onClickDommage(checkbox) {
    const valeur = checkbox.value;
    const estCoche = checkbox.checked;

    if (valeur == "Autre") {
        if (estCoche) {
            $(`#divAutreDommage`).removeAttr('hidden');
        } else {
            $(`#divAutreDommage`).attr('hidden', '');
        }
    }
}

function showSousQuestion(idSS, $show) {
    if ($show) {
        $(`#sous-question-${idSS}`).removeAttr('hidden');
    } else {
        $(`#sous-question-${idSS}`).attr('hidden', '');
    }
}

function finish() {
    saveScriptPartiel('fin');
}
</script>
