<script>
// Gestion des RDV pour Proxinistre B2B
class RDVProxinistreB2B {
    constructor() {
        this.rdvData = {};
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        $(document).on('click', '#btnConfirmerRDV', () => this.confirmerRDV());
        $(document).on('click', '#btnAnnulerRDV', () => this.annulerRDV());
        $(document).on('change', '#dateRDV', (e) => this.onDateChange(e));
        $(document).on('change', '#expertRV', (e) => this.onExpertChange(e));
    }
    
    confirmerRDV() {
        const rdvData = this.collectRDVData();
        
        if (this.validateRDV(rdvData)) {
            this.saveRDV(rdvData);
        }
    }
    
    annulerRDV() {
        this.clearRDV();
        $('#divPriseRvRT').attr('hidden', true);
    }
    
    collectRDVData() {
        return {
            expert: $('#expertRV').val(),
            idExpert: $('#idExpertRV').val(),
            date: $('#dateRV').val(),
            heure: $('#heureRV').val(),
            commentaire: $('#commentaireRDV').val(),
            contextId: $('#contextId').val()
        };
    }
    
    validateRDV(data) {
        if (!data.expert || !data.date || !data.heure) {
            alert('Veuillez remplir tous les champs obligatoires pour le RDV.');
            return false;
        }
        return true;
    }
    
    saveRDV(data) {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.saveRDV,
            method: 'POST',
            data: {
                ...data,
                action: 'saveRDV'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    alert('RDV confirmé avec succès !');
                    this.onRDVSaved(data);
                } else {
                    alert('Erreur lors de la confirmation du RDV : ' + result.message);
                }
            },
            error: () => {
                alert('Erreur lors de la sauvegarde du RDV');
            }
        });
    }
    
    onRDVSaved(data) {
        this.rdvData = data;
        this.updateRDVDisplay();
        $('#divPriseRvRT').attr('hidden', true);
        
        // Passer à l'étape suivante si applicable
        if (window.interfaceProxinistreB2B) {
            window.interfaceProxinistreB2B.nextStep();
        }
    }
    
    updateRDVDisplay() {
        const rdv = this.rdvData;
        if (rdv.expert && rdv.date && rdv.heure) {
            const displayText = `RDV confirmé avec ${rdv.expert} le ${rdv.date} à ${rdv.heure}`;
            $('#rdv-display').html(`<div class="alert alert-success">${displayText}</div>`);
        }
    }
    
    clearRDV() {
        this.rdvData = {};
        $('#expertRV').val('');
        $('#idExpertRV').val('');
        $('#dateRV').val('');
        $('#heureRV').val('');
        $('#commentaireRDV').val('');
        $('#INFO_RDV').text('');
        $('#rdv-display').empty();
    }
    
    onDateChange(e) {
        const date = $(e.target).val();
        const expert = $('#expertRV').val();
        
        if (date && expert) {
            // Recharger les disponibilités pour cette date
            if (window.disponibilitesProxinistreB2B) {
                window.disponibilitesProxinistreB2B.loadDisponibilites(expert, date);
            }
        }
    }
    
    onExpertChange(e) {
        const expert = $(e.target).val();
        const date = $('#dateRDV').val();
        
        if (date && expert) {
            // Recharger les disponibilités pour cet expert
            if (window.disponibilitesProxinistreB2B) {
                window.disponibilitesProxinistreB2B.loadDisponibilites(expert, date);
            }
        }
    }
    
    getRDVData() {
        return this.rdvData;
    }
    
    setRDVData(data) {
        this.rdvData = data || {};
        this.updateRDVDisplay();
    }
    
    loadRDVForContext(contextId) {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.loadRDV,
            method: 'POST',
            data: {
                contextId: contextId,
                action: 'loadRDV'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success && result.rdv) {
                    this.setRDVData(result.rdv);
                }
            },
            error: () => {
                console.error('Erreur lors du chargement du RDV');
            }
        });
    }
}

// Fonctions globales pour compatibilité
function confirmerRDV() {
    if (window.rdvProxinistreB2B) {
        window.rdvProxinistreB2B.confirmerRDV();
    }
}

function annulerRDV() {
    if (window.rdvProxinistreB2B) {
        window.rdvProxinistreB2B.annulerRDV();
    }
}

// Initialisation
$(document).ready(function() {
    window.rdvProxinistreB2B = new RDVProxinistreB2B();
    
    // Charger le RDV existant si un contextId est présent
    const contextId = $('#contextId').val();
    if (contextId) {
        window.rdvProxinistreB2B.loadRDVForContext(contextId);
    }
});
</script>
