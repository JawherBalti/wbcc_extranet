<?php
/**
 * Gestion de l'envoi d'emails et documentation - Version B2C
 */
?>
<script>
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

function getInfoMail() {
    objetMail =
        `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    bodyMail = `<p style="text-align:justify">${`<?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?>`}<br><br>
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
                 ${`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`}
                                        `;

    $('#objetMailEnvoiDoc').val(objetMail)
    $('#signatureMail').val(`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`)
    tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
    tinyMCE.get("bodyMailEnvoiDoc").getBody().setAttribute('contenteditable', false);
}

function showModalSendDoc() {
    getInfoMail();
    $('#modalEnvoiDoc').modal('show');
}
</script>
