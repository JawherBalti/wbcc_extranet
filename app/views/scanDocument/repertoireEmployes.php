<?php
$user = $_SESSION["connectedUser"];
$idUtilisateur = $user->idUtilisateur;
$fullName = $user->fullName;
$role = $user->idRole;
$viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
$isAdmin = ($role == "1" || $role == "2") ? true : false;
?>

<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Réaffecter le document</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formSelectRepertoire">
                <div class="modal-body px-5 py-4">
                    <!-- Company Selection -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold">Réaffecter</label>
                        <select id="entrepriseSelect" class="form-control" onchange="loadTopLevelFolders()">
                            <option value="">-- Sélectionner une entreprise --</option>
                            <!-- Options will be loaded dynamically -->
                        </select>
                    </div>

                    <!-- Folder Hierarchy -->
                    <div id="folderHierarchy">
                        <!-- Dynamic selects will appear here -->
                    </div>
                </div>
                <div class="modal-footer px-5 pb-4 pt-0">
                    <button id="confirm-btn" class="btn btn-danger btn-lg w-100">
                        Confirmer la réaffectation
                    </button>
                </div>
            </form>
            <input type="hidden" id="modalActivityUserId">
            <input type="hidden" id="modalDocumentId">
            <input type="hidden" id="modalActivityId">
            <input type="hidden" id="modalDocumentCreateDate">
            <input type="hidden" id="modalDocumentEditDate">
            <input type="hidden" id="modalDocumentNom">
            <input type="hidden" id="modalNouveauDocumentNom">
            <input type="hidden" id="modalDocumentUrl">
            <input type="hidden" id="modalDossierUrl">
        </div>
    </div>
</div>

<div class="modal fade" id="leaveRequestModal2" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Réassigner la tâche</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formSelectUser">
                <div class="modal-body px-5 py-4">
                    <!-- Company Selection -->

                    <!-- Folder Hierarchy -->
                    <div id="userHierarchy">
                        <!-- Dynamic selects will appear here -->
                    </div>
                </div>
            </form>
            <div class="modal-footer px-5 pb-4 pt-0">
                <button type="submit" id="confirm-user-btn" class="btn btn-danger btn-lg w-100">
                    Confirmer la réassignation
                </button>
            </div>
                <input type="hidden" id="modalActivityUserId2">
                <input type="hidden" id="modalDocumentId2">
                <input type="hidden" id="modalActivityId2">
                <input type="hidden" id="modalDocumentCreateDate2">
                <input type="hidden" id="modalDocumentEditDate2">
                <input type="hidden" id="modalDocumentNom2">
                <input type="hidden" id="modalNouveauDocumentNom2">
                <input type="hidden" id="modalDocumentUrl2">
                <input type="hidden" id="modalDossierUrl2">
        </div>
    </div>
</div>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> Mon répertoire
        </h2>
    </div>
</div>

<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('ScanDocument', 'repertoireEmployes') ?>"
                        style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">

                        <div class="row justify-content-center p-2" style="width: 100%;">
                            <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Statut
                                    </legend>
                                    <div class="card ">
                                        <select id="statut" name="statut" class="form-control">
                                            <option value="">Tout</optionn>
                                            <option value="0">Non traité</option>
                                            <option value="1">Traité</option>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Employé
                                    </legend>
                                    <div class="card ">
                                        <select id="idUtilisateur" name="userId" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($listeUtilisateurs as $contact) {
                                            ?>
                                                <option value="<?= $contact->idUtilisateur ?>"
                                                    <?= $contact->idUtilisateur == $userId ? "selected" : "" ?>>
                                                    <?= $contact->fullName ?>
                                                </option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Site
                                    </legend>
                                    <select id="site" name="idSite" class="form-control">
                                        <option value="">Tout</option>
                                        <?php
                                        foreach ($sites as $sit) {
                                        ?>
                                            <option value="<?= $sit->idSite ?>">
                                                <?= $sit->nomSite ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-md-3 col-xs-12 mb-3">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Date
                                    </legend>
                                    <div class="card">
                                        <Select name="periode" id="dateDemande" class="form-control"
                                            onchange="dateCreationSelect(this.value)">
                                            <option value="">Tout</option>
                                            <option value="today">Aujourd'hui</option>
                                            <option value="semaine">Semaine en cours</option>
                                            <option value="mois">Mois en cours</option>
                                            <option value="annee">Année en cours</option>
                                            <option value="trimestre">Trimestre en cours</option>
                                            <option value="semestre">Semestre en cours</option>
                                            <option value="1">A la date du</option>
                                            <option value="2">Personnaliser</option>
                                        </Select>
                                    </div>
                                </fieldset>
                                <fieldset id="anneepair" style="display: none;">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Personnaliser
                                    </legend>
                                    <p>
                                        <label for="defaultFormControlInput" class="form-label">Année:</label>
                                        <br>
                                        <Select name="annee" id="annee" class="form-control">
                                            <option value="" disabled selected>Choisir une année</option>
                                            <?php
                                            $currentYear = date("Y");
                                            $startYear = $currentYear - 5; // Number of years before current to show
                                            $endYear = $currentYear + 1;   // Number of years after current to show

                                            for ($year = $startYear; $year <= $endYear; $year++) {

                                                echo "<option value='" . $year . "' " . $selected . ">" . $year . "</option>";
                                            }
                                            ?>
                                        </Select>
                                    </p>
                                </fieldset>

                                <fieldset id="datepairOne" style="display: none;">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Personnaliser
                                    </legend>
                                    <p>
                                        <label for="defaultFormControlInput" class="form-label">Date:</label>
                                        <br>
                                        <input name="dateOne" id="dateOne" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date start "
                                            value="<?= isset($dateOne) ? $dateOne : ''; ?>" placeholder="Choisir..." />
                                    </p>
                                </fieldset>

                                <fieldset id="datepair" style="display: none;">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Personnaliser
                                    </legend>
                                    <p>
                                        <label for="defaultFormControlInput" class="form-label">Début:</label>
                                        <br>
                                        <input name="dateDebut" id="dateDebut" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date start "
                                            value="<?= isset($dateDebut) ? $dateDebut : ''; ?>"
                                            placeholder="Choisir..." />
                                        <br><br>
                                        <label for="defaultFormControlInput" class="form-label">Fin:</label>
                                        <br>
                                        <input name="dateFin" id="dateFin" readonly style="border: 1px solid black;"
                                            type="text" class="this-form-control col-xs-12 col-md-12 date end "
                                            value="<?= isset($dateFin) ? $dateFin : ''; ?>" placeholder="Choisir..." />
                                    </p>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row justify-content-center" style="width: 100%; margin: auto;">
                            <div class="col-md-12 text-center">
                                <button type="submit" id="filterButton" class="btn btn-primary mb-2" style="margin-top: 0px; width: 200px;
                                    color: #fff;
                                        background-color: #0d6efd;
                                        border-color: #0d6efd;
                                        padding: 0.5rem 1rem;
                                        border-radius: 30px;
                                    ">FILTRER
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white" id="confirmModalHeader">
                    <h5 class="modal-title" id="confirmModalTitle">Confirmer</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="confirmModalBody">
                    <!-- Le texte sera injecté par JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="confirmBtn">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="noteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary  text-center text-white">
                <h5 class="modal-title text-center notes-titre" style="font-weight: bold; margin-left: auto"></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <div id="notesTableContainer">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabledata1" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Notes will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center py-3" id="loadingIndicator">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success" id="addNewNoteBtn">
                    <i class="fas fa-plus"></i> Ajouter une note
                </button>
            </div>

            <input type="hidden" id="noteModalDocumentId">
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModalAuto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white" id="confirmModalHeaderAuto">
                <h5 class="modal-title" id="confirmModalTitleAuto">Confirmer</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" id="confirmModalBodyAuto">
                <!-- Le texte sera injecté par JS -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="refusBtnAuto" data-dismiss="modal">Refuser</button>
                <button type="button" class="btn btn-success" id="confirmBtnAuto">Confirmer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmModalTraite" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white" id="confirmModalHeaderTraite">
                <h5 class="modal-title" id="confirmModalTitleTraite">Confirmer</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" id="confirmModalBodyTraite">
                <!-- Le texte sera injecté par JS -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmBtnTraite">Confirmer</button>
            </div>

            <input type="hidden" id="modalDocumentNom">
            <input type="hidden" id="modalNouveauDocumentNom">

        </div>
    </div>
</div>

    <!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" style="font-weight: bold">Note</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="noteForm">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" class="form-control" id="noteDate" disabled>
                    </div>
                    <div class="form-group">
                        <label>Auteur</label>
                        <input type="text" class="form-control" id="noteAuthor" disabled>
                    </div>
                    <div class="form-group">
                        <label>Note</label>
                        <textarea id="noteText" class="form-control" rows="8"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-pill" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success rounded-pill" id="saveNoteBtn">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

    <!-- MODAL ERROR -->
    <div class="modal fade modal-center" id="errorOperation">
        <div class="modal-dialog modal-lg bg-white">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 id="msgError" style="color:red"></h3>
                    <button onclick="closeModal()" class="btn btn-danger" data-dismiss="modal"
                        data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


<!-- DataTales Example -->
<div class="card shadow">
    <div class="card-header py-3 text-center bg-secondary">
        <div class="row align-items-center justify-content-center">
            <h2 class="text-center font-weight-bold text-white" id="titre">Liste des tâches</h2>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="large-table-fake-top-scroll-container-3">
                <div style="width: 1251.83px;">&nbsp;</div>
            </div>
            <table class="table table-bordered" id="tabledata" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th >Actions</th>
                        <th >Confirmer</th>
                        <th>Réaffecter</th>
                        <th>Réassigner</th>
                        <th>Désassigner</th>
                        <th>Traiter</th>

                        <th>Date d'importation</th>
                        <th>Date d'assignation</th>
                        <th>Date de debut de traitement</th>
                        <th>Date de fin de traitement</th>
                        <th>Date de réalisastion</th>
                        <th>En retard</th>
                        <th>Nombre de jours</th>
                        <th>Nom de base</th>
                        <th>Nouveau nom</th>
                        <th>Assigné par</th>
                        <th class="<?= $isAdmin ? '' : 'hidden' ?>">Assigné À</th>
                        <th>Emplacement</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded by DataTables -->
                </tbody>
            </table>
            <span id="connectedUserId" class="hidden" value=<?php $_SESSION["connectedUser"]->idUtilisateur ?>></span>
            <span id="connectedUserName" class="hidden" value=<?php $_SESSION["connectedUser"]->fullName ?>></span>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).on('click', '#addNewNoteBtn', function() {
        // Set current date and user
        const now = new Date();
        $('#noteDate').val(now.toLocaleString());
        $('#noteAuthor').val('<?= $_SESSION['connectedUser']->fullName ?>');
        
        // Clear editor        
        // Show modal
        $('#addNoteModal').modal('show');
    });

    $(document).on('click', '#saveNoteBtn', async function() {
        const noteContent = tinyMCE.get('noteText').getContent();
        const plainText = $(tinyMCE.get('noteText').getBody()).text();
        const documentId = document.querySelector("#noteModalDocumentId").value;
        // console.log(documentId)
        const userId = <?= $_SESSION['connectedUser']->idUtilisateur ?>;
        const auteur = '<?= $_SESSION['connectedUser']->fullName ?>';
        
        if (noteContent.trim() === '') {
            alert('Veuillez saisir le contenu de la note');
            return;
        }
        
        // Create the note
        await createNote(documentId, userId, auteur, noteContent, plainText)
        await createHistorique(`${auteur} a ajouté une note`);

        setTimeout(() => window.location.reload(), 500);
    });

    function closeModal() {
        $('#errorOperation').modal('hide');
    }

    // HTML escaping function (important for security)
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    $(document).ready(function() {
        $('.large-table-fake-top-scroll-container-3').on('scroll', function () {
        $('.table-responsive').scrollLeft($(this).scrollLeft());
        });
        $('.table-responsive').on('scroll', function () {
        $('.large-table-fake-top-scroll-container-3').scrollLeft($(this).scrollLeft());
        });
        const isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;

        const table = $('#tabledata').DataTable({
            "oLanguage": {
                "sZeroRecords": "Aucune donnée !",
                "sProcessing": "En cours...",
                "sLengthMenu": "Afficher _MENU_ éléments",
                "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                "sInfoEmpty": "Affichage de 0 à 0 sur 0 entrée",
                "sInfoFiltered": "(filtré à partir de _MAX_ total entrées)",
                "sSearch": "Recherche:",
                "oPaginate": {
                    "sPrevious": "Précédent",
                    "sNext": "Suivant"
                }
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": `<?= URLROOT ?>/public/json/scanDocument.php?action=getActivitiesDataTable&connectedUserId=<?= $idUtilisateur ?>&isAdmin=<?= $isAdmin ?>&periode=<?= $periode ?>&dateOne=<?= $dateOne ?>&dateDebut=<?= $dateDebut ?>&dateFin=<?= $dateFin ?>&statut=<?= $statut ?>&idSite=<?= $idSite ?>&userId=<?= $userId ?>`,
                "type": "GET",
                "dataType": "json",
                "data": function(d) {
                    // Add your custom filters
                    d.idUtilisateur = $('#userFilter').val();
                    d.statut = $('#statusFilter').val();
                    d.idSite = $('#siteFilter').val();
                    d.periode = $('#periodFilter').val();
                    d.dateOne = $('#dateOneFilter').val();
                    d.dateDebut = $('#dateStartFilter').val();
                    d.dateFin = $('#dateEndFilter').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('AJAX Error:', xhr.responseText);
                    $('#tabledata').before(
                        '<div class="alert alert-danger">Erreur lors du chargement des données. Veuillez réessayer.</div>'
                    );
                }
            },
            "columns": [
        {
            "data": "DT_RowIndex",
            "render": function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
            "orderable": false
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `<div class="row justify-content-around">
                            <a href="<?= URLROOT ?>/public/documents/repertoires/${row.urlDossier}" 
                               target="_blank" 
                               class="btn btn-sm btn-icon" 
                               style="background: #e74c3c; color:white">
                                <i class="fas fa-eye"></i>
                            </a>
                        <button onclick=openNoteModal(${row.idDocument})  class="btn btn-sm btn-icon" style="background: #e74c3c; color:white"><i class="far fa-sticky-note"></i></button>
                    </div>
                `;
            },
            "orderable": false
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `<div class="row justify-content-around w-100">
                            <button ${row.isAuto == '0' ? 'disabled' : '' }                                 
                            onclick="openConfirmAutoModal(${row.idActivity}, ${row.idDocument}, '${escapeHtml(row.nomDocument)}', '${escapeHtml(row.nouveauNomDocument)}', '${escapeHtml(row.urlDossier)}')"  class="btn btn-sm btn-icon" style="background: #e74c3c; color:white"><i class="fas fa-check"></i>
                            </button>
                        </div>
                `;
            },
            "orderable": false
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `
                    <button onclick="openTransferModal(${row.idActivity})" 
                            class="btn btn-primary" 
                            ${row.isCleared == '1' || row.isAuto == '1' ? 'disabled' : ''}>
                        Réaffecter
                    </button>
                `;
            },
            "orderable": false,
            "visible": isAdmin
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `
                    <button onclick="openReassignerModal(${row.idActivity})" 
                            class="btn btn-primary" 
                            ${row.isCleared == '1' || row.isAuto == '1' ? 'disabled' : ''}>
                        Réassigner
                    </button>
                `;
            },
            "orderable": false,
            "visible": isAdmin
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `
                    <button title="Désassigner" 
                            ${row.isCleared == '1' || row.isAuto == '1' ? 'disabled' : ''} 
                            class="btn btn-danger"
                            onclick="openConfirmModal(${row.idActivity}, ${row.idDocument}, '${escapeHtml(row.urlDossier)}', '${escapeHtml(row.nomDocument)}', '${escapeHtml(row.nouveauNomDocument)}')">
                        <i class="fas fa-times"></i>
                    </button>
                `;
            },
            "orderable": false,
            "visible": isAdmin
        },
        {
            "data": "idActivity",
            "render": function(data, type, row) {
                return `
                    <button title="Traiter" 
                            class="btn btn-warning" 
                            onclick="openTreatModal(${row.idActivity}, '${escapeHtml(row.nomDocument)}', '${escapeHtml(row.nouveauNomDocument)}')" 
                            ${row.isCleared == '1' || row.isAuto == '1' ? 'disabled' : ''}>
                        <i class="fas fa-check"></i>
                    </button>
                `;
            },
            "orderable": false
        },
        { "data": "dateImport" },
        { "data": "dateAssignation" },
        { "data": "dateDebut" },
        { "data": "dateFin" },
        { "data": "dateRealisation" },
        { "data": "enRetard" },
        { "data": "nbrJours" },
        { "data": "nomDocument" },
        { "data": "nouveauNomDocument" },
        { "data": "realisedBy" },
        { 
            "data": "organizer",
            "visible": isAdmin 
        },
        { "data": "url" },
        {
            "data": "status",
            "render": function(data) {
                return data == '1' ? 
                    '<span class="badge badge-success">Traité</span>' : 
                    '<span class="badge badge-danger">Non Traité</span>';
            },
            "orderable": false
        }
    ],
            "order": [
                [5, 'desc']
            ], // Default order by createDate
            "responsive": true,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Tous"]
            ],
            "pageLength": 25
        });

        // Refresh table when filters change
        $('#userFilter, #statusFilter, #siteFilter, #periodFilter, #dateOneFilter, #dateStartFilter, #dateEndFilter')
            .change(function() {
                table.ajax.reload();
            });

        // Update title with record count
        table.on('draw.dt', function() {
            const total = table.page.info().recordsDisplay;
            $('#titre').text(`Liste des tâches (${total})`);
        });
    });

    function openNoteModal(id) {
    // Initialize the table structure
    const noteModalDocIdInput = document.querySelector("#noteModalDocumentId")
    noteModalDocIdInput.value = id
    $('#notesTableContainer').html(`
        <div class="table-responsive">
            <table class="table table-bordered" id="tabledata" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Auteur</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="text-center py-3" id="loadingIndicator">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>
    `);

    $('#noteModal').modal('show');

    $.ajax({
        url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getNotesByDocumentId`,
        method: 'POST',
        data: { idDocument: id },
        dataType: 'json',
        success: function(response) {
            $('#loadingIndicator').remove();
            $(".notes-titre").html("Liste des notes")
            
            // Initialize DataTable with row numbering
            const table = $('#tabledata').DataTable({
                "data": response,
                "columns": [
                    {
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return meta.row + 1; // Returns 1-based index
                        }
                    },
                    { 
                        "data": "dateNote",
                        "render": function(data) {
                            return data ? new Date(data).toLocaleString() : 'N/A';
                        }
                    },
                    { 
                        "data": "auteur",
                        "render": function(data) {
                            return data || 'Inconnu';
                        }
                    },
                    { 
                        "data": "plainText",
                        "render": function(data, type, row) {
                            const text = data || row.noteText || '';
                            return text.length > 100 ? text.substring(0, 100) + '...' : text;
                        }
                    }
                ],
                "language": {
                    "lengthMenu": "Nombre d'éléments: _MENU_",
                    "search": "Recherche:",
                    "paginate": {
                        "previous": "<<",
                        "next": ">>"
                    },
                    "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    "infoEmpty": "Affichage de 0 à 0 sur 0 entrée",
                    "infoFiltered": "(filtré à partir de _MAX_ entrées totales)",
                    "zeroRecords": "Aucune donnée trouvée",
                    "processing": "En cours..."
                },
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "order": [[1, 'desc']] // Default sort by date (column index 1)
            });
        },
        error: function() {
            $('#loadingIndicator').remove();
            $('#tabledata').after('<div class="alert alert-danger mb-0 mt-3">Erreur de chargement des notes. Veuillez réessayer.</div>');
        }
    });
}

    function openTransferModal(id) {
        resetModal();
        $.ajax({
            url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getActivityById`,
            method: 'POST',
            data: {
                idActivity: id
            },
            dataType: 'json',
            success: function(response) {
                const idUtilisateur = document.querySelector("#modalActivityUserId")
                idUtilisateur.value = response.data.idUtilisateur;
                const idActivity = document.querySelector("#modalActivityId")
                idActivity.value = id;
                const createDate = document.querySelector("#modalDocumentCreateDate")
                createDate.value = response.data.createDate
                const editDate = document.querySelector("#modalDocumentEditDate")
                editDate.value = response.data.editDate
                const nomDoc = document.querySelector("#modalDocumentNom")
                nomDoc.value = response.data.nomDocument
                const newNomDoc = document.querySelector("#modalNouveauDocumentNom")
                newNomDoc.value = response.data.nouveauNomDocument
                const urlDoc = document.querySelector("#modalDocumentUrl")
                urlDoc.value = response.data.urlDocument
                const urlDossier = document.querySelector("#modalDossierUrl")
                urlDossier.value = response.data.urlDossier
                loadCompanyUsers(response.data.urlDossier.split('/')[0]);
                $('#leaveRequestModal').modal('show');
            },
            error: function(response) {
                console.error(response);
            }
        });
    }
    
    function openReassignerModal(id) {
        resetModal();
        console.log(id)
        $.ajax({
            url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getActivityById`,
            method: 'POST',
            data: {
                idActivity: id
            },
            dataType: 'json',
            success: function(response) {
                const idUtilisateur = document.querySelector("#modalActivityUserId2")
                idUtilisateur.value = response.data.idUtilisateur;
                const idActivity = document.querySelector("#modalActivityId2")
                idActivity.value = id;
                const createDate = document.querySelector("#modalDocumentCreateDate2")
                createDate.value = response.data.createDate
                const editDate = document.querySelector("#modalDocumentEditDate2")
                editDate.value = response.data.editDate
                const nomDoc = document.querySelector("#modalDocumentNom2")
                nomDoc.value = response.data.nomDocument
                const newNomDoc = document.querySelector("#modalNouveauDocumentNom2")
                newNomDoc.value = response.data.nouveauNomDocument
                const urlDoc = document.querySelector("#modalDocumentUrl2")
                urlDoc.value = response.data.urlDocument
                const urlDossier = document.querySelector("#modalDossierUrl2")
                urlDossier.value = response.data.urlDossier
                loadCompanyUsers(response.data.urlDossier.split('/')[0]);
                $('#leaveRequestModal2').modal('show');
            },
            error: function(response) {
                console.error(response);
            }
        });
    }

    function resetModal() {
        // Reset form elements
        $('#entrepriseSelect').val('').trigger('change');
        $('#folderHierarchy').empty();
        $('#userHierarchy').empty();
        $('#pathDisplay').text('Aucune sélection');

        // Reset stored variables
        selectedPath = [];
        selectedUser = null;

        // Hide any error messages
        $('.error-message').remove();
    }

    $(document).ready(function() {
        loadCompanies();
    });

    function loadCompanies() {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getCompanies`,
            type: 'POST',
            dataType: 'json', // Explicitly expect JSON
            success: function(response) {
                if (response.success) {
                    $('#entrepriseSelect').html('<option value="">-- Sélectionner une entreprise --</option>');
                    response.data.forEach(company => {
                        // Change company.nom to company.nom_societe
                        $('#entrepriseSelect').append(
                            `<option value="${company.id}">${company.nom_societe}</option>`);
                    });
                }
            }
        });
    }

    let selectedPath = []; // To store the complete folder path
    let selectedUser = null; // To store the selected user

    function setSelectedUser(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const selectedUserEmail = selectedOption.getAttribute('data-email');

        selectedUser = {
            id: selectElement.value,
            name: selectedOption.text,
            email: selectedUserEmail
        };
    }

    function loadTopLevelFolders() {
        const companyId = $('#entrepriseSelect').val();
        if (!companyId) return;
        const companySelect = document.querySelector('#entrepriseSelect')
        const companySelectedName = companySelect.options[companySelect.selectedIndex].text;
        selectedPath = [{
            type: 'company',
            name: companySelectedName
        }]; // Reset path with company
        $('#folderHierarchy').empty();

        $.ajax({
            url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders`,
            type: 'POST',
            dataType: 'json', // Explicitly expect JSON
            data: {
                idSociete: companyId,
                idParent: null
            },
            success: function(response) {
                if (response.success) {
                    addFolderSelect(null, response.folders);
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    function addFolderSelect(parentId, folders) {
        const selectId = `folderSelect_${parentId || 'root'}`;

        const selectHtml = `
    <div class="form-group folder-select">
        <select id="${selectId}" class="form-control" onchange="loadChildFolders(${parentId || 'null'}, this.value, this.options[this.selectedIndex].text
)">
            <option value="">-- Sélectionner un répertoire --</option>
            ${folders.map(folder => `<option value="${folder.id}">${folder.nom}</option>`).join('')}
        </select>
    </div>`;

        $('#folderHierarchy').append(selectHtml);
    }

    function loadChildFolders(parentId, folderId, folderName) {
        if (!folderId) {
            // Remove all selects after this one
            $(`#folderSelect_${parentId || 'root'}`).parent().nextAll().remove();
            // Update path to remove subsequent folders
            selectedPath = selectedPath.slice(0, selectedPath.findIndex(item => item.id === parentId) + 1);
            return;
        }

        // Add/update folder in path
        const folderIndex = selectedPath.findIndex(item => item.id === parentId);
        if (folderIndex >= 0) {
            selectedPath = selectedPath.slice(0, folderIndex + 1);
        }
        selectedPath.push({
            type: 'folder',
            id: folderId,
            name: folderName
        });

        $.ajax({
            url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders`,
            type: 'POST',
            dataType: 'json', // Explicitly expect JSON
            data: {
                idSociete: $('#entrepriseSelect').val(),
                idParent: folderId
            },
            success: function(response) {
                const companyId = $('#entrepriseSelect').val()
                const companySelect = document.querySelector('#entrepriseSelect')
                const companySelectedName = companySelect.options[companySelect.selectedIndex].text;
                // Remove all selects after this one
                $(`#folderSelect_${parentId || 'root'}`).parent().nextAll().remove();

                if (response.success) {
                    if (response.folders.length > 0) {
                        // If there are more folders, show folder select
                        addFolderSelect(folderId, response.folders);
                    }
                }
            }
        });
    }

    function loadCompanyUsers(companyName) {
        // const isAdmin = <?= $role ?> == "1" || <?= $role ?> == "2" || <?= $role ?> == "25" ? true : false;
        const isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;

        const connectedUserId = <?= $idUtilisateur; ?>;
        $.ajax({
            url: `<?= URLROOT ?>/public/json/utilisateurs.php?action=getUsersByCompany`,
            type: 'POST',
            dataType: 'json',
            data: {
                companyName: companyName,
                isAdmin: isAdmin,
                connectedUserId: connectedUserId
            },
            success: function(response) {
                addUsersSelect(response);
            }
        });
    }

    function addUsersSelect(users) {
        const selectHtml = `
    <div class="form-group users-select">
        <label class="font-weight-bold">Réassigner</label>
        <select id="userSelect" class="form-control" onchange="setSelectedUser(this)">
            <option value="">-- Sélectionner un utilisateur --</option>
            ${users.map(user => `<option value="${user.idUtilisateur}" data-email="${user.email}">${user.fullName}</option>`).join('')}
        </select>
    </div>
    `;

        $('#userHierarchy').append(selectHtml);
    }

            function createHistorique(historyAction) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=createHistorique`,
                    type: 'POST',
                    data: {
                        fullName: "<?= htmlspecialchars($fullName); ?>",
                        idUtilisateurF: "<?= htmlspecialchars($idUtilisateur); ?>",
                        historyAction: historyAction,
                        idOp: ""
                    },
                    dataType: 'json',
                    success: (response) => response.success ? resolve(true) : reject(new Error(response
                        .error)),
                    error: (xhr, status, error) => reject(new Error(error))
                });
            });
        }

    // Function to create notification
    function createNotification(idUtilisateur, title, message) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/pointage.php?action=createNotification`,
                type: 'POST',
                data: {
                    idUtilisateur: idUtilisateur,
                    title: title,
                    message: message
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        resolve(true);
                    } else {
                        reject(new Error(response.error || "Failed to create notification"));
                    }
                },
                error: function(xhr, status, error) {
                    reject(new Error("AJAX Error: " + error));
                }
            });
        });
    }

     function createNote(idDocument, idUtilisateur, auteur, texte) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=createNote`,
                    type: 'POST',
                    data: {
                        idDocument: idDocument,
                        idUtilisateur: idUtilisateur,
                        auteur: auteur,
                        texte: texte
                    },
                    dataType: 'json',
                    success: (response) => response.success ? resolve(true) : reject(new Error(response
                        .error)),
                    error: (xhr, status, error) => reject(new Error(error))
                });
            });
        }

    function updateActivity(idActivity, assignePar, connectedUserName, urlDoc) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=updateActivity`,
                type: 'POST',
                data: {
                    idActivity: idActivity,
                    assignePar: assignePar,
                    connectedUserName: connectedUserName,
                    urlDoc: urlDoc
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        resolve(true);
                    } else {
                        reject(new Error(response.error || "Failed to update activity"));
                    }
                },
                error: function(xhr, status, error) {
                    reject(new Error("AJAX Error: " + error));
                }
            });
        });
    }

    function updateActivityUser(idActivity, assignePar, connectedUserName, assigneA, userSelectedName) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=updateActivityUser`,
                type: 'POST',
                data: {
                    idActivity: idActivity,
                    assignePar: assignePar,
                    connectedUserName: connectedUserName,
                    assigneA: assigneA,
                    userSelectedName: userSelectedName,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        resolve(true);
                    } else {
                        reject(new Error(response.error || "Failed to update activity"));
                    }
                },
                error: function(xhr, status, error) {
                    reject(new Error("AJAX Error: " + error));
                }
            });
        });
    }

    async function rollbackMove(originalPath, newPath, userId, userName) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=rollBackDocumentEmploye`,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    sourceUrl: newPath,
                    destinationPath: originalPath.split('/').slice(0, -1).join('/'),
                    userId,
                    userName
                }),
                success: function(rollbackData) {
                    if (!rollbackData.success) {
                        reject(new Error("Rollback failed on server"));
                    } else {
                        resolve(rollbackData);
                    }
                },
                error: function(xhr, status, error) {
                    reject(new Error("Rollback HTTP error"));
                }
            });
        });
    }

    function getUsersByCompany(companyName, userSelect) {
        // const isAdmin = <?= $role ?> == "1" || <?= $role ?> == "2" || <?= $role ?> == "25" ? true : false;
        const isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;

        const connectedUserId = <?= $idUtilisateur; ?>;
        $.ajax({
            url: `<?= URLROOT ?>/public/json/utilisateurs.php?action=getUsersByCompany`,
            type: 'POST',
            data: {
                companyName: companyName,
                isAdmin: isAdmin,
                connectedUserId: connectedUserId
            },
            dataType: 'json',
            success: function(response) {
                userSelect.innerHTML = '<option value="">Choisir utilisateur</option>';
                response.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.idUtilisateur;
                    option.textContent = user.fullName;
                    userSelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error creating notification:', error);
            }
        });
    }


    function dateCreationSelect(val) {
        if (val == 2) {
            $('#datepair').show();
            $('#datepairOne').hide();
            $('#anneepair').hide();
        } else if (val == 1) {
            $('#datepairOne').show();
            $('#datepair').hide();
            $('#anneepair').hide();
        } else if (val == "annee") {
            $('#anneepair').show();
            $('#datepair').hide();
            $('#datepairOne').hide();
        } else {
            $('#datepair').hide();
            $('#datepairOne').hide();
            $('#anneepair').hide();
        }
    }

    $(document).ready(function() {
        var dateCreation = $('#dateDemande').val();
        dateCreationSelect(dateCreation);

        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: '<?= date('d-m-Y') ?>',
            weekStart: 1
        });

        $('.time').timepicker({
            showDuration: true,
            timeFormat: 'H:i',
            step: 1
        });
        //  $('.select3').select2();
    });

    let selectedActivityId = null;
    let selectedDocumentId = null;
    let selectedDocUrl = null;
    let currentAction = null;
    let activityNomDoc = null;
    let activityNewNomDoc = null

    function openConfirmModal(activityId, documentId, docUrl, nomDoc, newNomDoc) {
        selectedActivityId = activityId;
        selectedDocumentId = documentId;
        activityNomDoc = nomDoc
        activityNewNomDoc = newNomDoc
        selectedDocUrl = docUrl
        document.getElementById("confirmModalTitle").innerText = "Confirmer la désassociation";
        document.getElementById("confirmModalBody").innerText =
            "Voulez-vous désassocier cette tâche ? Elle sera déplacée dans les documents communs.";
        document.getElementById("confirmModalHeader").className = "modal-header bg-danger text-white";
        $('#confirmModal').modal('show');
    }

    function openTreatModal(id, nomDoc, newNomDoc) {
        selectedActivityId = id;
        activityNomDoc = nomDoc
        activityNewNomDoc = newNomDoc
        document.getElementById("confirmModalTitleTraite").innerText = "Confirmer le traitement";
        document.getElementById("confirmModalBodyTraite").innerText = "Voulez-vous marquer cette tâche comme Clôturée ?";
        document.getElementById("confirmModalHeaderTraite").className = "modal-header bg-success text-white";
        $('#confirmModalTraite').modal('show');
    }

    function openConfirmAutoModal(idActivity, idDocument, nomDoc, newNomDoc, docUrl) {
        selectedActivityId = idActivity;
        selectedDocumentId = idDocument
        selectedDocUrl = docUrl
        activityNomDoc = nomDoc
        activityNewNomDoc = newNomDoc

        document.getElementById("confirmModalTitleAuto").innerText = "Confirmer ou refuser l'assignation automatique";
        document.getElementById("confirmModalBodyAuto").innerText = "Voulez-vous confirmer l'assignation automatique de cette tâche ? Refuser l'assignation automatique déplacera le document vers la corbeille d'arrivée.";
        document.getElementById("confirmModalHeaderAuto").className = "modal-header bg-success text-white";
        $('#confirmModalAuto').modal('show');
    }

    document.getElementById("confirmBtn").addEventListener("click", async () => {
        if (!selectedActivityId || !selectedDocumentId || !selectedDocUrl) return;
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";

        $.ajax({
            url: "<?= URLROOT ?>/public/json/scanDocument.php?action=desassocier",
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({
                action: currentAction,
                idActivity: selectedActivityId,
                idDocument: selectedDocumentId,
                docUrl: selectedDocUrl
            }),
            success: async function(res) {
                if (res.success) {
                    await createHistorique(`${connectedUserName} a remis le document ${activityNomDoc} - ${activityNewNomDoc} à la corbeille`);
                } else {
                    alert(res.message);
                }
            },
            error: function(xhr, status, error) {
                $('#confirmModal').modal('hide');
                alert("Une erreur s'est produite lors de la désassociation.");
            }
        });
        setTimeout(() => window.location.reload(), 500);
    });

    $("#confirm-user-btn").on("click", async function() {
        const idActivity = document.querySelector("#modalActivityId2").value
        const nomDoc = document.querySelector("#modalDocumentNom2").value
        const newNomDoc = document.querySelector('#modalNouveauDocumentNom2').value
        const userSelectedId = selectedUser.id
        const userSelectedName = selectedUser.name
        const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";

        try {
            await updateActivityUser(idActivity, connectedUserId, connectedUserName, userSelectedId,
                userSelectedName);
        } catch (error) {
            $("#msgError").text("Erreur lors de la mise à jour de l'activité.");
            $('#errorOperation').modal('show');
        }
        // Step 3: Create history
        await createHistorique(`${connectedUserName} a réassigné la tâche ${nomDoc} - ${newNomDoc} à ${userSelectedName}`);

        // Step 4: Send notification (non-critical)
        try {
            await createNotification(userSelectedId, "Tâche assignée", "Nouvelle tâche assigné");
        } catch (notificationError) {
            console.error("Notification failed (non-critical):", notificationError);
        }

        // Appel de sendEmail avec l'email dynamique
        const email = selectedUser.email
        const emailSubject = "Affectation de tâche"
        const emailBody = `Bonjour,<br /><br /> Vous avez une nouvelle tâche dans votre répertoire personnel affectée par ${connectedUserName}.<br /><br />
     Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
    Cordialement,<br />
    Votre équipe RH<br />`
        sendEmail(
            email, // Utilisation de l'email dynamique
            emailSubject,
            emailBody
        );
        // setTimeout(() => window.location.reload(), 500);
    })

    $("#confirm-btn").on("click", async function() {
        const idActivity = document.querySelector("#modalActivityId").value
        const createDate = document.querySelector("#modalDocumentCreateDate")
        const editDate = document.querySelector("#modalDocumentEditDate")
        const nomDoc = document.querySelector("#modalDocumentNom").value
        const newNomDoc = document.querySelector('#modalNouveauDocumentNom').value
        const urlDoc = document.querySelector("#modalDocumentUrl")
        const urlDossier = document.querySelector("#modalDossierUrl")
        const fullUrlDoc = "<?= URLROOT ?>/public/documents/repertoires/" + urlDossier.value

        // Validate selections
        if (selectedPath.length == 0) {
            $("#msgError").text("Veuillez remplir tous les champs.");
            $('#errorOperation').modal('show');
            return;
        }
        const fullPath = selectedPath.map(item => item.name).join('/');
        const extDoc = urlDoc.value
        const newDocumentUrl = `${fullPath}/${extDoc}`;
        const idUtilisateur = document.querySelector("#modalActivityUserId")
        const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";

        let originalFilePath; // Store for rollback
        let newFilePath; // Store moved file path
        try {
            // Step 1: Move the file
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=copyDocument`,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    sourceUrl: fullUrlDoc,
                    destinationPath: fullPath,
                    userId: connectedUserId,
                    userName: connectedUserName
                }),
                success: async function(moveData) {
                    if (!moveData.success) throw new Error(moveData.message);
                    // Store paths for rollback
                    originalFilePath = moveData.originalPath;
                    newFilePath = moveData.newPath;
                    // Step 2: Create activity
                    try {
                        await updateActivity(idActivity, connectedUserId, connectedUserName,
                            newDocumentUrl);
                    } catch (activityError) {
                        // Rollback the moved file because createActivity failed
                        $("#msgError").text(
                            "Erreur lors de la création de l'activité. Annulation du déplacement..."
                        );
                        $('#errorOperation').modal('show');
                        await rollbackMove(originalFilePath, newFilePath, connectedUserId,
                            connectedUserName);
                        throw activityError; // rethrow to catch block below
                    }
                    // Step 3: Create history
                     await createHistorique(`${connectedUserName} a réassigné la tâche ${nomDoc} - ${newNomDoc} vers ${fullPath}`);

                    // Step 4: Send notification (non-critical)
                    try {
                        await createNotification(idUtilisateur.value, "Tâche assignée",
                            "Nouvelle tâche assigné");
                    } catch (notificationError) {
                        console.error("Notification failed (non-critical):", notificationError);
                    }
                    // Appel de sendEmail avec l'email dynamique
                    const email = selectedUser.email
                    const emailSubject = "Affectation de tâche"
                    const emailBody = `Bonjour,<br /><br /> Vous avez une nouvelle tâche dans votre répertoire personnel affectée par ${connectedUserName}.<br /><br />
            Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
            Cordialement,<br />
            Votre équipe RH<br />`
                    sendEmail(
                        email, // Utilisation de l'email dynamique
                        emailSubject,
                        emailBody
                    );

                    // setTimeout(() => window.location.reload(), 500);
                },
                error: function(xhr, status, error) {
                    throw new Error("Échec du déplacement du fichier.");
                }
            });
        } catch (error) {
            console.error("Error:", error);

            // Rollback file move if it was successful
            if (originalFilePath && newFilePath) {
                try {
                    await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
                } catch (rollbackError) {
                    console.error("Rollback failed:", rollbackError);
                }
            }
        }
    });

    $("#confirmBtnTraite").on("click", async function() {
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
        if (!selectedActivityId) return;
        let postDataTraite = {
            action: currentAction,
            idActivity: selectedActivityId,
        };

        $.ajax({
            url: "<?= URLROOT ?>/public/json/scanDocument.php?action=traiter",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(postDataTraite),
            success: async function(res) {
                const data = JSON.parse(res)
                if (data.success) {
                    await createHistorique(`${connectedUserName} a traité la tâche ${activityNomDoc} - ${activityNewNomDoc}`);
                }
            },
            error: function(xhr) {
                $('#confirmModalTraite').modal('hide');
                alert(xhr.responseJSON?.error || "Erreur réseau ou serveur");
            }
        });
            setTimeout(() => window.location.reload(), 500);
    });

    $("#confirmBtnAuto").on("click", async function() {
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
        if (!selectedActivityId) return;
        let postDataConfirm = {
            action: currentAction,
            idActivity: selectedActivityId,
        };

        $.ajax({
            url: "<?= URLROOT ?>/public/json/scanDocument.php?action=confirmAssignation",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(postDataConfirm),
            success: async function(res) {
                const data = JSON.parse(res)
                if (data.success) {
                    await createHistorique(`${connectedUserName} a confirmé l'assignation automatique de la tâche ${activityNomDoc} - ${activityNewNomDoc}`);
                }
            },
            error: function(xhr) {
                $('#confirMmodalAuto').modal('hide');
                alert(xhr.responseJSON?.error || "Erreur réseau ou serveur");
            }
        });
            setTimeout(() => window.location.reload(), 500);
    });

    $("#refusBtnAuto").on("click", async function() {
        const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
        if (!selectedActivityId) return;
        let postDataRefus = {
            idActivity: selectedActivityId,
            idDocument: selectedDocumentId,
            docUrl: selectedDocUrl
        };

        $.ajax({
            url: "<?= URLROOT ?>/public/json/scanDocument.php?action=refusAssignation",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(postDataRefus),
            success: async function(res) {
                const data = JSON.parse(res)
                if (data.success) {
                    await createHistorique(`${connectedUserName} a refusé l'assignation automatique de la tâche ${activityNomDoc} - ${activityNewNomDoc}`);
                }
            },
            error: function(xhr) {
                $('#confirMmodalAuto').modal('hide');
                alert(xhr.responseJSON?.error || "Erreur réseau ou serveur");
            }
        });
            setTimeout(() => window.location.reload(), 500);
    });


    function sendEmail(to, subject, body) {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/pointage.php?action=sendEmail`, // URL de la fonction PHP
            type: 'POST',
            data: {
                to: to,
                subject: subject,
                body: body
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Email sent successfully:', response.message);
                } else {
                    console.error('Failed to send email:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending email:', error);
            }
        });
    }
</script>