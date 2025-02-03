<?php
$idRole = $_SESSION["connectedUser"]->role;
$viewAdmin = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
$viewAdmin2 = (($idRole == "1" || $idRole == "2" || $idRole == "8" || $idRole == "9" || $idRole == 25 || $_SESSION["connectedUser"]->isAccessAllOP == "1")) ? "" : "hidden";
// $pointageListe = $idRole == 1 || $idRole == 2 || $idRole == 25 ? $pointages : $pointagesById;

function formatDate($date)
{
    if (!empty($date)) {
        $dateObj = new DateTime($date);
        return $dateObj->format('d/m/Y');
    }
    return '-'; // Retourne un tiret si la date est vide ou nulle
}
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
            <i class="fas fa-fw fa-arrow-left" style="color: #c00000">
            </i>
        </button>
        <span>
            &nbsp;&nbsp;
            <i class="fas fa-fw fa-file" style="color: #c00000"></i>
            mes congés
        </span>
    </h2>
</div>

<div class=" mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="accordion-body" style="box-shadow: none !important;">
                    <form method="GET" id="filterForm" action="<?= linkTo('GestionInterne', 'gererConges') ?>"
                        style="border: none; margin: 0px !important; padding: 0px !important; margin: auto;">
                        <div class="row justify-content-center" style="width: 100%;  margin: auto;">
                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Employé
                                    </legend>
                                    <div class="card ">
                                        <select id="idUtilisateur" name="idUtilisateur" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($matricules as $contact) {
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

                            <div class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "col-md-2 col-xs-12" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Site
                                    </legend>
                                    <select id="site" name="idSite" class="form-control">
                                        <option value="">Tout</option>
                                        <?php
                                        foreach ($sites as $sit) {
                                            if ((($idRole == "1" || $idRole == "2" || $idRole == "9" || $idRole == "8" || $_SESSION["connectedUser"]->isAccessAllOP == "1") || (($idRole == "3" || $idRole == "25") && $_SESSION["connectedUser"]->nomSite == $sit->nomSite))) {
                                        ?>
                                                <option value="<?= $sit->idSite ?>">
                                                    <?= $sit->nomSite ?>
                                                </option>
                                        <?php
                                            }
                                        } ?>
                                    </select>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Type de congé
                                    </legend>
                                    <div class="card ">
                                        <select id="typeConge" name="typeConge" class="form-control">
                                            <option value="">Tout</option>
                                            <?php
                                            foreach ($typesConge as $type) {
                                            ?>
                                                <option value="<?= $type->idTypeConge ?>">
                                                    <?= $type->type ?>
                                                </option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        Statut
                                    </legend>
                                    <div class="card ">
                                        <select id="statut" name="statut" class="form-control">
                                            <option <?= $statut == "" ? 'selected' : '' ?> value="">Tout</option>
                                            <option <?= $statut == "1" ? 'selected' : '' ?> value="1">Approuvé</option>
                                            <option <?= $statut == "2" ? 'selected' : '' ?> value="2">Rejeté</option>
                                            <option <?= $statut == "3" ? 'selected' : '' ?> value="3">Annulé</option>
                                            <option <?= $statut == "0" ? 'selected' : '' ?> value="0">En attente</option>
                                        </select>
                                    </div>
                                </fieldset>
                            </div>

                            <div
                                class="<?= $viewAdmin2 != "" ? "col-md-4 col-xs-12 mb-3" : "col-md-2 col-xs-12 mb-3" ?>">
                                <fieldset class="py-4">
                                    <legend
                                        class='text-white col-md-12 text-uppercase font-weight-bold text-center py-2 badge bg-dark mx-0'>
                                        &nbsp;Date de demande
                                    </legend>
                                    <div class="card">
                                        <Select name="periode" id="dateDemande" class="form-control"
                                            onchange="dateCreationSelect(this.value)">
                                            <option value="">Tout</option>
                                            <option value="today">Aujourd'hui</option>
                                            <option value="annee">Année</option>
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

                                <!-- <p id="datepair" style="display: none;">
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
                                    </p> -->
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

    <div class="modal fade" id="detailCongeModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content shadow-lg rounded">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold text-uppercase" id="modalLabel">Détails du Congé</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body px-4 py-4">
                    <div class="row">

                        <div class="col-md-6">
                            <p><i class="fas fa-user"></i> <strong>L'employé:</strong> <span id="modalemploye"></span>
                            </p>
                            <p><i class="fas fa-id-badge"></i> <strong>Matricule:</strong> <span
                                    id="modalmatricule"></span></p>
                            <p><i class="fas fa-building"></i> <strong>Site:</strong> <span id="modalsite"></span></p>
                            <p><i class="fas fa-exclamation-circle"></i> <strong>Type:</strong> <span id="modaltype"></span></p>

                            <p><i class="fas fa-calendar-alt"></i><strong>Nombre de jours:</strong> <span
                                    id="modaljours"></span></p>
                            <p><i class="fas fa-exclamation-circle"></i> <strong>Statut:</strong> <span
                                    id="modalEtat"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début souhaitée:</strong> <span
                                    id="modalDebutSouhaite"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin souhaitée:</strong> <span
                                    id="modalFinSouhaite"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début proposée:</strong> <span
                                    id="modalDebutPropose"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin proposée:</strong> <span
                                    id="modalFinPropose"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de début du congé:</strong> <span
                                    id="modalDebut"></span></p>
                            <p><i class="fas fa-calendar-alt"></i> <strong>Date de fin du congé:</strong> <span
                                    id="modalFin"></span></p>


                            <span class="hidden" id="modalDebutSouhaiteHidden"></span>
                            <span class="hidden" id="modalFinSouhaiteHidden"></span>
                            <span class="hidden" id="modalDebutProposeHidden"></span>
                            <span class="hidden" id="modalFinProposeHidden"></span>
                            <span class="hidden" id="idUtilisateurHidden"></span>
                        </div>
                    </div>
                    <hr>
                    <div class="document-section">
                        <p>
                            <i class="fas fa-link"></i>
                            <strong>Pièces justificatives:</strong>
                            <span id="modalPieceJustificative"></span>
                        </p>
                        <div class="scrollable-container mb-3">
                            <span id="modalurlJustification"></span>
                        </div>
                    </div>
                    <hr>

                    <span class="justif-arrivee-text"></span>
                    <div class="arrivee-section">
                        <p>
                            <i class="fas fa-comment"></i>
                            <strong>Proposer une date:</strong>
                            <span id="modalMotifRetard"></span>
                        </p>

                        <div class="<?= $viewAdmin2 != '' ? $viewAdmin2 : 'row confirmDatePropose' ?>">
                            <div class="col-md-4 mb-3">
                                <label for="startDate">Date de début <small class="text-danger">*</small></label>
                                <input type="date" id="startDate" name="startDate" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="endDate">Date de fin <small class="text-danger">*</small></label>
                                <input type="date" id="endDate" name="endDate" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="commentaire">Commentaire <small class="text-danger">*</small></label>
                                <input type="text" id="commentaire" name="commentaire" placeholder="Ajouter un commentaire" class="form-control">
                            </div>
                        </div>
                        <div id="confirmDateProposeMsg"></div>
                        <br>
                        <div class="<?= $viewAdmin == '' ? 'hidden' : 'form-group confirmPropositionConge' ?>">
                            <p>
                                <i class="fas fa-comment"></i>
                                <strong>Commentaire:</strong>
                            <p id="modalCommentaire" style="font-size:16px;"></p>
                            </p>
                            <label for="confirmationDepart" class="font-weight-bold">Accepter ou refuser cette proposition.
                            </label>
                            <br>
                            <div class="row">
                                <div class="form-check d-inline-block ml-3">
                                    <input type="radio" class="form-check-input" id="acceptProposition"
                                        name="confirmProposition" value="accepter">
                                    <label class="form-check-label font-weight-bold"
                                        for="acceptProposition">Accepter</label>
                                </div>

                                <div class="form-check d-inline-block ml-3">
                                    <input type="radio" class="form-check-input" id="refuseProposition"
                                        name="confirmProposition" value="refuser">
                                    <label class="form-check-label font-weight-bold"
                                        for="refuseProposition">Refuser</label>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="<?= $viewAdmin == '' ? 'hidden' : 'form-group' ?>">
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="button"
                                            id="confirmPropositionSubmit">Confirmer</button>
                                        <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                    </div>
                                </div>
                                <div class="hidden dateProposeMsg"></div>
                            </div>
                        </div>

                        <div class="mt-0">
                            <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group confirmDateProposeBtn' ?>">
                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button"
                                        id="confirmCongeDateSubmit">Confirmer</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <div class="hidden dateProposeMsg"></div>
                        </div>
                    </div>



                    <hr id="justif-depart-hr">
                    <span class="justif-depart-text"></span>

                    <div class="depart-section">
                        <p><i class="fas fa-comment"></i> <strong>Valider le congé:</strong>
                            <!-- <span id="modalMotifRetarddepart"></span> -->
                        </p>
                        <div class="mt-0">
                            <div class="<?= $viewAdmin != '' ? $viewAdmin : 'form-group confirmDemandeConge' ?>">
                                <label for="confirmationDepart" class="font-weight-bold">Valider ou rejeter cette demande de congé.
                                </label>
                                <br>
                                <div class="row">
                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartOui"
                                            name="confirmationDepart" value="valider">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartOui">Valider</label>
                                    </div>

                                    <div class="form-check d-inline-block ml-3">
                                        <input type="radio" class="form-check-input" id="confirmDepartNon"
                                            name="confirmationDepart" value="rejeter">
                                        <label class="form-check-label font-weight-bold"
                                            for="confirmDepartNon">Rejeter</label>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-6 mb-3">
                                    <label for="commentaireRejet">En cas de rejet, ajouter un commentaire</label>
                                    <input type="text" id="commentaireRejet" name="commentaireRejet" placeholder="Ajouter un commentaire" class="form-control">
                                </div>
                                <input type="hidden" id="modalCongeId">

                                <div class="modal-footer">
                                    <button class="btn btn-success" type="button"
                                        id="confirmCongeStatutSubmit">Confirmer</button>
                                    <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                            <div class="hidden confirmDemandeMsg"></div>
                            <br>
                            <p class="commentaireRejetMsgContainer">
                                <i class="fas fa-comment"></i>
                                <strong>Commentaire:</strong>
                            <p id="commentaireRejetMsg" style="font-size:16px;"></p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="leaveRequestModal" tabindex="-1" role="dialog"
        aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #c00000;">
                    <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                        Demande de Congé
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="leaveRequestForm" enctype="multipart/form-data">
                    <div class="modal-body mt-0">
                        <div class="row mt-0">
                            <div class="col-md-12 text-left">
                                <div class="col-md-12 mx-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="leaveType">Type de congé <small class="text-danger">*</small></label>
                                            <select id="leaveType" name="leaveType" class="form-control" required>
                                                <option value="" disabled selected>Sélectionnez un type de congé</option>
                                                <?php foreach ($typesConge as $type) { ?>
                                                    <option value="<?= $type->idTypeConge ?>" data-quotas="<?= $type->quotas ?>">
                                                        <?= $type->type ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="attachments">Pièces jointes</label>
                                            <input type="file" id="attachments" name="attachments[]" class="form-control" multiple accept="image/*, .pdf, .mp4">
                                        </div>
                                    </div>
                                    <div id="fileDetails" class="mt-3"></div> <!-- Conteneur pour les détails des fichiers -->

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label for="startDate">Date de début <small
                                                    class="text-danger">*</small></label>
                                            <input type="date" id="startDateConge" name="startDate" class="form-control"
                                                required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="endDate">Date de fin <small
                                                    class="text-danger">*</small></label>
                                            <input type="date" id="endDateConge" name="endDate" class="form-control"
                                                required>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <label for="motifEditor">Motif
                                                <small class="text-danger">*</small>
                                            </label>

                                            <textarea name="motifEditor" id="motifEditor" cols="30" rows="10" readonly required class="form-control"></textarea>
                                            <small class="text-danger" id="justificationError" style="display: none;">Ce champ est requis.</small>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <button class="btn btn-success" type="submit">Envoyer</button>
                                                <button class="btn btn-danger" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selectedQuota" class="hidden"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCongeModal" tabindex="-1" role="dialog"
        aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header" style="background-color: #c00000;">
                    <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                        Modifier le Congé
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="editCongeForm">
                    <div class="modal-body mt-0">
                        <div class="row mt-0">
                            <div class="col-md-12 text-left">
                                <div class="col-md-12 mx-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="leaveType">Type de congé <small
                                                    class="text-danger">*</small></label>
                                            <select id="leaveTypeEdit" name="leaveType" class="form-control" required>
                                                <option value="" disabled selected>Sélectionnez un type de congé
                                                </option>
                                                <?php
                                                foreach ($typesConge as $type) {
                                                ?>
                                                    <option value="<?= $type->idTypeConge ?>" data-quotas="<?= $type->quotas ?>">
                                                        <?= $type->type ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="attachments">Pièces jointes</label>
                                            <input type="file" id="attachments" name="attachments[]"
                                                class="form-control">
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="startDate">Date de début <small
                                                    class="text-danger">*</small></label>
                                            <input type="date" id="startDateCongeEdit" name="startDate" class="form-control"
                                                required>
                                        </div>


                                        <div class="col-md-6 mb-3">
                                            <label for="endDate">Date de fin <small
                                                    class="text-danger">*</small></label>
                                            <input type="date" id="endDateCongeEdit" name="endDate" class="form-control"
                                                required>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 text-left">
                                            <label for="motifEditorEdit">Motif
                                                <small class="text-danger">*</small>
                                            </label>
                                            <textarea name="motifEditorEdit" id="motifEditorEdit" cols="30" rows="10" readonly required class="form-control"></textarea>
                                            <small class="text-danger" id="justificationError" style="display: none;">Ce champ est requis.</small>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <button class="btn btn-success" type="submit">Envoyer</button>
                                                <button class="btn btn-danger" type="button"
                                                    data-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selectedQuotaEdit" class="hidden"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="annulerCongeModal" tabindex="-1" role="dialog"
        aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #c00000;">
                    <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                        Annuler la demande
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" id="annulerCongeForm">
                    <div class="modal-body mt-0">
                        <div class="row mt-0">
                            <div class="col-md-12 text-left">
                                <div class="col-md-12 mx-3">
                                    <div class="modal-body">
                                        <input type="hidden" name="idUtilisateur" id="idUtilisateur">
                                        <input type="hidden" name="etatUser" id="etatUser">
                                        <div id="textBloquage">
                                            Voulez-vous vraiment annuler cette demande?
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="modal-footer">
                                                <button id="annulerCongeSubmit" class="btn btn-success" type="submit">Oui</button>
                                                <button class="btn btn-danger" type="button" data-dismiss="modal" data-bs-dismiss="modal">Non</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="nbrJours">
                                    <input type="hidden" id="statutConge">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
</div>

<div class="<?= $solde == '' ? 'hidden' : 'row justify-content-center mb-2 mt-2' ?>">
    <div class="col-md-3 accordion-body">
        <div class="card bg-white text-black mb-4">
            <div class="card-body">
                <h1 class="card-text" id="soldeCumule"><?= $solde->soldeCumule ?></h1>
                <p class="mb-0">Solde cumulé</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 accordion-body">
        <div class="card bg-white text-black mb-4">
            <div class="card-body">
                <h1 class="card-text" id="soldeRestant"><?= $solde->soldeRestant ?></h1>
                <p class="mb-0">Solde restant</p>
            </div>
        </div>
    </div>
</div>




<div class="card">
    <div class="card-body">
        <button type="button" class="<?= $viewAdmin2 == '' ? 'hidden' : 'btn btn-sm btn-red ml-1' ?>" data-toggle="modal"
            data-target="#leaveRequestModal" rel="tooltip" title="Ajouter">
            DEMANDER UN CONGÉ
        </button>
        <a href="<?= linkTo('GestionInterne', 'ajouterTypeConge') ?>" type="button"
            class="<?= $viewAdmin2 != "" ? $viewAdmin2 : "btn btn-sm btn-red ml-1" ?>" rel="tooltip"
            title="Ajouter">
            <i class="fas fa-plus" style="color: #ffffff"></i>
            AJOUTER UN TYPE DE CONGÉ
        </a>
        <h2 class="text-center" style="color: grey;">Liste des congés</h2>
        <div class="table-responsive">
            <table id="dataTable16" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Actions</th>
                        <th class="<?= $viewAdmin2 ?>">Employé</th>
                        <th>Type de congé</th>
                        <th>Nombre de jours</th>
                        <th>Date début souhaitée</th>
                        <th>Date fin souhaitée</th>
                        <th>Date début réelle</th>
                        <th>Date fin réelle</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conges as $index => $demande) { ?>
                        <!-- DEBUT calcul de nombre de jours -->
                        <?php
                        if ($demande->jours == null) {
                            $nbrJours = "-";
                            if (!empty($demande->dateDebutDeCongeReelle) && !empty($demande->dateFinDeCongeReelle)) {
                                $datetimeDebut = new DateTime($demande->dateDebutDeCongeReelle);
                                $datetimeFin = new DateTime($demande->dateFinDeCongeReelle);
                                $nbrJours = $datetimeFin->diff($datetimeDebut)->format('%d');
                            } elseif (!empty($demande->dateDebutDeCongeSouhaite) && !empty($demande->dateFinDeCongeSouhaite)) {
                                $datetimeDebut = new DateTime($demande->dateDebutDeCongeSouhaite);
                                $datetimeFin = new DateTime($demande->dateFinDeCongeSouhaite);
                                $nbrJours = $datetimeFin->diff($datetimeDebut)->format('%d');
                            }
                        }

                        ?>
                        <!-- FIN calcul de nombre de jours -->

                        <tr data-id="<?php echo htmlspecialchars($demande->idDemande); ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td class="d-flex border-right-0 border-left-0 border-bottom-0">
                                <button type="button" class="btn btn-sm btn-icon ml-2 btn-info"
                                    title="Détails"
                                    onclick="showCongeDetails(<?= isset($demande->idDemande) ? $demande->idDemande : 'null' ?>)"
                                    style="color:white">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="<?= $viewAdmin2 == '' || $demande->idTraiteF != null || $demande->statut == '3' ? 'hidden' : 'btn btn-sm btn-icon ml-2 btn-warning' ?>"
                                    title="Editer"
                                    onclick="showCongeEdit(<?= isset($demande->idDemande) ? $demande->idDemande : 'null' ?>)"
                                    style="color:white">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <?php
                                // Convert the dates to DateTime objects
                                $dateTime1 = DateTime::createFromFormat('d/m/Y', formatDate($serverTime));
                                $dateTime2 = DateTime::createFromFormat('d/m/Y', formatDate($demande->dateDebutDeCongeReelle));

                                // Compare the dates
                                if ($viewAdmin2 == '' || $demande->statut == "2" || $demande->statut == "3" || ($demande->statut == "1" && $dateTime1 > $dateTime2) || ($demande->statut == "1" && formatDate($demande->dateDebutDeCongeReelle) == "-" && formatDate($serverTime) > formatDate($demande->dateDebutDeCongeSouhaite))) {
                                    echo "";
                                } else {
                                    // Render the button if the first date is older than the second date
                                ?>
                                    <button type="button" class='btn btn-sm btn-icon ml-2 btn-danger'
                                        title="Annuler"
                                        onclick="annulerConge(<?= $demande->idDemande ?>, <?= $demande->jours ?>, '<?= $demande->statut ?>')"
                                        style="color:white">
                                        <i class="fas fa-times"></i>
                                    </button>
                                <?php
                                }
                                ?>
                            </td>
                            <td class="<?= $viewAdmin2 ?>"><?php echo htmlspecialchars($demande->fullName); ?></td>
                            <td><?php echo htmlspecialchars($demande->type); ?></td>
                            <td><?= $demande->jours == null ?  $nbrJours + 1  : $demande->jours ?></td>
                            <td><?php echo htmlspecialchars(formatDate($demande->dateDebutDeCongeSouhaite)); ?></td>
                            <td><?php echo htmlspecialchars(formatDate($demande->dateFinDeCongeSouhaite)); ?></td>
                            <td><?php echo htmlspecialchars(formatDate($demande->dateDebutDeCongeReelle)); ?></td>
                            <td><?php echo htmlspecialchars(formatDate($demande->dateFinDeCongeReelle)); ?></td>
                            <td>
                                <?php
                                if ($demande->statut == 0) {
                                    echo '<span class="badge badge-primary">En attente</span>';
                                } elseif ($demande->statut == 1) {
                                    echo '<span class="badge badge-success">Approuvé</span>';
                                } elseif ($demande->statut == 2) {
                                    echo '<span class="badge badge-danger">Rejeté</span>';
                                } else {
                                    echo '<span class="badge badge-warning">Annulé</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>



<script src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/jquery/jquery.js"></script>
<script type="text/javascript"
    src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery-3.5.1.min.js"></script>

<!-- <script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/vendor/libs/bootstrap/js/bootstrap.js"></script> -->

<script type="text/javascript"
    src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/jquery.timepicker.js"></script>
<script type="text/javascript"
    src="<?= URLROOT ?>/assets/ticket/vendor/libs/datepicker/documentation-assets/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/datepair.js"></script>
<script type="text/javascript" src="<?= URLROOT ?>/assets/ticket/js/jquery.datepair.js"></script>
<script src="<?= URLROOT ?>/assets/ticket/vendor/js/bootstrap.js"></script>
<!-- <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script> -->

<script>
    const URLROOT = '<?php echo URLROOT; ?>';
    $(document).ready(function() {
        $('.select3').select2();
    });

    // Lors de la création de la demande de congé, ajouter les champs "nom du document" et "commentaire" pour 
    // chaque document sélectionné
    document.getElementById('attachments').addEventListener('change', function (event) {
        const files = event.target.files;
        const fileDetailsContainer = document.getElementById('fileDetails');
        fileDetailsContainer.innerHTML = ''; // Effacer les champs précédents

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Créer un conteneur pour chaque fichier
            const fileContainer = document.createElement('div');
            fileContainer.className = 'file-container mb-3 p-3 border rounded';

            // Afficher le nom du fichier
            const fileName = document.createElement('div');
            fileName.textContent = `Fichier : ${file.name} (${(file.size / 1024).toFixed(2)} KB)`;
            fileName.className = 'mb-2';
            fileContainer.appendChild(fileName);

            // Ajouter un champ pour le nom du document
            const nomDocumentLabel = document.createElement('label');
            nomDocumentLabel.textContent = 'Nom du document :';
            nomDocumentLabel.className = 'form-label';
            const nomDocumentInput = document.createElement('input');
            nomDocumentInput.type = 'text';
            nomDocumentInput.name = 'nomDocument[]';
            nomDocumentInput.className = 'form-control mb-2';
            nomDocumentInput.required = true;
            nomDocumentInput.placeholder = 'Entrez le nom du document';
            fileContainer.appendChild(nomDocumentLabel);
            fileContainer.appendChild(nomDocumentInput);

            // Ajouter un champ pour le commentaire
            const commentLabel = document.createElement('label');
            commentLabel.textContent = 'Commentaire :';
            commentLabel.className = 'form-label';
            const commentInput = document.createElement('input');
            commentInput.type = 'text';
            commentInput.name = 'comments[]';
            commentInput.className = 'form-control mb-2';
            commentInput.placeholder = 'Entrez un commentaire';
            fileContainer.appendChild(commentLabel);
            fileContainer.appendChild(commentInput);

            // Ajouter le conteneur au formulaire
            fileDetailsContainer.appendChild(fileContainer);
        }
    });

    //Lors du choix de la date de début de congé, la date valide la plus proche est aujourd'hui + 8 jours
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('startDateConge');

        const today = new Date();
        const todayISO = today.toISOString().split('T')[0];

        const startDate = new Date(today);
        startDate.setDate(today.getDate() + 8);
        const startDateISO = startDate.toISOString().split('T')[0];

        // Calculer la date min 8 jours à partir d'aujourd'hui
        const minDate = new Date(today);
        minDate.setDate(today.getDate() + 8);
        const minDateISO = minDate.toISOString().split('T')[0];

        const maxDate = new Date(today);
        maxDate.setFullYear(today.getFullYear() + 1);
        const maxDateISO = maxDate.toISOString().split('T')[0];

        startDateInput.min = startDateISO;
        startDateInput.max = maxDateISO;

        //Si l'utilisateur choisit une date du calendrier
        startDateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const dayOfWeek = selectedDate.getDay();

            if (dayOfWeek === 0 || dayOfWeek === 6) {
                const msgError = document.getElementById("msgError")
                msgError.innerHTML = "Vous ne pouvez pas choisir un weekend."
                $('#errorOperation').modal('show');
                this.value = "";
            }
        });

        // Empêcher l'entrée manuelle de dates
        startDateInput.addEventListener('keydown', function(event) {
            event.preventDefault(); // Empêcher la saisie au clavier
        });


        const endDateInput = document.getElementById('endDateConge');
        endDateInput.disabled = true; // Désactiver l'input de date fin

        // Empêcher l'entrée manuelle de dates
        endDateInput.addEventListener('keydown', function(event) {
            event.preventDefault(); // Empêcher la saisie au clavier
        });

        endDateInput.setAttribute('min', today); //La date de fin min est la date de début sélectionné

        // Lorsqu'on choisit une date de début
        startDateInput.addEventListener('change', function() {
            endDateInput.disabled = false; // Activer l'input de date fin

            // Mettre la date fin min à la date début sélectionnée
            endDateInput.removeAttribute('min');
            endDateInput.setAttribute('min', this.value);

            // Si la date fin est antérieure à la date début, mettre date fin à date début
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
        });


    });

    // Fonction utilitaire pour récupérer le statut sélectionné dans un groupe de boutons radio
    function getSelectedStatus(groupName) {
        var selectedOption = $(`input[name="${groupName}"]:checked`).val();
        if (selectedOption === 'valider') {
            return '1';
        } else if (selectedOption === 'rejeter') {
            return '2';
        }
        return null; // Aucun choix sélectionné
    }

    // Fonction AJAX générique pour mettre à jour les congés
    function updateDemandeConge(endpoint, data) {
        return $.ajax({
            url: `${URLROOT}/public/json/conge.php?action=${endpoint}`,
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.success) {

                    // Appel de createNotification
                    // createNotification(userid_pointage, titleNotificationToSend, notificationTosend);

                    // Appel de sendEmail avec l'email dynamique
                    // sendEmail(
                    //     email, // Utilisation de l'email dynamique
                    //     emailSubject,
                    //     emailBody
                    // );
                } else {
                    console.error('Erreur lors de la mise à jour :', response.error);
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = 'Erreur: ' + response.error
                    $('#errorOperation').modal('show');
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX :', error);
                const msgError = document.getElementById("msgError")
                msgError.innerHTML = 'Une erreur est survenue lors de la mise à jour.'
                $('#errorOperation').modal('show');
            }
        });
    }

    $('#confirmCongeDateSubmit').on('click', function() {

        var congeId = $('#modalCongeId').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var commentaire = $('#commentaire').val();

        if (!congeId) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'ID de pointage introuvable.'
            $('#errorOperation').modal('show');
            return;
        }
        if (!startDate || !endDate) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'Veuillez selectionner une date de debut et une date de fin.'
            $('#errorOperation').modal('show');
            return;
        }

        // Mise à jour de la date de congé proposée
        updateDemandeConge(
            'updateCongeDatePropose', {
                congeId: congeId,
                userId: userId,
                startDate: startDate,
                endDate: endDate,
                commentaire: commentaire
            }
        );

        // // Optionnel : Rafraîchir la page après un délai pour attendre la fin des requêtes AJAX
        setTimeout(function() {
            window.location.reload();
        }, 500);
    });

    $('#confirmPropositionSubmit').on('click', function() {
        // Récupération des ID nécessaires
        var congeId = $('#modalCongeId').val();
        var debutSouhaite = $('#modalDebutSouhaiteHidden').text()
        var finSouhaite = $('#modalFinSouhaiteHidden').text()
        var debutPropose = $('#modalDebutProposeHidden').text()
        var finPropose = $('#modalFinProposeHidden').text()

        let startDate;
        let endDate;

        // const confirmOui = document.getElementById("confirmOui").checked;
        // const confirmNon = document.getElementById("confirmNon").checked;
        const acceptProposition = document.getElementById("acceptProposition").checked;
        const refuseProposition = document.getElementById("refuseProposition").checked;

        const datePointageElement = document.getElementById("modalDatePointage");
        const datePointage = datePointageElement ? datePointageElement.innerText : "-";

        let titleNotificationToSend = "";
        let notificationTosend = "";
        let emailSubject = "";
        let emailBody = "";

        // Déterminer le choix pour "arrivée"
        // if (confirmOui || confirmNon) {
        //     const confirmation = confirmOui ? "oui" : "non";
        //     titleNotificationToSend = `Justificatif ${confirmation === "oui" ? "accepté" : "refusé"}`;
        //     notificationTosend = `Votre justificatif d'arrivée pour le ${datePointage} a été ${confirmation === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        //     emailSubject = `Justification ${confirmation === "oui" ? "Acceptée" : "Rejetée"}`;
        //     emailBody = `
        //     Bonjour,<br /><br />
        //     Votre manager a ${confirmation === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        //     ${confirmation === "oui" ? 
        //         "Votre justificatif a été approuvé et enregistré avec succès. L'état d'arrivée est maintenant 'justifié'." : 
        //         "Malheureusement, votre justificatif a été refusé. L'état d'arrivée reste 'injustifié'."}<br /><br />
        //     Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        //     Cordialement,<br />
        //     Votre équipe RH<br />
        //     `;
        // }

        // Déterminer le choix pour "départ"
        // if (confirmDepartOui || confirmDepartNon) {
        //     const confirmationDepart = confirmDepartOui ? "oui" : "non";
        //     titleNotificationToSend = `Justificatif ${confirmationDepart === "oui" ? "accepté" : "refusé"}`;
        //     notificationTosend = `Votre justificatif de départ pour le ${datePointage} a été ${confirmationDepart === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        //     emailSubject = `Justification ${confirmationDepart === "oui" ? "Acceptée" : "Rejetée"}`;
        //     emailBody = `
        //         Bonjour,<br /><br />
        //         Votre manager a ${confirmationDepart === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        //         ${confirmationDepart === "oui" ? 
        //             "Votre justificatif a été approuvé et enregistré avec succès. L'état du départ est maintenant 'justifié'." : 
        //             "Malheureusement, votre justificatif a été refusé. L'état du départ reste 'injustifié'."}<br /><br />
        //         Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        //         Cordialement,<br />
        //         Votre équipe RH<br />
        //         `;
        // }

        if (!congeId) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'ID de pointage introuvable.'
            $('#errorOperation').modal('show');
            return;
        }

        // Obtenir les sélections pour les justifications d'arrivée et de départ
        // var arriveeStatus = getSelectedStatus('confirmation'); // Radio group "confirmation"

        if (!acceptProposition && !refuseProposition) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'Veuillez accepter ou refuser proposition'
            $('#errorOperation').modal('show');
            return;
        }

        let choixProposition;

        if (acceptProposition) {
            choixProposition = true
        } else {
            choixProposition = false
        }

        if (choixProposition) {
            startDate = debutPropose
            endDate = finPropose
        } else {
            startDate = null
            endDate = null
        }

        if (acceptProposition || refuseProposition) {
            updateDemandeConge(
                'updateCongeDatePropose', {
                    congeId: congeId,
                    userId: userId,
                    employeId: userId,
                    startDate: startDate,
                    endDate: endDate,
                    commentaire: commentaire,
                    choix: choixProposition
                }
            );
        }


        // Optionnel : Rafraîchir la page après un délai pour attendre la fin des requêtes AJAX
        setTimeout(function() {
            window.location.reload();
        }, 500);
    });

    $('#confirmCongeStatutSubmit').on('click', function() {
        // Récupération des ID nécessaires
        var congeId = $('#modalCongeId').val();
        var employeId = $('#idUtilisateurHidden').text();
        var debutSouhaite = $('#modalDebutSouhaiteHidden').text()
        var finSouhaite = $('#modalFinSouhaiteHidden').text()
        var debutPropose = $('#modalDebutProposeHidden').text()
        var finPropose = $('#modalFinProposeHidden').text()
        var commentaire = $('#commentaireRejet').val()

        let startDate;
        let endDate;

        if (debutSouhaite && finSouhaite) {
            startDate = debutSouhaite
            endDate = finSouhaite
        } else if (debutPropose && finPropose) {
            startDate = debutPropose
            endDate = finPropose
        }

        // const confirmOui = document.getElementById("confirmOui").checked;
        // const confirmNon = document.getElementById("confirmNon").checked;
        const confirmDepartOui = document.getElementById("confirmDepartOui").checked;
        const confirmDepartNon = document.getElementById("confirmDepartNon").checked;

        const datePointageElement = document.getElementById("modalDatePointage");
        const datePointage = datePointageElement ? datePointageElement.innerText : "-";

        let titleNotificationToSend = "";
        let notificationTosend = "";
        let emailSubject = "";
        let emailBody = "";

        // Déterminer le choix pour "arrivée"
        // if (confirmOui || confirmNon) {
        //     const confirmation = confirmOui ? "oui" : "non";
        //     titleNotificationToSend = `Justificatif ${confirmation === "oui" ? "accepté" : "refusé"}`;
        //     notificationTosend = `Votre justificatif d'arrivée pour le ${datePointage} a été ${confirmation === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        //     emailSubject = `Justification ${confirmation === "oui" ? "Acceptée" : "Rejetée"}`;
        //     emailBody = `
        //     Bonjour,<br /><br />
        //     Votre manager a ${confirmation === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        //     ${confirmation === "oui" ? 
        //         "Votre justificatif a été approuvé et enregistré avec succès. L'état d'arrivée est maintenant 'justifié'." : 
        //         "Malheureusement, votre justificatif a été refusé. L'état d'arrivée reste 'injustifié'."}<br /><br />
        //     Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        //     Cordialement,<br />
        //     Votre équipe RH<br />
        //     `;
        // }

        // Déterminer le choix pour "départ"
        // if (confirmDepartOui || confirmDepartNon) {
        //     const confirmationDepart = confirmDepartOui ? "oui" : "non";
        //     titleNotificationToSend = `Justificatif ${confirmationDepart === "oui" ? "accepté" : "refusé"}`;
        //     notificationTosend = `Votre justificatif de départ pour le ${datePointage} a été ${confirmationDepart === "oui" ? "approuvé" : "rejeté"} par votre manager.`;
        //     emailSubject = `Justification ${confirmationDepart === "oui" ? "Acceptée" : "Rejetée"}`;
        //     emailBody = `
        //         Bonjour,<br /><br />
        //         Votre manager a ${confirmationDepart === "oui" ? "accepté" : "rejeté"} le justificatif que vous avez soumis pour le ${datePointage}.<br /><br />
        //         ${confirmationDepart === "oui" ? 
        //             "Votre justificatif a été approuvé et enregistré avec succès. L'état du départ est maintenant 'justifié'." : 
        //             "Malheureusement, votre justificatif a été refusé. L'état du départ reste 'injustifié'."}<br /><br />
        //         Si vous avez des questions ou souhaitez obtenir plus d'informations, n'hésitez pas à contacter votre manager.<br /><br />
        //         Cordialement,<br />
        //         Votre équipe RH<br />
        //         `;
        // }

        if (!congeId) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'ID de pointage introuvable.'
            $('#errorOperation').modal('show');
            return;
        }

        // // Obtenir les sélections pour les justifications d'arrivée et de départ
        // // var arriveeStatus = getSelectedStatus('confirmation'); // Radio group "confirmation"
        var congeStatus = getSelectedStatus('confirmationDepart'); // Radio group "confirmationDepart"

        if (congeStatus === null) {
            const msgError = document.getElementById("msgError")
            msgError.innerHTML = 'Veuillez valider ou rejeter la demande de congé'
            $('#errorOperation').modal('show');
            return;
        }

        if (congeStatus !== null) {
            updateDemandeConge(
                'updateCongeStatut', {
                    congeId: congeId,
                    userId: userId,
                    employeId: employeId,
                    statut: congeStatus,
                    startDate: startDate,
                    endDate: endDate,
                    commentaire: commentaire
                }
            );
        }
        // // Optionnel : Rafraîchir la page après un délai pour attendre la fin des requêtes AJAX
        setTimeout(function() {
            window.location.reload();
        }, 500);
    });

    // Formater la date
    function formatDate(dateString) {
        if (!dateString) return '-';

        const date = new Date(dateString);

        if (isNaN(date.getTime())) {
            return '-';
        }

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = String(date.getFullYear());
        return `${day}/${month}/${year}`;
    }

    function showCongeDetails(id) {
        if (id === null) {
            $('#errorOperation').modal('show');
            return;
        }

        $.ajax({
            url: `${URLROOT}/public/json/conge.php?action=getCongeById`,
            method: 'POST',
            data: {
                idDemande: id
            },
            dataType: 'json',
            success: function(response) {

                const idUtilisateur = document.getElementById("idUtilisateurHidden")
                idUtilisateur.innerHTML = response.idUtilisateurF
                justificationLinkElement = document.getElementById('modalurlJustification');
                let justificationLinks = '-'; // Default value

                if (response.documents && response.documents.length > 0) {
                    // Obtenir les documents relatifs à la demande
                    const filteredDocs = response.documents;

                    if (filteredDocs.length > 0) {
                        // Créer un lien pour chaque document
                        justificationLinks = filteredDocs
                            .map(doc =>
                                `<a style="color:#13058f; text-decoration: none; font-size:16px; font-weight:bold; margin-left:20px;" href="${URLROOT}/public/documents/conge/justification/${doc.urlDocument}" target="_blank">${doc.nomDocument}</a>`
                            )
                            .join('<br>'); // Add an HTML line break between the links
                    } else {
                        // Pas de documents dans la demande
                        justificationLinks = 'Aucun document associé.';
                    }
                } else {
                    // Pas de documents dans la reponse
                    justificationLinks = 'Aucun document trouvé.';
                }

                // Update the HTML content of the element
                if (justificationLinkElement) {
                    justificationLinkElement.innerHTML = justificationLinks;
                }

                // Get the start date input and end date input elements
                const startDateInput = document.getElementById('startDate');
                const today = new Date();
                const todayISO = today.toISOString().split('T')[0];

                const startDate = new Date(today);
                startDate.setDate(today.getDate() + 8);
                const startDateISO = startDate.toISOString().split('T')[0];

                const maxDate = new Date(today);
                maxDate.setFullYear(today.getFullYear() + 1);
                const maxDateISO = maxDate.toISOString().split('T')[0];

                startDateInput.min = startDateISO;
                startDateInput.max = maxDateISO;

                startDateInput.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const dayOfWeek = selectedDate.getDay();

                    if (dayOfWeek === 0 || dayOfWeek === 6) {
                        const msgError = document.getElementById("msgError")
                        msgError.innerHTML = "Vous ne pouvez pas choisir un weekend."
                        $('#errorOperation').modal('show');

                        this.value = ""; // Clear the invalid input
                    }
                });

                const endDateInput = document.getElementById('endDate');
                // Empêcher l'entrée manuelle de dates
                startDateInput.addEventListener('keydown', function(event) {
                    event.preventDefault(); // Empêcher la saisie au clavier
                });                
                endDateInput.addEventListener('keydown', function(event) {
                    event.preventDefault(); // Empêcher la saisie au clavier
                });                
                endDateInput.disabled = true; // Disable the input

                endDateInput.setAttribute('min', today);

                // Lorsqu'on choisit une date de début
                startDateInput.addEventListener('change', function() {
                    endDateInput.disabled = false; // Activer l'input de date fin

                    // Mettre la date fin min à la date début sélectionnée
                    endDateInput.removeAttribute('min');
                    endDateInput.setAttribute('min', this.value);

                    // Si la date fin est antérieure à la date début, mettre date fin à date début
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = this.value;
                    }
                });


                let congeId = document.getElementById('modalCongeId');
                congeId.value = response.idDemande;

                let confirmDemandeConge = document.querySelector(".confirmDemandeConge")
                let confirmDemandeMsg = document.querySelector(".confirmDemandeMsg")

                let confirmDatePropose = document.querySelector(".confirmDatePropose")
                let confirmDateProposeMsg = document.querySelector("#confirmDateProposeMsg")
                let modalCommentaire = document.querySelector("#modalCommentaire")

                let confirmDateProposeBtn = document.querySelector(".confirmDateProposeBtn")

                let confirmPropositionConge = document.querySelector(".confirmPropositionConge")

                let commentaireRejetMsg = document.querySelector("#commentaireRejetMsg")
                let commentaireRejetMsgContainer = document.querySelector(".commentaireRejetMsgContainer")

                //Si la demande est rejetée, afficher la raison du rejet
                if (commentaireRejetMsgContainer) {
                    commentaireRejetMsgContainer.classList.add("hidden")
                    commentaireRejetMsg.innerHTML = ""
                    if (response.statut == "2" && response.commentaire && !response.dateDebutDeCongePropose) {
                        commentaireRejetMsgContainer.classList.remove("hidden")
                        commentaireRejetMsg.innerHTML = response.commentaire
                    }
                }

                //Si le responsable propose une date, afficher la section pour accepter ou refuser la proposition
                if (confirmPropositionConge) {
                    confirmPropositionConge.classList.add('hidden')

                    if (response.statut == "0" && response.dateDebutDeCongePropose && response.dateFinDeCongePropose && !response.dateDebutDeCongeReelle && !response.dateFinDeCongeReelle) {
                        confirmPropositionConge.classList.remove('hidden')
                    } else {
                        confirmPropositionConge.classList.add('hidden')
                    }
                }

                //Traitement pour la section 'Proposer une date' (Responsable)
                if (confirmDatePropose && confirmDateProposeBtn && confirmDateProposeMsg) {

                    confirmDatePropose.classList.remove("hidden")
                    confirmDateProposeBtn.classList.remove("hidden")
                    confirmDateProposeMsg.innerHTML = ''
                    //Demande en attente avec une date proposée
                    if (response.statut == "0" && response.dateDebutDeCongePropose && response.dateFinDeCongePropose) {
                        confirmDatePropose.classList.add("hidden")
                        confirmDateProposeBtn.classList.add("hidden")
                        confirmDateProposeMsg.innerHTML = `${response.nomTraite} propose d'avoir le congé du ${formatDate(response.dateDebutDeCongePropose)} au ${formatDate(response.dateFinDeCongePropose)}`
                        modalCommentaire.innerHTML = response.commentaire
                    } //Demande validée 
                    else if (response.statut == "1") {
                        confirmDatePropose.classList.add("hidden")
                        confirmDateProposeBtn.classList.add("hidden")
                        //Utiliser la date réelle dans le message
                        if (response.dateDebutDeCongeReelle && response.dateFinDeCongeReelle) {
                            confirmDateProposeMsg.innerHTML = `${response.nomTraite} a validé le congé du ${formatDate(response.dateDebutDeCongeReelle)} au ${formatDate(response.dateFinDeCongeReelle)}`
                        }//Utiliser la date proposée dans le message
                        else if (response.dateDebutDeCongePropose && response.dateFinDeCongePropose) {
                            confirmDateProposeMsg.innerHTML = `${response.nomTraite} a validé le congé du ${formatDate(response.dateDebutDeCongePropose)} au ${formatDate(response.dateFinDeCongePropose)}`
                        }
                    } //Demande rejetée
                    else if (response.statut == "2") {
                        confirmDatePropose.classList.add("hidden")
                        confirmDateProposeBtn.classList.add("hidden")
                        confirmDateProposeMsg.innerHTML = `${response.nomTraite} a rejeté cette demande`
                    }//Demande annulée
                    else if (response.statut == "3") {
                        confirmDatePropose.classList.add("hidden")
                        confirmDateProposeBtn.classList.add("hidden")
                        confirmDateProposeMsg.innerHTML = `Cette demande a été annulé`
                    }
                }
                //Traitement pour la section 'Proposer une date' (Employé)
                else if (confirmDateProposeMsg) {
                    confirmDateProposeMsg.innerHTML = ''
                    if (response.statut == "0" && response.dateDebutDeCongePropose && response.dateFinDeCongePropose) {
                        confirmDateProposeMsg.innerHTML = `${response.nomTraite} propose d'avoir votre congé du ${formatDate(response.dateDebutDeCongePropose)} au ${formatDate(response.dateFinDeCongePropose)}`
                        modalCommentaire.innerHTML = response.commentaire
                    } else if (response.statut == "1") {
                        if (response.dateDebutDeCongeReelle && response.dateFinDeCongeReelle) {
                            confirmDateProposeMsg.innerHTML = `${response.nomTraite} a validé le congé du ${formatDate(response.dateDebutDeCongeReelle)} au ${formatDate(response.dateFinDeCongeReelle)}`
                        } else if (response.dateDebutDeCongePropose && response.dateFinDeCongePropose) {
                            confirmDateProposeMsg.innerHTML = `${response.nomTraite} a validé le congé du ${formatDate(response.dateDebutDeCongePropose)} au ${formatDate(response.dateFinDeCongePropose)}`
                        }
                    } else if (response.statut == "2") {
                        confirmDateProposeMsg.innerHTML = `${response.nomTraite} a rejeté cette demande`

                    } else if (response.statut == "3") {
                        confirmDateProposeMsg.innerHTML = `Cette demande a été annulé`
                    }
                }

                //Traitement pour la section 'Valider le congé' (Responsable)
                if (confirmDemandeConge) {
                    //Demande validée
                    if (response.statut === '1') {
                        confirmDemandeConge.classList.add('hidden')
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande validée par ${response.nomTraite}`
                    }//Demande rejetée
                    else if (response.statut === '2') {
                        confirmDemandeConge.classList.add('hidden')
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande rejetée par ${response.nomTraite}`
                    }//Demande annulée
                    else if (response.statut === '3') {
                        confirmDemandeConge.classList.add('hidden')
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande annulée`
                    }//Demande en attente avec date de proposition
                    else if (response.statut == "0" && response.dateDebutDeCongePropose && response.dateFinDeCongePropose) {
                        confirmDemandeConge.classList.add("hidden")
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande en cours de traitement`
                    }//Demande en attente sans date de proposition
                    else {
                        confirmDemandeConge.classList.remove('hidden')
                        confirmDemandeMsg.classList.add("hidden")
                        confirmDemandeMsg.innerHTML = ``
                    }
                }
                //Traitement pour la section 'Valider le congé' (Employé)
                else {
                    //Demande validée
                    if (response.statut === '1') {
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande validée par ${response.nomTraite}`
                    }//Demande rejetée
                    else if (response.statut === '2') {
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande rejetée par ${response.nomTraite}`
                    }//Demande annulée
                    else if (response.statut === '3') {
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande annulée`
                    }//Demande en attente
                    else {
                        confirmDemandeMsg.classList.remove("hidden")
                        confirmDemandeMsg.innerHTML = `Demande en cours de traitement`
                    }
                }

                let employeElement = document.getElementById('modalemploye');
                if (employeElement) {
                    employeElement.innerText = response.fullName || '-';
                }

                let matriculeElement = document.getElementById('modalmatricule');
                if (matriculeElement) {
                    matriculeElement.innerText = response.matricule || '-';
                }

                let typeElement = document.getElementById('modaltype');
                if (typeElement) {
                    typeElement.innerText = response.type || '-';
                }

                let siteElement = document.getElementById('modalsite');
                if (siteElement) {
                    siteElement.innerText = response.nomSite || '-';
                }

                function daysDifference(date1, date2) {
                    const diffInMs = Math.abs(date2.getTime() - date1.getTime());
                    const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));
                    return diffInDays;
                }

                let nbrJoursElement = document.getElementById('modaljours');

                if (nbrJoursElement) {
                    let nbrJours = "-";

                    if (response && response.dateDebutDeCongeReelle && response.dateFinDeCongeReelle) {
                        const dateDebut = response.dateDebutDeCongeReelle
                        const dateFin = response.dateFinDeCongeReelle
                        nbrJours = calculDays(dateDebut, dateFin)
                    } else if (response && response.dateDebutDeCongeSouhaite && response.dateFinDeCongeSouhaite) {
                        const dateDebut = response.dateDebutDeCongeSouhaite;
                        const dateFin = response.dateFinDeCongeSouhaite;
                        nbrJours = calculDays(dateDebut, dateFin)
                    }
                    nbrJoursElement.innerText = nbrJours;
                }

                let etatElement = document.getElementById('modalEtat');
                if (etatElement) {
                    let etat = '';
                    if (response.statut == 0) {
                        etat = '<span class="badge badge-primary">En attente</span>';
                    } else if (response.statut == 1) {
                        etat = '<span class="badge badge-success">Approuvé</span>';
                    } else if (response.statut == 2) {
                        etat = '<span class="badge badge-danger">Rejeté</span>';
                    } else if (response.statut == 3) {
                        etat = '<span class="badge badge-warning">Annulé</span>';
                    }
                    etatElement.innerHTML = etat;
                }

                let debutSouhaiteElement = document.getElementById('modalDebutSouhaite');
                let debutSouhaiteHiddenElement = document.getElementById('modalDebutSouhaiteHidden');
                if (debutSouhaiteElement) {
                    debutSouhaiteElement.innerText = formatDate(response.dateDebutDeCongeSouhaite) || '-';
                    debutSouhaiteHiddenElement.innerText = (response.dateDebutDeCongeSouhaite) || '-';
                }
                let finSouhaiteElement = document.getElementById('modalFinSouhaite');
                let finSouhaiteHiddenElement = document.getElementById('modalFinSouhaiteHidden');
                if (finSouhaiteElement) {
                    finSouhaiteElement.innerText = formatDate(response.dateFinDeCongeSouhaite) || '-';
                    finSouhaiteHiddenElement.innerText = (response.dateFinDeCongeSouhaite) || '-';
                }

                let debutProposeElement = document.getElementById('modalDebutPropose');
                let debutProposeHiddenElement = document.getElementById('modalDebutProposeHidden');
                if (debutProposeElement) {
                    debutProposeElement.innerText = formatDate(response.dateDebutDeCongePropose) || '-';
                    debutProposeHiddenElement.innerText = (response.dateDebutDeCongePropose) || '-';
                }
                let finProposeElement = document.getElementById('modalFinPropose');
                let finProposeHiddenElement = document.getElementById('modalFinProposeHidden');
                if (finProposeElement) {
                    finProposeElement.innerText = formatDate(response.dateFinDeCongePropose) || '-';
                    finProposeHiddenElement.innerText = (response.dateFinDeCongePropose) || '-';
                }

                let debutCongeElement = document.getElementById('modalDebut');
                if (debutCongeElement) {
                    debutCongeElement.innerText = formatDate(response.dateDebutDeCongeReelle) || '-';
                }
                let finCongeElement = document.getElementById('modalFin');
                if (finCongeElement) {
                    finCongeElement.innerText = formatDate(response.dateFinDeCongeReelle) || '-';
                }

                $('#detailCongeModal').modal('show');
            },

            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des détails du pointage:', error);
                const msgError = document.getElementById("msgError")
                msgError.innerHTML = 'Une erreur s\'est produite lors de la récupération des détails.'
                $('#errorOperation').modal('show');
            }
        });
    }

    function showCongeEdit(id) {
        if (id === null) {
            $('#errorOperation').modal('show');
            return;
        }

        let congeId = document.getElementById('modalCongeId');

        $.ajax({
            url: `${URLROOT}/public/json/conge.php?action=getCongeById`,
            method: 'POST',
            data: {
                idDemande: id
            },
            dataType: 'json',
            success: function(response) {
                console.log(response)
                const congeData = response; // Assuming your PHP returns an array of one object
                // Populate the form fields
                congeId.value = congeData.idDemande;
                $('#leaveTypeEdit').val(congeData.idTypeCongeF); // Assuming this is the correct key
                $('#startDateCongeEdit').val(congeData.dateDebutDeCongeSouhaite); // Format date if needed
                $('#endDateCongeEdit').val(congeData.dateFinDeCongeSouhaite); // Format date if needed
                const selectedQuotas = document.querySelector("#selectedQuotaEdit")
                selectedQuotas.innerHTML = congeData.quotas
                var noteText = tinyMCE.get("motifEditorEdit").setContent(congeData.motif)
                var plainText = $('<div>').html(noteText).text();
                $('#motifEditorEdit').val(response.motif);

                $('#editCongeModal').modal('show');

                // Get the start date input and end date input elements
                const startDateInput = document.getElementById('startDateCongeEdit');

                const today = new Date();
                const todayISO = today.toISOString().split('T')[0];

                const startDate = new Date(today);
                startDate.setDate(today.getDate() + 8);
                const startDateISO = startDate.toISOString().split('T')[0];

                const maxDate = new Date(today);
                maxDate.setFullYear(today.getFullYear() + 1);
                const maxDateISO = maxDate.toISOString().split('T')[0];

                startDateInput.min = startDateISO;
                startDateInput.max = maxDateISO;

                startDateInput.addEventListener('change', function() {
                    const selectedDate = new Date(this.value);
                    const dayOfWeek = selectedDate.getDay();

                    if (dayOfWeek === 0 || dayOfWeek === 6) {
                        const msgError = document.getElementById("msgError")
                        msgError.innerHTML = "Vous ne pouvez pas choisir un weekend."
                        $('#errorOperation').modal('show');
                        this.value = ""; // Clear the invalid input
                    }
                });

                const endDateInput = document.getElementById('endDateCongeEdit');
                
                startDateInput.addEventListener('keydown', function(event) {
                    event.preventDefault(); // Empêcher la saisie au clavier
                });                
                endDateInput.addEventListener('keydown', function(event) {
                    event.preventDefault(); // Empêcher la saisie au clavier
                });   

                endDateInput.setAttribute('min', today);

                startDateInput.addEventListener('change', function() {
                    endDateInput.disabled = false; // Disable the input

                    // Clear previous min date on end date input
                    endDateInput.removeAttribute('min');

                    // Set minimum date for end date input to selected start date
                    endDateInput.setAttribute('min', this.value);

                    //Check if the end date was before the start date if so reset it to the start date
                    if (endDateInput.value && endDateInput.value < this.value) {
                        endDateInput.value = this.value;
                    }
                });
            },

            error: function(xhr, status, error) {
                console.error('Erreur lors de la récupération des détails du pointage:', error);
                const msgError = document.getElementById("msgError")
                msgError.innerHTML = 'Une erreur s\'est produite lors de la récupération des détails.'
                $('#errorOperation').modal('show');
            }
        });
    }

    function annulerConge(id, nbrJours, statut) {
        if (id === null) {
            $('#errorOperation').modal('show');
            return;
        }
        let congeId = document.getElementById('modalCongeId');
        let nbrJoursConge = document.getElementById('nbrJours');
        let statutConge = document.getElementById('statutConge');

        congeId.value = id
        nbrJoursConge.value = nbrJours
        statutConge.value = statut

        $('#annulerCongeModal').modal('show');
    }

    function calculDays(startDate, endDate) {
        // Parse the input dates to Date objects if they are not already
        startDate = new Date(startDate);
        endDate = new Date(endDate);

        // Ensure startDate is before endDate, otherwise swap them
        if (startDate > endDate) {
            var temp = startDate;
            startDate = endDate;
            endDate = temp;
        }

        let businessDaysCount = 0;

        // Iterate over each day from startDate to endDate
        while (startDate <= endDate) {
            // Check if it's a weekday (Monday to Friday)
            let dayOfWeek = startDate.getDay();
            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // 0 is Sunday, 6 is Saturday
                businessDaysCount++;
            }

            // Move to the next day
            startDate.setDate(startDate.getDate() + 1);
        }
        return businessDaysCount;
    }

    // Initialize Quill when the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize the Quill editor

        //Récuperer le quota du type sélectionné lors de la demande
        document.getElementById('leaveType').addEventListener('change', function() {
            const selectedQuotas = document.querySelector("#selectedQuota")
            // Récuperer l'élement sélectionné
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                // 'data-quotas' attribute value
                quotasValue = selectedOption.getAttribute('data-quotas');
                selectedQuotas.innerHTML = quotasValue
            }
        });

        //Récuperer le quota du type sélectionné lors de la modification
        document.getElementById('leaveTypeEdit').addEventListener('change', function() {
            const selectedQuotas = document.querySelector("#selectedQuotaEdit")
            // Récuperer l'élement sélectionné
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value !== "") {
                // 'data-quotas' attribute value
                quotasValue = selectedOption.getAttribute('data-quotas');
                selectedQuotas.innerHTML = quotasValue
            }
        });

        $(document).ready(function() {
            $('#leaveRequestForm').on('submit', function(event) {
                event.preventDefault(); // Empêche l'envoi du formulaire par défaut
                $('#justificationError').hide(); // Cache les messages d'erreur précédents

                var noteText = tinyMCE.get("motifEditor").getContent().trim();
                var plainText = $('<div>').html(noteText).text();
                $('#motifEditor').val(plainText);

                var formData = new FormData(this); // Crée un objet FormData basé sur le formulaire
                var typeConge = $("#leaveType").val()
                var startDate = $("#startDateConge").val()
                var endDate = $("#endDateConge").val()

                //Récuperer le quota du type sélectionné
                const selectedQuotas = document.querySelector("#selectedQuota").innerHTML
                //Récuperer le solde cumulé et restant
                const soldeCumule = document.querySelector("#soldeCumule").innerHTML
                const soldeRestant = document.querySelector("#soldeRestant").innerHTML
                //Récuperer le nombre de jours de congé
                const nbrJours = calculDays(startDate, endDate)

                if (nbrJours > soldeCumule + soldeRestant) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = "Votre solde est insuffisant"
                    $('#errorOperation').modal('show');
                    return
                } else if (nbrJours > selectedQuotas) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = `Vous ne pouvez pas avoir plus de ${selectedQuotas} pour ce type de congé`
                    $('#errorOperation').modal('show');
                    return
                }

                const date1 = new Date(startDate);
                const date2 = new Date(endDate);

                // Compare the two dates
                if (date1.getTime() > date2.getTime()) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = `La date de fin de congé doit être après le ${startDate}`
                    $('#errorOperation').modal('show');
                }

                const nomDocuments = [];
                const comments = [];

                // Parcourir tous les champs "nomDocument[]" et "comments[]"
                document.querySelectorAll('input[name="nomDocument[]"]').forEach((input, index) => {
                    nomDocuments.push(input.value); // Ajouter la valeur du champ "nomDocument"
                });

                document.querySelectorAll('input[name="comments[]"]').forEach((input, index) => {
                    comments.push(input.value); // Ajouter la valeur du champ "comments"
                });

                // Ajouter les valeurs au FormData
                nomDocuments.forEach((nomDocument, index) => {
                    formData.append('nomDocument[]', nomDocument);
                });

                comments.forEach((comment, index) => {
                    formData.append('comments[]', comment);
                });

                formData.append('motif', plainText);
                formData.append('userId', userId);
                formData.append('typeConge', typeConge);
                formData.append('endDate', endDate);
                formData.append('startDate', startDate); 

                // Soumission AJAX
                $.ajax({
                    url: `${URLROOT}/public/json/conge.php?action=saveConge`, // URL d'envoi (variable URLROOT doit être définie)
                    type: 'POST',
                    data: formData,
                    contentType: false, // Empêche jQuery de définir un content-type par défaut
                    processData: false, // Empêche jQuery de traiter les données envoyées (nécessaire pour FormData)
                    success: function(response) {
                        // Redirection après succès de la soumission
                        window.location.href = `${URLROOT}/GestionInterne/gererConges`;
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Affiche la réponse en cas d'erreur
                        const msgError = document.getElementById("msgError")
                        msgError.innerHTML = 'Une erreur est survenue lors de la soumission.'
                        $('#errorOperation').modal('show');
                    }
                });
            });

            $('#editCongeForm').on('submit', function(event) {
                event.preventDefault(); // Empêche l'envoi du formulaire par défaut
                $('#justificationError').hide(); // Cache les messages d'erreur précédents

                var noteText = tinyMCE.get("motifEditorEdit").getContent().trim();
                var plainText = $('<div>').html(noteText).text();
                $('#motifEditorEdit').val(plainText);

                var formData = new FormData(this); // Crée un objet FormData basé sur le formulaire
                var typeConge = $("#leaveTypeEdit").val()
                var startDate = $("#startDateCongeEdit").val()
                var endDate = $("#endDateCongeEdit").val()
                let congeId = $("#modalCongeId").val()

                //Récuperer le quota du type sélectionné
                const selectedQuotas = document.querySelector("#selectedQuotaEdit").innerHTML
                //Récuperer le solde cumulé et restant
                const soldeCumule = document.querySelector("#soldeCumule").innerHTML
                const soldeRestant = document.querySelector("#soldeRestant").innerHTML
                //Récuperer le nombre de jours de congé
                const nbrJours = calculDays(startDate, endDate)

                if (nbrJours > soldeCumule + soldeRestant) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = "Votre solde est insuffisant"
                    $('#errorOperation').modal('show');
                    return
                } else if (nbrJours > selectedQuotas) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = `Vous ne pouvez pas avoir plus de ${selectedQuotas} pour ce type de congé`
                    $('#errorOperation').modal('show');
                    return
                }

                const date1 = new Date(startDate);
                const date2 = new Date(endDate);

                // Comparer la date de début et de fin
                if (date1.getTime() > date2.getTime()) {
                    const msgError = document.getElementById("msgError")
                    msgError.innerHTML = `La date de fin de congé doit être après le ${startDate}`
                    $('#errorOperation').modal('show');
                    return
                }

                formData.append('congeId', congeId); // Ajoute l'ID du congé à FormData
                formData.append('motif', plainText); // Ajoute le motif à FormData
                formData.append('userId', userId); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)
                formData.append('typeConge', typeConge); // Ajoute le type du cogé
                formData.append('endDate', endDate); // Ajoute la date de fin de congé
                formData.append('startDate', startDate); // Ajoute la date de début de congé

                // Soumission AJAX
                $.ajax({
                    url: `${URLROOT}/public/json/conge.php?action=saveConge`, // URL d'envoi (variable URLROOT doit être définie)
                    type: 'POST',
                    data: formData,
                    contentType: false, // Empêche jQuery de définir un content-type par défaut
                    processData: false, // Empêche jQuery de traiter les données envoyées (nécessaire pour FormData)
                    success: function(response) {
                        // Redirection après succès de la soumission
                        window.location.href = `${URLROOT}/GestionInterne/gererConges`;
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Affiche la réponse en cas d'erreur
                        const msgError = document.getElementById("msgError")
                        msgError.innerHTML = 'Une erreur est survenue lors de la soumission.'
                        $('#errorOperation').modal('show');

                    }
                });
            });

            $('#annulerCongeForm').on('submit', function(event) {
                event.preventDefault(); // Empêche l'envoi du formulaire par défaut
                let congeId = $("#modalCongeId").val()
                let nbrJours = $("#nbrJours").val()
                let statutActuel = $("#statutConge").val()

                updateDemandeConge(
                    'updateCongeStatut', {
                        congeId: congeId,
                        userId: null,
                        employeId: userId,
                        statut: '3',
                        statutActuel: statutActuel,
                        nbrJoursActuel: nbrJours,
                        startDate: null,
                        endDate: null
                    }
                );
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            });
        });
    });

    function closeModal() {
        $('#errorOperation').modal('hide');
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

    $("#dateDemande").on("change", function() {
        if ($("#dateDemande option:selected").val() == "perso" || $("#dateDemande option:selected").val() == "jour") {
            $("#changeperso").removeAttr("hidden");
            if ($("#dateDemande option:selected").val() == "perso") {
                $("#date2").removeAttr("hidden");

                $("#date1").removeClass("col-md-12");
                $("#date1").addClass("col-md-6");
            } else {
                $("#date2").attr("hidden", "hidden");
                $("#date1").removeClass("col-md-6");
                $("#date1").addClass("col-md-12");
            }
        } else {
            $("#changeperso").attr("hidden", "hidden");
        }
    })
    const userId = '<?php echo $_SESSION['connectedUser']->idUtilisateur; ?>'
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const filterButton = document.getElementById('filterButton');

        // Récupérer les filtres sauvegardés dans le localStorage et pré-remplir le formulaire
        const savedFilters = JSON.parse(localStorage.getItem('filterCriteriaConges'));
        if (savedFilters) {
            for (const key in savedFilters) {
                const element = document.querySelector(`[name=${key}]`);
                if (element) {
                    element.value = savedFilters[key];
                }
            }
            // Appliquer les filtres automatiquement si des filtres existent
            // applyFilters(savedFilters);
        }

        // Gérer l'événement du bouton de filtre
        // filterButton.addEventListener('click', function (e) {
        //     e.preventDefault(); // Empêcher la soumission par défaut du formulaire

        //     const formData = new FormData(filterForm);
        //     formData.append('userid', userId); // Supposons que userId est défini globalement

        //     // Récupérer les critères de filtre et les stocker dans localStorage
        //     const filterCriteria = {};
        //     for (const [key, value] of formData.entries()) {
        //         if (key !== 'userid') { // On ne stocke pas userid dans le localStorage
        //             filterCriteria[key] = value;
        //         }
        //     }

        //     // Sauvegarder les critères de filtre dans le localStorage
        //     localStorage.setItem('filterCriteriaConges', JSON.stringify(filterCriteria));

        //     // Mettre à jour l'URL avec les critères de filtre (sans userId)
        //     const queryParams = new URLSearchParams(filterCriteria).toString();
        //     const newUrl = `${window.location.pathname}?${queryParams}`;
        //     window.history.pushState(null, '', newUrl); // Mettre à jour l'URL sans recharger la page

        //     // Appliquer les filtres avec les critères de filtre récupérés
        //     // applyFilters(filterCriteria);
        // });

        // Fonction pour appliquer les filtres et mettre à jour les données dans la table
        function applyFilters(filterCriteria) {
            const formData = new FormData();
            for (const key in filterCriteria) {
                formData.append(key, filterCriteria[key]);
            }
            formData.append('userid', userId); // Inclure l'userId dans la requête POST

            fetch(`${URLROOT}/public/json/conge.php?action=filterConges`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        updateTable(data); // Mettre à jour la table avec les données filtrées
                    } else {
                        console.error('Format de données invalide:', data);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }

        // Gérer la navigation par historique (boutons précédent/suivant)
        window.addEventListener('popstate', function() {
            const queryParams = new URLSearchParams(window.location.search);
            const filterCriteria = Object.fromEntries(queryParams.entries());
            localStorage.setItem('filterCriteriaConges', JSON.stringify(filterCriteria)); // Synchroniser avec localStorage
            // applyFilters(filterCriteria); // Réappliquer les filtres en fonction de l'URL
        });

        // Fonction pour mettre à jour la table avec les données filtrées
        function updateTable(data) {
            const tableBody = document.querySelector('#dataTable16 tbody');
            tableBody.innerHTML = ''; // Vider les lignes existantes

            // Fonction pour formater la date au format dd/mm/yy
            function formatDate(dateString) {
                const dateObj = new Date(dateString);
                const day = String(dateObj.getDate()).padStart(2, '0'); // Jour
                const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Mois
                const year = String(dateObj.getFullYear()).slice(2); // Année (2 derniers chiffres)
                return `${day}/${month}/${year}`;
            }

            data.forEach((item, index) => {
                let statutBadge;

                // Déterminer le badge correspondant au statut
                if (item.statut === "0") {
                    statutBadge = '<span class="badge badge-secondary">En attente</span>';
                } else if (item.statut === "1") {
                    statutBadge = '<span class="badge badge-success">Approuvé</span>';
                } else if (item.statut === "2") {
                    statutBadge = '<span class="badge badge-danger">Rejeté</span>';
                } else {
                    statutBadge = '<span class="badge badge-warning">Statut inconnu</span>';
                }

                // Créer une nouvelle ligne dans la table
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-id', item.idDemande); // Ajouter l'ID de la demande comme attribut
                newRow.innerHTML = `
                <td>${index + 1}</td>
                <td>${item.typeConge}</td>
                <td>${formatDate(item.dateDebutDeCongeSouhaite)}</td>
                <td>${formatDate(item.dateFinDeCongeSouhaite)}</td>
                <td>${item.motif}</td>
                <td>${statutBadge}</td>
            `;
                tableBody.appendChild(newRow);
            });
        }
    });
</script>