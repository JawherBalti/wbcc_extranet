<?php
/**
 * Bloc JavaScript - Gestion géographique (régions/départements) pour formation
 */
?>
<script>
// Fonctions de gestion des régions et départements
function deleteRegion(element, code) {
    var parentDiv = element.parentNode;
    parentDiv.parentNode.parentNode.remove();
    regionsChoosed = regionsChoosed.filter(item => item[0] !== String(code));
    departementChoosed = departementChoosed.filter(item => item[2] !== String(code));
    getRegionsFrance();
    console.log(regionsChoosed);
    console.log(departementChoosed);
}

function choosedepertement(checkbox) {
    const checked = checkbox.checked;
    const code = checkbox.value;
    const nom = checkbox.dataset.nom;
    const codeRegion = checkbox.dataset.codeRegion;

    if (checked) {
        let line = [code, nom, codeRegion];
        departementChoosed.push(line);
    } else {
        departementChoosed = departementChoosed.filter(item => item[0] !== code);
    }
}

function chekCheckedsDepartement() {
    departementChoosed.forEach(dep => {
        document.getElementById('input-dep-' + dep[0]).checked = true;
    });
}

function inputRegionsFranceChange(code, nom) {
    if (code != "") {
        document.getElementById('loader-change-region').style.display = "block";
        let line = [code, nom];
        regionsChoosed.push(line);
        $.ajax({
            url: '<?= URLROOT . '/public/json/geoApi.php' ?>',
            method: 'GET',
            data: {
                action: 'getDepartementsByCoderegion',
                code: code
            },
            success: function(response) {
                const departements = JSON.parse(response);
                html = `  <div>
                            <hr>
                            <b style="font-size: 18px;">Région de: <span style="color: #36b9cc;">${nom}</span><b>
                            <button onclick="deleteRegion(this,${code})" class="fas fa-window-close" style='border-radius: 50% !important; font-size:20px; color:red; border: none !important; padding: 0px;'></button>
                            <br/><br/>
                            <div class="row">`;

                departements.forEach(departement => {
                    html += `<div class="form-group col-md-3">
                                    <label class="container-checkbox">
                                        ${departement.nom} (${departement.code})
                                        <input
                                            type="checkbox"
                                            id="input-dep-${departement.code}"
                                            value="${departement.code}"
                                            data-nom='${departement.nom.replace(/'/g, "&apos;").replace(/"/g, "&quot;")}'
                                            data-code-region='${departement.codeRegion}'
                                            onclick="choosedepertement(this)"
                                            >
                                        <span class="checkmark-checkbox"></span>
                                    </label>
                                </div>`;
                });
                html += `
                    </div></div>`;
                document.getElementById('display-place').innerHTML += html;
                getRegionsFrance();
                chekCheckedsDepartement();
            },
            complete: function() {
                document.getElementById('loader-change-region').style.display = "none";
            }
        });
    }
}

function getRegionsFrance() {
    $.ajax({
        url: '<?= URLROOT . '/public/json/geoApi.php' ?>',
        method: 'GET',
        data: {
            action: 'getRegionsFrance'
        },
        success: function(response) {
            const regions = JSON.parse(response);
            var optionsHtml = '<option value="">--Choisir--</option>';
            regions.forEach(region => {
                const alreadyAdded = regionsChoosed.some(item => item[0] === region.code);
                if (!alreadyAdded) {
                    optionsHtml += `<option value="${region.code}">${region.nom}</option>`;
                }
            });
            $('#inputRegionsFrance').html(optionsHtml);
        }
    });
}

// Initialisation au chargement de la page
$(document).ready(function() {
    getRegionsFrance();
});
</script>
