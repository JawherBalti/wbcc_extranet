<?php
$user = $_SESSION["connectedUser"];
$role = $user->idRole;
?>

<div class="section-title">
    <div class="col-md-6">
        <h2>
            <span>
                <i class="fa fa-solid fa-user" style="color: #c00000"></i>
            </span> GESTION PERSONNEL
        </h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div
                class="<?= $role == "1" || $role == "2" || $role == "25" ? "col-xl-3 col-md-3" : "col-xl-6 col-md-6" ?> mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="<?= $data['gerepresence'] ?>">
                                    <div class=" row text-lg font-weight-bold text-info text-uppercase mb-1">
                                        <div href="#" class="btn btn-info btn-circle">
                                            1
                                        </div><span class="mt-2"> &nbsp; POINTAGE </span>
                                    </div>
                                    <hr>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0 Absence</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-danger-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div
                class="<?= $role == "1" || $role == "2" || $role == "25" ? "col-xl-3 col-md-3" : "col-xl-6 col-md-6" ?> mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a  href="<?= $data['gererConges'] ?>">
                                    <div class="text-lg font-weight-bold text-success text-uppercase mb-1">
                                        <div class="btn btn-success btn-circle">
                                            2
                                        </div><span class="mt-2"> &nbsp; CONGE </span>
                                    </div>
                                    <hr>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-danger-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div
                class="<?= $role == "1" || $role == "2" || $role == "25" ? "col-xl-3 col-md-3" : "col-xl-6 col-md-6" ?> mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="#">
                                    <div class="text-lg font-weight-bold text-success text-danger mb-1">
                                        <div class="btn btn-danger btn-circle">
                                            3
                                        </div><span class="mt-2"> &nbsp; AVERTISSEMENT </span>
                                    </div>
                                    <hr>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-danger-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div
                class="<?= $role == "1" || $role == "2" || $role == "25" ? "col-xl-3 col-md-3" : "col-xl-6 col-md-6" ?> mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a href="#">
                                    <div class="text-lg font-weight-bold text-warning text-uppercase mb-1">
                                        <div class="btn btn-warning btn-circle">
                                            4
                                        </div><span class="mt-2"> &nbsp; PAIEMNENT </span>
                                    </div>
                                    <hr>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                                </a>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-euro-sign fa-2x text-danger-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($role == "1" || $role == "2" || $role == "25") {
?>
    <!-- DataTales Example -->
    <div class="card shadow mt-3">
        <div class="card-header py-3 text-center">
            <div class="row">
                <h3 class="m-0 mt-2 col-md-10 font-weight-bold text-primary">
                    <font style="vertical-align: inherit;">
                        <font style="vertical-align: inherit;"><?= $titre ?></font>
                    </font>
                </h3>
                <div class="float-right col-md-2">
                    <?php
                    if ($role == 1 || $role == 2) { ?>
                        <button onclick="onClickAdd()" type="button" rel="tooltip" title="Ajouter"
                            class="btn btn btn-sm btn-red  ml-1" data-toggle="modal" data-target="#personnelModal">
                            <i class="fas fa-user-plus" style="color: #ffffff"></i>
                            Ajouter un utilisateur
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable16" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Site</th>
                            <th>login</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Etat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($personnels as $pers) {
                            $etat = "";
                            if ($pers->etatUser == 0) {
                                $etat = "Bloqué";
                            } else {
                                if ($pers->token != null && $pers->token != "") {
                                    $etat = "En attente de confirmation";
                                } else {
                                    $etat = "Actif";
                                }
                            }
                        ?>
                            <tr style="background-color: <?= ($pers->etatUser == 0) ? "lightgrey" : ""  ?>;">
                                <td><?= $i++ ?></td>
                                <td><?= $pers->nomSite ?></td>
                                <td><?= $pers->login ?></td>
                                <td><?= ucfirst($pers->prenomContact) ?></td>
                                <td><?= strtoupper($pers->nomContact) ?></td>
                                <td><?= $pers->email ?></td>
                                <td><?= $pers->libelleRole ?></td>
                                <td><?= $etat ?></td>
                                <td style="text-align : center">
                                    <button <?= $_SESSION["connectedUser"]->libelleRole == "Administrateur" ? "" : "hidden" ?>
                                        type="button" rel="tooltip" title="Editer"
                                        onclick="onClickEdit(<?= $pers->idUtilisateur ?>)" value=""
                                        class="btn btn-sm btn-warning btn-simple btn-link" data-toggle="modal"
                                        data-target="#personnelModal">
                                        <i class="fas fa-user-edit" style="color: #ffffff"></i>
                                    </button>
                                    <button <?= $_SESSION["connectedUser"]->libelleRole == "Administrateur" ? "" : "hidden" ?>
                                        <?= ($idContact == $pers->idUtilisateur) ? "disabled" : "" ?> type="button"
                                        rel="tooltip" title="<?= ($pers->etatUser == 0) ? "Activer" : "Désactiver"  ?>"
                                        onclick="onClickBloquer(<?= $pers->idUtilisateur ?>,<?= $pers->etatUser ?>)" value=""
                                        class="btn btn-sm btn-info btn-simple btn-link" data-toggle="modal"
                                        data-target="#bloquerModal">
                                        <i class="fas  <?= ($pers->etatUser == 0) ? "fa-user" : "fa-user-slash"  ?>"
                                            style="color: #ffffff"></i>
                                    </button>
                                    <button <?= $_SESSION["connectedUser"]->libelleRole == "Administrateur" ? "" : "hidden" ?>
                                        <?= ($idContact == $pers->idUtilisateur) ? "disabled" : "" ?> type="button"
                                        rel="tooltip" title="Supprimer" onclick='onClickDelete(<?= $pers->idContact ?>)'
                                        class="btn btn-sm btn-danger btn-simple btn-link" data-toggle="modal"
                                        data-target="#deleteModal">
                                        <i class="fas fa-user-times" style="color: #ffffff"></i>
                                    </button>
                                    <a href="<?= linkTo("Utilisateur", "configuration", $pers->idUtilisateur); ?>" type="button"
                                        rel="tooltip" title="Configuration" class="btn btn-sm btn-primary btn-simple btn-link">
                                        <i class="fa fa-cog" style="color: #ffffff"></i>
                                    </a>
                                </td>

                            </tr>
                        <?php    }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Personnel Modal-->
    <div class="modal fade" id="personnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Utilisateur</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="msform" method="post" action="<?= linkTo("Utilisateur", "saveUser", "wbcc") ?>">
                    <div class="modal-body mt-0">
                        <div class="row mt-0">
                            <div class="col-md-12 text-left ">
                                <div class="card ">
                                    <div class="col-md-12 mx-0">
                                        <!-- progressbar -->
                                        <div class="row register-form mt-0">
                                            <fieldset>
                                                <legend class="text-center legend font-weight-bold text-uppercase"><i
                                                        class="icofont-info-circle"></i>Création d'un compte</legend>
                                                <input type="hidden" name="idContact" id="idContact">

                                                <input type="hidden" name="URLROOT" id="URLROOT" value="<?= URLROOT ?>">
                                                <div class="row">
                                                    <div class="row ">
                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Civilité </label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <select name="civilite" id="civilite" class="form-control">
                                                                    <option value="">-- Choisir --</option>
                                                                    <option value="M">Monsieur</option>
                                                                    <option value="Mme">Madame</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Prénom <small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input required type="text" name="prenom"
                                                                    class="form-control" id="prenom">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Nom<small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input required type="tel" name="nom" class="form-control"
                                                                    id="nom">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Ligne Directe<small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input required type="tel" name="tel1" class="form-control"
                                                                    id="tel1">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Email Personnel<small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <input onchange="onChangeEmailPerso()" required type="email"
                                                                    name="email" class="form-control" id="email">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Role <small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <select required="required" name="role" id="role"
                                                                    class="form-control">
                                                                    <option value="">-- Choisir --</option>
                                                                    <?php foreach ($roles as $r) {
                                                                    ?>
                                                                        <option value="<?= $r->idRole ?>">
                                                                            <?= $r->libelleRole ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 mb-1">
                                                            <div class="col-md-12">
                                                                <label for="">Site <small
                                                                        class="text-danger">*</small></label>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <select onchange="onChangeRole()" required="required"
                                                                    name="idSite" id="idSite" class="form-control">
                                                                    <option value="">-- Choisir --</option>
                                                                    <?php foreach ($sites as $s) {
                                                                    ?>
                                                                        <option value="<?= $s->idSite ?>">
                                                                            <?= $s->nomSite ?></option>
                                                                    <?php } ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Annuler</button>
                        <button class="btn btn-success" href="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bloquer Modal-->
    <div class="modal fade" id="bloquerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" id="modalHeader">
                    <h5 class="modal-title" id="exampleModalLabel2">Désactivation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="msform" method="post" action="<?= linkTo("Utilisateur", "bloquerUser", 'wbcc') ?>">
                    <div class="modal-body">
                        <input type="hidden" name="idUtilisateur" id="idUtilisateur">
                        <input type="hidden" name="etatUser" id="etatUser">
                        <div id="textBloquage">
                            Voulez-vous bloquer cet utilisateur ?
                            Ceci va empêcher cet utilisateur de se connecter!
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Non</button>
                        <button class="btn btn-success" href="submit">Oui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SUPPRESSION Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #E74A3B">
                    <h5 class="modal-title">Suppression</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="msform" method="post" action="<?= linkTo("Utilisateur", "delete", 'wbcc') ?>">
                    <div class="modal-body">
                        <input type="hidden" name="idContact2" id="idContact2">
                        <div id="textBloquage">
                            Voulez-vous supprimer ce collaborateur ?</br>
                            Cette action est irreversible !
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" type="button" data-dismiss="modal">Non</button>
                        <button class="btn btn-danger" href="submit">Oui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php   }
?>


<script type="text/javascript">
    const URLROOT = document.getElementById("URLROOT").value;

    function onClickAdd() {
        document.getElementById("email").removeAttribute("readonly");
        document.getElementById("idContact").value = "0";
        document.getElementById("civilite").value = "";
        document.getElementById("prenom").value = "";
        document.getElementById("nom").value = "";
        document.getElementById("tel1").value = "";
        document.getElementById("email").value = "";
        document.getElementById("role").value = "";
        document.getElementById("idSite").value = "";
    }

    function onChangeRole(elt) {
        const role = document.getElementById('role');
        if (role.value == 18) {
            document.getElementById("divConfig").removeAttribute("hidden");
        } else {
            document.getElementById("divConfig").setAttribute("hidden", "");
        }

    }


    function onClickEdit(id) {
        $.ajax({
            type: "GET",
            url: `${URLROOT}/public/json/utilisateur.php?action=findById&id=${id}`,
            dataType: "JSON",
            success: function(data) {

                // console.log(data);
                document.getElementById("idContact").value = data['idContact'];
                document.getElementById("civilite").value = data['civiliteContact'];
                document.getElementById("prenom").value = data['prenomContact'];
                document.getElementById("nom").value = data['nomContact'];
                document.getElementById("tel1").value = data['telContact'];
                document.getElementById("email").value = data['email'];

                if (data['libelleRole'] !== null && data['libelleRole'] !== "") {
                    document.getElementById("role").value = data['idRole'];
                }

                if (data['idSiteF'] !== null && data['idSiteF'] !== "") {
                    document.getElementById("idSite").value = data['idSiteF'];
                }
                document.getElementById("email").setAttribute("readonly", "readonly");
            },
            error: function(jqXHR, error, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }

    function onClickBloquer(id, etat) {
        document.getElementById("idUtilisateur").value = id;
        document.getElementById("etatUser").value = etat;
        if (etat == 1) {
            document.getElementById("exampleModalLabel2").innerHTML = "Désactivation du compte";
            document.getElementById("textBloquage").innerHTML =
                "Voulez-vous désactiver le compte de ce collaborateur ?</br> Ceci va empêcher au collaborateur de se connecter sur l'extranet <b> WBCC ASSISTANCE </b>";
            document.getElementById("modalHeader").style.backgroundColor = "#E74A3B";

        } else {
            document.getElementById("exampleModalLabel2").innerHTML = "Activation du compte";
            document.getElementById("textBloquage").innerHTML =
                "Voulez-vous activer le compte de ce collaborateur ?</br> Ceci va permettre au collaborateur de se connecter sur l'extranet <b> WBCC ASSISTANCE </b>";
            document.getElementById("modalHeader").style.backgroundColor = "#1CC88A";
        }
    }

    function onClickDelete(idContact) {
        document.getElementById("idContact2").value = idContact;
    }

    function onChangeEmailPerso() {
        var email = document.getElementById("email").value;
        $.ajax({
            type: "GET",
            url: `${URLROOT}/public/json/utilisateur.php?action=findByEmail&email=${email}`,
            dataType: "JSON",
            success: function(data) {
                if (data !== "0") {
                    alert("Cette adresse email est déjà utilisée par un autre utilisateur !");
                    document.getElementById("email").value = "";
                    document.getElementById("email").focus();
                }
            },
            error: function(jqXHR, error, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }

    function changePostalCode() {
        var code = document.getElementById("codePostal").value;
        if (code.length === 5) {
            readTextFile(`${URLROOT}/public/json/codePostal.json`, function(text) {
                var data = JSON.parse(text);
                var test = false;
                data.forEach(function(val) {
                    if (val[2] === Number(code)) {
                        test = true;
                        document.getElementById("ville").value = val[9];
                        document.getElementById("departement").value = val[12];
                        document.getElementById("region").value = val[14];
                        //console.log(val[9],val[12],val[14]);
                    }
                });
                if (!test) {
                    alert("Ce code postal n'existe Pas");
                }
            });
        } else {
            document.getElementById("codePostal").value = "";
            document.getElementById("ville").value = "";
            document.getElementById("departement").value = "";
            document.getElementById("region").value = "";
            alert("Code postal invalide !");
        }

    }

    function readTextFile(file, callback) {
        var rawFile = new XMLHttpRequest();
        rawFile.overrideMimeType("application/json");
        rawFile.open("GET", file, true);
        rawFile.onreadystatechange = function() {
            if (rawFile.readyState === 4 && rawFile.status == "200") {
                callback(rawFile.responseText);
            }
        }
        rawFile.send(null);
    }
</script>