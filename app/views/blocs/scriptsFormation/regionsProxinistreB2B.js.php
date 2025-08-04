<script>
// Gestion des régions pour Proxinistre B2B
class RegionsProxinistreB2B {
    constructor() {
        this.regionsChoosed = [];
        this.init();
    }
    
    init() {
        this.getRegionsFrance();
        this.bindEvents();
    }
    
    bindEvents() {
        $(document).on('change', '#inputRegionsFrance', (e) => this.addRegion(e));
        $(document).on('click', '.remove-region', (e) => this.removeRegion(e));
    }
    
    getRegionsFrance() {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getRegions,
            method: 'GET',
            data: {
                action: 'getRegionsFrance'
            },
            success: (response) => {
                const regions = JSON.parse(response);
                this.populateRegionsSelect(regions);
            },
            error: () => {
                console.error('Erreur lors du chargement des régions');
            }
        });
    }
    
    populateRegionsSelect(regions) {
        let optionsHtml = '<option value="">--Choisir--</option>';
        regions.forEach(region => {
            const alreadyAdded = this.regionsChoosed.some(item => item[0] === region.code);
            if (!alreadyAdded) {
                optionsHtml += `<option value="${region.code}">${region.nom}</option>`;
            }
        });
        $('#inputRegionsFrance').html(optionsHtml);
    }
    
    addRegion(e) {
        const select = $(e.target);
        const regionCode = select.val();
        const regionName = select.find('option:selected').text();
        
        if (regionCode && regionName !== '--Choisir--') {
            this.regionsChoosed.push([regionCode, regionName]);
            this.updateRegionsDisplay();
            this.getRegionsFrance(); // Refresh the list
        }
    }
    
    removeRegion(e) {
        const button = $(e.target);
        const regionCode = button.data('region-code');
        
        this.regionsChoosed = this.regionsChoosed.filter(region => region[0] !== regionCode);
        this.updateRegionsDisplay();
        this.getRegionsFrance(); // Refresh the list
    }
    
    updateRegionsDisplay() {
        const container = $('#selected-regions');
        container.empty();
        
        this.regionsChoosed.forEach(region => {
            const regionHtml = `
                <div class="region-tag">
                    <span>${region[1]}</span>
                    <button type="button" class="remove-region" data-region-code="${region[0]}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.append(regionHtml);
        });
        
        // Mettre à jour les champs cachés pour la soumission
        this.updateHiddenFields();
    }
    
    updateHiddenFields() {
        const regionsJson = JSON.stringify(this.regionsChoosed);
        $('#regions-data').val(regionsJson);
    }
    
    getSelectedRegions() {
        return this.regionsChoosed;
    }
    
    setSelectedRegions(regions) {
        this.regionsChoosed = regions || [];
        this.updateRegionsDisplay();
        this.getRegionsFrance();
    }
}

// Variables globales pour les régions
let regionsChoosed = [];

// Initialisation
$(document).ready(function() {
    window.regionsProxinistreB2B = new RegionsProxinistreB2B();
});
</script>
