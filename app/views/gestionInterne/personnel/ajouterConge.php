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
            Types de congés
        </span>
    </h2>
</div>

<div class="mt-3" id="accordionFiltrea">
    <div class="table-responsive">
        <div class="card accordion-item" style="broder-radius: none !important; box-shadow: none !important;">
            <div id="bloc1" class="accordion-collapse collapse show" data-bs-parent="#accordionFiltrea"
                style="box-shadow: none !important;">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-sm btn-red ml-1" data-toggle="modal"
                            data-target="#leaveRequestModal" rel="tooltip" title="Ajouter">
                            <i class="fas fa-plus" style="color: #ffffff"></i>
                            AJOUTER UN TYPE
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="color: grey;">Types de congés</h2>
            <div class="table-responsive">
                <table id="dataTable16" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Actions</th>
                            <th>Type</th>
                            <th>Quota</th>
                            <th>Politique</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($typesConge as $index => $typeConge) { ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-icon ml-2 btn-warning"
                                        title="Editer"
                                        onclick="showTypeCongeEdit(<?= isset($typeConge->idTypeConge) ? $typeConge->idTypeConge : 'null' ?>)"
                                        style="color:white">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td ><?= $typeConge->type; ?></td>
                                <td><?= $typeConge->quotas; ?></td>
                                <td><?= $typeConge->politique; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="leaveRequestModal" tabindex="-1" role="dialog" aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
         
            <div class="modal-header" style="background-color: #c00000;">
                <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                    Ajouter un type de congé
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" id="leaveRequestForm">
                <div class="modal-body mt-0">
                    <div class="row mt-0">
                        <div class="col-md-12 text-left">
                            <div class="col-md-12 mx-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="typeConge">Type du congé<small class="text-danger">*</small></label>
                                        <input type="text" id="typeConge" name="typeConge" class="form-control">
                                        <small class="text-danger" id="typeCongeError" style="display: none;">Ce champ est requis.</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="quotaConge">Quota du congé <small class="text-danger">*</small></label>
                                        <input type="number" id="quotaConge" name="quotaConge" class="form-control">
                                        <small class="text-danger" id="quotaCongeError" style="display: none;">Ce champ est requis.</small>
                                    </div>
                                </div>
                                
                            
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <label for="politiqueEditor">Politique <small class="text-danger">*</small></label>
                                        <textarea name="politiqueEditor" id="politiqueEditor" cols="30" rows="10" readonly required class="form-control"></textarea>
                                    </div>
                                </div>
                                
                        
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="modal-footer">
                                            <button class="btn btn-success" type="submit">Envoyer</button>
                                            <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal ERROR -->
<div>
    <div class="modal fade modal-center" id="errorOperation" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg bg-white">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h3 id="msgError" class="" style="color:red">Erreur lors de la récupération des données!!</h3>
                    <button class="btn btn-danger" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal UPDATE -->
<div class="modal fade" id="editCongeModal" tabindex="-1" role="dialog"
            aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header" style="background-color: #c00000;">
                        <h5 class="modal-title font-weight-bold text-uppercase text-white" id="leaveRequestModalLabel">
                            Modifier le Congé
                        </h5>
                        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
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
                                                <label for="typeCongeEdit">Type du congé<small class="text-danger">*</small></label>
                                                <input type="text" id="typeCongeEdit" name="typeCongeEdit" class="form-control">
                                                <small class="text-danger" id="typeCongeError" style="display: none;">Ce champ est requis.</small>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="quotaCongeEdit">Quota du congé <small class="text-danger">*</small></label>
                                                <input type="number" id="quotaCongeEdit" name="quotaCongeEdit" class="form-control">
                                                <small class="text-danger" id="quotaCongeError" style="display: none;">Ce champ est requis.</small>
                                            </div>
                                        </div>
                                        
                                    
                                        <div class="row">
                                            <div class="col-md-12 text-left">
                                                <label for="politiqueEditorEdit">Politique <small class="text-danger">*</small></label>
                                                <textarea name="politiqueEditorEdit" id="politiqueEditorEdit" cols="30" rows="10" readonly required class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <input type="hidden" id="modalCongeId">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Envoyer</button>
                                                    <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Annuler</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

    <script>
        const URLROOT = '<?php echo URLROOT; ?>';

        function showTypeCongeEdit(id) {
            if (id === null) {
                $('#errorOperation').modal('show');
                return;
            }

            let congeId = document.getElementById('modalCongeId');

            $.ajax({
                url: `${URLROOT}/public/json/conge.php?action=getTypeCongeById`,
                method: 'POST',
                data: {
                    idTypeConge: id
                },
                dataType: 'json',
                success: function (response) {      
                        const typeCongeData = response;

                        var noteText = tinyMCE.get("politiqueEditorEdit").setContent(typeCongeData.politique)
                        var plainText = $('<div>').html(noteText).text();
                        $('#politiqueEditorEdit').val(typeCongeData.politique);

                        // Populate the form fields
                        congeId.value = typeCongeData.idTypeConge;
                        $('#typeCongeEdit').val(typeCongeData.type);
                        $('#quotaCongeEdit').val(typeCongeData.quotas);
                        $('#editCongeModal').modal('show');
                },

                error: function (xhr, status, error) {
                    console.error('Erreur lors de la récupération des détails du pointage:', error);
                    alert('Une erreur s\'est produite lors de la récupération des détails.');
                }
            });
        }

        $('#editCongeForm').on('submit', function (event) {
            event.preventDefault(); // Empêche l'envoi du formulaire par défaut
            $('#justificationError').hide(); // Cache les messages d'erreur précédents

            var formData = new FormData(this); // Crée un objet FormData basé sur le formulaire

            var noteText = tinyMCE.get("politiqueEditorEdit").getContent().trim();
            var plainText = $('<div>').html(noteText).text();
            $('#politiqueEditorEdit').val(plainText); 

            var type = $("#typeCongeEdit").val()
            var quota = $("#quotaCongeEdit").val()
            let congeId = $("#modalCongeId").val()

            formData.append('congeId', congeId); // Ajoute congeId à FormData
            formData.append('politique', plainText); // Ajoute la politique à FormData
            formData.append('type', type); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)
            formData.append('quota', quota); // Ajoute l'ID de l'utilisateur (userId doit être défini globalement)

            // Soumission AJAX
            $.ajax({
                url: `${URLROOT}/public/json/conge.php?action=updateTypeConge`, // URL d'envoi (variable URLROOT doit être définie)
                type: 'POST',
                data: formData,
                contentType: false, // Empêche jQuery de définir un content-type par défaut
                processData: false, // Empêche jQuery de traiter les données envoyées (nécessaire pour FormData)
                success: function (response) {
                    // Redirection après succès de la soumission
                    window.location.href = `${URLROOT}/GestionInterne/ajouterTypeConge`;
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Affiche la réponse en cas d'erreur
                    alert('Une erreur est survenue lors de la soumission.');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            $('#typeCongeError').hide();
            $('#quotaCongeError').hide();

            $(document).ready(function () {
                $('#leaveRequestForm').on('submit', function (event) {
                    event.preventDefault(); // Empêche l'envoi du formulaire par défaut
                    $('#justificationError').hide(); // Cache les messages d'erreur précédents

                    var formData = new FormData(this); // Crée un objet FormData basé sur le formulaire

                    var noteText = tinyMCE.get("politiqueEditor").getContent().trim();
                    var plainText = $('<div>').html(noteText).text();
                    $('#politiqueEditor').val(plainText); 

                    var typeConge = $("#typeConge").val()
                    var quotaConge = $("#quotaConge").val()
                    // Vérifie si quota ou bien type est vide
                    if (!typeConge && !quotaConge) {
                        $('#typeCongeError').show(); // Affiche un message d'erreur
                        $('#quotaCongeError').show(); // Affiche un message d'erreur
                        $('#typeCongeError').text('Le type est obligatoire.');
                        $('#quotaCongeError').text('Le quota est obligatoire.');
                        return; // Arrête l'exécution si la justification est vide
                    }
                    if(typeConge) {
                        $('#typeCongeError').hide() // Cacher un message d'erreur
                    }
                    if(quotaConge) {
                        $('#quotaCongeError').hide() // Cacher un message d'erreur
                    }
                    if (!typeConge) {
                        $('#typeCongeError').show(); // Affiche un message d'erreur
                        $('#typeCongeError').text('Le type est obligatoire.');
                    }
                    if (!quotaConge) {
                        $('#quotaCongeError').show(); // Affiche un message d'erreur
                        $('#quotaCongeError').text('Le quota est obligatoire.');
                        return; // Arrête l'exécution si la justification est vide
                    }

                    formData.append('politique', plainText); // Ajoute la politique à FormData
                    formData.append('quota', quotaConge); // Ajoute le quota à FormData
                    formData.append('type', typeConge); // Ajoute la type à FormData

                    // Soumission AJAX
                    $.ajax({
                        url: `${URLROOT}/public/json/conge.php?action=saveTypeConge`, // URL d'envoi (variable URLROOT doit être définie)
                        type: 'POST',
                        data: formData,
                        contentType: false, // Empêche jQuery de définir un content-type par défaut
                        processData: false, // Empêche jQuery de traiter les données envoyées (nécessaire pour FormData)
                        success: function (response) {
                            console.log(response)
                            // Redirection après succès de la soumission
                            window.location.href = `${URLROOT}/GestionInterne/ajouterTypeConge`;
                        },
                        error: function (xhr, status, error) {
                            console.log(xhr.responseText); // Affiche la réponse en cas d'erreur
                            alert('Une erreur est survenue lors de la soumission.');
                        }
                    });
                });
            });

        });


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

        $(document).ready(function () {
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

        $("#dateDemande").on("change", function () {
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
        const userId = '<?php echo $_SESSION['connectedUser']->idContactF; ?>'
        document.addEventListener('DOMContentLoaded', function () {
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
            window.addEventListener('popstate', function () {
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