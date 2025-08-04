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


var rdv1Exst = true;
var divRDV1 = '';
var rdv1Position1 = 0;
var hidePlaceRdv1 = true,
    hidePlaceRdvbis = true;
var hidePlaceRdv2 = true,
    hidePlaceRdv2bis = true;

// Variables RDV globales
var tab = [];
var taille = 0;
var iColor = 0;
var nbPage = 0;
var nbPageTotal = 0;
var k = 0;
var nbDispo = 0;
var horaires = [];
var nTaille = 0;
var commercialRDV = "";
var dateRDV = "";
var heureDebutRDV = "";
var heureFinRDV = "";
var idCommercialRDV = "0";

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
                console.log("Before Send");
            },
            success: function(response1) {
                console.log("success ok code");
                console.log(response1);
                if (response1 != null && response1 !== undefined && response1 != {}) {

                } else {
                    $("#msgError").text(
                        "(1)Erreur enregistrement, Veuillez réessayer ou contacter l'administrateur"
                    );
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response1) {
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
                    Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d'assurance, en nous occupant de tout, de A à Z.<br><br>
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
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d'esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                     ${`<?php //SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`}
                                            `;

    $('#objetMailEnvoiDoc').val(objetMail)
    $('#signatureMail').val(`<?php //SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`)
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

// Fonction pour mettre à jour les boutons et l'affichage
function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    
    // Correction: Utiliser le nombre total d'étapes (31) au lieu de 17
    nextBtn.classList.toggle("hidden", currentStep >= 30); // 30 car index commence à 0
    finishBtn.classList.toggle("hidden", currentStep < 30);

    // Mettre à jour les numéros de question selon le script B2C
    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        // Calculer le numéro de question basé sur l'étape actuelle et le script B2C
        let questionNumber = getQuestionNumber(currentStep);
        span.textContent = questionNumber;
    });
}

// Fonction pour obtenir le bon numéro de question selon le script B2C
function getQuestionNumber(stepIndex) {
    // Mapping des étapes aux numéros de questions selon le PDF B2C
    const questionMapping = {
        0: 1,  // Question 1: Validation identité
        3: 2,  // Question 2: Demande d'autorisation de poursuivre
        4: 3,  // Question 3: Vérification du statut du prospect
        5: 4,  // Question 4: Identification des assurances détenues
        6: 5,  // Question 5: Niveau de satisfaction actuel
        7: 6,  // Question 6: Validation du besoin potentiel
        12: 7, // Question 7: Assurance emprunteur immobilier
        13: 7, // Question 7: Assurance santé complémentaire
        14: 7, // Question 7: Assurance prévoyance individuelle
        15: 7, // Question 7: Assurance habitation
        16: 7, // Question 7: Assurance automobile
        17: 7, // Question 7: Assurances spécifiques
        18: 8, // Question 8: Argumentaire et proposition d'action
        19: 9, // Question 9: Objection "Satisfait de mon assurance actuelle"
        20: 10, // Question 10: Objection "Pas le temps, pas intéressé"
        21: 11, // Question 11: Objection "Méfiance ou manque de confiance"
        22: 12, // Question 12: Objection "Prix trop élevés ou budget limité"
        23: 13, // Question 13: Synthèse rapide de l'appel
    };
    
    return questionMapping[stepIndex] || Math.min(Math.floor(stepIndex / 2) + 1, 13);
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    
    // Incrémenter pageIndex seulement pour les vraies questions
    if (isQuestionStep(index)) {
        pageIndex++;
    }

    currentStep = index;
    steps[currentStep].classList.add("active");
    updateButtons();
}

// Fonction pour déterminer si une étape est une vraie question
function isQuestionStep(stepIndex) {
    // Les étapes qui correspondent aux vraies questions du script B2C
    const questionSteps = [0, 3, 4, 5, 6, 7, 8, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
    return questionSteps.includes(stepIndex);
}

function goBackScript() {
    if (history.length === 0) return;
    
    // Décrémenter pageIndex seulement pour les vraies questions
    if (isQuestionStep(currentStep)) {
        pageIndex--;
    }
    
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    updateButtons();
}

// Fonctions spécifiques pour les interactions B2C
function onClickIdentite(response) {
    if (response === 'non') {
        $('#correction-identite').removeAttr('hidden');
    } else {
        $('#correction-identite').attr('hidden', 'hidden');
    }
}


function goNext() {
    // Logique de navigation corrigée pour le script B2C avec 31 étapes
    
    // Étape 0: Validation identité
    if (currentStep === 0) {
        const val = document.querySelector('input[name="identiteConfirmee"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            return showStep(1); // Présentation HB Assurance
        } else {
            // Gérer la correction d'identité
            return showStep(1);
        }
    }

    // Étape 1: Présentation HB Assurance (pas d'interaction)
    if (currentStep === 1) {
        return showStep(2); // Accroche initiale
    }

    // Étape 2: Accroche initiale (pas d'interaction)
    if (currentStep === 2) {
        return showStep(3); // Demande d'autorisation
    }

    // Étape 3: Demande d'autorisation de poursuivre
    if (currentStep === 3) {
        const val = document.querySelector('input[name="prospectDisponible"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            return showStep(4); // Qualification rapide
        } else {
            // Gérer le rappel
            return showStep(4); // Pour l'instant, continuer
        }
    }

    // Étape 4: Vérification du statut du prospect
    if (currentStep === 4) {
        // Vérifier que tous les champs sont remplis
        const statutHabitation = document.querySelector('select[name="statutHabitation"]').value;
        const statutEmprunteur = document.querySelector('select[name="statutEmprunteur"]').value;
        const situationPro = document.querySelector('select[name="situationPro"]').value;
        const situationFamiliale = document.querySelector('select[name="situationFamiliale"]').value;
        
        if (!statutHabitation || !statutEmprunteur || !situationPro || !situationFamiliale) {
            $("#msgError").text("Veuillez compléter toutes les informations !");
            $('#errorOperation').modal('show');
            return;
        }
        return showStep(5); // Identification des assurances
    }

    // Étape 5: Identification des assurances détenues
    if (currentStep === 5) {
        const assurances = document.querySelectorAll('input[name="assurancesDetenues[]"]:checked');
        if (assurances.length === 0) {
            $("#msgError").text("Veuillez sélectionner au moins une assurance !");
            $('#errorOperation').modal('show');
            return;
        }
        return showStep(6); // Niveau de satisfaction
    }

    // Étape 6: Niveau de satisfaction actuel
    if (currentStep === 6) {
        const satisfactionTarifs = document.querySelector('select[name="satisfactionTarifs"]').value;
        const satisfactionGaranties = document.querySelector('select[name="satisfactionGaranties"]').value;
        const satisfactionService = document.querySelector('select[name="satisfactionService"]').value;
        
        if (!satisfactionTarifs || !satisfactionGaranties || !satisfactionService) {
            $("#msgError").text("Veuillez évaluer tous les aspects !");
            $('#errorOperation').modal('show');
            return;
        }
        
        // Déclencher la mise à jour du score prospect
        if (window.B2CWorkflow) {
            window.B2CWorkflow.updateProspectScore();
            window.B2CWorkflow.checkForObjectionTriggers();
        }
        
        return showStep(7); // Validation du besoin
    }

    // Étape 7: Validation du besoin potentiel
    if (currentStep === 7) {
        const besoins = document.querySelectorAll('input[name="besoins[]"]:checked');
        if (besoins.length === 0) {
            $("#msgError").text("Veuillez sélectionner au moins un besoin !!!!");
            $('#errorOperation').modal('show');
            return;
        }
        
        console.log(`Étape 7: ${besoins.length} besoins sélectionnés`);
        besoins.forEach(besoin => {
            console.log(`- Besoin sélectionné: ${besoin.value}`);
        });
        
        // Forcer la mise à jour des besoins sélectionnés
        if (window.B2CWorkflow) {
            // Mettre à jour manuellement les besoins
            window.selectedBesoins = [];
            besoins.forEach(besoin => {
                window.selectedBesoins.push(besoin.value);
            });
            console.log('Besoins forcés:', window.selectedBesoins);
            
            window.B2CWorkflow.updateProspectScore();
            window.B2CWorkflow.showRelevantProductSections();
            window.B2CWorkflow.checkForObjectionTriggers();
        }
        
        // Navigation intelligente vers la section produit spécifique
        let produitPrioritaire = null;
        besoins.forEach(besoin => {
            if (besoin.value === "emprunteur" && !produitPrioritaire) produitPrioritaire = 12;
            else if (besoin.value === "sante" && !produitPrioritaire) produitPrioritaire = 13;
            else if (besoin.value === "prevoyance" && !produitPrioritaire) produitPrioritaire = 14;
            else if (besoin.value === "habitation" && !produitPrioritaire) produitPrioritaire = 15;
            else if (besoin.value === "auto" && !produitPrioritaire) produitPrioritaire = 16;
            else if ((besoin.value === "animaux" || besoin.value === "cyber") && !produitPrioritaire) produitPrioritaire = 17;
        });
        
        // Si un produit spécifique est sélectionné, aller directement à cette section
        if (produitPrioritaire) {
            console.log(`Navigation directe vers la section produit: étape ${produitPrioritaire}`);
            return showStep(produitPrioritaire);
        }
        
        // Sinon, passer par la présentation générale
        return showStep(8); // Présentation des produits
    }

    // Étapes 8-10: Présentation synthétique des services (pas d'interaction)
    if (currentStep >= 8 && currentStep <= 10) {
        
        
        return showStep(currentStep + 1);
    }

    // Étape 11: Orientation vers le produit spécifique
    if (currentStep === 11) {
        // Déterminer quel produit spécifique présenter selon les besoins
        const besoins = document.querySelectorAll('input[name="besoins[]"]:checked');
        console.log("test 11");
        let produitPrioritaire = null;
        
        besoins.forEach(besoin => {
            if (besoin.value === "emprunteur") produitPrioritaire = 12;
            else if (besoin.value === "sante" && !produitPrioritaire) produitPrioritaire = 13;
            else if (besoin.value === "prevoyance" && !produitPrioritaire) produitPrioritaire = 14;
            else if (besoin.value === "habitation" && !produitPrioritaire) produitPrioritaire = 15;
            else if (besoin.value === "auto" && !produitPrioritaire) produitPrioritaire = 16;
            else if (!produitPrioritaire) produitPrioritaire = 17;
        });
        
        return showStep(produitPrioritaire || 12);
    }

    // Étapes 12-17: Déroulement spécifique par produit
    if (currentStep >= 12 && currentStep <= 17) {
        console.log("tesst 12-17");
        // Valider les champs spécifiques selon le produit
        if (currentStep === 12) { // Assurance emprunteur
            console.log("tesst 12"); 
            const empruntEnCours = document.querySelector('select[name="emprunt_en_cours"]');
            if (!empruntEnCours || !empruntEnCours.value) {
                $("#msgError").text("Veuillez indiquer si vous avez un emprunt en cours !");
                $('#errorOperation').modal('show');
                return;
            }
        }
        if (currentStep === 13) { // Assurance santé
            console.log("tesst 13");
            const mutuelleActuelle = document.querySelector('input[name="mutuelle_actuelle"]');
            if (!mutuelleActuelle || !mutuelleActuelle.value.trim()) {
                $("#msgError").text("Veuillez renseigner votre mutuelle actuelle !");
                $('#errorOperation').modal('show');
                return;
            }
        }
        if (currentStep === 14) { // Assurance prévoyance
            const situationFamilialePrev = document.querySelector('select[name="situation_familiale_prev"]');
            if (!situationFamilialePrev || !situationFamilialePrev.value) {
                $("#msgError").text("Veuillez indiquer votre situation familiale !");
                $('#errorOperation').modal('show');
                return;
            }
        }
        if (currentStep === 15) { // Assurance habitation
            const typeLogement = document.querySelector('select[name="type_logement"]');
            if (!typeLogement || !typeLogement.value) {
                $("#msgError").text("Veuillez indiquer le type de logement !");
                $('#errorOperation').modal('show');
                return;
            }
        }
        if (currentStep === 16) { // Assurance automobile
            const typeVehicule = document.querySelector('input[name="type_vehicule"]');
            // if (!typeVehicule || !typeVehicule.value.trim()) {
            //     $("#msgError").text("Veuillez renseigner le type de véhicule !");
            //     $('#errorOperation').modal('show');
            //     return;
            // }
            return showStep(17); // Assurances spécifiques
        }
        if (currentStep === 17) { // Assurances spécifiques
            // Pas de validation obligatoire pour les assurances spécifiques
            // L'utilisateur peut sélectionner "Non" pour tous les champs
            return showStep(18); // Argumentaire et proposition
        }
        return showStep(18); // Argumentaire et proposition
    }

    // Étape 18: Argumentaire et proposition d'action concrète (QUESTION 8)
    if (currentStep === 18) {
        const acceptDevis = document.querySelector('input[name="accept_devis"]:checked');
        if (!acceptDevis) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (acceptDevis.value === "oui") {
            return showStep(23); // Synthèse rapide
        } else {
            return showStep(19); // Gestion des objections
        }
    }

    // Étapes 19-22: Gestion des objections courantes
    if (currentStep === 19) { // Objection "Satisfait de mon assurance actuelle"
        const acceptComparaison = document.querySelector('input[name="accept_comparaison_b2c"]:checked');
        if (!acceptComparaison) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (acceptComparaison.value === "oui") {
            return showStep(23); // Synthèse rapide
        } else {
            return showStep(20); // Objection suivante
        }
    }

    if (currentStep === 20) { // Objection "Pas le temps, pas intéressé"
        const solutionTemps = document.querySelector('input[name="solution_temps"]:checked');
        if (!solutionTemps) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (solutionTemps.value === "2min") {
            return showStep(23); // Synthèse rapide
        } else {
            return showStep(21); // Objection suivante
        }
    }

    if (currentStep === 21) { // Objection "Méfiance ou manque de confiance"
        const acceptRdvConfiance = document.querySelector('input[name="accept_rdv_confiance_b2c"]:checked');
        if (!acceptRdvConfiance) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (acceptRdvConfiance.value === "oui") {
            return showStep(23); // Synthèse rapide
        } else {
            return showStep(22); // Objection suivante
        }
    }

    if (currentStep === 22) { // Objection "Prix trop élevés ou budget limité"
        const acceptComparaisonBudget = document.querySelector('input[name="accept_comparaison_budget"]:checked');
        if (!acceptComparaisonBudget) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        return showStep(23); // Synthèse rapide
    }

    // Étapes 23-25: Conclusion et prochaines étapes
    if (currentStep === 23) { // Synthèse rapide de l'appel
        return showStep(24); // Confirmation action concrète
    }

    if (currentStep === 24) { // Confirmation action concrète
        return showStep(25); // Recueil dernières questions
    }

    if (currentStep === 25) { // Recueil dernières questions
        return showStep(26); // Remerciements chaleureux
    }

    if (currentStep === 26) { // Remerciements chaleureux
        return showStep(27); // Cas particuliers
    }

    // Étapes 27-30: Cas particuliers et scénarios spéciaux
    if (currentStep >= 27 && currentStep <= 29) {
        return showStep(currentStep + 1);
    }

    // Étape 30: Suivi interne immédiat (CRM) - dernière étape
    if (currentStep === 30) {
        const statutAppel = document.querySelector('select[name="statut_appel_b2c"]');
        if (!statutAppel || !statutAppel.value) {
            $("#msgError").text("Veuillez sélectionner le statut de l'appel !");
            $('#errorOperation').modal('show');
            return;
        }
        // Fin du script
        updateButtons();
        return;
    }

    // Navigation par défaut
    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}

function saveScriptPartiel(etape) {
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let assurancesDetenues = formData.getAll('assurancesDetenues[]');
    let besoins = formData.getAll('besoins[]');
    
    formData.append('assurancesDetenues', assurancesDetenues);
    formData.append('besoins', besoins);
    formData.append('idAuteur', "<?= $idAuteur ?>");
    formData.append('auteur', "<?= $auteur ?>");
    formData.append('etapeSauvegarde', etape);

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
        },
    });
}


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
    if (val == "oui") {
        // Prospect disponible maintenant - masquer le module RDV
        $("#div-prise-rdv").attr("hidden", "hidden");
        hidePlaceRdv1 = true;
        document.getElementById("div-prise-rdv").innerHTML = '';
        console.log('Prospect disponible maintenant');
    } else {
        // Prospect préfère un RDV ultérieur - afficher le module RDV
        if (hidePlaceRdv1) {
            console.log('Affichage du module RDV');
            
            // Réinitialiser les variables RDV
            dateRDV = "";
            commercialRDV = "";
            heureDebutRDV = "";
            heureFinRDV = "";
            idCommercialRDV = "0";
            
            // Vérifier que l'élément existe avant de modifier son contenu
            const divRdv = document.getElementById("div-prise-rdv");
            if (divRdv) {
                // Injecter le HTML du module RDV
                divRdv.innerHTML = htmlRDV1();
                
                // Afficher le module RDV
                $("#div-prise-rdv").removeAttr("hidden");
                
                // Charger les disponibilités
                getDisponiblites();
                
                // Marquer que le module RDV est affiché
                hidePlaceRdv1 = false;
            } else {
                console.error('Élément div-prise-rdv non trouvé dans le DOM');
            }
        }
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
            //console.log(myHTML);
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


function finish() {
    saveScriptPartiel('fin');
}

// Initialisation
updateButtons();

// Reste du code inchangé pour les autres fonctions...
// [Le reste des fonctions comme loadPageSign, onClickTerminerAssistant, etc. reste identique]

// ====================================================================
// LOGIQUE B2C SPÉCIALISÉE - HB ASSURANCE
// ====================================================================

// Variables globales pour le scoring et l'état B2C
let prospectScore = 0;
let selectedBesoins = [];
let selectedAssurancesDetenues = [];
let satisfactionData = {};

/**
 * Initialise la logique spécifique B2C
 */
function initializeB2CLogic() {
    console.log('Script B2C HB Assurance - Initialisé');
    
    // Masquer les sections produits spécialisées au démarrage
    const specializedSections = [
        'script-emprunteur', 'script-sante', 'script-prevoyance', 
        'script-habitation', 'script-auto', 'script-specifiques'
    ];
    
    specializedSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });
    
    // Configurer les événements
    setupB2CEventListeners();
}

/**
 * Configure les événements spécifiques au B2C
 */
function setupB2CEventListeners() {
    // Écouter les changements sur les checkboxes de besoins
    const besoinCheckboxes = document.querySelectorAll('input[name="besoins[]"]');
    console.log(`Trouvé ${besoinCheckboxes.length} checkboxes de besoins`);
    
    besoinCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log(`Changement détecté sur besoin: ${this.value}, coché: ${this.checked}`);
            updateSelectedBesoins();
            updateProspectScore();
        });
    });
    
    // Écouter les changements sur les checkboxes d'assurances détenues
    const assurancesCheckboxes = document.querySelectorAll('input[name="assurancesDetenues[]"]');
    assurancesCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            console.log(`Changement détecté sur assurance: ${this.value}, coché: ${this.checked}`);
            updateSelectedAssurancesDetenues();
        });
    });
    
    // Écouter les changements de satisfaction
    const satisfactionSelects = document.querySelectorAll('select[name^="satisfaction"]');
    satisfactionSelects.forEach(select => {
        select.addEventListener('change', function() {
            console.log(`Changement détecté sur satisfaction: ${this.name} = ${this.value}`);
            updateSatisfactionData();
            updateProspectScore();
            checkForObjectionTriggers();
        });
    });
}

/**
 * Met à jour la liste des besoins sélectionnés
 */
function updateSelectedBesoins() {
    selectedBesoins = [];
    const checkedBoxes = document.querySelectorAll('input[name="besoins[]"]:checked');
    checkedBoxes.forEach(checkbox => {
        selectedBesoins.push(checkbox.value);
    });
    
    console.log('Besoins sélectionnés:', selectedBesoins);
    
    // Déclencher l'affichage conditionnel des sections
    showRelevantProductSections();
}

/**
 * Met à jour la liste des assurances détenues
 */
function updateSelectedAssurancesDetenues() {
    selectedAssurancesDetenues = [];
    const checkedBoxes = document.querySelectorAll('input[name="assurancesDetenues[]"]:checked');
    checkedBoxes.forEach(checkbox => {
        selectedAssurancesDetenues.push(checkbox.value);
    });
    
    console.log('Assurances détenues:', selectedAssurancesDetenues);
}

/**
 * Met à jour les données de satisfaction
 */
function updateSatisfactionData() {
    satisfactionData = {
        tarifs: document.querySelector('select[name="satisfactionTarifs"]')?.value || '',
        garanties: document.querySelector('select[name="satisfactionGaranties"]')?.value || '',
        service: document.querySelector('select[name="satisfactionService"]')?.value || ''
    };
    
    console.log('Satisfaction mise à jour:', satisfactionData);
}

/**
 * Affiche les sections produits pertinentes selon les besoins
 */
function showRelevantProductSections() {
    // Masquer toutes les sections d'abord
    hideAllSpecializedSections();
    
    // Afficher les sections selon les besoins sélectionnés
    if (selectedBesoins.includes('emprunteur') || selectedAssurancesDetenues.includes('emprunteur')) {
        showSectionB2C('script-emprunteur');
    }
    
    if (selectedBesoins.includes('sante') || selectedAssurancesDetenues.includes('sante')) {
        showSectionB2C('script-sante');
    }
    
    if (selectedBesoins.includes('prevoyance') || selectedAssurancesDetenues.includes('prevoyance')) {
        showSectionB2C('script-prevoyance');
    }
    
    if (selectedBesoins.includes('auto') || selectedAssurancesDetenues.includes('auto')) {
        showSectionB2C('script-auto');
    }
    
    if (selectedBesoins.includes('habitation') || selectedAssurancesDetenues.includes('habitation')) {
        showSectionB2C('script-habitation');
    }
    
    if (selectedBesoins.includes('animaux') || selectedBesoins.includes('cyber') || hasOtherBesoins()) {
        showSectionB2C('script-specifiques');
    }
}

/**
 * Affiche une section spécifique
 */
function showSectionB2C(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'block';
        console.log(`Section ${sectionId} affichée`);
    }
}

/**
 * Masque une section spécifique
 */
function hideSectionB2C(sectionId) {
    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'none';
        console.log(`Section ${sectionId} masquée`);
    }
}

/**
 * Masque toutes les sections produits spécialisées
 */
function hideAllSpecializedSections() {
    const specializedSections = [
        'script-emprunteur', 'script-sante', 'script-prevoyance', 
        'script-habitation', 'script-auto', 'script-specifiques'
    ];
    
    specializedSections.forEach(sectionId => {
        hideSectionB2C(sectionId);
    });
}

/**
 * Vérifie s'il y a d'autres besoins spécifiés
 */
function hasOtherBesoins() {
    const otherField = document.querySelector('input[name="besoin_autre"]');
    return otherField && otherField.value.trim() !== '';
}

/**
 * Calcule le score du prospect selon les critères documentés
 */
function updateProspectScore() {
    prospectScore = 0;
    
    // Score basé sur l'insatisfaction
    if (satisfactionData.tarifs === 'insatisfait') prospectScore += 3;
    if (satisfactionData.tarifs === 'moyen') prospectScore += 1;
    
    if (satisfactionData.garanties === 'insatisfait') prospectScore += 3;
    if (satisfactionData.garanties === 'moyen') prospectScore += 1;
    
    if (satisfactionData.service === 'insatisfait') prospectScore += 2;
    if (satisfactionData.service === 'moyen') prospectScore += 1;
    
    // Score basé sur le nombre de besoins exprimés
    prospectScore += selectedBesoins.length * 2;
    
    // Classification du prospect
    let qualification = '';
    if (prospectScore > 5) {
        qualification = 'Prospect chaud 🔥';
    } else if (prospectScore >= 3) {
        qualification = 'Prospect tiède 🟡';
    } else {
        qualification = 'Prospect froid ❄️';
    }
    
    console.log(`Score prospect: ${prospectScore} - ${qualification}`);
    
    // Mettre à jour l'affichage du score si un élément existe
    const scoreDisplay = document.getElementById('prospect-score-display');
    const scoreContainer = document.getElementById('prospect-score-container');
    
    if (scoreDisplay && prospectScore > 0) {
        scoreDisplay.textContent = `Score: ${prospectScore} - ${qualification}`;
        if (scoreContainer) {
            scoreContainer.style.display = 'block';
        }
    }
    
    return prospectScore;
}

/**
 * Vérifie et déclenche les objections selon les conditions
 */
function checkForObjectionTriggers() {
    // Déclencher objection "satisfaction" si toutes les satisfactions sont "satisfait"
    if (satisfactionData.tarifs === 'satisfait' && 
        satisfactionData.garanties === 'satisfait' && 
        satisfactionData.service === 'satisfait') {
        console.log('Trigger objection: Satisfait de assurance actuelle');
        showSectionB2C('objection-satisfait-b2c');
    }
    
    // Autres triggers d'objections peuvent être ajoutés ici
}

/**
 * Validation spécifique avant passage à l'étape suivante
 */
function validateCurrentStepB2C() {
    const currentStep = getCurrentStep();
    
    // Validation pour l'étape de qualification des besoins
    if (currentStep === 7) {
        if (selectedBesoins.length === 0) {
            alert('Veuillez sélectionner au moins un besoin avant de continuer.');
            return false;
        }
    }
    
    return true;
}

/**
 * Export des fonctions pour utilisation externe
 */
window.B2CWorkflow = {
    showSection: showSectionB2C,
    hideSection: hideSectionB2C,
    updateProspectScore,
    calculateProspectScore: updateProspectScore,
    showRelevantProductSections,
    checkForObjectionTriggers,
    validateCurrentStepB2C
};

// Initialisation de la logique B2C au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser après un délai pour s'assurer que le DOM principal est prêt
    setTimeout(function() {
        initializeB2CLogic();
        console.log('Script B2C HB Assurance - Toutes les fonctions chargées');
    }, 100);
});

</script>

<?php
// include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>