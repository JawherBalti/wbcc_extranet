<script>
// Configuration spécifique pour Proxinistre B2B
const CONFIG_PROXINISTRE_B2B = {
    // Configuration du script
    totalSteps: 20,
    currentStep: 0,
    
    // URLs et endpoints
    endpoints: {
        saveScript: '<?= URLROOT ?>/campagne/saveScriptFormationProxinistreB2B',
        loadScript: '<?= URLROOT ?>/campagne/loadScriptFormationProxinistreB2B',
        getRegions: '<?= URLROOT ?>/public/json/geoApi.php',
        sendDocumentation: '<?= URLROOT ?>/campagne/sendDocumentationProxinistre'
    },
    
    // Configuration des régions
    regions: {
        available: [],
        selected: []
    },
    
    // Configuration des types de sinistre
    typeSinistres: {
        'degat_eaux': 'Dégât des eaux',
        'incendie': 'Incendie',
        'bris_glace': 'Bris de glace',
        'effraction': 'Effraction avec dommages matériels',
        'catastrophe_naturelle': 'Catastrophe naturelle',
        'autre': 'Autre'
    },
    
    // Configuration RDV
    rdv: {
        commercial: null,
        date: null,
        heureDebut: null,
        heureFin: null,
        disponibilites: []
    },
    
    // Configuration des éléments du DOM
    selectors: {
        form: '#scriptForm',
        steps: '.step',
        nextBtn: '.btn-next',
        prevBtn: '.btn-prev',
        finishBtn: '.btn-finish',
        typeSinistre: '#typeSinistre',
        autreSinistre: '#autre-sinistre'
    },
    
    // Messages et textes
    messages: {
        saveSuccess: 'Script sauvegardé avec succès',
        saveError: 'Erreur lors de la sauvegarde',
        loadError: 'Erreur lors du chargement',
        invalidStep: 'Étape invalide',
        missingData: 'Données manquantes'
    },
    
    // Validation
    validation: {
        required: ['responsable', 'reponse_concerne', 'type_sinistre'],
        steps: {
            0: ['responsable'],
            1: ['reponse_concerne'],
            2: ['type_sinistre']
        }
    }
};

// Variables globales spécifiques à Proxinistre B2B
let currentStepProxinistre = 0;
let scriptDataProxinistre = {};
let rdvDataProxinistre = {};
let regionsDataProxinistre = [];
</script>
