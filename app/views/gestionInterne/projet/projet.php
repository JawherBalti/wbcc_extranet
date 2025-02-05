<?php
$active = "red";
?>
<!-- ======= Avantages Section ======= -->
<div class="section-title mb-0">
    <h2><button onclick="document.location.href='<?= URLROOT ?>/GestionInterne/indexProjet'"><i
                class="fas fa-fw fa-arrow-left" style="color: #c00000"></i></button> <span><i
                class="fa fa-regular fa-folder-open" style="color: #c00000"></i></span> gestion projet</h2>
</div>

<div class="row mt-0">
    <div class="<?= $projet ? "col-md-6" : "col-md-12" ?> text-left m-0 p-0">
        <div class="row  mt-0 p-0">
            <fieldset>
                <legend class=" text-center legend font-weight-bold text-uppercase"><i
                        class="icofont-info-circle my-1"></i>1-Projet</legend>
                <form class="mt-0 p-0" id="msform" method="POST"
                    action="<?= linkTo("GestionInterne", "saveProjet") ?>">
                    <div class="col-md-12 px-0 mt-0">

                    <input type="hidden" id="idImmeuble" name="idImmeuble" value="">
                    <input type="hidden" id="idApp" name="idApp" value="">

                        <input type='text' id='idUtilisateur' class='form-control'
                            value='<?= $_SESSION['connectedUser']->idUtilisateur ?>' hidden>
                        <input type='text' id='auteur' class='form-control'
                            value='<?= $_SESSION['connectedUser']->fullName ?>' hidden>
                        <input type='text' id='numeroAuteur' class='form-control'
                            value='<?= $_SESSION['connectedUser']->numeroContact ?>' hidden>
                        <input type="hidden" name="URLROOT" id="URLROOT" value="<?= URLROOT ?>">
                        <div class="row text-left mt-0">
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="">Nom du projet</label>
                                </div>
                                <input required type="text"
                                    value="<?= ($projet) ?  "$projet->idProjet" : "0" ?>"
                                    name="idProjet" class="form-control" id="idProjet" hidden>
                                <div class="col-md-12">
                                    <input required type="text"
                                        value="<?= ($projet) ?  "$projet->nomProjet" : "" ?>"
                                        name="nomProjet" class="form-control" id="nomProjet">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="">Description du projet</label>
                                </div>
                                <div class="col-md-12">
                                    <input required type="text"
                                        value="<?= ($projet) ?  "$projet->descriptionProjet" : "" ?>"
                                        name="descriptionProjet" class="form-control" id="descriptionProjet">
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                               <div class="col-md-12">
                                    <label class="font-weight-bold" for="">Selectionner un Immeuble ou un lot</label>
                                </div>
                               <div class="col-md-12">
                                    <label class="font-weight-bold" for="">Immeubles</label>
                                </div>
                                <table class="table table-bordered" id="dataTable16" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code de l'immeuble</th>
                                            <th>Type de l'immeuble</th>
                                            <th>Adresse</th>
                                            <th>Code postal</th>
                                            <th>Ville</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            foreach ($immeubles as $immeuble) {
                                                $i++;
                                        ?>
                                        <tr class="p-0 m-0" onclick="selectRow(this, 'immeuble')" data-id="<?= $immeuble->idImmeuble ?>">
                                        <td><?= $i ?></td>
                                            <td><?= $immeuble->codeImmeuble ?></td>
                                            <td><?= $immeuble->typeImmeuble ?></td>
                                            <td><?= $immeuble->adresse ?></td>
                                            <td><?= $immeuble->codePostal ?></td>
                                            <td><?= $immeuble->ville ?></td>
                                        </tr>
                                        <?php    }
                                        ?>
                                    </tbody>                
                                </table>
                               <div class="col-md-12">
                                    <label class="font-weight-bold" for="">Lots</label>
                                </div>
                                <table class="table table-bordered" id="dataTable17" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code de l'immeuble</th>
                                            <th>Type de l'immeuble</th>
                                            <th>Adresse</th>
                                            <th>Code postal</th>
                                            <th>Ville</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 0;
                                            foreach ($immeubles as $immeuble) {
                                                $i++;
                                        ?>
                                        <tr class="p-0 m-0" onclick="selectRow(this, 'lot')" data-id="<?= $immeuble->idImmeuble ?>">
                                            <td><?= $i ?></td>
                                            <td><?= $immeuble->codeImmeuble ?></td>
                                            <td><?= $immeuble->typeImmeuble ?></td>
                                            <td><?= $immeuble->adresse ?></td>
                                            <td><?= $immeuble->codePostal ?></td>
                                            <td><?= $immeuble->ville ?></td>
                                        </tr>
                                        <?php    }
                                        ?>
                                    </tbody>                
                                </table>
                            </div>
                        </div>
                        <div class="row mt-2 mb-0 p-0">
                            <div class="col text-center">
                                <input name="valider" class="btn btn btn-md text-white" type="submit"
                                    style="background-color: darkgreen;" value="Enregistrer" />
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<script src="<?= URLROOT ?>/public/assets/vendor/jquery/jquery.min.js"></script>
<script type="text/javascript">
    const URLROOT = document.getElementById("URLROOT").value;
    var idEmp = 0;
    var actionCritere = "";
    let idCritere = "";
    let idDocument = "";
    let typeDelete = "";
    let idCondition = "";

    function selectRow(row, table) {
            // Deselect all rows in both tables
    $('#dataTable16 tbody tr').removeClass('selected-row');  // Deselect rows in the first table
    $('#dataTable17 tbody tr').removeClass('selected-row');  // Deselect rows in the second table

            // Check which table was clicked
    if (table === 'immeuble') {
        // Reset the idApp field if an Immeuble row is selected
        $('#idApp').val(null);
    } else if (table === 'lot') {
        // Reset the idImmeuble field if a Lot row is selected
        $('#idImmeuble').val(null);
    }

        // Remove the 'selected-row' class from all rows in the selected table
        $(row).closest('table').find('tbody tr').removeClass('selected-row');

    // // Remove the 'selected-row' class from all rows
    // $('#dataTable16 tbody tr').removeClass('selected-row');

    // Add the 'selected-row' class to the clicked row
    $(row).addClass('selected-row');

    // Get the idImmeuble from the clicked row's data-id attribute
    var selectedId = $(row).data('id');

    // Set the selected ID in the appropriate hidden input
    if (table === 'immeuble') {
        $('#idImmeuble').val(selectedId);
    } else if (table === 'lot') {
        $('#idApp').val(selectedId);
    }

    // Optional: Log the selected ID for debugging
    console.log("Selected Immeuble ID: " + selectedId);
}
    //CONDITION
    function onClickCondition(id, indexCritere) {
        idCritere = id;
        $("#titreCondition").text(
            "Ajout d'une condition au critere N°" + indexCritere
        );
        $('#modalCondition').modal('show');
    }

    function onChangeCondition() {
        let typeCondition = document.getElementById("typeCondition").value;
        if (typeCondition == "Autre") {
            document.getElementById("divAutreCondition").removeAttribute("hidden");
        } else {
            document.getElementById("divAutreCondition").setAttribute("hidden", "hidden");
        }
    }

    function saveCondition() {
        var idSubvention = document.getElementById('idSubvention').value;
        var typeCondition = document.getElementById('typeCondition').value;
        var operateurCondtion = document.getElementById('operateurCondtion').value;
        var valeurCondition = document.getElementById('valeurCondition').value;
        var autreTypeCondition = document.getElementById('autreTypeCondition').value;
        if (typeCondition != "" && valeurCondition != "" && typeCondition != "" && (typeCondition != "Autre" || (
                typeCondition ==
                "Autre" && autreTypeCondition != ""))) {
            console.log(typeCondition);

            //SAVE
            $.ajax({
                url: '<?= URLROOT . "/public/json/critere.php?action=saveCondition" ?>',
                method: 'POST',
                data: JSON.stringify({
                    idSubvention: idSubvention,
                    idCritere: idCritere,
                    idCondition: '0',
                    idTypeConditionF: typeCondition,
                    autreTypeCondition: autreTypeCondition,
                    valeurCondition: valeurCondition,
                    operateur: operateurCondtion.split(';')[1],
                    signeOperateur: operateurCondtion.split(';')[0],
                    idAuteur: '<?= $_SESSION["nomUser"]->idUtilisateur ?>'
                }),
                dataType: "JSON",
                beforeSend: function() {
                    $('#loadingModal').modal('show');
                },
                success: function(response) {
                    console.log("save critere");
                    console.log(response);
                    if (response == "1") {
                        setTimeout(() => {
                            $('#modalCondition').modal('hide');
                            $('#loadingModal').modal('hide');
                        }, 1000);
                        location.reload();
                    }
                },
                error: function(response) {
                    console.log("ERROR");
                    console.log(response);
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 1000);
                    $("#msgError").text(
                        "Erreur d'enregistrement !");
                    $('#errorOperation').modal('show');
                },
                complete: function() {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 1000);
                },
            });

        } else {
            $("#msgError").text(
                "Tous les champs sont obligatoires !");
            $('#errorOperation').modal('show');
        }
    }

    function deleteCondition() {
        $.ajax({
            url: '<?= URLROOT . "/public/json/critere.php?action=deleteConditionCritere" ?>',
            method: 'POST',
            data: JSON.stringify({
                idCondition: idCondition,
                idCritere: idCritere
            }),
            dataType: "JSON",
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                // console.log("delete condition");
                // console.log(response);
                if (response == "1") {
                    setTimeout(() => {
                        $('#modalDelete').modal('hide');
                        $('#loadingModal').modal('hide');
                    }, 1000);

                    location.reload();
                }
            },
            error: function(response) {
                console.log("ERROR");
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
                $("#msgError").text(
                    "Erreur de suppression !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
            },
        });
    }



    //critere
    function onClickCritere(id) {
        if (id == 0) {
            actionCritere = "add";
            loadDataCritere(null, true);
        } else {
            actionCritere = "edit"
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: `${URLROOT}/public/json/critere.php?action=find&id=${id}`,
                success: function(data) {
                    console.log(data);
                    if (data != undefined && data != null && data != "false") {
                        loadDataCritere(data, false);
                    } else {
                        $("#msgError").text(
                            "Impossible de charger les infos, contacter l'administrateur !"
                        );
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(jqXHR, error, errorThrown) {
                    console.log("error");
                    console.log(jqXHR.responseText);
                    $("#msgError").text(
                        "Impossible de charger les infos, contacter l'administrateur !"
                    );
                    $('#errorOperation').modal('show');
                }
            });
        }
    }

    function loadDataCritere(data = null, readOnly = false) {
        if (data != null) {
            document.getElementById("idCritere").value = data['idCritere'];
            document.getElementById("typeCondition").value = data['idTypeConditionF'];
            document.getElementById("operateurCondtion").value = data['signeOperateur'] + ";" + data['operateur'];
            document.getElementById("valeurCondition").value = data['valeur'];
        } else {
            document.getElementById("idCritere").value = "";
            document.getElementById("typeCondition").value = "";
            document.getElementById("operateurCondtion").value = "";
            document.getElementById("valeurCondition").value = "";
        }
    }

    function saveCritere(index) {
        var idSubvention = document.getElementById('idSubvention').value;
        var idCritere = document.getElementById('idCritere' + index).value;
        var valeurCritere = document.getElementById('valeurCritere' + index).value;
        var typeValeurCritere = document.getElementById('typeValeurCritere' + index).value;
        if (valeurCritere != "" && typeValeurCritere != "") {
            //SAVE
            $.ajax({
                url: '<?= URLROOT . "/public/json/critere.php?action=saveCritere" ?>',
                method: 'POST',
                data: JSON.stringify({
                    idSubvention: idSubvention,
                    idCritere: idCritere,
                    valeurCritere: valeurCritere,
                    typeValeurCritere: typeValeurCritere,
                    idAuteur: '<?= $_SESSION["nomUser"]->idUtilisateur ?>'
                }),
                dataType: "JSON",
                beforeSend: function() {
                    $('#loadingModal').modal('show');
                },
                success: function(response) {
                    console.log("save critere");
                    console.log(response);
                    if (response == "1") {
                        setTimeout(() => {
                            $('#modalCondition').modal('hide');
                            $('#loadingModal').modal('hide');
                        }, 1000);
                        location.reload();
                    }
                },
                error: function(response) {
                    console.log("ERROR");
                    console.log(response);
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 1000);
                    $("#msgError").text(
                        "Erreur d'enregistrement !");
                    $('#errorOperation').modal('show');
                },
                complete: function() {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 1000);
                },
            });
        } else {
            $("#msgError").text(
                "Tous les champs sont obligatoires !");
            $('#errorOperation').modal('show');
        }
    }

    function deleteCritere() {
        var idSubvention = document.getElementById('idSubvention').value;
        $.ajax({
            url: '<?= URLROOT . "/public/json/critere.php?action=deleteCritereSubvention" ?>',
            method: 'POST',
            data: JSON.stringify({
                idSubvention: idSubvention,
                idCritere: idCritere
            }),
            dataType: "JSON",
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                // console.log("delete critere");
                // console.log(response);
                if (response == "1") {
                    setTimeout(() => {
                        $('#modalDelete').modal('hide');
                        $('#loadingModal').modal('hide');
                    }, 1000);

                    location.reload();
                }

            },
            error: function(response) {
                console.log("ERROR");
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
                $("#msgError").text(
                    "Erreur de suppression !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
            },
        });
    }
    //DOCUMENT
    function onClickDocument() {
        $('#modalDocument').modal('show');
    }

    function saveDocument() {
        var idSubvention = document.getElementById('idSubvention').value;
        var docs = document.getElementsByName('checkDoc');
        let tabDocSub = [];
        for (let index = 0; index < docs.length; index++) {
            if (docs[index].checked) {
                let elt = {
                    "idSubvention": idSubvention,
                    "idDocumentRequis": docs[index].value,
                    "etat": $(".etat" + docs[index].value + ":radio:checked").val()
                }
                tabDocSub.push(elt);
            }
        }

        $.ajax({
            url: '<?= URLROOT . "/public/json/subvention.php?action=saveDocumentRequisSubvention" ?>',
            method: 'POST',
            data: JSON.stringify(tabDocSub),
            dataType: "JSON",
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                console.log("save documents");
                console.log(response);
                if (response == "1") {
                    setTimeout(() => {
                        $('#modalDocument').modal('hide');
                        $('#loadingModal').modal('hide');
                    }, 1000);

                    location.reload();
                }
            },
            error: function(response) {
                console.log("ERROR");
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
                $("#msgError").text(
                    "Erreur d'enregistrement !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
            },
        });
    }

    function onClickDelete(id, type, idCrit = "", index = "") {
        typeDelete = type;
        if (typeDelete == 'critere') {
            idCritere = id
            $("#textDelete").text(
                "Voulez-vous supprimer le critére N°" + index + " ?");
        } else {
            if (typeDelete == "document") {
                $("#textDelete").text(
                    "Voulez-vous supprimer ce document ?");
                idDocument = id
            } else {
                if (typeDelete == "condition") {
                    $("#textDelete").text(
                        "Voulez-vous supprimer cette condition du critére N°" + index + " ?");
                    idCondition = id
                    idCritere = idCrit
                }
            }
        }
        $('#modalDelete').modal('show');
    }

    function confirmDelete() {
        console.log(typeDelete)
        if (typeDelete == "critere") {
            deleteCritere()
        } else {
            if (typeDelete == "document") {
                deleteDocument()
            } else {
                if (typeDelete == "condition") {
                    deleteCondition()
                }
            }
        }
    }



    function deleteDocument() {
        var idSubvention = document.getElementById('idSubvention').value;
        $.ajax({
            url: '<?= URLROOT . "/public/json/subvention.php?action=deleteDocumentSubvention" ?>',
            method: 'POST',
            data: JSON.stringify({
                idSubvention: idSubvention,
                idDocumentRequis: idDocument
            }),
            dataType: "JSON",
            beforeSend: function() {
                $('#loadingModal').modal('show');
            },
            success: function(response) {
                // console.log("delete critere");
                // console.log(response);
                if (response == "1") {
                    setTimeout(() => {
                        $('#modalDelete').modal('hide');
                        $('#loadingModal').modal('hide');
                    }, 1000);

                    location.reload();
                }

            },
            error: function(response) {
                console.log("ERROR");
                console.log(response);
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
                $("#msgError").text(
                    "Erreur de suppression !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 1000);
            },
        });
    }
</script>