<script>
// Configuration et variables globales pour la formation B2C
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

// Variables pour la gestion des RDV
var rdv1Exst = true;
var divRDV1 = '';
var rdv1Position1 = 0;
var hidePlaceRdv1 = true, hidePlaceRdvbis = true;
var hidePlaceRdv2 = true, hidePlaceRdv2bis = true;

// Variables pour l'assistant territorial
let numPageTE = 0;
let nbPageTE = 4;
var regionsChoosed = [], departementChoosed = [];

// Variables pour les disponibilités RDV
var taille = 0;
var tab = [];
var k = 0;
var first = 0;
var nbPage = 0;
var nbPageTotal = 0;
var nbDispo = 0;
var iColor = 0;
var idCommercialRDV = "0";
var commercialRDV = "";
var dateRDV = "";
var heureDebutRDV = "";
var heureFinRDV = "";
var secondHD = 0;
var secondHF = 0;
var horaires = [];
var nTaille = 0;
var heure = 0;
var min = 0;

// Configuration des tooltips
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

// Gestion des références
refs.forEach(ref => {
    ref.addEventListener('input', (e) => {
        refs.forEach(r => {
            if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                r.value = ref.value;
            }
        });
    });
});

// Fonction utilitaire pour sélectionner un radio
function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// Script de vérification pour B2C
$(document).ready(function() {
    console.log('Configuration B2C chargée');
    
    // Vérifier les éléments DOM nécessaires
    if ($('#contextId').length > 0) {
        console.log('✓ Element #contextId trouvé, valeur:', $('#contextId').val());
    } else {
        console.error('✗ Element #contextId non trouvé');
    }
    
    if ($('#contextType').length > 0) {
        console.log('✓ Element #contextType trouvé, valeur:', $('#contextType').val());
    } else {
        console.error('✗ Element #contextType non trouvé');
    }
});
</script>
