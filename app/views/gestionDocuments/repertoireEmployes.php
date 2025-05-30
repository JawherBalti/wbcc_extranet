<?php
    $user = $_SESSION["connectedUser"];
    $idUtilisateur = $user->idUtilisateur;
    $fullName = $user->fullName;
    $role = $user->idRole;
    $viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
?>

    <!-- DataTales Example -->
<?php
// Function to get companies
function getCompanies($path) {
    $companies = [];
    if (is_dir($path)) {
        $items = array_diff(scandir($path), ['.', '..']);
        foreach ($items as $item) {
            if (is_dir($path . $item)) {
                $companies[] = $item;
            }
        }
    }
    return $companies;
}

// Function to get years for a company
function getYears($path, $company) {
    $years = [];
    $companyPath = $path . $company . '/';
    if (is_dir($companyPath)) {
        $items = array_diff(scandir($companyPath), ['.', '..']);
        foreach ($items as $item) {
            if (is_dir($companyPath . $item)) {
                $years[] = $item;
            }
        }
    }
    return $years;
}

// Function to get services for a company and year
function getServices($path, $company, $year) {
    $services = [];
    $yearPath = $path . $company . '/' . $year . '/';
    if (is_dir($yearPath)) {
        $items = array_diff(scandir($yearPath), ['.', '..']);
        foreach ($items as $item) {
            if (is_dir($yearPath . $item)) {
                $services[] = $item;
            }
        }
    }
    return $services;
}

// Function to get users for a company, year and service
function getUsers($path, $company, $year, $service) {
    $users = [];
    $servicePath = $path . $company . '/' . $year . '/' . $service . '/';
    if (is_dir($servicePath)) {
        $items = array_diff(scandir($servicePath), ['.', '..']);
        foreach ($items as $item) {
            if (is_dir($servicePath . $item)) {
                $users[] = $item;
            }
        }
    }
    return $users;
}

$basePath = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/';
$companies = getCompanies($basePath);
?>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> RÉPERTOIRE DES EMPLOYÉS
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
                        
                        <div class="row justify-content-center" style="width: 100%;  margin: auto;">
                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-3 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Statut
                                    </legend>
                                    <div class="card ">
                                        <select id="statut" name="statut" class="form-control">
                                            <option value="">Tout</optionn>
                                            <option value="0">En attente</option>
                                            <option value="1">Cloturée</option>
                                            <option value="2">En retard</option>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>
                        
                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-3 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Employé
                                    </legend>
                                    <div class="card ">
                                        <select id="idUtilisateur" name="idUtilisateur" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($listeComptableGestionnaire as $contact) {
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

                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-3 col-xs-12" ?>">
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

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-3 col-xs-12 mb-3" ?>">
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
                                            value="<?= isset($dateOne) ? $dateOne : ''; ?>"
                                            placeholder="Choisir..." />
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
                                            value="<?= isset($dateFin) ? $dateFin : ''; ?>"
                                            placeholder="Choisir..." />
                                    </p>
                                </fieldset>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <br>
                                <button type="submit" id="filterButton" class="btn btn-primary form-control"
                                    style="margin-top: 20px; border-radius: 0px; background: #c00000; ">FILTRER</button>
                                <br><br>
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
                            <th>Date de création</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Nom document</th>
                            <th>Emplacement</th>
                            <th>Type</th>
                            <th>Assigné par</th>
                            <th>Assigné À</th>
                            <th>Statut</th>
                            <th>Action</th>
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
                            <td><?= $dateCreationFormatee ?></td>
                            <td><?= $dateDebutFormatee ?></td>
                            <td><?= $dateFinFormatee ?></td>
                            <td><?= $rep->regarding ?></td>
                            <td><?= $rep->urlDossier?></td>
                            <td><?= $rep->activityType ?></td>
                            <td><?= $rep->realisedBy ?></td>
                            <td><?= $rep->organizer ?></td>
                            <td><?php
                                if ($rep->isCleared == '1') {
                                    echo '<span class="badge badge-success">Cloturé</span>';
                                } elseif ($rep->isCleared == '0' && strtotime($rep->endTime) < strtotime(date('Y-m-d'))) {
                                    echo '<span class="badge badge-danger">En retard</span>';
                                } elseif ($rep->isCleared == '0' && strtotime($rep->endTime) > strtotime(date('Y-m-d'))) {
                                    echo '<span class="badge badge-primary">En attente</span>';
                                }
                            ?></td>
                            
                            <td>
                                <form class="<?=$viewAdmin != '' ? 'hidden' : 'd-flex'?>">
                                    <div class="cascading-dropdowns">
                                        <!-- Company Dropdown -->
                                        <select <?=$rep->isCleared == '1' ? 'disabled' : ''?> class="form-control company-select mb-2" 
                                                onchange="updateYears(this)" 
                                                style="width: 200px !important;">
                                            <option value="">Choisir société</option>
                                            <?php foreach ($companies as $company): ?>
                                                <option value="<?= htmlspecialchars($company); ?>">
                                                    <?= htmlspecialchars($company); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        
                                        <!-- Year Dropdown (initially hidden) -->
                                        <select class="form-control year-select mb-2 d-none" 
                                                onchange="updateServices(this)" 
                                                style="width: 200px !important;">
                                            <option value="">Choisir année</option>
                                        </select>
                                        
                                        <!-- Service Dropdown (initially hidden) -->
                                        <select class="form-control service-select mb-2 d-none" 
                                                style="width: 100% !important;">
                                            <option value="">Choisir service</option>
                                        </select>
                                        
                                        <!-- User Dropdown (initially hidden) -->
                                        <select class="form-control select3 user-select d-none" 
                                            style="width: 100% !important;">
                                            <option value="">Choisir utilisateur</option>
                                            <?php foreach ($listeComptableGestionnaire as $u): ?>
                                                <option value="<?= htmlspecialchars($u->idUtilisateur); ?>">
                                                    <?= htmlspecialchars($u->fullName); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="ml-3">
                                        <button <?=$rep->isCleared == '1' ? 'disabled' : ''?> type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this, <?=$rep->idActivity?>)">Valider</button>
                                    </div>
                                    <div class="ml-3">
                                        <button <?=$rep->isCleared == '1' ? 'disabled' : ''?> type="button" class="btn btn-danger form-control validerBtn"  onclick="openConfirmModal(<?= $rep->idActivity ?>, <?= $rep->idDocument ?>, '<?= $rep->urlDossier ?>')">Désassigner</button>
                                    </div>
                                </form>
                            
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
async function valider(button, idActivity) {
    const form = button.closest('form');
    const row = button.closest('tr');
    const viewButton = row.querySelector('td:nth-child(2) a');
    const documentUrl = viewButton.getAttribute('href');
    
    const viewButton2 = row.querySelector('td:nth-child(3)');
    const nomDoc = viewButton2.innerHTML;
    
    const companySelect = form.querySelector('.company-select');
    const yearSelect = form.querySelector('.year-select');
    const serviceSelect = form.querySelector('.service-select');
    const userSelect = form.querySelector('.user-select');
    
    // Validate selections
    if (!companySelect || !companySelect.value) {
        alert("Veuillez sélectionner une société.");
        return;
    }
    if (!yearSelect || !yearSelect.value) {
        alert("Veuillez sélectionner une année.");
        return;
    }
    if (!serviceSelect || !serviceSelect.value) {
        alert("Veuillez sélectionner un service.");
        return;
    }
    if (!userSelect || !userSelect.value) {
        alert("Veuillez sélectionner un utilisateur.");
        return;
    }
    
    const company = companySelect.value;
    const year = yearSelect.value;
    const service = serviceSelect.value;
    const user = userSelect.value;
    const userSelectedName = userSelect.options[userSelect.selectedIndex].text;
    const fullPath = `${company}/${year}/${service}`;
    const documentUrlArr = documentUrl.split("/");
    const extDoc = documentUrlArr[documentUrlArr.length - 1];
    const newDocumentUrl = fullPath + "/" + extDoc;

    const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
    const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Déplacement en cours...';

    let originalFilePath; // Store for rollback
    let newFilePath; // Store moved file path

    try {
        // Step 1: Move the file (atomic operation)
        const moveResponse = await fetch(`<?= URLROOT ?>/public/json/documents.php?action=copyDocument`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sourceUrl: documentUrl,
                destinationPath: fullPath,
                userId: connectedUserId,
                userName: connectedUserName
            })
        });

        if (!moveResponse.ok) {
            throw new Error("Échec du déplacement du fichier.");
        }

        const moveData = await moveResponse.json();
        if (!moveData.success) {
            throw new Error(moveData.message || "Échec du déplacement du fichier.");
        }

        // Store paths for rollback
        originalFilePath = moveData.originalPath;
        newFilePath = moveData.newPath;

        try {
            await updateActivity(idActivity, connectedUserId, connectedUserName, user, userSelectedName, nomDoc, newDocumentUrl);
        } catch (activityError) {
            // Rollback the moved file because createActivity failed
            await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
            throw activityError;  // rethrow to catch block below
        }
        await createHistorique("Déplacement");

        try {
            await createNotification(user, "Document déplacé", "L'administrateur a déplacé un document vers votre dossier");
        } catch (notificationError) {
            console.error("Notification failed (non-critical):", notificationError);
        }

        setTimeout(() => window.location.reload(), 500);

    } catch (error) {
        console.error("Error:", error);

        // Attempt to roll back the file move if any step failed
        if (originalFilePath && newFilePath) {
            try {
                await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
            } catch (rollbackError) {
                console.error("Rollback failed:", rollbackError);
            }
        }
    } finally {
        button.disabled = false;
        button.textContent = 'Valider';
    }
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

    function updateActivity(idActivity, assignePar, connectedUserName, assigneA, userSelectedName, nomDoc, urlDoc) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=updateActivity`,
            type: 'POST',
            data: {
                idActivity: idActivity,
                assignePar: assignePar,
                connectedUserName: connectedUserName,
                assigneA: assigneA,
                userSelectedName: userSelectedName,
                nomDoc: nomDoc,
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

    async function rollbackMove(originalPath, newPath, userId, userName) {
        const rollbackResponse = await fetch(`<?= URLROOT ?>/public/json/documents.php?action=rollBackDocumentEmploye`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                sourceUrl: newPath,
                destinationPath: originalPath.split('/').slice(0, -1).join('/'),
                userId,
                userName
            })
        });
        if (!rollbackResponse.ok) throw new Error("Rollback HTTP error");
        const rollbackData = await rollbackResponse.json();
        if (!rollbackData.success) throw new Error("Rollback failed on server");
    }

</script>

<script>
    // Store the folder data in JavaScript variables
    // Store the folder data in JavaScript variables
const folderData = {
    companies: <?= json_encode($companies); ?>,
    years: {},
    services: {}
};

<?php
    // Preload years data
    foreach ($companies as $company) {
        $years = getYears($basePath, $company);
        echo "folderData.years['" . addslashes($company) . "'] = " . json_encode($years) . ";\n";
        
        // Preload services data
        foreach ($years as $year) {
            $services = getServices($basePath, $company, $year);
            echo "folderData.services['" . addslashes($company) . "_" . addslashes($year) . "'] = " . json_encode($services) . ";\n";
        }
    }
?>

function updateYears(selectElement) {
    const container = selectElement.closest('.cascading-dropdowns');
    const company = selectElement.value;
    const yearSelect = container.querySelector('.year-select');
    
    // Reset downstream selects
    yearSelect.innerHTML = '<option value="">Choisir année</option>';
    yearSelect.classList.add('d-none');
    
    const serviceSelect = container.querySelector('.service-select');
    serviceSelect.innerHTML = '<option value="">Choisir service</option>';
    serviceSelect.classList.add('d-none');
    
    const actionSelect = container.querySelector('.user-select');
    actionSelect.classList.add('d-none');

    if (!company) return;

    // Populate years
    const years = folderData.years[company] || [];
    years.forEach(year => {
        yearSelect.innerHTML += `<option value="${year}">${year}</option>`;
    });
    
    if (years.length > 0) {
        yearSelect.classList.remove('d-none');
    }
}

function updateServices(selectElement) {
    const container = selectElement.closest('.cascading-dropdowns');
    const company = container.querySelector('.company-select').value;
    const year = selectElement.value;
    const serviceSelect = container.querySelector('.service-select');
    
    // Reset action select
    const actionSelect = container.querySelector('.user-select');
    actionSelect.classList.add('d-none');

    if (!year) return;

    // Populate services
    const services = folderData.services[`${company}_${year}`] || [];
    serviceSelect.innerHTML = '<option value="">Choisir service</option>';
    services.forEach(service => {
        serviceSelect.innerHTML += `<option value="${service}">${service}</option>`;
    });
    
    if (services.length > 0) {
        serviceSelect.classList.remove('d-none');
        
        // Show action select when service is selected
        serviceSelect.addEventListener('change', function () {
            const row = this.closest('tr') || this.closest('.your-container-class'); // adjust as needed
            const select3 = row.querySelector('.select3');

            if (this.value) {
                select3.classList.remove('d-none');
                $(select3).select2();
            } else {
                select3.classList.add('d-none');
            }
        });
    }
}

// Helper function to construct the full path
function getFullPath(container) {
    const company = container.querySelector('.company-select').value;
    const year = container.querySelector('.year-select').value;
    const service = container.querySelector('.service-select').value;
    const action = container.querySelector('.user-select').value;
    
    if (company && year && service && action) {
        return {
            path: `${company}/${year}/${service}`,
            action: action
        };
    }
    return null;
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

    document.getElementById("confirmBtn").addEventListener("click", () => {
        if (!selectedActivityId || !currentAction || !selectedDocumentId || !selectedDocUrl) return;
        fetch("<?= URLROOT ?>/public/json/documents.php?action=desassocier", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
            action: currentAction,
            idActivity: selectedActivityId,
            idDocument: selectedDocumentId,
            docUrl: selectedDocUrl,
            })
        })
        .then(res => res.json())
        .then(res => {
            $('#confirmModal').modal('hide');
            if (res.success) {
            window.location.reload();
            } else {
            alert(res.message);
            }
        });
    });
</script>