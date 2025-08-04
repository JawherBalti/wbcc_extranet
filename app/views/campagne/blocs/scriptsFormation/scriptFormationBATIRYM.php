<script>
// Déclaration immédiate dans le scope global pour éviter les conflits
window.updateAccroche = function(variante) {
    console.log('updateAccroche appelée avec:', variante);
    const varianteContent = document.getElementById('variante-content');
    if (!varianteContent) {
        console.error('Élément variante-content non trouvé');
        return;
    }
    const variantes = {
        'commercant': '◆ Nous avons récemment rénové une boutique dans votre secteur qui a vu sa fréquentation augmenter après les travaux.',
        'restaurant': '◆ Plusieurs restaurateurs nous ont sollicités pour transformer leur salle et améliorer le confort client.',
        'syndic': '◆ Nous accompagnons des syndics dans la réhabilitation énergétique ou structurelle de leurs immeubles.'
    };
    varianteContent.textContent = variantes[variante] || 'Sélectionnez une variante pour personnaliser l\'accroche';
    console.log('updateAccroche exécutée avec succès');
};

window.updateQuestionsSecteur = function(secteur) {
    console.log('updateQuestionsSecteur appelée avec:', secteur);
    const questionsSecteur = document.getElementById('questions-secteur');
    if (!questionsSecteur) {
        console.error('Élément questions-secteur non trouvé');
        return;
    }
    
    const questions = {
        'commerce': '<p style="color: black; font-weight: bold;"><strong>🛍️ Commerce / Boutique :</strong><br>"Avez-vous constaté une baisse de fréquentation ou des remarques clients qui pourraient être liées à l\'image ou à l\'état de votre boutique ?"</p>',
        'restaurant': '<p style="color: black; font-weight: bold;"><strong>🍽️ Restaurant / Métier de bouche :</strong><br>"Est-ce que votre salle ou votre cuisine aurait besoin d\'être réorganisée ou remise au goût du jour ?"</p>',
        'liberal': '<p style="color: black; font-weight: bold;"><strong>👩‍⚕️ Cabinet médical / Profession libérale :</strong><br>"Est-ce que vos patients vous parlent parfois du confort ou de l\'ambiance de votre salle d\'attente ?"</p>',
        'syndic': '<p style="color: black; font-weight: bold;"><strong>🏢 Syndic / Gestionnaire :</strong><br>"Avez-vous des bâtiments ou parties communes en attente de travaux ? Par exemple façade, cages d\'escaliers, isolation ?"</p>'
    };
    questionsSecteur.innerHTML = questions[secteur] || '<p class="text-justify">Les questions seront conditionnées à la sélection du groupe métier ci-dessus.</p>';
};

function updateProfilProspect() {
    const secteurSelect = document.querySelector('select[name="secteur_activite"]');
    const typeLocalSelect = document.querySelector('select[name="type_local"]');
    const statutSelect = document.querySelector('select[name="statut_prospect"]');
    
    if (!secteurSelect || !typeLocalSelect || !statutSelect) {
        console.error('Un ou plusieurs éléments de sélection non trouvés');
        return;
    }
    
    const secteur = secteurSelect.value;
    const typeLocal = typeLocalSelect.value;
    const statut = statutSelect.value;
    
    if (secteur && typeLocal && statut) {
        const badge = document.getElementById('badge-profil-prospect');
        const details = document.getElementById('profil-prospect-details');
        if (badge && details) {
            details.textContent = `${secteur} - ${typeLocal} - ${statut}`;
            badge.style.display = 'block';
            
            // Suggérer l'argumentaire sectoriel
            updateArgumentaireSectoriel(secteur);
        }
    }
}

function updateArgumentaireSectoriel(secteur) {
    const argumentaireSectoriel = document.getElementById('argumentaire-sectoriel');
    const content = document.getElementById('argumentaire-sectoriel-content');
    
    if (argumentaireSectoriel && content && secteur) {
        content.textContent = `Module 4.${secteur} suggéré selon la classification`;
        argumentaireSectoriel.style.display = 'block';
    }
}

window.onClickInterlocuteur = function(val) {
    const correctionElement = document.getElementById('correction-interlocuteur');
    if (!correctionElement) {
        console.error('Élément correction-interlocuteur non trouvé');
        return;
    }
    
    if (val == "oui") {
        correctionElement.setAttribute("hidden", "hidden");
    } else {
        correctionElement.removeAttribute("hidden");
    }
};

window.onClickPermission = function(val) {
    console.log('onClickPermission appelée avec:', val);
    const reprogrammationElement = document.getElementById('div-reprogrammation');
    if (!reprogrammationElement) {
        console.error('Élément div-reprogrammation non trouvé');
        return;
    }
    
    if (val == "oui") {
        reprogrammationElement.setAttribute("hidden", "hidden");
        // Stocker le tag CRM "Prospect engagé (2 min)"
        storeEngagementTag('Prospect engagé (2 min)');
    } else {
        reprogrammationElement.removeAttribute("hidden");
    }
    console.log('onClickPermission exécutée avec succès');
};

function storeEngagementTag(tag) {
    // Fonction pour stocker le tag CRM
    console.log('Tag CRM stocké:', tag);
    // Ici, vous pouvez ajouter la logique de stockage dans le CRM
};

window.selectRadio = function(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
};

function openReferencesModule() {
    // Fonction pour ouvrir le module "Références client BATIRYM"
    alert('Ouverture du module "Références client BATIRYM" - Accès à 3 fiches chantiers types selon la cible');
}

// Variables globales pour la navigation
let steps, prevBtn, nextBtn, finishBtn, indexPage;
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
const history = [];

// Structure des étapes du questionnaire BATIRYM (9 étapes au total)
const BATIRYM_STEPS = {
    ACCROCHE_INITIALE: 0,           // 1.1.1 Accroche initiale
    IDENTIFICATION_INTERLOCUTEUR: 1, // 1.1.2 Identification du bon interlocuteur
    PRESENTATION_BATIRYM: 2,        // 1.1.3 Brève présentation de BATIRYM
    PERMISSION_POURSUIVRE: 3,       // 1.2 Permission explicite de poursuivre
    EXPLORATION_BESOIN: 4,          // 2.1 Questions d'exploration du besoin
    QUESTIONS_SECTEUR: 5,           // Questions personnalisables selon le secteur
    CLASSIFICATION_PROSPECT: 6,     // 2.2 Classification du prospect
    ARGUMENTAIRE_GENERAL: 7,        // 3.1 Argumentaire général
    VARIANTE_ARGUMENTAIRE_PERSONNALISEE: 8, // 3.2 Variante argumentaire personnalisée
    PHRASE_IMPACT_METIER: 9,        // 3.3 Phrase d’impact métier
    OBJECTION_PAS_BESOIN: 10,       // 4.1. « Je n’ai pas de besoin »
    OBJECTION_DEJA_PRESTATAIRE: 11, // 4.2. « J’ai déjà un prestataire »
    OBJECTION_PAS_MOMENT: 12,       // 4.3. « Ce n’est pas le moment »
    OBJECTION_PAS_BUDGET: 13,       // 4.4. « Je n’ai pas de budget »
    OBJECTION_PAS_CONNU: 14,        // 4.5. « Je ne vous connais pas »
    OBJECTION_RAPPELER_PLUS_TARD: 15, // 4.6. « Rappelez-moi plus tard »
    OBJECTION_PAS_DECIDEUR: 16,     // 4.7. « Ce n’est pas moi qui décide »
    RDV_QUALIFIE: 17,               // 5.1. Proposer un rendez-vous qualifié
    REFUS_ENVOI_DOC_RELANCE: 18,    // 5.2. Si refus : envoi documentation + relance programmée
    DOUTE_RAPPEL_CRM: 19,           // 5.3. Si doute : rappel à planifier dans CRM
    CONFIRMATION_COORDONNEES: 20,   // 5.4. Confirmation finale des coordonnées
    CONCLUSION: 21                  // Étape finale
};

// Initialisation quand le DOM est prêt
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded - Initialisation du questionnaire BATIRYM');
    
    // Initialiser les références aux éléments DOM
    steps = document.querySelectorAll(".step");
    prevBtn = document.getElementById("prevBtn");
    nextBtn = document.getElementById("nextBtn");
    finishBtn = document.getElementById("finishBtn");
    indexPage = document.getElementById('indexPage');
    
    console.log('Éléments initialisés:', {
        steps: steps.length,
        prevBtn: !!prevBtn,
        nextBtn: !!nextBtn,
        finishBtn: !!finishBtn,
        indexPage: !!indexPage
    });
    
    // Vérifier que nous avons exactement 22 étapes
    if (steps.length !== 22) {
        console.warn(`Attention: ${steps.length} étapes trouvées, 22 attendues pour le questionnaire BATIRYM`);
    }
    
    // Initialiser les boutons
    updateButtons();
    
    // Initialiser le select de variante
    const varianteSelect = document.querySelector('select[name="variante_accroche"]');
    if (varianteSelect && typeof updateAccroche === 'function') {
        updateAccroche(varianteSelect.value || 'commercant');
    }
});

// Initialisation jQuery
$(document).ready(function() {
    console.log('jQuery ready - Initialisation spécifique du questionnaire BATIRYM');
    
    // S'assurer que les références textuelles sont mises à jour
    if ($('#numQuestionScript0').length) {
        $('#numQuestionScript0').text(1);
    }
});

// Gérer l'état "pinned" des tooltips
document.addEventListener('click', function(e) {
    const allTooltips = document.querySelectorAll('.tooltip-content');
    let clickedOnTooltip = false;

    document.querySelectorAll('.tooltip-container').forEach(container => {
        const content = container.querySelector('.tooltip-content');

        if (container.contains(e.target)) {
            clickedOnTooltip = true;

            // Toggle pinned state
            if (content.classList.contains('pinned')) {
                content.classList.remove('pinned');
            } else {
                allTooltips.forEach(t => t.classList.remove('pinned'));
                content.classList.add('pinned');

                // Gérer la position dynamiquement
                const rect = content.getBoundingClientRect();
                const spaceAbove = rect.top;
                const spaceBelow = window.innerHeight - rect.bottom;

                // Si pas assez de place au-dessus, ouvrir vers le bas
                if (spaceAbove < 100 && spaceBelow > spaceAbove) {
                    content.style.top = '125%';
                    content.style.bottom = 'auto';
                    content.querySelector('::after')?.remove();
                    content.style.setProperty('--tooltip-arrow-direction', 'down');
                    content.style.transform = 'translateX(-50%)';
                    content.style.setProperty('--arrow-border-color',
                        '#333 transparent transparent transparent');
                    content.style.setProperty('--arrow-top', '-8px');
                } else {
                    content.style.bottom = '125%';
                    content.style.top = 'auto';
                }
            }
        }
    });

    if (!clickedOnTooltip) {
        allTooltips.forEach(t => t.classList.remove('pinned'));
    }
});

function updateButtons() {
    if (!steps || !prevBtn || !nextBtn || !finishBtn || !indexPage) {
        console.error('Éléments manquants pour updateButtons');
        return;
    }
    
    // Mettre à jour l'indicateur de page
    indexPage.innerText = pageIndex;
    
    // Gérer la visibilité des boutons
    prevBtn.classList.toggle("hidden", currentStep === 0);
    nextBtn.classList.toggle("hidden", currentStep === steps.length - 1);
    finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1);

    // Mettre à jour le numéro de question pour les étapes de qualification
    // Les questions commencent à l'étape 4 (exploration du besoin)
    if (currentStep >= BATIRYM_STEPS.EXPLORATION_BESOIN) {
        numQuestionScript = currentStep - BATIRYM_STEPS.EXPLORATION_BESOIN + 1;
    } else {
        numQuestionScript = 1;
    }

    // Mettre à jour tous les spans avec le numéro de question
    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = numQuestionScript;
    });
    
    console.log(`Étape actuelle: ${currentStep}, Page: ${pageIndex}, Question: ${numQuestionScript}`);
}

function showStep(index) {
    if (!steps || steps.length === 0) {
        console.error('Pas d\'étapes disponibles');
        return;
    }
    
    if (index < 0 || index >= steps.length) {
        console.error(`Index d'étape invalide: ${index}`);
        return;
    }
    
    // Masquer l'étape actuelle
    steps[currentStep].classList.remove("active");
    
    // Ajouter à l'historique pour la navigation arrière
    history.push(currentStep);
    
    // Mettre à jour les variables
    pageIndex++;
    currentStep = index;
    
    // Afficher la nouvelle étape
    steps[currentStep].classList.add("active");
    
    // Mettre à jour les boutons
    updateButtons();
    
    console.log(`Navigation vers l'étape ${currentStep}: ${getStepName(currentStep)}`);
}

function getStepName(stepIndex) {
    const stepNames = [
        "Accroche initiale",
        "Identification interlocuteur", 
        "Présentation BATIRYM",
        "Permission poursuivre",
        "Exploration besoin",
        "Questions secteur",
        "Classification prospect",
        "Argumentaire général",
        "Variante argumentaire personnalisée",
        "Phrase d’impact métier",
        "Objection - Pas de besoin",
        "Objection - Déjà un prestataire",
        "Objection - Pas le moment",
        "Objection - Pas de budget",
        "Objection - Ne vous connais pas",
        "Objection - Rappelez-moi plus tard",
        "Objection - Pas moi qui décide",
        "Rendez-vous qualifié",
        "Refus - Envoi doc + relance",
        "Doute - Rappel CRM",
        "Confirmation coordonnées",
        "Conclusion"
    ];
    return stepNames[stepIndex] || `Étape ${stepIndex}`;
}

window.goBackScript = function() {
    console.log('goBackScript appelée');
    
    if (!steps || steps.length === 0 || history.length === 0) {
        console.error('Impossible de revenir en arrière');
        return;
    }
    
    // Masquer l'étape actuelle
    steps[currentStep].classList.remove("active");
    
    // Revenir à l'étape précédente
    pageIndex--;
    currentStep = history.pop();
    
    // Afficher l'étape précédente
    steps[currentStep].classList.add("active");
    
    // Mettre à jour les boutons
    updateButtons();
    
    console.log(`Retour à l'étape ${currentStep}: ${getStepName(currentStep)}`);
};

window.goNext = function() {
    console.log('goNext appelée, currentStep:', currentStep);
    
    if (!steps || steps.length === 0) {
        console.error('Pas d\'étapes disponibles pour la navigation');
        return;
    }
    
    // Validation spécifique selon l'étape actuelle
    if (!validateCurrentStep()) {
        return; // Arrêter la navigation si la validation échoue
    }
    
    // Navigation séquentielle simple pour le questionnaire BATIRYM
    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    } else {
        console.log('Dernière étape atteinte');
        // Optionnel: déclencher automatiquement la finalisation
        finish();
    }
};

function validateCurrentStep() {
    // Validation selon l'étape actuelle
    switch (currentStep) {
        case BATIRYM_STEPS.IDENTIFICATION_INTERLOCUTEUR:
            const interlocuteur = document.querySelector('input[name="bonInterlocuteur"]:checked');
            if (!interlocuteur) {
                showError("Veuillez indiquer si vous êtes le bon interlocuteur.");
                return false;
            }
            break;
            
        case BATIRYM_STEPS.PERMISSION_POURSUIVRE:
            const permission = document.querySelector('input[name="permissionPoursuivre"]:checked');
            if (!permission) {
                showError("Veuillez indiquer si vous acceptez de poursuivre l'échange.");
                return false;
            }
            break;
            
        case BATIRYM_STEPS.EXPLORATION_BESOIN:
            const statutBesoin = document.querySelector('input[name="statut_besoin"]:checked');
            if (!statutBesoin) {
                showError("Veuillez indiquer le statut de votre besoin.");
                return false;
            }
            break;
            
        case BATIRYM_STEPS.QUESTIONS_SECTEUR:
            const groupeMetier = document.querySelector('select[name="groupe_metier"]');
            if (!groupeMetier || !groupeMetier.value) {
                showError("Veuillez sélectionner votre groupe métier.");
                return false;
            }
            break;
            
        case BATIRYM_STEPS.CLASSIFICATION_PROSPECT:
            const secteurActivite = document.querySelector('select[name="secteur_activite"]');
            const typeLocal = document.querySelector('select[name="type_local"]');
            const statutProspect = document.querySelector('select[name="statut_prospect"]');
            
            if (!secteurActivite?.value || !typeLocal?.value || !statutProspect?.value) {
                showError("Veuillez compléter toutes les informations de classification.");
                return false;
            }
            break;
            
        case BATIRYM_STEPS.VARIANTE_ARGUMENTAIRE_PERSONNALISEE:
            // Pas de validation spécifique requise pour cette étape, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.PHRASE_IMPACT_METIER:
            // Pas de validation spécifique requise pour cette étape, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.OBJECTION_PAS_BESOIN:
        case BATIRYM_STEPS.OBJECTION_DEJA_PRESTATAIRE:
        case BATIRYM_STEPS.OBJECTION_PAS_MOMENT:
        case BATIRYM_STEPS.OBJECTION_PAS_BUDGET:
        case BATIRYM_STEPS.OBJECTION_PAS_CONNU:
        case BATIRYM_STEPS.OBJECTION_RAPPELER_PLUS_TARD:
        case BATIRYM_STEPS.OBJECTION_PAS_DECIDEUR:
            // Pas de validation spécifique requise pour les objections, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.RDV_QUALIFIE:
            // Pas de validation spécifique requise pour cette étape, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.REFUS_ENVOI_DOC_RELANCE:
            // Pas de validation spécifique requise pour cette étape, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.DOUTE_RAPPEL_CRM:
            // Pas de validation spécifique requise pour cette étape, la prise de note est facultative
            break;
            
        case BATIRYM_STEPS.CONFIRMATION_COORDONNEES:
            // Valider que l'email et le téléphone sont remplis si le prospect a accepté de les donner
            const emailProspect = document.querySelector('input[name="email_prospect"]');
            const telephoneProspect = document.querySelector('input[name="telephone_prospect"]');
            if ((emailProspect && emailProspect.value !== '') || (telephoneProspect && telephoneProspect.value !== '')) {
                // Si l'un des champs est rempli, on considère que c'est bon
            } else {
                // Si les deux sont vides, on peut afficher un avertissement ou laisser passer si c'est facultatif
                // Pour l'instant, on laisse passer car la confirmation est une étape de vérification
            }
            break;
    }
    
    return true; // Validation réussie
}

function showError(message) {
    // Afficher un message d'erreur (adapter selon votre système d'affichage)
    if (typeof $ !== 'undefined' && $('#errorOperation').length) {
        $("#msgError").text(message);
        $('#errorOperation').modal('show');
    } else {
        alert(message);
    }
}

window.finish = function() {
    console.log('Questionnaire BATIRYM terminé');
    
    // Sauvegarder les données du formulaire
    saveFormData();
    
    // Afficher un message de confirmation
    if (typeof $ !== 'undefined' && $('#successOperation').length) {
        $("#msgSuccess").text("Questionnaire BATIRYM terminé avec succès !");
        $('#successOperation').modal('show');
    } else {
        alert('Questionnaire BATIRYM terminé avec succès !');
    }
    
    // Optionnel: redirection ou autres actions
    setTimeout(() => {
        // location.reload(); // Décommenté si nécessaire
        console.log('Questionnaire terminé - prêt pour la suite');
    }, 2000);
};

function saveFormData() {
    // Récupérer toutes les données du formulaire
    const form = document.getElementById('scriptForm');
    if (!form) {
        console.error('Formulaire non trouvé');
        return;
    }
    
    const formData = new FormData(form);
    const dataObject = Object.fromEntries(formData.entries());
    
    console.log('Données du questionnaire BATIRYM:', dataObject);
    
    // Ici vous pouvez ajouter la logique de sauvegarde
    // Par exemple, envoi AJAX vers le serveur
    /*
    $.ajax({
        url: 'votre-endpoint-de-sauvegarde',
        type: 'POST',
        data: dataObject,
        success: function(response) {
            console.log('Sauvegarde réussie:', response);
        },
        error: function(error) {
            console.error('Erreur de sauvegarde:', error);
        }
    });
    */
}

// Initialisation finale
console.log('Script de navigation BATIRYM chargé - Version corrigée');


</script>
