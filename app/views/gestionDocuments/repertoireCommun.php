<?php
    $user = $_SESSION["connectedUser"];
    $idUtilisateur = $user->idUtilisateur;
    $fullName = $user->fullName;
    $role = $user->idRole;
    $viewAdmin = (($role == "1" || $role == "2" || $role == "25")) ? "" : "hidden";
?>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> RÉPERTOIRE COMMUN
        </h2>
    </div>

</div>

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
                            <!-- <td>
                                <form class="<?=$viewAdmin != '' ? 'hidden' : 'd-flex'?>">
                                    <select name="folderPath" class="form-control contactSelect" style="width: 50% !important;">
                                        <option value="">Select destination folder:</option>
                                        <?php foreach ($folderHierarchy as $folder): ?>
                                            <option value="<?= htmlspecialchars($folder['path']); ?>">
                                                <?= htmlspecialchars("{$folder['company']} > {$folder['year']} > {$folder['service']} > {$folder['user']}"); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="ml-3">
                                        <button type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this)">Valider</button>
                                    </div>
                                </form>
                                <form class="<?=$viewAdmin == '' ? 'hidden' : 'd-flex'?>">
                                    <select name="folderPath" class="form-control contactSelect" style="width: 50% !important;">
                                        <option value="">Select destination folder:</option>
                                        <?php 
                                        // Find folders for the current user only
                                        foreach ($folderHierarchy as $folder) {
                                            if ($folder['user'] == $_SESSION["connectedUser"]->fullName) {
                                                echo '<option value="' . htmlspecialchars($folder['path']) . '">';
                                                echo htmlspecialchars("{$folder['company']} > {$folder['year']} > {$folder['service']}");
                                                echo '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="ml-3">
                                        <button type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this)">Valider</button>
                                    </div>
                                </form>
                            </td> -->
                            <td>
                                <form class="<?=$viewAdmin != '' ? 'hidden' : 'd-flex'?>">
                                    <div class="cascading-dropdowns">
                                        <!-- Company Dropdown -->
                                        <select class="form-control company-select mb-2" 
                                                onchange="updateYears(this)" 
                                                style="width: 100% !important;">
                                            <option value="">Select Company</option>
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
                                            <option value="">Select Year</option>
                                        </select>
                                        
                                        <!-- Service Dropdown (initially hidden) -->
                                        <select class="form-control service-select mb-2 d-none" 
                                                onchange="updateUsers(this)" 
                                                style="width: 100% !important;">
                                            <option value="">Select Service</option>
                                        </select>
                                        
                                        <!-- User Dropdown (initially hidden) -->
                                        <select name="folderPath" class="form-control user-select d-none" 
                                                style="width: 100% !important;">
                                            <option value="">Select User</option>
                                        </select>
                                    </div>
                                    <div class="ml-3">
                                        <button type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this)">Valider</button>
                                    </div>
                                </form>
                                
                                <!-- user form-->
                                <form class="<?=$viewAdmin == '' ? 'hidden' : 'd-flex'?>">
                                    <!-- Simplified version for admin view -->
                                    <select name="folderPath" class="form-control contactSelect" style="width: 50% !important;">
                                        <option value="">Select destination:</option>
                                        <?php 
                                        foreach ($companies as $company) {
                                            $years = getYears($basePath, $company);
                                            foreach ($years as $year) {
                                                $services = getServices($basePath, $company, $year);
                                                foreach ($services as $service) {
                                                    $users = getUsers($basePath, $company, $year, $service);
                                                    foreach ($users as $user) {
                                                        $path = "$company/$year/$service/$user";
                                                        echo '<option value="' . htmlspecialchars($path) . '">';
                                                        echo htmlspecialchars("$company > $year > $service > $user");
                                                        echo '</option>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="ml-3">
                                        <button type="button" class="btn btn-primary form-control validerBtn" onclick="valider(this)">Valider</button>
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
function valider(button) {
    const form = button.closest('form');
    const row = button.closest('tr');
    const viewButton = row.querySelector('td:nth-child(2) a');
    const documentUrl = viewButton.getAttribute('href');
    
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
    const fullPath = `${company}/${year}/${service}/${user}`;
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Déplacement en cours...';
    
    // AJAX call to MOVE (not copy) the file
    fetch(`<?= URLROOT ?>/public/json/documents.php?action=copyDocument`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            sourceUrl: documentUrl,
            destinationPath: fullPath,
            userId: document.getElementById('connectedUserId').getAttribute('value'),
            userName: document.getElementById('connectedUserName').getAttribute('value')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            createNotification(user, "Document déplacé", "L'administrateur a déplacé un document vers votre dossier");
            createHistorique("Déplacement");
            alert("Document déplacé avec succès!");
            
            // Remove the row from the table after moving
            row.remove();
        } else {
            alert("Erreur: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Une erreur est survenue lors du déplacement du document");
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = 'Valider';
    });
}

    function createHistorique(historyAction) {
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
                    console.log('Historique created successfully:', response.message);
                } else {
                    console.error('Failed to create historique:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error creating historique:', error);
            }
        });
    }
    // Function to create notification
    function createNotification(idUtilisateur, title, message) {
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
                        console.log('Notification created successfully:', response.message);
                    } else {
                        console.error('Failed to create notification:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error creating notification:', error);
                }
            });
        }

    function createActivity(assignePar, assigneA) {
                $.ajax({
                url: `<?= URLROOT ?>/public/json/documents.php?action=createAcitvity`,
                type: 'POST',
                data: {
                    assignePar: assignePar,
                    assigneA: assigneA,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        console.log('Notification created successfully:', response.message);
                    } else {
                        console.error('Failed to create notification:', response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error creating notification:', error);
                }
            });
    }

</script>

<script>
// Store the folder data in JavaScript variables
const folderData = {
    companies: <?= json_encode($companies); ?>,
    years: {},
    services: {},
    users: {}
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
        
        // Preload users data
        foreach ($services as $service) {
            $users = getUsers($basePath, $company, $year, $service);
            echo "folderData.users['" . addslashes($company) . "_" . addslashes($year) . "_" . addslashes($service) . "'] = " . json_encode($users) . ";\n";
        }
    }
}
?>

function updateYears(selectElement) {
    const container = selectElement.closest('.cascading-dropdowns');
    const company = selectElement.value;
    const yearSelect = container.querySelector('.year-select');
    
    // Reset downstream selects
    yearSelect.innerHTML = '<option value="">Select Year</option>';
    yearSelect.classList.add('d-none');
    
    const serviceSelect = container.querySelector('.service-select');
    serviceSelect.innerHTML = '<option value="">Select Service</option>';
    serviceSelect.classList.add('d-none');
    
    const userSelect = container.querySelector('.user-select');
    userSelect.innerHTML = '<option value="">Select User</option>';
    userSelect.classList.add('d-none');

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
    
    // Reset downstream selects
    serviceSelect.innerHTML = '<option value="">Select Service</option>';
    serviceSelect.classList.add('d-none');
    
    const userSelect = container.querySelector('.user-select');
    userSelect.innerHTML = '<option value="">Select User</option>';
    userSelect.classList.add('d-none');

    if (!year) return;

    // Populate services
    const services = folderData.services[`${company}_${year}`] || [];
    services.forEach(service => {
        serviceSelect.innerHTML += `<option value="${service}">${service}</option>`;
    });
    
    if (services.length > 0) {
        serviceSelect.classList.remove('d-none');
    }
}

function updateUsers(selectElement) {
    const container = selectElement.closest('.cascading-dropdowns');
    const company = container.querySelector('.company-select').value;
    const year = container.querySelector('.year-select').value;
    const service = selectElement.value;
    const userSelect = container.querySelector('.user-select');

    // Reset user select
    userSelect.innerHTML = '<option value="">Select User</option>';
    userSelect.classList.add('d-none');

    if (!service) return;

    // Populate users
    const users = folderData.users[`${company}_${year}_${service}`] || [];
    users.forEach(user => {
        console.log(user)
            $.ajax({
            url: `<?= URLROOT ?>/public/json/documents.php?action=getUser`,
            type: 'POST',
            data: {
               userId: user
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    console.log('Historique created successfully:', response);
                    userSelect.innerHTML += `<option value="${user}">${response.message.fullName}</option>`;
                } else {
                    console.error('Failed to create historique:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error creating historique:', error);
            }
        });
    });
    
    if (users.length > 0) {
        userSelect.classList.remove('d-none');
    }
}

// Helper function to construct the full path
function getFullPath(container) {
    const company = container.querySelector('.company-select').value;
    const year = container.querySelector('.year-select').value;
    const service = container.querySelector('.service-select').value;
    const user = container.querySelector('.user-select').value;
    
    if (company && year && service && user) {
        return `${company}/${year}/${service}/${user}`;
    }
    return '';
}
</script>