<script>
// =====================
// GESTION DES NOTES
// =====================

// Vérification des dépendances
if (typeof jQuery === 'undefined') {
    console.error('jQuery n\'est pas chargé - les fonctions de gestion des notes ne fonctionneront pas');
}

// Attendre que le DOM soit chargé
$(document).ready(function() {
    console.log('Script gestionNotes.js.php chargé avec succès');
});

// Définir les fonctions globalement
window.loadNotes = function(type) {
    if (type === 'modal') {
        // Charger les notes via AJAX et afficher dans le modal
        $.ajax({
            url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=loadNotes`,
            type: 'POST',
            data: {
                idCompanyGroup: $('#contextId').val(),
                contextType: $('#contextType').val()
            },
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Chargement des notes...");
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);

                // Vider le tableau des notes
                $('#dataTable20 tbody').empty();
                
                if (response && response.notes && response.notes.length > 0) {
                    // Remplir le tableau avec les notes
                    response.notes.forEach(function(note, index) {
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewNote(${note.id})" data-toggle="tooltip" title="Voir le détail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                                <td style="max-width: 300px; word-wrap: break-word;">
                                    ${note.content ? note.content.substring(0, 100) + (note.content.length > 100 ? '...' : '') : 'Aucun contenu'}
                                </td>
                                <td>${note.date ? formatDate(note.date) : 'Non définie'}</td>
                                <td>${note.auteur || 'Non défini'}</td>
                            </tr>
                        `;
                        $('#dataTable20 tbody').append(row);
                    });
                } else {
                    // Aucune note trouvée
                    $('#dataTable20 tbody').append(`
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fas fa-sticky-note"></i> Aucune note disponible
                            </td>
                        </tr>
                    `);
                }

                // Afficher le modal
                $('#modalListNotes').modal('show');
            },
            error: function(response) {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);
                $("#msgError").text("Impossible de charger les notes !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                // Initialiser le DataTable si pas déjà fait
                if (!$.fn.DataTable.isDataTable('#dataTable20')) {
                    $('#dataTable20').DataTable({
                        "pageLength": 10,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                        },
                        "order": [[3, "desc"]] // Trier par date décroissante
                    });
                }
            }
        });
    }
}

window.viewNote = function(noteId) {
    // Fonction pour afficher le détail d'une note
    $.ajax({
        url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=getNoteDetail`,
        type: 'POST',
        data: {
            noteId: noteId
        },
        dataType: "JSON",
        success: function(response) {
            if (response && response.note) {
                const note = response.note;
                const noteContent = `
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5><i class="fas fa-sticky-note"></i> Détail de la note</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Date :</strong> ${formatDate(note.date)}</p>
                            <p><strong>Auteur :</strong> ${note.auteur || 'Non défini'}</p>
                            <hr>
                            <p><strong>Contenu :</strong></p>
                            <div class="border p-3" style="max-height: 300px; overflow-y: auto;">
                                ${note.content || 'Aucun contenu'}
                            </div>
                        </div>
                    </div>
                `;
                
                // Créer un modal temporaire pour afficher le détail
                const modalHtml = `
                    <div class="modal fade" id="modalNoteDetail" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Détail de la note</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    ${noteContent}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Supprimer le modal s'il existe déjà
                $('#modalNoteDetail').remove();
                // Ajouter le nouveau modal
                $('body').append(modalHtml);
                // Afficher le modal
                $('#modalNoteDetail').modal('show');
            }
        },
        error: function() {
            $("#msgError").text("Impossible de charger le détail de la note !");
            $('#errorOperation').modal('show');
        }
    });
}

window.formatDate = function(dateString) {
    if (!dateString) return 'Non définie';
    
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    } catch (error) {
        return dateString;
    }
}

// Fonction pour sauvegarder une nouvelle note
window.saveNote = function(noteContent, callback) {
    if (!noteContent || noteContent.trim() === '') {
        $("#msgError").text("Le contenu de la note ne peut pas être vide !");
        $('#errorOperation').modal('show');
        return;
    }

    $.ajax({
        url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=saveNote`,
        type: 'POST',
        data: {
            content: noteContent,
            idCompanyGroup: $('#contextId').val(),
            contextType: $('#contextType').val(),
            idAuteur: `<?= $_SESSION['connectedUser']->idUtilisateur ?>`,
            auteur: `<?= $_SESSION['connectedUser']->fullName ?>`
        },
        dataType: "JSON",
        beforeSend: function() {
            $("#msgLoading").text("Sauvegarde de la note...");
            $('#loadingModal').modal('show');
        },
        success: function(response) {
            setTimeout(() => {
                $('#loadingModal').modal('hide');
            }, 500);

            if (response && response.success) {
                $("#msgSuccess").text("Note sauvegardée avec succès !");
                $('#successOperation').modal('show');
                
                setTimeout(function() {
                    $('#successOperation').modal('hide');
                    if (callback && typeof callback === 'function') {
                        callback();
                    }
                }, 1000);
            } else {
                $("#msgError").text("Erreur lors de la sauvegarde de la note !");
                $('#errorOperation').modal('show');
            }
        },
        error: function(response) {
            setTimeout(() => {
                $('#loadingModal').modal('hide');
            }, 500);
            $("#msgError").text("Impossible de sauvegarder la note !");
            $('#errorOperation').modal('show');
        }
    });
}
</script>
