<script>
// Assistant signature pour Proxinistre B2B
class AssistantSignatureProxinistreB2B {
    constructor() {
        this.signatureData = null;
        this.documentTypes = {};
        this.mandatData = {};
        this.init();
    }
    
    init() {
        this.setupDocumentTypes();
        this.bindEvents();
        this.initSignaturePad();
    }
    
    setupDocumentTypes() {
        this.documentTypes = {
            'mandat': {
                title: 'Mandat de représentation',
                description: 'Autorisation pour représenter vos intérêts auprès de votre assureur',
                required: true
            },
            'declaration': {
                title: 'Déclaration de sinistre',
                description: 'Document officiel de déclaration du sinistre',
                required: false
            },
            'estimation': {
                title: 'Accord d\'estimation',
                description: 'Validation des coûts estimés pour les réparations',
                required: false
            },
            'travaux': {
                title: 'Autorisation de travaux',
                description: 'Autorisation pour démarrer les travaux de réparation',
                required: false
            }
        };
    }
    
    bindEvents() {
        $(document).on('click', '#btnSignature', () => this.openSignatureModal());
        $(document).on('click', '#btnClearSignature', () => this.clearSignature());
        $(document).on('click', '#btnValidateSignature', () => this.validateSignature());
        $(document).on('click', '#btnGenerateMandat', () => this.generateMandat());
        $(document).on('change', '#signatureType', (e) => this.onSignatureTypeChange(e));
        $(document).on('click', '.btn-preview-document', (e) => this.previewDocument(e));
    }
    
    openSignatureModal() {
        const modalHtml = this.createSignatureModal();
        $('body').append(modalHtml);
        $('#signatureModal').modal('show');
        
        // Réinitialiser le pad de signature
        setTimeout(() => {
            this.initSignaturePad();
        }, 500);
    }
    
    createSignatureModal() {
        return `
            <div class="modal fade" id="signatureModal" tabindex="-1" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-pen-alt"></i> Signature électronique
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Type de document</label>
                                        <select class="form-control" id="signatureType">
                                            <option value="">Sélectionner le type</option>
                                            ${Object.keys(this.documentTypes).map(key => 
                                                `<option value="${key}">${this.documentTypes[key].title}</option>`
                                            ).join('')}
                                        </select>
                                        <small class="text-muted" id="typeDescription"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nom du signataire</label>
                                        <input type="text" class="form-control" id="signataireName" 
                                               value="${$('input[name="name"]').val() || ''}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="signature-section">
                                <label>Signature</label>
                                <div class="signature-container border rounded p-2" style="background: #f8f9fa;">
                                    <canvas id="signaturePad" width="650" height="200" 
                                            style="border: 1px dashed #ccc; background: white; cursor: crosshair;"></canvas>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-secondary" id="btnClearSignature">
                                        <i class="fas fa-eraser"></i> Effacer
                                    </button>
                                    <small class="text-muted ml-3">Signez dans la zone ci-dessus</small>
                                </div>
                            </div>
                            
                            <div class="legal-section mt-3">
                                <div class="alert alert-info">
                                    <small>
                                        <strong>Information légale :</strong> En signant ce document électroniquement, 
                                        vous acceptez que cette signature ait la même valeur juridique qu'une signature manuscrite 
                                        conformément à la réglementation européenne eIDAS.
                                    </small>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="acceptTerms" required>
                                    <label class="form-check-label" for="acceptTerms">
                                        J'accepte les conditions d'utilisation et confirme l'authenticité de ma signature
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success" id="btnValidateSignature">
                                <i class="fas fa-check"></i> Valider la signature
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    initSignaturePad() {
        const canvas = document.getElementById('signaturePad');
        if (!canvas) return;
        
        const ctx = canvas.getContext('2d');
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;
        
        // Configuration du style
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        
        // Events pour souris
        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            lastX = e.clientX - rect.left;
            lastY = e.clientY - rect.top;
        });
        
        canvas.addEventListener('mousemove', (e) => {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            const currentX = e.clientX - rect.left;
            const currentY = e.clientY - rect.top;
            
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(currentX, currentY);
            ctx.stroke();
            
            lastX = currentX;
            lastY = currentY;
        });
        
        canvas.addEventListener('mouseup', () => {
            isDrawing = false;
        });
        
        // Events pour touch (mobile)
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const rect = canvas.getBoundingClientRect();
            lastX = touch.clientX - rect.left;
            lastY = touch.clientY - rect.top;
            isDrawing = true;
        });
        
        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            if (!isDrawing) return;
            const touch = e.touches[0];
            const rect = canvas.getBoundingClientRect();
            const currentX = touch.clientX - rect.left;
            const currentY = touch.clientY - rect.top;
            
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(currentX, currentY);
            ctx.stroke();
            
            lastX = currentX;
            lastY = currentY;
        });
        
        canvas.addEventListener('touchend', () => {
            isDrawing = false;
        });
        
        this.signaturePad = canvas;
    }
    
    clearSignature() {
        if (this.signaturePad) {
            const ctx = this.signaturePad.getContext('2d');
            ctx.clearRect(0, 0, this.signaturePad.width, this.signaturePad.height);
        }
    }
    
    onSignatureTypeChange(e) {
        const type = $(e.target).val();
        const description = this.documentTypes[type]?.description || '';
        $('#typeDescription').text(description);
        
        if (type === 'mandat') {
            this.showMandatFields();
        } else {
            this.hideMandatFields();
        }
    }
    
    showMandatFields() {
        if ($('#mandatFields').length === 0) {
            const mandatHtml = `
                <div id="mandatFields" class="mt-3 p-3 border rounded bg-light">
                    <h6>Informations pour le mandat</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Numéro de police d'assurance</label>
                                <input type="text" class="form-control" id="policeNumber" 
                                       placeholder="Ex: 123456789">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Compagnie d'assurance</label>
                                <input type="text" class="form-control" id="insuranceCompany" 
                                       placeholder="Nom de votre assureur">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Étendue du mandat</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mandatNegociation" checked>
                            <label class="form-check-label" for="mandatNegociation">
                                Négociation avec l'assureur
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mandatExpertise" checked>
                            <label class="form-check-label" for="mandatExpertise">
                                Assistance lors de l'expertise
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="mandatTravaux">
                            <label class="form-check-label" for="mandatTravaux">
                                Coordination des travaux
                            </label>
                        </div>
                    </div>
                </div>
            `;
            $('#signatureModal .signature-section').before(mandatHtml);
        }
    }
    
    hideMandatFields() {
        $('#mandatFields').remove();
    }
    
    validateSignature() {
        // Vérifications
        if (!this.isSignatureValid()) {
            alert('Veuillez signer dans la zone prévue à cet effet.');
            return;
        }
        
        const signataireName = $('#signataireName').val().trim();
        if (!signataireName) {
            alert('Veuillez saisir le nom du signataire.');
            return;
        }
        
        const signatureType = $('#signatureType').val();
        if (!signatureType) {
            alert('Veuillez sélectionner le type de document.');
            return;
        }
        
        if (!$('#acceptTerms').is(':checked')) {
            alert('Veuillez accepter les conditions d\'utilisation.');
            return;
        }
        
        // Sauvegarder la signature
        this.saveSignature(signatureType, signataireName);
    }
    
    isSignatureValid() {
        if (!this.signaturePad) return false;
        
        const ctx = this.signaturePad.getContext('2d');
        const imageData = ctx.getImageData(0, 0, this.signaturePad.width, this.signaturePad.height);
        
        // Vérifier s'il y a des pixels non blancs
        for (let i = 0; i < imageData.data.length; i += 4) {
            if (imageData.data[i] !== 255 || imageData.data[i + 1] !== 255 || imageData.data[i + 2] !== 255) {
                return true; // Il y a du contenu
            }
        }
        return false;
    }
    
    saveSignature(type, signataireName) {
        const signatureDataUrl = this.signaturePad.toDataURL();
        const timestamp = new Date().toISOString();
        
        this.signatureData = {
            type: type,
            signataire: signataireName,
            signature: signatureDataUrl,
            timestamp: timestamp,
            ip: this.getClientIP(), // Fonction à implémenter
            userAgent: navigator.userAgent
        };
        
        // Collecter les données spécifiques selon le type
        if (type === 'mandat') {
            this.mandatData = {
                policeNumber: $('#policeNumber').val(),
                insuranceCompany: $('#insuranceCompany').val(),
                negociation: $('#mandatNegociation').is(':checked'),
                expertise: $('#mandatExpertise').is(':checked'),
                travaux: $('#mandatTravaux').is(':checked')
            };
        }
        
        // Envoyer au serveur
        this.sendSignatureToServer();
    }
    
    sendSignatureToServer() {
        const data = {
            signatureData: this.signatureData,
            mandatData: this.mandatData,
            contextId: $('#contextId').val(),
            action: 'saveSignature'
        };
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.saveSignature,
            method: 'POST',
            data: data,
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    this.onSignatureSaved(result);
                } else {
                    alert('Erreur lors de la sauvegarde : ' + result.message);
                }
            },
            error: () => {
                alert('Erreur lors de la sauvegarde de la signature');
            }
        });
    }
    
    onSignatureSaved(result) {
        alert('Signature enregistrée avec succès !');
        $('#signatureModal').modal('hide');
        
        // Mettre à jour l'interface
        this.updateSignatureDisplay();
        
        // Générer le document si c'est un mandat
        if (this.signatureData.type === 'mandat') {
            this.generateMandat();
        }
    }
    
    updateSignatureDisplay() {
        const container = $('#signature-status');
        if (container.length === 0) {
            $('#scriptForm').append('<div id="signature-status"></div>');
        }
        
        const signatureHtml = `
            <div class="alert alert-success">
                <h6><i class="fas fa-check-circle"></i> Document signé</h6>
                <p><strong>Type :</strong> ${this.documentTypes[this.signatureData.type].title}</p>
                <p><strong>Signataire :</strong> ${this.signatureData.signataire}</p>
                <p><strong>Date :</strong> ${new Date(this.signatureData.timestamp).toLocaleString()}</p>
                <button type="button" class="btn btn-sm btn-info btn-preview-document" 
                        data-type="${this.signatureData.type}">
                    <i class="fas fa-eye"></i> Aperçu
                </button>
            </div>
        `;
        
        $('#signature-status').html(signatureHtml);
    }
    
    generateMandat() {
        if (!this.signatureData || this.signatureData.type !== 'mandat') {
            alert('Aucun mandat signé trouvé.');
            return;
        }
        
        const mandatHtml = this.createMandatDocument();
        this.showDocumentPreview('Mandat de représentation', mandatHtml);
    }
    
    createMandatDocument() {
        const today = new Date().toLocaleDateString('fr-FR');
        const company = this.getCompanyData();
        
        return `
            <div class="mandat-document p-4" style="font-family: Arial, sans-serif; max-width: 800px;">
                <div class="header text-center mb-4">
                    <h2>MANDAT DE REPRÉSENTATION</h2>
                    <p class="text-muted">SOS Sinistre - Gestion de sinistres immobiliers</p>
                </div>
                
                <div class="content">
                    <p><strong>Date :</strong> ${today}</p>
                    
                    <h4>MANDANT</h4>
                    <p>
                        <strong>Nom/Dénomination :</strong> ${company.name || this.signatureData.signataire}<br>
                        <strong>Adresse :</strong> ${company.address || 'À compléter'}<br>
                        <strong>Téléphone :</strong> ${company.phone || 'À compléter'}<br>
                        <strong>Email :</strong> ${company.email || 'À compléter'}
                    </p>
                    
                    <h4>MANDATAIRE</h4>
                    <p>
                        <strong>Société :</strong> SOS Sinistre<br>
                        <strong>Représentée par :</strong> ${window.connectedUser?.fullName || 'Expert SOS Sinistre'}
                    </p>
                    
                    <h4>OBJET DU MANDAT</h4>
                    <p>Le mandant donne mandat au mandataire pour :</p>
                    <ul>
                        ${this.mandatData.negociation ? '<li>Négocier avec la compagnie d\'assurance</li>' : ''}
                        ${this.mandatData.expertise ? '<li>L\'assister lors de l\'expertise</li>' : ''}
                        ${this.mandatData.travaux ? '<li>Coordonner les travaux de réparation</li>' : ''}
                    </ul>
                    
                    <h4>ASSURANCE</h4>
                    <p>
                        <strong>Compagnie :</strong> ${this.mandatData.insuranceCompany || 'À préciser'}<br>
                        <strong>Police n° :</strong> ${this.mandatData.policeNumber || 'À préciser'}
                    </p>
                    
                    <h4>SIGNATURE</h4>
                    <div class="signature-section mt-4">
                        <p><strong>Le mandant :</strong></p>
                        <p>Date : ${new Date(this.signatureData.timestamp).toLocaleDateString('fr-FR')}</p>
                        <img src="${this.signatureData.signature}" style="max-width: 200px; border: 1px solid #ccc;">
                        <p><strong>Nom :</strong> ${this.signatureData.signataire}</p>
                    </div>
                </div>
            </div>
        `;
    }
    
    showDocumentPreview(title, content) {
        const modalHtml = `
            <div class="modal fade" id="documentPreviewModal" tabindex="-1">
                <div class="modal-dialog modal-xl">
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
                            <button type="button" class="btn btn-primary" onclick="window.print()">
                                <i class="fas fa-print"></i> Imprimer
                            </button>
                            <button type="button" class="btn btn-success" onclick="window.assistantSignatureProxinistreB2B.downloadPDF('${title}')">
                                <i class="fas fa-download"></i> Télécharger PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#documentPreviewModal').remove();
        $('body').append(modalHtml);
        $('#documentPreviewModal').modal('show');
    }
    
    previewDocument(e) {
        const type = $(e.target).data('type');
        
        if (type === 'mandat') {
            this.generateMandat();
        } else {
            alert('Aperçu non disponible pour ce type de document.');
        }
    }
    
    downloadPDF(title) {
        // Simulation du téléchargement PDF
        // À implémenter avec une vraie librairie PDF côté serveur
        alert('Fonctionnalité de téléchargement PDF à implémenter');
    }
    
    getCompanyData() {
        return {
            name: $('input[name="name"]').val(),
            address: $('input[name="businessLine1"]').val(),
            phone: $('input[name="businessPhone"]').val(),
            email: $('input[name="email"]').val()
        };
    }
    
    getClientIP() {
        // Cette fonction devrait être implémentée côté serveur
        return 'IP à déterminer';
    }
    
    exportSignatureData() {
        return {
            signature: this.signatureData,
            mandat: this.mandatData
        };
    }
}

// Nettoyage modal à la fermeture
$(document).on('hidden.bs.modal', '#signatureModal', function() {
    $(this).remove();
});

// Initialisation
$(document).ready(function() {
    window.assistantSignatureProxinistreB2B = new AssistantSignatureProxinistreB2B();
});
</script>
