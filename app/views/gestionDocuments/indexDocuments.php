<?php
$idRole = $_SESSION["connectedUser"]->role;
$hasAccess = ($idRole == "1" || $_SESSION["connectedUser"]->isAccessAllOP == "1");
$viewAdmin = $hasAccess ? "col-md-4 col-xs-12 mb-3" : "hidden";
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css"
    href="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css"
    href="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.css" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= URLROOT ?>/assets/ticket/css/tenue-reunion.css" />

<div class="section-title mb-0">
    <h2 class="mb-0">
        <button onclick="history.back()">
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000"></i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-file" style="color: #c00000"></i>
            Tableau de Bord
        </span>
    </h2>
</div>

<div class="mt-3" id="accordionFiltrea">
  <div class="table-responsive">
    <div class="card accordion-item" style="border-radius: none !important; box-shadow: none !important;">
      <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
           style="box-shadow: none !important;">
        <div class="accordion-body">
          <form method="GET" style="border: none; margin: 0px; padding: 0px;">
            <div class="row" style="width: 100%; margin: auto;">

              <div class="col-md-4 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Nom de la tâche
                  </legend>
                  <input type="text" name="nom" class="form-control" placeholder="Rechercher..." value="<?= isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : '' ?>">
                </fieldset>
              </div>

              <div class="<?= $viewAdmin ?>">
  <fieldset class="py-3">
    <legend class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
      Assigné à
    </legend>
    <select name="assigner" class="form-control">
      <option value="">-- Sélectionner un utilisateur --</option>
      <?php foreach ($utilisateurs as $utilisateur) : ?>
        <option value="<?= htmlspecialchars($utilisateur->fullName) ?>"
          <?= (isset($_GET['assigner']) && $_GET['assigner'] === $utilisateur->fullName) ? 'selected' : '' ?>>
          <?= htmlspecialchars($utilisateur->fullName) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </fieldset>
</div>

              <div class="<?= $viewAdmin ?>">
    <fieldset class="py-3">
        <legend class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
            &nbsp;Site
        </legend>
        <select id="site" name="site" class="form-control">
            <option <?= $site === '' ? 'selected' : '' ?> value="">Tout</option>
            <?php foreach ($sites as $sit): ?>
                <?php
                if (
                    $hasAccess || $_SESSION["connectedUser"]->nomSite == $sit->nomSite
                ):
                ?>
                    <option <?= $site == $sit->nomSite ? "selected" : "" ?> value="<?= $sit->nomSite ?>">
                        <?= $sit->nomSite ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </fieldset>
</div>

              <div class="col-md-6 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Statut
                  </legend>
                  <select name="etat" class="form-control">
                    <option value="">Tout</option>
                    <option value="False" <?= isset($_GET['etat']) && $_GET['etat'] === 'False' ? 'selected' : '' ?>>Ouvert</option>
                    <option value="True" <?= isset($_GET['etat']) && $_GET['etat'] === 'True' ? 'selected' : '' ?>>Clôturé</option>
                  </select>
                </fieldset>
              </div>

              <div class="col-md-6 col-xs-12 mb-3">
                                  <fieldset class="py-3">
                                <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Date d'importation</legend>
                                    <div class="card ">
                                        <select name="periode" id="periode" class="form-control" onchange="dateCreationSelect(this.value)">
                                            <option <?= $periode === '' ? 'selected' : ''; ?> value="">Tout</option>
                                            <option <?= $periode === 'today' ? 'selected' : ''; ?> value="today">Aujourd'hui</option>
                                            <option <?= $periode === '1' ? 'selected' : ''; ?> value="1">A la date du</option>
                                            <option <?= $periode === '2' ? 'selected' : ''; ?> value="2">Personnaliser</option>
                                            <option <?= $periode === 'semaine' ? 'selected' : ''; ?> value="semaine">cette semaine</option>
                                            <option <?= $periode === 'mois' ? 'selected' : ''; ?> value="mois">ce mois</option>
                                            <option <?= $periode === 'trimestre' ? 'selected' : ''; ?> value="trimestre">Ce trimestre</option>
                                            <option <?= $periode === 'semestre' ? 'selected' : ''; ?> value="semestre">Ce semestre</option>
                                            <option <?= $periode === 'annuel' ? 'selected' : ''; ?> value="annuel">Cette année</option>
                                        </select>
                                    </div>
                                </fieldset>

                                <fieldset id="datepairOne" style="display: none;">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Personnaliser </legend>
                                    <p >
                                        <label for="defaultFormControlInput" class="form-label">Date:</label>
                                        <br>
                                        <input name="dateOne" id="dateOne" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start " value="<?= $dateOne ? $dateOne: ''; ?>" placeholder="Choisir..." />
                                    </p>
                                </fieldset>

                                <fieldset id="datepair" style="display: none;">
                                    <legend
                                            class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                            Personnaliser </legend>
                                    <p>
                                        <label for="defaultFormControlInput" class="form-label">Début:</label>
                                        <br>
                                        <input name="dateDebut" id="dateDebut" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date start " value="<?= $dateDebut ? $dateDebut : ''; ?>" placeholder="Choisir..." />
                                        <!-- <input name="heureDebut" id="heureDebut" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5  time start " value="<?= (isset($_GET['heureDebut'])) ? $_GET['heureDebut'] : ''; ?>" placeholder="Choisir..." /> -->
                                        <br><br>
                                        <label for="defaultFormControlInput" class="form-label">Fin:</label>
                                        <br>
                                        <input name="dateFin" id="dateFin" readonly style="border: 1px solid black;" type="text" class="this-form-control col-xs-12 col-md-12 date end " value="<?= $dateFin ? $dateFin : ''; ?>" placeholder="Choisir..." />
                                        <!-- <input name="heureFin" id="heureFin" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5 time end " value="<?= (isset($_GET['heureFin'])) ? $_GET['heureFin'] : ''; ?>" placeholder="Choisir..." /> -->
                                    </p>
                                </fieldset>
                            </div>
              <div class="col-md-4 offset-4 col-xs-12">
                <button type="submit" class="btn btn-danger form-control mt-2" style="border-radius: 0px;">
                  FILTRER
                </button>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mt-3" id="accordionFiltrea">
  <div class="table-responsive">
    <div class="card accordion-item" style="background-color: transparent !important;border-radius: none !important; box-shadow: none !important;">
      <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
           style="box-shadow: none !important;">
        <div class="card" style="background-color: transparent !important;">
          <div class="card-body">
          <?php if ($_SESSION["connectedUser"]->isAdmin): ?>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-sm btn-red ml-1" data-toggle="modal"
                      data-target="#leaveRequestModal" rel="tooltip" title="Ajouter">
                <i class="fas fa-plus" style="color: #ffffff"></i>
                Créer un répertoire
              </button>
            </div>
          <?php endif; ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Créer Répertoire -->
<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Bandeau en-tête rouge -->
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Créer un répertoire</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <!-- Corps du formulaire -->
      <form id="formCreateRepertoire">
        <div class="modal-body px-5 py-4">

          <div class="form-group mb-4">
            <label for="entrepriseSelect" class="font-weight-bold">Entreprise</label>
            <select id="entrepriseSelect" class="form-control" required></select>
          </div>

          <div class="form-group mb-4">
            <label for="anneeSelect" class="font-weight-bold">Année</label>
            <select id="anneeSelect" class="form-control" required disabled></select>
          </div>

          <div class="form-group mb-4">
            <label for="serviceSelect" class="font-weight-bold">Service</label>
            <select id="serviceSelect" class="form-control" required disabled></select>
          </div>

          <div class="form-group mb-4">
            <label for="userSelect" class="font-weight-bold">Nom utilisateur</label>
            <select id="userSelect" name="userId" class="form-control form-control-lg" required>
              <option value="">Chargement...</option>
            </select>
          </div>

        </div>

        <!-- Pied de la modale avec bouton -->
        <div class="modal-footer px-5 pb-4 pt-0">
          <button type="submit" class="btn btn-danger btn-lg w-100">
            Créer un nouveau répertoire
          </button>
        </div>

      </form>
    </div>
  </div>
</div>



<!-- compteur -->
<div class="row justify-content-center mt-3">
    <!-- Carte Tâches en attente -->
    <div class="col-md-3">
      <div class="card text-center p-3" style="border: 1px solid #ccc;">
        <div class="h4 mb-2">Tâches en attente</div>
        <div class="display-6" style="color: #c00000;">
          <?= $data['documentsEnAttente'] ?>
        </div>
      </div>
    </div>
  <div class="col-md-3">
    <div class="card text-center p-3" style="border: 1px solid #ccc;">
      <div class="h4 mb-2">Tâches ouvertes</div>
      <div class="display-6" style="color: #c00000;">
        <?= $data['tachesOuvertes'] ?>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-center p-3" style="border: 1px solid #ccc;">
      <div class="h4 mb-2">Tâches clôturées</div>
      <div class="display-6" style="color: #c00000;">
        <?= $data['tachesCloturees'] ?>
      </div>
    </div>
  </div>
</div>
<!-- Tableua -->
<div class="mt-4">
  <h5>Tâches récents</h5>
  <div class="table-responsive">
  <table class="table table-bordered">
  <thead>
  <tr>
    <th>#</th>
    <th>Nom</th>
    <th>Assigné a</th>
    <th>Nom du document</th>
    <th>Site</th>
    <th>Date importation</th>
    <th>Date d’assignation</th>
    <th>Statut</th>
  </tr>
</thead>
<tbody>
  <?php $i = 1; ?>
  <?php foreach ($data['Documents'] as $doc): ?>
    <tr>
      <td><?= $i++ ?></td>
      <td><?= htmlspecialchars($doc->nom) ?></td>
      <td><?= htmlspecialchars($doc->assignerName) ?></td>
      <td><?= htmlspecialchars($doc->nomDocument) ?></td>
      <td><?= htmlspecialchars($doc->siteName) ?></td>
      <td><?= date('d/m/Y H:i', strtotime($doc->createDate)) ?></td>
      <td><?= date('d/m/Y H:i', strtotime($doc->startTime)) ?></td>
      <td>
        <?php if ($doc->etatDocument == 1): ?>
          <span class="badge badge-success">Ouvert</span>
        <?php else: ?>
          <span class="badge badge-danger">Clôturé</span>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>
  </table>
</div>
</div>

<!-- Section des graphiques -->
<div class="row mt-4">
  <div class="col-md-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header text-white" style="background-color: #c00000;">
        <div class="d-flex justify-content-between align-items-center">
          <span><strong>1. Répartition des tâches</strong></span>
          <span class="badge bg-secondary">Total <?= array_sum($data['tachesStats']) ?></span>
        </div>
      </div>
      <div class="card-body text-center">
        <canvas id="chartTaches" ></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header text-white" style="background-color: #c00000;">
        <div class="d-flex justify-content-between align-items-center">
          <span><strong>2. Tâches par utilisateur</strong></span>
          <span class="badge bg-secondary">Total <?= array_sum($data['topUsersCounts']) ?></span>
        </div>
      </div>
      <div class="card-body text-center">
        <canvas id="chartTopUsers"></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-12 mb-4">
    <div class="card shadow-sm">
      <div class="card-header text-white" style="background-color: #c00000;">
        <div class="d-flex justify-content-between align-items-center">
          <span><strong>3. Tâches par site</strong></span>
          <span class="badge bg-secondary">Total <?= array_sum($data['siteCounts']) ?></span>
        </div>
      </div>
      <div class="card-body text-center">
        <canvas id="chartSites" ></canvas>
      </div>
    </div>
  </div>
</div>



<script src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/datepair.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/jquery.datepair.js"></script>
<script src="<?= URLROOT ?>/assets/ticket/vendor/js/bootstrap.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


<script>
  var isAdmin = `<?= $_SESSION["connectedUser"]->isAdmin ?>`;
  const tachesStats = <?= json_encode($data['tachesStats']) ?>;
  const topUsersLabels = <?= json_encode($data['topUsersLabels']) ?>;
  const topUsersCounts = <?= json_encode($data['topUsersCounts']) ?>;
  const siteLabels = <?= json_encode($data['siteLabels']) ?>;
  const siteCounts = <?= json_encode($data['siteCounts']) ?>;

  function toggleDateInputs(value) {
    document.getElementById('dateUnique').style.display = value === '1' ? 'block' : 'none';
    document.getElementById('dateRange').style.display = value === '2' ? 'block' : 'none';
  }
  let directoryStructure = {};

  fetch("<?= URLROOT ?>/public/json/document.php?action=getDirectoryStructure")
    .then(response => response.json())
    .then(data => {
      directoryStructure = data;
      const entrepriseSelect = document.getElementById("entrepriseSelect");
      entrepriseSelect.innerHTML = '<option value="">Sélectionner</option>';
      Object.keys(data).forEach(entreprise => {
        const opt = document.createElement("option");
        opt.value = entreprise;
        opt.textContent = entreprise;
        entrepriseSelect.appendChild(opt);
      });
    });

  document.getElementById("entrepriseSelect").addEventListener("change", function () {
    const anneeSelect = document.getElementById("anneeSelect");
    const serviceSelect = document.getElementById("serviceSelect");
    anneeSelect.innerHTML = '';
    serviceSelect.innerHTML = '';
    anneeSelect.disabled = false;
    serviceSelect.disabled = true;

    const years = Object.keys(directoryStructure[this.value] || {});
    years.forEach(y => {
      const opt = document.createElement("option");
      opt.value = y;
      opt.textContent = y;
      anneeSelect.appendChild(opt);
    });
  });

  document.getElementById("anneeSelect").addEventListener("change", function () {
    const entreprise = document.getElementById("entrepriseSelect").value;
    const services = directoryStructure[entreprise][this.value] || [];
    const serviceSelect = document.getElementById("serviceSelect");
    serviceSelect.innerHTML = '';
    serviceSelect.disabled = false;

    services.forEach(service => {
      const opt = document.createElement("option");
      opt.value = service;
      opt.textContent = service;
      serviceSelect.appendChild(opt);
    });
  });
  function loadUserListDynamic() {
    const entreprise = document.getElementById("entrepriseSelect").value;
    const annee = document.getElementById("anneeSelect").value;
    const service = document.getElementById("serviceSelect").value;
    const select = document.getElementById("userSelect");

    if (!entreprise || !annee || !service) return;

    fetch(`<?= URLROOT ?>/public/json/document.php?action=getAvailableUsers&entreprise=${entreprise}&annee=${annee}&service=${service}`)
      .then(response => response.json())
      .then(data => {
        select.innerHTML = '';
        if (data.length === 0) {
          const opt = document.createElement("option");
          opt.textContent = "Tous les utilisateurs ont un répertoire";
          opt.disabled = true;
          select.appendChild(opt);
        } else {
          const defaultOpt = document.createElement("option");
          defaultOpt.value = '';
          defaultOpt.textContent = 'Sélectionner un utilisateur';
          select.appendChild(defaultOpt);

          data.forEach(user => {
            const opt = document.createElement("option");
            opt.value = user.id;
            opt.textContent = user.name;
            select.appendChild(opt);
          });
        }
      });
  }

  document.getElementById("serviceSelect").addEventListener("change", function () {
    loadUserListDynamic();
  });


  document.getElementById("formCreateRepertoire").addEventListener("submit", function (e) {
  e.preventDefault();
  const userId = document.getElementById("userSelect").value;
  const entreprise = document.getElementById("entrepriseSelect").value;
  const annee = document.getElementById("anneeSelect").value;
  const service = document.getElementById("serviceSelect").value;

  if (!entreprise || !annee || !service || !userId) {
    alert("Tous les champs sont obligatoires.");
    return;
  }

  fetch("<?= URLROOT ?>/public/json/document.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      action: "createDirectory",
      idUtilisateur: userId,
      entreprise: entreprise,
      annee: annee,
      service: service
    })
  })
    .then(response => response.json())
    .then(result => {
      $('#leaveRequestModal').modal('hide');
      window.location.reload();
    });
});



// Données simulées (remplace avec tes vraies données PHP)
const tachesData = {
  labels: ['Ouvertes', 'Clôturées', 'En attente'],
  datasets: [{
    label: 'Tâches',
    data: [
      tachesStats.ouvertes || 0,
      tachesStats.cloturees || 0,
      tachesStats.attente || 0
    ],
    backgroundColor: ['#28a745', '#dc3545', '#ffc107']
  }]
};



const topUsersData = {
  labels: topUsersLabels,
  datasets: [{
    label: 'Tâches Assignés',
    data: topUsersCounts,
    backgroundColor: [
  '#17a2b8', '#ffc107', '#28a745', '#dc3545', '#6f42c1'
]

  }]
};


const docsSiteData = {
  labels: siteLabels,
  datasets: [{
    label: 'Tâches par site',
    data: siteCounts,
    backgroundColor: ['#6f42c1', '#fd7e14', '#20c997', '#007bff', '#dc3545', '#ffc107']
  }]
};

new Chart(document.getElementById('chartTaches'), {
  type: 'doughnut',
  data: tachesData
});


new Chart(document.getElementById('chartTopUsers'), {
  type: 'doughnut',
  data: topUsersData,
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'bottom',
      },
      title: {
        display: true,
        text: 'Répartition des tâches par utilisateur',
      }
    }
  }
});



new Chart(document.getElementById('chartSites'), {
  type: 'pie',
  data: docsSiteData
});


</script>