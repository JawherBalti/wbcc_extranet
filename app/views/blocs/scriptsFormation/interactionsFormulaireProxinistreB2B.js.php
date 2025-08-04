<script>
// Gestion des interactions de formulaire pour Proxinistre B2B
class InteractionsFormulaireProxinistreB2B {
    constructor() {
        this.validationRules = {};
        this.autoSaveTimer = null;
        this.init();
    }
    
    init() {
        this.setupValidationRules();
        this.bindEvents();
        this.initAutoSave();
    }
    
    setupValidationRules() {
        this.validationRules = {
            email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            phone: /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/,
            postalCode: /^\d{5}$/,
            required: (value) => value && value.trim().length > 0
        };
    }
    
    bindEvents() {
        // Validation en temps réel
        $(document).on('blur', 'input[data-validate]', (e) => this.validateField(e));
        $(document).on('input', 'input, textarea, select', (e) => this.onFieldChange(e));
        
        // Formatage automatique
        $(document).on('input', 'input[type="tel"]', (e) => this.formatPhone(e));
        $(document).on('input', 'input[name*="postal"]', (e) => this.formatPostalCode(e));
        
        // Auto-complétion
        $(document).on('focus', 'input[data-autocomplete]', (e) => this.initAutocomplete(e));
        
        // Synchronisation des champs
        $(document).on('change', 'input[data-sync]', (e) => this.syncFields(e));
        
        // Aide contextuelle
        $(document).on('focus', 'input, textarea, select', (e) => this.showContextualHelp(e));
        $(document).on('blur', 'input, textarea, select', () => this.hideContextualHelp());
    }
    
    validateField(e) {
        const field = $(e.target);
        const value = field.val();
        const validateType = field.data('validate');
        const isValid = this.isFieldValid(value, validateType);
        
        this.updateFieldValidation(field, isValid);
        return isValid;
    }
    
    isFieldValid(value, validateType) {
        if (!validateType) return true;
        
        const rules = validateType.split('|');
        
        for (let rule of rules) {
            if (rule === 'required') {
                if (!this.validationRules.required(value)) {
                    return false;
                }
            } else if (this.validationRules[rule]) {
                if (value && !this.validationRules[rule].test(value)) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    updateFieldValidation(field, isValid) {
        field.removeClass('is-valid is-invalid');
        
        if (isValid) {
            field.addClass('is-valid');
        } else {
            field.addClass('is-invalid');
        }
        
        // Mettre à jour le message d'erreur
        this.updateValidationMessage(field, isValid);
    }
    
    updateValidationMessage(field, isValid) {
        const messageContainer = field.next('.validation-message');
        
        if (!isValid) {
            const validateType = field.data('validate');
            const message = this.getValidationMessage(validateType);
            
            if (messageContainer.length === 0) {
                field.after(`<div class="validation-message text-danger small">${message}</div>`);
            } else {
                messageContainer.text(message);
            }
        } else {
            messageContainer.remove();
        }
    }
    
    getValidationMessage(validateType) {
        const messages = {
            'required': 'Ce champ est obligatoire',
            'email': 'Veuillez saisir une adresse email valide',
            'phone': 'Veuillez saisir un numéro de téléphone valide',
            'postalCode': 'Veuillez saisir un code postal valide (5 chiffres)'
        };
        
        const rules = validateType.split('|');
        for (let rule of rules) {
            if (messages[rule]) {
                return messages[rule];
            }
        }
        
        return 'Valeur invalide';
    }
    
    formatPhone(e) {
        const field = $(e.target);
        let value = field.val().replace(/\D/g, ''); // Supprimer tout ce qui n'est pas un chiffre
        
        // Formatage français
        if (value.startsWith('33')) {
            value = '+' + value;
        } else if (value.startsWith('0') && value.length === 10) {
            value = value.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
        }
        
        field.val(value);
    }
    
    formatPostalCode(e) {
        const field = $(e.target);
        let value = field.val().replace(/\D/g, ''); // Supprimer tout ce qui n'est pas un chiffre
        
        if (value.length > 5) {
            value = value.substring(0, 5);
        }
        
        field.val(value);
        
        // Auto-complétion de la ville
        if (value.length === 5) {
            this.loadCityFromPostalCode(value, field);
        }
    }
    
    loadCityFromPostalCode(postalCode, field) {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getRegions,
            method: 'GET',
            data: {
                action: 'getCityFromPostalCode',
                postalCode: postalCode
            },
            success: (response) => {
                const data = JSON.parse(response);
                if (data.success && data.city) {
                    const cityField = field.closest('.row').find('input[name*="city"], input[name*="ville"]');
                    if (cityField.length > 0) {
                        cityField.val(data.city);
                    }
                }
            },
            error: () => {
                console.log('Erreur lors de la récupération de la ville');
            }
        });
    }
    
    syncFields(e) {
        const field = $(e.target);
        const syncTarget = field.data('sync');
        const value = field.val();
        
        if (syncTarget) {
            $(syncTarget).val(value);
        }
    }
    
    showContextualHelp(e) {
        const field = $(e.target);
        const helpText = field.data('help');
        
        if (helpText) {
            this.displayHelp(field, helpText);
        }
    }
    
    displayHelp(field, helpText) {
        // Supprimer l'aide existante
        $('.contextual-help').remove();
        
        const helpDiv = $(`
            <div class="contextual-help bg-info text-white p-2 rounded position-absolute" style="z-index: 1000; font-size: 12px; max-width: 200px;">
                ${helpText}
            </div>
        `);
        
        $('body').append(helpDiv);
        
        // Positionner l'aide à côté du champ
        const fieldOffset = field.offset();
        helpDiv.css({
            top: fieldOffset.top,
            left: fieldOffset.left + field.outerWidth() + 10
        });
    }
    
    hideContextualHelp() {
        $('.contextual-help').fadeOut(300, function() {
            $(this).remove();
        });
    }
    
    initAutoSave() {
        // Sauvegarde automatique toutes les 30 secondes
        this.autoSaveTimer = setInterval(() => {
            this.performAutoSave();
        }, 30000);
    }
    
    onFieldChange(e) {
        // Déclencher la sauvegarde automatique après modification
        clearTimeout(this.autoSaveDebounce);
        this.autoSaveDebounce = setTimeout(() => {
            this.performAutoSave();
        }, 2000); // 2 secondes après la dernière modification
    }
    
    performAutoSave() {
        if (window.ajaxProxinistreB2B) {
            const formData = window.ajaxProxinistreB2B.collectFormData();
            this.saveToLocalStorage(formData);
        }
    }
    
    saveToLocalStorage(data) {
        const contextId = $('#contextId').val();
        if (contextId) {
            const key = `proxinistre_b2b_form_${contextId}`;
            localStorage.setItem(key, JSON.stringify(data));
        }
    }
    
    loadFromLocalStorage() {
        const contextId = $('#contextId').val();
        if (contextId) {
            const key = `proxinistre_b2b_form_${contextId}`;
            const data = localStorage.getItem(key);
            if (data) {
                try {
                    return JSON.parse(data);
                } catch (e) {
                    console.error('Erreur lors du parsing des données locales:', e);
                }
            }
        }
        return null;
    }
    
    clearLocalStorage() {
        const contextId = $('#contextId').val();
        if (contextId) {
            const key = `proxinistre_b2b_form_${contextId}`;
            localStorage.removeItem(key);
        }
    }
    
    validateForm() {
        let isValid = true;
        const errors = [];
        
        // Valider tous les champs avec validation
        $('input[data-validate], textarea[data-validate], select[data-validate]').each((index, element) => {
            const field = $(element);
            if (!this.validateField({ target: element })) {
                isValid = false;
                errors.push(field.attr('name') || field.attr('id') || `Champ ${index + 1}`);
            }
        });
        
        // Valider les champs obligatoires
        $('input[required], textarea[required], select[required]').each((index, element) => {
            const field = $(element);
            if (!field.val() || field.val().trim() === '') {
                isValid = false;
                field.addClass('is-invalid');
                errors.push(field.attr('name') || field.attr('id') || `Champ obligatoire ${index + 1}`);
            }
        });
        
        if (!isValid) {
            this.displayValidationErrors(errors);
        }
        
        return isValid;
    }
    
    displayValidationErrors(errors) {
        const errorList = errors.map(error => `<li>${error}</li>`).join('');
        const errorHtml = `
            <div class="alert alert-danger">
                <h6>Veuillez corriger les erreurs suivantes :</h6>
                <ul>${errorList}</ul>
            </div>
        `;
        
        $('#validation-errors').remove();
        $('#scriptForm').prepend(`<div id="validation-errors">${errorHtml}</div>`);
        
        // Scroll vers les erreurs
        $('html, body').animate({
            scrollTop: $('#validation-errors').offset().top - 100
        }, 500);
    }
    
    clearValidationErrors() {
        $('#validation-errors').remove();
        $('.is-invalid').removeClass('is-invalid');
        $('.validation-message').remove();
    }
    
    getFormData() {
        const data = {};
        
        $('input, textarea, select').each(function() {
            const name = $(this).attr('name');
            if (name) {
                if ($(this).is(':checkbox')) {
                    data[name] = $(this).is(':checked');
                } else if ($(this).is(':radio')) {
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
    
    destroy() {
        if (this.autoSaveTimer) {
            clearInterval(this.autoSaveTimer);
        }
        if (this.autoSaveDebounce) {
            clearTimeout(this.autoSaveDebounce);
        }
    }
}

// Initialisation
$(document).ready(function() {
    window.interactionsFormulaireProxinistreB2B = new InteractionsFormulaireProxinistreB2B();
    
    // Restaurer les données depuis le localStorage au chargement
    const savedData = window.interactionsFormulaireProxinistreB2B.loadFromLocalStorage();
    if (savedData && window.ajaxProxinistreB2B) {
        window.ajaxProxinistreB2B.populateForm(savedData);
    }
});

// Nettoyage avant déchargement de la page
$(window).on('beforeunload', function() {
    if (window.interactionsFormulaireProxinistreB2B) {
        window.interactionsFormulaireProxinistreB2B.destroy();
    }
});
</script>
