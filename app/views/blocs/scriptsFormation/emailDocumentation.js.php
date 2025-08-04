<script>
// =====================
// GESTION EMAILS ET DOCUMENTATION
// =====================

// Vérification des dépendances
if (typeof jQuery === 'undefined') {
    console.error('jQuery n\'est pas chargé - les fonctions d\'email ne fonctionneront pas');
}

// Attendre que le DOM soit chargé
$(document).ready(function() {
    console.log('Script emailDocumentation.js.php chargé avec succès');
});

window.sendDocumentation = function() {
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
            url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=envoiDocumentation`,
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

window.getInfoMail = function() {
    objetMail = `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
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

window.showModalSendDoc = function() {
    getInfoMail();
    $('#modalEnvoiDoc').modal('show');
}

function saveInfosGerant(type) {
    let dataObject = {};
    if (type == "resp") {
        dataObject = {
            civiliteGerant: document.getElementsByName('civiliteGerant')[0].value,
            emailGerant: document.getElementsByName('emailGerant')[0].value,
            idCompanyGerant: document.getElementsByName('idCompanyGerant')[0].value,
            idGerant: document.getElementsByName('idGerant')[0].value,
            nomGerant: document.getElementsByName('nomGerant')[0].value,
            posteGerant: document.getElementsByName('posteGerant')[0].value,
            prenomGerant: document.getElementsByName('prenomGerant')[0].value,
            telGerant: document.getElementsByName('telGerant')[0].value
        };
    } else {
        dataObject = {
            civiliteGerant: document.getElementsByName('civiliteInterlocuteur')[0].value,
            emailGerant: document.getElementsByName('emailInterlocuteur')[0].value,
            idCompanyGerant: document.getElementsByName('idCompanyInterlocuteur')[0].value,
            idGerant: document.getElementsByName('idInterlocuteur')[0].value,
            nomGerant: document.getElementsByName('nomInterlocuteur')[0].value,
            posteGerant: document.getElementsByName('posteInterlocuteur')[0].value,
            prenomGerant: document.getElementsByName('prenomInterlocuteur')[0].value,
            telGerant: document.getElementsByName('telInterlocuteur')[0].value
        };
    }

    console.log("Infos contact");
    console.log(dataObject);
    if (dataObject != {}) {
        $.ajax({
            url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=saveInfosContact`,
            type: 'POST',
            data: dataObject,
            dataType: "JSON",
            beforeSend: function() {
                console.log("Before Send");
            },
            success: function(response1) {
                console.log("success ok code");
                console.log(response1);
                if (response1 != null && response1 !== undefined && response1 != {}) {
                    // Success handling
                } else {
                    $("#msgError").text(
                        "(1)Erreur enregistrement, Veuillez réessayer ou contacter l'administrateur"
                    );
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response1) {
                console.log("ko");
                console.log(response1);
                $("#msgError").text(
                    "(2)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur"
                );
                $('#errorOperation').modal('show');
            },
            complete: function() {},
        });
    }
}

function saveScriptPartiel(etape) {
    getInfoMail()
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let causes = formData.getAll('cause[]');
    let dommages = formData.getAll('dommages[]');
    let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
    formData.append('causes', causes);
    formData.append('dommages', dommages);
    formData.append('noteTextCampagne', noteTextCampagne);
    formData.append('idAuteur', "<?= $idAuteur ?>");
    formData.append('auteur', "<?= $auteur ?>");
    formData.append('etapeSauvegarde', etape);
    formData.append('emailDestinataire', document.querySelector('input[name="emailGerant"]').value);
    formData.append('subject', $('#objetMailEnvoiDoc').val());
    formData.append('bodyMessage', tinyMCE.get("bodyMailEnvoiDoc").getContent());

    const dataObject = Object.fromEntries(formData.entries());
    $.ajax({
        url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=saveScriptPartiel`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        beforeSend: function() {
            if (etape == 'fin') {
                $("#msgLoading").text("Enregistrement en cours...");
                $("#loadingModal").modal("show");
            }
        },
        success: function(response) {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }

            if (etape == 'fin') {
                location.reload();
            }
        },
        error: function(response) {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("error");
        },
        complete: function() {
            if (etape == 'fin') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            if (opCree != null) {
                console.log("send code");
            }
        },
    });
}
</script>
