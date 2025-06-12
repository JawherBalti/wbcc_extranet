<?php
    $user = $_SESSION["connectedUser"];
    $idUtilisateur = $user->idUtilisateur;
    $fullName = $user->fullName;
    $role = $user->idRole;
    $viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
?>

<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Réaffecter ou déplacer un document</h5>
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
        <div class="modal-footer px-5 pb-4 pt-0">
          <button type="submit" id="confirm-user-btn" class="btn btn-danger btn-lg w-100">
            Confirmer la réaffectation
          </button>
        </div>
    </form>

      <form id="formSelectRepertoire">
        <div class="modal-body px-5 py-4">
          <!-- Company Selection -->
          <div class="form-group mb-4">
            <label class="font-weight-bold">Déplacer</label>
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
      <button id="confirm-btn" class="btn btn-danger btn-lg w-100">
        Confirmer le déplacement
      </button>
    </div>
        <input type="hidden" id="modalActivityUserId">
        <input type="hidden" id="modalDocumentId">
        <input type="hidden" id="modalActivityId">
        <input type="hidden" id="modalDocumentCreateDate">
        <input type="hidden" id="modalDocumentEditDate">
        <input type="hidden" id="modalDocumentNom">
        <input type="hidden" id="modalDocumentUrl">
        <input type="hidden" id="modalDossierUrl">
    </div>
  </div>
</div>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> <?=$titre?>
        </h2>
    </div>
</div>

<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('GestionDocuments', 'repertoireEmployes') ?>"
    style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">
    
    <div class="row justify-content-center" style="width: 100%; margin: auto;">
        <div class="<?= $viewAdmin != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-3 col-xs-12 mb-3" ?>">
            <fieldset class="py-4">
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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
    
        <div class="<?= $viewAdmin != "" ? "hidden" : "col-md-3 col-xs-12 mb-3" ?>">
            <fieldset class="py-4">
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    &nbsp;Employé
                </legend>
                <div class="card ">
                    <select id="idUtilisateur" name="idUtilisateur" class="form-control">
                        <option value="">Tout</option>
                        <?php
                        foreach ($listeUtilisateurs as $contact) {
                        ?>
                            <option value="<?= $contact->idUtilisateur ?>">
                                <?= $contact->fullName ?>
                            </option>
                        <?php
                        } ?>
                    </select>
                </div>
            </fieldset>
        </div>

        <div class="<?= $viewAdmin != "" ? "hidden" : "col-md-3 col-xs-12 mb-3" ?>">
            <fieldset class="py-4">
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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

        <div class="<?= $viewAdmin != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-3 col-xs-12 mb-3" ?>">
            <fieldset class="py-4">
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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

            <fieldset id="datepair" style="display: none;">
                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
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
    </div>
    
    <div class="row justify-content-center" style="width: 100%; margin: auto;">
        <div class="col-md-12 text-center">
            <button type="submit" id="filterButton" class="btn btn-primary"
                style="margin-top: 20px; border-radius: 0px; background: #c00000; width: 200px;">FILTRER</button>
        </div>
    </div>
</form>
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
                    <button onclick="closeModal()" class="btn btn-danger" data-dismiss="modal" data-bs-dismiss="modal">OK</button>
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

    </div>
  </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mt-3">
        <div class="card-header py-3 text-center">
            <div class="row align-items-center justify-content-center">
                <h3 class="m-0 mt-2 col-md-10 font-weight-bold text-primary">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $titre ?></font>
                    </font>
                </h3>
            </div>
        </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable16" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Visualiser</th>
                            <th>Date d'importation</th>

                            <th>Nom de base</th>
                            <th>Nouveau nom</th>
                             <th>Assigné par</th>
                            <th class="<?= $_SESSION["connectedUser"]->isAdmin ? '' : 'hidden'?>">Assigné À</th>
                            
                            <!-- <th>Date de début</th>
                            <th>Date de fin</th> -->
                            
                            <th>Emplacement</th>
                            <th>Statut</th>
                            <th class="<?= $_SESSION["connectedUser"]->isAdmin ? '' : 'hidden'?>">Réaffecter</th>
                            <th>Désassigner</th>
                            <th>Traiter</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($activities as $rep) {
                        $etat = "";
                        $dateCreationFormatee = date("d/m/Y", strtotime($rep->createDate));
                        $dateDebutFormatee = date("d/m/Y", strtotime($rep->startTime));
                        $dateFinFormatee = date("d/m/Y", strtotime($rep->endTime));
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="text-center">
                                <a href="<?= URLROOT ?>/public/documents/repertoires/<?=$rep->urlDossier?>" target="_blank" type="button" class="btn btn-sm btn-icon"
                                    style="background: #e74c3c; color:white">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td><?= $dateDebutFormatee ?></td>
                            <td><?= $rep->nomDocument ?></td>
                            <td><?= $rep->nouveauNomDocument ?></td>
                             <td><?= $rep->realisedBy ?></td>
                            <td class="<?= $_SESSION["connectedUser"]->isAdmin ? '' : 'hidden'?>"><?= $rep->organizer ?></td>
                            <!-- <td><?= $dateDebutFormatee ?></td>
                            <td><?= $dateFinFormatee ?></td> -->
                            <td><?= $rep->urlDossier?></td>
                            <td><?php
                                if ($rep->isCleared == '1') {
                                    echo '<span class="badge badge-success">Traité</span>';
                                } elseif ($rep->isCleared == '0') {
                                    echo '<span class="badge badge-danger">Non Traité</span>';
                                }
                                ?></td>
                            <td class="<?= $_SESSION["connectedUser"]->isAdmin ? '' : 'hidden'?>">
                                <button onclick='openTransferModal(<?= $rep->idActivity?>)' class="btn btn-primary" <?= $rep->isCleared == 1 ? 'disabled' : '' ?>>
                                    Réaffecter
                                </button>
                            </td>
                            
                            <td>
                                <div class="ml-3">
                                    <button title="Désassigner" <?=$rep->isCleared == '1' ? 'disabled' : ''?> type="button" class="btn btn-danger form-control validerBtn"  onclick="openConfirmModal(<?= $rep->idActivity ?>, <?= $rep->idDocument ?>, '<?= $rep->urlDossier ?>')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                    <button title="Traiter" type="button" class="btn form-control btn-success" onclick="openTreatModal(<?= $rep->idActivity ?>)"<?= $rep->isCleared == 1 ? 'disabled' : '' ?>>
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                            </td>
                        </tr>
                    <?php } ?>
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

    function openTransferModal(id) {
        resetModal();
        $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=getActivityById`,
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
                const urlDoc = document.querySelector("#modalDocumentUrl")
                urlDoc.value = response.data.urlDocument
                const urlDossier = document.querySelector("#modalDossierUrl")
                urlDossier.value = response.data.urlDossier
                loadCompanyUsers(response.data.urlDossier.split('/')[0]);
                $('#leaveRequestModal').modal('show');
            },
            error: function(response) {
                console.error('Erreur lors de la récupération des détails du pointage:', response);
                    // alert('Une erreur s\'est produite lors de la récupération des détails.');
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
        url: `<?= URLROOT ?>/public/json/documents.php?action=getCompanies`,
        type: 'POST',
        dataType: 'json', // Explicitly expect JSON
        success: function(response) {
        if(response.success) {
            $('#entrepriseSelect').html('<option value="">-- Sélectionner une entreprise --</option>');
            response.data.forEach(company => {
                // Change company.nom to company.nom_societe
                $('#entrepriseSelect').append(`<option value="${company.id}">${company.nom_societe}</option>`);
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
    if(!companyId) return;
    const companySelect = document.querySelector('#entrepriseSelect')
    const companySelectedName = companySelect.options[companySelect.selectedIndex].text;
    selectedPath = [{ type: 'company', name: companySelectedName }]; // Reset path with company
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
    selectedPath.push({ type: 'folder', id: folderId, name: folderName});

    $.ajax({
        url: `<?= URLROOT ?>/public/json/documents.php?action=getFolders`,
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
            
            if(response.success) {
                if(response.data.length > 0) {
                    // If there are more folders, show folder select
                    addFolderSelect(folderId, response.data);
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
        <label class="font-weight-bold">Réaffecter</label>
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
            url: `<?= URLROOT ?>/public/json/documents.php?action=createHistorique`,
            type: 'POST',
            data: {
                fullName: "<?= htmlspecialchars($fullName); ?>",
                idUtilisateurF: "<?= htmlspecialchars($idUtilisateur); ?>",
                historyAction: historyAction
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    resolve(true);
                } else {
                    reject(new Error(response.error || "Failed to create historique"));
                }
            },
            error: function(xhr, status, error) {
                reject(new Error("AJAX Error: " + error));
            }
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

    function updateActivity(idActivity, assignePar, connectedUserName, urlDoc) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/documents.php?action=updateActivity`,
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
                url: `<?= URLROOT ?>/public/json/documents.php?action=updateActivityUser`,
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
            url: `<?= URLROOT ?>/public/json/documents.php?action=rollBackDocumentEmploye`,
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
        const isAdmin = <?= $role ?> == "1" || <?= $role ?> == "2" || <?= $role ?> == "25" ? true : false;
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

    function openConfirmModal(activityId, documentId, docUrl) {
        selectedActivityId = activityId;
        selectedDocumentId = documentId;
        selectedDocUrl = docUrl
        currentAction = 'desassocier';
        document.getElementById("confirmModalTitle").innerText = "Confirmer la désassociation";
        document.getElementById("confirmModalBody").innerText = "Voulez-vous désassocier cette tâche ? Elle sera déplacée dans les documents communs.";
        document.getElementById("confirmModalHeader").className = "modal-header bg-danger text-white";
        $('#confirmModal').modal('show');
    }

    function openTreatModal(id) {
    selectedActivityId = id;
    currentAction = 'traiter';
    document.getElementById("confirmModalTitleTraite").innerText = "Confirmer le traitement";
    document.getElementById("confirmModalBodyTraite").innerText = "Voulez-vous marquer cette tâche comme Clôturer ?";
    document.getElementById("confirmModalHeaderTraite").className = "modal-header bg-success text-white";
    $('#confirmModalTraite').modal('show');
    }

document.getElementById("confirmBtn").addEventListener("click", () => {
    if (!selectedActivityId || !currentAction || !selectedDocumentId || !selectedDocUrl) return;
    
    $.ajax({
        url: "<?= URLROOT ?>/public/json/documents.php?action=desassocier",
        type: "POST",
        dataType: "json",
        contentType: "application/json",
        data: JSON.stringify({
            action: currentAction,
            idActivity: selectedActivityId,
            idDocument: selectedDocumentId,
            docUrl: selectedDocUrl
        }),
        success: function(res) {
            $('#confirmModal').modal('hide');
            if (res.success) {
                window.location.reload();
            } else {
                alert(res.message);
            }
        },
        error: function(xhr, status, error) {
            $('#confirmModal').modal('hide');
            alert("Une erreur s'est produite lors de la désassociation.");
        }
    });
});

$("#confirm-user-btn").on("click", async function () {
    const idActivity = document.querySelector("#modalActivityId").value
    const userSelectedId = selectedUser.id
    const userSelectedName = selectedUser.name
    const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
    const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";

    try {
        await updateActivityUser(idActivity, connectedUserId, connectedUserName, userSelectedId, userSelectedName);
    } catch(error) {
        $("#msgError").text("Erreur lors de la mise à jour de l'activité.");
        $('#errorOperation').modal('show');
    }
    // Step 3: Create history
    await createHistorique("Assignation");

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
    setTimeout(() => window.location.reload(), 500);
})

$("#confirm-btn").on("click", async function () {
    const idActivity = document.querySelector("#modalActivityId").value
    const createDate = document.querySelector("#modalDocumentCreateDate")
    const editDate = document.querySelector("#modalDocumentEditDate")
    const nomDoc = document.querySelector("#modalDocumentNom")
    const newNomDoc = document.querySelector('.document-input')
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
            try {
                await updateActivity(idActivity, connectedUserId, connectedUserName, newDocumentUrl);
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
                await createNotification(idUtilisateur.value, "Tâche assignée", "Nouvelle tâche assigné");
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
                    await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
                } catch (rollbackError) {
                    console.error("Rollback failed:", rollbackError);
                }
            }
        }
});

$("#confirmBtnTraite").on("click", function () {
  if (!selectedActivityId || !currentAction) return;
  let postDataTraite = {
    action: currentAction,
    idActivity: selectedActivityId,
  };


  $.ajax({
    url: "<?= URLROOT ?>/public/json/documents.php?action=traiter",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify(postDataTraite),
    success: function (res) {
      $('#confirmModalTraite').modal('hide');
      location.reload();
      if (res.success) {
        // location.reload();
        console.log(res.success)
      }
    },
    error: function (xhr) {
      $('#confirmModalTraite').modal('hide');
      alert(xhr.responseJSON?.error || "Erreur réseau ou serveur");
    }
  });
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