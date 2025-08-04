<?php
/**
 * Scripts JavaScript pour Proxinistre B2B
 */
?>
<script>
let steps = document.querySelectorAll(".stepDSS");
let prevBtn = document.getElementById("prevBtnDSS");
let nextBtn = document.getElementById("nextBtnDSS");
let finishBtn = document.getElementById("finishBtnDSS");
let indexPageDSS = document.getElementById('indexPageDSS');
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
const history = [];
let opCree = null;
let signature = null;
let siInterlocuteur = false;
let typePage = "DSS";

findOp();

function findOp() {
    $.ajax({
        url: `<?= URLROOT ?>/public/json/opportunity.php?action=findByName`,
        type: 'POST',
        data: {
            name: `<?= $questScript ? $questScript->numeroOP : '' ?>`
        },
        dataType: "JSON",
        beforeSend: function() {},
        success: function(response) {
            console.log(response);
            if (response && response != "false") {
                opCree = response;
            }
        },
        error: function(response) {
            console.log(response);
        },
        complete: function() {
        },
    });
}

//NAVIGATION
function updateButtons() {
    indexPageDSS.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);

    if (typePage == "DSS") {
        nextBtn.classList.toggle("hidden", currentStep === 4);
        finishBtn.classList.toggle("hidden", currentStep !== 4);
    }

    if (typePage == "SD") {
        nextBtn.classList.toggle("hidden", currentStep === 9);
        finishBtn.classList.toggle("hidden", currentStep !== 9);
    }

    if (typePage == "RvRT") {
        nextBtn.classList.toggle("hidden", currentStep === 4);
        finishBtn.classList.toggle("hidden", currentStep !== 4);
    }

    if (typePage == "RvPerso") {
        nextBtn.classList.toggle("hidden", currentStep === 2);
        finishBtn.classList.toggle("hidden", currentStep !== 2);
    }

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = pageIndex;
    });
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;

    currentStep = index;
    steps[currentStep].classList.add("active");
    updateButtons();
}

function goBackScript(type) {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    updateButtons();
}

function goNext(type) {
    if (type == "SD") {
        if (currentStep === 0) {
            const val = document.querySelector('input[name="siSignDeleg"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") return showStep(1);
            if (val.value === "non") {
                return showStep(9);
            }
            if (val.value == "plusTard") return showStep(8);
        }

        if (currentStep === 1) {
            if ($("#prenomSignataire").val() == "" || $("#nomSignataire").val() == "" || $("#dateNaissance").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 2) {
            if ($("#adresseImm").val() == "" || $("#cP").val() == "" || $("#ville").val() == "" || $("#etage").val() == "" || $("#porte").val() == "") {
                $("#msgError").text("Veuillez compléter les informations obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 3) {
            if ($("#nomCie").val() == "") {
                $("#msgError").text("Veuillez renseigner la compagnie d'assurance !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 4) {
            if ($("#numPolice").val() == "" || $("#dateDebutContrat").val() == "" || $("#dateFinContrat").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep == 5) {}

        if (currentStep == 6) {
            if ($("#emailSign").val() == "" || $("#telSign").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            } else {
                onClickTerminerAssistant();
                return;
            }
        }

        if (currentStep === 7) {
            onClickValidSignature();
            return;
        }

        if (currentStep === 8) {
            const val = document.querySelector('input[name="raisonRefusSignature"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }

            if (val.value == "prefereDemander") {
                $(`#textClotureSD`).text(
                    "Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. Nous fixerons ensuite un rendez-vous pour finaliser ensemble, une fois votre échange réalisé"
                );
            } else {
                if (val.value == "documentManquant") {
                    $(`#textClotureSD`).text(
                        "Oui effectivement, je note bien que certains documents vous manquent, c'est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
                    );
                } else {
                    if (val.value == "signatureComplique") {
                        $(`#textClotureSD`).text(
                            "Je comprends parfaitement. Soyez rassuré(e), c'est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                        );
                    } else {
                        if (val.value == "prendreConnaissance") {
                            $(`#textClotureSD`).text(
                                "C'est tout à fait normal et même recommandé. Je vous propose de vous envoyer immédiatement la délégation par mail accompagnée d'une courte présentation de nos services pour que vous puissiez en prendre connaissance tranquillement. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, en toute sérénité."
                            );
                        }
                    }
                }
            }
            return showStep(9)
        }
    }

    if (type == "RvRT") {
        if (currentStep === 0) {
            const val = document.querySelector('input[name="accordRVRT"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value === "oui") {
                this.getDisponiblites("");
                document.getElementById('textClotureRvRT').innerHTML =
                    " Je vous remercie et vous souhaite une bonne fin de journée!";
                return showStep(1);
            }
            if (val.value === "non") {
                document.getElementById('textClotureRvRT').innerHTML =
                    "Je comprends votre hésitation. Sachez simplement que le relevé technique réalisé par notre expert permet très souvent d'accélérer le traitement par votre assureur et facilite l'indemnisation rapide. Toutefois, je respecte votre décision et vous envoie immédiatement notre documentation par mail.<br>N'hésitez pas à revenir vers nous à tout moment si vous souhaitez avancer ensemble. Très bonne journée à vous !";
                $("#reponseDoc").removeAttr("hidden");
                $("#divEnvoiDoc").removeAttr("hidden");
                return showStep(4);
            }
        }
        if (currentStep === 3) {
            onClickEnregistrerRV("RTP")
            return;
        }
    }

    if (type == "RvPerso") {
        if (currentStep === 0) {
            this.getDisponiblites("Sup");
            return showStep(1);
        }
        if (currentStep === 1) {
            onClickEnregistrerRV("AT")
            return;
        }
    }

    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}

function finish(type) {
    if (type == 'DSS') {
        saveScriptPartiel('finDSS');
    } else {
        saveScriptPartiel('fin');
    }
}

updateButtons();

const refs = document.querySelectorAll('[ref]');
refs.forEach(ref => {
    ref.addEventListener('input', (e) => {
        refs.forEach(r => {
            if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                r.value = ref.value;
            }
        });
    });
});

function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

function changeDateTE() {
    if (document.getElementById('dateInconnu').checked) {
        $("#infosCom").removeAttr("hidden");
        $('#blockdateS').attr("hidden", "hidden");
        $("#dateS").val("");
        $("#timeS").val("");
    } else {
        $("#infosCom").attr("hidden", "hidden");
        $('#blockdateS').removeAttr("hidden");
        $("#dateConstat").val("");
        $("#anneeSurvenance").val("");
        $("#comDateInconnu").val("");
    }
}

function onClickChoixSignaturePT() {

}

function onClickCause(val, etat) {
    if (val.value == "Autre") {
        if (val.checked) {
            $(`#divAutreCause`).removeAttr('hidden');
        } else {
            $(`#divAutreCause`).attr('hidden', '');
        }
    }
}

function showBody(idAffiche) {
    getInfoMail()
    typePage = idAffiche;

    let div = "divBody" + idAffiche
    steps = document.querySelectorAll(".step" + idAffiche);
    prevBtn = document.getElementById("prevBtn" + idAffiche);
    nextBtn = document.getElementById("nextBtn" + idAffiche);
    finishBtn = document.getElementById("finishBtn" + idAffiche);
    indexPageDSS = document.getElementById('indexPage' + idAffiche);
    currentStep = 0;
    pageIndex = 1;
    numQuestionScript = 1;

    const divs = document.querySelectorAll('div[id^="divBody"]');
    divs.forEach(div => {
        div.setAttribute('hidden', '');
    });
    $('#' + div).removeAttr("hidden");
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
            to: $('#emailGerant').val(),
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
                console.log(response);
                saveScriptPartiel('fin');
                setTimeout(function() {
                    $('#successOperation').modal('hide');
                }, 1000);
            },
            error: function(response) {
                console.log(response);
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
    objetMail = `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    bodyMail = `<p style="text-align:justify">${`<?= "Madame, Monsieur," ?>`}<br><br>
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

onChangeTypeSin();

function onChangeTypeSin() {
    let id = "";
    const typeSinistre = document.getElementById('typeSinistre');
    let dommages = [];
    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts ?");
    if (typeSinistre.value == "autre") {
        dommages = [];
    } else {
        if (typeSinistre.value == "degatEaux") {
            $(`#textDommages`).text('Pouvez-vous me décrire les dommages liés aux dégats des eaux ?');
            dommages = ["Auréoles/taches visibles sur plafonds ou murs",
                "Cloques ou décollements de peinture ou de papier peint", "Parquet/plancher gondolé ou déformé",
                "Moquettes ou tapis détériorés ou tachés", "Mobilier gonflé, taché ou déformé",
                "Plinthes ou boiseries abîmées ou décollées",
                "Carrelage descellé ou joints abîmés",
                "Apparition de moisissures/champignons sur surfaces visibles",
                "Lambris ou revêtements décoratifs détériorés"
            ];
        } else {
            if (typeSinistre.value == "incendie") {
                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par l'incendie ?");
                dommages = ["Traces de fumée ou suie sur murs/plafonds",
                    "Mobilier partiellement brûlé nécessitant restauration",
                    "Sol (parquet, carrelage, moquette) brûlé ou taché",
                    "Portes/fenêtres déformées nécessitant remplacement",
                    "Revêtements muraux brûlés ou fortement salis",
                    "Façade extérieure noircie nécessitant nettoyage/peinture",
                    "Odeurs persistantes nécessitant traitement spécifique",
                    "Isolation intérieure détruite ou à remplacer", "Faux plafonds brûlés ou noircis à remplacer",
                    "Éléments décoratifs (rideaux, stores) endommagés"
                ];
            } else {
                if (typeSinistre.value == "brisGlace") {
                    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le bris de glace ?");
                    dommages = ["Vitrine commerciale endommagée", "Fenêtre ou baie vitrée endommagée",
                        "Porte vitrée brisée", "Miroir décoratif cassé",
                        "Verrière fissurée", "Cabine de douche brisée", "Mobilier vitré cassé",
                        "Étagère en verre cassée", "Plateau/table en verre fracturé",
                        "Garde-corps ou clôture en verre brisé"
                    ];
                } else {
                    if (typeSinistre.value == "vandalisme") {
                        $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vandalisme ?");
                        dommages = ["Murs ou vitrines tagués", "Dégradations portes/fenêtres",
                            "Dégradations mobilier urbain", "Dégradations équipements décoratifs",
                            "Enseigne commerciale taguée ou rayée", "Câbles coupés/endommagés",
                            "Sanitaires dégradés",
                            "Caméra surveillance détruite", "Clôtures/portails endommagés",
                            "Rideau métallique abîmé"
                        ];
                    } else {
                        if (typeSinistre.value == "evenementClimatique") {
                            $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par l'événment climatique ?");
                            dommages = [];
                        } else {
                            if (typeSinistre.value == "vol") {
                                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vol ?");
                                dommages = ["Porte/fenêtre fracturée", "Serrure endommagée ou forcée",
                                    "Mobilier ou éléments décoratifs détériorés",
                                    "Systèmes de sécurité/alarme dégradés", "Coffre-fort endommagé",
                                    "Vitrine fracturée", "Volets ou rideaux endommagés",
                                    "Documents sensibles endommagés"
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    dommages.push("Autre");
    let html = "";
    const dommagesCoches = '<?= $questScript ? $questScript->dommages : '' ?>'
    const domArray = dommagesCoches.split(";");

    dommages.forEach(element => {
        let isFuiteChecked = domArray.includes(element);
        html += `<div class="col-md-6 col-sm-6 text-left">
                                                    <input onclick='onClickDommage(this)' ${isFuiteChecked ? 'checked' : ''} type="checkbox" value="${element}"
                                                        name="dommages[]" class="dommages" >
                                                    <label> ${element}</label>
                                                </div>`;
    });
    document.getElementById("option-content").innerHTML = html;
}

function onClickDommage(checkbox) {
    const valeur = checkbox.value;
    const estCoche = checkbox.checked;

    if (valeur == "Autre") {
        if (estCoche) {
            $(`#divAutreDommage`).removeAttr('hidden');
        } else {
            $(`#divAutreDommage`).attr('hidden', '');
        }
    }
}

function onChangeDateDebutContrat() {
    let deb = $('#dateDebutContrat').val();
    let date = new Date(deb);
    $('#dateFinContrat').attr("value", (date.getFullYear() + 1) + "-" + String(date.getMonth() + 1).padStart(2, '0') + "-" + String(date.getDate()).padStart(2, '0'));
}

function showSousQuestion(idSS, $show) {
    if ($show) {
        $(`#sous-question-${idSS}`).removeAttr('hidden');
    } else {
        $(`#sous-question-${idSS}`).attr('hidden', '');
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
    formData.append('signatureMail', $("#signatureMail").val());

    const dataObject = Object.fromEntries(formData.entries());
    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveScriptPartiel`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        beforeSend: function() {
            if (etape == 'fin' || etape == 'finDSS') {
                $("#msgLoading").text("Enregistrement en cours...");
                $("#loadingModal").modal("show");
            }
        },
        success: function(response) {
            if (etape == 'fin' || etape == 'finDSS') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("success");
            console.log(response);

            if (etape == 'fin' || etape == 'finDSS') {
                location.reload();
            }
        },
        error: function(response) {
            if (etape == 'fin' || etape == 'finDSS') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("error");
            console.log(response);
        },
        complete: function() {
            if (etape == 'fin' || etape == 'finDSS') {
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

function onClickTerminerAssistant() {
    $("#msgLoading").text("Enregistrement en cours...");
    $('#loadingModal').modal('show');

    console.log("CREER OP");
    console.log("send code");

    let emailSign = $('#emailSign').val();
    let telSign = $('#telSign').val()

    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    formData.append("connectedUser", `<?= json_encode($connectedUser) ?>`);
    const dataObject = Object.fromEntries(formData.entries());
    console.log(dataObject);

    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveOPAndGenerateDeleg`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        success: function(response) {
            console.log("success");
            console.log(response);
            if (response != "0") {
                opCree = response;
            }
        },
        error: function(response) {
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 500);
            console.log(response);
            $('#errorOperation').modal('show');
        },
        complete: function() {
            if (opCree != null) {
                console.log("send code");
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/signature.php?action=sendCodeSignature`,
                    type: 'POST',
                    data: {
                        idOp: opCree.idOpportunity,
                        idDoc: opCree.delegationDoc.idDocument,
                        nomDoc: opCree.delegationDoc.nomDocument,
                        urlDoc: opCree.delegationDoc.urlDocument,
                        civilite: formData.get('civiliteGerant'),
                        prenom: formData.get('prenomSignataire'),
                        nom: formData.get('nomSignataire'),
                        email: emailSign,
                        tel: telSign,
                        type: "Email",
                        commentaire: "",
                        idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                        numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                        login: "",
                        auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $("#msgLoading").text("Génération de code et envoi en cours...");
                        $("#loadingModal").modal("show");
                        console.log("Before Send");
                    },
                    success: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("success ok code");
                        console.log(response1);
                        if (response1 != null && response1 !== undefined && response1 != {}) {
                            signature = response1;
                            showStep(7)
                        } else {
                            $("#msgError").text("(1)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur");
                            $('#errorOperation').modal('show');
                        }
                    },
                    error: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("ko");
                        console.log(response1);
                        $("#msgError").text("(2)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur");
                        $('#errorOperation').modal('show');
                    },
                    complete: function() {},
                });
            }
        },
    });
}

function onClickValidSignature() {
    let codeSaisi = $('#codeSign').val();
    let email = $('#emailSign').val();
    let tel = $('#telSign').val();
    let type = 'Email';
    if (signature != null) {
        if (signature.code != codeSaisi) {
            $("#msgError").text("Code erroné !!!");
            $('#errorOperation').modal('show');
        } else {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/signature.php?action=signDocument`,
                type: 'POST',
                data: {
                    idOp: opCree.idOpportunity,
                    idDoc: opCree.delegationDoc.idDocument,
                    nomDoc: opCree.delegationDoc.nomDocument,
                    urlDoc: opCree.delegationDoc.urlDocument,
                    createDate: `<?= $createDate ?>`,
                    civilite: $('#civiliteGerant').val(),
                    prenom: $('#prenomGerant').val(),
                    nom: $('#nomGerant').val(),
                    idContact: '',
                    numeroContact: '',
                    email: email,
                    tel: tel,
                    type: type,
                    commentaire: "",
                    idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                    numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                    login: "",
                    auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`,
                    signature: signature,
                    typeDocument: 'delegation'
                },
                dataType: "JSON",
                beforeSend: function() {
                    $("#msgLoading").text("Signature en cours...");
                    $("#loadingModal").modal("show");
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    if (response != null && response != "" && response == "1") {
                        $("#msgSuccess").text("Délégation de gestion signée avec succés !");
                        $('#successOperation').modal('show');
                        showStep(9);
                    } else {
                        $("#msgError").text("(1)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(response) {
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    console.log("ko");
                    console.log(response);
                    $("#msgError").text("(2)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
                    $('#errorOperation').modal('show');
                },
                complete: function() {},
            });
        }
    } else {
        $("#msgError").text("(3)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
        $('#errorOperation').modal('show');
    }
}

function onClickDeclareSinistre(params) {
    if (params == "oui") {
        $('#divNumSinistre').removeAttr("hidden");
    } else {
        $('#divNumSinistre').attr("hidden", "hidden");
    }
}

function AddOrEditCie() {
    let checkCie = $('.oneselectionCie:checkbox:checked').val().split(';')[0];
    console.log(checkCie)
    $.ajax({
        url: `<?= URLROOT ?>/public/json/company.php?action=find&id=${checkCie}`,
        type: 'GET',
        dataType: "JSON",
        success: function(response) {
            console.log("success");
            $('#idCie').attr("value", response.idCompany);
            $('#numeroCie').attr("value", response.numeroCompany);
            $('#nomCie').attr("value", response.name);
            $('#adresseCie').attr("value", response.businessLine1);
            $('#villeCie').attr("value", response.businessCity);
            $('#codePostalCie').attr("value", response.businessPostalCode);
            $('#telCie').attr("value", response.businessPhone);
            $('#emailCie').attr("value", response.email);
            $("#selectCompany").modal("hide");
            $("#btnAddCie").attr("onclick", "showModalCie('edit')");
            $("#iconeAddCie").attr("class", "fas fa-edit");
            $('#divInfosCie').removeAttr("hidden");
            $('#divInfosPasCie').attr("hidden", "hidden");
            $('#selectCompany').modal('hide');
        },
        error: function(response) {
            console.log(response);
            $('#selectCompany').modal('hide');
            $("#msgError").text("Erreur de choisir une compagnie");
            $('#errorOperation').modal('show');
        },
        complete: function() {

        },
    });
}

function showModalCie(action) {
    if (action == "edit") {
        $("#action").attr("value", "edit");
    } else {
        $("#action").attr("value", "add");
    }
    $("#selectCompany").modal("show");
}

// Variables pour RV RT
let tab = [];
let taille = 0;
let iColor = 0;
let nbPage = 0;
let nbPageTotal = 0;
let k = 0;
let nbDispo = 0;
let horaires = [];
let nTaille = 0;
let commercialRDV = "";
let dateRDV = "";
let heureDebutRDV = "";
let heureFinRDV = "";
let idCommercialRDV = "0";

function getDisponiblites(type) {
    let post = {
        adresseRV: $('#adresseImm').val(),
        codePostal: $('#cP').val(),
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        dateRV: "",
        heureRV: "",
        source: "wbcc"
    }
    let action = "getDisponibilitesExpert";
    if (type == 'Sup') {
        action = "getDisponibilitesSansContrainte";
    }
    $.ajax({
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=${action}`,
        type: 'POST',
        data: JSON.stringify(post),
        dataType: "JSON",
        beforeSend: function() {

        },
        success: function(result) {
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            console.log('result dispos');
            console.log(result);
            $('#btnRvRT').attr("hidden", "hidden");
            if (result !== null && result != undefined) {
                if (result.length == 0) {
                    $('#notDisponibilite').removeAttr("hidden");
                } else {
                    tab = result;
                    taille = tab.length;
                    nbPageTotal = Math.ceil(tab.length / 10);
                    nbPage++;
                    afficheBy10InTable(type);
                    $('#divPriseRvRT2').removeAttr("hidden");
                    if (nbPage == 1) {
                        $('#btnPrecedentRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnPrecedentRDV').removeAttr("hidden");
                    }
                    if (nbPage == nbPageTotal) {
                        $('#btnSuivantRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnSuivantRDV').removeAttr("hidden");
                    }
                }
            } else {
                $('#divChargementDisponibilite').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite').removeAttr("hidden");
            }
        },
        error: function(response) {
            $('#btnRvRT').removeAttr("hidden");
            $('#divPriseRvRT2').attr("hidden", "hidden");
            $('#divPriseRvRT').attr("hidden", "hidden");
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 1000);
            console.log("Erreur")
            console.log(response)
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            $('#divChargementNotDisponibilite').removeAttr("hidden");
        }
    });
}

function onClickEnregistrerRV(type) {
    let expert = $('#expertRV').val();
    let idExpert = $('#idExpertRV').val();
    let idContact = $('#idContactRV').val();
    let date = $('#dateRV').val();
    let heureD = $('#heureDebut').val();
    let heureF = $('#heureFin').val();
    let adresse = $('#adresseImm').val() + " " + $("#businessPostalCode").val() + " " + $("#businessCity").val();
    let commentaire = $('#commentaireRV').html();
    if (idExpert != "0" && date != "" && heureD != "" && adresse != "") {
        let post = [];
        post[0] = {
            idOpportunityF: type == "AT" ? "" : (opCree != null ? opCree.idOpportunity : null),
            numeroOP: type == "AT" ? "" : (opCree != null ? opCree.name : ''),
            expert: expert,
            idExpert: idExpert,
            idContact: type == "AT" ? "" : (opCree != null ? opCree.idContactClient : idContact),
            idContactGuidF: "",
            dateRV: date,
            heureDebut: heureD,
            heureFin: heureF,
            adresseRV: adresse,
            etage: $('#etage').val(),
            porte: $('#porte').val(),
            lot: $('#lot').val(),
            batiment: $('#batiment').val(),
            conclusion: commentaire,
            idUtilisateur: $('#idUtilisateur').val(),
            numeroAuteur: $('#numeroAuteur').val(),
            auteur: $('#auteur').val(),
            idRVGuid: "",
            idRV: "0",
            idAppGuid: "",
            idAppExtra: type == "AT" ? "" : (opCree != null && opCree.app ? opCree.app.idApp : ''),
            idAppConF: type == "AT" ? "" : (opCree != null && opCree.appCon != false ? opCree.appCon.idAppCon : ''),
            nomDO: type == "AT" ? "" : (opCree != null ? opCree.contactClient : ''),
            moyenTechnique: "",
            idCampagneF: "",
            typeRV: type != "AT" ? "RTP" : type,
            cote: "",
            libellePartieCommune: "",
            typeLot: ""
        }

        $.ajax({
            url: `<?= URLROOT ?>/public/json/rendezVous.php?action=saveRVRT&sourceEnreg=interne`,
            type: 'POST',
            data: JSON.stringify(post),
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Validation de RDV RT en cours...");
                $("#loadingModal").modal("show");
            },
            success: function(response) {
                console.log("success");
                console.log(response);
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500)
                if (response != "0") {
                    if (response == "2") {
                        $("#msgError").text("Cette disponibilité est invalide, veuillez choisir une autre !");
                        $('#errorOperation').modal('show');
                    } else {
                        $('#divPriseRvRT').attr("hidden", "hidden");
                        $('#btnRvRT').attr("hidden", "hidden");
                        $("#msgSuccess").text("Rendez-vous RT pris avec succés !");
                        $('#successOperation').modal('show');
                        if (type == "AT") {
                            showStep(2)
                        } else {
                            showStep(4)
                        }
                    }
                } else {
                    $("#msgError").text("(1)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response) {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500)
                console.log(response);
                $("#msgError").text("(2)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                $("#loadingModal").modal("hide");
            },
        });
    } else {
        setTimeout(() => {
            $("#loadingModal").modal("hide");
        }, 500)
        $("#msgError").text("Veuillez remplir tous les champs !");
        $('#errorOperation').modal('show');
    }
}

function onClickSuivantRDV(type) {
    if (nbPage >= nbPageTotal) {
        alert("Plus de disponibiltés! veuillez forcer");
    } else {
        nbPage++;
        afficheBy10InTable(type);
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function onClickPrecedentRDV(type) {
    if (nbPage != 1) {
        iColor = ((nbPage - 1) * 2) - 2;
        nbPage--;
        k = k - nbDispo - 10;
        afficheBy10InTable(type);
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function afficheBy10InTable(type) {
    var test = 0;
    var kD = k;
    first = k;
    console.log(`#divTabDisponibilite${type}`);

    $(`#divTabDisponibilite${type}`).empty();
    var html = `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html += `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5)
                        iColor++;
                    break;
                }
            }

            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2)
                    iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $(`#divTabDisponibilite${type}`).append(html);
    nbDispo = k - kD;

    $(".tdClass").click(function() {
        $(`#INFO_RDV${type}`).text("");
        $('#divPriseRvRT').attr("hidden", "hidden");
        $('#expertRV').attr("value", "");
        $('#idExpertRV').attr("value", "0");
        $('#dateRV').attr("value", "");
        $('#heureRV').attr("value", "");
        $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
        $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
        var item = $(this).closest("td").html();
        let nomCommercial = item.split("<br>")[0];
        let DATE_RV = item.split("<br>")[1];
        let HEURE_D = item.split("<br>")[2].split("-")[0];
        let HEURE_F = item.split("<br>")[2].split("-")[1];
        idCommercialRDV = item.split("<br>")[3].split("-")[1];
        let marge = item.split("<br>")[3].split("-")[2];
        let DUREE = item.split("<br>")[3].split("-")[3];
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
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

        afficheNewTable(nomCommercial, DATE_RV, DUREE, type);
    });
}

function afficheNewTable(nomCommercial, date, duree, type = "") {
    $(`#divTabHoraire${type}`).empty();
    var html = `<div class="font-weight-bold">
                                        <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                                    </div>
                <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
    html += `<tr class="ntr" style="background-color: lightgray">`;
    for (var i = 0; i < nTaille; i++) {
        html += `<td class="ntdClass"  align="center" id="cel${i}" value="${i}"> ${horaires[i]} </td>`;
    }
    html += `</tr>`;
    html += `</table>`;
    $(`#divTabHoraire${type}`).append(html);

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

        let civilite = $('#civiliteGerant').val();
        let prenom = $('#prenomGerant').val();
        let nom = $('#nomGerant').val();
        let emailG = $('#emailGerant').val();
        let tel = $('#telGerant').val();
        let nomCompany = $('#nomCompany').val();
        let telCompany = $('#telCompany').val();
        let emailCompany = $('#emailCompany').val();
        let adresseCompany = $('#businessLine1').val() + " " + $('#businessPostalCode').val() + " " + $('#businessCity').val();
        console.log(nom);
        console.log(adresseCompany);
        console.log(emailG);

        if (idCommercialRDV != "0") {
            $(`#INFO_RDV${type}`).text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " + heureDebutRDV + " à " + heureFinRDV);
            $(`#divBtnSaveRV${type}`).removeAttr('hidden');
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureDebut').attr("value", heureDebutRDV);
            $('#heureFin').attr("value", heureFinRDV);
            $('#divPriseRvRT').removeAttr("hidden");
            $('#commentaireRV').html(`Infos Contact : ${civilite} ${prenom} ${nom} <br> Tel : ${tel} Email : ${emailG} <br><br> Infos Société : ${nomCompany} <br> Adresse : ${adresseCompany} <br> Tel : ${telCompany} Email : ${emailCompany} `);
        }
    });
}

// Fonction utilitaire pour convertir millisecondes en temps
function msToTime(duration) {
    var seconds = Math.floor((duration / 1000) % 60),
        minutes = Math.floor((duration / (1000 * 60)) % 60),
        hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

    hours = (hours < 10) ? "0" + hours : hours;
    minutes = (minutes < 10) ? "0" + minutes : minutes;

    return hours + ":" + minutes;
}
</script>

<!-- JavaScript code moved from main file -->
<script>
    if (typePage == "DSS") {
        nextBtn.classList.toggle("hidden", currentStep === 4);
        finishBtn.classList.toggle("hidden", currentStep !== 4);
    }

    if (typePage == "SD") {
        nextBtn.classList.toggle("hidden", currentStep === 9);
        finishBtn.classList.toggle("hidden", currentStep !== 9);
    }

    if (typePage == "RvRT") {
        nextBtn.classList.toggle("hidden", currentStep === 4);
        finishBtn.classList.toggle("hidden", currentStep !== 4);
    }

    if (typePage == "RvPerso") {
        nextBtn.classList.toggle("hidden", currentStep === 2);
        finishBtn.classList.toggle("hidden", currentStep !== 2);
    }

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = pageIndex; // ou un autre texte si tu veux
    });

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;

    currentStep = index;
    steps[currentStep].classList.add("active");
    updateButtons();
}

function goBackScript(type) {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    updateButtons();
}

function goNext(type) {
    if (type == "SD") {
        if (currentStep === 0) {
            const val = document.querySelector('input[name="siSignDeleg"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") return showStep(1);
            if (val.value === "non") {
                return showStep(9);
            }
            if (val.value == "plusTard") return showStep(8);
        }

        if (currentStep === 1) {
            if ($("#prenomSignataire").val() == "" || $("#nomSignataire").val() == "" || $("#dateNaissance").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 2) {
            if ($("#adresseImm").val() == "" || $("#cP").val() == "" || $("#ville").val() == "" || $("#etage").val() == "" || $("#porte").val() == "") {
                $("#msgError").text("Veuillez compléter les informations obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 3) {
            if ($("#nomCie").val() == "") {
                $("#msgError").text("Veuillez renseigner la compagnie d'assurance !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep === 4) {
            if ($("#numPolice").val() == "" || $("#dateDebutContrat").val() == "" || $("#dateFinContrat").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            }
        }

        if (currentStep == 5) {}

        if (currentStep == 6) {
            if ($("#emailSign").val() == "" || $("#telSign").val() == "") {
                $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                $('#errorOperation').modal('show');
                return;
            } else {
                onClickTerminerAssistant();
                return;
            }
        }

        if (currentStep === 7) {
            onClickValidSignature();
            return;
        }

        if (currentStep === 8) {
            const val = document.querySelector('input[name="raisonRefusSignature"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }

            if (val.value == "prefereDemander") {
                $(`#textClotureSD`).text("Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. Nous fixerons ensuite un rendez-vous pour finaliser ensemble, une fois votre échange réalisé");
            } else {
                if (val.value == "documentManquant") {
                    $(`#textClotureSD`).text("Oui effectivement, je note bien que certains documents vous manquent, c'est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement.");
                } else {
                    if (val.value == "signatureComplique") {
                        $(`#textClotureSD`).text("Je comprends parfaitement. Soyez rassuré(e), c'est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. ");
                    } else {
                        if (val.value == "prendreConnaissance") {
                            $(`#textClotureSD`).text("C'est tout à fait normal et même recommandé. Je vous propose de vous envoyer immédiatement la délégation par mail accompagnée d'une courte présentation de nos services pour que vous puissiez en prendre connaissance tranquillement. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, en toute sérénité.");
                        } else {

                        }
                    }
                }
            }
            return showStep(9)
        }
    }

    if (type == "RvRT") {
        if (currentStep === 0) {
            const val = document.querySelector('input[name="accordRVRT"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value === "oui") {
                this.getDisponiblites("");
                document.getElementById('textClotureRvRT').innerHTML = " Je vous remercie et vous souhaite une bonne fin de journée!";
                return showStep(1);
            }
            if (val.value === "non") {
                document.getElementById('textClotureRvRT').innerHTML = "Je comprends votre hésitation. Sachez simplement que le relevé technique réalisé par notre expert permet très souvent d'accélérer le traitement par votre assureur et facilite l'indemnisation rapide. Toutefois, je respecte votre décision et vous envoie immédiatement notre documentation par mail.<br>N'hésitez pas à revenir vers nous à tout moment si vous souhaitez avancer ensemble. Très bonne journée à vous !";
                $("#reponseDoc").removeAttr("hidden");
                $("#divEnvoiDoc").removeAttr("hidden");
                return showStep(4);
            }
        }
        if (currentStep === 3) {
            onClickEnregistrerRV("RTP")
            return;
        }
    }

    if (type == "RvPerso") {
        if (currentStep === 0) {
            this.getDisponiblites("Sup");
            return showStep(1);
        }
        if (currentStep === 1) {
            onClickEnregistrerRV("AT")
            return;
        }
    }

    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}

function finish(type) {
    if (type == 'DSS') {
        saveScriptPartiel('finDSS');
    } else {
        saveScriptPartiel('fin');
    }
}

updateButtons();

const refs = document.querySelectorAll('[ref]');
refs.forEach(ref => {
    ref.addEventListener('input', (e) => {
        refs.forEach(r => {
            if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                r.value = ref.value;
            }
        });
    });
});

function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

function changeDateTE() {
    if (document.getElementById('dateInconnu').checked) {
        $("#infosCom").removeAttr("hidden");
        $('#blockdateS').attr("hidden", "hidden");
        $("#dateS").val("");
        $("#timeS").val("");
    } else {
        $("#infosCom").attr("hidden", "hidden");
        $('#blockdateS').removeAttr("hidden");
        $("#dateConstat").val("");
        $("#anneeSurvenance").val("");
        $("#comDateInconnu").val("");
    }
}

function onClickChoixSignaturePT() {

}

function onClickCause(val, etat) {
    if (val.value == "Autre") {
        if (val.checked) {
            $(`#divAutreCause`).removeAttr('hidden');
        } else {
            $(`#divAutreCause`).attr('hidden', '');
        }
    }
}

function showBody(idAffiche) {
    getInfoMail()
    typePage = idAffiche;

    let div = "divBody" + idAffiche
    steps = document.querySelectorAll(".step" + idAffiche);
    prevBtn = document.getElementById("prevBtn" + idAffiche);
    nextBtn = document.getElementById("nextBtn" + idAffiche);
    finishBtn = document.getElementById("finishBtn" + idAffiche);
    indexPageDSS = document.getElementById('indexPage' + idAffiche);
    currentStep = 0;
    pageIndex = 1;
    numQuestionScript = 1;

    const divs = document.querySelectorAll('div[id^="divBody"]');
    divs.forEach(div => {
        div.setAttribute('hidden', '');
    });
    $('#' + div).removeAttr("hidden");
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
            to: $('#emailGerant').val(),
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
                console.log(response);
                saveScriptPartiel('fin');
                setTimeout(function() {
                    $('#successOperation').modal('hide');
                }, 1000);
            },
            error: function(response) {
                console.log(response);
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
    objetMail = `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    bodyMail = `<p style="text-align:justify">${`<?= "Madame, Monsieur," ?>`}<br><br>
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

onChangeTypeSin();

function onChangeTypeSin() {
    let id = "";
    const typeSinistre = document.getElementById('typeSinistre');
    let dommages = [];
    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts ?");
    if (typeSinistre.value == "autre") {
        dommages = [];
    } else {
        if (typeSinistre.value == "degatEaux") {
            $(`#textDommages`).text('Pouvez-vous me décrire les dommages liés aux dégats des eaux ?');
            dommages = ["Auréoles/taches visibles sur plafonds ou murs",
                "Cloques ou décollements de peinture ou de papier peint", "Parquet/plancher gondolé ou déformé",
                "Moquettes ou tapis détériorés ou tachés", "Mobilier gonflé, taché ou déformé",
                "Plinthes ou boiseries abîmées ou décollées",
                "Carrelage descellé ou joints abîmés",
                "Apparition de moisissures/champignons sur surfaces visibles",
                "Lambris ou revêtements décoratifs détériorés"
            ];
        } else {
            if (typeSinistre.value == "incendie") {
                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par l'incendie ?");
                dommages = ["Traces de fumée ou suie sur murs/plafonds",
                    "Mobilier partiellement brûlé nécessitant restauration",
                    "Sol (parquet, carrelage, moquette) brûlé ou taché",
                    "Portes/fenêtres déformées nécessitant remplacement",
                    "Revêtements muraux brûlés ou fortement salis",
                    "Façade extérieure noircie nécessitant nettoyage/peinture",
                    "Odeurs persistantes nécessitant traitement spécifique",
                    "Isolation intérieure détruite ou à remplacer", "Faux plafonds brûlés ou noircis à remplacer",
                    "Éléments décoratifs (rideaux, stores) endommagés"
                ];
            } else {
                if (typeSinistre.value == "brisGlace") {
                    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le bris de glace ?");
                    dommages = ["Vitrine commerciale endommagée", "Fenêtre ou baie vitrée endommagée",
                        "Porte vitrée brisée", "Miroir décoratif cassé",
                        "Verrière fissurée", "Cabine de douche brisée", "Mobilier vitré cassé",
                        "Étagère en verre cassée", "Plateau/table en verre fracturé",
                        "Garde-corps ou clôture en verre brisé"
                    ];
                } else {
                    if (typeSinistre.value == "vandalisme") {
                        $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vandalisme ?");
                        dommages = ["Murs ou vitrines tagués", "Dégradations portes/fenêtres",
                            "Dégradations mobilier urbain", "Dégradations équipements décoratifs",
                            "Enseigne commerciale taguée ou rayée", "Câbles coupés/endommagés",
                            "Sanitaires dégradés",
                            "Caméra surveillance détruite", "Clôtures/portails endommagés",
                            "Rideau métallique abîmé"
                        ];
                    } else {
                        if (typeSinistre.value == "evenementClimatique") {
                            $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par l'événment climatique ?");
                            dommages = [];
                        } else {
                            if (typeSinistre.value == "vol") {
                                $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vol ?");
                                dommages = ["Porte/fenêtre fracturée", "Serrure endommagée ou forcée",
                                    "Mobilier ou éléments décoratifs détériorés",
                                    "Systèmes de sécurité/alarme dégradés", "Coffre-fort endommagé",
                                    "Vitrine fracturée", "Volets ou rideaux endommagés",
                                    "Documents sensibles endommagés"
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    dommages.push("Autre");
    let html = "";
    const dommagesCoches = '<?= $questScript ? $questScript->dommages : '' ?>'
    const domArray = dommagesCoches.split(";");

    dommages.forEach(element => {
        let isFuiteChecked = domArray.includes(element);
        html += `<div class="col-md-6 col-sm-6 text-left">
                                                    <input onclick='onClickDommage(this)' ${isFuiteChecked ? 'checked' : ''} type="checkbox" value="${element}"
                                                        name="dommages[]" class="dommages" >
                                                    <label> ${element}</label>
                                                </div>`;
    });
    document.getElementById("option-content").innerHTML = html;
}

function onClickDommage(checkbox) {
    const valeur = checkbox.value;
    const estCoche = checkbox.checked;

    if (valeur == "Autre") {
        if (estCoche) {
            $(`#divAutreDommage`).removeAttr('hidden');
        } else {
            $(`#divAutreDommage`).attr('hidden', '');
        }
    }
}

function onChangeDateDebutContrat() {
    let deb = $('#dateDebutContrat').val();
    let date = new Date(deb);
    $('#dateFinContrat').attr("value", (date.getFullYear() + 1) + "-" + String(date.getMonth() + 1).padStart(2, '0') + "-" + String(date.getDate()).padStart(2, '0'));
}

function showSousQuestion(idSS, $show) {
    if ($show) {
        $(`#sous-question-${idSS}`).removeAttr('hidden');
    } else {
        $(`#sous-question-${idSS}`).attr('hidden', '');
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
    formData.append('signatureMail', $("#signatureMail").val());

    const dataObject = Object.fromEntries(formData.entries());
    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveScriptPartiel`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        beforeSend: function() {
            if (etape == 'fin' || etape == 'finDSS') {
                $("#msgLoading").text("Enregistrement en cours...");
                $("#loadingModal").modal("show");
            }
        },
        success: function(response) {
            if (etape == 'fin' || etape == 'finDSS') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("success");
            console.log(response);

            if (etape == 'fin' || etape == 'finDSS') {
                location.reload();
            }
        },
        error: function(response) {
            if (etape == 'fin' || etape == 'finDSS') {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);
            }
            console.log("error");
            console.log(response);
        },
        complete: function() {
            if (etape == 'fin' || etape == 'finDSS') {
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

function onClickTerminerAssistant() {
    $("#msgLoading").text("Enregistrement en cours...");
    $('#loadingModal').modal('show');

    console.log("CREER OP");
    console.log("send code");

    let emailSign = $('#emailSign').val();
    let telSign = $('#telSign').val()

    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    formData.append("connectedUser", `<?= json_encode($connectedUser) ?>`);
    const dataObject = Object.fromEntries(formData.entries());
    console.log(dataObject);

    $.ajax({
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveOPAndGenerateDeleg`,
        type: 'POST',
        dataType: "JSON",
        data: dataObject,
        success: function(response) {
            console.log("success");
            console.log(response);
            if (response != "0") {
                opCree = response;
            }
        },
        error: function(response) {
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 500);
            console.log(response);
            $('#errorOperation').modal('show');
        },
        complete: function() {
            if (opCree != null) {
                console.log("send code");
                $.ajax({
                    url: `<?= URLROOT ?>/public/json/signature.php?action=sendCodeSignature`,
                    type: 'POST',
                    data: {
                        idOp: opCree.idOpportunity,
                        idDoc: opCree.delegationDoc.idDocument,
                        nomDoc: opCree.delegationDoc.nomDocument,
                        urlDoc: opCree.delegationDoc.urlDocument,
                        civilite: formData.get('civiliteGerant'),
                        prenom: formData.get('prenomSignataire'),
                        nom: formData.get('nomSignataire'),
                        email: emailSign,
                        tel: telSign,
                        type: "Email",
                        commentaire: "",
                        idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                        numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                        login: "",
                        auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $("#msgLoading").text("Génération de code et envoi en cours...");
                        $("#loadingModal").modal("show");
                        console.log("Before Send");
                    },
                    success: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("success ok code");
                        console.log(response1);
                        if (response1 != null && response1 !== undefined && response1 != {}) {
                            signature = response1;
                            showStep(7)
                        } else {
                            $("#msgError").text("(1)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur");
                            $('#errorOperation').modal('show');
                        }
                    },
                    error: function(response1) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        console.log("ko");
                        console.log(response1);
                        $("#msgError").text("(2)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur");
                        $('#errorOperation').modal('show');
                    },
                    complete: function() {},
                });
            }
        },
    });
}

function onClickValidSignature() {
    let codeSaisi = $('#codeSign').val();
    let email = $('#emailSign').val();
    let tel = $('#telSign').val();
    let type = 'Email';
    if (signature != null) {
        if (signature.code != codeSaisi) {
            $("#msgError").text("Code erroné !!!");
            $('#errorOperation').modal('show');
        } else {
            $.ajax({
                url: `<?= URLROOT ?>/public/json/signature.php?action=signDocument`,
                type: 'POST',
                data: {
                    idOp: opCree.idOpportunity,
                    idDoc: opCree.delegationDoc.idDocument,
                    nomDoc: opCree.delegationDoc.nomDocument,
                    urlDoc: opCree.delegationDoc.urlDocument,
                    createDate: `<?= $createDate ?>`,
                    civilite: $('#civiliteGerant').val(),
                    prenom: $('#prenomGerant').val(),
                    nom: $('#nomGerant').val(),
                    idContact: '',
                    numeroContact: '',
                    email: email,
                    tel: tel,
                    type: type,
                    commentaire: "",
                    idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                    numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                    login: "",
                    auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`,
                    signature: signature,
                    typeDocument: 'delegation'
                },
                dataType: "JSON",
                beforeSend: function() {
                    $("#msgLoading").text("Signature en cours...");
                    $("#loadingModal").modal("show");
                },
                success: function(response) {
                    console.log("success");
                    console.log(response);
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    if (response != null && response != "" && response == "1") {
                        $("#msgSuccess").text("Délégation de gestion signée avec succés !");
                        $('#successOperation').modal('show');
                        showStep(9);
                    } else {
                        $("#msgError").text("(1)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(response) {
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500);
                    console.log("ko");
                    console.log(response);
                    $("#msgError").text("(2)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
                    $('#errorOperation').modal('show');
                },
                complete: function() {},
            });
        }
    } else {
        $("#msgError").text("(3)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
        $('#errorOperation').modal('show');
    }
}

function onClickDeclareSinistre(params) {
    if (params == "oui") {
        $('#divNumSinistre').removeAttr("hidden");
    } else {
        $('#divNumSinistre').attr("hidden", "hidden");
    }
}

function AddOrEditCie() {
    let checkCie = $('.oneselectionCie:checkbox:checked').val().split(';')[0];
    console.log(checkCie)
    $.ajax({
        url: `<?= URLROOT ?>/public/json/company.php?action=find&id=${checkCie}`,
        type: 'GET',
        dataType: "JSON",
        success: function(response) {
            console.log("success");
            $('#idCie').attr("value", response.idCompany);
            $('#numeroCie').attr("value", response.numeroCompany);
            $('#nomCie').attr("value", response.name);
            $('#adresseCie').attr("value", response.businessLine1);
            $('#villeCie').attr("value", response.businessCity);
            $('#codePostalCie').attr("value", response.businessPostalCode);
            $('#telCie').attr("value", response.businessPhone);
            $('#emailCie').attr("value", response.email);
            $("#selectCompany").modal("hide");
            $("#btnAddCie").attr("onclick", "showModalCie('edit')");
            $("#iconeAddCie").attr("class", "fas fa-edit");
            $('#divInfosCie').removeAttr("hidden");
            $('#divInfosPasCie').attr("hidden", "hidden");
            $('#selectCompany').modal('hide');
        },
        error: function(response) {
            console.log(response);
            $('#selectCompany').modal('hide');
            $("#msgError").text("Erreur de choisir une compagnie");
            $('#errorOperation').modal('show');
        },
        complete: function() {

        },
    });
}

function showModalCie(action) {
    if (action == "edit") {
        $("#action").attr("value", "edit");
    } else {
        $("#action").attr("value", "add");
    }
    $("#selectCompany").modal("show");
}

// Variables pour RV RT
let tab = [];
let taille = 0;
let iColor = 0;
let nbPage = 0;
let nbPageTotal = 0;
let k = 0;
let nbDispo = 0;
let horaires = [];
let nTaille = 0;
let commercialRDV = "";
let dateRDV = "";
let heureDebutRDV = "";
let heureFinRDV = "";
let idCommercialRDV = "0";

function getDisponiblites(type) {
    let post = {
        adresseRV: $('#adresseImm').val(),
        codePostal: $('#cP').val(),
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        dateRV: "",
        heureRV: "",
        source: "wbcc"
    }
    let action = "getDisponibilitesExpert";
    if (type == 'Sup') {
        action = "getDisponibilitesSansContrainte";
    }
    $.ajax({
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=${action}`,
        type: 'POST',
        data: JSON.stringify(post),
        dataType: "JSON",
        beforeSend: function() {

        },
        success: function(result) {
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            console.log('result dispos');
            console.log(result);
            $('#btnRvRT').attr("hidden", "hidden");
            if (result !== null && result != undefined) {
                if (result.length == 0) {
                    $('#notDisponibilite').removeAttr("hidden");
                } else {
                    tab = result;
                    taille = tab.length;
                    nbPageTotal = Math.ceil(tab.length / 10);
                    nbPage++;
                    afficheBy10InTable(type);
                    $('#divPriseRvRT2').removeAttr("hidden");
                    if (nbPage == 1) {
                        $('#btnPrecedentRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnPrecedentRDV').removeAttr("hidden");
                    }
                    if (nbPage == nbPageTotal) {
                        $('#btnSuivantRDV').attr("hidden", "hidden");
                    } else {
                        $('#btnSuivantRDV').removeAttr("hidden");
                    }
                }
            } else {
                $('#divChargementDisponibilite').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite').removeAttr("hidden");
            }
        },
        error: function(response) {
            $('#btnRvRT').removeAttr("hidden");
            $('#divPriseRvRT2').attr("hidden", "hidden");
            $('#divPriseRvRT').attr("hidden", "hidden");
            setTimeout(() => {
                $("#loadingModal").modal("hide");
            }, 1000);
            console.log("Erreur")
            console.log(response)
            $('#divChargementDisponibilite').attr("hidden", "hidden");
            $('#divChargementNotDisponibilite').removeAttr("hidden");
        }
    });
}

function onClickEnregistrerRV(type) {
    let expert = $('#expertRV').val();
    let idExpert = $('#idExpertRV').val();
    let idContact = $('#idContactRV').val();
    let date = $('#dateRV').val();
    let heureD = $('#heureDebut').val();
    let heureF = $('#heureFin').val();
    let adresse = $('#adresseImm').val() + " " + $("#businessPostalCode").val() + " " + $("#businessCity").val();
    let commentaire = $('#commentaireRV').html();
    if (idExpert != "0" && date != "" && heureD != "" && adresse != "") {
        let post = [];
        post[0] = {
            idOpportunityF: type == "AT" ? "" : (opCree != null ? opCree.idOpportunity : null),
            numeroOP: type == "AT" ? "" : (opCree != null ? opCree.name : ''),
            expert: expert,
            idExpert: idExpert,
            idContact: type == "AT" ? "" : (opCree != null ? opCree.idContactClient : idContact),
            idContactGuidF: "",
            dateRV: date,
            heureDebut: heureD,
            heureFin: heureF,
            adresseRV: adresse,
            etage: $('#etage').val(),
            porte: $('#porte').val(),
            lot: $('#lot').val(),
            batiment: $('#batiment').val(),
            conclusion: commentaire,
            idUtilisateur: $('#idUtilisateur').val(),
            numeroAuteur: $('#numeroAuteur').val(),
            auteur: $('#auteur').val(),
            idRVGuid: "",
            idRV: "0",
            idAppGuid: "",
            idAppExtra: type == "AT" ? "" : (opCree != null && opCree.app ? opCree.app.idApp : ''),
            idAppConF: type == "AT" ? "" : (opCree != null && opCree.appCon != false ? opCree.appCon.idAppCon : ''),
            nomDO: type == "AT" ? "" : (opCree != null ? opCree.contactClient : ''),
            moyenTechnique: "",
            idCampagneF: "",
            typeRV: type != "AT" ? "RTP" : type,
            cote: "",
            libellePartieCommune: "",
            typeLot: ""
        }

        $.ajax({
            url: `<?= URLROOT ?>/public/json/rendezVous.php?action=saveRVRT&sourceEnreg=interne`,
            type: 'POST',
            data: JSON.stringify(post),
            dataType: "JSON",
            beforeSend: function() {
                $("#msgLoading").text("Validation de RDV RT en cours...");
                $("#loadingModal").modal("show");
            },
            success: function(response) {
                console.log("success");
                console.log(response);
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500)
                if (response != "0") {
                    if (response == "2") {
                        $("#msgError").text("Cette disponibilité est invalide, veuillez choisir une autre !");
                        $('#errorOperation').modal('show');
                    } else {
                        $('#divPriseRvRT').attr("hidden", "hidden");
                        $('#btnRvRT').attr("hidden", "hidden");
                        $("#msgSuccess").text("Rendez-vous RT pris avec succés !");
                        $('#successOperation').modal('show');
                        if (type == "AT") {
                            showStep(2)
                        } else {
                            showStep(4)
                        }
                    }
                } else {
                    $("#msgError").text("(1)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
                    $('#errorOperation').modal('show');
                }
            },
            error: function(response) {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500)
                console.log(response);
                $("#msgError").text("(2)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
                $('#errorOperation').modal('show');
            },
            complete: function() {
                $("#loadingModal").modal("hide");
            },
        });
    } else {
        setTimeout(() => {
            $("#loadingModal").modal("hide");
        }, 500)
        $("#msgError").text("Veuillez remplir tous les champs !");
        $('#errorOperation').modal('show');
    }
}

function onClickSuivantRDV(type) {
    if (nbPage >= nbPageTotal) {
        alert("Plus de disponibiltés! veuillez forcer");
    } else {
        nbPage++;
        afficheBy10InTable(type);
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function onClickPrecedentRDV(type) {
    if (nbPage != 1) {
        iColor = ((nbPage - 1) * 2) - 2;
        nbPage--;
        k = k - nbDispo - 10;
        afficheBy10InTable(type);
    }
    if (nbPage == 1) {
        $('#btnPrecedentRDV').attr("hidden", "hidden");
    } else {
        $('#btnPrecedentRDV').removeAttr("hidden");
    }
    if (nbPage == nbPageTotal) {
        $('#btnSuivantRDV').attr("hidden", "hidden");
    } else {
        $('#btnSuivantRDV').removeAttr("hidden");
    }
}

function afficheBy10InTable(type) {
    var test = 0;
    var kD = k;
    first = k;
    console.log(`#divTabDisponibilite${type}`);

    $(`#divTabDisponibilite${type}`).empty();
    var html = `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
    if (tab.length != 0) {
        for (var i = 0; i < 2; i++) {
            html += `<tr class="tr">`;
            for (var j = 0; j < 5; j++) {
                html += `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
                k++;
                test++;
                if (k == taille || test > 10 || k == 50) {
                    if (j == 5)
                        iColor++;
                    break;
                }
            }

            html += `</tr>`;
            if (k == taille || test > 10 || k == 50) {
                if (j != 5 && i == 2)
                    iColor++;
                break;
            }
            iColor++;
        }
    }
    html += `</table>`;
    $(`#divTabDisponibilite${type}`).append(html);
    nbDispo = k - kD;

    $(".tdClass").click(function() {
        $(`#INFO_RDV${type}`).text("");
        $('#divPriseRvRT').attr("hidden", "hidden");
        $('#expertRV').attr("value", "");
        $('#idExpertRV').attr("value", "0");
        $('#dateRV').attr("value", "");
        $('#heureRV').attr("value", "");
        $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
        $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
        var item = $(this).closest("td").html();
        let nomCommercial = item.split("<br>")[0];
        let DATE_RV = item.split("<br>")[1];
        let HEURE_D = item.split("<br>")[2].split("-")[0];
        let HEURE_F = item.split("<br>")[2].split("-")[1];
        idCommercialRDV = item.split("<br>")[3].split("-")[1];
        let marge = item.split("<br>")[3].split("-")[2];
        let DUREE = item.split("<br>")[3].split("-")[3];
        heure = Number(HEURE_D.split(":")[0].trim());
        min = Number(HEURE_D.split(":")[1].trim());
        secondHD = (heure * 3600 + min * 60) * 1000;
        heure = Number(HEURE_F.split(":")[0].trim());
        min = HEURE_F.split(":")[1].trim();
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

        afficheNewTable(nomCommercial, DATE_RV, DUREE, type);
    });
}

function afficheNewTable(nomCommercial, date, duree, type = "") {
    $(`#divTabHoraire${type}`).empty();
    var html = `<div class="font-weight-bold">
                                        <span class="text-center text-danger">2. Veuillez selectionner l'heure de disponibilité</span>
                                    </div>
                <table style="font-weight:bold; font-size:15px; margin-top : 20px" id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="${nTaille}">DISPONIBLITES DE ${nomCommercial} à la date du ${date}</th></tr>`;
    html += `<tr class="ntr" style="background-color: lightgray">`;
    for (var i = 0; i < nTaille; i++) {
        html += `<td class="ntdClass"  align="center" id="cel${i}" value="${i}"> ${horaires[i]} </td>`;
    }
    html += `</tr>`;
    html += `</table>`;
    $(`#divTabHoraire${type}`).append(html);

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

        let civilite = $('#civiliteGerant').val();
        let prenom = $('#prenomGerant').val();
        let nom = $('#nomGerant').val();
        let emailG = $('#emailGerant').val();
        let tel = $('#telGerant').val();
        let nomCompany = $('#nomCompany').val();
        let telCompany = $('#telCompany').val();
        let emailCompany = $('#emailCompany').val();
        let adresseCompany = $('#businessLine1').val() + " " + $('#businessPostalCode').val() + " " + $('#businessCity').val();
        console.log(nom);
        console.log(adresseCompany);
        console.log(emailG);

        if (idCommercialRDV != "0") {
            $(`#INFO_RDV${type}`).text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " + heureDebutRDV + " à " + heureFinRDV);
            $(`#divBtnSaveRV${type}`).removeAttr('hidden');
            $('#expertRV').attr("value", commercialRDV);
            $('#idExpertRV').attr("value", idCommercialRDV);
            $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
            $('#heureDebut').attr("value", heureDebutRDV);
            $('#heureFin').attr("value", heureFinRDV);
            $('#divPriseRvRT').removeAttr("hidden");
            $('#commentaireRV').html(`Infos Contact : ${civilite} ${prenom} ${nom} <br> Tel : ${tel} Email : ${emailG} <br><br> Infos Société : ${nomCompany} <br> Adresse : ${adresseCompany} <br> Tel : ${telCompany} Email : ${emailCompany} `);
        }
    });
}
</script>
