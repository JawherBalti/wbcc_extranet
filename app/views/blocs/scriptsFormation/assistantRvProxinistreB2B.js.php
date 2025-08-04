<script>
// Assistant RV pour Proxinistre B2B
class AssistantRvProxinistreB2B {
    constructor() {
        this.availableSlots = [];
        this.selectedSlot = null;
        this.expertsList = [];
        this.calendarData = {};
        this.init();
    }
    
    init() {
        this.loadExperts();
        this.bindEvents();
        this.setupCalendar();
    }
    
    bindEvents() {
        $(document).on('click', '#btnScheduleRV', () => this.openScheduleModal());
        $(document).on('change', '#selectExpert', (e) => this.onExpertChange(e));
        $(document).on('change', '#selectDate', (e) => this.onDateChange(e));
        $(document).on('click', '.time-slot', (e) => this.selectTimeSlot(e));
        $(document).on('click', '#btnConfirmRV', () => this.confirmRendezVous());
        $(document).on('click', '#btnCancelRV', () => this.cancelRendezVous());
        $(document).on('click', '.btn-reschedule', () => this.rescheduleRendezVous());
    }
    
    loadExperts() {
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getExperts,
            method: 'GET',
            data: { action: 'getExperts' },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    this.expertsList = result.experts;
                    this.populateExpertsSelect();
                }
            },
            error: () => {
                console.error('Erreur lors du chargement des experts');
            }
        });
    }
    
    populateExpertsSelect() {
        const select = $('#selectExpert');
        select.empty().append('<option value="">Sélectionner un expert</option>');
        
        this.expertsList.forEach(expert => {
            select.append(`<option value="${expert.id}">${expert.name} - ${expert.speciality}</option>`);
        });
    }
    
    openScheduleModal() {
        const modalHtml = this.createScheduleModal();
        $('body').append(modalHtml);
        $('#scheduleRVModal').modal('show');
        
        // Initialiser le calendrier après ouverture
        setTimeout(() => {
            this.initDatePicker();
        }, 500);
    }
    
    createScheduleModal() {
        return `
            <div class="modal fade" id="scheduleRVModal" tabindex="-1" data-backdrop="static">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-calendar-alt"></i> Planifier un rendez-vous
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">1. Sélection Expert</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Expert disponible</label>
                                                <select class="form-control" id="selectExpert">
                                                    <option value="">Chargement...</option>
                                                </select>
                                            </div>
                                            <div id="expertInfo" class="mt-3" style="display: none;">
                                                <div class="expert-card p-2 border rounded">
                                                    <div class="expert-photo mb-2">
                                                        <img id="expertPhoto" src="" class="rounded-circle" width="60" height="60">
                                                    </div>
                                                    <h6 id="expertName"></h6>
                                                    <p class="text-muted small" id="expertSpecialty"></p>
                                                    <div class="expert-rating" id="expertRating"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">2. Date</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Date souhaitée</label>
                                                <input type="date" class="form-control" id="selectDate" 
                                                       min="${new Date().toISOString().split('T')[0]}">
                                            </div>
                                            <div id="dateInfo" class="mt-3">
                                                <small class="text-muted">Sélectionnez une date pour voir les créneaux disponibles</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">3. Créneau</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="timeSlots">
                                                <small class="text-muted">Sélectionnez un expert et une date</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">4. Informations complémentaires</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Type de visite</label>
                                                        <select class="form-control" id="visitType">
                                                            <option value="expertise">Expertise initiale</option>
                                                            <option value="suivi">Visite de suivi</option>
                                                            <option value="final">Contrôle final</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Durée estimée</label>
                                                        <select class="form-control" id="visitDuration">
                                                            <option value="30">30 minutes</option>
                                                            <option value="60" selected>1 heure</option>
                                                            <option value="90">1h30</option>
                                                            <option value="120">2 heures</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Notes particulières</label>
                                                <textarea class="form-control" id="visitNotes" rows="3" 
                                                          placeholder="Informations importantes pour l'expert (accès, contraintes, etc.)"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Contact sur place</label>
                                                <input type="text" class="form-control" id="contactPerson" 
                                                       placeholder="Nom de la personne qui recevra l'expert">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="appointmentSummary" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Récapitulatif</h6>
                                    <div id="summaryContent"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-success" id="btnConfirmRV" disabled>
                                <i class="fas fa-check"></i> Confirmer le rendez-vous
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    initDatePicker() {
        // Configuration avancée du sélecteur de date
        const dateInput = $('#selectDate');
        
        // Désactiver les weekends si nécessaire
        dateInput.on('input', (e) => {
            const selectedDate = new Date(e.target.value);
            const dayOfWeek = selectedDate.getDay();
            
            // Optionnel : désactiver les dimanches (0)
            if (dayOfWeek === 0) {
                alert('Les rendez-vous ne sont pas disponibles le dimanche.');
                e.target.value = '';
            }
        });
    }
    
    onExpertChange(e) {
        const expertId = $(e.target).val();
        if (expertId) {
            const expert = this.expertsList.find(exp => exp.id == expertId);
            if (expert) {
                this.displayExpertInfo(expert);
                this.loadExpertAvailability(expertId);
            }
        } else {
            $('#expertInfo').hide();
            this.clearTimeSlots();
        }
        this.updateConfirmButton();
    }
    
    displayExpertInfo(expert) {
        $('#expertPhoto').attr('src', expert.photo || '/public/img/default-expert.png');
        $('#expertName').text(expert.name);
        $('#expertSpecialty').text(expert.speciality);
        $('#expertRating').html(this.generateRatingStars(expert.rating || 5));
        $('#expertInfo').show();
    }
    
    generateRatingStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fas fa-star text-warning"></i>';
            } else {
                stars += '<i class="far fa-star text-muted"></i>';
            }
        }
        return stars;
    }
    
    onDateChange(e) {
        const date = $(e.target).val();
        const expertId = $('#selectExpert').val();
        
        if (date && expertId) {
            this.loadAvailableSlots(expertId, date);
        } else {
            this.clearTimeSlots();
        }
        this.updateConfirmButton();
    }
    
    loadExpertAvailability(expertId) {
        // Charger la disponibilité générale de l'expert
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getExpertAvailability,
            method: 'POST',
            data: {
                expertId: expertId,
                action: 'getExpertAvailability'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    this.updateDateInfo(result.availability);
                }
            },
            error: () => {
                console.error('Erreur lors du chargement de la disponibilité');
            }
        });
    }
    
    updateDateInfo(availability) {
        let infoHtml = '<div class="availability-info">';
        infoHtml += '<small class="text-success"><i class="fas fa-check"></i> Expert disponible</small><br>';
        infoHtml += `<small class="text-muted">Jours: ${availability.days || 'Lun-Ven'}</small><br>`;
        infoHtml += `<small class="text-muted">Horaires: ${availability.hours || '8h-18h'}</small>`;
        infoHtml += '</div>';
        
        $('#dateInfo').html(infoHtml);
    }
    
    loadAvailableSlots(expertId, date) {
        $('#timeSlots').html('<i class="fas fa-spinner fa-spin"></i> Chargement...');
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.getAvailableSlots,
            method: 'POST',
            data: {
                expertId: expertId,
                date: date,
                action: 'getAvailableSlots'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    this.displayTimeSlots(result.slots);
                } else {
                    $('#timeSlots').html('<small class="text-danger">Aucun créneau disponible</small>');
                }
            },
            error: () => {
                $('#timeSlots').html('<small class="text-danger">Erreur de chargement</small>');
            }
        });
    }
    
    displayTimeSlots(slots) {
        if (slots.length === 0) {
            $('#timeSlots').html('<small class="text-muted">Aucun créneau disponible</small>');
            return;
        }
        
        let slotsHtml = '<div class="time-slots-grid">';
        slots.forEach(slot => {
            slotsHtml += `
                <button type="button" class="btn btn-outline-primary btn-sm time-slot m-1" 
                        data-start="${slot.start}" data-end="${slot.end}">
                    ${slot.start} - ${slot.end}
                </button>
            `;
        });
        slotsHtml += '</div>';
        
        $('#timeSlots').html(slotsHtml);
    }
    
    selectTimeSlot(e) {
        const button = $(e.target);
        
        // Désélectionner les autres créneaux
        $('.time-slot').removeClass('btn-primary').addClass('btn-outline-primary');
        
        // Sélectionner le créneau actuel
        button.removeClass('btn-outline-primary').addClass('btn-primary');
        
        this.selectedSlot = {
            start: button.data('start'),
            end: button.data('end')
        };
        
        this.updateAppointmentSummary();
        this.updateConfirmButton();
    }
    
    updateAppointmentSummary() {
        if (this.isAllRequiredDataSelected()) {
            const expert = this.expertsList.find(exp => exp.id == $('#selectExpert').val());
            const date = new Date($('#selectDate').val()).toLocaleDateString('fr-FR');
            const visitType = $('#visitType option:selected').text();
            const duration = $('#visitDuration').val();
            
            const summaryHtml = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Expert :</strong> ${expert.name}<br>
                        <strong>Date :</strong> ${date}<br>
                        <strong>Heure :</strong> ${this.selectedSlot.start} - ${this.selectedSlot.end}
                    </div>
                    <div class="col-md-6">
                        <strong>Type :</strong> ${visitType}<br>
                        <strong>Durée :</strong> ${duration} minutes<br>
                        <strong>Contact :</strong> ${$('#contactPerson').val() || 'Non précisé'}
                    </div>
                </div>
            `;
            
            $('#summaryContent').html(summaryHtml);
            $('#appointmentSummary').show();
        } else {
            $('#appointmentSummary').hide();
        }
    }
    
    isAllRequiredDataSelected() {
        return $('#selectExpert').val() && 
               $('#selectDate').val() && 
               this.selectedSlot;
    }
    
    updateConfirmButton() {
        const isValid = this.isAllRequiredDataSelected();
        $('#btnConfirmRV').prop('disabled', !isValid);
    }
    
    confirmRendezVous() {
        const appointmentData = this.collectAppointmentData();
        
        if (!this.validateAppointmentData(appointmentData)) {
            return;
        }
        
        $('#btnConfirmRV').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Confirmation...');
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.createAppointment,
            method: 'POST',
            data: {
                ...appointmentData,
                action: 'createAppointment'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    this.onAppointmentCreated(result.appointment);
                } else {
                    alert('Erreur lors de la création du rendez-vous : ' + result.message);
                    $('#btnConfirmRV').prop('disabled', false).html('<i class="fas fa-check"></i> Confirmer le rendez-vous');
                }
            },
            error: () => {
                alert('Erreur lors de la création du rendez-vous');
                $('#btnConfirmRV').prop('disabled', false).html('<i class="fas fa-check"></i> Confirmer le rendez-vous');
            }
        });
    }
    
    collectAppointmentData() {
        return {
            expertId: $('#selectExpert').val(),
            expertName: $('#selectExpert option:selected').text(),
            date: $('#selectDate').val(),
            timeStart: this.selectedSlot.start,
            timeEnd: this.selectedSlot.end,
            visitType: $('#visitType').val(),
            duration: $('#visitDuration').val(),
            notes: $('#visitNotes').val(),
            contactPerson: $('#contactPerson').val(),
            contextId: $('#contextId').val(),
            clientData: this.getClientData()
        };
    }
    
    getClientData() {
        return {
            name: $('input[name="name"]').val(),
            phone: $('input[name="businessPhone"]').val(),
            email: $('input[name="email"]').val(),
            address: $('input[name="businessLine1"]').val() + ', ' + 
                     $('input[name="businessPostalCode"]').val() + ' ' + 
                     $('input[name="businessCity"]').val()
        };
    }
    
    validateAppointmentData(data) {
        if (!data.expertId || !data.date || !data.timeStart) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }
        
        if (!data.contactPerson) {
            if (!confirm('Aucun contact sur place n\'est précisé. Voulez-vous continuer ?')) {
                return false;
            }
        }
        
        return true;
    }
    
    onAppointmentCreated(appointment) {
        alert('Rendez-vous confirmé avec succès !');
        $('#scheduleRVModal').modal('hide');
        
        this.updateAppointmentDisplay(appointment);
        this.sendConfirmationEmail(appointment);
        
        // Passer à l'étape suivante si applicable
        if (window.interfaceProxinistreB2B) {
            window.interfaceProxinistreB2B.nextStep();
        }
    }
    
    updateAppointmentDisplay(appointment) {
        const appointmentHtml = `
            <div class="alert alert-success appointment-confirmed">
                <h6><i class="fas fa-calendar-check"></i> Rendez-vous confirmé</h6>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Expert :</strong> ${appointment.expertName}<br>
                        <strong>Date :</strong> ${new Date(appointment.date).toLocaleDateString('fr-FR')}<br>
                        <strong>Heure :</strong> ${appointment.timeStart} - ${appointment.timeEnd}
                    </div>
                    <div class="col-md-6">
                        <strong>Référence :</strong> #${appointment.reference}<br>
                        <button type="button" class="btn btn-sm btn-outline-primary btn-reschedule mt-2">
                            <i class="fas fa-edit"></i> Modifier
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 ml-2" onclick="window.assistantRvProxinistreB2B.cancelRendezVous('${appointment.id}')">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $('#appointment-display').html(appointmentHtml);
    }
    
    sendConfirmationEmail(appointment) {
        // Envoyer un email de confirmation
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.sendAppointmentConfirmation,
            method: 'POST',
            data: {
                appointmentId: appointment.id,
                action: 'sendAppointmentConfirmation'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    console.log('Email de confirmation envoyé');
                }
            },
            error: () => {
                console.error('Erreur lors de l\'envoi de l\'email de confirmation');
            }
        });
    }
    
    rescheduleRendezVous() {
        // Rouvrir le modal avec les données actuelles
        this.openScheduleModal();
        // Préremplir avec les données existantes si nécessaire
    }
    
    cancelRendezVous(appointmentId) {
        if (!confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')) {
            return;
        }
        
        $.ajax({
            url: CONFIG_PROXINISTRE_B2B.endpoints.cancelAppointment,
            method: 'POST',
            data: {
                appointmentId: appointmentId,
                action: 'cancelAppointment'
            },
            success: (response) => {
                const result = JSON.parse(response);
                if (result.success) {
                    alert('Rendez-vous annulé avec succès');
                    $('#appointment-display').empty();
                } else {
                    alert('Erreur lors de l\'annulation : ' + result.message);
                }
            },
            error: () => {
                alert('Erreur lors de l\'annulation du rendez-vous');
            }
        });
    }
    
    clearTimeSlots() {
        $('#timeSlots').html('<small class="text-muted">Sélectionnez un expert et une date</small>');
        this.selectedSlot = null;
    }
    
    setupCalendar() {
        // Configuration du calendrier si nécessaire
        // Peut être étendu avec une librairie de calendrier
    }
}

// Nettoyage modal à la fermeture
$(document).on('hidden.bs.modal', '#scheduleRVModal', function() {
    $(this).remove();
});

// Initialisation
$(document).ready(function() {
    window.assistantRvProxinistreB2B = new AssistantRvProxinistreB2B();
});
</script>
