<script>
// Gestion des interactions pour Proxinistre B2B
class InteractionsProxinistreB2B {
    constructor() {
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        // Boutons radio et options
        $(document).on('click', '.option-button', (e) => this.handleOptionClick(e));
        
        // Sélecteurs spéciaux
        $(document).on('change', '#typeSinistre', (e) => this.onChangeTypeSin(e));
        $(document).on('blur', '#autre-sinistre', () => this.showSousQuestion('2-1', true));
        
        // Navigation entre questions
        $(document).on('click', '[data-next-step]', (e) => this.goToStep(e));
        
        // Synchronisation des champs référencés
        this.initFieldSync();
    }
    
    handleOptionClick(e) {
        const button = $(e.currentTarget);
        const radio = button.find('input[type="radio"]');
        
        if (radio.length > 0) {
            this.selectRadio(button[0]);
        }
    }
    
    selectRadio(element) {
        const radio = $(element).find('input[type="radio"]');
        const name = radio.attr('name');
        
        // Désélectionner tous les autres du même groupe
        $(`input[name="${name}"]`).prop('checked', false);
        $(`input[name="${name}"]`).closest('.option-button').removeClass('selected');
        
        // Sélectionner l'élément actuel
        radio.prop('checked', true);
        $(element).addClass('selected');
        
        // Actions spécifiques selon l'onclick
        const onclickAttr = $(element).attr('onclick');
        if (onclickAttr) {
            this.executeOnclickAction(onclickAttr);
        }
        
        // Synchroniser les champs ref
        this.syncRefFields(name, radio.val());
    }
    
    executeOnclickAction(onclickStr) {
        try {
            // Parser et exécuter les actions onclick
            const actions = onclickStr.split(';');
            actions.forEach(action => {
                action = action.trim();
                if (action.startsWith('showSousQuestion(')) {
                    const match = action.match(/showSousQuestion\('([^']+)',\s*(true|false)\)/);
                    if (match) {
                        this.showSousQuestion(match[1], match[2] === 'true');
                    }
                }
            });
        } catch (error) {
            console.error('Erreur lors de l\'exécution de l\'action onclick:', error);
        }
    }
    
    showSousQuestion(questionId, show) {
        const element = $(`#sous-question-${questionId}`);
        if (show) {
            element.removeAttr('hidden').show().addClass('active');
        } else {
            element.attr('hidden', true).hide().removeClass('active');
        }
    }
    
    onChangeTypeSin(e) {
        const select = $(e.target);
        const value = select.val();
        const autreInput = $('#autre-sinistre');
        
        if (value === 'autre') {
            autreInput.show().focus();
        } else {
            autreInput.hide().val('');
            if (value) {
                this.showSousQuestion('2-1', true);
            }
        }
    }
    
    goToStep(e) {
        const button = $(e.currentTarget);
        const stepNumber = button.data('next-step');
        
        if (window.interfaceProxinistreB2B) {
            window.interfaceProxinistreB2B.goToStep(stepNumber);
        }
    }
    
    initFieldSync() {
        // Synchronisation des champs avec attribut 'ref'
        const refs = $('[ref]');
        
        refs.each(function() {
            $(this).on('input change', function() {
                const refValue = $(this).attr('ref');
                const currentValue = $(this).val();
                
                // Mettre à jour tous les autres champs avec la même référence
                $(`[ref="${refValue}"]`).not(this).each(function() {
                    if ($(this).val() !== currentValue) {
                        $(this).val(currentValue);
                    }
                });
            });
        });
    }
    
    syncRefFields(fieldName, value) {
        // Synchroniser les champs avec l'attribut ref correspondant
        $(`[ref="${fieldName}"]`).val(value);
    }
    
    updateQuestionNumbers() {
        let questionNumber = 1;
        $('.step.active').each(function() {
            $(this).find('span[name="numQuestionScript"]').text(questionNumber);
            questionNumber++;
        });
    }
    
    highlightActiveOptions() {
        // Mettre en évidence les options sélectionnées
        $('input[type="radio"]:checked').each(function() {
            $(this).closest('.option-button').addClass('selected');
        });
    }
    
    validateStep(stepElement) {
        const requiredFields = stepElement.find('input[required], select[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            const field = $(this);
            if (field.is(':radio')) {
                const name = field.attr('name');
                if (!$(`input[name="${name}"]:checked`).length) {
                    isValid = false;
                    field.closest('.response-options').addClass('error');
                }
            } else if (!field.val()) {
                isValid = false;
                field.addClass('error');
            }
        });
        
        return isValid;
    }
    
    clearValidationErrors() {
        $('.error').removeClass('error');
    }
    
    showValidationMessage(message) {
        alert(message);
    }
}

// Fonctions globales pour compatibilité avec le code existant
function selectRadio(element) {
    if (window.interactionsProxinistreB2B) {
        window.interactionsProxinistreB2B.selectRadio(element);
    }
}

function showSousQuestion(questionId, show) {
    if (window.interactionsProxinistreB2B) {
        window.interactionsProxinistreB2B.showSousQuestion(questionId, show);
    }
}

function onChangeTypeSin() {
    const event = { target: $('#typeSinistre')[0] };
    if (window.interactionsProxinistreB2B) {
        window.interactionsProxinistreB2B.onChangeTypeSin(event);
    }
}

// Initialisation
$(document).ready(function() {
    window.interactionsProxinistreB2B = new InteractionsProxinistreB2B();
});
</script>
