<div class="modal fade" id="selectCompany" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" method="POST" action="" id="formChoiceCie">
            <input name="oldIdCie" id="oldIdCie" value="<?= isset($cie) &&  $cie ? $cie->idCompany : "" ?>" hidden>
            <input name="action" value="" id="action" hidden>
            <div class="modal-header bg-secondary text-white">
                <h2 class="text-center font-weight-bold">Choisissez une compagnie</h2>
                <button hidden type="" onclick="showModalAddCompany()" id="" class="btn btn-info">Ajouter</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>Nom Compagnie</th>
                                <th>Adresse</th>
                                <th>Email</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($tousCieAssurance))
                                foreach ($tousCieAssurance as $cie1) {
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="oneselectionCie" name="oneselectionCie"
                                            value="<?= $cie1->idCompany ?>;<?= $cie1->numeroCompany ?>">
                                    </td>
                                    <td><?= $i++ ?></td>
                                    <td><?= $cie1->name ?></td>
                                    <td><?= $cie1->businessLine1 ?></td>
                                    <td><?= $cie1->email ?></td>
                                    <td><?= $cie1->businessPhone ?></td>
                                </tr>
                            <?php  }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Annuler</a>
                <a href="javascript:void(0)" onclick="AddOrEditCie()" class="btn btn-success">Valider</a>
            </div>
        </div>
    </div>
</div>