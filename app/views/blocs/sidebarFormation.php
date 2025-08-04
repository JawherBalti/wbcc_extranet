<div class="col-md-4 col-sm-12 col-xs-12">
    <div class="script-container"
        style="height:90%; padding-top: 10px; padding-left:10px; padding-right:10px; margin:20px; align-items: center;justify-content: center;">
        <div class="mb-2">
            <a target="_blank" class="btn btn-info d-flex align-items-center"
                href="<?= linkTo('CompanyGroup', 'company',  $company->idCompany)  ?>">
                <i class="fas fa-info-circle mr-2"></i> Détails
            </a>
        </div>
        <div class="mb-2">
            <a class="btn btn-warning d-flex align-items-center" onclick="loadNotes('modal')">
                <i class="fas fa-fw fa-file mr-2"></i> Liste des Notes
            </a>
        </div>
        <div class="mb-2">
            <a class="btn btn-info d-flex align-items-center" onclick="showModalSendDoc()"><i
                    class="fa fa-paper-plane mr-2"></i> Envoi Doc</a>
        </div>
        <div class="mb-2">
            <label for="">Note</label>
            <textarea name="noteTextCampagne" id="noteTextCampagne" cols="10" rows="10" readonly
                class="form-control"><?= ($questScript ? $questScript->noteTextCampagne : "") ?></textarea>
        </div>
    </div>
</div>

<!-- Modal pour la liste des notes -->
<div class="modal fade" id="modalListNotes" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h2 class="text-center font-weight-bold">LISTE DES NOTES</h2>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
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
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
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
                                value="<?= isset($_SESSION['connectedUser']->prenomContact) ? $_SESSION['connectedUser']->prenomContact . ' ' . $_SESSION['connectedUser']->nomContact : $_SESSION['connectedUser']->fullName ?>">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
                <button type="button" onclick="sendDocumentation()" class="btn btn-info">Envoyer</button>
            </div>
        </div>
    </div>
</div>

<script>
// =====================
// FONCTIONS POUR GESTION DES NOTES ET ENVOI DOC
// =====================

function showModalSendDoc() {

    getInfoMail();
    $('#modalEnvoiDoc').modal('show');
}

// Fonction pour afficher le modal d'envoi de documentation
function showModalSendDoc() {
    console.log('showModalSendDoc appelée');
    
    // Préparer les informations du mail
    const objetMail = `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    const bodyMail = `<p style="text-align:justify"><?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?><br><br>
                    Merci pour notre échange très agréable d'aujourd'hui.<br><br>
                    Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d'assurance, en nous occupant de tout, de A à Z.<br><br>
                    <b>En choisissant Proxinistre, vous bénéficiez notamment de</b> :<br>
                    <ul>
                        <li>Un interlocuteur unique dédié à votre dossier.</li>
                        <li>Une expertise SOS Sinistre sous 24 heures.</li>
                        <li>Un soutien administratif et juridique complet.</li>
                        <li><b>0€ de coût de gestion</b> pour vous.</li>
                        <li>La facilitation complète des démarches liées à votre sinistre.</li>
                        <li>Une assistance disponible 24h/24 et 7j/7.</li>
                        <li>Des partenaires agréés pour des réparations rapides et garanties.</li>
                    </ul>
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d'esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                    <?= isset($_SESSION['connectedUser']->fullName) ? $_SESSION['connectedUser']->fullName : 'L\'équipe Proxinistre' ?>
                    </p>`;

    // Remplir les champs du modal
    if ($('#objetMailEnvoiDoc').length > 0) {
        $('#objetMailEnvoiDoc').val(objetMail);
    }
    
    // Utiliser TinyMCE si disponible, sinon utiliser textarea normale
    if (typeof tinyMCE !== 'undefined' && tinyMCE.get("bodyMailEnvoiDoc")) {
        tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
    } else if ($('#bodyMailEnvoiDoc').length > 0) {
        $('#bodyMailEnvoiDoc').val(bodyMail);
    }
    
    // Afficher le modal
    $('#modalEnvoiDoc').modal('show');
}


// Fonction pour envoyer la documentation
function sendDocumentation() {
    let emailDestinataire = $("#emailDestinataire").val()
    if (emailDestinataire == "") {
        $("#msgError").text("veuillez renseigner une adresse mail !");
        $('#errorOperation').modal('show');
    } else {
        let nomDoc = "";
        var cheminDoc = "/public/documents/campagne/" + nomDoc;
        let post = {
            to: emailDestinataire,
            subject: $('#objetMailEnvoiDoc').val(),
            bodyMessage: tinyMCE.get("bodyMailEnvoiDoc").getContent() + `
                            `,
            attachment: cheminDoc,
            attachmentName: nomDoc,
            idAuteur: `<?= $_SESSION['connectedUser']->idUtilisateur ?>`,
            auteur: `<?= $_SESSION['connectedUser']->fullName ?>`,
            numeroAuteur: `<?= $_SESSION['connectedUser']->numeroContact ?>`,
            regarding: "Envoi Documentation",
            idContact: $('#idContact').val(),
            idCompanyGroup: $('#contextId').val()
        }
        $.ajax({
            url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=envoiDocumentation`,
            type: 'POST',
            data: JSON.stringify(post),
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Envoi mail en cours...");
                $('#loadingModal').modal('show');
            },
            success: function(response) {

                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);


                $("#msgSuccess").text("Envoi de documentation effectué avec succés!");
                $('#successOperation').modal('show');

                setTimeout(function() {
                    $('#successOperation').modal('hide');
                }, 1000);

                setTimeout(function() {
                    location.reload();
                }, 1500);

            },
            error: function(response) {

                setTimeout(() => {
                    $('#loadingModal').modal('hide');
                }, 500);
                $("#msgError").text("Impossible d'envoyer le mail !");
                $('#errorOperation').modal('show');
            },
            complete: function() {

            },
        });
    }
}

</script>
