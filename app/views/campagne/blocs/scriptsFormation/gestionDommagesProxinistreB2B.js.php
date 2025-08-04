<script>
// Gestion des dommages pour Proxinistre B2B
class GestionDommagesProxinistreB2B {
    constructor() {
        this.dommagesData = {};
        this.photos = [];
        this.documentsUploaded = [];
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.setupFileUpload();
    }
    
    bindEvents() {
        $(document).on('click', '.btn-add-dommage', () => this.addDommage());
        $(document).on('click', '.btn-remove-dommage', (e) => this.removeDommage(e));
        $(document).on('change', '.dommage-type', (e) => this.onDommageTypeChange(e));
        $(document).on('click', '.btn-take-photo', (e) => this.takePhoto(e));
        $(document).on('change', '.file-upload', (e) => this.handleFileUpload(e));
        $(document).on('click', '.btn-estimate-cost', (e) => this.estimateCost(e));
    }
    
    addDommage() {
        const dommageId = 'dommage_' + Date.now();
        const dommageHtml = this.createDommageForm(dommageId);
        
        $('#dommages-container').append(dommageHtml);
        this.updateDommagesList();
    }
    
    createDommageForm(dommageId) {
        return `
            <div class="dommage-item border p-3 mb-3 rounded" data-dommage-id="${dommageId}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Dommage ${$('.dommage-item').length + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger btn-remove-dommage">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type de dommage</label>
                            <select class="form-control dommage-type" name="dommage_type_${dommageId}">
                                <option value="">Sélectionner...</option>
                                <option value="eau">Dégât des eaux</option>
                                <option value="feu">Dommage par le feu</option>
                                <option value="fumee">Dommage par la fumée</option>
                                <option value="bris">Bris/Casse</option>
                                <option value="vol">Vol/Effraction</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Zone affectée</label>
                            <input type="text" class="form-control" name="zone_${dommageId}" 
                                   placeholder="Ex: Salon, Cuisine, Plafond...">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description détaillée</label>
                            <textarea class="form-control" name="description_${dommageId}" rows="3"
                                      placeholder="Décrivez précisément les dommages constatés..."></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estimation des coûts (€)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="cout_estime_${dommageId}" 
                                       placeholder="0.00" step="0.01">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info btn-estimate-cost" 
                                            data-dommage-id="${dommageId}">
                                        Estimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urgence</label>
                            <select class="form-control" name="urgence_${dommageId}">
                                <option value="faible">Faible</option>
                                <option value="moyenne">Moyenne</option>
                                <option value="haute">Haute</option>
                                <option value="critique">Critique</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="photos-section mb-3">
                    <label>Photos du dommage</label>
                    <div class="d-flex flex-wrap align-items-center">
                        <button type="button" class="btn btn-outline-primary btn-sm btn-take-photo mr-2 mb-2" 
                                data-dommage-id="${dommageId}">
                            <i class="fas fa-camera"></i> Prendre une photo
                        </button>
                        <input type="file" class="file-upload d-none" accept="image/*" multiple 
                               data-dommage-id="${dommageId}">
                        <button type="button" class="btn btn-outline-secondary btn-sm mb-2" 
                                onclick="$(this).siblings('.file-upload').click()">
                            <i class="fas fa-upload"></i> Choisir fichiers
                        </button>
                    </div>
                    <div class="photos-preview-${dommageId} d-flex flex-wrap mt-2"></div>
                </div>
                
                <div class="documents-section">
                    <label>Documents associés</label>
                    <div class="documents-list-${dommageId}"></div>
                    <button type="button" class="btn btn-outline-info btn-sm" 
                            onclick="$(this).siblings('input[type=file]').click()">
                        <i class="fas fa-paperclip"></i> Ajouter document
                    </button>
                    <input type="file" class="d-none" accept=".pdf,.doc,.docx,.jpg,.png" 
                           onchange="window.gestionDommagesProxinistreB2B.handleDocumentUpload(event, '${dommageId}')">
                </div>
            </div>
        `;
    }
    
    removeDommage(e) {
        const dommageItem = $(e.target).closest('.dommage-item');
        const dommageId = dommageItem.data('dommage-id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer ce dommage ?')) {
            // Supprimer les fichiers associés
            this.removeAssociatedFiles(dommageId);
            
            // Supprimer l'élément DOM
            dommageItem.remove();
            
            // Mettre à jour la liste
            this.updateDommagesList();
            this.renumberDommages();
        }
    }
    
    onDommageTypeChange(e) {
        const select = $(e.target);
        const value = select.val();
        const dommageItem = select.closest('.dommage-item');
        
        // Ajouter des suggestions basées sur le type
        this.addTypeSuggestions(dommageItem, value);
    }
    
    addTypeSuggestions(dommageItem, type) {
        const suggestions = {
            'eau': ['Infiltration', 'Fuite canalisation', 'Débordement', 'Humidité'],
            'feu': ['Carbonisation', 'Noircissement', 'Déformation chaleur'],
            'fumee': ['Noircissement', 'Odeur persistante', 'Dépôts de suie'],
            'bris': ['Casse', 'Fissure', 'Éclatement', 'Détérioration'],
            'vol': ['Effraction', 'Vandalisme', 'Dégradation', 'Vol matériel']
        };
        
        const typeSuggestions = suggestions[type] || [];
        
        if (typeSuggestions.length > 0) {
            let suggestionsHtml = '<div class="suggestions mt-2"><small class="text-muted">Suggestions: ';
            typeSuggestions.forEach(suggestion => {
                suggestionsHtml += `<span class="badge badge-light suggestion-tag cursor-pointer mr-1">${suggestion}</span>`;
            });
            suggestionsHtml += '</small></div>';
            
            dommageItem.find('.suggestions').remove();
            dommageItem.find('.form-group').first().append(suggestionsHtml);
            
            // Bind click sur les suggestions
            dommageItem.find('.suggestion-tag').click(function() {
                const currentDesc = dommageItem.find('textarea').val();
                const newDesc = currentDesc ? `${currentDesc}, ${$(this).text()}` : $(this).text();
                dommageItem.find('textarea').val(newDesc);
            });
        }
    }
    
    takePhoto(e) {
        const dommageId = $(e.target).data('dommage-id');
        
        // Simuler la prise de photo (à remplacer par une vraie implémentation)
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            this.openCameraModal(dommageId);
        } else {
            // Fallback : ouvrir le sélecteur de fichier
            $(e.target).siblings('.file-upload').click();
        }
    }
    
    openCameraModal(dommageId) {
        const modalHtml = `
            <div class="modal fade" id="cameraModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Prendre une photo</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body text-center">
                            <video id="camera-preview" width="100%" height="300" autoplay></video>
                            <canvas id="photo-canvas" style="display: none;"></canvas>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-primary" onclick="window.gestionDommagesProxinistreB2B.capturePhoto('${dommageId}')">
                                <i class="fas fa-camera"></i> Capturer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modalHtml);
        $('#cameraModal').modal('show');
        
        // Démarrer la caméra
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                const video = document.getElementById('camera-preview');
                video.srcObject = stream;
            })
            .catch(err => {
                console.error('Erreur caméra:', err);
                alert('Impossible d\'accéder à la caméra');
                $('#cameraModal').modal('hide');
            });
        
        // Nettoyage à la fermeture
        $('#cameraModal').on('hidden.bs.modal', function() {
            const video = document.getElementById('camera-preview');
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
            }
            $(this).remove();
        });
    }
    
    capturePhoto(dommageId) {
        const video = document.getElementById('camera-preview');
        const canvas = document.getElementById('photo-canvas');
        const context = canvas.getContext('2d');
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0);
        
        // Convertir en blob
        canvas.toBlob(blob => {
            const file = new File([blob], `dommage_${dommageId}_${Date.now()}.jpg`, { type: 'image/jpeg' });
            this.addPhotoToPreview(dommageId, file);
            $('#cameraModal').modal('hide');
        }, 'image/jpeg', 0.8);
    }
    
    handleFileUpload(e) {
        const files = e.target.files;
        const dommageId = $(e.target).data('dommage-id');
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                this.addPhotoToPreview(dommageId, file);
            }
        });
    }
    
    addPhotoToPreview(dommageId, file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const photoId = 'photo_' + Date.now();
            const photoHtml = `
                <div class="photo-item position-relative mr-2 mb-2" data-photo-id="${photoId}">
                    <img src="${e.target.result}" class="border rounded" style="width: 100px; height: 100px; object-fit: cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute" 
                            style="top: -5px; right: -5px; padding: 2px 6px;"
                            onclick="$(this).parent().remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            $(`.photos-preview-${dommageId}`).append(photoHtml);
            
            // Stocker le fichier
            this.photos.push({
                id: photoId,
                dommageId: dommageId,
                file: file,
                dataUrl: e.target.result
            });
        };
        reader.readAsDataURL(file);
    }
    
    handleDocumentUpload(e, dommageId) {
        const files = e.target.files;
        
        Array.from(files).forEach(file => {
            const docId = 'doc_' + Date.now();
            const docHtml = `
                <div class="document-item d-flex align-items-center justify-content-between p-2 border rounded mb-2" data-doc-id="${docId}">
                    <div>
                        <i class="fas fa-file-alt mr-2"></i>
                        <span>${file.name}</span>
                        <small class="text-muted ml-2">(${this.formatFileSize(file.size)})</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="$(this).parent().remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            
            $(`.documents-list-${dommageId}`).append(docHtml);
            
            // Stocker le document
            this.documentsUploaded.push({
                id: docId,
                dommageId: dommageId,
                file: file
            });
        });
    }
    
    estimateCost(e) {
        const dommageId = $(e.target).data('dommage-id');
        const dommageItem = $(`.dommage-item[data-dommage-id="${dommageId}"]`);
        
        // Collecter les informations pour l'estimation
        const type = dommageItem.find('.dommage-type').val();
        const zone = dommageItem.find(`input[name="zone_${dommageId}"]`).val();
        const description = dommageItem.find(`textarea[name="description_${dommageId}"]`).val();
        
        if (!type || !zone) {
            alert('Veuillez remplir le type de dommage et la zone avant d\'estimer les coûts.');
            return;
        }
        
        // Estimation basique (à améliorer avec une vraie logique)
        const estimates = {
            'eau': { min: 500, max: 3000 },
            'feu': { min: 1000, max: 10000 },
            'fumee': { min: 300, max: 2000 },
            'bris': { min: 200, max: 1500 },
            'vol': { min: 100, max: 5000 },
            'autre': { min: 300, max: 2000 }
        };
        
        const estimate = estimates[type] || estimates['autre'];
        const avgCost = (estimate.min + estimate.max) / 2;
        
        dommageItem.find(`input[name="cout_estime_${dommageId}"]`).val(avgCost.toFixed(2));
        
        // Afficher les détails de l'estimation
        this.showEstimationDetails(dommageId, estimate);
    }
    
    showEstimationDetails(dommageId, estimate) {
        const modalHtml = `
            <div class="modal fade" id="estimationModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Estimation des coûts</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Estimation basée sur le type de dommage :</p>
                            <div class="alert alert-info">
                                <strong>Fourchette estimée :</strong> ${estimate.min}€ - ${estimate.max}€<br>
                                <strong>Coût moyen :</strong> ${((estimate.min + estimate.max) / 2).toFixed(2)}€
                            </div>
                            <small class="text-muted">
                                Cette estimation est indicative. Un expert pourra affiner cette évaluation lors de sa visite.
                            </small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" 
                                    onclick="window.gestionDommagesProxinistreB2B.scheduleExpertVisit('${dommageId}')">
                                Programmer visite expert
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#estimationModal').remove();
        $('body').append(modalHtml);
        $('#estimationModal').modal('show');
    }
    
    scheduleExpertVisit(dommageId) {
        alert('Programmation d\'une visite d\'expert pour ce dommage...');
        // Implémenter la logique de programmation
    }
    
    updateDommagesList() {
        const totalDommages = $('.dommage-item').length;
        $('#total-dommages').text(totalDommages);
        
        // Calculer le total estimé
        let totalEstime = 0;
        $('.dommage-item').each(function() {
            const cost = parseFloat($(this).find('input[name*="cout_estime"]').val()) || 0;
            totalEstime += cost;
        });
        
        $('#total-estime').text(totalEstime.toFixed(2) + '€');
    }
    
    renumberDommages() {
        $('.dommage-item').each(function(index) {
            $(this).find('h6').text(`Dommage ${index + 1}`);
        });
    }
    
    removeAssociatedFiles(dommageId) {
        // Supprimer les photos
        this.photos = this.photos.filter(photo => photo.dommageId !== dommageId);
        
        // Supprimer les documents
        this.documentsUploaded = this.documentsUploaded.filter(doc => doc.dommageId !== dommageId);
    }
    
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    exportDommagesData() {
        const dommagesData = this.collectDommagesData();
        return {
            dommages: dommagesData,
            photos: this.photos.map(photo => ({
                id: photo.id,
                dommageId: photo.dommageId,
                fileName: photo.file.name,
                size: photo.file.size
            })),
            documents: this.documentsUploaded.map(doc => ({
                id: doc.id,
                dommageId: doc.dommageId,
                fileName: doc.file.name,
                size: doc.file.size
            }))
        };
    }
    
    collectDommagesData() {
        const dommages = [];
        
        $('.dommage-item').each(function() {
            const dommageId = $(this).data('dommage-id');
            const dommage = {
                id: dommageId,
                type: $(this).find('.dommage-type').val(),
                zone: $(this).find(`input[name="zone_${dommageId}"]`).val(),
                description: $(this).find(`textarea[name="description_${dommageId}"]`).val(),
                coutEstime: parseFloat($(this).find(`input[name="cout_estime_${dommageId}"]`).val()) || 0,
                urgence: $(this).find(`select[name="urgence_${dommageId}"]`).val()
            };
            
            dommages.push(dommage);
        });
        
        return dommages;
    }
    
    setupFileUpload() {
        // Configuration globale pour les uploads
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            // Support HTML5 File API
            console.log('File API supportée');
        } else {
            console.warn('File API non supportée');
        }
    }
}

// Initialisation
$(document).ready(function() {
    window.gestionDommagesProxinistreB2B = new GestionDommagesProxinistreB2B();
});
</script>
