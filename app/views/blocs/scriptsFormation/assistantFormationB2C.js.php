<script>
// ================== ASSISTANT DE FORMATION B2C ==================
// Configuration des variables d'étapes et navigation
const steps = document.querySelectorAll(".step");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const finishBtn = document.getElementById("finishBtn");
const indexPage = document.getElementById('indexPage');
let currentStep = 0;
let pageIndex = 1;
let numQuestionScript = 1;
const history = [];
let opCree = null;
let signature = null;
$(`#numQuestionScript0`).text(1);
let siInterlocuteur = false;
const refs = document.querySelectorAll('[ref]');

// Variables pour RDV
var rdv1Exst = true;
var divRDV1 = '';
var rdv1Position1 = 0;
var hidePlaceRdv1 = true, hidePlaceRdvbis = true;
var hidePlaceRdv2 = true, hidePlaceRdv2bis = true;

// ASSISTANT TE
let numPageTE = 0;
let nbPageTE = 4;

// ASSISTANT SIGNATURE
let numPageSign = 0;
let nbPageSign = 7;

// ASSISTANT RV
let numPageRV = 0;
let nbPageRV = 4;

// Gestion des références synchronisées
refs.forEach(ref => {
    ref.addEventListener('input', (e) => {
        //update all other ref value
        refs.forEach(r => {
            if (r.id != ref.id && ref.getAttribute('ref') === r.getAttribute('ref')) {
                r.value = ref.value;
            }
        });
    });
});

// Fonction pour sélectionner un radio button
function selectRadio(button) {
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}

// ================== GESTION DES ÉTAPES ==================
function updateButtons() {
    indexPage.innerText = pageIndex;
    prevBtn.classList.toggle("hidden", currentStep === 0);
    nextBtn.classList.toggle("hidden", (currentStep == 30 || currentStep == 36));
    finishBtn.classList.toggle("hidden", (currentStep != 30 && currentStep != 36));

    const spans = document.querySelectorAll('span[name="numQuestionScript"]');
    spans.forEach((span, index) => {
        span.textContent = numQuestionScript;
    });
}

function showStep(index) {
    saveScriptPartiel('parcours');
    steps[currentStep].classList.remove("active");
    history.push(currentStep);
    pageIndex++;
    currentStep = index;
    steps[currentStep].classList.add("active");

    if (currentStep == 4) {
        numQuestionScript++;
    } else if (currentStep == 6) {
        numQuestionScript++;
    } else if (currentStep == 7) {
        numQuestionScript++;
    } else if (currentStep == 8) {
        numQuestionScript++;
    } else if (currentStep == 9) {
        numQuestionScript++;
    } else if (currentStep == 10) {
        numQuestionScript++;
    } else if (currentStep == 11) {
        numQuestionScript++;
    } else if (currentStep == 20) {
        numQuestionScript++;
    } else if (currentStep == 21) {
        numQuestionScript++;
    } else if (currentStep == 22) {
        numQuestionScript++;
    } else if (currentStep == 23) {
        numQuestionScript++;
    } else if (currentStep == 25) {
        numQuestionScript++;
    } else if (currentStep == 24) {
        numQuestionScript++;
    } else if (currentStep == 5) {
        numQuestionScript++;
    } else if (currentStep == 26) {
        numQuestionScript++;
    }
    updateButtons();
}

function goBackScript() {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");

    if (currentStep == 3) {
        numQuestionScript--;
    }
    if (currentStep == 4) {
        numQuestionScript--;
    } else if (currentStep == 6) {
        numQuestionScript--;
    } else if (currentStep == 7) {
        numQuestionScript--;
    } else if (currentStep == 8) {
        numQuestionScript--;
    } else if (currentStep == 9) {
        numQuestionScript--;
    } else if (currentStep == 10) {
        numQuestionScript--;
    } else if (currentStep == 11) {
        numQuestionScript--;
    } else if (currentStep == 20) {
        numQuestionScript--;
    } else if (currentStep == 21) {
        numQuestionScript--;
    } else if (currentStep == 22) {
        numQuestionScript--;
    } else if (currentStep == 24) {
        numQuestionScript--;
    }
    updateButtons();
}

// ================== SAUVEGARDE ==================
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
        url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveScriptPartiel`,
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

function finish() {
    saveScriptPartiel('fin');
}

// Initialisation
updateButtons();
</script>
