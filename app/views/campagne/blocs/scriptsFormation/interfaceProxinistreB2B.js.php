<script>
// Interface utilisateur pour Proxinistre B2B
class InterfaceProxinistreB2B {
    constructor() {
        this.currentStep = 0;
        this.totalSteps = CONFIG_PROXINISTRE_B2B.totalSteps;
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.updateStepDisplay();
    }
    
    bindEvents() {
        // Navigation
        $(document).on('click', '.btn-next', () => this.nextStep());
        $(document).on('click', '.btn-prev', () => this.prevStep());
        $(document).on('click', '.btn-finish', () => this.finish());
        
        // Sélection des options
        $(document).on('click', '.option-button', (e) => this.selectOption(e));
        
        // Type de sinistre
        $(document).on('change', '#typeSinistre', (e) => this.handleTypeSinistreChange(e));
        
        // Sauvegarde automatique
        $(document).on('change', 'input, select, textarea', () => this.autoSave());
    }
    
    nextStep() {
        if (this.validateCurrentStep()) {
            if (this.currentStep < this.totalSteps - 1) {
                this.hideStep(this.currentStep);
                this.currentStep++;
                this.showStep(this.currentStep);
                this.updateStepDisplay();
                this.autoSave();
            }
        }
    }
    
    prevStep() {
        if (this.currentStep > 0) {
            this.hideStep(this.currentStep);
            this.currentStep--;
            this.showStep(this.currentStep);
            this.updateStepDisplay();
        }
    }
    
    showStep(stepIndex) {
        $(CONFIG_PROXINISTRE_B2B.selectors.steps).removeClass('active');
        $(CONFIG_PROXINISTRE_B2B.selectors.steps).eq(stepIndex).addClass('active');
        this.updateQuestionNumber(stepIndex + 1);
    }
    
    hideStep(stepIndex) {
        $(CONFIG_PROXINISTRE_B2B.selectors.steps).eq(stepIndex).removeClass('active');
    }
    
    updateStepDisplay() {
        // Mise à jour des boutons de navigation
        $('.btn-prev').toggle(this.currentStep > 0);
        $('.btn-next').toggle(this.currentStep < this.totalSteps - 1);
        $('.btn-finish').toggle(this.currentStep === this.totalSteps - 1);
        
        // Mise à jour du compteur d'étapes
        this.updateProgressBar();
    }
    
    updateProgressBar() {
        const progress = ((this.currentStep + 1) / this.totalSteps) * 100;
        $('.progress-bar').css('width', `${progress}%`);
        $('.step-counter').text(`${this.currentStep + 1} / ${this.totalSteps}`);
    }
    
    updateQuestionNumber(num) {
        $('span[name="numQuestionScript"]').text(num);
    }
    
    selectOption(e) {
        const button = $(e.currentTarget);
        const radio = button.find('input[type="radio"]');
        
        // Désélectionner les autres options du même groupe
        const name = radio.attr('name');
        $(`input[name="${name}"]`).prop('checked', false);
        $(`input[name="${name}"]`).closest('.option-button').removeClass('selected');
        
        // Sélectionner l'option actuelle
        radio.prop('checked', true);
        button.addClass('selected');
        
        // Actions spécifiques selon la réponse
        this.handleOptionSelection(name, radio.val());
    }
    
    handleOptionSelection(name, value) {
        switch (name) {
            case 'responsable':
                this.handleResponsableSelection(value);
                break;
            case 'reponse_concerne':
                this.handleConcerneSelection(value);
                break;
            case 'siDeclarerSinistre':
                this.handleDeclarationSelection(value);
                break;
            case 'repSiMandatExpert':
                this.handleExpertSelection(value);
                break;
        }
    }
    
    handleResponsableSelection(value) {
        if (value === 'oui') {
            // Passer à l'étape suivante automatiquement après un délai
            setTimeout(() => this.nextStep(), 1000);
        } else if (value === 'non') {
            // Logique pour rediriger ou terminer
            this.showNonResponsableMessage();
        }
    }
    
    handleConcerneSelection(value) {
        if (value === 'oui') {
            setTimeout(() => this.nextStep(), 1000);
        } else {
            this.showNonConcerneMessage();
        }
    }
    
    handleDeclarationSelection(value) {
        this.toggleSubQuestion('4-2', value === 'oui');
        this.toggleSubQuestion('4-1', value === 'non');
    }
    
    handleExpertSelection(value) {
        this.toggleSubQuestion('4-2-1', value === 'oui');
        this.toggleSubQuestion('4-2-2', value === 'non');
    }
    
    handleTypeSinistreChange(e) {
        const value = $(e.target).val();
        const autreInput = $('#autre-sinistre');
        
        if (value === 'autre') {
            autreInput.show().focus();
        } else {
            autreInput.hide().val('');
        }
        
        // Passer à l'étape suivante si un type est sélectionné
        if (value && value !== 'autre') {
            setTimeout(() => this.nextStep(), 1000);
        }
    }
    
    toggleSubQuestion(questionId, show) {
        const element = $(`#sous-question-${questionId}`);
        if (show) {
            element.removeAttr('hidden').show();
        } else {
            element.attr('hidden', true).hide();
        }
    }
    
    showNonResponsableMessage() {
        alert('Merci, pouvez-vous me mettre en relation avec le responsable ?');
    }
    
    showNonConcerneMessage() {
        alert('Je comprends. Puis-je vous laisser mes coordonnées au cas où vous auriez besoin de nos services à l\'avenir ?');
    }
    
    validateCurrentStep() {
        const stepValidation = CONFIG_PROXINISTRE_B2B.validation.steps[this.currentStep];
        if (!stepValidation) return true;
        
        for (let field of stepValidation) {
            const input = $(`input[name="${field}"]:checked`);
            if (input.length === 0) {
                //alert(`Veuillez répondre à la question avant de continuer.`);
                return false;
            }
        }
        return true;
    }
    
    autoSave() {
        const formData = this.collectFormData();
        // Logique de sauvegarde automatique
        console.log('Auto-sauvegarde:', formData);
    }
    
    collectFormData() {
        const data = {};
        $(CONFIG_PROXINISTRE_B2B.selectors.form).find('input, select, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                if ($(this).is(':checkbox') || $(this).is(':radio')) {
                    if ($(this).is(':checked')) {
                        data[name] = $(this).val();
                    }
                } else {
                    data[name] = $(this).val();
                }
            }
        });
        return data;
    }
    
    finish() {
        if (this.validateCurrentStep()) {
            const formData = this.collectFormData();
            this.saveScript(formData);
        }
    }
    
    saveScript(data) {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.saveScript,
            method: 'POST',
            data: data,
            success: (response) => {
                alert(CONFIG_PROXINISTRE_B2B.messages.saveSuccess);
            },
            error: () => {
                alert(CONFIG_PROXINISTRE_B2B.messages.saveError);
            }
        });
    }
}

// Initialisation
$(document).ready(function() {
    window.interfaceProxinistreB2B = new InterfaceProxinistreB2B();
});
</script>
