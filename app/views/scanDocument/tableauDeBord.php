<?php
$idRole = $_SESSION["connectedUser"]->role;
$hasAccess = ($idRole == "1" || $_SESSION["connectedUser"]->isAccessAllOP == "1");
$viewAdmin = $hasAccess ? "col-md-2 col-xs-12 mb-3" : "hidden";

?>


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
            <div class="row justify-content-center" style="width: 100%; margin: auto;">



              <div class="col-md-2 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    &nbsp;la tâche
                  </legend>
                  <select name="nom" class="form-control select3">
                    <option value="">Tout</option>
                    <?php if (!empty($toutesLesTaches)): ?>
                      <?php foreach ($toutesLesTaches as $tache): ?>
                        <option
                          <?= isset($_GET['nom']) && $_GET['nom'] == $tache->idActivity ? 'selected' : '' ?>
                          value="<?= htmlspecialchars($tache->idActivity) ?>">
                          <?= htmlspecialchars($tache->numeroActivity . ' - ' . $tache->nomDocument) ?>
                        </option>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <option value="aucun">Aucune tâche disponible</option>
                    <?php endif; ?>
                  </select>

                </fieldset>
              </div>
              <div class="<?= $viewAdmin ?>">
                <fieldset class="py-3">
                  <legend
                    class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Assigné à
                  </legend>
                  <select name="assigner" class="form-control select3">
                    <option value="">Tout</option>
                    <?php
                    foreach ($utilisateurs  as $contact) {
                    ?>
                      <option value="<?= $contact->idUtilisateur ?>">
                        <?= $contact->fullName ?>
                      </option>
                    <?php
                    } ?>
                  </select>

                </fieldset>
              </div>

              <div class="<?= $viewAdmin ?>">
                <fieldset class="py-3">
                  <legend
                    class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Site
                  </legend>
                  <select id="site" name="site" class="form-control">
                    <option <?= $site === '' ? 'selected' : '' ?> value="">Tout</option>
                    <?php foreach ($sites as $sit): ?>
                      <?php
                      if (
                        $hasAccess || $_SESSION["connectedUser"]->nomSite == $sit->nomSite
                      ):
                      ?>
                        <option <?= $site == $sit->nomSite ? "selected" : "" ?>
                          value="<?= $sit->nomSite ?>">
                          <?= $sit->nomSite ?>
                        </option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </fieldset>
              </div>



              <div class="col-md-2 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend
                    class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Statut
                  </legend>
                  <select name="etat" class="form-control">
                    <option value="" <?= $etatSelected === '' ? 'selected' : '' ?>>Tout</option>
                    <option value="0" <?= $etatSelected === '0' ? 'selected' : '' ?>>Ouvert</option>
                    <option value="1" <?= $etatSelected === '1' ? 'selected' : '' ?>>Clôturé
                    </option>
                  </select>

                </fieldset>
              </div>
              <div class="col-md-2 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Date assignation</legend>
                  <div class="card ">
                    <select name="periode" id="periode" class="form-control"
                      onchange="dateCreationSelect(this.value)">
                      <option <?= $periode === '' ? 'selected' : ''; ?> value="">Tout</option>
                      <option <?= $periode === 'today' ? 'selected' : ''; ?> value="today">
                        Aujourd'hui</option>
                      <option <?= $periode === '1' ? 'selected' : ''; ?> value="1">A la date du
                      </option>
                      <option <?= $periode === '2' ? 'selected' : ''; ?> value="2">Personnaliser
                      </option>
                      <option <?= $periode === 'semaine' ? 'selected' : ''; ?> value="semaine">
                        cette semaine</option>
                      <option <?= $periode === 'mois' ? 'selected' : ''; ?> value="mois">ce mois
                      </option>
                      <option <?= $periode === 'trimestre' ? 'selected' : ''; ?>
                        value="trimestre">Ce trimestre</option>
                      <option <?= $periode === 'semestre' ? 'selected' : ''; ?> value="semestre">
                        Ce semestre</option>
                      <option <?= $periode === 'annuel' ? 'selected' : ''; ?> value="annuel">Cette
                        année</option>
                    </select>
                  </div>
                </fieldset>

                <fieldset id="datepairOne" style="display: none;">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Personnaliser </legend>
                  <p>
                    <label for="defaultFormControlInput" class="form-label">Date:</label>
                    <br>
                    <input name="dateOne" id="dateOne" readonly style="border: 1px solid black;"
                      type="text" class="this-form-control col-xs-12 col-md-12 date start "
                      value="<?= $dateOne ? $dateOne : ''; ?>" placeholder="Choisir..." />
                  </p>
                </fieldset>

                <fieldset id="datepair" style="display: none;">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Personnaliser </legend>
                  <p>
                    <label for="defaultFormControlInput" class="form-label">Début:</label>
                    <br>
                    <input name="dateDebut" id="dateDebut" readonly style="border: 1px solid black;"
                      type="text" class="this-form-control col-xs-12 col-md-12 date start "
                      value="<?= $dateDebut ? $dateDebut : ''; ?>" placeholder="Choisir..." />
                    <!-- <input name="heureDebut" id="heureDebut" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5  time start " value="<?= (isset($_GET['heureDebut'])) ? $_GET['heureDebut'] : ''; ?>" placeholder="Choisir..." /> -->
                    <br><br>
                    <label for="defaultFormControlInput" class="form-label">Fin:</label>
                    <br>
                    <input name="dateFin" id="dateFin" readonly style="border: 1px solid black;"
                      type="text" class="this-form-control col-xs-12 col-md-12 date end "
                      value="<?= $dateFin ? $dateFin : ''; ?>" placeholder="Choisir..." />
                    <!-- <input name="heureFin" id="heureFin" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5 time end " value="<?= (isset($_GET['heureFin'])) ? $_GET['heureFin'] : ''; ?>" placeholder="Choisir..." /> -->
                  </p>
                </fieldset>
              </div>



              <div class="col-md-2 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Date réalisation</legend>
                  <div class="card ">
                    <select name="periodeRealisation" id="periodeRealisation" class="form-control"
                      onchange="dateRealisationSelect(this.value)">
                      <option value="">Tout</option>
                      <option value="today">Aujourd'hui</option>
                      <option value="1">A la date du</option>
                      <option value="2">Personnaliser</option>
                      <option value="semaine">cette semaine</option>
                      <option value="mois">ce mois</option>
                      <option value="trimestre">Ce trimestre</option>
                      <option value="semestre">Ce semestre</option>
                      <option value="annuel">Cette année</option>
                    </select>
                  </div>
                </fieldset>

                <fieldset id="datepairOneRealisation" style="display: none;">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Personnaliser </legend>
                  <p>
                    <label for="defaultFormControlInput" class="form-label">Date:</label>
                    <br>
                    <input name="dateOneRealisation" id="dateOneRealisation" readonly
                      style="border: 1px solid black;" type="text"
                      class="this-form-control col-xs-12 col-md-12 date start"
                      placeholder="Choisir..." />
                  </p>
                </fieldset>

                <fieldset id="datepairRealisation" style="display: none;">
                  <legend
                    class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Personnaliser </legend>
                  <p>
                    <label for="defaultFormControlInput" class="form-label">Début:</label>
                    <br>
                    <input name="dateDebutRealisation" id="dateDebutRealisation" readonly
                      style="border: 1px solid black;" type="text"
                      class="this-form-control col-xs-12 col-md-12 date start"
                      placeholder="Choisir..." />
                    <!-- <input name="heureDebut" id="heureDebut" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5  time start " value="<?= (isset($_GET['heureDebut'])) ? $_GET['heureDebut'] : ''; ?>" placeholder="Choisir..." /> -->
                    <br><br>
                    <label for="defaultFormControlInput" class="form-label">Fin:</label>
                    <br>
                    <input name="dateFinRealisation" id="dateFinRealisation" readonly
                      style="border: 1px solid black;" type="text"
                      class="this-form-control col-xs-12 col-md-12 date end"
                      placeholder="Choisir..." />
                    <!-- <input name="heureFin" id="heureFin" style="border: 1px solid black; display: none;" type="text" class="this-form-control col-md-offset-1 col-md-4 col-xs-offset-1 col-xs-5 time end " value="<?= (isset($_GET['heureFin'])) ? $_GET['heureFin'] : ''; ?>" placeholder="Choisir..." /> -->
                  </p>
                </fieldset>
              </div>


            </div>
            <div class="col-6 text-center mt-3 mx-auto">
              <button type="submit" class="btn btn-danger form-control mt-2" style="border-radius: 0px;">
                FILTRER
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mt-3" id="accordionFiltrea">
  <div class="table-responsive">
    <div class="card accordion-item"
      style="background-color: transparent !important;border-radius: none !important; box-shadow: none !important;">
      <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
        style="box-shadow: none !important;">
        <div class="card" style="background-color: transparent !important;">
          <div class="card-body">
            <?php if ($_SESSION["connectedUser"]->role == 1 || $_SESSION["connectedUser"]->role == 2): ?>
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

<!-- Remplacer la modal de création de répertoire -->
<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="popupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-red text-white">
        <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Créer un répertoire</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <form id="formCreateRepertoire">
        <div class="modal-body px-4 py-4">
          <!-- Liste des sociétés avec style sommaire -->
          <div class="section-title mb-3">
            <h6 class="font-weight-bold">Sociétés</h6>
          </div>
          <div class="sections-container">
            <div id="societies-tree" class="sections-list">
              <!-- Les sociétés seront affichées ici -->
            </div>
          </div>

          <input type="hidden" id="selectedSocieteId" name="societeId">
          <input type="hidden" id="selectedParentId" name="parentId">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Ajouter la nouvelle modal pour créer un sous-dossier -->
<div class="modal fade" id="createSubFolderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-red text-white">
        <h5 class="modal-title m-0 w-100 text-center font-weight-bold">Créer un sous-dossier</h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <form id="formCreateSubFolder">
        <div class="modal-body px-4 py-4">
          <div class="form-group">
            <label class="font-weight-bold">Nom du sous-dossier</label>
            <input type="text" id="subFolderName" class="form-control" required>
            <input type="hidden" id="parentFolderId" name="parentId">
            <input type="hidden" id="parentSocieteId" name="societeId">
          </div>
        </div>
        <div class="modal-footer px-4 pb-4 pt-0">
          <button type="submit" class="btn btn-red btn-lg w-100">
            Créer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Remplacer la section des compteurs -->
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold text-info text-uppercase mb-1">
                <div class="btn btn-info btn-circle">
                  <i class="fas fa-file-alt"></i>
                </div>
                <span class="mt-2">&nbsp;En attente</span>
              </div>
              <hr>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="documentsEnAttente">
                <i class="fas fa-spinner fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                <div class="btn btn-success btn-circle">
                  <i class="fas fa-file-import"></i>
                </div>
                <span class="mt-2">&nbsp;Affectés</span>
              </div>
              <hr>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="documentsAffectes">
                <i class="fas fa-spinner fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold text-danger text-uppercase mb-1">
                <div class="btn btn-danger btn-circle">
                  <i class="fas fa-check"></i>
                </div>
                <span class="mt-2">&nbsp;Traités</span>
              </div>
              <hr>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="documentsTraites">
                <i class="fas fa-spinner fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-3 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">
                <div class="btn btn-warning btn-circle">
                  <i class="fas fa-exclamation"></i>
                </div>
                <span class="mt-2">&nbsp;En retard</span>
              </div>
              <hr>
              <div class="h5 mb-0 font-weight-bold text-gray-800" id="documentsEnRetard">
                <i class="fas fa-spinner fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Tableua -->
<div class="mt-4">
  <div class="table-responsive">
    <table class="table table-bordered" id="tabledata" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Nom de tâche</th>
          <th>Assigné à</th>
          <th>Nom du document</th>
          <th>Site</th>
          <th>Date importation</th>
          <th>Date assignation</th>
          <th>Date réalisation</th>
          <th>Statut</th>
        </tr>
      </thead>
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
        <canvas id="chartTaches"></canvas>
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
        <canvas id="chartSites"></canvas>
      </div>
    </div>
  </div>
</div>


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<script>
  var isAdmin = `<?= $_SESSION["connectedUser"]->isAdmin ?>`;
  const tachesStats = <?= json_encode($data['tachesStats']) ?>;
  const topUsersLabels = <?= json_encode($data['topUsersLabels']) ?>;
  const topUsersCounts = <?= json_encode($data['topUsersCounts']) ?>;
  const siteLabels = <?= json_encode($data['siteLabels']) ?>;
  const siteCounts = <?= json_encode($data['siteCounts']) ?>;

  $(document).ready(function() {
    // Fonction pour mettre à jour les compteurs
    function updateCompteurs() {
      const params = {
        action: 'getTableauDeBordStats',
        etat: $('select[name="etat"]').val() || '',
        site: $('#site').val() || '',
        assigner: $('select[name="assigner"]').val() || '',
        periode: $('#periode').val() || '',
        dateOne: $('#dateOne').val() || '',
        dateDebut: $('#dateDebut').val() || '',
        dateFin: $('#dateFin').val() || ''
      };

      // Convertir les paramètres en string de requête
      const queryString = Object.keys(params)
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
        .join('&');

      $.ajax({
        url: `<?= URLROOT ?>/public/json/scanDocument.php?${queryString}`,
        type: 'GET',
        success: function(response) {
          if (response.success) {
            $('#documentsEnAttente').text(response.data.documentsEnAttente);
            $('#documentsAffectes').text(response.data.documentsAffectes);
            $('#documentsTraites').text(response.data.documentsTraites);
            $('#documentsEnRetard').text(response.data.documentsEnRetard);
          }
        },
        error: function(xhr, error, thrown) {
          console.error("Erreur AJAX :", xhr.responseText);
        }
      });
    }

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
      "aLengthMenu": [
        [5, 10, 25, 50, 100, 500],
        [5, 10, 25, 50, 100, 500]
      ],
      "iDisplayLength": 50,
      "order": [
        [4, 'desc'] // Trier par la colonne Date importation (index 4) en ordre décroissant
      ],
      "ajax": {
        "url": `<?= URLROOT ?>/public/json/scanDocument.php`,
        "type": "GET",
        "data": function(d) {
          return {
            ...d,
            action: 'getTableauDeBordDataTable',
            etat: $('select[name="etat"]').val() || '',
            nom: $('select[name="nom"]').val() || '',
            assigner: $('select[name="assigner"]').val() || '',
            site: $('#site').val() || '',
            periode: $('#periode').val() || '',
            dateOne: $('#dateOne').val() || '',
            dateDebut: $('#dateDebut').val() || '',
            dateFin: $('#dateFin').val() || '',
            periodeRealisation: $('#periodeRealisation').val() || '',
            dateOneRealisation: $('#dateOneRealisation').val() || '',
            dateDebutRealisation: $('#dateDebutRealisation').val() || '',
            dateFinRealisation: $('#dateFinRealisation').val() || ''
          };
        },
        "error": function(xhr, error, thrown) {
          console.error("Erreur AJAX :", xhr.responseText);
          alert("Erreur lors du chargement des données. Vérifiez la console.");
        }
      },
      order: [
        [0, 'desc']
      ]
    });

    // Met à jour le titre avec le nombre total d'enregistrements
    table.on('xhr.dt', function(e, settings, json, xhr) {
      if (json && json.recordsFiltered !== undefined) {
        const total = json.recordsFiltered;
        $('#titre').text(`Tableau de bord (${total} documents)`);
      }
    });

    // Rafraîchir la table quand le formulaire est soumis
    $('form').on('submit', function(e) {
      e.preventDefault();
      table.ajax.reload();
      updateCompteurs();
    });
  });

  function dateCreationSelect(val) {
    console.log("Changement de période sélectionnée:", val); // Debug

    // Toujours cacher les deux blocs d'abord
    document.getElementById("datepair").style.display = "none";
    document.getElementById("datepairOne").style.display = "none";

    // Puis afficher le bon
    if (val === "1") {
      document.getElementById("datepairOne").style.display = "block";
    } else if (val === "2") {
      document.getElementById("datepair").style.display = "block";
    }
  }

  function dateRealisationSelect(val) {
    document.getElementById("datepairRealisation").style.display = "none";
    document.getElementById("datepairOneRealisation").style.display = "none";

    if (val === "1") {
      document.getElementById("datepairOneRealisation").style.display = "block";
    } else if (val === "2") {
      document.getElementById("datepairRealisation").style.display = "block";
    }
  }

  $(document).ready(function() {
    const periodeSelected = $("#periode").val();
    dateCreationSelect(periodeSelected);
    $('.select3').select2();
    $('#dateOne').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });

    $('#dateDebut').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });

    $('#dateFin').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });

    $('#dateOneRealisation').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });

    $('#dateDebutRealisation').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });

    $('#dateFinRealisation').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });
  });






  function loadUserListDynamic() {
    const entreprise = document.getElementById("entrepriseInput").value.trim();
    const annee = document.getElementById("anneeInput").value.trim();
    const service = document.getElementById("serviceInput").value.trim();
    if (!entreprise || !annee || !service) return;

    $.ajax({
      url: '<?= URLROOT ?>/public/json/scanDocument.php',
      type: 'GET',
      data: {
        action: 'getAvailableUsers',
        entreprise: entreprise,
        annee: annee,
        service: service
      },
      success: function() {
        window.location.reload();
      },
      error: function(xhr, status, error) {
        console.error('Erreur AJAX', error);
      }
    });
  }

  // Variables globales pour stocker la structure
  let directoryStructure = {};

  // Charger la structure des répertoires au chargement du modal
  $(function() { // DOM prêt
    $(document).on('shown.bs.modal', // délégation = sûr
      '#leaveRequestModal',
      function() { // le modal vient
        console.log('modal ouvert') // vérifie dans la console

        $.ajax({
          url: '<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders',
          type: 'POST',
          data: {
          },
          dataType: 'json',
          success: function(data) {
            console.log('structure:', data);
            directoryStructure = data;
            fillSelect($('#entrepriseSelect'), Object.keys(data));
            resetAnneeService();
          },
          error: function(xhr, status, error) {
            console.error('fetch error', error);
          }
        });

      })
  })

  // aide brève
  const fillSelect = (sel, arr) => {
    sel.empty()
      .append('<option value="">-- Sélectionner --</option>');
    arr.forEach(v => sel.append(`<option value="${v}">${v}</option>`));
  };

  /* ---------------------- niveau ENTREPRISE ------------------ */
  $('#entrepriseSelect').on('change', function() {
    const ent = this.value;
    const years = ent ? Object.keys(directoryStructure[ent] || {}) : [];
    fillSelect($('#anneeSelect').prop('disabled', !years.length), years);
    resetService(); // vide service + rep
    resetRep();
  });

  /* ------------------------- niveau ANNEE -------------------- */
  $('#anneeSelect').on('change', function() {
    const ent = $('#entrepriseSelect').val();
    const y = this.value;
    // <-- ICI : on prend les CLÉS de l'objet
    const svcs = (ent && y) ? Object.keys(directoryStructure[ent][y] || {}) : [];
    fillSelect($('#serviceSelect').prop('disabled', !svcs.length), svcs);
    resetRep();
  });

  /* ------------------------ niveau SERVICE ------------------- */
  $('#serviceSelect').on('change', function() {
    const e = $('#entrepriseSelect').val();
    const y = $('#anneeSelect').val();
    const s = this.value;
    const reps = (e && y && s) ? (directoryStructure[e][y][s] || []) : [];

    /* on n’utilise plus !reps.length pour désactiver :
       le select reste actif même si la liste est vide */
    fillSelect($('#repSelect').prop('disabled', false), reps);
  });

  // réinitialisations
  function resetAnneeService() {
    $('#anneeSelect, #serviceSelect').prop('disabled', true).empty()
    $('#anneeSelect').append('<option value="">-- Sélectionner une année --</option>')
    $('#serviceSelect').append('<option value="">-- Sélectionner un service --</option>')
  }

  function resetService() {
    $('#serviceSelect').prop('disabled', true).empty()
      .append('<option value="">-- Sélectionner un service --</option>')
  }

  function resetRep() {
    $('#repSelect').prop('disabled', true).empty()
      .append('<option value="">-- Sélectionner un répertoire --</option>')
  }



  // Fonction pour charger la structure existante
  function loadDirectoryStructure() {
    $.ajax({
      url: '<?= URLROOT ?>/public/json/scanDocument.php?action=getDirectoryStructure',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        directoryStructure = data;
        populateEntrepriseSelect();
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });

  }

  // Remplir le select des entreprises
  function populateEntrepriseSelect() {
    const select = $('#entrepriseSelect');
    select.empty().append('<option value="">-- Sélectionner une entreprise --</option>');

    Object.keys(directoryStructure).forEach(entreprise => {
      select.append(`<option value="${entreprise}">${entreprise}</option>`);
    });
  }

  // Remplir le select des années (quand une entreprise est sélectionnée)
  // $('#entrepriseSelect').change(function() {
  //     const entreprise = $(this).val();
  //     const anneeSelect = $('#anneeSelect');

  //     anneeSelect.empty().append('<option value="">-- Sélectionner une année --</option>');
  //     $('#serviceSelect').empty().prop('disabled', true);

  //     if (entreprise) {
  //         anneeSelect.prop('disabled', false);

  //         if (directoryStructure[entreprise]) {
  //             Object.keys(directoryStructure[entreprise]).forEach(annee => {
  //                 anneeSelect.append(`<option value="${annee}">${annee}</option>`);
  //             });
  //         }
  //     } else {
  //         anneeSelect.prop('disabled', true);
  //     }
  // });

  $('#anneeSelect').change(function() {
    const entreprise = $('#entrepriseSelect').val();
    const annee = $(this).val();
    const $service = $('#serviceSelect');

    $service.empty().append('<option value="">-- Sélectionner un service --</option>');

    if (entreprise && annee && directoryStructure[entreprise]?.[annee]) {
      const services = Object.keys(directoryStructure[entreprise][annee]);
      services.forEach(s => $service.append(`<option value="${s}">${s}</option>`));
      $service.prop('disabled', false);
    } else {
      $service.prop('disabled', true);
    }
  });


  // Afficher le champ pour créer un nouvel élément
  function showNewField(type) {
    $(`#new${type.charAt(0).toUpperCase() + type.slice(1)}Field`).show();
    $(`#${type}Select`).prop('disabled', true);
  }

  // // Soumission du formulaire
  // document.getElementById("formCreateRepertoire").addEventListener("submit", async function(e) {
  //     e.preventDefault();

  //     // Récupérer les valeurs
  //     let entreprise = $('#entrepriseSelect').val() || $('#newEntrepriseInput').val().trim();
  //     let annee = $('#anneeSelect').val() || $('#newAnneeInput').val().trim();
  //     let service = $('#serviceSelect').val() || $('#newServiceInput').val().trim();
  //     let rep = $('#repSelect').val() || $('#newRepInput').val().trim()

  //     if (!entreprise) {
  //         alert("L'entreprise est obligatoire.");
  //         return;
  //     }

  //     // Si année non spécifiée, créer juste l'entreprise
  //     if (!annee) {
  //         annee = null;
  //         service = null;
  //     } 
  //     // Si service non spécifié, créer entreprise + année
  //     else if (!service) {
  //         service = null;
  //     }

  //     // Appel API pour créer la structure
  //     $.ajax({
  //       url: '<?= URLROOT ?>/public/json/scanDocument.php?action=createDirectoryStructure',
  //       type: 'POST',
  //       contentType: 'application/json',
  //       data: JSON.stringify({ entreprise, annee, service, rep }),
  //       success: function () {
  //         $('#leaveRequestModal').modal('hide');
  //         loadDirectoryStructure();
  //       },
  //       error: function (xhr, status, error) {
  //         console.error(error);
  //       }
  //     });

  //   });
  // Données simulées (remplace avec tes vraies données PHP)
  const tachesData = {
    labels: ['En attente', 'Affectés', 'Traités', 'En retard'],
    datasets: [{
      label: 'Tâches',
      data: [
        tachesStats.attente || 0,
        tachesStats.ouvertes || 0,
        tachesStats.cloturees || 0,
        tachesStats.enretard || 0
      ],
      backgroundColor: ['#17a2b8', '#28a745', '#dc3545', '#ffc107']
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


  function updateCompteurs() {
    // Construire l'URL avec les paramètres de filtrage
    const params = new URLSearchParams({
      action: 'getTableauDeBordStats',
      etat: $('select[name="etat"]').val() || '',
      site: $('#site').val() || '',
      assigner: $('select[name="assigner"]').val() || '',
      periode: $('#periode').val() || '',
      dateOne: $('#dateOne').val() || '',
      dateDebut: $('#dateDebut').val() || '',
      dateFin: $('#dateFin').val() || ''
    });

    $.ajax({
      url: `<?= URLROOT ?>/public/json/scanDocument.php?${params}`,
      type: 'GET',
      success: function(response) {
        console.log(response)
        if (response.success) {
          $('#documentsEnAttente').text(response.data.documentsEnAttente);
          $('#documentsAffectes').text(response.data.documentsAffectes);
          $('#documentsTraites').text(response.data.documentsTraites);
          $('#documentsEnRetard').text(response.data.documentsEnRetard);

          // Mise à jour des graphiques
          updateChartsData(response.data);
        }
      },
      error: function(response) {
        console.error("Erreur AJAX :");
        console.log(response)
      }
    });
  }

  $(document).ready(function() {
    // Appel initial
    updateCompteurs();

    // Mettre à jour les compteurs lors du filtrage
    $('form').on('submit', function(e) {
      e.preventDefault();
      table.ajax.reload();
      updateCompteurs();
    });
  });

  // Remplacer la fonction updateChartsData
  function updateChartsData(data) {
    // Mise à jour des données pour le graphique des tâches
    if (window.chartTaches) {
      console.log(window.chartTaches.data)
      window.chartTaches.data.datasets[0].data = [
        data.tachesStats.attente || 0,
        data.tachesStats.ouvertes || 0,
        data.tachesStats.cloturees || 0,
        data.tachesStats.enretard || 0
      ];
      window.chartTaches.update();
    }

    // Mise à jour des données pour le graphique des utilisateurs
    if (window.chartTopUsers) {
      window.chartTopUsers.data.labels = data.topUsersLabels || [];
      window.chartTopUsers.data.datasets[0].data = data.topUsersCounts || [];
      window.chartTopUsers.update();
    }

    // Mise à jour des données pour le graphique des sites
    if (window.chartSites) {
      window.chartSites.data.labels = data.siteLabels || [];
      window.chartSites.data.datasets[0].data = data.siteCounts || [];
      window.chartSites.update();
    }

    // Mise à jour sécurisée des totaux
    const chartTachesTotal = document.querySelector('#chartTachesTotal');
    if (chartTachesTotal) {
      chartTachesTotal.textContent = 'Total ' +
        (data.tachesStats.ouvertes + data.tachesStats.cloturees + data.tachesStats.attente);
    }

    const chartUsersTotal = document.querySelector('#chartUsersTotal');
    if (chartUsersTotal) {
      chartUsersTotal.textContent = 'Total ' +
        data.topUsersCounts.reduce((a, b) => a + b, 0);
    }

    const chartSitesTotal = document.querySelector('#chartSitesTotal');
    if (chartSitesTotal) {
      chartSitesTotal.textContent = 'Total ' +
        data.siteCounts.reduce((a, b) => a + b, 0);
    }
  }

  // Replace the loadDirectoryStructure call
  $(function() {
    $(document).on('shown.bs.modal', '#leaveRequestModal', function() {
      console.log('modal ouvert');

      // Call getFolders instead of getDirectoryStructure
      $.ajax({
        url: '<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders',
        type: 'POST',
        data: {
          idSociete: '' // Empty to get all societies
        },
        success: function(response) {
          if (response.success) {
            const societiesList = $('#societies-tree');
            societiesList.empty();

            if (response.societies) {
              response.societies.forEach(society => {
                societiesList.append(`
                                <div class="section-item" data-societe-id="${society.id}">
                                    <div class="d-flex align-items-center justify-content-between w-100">
                                        <i class="fas fa-chevron-right folder-toggle mr-2"></i>
                                        <i class="fas fa-building"></i>
                                        <span class="ml-2">${society.name}</span>
                                        <button type="button" class="btn btn-sm btn-outline-danger add-root-folder-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="folder-structure pl-4" style="display: none;">
                                        <div class="folders-loading">
                                            <i class="fas fa-spinner fa-spin"></i> Chargement...
                                        </div>
                                    </div>
                                </div>
                            `);
              });

              // Gérer le clic sur la flèche
              $('.folder-toggle').click(function(e) {
                e.stopPropagation();
                const $sectionItem = $(this).closest('.section-item');
                const $folderStructure = $sectionItem.find(
                  '.folder-structure');
                const societeId = $sectionItem.data('societe-id');
                $(this).toggleClass('fa-chevron-right fa-chevron-down');

                if ($folderStructure.is(':hidden')) {
                  // Charger les dossiers uniquement lors du premier affichage
                  if ($folderStructure.find('.folders-loading')
                    .length) {
                    loadSocietyFolders(societeId, $folderStructure);
                  }
                }

                $folderStructure.slideToggle();
              });

              // Gérer la sélection de la société
              $('.section-item').click(function(e) {
                if (!$(e.target).hasClass('folder-toggle')) {
                  $('.section-item').removeClass('active');
                  $(this).addClass('active');
                  $('#selectedSocieteId').val($(this).data(
                    'societe-id'));
                }
              });

              // Ajouter le gestionnaire d'événements pour le nouveau bouton
              $('.add-root-folder-btn').click(function(e) {
                e.stopPropagation();
                const societeId = $(this).closest('.section-item').data(
                  'societe-id');
                $('#parentFolderId').val(
                  ''); // Pas de parent pour un dossier racine
                $('#parentSocieteId').val(societeId);
                $('#createSubFolderModal').modal('show');
              });
            }
          }
        },
        error: function(xhr, error) {
          console.error('Erreur lors du chargement des sociétés:', error);
        }
      });
    });
  });

  // Ajouter ces nouvelles fonctions
  function loadSocietyFolders(societeId, container) {
    $.ajax({
      url: '<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders',
      type: 'POST',
      data: {
        idSociete: societeId
      },
      success: function(response) {
        if (response.success && response.folders) {
          container.empty();
          console.log(response)
          renderFolders(response.folders, container);
        }
      },
      error: function(xhr, error) {
        container.html('<div class="text-danger">Erreur de chargement</div>');
      }
    });
  }

  function renderFolders(folders, container) {
    folders.forEach(folder => {
      const folderElement = $(`
            <div class="folder-item" data-folder-id="${folder.id}">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="d-flex align-items-center">
                        ${folder.hasChildren ? 
                            '<i class="fas fa-chevron-right folder-toggle-sub mr-2"></i>' : 
                            '<i class="fas fa-folder mr-2"></i>'}
                        <span class="folder-name">${folder.nom}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger add-subfolder-btn">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="subfolder-structure" style="display: none;">
                    ${folder.hasChildren ? 
                        '<div class="folders-loading"><i class="fas fa-spinner fa-spin"></i> Chargement...</div>' : ''}
                </div>
            </div>
        `);

      // Gestion du clic sur le bouton +
      folderElement.find('.add-subfolder-btn').click(function(e) {
        e.stopPropagation();
        const folderId = $(this).closest('.folder-item').data('folder-id');
        const societeId = $('.section-item.active').data('societe-id');
        $('#parentFolderId').val(folderId);
        $('#parentSocieteId').val(societeId);
        $('#createSubFolderModal').modal('show');
      });

      container.append(folderElement);

      // Gérer le clic sur la flèche
      const toggleBtn = folderElement.find('.folder-toggle-sub');
      if (toggleBtn.length) {
        toggleBtn.click(function(e) {
          e.stopPropagation();
          const $item = $(this).closest('.folder-item');
          const $subfolders = $item.find('> .subfolder-structure');

          $(this).toggleClass('fa-chevron-right fa-chevron-down');

          if ($subfolders.is(':hidden') && $subfolders.find('.folders-loading').length) {
            loadSubFolders(folder.id, $subfolders);
          }

          $subfolders.slideToggle();
        });
      }
    });
  }

  function loadSubFolders(parentId, container) {
    $.ajax({
      url: '<?= URLROOT ?>/public/json/scanDocument.php?action=getFolders',
      type: 'POST',
      data: {
        idParent: parentId
      },
      success: function(response) {
        if (response.success && response.folders) {
          container.empty();
          renderFolders(response.folders, container);
        }
      },
      error: function(xhr, error) {
        container.html('<div class="text-danger">Erreur de chargement</div>');
      }
    });
  }

  // Remplacer la fonction de soumission du formulaire de sous-dossier
  $('#formCreateSubFolder').on('submit', function(e) {
    e.preventDefault();

    const parentId = $('#parentFolderId').val();
    const societeId = $('#parentSocieteId').val();
    const name = $('#subFolderName').val().trim();

    // Validation
    if (!name) {
      alert('Veuillez saisir un nom de dossier');
      return;
    }

    if (!societeId) {
      alert('Veuillez sélectionner une société');
      return;
    }

    // Préparer FormData comme dans pointage.php
    const formData = new FormData();
    formData.append('parentId', parentId);
    formData.append('societeId', societeId);
    formData.append('nom', name);

    $.ajax({
      url: `<?= URLROOT ?>/public/json/scanDocument.php?action=createDirectory`,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(response) {
        if (response.success) {
          $('#createSubFolderModal').modal('hide');

          // Recharger la structure des dossiers
          const parentFolder = $(`.folder-item[data-folder-id="${parentId}"]`);
          if (parentFolder.length) {
            const subfolderContainer = parentFolder.find('.subfolder-structure');
            loadSubFolders(parentId, subfolderContainer);
          }

          // Reset form
          $('#subFolderName').val('');
          alert('Dossier créé avec succès');

          if (typeof table !== 'undefined') {
            table.ajax.reload();
          }
        } else {
          alert(response.error || 'Une erreur est survenue');
        }
      },
      error: function(xhr, status, error) {
        console.error('Erreur Ajax:', error);
        alert('Erreur lors de la création du dossier: ' + error);
      }
    });
  });
</script>
<style>
  .folder-structure {
    margin-left: 1.5rem;
    padding-left: 1.5rem;
    border-left: 2px solid #ddd;
  }

  .folder-item {
    position: relative;
    margin: 0.5rem 0;
    padding-left: 1.5rem;
  }

  .folder-item:before {
    content: '';
    position: absolute;
    left: -2px;
    top: 50%;
    width: 1.5rem;
    height: 2px;
    background-color: #ddd;
  }

  .subfolder-structure {
    margin-left: 1rem;
    padding-left: 1.5rem;
    border-left: 2px solid #ddd;
  }

  .subfolder-item {
    position: relative;
    margin: 0.5rem 0;
    padding-left: 1.5rem;
  }

  .subfolder-item:before {
    content: '';
    position: absolute;
    left: -2px;
    top: 50%;
    width: 1.5rem;
    height: 2px;
    background-color: #ddd;
  }

  .section-item {
    position: relative;
    margin: 0.5rem 0;
    padding: 0.75rem;
    border-radius: 4px;
    background: white;
    border: 1px solid #edf2f7;
  }

  .section-item .folder-structure {
    margin-top: 1rem;
  }

  .folder-toggle,
  .folder-toggle-sub {
    width: 20px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s;
    position: relative;
    z-index: 1;
  }

  .folder-toggle.fa-chevron-down,
  .folder-toggle-sub.fa-chevron-down {
    transform: rotate(90deg);
  }

  .folder-name {
    margin-left: 0.5rem;
    position: relative;
    z-index: 1;
  }

  .folders-loading {
    padding: 0.5rem;
    color: #666;
    margin-left: 1.5rem;
  }

  .add-subfolder-btn {
    padding: 0.25rem 0.5rem;
    line-height: 1;
    font-size: 0.875rem;
    margin-left: 0.5rem;
  }

  .add-root-folder-btn {
    padding: 0.25rem 0.5rem;
    line-height: 1;
    font-size: 0.875rem;
    margin-left: 0.5rem;
  }

  .section-item.active {
    background-color: #f8f9fa;
    margin-left: 1.5rem;
  }

  .add-subfolder-btn {
    padding: 0.25rem 0.5rem;
    line-height: 1;
    font-size: 0.875rem;
    margin-left: 0.5rem;
  }

  .section-item.active {
    background-color: #f8f9fa;
    border-color: #dc3545;
  }
</style>