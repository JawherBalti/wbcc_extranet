<?php
    $user = $_SESSION["connectedUser"];
    $idUtilisateur = $user->idUtilisateur;
    $isAdmin = $user->isAdmin;
    $fullName = $user->fullName;
    $role = $user->idRole;
    $viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
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
          <!-- Company Selection -->
          <div class="form-group mb-4">
            <label class="font-weight-bold">Entreprise</label>
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
    </form>
    <div class="modal-footer px-5 pb-4 pt-0">
      <button type="submit" id="confirm-btn" class="btn btn-danger btn-lg w-100">
        Confirmer la sélection
      </button>
    </div>
        <input type="hidden" id="modalDocumentId">
        <input type="hidden" id="modalDocumentCreateDate">
        <input type="hidden" id="modalDocumentEditDate">
        <input type="hidden" id="modalDocumentNom">
        <input type="hidden" id="modalDocumentUrl">
    </div>
  </div>
</div>

    
    <!-- MODAL ERROR -->
    <div class="modal fade modal-center" id="errorOperation">
        <div class="modal-dialog modal-lg bg-white">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 id="msgError" style="color:red"></h3>
                    <button onclick="closeModal()" class="btn btn-danger" data-dismiss="modal" data-bs-dismiss="modal">OK</button>
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
            </span> RÉPERTOIRE COMMUN
        </h2>
    </div>
</div>


<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('GestionDocuments', 'repertoireCommun') ?>"
                        style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">
                        
                        <div class="row justify-content-center" style="width: 100%;  margin: auto;">
                            <div
                                class="row alig-items-center justify-content-center col-md-10 col-xs-12 mb-3">
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
                                            value="<?= isset($dateOne) ? $dateOne : ''; ?>"
                                            placeholder="Choisir..." />
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
                                            value="<?= isset($dateFin) ? $dateFin : ''; ?>"
                                            placeholder="Choisir..." />
                                    </p>
                                </fieldset>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <br>
                                <button type="submit" id="filterButton" class="btn btn-primary form-control"
                                    style="margin-top: 0; border-radius: 0px; background: #c00000; ">FILTRER</button>
                                <br><br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="card shadow mt-3">
        <div class="card-header py-3 text-center">
            <div class="row align-items-center justify-content-center">
                <h3 class="m-0 mt-2 col-md-10 font-weight-bold text-primary">
                <div class="col-md-10">
                    <h2 class="text-center font-weight-bold" id="titre">Liste des documents</h2>
                </div>
                </h3>
            </div>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="tabledata" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Visualiser</th>
                        <th>Nom document</th>
                        <th>Date de création</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <span id="connectedUserId" class="hidden" value=<?php $_SESSION["connectedUser"]->idUtilisateur?>></span>
            <span id="connectedUserName" class="hidden" value=<?php $_SESSION["connectedUser"]->fullName?>></span>
        </div>
    </div>
</div>

<script type="text/javascript">

    function closeModal() {
        $('#errorOperation').modal('hide');
    }

$(document).ready(function() {
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
            "url": `<?= URLROOT ?>/public/json/documents.php?action=getRepertoireCommunDataTable&periode=<?= $periode ?>&dateOne=<?= $dateOne ?>&dateDebut=<?= $dateDebut ?>&dateFin=<?= $dateFin ?>`,
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
                "data": null,
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                "orderable": false
            },
            { "data": 1, "orderable": false },
            { "data": 2 },
            { "data": 3 },
            { "data": 4, "orderable": false }
        ],
        "order": [[3, 'desc']] // Default order by createDate
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
});

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
        resetModal();
        
        $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=getDocumentById`,
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
                console.error('Erreur lors de la récupération des détails du pointage:', response);
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
                url: `<?= URLROOT ?>/public/json/documents.php?action=createHistorique`,
                type: 'POST',
                data: {
                    fullName: "<?= htmlspecialchars($fullName); ?>",
                    idUtilisateurF: "<?= htmlspecialchars($idUtilisateur); ?>",
                    historyAction: historyAction
                },
                dataType: 'json',
                success: (response) => response.success ? resolve(true) : reject(new Error(response.error)),
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
                success: (response) => response.success ? resolve(true) : reject(new Error(response.error)),
                error: (xhr, status, error) => reject(new Error(error))
            });
        });
    }

    function createActivity(idDocument, assignePar, connectedUserName, assigneA, userSelectedName, nomDoc, newNomDoc, urlDoc) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/documents.php?action=createActivity`,
                type: 'POST',
                data: {
                    assignePar: assignePar,
                    connectedUserName: connectedUserName,
                    assigneA: assigneA,
                    userSelectedName: userSelectedName,
                    idDocument, idDocument,
                    nomDoc: nomDoc,
                    newNomDoc: newNomDoc,
                    urlDoc: urlDoc
                },
                dataType: 'json',
                success: (response) => response.success ? resolve(true) : reject(new Error(response.error)),
                error: (xhr, status, error) => reject(new Error(error))
            });
        });
    }

    function deleteDocument(id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/documents.php?action=deleteDocument`,
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: (response) => response.success ? resolve(true) : reject(new Error(response.error)),
                error: (xhr, status, error) => reject(new Error(error))
            });
        });
    }

async function rollbackMove(originalPath, newPath, userId, userName) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=rollBackDocument`,
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
let isAdmin = <?= $isAdmin ?> ? true : false

$(document).ready(function() {
        $('#leaveRequestModal').on('show.bs.modal', function() {
        resetModal();
        if(!isAdmin && connectedUserSocieteId) {
            loadTopLevelFolders(); // Auto-load for non-admins
        }
    });
    if(!isAdmin) {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=getCompanyByUserId`,
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
                console.error('Erreur lors de la récupération des détails du pointage:', response);
                    // alert('Une erreur s\'est produite lors de la récupération des détails.');
            }
        });
    } else {
        loadCompanies()
    }
});

function loadCompanies() {
    $.ajax({
        url: `<?= URLROOT ?>/public/json/documents.php?action=getCompanies`,
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        success: function(response) {
        if(response.success) {
                const select = $('#entrepriseSelect');
                select.empty();
                
                if(isAdmin) {
                    select.append('<option value="">-- Sélectionner une entreprise --</option>');
                    response.data.forEach(company => {
                        select.append(`<option value="${company.id}">${company.nom_societe}</option>`);
                    });
                } else {
                    // For non-admin, add only their company and trigger load
                    select.append(`<option value="${connectedUserSocieteId}" selected>${connectedUserSociete}</option>`);
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

    if(!companyId) return;
    const companySelect = document.querySelector('#entrepriseSelect')
    const companySelectedName = isAdmin ? companySelect.options[companySelect.selectedIndex].text : connectedUserSociete;
    selectedPath = [{ type: 'company', name: isAdmin ? companySelectedName : connectedUserSociete }]; // Reset path with company
    $('#folderHierarchy').empty();

    $.ajax({
        url: `<?= URLROOT ?>/public/json/documents.php?action=getFolders`,
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        data: { 
            idSociete: companyId,
            idParent: null 
        },
        success: function(response) {
            if(response.success) {
                addFolderSelect(null, response.data);
            }
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
    
    $('#folderHierarchy').append(selectHtml);
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
    selectedPath.push({ type: 'folder', id: folderId, name: folderName});
    const companyId = isAdmin ? $('#entrepriseSelect').val() : connectedUserSocieteId;

    $.ajax({
        url: `<?= URLROOT ?>/public/json/documents.php?action=getFolders`,
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        data: { 
            idSociete: companyId,
            idParent: folderId 
        },
        success: function(response) {
            const companySelect = document.querySelector('#entrepriseSelect')
            const companySelectedName = isAdmin ? companySelect.options[companySelect.selectedIndex].text : connectedUserSociete;
            // Remove all selects after this one
            $(`#folderSelect_${parentId || 'root'}`).parent().nextAll().remove();
            
            if(response.success) {
                if(response.data.length > 0) {
                    // If there are more folders, show folder select
                    addFolderSelect(folderId, response.data);
                } else {
                    // If no more folders, show users select
                    loadCompanyUsers(companySelectedName);
                }
            }
        }
    });
}

function loadCompanyUsers(companyName) {
    const isAdmin = <?= $role ?> == "1" || <?= $role ?> == "2" || <?= $role ?> == "25" ? true : false;

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
        <label class="font-weight-bold">Sélectionner un utilisateur</label>
        <select id="userSelect" class="form-control" onchange="setSelectedUser(this)">
            <option value="">-- Sélectionner un utilisateur --</option>
            ${users.map(user => `<option value="${user.idUtilisateur}" data-email="${user.email}">${user.fullName}</option>`).join('')}
        </select>
    </div>
    <div class="form-group users-select">
        <label class="font-weight-bold">Nom du document</label>
        <input class="form-control document-input" placeholder="Nom du document"/>
    </div>
    
    `;
    
    $('#folderHierarchy').append(selectHtml);
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
    $('#folderHierarchy').empty();
    $('#pathDisplay').text('Aucune sélection');
    selectedPath = [];
    selectedUser = null;
    
    if(isAdmin) {
        $('#entrepriseSelect').val('').prop('disabled', false);
    } else {
        $('#entrepriseSelect').prop('disabled', true);
    }
}

$("#confirm-btn").on("click", async function () {
    const idDocument = document.querySelector("#modalDocumentId")
    const createDate = document.querySelector("#modalDocumentCreateDate")
    const editDate = document.querySelector("#modalDocumentEditDate")
    const nomDoc = document.querySelector("#modalDocumentNom")
    const newNomDoc = document.querySelector('.document-input')
    const urlDoc = document.querySelector("#modalDocumentUrl")
    const fullUrlDoc = "<?= URLROOT ?>/public/documents/repertoireCommun/" + urlDoc.value

    // Validate selections
        if (!newNomDoc?.value || selectedPath.length == 0 || !selectedUser.name) {
                $("#msgError").text("Veuillez remplir tous les champs.");
                $('#errorOperation').modal('show');
            return;
        }
    const user = selectedUser.id;
    const userSelectedName = selectedUser.name
    const fullPath = selectedPath.map(item => item.name).join('/');
    const extDoc = urlDoc.value
    const newDocumentUrl = `${fullPath}/${extDoc}`;
    const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
    const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
        
    let originalFilePath; // Store for rollback
    let newFilePath; // Store moved file path

    try {
        // Step 1: Move the file
    $.ajax({
        url: `<?= URLROOT ?>/public/json/documents.php?action=copyDocument`,
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
            console.log(newDocumentUrl)
            try {
                await createActivity(idDocument.value, connectedUserId, connectedUserName, user, userSelectedName, nomDoc.value, newNomDoc.value, newDocumentUrl);
            } catch (activityError) {
                // Rollback the moved file because createActivity failed
                $("#msgError").text("Erreur lors de la création de l'activité. Annulation du déplacement...");
                $('#errorOperation').modal('show');
                await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
                throw activityError;  // rethrow to catch block below
            }
            
            // Step 3: Create history
            await createHistorique("Assignation");

            // Step 4: Send notification (non-critical)
            try {
                await createNotification(user, "Tâche assignée", "Nouvelle tâche assigné");
            } catch (notificationError) {
                console.error("Notification failed (non-critical):", notificationError);
            }

            // Step 5: Delete original record
            await deleteDocument(idDocument.value);

            
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