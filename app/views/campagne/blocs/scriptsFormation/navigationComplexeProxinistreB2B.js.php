<script>
// Navigation complexe pour Proxinistre B2B
class NavigationComplexeProxinistreB2B {
    constructor() {
        this.stepHistory = [];
        this.conditionalSteps = {};
        this.skipRules = {};
        this.init();
    }
    
    init() {
        this.setupConditionalSteps();
        this.setupSkipRules();
        this.bindEvents();
    }
    
    setupConditionalSteps() {
        this.conditionalSteps = {
            // Étape 1 : Si non responsable, aller à l'étape de fin
            1: {
                condition: (data) => data.responsable === 'non',
                target: 'fin_non_responsable'
            },
            // Étape 2 : Si pas concerné, aller à l'étape de suivi
            2: {
                condition: (data) => data.reponse_concerne === 'non',
                target: 'suivi_non_concerne'
            },
            // Étape 3 : Selon le type de sinistre
            3: {
                condition: (data) => data.type_sinistre === 'autre',
                target: 'details_autre_sinistre'
            },
            // Étape 4 : Selon la déclaration
            4: {
                condition: (data) => data.siDeclarerSinistre === 'non',
                target: 'aide_declaration'
            }
        };
    }
    
    setupSkipRules() {
        this.skipRules = {
            // Ignorer certaines étapes selon le contexte
            'expertise': (data) => data.siDeclarerSinistre === 'non',
            'indemnisation': (data) => data.repSiExpertVenu === 'non',
            'travaux': (data) => data.indemnisationRecu === 'non'
        };
    }
    
    bindEvents() {
        $(document).on('click', '.btn-next-conditional', (e) => this.handleConditionalNext(e));
        $(document).on('click', '.btn-goto-step', (e) => this.goToSpecificStep(e));
        $(document).on('click', '.btn-back-to-main', () => this.backToMainFlow());
    }
    
    handleConditionalNext(e) {
        e.preventDefault();
        
        const currentStep = window.interfaceProxinistreB2B?.currentStep || 0;
        const formData = this.getCurrentFormData();
        
        // Vérifier s'il y a une condition pour cette étape
        const stepCondition = this.conditionalSteps[currentStep];
        
        if (stepCondition && stepCondition.condition(formData)) {
            this.navigateToTarget(stepCondition.target);
        } else {
            this.navigateToNextStep();
        }
    }
    
    navigateToTarget(target) {
        // Sauvegarder l'historique
        this.addToHistory(window.interfaceProxinistreB2B?.currentStep || 0);
        
        switch (target) {
            case 'fin_non_responsable':
                this.showNonResponsableEnd();
                break;
            case 'suivi_non_concerne':
                this.showNonConcerneFollow();
                break;
            case 'details_autre_sinistre':
                this.showAutreSinistreDetails();
                break;
            case 'aide_declaration':
                this.showDeclarationHelp();
                break;
            default:
                this.goToStepById(target);
        }
    }
    
    navigateToNextStep() {
        const currentStep = window.interfaceProxinistreB2B?.currentStep || 0;
        const nextStep = this.findNextValidStep(currentStep);
        
        if (nextStep !== null) {
            this.addToHistory(currentStep);
            window.interfaceProxinistreB2B?.goToStep(nextStep);
        }
    }
    
    findNextValidStep(currentStep) {
        const formData = this.getCurrentFormData();
        let nextStep = currentStep + 1;
        const maxSteps = CONFIG_PROXINISTRE_B2B.totalSteps;
        
        // Vérifier les règles de saut
        while (nextStep < maxSteps) {
            const stepElement = $(CONFIG_PROXINISTRE_B2B.selectors.steps).eq(nextStep);
            const stepId = stepElement.attr('id') || stepElement.data('step-id');
            
            if (this.shouldSkipStep(stepId, formData)) {
                nextStep++;
                continue;
            }
            
            return nextStep;
        }
        
        return null; // Pas d'étape suivante valide
    }
    
    shouldSkipStep(stepId, formData) {
        if (!stepId || !this.skipRules[stepId]) {
            return false;
        }
        
        return this.skipRules[stepId](formData);
    }
    
    goToSpecificStep(e) {
        const button = $(e.currentTarget);
        const targetStep = button.data('target-step');
        
        if (targetStep !== undefined) {
            this.addToHistory(window.interfaceProxinistreB2B?.currentStep || 0);
            window.interfaceProxinistreB2B?.goToStep(targetStep);
        }
    }
    
    goToStepById(stepId) {
        const stepElement = $(`#${stepId}, [data-step-id="${stepId}"]`);
        if (stepElement.length > 0) {
            const stepIndex = $(CONFIG_PROXINISTRE_B2B.selectors.steps).index(stepElement);
            if (stepIndex >= 0) {
                window.interfaceProxinistreB2B?.goToStep(stepIndex);
            }
        }
    }
    
    addToHistory(stepIndex) {
        this.stepHistory.push(stepIndex);
        
        // Limiter l'historique à 10 étapes
        if (this.stepHistory.length > 10) {
            this.stepHistory.shift();
        }
        
        this.updateBackButton();
    }
    
    backToPreviousStep() {
        if (this.stepHistory.length > 0) {
            const previousStep = this.stepHistory.pop();
            window.interfaceProxinistreB2B?.goToStep(previousStep);
            this.updateBackButton();
        }
    }
    
    backToMainFlow() {
        // Retourner au flux principal
        this.stepHistory = [];
        window.interfaceProxinistreB2B?.goToStep(0);
        this.updateBackButton();
    }
    
    updateBackButton() {
        const backButton = $('.btn-back-history');
        if (this.stepHistory.length > 0) {
            backButton.show().off('click').on('click', () => this.backToPreviousStep());
        } else {
            backButton.hide();
        }
    }
    
    getCurrentFormData() {
        if (window.ajaxProxinistreB2B) {
            return window.ajaxProxinistreB2B.collectFormData();
        } else if (window.interactionsFormulaireProxinistreB2B) {
            return window.interactionsFormulaireProxinistreB2B.getFormData();
        }
        return {};
    }
    
    showNonResponsableEnd() {
        this.showCustomStep({
            title: 'Transfert vers le responsable',
            content: `
                <div class="text-center">
                    <i class="fas fa-user-tie fa-3x text-info mb-3"></i>
                    <h4>Merci pour votre temps</h4>
                    <p>Pouvez-vous me mettre en relation avec la personne responsable de la gestion des sinistres ?</p>
                    <div class="mt-4">
                        <button class="btn btn-primary" onclick="window.navigationComplexeProxinistreB2B.scheduleCallback()">
                            Programmer un rappel
                        </button>
                        <button class="btn btn-secondary ml-2" onclick="window.navigationComplexeProxinistreB2B.backToMainFlow()">
                            Recommencer
                        </button>
                    </div>
                </div>
            `
        });
    }
    
    showNonConcerneFollow() {
        this.showCustomStep({
            title: 'Suivi futur',
            content: `
                <div class="text-center">
                    <i class="fas fa-bookmark fa-3x text-warning mb-3"></i>
                    <h4>Information notée</h4>
                    <p>Je comprends que ce n'est pas un sujet d'actualité pour vous.</p>
                    <p>Puis-je vous laisser mes coordonnées au cas où vous auriez besoin de nos services à l'avenir ?</p>
                    <div class="mt-4">
                        <button class="btn btn-success" onclick="window.navigationComplexeProxinistreB2B.sendContactInfo()">
                            Recevoir les coordonnées
                        </button>
                        <button class="btn btn-secondary ml-2" onclick="window.navigationComplexeProxinistreB2B.endCall()">
                            Terminer l'appel
                        </button>
                    </div>
                </div>
            `
        });
    }
    
    showAutreSinistreDetails() {
        this.showCustomStep({
            title: 'Précisions sur le sinistre',
            content: `
                <div>
                    <h4>Détails du sinistre</h4>
                    <p>Pouvez-vous me donner plus de détails sur le type de sinistre que vous avez subi ?</p>
                    <div class="form-group">
                        <label>Description détaillée :</label>
                        <textarea class="form-control" name="description_autre_sinistre" rows="4" 
                                  placeholder="Décrivez votre sinistre..."></textarea>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary" onclick="window.navigationComplexeProxinistreB2B.saveAutreSinistreDetails()">
                            Continuer
                        </button>
                        <button class="btn btn-secondary ml-2" onclick="window.navigationComplexeProxinistreB2B.backToPreviousStep()">
                            Retour
                        </button>
                    </div>
                </div>
            `
        });
    }
    
    showDeclarationHelp() {
        this.showCustomStep({
            title: 'Aide à la déclaration',
            content: `
                <div>
                    <h4>Assistance pour la déclaration</h4>
                    <p>Pas de problème, nous pouvons vous aider avec la déclaration de sinistre.</p>
                    <div class="alert alert-info">
                        <h6>Nos services incluent :</h6>
                        <ul>
                            <li>Aide à la constitution du dossier</li>
                            <li>Contact direct avec votre assureur</li>
                            <li>Suivi de votre déclaration</li>
                        </ul>
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-success" onclick="window.navigationComplexeProxinistreB2B.scheduleDeclarationHelp()">
                            Programmer une aide
                        </button>
                        <button class="btn btn-info ml-2" onclick="window.navigationComplexeProxinistreB2B.sendDeclarationGuide()">
                            Recevoir le guide
                        </button>
                    </div>
                </div>
            `
        });
    }
    
    showCustomStep(stepData) {
        // Masquer toutes les étapes
        $(CONFIG_PROXINISTRE_B2B.selectors.steps).removeClass('active');
        
        // Créer et afficher l'étape personnalisée
        const customStep = $(`
            <div id="custom-step" class="step active">
                <div class="question-box">
                    <div class="question-content">
                        <h3>${stepData.title}</h3>
                        ${stepData.content}
                    </div>
                </div>
            </div>
        `);
        
        $('#custom-step').remove(); // Supprimer l'ancien si il existe
        $('#scriptForm').append(customStep);
    }
    
    // Méthodes d'action pour les boutons personnalisés
    scheduleCallback() {
        alert('Fonctionnalité de rappel à implémenter');
        // Implémenter la logique de programmation de rappel
    }
    
    sendContactInfo() {
        alert('Envoi des coordonnées...');
        // Implémenter l'envoi des coordonnées
    }
    
    endCall() {
        alert('Merci pour votre temps. Au revoir !');
        // Implémenter la fin d'appel
    }
    
    saveAutreSinistreDetails() {
        const description = $('textarea[name="description_autre_sinistre"]').val();
        if (description.trim()) {
            // Sauvegarder la description
            $('input[name="autre_sinistre"]').val(description);
            this.navigateToNextStep();
        } else {
            alert('Veuillez décrire votre sinistre avant de continuer.');
        }
    }
    
    scheduleDeclarationHelp() {
        alert('Programmation d\'une aide à la déclaration...');
        // Implémenter la programmation d'aide
    }
    
    sendDeclarationGuide() {
        alert('Envoi du guide de déclaration...');
        // Implémenter l'envoi du guide
    }
    
    getNavigationState() {
        return {
            currentStep: window.interfaceProxinistreB2B?.currentStep || 0,
            history: [...this.stepHistory]
        };
    }
    
    restoreNavigationState(state) {
        if (state) {
            this.stepHistory = state.history || [];
            if (state.currentStep !== undefined) {
                window.interfaceProxinistreB2B?.goToStep(state.currentStep);
            }
            this.updateBackButton();
        }
    }
}

// Initialisation
$(document).ready(function() {
    window.navigationComplexeProxinistreB2B = new NavigationComplexeProxinistreB2B();
});
</script>
