<?php
/**
 * Gestion des dommages et types de sinistres B2C
 */
?>
<script>
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
                                dommages = ["Porte/fenêtre fracturée", "Serrure endommagée ou forcée",
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
</script>
