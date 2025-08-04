<script>
// Gestion des disponibilités pour Proxinistre B2B
class DisponibilitesProxinistreB2B {
    constructor() {
        this.horaires = [];
        this.nTaille = 0;
        this.commercialRDV = '';
        this.dateRDV = '';
        this.heureDebutRDV = '';
        this.heureFinRDV = '';
        this.idCommercialRDV = '';
        this.init();
    }
    
    init() {
        this.bindEvents();
    }
    
    bindEvents() {
        $(document).on('click', '.commercial-dispo', (e) => this.selectCommercial(e));
        $(document).on('click', '.ntdClass', (e) => this.selectHoraire(e));
    }
    
    loadDisponibilites(commercial, date) {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getDisponibilites,
            method: 'POST',
            data: {
                commercial: commercial,
                date: date,
                action: 'getDisponibilites'
            },
            success: (response) => {
                const data = JSON.parse(response);
                this.displayDisponibilites(data);
            },
            error: () => {
                alert('Erreur lors du chargement des disponibilités');
            }
        });
    }
    
    displayDisponibilites(data) {
        this.horaires = data.horaires || [];
        this.nTaille = this.horaires.length;
        
        if (this.nTaille > 0) {
            this.afficheNewTable(data.nomCommercial, data.date, data.duree);
        } else {
            $('#divTabHoraire').html('<p class="text-danger">Aucune disponibilité pour cette date.</p>');
        }
    }
    
    afficheNewTable(nomCommercial, date, duree) {
        $('#divTabHoraire').empty();
        
        let html = `
            <div class="font-weight-bold">
                <span class="text-center text-danger">2. Veuillez sélectionner l'heure de disponibilité</span>
            </div>
            <table style="font-weight:bold; font-size:15px; margin-top: 20px" id="table" border="1" width="100%" cellpadding="10px">
                <tr>
                    <th colspan="${this.nTaille}">DISPONIBILITÉS DE ${nomCommercial} à la date du ${date}</th>
                </tr>
        `;
        
        html += `<tr class="ntr" style="background-color: lightgray">`;
        for (let i = 0; i < this.nTaille; i++) {
            html += `<td class="ntdClass" align="center" id="cel${i}" value="${i}">${this.horaires[i]}</td>`;
        }
        html += `</tr></table>`;
        
        $('#divTabHoraire').append(html);
    }
    
    selectCommercial(e) {
        const button = $(e.target);
        const commercial = button.data('commercial');
        const date = button.data('date');
        const idCommercial = button.data('id');
        
        this.idCommercialRDV = idCommercial;
        this.loadDisponibilites(commercial, date);
        
        // Mettre à jour l'affichage
        $('.commercial-dispo').removeClass('selected');
        button.addClass('selected');
    }
    
    selectHoraire(e) {
        const cell = $(e.target);
        const horaire = cell.text().trim();
        
        // Mise à jour visuelle
        $('.ntr > td').css('background-color', 'lightgray');
        cell.css('background-color', '#e74a3b');
        
        // Extraction des heures
        const heures = horaire.split('-');
        this.heureDebutRDV = heures[0];
        this.heureFinRDV = heures[1];
        
        // Mise à jour des informations de RDV
        this.updateRDVInfo();
    }
    
    updateRDVInfo() {
        if (this.idCommercialRDV !== "0" && this.commercialRDV && this.dateRDV && this.heureDebutRDV && this.heureFinRDV) {
            const infoText = `RDV à prendre pour ${this.commercialRDV} le ${this.dateRDV} de ${this.heureDebutRDV} à ${this.heureFinRDV}`;
            
            $('#INFO_RDV').text(infoText);
            $('#expertRV').val(this.commercialRDV);
            $('#idExpertRV').val(this.idCommercialRDV);
            $('#dateRV').val(this.dateRDV.split(' ')[1]);
            $('#heureRV').val(this.heureDebutRDV);
            $('#divPriseRvRT').removeAttr('hidden');
        }
    }
    
    getRDVData() {
        return {
            commercial: this.commercialRDV,
            date: this.dateRDV,
            heureDebut: this.heureDebutRDV,
            heureFin: this.heureFinRDV,
            idCommercial: this.idCommercialRDV
        };
    }
    
    setRDVData(data) {
        this.commercialRDV = data.commercial || '';
        this.dateRDV = data.date || '';
        this.heureDebutRDV = data.heureDebut || '';
        this.heureFinRDV = data.heureFin || '';
        this.idCommercialRDV = data.idCommercial || '';
        this.updateRDVInfo();
    }
}

// Variables globales pour compatibilité
let horaires = [];
let nTaille = 0;
let commercialRDV = '';
let dateRDV = '';
let heureDebutRDV = '';
let heureFinRDV = '';
let idCommercialRDV = '';

// Initialisation
$(document).ready(function() {
    window.disponibilitesProxinistreB2B = new DisponibilitesProxinistreB2B();
});
</script>
