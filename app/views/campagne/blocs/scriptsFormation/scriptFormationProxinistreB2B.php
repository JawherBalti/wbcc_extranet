<?php
/**
 * Bloc JavaScript - Gestion des tooltips pour formation
 */
?>

<script>
const steps = document.querySelectorAll(".step");
const prevBtn = document.getElementById("prevBtn");

const nextBtn = document.getElementById("nextBtn");
const finishBtn = document.getElementById("finishBtn");
const indexPage = document.getElementById('indexPage');
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
const history = [];
let opCree = null;
let signature = null;
$(`#numQuestionScript0`).text(1);
let siInterlocuteur = false;
const refs = document.querySelectorAll('[ref]');


//ASSISTANT TE
let numPageTE = 0;
let nbPageTE = 4;

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
                "Oui effectivement, je note bien que certains documents vous manquent, c’est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. <br>Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
            );
        } else {
            if (rep.value == "signatureComplique") {
                $(`#textPropositionHesitationSignature`).text(
                    "Je comprends parfaitement. Soyez rassuré(e), c’est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
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

function saveInfosGerant(type) {
    let dataObject = {};
    if (type == "resp") {
        dataObject = {
            civiliteGerant: document.getElementsByName('civiliteGerant')[0].value,
            emailGerant: document.getElementsByName('emailGerant')[0].value,
            idCompanyGerant: document.getElementsByName('idCompanyGerant')[0].value,
            idGerant: document.getElementsByName('idGerant')[0].value,
            nomGerant: document.getElementsByName('nomGerant')[0].value,
            posteGerant: document.getElementsByName('posteGerant')[0].value,
            prenomGerant: document.getElementsByName('prenomGerant')[0].value,
            telGerant: document.getElementsByName('telGerant')[0].value
        };
    } else {
        dataObject = {
            civiliteGerant: document.getElementsByName('civiliteInterlocuteur')[0].value,
            emailGerant: document.getElementsByName('emailInterlocuteur')[0].value,
            idCompanyGerant: document.getElementsByName('idCompanyInterlocuteur')[0].value,
            idGerant: document.getElementsByName('idInterlocuteur')[0].value,
            nomGerant: document.getElementsByName('nomInterlocuteur')[0].value,
            posteGerant: document.getElementsByName('posteInterlocuteur')[0].value,
            prenomGerant: document.getElementsByName('prenomInterlocuteur')[0].value,
            telGerant: document.getElementsByName('telInterlocuteur')[0].value
        };
    }

    console.log("Infos contact");
    console.log(dataObject);
    if (dataObject != {}) {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveInfosContact`,
            type: 'POST',
            data: dataObject,
            dataType: "JSON",
            beforeSend: function() {
                // $("#msgLoading").text("Génération de code et envoi en cours...");
                // $("#loadingModal").modal("show");
                console.log("Before Send");

            },
            success: function(response1) {
                console.log("success ok code");
                console.log(response1);
                body
                if (response1 != null && response1 !== undefined && response1 != {}) {

                } else {
                    $("#msgError").text(
                        "(1)Erreur enregistrement, Veuillez réessayer ou contacter l'administrateur"
                    );
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response1) {
                // $("#loadingModal").modal("hide");
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

}

function sendDocumentation() {
    let emailDestinataire = $("#emailDestinataire").val()
    if (emailDestinataire == "") {
        $("#msgError").text("veuillez renseigner une adresse mail !");
        $('#errorOperation').modal('show');
    } else {
        let nomDoc = "";
        var cheminDoc = "/public/documents/campagne/" + nomDoc;
        let post = {
            to: emailDestinataire,
            subject: $('#objetMailEnvoiDoc').val(),
            bodyMessage: tinyMCE.get("bodyMailEnvoiDoc").getContent() + `
                            `,
            attachment: cheminDoc,
            attachmentName: nomDoc,
            idAuteur: `<?= $_SESSION['connectedUser']->idUtilisateur ?>`,
            auteur: `<?= $_SESSION['connectedUser']->fullName ?>`,
            numeroAuteur: `<?= $_SESSION['connectedUser']->numeroContact ?>`,
            regarding: "Envoi Documentation",
            idContact: $('#idContact').val(),
            idCompanyGroup: $('#contextId').val()
        }
        $.ajax({
            url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=envoiDocumentation`,
            type: 'POST',
            data: JSON.stringify(post),
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Envoi mail en cours...");
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);


                $("#msgSuccess").text("Envoi de documentation effectué avec succés!");
                $('#successOperation').modal('show');

                setTimeout(function() {
                    $('#successOperation').modal('hide');
                }, 1000);

                setTimeout(function() {
                    location.reload();
                }, 1500);

            },
            error: function(response) {
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);
                $("#msgError").text("Impossible d'envoyer le mail !");
                $('#errorOperation').modal('show');
            },
            complete: function() {

            },
        });
    }
}

function getInfoMail() {
    objetMail =
        `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    bodyMail = `<p style="text-align:justify">${`<?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?>`}<br><br>
                    Merci pour notre échange très agréable d'aujourd'hui.<br><br>
                    Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d’assurance, en nous occupant de tout, de A à Z.<br><br>
                    <b>En choisissant Proxinistre, vous bénéficiez notamment de</b> :<br>
                    <ul>
                        <li>Un interlocuteur unique dédié à votre dossier.</li>
                        <li>Une expertise SOS Sinistre sous 24 heures.</li>
                        <li>Un soutien administratif et juridique complet.</li>
                        <li><b>0€ de coût de gestion</b> pour vous.</li>
                        <li>La facilitation complète des démarches liées à votre sinistre.</li>
                        <li>Une assistance disponible 24h/24 et 7j/7.</li>
                        <li>Des partenaires agréés pour des réparations rapides et garanties.</li>
                    </ul>
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d’esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                     ${`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`}
                                            `;

    $('#objetMailEnvoiDoc').val(objetMail)
    $('#signatureMail').val(`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`)
    tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
    tinyMCE.get("bodyMailEnvoiDoc").getBody().setAttribute('contenteditable', false);
}

function showModalSendDoc() {

    getInfoMail();
    $('#modalEnvoiDoc').modal('show');
}

onChangeTypeSin();

function onChangeTypeSin() {
    let id = "";
    const typeSinistre = document.getElementById('typeSinistre');
    let dommages = [];
    // $(`#textConfirmPriseEnCharge`).text('Est-ce que les travaux de remise en état ont été réalisés ?');
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

function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    // nextBtn.classList.toggle("hidden", currentStep === steps.length - 1 || currentStep == 7);
    nextBtn.classList.toggle("hidden", currentStep == 17);
    // finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1 && currentStep != 7);
    finishBtn.classList.toggle("hidden", currentStep != 17);

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = pageIndex; // ou un autre texte si tu veux
    });
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;

    currentStep = index;
    steps[currentStep].classList.add("active");
    updateButtons();
}

function goBackScript() {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    updateButtons();
}


function goNext() {
    // logiques conditionnelles selon étape
    if (document.querySelector('input[name="siTravaux"]:checked') != null && document.querySelector(
            'input[name="siTravaux"]:checked').value == "oui") {
        document.getElementById('textCloture').innerHTML =
            "Merci pour ces précisions. Dans la mesure où vos travaux ont déjà été réalisés, nous ne pouvons malheureusement plus intervenir gratuitement sur votre dossier. Toutefois, souhaitez-vous recevoir notre documentation afin de conserver nos coordonnées pour toute éventuelle assistance future ?";
        $("#reponseDoc").removeAttr("hidden");
        $("#divEnvoiDoc").removeAttr("hidden");

    } else {

        $('#reponseDoc').attr("hidden", "hidden");
        $('#divEnvoiDoc').attr("hidden", "hidden");
    }
    $("#sous-question-17-2").attr("hidden", "hidden");
    $("#sous-question-17-1").attr("hidden", "hidden");
    if (currentStep === 0) {
        const val = document.querySelector('input[name="responsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            siInterlocuteur = false;
            return showStep(1);
        } else {
            siInterlocuteur = true;
            if (val.value == "hesite") return showStep(20);
            if (val.value == "non") return showStep(21);
        }

    }

    if (currentStep == 1) {
        const val = document.querySelector('input[name="reponse_concerne"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            return showStep(2);
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email  pour vous envoyer une documentation  ?";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep === 2) {
        const val = document.querySelector('#typeSinistre');
        if (val.value == "") {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value != "") return showStep(3);
    }

    if (currentStep === 3) {
        const val = document.querySelector('input[name="siTravaux"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            const siEnvoiDocRadio = document.querySelector('input[name="siEnvoiDoc"][value="oui"]');
            if (siEnvoiDocRadio) siEnvoiDocRadio.checked = true;
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value == "non") {
            if (siInterlocuteur) {
                return showStep(25);
            } else {
                return showStep(4);
            }

        }
    }

    if (currentStep === 8) {
        if (siInterlocuteur) {
            //HABILITE INTERLOCUTEUR
            return showStep(26);
        } else {
            return showStep(9);
        }

    }

    if (currentStep === 9) {
        const val = document.querySelector('input[name="siSignDeleg"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") return showStep(10);
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends que vous ne voulez pas signer de délégation. (RDV A PROGRAMMER POUR UN SUPERVISEUR) Puis-je avoir votre email  pour vous envoyer une documentation ?";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value == "plusTard") return showStep(16);
    }

    if (currentStep === 10) {
        if ($("#prenomSignataire").val() == "" || $("#nomSignataire").val() == "" || $("#dateNaissance").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 11) {
        if ($("#adresseImm").val() == "" || $("#cP").val() == "" || $("#ville").val() == "" || $("#etage").val() ==
            "" || $("#porte").val() == "") {
            $("#msgError").text("Veuillez compléter les informations obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 12) {
        if ($("#nomCie").val() == "") {
            $("#msgError").text("Veuillez renseigner la compagnie d'assurance !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 13) {
        if ($("#numPolice").val() == "" || $("#dateDebutContrat").val() == "" || $("#dateFinContrat").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;

        }
    }

    if (currentStep == 14) {
        if ($("#emailSign").val() == "" || $("#telSign").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        } else {
            //Envoyer Code pour signature
            // onClickTerminerAssistant();
        }

    }

    if (currentStep === 15) {
        // onClickValidSignature();
        return showStep(18)
    }

    if (currentStep === 16) {
        const val = document.querySelector('input[name="raisonRefusSignature"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }

        if (val.value == "prefereDemander") {
            $(`#textPropositionHesitationSignature`).text(
                "Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. Nous fixerons ensuite un rendez-vous pour finaliser ensemble, une fois votre échange réalisé"
            );
        } else {
            if (val.value == "documentManquant") {
                $(`#textPropositionHesitationSignature`).text(
                    "Oui effectivement, je note bien que certains documents vous manquent, c’est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
                );
            } else {
                if (val.value == "signatureComplique") {
                    $(`#textPropositionHesitationSignature`).text(
                        "Je comprends parfaitement. Soyez rassuré(e), c’est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                    );
                } else {
                    if (val.value == "prendreConnaissance") {
                        $(`#textPropositionHesitationSignature`).text(
                            "C'est tout à fait normal et même recommandé. Je vous propose de vous envoyer immédiatement la délégation par mail accompagnée d’une courte présentation de nos services pour que vous puissiez en prendre connaissance tranquillement. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, en toute sérénité."
                        );
                    } else {

                    }
                }
            }
        }
        const siEnvoiDocRadio = document.querySelector('input[name="siEnvoiDoc"][value="oui"]');
        if (siEnvoiDocRadio) siEnvoiDocRadio.checked = true;
        $('#sous-question-17-1').removeAttr("hidden");
        $("#reponseDoc").removeAttr("hidden");
        $("#divEnvoiDoc").removeAttr("hidden");
        return showStep(27);
    }

    if (currentStep === 18) {
        const val = document.querySelector('input[name="accordRVRT"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            this.getDisponiblites();
            return showStep(19);
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends votre hésitation. Sachez simplement que le relevé technique réalisé par notre expert permet très souvent d'accélérer le traitement par votre assureur et facilite l'indemnisation rapide. Toutefois, je respecte votre décision et vous envoie immédiatement notre documentation par mail.<br>N'hésitez pas à revenir vers nous à tout moment si vous souhaitez avancer ensemble. Très bonne journée à vous !";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep === 19) {
        document.getElementById('textCloture').innerHTML =
            "Je vous remercie et vous souhaite une bonne fin de journée !";
        return showStep(17)
    }

    if (currentStep === 20) {
        const val = document.querySelector('input[name="confirmResponsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }

        if (val.value === "oui") {
            siInterlocuteur = false;
            return showStep(1);
        }

        if (val.value === "non") {
            siInterlocuteur = true;
            return showStep(21);
        }
    }

    if (currentStep === 21) {
        const val = document.querySelector('input[name="dispoResp"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "dispo") {
            return showStep(1);
            siInterlocuteur = false;
        } else {
            siInterlocuteur = true;
            if (val.value === "indispo") return showStep(22);
            if (val.value === "refus") return showStep(23);
        }
    }

    if (currentStep == 22) {
        const val = document.querySelector('input[name="reponse_concerne2"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(2);
        if (val.value === "non") {
            const siEnvoiDocRadio = document.querySelector('input[name="siEnvoiDoc"][value="oui"]');
            if (siEnvoiDocRadio) siEnvoiDocRadio.checked = true;
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email professionnel pour vous envoyer une documentation que vous pourriez transmettre au responsable ?";;
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep == 23) {
        const val = document.querySelector('input[name="siSinistreEnCours"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(2);
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email professionnel pour vous envoyer une documentation que vous pourriez transmettre au responsable ?";
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value === "je ne sais pas") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Très bien, je vais noter les coordonnées complètes de votre responsable pour fixer ce rendez-vous.<br>Pouvez-vous me donner son nom, prénom, sa fonction exacte dans l’établissement, son numéro de téléphone direct ainsi que son adresse email, s’il vous plaît ?";
            return showStep(24);
        }
    }

    if (currentStep == 24) {
        const val = document.querySelector('input[name="siRvTelResponsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        $('#reponseDoc').attr("hidden", "hidden");
        if (val.value === "oui") {
            document.getElementById('textCloture').innerHTML =
                "Parfait, je vous remercie. Le rendez-vous téléphonique est confirmé. Je vous adresse dès maintenant notre documentation complète par mail afin qu’il puisse en prendre connaissance avant notre échange. Merci beaucoup pour votre aide et excellente journée ! ";
            return showStep(28);
        }
        if (val.value === "refusAvecDoc") {
            document.getElementById('textCloture').innerHTML =
                "Très bien, je comprends votre décision. Je vous envoie tout de même notre documentation complète par mail afin que vous puissiez la transmettre à votre responsable pour une consultation ultérieure. Nous restons à votre disposition si besoin.";
            $('#sous-question-17-1').removeAttr("hidden");
            $('#divEnvoiDoc').removeAttr("hidden");
            return showStep(17);
        }
        if (val.value === "refusSansDoc") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends et respecte votre choix. Sachez toutefois que nous restons entièrement à votre écoute si vous souhaitez nous recontacter à l’avenir. Je vous remercie pour votre disponibilité et vous souhaite une agréable journée !";
            return showStep(17);
        }

    }

    if (currentStep == 25) {
        return showStep(4)
    }


    if (currentStep == 26) {
        const val = document.querySelector('input[name="reponse_sihabile_signature"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(9);
        if (val.value === "non") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Je comprends votre souhait de transférer la décision à votre responsable. Seriez-vous d’accord pour que nous prenions dès maintenant un rendez-vous téléphonique avec lui ? Cela me permettra de lui présenter directement et clairement les bénéfices de notre accompagnement gratuit. ";
            return showStep(24);
        }
        if (val.value === "ouiResponsable") {
            $(`#textPropositionHesitationSignature`).text(
                "Je comprends tout à fait votre démarche. Afin que vous puissiez facilement présenter cette délégation à votre responsable, je vous propose de vous l’envoyer immédiatement par mail accompagnée d’une courte présentation de nos services. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour que nous puissions, après votre échange avec votre responsable, finaliser cette validation ensemble."
            );
            return showStep(27)

        };
        if (val.value === "refus") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Je comprends votre souhait de transférer la décision à votre responsable. Seriez-vous d’accord pour que nous prenions dès maintenant un rendez-vous téléphonique avec lui ? Cela me permettra de lui présenter directement et clairement les bénéfices de notre accompagnement gratuit. ";
            return showStep(24);
        };
    }

    if (currentStep === 27) {
        const val = document.querySelector('input[name="siRdvPerso"]:checked');
        $('#reponseDoc').attr("hidden", "hidden");
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            document.getElementById('textCloture').innerHTML =
                "Parfait, je vous remercie beaucoup pour votre temps et votre confiance. Vous recevrez immédiatement un mail récapitulatif de notre entretien et de notre prochain rendez-vous téléphonique. <br>Nous restons à votre disposition si besoin. Merci de votre accueil et excellente journée ! ";
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Très bien, je comprends votre décision. Je vous envoie donc notre documentation complète accompagnée de la délégation de gestion par mail afin que vous puissiez la transmettre à votre responsable pour une consultation ultérieure. Nous restons à votre disposition si besoin. Merci de votre accueil et excellente journée ! ";
        }
        return showStep(17);
    }

    if (currentStep === 28) {
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        $('#reponseDoc').attr("hidden", "hidden");
        document.getElementById('textCloture').innerHTML =
            "Parfait, je vous remercie. Le rendez-vous téléphonique avec votre responsable est confirmé. Je vous adresse dès maintenant notre documentation complète par mail afin qu’il puisse en prendre connaissance avant notre échange. Merci beaucoup pour votre aide et excellente journée !";
        return showStep(17);
    }

    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}


function saveScriptPartiel(etape) {
    getInfoMail()
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let causes = formData.getAll('cause[]');
    let dommages = formData.getAll('dommages[]');
    let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
    formData.append('causes', causes);
    formData.append('dommages', dommages);
    formData.append('noteTextCampagne', noteTextCampagne);
    formData.append('idAuteur', "<?= $idAuteur ?>");
    formData.append('auteur', "<?= $auteur ?>");
    formData.append('etapeSauvegarde', etape);
    formData.append('emailDestinataire', document.querySelector('input[name="emailGerant"]').value);
    formData.append('subject', $('#objetMailEnvoiDoc').val());
    formData.append('bodyMessage', tinyMCE.get("bodyMailEnvoiDoc").getContent());


    const dataObject = Object.fromEntries(formData.entries());
    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveScriptPartiel`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        beforeSend: function() {
            if (etape == 'fin') {
                $("#msgLoading").text("Enregistrement en cours...");
                $("#loadingModal").modal("show");
            }
        },
        success: function(response) {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("success");
            console.log(response);

            // if (response != "0") {
            //     opCree = response;
            // }
            if (etape == 'fin') {
                location.reload();
            }
        },
        error: function(response) {
            if (etape == 'fin') {

                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("error");
            console.log(response);
        },
        complete: function() {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            if (opCree != null) {
                console.log("send code");
                0

            }
        },
    });
}

function finish() {
    saveScriptPartiel('fin');
}

updateButtons();

//ASSISTANT SIGNATURE
let numPageSign = 0;
let nbPageSign = 7;

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
    //Vérif assurance
    if (params == "suivant") {

        if (numPageSign == "1") {
            // onClickTerminerAssistant();
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
                    text =
                        "Veuillez renseigner la compagnie d'assurance !";
                    verif = false;
                }
            } else {
                if (numPageSign == "4") {
                    if (numPolice == "" || dateDebutContrat == "" || dateFinContrat == "") {
                        text =
                            "Veuillez renseigner les informations du contrat d'assurance !";
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
                                text =
                                    "Veuillez renseigner l'adresse, l'étage et le N° de porte !";
                                verif = false;
                            }
                            if (typeSinistre == "Partie commune exclusive" && (libellePartieCommune == "")) {
                                text =
                                    "Veuillez renseigner l'adresse et la localisation !";
                                verif = false;
                            }
                        } else {
                            if (numPageSign == "7") {
                                console.log("Email Tel");

                                if (emailSign == "" || telSign == "") {
                                    text = "Veuillez confirmer le numèro de téléphone et l'adresse email !";
                                    verif = false;
                                } else {
                                    console.log("save");

                                }
                            } else {

                            }
                        }
                    }
                }
            }
        }
        //SAVE ON CLICK SUIVANT
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
            console.log("NumPage et nbPageSign " + numPageSign + " " + nbPageSign);

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

function saveInfosAssistant() {

    if (numPageSign != "0") {
        if (numPageSign == "1") {
            //SAVE TE
            // saveCauses();
        } else {
            //SAVE INFO ASSURANCES
            if ($('#typeSinistre').val() == "Partie commune exclusive") {
                // saveInfosAssurance('MRI', 'enreg');
            } else {
                // saveInfosAssurance('MRH', 'enreg');
            }
            if (numPageSign == 7) {

            }
        }
    }
}

function onClickTerminerAssistant() {
    $("#msgLoading").text("Enregistrement en cours...");
    $('#loadingModal').modal('show');
    // let resultatActivityTE = $('#resultatActivityTE').val();
    //Save INFOS IMMEUBLE
    // AddOrEditImmeuble('editLot');

    // addOrupdateContact('update');
    //SAVE TE

    // saveCauses('fin');
    console.log("CREER OP");

    console.log("send code");

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

            console.log("success");
            console.log(response);
            if (response != "0") {
                opCree = response;
            }
        },
        error: function(response) {
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 500);
            console.log(response);
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
                    console.log("success");
                    console.log(response);
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

                    console.log("ko");
                    console.log(response);
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
            console.log("success");

            // console.log(response);
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
            // divInfosCie
            $('#divInfosCie').removeAttr("hidden");
            $('#divInfosPasCie').attr("hidden", "hidden");
            $('#selectCompany').modal('hide');

        },
        error: function(response) {
            console.log(response);
            $('#selectCompany').modal('hide');
            $("#msgError").text(
                "Erreur de choisir une compagnie"
            );
            $('#errorOperation').modal('show');
        },
        complete: function() {

        },
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

//ASSISTANT RV
let numPageRV = 0;
let nbPageRV = 4;

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
    //Vérif assurance
    if (params == "suivant") {
        if (numPageRV == "1") {
            if (tel == "" || email == "") {
                text =
                    "Veuillez renseigner le numèro de téléphone et l'adresse Email !";
                verif = false;
            }
        } else {
            if (numPageRV == "2") {

                if (typeSinistre != "Partie commune exclusive" && (adresseImmeuble == "" || etage ==
                        "" || porte == "")) {
                    text =
                        "Veuillez renseigner l'adresse, l'étage et le N° de porte !";
                    verif = false;
                }
                if (typeSinistre == "Partie commune exclusive" && (libellePartieCommune == "")) {
                    text =
                        "Veuillez renseigner l'adresse et la localisation !";
                    verif = false;
                }


            } else {
                if (numPageRV == "3") {
                    if (textRV == "") {
                        text =
                            "Veuillez choisir une disponibilité !";
                        verif = false;
                    }
                } else {

                }
            }
        }

    }

    if (verif) {
        console.log(numPageRV)
        //SI MEME RV
        let siMemeRV = $('.siMemeRV:checked').val();
        //SET TEL EMAIL
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
                if (numPageRV == "1") {
                    // addOrupdateContact('update');
                }
                if (numPageRV == "2") {
                    // AddOrEditImmeuble('editLot');
                }
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


//PRISE RDV
let tab = [];
let taille = 0;
let iColor = 0;
let nbPage = 0;
let nbPageTotal = 0;
let k = 0;
let nbDispo = 0;
let horaires = [];
let nTaille = 0;
let commercialRDV = "";
let dateRDV = "";
let heureDebutRDV = "";
let heureFinRDV = "";
let idCommercialRDV = "0";



function onClickPrendreRvRT(params) {
    let email = $('#emailContact').val();
    let adresse = $('#adresseImm').val();
    let idContact = $('#idContact').val();
    // if (idContact == "0" || idContact == "") {
    //     $("#msgError").text(
    //         "Veuillez renseigner le contact au bloc 'N°1' !"
    //     );
    //     $('#errorOperation').modal('show');
    //     $('#email').focus();
    // } else {
    //     if (email == null || email == "") {
    //         $("#msgError").text(
    //             "Veuillez renseigner l'email du contact au bloc 'N°1' !"
    //         );
    //         $('#errorOperation').modal('show');
    //         $('#email').focus();
    //     } else {
    //         if (adresse == null || adresse == "") {
    //             $("#msgError").text(
    //                 "Veuillez renseigner l'adresse du rendez-vous au bloc 'N°5'!"
    //             );
    //             $('#errorOperation').modal('show');
    //             $('#email').focus();
    //         } else {
    //             //CONFIRM ADRESSE
    //             $('#confirmRDVRTModal').modal('show');
    //             // getDisponiblites();
    //         }
    //     }
    // }
    getDisponiblites();
}

function getDisponiblites() {
    let post = {
        adresseRV: $('#adresseImm').val(),
        codePostal: $('#cP').val(),
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        dateRV: "<?= "" ?>",
        heureRV: "<?= "" ?>",
        source: "wbcc"
    }
    $.ajax({
        // url: `<?= URLROOT ?>/public/json/disponibilite.php?action=getDisponibilitesExpert`,
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesExpert`,
        type: 'POST',
        data: JSON.stringify(post),
        dataType: "JSON",
        beforeSend: function() {
            $('#divChargementNotDisponibilite').attr("hidden", "hidden");
            $('#divChargementDisponibilite').removeAttr("hidden");
            // $("#msgLoading").text("Chargement agenda en cours ...");
            // $("#loadingModal").modal("show");
        },
        success: function(result) {
            // setTimeout(() => {
            //     $("#loadingModal").modal("hide");
            // }, 1000);
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
                    $('#divPriseRvRT2').removeAttr("hidden");
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
            $('#divPriseRvRT2').attr("hidden", "hidden");
            $('#divPriseRvRT').attr("hidden", "hidden");
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 1000);
            console.log("Erreur")
            console.log(response)
            // $("#msgError").text(
            //     "Impossible de charger les disponibilités, Veuillez réessayer ou contacter le support"
            // );
            // $('#errorOperation').modal('show');
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            $('#divChargementNotDisponibilite').removeAttr("hidden");
        }
    });
}

function onClickEnregistrerRV() {
    // let expert = document.getElementById('expertRV');
    // let idExpert = expert.options[expert.selectedIndex].value;
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

        // let siPlusieursRV = $('.siPlusieursRV:checked').val();
        // let idsOthersOP = $('#idsOthersOP').val();
        // let namesOthersOP = $('#namesOthersOP').val();
        // let tabIdsOP = [];
        // if (idsOthersOP != undefined && idsOthersOP != "" && idsOthersOP != null) {
        //     tabIdsOP = idsOthersOP.split(',');
        // }
        // let tabNamesOP = [];
        // if (namesOthersOP != undefined && namesOthersOP != "" && namesOthersOP != null) {
        //     tabNamesOP = namesOthersOP.split(',');
        // }
        // if ($('#idsOthersOP').val() != "" && siPlusieursRV == "Oui" && tabIdsOP.length != 0) {

        //     tabIdsOP.forEach((element, index) => {
        //         if (element.trim() != "") {
        //             post.push({
        //                 idOpportunityF: element,
        //                 numeroOP: tabNamesOP[index],
        //                 expert: expert,
        //                 idExpert: idExpert,
        //                 idContact: idContact,
        //                 idContactGuidF: $('#numeroContactRV').val(),
        //                 dateRV: date,
        //                 heureDebut: heure,
        //                 adresseRV: adresse,
        //                 etage: $('#etage2').val(),
        //                 porte: $('#porte2').val(),
        //                 lot: $('#lot2').val(),
        //                 batiment: $('#batiment2').val(),
        //                 conclusion: commentaire,
        //                 idUtilisateur: $('#idUtilisateur').val(),
        //                 numeroAuteur: $('#numeroAuteur').val(),
        //                 auteur: $('#auteur').val(),
        //                 idRVGuid: "",
        //                 idRV: "0",
        //                 idAppGuid: $('#numeroApp').val(),
        //                 idAppExtra: $('#idApp').val(),
        //                 idAppConF: $('#idAppCon').val(),
        //                 nomDO: $('#nomDO').val(),
        //                 moyenTechnique: "",
        //                 idCampagneF: "",
        //                 typeRV: "RTP",
        //                 cote: $('#cote2').val(),
        //                 libellePartieCommune: $('#libellePartieCommune2').val(),
        //                 typeLot: $('#typeLot').val()
        //             });
        //         }
        //     });
        // }

        // console.log(post)

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
                console.log("success");
                console.log(response);
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

                        if ($('#idsOthersOP').val() != "" && siPlusieursRV == "Oui") {
                            tabIdsOP.forEach((element, index) => {
                                if (element.trim() != "") {
                                    closeActivity('Programmer le RT', 3, element, tabNamesOP[
                                        index]);
                                }
                            });
                        }
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
                console.log(response);
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
        // $(".tr > td").css("background-color", "white");
        // $(this).closest("td").css("background-color", "lightgray");
        $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
        // $(this).closest("td").css("position", "relative");
        // $(this).closest("td").css("z-index", "2");
        var item = $(this).closest("td").html();
        // console.log(item);
        let nomCommercial = item.split("<br>")[0];
        let DATE_RV = item.split("<br>")[1];
        let HEURE_D = item.split("<br>")[2].split("-")[0];
        let HEURE_F = item.split("<br>")[2].split("-")[1];
        idCommercialRDV = item.split("<br>")[3].split("-")[1];
        let marge = item.split("<br>")[3].split("-")[2];
        let DUREE = item.split("<br>")[3].split("-")[3];
        // console.log(idCommercialRDV);
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
        //NEW
        // $("#INFO_RDV").text("RDV à prendre pour " + nomCommercial + " le " + DATE_RV + " de " +
        //     HEURE_D + " à " + HEURE_F);
        // $('#expertRV').attr("value", nomCommercial);
        // $('#idExpertRV').attr("value", idCommercialRDV);
        // $('#dateRV').attr("value", DATE_RV.replace(" ", "").split(' ')[1]);
        // $('#heureRV').attr("value", HEURE_D + "-" + HEURE_F);
        // $('#divPriseRvRT').removeAttr("hidden");
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
        // console.log(item);
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

function changeValueAdr() {
    $('#etage').attr("value", $('#etage2').val());
    $('#porte').attr("value", $('#porte2').val());
    $('#lot').attr("value", $('#lot2').val());
    $('#batiment').attr("value", $('#batiment2').val());
    $('#libellePartieCommune').attr("value", $('#libellePartieCommune2').val());
    $('#cote').attr("value", $('#cote2').val());
}
</script>