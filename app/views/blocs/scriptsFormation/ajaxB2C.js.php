<?php if (!defined('URLROOT')) exit('Direct access denied.'); ?>
<script>
// AJAX functions and data management for B2C
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
            url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveInfosContact`,
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
            bodyMessage: tinyMCE.get("bodyMailEnvoiDoc").getContent()
        };

        $.ajax({
            url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=sendDocumentation`,
            type: 'POST',
            data: post,
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Envoi en cours...");
                $("#loadingModal").modal("show");
            },
            success: function(response) {
                $("#loadingModal").modal("hide");
                if (response.success) {
                    $("#msgSuccess").text("Documentation envoyée avec succès !");
                    $('#successOperation').modal('show');
                    $("#envoyerDocModal").modal("hide");
                } else {
                    $("#msgError").text("Erreur lors de l'envoi de la documentation");
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response) {
                $("#loadingModal").modal("hide");
                $("#msgError").text("Erreur lors de l'envoi de la documentation");
                $('#errorOperation').modal('show');
            }
        });
    }
}

// Event handlers pour les tables de disponibilité
$(document).on('click', '.tdClass', function() {
    $(".tr > td").css("background-color", "lightgray");
    $(this).closest("td").css("background-color", "#e74a3b");
    var item = $(this).closest("td").html();
    let nomCommercial = item.split("<br>")[0];
    let DATE_RV = item.split("<br>")[1];
    let HEURE_D = item.split("<br>")[2].split("-")[0];
    let HEURE_F = item.split("<br>")[2].split("-")[1];
    idCommercialRDV = item.split("<br>")[3].split("-")[1];
    let marge = item.split("<br>")[3].split("-")[2];
    let DUREE = item.split("<br>")[3].split("-")[3];
    
    //Nouveau tableau
    heure = Number(HEURE_D.split(":")[0].trim());
    min = Number(HEURE_D.split(":")[1].trim());
    secondHD = (heure * 3600 + min * 60) * 1000;
    heure = Number(HEURE_F.split(":")[0].trim());
    min = HEURE_F.split(":")[1].trim();
    //TEST IF FIN + MARGE
    secondHF = (heure * 3600 + min * 60 + ((marge == "" || marge == null) ? 0 : marge * 60)) * 1000;
    horaires = [];
    for (var i = secondHD; i < secondHF - 6000; i = i + 1800000) {
        j = i + 1800000;
        time1 = msToTime(i);
        time2 = msToTime(j);
        if (j <= secondHF) {
            horaires.push(time1 + "-" + time2);
        }
    }
    nTaille = horaires.length;

    afficheNewTable(nomCommercial, DATE_RV, DUREE);
});

$(document).on('click', '.tdClass2', function() {
    $(".tr2 > td").css("background-color", "lightgray");
    $(this).closest("td").css("background-color", "#e74a3b");
    var item = $(this).closest("td").html();
    let nomCommercial = item.split("<br>")[0];
    let DATE_RV = item.split("<br>")[1];
    let HEURE_D = item.split("<br>")[2].split("-")[0];
    let HEURE_F = item.split("<br>")[2].split("-")[1];
    idCommercialRDV = item.split("<br>")[3].split("-")[1];
    let marge = item.split("<br>")[3].split("-")[2];
    let DUREE = item.split("<br>")[3].split("-")[3];
    
    //Nouveau tableau
    heure = Number(HEURE_D.split(":")[0].trim());
    min = Number(HEURE_D.split(":")[1].trim());
    secondHD = (heure * 3600 + min * 60) * 1000;
    heure = Number(HEURE_F.split(":")[0].trim());
    min = HEURE_F.split(":")[1].trim();
    //TEST IF FIN + MARGE
    secondHF = (heure * 3600 + min * 60 + ((marge == "" || marge == null) ? 0 : marge * 60)) * 1000;
    horaires = [];
    for (var i = secondHD; i < secondHF - 6000; i = i + 1800000) {
        j = i + 1800000;
        time1 = msToTime(i);
        time2 = msToTime(j);
        if (j <= secondHF) {
            horaires.push(time1 + "-" + time2);
        }
    }
    nTaille = horaires.length;

    afficheNewTable2(nomCommercial, DATE_RV, DUREE);
});
</script>
