<?php
/**
 * Bloc modals pour formation
 * Variables attendues: $gerant, $tousCieAssurance, $cie
 */
?>
<!-- Modal pour la liste des notes -->
<div class="modal fade" id="modalListNotes" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="text-center font-weight-bold">LISTE DES NOTES</h2>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voir</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Auteur</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Fermer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Envoi de Documentation -->
<div class="modal fade" id="modalEnvoiDoc" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h2 class="text-center font-weight-bold text-uppercase">envoi documentation</h2>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Date</label>
                            <input type="text" name="" id="dateNote" readonly class="form-control"
                                value="<?= date('d-m-Y H:i') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Auteur</label>
                            <input type="text" name="" id="auteurNote" readonly class="form-control"
                                value="<?= $_SESSION['connectedUser']->prenomContact . ' ' . $_SESSION['connectedUser']->nomContact ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Confirmez l'adresse mail</label>
                        <input type="text" class="form-control" value="<?= $gerant ? $gerant->email : '' ?>"
                            id="emailDestinataire" name="emailGerant" ref="emailGerant">
                    </div>
                    <div class="form-group">
                        <label for="">Objet</label>
                        <input type="text" class="form-control" id="objetMailEnvoiDoc" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Contenu</label>
                        <textarea name="" id="bodyMailEnvoiDoc" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <input hidden type="text" class="form-control" value="" id="signatureMail" name="signatureMail"
                        ref="signatureMail">
                </form>
            </div>
            <div class="modal-footer">
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Annuler</a>
                <a href="javascript:void(0)" onclick="sendDocumentation()" class="btn btn-info">Envoyer</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour les ajout et edit de compagnie -->
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
                            <?php } ?>
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
