<?php
// $hidden = (isset($etape) && $etape != "") ? "" : "hidden";
// $hiddenFinal = (isset($etape) && $etape != "") ? "hidden" : "";
$active = "red";
?>

<!-- ======= Avantages Section ======= -->

<div class="section-title">
    <div class="row">
        <div class="col-md-6">
            <h2><span>
                
            <i class="fa fa-regular fa-folder-open" style="color: #c00000"></i>
            </span> GESTION DES PROJETS</h2>
        </div>
        <div class="col-md-6">
            <div class="float-right mt-0 mb-3">
                <a type="button" rel="tooltip" title="Ajouter" href="<?= linkto('GestionInterne', 'projet') ?>"
                    class="btn btn btn-sm btn-red  ml-1">
                    <i class="fas fa-plus" style="color: #ffffff"></i>
                    Ajouter un projet
                </a>
                <a type="button" rel="tooltip" title="Paramétrer"
                    href="<?= linkto('GestionInterne', 'parametrageSubvention') ?>"
                    class="btn btn btn-sm btn-red  ml-1">
                    <i class="fas fa-cog" style="color: #ffffff"></i>
                    Paramétrage
                </a>
            </div>
        </div>
    </div>

</div>

<!-- DataTales Example -->
<div class="card shadow mb-4 col-md-12 ">
    <input type="hidden" name="URLROOT" id="URLROOT" value="<?= URLROOT ?>">
    <div class="card-header bg-secondary text-white">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center font-weight-bold" id="titre"> <?= $titre . " (" . sizeof($projets) . ")" ?>
                </h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable16" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($projets as $projet) {
                        $i++;
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $projet->nomProjet?></td>
                            <td><?= $projet->descriptionProjet?></td>
                            <td><?= $projet->createDate?></td>

                            <td style="text-align : center">
                                <a type="button" rel="tooltip" title="Modifier"
                                    href="<?= linkto('GestionInterne', 'projet', $projet->idProjet) ?>"
                                    class="btn btn btn-sm btn-warning  ml-1">
                                    <i class="fas fa-edit" style="color: #ffffff"></i>
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


<script type="text/javascript">

</script>