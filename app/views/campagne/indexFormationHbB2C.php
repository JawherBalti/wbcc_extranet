<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;

// Initialisation des variables si elles n'existent pas
$gerant = $gerant ?? null;
$questScript = $questScript ?? null;

function checked($field, $value, $object, $action)
{
    return $object && isset($object->$field) && $object->$field == $value ? $action : '';
}

// Variables pour les blocs partagés
$imgUrl = '/public/img/logo_Assurance_HB.png';
$titre = 'Campagne formation B2C ASSURANCE HB';
$icon = '<i class="fas fa-fw fa-users" style="color: #0066cc;"></i>';

?>

<!-- Include des blocs partagés -->
<?php
// Inclusion des styles
include_once dirname(__FILE__) . '/blocs/stylesFormation.php';
?>

<!-- Include des modals -->
<?php
include_once dirname(__FILE__) . '/blocs/modalsFormation.php';
include_once dirname(__FILE__) . '/../crm/blocs/boitesModal.php';
?>

<input type="hidden" id="contextType" value="<?= 'individual' ?>">

<div class="col-12">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <!-- Include du bloc titre -->
            <?php
                $imgUrl = '/public/img/logo_Assurance_HB.png';
                $titre = 'Campagne formation B2C ASSURANCE HB -';
                $icon = '<i class="fas fa-fw fa-users" style="color: #0066cc;"></i>';

                include_once dirname(__FILE__) .'/blocs/titre.php';
            ?>

            <!-- Include du bloc formulaire particulier -->
            <?php
                // Set the variables before including
                $company = $company ?? null; // Your company data object or null for empty form
                $options = [
                    'showStatus' => true, // Show the status field
                    'showWhatsApp' => false, // Hide WhatsApp button
                    'isB2C' => true // Indicate this is B2C
                ];

                include_once dirname(__FILE__) . '/blocs/formHbB2C.php';
            ?>
            
            <div class="script-container" style="margin-top:15px; padding:10px">
                <form id="scriptForm">
                    <input hidden id="contextId" name="idContact"
                        value="<?= $gerant ? $gerant->idContact : 0 ?>">

                    <!-- Étape 0 : Présentation B2C -->
                    <div class="step active">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez chaleureux et rassurant dans votre approche.<br><br></li>
                                                <li>• Créez un climat de confiance dès les premiers mots.<br><br></li>
                                                <li>• Montrez que vous vous intéressez à leur situation personnelle.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Bonjour <?= $gerant ? "<b style='color: blue;'>{$gerant->civiliteContact} {$gerant->nomContact}</b>" : "Madame/Monsieur" ?>, 
                                        je suis <b><?= $connectedUser->fullName ?></b>, conseiller en assurance chez <b>HB Assurance</b>.<br><br>
                                        Je vous contacte aujourd'hui car nous proposons des solutions d'assurance 
                                        spécialement adaptées aux particuliers de votre région.<br><br>
                                        Avez-vous quelques minutes pour que je vous présente brièvement nos services ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickDisponibilite('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="disponibilite" class="btn-check" value="oui" />
                                    </div>
                                    Oui, j'ai quelques minutes
                                </button>
                                <button onclick="selectRadio(this); onClickDisponibilite('pas_maintenant');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="disponibilite" class="btn-check" value="pas_maintenant" />
                                    </div>
                                    Pas maintenant
                                </button>
                                <button onclick="selectRadio(this); onClickDisponibilite('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="disponibilite" class="btn-check" value="non" />
                                    </div>
                                    Non, pas intéressé
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 1 : Qualification assurance habitation -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Commencez par les besoins essentiels (habitation).<br><br></li>
                                                <li>• Écoutez attentivement les réponses pour identifier les opportunités.<br><br></li>
                                                <li>• Restez dans un ton conseil et non commercial.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Parfait ! Pour mieux vous conseiller, j'aimerais d'abord connaître votre situation actuelle.<br><br>
                                        Concernant votre logement, êtes-vous propriétaire ou locataire ? 
                                        Et disposez-vous actuellement d'une assurance habitation ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickLogement('proprietaire_assure');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="logement" class="btn-check" value="proprietaire_assure" />
                                    </div>
                                    Propriétaire avec assurance
                                </button>
                                <button onclick="selectRadio(this); onClickLogement('proprietaire_non_assure');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="logement" class="btn-check" value="proprietaire_non_assure" />
                                    </div>
                                    Propriétaire sans assurance
                                </button>
                                <button onclick="selectRadio(this); onClickLogement('locataire_assure');" type="button"
                                    class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" name="logement" class="btn-check" value="locataire_assure" />
                                    </div>
                                    Locataire avec assurance
                                </button>
                                <button onclick="selectRadio(this); onClickLogement('locataire_non_assure');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="logement" class="btn-check" value="locataire_non_assure" />
                                    </div>
                                    Locataire sans assurance
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2 : Qualification assurance auto -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Identifiez le nombre de véhicules et le type de couverture.<br><br></li>
                                                <li>• Posez des questions sur leur satisfaction actuelle.<br><br></li>
                                                <li>• Notez les informations pour personnaliser la suite.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Très bien. Et concernant vos véhicules, combien de voitures avez-vous dans votre foyer ?<br><br>
                                        Êtes-vous satisfait de votre assurance auto actuelle, notamment au niveau des tarifs et des garanties ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickVehicules('1_satisfait');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="vehicules" class="btn-check" value="1_satisfait" />
                                    </div>
                                    1 véhicule, satisfait
                                </button>
                                <button onclick="selectRadio(this); onClickVehicules('1_insatisfait');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="vehicules" class="btn-check" value="1_insatisfait" />
                                    </div>
                                    1 véhicule, insatisfait
                                </button>
                                <button onclick="selectRadio(this); onClickVehicules('plusieurs_satisfait');" type="button"
                                    class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" name="vehicules" class="btn-check" value="plusieurs_satisfait" />
                                    </div>
                                    Plusieurs véhicules, satisfait
                                </button>
                                <button onclick="selectRadio(this); onClickVehicules('plusieurs_insatisfait');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="vehicules" class="btn-check" value="plusieurs_insatisfait" />
                                    </div>
                                    Plusieurs véhicules, insatisfait
                                </button>
                                <button onclick="selectRadio(this); onClickVehicules('aucun');" type="button"
                                    class="option-button btn btn-secondary">
                                    <div class="option-circle">
                                        <input type="radio" name="vehicules" class="btn-check" value="aucun" />
                                    </div>
                                    Aucun véhicule
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3 : Besoins complémentaires -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Explorez les besoins en assurance complémentaire.<br><br></li>
                                                <li>• Identifiez les préoccupations liées à la famille et aux loisirs.<br><br></li>
                                                <li>• Préparez l'argumentation selon leurs priorités.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        D'accord. Maintenant, concernant votre famille et vos biens, qu'est-ce qui vous préoccupe le plus ?<br><br>
                                        La protection de vos proches (santé, prévoyance), la sécurité de vos biens de valeur, 
                                        ou plutôt la couverture de vos loisirs (vélo, équipements sportifs) ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickBesoins('famille');" type="button"
                                    class="option-button btn btn-primary">
                                    <div class="option-circle">
                                        <input type="radio" name="besoins" class="btn-check" value="famille" />
                                    </div>
                                    Protection de la famille
                                </button>
                                <button onclick="selectRadio(this); onClickBesoins('biens');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="besoins" class="btn-check" value="biens" />
                                    </div>
                                    Sécurité des biens
                                </button>
                                <button onclick="selectRadio(this); onClickBesoins('loisirs');" type="button"
                                    class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" name="besoins" class="btn-check" value="loisirs" />
                                    </div>
                                    Couverture des loisirs
                                </button>
                                <button onclick="selectRadio(this); onClickBesoins('tout');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="besoins" class="btn-check" value="tout" />
                                    </div>
                                    Tout m'intéresse
                                </button>
                                <button onclick="selectRadio(this); onClickBesoins('aucun');" type="button"
                                    class="option-button btn btn-secondary">
                                    <div class="option-circle">
                                        <input type="radio" name="besoins" class="btn-check" value="aucun" />
                                    </div>
                                    Rien de particulier
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 4 : Proposition personnalisée -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Adaptez votre proposition aux réponses précédentes.<br><br></li>
                                                <li>• Mettez en avant les économies potentielles.<br><br></li>
                                                <li>• Créez de l'intérêt pour un bilan personnalisé.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Parfait ! En fonction de votre profil, je pense que nous pourrions vous proposer 
                                        des solutions vraiment intéressantes chez HB Assurance.<br><br>
                                        Nous avons notamment des formules qui permettent de regrouper plusieurs assurances 
                                        avec des tarifs préférentiels. Souvent, nos clients économisent entre 15% et 30% 
                                        sur leur budget assurance annuel.<br><br>
                                        Seriez-vous intéressé par un bilan gratuit de vos assurances actuelles ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickBilan('tres_interesse');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="bilan" class="btn-check" value="tres_interesse" />
                                    </div>
                                    Oui, très intéressé
                                </button>
                                <button onclick="selectRadio(this); onClickBilan('interesse');" type="button"
                                    class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" name="bilan" class="btn-check" value="interesse" />
                                    </div>
                                    Ça m'intéresse
                                </button>
                                <button onclick="selectRadio(this); onClickBilan('hesite');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="bilan" class="btn-check" value="hesite" />
                                    </div>
                                    J'hésite, dites-moi en plus
                                </button>
                                <button onclick="selectRadio(this); onClickBilan('pas_interesse');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="bilan" class="btn-check" value="pas_interesse" />
                                    </div>
                                    Non, pas intéressé
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 5 : Prise de rendez-vous -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Proposez des créneaux flexibles et adaptés.<br><br></li>
                                                <li>• Rassurez sur la gratuité et l'absence d'engagement.<br><br></li>
                                                <li>• Confirmez la valeur du rendez-vous.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Excellent ! Pour ce bilan personnalisé, je peux me déplacer chez vous 
                                        ou nous pouvons nous rencontrer dans nos locaux, selon votre préférence.<br><br>
                                        C'est un service gratuit et sans aucun engagement de votre part. 
                                        Cela prend environ 30 minutes.<br><br>
                                        Seriez-vous disponible en fin de semaine ou préférez-vous la semaine prochaine ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickRdvB2C('fin_semaine');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" name="rdv" class="btn-check" value="fin_semaine" />
                                    </div>
                                    Fin de semaine
                                </button>
                                <button onclick="selectRadio(this); onClickRdvB2C('semaine_prochaine');" type="button"
                                    class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" name="rdv" class="btn-check" value="semaine_prochaine" />
                                    </div>
                                    Semaine prochaine
                                </button>
                                <button onclick="selectRadio(this); onClickRdvB2C('autre_moment');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="rdv" class="btn-check" value="autre_moment" />
                                    </div>
                                    Un autre moment
                                </button>
                                <button onclick="selectRadio(this); onClickRdvB2C('pas_de_rdv');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="rdv" class="btn-check" value="pas_de_rdv" />
                                    </div>
                                    Pas de rendez-vous
                                </button>
                            </div>
                        </div>

                        <!-- Bloc de planification RDV B2C -->
                        <div class="response-options" id="rdv-planning-b2c" hidden>
                            <div class="options-container col-md-11">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="rdvDateB2C">Date souhaitée :</label>
                                        <input type="date" class="form-control" name="rdvDateB2C" id="rdvDateB2C">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="rdvTimeB2C">Heure souhaitée :</label>
                                        <input type="time" class="form-control" name="rdvTimeB2C" id="rdvTimeB2C">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="rdvLieu">Lieu de rendez-vous :</label>
                                        <select class="form-control" name="rdvLieu" id="rdvLieu">
                                            <option value="">--Choisir--</option>
                                            <option value="domicile">À mon domicile</option>
                                            <option value="agence">En agence</option>
                                            <option value="autre">Autre lieu</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="rdvNotesB2C">Remarques :</label>
                                        <textarea class="form-control" name="rdvNotesB2C" id="rdvNotesB2C" 
                                                  rows="3" placeholder="Remarques particulières, adresse si autre lieu..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape finale : Conclusion B2C -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Récapitulez chaleureusement l'échange.<br><br></li>
                                                <li>• Rassurez une dernière fois sur la gratuité.<br><br></li>
                                                <li>• Terminez sur une note positive et personnelle.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <p class="text-justify">
                                        Parfait ! Je vous remercie pour cet échange très agréable.<br><br>
                                        Je récapitule : nous nous rencontrons pour faire un bilan complet de vos assurances 
                                        et voir comment HB Assurance peut vous accompagner dans la protection de votre famille 
                                        et de vos biens.<br><br>
                                        Je vous enverrai un SMS de confirmation avec tous les détails du rendez-vous.<br><br>
                                        Avez-vous des questions avant que nous nous quittions ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="form-group">
                                    <label for="remarquesFinalesB2C">Questions/Remarques finales du prospect :</label>
                                    <textarea class="form-control" name="remarquesFinalesB2C" id="remarquesFinalesB2C" 
                                              rows="3" placeholder="Notez ici les dernières questions ou remarques..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            
            <!-- Include de la navigation pour formation -->
            <?php 
            $section = 'Formation';
            include_once dirname(__FILE__) . '/blocs/navigationFormation.php'; 
            ?>
            
        </div>

        <!-- Include de la sidebar pour formation -->
        <?php include_once dirname(__FILE__) . '/blocs/sidebarFormation.php'; ?>
    </div>
</div>

<?php
// Inclusion des scripts modulaires pour la formation HB B2C
include_once dirname(__FILE__) . '/blocs/scriptsFormation/variablesGlobales.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/tooltips.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/navigationEtapes.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/rdv.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/ajaxRegions.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/emailDocumentation.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/gestionNotes.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/utilitaires.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/gestionRdv.js.php';
include_once dirname(__FILE__) . '/blocs/scriptsFormation/assistantsSignature.js.php';
?>

<?php
include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>

<script>
// Fonctions spécifiques pour le script HB Assurance B2C
function onClickDisponibilite(value) {
    console.log('Disponibilité:', value);
    // Logique selon la disponibilité exprimée
}

function onClickLogement(value) {
    console.log('Situation logement:', value);
    // Adapter l'argumentaire selon la situation de logement
}

function onClickVehicules(value) {
    console.log('Situation véhicules:', value);
    // Logique selon le nombre et la satisfaction des véhicules
}

function onClickBesoins(value) {
    console.log('Besoins exprimés:', value);
    // Adapter l'argumentaire selon les besoins identifiés
}

function onClickBilan(value) {
    console.log('Intérêt bilan:', value);
    // Logique selon l'intérêt pour le bilan
}

function onClickRdvB2C(value) {
    const rdvPlanning = document.getElementById('rdv-planning-b2c');
    if (value === 'autre_moment') {
        rdvPlanning.hidden = false;
    } else {
        rdvPlanning.hidden = true;
    }
    console.log('RDV B2C:', value);
}

function selectRadio(button) {
    // Désélectionner tous les boutons du même groupe
    const container = button.closest('.options-container');
    const buttons = container.querySelectorAll('.option-button');
    buttons.forEach(btn => btn.classList.remove('selected'));
    
    // Sélectionner le bouton cliqué
    button.classList.add('selected');
    
    // Cocher le radio correspondant
    const radio = button.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }
}
</script>
