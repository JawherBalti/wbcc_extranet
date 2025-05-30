<?php
    $user = $_SESSION["connectedUser"];
    $idUtilisateur = $user->idUtilisateur;
    $fullName = $user->fullName;
    $role = $user->idRole;
    $viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
?>

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
                            <th>Nom document</th>
                            <th>Date de création</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    foreach ($repertoireCommun as $rep) {
                        $etat = "";
                        $dateFormatee = date("d/m/Y", strtotime($rep->createDate));
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="text-center">
                                <a href="<?= URLROOT ?>/public/documents/repertoireCommun/<?=$rep->urlDocument?>" target="_blank" type="button" class="btn btn-sm btn-icon"
                                    style="background: #e74c3c; color:white">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td><?= $rep->nomDocument ?></td>
                            <td><?= $dateFormatee ?></td>
<td>
    <form class="d-flex">
        <div class="cascading-dropdowns">
            <!-- Company Dropdown -->
            <select class="form-control company-select mb-2" 
                    onchange="updateYears(this)" 
                    style="width: 100% !important;">
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
                    style="width: 100% !important;">
                <option value="">Choisir année</option>
            </select>
            
            <!-- Service Dropdown (initially hidden) -->
            <select class="form-control service-select mb-2 d-none" 
                    style="width: 100% !important;">
                <option value="">Choisir service</option>
            </select>
            
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
            <button type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this, <?=$rep->idDocument?>)">Valider</button>
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

    async function valider(button, id) {
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
    if (!companySelect?.value || !yearSelect?.value || !serviceSelect?.value || !userSelect?.value) {
        alert("Veuillez remplir tous les champs.");
        return;
    }
    
    const company = companySelect.value;
    const year = yearSelect.value;
    const service = serviceSelect.value;
    const user = userSelect.value;
    const userSelectedName = userSelect.options[userSelect.selectedIndex].text;
    const fullPath = `${company}/${year}/${service}`;
    const extDoc = documentUrl.split("repertoireCommun/")[1];
    const newDocumentUrl = `${fullPath}/${extDoc}`;

    const connectedUserId = <?= $_SESSION['connectedUser']->idUtilisateur; ?>;
    const connectedUserName = "<?= addslashes($_SESSION['connectedUser']->fullName); ?>";
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Déplacement en cours...';

    let originalFilePath; // Store for rollback
    let newFilePath; // Store moved file path

    try {
        // Step 1: Move the file
        const moveResponse = await fetch(`<?= URLROOT ?>/public/json/documents.php?action=copyDocument`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                sourceUrl: documentUrl,
                destinationPath: fullPath,
                userId: connectedUserId,
                userName: connectedUserName
            })
        });

        if (!moveResponse.ok) throw new Error("Échec du déplacement du fichier.");
        
        const moveData = await moveResponse.json();
        if (!moveData.success) throw new Error(moveData.message);
        
        // Store paths for rollback
        originalFilePath = moveData.originalPath;
        newFilePath = moveData.newPath;

        // Step 2: Create activity
        try {
            await createActivity(id, connectedUserId, connectedUserName, user, userSelectedName, nomDoc, newDocumentUrl);
        } catch (activityError) {
            // Rollback the moved file because createActivity failed
            alert("Erreur lors de la création de l'activité. Annulation du déplacement...");
            await rollbackMove(originalFilePath, newFilePath, connectedUserId, connectedUserName);
            throw activityError;  // rethrow to catch block below
        }
        // Step 3: Create history
        await createHistorique("Assignation");

        // Step 4: Send notification (non-critical)
        try {
            await createNotification(user, "Tâche assignée", "L'administrateur vous a assigné une tâche");
        } catch (notificationError) {
            console.error("Notification failed (non-critical):", notificationError);
        }

        // Step 5: Delete original record
        await deleteDocument(id);

        setTimeout(() => window.location.reload(), 500);

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

    function createActivity(idDocument, assignePar, connectedUserName, assigneA, userSelectedName, nomDoc, urlDoc) {
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
        const rollbackResponse = await fetch(`<?= URLROOT ?>/public/json/documents.php?action=rollBackDocument`, {
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
</script>