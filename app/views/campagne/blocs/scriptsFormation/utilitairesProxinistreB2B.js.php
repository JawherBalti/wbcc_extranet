<script>
// Utilitaires pour Proxinistre B2B
class UtilitairesProxinistreB2B {
    constructor() {
        this.utils = {};
        this.cache = new Map();
        this.init();
    }
    
    init() {
        this.setupUtils();
        this.bindEvents();
    }
    
    setupUtils() {
        this.utils = {
            formatters: {
                currency: (value) => new Intl.NumberFormat('fr-FR', { 
                    style: 'currency', 
                    currency: 'EUR' 
                }).format(value),
                
                date: (date) => new Date(date).toLocaleDateString('fr-FR'),
                
                phone: (phone) => {
                    if (!phone) return '';
                    return phone.replace(/(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/, '$1 $2 $3 $4 $5');
                },
                
                capitalizeFirst: (str) => {
                    if (!str) return '';
                    return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
                }
            },
            
            validators: {
                email: (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email),
                phone: (phone) => /^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/.test(phone),
                siret: (siret) => /^\d{14}$/.test(siret?.replace(/\s/g, '')),
                postalCode: (code) => /^\d{5}$/.test(code)
            },
            
            generators: {
                uuid: () => 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    const r = Math.random() * 16 | 0;
                    const v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                }),
                
                reference: (prefix = 'PROX') => {
                    const timestamp = Date.now().toString(36);
                    const random = Math.random().toString(36).substr(2, 5);
                    return `${prefix}-${timestamp}-${random}`.toUpperCase();
                }
            }
        };
    }
    
    bindEvents() {
        // Auto-formatage des champs
        $(document).on('blur', 'input[data-format]', (e) => this.autoFormat(e));
        
        // Auto-validation
        $(document).on('blur', 'input[data-validate-type]', (e) => this.autoValidate(e));
        
        // Copie en un clic
        $(document).on('click', '[data-copy]', (e) => this.copyToClipboard(e));
        
        // Sauvegarde d'état
        $(document).on('change', 'input, select, textarea', () => this.saveState());
    }
    
    autoFormat(e) {
        const field = $(e.target);
        const formatType = field.data('format');
        const value = field.val();
        
        if (!value || !this.utils.formatters[formatType]) return;
        
        const formattedValue = this.utils.formatters[formatType](value);
        field.val(formattedValue);
    }
    
    autoValidate(e) {
        const field = $(e.target);
        const validateType = field.data('validate-type');
        const value = field.val();
        
        if (!value || !this.utils.validators[validateType]) return;
        
        const isValid = this.utils.validators[validateType](value);
        this.updateFieldValidationState(field, isValid);
    }
    
    updateFieldValidationState(field, isValid) {
        field.removeClass('is-valid is-invalid');
        
        if (isValid) {
            field.addClass('is-valid');
        } else {
            field.addClass('is-invalid');
        }
    }
    
    copyToClipboard(e) {
        const element = $(e.target);
        const textToCopy = element.data('copy') || element.text();
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                this.showToast('Copié dans le presse-papiers', 'success');
            });
        } else {
            // Fallback
            const textArea = document.createElement('textarea');
            textArea.value = textToCopy;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            this.showToast('Copié dans le presse-papiers', 'success');
        }
    }
    
    showToast(message, type = 'info', duration = 3000) {
        const toastClass = {
            'success': 'bg-success',
            'error': 'bg-danger',
            'warning': 'bg-warning',
            'info': 'bg-info'
        }[type] || 'bg-info';
        
        const toast = $(`
            <div class="toast-message position-fixed ${toastClass} text-white p-3 rounded" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 250px;">
                ${message}
            </div>
        `);
        
        $('body').append(toast);
        
        toast.fadeIn(300);
        
        setTimeout(() => {
            toast.fadeOut(300, () => toast.remove());
        }, duration);
    }
    
    saveState() {
        if (this.saveStateTimeout) {
            clearTimeout(this.saveStateTimeout);
        }
        
        this.saveStateTimeout = setTimeout(() => {
            const state = this.collectFormState();
            const contextId = $('#contextId').val();
            
            if (contextId) {
                localStorage.setItem(`proxinistre_state_${contextId}`, JSON.stringify(state));
            }
        }, 1000);
    }
    
    collectFormState() {
        const state = {
            timestamp: Date.now(),
            currentStep: window.interfaceProxinistreB2B?.currentStep || 0,
            formData: {},
            selectedOptions: []
        };
        
        // Collecter les données du formulaire
        $('input, select, textarea').each(function() {
            const name = $(this).attr('name');
            if (name) {
                if ($(this).is(':checkbox') || $(this).is(':radio')) {
                    if ($(this).is(':checked')) {
                        state.formData[name] = $(this).val();
                    }
                } else {
                    state.formData[name] = $(this).val();
                }
            }
        });
        
        // Collecter les options sélectionnées
        $('.option-button.selected').each(function() {
            const radio = $(this).find('input[type="radio"]');
            if (radio.length > 0) {
                state.selectedOptions.push({
                    name: radio.attr('name'),
                    value: radio.val()
                });
            }
        });
        
        return state;
    }
    
    restoreState(contextId) {
        const stateKey = `proxinistre_state_${contextId}`;
        const savedState = localStorage.getItem(stateKey);
        
        if (savedState) {
            try {
                const state = JSON.parse(savedState);
                this.applyState(state);
                return true;
            } catch (e) {
                console.error('Erreur lors de la restauration de l\'état:', e);
            }
        }
        
        return false;
    }
    
    applyState(state) {
        // Restaurer les données du formulaire
        Object.keys(state.formData).forEach(name => {
            const field = $(`[name="${name}"]`);
            if (field.length > 0) {
                if (field.is(':checkbox') || field.is(':radio')) {
                    field.filter(`[value="${state.formData[name]}"]`).prop('checked', true);
                } else {
                    field.val(state.formData[name]);
                }
            }
        });
        
        // Restaurer les options sélectionnées
        state.selectedOptions.forEach(option => {
            const radio = $(`input[name="${option.name}"][value="${option.value}"]`);
            if (radio.length > 0) {
                radio.prop('checked', true);
                radio.closest('.option-button').addClass('selected');
            }
        });
        
        // Restaurer l'étape actuelle
        if (window.interfaceProxinistreB2B && state.currentStep) {
            window.interfaceProxinistreB2B.goToStep(state.currentStep);
        }
    }
    
    clearState(contextId) {
        const stateKey = `proxinistre_state_${contextId}`;
        localStorage.removeItem(stateKey);
    }
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }
    
    cache(key, value = null, ttl = 300000) { // TTL par défaut : 5 minutes
        if (value !== null) {
            // Sauvegarder en cache
            this.cache.set(key, {
                value: value,
                expires: Date.now() + ttl
            });
            return value;
        } else {
            // Récupérer du cache
            const cached = this.cache.get(key);
            if (cached && cached.expires > Date.now()) {
                return cached.value;
            } else {
                this.cache.delete(key);
                return null;
            }
        }
    }
    
    clearCache() {
        this.cache.clear();
    }
    
    loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.head.appendChild(script);
        });
    }
    
    loadCSS(href) {
        return new Promise((resolve, reject) => {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = href;
            link.onload = resolve;
            link.onerror = reject;
            document.head.appendChild(link);
        });
    }
    
    exportData(data, filename, format = 'json') {
        let content, mimeType;
        
        switch (format) {
            case 'json':
                content = JSON.stringify(data, null, 2);
                mimeType = 'application/json';
                break;
            case 'csv':
                content = this.jsonToCSV(data);
                mimeType = 'text/csv';
                break;
            default:
                throw new Error('Format non supporté');
        }
        
        const blob = new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        
        const link = document.createElement('a');
        link.href = url;
        link.download = `${filename}.${format}`;
        link.click();
        
        URL.revokeObjectURL(url);
    }
    
    jsonToCSV(data) {
        if (!Array.isArray(data) || data.length === 0) {
            return '';
        }
        
        const headers = Object.keys(data[0]);
        const csvContent = [
            headers.join(','),
            ...data.map(row => 
                headers.map(header => 
                    JSON.stringify(row[header] || '')
                ).join(',')
            )
        ].join('\n');
        
        return csvContent;
    }
    
    generateReport() {
        const reportData = {
            timestamp: new Date().toISOString(),
            contextId: $('#contextId').val(),
            formData: this.collectFormState().formData,
            metadata: {
                userAgent: navigator.userAgent,
                language: navigator.language,
                platform: navigator.platform
            }
        };
        
        // Ajouter les données spécifiques
        if (window.gestionDommagesProxinistreB2B) {
            reportData.dommages = window.gestionDommagesProxinistreB2B.exportDommagesData();
        }
        
        if (window.assistantSignatureProxinistreB2B) {
            reportData.signature = window.assistantSignatureProxinistreB2B.exportSignatureData();
        }
        
        if (window.regionsProxinistreB2B) {
            reportData.regions = window.regionsProxinistreB2B.getSelectedRegions();
        }
        
        return reportData;
    }
    
    printSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (!section) {
            alert('Section introuvable');
            return;
        }
        
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Impression - Proxinistre B2B</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .no-print { display: none !important; }
                        @media print {
                            body { margin: 0; }
                            .page-break { page-break-before: always; }
                        }
                    </style>
                </head>
                <body>
                    ${section.innerHTML}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
    
    showModal(title, content, size = 'modal-lg') {
        const modalId = 'utilModal_' + Date.now();
        const modalHtml = `
            <div class="modal fade" id="${modalId}" tabindex="-1">
                <div class="modal-dialog ${size}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            ${content}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modalHtml);
        $(`#${modalId}`).modal('show');
        
        // Auto-suppression à la fermeture
        $(`#${modalId}`).on('hidden.bs.modal', function() {
            $(this).remove();
        });
        
        return modalId;
    }
    
    confirm(message, title = 'Confirmation') {
        return new Promise((resolve) => {
            const modalId = 'confirmModal_' + Date.now();
            const modalHtml = `
                <div class="modal fade" id="${modalId}" tabindex="-1" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${title}</h5>
                            </div>
                            <div class="modal-body">
                                ${message}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-result="false" data-dismiss="modal">Annuler</button>
                                <button type="button" class="btn btn-primary" data-result="true" data-dismiss="modal">Confirmer</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalHtml);
            
            $(`#${modalId}`).on('click', '[data-result]', function() {
                const result = $(this).data('result') === 'true';
                resolve(result);
            });
            
            $(`#${modalId}`).on('hidden.bs.modal', function() {
                $(this).remove();
            });
            
            $(`#${modalId}`).modal('show');
        });
    }
    
    getUrlParams() {
        const params = new URLSearchParams(window.location.search);
        const result = {};
        for (const [key, value] of params) {
            result[key] = value;
        }
        return result;
    }
    
    updateUrl(params, replace = false) {
        const url = new URL(window.location);
        Object.keys(params).forEach(key => {
            if (params[key] !== null && params[key] !== undefined) {
                url.searchParams.set(key, params[key]);
            } else {
                url.searchParams.delete(key);
            }
        });
        
        if (replace) {
            window.history.replaceState({}, '', url);
        } else {
            window.history.pushState({}, '', url);
        }
    }
}

// Fonctions utilitaires globales
function formatCurrency(value) {
    return window.utilitairesProxinistreB2B?.utils.formatters.currency(value) || value;
}

function formatDate(date) {
    return window.utilitairesProxinistreB2B?.utils.formatters.date(date) || date;
}

function validateEmail(email) {
    return window.utilitairesProxinistreB2B?.utils.validators.email(email) || false;
}

function showToast(message, type, duration) {
    if (window.utilitairesProxinistreB2B) {
        window.utilitairesProxinistreB2B.showToast(message, type, duration);
    }
}

function generateReference(prefix) {
    return window.utilitairesProxinistreB2B?.utils.generators.reference(prefix) || '';
}

// Initialisation
$(document).ready(function() {
    window.utilitairesProxinistreB2B = new UtilitairesProxinistreB2B();
    
    // Restaurer l'état si un contextId est présent
    const contextId = $('#contextId').val();
    if (contextId) {
        window.utilitairesProxinistreB2B.restoreState(contextId);
    }
});

// Sauvegarde avant déchargement
$(window).on('beforeunload', function() {
    if (window.utilitairesProxinistreB2B) {
        window.utilitairesProxinistreB2B.saveState();
    }
});
</script>
