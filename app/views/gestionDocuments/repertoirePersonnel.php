<?php

?>
<div class="section-title mb-0">
    <h2 class="mb-0">
        <button onclick="history.back()">
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000"></i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-file" style="color: #c00000"></i>
            Répertoire Personnel
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
        <legend class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
            &nbsp;la tâche
        </legend>
        <select name="idUtilisateur" class="form-control" id="contactSelect">
    <option value="">Tout</option>
    <?php if (!empty($taches)): ?>
        <?php foreach ($taches as $tache): ?>
            <option <?= $idUser == $tache->idActivity ? 'selected' : '' ?> value="<?= htmlspecialchars($tache->idActivity) ?>">
                <?= htmlspecialchars($tache->numeroActivity . ' - ' . $tache->nomDocument) ?>
            </option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="aucun">Aucune tâche disponible</option>
    <?php endif; ?>
</select>

    </fieldset>
</div>

              <div class="col-md-4 col-xs-12 mb-3">
                <fieldset class="py-3">
                  <legend class='col-md-12 text-white text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                    Statut
                  </legend>
                  <select name="etat" class="form-control">
                    <option value="">Tout</option>
                    <option value="1" <?= isset($_GET['etat']) && $_GET['etat'] === '1' ? 'selected' : '' ?>>Ouvert</option>
                    <option value="0" <?= isset($_GET['etat']) && $_GET['etat'] === '0' ? 'selected' : '' ?>>Clôturé</option>
                  </select>
                </fieldset>
              </div>
              
              
                            <div class="col-md-4 col-xs-12 mb-3">
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

<div class="container mt-4">
  <h4 class="mb-3">Mes tâches personnelles</h4>
  <div class="table-responsive">
  <table id="dataTable16" class="table table-bordered" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Visualiser</th>
          <th>Nom</th>
          <th>Assigné par</th>
          <th>Nom du document</th>
          <th>Date d'importation</th>
          <th>Date début</th>
          <th>Date fin</th>
          <th>société</th>
          <th>Statut</th>
          <?php if ($tache->isCleared == 0) { ?>
  <th>Action</th>
<?php } ?>

        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php foreach ($data['taches'] as $tache): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td class="text-center">
            <?php if (!empty($tache->urlDocument)): ?>
                <a href="<?= URLROOT ?>/public/documents/repertoires/<?= $tache->urlDocument ?>" target="_blank" class="btn btn-sm btn-icon" style="background: #e74c3c; color:white">
                <i class="fas fa-eye"></i>
                </a>
            <?php else: ?>
                <span class="text-muted">—</span>
            <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($tache->numeroActivity) ?></td>
            <td><?= htmlspecialchars($tache->assignerName) ?></td>
            <td><?= htmlspecialchars($tache->nomDocument) ?></td>
            <td><?= date('d/m/Y', strtotime($tache->createDate)) ?></td>
            <td><?= date('d/m/Y', strtotime($tache->startTime)) ?></td>
            <td><?= date('d/m/Y', strtotime($tache->endTime)) ?></td>
            <td><?= htmlspecialchars($tache->urlDocument) ?></td>
            <td>
              <?php if ($tache->isCleared == 0): ?>
                <span class="badge badge-success">Ouvert</span>
              <?php else: ?>
                <span class="badge badge-danger">Clôturé</span>
              <?php endif; ?>
            </td>
            <?php if ($tache->isCleared != 1): ?>
    <td>
        <form method="POST" action="<?= URLROOT ?>/gestionDocuments/desassocier" style="display: inline;">
            <button type="button" class="btn btn-sm btn-danger" onclick="openConfirmModal(<?= $tache->idActivity ?>)">
                désassigner
            </button>
        </form>
        <form method="POST" style="display: inline;">
            <button type="button" class="btn btn-sm btn-success" onclick="openTreatModal(<?= $tache->idActivity ?>)">
                Traiter
            </button>
        </form>
    </td>
<?php else: ?>
    <!-- Pas de colonne affichée si isCleared == 0 -->
<?php endif; ?>


          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>


<!-- Modal -->
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


<script src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>

<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/datepair.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/jquery.datepair.js"></script>
<script src="<?= URLROOT ?>/assets/ticket/vendor/js/bootstrap.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>

  function dateCreationSelect(val) {
                if (val == 2) {
                    $('#datepair').show();
                    $('#datepairOne').hide();
                } else if (val == 1) {
                    $('#datepairOne').show();
                    $('#datepair').hide();
                } else {
                    $('#datepair').hide();
                    $('#datepairOne').hide();
                }
            }

            $(document).ready(function() {
                var dateCreation = $('#periode').val();
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

            });

let selectedActivityId = null;
let currentAction = null;

function openConfirmModal(id) {
  selectedActivityId = id;
  currentAction = 'desassocier';
  document.getElementById("confirmModalTitle").innerText = "Confirmer la désassociation";
  document.getElementById("confirmModalBody").innerText = "Voulez-vous désassocier cette tâche ? Elle sera déplacée dans les documents communs.";
  document.getElementById("confirmModalHeader").className = "modal-header bg-danger text-white";
  $('#confirmModal').modal('show');
}

function openTreatModal(id) {
  selectedActivityId = id;
  currentAction = 'traiter';
  document.getElementById("confirmModalTitle").innerText = "Confirmer le traitement";
  document.getElementById("confirmModalBody").innerText = "Voulez-vous marquer cette tâche comme Clôturer ?";
  document.getElementById("confirmModalHeader").className = "modal-header bg-success text-white";
  $('#confirmModal').modal('show');
}

document.getElementById("confirmBtn").addEventListener("click", () => {
  if (!selectedActivityId || !currentAction) return;

  fetch("<?= URLROOT ?>/public/json/documents.php?action=traiter", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      action: currentAction,
      idActivity: selectedActivityId
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