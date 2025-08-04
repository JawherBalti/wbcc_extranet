<script>
// Gestion AJAX pour Proxinistre B2B
class AjaxProxinistreB2B {
    constructor() {
        this.init();
    }
    
    init() {
        this.setupAjaxDefaults();
        this.bindEvents();
    }
    
    setupAjaxDefaults() {
        $.ajaxSetup({
            timeout: 30000,
            error: (xhr, status, error) => {
                console.error('Erreur AJAX:', error);
                this.handleAjaxError(xhr, status, error);
            }
        });
    }
    
    bindEvents() {
        $(document).on('click', '#btnSaveScript', () => this.saveScript());
        $(document).on('click', '#btnLoadScript', () => this.loadScript());
        $(document).on('click', '#btnSendDocumentation', () => this.sendDocumentation());
    }
    
    saveScript() {
        const formData = this.collectFormData();
        
        this.showLoader('Sauvegarde en cours...');
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.saveScript,
            method: 'POST',
            data: {
                ...formData,
                action: 'saveScript'
            },
            success: (response) => {
                this.hideLoader();
                const result = JSON.parse(response);
                if (result.success) {
                    this.showSuccess('Script sauvegardé avec succès');
                } else {
                    this.showError('Erreur lors de la sauvegarde: ' + result.message);
                }
            },
            error: () => {
                this.hideLoader();
                this.showError('Erreur lors de la sauvegarde');
            }
        });
    }
    
    loadScript() {
        const contextId = $('#contextId').val();
        
        if (!contextId) {
            this.showError('Aucun contexte sélectionné');
            return;
        }
        
        this.showLoader('Chargement en cours...');
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.loadScript,
            method: 'POST',
            data: {
                contextId: contextId,
                action: 'loadScript'
            },
            success: (response) => {
                this.hideLoader();
                const result = JSON.parse(response);
                if (result.success) {
                    this.populateForm(result.data);
                    this.showSuccess('Script chargé avec succès');
                } else {
                    this.showError('Erreur lors du chargement: ' + result.message);
                }
            },
            error: () => {
                this.hideLoader();
                this.showError('Erreur lors du chargement');
            }
        });
    }
    
    sendDocumentation() {
        const emailData = this.collectEmailData();
        
        if (!this.validateEmailData(emailData)) {
            return;
        }
        
        this.showLoader('Envoi en cours...');
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.sendDocumentation,
            method: 'POST',
            data: {
                ...emailData,
                action: 'sendDocumentation'
            },
            success: (response) => {
                this.hideLoader();
                const result = JSON.parse(response);
                if (result.success) {
                    this.showSuccess('Documentation envoyée avec succès');
                    $('#modalEnvoiDoc').modal('hide');
                } else {
                    this.showError('Erreur lors de l\'envoi: ' + result.message);
                }
            },
            error: () => {
                this.hideLoader();
                this.showError('Erreur lors de l\'envoi de la documentation');
            }
        });
    }
    
    collectFormData() {
        const data = {};
        
        // Collecter tous les champs du formulaire
        $('#scriptForm').find('input, select, textarea').each(function() {
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
        
        // Ajouter les données spécifiques
        data.contextId = $('#contextId').val();
        data.contextType = $('#contextType').val();
        
        // Ajouter les régions sélectionnées
        if (window.regionsProxinistreB2B) {
            data.regions = JSON.stringify(window.regionsProxinistreB2B.getSelectedRegions());
        }
        
        // Ajouter les données RDV
        if (window.rdvProxinistreB2B) {
            data.rdv = JSON.stringify(window.rdvProxinistreB2B.getRDVData());
        }
        
        return data;
    }
    
    collectEmailData() {
        return {
            destinataire: $('#emailDestinataire').val(),
            objet: $('#objetMailEnvoiDoc').val(),
            contenu: $('#bodyMailEnvoiDoc').val(),
            signature: $('#signatureMail').val(),
            contextId: $('#contextId').val()
        };
    }
    
    validateEmailData(data) {
        if (!data.destinataire) {
            this.showError('Veuillez saisir l\'adresse email du destinataire');
            return false;
        }
        
        if (!data.objet) {
            this.showError('Veuillez saisir l\'objet du mail');
            return false;
        }
        
        if (!data.contenu) {
            this.showError('Veuillez saisir le contenu du mail');
            return false;
        }
        
        // Validation de l'email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.destinataire)) {
            this.showError('Veuillez saisir une adresse email valide');
            return false;
        }
        
        return true;
    }
    
    populateForm(data) {
        // Remplir les champs du formulaire
        Object.keys(data).forEach(key => {
            const field = $(`[name="${key}"]`);
            if (field.length > 0) {
                if (field.is(':radio')) {
                    field.filter(`[value="${data[key]}"]`).prop('checked', true);
                } else if (field.is(':checkbox')) {
                    field.prop('checked', data[key] === '1' || data[key] === true);
                } else {
                    field.val(data[key]);
                }
            }
        });
        
        // Restaurer les régions
        if (data.regions && window.regionsProxinistreB2B) {
            try {
                const regions = JSON.parse(data.regions);
                window.regionsProxinistreB2B.setSelectedRegions(regions);
            } catch (e) {
                console.error('Erreur lors du parsing des régions:', e);
            }
        }
        
        // Restaurer les données RDV
        if (data.rdv && window.rdvProxinistreB2B) {
            try {
                const rdv = JSON.parse(data.rdv);
                window.rdvProxinistreB2B.setRDVData(rdv);
            } catch (e) {
                console.error('Erreur lors du parsing du RDV:', e);
            }
        }
        
        // Mettre à jour l'interface
        if (window.interactionsProxinistreB2B) {
            window.interactionsProxinistreB2B.highlightActiveOptions();
        }
    }
    
    showLoader(message = 'Chargement...') {
        if ($('#ajax-loader').length === 0) {
            $('body').append(`
                <div id="ajax-loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                     background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                    <div style="background: white; padding: 20px; border-radius: 5px;">
                        <i class="fas fa-spinner fa-spin"></i> ${message}
                    </div>
                </div>
            `);
        }
    }
    
    hideLoader() {
        $('#ajax-loader').remove();
    }
    
    showSuccess(message) {
        this.showNotification(message, 'success');
    }
    
    showError(message) {
        this.showNotification(message, 'error');
    }
    
    showNotification(message, type = 'info') {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const notification = $(`
            <div class="alert ${alertClass} alert-dismissible fade show" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `);
        
        $('body').append(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.fadeOut(() => notification.remove());
        }, 5000);
    }
    
    handleAjaxError(xhr, status, error) {
        this.hideLoader();
        
        let message = 'Une erreur est survenue';
        if (status === 'timeout') {
            message = 'La requête a expiré. Veuillez réessayer.';
        } else if (xhr.status === 403) {
            message = 'Accès refusé. Veuillez vous reconnecter.';
        } else if (xhr.status === 404) {
            message = 'Service non trouvé.';
        } else if (xhr.status >= 500) {
            message = 'Erreur serveur. Veuillez réessayer plus tard.';
        }
        
        this.showError(message);
    }
}

// Fonctions globales pour compatibilité
function saveScript() {
    if (window.ajaxProxinistreB2B) {
        window.ajaxProxinistreB2B.saveScript();
    }
}

function loadScript() {
    if (window.ajaxProxinistreB2B) {
        window.ajaxProxinistreB2B.loadScript();
    }
}

function sendDocumentation() {
    if (window.ajaxProxinistreB2B) {
        window.ajaxProxinistreB2B.sendDocumentation();
    }
}

// Initialisation
$(document).ready(function() {
    window.ajaxProxinistreB2B = new AjaxProxinistreB2B();
});
</script>
