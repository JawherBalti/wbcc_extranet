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

// Calculer le nombre total d'étapes dynamiquement
const totalSteps = steps.length;

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

function onClickAssurance(val, etat) {
    // Gestion avancée de la sélection des types d'assurance
    if (val.value == "Autre") {
        if (val.checked) {
            $(`#divAutreAssurance`).removeAttr('hidden');
        } else {
            $(`#divAutreAssurance`).attr('hidden', '');
        }
    }
    
    // Navigation conditionnelle intelligente selon le type sélectionné
    if (val.checked) {
        const selectedType = val.value;
        
        // Préparation des sections spécialisées
        if (selectedType === 'mri') {
            // Préparer les champs Multirisque Immeuble
            const mriSection = document.getElementById('script-mri');
            if (mriSection) {
                mriSection.classList.add('prepared-section');
            }
        } else if (selectedType === 'mrin') {
            // Préparer les champs Multirisque Industriel
            const mrinSection = document.getElementById('script-mrin');
            if (mrinSection) {
                mrinSection.classList.add('prepared-section');
            }
        } else if (selectedType === 'rcpro') {
            // Préparer les champs RC Professionnelle
            const rcproSection = document.getElementById('script-rcpro');
            if (rcproSection) {
                rcproSection.classList.add('prepared-section');
            }
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
    if (typeSinistre && typeSinistre.value == "autre") {
        dommages = [];
    } else {
        if (typeSinistre &&  typeSinistre.value == "degatEaux") {
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
            if (typeSinistre &&  typeSinistre.value == "incendie") {
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
                if (typeSinistre &&  typeSinistre.value == "brisGlace") {
                    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le bris de glace ?");
                    dommages = ["Vitrine commerciale endommagée", "Fenêtre ou baie vitrée endommagée",
                        "Porte vitrée brisée", "Miroir décoratif cassé",
                        "Verrière fissurée", "Cabine de douche brisée", "Mobilier vitré cassé",
                        "Étagère en verre cassée", "Plateau/table en verre fracturé",
                        "Garde-corps ou clôture en verre brisé"
                    ];
                } else {
                    if (typeSinistre &&  typeSinistre.value == "vandalisme") {
                        $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vandalisme ?");
                        dommages = ["Murs ou vitrines tagués", "Dégradations portes/fenêtres",
                            "Dégradations mobilier urbain", "Dégradations équipements décoratifs",
                            "Enseigne commerciale taguée ou rayée", "Câbles coupés/endommagés",
                            "Sanitaires dégradés",
                            "Caméra surveillance détruite", "Clôtures/portails endommagés",
                            "Rideau métallique abîmé"
                        ];
                    } else {
                        if (typeSinistre &&  typeSinistre.value == "evenementClimatique") {
                            $(`#textDommages`).text(
                                "Pouvez-vous me décrire les dégâts causés par l'événment climatique ?");
                            dommages = [];
                        } else {
                            if (typeSinistre &&  typeSinistre.value == "vol") {
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
    const optionContent = document.getElementById("option-content")
    if(optionContent) optionContent.innerHTML = html;
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

// Fonction pour calculer le numéro de question réel selon la logique du script
function getQuestionNumber(stepIndex) {
    // Mapping des étapes vers les numéros de questions logiques
    const questionMapping = {
        0: 1,   // Introduction - Question 1
        1: 2,   // Présentation HB - Question 2  
        2: 3,   // Objet de l'appel - Question 3
        3: 4,   // Accroche personnalisée - Question 4
        4: 5,   // Demande d'autorisation - Question 5
        5: 6,   // Qualification prospect - Question 6
        6: 7,   // Situation actuelle - Question 7
        7: 8,   // Vérification besoin - Question 8
        8: 9,   // Présentation produits - (pas de question)
        9: 10,  // Avantages concurrentiels - (pas de question)
        10: 11, // Transition script spécifique - (pas de question)
        11: 8,  // MRI spécifique - Question 8 (suite)
        12: 8,  // MRIN spécifique - Question 8 (suite)
        13: 8,  // RC Pro spécifique - Question 8 (suite)
        14: 8,  // Autres assurances - Question 8 (suite)
        15: 9,  // Argumentaire et proposition - Question 9
        16: 10, // Objection satisfait - Question 10
        17: 11, // Objection temps - Question 11
        18: 12, // Objection budget - Question 12
        19: 13, // Objection méfiance - Question 13
        20: 14, // Synthèse - Question 14
        21: 15, // Confirmation action - Question 15
        22: 16, // Dernières questions - Question 16
        23: 17, // Remerciements - (pas de question)
        24: 18, // Absent - Question 18
        25: 19, // Rappel - Question 19
        26: 20, // Refus - (pas de question)
        27: 21, // Prescription - Question 21
        28: 22  // CRM - (pas de question)
    };
    
    return questionMapping[stepIndex] || stepIndex + 1;
}

function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    
    // Utiliser le nombre total d'étapes calculé dynamiquement
    nextBtn.classList.toggle("hidden", currentStep === totalSteps - 1 || currentStep == 23);

    finishBtn.classList.toggle("hidden", currentStep !== totalSteps - 1 && currentStep != 23);

    // Mise à jour des numéros de questions avec la logique correcte
    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    const questionNumber = getQuestionNumber(currentStep);
    spans.forEach((span, index) => {
        span.textContent = questionNumber;
    });
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;

    currentStep = index;
    steps[currentStep].classList.add("active");
    
    // Debug pour vérifier les étapes
    console.log('Navigation vers étape:', index, 'depuis étape:', history[history.length - 1]);
    
    // Gestion avancée des sections spécialisées
    manageSpecializedSectionsDisplay(index);
    
    updateButtons();
}

// Fonction pour forcer le masquage des sections spécialisées
function forceHideSpecializedSections() {
    const specializedSections = ['script-mri', 'script-mrin', 'script-rcpro', 'script-autres'];
    specializedSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none !important';
            section.classList.remove('active');
            section.classList.add('specialized-hidden');
        }
    });
}

// Navigation vers sections spécialisées avec gestion conditionnelle
function navigateToSpecificSection(sectionId, stepIndex) {
    // Préparer l'affichage des sections spécialisées
    prepareSpecializedSections();
    
    // Naviguer vers l'étape spécifique
    showStep(stepIndex);
    
    // Afficher la section demandée
    const section = document.getElementById(sectionId);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Gestion de l'affichage conditionnel des sections spécialisées
function manageSpecializedSectionsDisplay(stepIndex) {
    // Masquer toutes les sections spécialisées par défaut
    const specializedSections = ['script-mri', 'script-mrin', 'script-rcpro', 'script-autres'];
    specializedSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
        }
    });
    
    // Réinitialiser tous les steps à leur état normal
    steps.forEach((step, index) => {
        if (step.classList.contains('specialized-section')) {
            step.classList.remove('specialized-section');
        }
    });
    
    // Afficher la section appropriée selon l'étape
    if (stepIndex === 11) {
        const mriSection = document.getElementById('script-mri');
        if (mriSection) {
            mriSection.style.display = 'block';
            mriSection.classList.add('specialized-section');
        }
    } else if (stepIndex === 12) {
        const mrinSection = document.getElementById('script-mrin');
        if (mrinSection) {
            mrinSection.style.display = 'block';
            mrinSection.classList.add('specialized-section');
        }
    } else if (stepIndex === 13) {
        const rcproSection = document.getElementById('script-rcpro');
        if (rcproSection) {
            rcproSection.style.display = 'block';
            rcproSection.classList.add('specialized-section');
        }
    } else if (stepIndex === 14) {
        const autresSection = document.getElementById('script-autres');
        if (autresSection) {
            autresSection.style.display = 'block';
            autresSection.classList.add('specialized-section');
        }
    } else {
        // Pour toutes les autres étapes, s'assurer que les sections spécialisées sont masquées
        specializedSections.forEach(sectionId => {
            const section = document.getElementById(sectionId);
            if (section && section.parentElement) {
                section.style.display = 'none';
            }
        });
    }
}

// Préparation des sections spécialisées selon les sélections
function prepareSpecializedSections() {
    const checkboxes = document.querySelectorAll('input[name="besoin[]"]:checked');
    const selectedValues = Array.from(checkboxes).map(cb => cb.value);
    
    // Configuration dynamique des sections selon les besoins sélectionnés
    selectedValues.forEach(value => {
        if (value === 'mri') {
            // Préparer la section Multirisque Immeuble
            const mriFields = document.querySelectorAll('[data-section="mri"]');
            mriFields.forEach(field => field.classList.add('active-section'));
        } else if (value === 'mrin') {
            // Préparer la section Multirisque Industriel
            const mrinFields = document.querySelectorAll('[data-section="mrin"]');
            mrinFields.forEach(field => field.classList.add('active-section'));
        } else if (value === 'rcpro') {
            // Préparer la section RC Professionnelle
            const rcproFields = document.querySelectorAll('[data-section="rcpro"]');
            rcproFields.forEach(field => field.classList.add('active-section'));
        }
    });
}

// Initialisation complète du script HB Assurance
function initializeHBAssuranceScript() {
    // Configuration initiale des visibilités
    const divEnvoiDoc = document.getElementById('divEnvoiDoc')
    if(divEnvoiDoc) divEnvoiDoc.setAttribute('hidden', '');
    const divPriseRdv = document.getElementById('div-prise-rdv')
    if(divPriseRdv) divPriseRdv.setAttribute('hidden', '');
    
    // Masquer toutes les sections spécialisées au démarrage
    const specializedSections = ['script-mri', 'script-mrin', 'script-rcpro', 'script-autres'];
    specializedSections.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'none';
            section.classList.add('specialized-hidden');
        }
    });
    
    // Préparation des sections spécialisées
    prepareSpecializedSections();
    
    // Initialisation des boutons de navigation
    updateButtons();
    
    // Configuration des événements spécifiques
    const responsableInputs = document.querySelectorAll('input[name="decideurConfirme"]');
    responsableInputs.forEach(input => {
        input.addEventListener('change', (e) => onClickResponsable(e.target.value));
    });
    
    const disponibiliteInputs = document.querySelectorAll('input[name="siDsiponible"]');
    disponibiliteInputs.forEach(input => {
        input.addEventListener('change', (e) => onClickSiDsiponible(e.target.value));
    });
    
    const assuranceInputs = document.querySelectorAll('input[name="besoin[]"]');
    assuranceInputs.forEach(input => {
        input.addEventListener('change', (e) => onClickAssurance(e.target, e.target.checked));
    });
    
    console.log('🎯 Script HB Assurance B2B initialisé avec gestion correcte du retour en arrière');
}

function goBackScript() {
    if (history.length === 0) return;
    
    const previousStep = history[history.length - 1];
    console.log('Retour en arrière vers étape:', previousStep, 'depuis étape:', currentStep);
    
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    
    // Force le masquage des sections spécialisées avant de gérer l'affichage
    forceHideSpecializedSections();
    
    // Gestion correcte des sections spécialisées lors du retour en arrière
    manageSpecializedSectionsDisplay(currentStep);
    
    updateButtons();
}

// Fonction pour gérer les fonctions spécifiques au script HB Assurance
function onClickResponsable(value) {
    if (value === 'oui') {
        // Décideur confirmé, continuer normalement
        document.getElementById('divEnvoiDoc').setAttribute('hidden', '');
    } else {
        // Mauvais interlocuteur, afficher le formulaire de coordonnées
        document.getElementById('divEnvoiDoc').removeAttribute('hidden');
    }
}


function goNext() {
    // Logique de navigation intelligente pour le script HB Assurance B2B
    
    // Validation basique pour chaque étape
    if (currentStep === 0) {
        // Vérification du décideur
        const val = document.querySelector('input[name="decideurConfirme"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
    }
    
    if (currentStep === 4) {
        // Vérification de la disponibilité
        const val = document.querySelector('input[name="siDsiponible"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
    }
    
    if (currentStep === 7) {
        // Navigation conditionnelle selon les besoins sélectionnés
        const checkboxes = document.querySelectorAll('input[name="besoin[]"]:checked');
        const autreInput = document.querySelector('input[name="besoin_autre"]');
        
        if (checkboxes.length === 0 && (!autreInput || autreInput.value.trim() === '')) {
            $("#msgError").text("Veuillez sélectionner au moins un type d'assurance !");
            $('#errorOperation').modal('show');
            return;
        }
        
        // Navigation conditionnelle vers sections spécialisées
        if (checkboxes.length > 0) {
            const firstSelected = checkboxes[0].value;
            if (firstSelected === 'mri') return navigateToSpecificSection('script-mri', 11);
            if (firstSelected === 'mrin') return navigateToSpecificSection('script-mrin', 12);
            if (firstSelected === 'rcpro') return navigateToSpecificSection('script-rcpro', 13);
            if (firstSelected === 'flotte' || firstSelected === 'sante') return navigateToSpecificSection('script-autres', 14);
        }
    }
    
    // Navigation depuis les sections spécialisées vers l'argumentaire
    if (currentStep >= 11 && currentStep <= 14) {
        // Après les sections spécialisées (MRI, MRIN, RC Pro, Autres), aller vers l'argumentaire
        return showStep(15);
    }
    
    if (currentStep === 15) {
        // Navigation conditionnelle après audit
        const val = document.querySelector('input[name="accept_audit"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        
        if (val.value === 'oui') {
            return showStep(18); // Vers conclusion
        } else {
            return showStep(16); // Vers objections
        }
    }
    
    // Gestion spécifique des objections avec navigation séquentielle
    if (currentStep === 16) {
        // Objection "Satisfait de mon assureur actuel"
        const val = document.querySelector('input[name="accept_comparaison"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        
        if (val.value === 'oui') {
            return showStep(20); // Vers conclusion/synthèse
        } else {
            return showStep(17); // Vers objection suivante (temps)
        }
    }
    
    if (currentStep === 17) {
        // Objection "Pas de temps"
        const val = document.querySelector('input[name="accept_processus"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        
        if (val.value === 'oui') {
            return showStep(20); // Vers conclusion/synthèse
        } else {
            return showStep(18); // Vers objection suivante (budget)
        }
    }
    
    if (currentStep === 18) {
        // Objection "Budget limité"
        const val = document.querySelector('input[name="accept_analyse_budget"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        
        if (val.value === 'oui') {
            return showStep(20); // Vers conclusion/synthèse
        } else {
            return showStep(19); // Vers objection suivante (méfiance)
        }
    }
    
    if (currentStep === 19) {
        // Objection "Méfiance"
        const val = document.querySelector('input[name="accept_rdv_confiance"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        
        if (val.value === 'oui') {
            return showStep(20); // Vers conclusion/synthèse
        } else {
            return showStep(26); // Vers refus définitif
        }
    }

    // Avancer à l'étape suivante si on n'est pas à la dernière
    if (currentStep < totalSteps - 1) {
        showStep(currentStep + 1);
    }
}

function saveScriptPartiel(etape) {
    getInfoMail()
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let causes = formData.getAll('cause[]');
    let dommages = formData.getAll('dommages[]');
    let noteTextCampagne = tinyMCE.get("noteTextCampagne") ? tinyMCE.get("noteTextCampagne").getContent() : '';
    formData.append('causes', causes);
    formData.append('dommages', dommages);
    formData.append('noteTextCampagne', noteTextCampagne);
    formData.append('idAuteur', "<?= $idAuteur ?>");
    formData.append('auteur', "<?= $auteur ?>");
    formData.append('etapeSauvegarde', etape);
    formData.append('emailDestinataire', document.querySelector('input[name="emailGerant"]') ? document.querySelector('input[name="emailGerant"]').value : '');
    formData.append('subject', $('#objetMailEnvoiDoc').val());
    formData.append('bodyMessage', tinyMCE.get("bodyMailEnvoiDoc") ? tinyMCE.get("bodyMailEnvoiDoc").getContent() : '');

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
            if (opCree != null) {
                console.log("send code");
            }
        },
    });
}

function finish() {
    saveScriptPartiel('fin');
}

// Initialiser les boutons au chargement et le script complet
updateButtons();
initializeHBAssuranceScript();

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
function getDisponiblites() {
    let post = {
        codePostal: "",
        adresseRV: "",
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        idUser: <?= $idAuteur ?>,
        nomUserRV: "<?= $auteur ?>",
        organisateurs: []
    }
    $.ajax({
        // url: `<?= URLROOT ?>/public/json/disponibilite.php?action=getDisponibilitesExpert`,
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=wbcc&origine=web&forcage=1`,
        type: 'POST',
        data: (post),
        dataType: "JSON",
        beforeSend: function() {
            $('#divChargementNotDisponibilite').attr("hidden", "hidden");
            $('#divChargementDisponibilite').removeAttr("hidden");
            // $("#msgLoading").text("Chargement agenda en cours ...");
            // $("#loadingModal").modal("show");
        },
        success: function(result) {
            console.log(result);
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
                    $('#divPriseRvRT-1').removeAttr("hidden");
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
            $('#divPriseRvRT-1').attr("hidden", "hidden");
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
