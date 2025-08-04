<?php
/**
 * Bloc JavaScript - Gestion des rendez-vous pour formation
 */
?>
<script>
function afficheNewTable2(nomCommercial, date, duree) {
    $('#divTabHoraire2').empty();
    var html =
        `<div class="font-weight-bold">
            <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
        </div>
        <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
    html += `<tr class="ntr" style="background-color: lightgray">`;
    for (var i = 0; i < nTaille; i++) {
        html += `<td class="ntdClass"  align="center" id="cel${i}" value="${i}"> ${horaires[i]} </td>`;
    }
    html += `</tr>`;
    html += `</table>`;
    $('#divTabHoraire2').append(html);

    $(".ntdClass").click(function() {
        $(".ntr > td").css("background-color", "lightgray");
        $(this).closest("td").css("background-color", "#e74a3b");
        var item = $(this).closest("td").html();
        commercialRDV = nomCommercial;
        dateRDV = date;
        heureDebutRDV = item.split("-")[0];
        heureFinRDV = item.split("-")[1];
        let DUREE = duree;
        let HEURE_RV = item;
        if (idCommercialRDV != "0") {
            $("#INFO_RDV2").text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " +
                heureDebutRDV +
                " à " + heureFinRDV);
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureRV').attr("value", heureDebutRDV);
            $('#divPriseRvRT-2').removeAttr("hidden");

            if (currentStep == 22) {
                const typeRencontre = document.querySelector('input[name="typeRencontre"]:checked');
                let typeRencontretext = "";
                if (!typeRencontre) {
                } else if (typeRencontre.value == "physique") {
                    typeRencontretext = "physique";
                } else if (typeRencontre.value == "Visioconférence") {
                    typeRencontretext = "visioconférence";
                }
                const maVar = document.getElementById('place-rdv');
                maVar.innerHTML = ` ${typeRencontretext} le ${dateRDV} de ${heureDebutRDV} à ${heureFinRDV}.`;
                $("#sous-menu-recap").removeAttr("hidden");
            }
        }
    });
}

function changeValueAdr() {
    $('#etage').attr("value", $('#etage2').val());
    $('#porte').attr("value", $('#porte2').val());
    $('#lot').attr("value", $('#lot2').val());
    $('#batiment').attr("value", $('#batiment2').val());
    $('#libellePartieCommune').attr("value", $('#libellePartieCommune2').val());
    $('#cote').attr("value", $('#cote2').val());
}
</script>
