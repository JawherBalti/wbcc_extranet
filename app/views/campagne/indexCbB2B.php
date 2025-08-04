<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;
$isConsigneHidden = false;

$rt = false;
function checked($field, $value, $object, $action)
{
    return $object && isset($object->$field) && $object->$field == $value ? $action : '';
}
?>

<style>
    .stepAccueil,
    .stepIndisponibelRappel,
    .stepPartenaireExistant,
    .stepQuelAvantages,
    .stepPasDetemps,
    .stepMefianceInconnu,
    .stepPresentationPartenariat,
    .stepMessageFin,
    .MessageFinRDVRelance,
    .stepDSS,
    .stepSD,
    .stepRvRT,
    .stepRvPerso {
        display: none;
    }

    .stepAccueil.active,
    .stepIndisponibelRappel.active,
    .stepPartenaireExistant.active,
    .stepQuelAvantages.active,
    .stepPasDetemps.active,
    .stepMefianceInconnu.active,
    .stepPresentationPartenariat.active,
    .stepMessageFin.active,
    .MessageFinRDVRelance.active,
    .stepDSS.active,
    .stepSD.active,
    .stepRvRT.active,
    .stepRvPerso.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        font-size: 16px;
    }

    .btn-prev {
        background-color: rgb(78, 123, 172);
        color: #ffffff;
    }

    .btn-next {
        background-color: #007BFF;
        color: white;
    }

    .btn-finish {
        background-color: green;
        color: white;
    }

    .hidden {
        display: none;
    }


    #sinistreForm {
        font-size: 18px;
    }

    /******************** */

    .tooltip-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .tooltip-content {
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #D3D3D3;
        border: 2px solid #36b9cc;
        color: black;
        padding: 16px 20px;
        border-radius: 8px;
        z-index: 1000;
        min-width: 500px;
        max-width: 500px;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        text-align: left;
        display: none;

        scrollbar-width: none;
        /* Firefox */
        -ms-overflow-style: none;
        /* IE/Edge */
    }

    .tooltip-content::-webkit-scrollbar {
        display: none;
        /* Chrome/Safari */
    }

    .tooltip-content::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 8px;
        border-style: solid;
        border-color: #333 transparent transparent transparent;
    }

    .tooltip-container:hover .tooltip-content:not(.pinned) {
        display: block;
    }

    .tooltip-content.pinned {
        display: block !important;
    }

    .container-checkbox {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 13px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-weight: bold;
    }

    .checkmark-checkbox {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }

    /******** Radio ******* */

    .container-radio {
        display: block;
        position: relative;
        /*padding-left: 35px;*/
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 13px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-weight: bold;
    }

    .container-radio>input[type="radio"] {
        height: 17px;
        width: 17px;
    }

    .menu-section {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 0;
    }

    .icon-label {
        white-space: nowrap;
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }

    .menu-divider {
        flex: 1;
        height: 1px;
        background-color: #ccc;
        margin-left: 8px;
    }
</style>
<!-- les modal pour la liste des notes -->
<?php include_once dirname(__FILE__) .'/blocs/notesModal.php';?>

<!-- les modal pour D de Documentation -->
<?php include_once dirname(__FILE__) .'/blocs/documentationModal.php';?>

<?php// include_once dirname(__FILE__) . '/../crm/blocs/boitesModal.php';?>

<input type="hidden" id="contextType" value="<?= 'company' ?>">

<!-- les modal pour les ajout et edit de compagnie -->
<?php include_once dirname(__FILE__) .'/blocs/compagnieModal.php';?>


<div class=" col-12">
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php
                $imgUrl = '/public/img/logo_Cabinet_Bruno.png';
                $titre = 'Campagne production B2B CABINET BRUNO -';
                $icon = '<i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i>';

                include_once dirname(__FILE__) .'/blocs/titre.php';
            ?>


            <?php
                // Set the variables before including
                $company = $company ?? null; // Your company data object or null for empty form
                $options = [
                    'showStatus' => true, // Show the status field
                    'showWhatsApp' => false // Hide WhatsApp button
                ];

                include_once dirname(__FILE__) . '/blocs/formCbB2B.php';
            ?>

            <form id="scriptForm">
                <input hidden id="contextId" name="idCompanyGroup" value="<?= $company ? $company->idCompany : 0 ?>">
                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyAccueil">
                    <!-- Étape 0 : Presentation -->
                    <div class="stepAccueil active">
                        <!-- question box -->
                            <?php
                            $consignes = '<li>• Soyez formel et professionnel dès les premières secondes, car il
                                s’agit d’un appel B2B. <br><br></li>
                            <li>• Validez clairement que vous vous adressez au bon décideur pour
                                éviter toute perte de temps. <br><br></li>
                            <li>• Si ce n’est pas la bonne personne, demandez poliment les
                                coordonnées du responsable approprié.</li>';

                            $paragraph = '<p class="text-justify">
                                <strong>Question <span name="numQuestionScript"></span> :</strong>
                                <br>
                                Bonjour, je suis <b>' . $connectedUser->fullName . '</b>, chargé(e) de
                                partenariats pour le <b>Cabinet Bruno</b>. <br>
                                Puis-je parler ' .
                                ($gerant ? "à <b style=\"color: blue;\">{$gerant->prenom} {$gerant->nom}</b>," : "au") . '
                                responsable des partenariats ou des relations commerciales
                                chez <b>' . (!empty($company) ? $company->name : 'user') . '</b> ?
                            </p>';

                            include_once dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>

                            <?php
                                // Option set 1: Responsable
                                $name = 'responsable';
                                $options = [
                                    [
                                        'onclick' => "onClickResponsable('oui');",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => "onClickResponsable('non');",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include_once dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                        <div class="response-options" id="sous-question-0"
                            <?= $questScript && $questScript->responsable == 'non' ? "" : "hidden"; ?>>
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="civiliteResponsable"
                                            id="civiliteResponsable">
                                            <option value="">--Choisir--</option>
                                            <option value="Madame"
                                                <?= $questScript && ($questScript->civiliteResponsable == 'Mme' || $questScript->civiliteResponsable == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= $questScript && ($questScript->civiliteResponsable == 'M' || $questScript->civiliteResponsable == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="prenomResponsable"
                                            value="<?= $questScript ? $questScript->prenomResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomResponsable"
                                            name="nomResponsable" value="<?= $questScript ? $questScript->nomResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleResponsable"
                                            value="<?= $questScript ? $questScript->jobTitleResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telResponsable"
                                            name="telResponsable" value="<?= $questScript ? $questScript->telResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailResponsable"
                                            name="emailResponsable"
                                            value="<?= $questScript ? $questScript->emailResponsable : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 1 : -->
                    <div class="stepAccueil">
                        <?php
                            $consignes = "<li>• Soyez clair et précis, en rappelant succinctement l'activité du
                                                    Cabinet Bruno.<br><br></li>
                                                <li>• Mettez en avant la spécialisation en copropriété pour
                                                    immédiatement situer l’intérêt potentiel pour le prospect
                                                    entreprise.<br><br></li>
                                                <li>• Évitez toute improvisation inutile; allez directement au contexte
                                                    de l’appel.<br><br></li>";
                            $paragraph = "<p class='text-justify'>
                                        Le <b>Cabinet Bruno</b> est une entreprise spécialisée dans la gestion
                                        immobilière , et
                                        particulièrement dans la gestion et l'administration des copropriétés. <br>
                                        Je vous appelle aujourd’hui dans le cadre d’une proposition de partenariat
                                        mutuellement bénéfique entre
                                        nos deux sociétés.
                                    </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>

                    <!-- Étape 2 : -->
                    <div class="stepAccueil">

                    <?php
                            $consignes = "<li>• Soyez clair, direct et enthousiaste en expliquant brièvement le
                                                    partenariat.<br><br></li>
                                                <li>• Insistez sur l’aspect « gagnant-gagnant » dès le départ pour
                                                    susciter un intérêt rapide du prospect.<br><br></li>
                                                <li>• Soyez attentif aux premières réactions afin d’orienter la suite de
                                                    la conversation efficacement.<br><br></li>";
                            $paragraph = "<p>
                                        Concrètement, nous souhaitons vous proposer un <b>partenariat de prescription
                                            mutuelle</b>
                                        où nous pourrions réciproquement recommander nos services à nos clients
                                        respectifs, afin de
                                        créer ensemble de nouvelles opportunités commerciales avantageuses pour nos deux
                                        entreprises.
                                    </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>

                    <!-- Étape 3 : -->
                    <div class="stepAccueil">
                        <?php
                            $consignes = "<li>• Soulignez clairement le lien direct et concret entre les activités
                                                    des deux sociétés.<br><br></li>
                                                <li>• Montrez immédiatement la pertinence d’un partenariat pratique et
                                                    complémentaire.<br><br></li>
                                                <li>• Observez attentivement la réaction de votre interlocuteur, qui
                                                    sera déterminante pour la suite de l’appel.<br><br></li>";
                            $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Nous gérons actuellement un grand nombre d’immeubles et de copropriétés qui ont
                                        très
                                        régulièrement besoin de services tels que ceux que vous proposez
                                        <b>' . (!empty($company) ? $company->name : '') . '</b>. <br>
                                        Je suis convaincu(e) qu’un partenariat entre nos sociétés
                                        pourrait être extrêmement bénéfique, à la fois pour nos clients respectifs et
                                        pour développer
                                        ensemble nos activités.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'Accueil'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyIndisponibelRappel" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepIndisponibelRappel">
                        <?php 
                            $consignes = "<li>• Soyez bref, courtois et professionnel dans votre demande.<br><br>
                                                </li>
                                        <li>• Si le responsable n'est pas disponible immédiatement, proposez
                                                    clairement et simplement une autre plage horaire.<br><br></li>
                                                <li>• Soyez flexible et arrangeant pour faciliter la prise d’un
                                                    rendez-vous ultérieur.</li>";
                            $paragraph = '<p class="text-justify">
                                        Je comprends que vous ne soyez pas disponible pour le moment. <br>
                                        Afin de mieux m’adapter à votre emploi du temps, pourriez-vous me communiquer
                                        une date et une heure qui vous conviendraient pour un rappel téléphonique ?
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                        <?php
                        // Option set 2: Si RDV Rappel
                            $name = 'siDisponible';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVRappel('Prendre RDV relance');",
                                    'btn_class' => 'success',
                                    'value' => 'Prendre RDV relance',
                                    'label' => 'Prendre RDV relance'
                                ],
                                [
                                    'onclick' => "onClickSiRDVRappel('Refus RDV');",
                                    'btn_class' => 'danger',
                                    'value' => 'Refus RDV',
                                    'label' => 'Refus RDV'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>

                        <div class="response-options" id="div-prise-rdv" hidden></div>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'IndisponibelRappel'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>

                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyPartenaireExistant" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepPartenaireExistant">
                            <?php
                                $consignes = '<li>• Soulignez clairement les différenciants du Cabinet Bruno pour
                                                    rassurer le prospect sur la complémentarité possible avec ses
                                                    partenariats existants.<br><br></li>
                                                <li>• Proposez spontanément un test sans engagement pour faciliter la
                                                    prise de décision du partenaire<br><br></li>
                                                <li>• Soyez diplomate, rassurant et professionnel afin de lever cette
                                                    objection efficacement.</li>';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge" style="color: red;">
                                        Je comprends tout à fait votre situation actuelle. Sachez cependant que le
                                        Cabinet Bruno se
                                        distingue par son <b style="color: green;">expertise spécialisée</b> 🌟, sa
                                        grande <b style="color: green;">souplesse</b> 🌟 et une <b
                                            style="color: green;">offre
                                            particulièrement concurrentielle</b> , ce qui peut très bien compléter vos
                                        partenariats
                                        existants. Nous vous proposons simplement d’effectuer un essai sans aucune
                                        exclusivité ✍🏾 afin
                                        de constater concrètement notre valeur ajoutée. <br>
                                        <b>Seriez-vous ouvert(e) à cette idée ?</b>
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>

                            <?php
                            // Option set 3: Partenaire Existant
                                $name = 'siExistePartenaireRep';
                                $options = [
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'PartenaireExistant'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyQuelAvantages" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepQuelAvantages">
                        <?php
                                $consignes = '<li>• Expliquez brièvement et clairement les avantages financiers
                                                    directs et les bénéfices indirects du partenariat.<br><br></li>
                                                <li>• Valorisez fortement le double avantage (commission + échanges
                                                    de clients potentiels).<br><br></li>
                                                <li>• Soyez attentif aux demandes de précisions pour adapter
                                                    précisément vos réponses suivantes.</li>';
                                $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                        L’avantage concret pour vous est double : tout d'abord, vous percevez une <b
                                            style='color: green;'>commission directe</b> 💡
                                        pour chaque nouveau client recommandé signant un mandat avec nous. <br>
                                        Ensuite, nous pratiquons systématiquement des <b style='color: green;'>renvois
                                            d’ascenseur</b> 💡 en orientant activement nos
                                        copropriétaires et clients vers vos propres services dès qu’un besoin
                                        pertinent est détecté. <br>
                                        Cette
                                        complémentarité crée ainsi des bénéfices financiers directs et des
                                        opportunités commerciales
                                        accrues pour votre entreprise.
                                    </p>";
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        
                            <?php
                                // Option set 4: Accepte Partenariat
                                $name = 'siAccepteSuiteQuelAvantage';
                                $options = [
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Accepte le partenariat'
                                    ],
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Refuse le partenariat'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'QuelAvantages'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyPasDetemps" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepPasDetemps ">

                    <?php
                                $consignes = '<li>• Rassurez immédiatement le partenaire potentiel en expliquant
                                                    clairement la simplicité et la rapidité du processus.<br><br>
                                                </li>
                                                <li>• Insistez fortement sur le fait que le Cabinet Bruno gère
                                                    l’intégralité du suivi après recommandation.<br><br></li>
                                                <li>• Soyez attentif aux réactions pour proposer spontanément une
                                                    démonstration de la simplicité du processus.</li>';
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Je comprends parfaitement votre contrainte de temps. Sachez toutefois que
                                        nous avons conçu
                                        un <b style='color: green;'>processus extrêmement simple</b> 🕒 de
                                        recommandation, qui se limite uniquement à une
                                        rapide mise en relation. <br>
                                        Ensuite, le Cabinet Bruno assure la <b style='color: green;'>prise en charge
                                            complète du suivi</b>
                                        auprès du contact recommandé. <br>
                                        Ainsi, cela ne représentera aucune charge
                                        supplémentaire
                                        pour vous. <br>
                                        Seriez-vous rassuré(e) par cette simplicité opérationnelle ?
                                    </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                            <?php
                                // Option set 5: Pas de Temps
                                $name = 'siAccepteSuitePasTemps';
                                $options = [
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => '',
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'PasDetemps'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyMefianceInconnu" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepMefianceInconnu ">
                        <?php
                        $consignes = '<li>• Rassurez immédiatement votre interlocuteur en proposant une
                                                    rencontre physique ou une visioconférence.<br><br></li>
                                                <li>• Mentionnez explicitement des références sérieuses pour
                                                    renforcer votre crédibilité.<br><br></li>
                                                <li>• Soyez calme, ouvert, et montrez-vous disponible pour établir
                                                    une relation de confiance solide.</li>';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je comprends totalement vos réserves. <br>
                                        Pour établir une réelle confiance et répondre pleinement
                                        à vos interrogations, nous pourrions organiser une <b
                                            style="color: green;">rencontre en personne</b> 🤝 ou une
                                        visioconférence, au cours de laquelle nous vous présenterons des <b
                                            style="color: green;">références sérieuses</b> 🤝 ,
                                        telles que des notaires ou des agences immobilières qui collaborent déjà
                                        efficacement avec le
                                        Cabinet Bruno. <br>
                                        Cette approche vous conviendrait-elle ?
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        
                        ?>
                        <?php
                            // Option set 6: Méfiance/Inconnu
                            $name = 'siRDVMefianceInconnu';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui, Planifier rencontre'
                                ],
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non, pas intéressé(e)'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>

                        <!--  Planifier rencontre -->
                        <div class="response-options" id="div-prise-rdv2" hidden></div>
                    </div>


                    <!-- Navigation sd -->
                    <?php $section = 'MefianceInconnu'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyPresentationPartenariat" hidden>

                    <!-- Étape 0 : Presentation -->
                    <div class="stepPresentationPartenariat">
                        <?php
                        $consignes = '<li>• Vérifiez précisément et rapidement l’activité réelle de
                                                    l’entreprise pour assurer la pertinence du partenariat
                                                    proposé.<br><br></li>
                                                <li>• Demandez clairement la zone géographique couverte afin de cibler
                                                    précisément le potentiel de partenariat.<br><br></li>
                                                <li>• Soyez concis et précis, sans donner l’impression de questionner
                                                    trop longuement.</li>';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour nous assurer de la pertinence de notre proposition, pourriez-vous me
                                        confirmer
                                        rapidement que votre entreprise est bien spécialisée en
                                        <b>' . /*!empty($company) ? $company->industry : '' .*/ '</b> ? <br>
                                        Quelle est précisément votre zone d’intervention géographique habituelle ?
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                        <div class="response-options">
                            <div class="options-container">
                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <label for="" style="font-weight: bold;">A- Activités:</label>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input 
                                                    <?= isset($questScript->activiteRadio) && $questScript->activiteRadio == 'Gardiennage' ? 'checked' : '' ?> 
                                                 type="radio" name="activiteRadio" id="checkGardiennage"
                                                    value="Gardiennage" onclick="functionActivite(this.value);">
                                                🛡️ gardiennage
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input
                                                    <?= isset($questScript->activiteRadio) && $questScript->activiteRadio == 'Nettoyage' ? 'checked' : '' ?> 
                                                  type="radio" name="activiteRadio" id="checkNettoyage"
                                                    value="Nettoyage" onclick="functionActivite(this.value);">
                                                🧹 Nettoyage
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input
                                                    <?= isset($questScript->activiteRadio) && $questScript->activiteRadio == 'Maintenance' ? 'checked' : '' ?> 
                                                  type="radio" name="activiteRadio" id="checkMaintenance"
                                                    value="Maintenance" onclick="functionActivite(this.value);">
                                                🛠️ Maintenance
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="container-radio">
                                                <input <?= isset($questScript->activiteRadio) && $questScript->activiteRadio == 'Autres' ? 'checked' : '' ?> type="radio" name="activiteRadio" id="checkAutre" value="Autres"
                                                    onclick="functionActivite(this.value);">
                                                Autres
                                                <span class="checkmark-radio"></span>
                                                </label>
                                                <input type="text" class="form-control" id="autreActivite" 
                                                    name="autreActivite" placeholder="Saisir..." 
                                                    <?= isset($questScript->activiteRadio) && $questScript->activiteRadio == 'Autres' ? '' : 'hidden' ?> 
                                                    value="<?= htmlspecialchars(!empty($questScript->autreActivite) ? $questScript->autreActivite : '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <hr>
                                    <label class="font-weight-bold">B- Zone géographique couverte</label>
                                    <br>
                                    <label>Régions:</label>
                                    <select name="inputRegionsFrance" id="inputRegionsFrance" class="form-control"
                                        onchange="inputRegionsFranceChange(this.value, this.options[this.selectedIndex].text)">
                                    </select>

                                    <div id="display-place">

                                    </div>

                                    <div style="text-align: center; display: none;" id="loader-change-region">
                                        <hr>
                                        <img src="<?= URLROOT ?>/public/images/loader-image.gif" alt
                                            class="rounded-circle" style="width: 50px;" />
                                        <br><br>
                                        <p style="color: red; font-weight: bold;">
                                            Chargement...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 1 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = '<li>• Obtenez rapidement et précisément ces deux informations clés afin
                                                    d’évaluer conrètement le potentiel du partenariat proposé.<br><br>
                                                </li>
                                                <li>• Expliquez simplement pourquoi ces informations sont importantes,
                                                    sans insister excessivement.<br><br></li>
                                                <li>• Notez soigneusement ces informations, elles seront essentielles
                                                    pour les étapes suivantes du partenariat.</li>';
                                $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin d’estimer rapidement l’intérêt de notre partenariat, pourriez-vous me
                                        préciser
                                        approximativement combien de clients vous servez actuellement en: <span
                                            id="place-regions" style="font-weight: bold;"></span>, ainsi que la
                                        typologie principale de ces clients (copropriétés, résidences, entreprises…) ?
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                        <!-- Autre décideur -->
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-12">
                                        <label for="">Nombre approximatif de clients:</label>
                                        <input type="number" class="form-control" min="0" 
                                            id="nombreClients" name="nombreClients" placeholder="" 
                                            value="<?= !empty($questScript->nombreClients) ? htmlspecialchars($questScript->nombreClients) : '0' ?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Typologie principale des clients:</label>
                                        <label class="container-checkbox">
                                            Mono propriété ( maison individuelle, pavillon)
                                            <input
                                            <?= !empty($questScript) && $questScript->typoMonoPropriete =='Mono propriété ( maison individuelle, pavillon)' ? 'checked': ''?>
                                            name="typoMonoPropriete" type="checkbox" id="categorie1"
                                                value="Mono propriété ( maison individuelle, pavillon)">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Copropriété
                                            <input
                                            <?= !empty($questScript) && $questScript->typoCopro =='Copropriété' ? 'checked': ''?>
                                            name="typoCopro" type="checkbox" id="categorie2" value="Copropriété">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Zone commerciale
                                            <input <?= !empty($questScript) && $questScript->typoZoneCommerciale =='Zone commerciale' ? 'checked': ''?> name="typoZoneCommerciale" type="checkbox" id="categorie3" value="Zone commerciale">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Autres
                                            <input name="autresTypologies" type="checkbox" id="categorie4" value="Autres" 
                                                    onchange="toggleAutreTypologie(this.checked)">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <input type="text" class="form-control" id="autreTypologie" 
                                                name="typoAutres" placeholder="Saisir..." 
                                                value="<?= htmlspecialchars($questScript->typoAutres ?? '') ?>" 
                                                style="display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 2 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = '<li>• Présentez le partenariat clairement et simplement, en valorisant
                                                    immédiatement le bénéfice réciproque.<br><br></li>
                                                <li>• Insistez sur l’aspect spontané et naturel de ce type de
                                                    partenariat, sans contraintes excessives.<br><br></li>
                                                <li>• Soyez attentif à la réaction de l’interlocuteur pour adapter au
                                                    mieux la suite de votre présentation.</li>';
                                $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Le principe que nous proposons est un <b style="color: green;">parrainage
                                            réciproque</b> , simple et efficace : <br><br>
                                        • Chaque fois que vous détectez chez vos clients un besoin immobilier
                                        correspondant à nos
                                        services, vous nous les recommandez spontanément. <br><br>
                                        • Et réciproquement, lorsque nous détectons un besoin pour vos services auprès
                                        de nos
                                        propres clients, nous les orientons naturellement vers vous. <br>
                                        Cela permet à chacun de nos
                                        clients de bénéficier de services complets, et à nos entreprises respectives de
                                        développer
                                        ensemble notre activité.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>


                    <!-- Etape 3 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                        $consignes = '<li>• Insistez sur le bénéfice financier concret pour l’entreprise
                                                    partenaire.<br><br></li>
                                                <li>• Précisez clairement que la commission sera systématique dès
                                                    signature d’un mandat par un client recommandé.<br><br></li>
                                                <li>• Soyez attentif aux questions éventuelles sur les modalités
                                                    précises (montant, fréquence de paiement).</li>';
                                $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        L’un des avantages majeurs de ce partenariat est le <b
                                            style="color: green;">nouveau revenu potentiel</b> généré pour
                                        votre entreprise : en effet, vous percevez une <b
                                            style="color: green;">commission</b> chaque fois qu’un client que vous
                                        recommandez signe effectivement un mandat avec le Cabinet Bruno.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions ou demandes spécifiques du
                                    prospect dans le champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 4 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = "<li>• Valorisez clairement le bénéfice qualitatif et stratégique de ce
                                                    partenariat pour l’entreprise prospectée.<br><br></li>
                                                <li>• Expliquez brièvement comment cela renforce leur crédibilité et
                                                    leur relation client.<br><br></li>
                                                <li>• Soyez attentif aux éventuelles demandes de précisions du prospect.
                                                </li>";
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Ce partenariat permet également un <b style='color: green;'>enrichissement de
                                            votre offre</b> auprès de vos clients
                                        existants. <br>
                                        En les proposant un syndic fiable comme le Cabinet Bruno, vous
                                        renforcez ainsi votre propre <b style='color: green;'>position de conseil
                                            renforcée</b> , tout en augmentant leur
                                        satisfaction globale.
                                    </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions ou demandes du prospect dans le
                                    champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 5 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = "<li>• Insistez sur l’aspect réciproque et équilibré du
                                                    partenariat.<br><br></li>
                                                <li>• Soulignez que le Cabinet Bruno est tout à fait disposé à
                                                    recommander activement le partenaire auprès de ses propres
                                                    clients.<br><br></li>
                                                <li>• Soyez particulièrement attentif aux réactions immédiates pour
                                                    adapter la suite du dialogue.</li>";
                            $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Par ailleurs, ce partenariat représente une réelle <b
                                            style="color: green;">opportunité de réciprocité</b>. De notre côté,
                                        le Cabinet Bruno pourra à son tour recommander activement votre entreprise et
                                        vos services
                                        auprès de ses propres clients copropriétaires, ce qui générera ainsi un
                                        véritable cercle vertueux
                                        bénéfique à nos deux activités.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les remarques du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 6 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = "<li>• Présentez clairement la simplicité du processus afin de rassurer
                                                    immédiatement le partenaire.<br><br></li>
                                                <li>• Insistez sur le respect strict de la confidentialité et de
                                                    l’accord préalable du prospect recommandé.<br><br></li>
                                                <li>• Restez attentif aux éventuelles questions sur les détails
                                                    pratiques.</li>";
                            $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Nous avons mis en place un <b style="color: green;">processus simple de
                                            recommandation</b> pour faciliter notre
                                        collaboration : <br><br>
                                        • Dès que vous identifiez un client potentiellement intéressé par nos services,
                                        vous nous
                                        transmettez simplement ses coordonnées. <br><br>
                                        • Cette transmission se fait toujours avec l’accord préalable de votre client,
                                        afin de
                                        respecter pleinement la confidentialité et la confiance. <br>
                                        Ce processus garantit ainsi une fluidité maximale et une grande efficacité pour
                                        nos deux
                                        entreprises.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                    </div>


                    <!-- Etape 7 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = "<li>• Insistez sur l’importance accordée à la transparence et au sérieux
                                                    du suivi des recommandations.<br><br></li>
                                                <li>• Expliquez brièvement que le partenaire sera systématiquement
                                                    informé des suites données à chaque recommandation.<br><br></li>
                                                <li>• Soyez attentif aux questions éventuelles sur les modalités
                                                    précises de ce suivi.</li>";
                            $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de garantir une collaboration efficace, nous assurons une <b
                                            style="color: green;">transparence totale</b> ainsi
                                        qu’un <b style="color: green;">suivi rigoureux</b> des leads transmis. <br>
                                        Vous serez ainsi systématiquement informé(e) de
                                        l’issue donnée à chaque contact que vous nous recommandez, ce qui permet une
                                        confiance et
                                        une visibilité optimales entre nos deux entreprises.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 8 : -->
                    <div class="stepPresentationPartenariat">
                        <?php
                            $consignes = "<li>• Soulignez clairement l’importance majeure accordée par le Cabinet
                                                    Bruno à la qualité du traitement des contacts recommandés.<br><br>
                                                </li>
                                                <li>• Rassurez le partenaire en expliquant que sa réputation sera
                                                    toujours protégée.<br><br></li>
                                                <li>• Soyez attentif aux éventuelles inquiétudes exprimées afin d'y
                                                    répondre immédiatement.</li>";
                            $paragraph = '<p class="text-justify" id="textConfirmPriseEnCharge">
                                        Sachez également que le Cabinet Bruno prend un <b
                                            style="color: green;">engagement de qualité</b> fort envers tous
                                        les clients que vous recommandez. <br>
                                        Nous garantissons un traitement sérieux, professionnel et
                                        attentif de chaque contact afin de préserver pleinement le <b
                                            style="color: green;">respect de votre réputation</b>
                                        auprès de vos clients.
                                    </p>';
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 9 : -->
                    <div class="stepPresentationPartenariat">
                        <div class="question-box" id="bloc-gardiennage" hidden>
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Insistez fortement sur la complémentarité évidente entre sécurité
                                                    et gestion efficace de immeubles.<br><br></li>
                                                <li>• Expliquez brièvement comment un syndic performant facilite
                                                    concrètement le quotidien des équipes de sécurité.<br><br></li>
                                                <li>• Soyez attentif aux réactions du partenaire pour renforcer les
                                                    points positivement reçus.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Compte tenu de votre activité dans le domaine du gardiennage 🛡️, notre
                                        partenariat présente
                                        une forte convergence d’objectifs. En effet, une <b
                                            style="color: green;">sécurité optimale</b> 🛡️ dans les copropriétés est
                                        étroitement liée à une gestion rigoureuse des immeubles. <b
                                            style="color: green;">Un syndic efficace</b> 🛡️ comme le
                                        Cabinet Bruno facilite ainsi directement le travail quotidien de vos agents sur
                                        le terrain,
                                        notamment en matière de communication, d’accès sécurisé et de maintenance
                                        générale.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="question-box " id="bloc-Nettoyage" hidden>
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez fortement l’intérêt réciproque : des copropriétés bien
                                                    gérées nécessitent systématiquement des prestataires
                                                    fiables.<br><br></li>
                                                <li>• Expliquez brièvement que le partenaire pourra fidéliser sa
                                                    clientèle grâce à une recommandation de syndic de qualité.<br><br>
                                                </li>
                                                <li>• Soyez très attentif aux réactions positives pour renforcer
                                                    immédiatement votre argumentaire.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Dans votre secteur d’activité, le nettoyage 🧹, il existe une complémentarité
                                        évidente avec notre
                                        métier. Des copropriétés bénéficiant d’une <b style="color: green;">gestion
                                            optimale</b> 🧹 ont toujours besoin de
                                        <b style="color: green;">prestataires fiables</b> 🧹 . Ainsi, en recommandant un
                                        syndic performant tel que le Cabinet Bruno,
                                        vous pouvez fidéliser davantage vos propres clients et renforcer votre relation
                                        commerciale avec
                                        eux, dans un cadre de confiance réciproque.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="question-box" id="bloc-maintenance" hidden>
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez précisément comment un syndic proactif comme le Cabinet
                                                    Bruno améliore les conditions de travail des prestataires
                                                    externes.<br><br></li>
                                                <li>• Expliquez succinctement que cette collaboration peut
                                                    considérablement renforcer la relation commerciale avec leurs
                                                    clients.<br><br></li>
                                                <li>• Soyez attentif aux réactions immédiates pour adapter précisément
                                                    votre discours.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Compte tenu de votre activité dans le secteur (<b
                                            style="color: green;">maintenance ⚙️ , paysagisme 🌿, autres
                                            services aux immeubles</b>), un <b style="color: green;">syndic proactif</b>
                                        ⚙️ comme le Cabinet Bruno permet une véritable
                                        <b style="color: green;">valorisation de votre travail</b> ⚙️. Grâce à une
                                        gestion dynamique et efficace des immeubles, vos
                                        interventions sont mieux organisées, plus appréciées et davantage mises en avant
                                        auprès des
                                        copropriétaires. Un partenariat basé sur cet échange de bons procédés serait
                                        donc
                                        particulièrement bénéfique à nos deux activités.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="question-box" id="bloc-autre" hidden>
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez précisément comment un syndic proactif comme le Cabinet
                                                    Bruno améliore les conditions de travail des prestataires
                                                    externes.<br><br></li>
                                                <li>• Expliquez succinctement que cette collaboration peut
                                                    considérablement renforcer la relation commerciale avec leurs
                                                    clients.<br><br></li>
                                                <li>• Soyez attentif aux réactions immédiates pour adapter précisément
                                                    votre discours.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Texte activité autre à remplacer.
                                        Egalement les consignes aux téléconseiller.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="options-container col-md-11">
                                    <label style="font-weight: bold;">Indiquez les réactions du prospect dans le champ
                                        "Note" à droite.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation sd -->
                    <?php $section = 'PresentationPartenariat'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyMessageFin" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepMessageFin ">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Merci pour votre réponse, je respecte tout à fait votre position.
                                        Si jamais votre avis évolue ou si vous avez besoin d’un partenaire de confiance
                                        à l’avenir,
                                        le Cabinet Bruno restera à votre disposition. <br>
                                        Très bonne continuation à vous !
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Navigation sd -->
                    <?php $section = 'MessageFin'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyMessageFinRDVRelance" hidden>
                    <!-- Étape 0 : Presentation -->
                    <div class="stepMessageFinRDVRelance ">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Merci beaucoup pour votre disponibilité.
                                        Je vous confirme donc notre rendez-vous pour le <span id="place-date-heure-rdv"
                                            style="font-weight: bold;"></span>. <br>
                                        En attendant, je vous souhaite une excellente journée et je me réjouis de notre
                                        conversation à venir. <br>
                                        À très bientôt !
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Navigation sd -->
                    <?php $section = 'MessageFinRDVRelance'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid orange"
                    id="divBodyDoc" hidden>
                    <div class="question-box ">
                        <div class="agent-icon">
                            <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                        </div>
                        <div class="question-content">
                            <div class="question-text">
                                <p class="text-justify">Permettez-moi de prendre vos coordonées pour vous envoyer notre
                                    document de présentation</p>
                            </div>
                        </div>
                    </div>
                    <div class="question-content col-md-11">
                        <div class="col-md-12 mb-3">
                            <!-- INFOS MAIL -->
                            <div class="row col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="">Civilité</label>
                                    <select name="civiliteGerant" ref="civiliteGerant" id="civiliteGerant"
                                        class="form-control">
                                        <option value="">....</option>
                                        <option <?= $questScript && $questScript->civiliteGerant == "Monsieur" ? 'selected' : '' ?>
                                            value="Monsieur">Monsieur</option>
                                        <option <?= $questScript && $questScript->civiliteGerant == "Madame" ? 'selected' : '' ?>
                                            value="Madame">Madame</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prénom</label>
                                    <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                        id="prenomGerant" value="<?= $questScript ? $questScript->prenomGerant : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nom</label>
                                    <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                        id="nomGerant" value="<?= $questScript ? $questScript->nomGerant : '' ?>">
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="emailGerant" ref="emailGerant"
                                        value="<?= $questScript ? $questScript->emailGerant : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Téléphone</label>
                                    <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                        value="<?= $questScript ? $questScript->telGerant : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Poste</label>
                                    <select name="posteGerant" ref="posteGerant" id="" class="form-control">
                                        <option value="responsable">Responsable</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 offset-5 mb-2">
                        <a target="_blank" class="btn btn-warning d-flex align-items-center"
                            onclick="sendDocumentation()">
                            <i class="fas fa-paper-plane mr-2"></i> Envoyer
                        </a>
                    </div>

                </div>

                <div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid blue"
                    id="divBodyDSS" hidden>
                    <!-- NATURE DU SINISTRE -->
                    <div class="stepDSS ">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p>Nous allons pouvoir vous aider. Je vais rapidement recueillir les informations
                                        essentielles afin de
                                        pouvoir
                                        vous accompagner immédiatement et gratuitement dans la gestion de votre
                                        sinistre.
                                        <br>Tout
                                        d'abord, quel type de sinistre avez-vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="col-md-10" style="margin-left: 95px; margin-bottom: 10px;">
                                <label for="typeSinistre" class="fw-bold">Choisir le type de sinistre</label>
                                <select class="form-control" id="typeSinistre" name="type_sinistre"
                                    onchange="onChangeTypeSin(); showSousQuestion('2-1',true)">
                                    <option value="">Choisir la nature du sinistre</option>
                                    <?php $selectedType = $questScript->type_sinistre ?? '';
                                    foreach ($typeSinistres as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $value == $selectedType ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" class="form-control mt-2" id="autre-sinistre" name="autre_sinistre"
                                    placeholder="Précisez le type de sinistre" style="display: none;"
                                    onblur="showSousQuestion('2-1',true)">
                            </div>
                        </div>

                    </div>
                    <!-- dommages -->
                    <div class="stepDSS">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Quelle est
                                        la
                                        date du sinistre ?</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class='col-md-6'>
                                        <input type='date' name='dateSinistre' id="dateS" max="<?= date('Y-m-d') ?>"
                                            value='<?= ($rt  && $rt->date != '' && $rt->date != null) ?  date('Y-m-d', strtotime(explode(" ", $rt->date)[0]))   : ($questScript && $questScript->dateSinistre != ""  ? date('Y-m-d', strtotime($questScript->dateSinistre))  : "") ?>'
                                            class='col-md-10 form-control'>
                                    </div>
                                    <div class='col-md-6 badge bg-secondary py-2 mb-3 text-white'>
                                        <input type='checkbox' name='dateInconnue' id='dateInconnu'
                                            <?= checked('dateInconnue', 'oui', $questScript, 'checked') ?> value='oui'
                                            class='checkbox' onclick='changeDateTE()'>
                                        <label for=''>Date Inconnue</label>
                                    </div>
                                </div>
                                <div class="card" id='infosCom'
                                    <?= $questScript && $questScript->dateInconnue == 'oui' ? '' : 'hidden' ?>>
                                    <div class="card-body">
                                        <div class='row mt-2'>
                                            <label for='' class='col-md-5'>a. Date approximative de constatation du
                                                sinistre : </label>
                                            <input type='date' name='dateApproximative' id='dateConstat'
                                                max="<?= date('Y-m-d') ?>"
                                                value='<?= ($rt != null && $rt != false) ? ($rt->dateConstat != '' ?  date('Y-m-d', strtotime($rt->dateConstat)) : "")  : ($questScript && $questScript->dateApproximative != "" ? date('Y-m-d', strtotime($questScript->dateApproximative))  : "")  ?>'
                                                class='offset-md-1 col-md-6 form-control'>
                                        </div>
                                        <div class='col-md-2'>OU</div>
                                        <div class='row'>
                                            <label for='' class='col-md-6'>b. Pouvez-vous nous
                                                donner au moins
                                                l'année de survenance du sinistre ?</label>
                                            <input type='text' name='anneeSurvenance' id='anneeSurvenance'
                                                value='<?= ($rt != null && $rt != false) ? $rt->anneeSurvenance  : ($questScript ? $questScript->anneeSurvenance : "") ?>'
                                                class='col-md-6 form-control'>
                                        </div>
                                        <div class='row mt-2'>
                                            <label for='' class=''>c. Expliquez-nous les raisons
                                                pour lesquelles
                                                vous n'êtes pas en mesure de nous donner la date
                                                précise du sinistre
                                                ?</label>
                                            <textarea name='commentaireDateInconnue' id='comDateInconnu' cols='30'
                                                rows='5'
                                                class='form-control'><?= ($rt != null && $rt != false) ? $rt->commentaireDateInconnue  : ($questScript ? $questScript->commentaireDateInconnue : "") ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Etape 5 : Dommages -->
                    <div class="stepDSS">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textDommages">Qu'est-ce que vous avez comme dommages ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class='row col-md-12'>
                                    <!-- Dégât des eaux -->
                                    <div id="option-content" class="form-group col-md-12 row">

                                    </div>
                                    <div class="row">
                                        <div class='col-md-12' id="divAutreDommage"
                                            <?= $questScript && str_contains($questScript->dommages, 'Autre')  ? '' : 'hidden'  ?>>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <label for=''>Précisez Autres Dommages : </label>
                                                </div>
                                                <div class='col-md-12'>
                                                    <input value='<?= $questScript ? $questScript->autreDommage : '' ?>'
                                                        type='text' name='autreDommage' class='form-control'
                                                        id='autreDommage'>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 6 : origine -->
                    <div class="stepDSS">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">Pouvez-vous me dire svp
                                        l'origine du sinistre ?</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12" id="origineSinistreDDE">
                                    <div class='col-md-6'>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Fuite', $causes) ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Fuite', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Fuite' id='fuite'
                                                name='cause[]' class="cause">
                                            <label>a. Fuite</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Infiltration', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Infiltration', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Infiltration'
                                                id='infiltration' name='cause[]' class="cause">
                                            <label>c. Infiltration</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Engorgement', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Engorgement', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Engorgement'
                                                id='engorgement' name='cause[]' class="cause">
                                            <label>e. Engorgement</label>
                                        </div>
                                    </div>
                                    <div class='col-md-6'>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Débordement', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Débordement', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Débordement'
                                                id='debordement' name='cause[]' class="cause">
                                            <label>b. Débordement</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('je ne sais pas', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('je ne sais pas', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='je ne sais pas'
                                                id='nesaispasCause' name='cause[]' class="cause">
                                            <label>d. Je ne sais pas</label>
                                        </div>
                                        <div class='col-12 text-left'>
                                            <input
                                                <?= ($rt) ? (in_array('Autre', $causes)  ? 'checked' : '') : ($questScript && $questScript->causes != "" && (in_array('Autre', explode(";", $questScript->causes))) ?  'checked' : "") ?>
                                                onchange='onClickCause(this,1)' type='checkbox' value='Autre' id='autre'
                                                name='cause[]' class="cause">
                                            <label>f. Autre</label>
                                        </div>

                                    </div>
                                    <div class='col-md-12'
                                        <?= ($rt) ? (in_array('Autre', $causes)  ? '' : 'hidden') : ($questScript && $questScript->causes != "" && (in_array('Autre', explode(";", $questScript->causes))) ?  '' : "hidden") ?>
                                        id="divAutreCause">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <label for=''>Précisez Autres origines : </label>
                                            </div>
                                            <div class='col-md-12'>
                                                <input value='<?= $questScript ? $questScript->autreCauseDegat : '' ?>'
                                                    type='text' name='autreCauseDegat' class='form-control'
                                                    id='autreCauseDegat'>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 7 : Circonstantces -->
                    <div class="stepDSS">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge"> Dites-nous tout ce que vous
                                        savez
                                        sur le sinistre</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <textarea style="white-space: normal" name='commentaireSinistre' class='form-control'
                                    id='commentaireSinistre' cols=30
                                    rows=5><?= ($rt) ?  $rt->precisionComplementaire : ($questScript ? $questScript->commentaireSinistre : "") ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation DSS -->
                    <div class="buttons">
                        <button id="prevBtnDSS" type="button" class="btn-prev hidden" onclick="goBackScript('DSS')">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPageDSS" class="font-weight-bold"></span></label>
                        <button id="nextBtnDSS" type="button" class="btn-next" onclick="goNext('DSS')">Suivant
                            ➡</button>
                        <button id="finishBtnDSS" type="button" class="btn-finish hidden" onclick="finish('DSS')">✅
                            Terminer</button>
                    </div>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid red" id="divBodySD"
                    hidden>
                    <!-- SIGNATURE DELEGATION -->
                    <!-- Etape 0 : DELEGATION 1 -->
                    <div class="stepSD active">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Si vous souhaitez que nous intervenions sur votre dossier,
                                        nous
                                        allons valider ensemble une délégation qui va nous permettre :<br>
                                        1- d'intervenir pour vous auprès de votre assurance,<br>
                                        2- de vous faire bénéficier de toute notre expertise ( défense de vos
                                        droits)<br>
                                        3- de faire effectuer vos travaux par nos professionnels qualifiés.<br>
                                        Vous aurez ensuite un délai de 14 jours pour vous rétracter ( nous tenons à
                                        intervenir dans la confiance mutuelle, c'est pour cela que nous avons souhaité
                                        doubler le délai légal de rétractation de 7 jours).
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                            $name = 'siSignDeleg';
                            $options = [
                                [
                                    'onclick' => '',
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui'
                                ],
                                [
                                    'onclick' => '',
                                    'btn_class' => 'warning',
                                    'value' => 'plusTard',
                                    'label' => 'Plus Tard'
                                ],
                                [
                                    'onclick' => '',
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non'
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>

                    <!-- SI SIGNATURE = OUI -->
                    <!-- Etape 1 : DELEGATION 2 -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Merci de nous confirmer ces informations
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Civilité</label>
                                            <select name="civiliteGerant" ref="civiliteGerant" id=""
                                                class="form-control">
                                                <option value="">....</option>
                                                <option
                                                    <?= $questScript && $questScript->civiliteGerant == "Monsieur" ? 'selected' : '' ?>
                                                    value="Monsieur">Monsieur</option>
                                                <option
                                                    <?= $questScript && $questScript->civiliteGerant == "Madame" ? 'selected' : '' ?>
                                                    value="Madame">Madame</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Prénom <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="prenomGerant"
                                                ref="prenomGerant" value="<?= $questScript ? $questScript->prenomGerant : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nom <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                value="<?= $questScript ? $questScript->nomGerant : '' ?>">
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" name="emailGerant"
                                                ref="emailGerant" value="<?= $questScript ? $questScript->emailGerant : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Téléphone</label>
                                            <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                value="<?= $questScript ? $questScript->telGerant : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Poste</label>
                                            <select name="posteGerant" ref="posteGerant" id="" class="form-control">
                                                <option value="responsable">Responsable</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Date Naissance <small class="text-danger">*</small>
                                            </label>
                                            <input class="form-control" type="date" name="dateNaissanceSignataire"
                                                max="<?= date('Y-m-d', strtotime('18 years ago')) ?>" id="dateNaissance"
                                                value="<?= $gerant && $gerant->dateNaissance != null && $gerant->dateNaissance != ""  ? $gerant->dateNaissance : ($questScript ? $questScript->dateNaissanceSignataire : "") ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 2 : DELEGATION 3 : Adresse -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Veuillez nous confirmez l'adresse du sinsitre
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Adresse <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="adresse" id="adresseImm"
                                                value="<?= $questScript->adresse ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Code Postal <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="cp" id="cP"
                                                value="<?= $questScript->cp ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Ville <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="ville" id="ville"
                                                value="<?= $questScript->ville ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row col-md-12">
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Etage <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="etage" id="etage"
                                                value="<?= $questScript ? $questScript->etage : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Porte <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="porte" id="porte"
                                                value="<?= $questScript ? $questScript->porte : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">N° Lot</label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="lot" id="lot"
                                                value="<?= $questScript ? $questScript->lot : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div>
                                            <label for="">Bâtiment</label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="batiment" id="batiment"
                                                value="<?= $questScript ? $questScript->batiment : "" ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 3 : DELEGATION 4 -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Veuillez renseigner le nom de la compagnie d'assurance
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <div class="col-md-12">
                                    <div>
                                        <label for="">Nom Compagnie <small class="text-danger">*</small></label>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input readonly type="text" name="nomCieAssurance" id="nomCie"
                                                class="form-control"
                                                value="<?= isset($cie) && $cie ? $cie->name  : ($questScript ? $questScript->nomCieAssurance : "") ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <a type="button" rel="tooltip" id="btnAddCie"
                                                title="Ajouter ou Modifier la compagnie d'assurance"
                                                onclick="showModalCie('add')" class="btn btn-sm btn-secondary ">
                                                Ajouter/Modifier la Compagnie <i id="iconeAddCie" class="fa fa-plus"
                                                    style="color: #ffffff"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 4 : DELEGATION 5 -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Veuillez renseigner les informations du contrat
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">N° Police Assurance (N° Contrat)
                                                <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="numPolice" id="numPolice"
                                                value="<?= ($questScript ? $questScript->numPolice : "") ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for=""> Date Début Contrat <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="date" max="<?= date(" Y-m-d") ?>"
                                                name="dateDebutContrat" id="dateDebutContrat" value="<?= ($questScript ? $questScript->dateDebutContrat : "") ?>"
                                                onchange="onChangeDateDebutContrat()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Date Fin Contrat <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="date" name="dateFinContrat"
                                                id="dateFinContrat"
                                                value="<?= ($questScript ? $questScript->dateFinContrat : "") ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 5 : DELEGATION 5 -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Veuillez renseigner les informations du contrat
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-12">
                                        <div class="font-weight-bold  mb-2">
                                            6. Avez-vous déclarer votre sinistre
                                        </div>
                                        <div class="row p-3  text-center">
                                            <div class="col-md-6">
                                                <input onclick="onClickDeclareSinistre('oui')" type="radio" id=""
                                                    name="siDeclarerSinistre" value="Oui"
                                                    <?= ($questScript && $questScript->siDeclarerSinistre == "Oui") ? "checked" : "" ?>><label
                                                    class="ml-2" for="">Oui</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input onclick="onClickDeclareSinistre('non')" type="radio" id=""
                                                    name="siDeclarerSinistre" value="Non"
                                                    <?= ($questScript && $questScript->siDeclarerSinistre == "Non") ? "checked" : "" ?>><label
                                                    class="ml-2" for="">Non</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 offset-3" id="divNumSinistre"
                                            <?= ($questScript && $questScript->siDeclarerSinistre == "Oui") ? "" : "hidden" ?>>
                                            <div>
                                                <label for="">Numero de sinistre</label>
                                            </div>
                                            <div>
                                                <input class="form-control" type="text" name="numSinistre"
                                                    id="numSinistre"
                                                    value="<?= ($questScript ? $questScript->numSinistre : "") ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 6 : DELEGATION 6 - Envoi Code -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Merci de nous confirmez votre adresse mail et numèro
                                        téléphone.
                                        Vous recevrez un code de 6 chiffres par sms sur ce numèro
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12 mt-2">
                                    <div class="col-md-6 mt-2">
                                        <div>
                                            <label for="">Email <small class="text-danger">*</small>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" ref="emailGerant" name="emailGerant" id="emailSign"
                                                class="form-control" value="<?= $gerant ? $gerant->email : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div>
                                            <label for="">Téléphone <small class="text-danger">*</small>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" name="telGerant" ref="telGerant" id="telSign"
                                                class="form-control" value="<?= $gerant ? $gerant->tel : "" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 7 : DELEGATION 7 - Confirm Code -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Merci de me communiquez le code à 6 chiffres que vous avez
                                        reçu
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <div class="row">
                                    <input maxlength="6" style="font-size: 50px;" type="text" name="codeSign"
                                        id="codeSign" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SI SIGNATURE = PLUS TARD -->
                    <!-- Etape 8 : DELEGATION 1 - Demander raison hesitation -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Très bien, je comprends parfaitement. Pour mieux vous
                                        accompagner, pourriez-vous simplement me préciser la raison principale pour
                                        laquelle vous souhaitez signer un peu plus tard </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" value="prendreConnaissance"
                                                id="prendreConnaissance" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'prendreConnaissance', $questScript, 'checked') ?> />
                                            <label for="prendreConnaissance"> a- Je
                                                souhaite
                                                prendre connaissance tranquillement du document avant de signer</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" id="signatureComplique"
                                                value="signatureComplique" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'signatureComplique', $questScript, 'checked') ?> />
                                            <label for="signatureComplique"> b- Je n’ai pas l’habitude des signatures
                                                électroniques, cela me paraît compliqué.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" id="documentManquant"
                                                value="documentManquant" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'documentManquant', $questScript, 'checked') ?> />
                                            <label for="documentManquant">c- Je n’ai
                                                pas
                                                tous
                                                les documents ou toutes les informations sur moi.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input onclick="onClickChoixSignaturePT()" value="prefereDemander"
                                                id="prefereDemander" name="raisonRefusSignature" type="radio"
                                                <?= checked('raisonRefusSignature', 'prefereDemander', $questScript, 'checked') ?> />
                                            <label for="prefereDemander"> d- Je préfère
                                                en
                                                parler d'abord avec un proche ou un associé</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- etape 9 FIN -->
                    <div class="stepSD">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>FIN DU bloc :</strong>
                                    <p id="textClotureSD">
                                        Je vous remercie et vous souhaite une bonne fin de journée.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'SD'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>

                <div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid green"
                    id="divBodyRvPerso" hidden>
                    <!-- STEP 0 -->
                    <div class="stepRvPerso active">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify">Permettez-moi de prendre vos coordonées </p>
                                </div>
                            </div>
                        </div>
                        <div class="question-content col-md-11">
                            <div class="col-md-12 mb-3">
                                <!-- INFOS MAIL -->
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité</label>
                                        <select name="civiliteGerant" ref="civiliteGerant" id="" class="form-control">
                                            <option value="">....</option>
                                            <option <?= $questScript && $questScript->civiliteGerant == "Monsieur" ? 'selected' : '' ?>
                                                value="Monsieur">Monsieur</option>
                                            <option <?= $questScript && $questScript->civiliteGerant == "Madame" ? 'selected' : '' ?>
                                                value="Madame">Madame</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom</label>
                                        <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                            value="<?= $questScript ? $questScript->prenomGerant : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom</label>
                                        <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                            value="<?= $questScript ? $questScript->nomGerant : '' ?>">
                                    </div>
                                </div>

                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="emailGerant" ref="emailGerant"
                                            id="emailGerant" value="<?= $questScript ? $questScript->emailGerant : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone</label>
                                        <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                            id="telGerant" value="<?= $questScript ? $questScript->telGerant : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste</label>
                                        <select name="posteGerant" ref="posteGerant" id="posteGerant"
                                            class="form-control">
                                            <option value="responsable">Responsable</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 1 -->
                    <div class="stepRvPerso">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify">Prendre RDV pour un superviseur </p>
                                </div>
                            </div>
                        </div>
                        <div class="question-content col-md-11">
                            <div class="options-container col-md-11">
                                <div class="form-group col-md-6">
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">1. Type de RDV</span>
                                    </div>
                                    <select class="form-control" name="" id=""
                                        onchange="typeReunionChange(this.value);">
                                        <option value="">--Choisir--</option>
                                        <option value="physique">Physique</option>
                                        <option value="Visioconférence">Visioconférence</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-5" id="imputLienVisioconference" hidden>
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">1.1 Lien visoiconférence:</span>
                                    </div>

                                    <input type="text" class="form-control" id="lienVisioconference"
                                        name="lienVisioconference" value="">
                                </div>

                                <div class="col-md-12">
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">2. Veuillez selectionner la plage de
                                            disponibilité</span>
                                    </div>

                                    <!-- INFOS RDV -->

                                    <input type="text" value="" id="expertRV" hidden>
                                    <input type="text" value="" id="idExpertRV" hidden>
                                    <input type="text" id="idContactRV" value="0" hidden>
                                    <input type="text" value="" id="dateRV" hidden>
                                    <input type="text" value="" id="heureDebut" hidden>
                                    <input type="text" value="" id="heureFin" hidden>
                                    <input type="text" hidden
                                        value="<?= $company->businessLine1 . ' ' . $company->businessPostalCode . ' ' . $company->businessCity ?>">
                                    <textarea name="" hidden id="commentaireRV"></textarea>
                                    <input type="text" hidden value="<?= $_SESSION['connectedUser']->idUtilisateur ?>"
                                        id="idUtilisateur">
                                    <input type="text" hidden value="" id="numeroAuteur">
                                    <input type="text" hidden value="<?= $_SESSION['connectedUser']->fullName ?>"
                                        id="auteur">


                                    <div class="row mt-2" id="divTabDisponibiliteSup">

                                    </div>

                                    <div>
                                        <div
                                            class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                            <div class="pull-left page-item col-md-6 p-0 m-0">
                                                <div id="btnPrecedentRDV">
                                                    <a type="button" class="text-center btn"
                                                        style="background-color: grey;color:white"
                                                        onclick="onClickPrecedentRDV('Sup')">Dispos Prec. << </a>
                                                </div>
                                            </div>
                                            <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0"><a
                                                    type="button" class="text-center btn"
                                                    style="background-color: grey;color:white"
                                                    onclick="onClickSuivantRDV('Sup')">>>
                                                    Dispos Suiv.</a></div>
                                        </div>
                                    </div>

                                    <div class="row mt-2" id="divTabHoraireSup">


                                    </div>
                                    <div class=" row mt-5 text-center">
                                        <h4 class="text-center font-wei ght-bold" id="INFO_RDVSup"></h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 2  : PRISE DE RDV PERSO-->
                    <div class="stepRvPerso">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>FIN RDV PERSO :</strong>
                                    <p id="textClotureRvRT">
                                        Je vous remercie et vous souhaite une bonne fin de journée!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation sd -->
                    <?php $section = 'RvPerso'; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </div>
            </form>
        </div>
        <?php include_once dirname(__FILE__) .'/blocs/prodCbB2BSidebar.php';?>
    </div>
</div>

<script>

function onClickPrendreRvRT(params) {
    let email = $('#emailContact').val();
    let adresse = $('#adresseImm').val();
    let idContact = $('#idContact').val();
    // if (idContact == "0" || idContact == "") {
    //     $("#msgError").text(
    //         "Veuillez renseigner le contact au bloc 'N°1' !"
    //     );
    //     $('#errorOperation').modal('show');
    //     $('#email').focus();
    // } else {
    //     if (email == null || email == "") {
    //         $("#msgError").text(
    //             "Veuillez renseigner l'email du contact au bloc 'N°1' !"
    //         );
    //         $('#errorOperation').modal('show');
    //         $('#email').focus();
    //     } else {
    //         if (adresse == null || adresse == "") {
    //             $("#msgError").text(
    //                 "Veuillez renseigner l'adresse du rendez-vous au bloc 'N°5'!"
    //             );
    //             $('#errorOperation').modal('show');
    //             $('#email').focus();
    //         } else {
    //             //CONFIRM ADRESSE
    //             $('#confirmRDVRTModal').modal('show');
    //             // getDisponiblites();
    //         }
    //     }
    // }
    getDisponiblites();
}

    function onClickPrendreRvRT2(params) {
    let email = $('#emailContact').val();
    let adresse = $('#adresseImm').val();
    let idContact = $('#idContact').val();
    // if (idContact == "0" || idContact == "") {
    //     $("#msgError").text(
    //         "Veuillez renseigner le contact au bloc 'N°1' !"
    //     );
    //     $('#errorOperation').modal('show');
    //     $('#email').focus();
    // } else {
    //     if (email == null || email == "") {
    //         $("#msgError").text(
    //             "Veuillez renseigner l'email du contact au bloc 'N°1' !"
    //         );
    //         $('#errorOperation').modal('show');
    //         $('#email').focus();
    //     } else {
    //         if (adresse == null || adresse == "") {
    //             $("#msgError").text(
    //                 "Veuillez renseigner l'adresse du rendez-vous au bloc 'N°5'!"
    //             );
    //             $('#errorOperation').modal('show');
    //             $('#email').focus();
    //         } else {
    //             //CONFIRM ADRESSE
    //             $('#confirmRDVRTModal').modal('show');
    //             // getDisponiblites();
    //         }
    //     }
    // }
    getDisponiblites2();
}

    function toggleAutreTypologie(isChecked) {
        $('#autreTypologie').toggle(isChecked);
        if (isChecked) {
            $('#autreTypologie').focus();
        }
    }

    $(document).ready(function() {
        // Initialize
        if ($('#autreTypologie').val()) {
            $('#categorie4').prop('checked', true);
            $('#autreTypologie').show();
        }
    });

    let currentStep = 0;
    //let stepAccueil = document.querySelectorAll(".stepAccueil");
    let steps = document.querySelectorAll(".stepAccueil");
    //let steps = document.querySelectorAll(".stepDSS");
    let prevBtn = document.getElementById("prevBtnAccueil");
    let nextBtn = document.getElementById("nextBtnAccueil");
    let finishBtn = document.getElementById("finishBtnAccueil");
    let indexPageDSS = document.getElementById('indexPageDSS');
    let pageIndex = 1;
    let numQuestionScript = 1;
    const history = [];
    let opCree = null;
    let signature = null;
    let siInterlocuteur = false;
    let typePage = "Accueil";

    var hidePlaceRdv1 = true,
        hidePlaceRdvbis = true;
    var hidePlaceRdv2 = true,
        hidePlaceRdv2bis = true;

    function finish(type) {
        if (type == 'DSS') {
            saveScriptPartiel('finDSS');
        } else {
            saveScriptPartiel('fin');
        }

    }
    function getInfoMail() {
        console.log(1)
    }
    function saveScriptPartiel(etape) {
        getInfoMail()
        let form = document.getElementById('scriptForm');
        const formData = new FormData(form);
        let causes = formData.getAll('cause[]');
        let dommages = formData.getAll('dommages[]');
        let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
        formData.append('type', 'CbB2b');
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

                // if (response != "0") {
                //     opCree = response;
                // }
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
                    0

                }
            },
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
        function selectRadio(button) {
        const radio = button.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
    }
        function onClickResponsable(val) {
        if (val == "oui") {
            $("#sous-question-0").attr("hidden", "hidden");
        } else {
            $("#sous-question-0").removeAttr("hidden");
        }
    }


    function goNext(type) {

        if (type == "Accueil") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="responsable"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") {
                    $("#sous-question-0").attr("hidden", "hidden");
                    return showStep(1);
                } else {
                    $("#sous-question-0").removeAttr("hidden");
                    return showStep(1);
                }

            }
        }

        if (type == "IndisponibelRappel") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siDsiponible"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "Refus RDV") {
                    return showBody('MessageFin');
                } else {
                    var div = document.getElementById('place-date-heure-rdv');
                    if (dateRDV == "") {
                        $("#msgError").text("Veullez prendre le rendez-vous !");
                        $('#errorOperation').modal('show');
                    } else {
                        div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                        return showBody('MessageFinRDVRelance');
                    }
                }

            }
        }

        if (type == "PartenaireExistant") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siExistePartenaireRep"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") {
                    return showBody('PresentationPartenariat');
                } else {
                    return showBody('MessageFin');
                }

            }
        }

        if (type == "QuelAvantages") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siAccepteSuiteQuelAvantage"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") {
                    return showBody('PresentationPartenariat');
                } else {
                    return showBody('MessageFin');
                }
            }
        }

        if (type == "PasDetemps") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siAccepteSuitePasTemps"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") {
                    return showBody('PresentationPartenariat');
                } else {
                    return showBody('MessageFin');
                }
            }
        }

        if (type == "MefianceInconnu") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siRDVMefianceInconnu"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "non") {
                    return showBody('MessageFin');
                } else {
                    var div = document.getElementById('place-date-heure-rdv');
                    if (dateRDV == "") {
                        $("#msgError").text("Veullez prendre le rendez-vous !");
                        $('#errorOperation').modal('show');
                    } else {
                        div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                        return showBody('MessageFinRDVRelance');
                    }
                }
            }
        } else if (type == "PresentationPartenariat") {
            if (currentStep === 0) {
                let activiteRadio = document.querySelector('input[name="activiteRadio"]:checked');
                //console.log("activiteRadio.value "+activiteRadio.value);
                if (activiteRadio) {
                    let autreActivite = document.getElementById("autreActivite");
                    if (activiteRadio.value == "Autres" && autreActivite.value == "") {
                        $("#msgError").text("Veuillez saisir l'activité !");
                        $('#errorOperation').modal('show');
                        return;
                    }
                } else {
                    $("#msgError").text("Veuillez sélectionner au moins une activité !");
                    $('#errorOperation').modal('show');
                    return;
                }

                if (regionsChoosed.length == 0) {
                    $("#msgError").text("Veuillez sélectionner au moins une région !");
                    $('#errorOperation').modal('show');
                    return;
                } else {
                    let regionLibelles = '';
                    regionsChoosed.forEach(reg => {
                        regionLibelles += regionLibelles == '' ? reg[1] : ', ' + reg[1];
                    });
                    document.getElementById("place-regions").innerHTML = regionLibelles;
                    return showStep(1);
                }
            } else if (currentStep === 8) {
                let activiteRadio = document.querySelector('input[name="activiteRadio"]:checked');
                if (activiteRadio.value == "Gardiennage") {
                    $("#bloc-gardiennage").removeAttr("hidden");
                } else {
                    $("#bloc-gardiennage").attr("hidden", "hidden");
                }


                if (activiteRadio.value == "Nettoyage") {
                    $("#bloc-Nettoyage").removeAttr("hidden");
                } else {
                    $("#bloc-Nettoyage").attr("hidden", "hidden");
                }

                if (activiteRadio.value == "Maintenance") {
                    $("#bloc-maintenance").removeAttr("hidden");
                } else {
                    $("#bloc-maintenance").attr("hidden", "hidden");
                }

                if (activiteRadio.value == "Autres") {
                    $("#bloc-autre").removeAttr("hidden");
                } else {
                    $("#bloc-autre").attr("hidden", "hidden");
                }

                return showStep(9);
            }
        } else if (type == "SD") {
            if (currentStep === 0) {
                const val = document.querySelector('input[name="siSignDeleg"]:checked');
                if (!val) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val.value == "oui") return showStep(1);
                if (val.value === "non") {
                    // document.getElementById('textClotureSD').innerHTML =
                    //     "Je comprends que vous ne voulez pas signer de délégation. (RDV A PROGRAMMER POUR UN SUPERVISEUR) Puis-je avoir votre email  pour vous envoyer une documentation ?";
                    // $("#reponseDoc").removeAttr("hidden");
                    // $("#divEnvoiDoc").removeAttr("hidden");
                    return showStep(9);
                }
                if (val.value == "plusTard") return showStep(8);
            }

            if (currentStep === 1) {
                if ($("#prenomSignataire").val() == "" || $("#nomSignataire").val() == "" || $("#dateNaissance").val() ==
                    "") {
                    $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
                    $('#errorOperation').modal('show');
                    return;
                }
            }

            if (currentStep === 2) {
                if ($("#adresseImm").val() == "" || $("#cP").val() == "" || $("#ville").val() == "" || $("#etage").val() ==
                    "" || $("#porte").val() == "") {
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
                    //Envoyer Code pour signature
                    onClickTerminerAssistant();
                    return;
                }

            }

            if (currentStep === 7) {
                onClickValidSignature();
                return;
                // return showStep(8)
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
                            "Oui effectivement, je note bien que certains documents vous manquent, c’est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
                        );
                    } else {
                        if (val.value == "signatureComplique") {
                            $(`#textClotureSD`).text(
                                "Je comprends parfaitement. Soyez rassuré(e), c’est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                            );
                        } else {
                            if (val.value == "prendreConnaissance") {
                                $(`#textClotureSD`).text(
                                    "C'est tout à fait normal et même recommandé. Je vous propose de vous envoyer immédiatement la délégation par mail accompagnée d’une courte présentation de nos services pour que vous puissiez en prendre connaissance tranquillement. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, en toute sérénité."
                                );
                            } else {

                            }
                        }
                    }
                }
                return showStep(9)
            }
        } else if (type == "RvRT") {
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
        } else if (type == "RvPerso") {
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



    function typeReunionChange(val) {
        if (val == "Visioconférence") {
            $("#imputLienVisioconference").removeAttr("hidden");
        } else {
            $("#imputLienVisioconference").attr("hidden", "hidden");
        }
    }

    /************ Debut activité, région département ***************/
    var regionsChoosed = [],
        departementChoosed = [];

    function functionActivite(value) {
        if (value == "Autres") {
            $(`#autreActivite`).removeAttr('hidden');
        } else {
            $(`#autreActivite`).attr('hidden', '');
        }
    }

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
        console.log(departementChoosed)
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
                    console.log(departements)
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
                //console.log(regions);
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

    $(document).ready(function() {
        getRegionsFrance();
    });
    /************ Fin activité, région département ***************/

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
            // console.log(item);
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

            }

        });
    }

    function afficheBy10InTable2() {
        var test = 0;
        var kD = k;
        first = k;
        $('#divTabDisponibilite2').empty();
        var html =
            `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
        if (tab.length != 0) {
            for (var i = 0; i < 2; i++) {
                html += `<tr class="tr">`;
                for (var j = 0; j < 5; j++) {
                    html +=
                        `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
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
        $('#divTabDisponibilite2').append(html);
        nbDispo = k - kD;
        //recuperer la valeur d4une cellule
        $(".tdClass").click(function() {
            $("#INFO_RDV").text("");
            $('#divPriseRvRT').attr("hidden", "hidden");
            $('#expertRV').attr("value", "");
            $('#idExpertRV').attr("value", "0");
            $('#dateRV').attr("value", "");
            $('#heureRV').attr("value", "");
            $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
            // $(".tr > td").css("background-color", "white");
            // $(this).closest("td").css("background-color", "lightgray");
            $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
            // $(this).closest("td").css("position", "relative");
            // $(this).closest("td").css("z-index", "2");
            var item = $(this).closest("td").html();
            // console.log(item);
            let nomCommercial = item.split("<br>")[0];
            let DATE_RV = item.split("<br>")[1];
            let HEURE_D = item.split("<br>")[2].split("-")[0];
            let HEURE_F = item.split("<br>")[2].split("-")[1];
            idCommercialRDV = item.split("<br>")[3].split("-")[1];
            let marge = item.split("<br>")[3].split("-")[2];
            let DUREE = item.split("<br>")[3].split("-")[3];
            // console.log(idCommercialRDV);
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
            //NEW
            // $("#INFO_RDV").text("RDV à prendre pour " + nomCommercial + " le " + DATE_RV + " de " +
            //     HEURE_D + " à " + HEURE_F);
            // $('#expertRV').attr("value", nomCommercial);
            // $('#idExpertRV').attr("value", idCommercialRDV);
            // $('#dateRV').attr("value", DATE_RV.replace(" ", "").split(' ')[1]);
            // $('#heureRV').attr("value", HEURE_D + "-" + HEURE_F);
            // $('#divPriseRvRT').removeAttr("hidden");
        });
    }

    function getDisponiblites2() {
        let post = {
            adresseRV: $('#adresseImm').val(),
            codePostal: $('#cP').val(),
            ville: $('#ville').val(),
            batiment: "",
            etage: "",
            libelleRV: "",
            batiment: "",
            etage: "",
            libelleRV: "",
            idUser: <?= $idAuteur ?>,
            nomUserRV: "<?= $auteur ?>",
            organisateurs: [{
                "id": 3,
                "nom": "Ben PADONOU"
            }, {
                "id": 162,
                "nom": "Narcisse DJOSSINOU"
            }]
        }
        $.ajax({
            url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=cb&origine=web&forcage=0`,
            type: 'POST',
            data: (post),
            dataType: "JSON",
            beforeSend: function() {
                $('#divChargementNotDisponibilite2').attr("hidden", "hidden");
                $('#divChargementDisponibilite2').removeAttr("hidden");
                // $("#msgLoading").text("Chargement agenda en cours ...");
                // $("#loadingModal").modal("show");
            },
            success: function(result) {
                console.log(result);
                // setTimeout(() => {
                //     $("#loadingModal").modal("hide");
                // }, 1000);
                $('#divChargementDisponibilite2').attr("hidden", "hidden");
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
                        afficheBy10InTable2();
                        $('#divPriseRvRT-2').removeAttr("hidden");
                        if (nbPage == 1) {
                            $('#btnPrecedentRDV2').attr("hidden", "hidden");
                        } else {
                            $('#btnPrecedentRDV2').removeAttr("hidden");
                        }
                        if (nbPage == nbPageTotal) {
                            $('#btnSuivantRDV2').attr("hidden", "hidden");
                        } else {
                            $('#btnSuivantRDV2').removeAttr("hidden");
                        }
                    }
                } else {
                    $('#divChargementDisponibilite2').attr("hidden", "hidden");
                    $('#divChargementNotDisponibilite2').removeAttr("hidden");
                }

            },
            error: function(response) {
                $('#btnRvRT').removeAttr("hidden");
                $('#divPriseRvRT-2').attr("hidden", "hidden");
                $('#divPriseRvRT').attr("hidden", "hidden");
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 1000);
                console.log("Erreur")
                console.log(response)
                // $("#msgError").text(
                //     "Impossible de charger les disponibilités, Veuillez réessayer ou contacter le support"
                // );
                // $('#errorOperation').modal('show');
                $('#divChargementDisponibilite2').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite2').removeAttr("hidden");
            }
        });
    }

    function htmlRDV2() {
        const htmlRDV = `<hr>
                            <div class="col-md-12" id="divChargementDisponibilite2" hidden>
                                <div class="font-weight-bold text-center text-success">
                                    <span class="text-center">Chargement des disponibilités en cours...</span>
                                </div>
                            </div>
                            <div class="col-md-12" id="divChargementNotDisponibilite2" hidden>
                                <div class="col-md-12 text-center">
                                    <div class="font-weight-bold text-center text-danger">
                                        <span class="text-center">Impossible de charger l'agenda, merci de réessayer en
                                            cliquant sur ce bouton (Si cela persiste, contactez l'administrateur)</span>

                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="pull-right page-item col-md-6 p-0 m-0"><a type="button"
                                            class="text-center btn btn-success" onclick="onClickPrendreRvRT2()">
                                            Charger Agenda</a></div>
                                </div>
                            </div>
                            <div class="col-md-12" id="divPriseRvRT-2" hidden>
                                <div class="col-md-12 text-center" hidden>
                                    <div class="font-weight-bold text-center">
                                        <span class="text-center">Un rendez-vous ne peut pas être pris après le
                                            '<?= date('d/m/Y', strtotime('+16 day'))  ?>', proposez de rappeler l'assuré
                                            dans ce cas</span>
                                    </div>
                                </div>
                                <div class="row mt-2 mb-2 ml-2">
                                    <div class="col-md-12 row">
                                        <div class="col-md-3 row">
                                            <div class="col-md-2" style="background-color: #d3ff78;">

                                            </div>
                                            <div class="col-md-10">
                                                <span>Même Date & Même Heure</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 row">
                                            <div class="col-md-2" style="background-color: lightblue;">

                                            </div>
                                            <div class="col-md-10">
                                                <span>Même Date mais Heure différente</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 row">
                                            <div class="col-md-2" style="background-color: #ffc020;">

                                            </div>
                                            <div class="col-md-10">
                                                <span>Date différente</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 row">
                                            <div class="col-md-2" style="background-color: #FF4C4C;">

                                            </div>
                                            <div class="col-md-10">
                                                <span>Expert Sans RDV</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="divTabDisponibilite2">

                                </div>
                                <div>
                                    <div class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                        <div class="pull-left page-item col-md-6 p-0 m-0">
                                            <div id="btnPrecedentRDV2">
                                                <a type="button" class="text-center btn"
                                                    style="background-color: grey;color:white"
                                                    onclick="onClickPrecedentRDV2()">Dispos Prec. << </a>
                                            </div>
                                        </div>
                                        <div id="btnSuivantRDV2" class="pull-right page-item col-md-6 p-0 m-0"><a
                                                type="button" class="text-center btn"
                                                style="background-color: grey;color:white"
                                                onclick="onClickSuivantRDV2()">>>
                                                Dispos Suiv.</a></div>
                                    </div>
                                </div>
                                <div id="divTabHoraire2">

                                </div>
                                <div class="mt-5 text-center">
                                    <h4 class="text-center font-weight-bold" id="INFO_RDV2"></h4>
                                </div>
                            </div>`;
        return htmlRDV;
    }

    function htmlRDV1() {
        const htmlRDV = `<hr>
                    <div class="col-md-12" id="divChargementDisponibilite" hidden>
                        <div class="font-weight-bold text-center text-success">
                            <span class="text-center">Chargement des disponibilités en cours...</span>
                        </div>
                    </div>
                    <div class="col-md-12" id="divChargementNotDisponibilite" hidden>
                        <div class="col-md-12 text-center">
                            <div class="font-weight-bold text-center text-danger">
                                <span class="text-center">Impossible de charger l'agenda, merci de réessayer en
                                    cliquant sur ce bouton (Si cela persiste, contactez l'administrateur)</span>

                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="pull-right page-item col-md-6 p-0 m-0"><a type="button"
                                    class="text-center btn btn-success" onclick="onClickPrendreRvRT()">
                                    Charger Agenda</a></div>
                        </div>
                    </div>
                    <div class="col-md-12" id="divPriseRvRT-1" hidden>
                        <div class="col-md-12 text-center" hidden>
                            <div class="font-weight-bold text-center">
                                <span class="text-center">Un rendez-vous ne peut pas être pris après le
                                    '<?= date('d/m/Y', strtotime('+16 day'))  ?>', proposez de rappeler l'assuré
                                    dans ce cas</span>
                            </div>
                        </div>
                        <div class="row mt-2 mb-2 ml-2">
                            <div class="col-md-12 row">
                                <div class="col-md-3 row">
                                    <div class="col-md-2" style="background-color: #d3ff78;">

                                    </div>
                                    <div class="col-md-10">
                                        <span>Même Date & Même Heure</span>
                                    </div>
                                </div>
                                <div class="col-md-3 row">
                                    <div class="col-md-2" style="background-color: lightblue;">

                                    </div>
                                    <div class="col-md-10">
                                        <span>Même Date mais Heure différente</span>
                                    </div>
                                </div>
                                <div class="col-md-3 row">
                                    <div class="col-md-2" style="background-color: #ffc020;">

                                    </div>
                                    <div class="col-md-10">
                                        <span>Date différente</span>
                                    </div>
                                </div>
                                <div class="col-md-3 row">
                                    <div class="col-md-2" style="background-color: #FF4C4C;">

                                    </div>
                                    <div class="col-md-10">
                                        <span>Expert Sans RDV</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="divTabDisponibilite">

                        </div>
                        <div>
                            <div class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                <div class="pull-left page-item col-md-6 p-0 m-0">
                                    <div id="btnPrecedentRDV">
                                        <a type="button" class="text-center btn"
                                            style="background-color: grey;color:white"
                                            onclick="onClickPrecedentRDV()">Dispos Prec. << </a>
                                    </div>
                                </div>
                                <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0"><a
                                        type="button" class="text-center btn"
                                        style="background-color: grey;color:white"
                                        onclick="onClickSuivantRDV()">>>
                                        Dispos Suiv.</a></div>
                            </div>
                        </div>
                        <div id="divTabHoraire">


                        </div>
                        <div class="mt-5 text-center">
                            <h4 class="text-center font-weight-bold" id="INFO_RDV"></h4>
                        </div>
                    </div>`;
        return htmlRDV;
    }

    function onClickSiRDVMefianceInconnu(val) {
        if (val == "oui") {
            if (hidePlaceRdv2) {
                dateRDV = "";
                document.getElementById("div-prise-rdv2").innerHTML = htmlRDV2();
                getDisponiblites2();


                $("#div-prise-rdv2").removeAttr("hidden");
                $("#divChargementDisponibilite2").removeAttr("hidden");
                hidePlaceRdv2 = false;
                hidePlaceRdv2bis = true;
            }
        } else {
            $("#div-prise-rdv2").attr("hidden", "hidden");
            $("#divChargementDisponibilite2").attr("hidden", "hidden");
            hidePlaceRdv2 = true;
            document.getElementById("div-prise-rdv2").innerHTML = '';
        }
    }

    function onClickSiRDVRappel(val) {
        if (val == "Refus RDV") {
            $("#div-prise-rdv").attr("hidden", "hidden");
            $("#divChargementDisponibilite").attr("hidden", "hidden");
            hidePlaceRdv1 = true;
            document.getElementById("div-prise-rdv").innerHTML = '';
        } else {
            if (hidePlaceRdv1) {
                dateRDV = "";
                document.getElementById("div-prise-rdv").innerHTML = htmlRDV1();
                getDisponiblites("");


                $("#div-prise-rdv").removeAttr("hidden");
                $("#divPriseRvRT-1").removeAttr("hidden");
                $("#divChargementDisponibilite").removeAttr("hidden");
                hidePlaceRdv1 = false;
                hidePlaceRdvbis = true;
            }
        }
    }


    // Gérer l'état "pinned"
    document.addEventListener('click', function(e) {
        const allTooltips = document.querySelectorAll('.tooltip-content');
        let clickedOnTooltip = false;

        document.querySelectorAll('.tooltip-container').forEach(container => {
            const content = container.querySelector('.tooltip-content');

            if (container.contains(e.target)) {
                clickedOnTooltip = true;

                // Toggle pinned state
                if (content.classList.contains('pinned')) {
                    content.classList.remove('pinned');
                } else {
                    allTooltips.forEach(t => t.classList.remove('pinned'));
                    content.classList.add('pinned');

                    // Gérer la position dynamiquement
                    const rect = content.getBoundingClientRect();
                    const spaceAbove = rect.top;
                    const spaceBelow = window.innerHeight - rect.bottom;

                    // Si pas assez de place au-dessus, ouvrir vers le bas
                    if (spaceAbove < 100 && spaceBelow > spaceAbove) {
                        content.style.top = '125%';
                        content.style.bottom = 'auto';
                        content.querySelector('::after')?.remove();
                        content.style.setProperty('--tooltip-arrow-direction', 'down');
                        content.style.transform = 'translateX(-50%)';
                        content.style.setProperty('--arrow-border-color',
                            '#333 transparent transparent transparent');
                        content.style.setProperty('--arrow-top', '-8px');
                    } else {
                        content.style.bottom = '125%';
                        content.style.top = 'auto';
                    }
                }
            }
        });

        if (!clickedOnTooltip) {
            allTooltips.forEach(t => t.classList.remove('pinned'));
        }
    });

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
                // setTimeout(() => {
                //     $('#loadingModal').modal('hide');
                // }, 500);
                // $("#msgError").text("Impossible d'envoyer le mail !");
                // $('#errorOperation').modal('show');
            },
            complete: function() {

            },
        });
    }

    //NAVIGATION
    function updateButtons() {
        indexPageDSS.innerText = pageIndex;
        prevBtn.classList.toggle("hidden", currentStep === 0);

        if (typePage == "Accueil") {
            nextBtn.classList.toggle("hidden", currentStep === 3);
            finishBtn.classList.toggle("hidden", currentStep !== 3);
        }

        if (typePage == "IndisponibelRappel") {
            nextBtn.classList.toggle("hidden", currentStep === 1);
            finishBtn.classList.toggle("hidden", currentStep !== 1);
        }

        if (typePage == "PartenaireExistant") {
            console.log("typePage :" + typePage);
            nextBtn.classList.toggle("hidden", currentStep === 1);
            finishBtn.classList.toggle("hidden", currentStep !== 1);
        }

        if (typePage == "QuelAvantages") {
            nextBtn.classList.toggle("hidden", currentStep === 1);
            finishBtn.classList.toggle("hidden", currentStep !== 1);
        }

        if (typePage == "PasDetemps") {
            nextBtn.classList.toggle("hidden", currentStep === 1);
            finishBtn.classList.toggle("hidden", currentStep !== 1);
        }

        if (typePage == "MefianceInconnu") {
            nextBtn.classList.toggle("hidden", currentStep === 1);
            finishBtn.classList.toggle("hidden", currentStep !== 1);
        }

        if (typePage == "PresentationPartenariat") {
            nextBtn.classList.toggle("hidden", currentStep === 9);
            finishBtn.classList.toggle("hidden", currentStep !== 9);
        }

        if (typePage == "MessageFin") {
            nextBtn.classList.toggle("hidden", currentStep === 0);
            finishBtn.classList.toggle("hidden", currentStep !== 0);
        }

        if (typePage == "MessageFinRDVRelance") {
            nextBtn.classList.toggle("hidden", currentStep === 0);
            finishBtn.classList.toggle("hidden", currentStep !== 0);
        }



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
    }

    function goBackScript(type) {
        console.log('steps[currentStep] :' + currentStep);
        if (history.length === 0) return;
        pageIndex--;
        steps[currentStep].classList.remove("active");
        currentStep = history.pop();
        steps[currentStep].classList.add("active");
        updateButtons();
    }


    updateButtons();

    const refs = document.querySelectorAll('[ref]');
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

    //SHOW BODY
    function showBody(idAffiche) {
        getInfoMail()
        typePage = idAffiche;
        // const btns = document.querySelectorAll('#sidebar a');
        // btns.forEach(btn => {
        //     btn.setAttribute('style', 'background-color: dodgerblue');
        //     btn.addEventListener('click', (e) => {
        //         btn.setAttribute('style',
        //             'background-color: deepskyblue; box-shadow: 2px 2px 5px 2px #A31C27');
        //     });
        // });

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

        let myCpt = -1;
        steps.forEach(oneSptape => {
            myCpt++;
            steps[myCpt].classList.remove("active");
        });
        showStep(currentStep);
        pageIndex = 1;
        updateButtons();

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
                    // setTimeout(() => {
                    //     $('#loadingModal').modal('hide');
                    // }, 500);
                    // $("#msgSuccess").text("Envoi de documentation effectué avec succés!");
                    // $('#successOperation').modal('show');

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



    function showModalSendDoc() {

        getInfoMail();
        $('#modalEnvoiDoc').modal('show');
    }

    onChangeTypeSin();

    function onChangeTypeSin() {
        let id = "";
        const typeSinistre = document.getElementById('typeSinistre');
        let dommages = [];
        // $(`#textConfirmPriseEnCharge`).text('Est-ce que les travaux de remise en état ont été réalisés ?');
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
                                $(`#textDommages`).text(
                                    "Pouvez-vous me décrire les dégâts causés par l'événment climatique ?");
                                dommages = [];
                            } else {
                                if (typeSinistre.value == "vol") {
                                    $(`#textDommages`).text("Pouvez-vous me décrire les dégâts causés par le vol ?");
                                    $dommages = ["Porte/fenêtre fracturée", "Serrure endommagée ou forcée",
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
        const dommagesCoches =
            '<?= $questScript ? $questScript->dommages : '' ?>' // <- récupéré depuis PHP ou du formulaire
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
        $('#dateFinContrat').attr("value", (date.getFullYear() + 1) + "-" + String(date.getMonth() + 1).padStart(2,
            '0') + "-" + String(date.getDate()).padStart(2, '0'));
    }

    function showSousQuestion(idSS, $show) {
        if ($show) {
            $(`#sous-question-${idSS}`).removeAttr('hidden');
        } else {
            $(`#sous-question-${idSS}`).attr('hidden', '');
        }

    }

    function onClickTerminerAssistant() {
        $("#msgLoading").text("Enregistrement en cours...");
        $('#loadingModal').modal('show');
        // let resultatActivityTE = $('#resultatActivityTE').val();
        //Save INFOS IMMEUBLE
        // AddOrEditImmeuble('editLot');

        // addOrupdateContact('update');
        //SAVE TE

        // saveCauses('fin');
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
                    //Send Code
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
                                // $('#btnSignTerminer').attr("hidden", "hidden");
                                // $('#divSign7').attr("hidden", "hidden");
                                // $('#divCodeSign').removeAttr("hidden");
                                // $('#btnSignFinaliser').removeAttr("hidden");
                                showStep(7)
                            } else {
                                $("#msgError").text(
                                    "(1)Impossible de générer le code, Veuillez réessayer ou contacter l'administrateur"
                                );
                                $('#errorOperation').modal('show');
                            }
                        },
                        error: function(response1) {
                            setTimeout(() => {
                                $("#loadingModal").modal("hide");
                            }, 500);
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

                //SIGNATURE
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
                            $("#msgError").text(
                                "(1)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !"
                            );
                            $('#errorOperation').modal('show');
                        }

                    },
                    error: function(response) {
                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);

                        console.log("ko");
                        console.log(response);
                        $("#msgError").text(
                            "(2)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !"
                        );
                        $('#errorOperation').modal('show');
                    },
                    complete: function() {},
                });
            }
        } else {
            $("#msgError").text(
                "(3)Impossible de signer le document, Veuillez réessayer ou contacter l'administrateur !");
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

                // console.log(response);
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
                // divInfosCie
                $('#divInfosCie').removeAttr("hidden");
                $('#divInfosPasCie').attr("hidden", "hidden");
                $('#selectCompany').modal('hide');

            },
            error: function(response) {
                console.log(response);
                $('#selectCompany').modal('hide');
                $("#msgError").text(
                    "Erreur de choisir une compagnie"
                );
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

    //RV RT
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
        let organisateurs = [];
        let source = "wbcc";
        let forcage = 1
        if (type == 'Sup') {
            source = "cb"
            forcage = 0
            organisateurs = [{
                "id": 3,
                "nom": "Ben PADONOU"
            }, {
                "id": 162,
                "nom": "Narcisse DJOSSINOU"
            }];
        }

        let post = {
            adresseRV: type == 'Sup' ? $('#adresseImm').val() : "",
            codePostal: type == 'Sup' ? $('#cP').val() : "",
            ville: type == 'Sup' ? $('#ville').val() : "",
            batiment: "",
            etage: "",
            libelleRV: "",
            batiment: "",
            etage: "",
            libelleRV: "",
            idUser: <?= $idAuteur ?>,
            nomUserRV: "<?= $auteur ?>",
            organisateurs: organisateurs
        }

        $.ajax({
            url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=${source}&origine=web&forcage=${forcage}`,
            type: 'POST',
            data: (post),
            dataType: "JSON",
            beforeSend: function() {
                // $('#divChargementNotDisponibilite').attr("hidden", "hidden");
                // $('#divChargementDisponibilite').removeAttr("hidden");
                // $("#msgLoading").text("Chargement agenda en cours ...");
                // $("#loadingModal").modal("show");
            },
            success: function(result) {
                // setTimeout(() => {
                //     $("#loadingModal").modal("hide");
                // }, 1000);
                $('#divChargementDisponibilite').attr("hidden", "hidden");
                console.log('result dispos');
                console.log(result);

                if (result !== null && result != undefined) {
                    if (result.length == 0) {
                        $('#notDisponibilite').removeAttr("hidden");
                    } else {
                        tab = result;
                        taille = tab.length;
                        nbPageTotal = Math.ceil(tab.length / 10);
                        nbPage++;
                        afficheBy10InTable(type);

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
                // $("#msgError").text(
                //     "Impossible de charger les disponibilités, Veuillez réessayer ou contacter le support"
                // );
                // $('#errorOperation').modal('show');
                $('#divChargementDisponibilite').attr("hidden", "hidden");
                $('#divChargementNotDisponibilite').removeAttr("hidden");
            }
        });
    }


    function onClickEnregistrerRV(type) {
        // let expert = document.getElementById('expertRV');
        // let idExpert = expert.options[expert.selectedIndex].value;
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
                            $("#msgError").text(
                                "Cette disponibilité est invalide, veuillez choisir une autre !"
                            );
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
                        $("#msgError").text(
                            "(1)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !"
                        );
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(response) {
                    setTimeout(() => {
                        $("#loadingModal").modal("hide");
                    }, 500)
                    console.log(response);
                    $("#msgError").text(
                        "(2)Impossible d'enregistrer un RDV! Réessayer ou contacter l'administrateur !");
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
        console.log("type =" + type);
        var test = 0;
        var kD = k;
        first = k;
        console.log(`#divTabDisponibilite${type}`);

        $(`#divTabDisponibilite${type}`).empty();
        var html =
            `<table style="font-weight:bold; font-size:15px; " id="table" border ="1" width="100%" cellpadding="10px"><tr><th colspan="7">DISPONIBLITES DES EXPERTS- Page${nbPage}/${nbPageTotal}</th></tr>`;
        if (tab.length != 0) {
            for (var i = 0; i < 2; i++) {
                html += `<tr class="tr">`;
                for (var j = 0; j < 5; j++) {
                    html +=
                        `<td style="background-color : ${tab[k].couleur}" class="tdClass"  align="center" id="cel${k}" value="${k}"> ${tab[k].commercial} <br> ${tab[k].date} <br> ${tab[k].horaire}<br><span hidden="">-${tab[k].idCommercial}-${tab[k].marge}-${tab[k].duree}min -</span></td>`;
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

        //recuperer la valeur d4une cellule
        $(".tdClass").click(function() {
            $(`#INFO_RDV${type}`).text("");
            $('#divPriseRvRT').attr("hidden", "hidden");
            $('#expertRV').attr("value", "");
            $('#idExpertRV').attr("value", "0");
            $('#dateRV').attr("value", "");
            $('#heureRV').attr("value", "");
            $(".tr > td").css("box-shadow", "0px 0px 0px 0px lightgray");
            // $(".tr > td").css("background-color", "white");
            // $(this).closest("td").css("background-color", "lightgray");
            $(this).closest("td").css("box-shadow", " 1px 1px 5px 5px  #e74a3b");
            // $(this).closest("td").css("position", "relative");
            // $(this).closest("td").css("z-index", "2");
            var item = $(this).closest("td").html();
            // console.log(item);
            let nomCommercial = item.split("<br>")[0];
            let DATE_RV = item.split("<br>")[1];
            let HEURE_D = item.split("<br>")[2].split("-")[0];
            let HEURE_F = item.split("<br>")[2].split("-")[1];
            idCommercialRDV = item.split("<br>")[3].split("-")[1];
            let marge = item.split("<br>")[3].split("-")[2];
            let DUREE = item.split("<br>")[3].split("-")[3];
            // console.log(idCommercialRDV);
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

            afficheNewTable(nomCommercial, DATE_RV, DUREE, type);
            //NEW
            // $("#INFO_RDV").text("RDV à prendre pour " + nomCommercial + " le " + DATE_RV + " de " +
            //     HEURE_D + " à " + HEURE_F);
            // $('#expertRV').attr("value", nomCommercial);
            // $('#idExpertRV').attr("value", idCommercialRDV);
            // $('#dateRV').attr("value", DATE_RV.replace(" ", "").split(' ')[1]);
            // $('#heureRV').attr("value", HEURE_D + "-" + HEURE_F);
            // $('#divPriseRvRT').removeAttr("hidden");
        });
    }


    function afficheNewTable(nomCommercial, date, duree, type = "") {
        $(`#divTabHoraire${type}`).empty();
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
        $(`#divTabHoraire${type}`).append(html);

        $(".ntdClass").click(function() {
            $(".ntr > td").css("background-color", "lightgray");
            $(this).closest("td").css("background-color", "#e74a3b");
            var item = $(this).closest("td").html();
            // console.log(item);
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
            let adresseCompany = $('#businessLine1').val() + " " + $('#businessPostalCode').val() + " " + $(
                '#businessCity').val();
            console.log(nom);
            console.log(adresseCompany);
            console.log(emailG);

            if (idCommercialRDV != "0") {
                $(`#INFO_RDV${type}`).text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " +
                    heureDebutRDV + " à " + heureFinRDV);
                $(`#divBtnSaveRV${type}`).removeAttr('hidden');
                $('#expertRV').attr("value", commercialRDV);
                $('#idExpertRV').attr("value", idCommercialRDV);
                $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
                $('#heureDebut').attr("value", heureDebutRDV);
                $('#heureFin').attr("value", heureFinRDV);
                $('#divPriseRvRT').removeAttr("hidden");
                $('#commentaireRV').html(
                    `Infos Contact : ${civilite} ${prenom} ${nom} <br> Tel : ${tel} Email : ${emailG} <br><br> Infos Société : ${nomCompany} <br> Adresse : ${adresseCompany} <br> Tel : ${telCompany} Email : ${emailCompany} `
                );
            }

        });
    }

    $(document).ready(function() {
        //showBody('Accueil');
    });
</script>

<?php
// include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>