<script>
// Assistant Formation pour Proxinistre B2B
class AssistantFormationProxinistreB2B {
    constructor() {
        this.suggestions = [];
        this.currentContext = {};
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.loadSuggestions();
    }
    
    bindEvents() {
        $(document).on('click', '#btnAssistant', () => this.toggleAssistant());
        $(document).on('click', '.suggestion-item', (e) => this.applySuggestion(e));
        $(document).on('keyup', '#assistant-search', (e) => this.searchSuggestions(e));
    }
    
    loadSuggestions() {
        this.suggestions = [
            {
                id: 'presentation',
                title: 'Présentation standard',
                content: 'Bonjour, je suis {{nom}} de la société SOS Sinistre, spécialisée dans la gestion des sinistres immobiliers.',
                category: 'introduction'
            },
            {
                id: 'service_gratuit',
                title: 'Service gratuit',
                content: 'Nos services d\'assistance sont totalement gratuits pour les commerçants.',
                category: 'avantages'
            },
            {
                id: 'types_sinistres',
                title: 'Types de sinistres couverts',
                content: 'Nous intervenons pour les dégâts des eaux, incendies, bris de glace, effractions avec dommages matériels, etc.',
                category: 'services'
            },
            {
                id: 'expertise',
                title: 'Accompagnement expertise',
                content: 'Nous vous accompagnons lors de l\'expertise et défendons vos intérêts face à votre assureur.',
                category: 'services'
            },
            {
                id: 'travaux',
                title: 'Gestion des travaux',
                content: 'Nous coordonnons les travaux de réparation sans frais à avancer, sauf la franchise éventuelle.',
                category: 'services'
            },
            {
                id: 'rdv_expert',
                title: 'Prise de rendez-vous expert',
                content: 'Un de nos experts peut se déplacer pour évaluer la situation et vous accompagner.',
                category: 'rdv'
            },
            {
                id: 'documentation',
                title: 'Envoi de documentation',
                content: 'Je peux vous envoyer notre documentation détaillée par email.',
                category: 'suivi'
            }
        ];
    }
    
    toggleAssistant() {
        const panel = $('#assistant-panel');
        if (panel.is(':visible')) {
            panel.slideUp();
        } else {
            panel.slideDown();
            this.updateContextualSuggestions();
        }
    }
    
    updateContextualSuggestions() {
        // Analyser le contexte actuel pour proposer des suggestions pertinentes
        const currentStep = window.interfaceProxinistreB2B?.currentStep || 0;
        const selectedOptions = this.getSelectedOptions();
        
        this.currentContext = {
            step: currentStep,
            options: selectedOptions
        };
        
        this.renderSuggestions();
    }
    
    getSelectedOptions() {
        const options = {};
        $('input[type="radio"]:checked').each(function() {
            const name = $(this).attr('name');
            const value = $(this).val();
            options[name] = value;
        });
        return options;
    }
    
    renderSuggestions() {
        const filteredSuggestions = this.filterSuggestionsByContext();
        const container = $('#suggestions-container');
        
        container.empty();
        
        if (filteredSuggestions.length === 0) {
            container.append('<p class="text-muted">Aucune suggestion disponible pour le contexte actuel.</p>');
            return;
        }
        
        const groupedSuggestions = this.groupSuggestionsByCategory(filteredSuggestions);
        
        Object.keys(groupedSuggestions).forEach(category => {
            const categoryDiv = $(`<div class="suggestion-category mb-3"></div>`);
            categoryDiv.append(`<h6 class="text-uppercase text-muted">${this.getCategoryLabel(category)}</h6>`);
            
            groupedSuggestions[category].forEach(suggestion => {
                const item = $(`
                    <div class="suggestion-item p-2 mb-2 border rounded cursor-pointer" data-id="${suggestion.id}">
                        <strong>${suggestion.title}</strong>
                        <p class="mb-0 small text-muted">${suggestion.content}</p>
                    </div>
                `);
                categoryDiv.append(item);
            });
            
            container.append(categoryDiv);
        });
    }
    
    filterSuggestionsByContext() {
        const step = this.currentContext.step;
        const options = this.currentContext.options;
        
        return this.suggestions.filter(suggestion => {
            // Logique de filtrage basée sur l'étape et les options sélectionnées
            if (step === 0) {
                return suggestion.category === 'introduction';
            } else if (step === 1 && options.responsable === 'oui') {
                return suggestion.category === 'avantages' || suggestion.category === 'services';
            } else if (options.reponse_concerne === 'oui') {
                return suggestion.category === 'services' || suggestion.category === 'rdv';
            }
            
            return true; // Par défaut, afficher toutes les suggestions
        });
    }
    
    groupSuggestionsByCategory(suggestions) {
        return suggestions.reduce((groups, suggestion) => {
            const category = suggestion.category;
            if (!groups[category]) {
                groups[category] = [];
            }
            groups[category].push(suggestion);
            return groups;
        }, {});
    }
    
    getCategoryLabel(category) {
        const labels = {
            'introduction': 'Introduction',
            'avantages': 'Avantages',
            'services': 'Services',
            'rdv': 'Rendez-vous',
            'suivi': 'Suivi'
        };
        return labels[category] || category;
    }
    
    applySuggestion(e) {
        const item = $(e.currentTarget);
        const suggestionId = item.data('id');
        const suggestion = this.suggestions.find(s => s.id === suggestionId);
        
        if (suggestion) {
            this.insertSuggestionContent(suggestion);
            this.highlightAppliedSuggestion(item);
        }
    }
    
    insertSuggestionContent(suggestion) {
        // Remplacer les variables dans le contenu
        let content = suggestion.content;
        content = content.replace('{{nom}}', window.connectedUser?.fullName || '[Nom]');
        
        // Trouver le champ de texte actif ou le plus approprié
        const activeField = this.findActiveTextField();
        if (activeField) {
            const currentValue = activeField.val();
            const newValue = currentValue ? `${currentValue} ${content}` : content;
            activeField.val(newValue).trigger('change');
        } else {
            // Copier dans le presse-papiers
            this.copyToClipboard(content);
            alert('Suggestion copiée dans le presse-papiers');
        }
    }
    
    findActiveTextField() {
        // Chercher un champ de texte actif ou visible
        const textFields = $('textarea:visible, input[type="text"]:visible');
        
        // Prioriser le champ avec le focus
        const focusedField = textFields.filter(':focus');
        if (focusedField.length > 0) {
            return focusedField.first();
        }
        
        // Sinon, prendre le premier champ visible
        return textFields.first();
    }
    
    copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text);
        } else {
            // Fallback pour les anciens navigateurs
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }
    }
    
    highlightAppliedSuggestion(item) {
        item.addClass('bg-success text-white').delay(1000).queue(function() {
            $(this).removeClass('bg-success text-white').dequeue();
        });
    }
    
    searchSuggestions(e) {
        const query = $(e.target).val().toLowerCase();
        
        if (query.length < 2) {
            this.renderSuggestions();
            return;
        }
        
        const filteredSuggestions = this.suggestions.filter(suggestion => 
            suggestion.title.toLowerCase().includes(query) ||
            suggestion.content.toLowerCase().includes(query)
        );
        
        this.renderFilteredSuggestions(filteredSuggestions);
    }
    
    renderFilteredSuggestions(suggestions) {
        const container = $('#suggestions-container');
        container.empty();
        
        if (suggestions.length === 0) {
            container.append('<p class="text-muted">Aucune suggestion trouvée.</p>');
            return;
        }
        
        suggestions.forEach(suggestion => {
            const item = $(`
                <div class="suggestion-item p-2 mb-2 border rounded cursor-pointer" data-id="${suggestion.id}">
                    <strong>${suggestion.title}</strong>
                    <p class="mb-0 small text-muted">${suggestion.content}</p>
                </div>
            `);
            container.append(item);
        });
    }
    
    addCustomSuggestion(title, content, category = 'custom') {
        const suggestion = {
            id: 'custom_' + Date.now(),
            title: title,
            content: content,
            category: category
        };
        
        this.suggestions.push(suggestion);
        this.renderSuggestions();
    }
    
    exportSuggestions() {
        const dataStr = JSON.stringify(this.suggestions, null, 2);
        const dataBlob = new Blob([dataStr], {type: 'application/json'});
        
        const link = document.createElement('a');
        link.href = URL.createObjectURL(dataBlob);
        link.download = 'suggestions_proxinistre_b2b.json';
        link.click();
    }
}

// Initialisation
$(document).ready(function() {
    window.assistantFormationProxinistreB2B = new AssistantFormationProxinistreB2B();
});
</script>
