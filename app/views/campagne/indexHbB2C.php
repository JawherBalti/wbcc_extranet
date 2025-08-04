<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;
$isConsigneHidden = false;

function checked($field, $value, $object, $action)
{
    return $object && isset($object->$field) && $object->$field == $value ? $action : '';
}

?>

<div class="options-container col-md-11" hidden>
    <div class="row col-md-12 mt-2">
        <div class="col-md-4">
            <div>
                <label for="">Adresse <small class="text-danger">*</small></label>
            </div>
            <div>
                <input class="form-control" type="text" name="adresse" id="adresseImm"
                    value="<?= $company->businessLine1 ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <label for="">Code Postal <small class="text-danger">*</small></label>
            </div>
            <div>
                <input class="form-control" type="text" name="cp" id="cP" value="<?= $company->businessPostalCode ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div>
                <label for="">Ville <small class="text-danger">*</small></label>
            </div>
            <div>
                <input class="form-control" type="text" name="ville" id="ville" value="<?= $company->businessCity ?>">
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

<style>
    .step {
        display: none;
    }

    .step.active {
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
</style>
<!-- les modal pour la liste des notes -->
<div class="modal fade" id="modalListNotes" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h2 class="text-center font-weight-bold">LISTE DES NOTES</h2>
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
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Fermer</a>
            </div>
        </div>
    </div>
</div>

<!-- les modal pour Envoi de Documentation -->
<div class="modal fade" id="modalEnvoiDoc" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-info text-white">
                <h2 class="text-center font-weight-bold text-uppercase">envoi documentation</h2>
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
                                value="<?= $_SESSION['connectedUser']->prenomContact . ' ' . $_SESSION['connectedUser']->nomContact ?>">
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
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Annuler</a>
                <a href="javascript:void(0)" onclick="sendDocumentation()" class="btn btn-info">Envoyer</a>
            </div>
        </div>
    </div>
</div>

<?php
include_once dirname(__FILE__) . '/../crm/blocs/boitesModal.php';
?>
<input type="hidden" id="contextType" value="<?= 'company' ?>">

<!-- les modal pour les ajout et edit de compagnie -->
<div class="modal fade" id="selectCompany" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" method="POST" action="" id="formChoiceCie">
            <input name="oldIdCie" id="oldIdCie" value="<?= isset($cie) &&  $cie ? $cie->idCompany : "" ?>" hidden>
            <input name="action" value="" id="action" hidden>
            <div class="modal-header bg-secondary text-white">
                <h2 class="text-center font-weight-bold">Choisissez une compagnie</h2>
                <button hidden type="" onclick="showModalAddCompany()" id="" class="btn btn-info">Ajouter</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>Nom Compagnie</th>
                                <th>Adresse</th>
                                <th>Email</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($tousCieAssurance))
                                foreach ($tousCieAssurance as $cie1) {
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="oneselectionCie" name="oneselectionCie"
                                            value="<?= $cie1->idCompany ?>;<?= $cie1->numeroCompany ?>">
                                    </td>
                                    <td><?= $i++ ?></td>
                                    <td><?= $cie1->name ?></td>
                                    <td><?= $cie1->businessLine1 ?></td>
                                    <td><?= $cie1->email ?></td>
                                    <td><?= $cie1->businessPhone ?></td>
                                </tr>
                            <?php  }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Annuler</a>
                <a href="javascript:void(0)" onclick="AddOrEditCie()" class="btn btn-success">Valider</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="selectCompany" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" method="POST" action="" id="formChoiceCie">
            <input name="oldIdCie" id="oldIdCie" value="<?= isset($cie) &&  $cie ? $cie->idCompany : "" ?>" hidden>
            <input name="action" value="" id="action" hidden>
            <div class="modal-header bg-secondary text-white">
                <h2 class="text-center font-weight-bold">Choisissez une compagnie</h2>
                <button hidden type="" onclick="showModalAddCompany()" id="" class="btn btn-info">Ajouter</button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-danger text-white">
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>Nom Compagnie</th>
                                <th>Adresse</th>
                                <th>Email</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            if (isset($tousCieAssurance))
                                foreach ($tousCieAssurance as $cie1) {
                            ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="oneselectionCie" name="oneselectionCie"
                                            value="<?= $cie1->idCompany ?>;<?= $cie1->numeroCompany ?>">
                                    </td>
                                    <td><?= $i++ ?></td>
                                    <td><?= $cie1->name ?></td>
                                    <td><?= $cie1->businessLine1 ?></td>
                                    <td><?= $cie1->email ?></td>
                                    <td><?= $cie1->businessPhone ?></td>
                                </tr>
                            <?php  }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a onclick="" class="btn btn-danger" data-dismiss="modal">Annuler</a>
                <a href="javascript:void(0)" onclick="AddOrEditCie()" class="btn btn-success">Valider</a>
            </div>
        </div>
    </div>
</div>


    <div class=" col-12">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">

            <div style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px;     background-color: #fff; text-align: center;">
                    <h2><span><i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i></span> Campagne production B2C HB Assurance - 
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/logo_Cabinet_Bruno.png" alt=""></h2>
                </div>

                <?=
                    include dirname(__FILE__) . '/blocs/formCbB2C.php';
                ?>
                <div class="script-container" style="margin-top:15px; padding:10px">
                    <form id="scriptForm">
                        <input hidden id="contextId" name="idCompanyGroup"
                            value="<?= $company ? $company->idCompany : 0 ?>">

                        <!-- Étape 0 : Presentation -->
                        <div class="step active">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "
                                    <li>• Commencez l’appel par une salutation chaleureuse mais très professionnelle.</li>
                                    <li>• Vérifiez rapidement et explicitement l’identité de votre interlocuteur particulier.</li>
                                    <li>• Si l’interlocuteur n’est pas la bonne personne, obtenez rapidement les bonnes
                                    coordonnées sans perdre de temps.</li>
                                    ";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                                <p class="text-justify">
                                                    Bonjour, je suis ' . $connectedUser->fullName . ', conseiller chez HB Assurance. Je souhaiterais m’assurer que je m’adresse bien à ' . ($contact ? "à <b style=\"color: blue;\">{$contact->prenom} {$contact->nom}</b>," : "") . '. Est-ce bien le cas ?
                                                </p>';
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <?php
                                $name = 'prospectB2C';
                                $options = [
                                    [
                                        'onclick' => "onClickProspectB2C('oui');",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => "onClickProspectB2C('non');",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <div class="response-options" id="sous-question-0"
                                <?= $questScript && isset($questScript->prospectB2C) && $questScript->prospectB2C == 'non' ? "" : "hidden"; ?>>
                                <div class="options-container col-md-11">
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Civilités: <small class="text-danger">*</small>
                                            </label>
                                            <select class="form-control" name="civiliteProspect"
                                                id="civiliteProspect">
                                                <option value="">--Choisir--</option>
                                                <option value="Madame"
                                                    <?= !empty($contact) && ($contact->civilite == 'Mme' || $contact->civilite == 'Madame') ? 'Selected' : '' ?>>
                                                    Madame</option>
                                                <option value="Monsieur"
                                                    <?= !empty($contact) && ($contact->civilite == 'M' || $contact->civilite == 'Monsieur') ? 'Selected' : '' ?>>
                                                    Monsieur</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Prénom: <small class="text-danger">*</small>
                                            </label>
                                            <input type="text" class="form-control" id="prenomProspect"
                                                name="prenomProspect"
                                                value="<?= !empty($contact) ? $contact->prenom : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nom: <small class="text-danger">*</small>
                                            </label>
                                            <input type="text" class="form-control" id="nomProspect"
                                                name="nomProspect" value="<?= !empty($contact) ? $contact->nom : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Statut: <small class="text-danger">*</small>
                                            </label>
                                            <input class="form-control" type="text" name="posteProspect"
                                                value="<?= !empty($contact) ? $contact->statut : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Téléphone: <small class="text-danger">*</small>
                                            </label>
                                            <input type="text" class="form-control" id="telProspect"
                                                name="telProspect" value="<?= !empty($contact) ? $contact->tel : ''; ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Email: <small class="text-danger">*</small>
                                            </label>
                                            <input class="form-control" type="text" id="emailProspect"
                                                name="emailProspect"
                                                value="<?= !empty($contact) ? $contact->email : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 1 : -->
                        <div class="step">
                            <div class="question-box ">
                                    <?php 
                                        $consignes = "<li>• Présentez-vous clairement, brièvement et avec enthousiasme.</li>
                                                        <li>• Soulignez immédiatement l’avantage concurrentiel : indépendance et réduction des
                                                        coûts pour capter rapidement l’intérêt.</li>
                                                        <li>• Maintenez un ton chaleureux et rassurant pour mettre le prospect à l’aise dès le début de
                                                        l’appel.</li> ";
                                        $paragraph = '<p class="text-justify">
                                            Pour me présenter rapidement, je suis ' . $connectedUser->fullName . ', conseiller chez <strong>HB Assurance</strong>, cabinet
                                            indépendant spécialiste des assurances pour particuliers. Notre métier consiste à vous aider à
                                            réduire concrètement vos coûts d’assurance, tout en optimisant vos garanties.
                                            </p>';
                                                               
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                        </div>
                        

                        <!-- Etape 2 -->
                        <div class="step">
                            <div class="question-box">
                                <?php 
                                        $consignes = "<li>• Présentez immédiatement et clairement l’objet précis de votre appel pour capter
                                                    rapidement l’intérêt du particulier.</li>
                                                    <li>• Insistez sur la gratuité et l’absence totale d’engagement afin de rassurer immédiatement
                                                    votre interlocuteur.</li>
                                                    <li>• Soyez dynamique, positif et chaleureux pour créer immédiatement une ouverture à
                                                    l’échange.</li>";
                                        $paragraph = '<p class="text-justify">
                                            Je vous contacte dans le cadre d’une campagne entièrement gratuite d’information destinée à
                                            optimiser vos contrats d’assurance : <b style="color: green;">emprunteur</b> , <b style="color: green;">santé</b> , <b style="color: green;">prévoyance</b> , <b style="color: green;">automobile</b>
                                            ou encore <b style="color: green;">habitation</b> . L’objectif est simplement de vous permettre de réaliser rapidement
                                            des économies tout en améliorant vos garanties. 
                                        </p>';                 
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                            <?php
                            ?>
                        </div>

                        <!-- 5. Gestion des objections courantes -->
                        <!-- 5.2.1. Objection : « Je n’ai pas le temps / Je ne suis pas intéressé » -->
                        <!-- Etape 3 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "<li>• Vérifiez explicitement et rapidement la disponibilité du prospect pour poursuivre
                                                    l’échange.</li>
                                                    <li>• Soyez flexible en proposant immédiatement une alternative de rappel si nécessaire.</li>
                                                    <li>• Restez professionnel et respectueux du temps de votre interlocuteur.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                             Auriez-vous quelques instants à m’accorder dès maintenant afin que je puisse vous présenter
                                            rapidement comment vous pourriez bénéficier concrètement de ces économies, ou préférez-
                                            vous que nous programmions un rappel à un autre moment plus adapté pour vous ?
                                        </p>';                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <?php
                                $name = 'siOccupe';
                                $options = [
                                    [
                                        'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui, Présenter brièvement'
                                    ],
                                    [
                                        'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                        'btn_class' => 'warning',
                                        'value' => 'rdv',
                                        'label' => 'Replanifier l\'appel'
                                    ],
                                    [
                                        'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non, terminer'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            <div class="response-options" id="div-prise-rdv6" hidden></div>
                        </div>

                        <!-- Etape 4 : origine -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "<li>• Soyez rapide, précis et cordial pour obtenir ces informations essentielles.</li>
                                                    <li>• Expliquez succinctement que ces informations sont nécessaires afin de proposer des
                                                    assurances réellement adaptées.</li>
                                                    <li>• Écoutez activement pour anticiper les besoins du prospect et adapter la suite du discours commercial. </li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Afin que je puisse vous proposer rapidement une offre vraiment adaptée à votre situation,
                                            pourriez-vous simplement m’indiquer :
                                        </p>';                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            
                            <label class="form-title">Si vous êtes propriétaire ou locataire:</label>
                            <?php
                                $name = 'habitation';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'proprietaire',
                                        'label' => 'Proprietaire'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'locataire',
                                        'label' => 'Locataire'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title">Si vous avez un emprunt immobilier en cours :</label>
                            <?php
                                $name = 'emprunteur';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'emprunteur',
                                        'label' => 'Emprunteur immobilier'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'non-emprunteur',
                                        'label' => 'Non Emprunteur'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title">Votre statut professionnel :</label>
                            <?php
                                $name = 'profession';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'salarie',
                                        'label' => 'Salarié'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'independant',
                                        'label' => 'Indépendant'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'retraite',
                                        'label' => 'Retraité'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'info',
                                        'value' => 'sans-activité',
                                        'label' => 'Sans activité'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title">Si vous êtes célibataire, en couple ou en famille avec enfants ? :</label>
                            <?php
                                $name = 'famille';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'celibataire',
                                        'label' => 'Célibataire'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'en-couple',
                                        'label' => 'En couple'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'famille',
                                        'label' => 'Famille avec enfants'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        
                        </div>


                        <!-- Etape 5 :"Autre profil" -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Cette étape est capitale pour qualifier précisément le profil du prospect : soyez
                                                        particulièrement attentif et utilisez des questions ouvertes simples.<br><br></li>
                                                    <li>• N'interrompez pas le prospect lorsqu’il répond, laissez-le s'exprimer librement pour
                                                        obtenir des indices sur son statut immobilier.<br><br></li>
                                                    <li>• En cas de réponse imprécise, reformulez votre question ou demandez une précision
                                                        supplémentaire de façon courtoise, sans pression.
                                                    </li>";
                                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            <b>Prospect ayant sélectionné statut 'autre'.</b> <br><br>
                                            Afin de vous orienter au mieux, pourriez-vous m’indiquer brièvement votre situation concernant
                                            l’immobilier : envisagez-vous un projet
                                            immobilier prochainement ? 
                                        </p>";                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <?php
                                $name = 'siEnvisagerProjetImmobilier';
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
                        
                        
                        <!-- Etape 6 "proprétaire" : -->
                    <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Confirmez rapidement et clairement l'information disponible sur l’écran avec le prospect.<br><br></li>
                                                    <li>• Si la réponse est négative ou imprécise, demandez une correction simple sans insister lourdement.<br><br></li>
                                                    <li>• L’objectif ici est de valider la pertinence des données pour adapter précisément votre discours dans les prochaines étapes.
                                                    </li>";
                                        $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Selon mes informations, vous êtes propriétaire d\'un bien situé à' . !empty($contact) && !empty($contact->adresse)  ? $contact->adresse : '' . '. Vous me
                                            confirmez cette information ?
                                        </p>';                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this); onClickCorrecteInfosProprietaire('oui');" type="button"
                                        class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio"
                                                <?= checked('correcteInfosProprietaire', 'oui', $questScript, 'checked') ?>
                                                name="correcteInfosProprietaire" class="btn-check " value="oui" />
                                        </div>
                                        Information correcte
                                    </button>
                                    <button onclick="selectRadio(this);  onClickCorrecteInfosProprietaire('non');" type="button"
                                        class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" name="correcteInfosProprietaire"
                                                <?= checked('correcteInfosProprietaire', 'non', $questScript, 'checked') ?>
                                                class="btn-check" value="non" />
                                        </div>
                                        Information incorrecte
                                    </button>
                                </div>
                            </div>
                        <div class="response-options" id="sous-question-6"
                            <?=$questScript && $questScript->correcteInfosProprietaire == 'non' ? '' : 'hidden'?>
                            >
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
                                            <label for="">Statut: <small class="text-danger">*</small>
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
                        
                        <!-- Etape 7 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Validez rapidement les assurances déjà souscrites par le prospect pour identifier
                                                        précisément les opportunités commerciales.</li>
                                                        <li>• Posez ces questions de manière très rapide et fluide afin d'éviter une sensation
                                                        d'interrogatoire.</li>
                                                        <li>• Écoutez activement les réponses pour orienter directement vers les solutions adaptées.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de mieux cibler les économies possibles pour vous, pourriez-vous simplement me préciser
                                            parmi ces assurances celles que vous possédez actuellement :
                                            Auto , Habitation , Santé , Assurance emprunteur , Prévoyance individuelle ?
                                        </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <div class="form-group">
                                        <label class="form-title">Types d'assurance :</label>
                                        <div class="options-row d-flex flex-column">
                                            <!-- Assurance Auto -->
                                            <label class="option-checkbox">
                                                <input <?= isset($questScript) && $questScript->assuranceAuto === 'oui' ? 'checked' : ''?> value="oui" type="checkbox" name="assuranceAuto" id="assurance_auto">
                                                <span class="checkbox-icon"><i class="fas fa-car"></i></span>
                                                <span class="checkbox-label">Assurance Auto</span>
                                            </label>
                                            
                                            <!-- Assurance Habitation -->
                                            <label class="option-checkbox">
                                                <input <?= isset($questScript) && $questScript->assuranceHabitation === 'oui' ? 'checked' : ''?> value="oui" type="checkbox" name="assuranceHabitation" id="assurance_habitation">
                                                <span class="checkbox-icon"><i class="fas fa-home"></i></span>
                                                <span class="checkbox-label">Assurance Habitation</span>
                                            </label>
                                            
                                            <!-- Assurance Santé complémentaire -->
                                            <label class="option-checkbox">
                                                <input <?= isset($questScript) && $questScript->assuranceSante === 'oui' ? 'checked' : ''?> value="oui" type="checkbox" name="assuranceSante" id="assurance_sante">
                                                <span class="checkbox-icon"><i class="fas fa-heartbeat"></i></span>
                                                <span class="checkbox-label">Assurance Santé complémentaire</span>
                                            </label>
                                            
                                            <!-- Assurance Emprunteur -->
                                            <label class="option-checkbox">
                                                <input <?= isset($questScript) && $questScript->assuranceEmprunteur === 'oui' ? 'checked' : ''?> value="oui" type="checkbox" name="assuranceEmprunteur" id="assurance_emprunteur">
                                                <span class="checkbox-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                                <span class="checkbox-label">Assurance Emprunteur</span>
                                            </label>
                                            
                                            <!-- Assurance Prévoyance individuelle -->
                                            <label class="option-checkbox">
                                                <input <?= isset($questScript) && $questScript->assurancePrevoyance === 'oui' ? 'checked' : ''?> value="oui" type="checkbox" name="assurancePrevoyance" id="assurance_prevoyance">
                                                <span class="checkbox-icon"><i class="fas fa-umbrella"></i></span>
                                                <span class="checkbox-label">Assurance Prévoyance individuelle</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- Etape 8 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Évaluez très rapidement la satisfaction actuelle du prospect pour identifier clairement les
                                                        leviers commerciaux (tarifs, garanties, service).
                                                    <li>• Soyez attentif aux nuances exprimées spontanément par le prospect pour mieux orienter
                                                    votre proposition commerciale.
                                                    <li>• Restez fluide et dynamique afin que cette étape de qualification soit rapide et naturelle.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                             De façon très rapide, pourriez-vous simplement m’indiquer votre niveau global de satisfaction
                                            concernant vos assurances actuelles, notamment au niveau :
                                        </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <label class="form-title">Satisfaction Tarifs :</label>
                            <?php
                                $name = 'satisfactionTarifs';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'satisfait',
                                        'label' => 'Satisfait'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'moyen',
                                        'label' => 'Moyen'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'insatisfait',
                                        'label' => 'Insatisfait'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                                            
                            <label class="form-title">Satisfaction Garanties :</label>
                            <?php
                                $name = 'satisfactionGaranties';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'satisfait',
                                        'label' => 'Satisfait'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'moyen',
                                        'label' => 'Moyen'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'insatisfait',
                                        'label' => 'Insatisfait'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title">Satisfaction Qualité Service :</label>
                            <?php
                                $name = 'satisfactionService';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'satisfait',
                                        'label' => 'Satisfait'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'moyen',
                                        'label' => 'Moyen'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'insatisfait',
                                        'label' => 'Insatisfait'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>

                        <!-- Etape 9 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Vérifiez précisément et très rapidement les besoins réels du prospect afin d’orienter
                                                        immédiatement votre discours vers la bonne typologie d’assurance.</li>
                                                        <li>• Écoutez activement les réponses pour identifier précisément les opportunités
                                                        commerciales prioritaires.</li>
                                                        <li>• Soyez professionnel et dynamique pour susciter l’intérêt immédiat du prospect.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                                        Parmi les assurances suivantes, pourriez-vous simplement me préciser celles pour lesquelles
                                                        vous pourriez être intéressé(e)
                                                    </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <?php
                                $name = 'typeAssurance';

                                $options = [
                                    [
                                        'id' => 'assurance_emp',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'emprunteur',
                                        'label' => 'Assurance Emprunteur'
                                    ],
                                    [
                                        'id' => 'assurance_san',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'sante',
                                        'label' => 'Assurance Santé complémentaire'
                                    ],
                                    [
                                        'id' => 'assurance_prev',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'prevoyance',
                                        'label' => 'Assurance Prévoyance individuelle'
                                    
                                    ],
                                    [
                                        'id' => 'assurance_aut',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'auto',
                                        'label' => 'Assurance Auto'
                                    ],
                                    [
                                        'id' => 'assurance_hab',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'habitation',
                                        'label' => 'Assurance Habitation'
                                    ],
                                    [
                                        'id' => 'assurance_ani',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'animaux',
                                        'label' => 'Assurance Animaux'
                                    ],
                                    [
                                        'id' => 'assurance_cyb',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'cyber',
                                        'label' => 'Cyberassurance individuelle'
                                    ],
                                    [
                                        'id' => 'assurance_autre',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'autre',
                                        'label' => 'Autre assurance spécifique'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            <input value="<?= isset($questScript) && $questScript->assuranceText ? $questScript->assuranceText : ''?>" type="text" class="form-control mt-2" id="autre_assurance_text" 
                            name="assuranceText" placeholder="Précisez..." 
                            style="display:<?= isset($questScript) && $questScript->assuranceText ? 'block' : 'none' ?>; width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ddd;">
                        </div>

                        <!-- 4. Déroulement du script par profil de prospect (embranchements) -->
                        <!-- 4.1. Cas d’un prospect propriétaire occupant en copropriété (Mandat de syndic) -->
                        <!-- Etape 10 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Présentez brièvement et clairement les principales assurances proposées aux
                                                        particuliers.</li>
                                                        <li>• Valorisez succinctement l’intérêt immédiat de chaque type d’assurance pour capter
                                                        rapidement l’attention.</li>
                                                        <li>• Restez dynamique et professionnel afin de guider facilement le prospect vers le produit le
                                                        plus adapté.</li>";
                                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            HB Assurance propose aux particuliers une gamme complète d’assurances spécialement
                                            conçues pour optimiser vos garanties et vos coûts :<br>
                                            • <b style='color: green;'>L’assurance emprunteur immobilier</b> avec des économies garanties<br>
                                            • <b style='color: green;'>La complémentaire santé</b> avec de meilleurs remboursements à moindre coût<br>
                                            • <b style='color: green;'>Une prévoyance individuelle</b> pour protéger financièrement votre famille<br>
                                            • <b style='color: green;'>L’assurance habitation</b> aux garanties étendues et optimisées<br>
                                            • <b style='color: green;'>L’assurance automobile</b> avec économies immédiates et couverture adaptée
                                            ainsi que des assurances spécifiques comme pour vos animaux , votre mobilité
                                            électrique , ou encore une cyberassurance individuelle .
                                            </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                        </div>
                        
                        <!-- Etape 11 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Présentez succinctement et clairement ces points forts afin d’accrocher rapidement
                                                        l’intérêt du prospect.</li>
                                                        <li>• Valorisez particulièrement l’indépendance, la simplicité et la rapidité des démarches
                                                        comme facteurs clés d’attractivité.</li>
                                                        <li>• Soyez dynamique et rassurant, en insistant sur la facilité immédiate pour le particulier.</li>";
                                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Choisir HB Assurance, c’est bénéficier immédiatement :<br>
                                                • D’une <b style='color: green;'> indépendance totale</b> avec <b style='color: green;'> un comparatif rapide des meilleures offres du marché</b><br>
                                                • D’une <b style='color: green;'> optimisation immédiate des coûts </b> et de garanties parfaitement adaptées<br>
                                                • D’un <b style='color: green;'> accompagnement entièrement personnalisé par un interlocuteur unique dédié
                                                </b> <br>
                                                • Et enfin, d’une grande <b style='color: green;'>
                                                simplicité et rapidité des démarches administratives</b> ,
                                                aussi bien pour souscrire que pour résilier vos contrats actuels. »
                                        </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                        </div>
                        
                        <!-- Etape 12 : -->
                        <div class="step">
                            <?php
                            $consignes = "<li>• Posez ces questions spécifiques rapidement et clairement pour cibler précisément
                                            l’opportunité d’économie.</li>
                                            <li>• Soyez attentif aux détails fournis par le prospect, car ils conditionneront fortement
                                            l’argumentaire à suivre.</li>
                                            <li>• Adoptez un ton professionnel et bienveillant afin de rassurer le prospect lors du recueil
                                            des informations.</li>";
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de vérifier rapidement si vous pouvez réaliser des économies significatives sur votre
                                            assurance emprunteur, pourriez-vous simplement m’indiquer :
                                        </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                            <label>Emprunt immobilier en cours :</label>
                            <?php
                            $name = 'empruntEnCours';
                            $options = [
                                [
                                    'onclick' => '',
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Oui',
                                ],
                                [
                                    'onclick' => '',
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Non',
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            <div class="form-group col-md-12">
                                <label>Durée restante de l’emprunt (en années) </label>
                                <input type="text" class="form-control" name="dureeEmprunt" value="<?=isset($questScript) ? $questScript->dureeEmprunt : ''?>">
                                <label>Mensualité actuelle d’assurance emprunteur (en €)</label>
                                <input type="text" class="form-control" name="mensualite" value="<?=isset($questScript) ? $questScript->mensualite : ''?>">
                                <label>Garanties actuelles souscrites</label>
                                <input type="text" class="form-control" name="garantiesP" value="<?=isset($questScript) ? $questScript->garantiesP : ''?>">
                            </div>
                        </div>
                        
                        
                        <!-- Etape 13 : -->
                        <div class="step">
                            <?php
                            $consignes = "<li> Valorisez fortement l’opportunité d’économie immédiate et significative garantie par la loi
                                            Lemoine.</li>
                                            <li> Rassurez immédiatement sur la simplicité et rapidité de la procédure de changement
                                            d’assurance.</li>
                                            <li> Insistez sur les gains mensuels concrets pour renforcer l’attractivité immédiate de votre
                                            proposition.</li>";
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Grâce à la Loi Lemoine, HB Assurance vous permet de réaliser des <b style='color: green;'>économies immédiates
                                            garanties</b> sur votre assurance emprunteur. De plus, le processus de changement d’assureur
                                            est désormais extrêmement <b style='color: green;'>simple et rapide</b> , vous permettant ainsi de profiter très
                                            rapidement de <b style='color: green;'>gains significatifs chaque mois</b> .</p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 14 : -->
                        <div class="step">
                            <?php
                                $consignes = "<li>• Proposez directement et clairement les prochaines étapes concrètes afin d’obtenir un
                                                engagement immédiat du prospect.</li>
                                                <li>• Valorisez la gratuité, la rapidité et la précision de la simulation et du devis proposés.</li>
                                                <li>• Encouragez immédiatement à fixer un rendez-vous avec un conseiller spécialisé pour
                                                approfondir l’offre.</li>";
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Pour vous permettre de constater immédiatement les économies possibles, je vous propose
                                            une <b style='color: green;'>simulation immédiate gratuite</b> , accompagnée d’un <b style='color: green;'>devis personnalisé rapide</b> .
                                            Nous pouvons également programmer dès maintenant un <b style='color: green;'>rendez-vous téléphonique
                                            approfondi avec un conseiller spécialisé</b> . Préférez-vous que l’on fixe ce rendez-vous
                                            ensemble dès à présent ?</p>";
                                include dirname(__FILE__) . '/blocs/questionContent.php';

                                $name = 'rdvOuEtudeGratuite';
                                $options = [
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Rendez-vous gestionnaire');",
                                        'btn_class' => 'success',
                                        'value' => 'Rendez-vous gestionnaire',
                                        'label' => 'Rendez-vous gestionnaire 🗓️',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Rendez-vous gestionnaire', $questScript, 'checked')
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Étude gratuite');",
                                        'btn_class' => 'warning',
                                        'value' => 'Étude gratuite',
                                        'label' => 'Étude gratuite 📖',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Étude gratuite', $questScript, 'checked')
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Refus');",
                                        'btn_class' => 'danger',
                                        'value' => 'Refus',
                                        'label' => 'Refus',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Refus', $questScript, 'checked')
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                                ?>
                        </div>
                        
                        
                        <!-- Etape 15 : -->
                        <div class="step">
                            <?php
                                $consignes = "<li>• Respectez sans insister le refus exprimé par le prospect.</li>
                                                <li>• Orientez poliment l’échange vers des recommandations indirectes, comme des membres
                                                de la famille ou des amis susceptibles d’être intéressés.</li>
                                                <li>• Clôturez positivement afin de préserver l’image professionnelle d’HB Assurance.</li>
                                                ";
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Je comprends parfaitement votre décision, et je vous remercie sincèrement du temps que vous
                                                m’avez accordé. Avant de conclure, auriez-vous éventuellement des personnes de votre famille
                                                ou de votre entourage qui pourraient être intéressées par des économies immédiates sur leur
                                                assurance emprunteur immobilier ?</p>";
                                include dirname(__FILE__) . '/blocs/questionContent.php';

                                $name = 'demandeConnaissanceAutreProspect';
                                $options = [
                                    [
                                        'id' => 'Locataire',
                                        'onclick' => "onClickDemandeConnaissanceAutreProspect('oui');",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                    ],
                                    [
                                        'onclick' => "onClickDemandeConnaissanceAutreProspect('non');",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                                ?>
                                <div style="display:none;" class="form-group" id="recommendationsEventuelles">
                                    <label>Recommandations éventuelles</label>
                                    <input type="text" class="form-control" name="recommendations" value="">
                                </div>
                        </div>


                        <!-- 4. Déroulement du script par profil de prospect (embranchements) -->
                        <!-- 4.2. Cas d’un prospect propriétaire bailleur (Mandat de gestion locative) -->
                        <!-- Etape 16 : -->
                        <div class="step">
                            <?php
                                $consignes = "<li>• Recueillez rapidement ces informations spécifiques pour cibler immédiatement les
                                                possibilités d'amélioration ou d’économie.</li>
                                                <li>• Soyez précis et fluide dans vos questions pour démontrer votre expertise.</li>
                                                <li>• Rassurez le prospect sur l’importance d’avoir ces données précises afin d’obtenir un devis
                                                réellement avantageux.</li>
                                                ";
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Afin de vérifier rapidement si nous pouvons améliorer votre couverture santé tout en réduisant
                                                vos coûts, pourriez-vous m’indiquer :
                                            </p>";
                                include dirname(__FILE__) . '/blocs/questionContent.php';

                                // $name = 'siGere';
                                // $options = [
                                //     [
                                //         'onclick' => '',
                                //         'btn_class' => 'success',
                                //         'value' => 'oui',
                                //         'label' => 'Gestion personnelle',
                                //     ],
                                //     [
                                //         'onclick' => '',
                                //         'btn_class' => 'danger',
                                //         'value' => 'non',
                                //         'label' => 'Agence immobilière',
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                                // ?>
                                <div class="form-group">
                                    <label>Nom de la mutuelle actuelle</label>
                                    <input value="<?= isset($questScript) ? $questScript->mutuelle : ''?>" type="text" class="form-control" name="mutuelle" value="">
                                    <label>Type de couverture santé en vigueur</label>
                                    <input value="<?= isset($questScript) ? $questScript->typeCouverture : ''?>" type="text" class="form-control" name="typeCouverture" value="">
                                    <label>Niveau global de remboursements perçus</label>
                                    <input value="<?= isset($questScript) ? $questScript->remboursement : ''?>" type="text" class="form-control" name="remboursement" value="">
                                    <label>Montant approximatif de la prime mensuelle ou annuelle</label>
                                    <input value="<?= isset($questScript) ? $questScript->primeApprox : ''?>" type="text" class="form-control" name="primeApprox" value="">
                                </div>
                        </div>
                        
                        <!-- Etape 17 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Insistez sur les économies rapides et réelles que le prospect peut réaliser grâce à HB
                                            Assurance.</li>
                                            <li>• Valorisez l’amélioration concrète et immédiate des remboursements pour renforcer
                                            l’intérêt du prospect.</li>
                                            <li>• Soulignez fortement la personnalisation des garanties adaptées à la situation précise du
                                            prospect pour accentuer l’impact positif.</li>
                                            ";
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            En souscrivant votre complémentaire santé chez HB Assurance, vous bénéficiez
                                            immédiatement d’une <b style='color: green;'>réduction significative de vos coûts</b> , tout en profitant d’une
                                            <b style='color: green;'>amélioration immédiate de vos remboursements santé</b> . De plus, nous adaptons
                                            précisément vos garanties à votre <b style='color: green;'>situation familiale ou personnelle</b> pour une couverture
                                            parfaitement optimisée.</p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            // $name = 'siDifficulte';
                            // $options = [
                            //     [
                            //         'onclick' => '',
                            //         'btn_class' => 'success',
                            //         'value' => 'oui',
                            //         'label' => 'Oui',
                            //     ],
                            //     [
                            //         'onclick' => '',
                            //         'btn_class' => 'danger', 
                            //         'value' => 'non',
                            //         'label' => 'Non',
                            //     ]
                            // ];
                            // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            // ?>
                        </div>
                        
                        
                        <!-- Etape 18 : -->
                        <div class="step">
                            <?php
                            $consignes = "<li>• Proposez explicitement les prochaines étapes pratiques afin d’obtenir un engagement
                                            immédiat du prospect.</li>
                                            <li>• Valorisez fortement la gratuité, la rapidité et l’absence totale d’engagement de cette
                                            démarche.</li>
                                            <li>• Encouragez immédiatement la fixation d’un rendez-vous téléphonique pour mieux
                                            accompagner le prospect.</li>";
                            
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Pour vous permettre de juger concrètement les économies et améliorations possibles sur votre
                                            complémentaire santé, je vous propose dès maintenant un <b style='color: green;'>devis immédiat gratuit</b> , ainsi
                                            qu’un <b style='color: green;'>rendez-vous téléphonique rapide</b> pour une comparaison directe des meilleures offres.
                                            Souhaitez-vous fixer ce rendez-vous maintenant, ou préférez-vous d’abord recevoir <b style='color: green;'>une
                                            proposition écrite</b> détaillée par email ?</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            $name = 'emailOuEtudeGratuite';
                                $options = [
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Rendez-vous gestionnaire');",
                                        'btn_class' => 'success',
                                        'value' => 'Rendez-vous gestionnaire',
                                        'label' => 'Rendez-vous gestionnaire 🗓️',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Rendez-vous gestionnaire', $questScript, 'checked')
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Étude gratuite');",
                                        'btn_class' => 'warning',
                                        'value' => 'Étude gratuite',
                                        'label' => 'Étude gratuite 📖',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Étude gratuite', $questScript, 'checked')
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Refus');",
                                        'btn_class' => 'danger',
                                        'value' => 'Refus',
                                        'label' => 'Refus',
                                        'checked' => checked('rdvOuEtudeGratuite', 'Refus', $questScript, 'checked')
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>
                        
                        <!-- Etape 19 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Recueillez clairement ces informations clés afin de comprendre précisément les besoins
                                            réels du prospect en matière de prévoyance individuelle.</li>
                                            <li>• Soyez à l’écoute active et sensible, car ces questions touchent à la protection personnelle
                                            et familiale du prospect.</li>
                                            <li>• Adoptez un ton rassurant et professionnel pour instaurer immédiatement un climat de
                                            confiance.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de vous proposer une offre parfaitement adaptée en prévoyance individuelle (décèsinvalidité, accidents vie privée), pourriez-vous simplement me préciser :
                                        </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            ?>
                            <label class="form-title">Votre statut professionnel :</label>
                            <?php
                                $name = 'profession';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'salarie',
                                        'label' => 'Salarié'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'independant',
                                        'label' => 'Indépendant'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'retraite',
                                        'label' => 'Retraité'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'info',
                                        'value' => 'sans-activité',
                                        'label' => 'Sans activité'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title">Si vous êtes célibataire, en couple ou en famille avec enfants ? :</label>
                            <?php    
                            $name = 'famille';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'celibataire',
                                        'label' => 'Célibataire'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'en-couple',
                                        'label' => 'En couple'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'famille',
                                        'label' => 'Famille avec enfants'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            <label class="form-title">si vous bénéficiez déjà actuellement d’une prévoyance individuelle ou collective ? </label>
                            <?php
                            $name = 'typePrevoyance';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'individuelle',
                                        'label' => 'Individuelle'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'warning',
                                        'value' => 'collective',
                                        'label' => 'Collective'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>

                        <!-- Etape 20 : -->
                        <div class="step">
                            <?php
                            // Main question component
                            $consignes = "<li>• Insistez fortement sur l’importance concrète et émotionnelle de protéger la famille et les
                                            revenus du prospect.</li>
                                            <li>• Valorisez le coût maîtrisé pour démontrer que la protection est accessible à tous les
                                            budgets.</li>
                                            <li>• Mettez en avant la simplicité et la rapidité du processus de souscription pour rassurer
                                            immédiatement.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Notre prévoyance individuelle vous garantit une <b style='color: green;'>couverture renforcée</b> spécialement
                                            conçue pour protéger efficacement votre famille et sécuriser vos revenus en cas d’imprévu
                                            (décès, invalidité, accident). HB Assurance vous propose cette protection indispensable à un
                                            <b style='color: green;'>coût parfaitement maîtrisé</b> et adapté à votre budget , <b style='color: green;'>avec une simplicité et une rapidité
                                            maximale lors de la souscription</b></p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            // $name = 'typeRencontre';
                            // $options = [
                            //     [
                            //         'onclick' => "onClickTypeRencontre('physique');",
                            //         'btn_class' => 'success',
                            //         'value' => 'physique',
                            //         'label' => 'Rencontre physique',
                            //         'checked' => checked('typeRencontre', 'physique', $questScript, 'checked')
                            //     ],
                            //     [
                            //         'onclick' => "onClickTypeRencontre('Visioconférence');",
                            //         'btn_class' => 'warning',
                            //         'value' => 'Visioconférence',
                            //         'label' => 'Visioconférence',
                            //         'checked' => checked('typeRencontre', 'Visioconférence', $questScript, 'checked')
                            //     ],
                            //     [
                            //         'onclick' => "onClickTypeRencontre('non');",
                            //         'btn_class' => 'danger',
                            //         'value' => 'non',
                            //         'label' => 'Aucun intérêt immédiat',
                            //         'checked' => checked('typeRencontre', 'non', $questScript, 'checked')
                            //     ]
                            // ];
                            
                            // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <!-- Additional form elements (kept as original HTML since they're unique) -->
                            <div class="response-options" id="bloc-prise-rdv2-bis" hidden>
                                <div class="options-container col-md-11">
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-12" id="imputLienVisioconference">
                                            <label for="">Lien visioconférence: <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" id="lienVisioconference"
                                                name="lienVisioconference" value="<?=!empty($questScript) && $questScript->lienVisioconference ? $questScript->lienVisioconference : '' ?>">
                                        </div>
                                    </div>
                                    <div id="div-prise-rdv2-bis"></div>
                                </div>
                            </div>

                            <!-- Hidden recap section -->
                            <div class="question-box" hidden id="sous-menu-recap">
                                <?php
                                $consignes = "<li>• Soyez particulièrement attentif aux signaux positifs.<br><br></li>
                                            <li>• Validez explicitement avec enthousiasme l'intérêt mutuel.<br><br></li>
                                            <li>• Notez précisément les détails évoqués.</li>";
                                
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span>.1 :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Pour récapituler brièvement, nous confirmons ensemble aujourd'hui notre volonté
                                                commune de collaborer 🤝. <br>
                                                Nous démarrerons par un premier test pratique sur quelques
                                                recommandations 📩, et nous avons convenu d'un rendez-vous <span
                                                    style='font-weight: bold;' id='place-rdv'></span>📅. <br>
                                                    Est-ce bien correct pour vous ?
                                            </p>";
                                
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                        </div>


                        <!-- Etape 21 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Proposez directement une action concrète (devis ou rendez-vous) afin d’obtenir un
                                            engagement immédiat du prospect.</li>
                                            <li>• Valorisez fortement la rapidité, la simplicité et la personnalisation du devis proposé.</li>
                                            <li>• Encouragez immédiatement la prise d’un rendez-vous avec un conseiller expert pour
                                            faciliter la décision du prospect.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin que vous puissiez évaluer concrètement les bénéfices d’une prévoyance parfaitement
                                            adaptée à votre situation, je vous propose dès maintenant un devis rapide et personnalisé
                                            ainsi qu’un rendez-vous téléphonique ou physique avec un conseiller expert . Souhaitezvous fixer ce rendez-vous immédiatement ?</p>";
                                                                        
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            $name = 'siInteresse';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Rendez-vous',
                                ],
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Refus immédiat',
                                ]
                            ];
                            
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <!--  Planifier rencontre -->
                            <div class="response-options" id="div-prise-rdv2" hidden></div>

                            <!-- Additional form for property owner details (if needed) -->
                            <!-- Can be implemented as a separate component if reused frequently -->
                        </div>

                        <!-- 4.3. Cas d’un prospect ayant un projet de vente immobilière (Mandat de vente)
                        4.3.1. Questions spécifiques : Détails sur le projet de vente -->
                        <!-- Etape 22 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Posez rapidement ces questions spécifiques pour identifier précisément les possibilités
                                            d’économie et d’optimisation des garanties.</li>
                                            <li>• Adoptez un ton clair, rassurant et professionnel afin de faciliter la communication
                                            d’informations précises par le prospect.</li>
                                            <li>• Restez attentif aux détails fournis pour mieux orienter la proposition adaptée qui suivra.</li>
                                            ";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de vous proposer rapidement une assurance habitation optimisée et adaptée, pourriezvous simplement m’indiquer :</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                            <label class="form-title">Type de logement :</label>
                            <?php
                            $name = 'typeLogement';
                            $options = [
                                [
                                    'onclick' => '',
                                    'btn_class' => 'success',
                                    'value' => 'maison',
                                    'label' => 'Maison',
                                ],
                                [
                                    'onclick' => '',
                                    'btn_class' => 'danger',
                                    'value' => 'appartement',
                                    'label' => 'Appartement',
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <label class="form-title mt-3">Statut d'occupation :</label>
                        <?php
                            $name = 'habitation';
                            $options = [
                                [
                                    'onclick' => '',
                                    'btn_class' => 'success',
                                    'value' => 'proprietaire',
                                    'label' => 'Proprietaire',
                                ],
                                [
                                    'onclick' => '',
                                    'btn_class' => 'danger',
                                    'value' => 'locataire',
                                    'label' => 'Locataire',
                                ]
                            ];
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <label class="form-title mt-3">Montant approximatif des primes actuelles :</label>
                            <div class="input-group">
                                <span class="input-group-text">€</span>
                                <input value="<?=isset($questScript) ? $questScript->primeApprox : ''?>" type="number" class="form-control" name="primeApprox" placeholder="Montant annuel">
                                <span class="input-group-text">/an</span>
                            </div>
                                        
                            <!-- Garanties principales -->
                            <label class="form-title mt-3">Garanties principales actuellement souscrites :</label>
                            <textarea class="form-control" name="garantiesP" rows="3" 
                                    placeholder="Décrivez vos garanties actuelles...">
                                <?=!empty($questScript->garantiesP) ? $questScript->garantiesP : ''?></textarea>
                        </div>
                        
                        <!-- Etape 23 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Valorisez fortement la réduction immédiate des coûts et l’amélioration significative des
                                            garanties.</li>
                                            <li>• Rassurez immédiatement sur la simplicité et la fluidité du processus administratif
                                            proposé par HB Assurance.</li>
                                            <li>• Soyez dynamique et positif pour renforcer l’attractivité immédiate de votre proposition.</li>";
                                                                        
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Avec HB Assurance, votre contrat d’assurance habitation sera immédiatement optimisé pour
                                            vous garantir une <b style='color: green;'>réduction tarifaire immédiate</b> , tout en bénéficiant de <b style='color: green;'>garanties
                                            renforcées</b> sur les dommages , la responsabilité civile , et les dégâts des eaux . De plus,
                                            nous vous garantissons une <b style='color: green;'>simplicité administrative maximale</b> , afin que tout soit fluide et
                                            rapide pour vous.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 24 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Proposez explicitement et directement les prochaines étapes pour encourager un
                                            engagement immédiat du prospect.</li>
                                            <li>• Valorisez fortement la gratuité et l’efficacité immédiate de la comparaison et du devis.</li>
                                            <li>• Encouragez immédiatement la prise d’un rendez-vous pour accompagner le prospect
                                            dans son choix.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Afin de constater rapidement les économies et améliorations possibles sur votre assurance
                                        habitation, je vous propose dès maintenant un devis immédiat gratuit , accompagné d’une
                                        comparaison rapide des meilleures offres concurrentes . Souhaitez-vous que nous fixions
                                        ensemble dès à présent un rendez-vous personnalisé avec un conseiller habitation dédié
                                        pour vous accompagner dans votre choix ?</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            $name = 'siInteresse';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Rendez-vous',
                                    'checked' => checked('responsable', 'oui', $questScript, 'checked')
                                ],
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Refus immédiat',
                                    'checked' => checked('responsable', 'non', $questScript, 'checked')
                                ]
                            ];
                            
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                             <!--  Planifier rencontre -->
                            <div class="response-options" id="div-prise-rdv3" hidden></div>

                        </div>
                        
                        <!-- Etape 25 : -->
                        <div class="step">
                            <?php
                            // Question content component (unchanged)
                            $consignes = "<li>• Posez rapidement ces questions précises pour identifier immédiatement le potentiel
                                            d’économie et d’optimisation des garanties.</li>
                                            <li>• Restez attentif aux détails donnés par le prospect afin d’adapter précisément la suite de
                                            votre argumentaire.</li>
                                            <li>• Maintenez un ton professionnel, rassurant et dynamique pour faciliter l’obtention rapide
                                            des informations demandées.</li>
                                            ";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Afin de vérifier rapidement les économies possibles sur votre assurance automobile, pourriezvous simplement m’indiquer :</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
        
                            <div class="response-options">
                                <div class="options-container">
                                    <div class="insurance-form-container">
                                        
                                        <!-- Previous sections here... -->
                                        
                                        <!-- Vehicle Information Section -->
                                        <div class="form-group mt-4">
                                            <h5 class="section-title mb-3">Informations véhicule</h5>
                                            
                                            <!-- Type de véhicule -->
                                            <div class="mb-3">
                                                <label class="form-label">Type de véhicule (Marque, modèle, année) :</label>
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <input value="<?=isset($questScript) && isset($questScript->marque) ? $questScript->marque : ''?>" type="text" class="form-control" name="marque" placeholder="Marque" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input value="<?=isset($questScript) && isset($questScript->model) ? $questScript->model : ''?>" type="text" class="form-control" name="model" placeholder="Modèle" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input value="<?=isset($questScript) && isset($questScript->vehiculeAnnee) ? $questScript->vehiculeAnnee : ''?>" type="number" class="form-control" name="vehiculeAnnee" placeholder="Année" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Type de couverture actuelle -->
                                            <div class="mb-3">
                                                <label class="form-label">Type de couverture actuelle :</label>
                                                <input value="<?=isset($questScript) && isset($questScript->typeCouverture) ? $questScript->typeCouverture : ''?>" type="text" class="form-control" name="typeCouverture" 
                                                    placeholder="Ex: Tiers simple, Tous risques, etc." required>
                                            </div>
                                            
                                            <!-- Montant approximatif des primes annuelles -->
                                            <div class="mb-3">
                                                <label class="form-label">Montant approximatif des primes annuelles :</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">€</span>
                                                    <input value="<?=isset($questScript) && isset($questScript->primeApprox) ? $questScript->primeApprox : ''?>" type="number" class="form-control" name="primeApprox" 
                                                        placeholder="Montant annuel" min="0" step="0.01" required>
                                                    <span class="input-group-text">/an</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Etape 26 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Insistez fortement sur l’avantage financier immédiat et concret pour susciter l’intérêt
                                            immédiat du prospect.</li>
                                            <li>• Valorisez la personnalisation totale de la couverture auto selon le véhicule et le profil
                                            précis du conducteur.</li>
                                            <li>• Rassurez clairement sur la simplicité et la rapidité des démarches administratives afin de
                                            faciliter la décision du prospect.</li>
                                            ";
                            
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                        En confiant votre assurance automobile à HB Assurance, vous avez la certitude de réaliser des
                                        <b style='color: green;'>économies immédiates garanties</b> , tout en profitant d’une <b style='color: green;'>couverture optimale
                                        parfaitement adaptée à votre véhicule et à votre profil conducteur</b> . De plus, les démarches administratives chez nous sont extrêmement <b style='color: green;'>simplifiées et rapides</b> , pour
                                        vous offrir un maximum de confort et de tranquillité.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 27 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Proposez directement et explicitement les prochaines étapes concrètes pour encourager
                                            un engagement immédiat du prospect.</li>
                                            <li>• Valorisez fortement la rapidité et la précision du devis proposé.</li>
                                            <li>• Encouragez immédiatement à fixer un rendez-vous afin d’optimiser la prise de décision du
                                            prospect.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin que vous puissiez constater immédiatement les économies possibles sur votre assurance
                                            automobile, je vous propose un devis personnalisé immédiat gratuit , ainsi qu’un rendezvous rapide avec un conseiller auto dédié . Souhaitez-vous fixer ce rendez-vous dès
                                            maintenant pour optimiser rapidement vos coûts et garanties ?</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            $name = 'siEstimationRDV';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'rdv',
                                    'label' => 'Rendez-vous gestionnaire 🗓️',
                                    'checked' => checked('siEstimationRDV', 'rdv', $questScript, 'checked')
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'oui',
                                    'label' => 'Devis personnalisé 📖',
                                    'checked' => checked('siEstimationRDV', 'oui', $questScript, 'checked')
                                ],
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Refus RDV',
                                    'checked' => checked('siEstimationRDV', 'non', $questScript, 'checked')
                                ]
                            ];
                            
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <div class="response-options" id="div-prise-rdv4" hidden></div>

                        </div>



                        <!-- 4. Déroulement du script par profil de prospect (embranchements)
                        4.4. Cas d’un prospect locataire ou sans besoin direct identifié (Pas de mandat direct)
                        4.4.1. Cas spécifique du locataire : Proposition indirecte via le propriétaire ou la copropriété -->
                        <!-- Etape 28 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Respectez immédiatement le refus exprimé sans insister.</li>
                                            <li>• Orientez l’échange de manière positive vers des recommandations indirectes auprès de
                                            la famille ou de l’entourage.</li>
                                            <li>• Gardez une attitude professionnelle et courtoise pour laisser une excellente impression
                                            malgré le refus.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                             Je comprends parfaitement votre décision et vous remercie sincèrement du temps accordé.
                                            Avant de conclure, auriez-vous éventuellement des personnes dans votre entourage, famille ou
                                            amis, susceptibles d’être intéressées par une optimisation rapide et avantageuse de leur
                                            assurance automobile ? </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                                $name = 'demandeConnaissanceAutreProspect';
                                $options = [
                                    [
                                        'onclick' => "onClickDemandeConnaissanceAutreProspect('oui');",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                        'checked' => checked('demandeConnaissanceAutreProspect', 'oui', $questScript, 'checked')
                                    ],
                                    [
                                        'onclick' => "onClickDemandeConnaissanceAutreProspect('non');",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                        'checked' => checked('demandeConnaissanceAutreProspect', 'non', $questScript, 'checked')
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                                ?>
                                <div style="display:none;" class="form-group" id="recommendationsEventuelles2">
                                    <label>Recommandations éventuelles</label>
                                    <input type="text" class="form-control" name="recommendations" value="">
                                </div>
                        </div>
                    
                    <!-- Etape 29 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Recueillez rapidement ces informations spécifiques afin de cerner précisément les
                                        besoins potentiels du prospect.</li>
                                        <li>• Adoptez un ton dynamique et empathique, montrant une écoute active.</li>
                                        <li>• Soyez clair, rapide et précis pour faciliter l’échange sans alourdir la conversation.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Très rapidement, pour vérifier si certaines assurances spécifiques pourraient vous être utiles,
                                        pourriez-vous simplement me préciser
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>     
                        
                        <label class="form-label">Animal domestique :</label>
                        <?php
                                $name = 'siAnimal';
                                $options = [
                                    [
                                        'onclick' => "togglePetField(this);",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                    ],
                                    [
                                        'onclick' => "togglePetField(this);",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                        <input type="text" class="form-control" id="pet_type_field" name="typeAnima" 
                            value="<?= isset($questScript) ? $questScript->typeAnima : ''?>" placeholder="Type d'animal (chien, chat, etc.)" style="display:<?= isset($questScript) && $questScript->siAnimal === 'oui' ? 'block' : 'none'?>;">

                        <label class="form-label">Véhicule électrique ou mobilité électrique :</label>
                        <?php
                                $name = 'siVehiculeElec';
                                $options = [
                                    [
                                        'onclick' => "toggleVehicleField(this);",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                    ],
                                    [
                                        'onclick' => "toggleVehicleField(this);",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                        <input type="text" class="form-control" id="vehicle_type_field" name="typeVehicule" 
                                value="<?= isset($questScript) ? $questScript->typeVehicule : ''?>" placeholder="Type de véhicule (voiture, scooter, vélo, etc.)" style="display:<?= isset($questScript) && $questScript->siVehiculeElec === 'oui' ? 'block' : 'none'?>; ">
                        
                        
                        <label class="form-label">Besoins spécifiques en protection numérique personnelle :</label>
                        <?php
                                $name = 'siProtection';
                                $options = [
                                    [
                                        'onclick' => "toggleDigitalField(this);",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui',
                                    ],
                                    [
                                        'onclick' => "toggleDigitalField(this);",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non',
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    <textarea class="form-control" id="digital_needs_field" name="typeProtection" placeholder="Décrivez vos besoins..." style="display:<?=isset($questScript)&&$questScript->siProtection==='oui'?'block':'none'?>;"><?=isset($questScript)?trim($questScript->typeProtection):''?></textarea>                    </div>

                    <!-- Etape 30 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Terminez toujours positivement, avec une grande courtoisie et en remerciant sincèrement le prospect pour son temps.<br><br></li>
                                    <li>• Invitez clairement le prospect à conserver précieusement les coordonnées du Cabinet Bruno, cela pourrait générer une recommandation indirecte ultérieure.<br><br></li>
                                    <li>• Soyez bref mais chaleureux afin de laisser une très bonne impression finale.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Je vous remercie sincèrement pour le temps que vous m'avez accordé. <br>
                                        N'hésitez pas à garder nos coordonnées si jamais vous-même ou votre entourage avez besoin de services d'assurance à
                                        l'avenir. <br>
                                        HB Assurance reste à votre entière disposition. Je vous souhaite une excellente journée !
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>
                    
                    <!-- 5.2.3. Objection : « Je n’ai pas de besoin actuellement » -->
                     <!-- • Prévoir l’affichage rapide de cette réponse dès que le téléopérateur clique sur « Alerte
                    » et sélectionne « Aucun besoin actuel ». -->
                    <!-- Etape 31 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Soyez compréhensif et respectueux du fait que le prospect n'ait pas de besoin immédiat.<br><br></li>
                                    <li>• Proposez spontanément un rappel futur, tout en sollicitant positivement une recommandation indirecte.<br><br></li>
                                    <li>• Restez bref, courtois et souriant, afin de faciliter la recommandation éventuelle par le prospect.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Souhaitez-vous que je vous recontacte dans quelques mois pour
                                        faire le point sur votre situation, ou auriez-vous dans votre entourage une personne
                                        susceptible d'être intéressée par nos services ?
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';

                        // Response options component
                        $name = 'responsable';
                        $options = [
                            [
                                'onclick' => "",
                                'btn_class' => 'success',
                                'value' => 'oui',
                                'label' => 'Recontact ultérieur',
                                'checked' => checked('responsable', 'oui', $questScript, 'checked')
                            ],
                            [
                                'onclick' => "",
                                'btn_class' => 'danger',
                                'value' => 'non',
                                'label' => 'Demande recommandation',
                                'checked' => checked('responsable', 'non', $questScript, 'checked')
                            ]
                        ];
                        
                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>
                    
                    <!-- 5.2.4. Objection : « Doutes sur les honoraires ou la confiance » -->
                    <!-- Etape 32 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Rassurez immédiatement le prospect en insistant sur la transparence et les références sérieuses du Cabinet Bruno.<br><br></li>
                                    <li>• Valorisez fortement l'option d'un essai sans engagement ou d'un rendez-vous informatif, qui permettent de lever les doutes efficacement.<br><br></li>
                                    <li>• Soyez très empathique et calme, afin d'établir une relation de confiance avec le prospect.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Je comprends totalement vos préoccupations. Le Cabinet Bruno mise précisément sur une
                                        <b>transparence totale</b> de ses tarifs et bénéficie de solides <b>références locales</b> pour vous rassurer
                                        pleinement. Pourriez-vous être intéressé(e) par un rendez-vous d'information détaillé ou
                                        préféreriez-vous débuter par un essai sans aucun engagement pour mieux juger par vous-même ?
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';

                        // Response options component
                        $name = 'responsable';
                        $options = [
                            [
                                'onclick' => "",
                                'btn_class' => 'success',
                                'value' => 'oui',
                                'label' => 'Rendez-vous d\'information',
                                'checked' => checked('responsable', 'oui', $questScript, 'checked')
                            ],
                            [
                                'onclick' => "",
                                'btn_class' => 'danger',
                                'value' => 'non',
                                'label' => 'Essai sans engagement',
                                'checked' => checked('responsable', 'non', $questScript, 'checked')
                            ]
                        ];
                        
                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                        ?>
                    </div>
                    
                    <!-- Etape 33 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Valorisez fortement la spécificité et l’adaptation totale des couvertures proposées.</li>
                                        <li>• Mettez clairement en avant l’attractivité financière et tarifaire immédiate des produits
                                        niche proposés.</li>
                                        <li>• Insistez sur la facilité et la rapidité du processus de souscription afin d’encourager une
                                        prise de décision rapide.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        HB Assurance propose des assurances spécifiques qui offrent une couverture parfaitement
                                        adaptée à vos besoins précis (animaux, mobilité électrique, protection numérique
                                        personnelle), avec des tarifs particulièrement attractifs et une facilité maximale de
                                        souscription immédiate pour votre confort et votre tranquillité.
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                    </div>

                    <!-- Etape 34 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "<li>• Proposez explicitement les prochaines étapes pratiques pour encourager
                                        immédiatement la souscription.</li>
                                        <li>• Insistez sur la simplicité, la rapidité et la gratuité du devis proposé.</li>
                                        <li>• Encouragez activement la prise rapide du rendez-vous pour optimiser la décision du
                                        prospect.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Pour vous permettre de constater immédiatement les avantages et tarifs très attractifs de ces
                                        assurances spécifiques, je vous propose dès maintenant un devis rapide et personnalisé gratuit
                                        , ainsi qu’un rendez-vous simplifié par téléphone ou en ligne pour faciliter votre
                                        souscription immédiate. Souhaitez-vous fixer ce rendez-vous ensemble dès à présent ?</p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        // Response options component
                            $name = 'siEstimationRDV';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'rdv',
                                    'label' => 'Rendez-vous gestionnaire 🗓️',
                                    'checked' => checked('siEstimationRDV', 'rdv', $questScript, 'checked')
                                ],
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'oui',
                                    'label' => 'Devis personnalisé 📖',
                                    'checked' => checked('siEstimationRDV', 'oui', $questScript, 'checked')
                                ],
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('non');",
                                    'btn_class' => 'danger',
                                    'value' => 'non',
                                    'label' => 'Refus RDV',
                                    'checked' => checked('siEstimationRDV', 'non', $questScript, 'checked')
                                ]
                            ];
                            
                            include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <div class="response-options" id="div-prise-rdv5" hidden></div>

                    </div>
                    
                    <!-- Etape 35 : -->
                    <div class="step">
                        <div class="question-box ">
                            <?php
                                // Question content component
                                $consignes = "<li>• Cette étape garantit que le prospect quitte l’appel en ayant toutes les réponses nécessaires.<br><br></li>
                                                        <li>• Soyez très ouvert, encouragez le prospect à poser des questions pour dissiper tout doute restant.<br><br></li>
                                                        <li>• Fournissez explicitement les coordonnées et invitez chaleureusement le prospect à revenir vers vous en cas de besoin.
                                                        </li>";
                                
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Avant de terminer, avez-vous des questions supplémentaires ou besoin d’une précision sur ce
                                                que nous avons vu ensemble ? N’hésitez surtout pas à revenir vers nous au numéro [numéro
                                                Cabinet Bruno] ou par email [email Cabinet Bruno], nous sommes pleinement disponibles
                                                pour vous accompagner.
                                            </p>";
                                
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                        </div>
                    </div>

                    <!-- Etape 36 : -->
                    <div class="step">
                        <div class="question-box ">
                            <?php
                                // Question content component
                                $consignes = "<li>• Remerciez chaleureusement, avec sourire et enthousiasme sincère.<br><br></li>
                                                <li>• Prenez congé de manière professionnelle et positive pour laisser une excellente impression finale.<br><br></li>
                                                <li>• Clôturez l’appel dès que vous avez terminé cette dernière phrase.
                                                </li>";
                                
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Je vous remercie chaleureusement, [Prénom du prospect], pour votre disponibilité et votre
                                        attention.  <br>
                                        Je vous souhaite une excellente journée, au plaisir de notre prochain échange. À très
                                        bientôt !
                                    </p>";
                                
                                include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                        </div>
                    </div>
                    <?php $section = ''; include dirname(__FILE__) . '/blocs/navigationBtns.php'; ?>
                </form>

            </div>
        </div>

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
    </div>
</div>


<script>
    let interetAssurance = ""
    function toggleOtherInsurance(checkbox) {
        const radioInput = checkbox.querySelector('input[type="radio"]');

        interetAssurance = radioInput.value;
        console.log(interetAssurance)
        const otherInput = document.getElementById('autre_assurance_text');
        otherInput.value = "";
        otherInput.style.display = interetAssurance === "autre" ? 'block' : 'none';
        if (!radioInput.checked) otherInput.value = '';
    }

    // Toggle pet type field
    function togglePetField(radio) {
        const radioInput = radio.querySelector('input[type="radio"]');
        const selectedValue = radioInput.value;

        const petField = document.getElementById('pet_type_field');
        petField.style.display = selectedValue === 'oui' ? 'block' : 'none';
        if (selectedValue !== 'oui') petField.value = '';
    }

    // Toggle electric vehicle field
    function toggleVehicleField(radio) {
        const radioInput = radio.querySelector('input[type="radio"]');
        const selectedValue = radioInput.value;

        const vehicleField = document.getElementById('vehicle_type_field');
        vehicleField.style.display = selectedValue === 'oui' ? 'block' : 'none';
        if (selectedValue !== 'oui') vehicleField.value = '';
    }

    // Toggle digital protection field
    function toggleDigitalField(radio) {
        const radioInput = radio.querySelector('input[type="radio"]');
        const selectedValue = radioInput.value;

        const digitalField = document.getElementById('digital_needs_field');
        digitalField.style.display = selectedValue === 'oui' ? 'block' : 'none';
        if (selectedValue !== 'oui') digitalField.value = '';
    }

    function onClickDemandeConnaissanceAutreProspect(val) {
        const recommendationInput = document.getElementById('recommendationsEventuelles')
        const recommendationInput2 = document.getElementById('recommendationsEventuelles2')
        if(val=="oui") {
            recommendationInput.style.display = "block"
            recommendationInput2.style.display = "block"
        }else {
            recommendationInput.style.display = "none"
            recommendationInput2.style.display = "none"
        }
    }
    function onClickSiOccupe(val) {
        const datePicker = document.getElementById('dateInput'); // Assuming you have an element with ID 'datePicker'
        const timePicker = document.getElementById('timeInput'); // Assuming you have an element with ID 'datePicker'
        
        if (val === 'rdv') {
            datePicker.style.display = 'block';
            timePicker.style.display = 'block';
            const now = new Date();

            datePicker.value = now.toISOString().split('T')[0]; // Sets to today's date
            timeInput.value = now.toTimeString().substring(0, 5); // HH:MM
        } else {
            datePicker.style.display = 'none';
            datePicker.value = null;
            timePicker.style.display = 'none';
            timePicker.value = null;
        }
    }
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

    var rdv1Exst = true;
    var divRDV1 = '';
    var rdv1Position1 = 0;
    var hidePlaceRdv1 = true,
        hidePlaceRdvbis = true;
    var hidePlaceRdv2 = true,
        hidePlaceRdv2bis = true;

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

    //ASSISTANT TE
    let numPageTE = 0;
    let nbPageTE = 4;

    var regionsChoosed = [],
        departementChoosed = [];

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

    function selectRadio(button) {
        const radio = button.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
    }

    function onClickProspectB2C(val) {
        if (val == "oui") {
            $("#sous-question-0").attr("hidden", "hidden");
        } else {
            $("#sous-question-0").removeAttr("hidden");
        }
    }

    function onClickSiExistePartenaire(val) {
        if (val == "oui") {
            $("#sous-question-5").attr("hidden", "hidden");
        } else {
            $("#sous-question-5").removeAttr("hidden");
        }
    }

    function onClickSiRecommenderCb(val) {
        if (val == "oui") {
            $("#sous-question-7").removeAttr("hidden");
            $("#div-objections").attr("hidden", "hidden");

            $("#objection-1").attr("hidden", "hidden");
            $("#objection-2").attr("hidden", "hidden");
            $("#objection-3").attr("hidden", "hidden");
        } else if (val == "non") {
            $("#sous-question-7").attr("hidden", "hidden");
            $("#div-objections").attr("hidden", "hidden");

            $("#objection-1").attr("hidden", "hidden");
            $("#objection-2").attr("hidden", "hidden");
            $("#objection-3").attr("hidden", "hidden");
        } else if (val == "objection") {
            $("#sous-question-7").attr("hidden", "hidden");
            $("#div-objections").removeAttr("hidden");

            const valObjection = document.querySelector('input[name="objectionRecommanderCb"]:checked');
            if (valObjection) {
                if (valObjection.value == "Quel avantage concret pour nous ?") {
                    $("#objection-1").removeAttr("hidden");
                    $("#objection-2").attr("hidden", "hidden");
                    $("#objection-3").attr("hidden", "hidden");
                } else if (valObjection.value == "Nous n’avons pas le temps de nous en occuper.") {
                    $("#objection-2").removeAttr("hidden");
                    $("#objection-1").attr("hidden", "hidden");
                    $("#objection-3").attr("hidden", "hidden");
                } else if (valObjection.value == "Méfiance ou inconnu.") {
                    $("#objection-3").removeAttr("hidden");
                    $("#objection-1").attr("hidden", "hidden");
                    $("#objection-2").attr("hidden", "hidden");
                }
            }
        }
    }

    function onClickObjectionRecommanderCb(val) {
        if (val == 1) {
            $("#objection-1").removeAttr("hidden");
            $("#objection-2").attr("hidden", "hidden");
            $("#objection-3").attr("hidden", "hidden");
        } else if (val == 2) {
            $("#objection-2").removeAttr("hidden");
            $("#objection-1").attr("hidden", "hidden");
            $("#objection-3").attr("hidden", "hidden");
        } else if (val == 3) {
            $("#objection-3").removeAttr("hidden");
            $("#objection-1").attr("hidden", "hidden");
            $("#objection-2").attr("hidden", "hidden");
        }
    }

    function onClickSiPersonneDecisionnaire(val) {
        if (val == "non") {
            $("#sous-question-8").removeAttr("hidden");
        } else {
            $("#sous-question-8").attr("hidden", "hidden");
        }
    }
    
    function onclickStautProspect(val) {
        const Proprietaire = document.getElementById('Proprietaire');
        const Locataire = document.getElementById('Locataire');
        const Autre = document.getElementById('Autre');

        if(Proprietaire.checked == true){
            $("#div-si-proprietaire").removeAttr("hidden");
        }
        else{
            $("#div-si-proprietaire").attr("hidden", "hidden");
        }
        
        if(Locataire.checked == true || Autre.checked == true){
            $("#div-si-locataire-autre").removeAttr("hidden");
        }
        else{
             $("#div-si-locataire-autre").attr("hidden", "hidden");
        }
    }

    function functionStatutProspect(isChecked) {
        if (isChecked) {
            $(`#statutProspect`).removeAttr('hidden');
        } else {
            $(`#statutProspect`).attr('hidden', '');
        }
    }

    function onClickSiContacBailleur(val) {
        if (val == "oui") {
            $("#div-has-contact-bailleur").removeAttr("hidden");
        } else {
            $("#div-has-contact-bailleur").attr("hidden", "hidden");
        }
    }
    
    function onClickCorrecteInfosProprietaire(val) {
        if (val == "oui") {
            $("#sous-question-6").attr("hidden", "hidden");
        } else {
            $("#sous-question-6").removeAttr("hidden");
        }
    }

    function selectTypebailleur(val) {
        if (val == "Propriétaire") {
            $("#div-type-bailleur-proprietaire").removeAttr("hidden");
            $("#div-type-bailleur-syndic").attr("hidden", "hidden");
        } else if(val == "Syndic") {
            $("#div-type-bailleur-syndic").removeAttr("hidden");
            $("#div-type-bailleur-proprietaire").attr("hidden", "hidden");
        }
        else{
            $("#div-type-bailleur-syndic").attr("hidden", "hidden");
            $("#div-type-bailleur-proprietaire").attr("hidden", "hidden");
        }
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


    function onClickSiDsiponible(val) {
        if (val == "rdv") {
            if (hidePlaceRdv1) {
                dateRDV = "";
                document.getElementById('div-prise-rdv-bis').innerHTML = '';
                document.getElementById("div-prise-rdv").innerHTML = htmlRDV1();
                getDisponiblites();


                $("#div-prise-rdv").removeAttr("hidden");
                $("#divChargementDisponibilite").removeAttr("hidden");
                hidePlaceRdv1 = false;
                hidePlaceRdvbis = true;
            }
        } else {
            $("#div-prise-rdv").attr("hidden", "hidden");
            $("#divChargementDisponibilite").attr("hidden", "hidden");
            hidePlaceRdv1 = true;
            document.getElementById("div-prise-rdv").innerHTML = '';
        }
    }


    function onClickTypeRencontre(val) {
        if (val == "physique" || val == "Visioconférence") {
            $("#bloc-prise-rdv2-bis").removeAttr("hidden");
            if (val == "Visioconférence") {
                $("#imputLienVisioconference").removeAttr("hidden");
            } else {
                $("#imputLienVisioconference").attr("hidden", "hidden");
            }

            if (hidePlaceRdv2bis) {
                dateRDV = "";
                $("#sous-menu-recap").attr("hidden", "hidden");
                document.getElementById("div-prise-rdv2").innerHTML = "";
                const myHTML = htmlRDV2();
                document.getElementById("div-prise-rdv2-bis").innerHTML = myHTML;
                //console.log(myHTML);
                getDisponiblites2();
                $("#divChargementDisponibilite2").removeAttr("hidden");
                hidePlaceRdv2bis = false;
                hidePlaceRdv2 = true;
            }

        } else {
            $("#bloc-prise-rdv2-bis").attr("hidden", "hidden");
            $("#sous-menu-recap").attr("hidden", "hidden");
            $("#imputLienVisioconference").attr("hidden", "hidden");
            $("#divChargementDisponibilite2").attr("hidden", "hidden");
            hidePlaceRdv2bis = true;
            document.getElementById("div-prise-rdv2-bis").innerHTML = '';

        }
    }



    function onClickSiDisponiblePoint(val) {
        if (val == "oui") {
            $("#div-prise-rdv-bis").attr("hidden", "hidden");
            $("#divChargementDisponibilite").attr("hidden", "hidden");
            hidePlaceRdvbis = true;
            document.getElementById("div-prise-rdv-bis").innerHTML = '';
        } else {
            if (hidePlaceRdvbis) {
                dateRDV = "";
                document.getElementById('div-prise-rdv').innerHTML = '';
                document.getElementById("div-prise-rdv-bis").innerHTML = htmlRDV1();
                getDisponiblites();

                $("#div-prise-rdv-bis").removeAttr("hidden");
                $("#divChargementDisponibilite").removeAttr("hidden");
                hidePlaceRdvbis = false;
                hidePlaceRdv1 = true;
            }
        }
    }


    function onClickSiRDVMefianceInconnu(val) {
        if (val == "oui") {
            if (hidePlaceRdv2) {
                dateRDV = "";
                document.getElementById('div-prise-rdv2-bis').innerHTML = '';
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
        const rep = document.querySelector('input[name="raisonRefusSignature"]:checked');
        $(`#divPriseRdvPerso`).removeAttr('hidden');
        if (rep.value == "prefereDemander") {
            $(`#textPropositionHesitationSignature`).text(
                "Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. <br>Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, une fois votre échange réalisé."
            );
        } else {
            if (rep.value == "documentManquant") {
                $(`#textPropositionHesitationSignature`).text(
                    "Oui effectivement, je note bien que certains documents vous manquent, c’est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. <br>Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
                );
            } else {
                if (rep.value == "signatureComplique") {
                    $(`#textPropositionHesitationSignature`).text(
                        "Je comprends parfaitement. Soyez rassuré(e), c’est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                    );
                } else {
                    if (rep.value == "prendreConnaissance") {
                        $(`#textPropositionHesitationSignature`).text(
                            "Parfait, je vous remercie. Le rendez-vous téléphonique est confirmé. Je vous adresse dès maintenant notre documentation complète ainsi que la délégation de gestion par mail afin que vous puissiez en prendre connaissance avant notre échange.<b>Merci beaucoup pour votre aide et excellente journée !"
                        );
                    } else {

                    }
                }
            }
        }
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

    function functionAutreTypologie(isChecked) {
        if (isChecked) {
            $(`#autreTypologie`).removeAttr('hidden');
        } else {
            $(`#autreTypologie`).attr('hidden', '');
        }
    }

    function functionActivite(value) {
        if (value == "Autres") {
            $(`#autreActivite`).removeAttr('hidden');
        } else {
            $(`#autreActivite`).attr('hidden', '');
        }
    }

    function ClickResponsable(val) {
        console.log(val);
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
                url: `<?= URLROOT ?>/public/json/vocalcom/campagneSociete.php?action=saveInfosContact`,
                type: 'POST',
                data: dataObject,
                dataType: "JSON",
                beforeSend: function() {
                    // $("#msgLoading").text("Génération de code et envoi en cours...");
                    // $("#loadingModal").modal("show");
                    console.log("Before Send");

                },
                success: function(response1) {
                    console.log("success ok code");
                    console.log(response1);
                    body
                    if (response1 != null && response1 !== undefined && response1 != {}) {

                    } else {
                        $("#msgError").text(
                            "(1)Erreur enregistrement, Veuillez réessayer ou contacter l'administrateur"
                        );
                        $('#errorOperation').modal('show');
                    }
                },
                error: function(response1) {
                    // $("#loadingModal").modal("hide");
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

    }

    //onChangeTypeSin();

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
            '<?= isset($questScript) && isset($questScript->dommages) ? $questScript->dommages : '' ?>' // <- récupéré depuis PHP ou du formulaire
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

    function showSousQuestion(idSS, $show) {
        if ($show) {
            $(`#sous-question-${idSS}`).removeAttr('hidden');
        } else {
            $(`#sous-question-${idSS}`).attr('hidden', '');
        }

    }

    function updateButtons() {
        indexPage.innerText = pageIndex;
        prevBtn.classList.toggle("hidden", currentStep === 0);
        // nextBtn.classList.toggle("hidden", currentStep === steps.length - 1 || currentStep == 7);
        nextBtn.classList.toggle("hidden", (currentStep == 30 || currentStep == 36 /*|| currentStep ==
            70*/));
        // finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1 && currentStep != 7);
        finishBtn.classList.toggle("hidden", (currentStep != 30 && currentStep != 36 /*&& currentStep !=
            70*/));

        const spans = document.querySelectorAll('span[name="numQuestionScript"]');
        /* spans.forEach((span, index) => {
            span.textContent = pageIndex; // ou un autre texte si tu veux
        });*/
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


    function goNext() {
        if (currentStep === 0) {
            const val = document.querySelector('input[name="prospectB2C"]:checked');
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
        else if (currentStep === 2) {
            const val = document.querySelector('input[name="siDsiponible"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(4);
            } else {
                return showStep(3);
            }

        }
        else if (currentStep === 3) {
            const val = document.querySelector('input[name="siOccupe"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(4);
            } 
            else if (val.value == "rdv") {
                // RDV + FIN RDV
            } else {
                // Fin
                return showStep(30);
            }
        }
        else if (currentStep === 4) {

            const Proprietaire = document.getElementById('Proprietaire');
            const Locataire = document.getElementById('Locataire');
            const Autre = document.getElementById('Autre');

            if (! Proprietaire.checked  && ! Locataire.checked  && ! Autre.checked ) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (Proprietaire.checked) {
                const val2 = document.querySelector('input[name="typeBienProprietaure"]:checked');
                if (!val2) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                else{
                    return showStep(6);
                }
            } 
            if(Locataire.checked || Autre.checked) {
                const val2 = document.querySelector('input[name="siContacBailleur"]:checked');
                if (!val2) {
                    $("#msgError").text("Veuillez sélectionner une réponse !");
                    $('#errorOperation').modal('show');
                    return;
                }
                else{
                    if(Autre.checked){
                        return showStep(5);
                    }
                    else{
                        return showStep(7);
                    }
                    
                }
            }
        }
        else if (currentStep === 5) {
            const val = document.querySelector('input[name="siEnvisagerProjetImmobilier"]:checked');
            const Proprietaire = document.getElementById('Proprietaire');
            const Locataire = document.getElementById('Locataire');
            
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            else if (val.value == "oui") {
                if(! Proprietaire.checked && ! Locataire.checked){
                    return showStep(31);
                }
                else{
                    return showStep(7);
                }
            } else {
                if(! Proprietaire.checked && ! Locataire.checked){
                    return showStep(30);
                }
                else{
                    return showStep(7);
                }
            }
        }
        else if (currentStep === 6) {
            const val = document.querySelector('input[name="correcteInfosProprietaire"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            else{
                return showStep(7);
            }
        }
        else if (currentStep === 9) {
            const Proprietaire = document.getElementById('Proprietaire');
            const Locataire = document.getElementById('Locataire');
            const Autre = document.getElementById('Autre');

            if(! Proprietaire.checked && ! Locataire.checked && ! Autre.checked){
                return showStep(4);
            }   
            else{
                if(Proprietaire.checked){
                    const typeBienProprietaure = document.querySelector('input[name="typeBienProprietaure"]:checked');
                    if(typeBienProprietaure.value == "Résidence principale en copropriété"){
                        return showStep(10);
                    }
                    else if(typeBienProprietaure.value == "Bien mis en location"){
                        return showStep(16);
                    }
                    else if(typeBienProprietaure.value == "Projet de vente"){
                        return showStep(22);
                    }
                    else{
                        return showStep(4);
                    }
                    
                }
                else if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(30);
                }
            }
        }

        else if (currentStep === 14) {
            const val = document.querySelector('input[name="rdvOuEtudeGratuite"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "Refus changement syndic") {
                return showStep(15);
            } else {
                const Locataire = document.getElementById('Locataire');
                if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(33);
                }
            }
        }
        
        else if (currentStep === 15) {
            const val = document.querySelector('input[name="demandeConnaissanceAutreProspect"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            else{
                const Locataire = document.getElementById('Locataire');
                if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(30);
                }
            }
        }

        else if (currentStep === 20) {
            const val = document.querySelector('input[name="typeRencontre"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                return showStep(21);
            } else {
                const Locataire = document.getElementById('Locataire');
                if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(33);
                }
            }
        }

        else if (currentStep === 21) {
            return showStep(30);
        }

        else if (currentStep === 27) {
            const val = document.querySelector('input[name="siEstimationRDV"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                const Locataire = document.getElementById('Locataire');
                if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(30);
                }
            } else {
                const Locataire = document.getElementById('Locataire');
                if(Locataire.checked){
                    return showStep(28);
                }
                else{
                    return showStep(33);
                }
            }
        }
        
        else if (currentStep === 29) {
            return showStep(33);
        }
        
        else if (currentStep === 31) {
            return showStep(30);
        }

         /*else if (currentStep === 4) {
            var div = document.getElementById('place-date-heure-rdv');
            const val = document.querySelector('input[name="siDsiponible"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(6);
            } else {
                if (dateRDV == "") {
                    $("#msgError").text("Veullez prendre le rendez-vous !");
                    $('#errorOperation').modal('show');
                } else {
                    div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                    return showStep(5);
                }
            }
        } else if (currentStep === 6) {
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
                return showStep(7);
            }
        } else if (currentStep === 7) {
            const val = document.querySelector('input[name="siExistePartenaire"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(8);
            } else {
                return showStep(9);
            }
        } else if (currentStep === 8) {
            const val = document.querySelector('input[name="siExistePartenaireRep"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(10);
            } else {
                return showStep(25); //FIN
            }
        } else if (currentStep === 9) {
            const val = document.querySelector('input[name="siRecommenderCb"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(10);
            } else if (val.value == "non") {
                return showStep(25); //FIN
            } else if (val.value == "objection") {
                const val2 = document.querySelector('input[name="objectionRecommanderCb"]:checked');
                if (!val2) {
                    $("#msgError").text("Veuillez sélectionner une objection !");
                    $('#errorOperation').modal('show');
                    return;
                }
                if (val2.value == "Quel avantage concret pour nous ?") {
                    const val2 = document.querySelector('input[name="siAccepteSuiteQuelAvantage"]:checked');
                    if (!val2) {
                        $("#msgError").text("Veuillez sélectionner une réponse !");
                        $('#errorOperation').modal('show');
                        return;
                    }
                    if (val2.value == "oui") {
                        return showStep(10);
                    } else {
                        return showStep(25); //FIN
                    }

                } else if (val2.value == "Nous n’avons pas le temps de nous en occuper.") {

                    const val = document.querySelector('input[name="siAccepteSuitePasTemps"]:checked');
                    if (!val) {
                        $("#msgError").text("Veuillez sélectionner une réponse !");
                        $('#errorOperation').modal('show');
                        return;
                    }
                    if (val.value == "oui") {
                        return showStep(10);
                    } else {
                        return showStep(25); //FIN
                    }
                } else if (val2.value == "Méfiance ou inconnu.") {

                    var div = document.getElementById('place-date-heure-rdv');
                    const val = document.querySelector('input[name="siRDVMefianceInconnu"]:checked');
                    if (!val) {
                        $("#msgError").text("Veuillez sélectionner une réponse !");
                        $('#errorOperation').modal('show');
                        return;
                    }
                    if (val.value == "non") {
                        return showStep(10); //FIN
                    } else {
                        if (dateRDV == "") {
                            $("#msgError").text("Veullez prendre le rendez-vous !");
                            $('#errorOperation').modal('show');
                        } else {
                            div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                            return showStep(5);
                        }
                    }

                }
            }
        } else if (currentStep === 18) {


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

            return showStep(19);
        } else if (currentStep === 20) {
            var div = document.getElementById('place-date-heure-rdv');
            const val = document.querySelector('input[name="siDisponiblePoint"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(21);
            } else {
                if (dateRDV == "") {
                    $("#msgError").text("Veullez prendre le rendez-vous !");
                    $('#errorOperation').modal('show');
                } else {
                    div.innerHTML = ` ${dateRDV}  de ${heureDebutRDV} à  ${heureFinRDV}`;
                    return showStep(5); //Fin
                }
            }
        } else if (currentStep === 21) {
            const val = document.querySelector('input[name="siValideAujourdhui"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(22);
            } else {
                return showStep(26); //FIN
            }
        } else if (currentStep === 22) {
            var div = document.getElementById('place-date-heure-rdv');
            const val = document.querySelector('input[name="typeRencontre"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                return showStep(26); // Fin
            } else {
                if (dateRDV == "") {
                    $("#msgError").text("Veullez prendre le rendez-vous !");
                    $('#errorOperation').modal('show');
                } else {
                    return showStep(23);
                }
            }
        }*/ else if (currentStep < steps.length - 1) {
            showStep(currentStep + 1);
        }
    }


    function saveScriptPartiel(etape) {
        getInfoMail()
        let form = document.getElementById('scriptForm');
        const formData = new FormData(form);
        let causes = formData.getAll('cause[]');
        let dommages = formData.getAll('dommages[]');
        let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
        formData.append('type', 'HbB2c');
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



                // if (response != "0") {
                //     opCree = response;
                // }
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
                    0

                }
            },
        });
    }

    function finish() {
        saveScriptPartiel('fin');
    }

    updateButtons();

    //ASSISTANT SIGNATURE
    let numPageSign = 0;
    let nbPageSign = 7;

    function loadPageSign(params) {

        let idOP = $('#idOP').val();
        let numPolice = $('#numPolice').val();
        let numSinistre = $('#numSinistre').val();
        let dateSinistre = $('#dateSinistre').val();
        let dateDebutContrat = $('#dateDebutContrat').val();
        let dateFinContrat = $('#dateFinContrat').val();
        let idCie = $('#idCie').val();
        let guidCie = $('#numeroCie').val();
        let nomCie = $('#nomCie').val();
        let adresse = $('#adresseCie').val();
        let ville = $('#villeCie').val();
        let codePostal = $('#codePostalCie').val();
        let email = $('#emailCie').val();
        let tel = $('#telCie').val();
        let idApp = $('#idApp').val();
        let idImmeuble = $('#idImmeuble').val();
        let adresseImmeuble = $('#adresseImm').val();
        let dateNaissance = $('#dateNaissance').val();
        let prenomSignataire = $('#prenomSignataire').val();
        let nomSignataire = $('#nomSignataire').val();
        let idSignataire = $('#idSignataire').val();
        let idContact = $('#idContact').val()
        let etage = $('#etage').val();
        let porte = $('#porte').val()
        let libellePartieCommune = $('#libellePartieCommune').val()
        let cote = $('#cote').val()
        let typeSinistre = $('#typeSinistre').val();
        let resultatActivityTE = $('#resultatActivityTE').val()

        let emailSign = $('#emailSign').val();
        let telSign = $('#telSign').val()
        let signature = $('#modeSignature').val()

        let verif = true;
        let text = "";
        //Vérif assurance
        if (params == "suivant") {

            if (numPageSign == "1") {
                // onClickTerminerAssistant();
                if (typeSinistre != "Partie commune exclusive" && (dateNaissance == "" || prenomSignataire.trim() == "" ||
                        nomSignataire.trim() == "")) {
                    if (dateNaissance == "") {
                        text = "Veuillez renseigner la date de naissance !";

                    } else {
                        if (prenomSignataire.trim() == "") {
                            text = "Veuillez renseigner le prénom !";
                        } else {
                            if (nomSignataire.trim() == "") {
                                text = "Veuillez renseigner le nom !";
                            }
                        }
                    }
                    verif = false;
                }
            } else {
                if (numPageSign == "3") {
                    if (nomCie == "") {
                        text =
                            "Veuillez renseigner la compagnie d'assurance !";
                        verif = false;
                    }
                } else {
                    if (numPageSign == "4") {
                        if (numPolice == "" || dateDebutContrat == "" || dateFinContrat == "") {
                            text =
                                "Veuillez renseigner les informations du contrat d'assurance !";
                            verif = false;
                        }
                    } else {
                        if (numPageSign == "5") {
                            if (dateSinistre == "") {
                                text = "Veuillez renseigner la date du sinistre !";
                                verif = false;
                            }
                        } else {
                            if (numPageSign == "2") {
                                if (typeSinistre != "Partie commune exclusive" && (adresseImmeuble == "" || etage ==
                                        "" || porte == "")) {
                                    text =
                                        "Veuillez renseigner l'adresse, l'étage et le N° de porte !";
                                    verif = false;
                                }
                                if (typeSinistre == "Partie commune exclusive" && (libellePartieCommune == "")) {
                                    text =
                                        "Veuillez renseigner l'adresse et la localisation !";
                                    verif = false;
                                }
                            } else {
                                if (numPageSign == "7") {
                                    console.log("Email Tel");

                                    if (emailSign == "" || telSign == "") {
                                        text = "Veuillez confirmer le numèro de téléphone et l'adresse email !";
                                        verif = false;
                                    } else {
                                        console.log("save");

                                    }
                                } else {

                                }
                            }
                        }
                    }
                }
            }
            //SAVE ON CLICK SUIVANT
            if (verif) {
                console.log("numPage " + numPageSign);
            }
        } else {
            $('#divCodeSign').attr("hidden", "hidden");
            $('#btnSignFinaliser').attr("hidden", "hidden");
        }

        if (verif) {
            $('#divSign' + numPageSign).attr("hidden", "hidden");
            if (params == 'suivant') {
                numPageSign++;
            } else {
                numPageSign--;
            }
            $('#divSign' + numPageSign).removeAttr("hidden");

            if (numPageSign == 0) {
                $('#btnSignPrec').attr("hidden", "hidden");
            } else {
                $('#btnSignPrec').removeAttr("hidden");
            }

            if (numPageSign == nbPageSign) {
                console.log("NumPage et nbPageSign " + numPageSign + " " + nbPageSign);

                let btn = document.getElementById("btnSignTerminer");
                if (signature != null && signature != "") {
                    btn.innerHTML =
                        `<a type="button" class="text-center btn btn-success" onclick="onClickTerminerAssistant()">Terminer</a>`;
                } else {
                    btn.innerHTML =
                        `<a type="button" class="text-center btn btn-danger" onclick="onClickTerminerAssistant()">Suivant</a>`;
                }
                $('#btnSignSuiv').attr("hidden", "hidden");
                $('#btnSignTerminer').removeAttr("hidden");

            } else {
                $('#btnSignSuiv').removeAttr("hidden");
                $('#btnSignTerminer').attr("hidden", "hidden");
            }
        } else {
            $("#msgError").text(text);
            $('#errorOperation').modal('show');
        }
    }

    function saveInfosAssistant() {

        if (numPageSign != "0") {
            if (numPageSign == "1") {
                //SAVE TE
                // saveCauses();
            } else {
                //SAVE INFO ASSURANCES
                if ($('#typeSinistre').val() == "Partie commune exclusive") {
                    // saveInfosAssurance('MRI', 'enreg');
                } else {
                    // saveInfosAssurance('MRH', 'enreg');
                }
                if (numPageSign == 7) {

                }
            }
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



                if (response != "0") {
                    opCree = response;
                }
            },
            error: function(response) {
                setTimeout(() => {
                    $("#loadingModal").modal("hide");
                }, 500);

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
                                $('#btnSignTerminer').attr("hidden", "hidden");
                                $('#divSign7').attr("hidden", "hidden");
                                $('#divCodeSign').removeAttr("hidden");
                                $('#btnSignFinaliser').removeAttr("hidden");
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
                        createDate: $('#createDateSign').val(),
                        civilite: $('#civiliteSign').val(),
                        prenom: $('#prenomSign').val(),
                        nom: $('#nomSign').val(),
                        idContact: $('#idContactSign').val(),
                        numeroContact: $('#numeroContactSign').val(),
                        email: email,
                        tel: tel,
                        type: type,
                        commentaire: "",
                        idAuteur: `<?= $connectedUser->idUtilisateur ?>`,
                        numeroAuteur: `<?= $connectedUser->numeroContact ?>`,
                        login: "",
                        auteur: `<?= $connectedUser->prenomContact . ' ' . $connectedUser->nomContact  ?>`,
                        signature: signature
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        $("#msgLoading").text("Signature en cours...");
                        $("#loadingModal").modal("show");
                    },
                    success: function(response) {


                        setTimeout(() => {
                            $("#loadingModal").modal("hide");
                        }, 500);
                        if (response != null && response != "" && response == "1") {
                            $("#msgSuccess").text("Délégation de gestion signée avec succés !");
                            $('#successOperation').modal('show');
                            closeActivity("Faire signer la délégation de gestion", 1);
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


                // 
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

    function onChangeDateDebutContrat() {
        let deb = $('#dateDebutContrat').val();
        let date = new Date(deb);
        $('#dateFinContrat').attr("value", (date.getFullYear() + 1) + "-" + String(date.getMonth() + 1).padStart(2,
            '0') + "-" + String(date.getDate()).padStart(2, '0'));
    }

    //ASSISTANT RV
    let numPageRV = 0;
    let nbPageRV = 4;

    function onClickReprogrammerRvRT() {
        loadPageRV("suivant");
        $('#divFooterRV').removeAttr("hidden");
    }

    function loadPageRV(params) {
        let idOP = $('#idOP').val();
        let idApp = $('#idApp').val();
        let idImmeuble = $('#idImmeuble').val();
        let adresseImmeuble = $('#adresseImm').val();
        let idContact = $('#idContact').val()
        let etage = $('#etage').val();
        let porte = $('#porte').val();
        let tel = $('#telRV').val();
        let email = $('#emailRV').val();
        let textRV = $("#INFO_RDV").text();
        let libellePartieCommune = $('#libellePartieCommune').val()
        let cote = $('#cote').val()
        let typeSinistre = $('#typeSinistre').val();

        let verif = true;
        let text = "";
        //Vérif assurance
        if (params == "suivant") {
            if (numPageRV == "1") {
                if (tel == "" || email == "") {
                    text =
                        "Veuillez renseigner le numèro de téléphone et l'adresse Email !";
                    verif = false;
                }
            } else {
                if (numPageRV == "2") {

                    if (typeSinistre != "Partie commune exclusive" && (adresseImmeuble == "" || etage ==
                            "" || porte == "")) {
                        text =
                            "Veuillez renseigner l'adresse, l'étage et le N° de porte !";
                        verif = false;
                    }
                    if (typeSinistre == "Partie commune exclusive" && (libellePartieCommune == "")) {
                        text =
                            "Veuillez renseigner l'adresse et la localisation !";
                        verif = false;
                    }


                } else {
                    if (numPageRV == "3") {
                        if (textRV == "") {
                            text =
                                "Veuillez choisir une disponibilité !";
                            verif = false;
                        }
                    } else {

                    }
                }
            }

        }

        if (verif) {
            console.log(numPageRV)
            //SI MEME RV
            let siMemeRV = $('.siMemeRV:checked').val();
            //SET TEL EMAIL
            $('#telContact').val(tel);
            $('#emailContact').val(email);
            $('#divRV' + numPageRV).attr("hidden", "hidden");
            if (params == 'suivant') {
                if (siMemeRV == "Oui") {
                    $("#INFO_RDV").text("RDV à prendre pour " + $('#nomCommercialFuturRV').val() + " le " + $(
                            '#dateFuturRV').val() + " à partir de " +
                        $('#heureFuturRV').val());
                    $('#expertRV').attr("value", $('#nomCommercialFuturRV').val());
                    $('#idExpertRV').attr("value", $('#idCommercialFuturRV').val());
                    $('#dateRV').attr("value", $('#dateFuturRV').val());
                    $('#heureRV').attr("value", $('#heureFuturRV').val());
                    numPageRV = 4;
                } else {
                    if (numPageRV == "1") {
                        // addOrupdateContact('update');
                    }
                    if (numPageRV == "2") {
                        // AddOrEditImmeuble('editLot');
                    }
                    numPageRV++;

                    if (numPageRV == "1") {
                        onClickPrendreRvRT();
                    }
                }
            } else {
                if (siMemeRV == "Oui") {
                    numPageRV = 0;
                } else {
                    numPageRV--;
                }
            }
            console.log("after " + numPageRV);
            $('#divRV' + numPageRV).removeAttr("hidden");

            if (numPageRV == 0) {
                $('#btnRVPrec').attr("hidden", "hidden");
            } else {
                $('#btnRVPrec').removeAttr("hidden");
            }

            if (numPageRV == nbPageRV) {
                $('#btnRVSuiv').attr("hidden", "hidden");
                $('#btnRVTerminer').removeAttr("hidden");

            } else {
                $('#btnRVSuiv').removeAttr("hidden");
                $('#btnRVTerminer').attr("hidden", "hidden");
            }

        } else {
            $("#msgError").text(text);
            $('#errorOperation').modal('show');
        }

    }


    //PRISE RDV
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

    function getDisponiblites() {
        let post = {
            codePostal: "",
            adresseRV: "",
            ville: "",
            batiment: "",
            etage: "",
            libelleRV: "",
            idUser: <?= $idAuteur ?>,
            nomUserRV: "<?= $auteur ?>",
            organisateurs: []
        }
        $.ajax({
            // url: `<?= URLROOT ?>/public/json/disponibilite.php?action=getDisponibilitesExpert`,
            url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesMultiples&source=wbcc&origine=web&forcage=1`,
            type: 'POST',
            data: (post),
            dataType: "JSON",
            beforeSend: function() {
                $('#divChargementNotDisponibilite').attr("hidden", "hidden");
                $('#divChargementDisponibilite').removeAttr("hidden");
                // $("#msgLoading").text("Chargement agenda en cours ...");
                // $("#loadingModal").modal("show");
            },
            success: function(result) {
                console.log(result);
                // setTimeout(() => {
                //     $("#loadingModal").modal("hide");
                // }, 1000);
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
                        afficheBy10InTable();
                        $('#divPriseRvRT-1').removeAttr("hidden");
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
                $('#divPriseRvRT-1').attr("hidden", "hidden");
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
            // url: `<?= URLROOT ?>/public/json/disponibilite.php?action=getDisponibilitesExpert`,
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

    function onClickEnregistrerRV() {
        // let expert = document.getElementById('expertRV');
        // let idExpert = expert.options[expert.selectedIndex].value;
        let expert = $('#expertRV').val();
        let idExpert = $('#idExpertRV').val();
        let idContact = $('#idContactRV').val();
        let date = $('#dateRV').val();
        let heure = $('#heureRV').val();
        let adresse = $('#adresseImm').val();
        let commentaire = $('#commentaireRV').val();
        if (idExpert != "0" && idContact != "0" && date != "" && heure != "" && adresse != "") {
            let post = [];
            post[0] = {
                idOpportunityF: $('#idOP').val(),
                numeroOP: $('#nameOP').val(),
                expert: expert,
                idExpert: idExpert,
                idContact: idContact,
                idContactGuidF: $('#numeroContactRV').val(),
                dateRV: date,
                heureDebut: heure,
                adresseRV: adresse,
                etage: $('#etage2').val(),
                porte: $('#porte2').val(),
                lot: $('#lot2').val(),
                batiment: $('#batiment2').val(),
                conclusion: commentaire,
                idUtilisateur: $('#idUtilisateur').val(),
                numeroAuteur: $('#numeroAuteur').val(),
                auteur: $('#auteur').val(),
                idRVGuid: "",
                idRV: "0",
                idAppGuid: $('#numeroApp').val(),
                idAppExtra: $('#idApp').val(),
                idAppConF: $('#idAppCon').val(),
                nomDO: $('#nomDO').val(),
                moyenTechnique: "",
                idCampagneF: "",
                typeRV: "RTP",
                cote: $('#cote2').val(),
                libellePartieCommune: $('#libellePartieCommune2').val(),
                typeLot: $('#typeLot').val()
            }

            // let siPlusieursRV = $('.siPlusieursRV:checked').val();
            // let idsOthersOP = $('#idsOthersOP').val();
            // let namesOthersOP = $('#namesOthersOP').val();
            // let tabIdsOP = [];
            // if (idsOthersOP != undefined && idsOthersOP != "" && idsOthersOP != null) {
            //     tabIdsOP = idsOthersOP.split(',');
            // }
            // let tabNamesOP = [];
            // if (namesOthersOP != undefined && namesOthersOP != "" && namesOthersOP != null) {
            //     tabNamesOP = namesOthersOP.split(',');
            // }
            // if ($('#idsOthersOP').val() != "" && siPlusieursRV == "Oui" && tabIdsOP.length != 0) {

            //     tabIdsOP.forEach((element, index) => {
            //         if (element.trim() != "") {
            //             post.push({
            //                 idOpportunityF: element,
            //                 numeroOP: tabNamesOP[index],
            //                 expert: expert,
            //                 idExpert: idExpert,
            //                 idContact: idContact,
            //                 idContactGuidF: $('#numeroContactRV').val(),
            //                 dateRV: date,
            //                 heureDebut: heure,
            //                 adresseRV: adresse,
            //                 etage: $('#etage2').val(),
            //                 porte: $('#porte2').val(),
            //                 lot: $('#lot2').val(),
            //                 batiment: $('#batiment2').val(),
            //                 conclusion: commentaire,
            //                 idUtilisateur: $('#idUtilisateur').val(),
            //                 numeroAuteur: $('#numeroAuteur').val(),
            //                 auteur: $('#auteur').val(),
            //                 idRVGuid: "",
            //                 idRV: "0",
            //                 idAppGuid: $('#numeroApp').val(),
            //                 idAppExtra: $('#idApp').val(),
            //                 idAppConF: $('#idAppCon').val(),
            //                 nomDO: $('#nomDO').val(),
            //                 moyenTechnique: "",
            //                 idCampagneF: "",
            //                 typeRV: "RTP",
            //                 cote: $('#cote2').val(),
            //                 libellePartieCommune: $('#libellePartieCommune2').val(),
            //                 typeLot: $('#typeLot').val()
            //             });
            //         }
            //     });
            // }

            // console.log(post)

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

                            if ($('#idsOthersOP').val() != "" && siPlusieursRV == "Oui") {
                                tabIdsOP.forEach((element, index) => {
                                    if (element.trim() != "") {
                                        closeActivity('Programmer le RT', 3, element, tabNamesOP[
                                            index]);
                                    }
                                });
                            }
                            closeActivity('Programmer le RT', 3);
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

    function onClickSuivantRDV() {
        if (nbPage >= nbPageTotal) {
            alert("Plus de disponibiltés! veuillez forcer");
        } else {
            nbPage++;
            afficheBy10InTable();
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

    function onClickSuivantRDV2() {
        if (nbPage >= nbPageTotal) {
            alert("Plus de disponibiltés! veuillez forcer");
        } else {
            nbPage++;
            afficheBy10InTable2();
        }
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

    function onClickPrecedentRDV() {
        if (nbPage != 1) {
            iColor = ((nbPage - 1) * 2) - 2;
            nbPage--;
            k = k - nbDispo - 10;
            afficheBy10InTable();
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

    function onClickPrecedentRDV2() {
        if (nbPage != 1) {
            iColor = ((nbPage - 1) * 2) - 2;
            nbPage--;
            k = k - nbDispo - 10;
            afficheBy10InTable2();
        }
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

    function afficheBy10InTable() {
        var test = 0;
        var kD = k;
        first = k;
        $('#divTabDisponibilite').empty();
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
        $('#divTabDisponibilite').append(html);
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

            afficheNewTable(nomCommercial, DATE_RV, DUREE);
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

    function afficheNewTable(nomCommercial, date, duree) {
        $('#divTabHoraire').empty();
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
        $('#divTabHoraire').append(html);

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
                $("#INFO_RDV").text("RDV à prendre pour " + commercialRDV + " le " + dateRDV + " de " +
                    heureDebutRDV +
                    " à " + heureFinRDV);
                $('#expertRV').attr("value", commercialRDV);
                $('#idExpertRV').attr("value", idCommercialRDV);
                $('#dateRV').attr("value", dateRDV.replace(" ", "").split(' ')[1]);
                $('#heureRV').attr("value", heureDebutRDV);
                $('#divPriseRvRT').removeAttr("hidden");
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

<?php
include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>