<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="script-container"
        style="height:90%; padding-top: 10px; padding-left:10px; padding-right:10px; margin:20px; align-items: center;justify-content: center;">
        <div class="mb-2">
            <a target="_blank" class="btn btn-info d-flex align-items-center"
                href="<?= linkTo('CompanyGroup', 'company',  $company->idCompany)  ?>">
                <i class="fas fa-info-circle mr-2"></i> Détails
            </a>
        </div>
        <div class="mb-2">
            <a class="btn btn-warning d-flex align-items-center" onclick="loadNotes('modal')">
                <i class="fas fa-fw fa-file mr-2"></i> Liste des Notes
            </a>
        </div>
        <div class="mb-2">
            <a class="btn btn-info d-flex align-items-center" onclick="showModalSendDoc()"><i
                    class="fa fa-paper-plane mr-2"></i> Envoi Doc</a>
        </div>
        <div class="mb-2">
            <label for="">Note</label>
            <textarea name="noteTextCampagne" id="noteTextCampagne" cols="10" rows="10" readonly
                class="form-control"><?= ($questScript ? $questScript->noteTextCampagne : "") ?></textarea>
        </div>
    </div>
</div>

<!-- Modal pour la liste des notes -->
<div class="modal fade" id="modalListNotes" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="text-center font-weight-bold">LISTE DES NOTES</h2>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voir</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Auteur</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Envoi de Documentation -->
<div class="modal fade" id="modalEnvoiDoc" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h2 class="text-center font-weight-bold text-uppercase">envoi documentation</h2>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Date</label>
                            <input type="text" name="" id="dateNote" readonly class="form-control"
                                value="<?= date('d-m-Y H:i') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Auteur</label>
                            <input type="text" name="" id="auteurNote" readonly class="form-control"
                                value="<?= isset($_SESSION['connectedUser']->prenomContact) ? $_SESSION['connectedUser']->prenomContact . ' ' . $_SESSION['connectedUser']->nomContact : $_SESSION['connectedUser']->fullName ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Confirmez l'adresse mail</label>
                        <input type="text" class="form-control" value="<?= $contact ? $contact->email : '' ?>"
                            id="emailDestinataire" name="emailContact" ref="emailContact">
                    </div>
                    <div class="form-group">
                        <label for="">Objet</label>
                        <input type="text" class="form-control" id="objetMailEnvoiDoc" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Contenu</label>
                        <textarea name="" id="bodyMailEnvoiDoc" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <input hidden type="text" class="form-control" value="" id="signatureMail" name="signatureMail"
                        ref="signatureMail">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                <button type="button" onclick="sendDocumentation()" class="btn btn-info">Envoyer</button>
            </div>
        </div>
    </div>
</div>

<script>
// =====================
// FONCTIONS POUR GESTION DES NOTES ET ENVOI DOC - B2C
// =====================

function loadNotes(type) {
    console.log('loadNotes B2C appelée avec type:', type);
    
    if (type === 'modal') {
        // Vérifier que jQuery est disponible
        if (typeof $ === 'undefined') {
            alert('jQuery n\'est pas disponible');
            return;
        }
        
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
                console.log('Chargement des notes...');
                // Afficher un message de chargement si possible
                if ($('#loadingModal').length > 0) {
                    $("#msgLoading").text("Chargement des notes...");
                    $('#loadingModal').modal('show');
                }
            },
            success: function(response) {
                console.log('Réponse reçue:', response);
                
                // Cacher le modal de chargement
                if ($('#loadingModal').length > 0) {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 500);
                }

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
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error, xhr.responseText);
                
                // Cacher le modal de chargement
                if ($('#loadingModal').length > 0) {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 500);
                }
                
                // Afficher l'erreur
                if ($('#errorOperation').length > 0) {
                    $("#msgError").text("Impossible de charger les notes ! Erreur: " + error);
                    $('#errorOperation').modal('show');
                } else {
                    alert("Impossible de charger les notes ! Erreur: " + error);
                }
            }
        });
    }
}

function showModalSendDoc() {
    console.log('showModalSendDoc B2C appelée');
    
    // Préparer les informations du mail - Version B2C
    const objetMail = `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    const bodyMail = `<p style="text-align:justify"><?= $contact ? "Bonjour {$contact->civilite} {$contact->prenom} {$contact->nom}," : "Madame, Monsieur," ?><br><br>
                    Merci pour notre échange très agréable d'aujourd'hui.<br><br>
                    Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d'assurance, en nous occupant de tout, de A à Z.<br><br>
                    <b>En choisissant Proxinistre, vous bénéficiez notamment de</b> :<br>
                    <ul>
                        <li>Un interlocuteur unique dédié à votre dossier.</li>
                        <li>Une expertise SOS Sinistre sous 24 heures.</li>
                        <li>Un soutien administratif et juridique complet.</li>
                        <li><b>0€ de coût de gestion</b> pour vous.</li>
                        <li>La facilitation complète des démarches liées à votre sinistre.</li>
                        <li>Une assistance disponible 24h/24 et 7j/7.</li>
                        <li>Des partenaires agréés pour des réparations rapides et garanties.</li>
                    </ul>
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d'esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                    <?= isset($_SESSION['connectedUser']->fullName) ? $_SESSION['connectedUser']->fullName : 'L\'équipe Proxinistre' ?>
                    </p>`;

    // Remplir les champs du modal
    if ($('#objetMailEnvoiDoc').length > 0) {
        $('#objetMailEnvoiDoc').val(objetMail);
    }
    
    // Utiliser TinyMCE si disponible, sinon utiliser textarea normale
    if (typeof tinyMCE !== 'undefined' && tinyMCE.get("bodyMailEnvoiDoc")) {
        tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
    } else if ($('#bodyMailEnvoiDoc').length > 0) {
        $('#bodyMailEnvoiDoc').val(bodyMail);
    }
    
    // Afficher le modal
    $('#modalEnvoiDoc').modal('show');
}

function viewNote(noteId) {
    console.log('viewNote B2C appelée avec ID:', noteId);
    alert('Fonction viewNote B2C appelée pour la note ID: ' + noteId + '\nImplémentation complète à faire...');
}

function formatDate(dateString) {
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

function sendDocumentation() {
    console.log('sendDocumentation B2C appelée');
    
    let emailDestinataire = $("#emailDestinataire").val();
    if (emailDestinataire == "") {
        alert("Veuillez renseigner une adresse mail !");
        return;
    }
    
    let post = {
        to: emailDestinataire,
        subject: $('#objetMailEnvoiDoc').val(),
        bodyMessage: $('#bodyMailEnvoiDoc').val(),
        idAuteur: `<?= $_SESSION['connectedUser']->idUtilisateur ?>`,
        auteur: `<?= $_SESSION['connectedUser']->fullName ?>`,
        idCompanyGroup: $('#contextId').val(),
        type: 'B2C'
    };
    
    $.ajax({
        url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=envoiDocumentation`,
        type: 'POST',
        data: JSON.stringify(post),
        dataType: "JSON",
        beforeSend: function() {
            console.log("Envoi mail B2C en cours...");
        },
        success: function(response) {
            alert("Envoi de documentation B2C effectué avec succès!");
            setTimeout(function() {
                $('#modalEnvoiDoc').modal('hide');
            }, 1000);
        },
        error: function(response) {
            console.error("Erreur envoi mail B2C:", response);
            alert("Impossible d'envoyer le mail !");
        }
    });
}

// Initialisation au chargement du document
$(document).ready(function() {
    console.log('Script sidebarFormationB2C.php chargé avec succès');
    console.log('Fonctions B2C disponibles: loadNotes, showModalSendDoc, viewNote, formatDate, sendDocumentation');
});
</script>

<!-- Inclusion des scripts modulaires B2C -->
<?php include_once 'scriptsFormation/variablesGlobalesB2C.php'; ?>
<?php include_once 'scriptsFormation/navigationEtapesB2C.js.php'; ?>
<?php include_once 'scriptsFormation/interactionsFormulaireB2C.js.php'; ?>
<?php include_once 'scriptsFormation/gestionGeographiqueShared.js.php'; ?>
<?php include_once 'scriptsFormation/gestionRdvB2C.js.php'; ?>
<?php include_once 'scriptsFormation/gestionDommagesB2C.js.php'; ?>
<?php include_once 'scriptsFormation/sauvegardeB2C.js.php'; ?>
<?php include_once 'scriptsFormation/emailDocumentationB2C.js.php'; ?>
<?php include_once 'scriptsFormation/assistantsB2C.js.php'; ?>
<?php include_once 'scriptsFormation/rdvComplexeB2C.js.php'; ?>

<!-- Réutilisation des scripts partagés avec B2B -->
<?php include_once 'scriptsFormation/tooltips.js.php'; ?>

<script>
// Script de vérification et initialisation B2C
$(document).ready(function() {
    console.log('✓ Scripts modulaires B2C chargés avec succès');
    
    // Vérifier les éléments DOM nécessaires
    if ($('#contextId').length > 0) {
        console.log('✓ Element #contextId trouvé, valeur:', $('#contextId').val());
    } else {
        console.error('✗ Element #contextId non trouvé');
    }
    
    if ($('#contextType').length > 0) {
        console.log('✓ Element #contextType trouvé, valeur:', $('#contextType').val());
    } else {
        console.error('✗ Element #contextType non trouvé');
    }
    
    // Initialiser les composants après le chargement
    if (typeof updateButtons === 'function') {
        updateButtons();
    }
    
    // Gérer l'état "pinned" des tooltips
    document.addEventListener('click', function(e) {
        const allTooltips = document.querySelectorAll('.tooltip-content');
        let clickedOnTooltip = false;

        document.querySelectorAll('.tooltip-container').forEach(container => {
            const content = container.querySelector('.tooltip-content');

            if (container.contains(e.target)) {
                clickedOnTooltip = true;

                // Toggle pinned state
                if (content.classList.contains('pinned')) {
                    content.classList.remove('pinned');
                } else {
                    allTooltips.forEach(t => t.classList.remove('pinned'));
                    content.classList.add('pinned');

                    // Gérer la position dynamiquement
                    const rect = content.getBoundingClientRect();
                    const spaceAbove = rect.top;
                    const spaceBelow = window.innerHeight - rect.bottom;

                    // Si pas assez de place au-dessus, ouvrir vers le bas
                    if (spaceAbove < 100 && spaceBelow > spaceAbove) {
                        content.style.top = '125%';
                        content.style.bottom = 'auto';
                        content.querySelector('::after')?.remove();
                        content.style.setProperty('--tooltip-arrow-direction', 'down');
                        content.style.transform = 'translateX(-50%)';
                        content.style.setProperty('--arrow-border-color',
                            '#333 transparent transparent transparent');
                        content.style.setProperty('--arrow-top', '-8px');
                    } else {
                        content.style.bottom = '125%';
                        content.style.top = 'auto';
                    }
                }
            }
        });

        if (!clickedOnTooltip) {
            allTooltips.forEach(t => t.classList.remove('pinned'));
        }
    });
});
</script>
