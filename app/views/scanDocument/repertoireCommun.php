<?php
$user = $_SESSION["connectedUser"];
$idUtilisateur = $user->idUtilisateur;
$fullName = $user->fullName;
$role = $user->idRole;
$viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
$isAdmin = ($role == "1" || $role == "2") ? true : false;
// $isAdmin = $_SESSION['connectedUser']->isAdmin;
?>

<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Sélectionner un répertoire</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formSelectRepertoire">
                <div class="modal-body px-5 py-4">
                    <!-- Folder Hierarchy -->
                    <div id="folderHierarchy">
                        <!-- Dynamic selects will appear here -->
                    </div>
                    <!-- Company Selection -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold"><span id="repertoire-select">2- </span>Sélectionner le répertoire</label>
                        <select id="entrepriseSelect" class="form-control" onchange="loadTopLevelFolders()">
                            <option value="">-- Sélectionner une entreprise --</option>
                            <!-- Options will be loaded dynamically -->
                        </select>
                    </div>
                    <!-- Folder Hierarchy -->
                    <div id="folderHierarchy2">
                        <!-- Dynamic selects will appear here -->
                    </div>
                    <div class="form-group mb-4" id="assigner-container">
                        <label class="font-weight-bold">3- Voulez-vous assigner ce document?</label>
                            <div class="row ml-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="remplacement" id="remplacementOui" value="oui" checked>
                                    <label class="form-check-label" for="remplacementOui">Oui</label>
                                </div>
                                <div class="form-check mx-3">
                                    <input class="form-check-input" type="radio" name="remplacement" id="remplacementNon" value="non">
                                    <label class="form-check-label" for="remplacementNon">Non</label>
                                </div>
                            </div>
                    </div>

                    <div id="folderHierarchy3">
                        <!-- Dynamic selects will appear here -->
                    </div>
                        <!-- Date Selection -->
                    <div id="folderHierarchy4" class="form-group">
                        <label class="font-weight-bold" for="startDate">5- Date de début</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" required>
                    </div>
                        <!-- Rest of your existing modal content -->
                    </div>
                </form>
                <div class="modal-footer px-5 pb-4 pt-0">
                    <button onclick=openConfirmPublierModal() type="submit" id="confirm-btn-2" class="btn btn-danger btn-lg w-100">
                        Confirmer la sélection
                    </button>
                </div>

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

<div class="modal fade" id="confirmPublierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white" id="confirmModalHeaderPublier">
                <h5 class="modal-title" id="confirmModalTitlePublier">Confirmer</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body" id="confirmModalBodyPublier">
                <!-- Le texte sera injecté par JS -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  onclick='openConfirmAffecterModal("non")' data-dismiss="modal">Non</button>
                <button type="button" class="btn btn-danger" onclick='openConfirmAffecterModal("oui")'>Oui</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="confirmAffecterModal" tabindex="-1" aria-hidden="true">
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
                <button type="button" class="btn btn-danger" id="confirm-btn">Confirmer</button>
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
<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> CORBEILLE D'ARRIVÉE
        </h2>
    </div>
</div>


<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="border-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('ScanDocument', 'repertoireCommun') ?>"
                        style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">

                        <div class="row justify-content-center" style="width: 100%;  margin: auto;">
                            <div class="row alig-items-center justify-content-center col-md-10 col-xs-12 mb-3">
                                <fieldset class="py-4 col-md-12 date-picker">
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
                                <fieldset id="datepairOne" class="col-md-4" style="display: none;">
                                    <legend
                                        class='text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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

                                <fieldset id="datepair" class="col-md-4" style="display: none;">
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
                            <div class="col-md-12 text-center">
                                <button type="submit" id="filterButton" class="btn btn-primary form-control" style="margin-top: 0px; width: 200px;
                                    color: #fff;
                                        background-color: #0d6efd;
                                        border-color: #0d6efd;
                                        padding: 0.5rem 1rem;
                                        border-radius: 30px;
                                    ">FILTRER</button>
                                <br><br>
                            </div>
                        </div>
                    </form>
                    <button onclick="test()">Test</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3 text-center bg-secondary">
            <div class="row align-items-center justify-content-center">
                <button style="padding: 0.5rem 1rem; border-radius: 20px" id="btnTransferer" class="btn btn-primary"
                    hidden>
                    <i class="fas fa-exchange-alt" style="color: #ffffff"></i> Affecter (<span
                        id="selectedCount">0</span>)
                </button>
                <h3 class="m-0 mt-2 col-md-10 font-weight-bold text-white">
                    <div class="col-md-10">
                        <h2 class="text-center font-weight-bold" id="titre">Liste des documents</h2>
                    </div>
                </h3>
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
                            <th><input type="checkbox" class="form-control" name="checkAll" id="checkAll"
                                    onclick="onCheckAll()"></th>
                            <th>#</th>
                            <th>Actions</th>
                            <th>Nom document</th>
                            <th>Date de création</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <span id="connectedUserId" class="hidden"
                    value=<?php $_SESSION["connectedUser"]->idUtilisateur ?>></span>
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

    let selectedItems = new Set();
    let publierSelectedVal = ''

            //Lors du choix de la date de début, la date valide la plus proche est aujourd'hui
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('startDate');
    const today = new Date();
    
    // Format today's date as YYYY-MM-DD
    const todayISO = today.toISOString().split('T')[0];
    
    // Set default value to today
    startDateInput.value = todayISO;
    
    // Set min date to today
    const minDate = new Date(today);
    minDate.setDate(today.getDate());
    const minDateISO = minDate.toISOString().split('T')[0];
    
    // Set max date to 1 year from today
    const maxDate = new Date(today);
    maxDate.setFullYear(today.getFullYear() + 1);
    const maxDateISO = maxDate.toISOString().split('T')[0];
    
    startDateInput.min = minDateISO;
    startDateInput.max = maxDateISO;
    
    // Weekend validation
    startDateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const dayOfWeek = selectedDate.getDay();
        
        if (dayOfWeek === 0 || dayOfWeek === 6) {
            document.getElementById("msgError").innerHTML = "Vous ne pouvez pas choisir un weekend.";
            $('#errorOperation').modal('show');
            this.value = todayISO; // Reset to today if weekend is selected
        }
    });
    
    // Prevent manual date entry
    startDateInput.addEventListener('keydown', function(event) {
        event.preventDefault();
    });
});

        function openConfirmAffecterModal(val) {
            document.getElementById("confirmModalTitleTraite").innerText = "Confirmer l'affectation";
            document.getElementById("confirmModalBodyTraite").innerText = "Voulez-vous affecter cette tâche?";
            document.getElementById("confirmModalHeaderTraite").className = "modal-header bg-success text-white";
            publierSelectedVal = val
            $('#confirmAffecterModal').modal('show');
        }

        function openConfirmPublierModal() {
            document.getElementById("confirmModalTitlePublier").innerText = "Confirmer la publication ";
            document.getElementById("confirmModalBodyPublier").innerText = "Voulez-vous publier cette tâche?";
            document.getElementById("confirmModalHeaderPublier").className = "modal-header bg-success text-white";
            $('#confirmPublierModal').modal('show');
        }

        $(document).on('change', 'input[name="remplacement"]', function() {
            if ($(this).val() === 'non') {
                // Hide user selection
                $('#folderHierarchy3').hide();
            } else {
                $('#folderHierarchy3').show();
            }
        });

        // Check/Uncheck all rows
        function onCheckAll() {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.row-checkbox');
            const btnTransferer = document.getElementById('btnTransferer');
            const selectedCount = document.getElementById('selectedCount');

            // Toggle all checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
                const docId = checkbox.dataset.id;

                if (checkAll.checked) {
                    selectedItems.add(docId);
                } else {
                    selectedItems.delete(docId);
                }
            });

            // Update UI
            updateTransferButton();
        }

        // Handle individual row selection
        function onCheckOne(checkbox) {
            const docId = checkbox.dataset.id;

            if (checkbox.checked) {
                selectedItems.add(docId);
            } else {
                selectedItems.delete(docId);
                document.getElementById('checkAll').checked = false;
            }

            updateTransferButton();
        }

        // Update the transfer button state
        function updateTransferButton() {
            const btnTransferer = document.getElementById('btnTransferer');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = selectedItems.size;

            if (selectedItems.size > 0) {
                btnTransferer.removeAttribute('hidden');
            } else {
                btnTransferer.setAttribute('hidden', 'hidden');
            }
        }


        function closeModal() {
            $('#errorOperation').modal('hide');
        }

        $(document).ready(function() {
            // Synchronisation scroll horizontal entre la fausse barre et la vraie
            $('.large-table-fake-top-scroll-container-3').on('scroll', function () {
            $('.table-responsive').scrollLeft($(this).scrollLeft());
            });
            $('.table-responsive').on('scroll', function () {
            $('.large-table-fake-top-scroll-container-3').scrollLeft($(this).scrollLeft());
            });
            const table = $('#tabledata').DataTable({
                "oLanguage": {
                    "sZeroRecords": "Aucune donnée !",
                    "sProcessing": "En cours...",
                    "sLengthMenu": "Nombre d'éléments _MENU_ ",
                    "sInfo": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                    "sInfoEmpty": "Affichage de 0 à 0 sur 0 entrée",
                    "sInfoFiltered": "(filtré à partir de _MAX_ total entrées)",
                    "sSearch": "Recherche:",
                },
                "language": {
                    "paginate": {
                        "previous": "<<",
                        "next": ">>"
                    }
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": `<?= URLROOT ?>/public/json/scanDocument.php?action=getRepertoireCommunDataTable&periode=<?= $periode ?>&dateOne=<?= $dateOne ?>&dateDebut=<?= $dateDebut ?>&dateFin=<?= $dateFin ?>`,
                    "type": "GET",
                    "data": function(d) {
                        // Add your custom filters to the DataTables request
                        d.periode = $('#periodeFilter').val();
                        d.dateOne = $('#dateOneFilter').val();
                        d.dateDebut = $('#dateDebutFilter').val();
                        d.dateFin = $('#dateFinFilter').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error("Erreur AJAX :", xhr.responseText);
                        alert("Erreur lors du chargement des données. Vérifie la console.");
                    }
                },
"columns": [
    {
        "data": "checkbox",
        "orderable": false,
        "render": function(data, type, row) {
            return `<input type="checkbox" class="row-checkbox form-control" 
                name="checkOne" data-id="${row.idDocument}" 
                onclick="onCheckOne(this)">`;
        }
    },
    {
        "data": null, // auto-increment index
        "render": function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
        "orderable": false
    },
    {
        "data": "viewButton",
        "orderable": false,
        "render": function(data, type, row) {
            return `<div class="row justify-content-around w-100">
            <a href="<?=URLROOT?>/public/documents/repertoireCommun/${row.urlDocument}" target="_blank" class="btn btn-sm btn-icon" style="background: #e74c3c; color:white"><i class="fas fa-eye"></i></a>
            <button onclick=openNoteModal(${row.idDocument})  class="btn btn-sm btn-icon" style="background: #e74c3c; color:white"><i class="far fa-sticky-note"></i></button>
        </div>`;
        }
    },
    {
        "data": "nomDocument"
    },
    {
        "data": "createDateRaw", // used for sorting
        "render": function(data, type, row) {
            return row.createDate; // show formatted
        }
    },
    {
        "data": "actionButton",
        "orderable": false,
        "render": function(data, type, row) {
            return `<button onclick=openTransferModal(${row.idDocument}) class="btn btn-primary">Affecter</button>`;
        }
    }
],

                "drawCallback": function(settings) {
                    // Clear selections when table is redrawn
                    selectedItems.clear();
                    document.getElementById('checkAll').checked = false;
                    updateTransferButton();
                },
                "order": [
                    [3, 'desc']
                ] // Default order by createDate
            });

            // Refresh table when filters change
            $('#periodeFilter, #dateOneFilter, #dateDebutFilter, #dateFinFilter').change(function() {
                table.ajax.reload();
            });

            // Update title with record count
            table.on('draw.dt', function() {
                const total = table.page.info().recordsDisplay;
                $('#titre').text(`Liste des documents (${total})`);
            });

            $('#btnTransferer').click(function() {
                if (selectedItems.size === 0) {
                    alert('Veuillez sélectionner au moins un document');
                    return;
                }
                // Convert Set to Array
                const selectedIds = Array.from(selectedItems);

                // Here you would implement your bulk transfer logic
                console.log('Documents selected for transfer:', selectedIds);
                // Open your transfer modal and pass the selected IDs
                openBulkTransferModal(selectedIds);
            });
        });

        let idsBulk = []
        let createDatesBulk = []
        let editDatesBulk = []
        let nomDocsBulk = []
        let urlDocsBulk = []

        function openBulkTransferModal(documentIds) {
            resetModal()
            documentIds.forEach(id => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getDocumentById`,
                    method: 'POST',
                    data: {
                        idDocument: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        idsBulk.push(id);
                        createDatesBulk.push(response.data.createDate)
                        editDatesBulk.push(response.data.editDate)
                        nomDocsBulk.push(response.data.nomDocument)
                        urlDocsBulk.push(response.data.urlDocument)

                        $('#leaveRequestModal').modal('show');
                    },
                    error: function(response) {
                        console.error('Erreur lors de la récupération des détails du document:',
                            response);
                        // alert('Une erreur s\'est produite lors de la récupération des détails.');
                    }
                });
            })
            // Implement your modal opening and transfer logic here
            console.log('Opening bulk transfer modal for documents:', documentIds);

            // Example:
            $('#leaveRequestModal').modal('show');
        }

        function dateCreationSelect(val) {
            if (val == 2) {
                $('#datepair').show();
                $('#datepairOne').hide();
                $('#anneepair').hide();
                $(".date-picker").removeClass("col-md-12");
                $(".date-picker").addClass("col-md-4");
            } else if (val == 1) {
                $('#datepairOne').show();
                $('#datepair').hide();
                $('#anneepair').hide();
                $(".date-picker").removeClass("col-md-12");
                $(".date-picker").addClass("col-md-4");
            } else if (val == "annee") {
                $('#anneepair').show();
                $('#datepair').hide();
                $('#datepairOne').hide();
                $(".date-picker").removeClass("col-md-4");
                $(".date-picker").addClass("col-md-12");
            } else {
                $('#datepair').hide();
                $('#datepairOne').hide();
                $('#anneepair').hide();
                $(".date-picker").removeClass("col-md-4");
                $(".date-picker").addClass("col-md-12");
            }
        }

        function openTransferModal(id) {
            $('#assigner-container').hide();
            $('#repertoire-select').hide();
            resetModal();
            selectedItems = new Set();
            const selectedIds = Array.from(selectedItems);
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getDocumentById`,
                method: 'POST',
                data: {
                    idDocument: id
                },
                dataType: 'json',
                success: function(response) {
                    const idDocument = document.querySelector("#modalDocumentId")
                    idDocument.value = id;
                    const createDate = document.querySelector("#modalDocumentCreateDate")
                    createDate.value = response.data.createDate
                    const editDate = document.querySelector("#modalDocumentEditDate")
                    editDate.value = response.data.editDate
                    const nomDoc = document.querySelector("#modalDocumentNom")
                    nomDoc.value = response.data.nomDocument
                    const urlDoc = document.querySelector("#modalDocumentUrl")
                    urlDoc.value = response.data.urlDocument
                    $('#leaveRequestModal').modal('show');
                },
                error: function(response) {
                    console.error('Erreur lors de la récupération des détails du document:', response);
                    // alert('Une erreur s\'est produite lors de la récupération des détails.');
                }
            });
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
                    success: (response) => response.success ? resolve(true) : reject(new Error(response
                        .error)),
                    error: (xhr, status, error) => reject(new Error(error))
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

        function createActivity(idDocument, assignePar, connectedUserName, assigneA, userSelectedName, nomDoc, newNomDoc,
            urlDoc, isConfirmOui, publierSelectedVal, startDateInput) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=createActivity`,
                    type: 'POST',
                    data: {
                        assignePar: assignePar,
                        connectedUserName: connectedUserName,
                        assigneA: assigneA,
                        userSelectedName: userSelectedName,
                        idDocument,
                        idDocument,
                        nomDoc: nomDoc,
                        newNomDoc: newNomDoc,
                        urlDoc: urlDoc,
                        isConfirmOui,
                        publierSelectedVal,
                        startDate: startDateInput
                    },
                    dataType: 'json',
                    success: (response) => response.success ? resolve(true) : reject(new Error(response
                        .error)),
                    error: (xhr, status, error) => reject(new Error(error))
                });
            });
        }

        function deleteDocument(id) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=deleteDocument`,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: (response) => response.success ? resolve(true) : reject(new Error(response
                        .error)),
                    error: (xhr, status, error) => reject(new Error(error))
                });
            });
        }

        async function rollbackMove(originalPath, newPath, userId, userName) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=rollBackDocument`,
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


        // Load companies when modal opens

        let connectedUserSociete = ''
        let connectedUserSocieteId = ''
        let isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;
        $(document).ready(function() {
            $('#leaveRequestModal').on('show.bs.modal', function() {
                resetModal();
                if (!isAdmin && connectedUserSocieteId) {
                    loadTopLevelFolders(); // Auto-load for non-admins
                }
            });
            if (!isAdmin) {
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getCompanyByUserId`,
                    method: 'POST',
                    data: {
                        idUtilisateur: '<?= $idUtilisateur ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        connectedUserSociete = response.data.nom_societe
                        connectedUserSocieteId = response.data.id
                        loadCompanies();
                    },
                    error: function(response) {
                        console.error('Erreur lors de la récupération des détails du pointage:',
                            response);
                        // alert('Une erreur s\'est produite lors de la récupération des détails.');
                    }
                });
            } else {
                loadCompanies()
            }
        });

        function loadCompanies() {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getCompanies`,
                type: 'POST',
                dataType: 'json', // Explicitly expect JSON
                success: function(response) {
                    console.log(response)
                    if (response.success) {
                        const select = $('#entrepriseSelect');
                        select.empty();

                        if (isAdmin) {
                            select.append('<option value="">-- Sélectionner une entreprise --</option>');
                            response.data.forEach(company => {
                                select.append(
                                    `<option value="${company.id}">${company.nom_societe}</option>`);
                            });
                        } else {
                            // For non-admin, add only their company and trigger load
                            select.append(
                                `<option value="${connectedUserSocieteId}" selected>${connectedUserSociete}</option>`
                            );
                            select.prop('disabled', true);
                            loadTopLevelFolders(); // Automatically load folders
                        }

                    }
                }
            });
        }

        let selectedPath = []; // To store the complete folder path
        let selectedUser = null; // To store the selected user


        function loadTopLevelFolders() {
            const companyId = isAdmin ? $('#entrepriseSelect').val() : connectedUserSocieteId;
            console.log(companyId)

            if (!companyId) return;
            const companySelect = document.querySelector('#entrepriseSelect')
            const companySelectedName = isAdmin ? companySelect.options[companySelect.selectedIndex].text :
                connectedUserSociete;
            selectedPath = [{
                type: 'company',
                name: isAdmin ? companySelectedName : connectedUserSociete
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
                    console.log("response.folders")
                    console.log(response)
                    if (response.success) {
                        addFolderSelect(null, response.folders);
                        loadCompanyUsers(companySelectedName);
                        $('#assigner-container').show();
                        $('#repertoire-select').show();
                    }
                },
                error: function(response) {
                    console.log("erreur")
                    console.log(response)
                }
            });
        }

        function addFolderSelect(parentId, folders) {
            const selectId = `folderSelect_${parentId || 'root'}`;
            const companyId = isAdmin ? $('#entrepriseSelect').val() : connectedUserSocieteId;

            const selectHtml = `
                <div class="form-group folder-select">
                    <select id="${selectId}" class="form-control" 
                            onchange="loadChildFolders(
                                ${parentId || 'null'}, 
                                this.value, 
                                this.options[this.selectedIndex].text
                            )">
                        <option value="">-- Sélectionner un répertoire --</option>
                        ${folders.map(folder => `<option value="${folder.id}">${folder.nom}</option>`).join('')}
                    </select>
                </div>`;
            $('#folderHierarchy2').append(selectHtml);
        }

        function loadChildFolders(parentId, folderId, folderName) {
            if (!folderId) {
                // Remove all selects after this one
                $(`#folderSelect_${parentId || 'root'}`).parent().nextAll().remove();
                // Update path to remove subsequent folders
                // selectedPath = selectedPath.slice(0, selectedPath.findIndex(item => item.id === parentId) + 1);
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
            const companyId = isAdmin ? $('#entrepriseSelect').val() : connectedUserSocieteId;

            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders`,
                type: 'POST',
                dataType: 'json', // Explicitly expect JSON
                data: {
                    idSociete: companyId,
                    idParent: folderId
                },
                success: function(response) {
                    console.log(response);
                    const companySelect = document.querySelector('#entrepriseSelect')
                    const companySelectedName = isAdmin ? companySelect.options[companySelect.selectedIndex]
                        .text : connectedUserSociete;
                    // Remove all selects after this one
                    $(`#folderSelect_${parentId || 'root'}`).parent().nextAll().remove();

                    if (response.success) {
                        if (response.folders.length > 0) {
                            // If there are more folders, show folder select
                            addFolderSelect(folderId, response.folders);
                        } else {
                            // If no more folders, show users select
                        }
                    }
                }
            });
        }

        function loadCompanyUsers(companyName) {
            const isAdmin = true;

            const connectedUserId = <?= $idUtilisateur; ?>;
            $.ajax({
                url: `<?= URLROOT ?>/public/json/utilisateur.php?action=getUsersByCompany`,
                type: 'POST',
                dataType: 'json',
                data: {
                    companyName: companyName,
                    isAdmin: isAdmin,
                    connectedUserId: connectedUserId
                },
                success: function(response) {
                    $('#folderHierarchy4').show()
                    addUsersSelect(response);
                }
            });
        }

        function addUsersSelect(users) {
            const selectHtml1 = `
            <div class="form-group users-select">
                <label class="font-weight-bold">1- Nom du document</label>
                <input class="form-control document-input" placeholder="Nom du document"/>
            </div>
            `;
            const selectHtml2 = `
            <div class="form-group users-select">
                <label class="font-weight-bold">4- Sélectionner un utilisateur</label>
                <select id="userSelect" class="form-control" onchange="setSelectedUser(this)">
                    <option value="">-- Sélectionner un utilisateur --</option>
                    ${users.map(user => `<option value="${user.idUtilisateur}" data-email="${user.email}">${user.fullName}</option>`).join('')}
                </select>
            </div>
            `;

            $('#folderHierarchy').append(selectHtml1);
            $('#folderHierarchy3').append(selectHtml2);
        }

        function setSelectedUser(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const selectedUserEmail = selectedOption.getAttribute('data-email');

            selectedUser = {
                id: selectElement.value,
                name: selectedOption.text,
                email: selectedUserEmail
            };
        }

        function resetModal() {
            $('.folder-select').empty();
            $('#folderHierarchy').empty();
            $('#folderHierarchy3').empty();
            $('#assigner-container').hide();
            $('#repertoire-select').hide();
            $('#folderHierarchy4').hide();
            //Reset date debut
            const startDateInput = document.getElementById('startDate');
            const today = new Date();
            // Format today's date as YYYY-MM-DD
            const todayISO = today.toISOString().split('T')[0];
            // Set default value to today
            startDateInput.value = todayISO;

            selectedPath = [];
            selectedUser = null;
            if (isAdmin) {
                $('#entrepriseSelect').val('').prop('disabled', false);
            } else {
                $('#entrepriseSelect').prop('disabled', true);
            }
        }

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

         $("#confirm-btn").on("click", async function() {
            const isConfirmOui = $('#remplacementOui').is(':checked') ? true : false
            
            const idDocument = document.querySelector("#modalDocumentId")
            const createDate = document.querySelector("#modalDocumentCreateDate")
            const editDate = document.querySelector("#modalDocumentEditDate")
            const nomDoc = document.querySelector("#modalDocumentNom")
            const newNomDoc = document.querySelector('.document-input')
            const urlDoc = document.querySelector("#modalDocumentUrl")
            const startDateInput = document.getElementById('startDate');

            console.log(idsBulk);
            console.log(createDatesBulk);
            console.log(editDatesBulk);
            console.log(nomDocsBulk);
            console.log(urlDocsBulk);

            // Validate selections
            if (isConfirmOui && (!startDateInput.value || !newNomDoc?.value || selectedPath?.length == 0 || !selectedUser?.name)) {
                $("#msgError").text("Veuillez remplir tous les champs.");
                $('#errorOperation').modal('show');
                return;
            }

            if(!isConfirmOui && (!newNomDoc?.value || selectedPath.length == 0)) {
                $("#msgError").text("Veuillez remplir tous les champs.");
                $('#errorOperation').modal('show');
                return;
            }
            const user = isConfirmOui ? selectedUser.id : '1';
            const userSelectedName = isConfirmOui ? selectedUser.name : 'wbcc'
            const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
            const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
            const fullPath = selectedPath.map(item => item.name).join('/');

            let originalFilePath; // Store for rollback
            let newFilePath; // Store moved file path

            if (idsBulk.length == 0) {
                const extDoc = urlDoc.value
                const fullUrlDoc = "<?= URLROOT ?>/public/documents/repertoireCommun/" + urlDoc.value
                const newDocumentUrl = `${fullPath}/${extDoc}`;
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
                            console.log(moveData)
                            if (!moveData.success) throw new Error(moveData.message);
                            // Store paths for rollback
                            originalFilePath = moveData.originalPath;
                            newFilePath = moveData.newPath;
                            // Step 2: Create activity
                            try {
                                await createActivity(idDocument.value, connectedUserId,
                                    connectedUserName, user, userSelectedName, nomDoc.value,
                                    newNomDoc.value, newDocumentUrl, isConfirmOui, publierSelectedVal, startDateInput.value);
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
                            await createHistorique(`${connectedUserName} a associé le document ${nomDoc.value} - ${newNomDoc.value} à ${userSelectedName}`);
                            const texte = `${connectedUserName} a affecté ce document.`
                            await createNote(idDocument.value, connectedUserId, connectedUserName, texte)
                            // Step 4: Send notification
                            try {
                                await createNotification(user, "Tâche assignée",
                                    "Nouvelle tâche assigné");
                            } catch (notificationError) {
                                console.error("Notification failed (non-critical):",
                                    notificationError);
                            }

                            // Step 5: Delete original record
                            await deleteDocument(idDocument.value);


                            // Appel de sendEmail avec l'email dynamique
                                if(isConfirmOui) {
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
                                }
                            publierSelectedVal = ''
                            setTimeout(() => window.location.reload(), 500);
                        },
                        error: function(response) {
                            console.log("error")
                            console.log(response)
                            throw new Error("Échec du déplacement du fichier.");
                        }
                    });
                } catch (error) {
                    console.error("Error:", error);

                    // Rollback file move if it was successful
                    if (originalFilePath && newFilePath) {
                        try {
                            await rollbackMove(originalFilePath, newFilePath, connectedUserId,
                                connectedUserName);
                        } catch (rollbackError) {
                            console.error("Rollback failed:", rollbackError);
                        }
                    }
                }
            } else {
                idsBulk.forEach(async (id, index) => {
                    const extDoc = urlDocsBulk[index]
                    const fullUrlDoc = "<?= URLROOT ?>/public/documents/repertoireCommun/" +
                        urlDocsBulk[index]
                    const newDocumentUrl = `${fullPath}/${extDoc}`;

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
                                if (!moveData.success) throw new Error(moveData
                                    .message);
                                // Store paths for rollback
                                originalFilePath = moveData.originalPath;
                                newFilePath = moveData.newPath;
                                // Step 2: Create activity
                                console.log(newDocumentUrl)
                                try {
                                    await createActivity(id, connectedUserId,
                                        connectedUserName, user, userSelectedName,
                                        nomDocsBulk[index], newNomDoc.value,
                                        newDocumentUrl, isConfirmOui, publierSelectedVal, startDateInput.value);
                                } catch (activityError) {
                                    // Rollback the moved file because createActivity failed
                                    $("#msgError").text(
                                        "Erreur lors de la création de l'activité. Annulation du déplacement..."
                                    );
                                    $('#errorOperation').modal('show');
                                    await rollbackMove(originalFilePath, newFilePath,
                                        connectedUserId, connectedUserName);
                                    throw activityError; // rethrow to catch block below
                                }

                                // Step 3: Create history
                                await createHistorique(`${connectedUserName} $ associé le document ${nomDocsBulk[index]} - ${newNomDoc.value} à ${userSelectedName}`);
                                const texte = `${connectedUserName} a affecté ce document.`
                                await createNote(id, connectedUserId, connectedUserName, texte)
                            
                                // Step 4: Send notification
                                try {
                                    await createNotification(user, "Tâche assignée", "Nouvelle tâche assigné");
                                } catch (notificationError) {
                                    console.error("Notification failed (non-critical):",
                                        notificationError);
                                }

                                // Step 5: Delete original record
                                await deleteDocument(idsBulk[index]);


                                // Appel de sendEmail avec l'email dynamique
                                if(isConfirmOui) {
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
                                }
                                publierSelectedVal = ''
                                setTimeout(() => window.location.reload(), 500);
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
                                await rollbackMove(originalFilePath, newFilePath, connectedUserId,
                                    connectedUserName);
                            } catch (rollbackError) {
                                console.error("Rollback failed:", rollbackError);
                            }
                        }
                    }
                })
            }
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

        function test() {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/scanDocument.php?action=transferDocumentIA`, // URL de la fonction PHP
                type: 'POST',
                data: {},
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