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