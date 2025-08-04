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
                    <h2><span><i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i></span> Campagne production B2B HB Assurance - 
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/logo_Cabinet_Bruno.png" alt=""></h2>
                </div>

                <?=
                    include dirname(__FILE__) . '/blocs/formCbB2B.php';
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
                                    <li>• Utilisez impérativement un ton formel, cordial et très professionnel dès le début de
                                    l’appel.</li>
                                    <li>• Vérifiez clairement et rapidement l’identité de votre interlocuteur afin d’éviter toute perte
                                    de temps.</li>
                                    <li>• Si vous n’êtes pas en présence du bon décideur, obtenez systématiquement les
                                    coordonnées précises du responsable pertinent.</li>
                                    ";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                                <p class="text-justify">
                                                Bonjour, <b style="color: blue">' . $gerant->prenom . ' ' . $gerant->nom . '</b>, je suis ' . $connectedUser->fullName . ', conseiller commercial chez HB Assurance,
                                                cabinet indépendant spécialisé dans l’optimisation des assurances professionnelles. Pourriezvous me confirmer que vous êtes bien la personne en charge des contrats d’assurance au sein de
                                                votre entreprise ?
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
                                        <div class="col-md-12 mb-3">
                                    <!-- INFOS MAIL -->
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Civilité</label>
                                            <select name="civiliteGerant" ref="civiliteGerant" id="" class="form-control">
                                                <option value="">....</option>
                                                <option <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                    value="Monsieur">Monsieur</option>
                                                <option <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                    value="Madame">Madame</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Prénom</label>
                                            <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                                value="<?= $gerant ? $gerant->prenom : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nom</label>
                                            <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                value="<?= $gerant ? $gerant->nom : '' ?>">
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" name="emailGerant" ref="emailGerant"
                                                id="emailGerant" value="<?= $gerant ? $gerant->email : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Téléphone</label>
                                            <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                id="telGerant" value="<?= $gerant ? $gerant->tel : '' ?>">
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
                        </div>

                        <!-- Étape 1 : -->
                        <div class="step">
                            <div class="question-box ">
                                    <?php 
                                        $consignes = "<li>• Présentez-vous clairement et brièvement.</li>
                                                        <li>• Soulignez rapidement la spécialisation du cabinet et la couverture géographique
                                                        nationale afin de renforcer immédiatement la crédibilité.</li>
                                                        <li>• Adoptez toujours un ton professionnel, cordial et rassurant.</li>";
                                        $paragraph = '<p class="text-justify">
                                            Je me présente brièvement : je suis' . $connectedUser->fullName . ', conseiller commercial chez <b style="color: blue">HB Assurance</b>,
                                            <b style="color: blue">cabinet indépendant spécialisé dans les assurances pour les professionnels</b>. Nous intervenons
                                            sur <b style="color: blue">toute la France</b> pour accompagner les entreprises dans l’optimisation de leurs contrats
                                            d’assurance. 
                                            </p>';
                                                               
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                        </div>
                        

                        <!-- Etape 2 -->
                        <div class="step">
                            <div class="question-box">
                                <?php 
                                        $consignes = "<li>• Exprimez clairement et directement l’objectif principal de l’appel afin d’attirer
                                                        immédiatement l’attention du décideur.</li>
                                                        <li>• Insistez sur les bénéfices concrets et immédiats pour le prospect : réduction des coûts et
                                                        amélioration des garanties existantes.</li>
                                                        <li>• Restez attentif aux premières réactions pour mieux orienter la suite de la conversation.</li>";
                                        $paragraph = '<p class="text-justify">
                                            Je vous appelle aujourd’hui dans le cadre d’une campagne visant à <b style="color: green">l’optimisation des contrats
                                                d’assurance</b> des entreprises comme la vôtre. L’objectif est simple : vous permettre de réaliser
                                                une <b style="color: green">réduction significative des coûts</b> , tout en bénéficiant d’une <b style="color: green">amélioration des garanties</b>
                                                de vos contrats actuels.
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
                                    $consignes = "<li>• Vérifiez explicitement la disponibilité immédiate de votre interlocuteur avant de
                                                    poursuivre.</li>
                                                    <li>• Proposez immédiatement un rendez-vous si nécessaire, en restant flexible et
                                                    professionnel.</li>
                                                    <li>• Rassurez votre interlocuteur sur le respect de son temps.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                             Auriez-vous quelques minutes à m’accorder maintenant pour que je puisse vous présenter
                                            brièvement notre proposition, ou préférez-vous que nous convenions d’un rendez-vous
                                            téléphonique à un autre moment qui vous conviendrait mieux ?
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
                                        'label' => 'Disponible immédiatement'
                                    ],
                                    [
                                        'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                        'btn_class' => 'warning',
                                        'value' => 'rdv',
                                        'label' => 'Rendez-vous ultérieur'
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
                                    $consignes = "
                                    <li>• Vérifiez rapidement mais précisément l’activité réelle du prospect et sa localisation.</li>
                                    <li>• Restez concis, professionnel, et démontrez votre intérêt authentique pour mieux adapter
                                    votre proposition.</li>
                                    <li>• Rectifiez immédiatement toute information erronée pour garantir la pertinence de la suite
                                    de l’échange.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Afin de vous proposer une offre parfaitement adaptée, pourriez-vous simplement me confirmer
                                    que votre entreprise exerce bien dans le secteur <b style="color: blue">' . $company->industry . '</b>, et que votre zone
                                d’intervention principale est bien située sur <b style="color: blue">' . $company->region . '</b>?
                                        </p>';                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                                    <div class="form-group col-md-4">
                                        <label for="">Activité</label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="industry"
                                            value="<?= $company ? $company->industry : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Zone géographique</label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="region"
                                            value="<?= $company ? $company->region : ''; ?>">
                                    </div>
                                </div>

                            
                            <!-- <label class="form-title">Si vous êtes propriétaire ou locataire:</label> -->
                            <?php
                                // $name = 'habitation';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'proprietaire',
                                //         'label' => 'Proprietaire'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'locataire',
                                //         'label' => 'Locataire'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <!-- <label class="form-title">Si vous avez un emprunt immobilier en cours :</label> -->
                            <?php
                                // $name = 'emprunteur';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'emprunteur',
                                //         'label' => 'Emprunteur immobilier'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'non-emprunteur',
                                //         'label' => 'Non Emprunteur'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <!-- <label class="form-title">Votre statut professionnel :</label> -->
                            <?php
                                // $name = 'profession';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'salarie',
                                //         'label' => 'Salarié'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'warning',
                                //         'value' => 'independant',
                                //         'label' => 'Indépendant'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'retraite',
                                //         'label' => 'Retraité'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'info',
                                //         'value' => 'sans-activité',
                                //         'label' => 'Sans activité'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <!-- <label class="form-title">Si vous êtes célibataire, en couple ou en famille avec enfants ? :</label> -->
                            <?php
                                // $name = 'famille';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'celibataire',
                                //         'label' => 'Célibataire'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'warning',
                                //         'value' => 'en-couple',
                                //         'label' => 'En couple'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'famille',
                                //         'label' => 'Famille avec enfants'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        
                        </div>


                        <!-- Etape 5 :"Autre profil" -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Confirmez précisément si votre interlocuteur est le décideur final.</li>
                                                        <li>• Si ce n’est pas le cas, recueillez immédiatement les coordonnées exactes du décideur
                                                        réel.</li>
                                                        <li>• Fixez immédiatement un rappel précis pour optimiser votre suivi commercial ultérieur.</li>";
                                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Êtes-vous directement la personne décisionnaire concernant les assurances professionnelles
                                            au sein de votre entreprise, ou pourriez-vous m’indiquer les coordonnées précises du
                                            responsable concerné afin que je puisse lui présenter directement notre proposition ?
                                        </p>";                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <?php
                                $name = 'dispoResp';
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
                            <div class="response-options" id="sous-question-8"
                                    <?= $questScript && isset($questScript->prospectB2C) && $questScript->prospectB2C == 'non' ? "" : "hidden"; ?>>
                                    <div class="options-container col-md-11">
                                        <div class="col-md-12 mb-3">
                                    <!-- INFOS MAIL -->
                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Civilité</label>
                                            <select name="civiliteGerant" ref="civiliteGerant" id="" class="form-control">
                                                <option value="">....</option>
                                                <option <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                    value="Monsieur">Monsieur</option>
                                                <option <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                    value="Madame">Madame</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Prénom</label>
                                            <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                                value="<?= $gerant ? $gerant->prenom : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nom</label>
                                            <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                value="<?= $gerant ? $gerant->nom : '' ?>">
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" name="emailGerant" ref="emailGerant"
                                                id="emailGerant" value="<?= $gerant ? $gerant->email : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Téléphone</label>
                                            <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                id="telGerant" value="<?= $gerant ? $gerant->tel : '' ?>">
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
                        </div>
                        
                        
                        <!-- Etape 6 "proprétaire" : -->
                    <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Obtenez rapidement ces informations clés de façon fluide et professionnelle, sans donner
                                        l’impression d’interroger lourdement.</li>
                                        <li>• Notez précisément l’assureur actuel et l’échéance des contrats, qui seront utiles pour
                                        proposer des offres adaptées.</li>
                                        <li>• Évaluez clairement le niveau de satisfaction du prospect pour identifier des opportunités
                                        de changement d’assurance.</li>";
                                        $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de vous faire gagner du temps et vous présenter des solutions vraiment adaptées, pourriezvous m’indiquer rapidement quel est votre assureur actuel, la date approximative d’échéance de
                                        vos contrats, et votre niveau global de satisfaction concernant les garanties et tarifs en vigueur ?
                                        </p>';                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>Assureur Actuel </label>
                                <input type="text" class="form-control" name="assureur" value="<?=isset($questScript) ? $questScript->assureur : ''?>">
                                <label>Date échéance du contrat</label>
                                <input type="date" class="form-control" name="dateEcheanceContrat" value="<?=isset($questScript) ? $questScript->dateEcheanceContrat : ''?>">
                            </div>
                            <label>Niveau de satisfaction actuel</label>
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
                        
                        <!-- Etape 7 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Validez rapidement et précisément le besoin potentiel du prospect pour orienter
                                                        immédiatement votre argumentaire commercial.</li>
                                                        <li>• Ne pas hésiter à proposer d'autres typologies si le prospect évoque spontanément
                                                        d'autres besoins.</li>
                                                        <li>• Cette étape permet une orientation rapide vers la suite du script spécifique adaptée au
                                                        besoin identifié.</li>
                                                        ";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Très rapidement, pourriez-vous me préciser parmi les assurances suivantes celles pour
                                            lesquelles vous seriez intéressé par une optimisation ou un devis comparatif gratuit : Multirisque
                                            immeuble, Multirisque industriel, RC professionnelle, Flotte automobile, Santé collective ou
                                            éventuellement une autre assurance spécifique ?</p>";                            
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
                                        'value' => 'industriel',
                                        'label' => 'Multirisque Industriel'
                                    ],
                                    [
                                        'id' => 'assurance_san',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'sante',
                                        'label' => 'Santé collective / prévoyance salariés'
                                    ],
                                    [
                                        'id' => 'assurance_prev',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'rcPro',
                                        'label' => 'Responsabilité Civile Professionnelle (RC Pro)'
                                    
                                    ],
                                    [
                                        'id' => 'assurance_aut',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'auto',
                                        'label' => 'Assurance Flotte Automobile'
                                    ],
                                    [
                                        'id' => 'assurance_hab',
                                        'onclick' => "toggleOtherInsurance(this);",
                                        'btn_class' => '',
                                        'value' => 'immeuble',
                                        'label' => 'Multirisque Immeuble'
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
                        
                        
                        <!-- Etape 8 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Présentez très succinctement et clairement les produits proposés pour susciter
                                                    rapidement l’intérêt du prospect.</li>
                                                    <li>• Personnalisez légèrement votre présentation en insistant sur les assurances les plus
                                                    pertinentes par rapport aux réponses précédentes du prospect.</li>
                                                    <li>• Soyez clair et professionnel en valorisant immédiatement la diversité et l’expertise de HB
                                                    Assurance.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                             HB Assurance vous accompagne sur l’ensemble des assurances professionnelles essentielles,
                                                notamment : <br>
                                                • La Multirisque Immeuble destinée aux propriétaires d’immeubles professionnels et
                                                aux syndicats de copropriétés.<br>
                                                • La Multirisque Industrielle , idéale pour les industriels, ateliers et entrepôts.<br>
                                                • La Responsabilité Civile Professionnelle (RC Pro) , couvrant tous secteurs d’activité.<br>
                                                • Mais aussi d’autres assurances telles que les Flottes Automobiles ou encore la Santé
                                                    collective et prévoyance professionnelle .
                                        </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <!-- <label class="form-title">Satisfaction Tarifs :</label> -->
                            <?php
                                // $name = 'satisfactionTarifs';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'satisfait',
                                //         'label' => 'Satisfait'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'warning',
                                //         'value' => 'moyen',
                                //         'label' => 'Moyen'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'insatisfait',
                                //         'label' => 'Insatisfait'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                                            
                            <!-- <label class="form-title">Satisfaction Garanties :</label> -->
                            <?php
                                // $name = 'satisfactionGaranties';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'satisfait',
                                //         'label' => 'Satisfait'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'warning',
                                //         'value' => 'moyen',
                                //         'label' => 'Moyen'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'insatisfait',
                                //         'label' => 'Insatisfait'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            
                            <!-- <label class="form-title">Satisfaction Qualité Service :</label> -->
                            <?php
                                // $name = 'satisfactionService';
                                // $options = [
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'success',
                                //         'value' => 'satisfait',
                                //         'label' => 'Satisfait'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'warning',
                                //         'value' => 'moyen',
                                //         'label' => 'Moyen'
                                //     ],
                                //     [
                                //         'onclick' => "",
                                //         'btn_class' => 'danger',
                                //         'value' => 'insatisfait',
                                //         'label' => 'Insatisfait'
                                //     ]
                                // ];
                                // include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>

                        <!-- Etape 9 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>• Insistez clairement et succinctement sur les bénéfices immédiats et concrets pour le
                                                        prospect.</li>
                                                        <li>• Présentez les avantages en mettant en avant la valeur ajoutée d'un courtier indépendant
                                                        comme HB Assurance.</li>
                                                        <li>• Soyez attentif aux réactions positives du prospect pour renforcer ces points.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                                        Notre démarche chez HB Assurance repose sur plusieurs avantages concrets :<br>
                                                        • <b style='color: green'>Une expertise indépendante</b> nous permettant de comparer immédiatement les
                                                        meilleures offres du marché.<br>
                                                        • <b style='color: green'>Une optimisation de vos garanties et des économies immédiates</b> sur le coût de vos
                                                        primes d’assurance.<br>
                                                        • <b style='color: green'>Une réactivité exemplaire, un accompagnement totalement personnalisé et une
                                                        gestion simplifiée grâce à un interlocuteur unique dédié</b> .
                                                    </p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
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
                            $consignes = "<li>• Posez ces questions de façon concise et claire pour obtenir rapidement une bonne
                                            compréhension du risque à couvrir.</li>
                                            <li>• Restez attentif aux détails mentionnés par le prospect, car ils seront essentiels pour
                                            construire une offre adaptée.</li>
                                            <li>• Adaptez votre rythme en fonction de l’ouverture du prospect à donner ces informations
                                            précises.</li>
                                            ";
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de vous proposer une offre parfaitement adaptée en Multirisque Immeuble, pourriez-vous
                                            m’indiquer rapidement :<br>
                                            • La nature du bâtiment concerné (bureaux, commercial, mixte…) ?<br>
                                            • Le type d’occupation actuelle (locataires, copropriété, usage mixte…) ?<br>
                                            • Et enfin, les principales garanties de votre assurance actuelle, si vous les connaissez ?</p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                            <div class="form-group col-md-12">
                                <label>Nature du bâtiment (Bureaux / Commercial / Mixte / Autre) </label>
                                <input type="text" class="form-control" name="natureBatiment" value="<?=isset($questScript) ? $questScript->natureBatiment : ''?>">
                                <label>Type d’occupation (Locataires / Copropriété / Usage mixte / Autre)</label>
                                <input type="text" class="form-control" name="typeOccupation" value="<?=isset($questScript) ? $questScript->typeOccupation : ''?>">
                                <label>Assurances actuelles et principales garanties souscrites</label>
                                <input type="text" class="form-control" name="assuranceActuelle" value="<?=isset($questScript) ? $questScript->assuranceActuelle : ''?>">
                            </div>
                        </div>
                        
                        
                        <!-- Etape 13 : -->
                        <div class="step">
                            <?php
                            $consignes = "<li>• Insistez fortement sur les bénéfices financiers immédiats (économies) et la sécurité
                                            accrue grâce aux garanties complètes proposées.</li>
                                            <li>• Valorisez l’efficacité et la rapidité de l’assistance offerte par HB Assurance en cas de
                                            sinistre.</li>
                                            <li>• Soyez particulièrement attentif aux réactions positives pour adapter la suite de votre
                                            échange.</li>";
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            En souscrivant votre assurance Multirisque Immeuble chez HB Assurance, vous pouvez réaliser
                                            <b style='color: green'>des économies immédiates sur votre prime d’assurance </b>, tout en bénéficiant de <b style='color: green'>garanties
                                            étendues</b> couvrant notamment les incendies, les dégâts des eaux, et la responsabilité
                                            civile complète. De plus, nous assurons une <b style='color: green'>assistance rapide et efficace</b> en cas de sinistre,
                                            vous permettant ainsi de gérer sereinement tout imprévu. </p>";
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 14 : -->
                        <div class="step">
                            <?php
                                $consignes = "<li>• Proposez explicitement l’étape suivante, clairement définie, pour faciliter la décision
                                            immédiate du prospect.</li>
                                            <li>• Valorisez la gratuité, la rapidité et l’absence d’engagement de l’audit et de la comparaison.</li>
                                            <li>• Soyez attentif et réactif pour programmer immédiatement un rendez-vous si le prospect
                                            est intéressé.</li>";
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Pour vous permettre de juger concrètement de notre valeur ajoutée, je vous propose de réaliser
                                                dès maintenant un <b style='color: green'>audit entièrement gratuit de vos contrats actuels</b> , accompagné d’une
                                                <b style='color: green'>comparaison immédiate</b> des meilleures offres disponibles sur le marché. Souhaitez-vous
                                                que nous fixions ensemble dès à présent un <b style='color: green'>rendez-vous personnalisé</b> avec l’un de nos
                                                experts HB Assurance ?</p>";
                                include dirname(__FILE__) . '/blocs/questionContent.php';

                                $name = 'rdvOuEtudeGratuite';
                                $options = [
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Rendez-vous gestionnaire');",
                                        'btn_class' => 'success',
                                        'value' => 'Rendez-vous personnalisé',
                                        'label' => 'Rendez-vous personnalisé 🗓️',
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Étude gratuite');",
                                        'btn_class' => 'warning',
                                        'value' => 'Audit gratuit',
                                        'label' => 'Audit gratuit 📖',
                                    ],
                                    [
                                        'onclick' => "onClickRdvOuEtudeGratuite('Refus');",
                                        'btn_class' => 'danger',
                                        'value' => 'Refus',
                                        'label' => 'Refus',
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
                            $consignes = "<li>• Obtenez clairement et rapidement ces informations précises pour qualifier le besoin du
                            prospect.</li>
                            <li>• Soyez précis et concret dans vos questions pour démontrer votre professionnalisme et
                            votre efficacité.</li>
                            <li>• Prenez immédiatement note de ces informations pour orienter efficacement votre
                            proposition.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin de vous proposer une solution parfaitement adaptée, pourriez-vous me préciser rapidement
                                                :<br>
                                                • Le nombre de véhicules que vous possédez dans votre flotte automobile,<br>
                                                • Le nombre de salariés à assurer pour votre santé collective,<br>
                                                • Et enfin, s’il s’agit d’un dirigeant seul ou d’associés pour votre prévoyance professionnelle
                                                ? »
                                                </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            ?>
                            <label class="form-title mt-3">Nombre de véhicules pour flotte automobile</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->nombreVehicules : ''?>" type="number" class="form-control" name="nombreVehicules" placeholder="Nombre de véhicules pour flotte automobile">
                            </div>
                            <label class="form-title mt-3">Nombre de salariés concernés par la santé collective</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->nombreSalaries : ''?>" type="number" class="form-control" name="nombreSalaries" placeholder="Nombre de salariés concernés par la santé collective">
                            </div>
                            <label class="form-title mt-3"> Dirigeant seul ou associés pour prévoyance professionnelle </label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->dirigeant : ''?>" type="text" class="form-control" name="dirigeant" placeholder="Dirigeant seul ou associés pour prévoyance professionnelle ">
                            </div>
                        </div>

                        <!-- Etape 20 : -->
                        <div class="step">
                            <?php
                            // Main question component
                            $consignes = "<li>• Valorisez immédiatement les économies concrètes réalisables grâce à HB Assurance.</li>
                                        <li>• Mettez en avant l’adaptation précise des garanties aux besoins spécifiques du prospect.</li>
                                        <li>• Insistez sur l’aspect simplifié des démarches, un avantage très apprécié des
                                        professionnels.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Quelle que soit l’assurance professionnelle que vous recherchez, HB Assurance vous permet de
                                        réaliser des <b style='color: green;'>économies immédiates sur vos contrats professionnels</b> , tout en bénéficiant
                                        de <b style='color: green;'>garanties parfaitement optimisées selon vos besoins spécifiques</b> . De plus, nous assurons une <b style='color: green;'>simplicité maximale dans toutes vos démarches administratives</b> , vous
                                        permettant ainsi de rester pleinement concentré sur votre activité.
                                        </p>";
                            
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
                            $consignes = "<li>• Proposez explicitement et immédiatement la réalisation gratuite d’un devis personnalisé
                                            pour encourager une prise de décision rapide.</li>
                                            <li>• Insistez sur la possibilité d’un rendez-vous rapide avec un conseiller spécialisé afin de
                                            valoriser un accompagnement personnalisé.</li>
                                            <li>• Soyez réactif afin de fixer immédiatement un rendez-vous si le prospect montre un intérêt
                                            clair.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Afin que vous puissiez apprécier concrètement les bénéfices de notre démarche, je vous
                                            propose dès maintenant la réalisation d’un devis immédiat et totalement gratuit ainsi qu’un
                                            rendez-vous téléphonique ou physique avec l’un de nos conseillers spécialisés .
                                            Souhaitez-vous fixer dès à présent une date qui vous conviendrait ?</p>";
                                                                        
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
                            $consignes = "<li>• Obtenez rapidement et précisément les informations clés pour comprendre le risque
                                            industriel concerné.</li>
                                            <li>• Soyez précis sur les risques évoqués, en insistant sur leur importance pour offrir une
                                            proposition adaptée.</li>
                                            <li>• Adoptez une approche claire et professionnelle, montrant votre expertise du secteur
                                            industriel.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Pour vous proposer une couverture Multirisque Industrielle parfaitement adaptée, pourriez-vous
                                            m’indiquer précisément :<br>
                                            • Le type d’activité industrielle concernée (atelier, usine, stockage…) ?<br>
                                            • Les risques spécifiques actuellement couverts par vos contrats, tels que le bris de
                                            machines, l'incendie, l'interruption d'activité ou encore la responsabilité civile
                                            environnementale ?</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>

                            <label class="form-title mt-3">Activité industrielle précise (atelier, usine, stockage, autre)  :</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->activiteIndus : ''?>" type="text" class="form-control" name="activiteIndus" placeholder="Activité industrielle précise (atelier, usine, stockage, autre)">
                            </div>
                                        
                            <!-- Garanties principales -->
                            <label class="form-title mt-3">Risques actuellement couverts (bris de machines, incendie, interruption
                                d'activité, RC environnementale, autres) :</label>
                            <textarea class="form-control" name="risquesCouverts" rows="3" 
                                    placeholder="Risques actuellement couverts (bris de machines, incendie, interruption
                                d'activité, RC environnementale, autres) :">
                                <?=!empty($questScript->garantiesP) ? $questScript->risquesCouverts : ''?></textarea>
                        </div>
                        
                        <!-- Etape 23 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Insistez sur l’aspect personnalisé de la couverture et les économies réalisables grâce à
                                        l’expertise indépendante de HB Assurance.</li>
                                        <li>• Valorisez particulièrement le soutien en prévention des risques, facteur très important
                                        pour les industries.</li>
                                        <li>• Soulignez la simplicité et la réactivité exceptionnelle en gestion de sinistre pour rassurer
                                        le prospect.</li>
                                        ";
                                                                        
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Chez HB Assurance, nous construisons une <b style='color: green'>couverture multirisque industrielle totalement
                                            sur mesure</b> , spécifiquement adaptée à votre activité. Grâce à notre capacité à mettre en
                                            concurrence plusieurs assureurs, nous vous garantissons une <b style='color: green'>réduction significative de vos
                                            coûts</b> . Vous bénéficierez aussi d’un véritable <b style='color: green'>accompagnement en prévention des risques
                                            industriels</b> , ainsi que d’une <b style='color: green'>gestion rapide et simplifiée</b> en cas de sinistre, pour assurer
                                            la continuité sereine de votre activité.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 24 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "<li>• Présentez la prochaine étape avec assurance et clarté, en valorisant la gratuité, la rapidité
                                            et l’absence d’engagement.</li>
                                            <li>• Encouragez le prospect à profiter immédiatement de cette opportunité d’analyse gratuite
                                            par un expert industriel.</li>
                                            <li>• Soyez réactif afin d’organiser rapidement le rendez-vous si le prospect montre un intérêt
                                            immédiat.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Pour vous permettre de constater directement les avantages concrets de notre démarche, je
                                        vous propose un audit entièrement gratuit de votre couverture actuelle des risques
                                        industriels , accompagné d’une comparaison immédiate des meilleures offres
                                        disponibles sur le marché . Souhaitez-vous que nous organisions dès maintenant un rendezvous personnalisé avec l’un de nos experts spécialisés en risques industriels ?</p>";
                            
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
                            $consignes = "<li>• Respectez immédiatement le refus exprimé par le prospect sans aucune insistance.</li>
                                            <li>• Orientez professionnellement l’échange vers d’éventuelles recommandations indirectes
                                            d’autres entreprises intéressées par une RC Pro optimisée.</li>
                                            <li>• Maintenez une relation positive et professionnelle pour préserver les chances futures.</li>";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Je comprends parfaitement votre décision actuelle et vous remercie sincèrement du temps que
                                            vous m’avez accordé. Avant de conclure notre échange, pourriez-vous éventuellement me
                                            recommander d’autres entreprises ou contacts professionnels qui pourraient avoir intérêt à
                                            bénéficier d’une optimisation de leur Responsabilité Civile Professionnelle ? </p>";
                            
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
                        $consignes = "<li>• Obtenez rapidement des informations précises sur le métier du prospect afin de cerner
                                        précisément ses risques professionnels.</li>
                                        <li>• Insistez sur l’importance de bien comprendre leur activité afin de proposer une assurance
                                        parfaitement adaptée.</li>
                                        <li>• Soyez professionnel et clair, tout en étant à l’écoute active du prospect.</li>";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Pour vous fournir une offre de Responsabilité Civile Professionnelle parfaitement adaptée à
                                        votre métier, pourriez-vous m’indiquer :<br>
                                        • Votre secteur d’activité précis,<br>
                                        • Les risques particuliers que vous rencontrez dans le cadre de votre métier,<br>
                                        • Votre chiffre d’affaires approximatif annuel,<br>
                                        • Ainsi que le nombre d’employés de votre entreprise ?
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>     
                            <label class="form-title mt-3">Secteur d’activité précis</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->activiteRC : ''?>" type="text" class="form-control" name="activiteRC" placeholder="Secteur d’activité précis">
                            </div>
                            <label class="form-title mt-3">Risques particuliers liés au métier</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->risquesRC : ''?>" type="text" class="form-control" name="risquesRC" placeholder="Risques particuliers liés au métier ">
                            </div>
                            <label class="form-title mt-3">Chiffre d’affaires approximatif annuel</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->chiffreAnnuel : ''?>" type="number" class="form-control" name="chiffreAnnuel" placeholder="Chiffre d’affaires approximatif annuel">
                            </div>
                            <label class="form-title mt-3">Nombre d’employés</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->nombreEmpl : ''?>" type="number" class="form-control" name="nombreEmpl" placeholder="Nombre d’employés">
                            </div>
                        </div>
                        
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
                                        Notre offre en Responsabilité Civile Professionnelle se distingue par un <b style='color: green'>tarif particulièrement
                                        compétitif</b> , et surtout par une <b style='color: green'>couverture très précisément adaptée à votre activité
                                        professionnelle</b> . De plus, nous mettons l’accent sur une <b style='color: green'>simplification administrative
                                        maximale</b> , vous permettant ainsi de gagner du temps au quotidien, et nous vous assurons
                                        une <b style='color: green'>réactivité immédiate en cas de mise en cause juridique</b> , pour une parfaite sérénité
                                        dans l’exercice de votre activité. »</p>";
                        
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

    function showModalSendDoc() {

        getInfoMail();
        $('#modalEnvoiDoc').modal('show');
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
        console.log(currentStep)
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
        // else if (currentStep === 2) {
        //     const val = document.querySelector('input[name="siDisponible"]:checked');
        //     if (!val) {
        //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //         $('#errorOperation').modal('show');
        //         return;
        //     }
        //     if (val.value == "oui") {
        //         return showStep(4);
        //     } else {
        //         return showStep(3);
        //     }

        // }
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
                return showStep(30);
            } else {
                // Fin
                return showStep(30);
            }
        }
        // else if (currentStep === 4) {
        //     const habitationSelected = document.querySelector('input[name="habitation"]:checked');
        //     const emprunteurSelected = document.querySelector('input[name="emprunteur"]:checked');
        //     const professionSelected = document.querySelector('input[name="profession"]:checked');
        //     const familleSelected = document.querySelector('input[name="famille"]:checked');
        //     // Validation check
        //     if (!habitationSelected || !emprunteurSelected || !professionSelected || !familleSelected) {
        //         // Highlight missing selections
        //         if (!habitationSelected) {
        //             $("#msgError").text("Veuillez sélectionner votre statut d'habitation");
        //             $('#errorOperation').modal('show');
        //             return;
        //         }
        //         if (!emprunteurSelected) {
        //             $("#msgError").text("Veuillez sélectionner votre statut d'emprunteur");
        //             $('#errorOperation').modal('show');
        //             return
        //         }
        //         if (!professionSelected) {
        //             $("#msgError").text("Veuillez sélectionner votre situation professionnelle");
        //             $('#errorOperation').modal('show');  
        //             return      
        //         }
        //         if (!familleSelected) {
        //             $("#msgError").text("Veuillez sélectionner votre situation familiale");
        //             $('#errorOperation').modal('show');
        //             return      
        //         }
        //     } else {
        //         return showStep(7);
        //     }
    
        //     // if (! Proprietaire.checked  && ! Locataire.checked  && ! Autre.checked ) {
        //     //     $("#msgError").text("Veuillez sélectionner une réponse !");
        //     //     $('#errorOperation').modal('show');
        //     //     return;
        //     // }
        //     // if (Proprietaire.checked) {
        //     //     const val2 = document.querySelector('input[name="typeBienProprietaire"]:checked');
        //     //     if (!val2) {
        //     //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //     //         $('#errorOperation').modal('show');
        //     //         return;
        //     //     }
        //     //     else{
        //     //         return showStep(6);
        //     //     }
        //     // } 
        //     // if(Locataire.checked || Autre.checked) {
        //     //     const val2 = document.querySelector('input[name="siContacBailleur"]:checked');
        //     //     if (!val2) {
        //     //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //     //         $('#errorOperation').modal('show');
        //     //         return;
        //     //     }
        //     //     else{
        //     //         if(Autre.checked){
        //     //             return showStep(5);
        //     //         }
        //     //         else{
        //     //             return showStep(7);
        //     //         }
                    
        //     //     }
        //     // }
        // }
        // else if (currentStep === 5) {
        //     const val = document.querySelector('input[name="siEnvisagerProjetImmobilier"]:checked');
        //     const Proprietaire = document.getElementById('Proprietaire');
        //     const Locataire = document.getElementById('Locataire');
            
        //     if (!val) {
        //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //         $('#errorOperation').modal('show');
        //         return;
        //     }
        //     else if (val.value == "oui") {
        //         if(! Proprietaire.checked && ! Locataire.checked){
        //             return showStep(31);
        //         }
        //         else{
        //             return showStep(7);
        //         }
        //     } else {
        //         if(! Proprietaire.checked && ! Locataire.checked){
        //             return showStep(30);
        //         }
        //         else{
        //             return showStep(7);
        //         }
        //     }
        // }
        // else if (currentStep === 6) {
        //     const val = document.querySelector('input[name="correcteInfosProprietaire"]:checked');
        //     if (!val) {
        //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //         $('#errorOperation').modal('show');
        //         return;
        //     }
        //     else{
        //         return showStep(7);
        //     }
        // }
        else if (currentStep === 14) {
            const val = document.querySelector('input[name="rdvOuEtudeGratuite"]:checked');
            console.log(val.value)
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "Refus") {
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

        else if (currentStep === 18) {
            const val = document.querySelector('input[name="emailOuEtudeGratuite"]:checked');
            console.log(val.value)
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "Refus") {
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

        // else if (currentStep === 20) {
        //     const val = document.querySelector('input[name="typeRencontre"]:checked');
        //     if (!val) {
        //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //         $('#errorOperation').modal('show');
        //         return;
        //     }
        //     if (val.value == "non") {
        //         return showStep(21);
        //     } else {
        //         const Locataire = document.getElementById('Locataire');
        //         if(Locataire.checked){
        //             return showStep(28);
        //         }
        //         else{
        //             return showStep(33);
        //         }
        //     }
        // }

        else if (currentStep === 21) {
            return showStep(30);
        }

        else if (currentStep === 24) {
            const val = document.querySelector('input[name="siInteresse"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }

            if(val.value == 'non') {
                return showStep(15);
            } else {
                showStep(30)
            }
        }

        else if (currentStep === 27) {
            const val = document.querySelector('input[name="siEstimationRDV"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                return showStep(28);
            }else {
                showStep(30)
            }
        }

        else if (currentStep === 28) {
            const val = document.querySelector('input[name="demandeConnaissanceAutreProspect"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                return showStep(30);
            }else {
                showStep(30)
            }
        }
        
        else if (currentStep === 29) {
            return showStep(33);
        }
        
        else if (currentStep === 31) {
            return showStep(30);
        }

        else if (currentStep === 34) {
            const val = document.querySelector('input[name="siEstimationRDV"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "non") {
                return showStep(28);
            }else {
                showStep(30)
            }
        }

        else if(currentStep === 9) {
            console.log(interetAssurance)
            if(interetAssurance == "industriel") {showStep(22)}
            else if(interetAssurance == "immeuble") {showStep(12)}
            else if(interetAssurance == "rcPro") {showStep(29)}
            // else if(interetAssurance == "sante") {showStep(16)}
            // else if(interetAssurance == "auto") {showStep(25)}
            else{showStep(19)}
        }

        // else if (currentStep === 8) {
        //     // Get all radio groups
        //     const tarifsSelected = document.querySelector('input[name="satisfactionTarifs"]:checked');
        //     const garantiesSelected = document.querySelector('input[name="satisfactionGaranties"]:checked');
        //     const serviceSelected = document.querySelector('input[name="satisfactionService"]:checked');
        //     if (!tarifsSelected) {
        //         $("#msgError").text("Veuillez sélectionner votre satisfaction concernant les tarifs");
        //         $('#errorOperation').modal('show');
        //         return
        //     }
            
        //     if (!garantiesSelected) {
        //         $("#msgError").text("Veuillez sélectionner votre satisfaction concernant les garanties");
        //         $('#errorOperation').modal('show');
        //         return            
        //     }
        //     if (!serviceSelected) {
        //         $("#msgError").text("Veuillez sélectionner votre satisfaction concernant la qualité de service");
        //         $('#errorOperation').modal('show');
        //         return              
        //     }
        //     showStep(9)
        // }
        // else if (currentStep === 9) {
        //         // Get all checkboxes
        //         const checkboxes = [
        //             'assurance_emp',
        //             'assurance_san',
        //             'assurance_prev',
        //             'assurance_aut',
        //             'assurance_hab',
        //             'assurance_ani',
        //             'assurance_cyb',
        //             'assurance_autre'
        //         ].map(id => document.getElementById(id));
                
        //         // Check if at least one is selected
        //         const atLeastOneSelected = checkboxes.some(checkbox => checkbox.checked);
        //         // Check if "autre" is selected and has text
        //         const autreChecked = document.getElementById('assurance_autre').checked;
        //         const autreText = document.getElementById('autre_assurance_text').value.trim();
        //         const autreValid = !autreChecked || (autreChecked && autreText !== '');
                
        //         // Validate and show errors if needed
        //         if (!atLeastOneSelected) {
        //             $("#msgError").text("Veuillez sélectionner une assurance");
        //             $('#errorOperation').modal('show');
        //             return
        //         }
                
        //         if (!autreValid) {
        //             $("#msgError").text("Veuillez remplir le champ");
        //             $('#errorOperation').modal('show');
        //             return    
        //         }
        //         showStep(10)
        // }

            // const val = document.querySelector('input[name="siExistePartenaireRep"]:checked');
            // if (!val) {
            //     $("#msgError").text("Veuillez sélectionner une réponse !");
            //     $('#errorOperation').modal('show');
            //     return;
            // }
            // if (val.value == "oui") {
            //     return showStep(10);
            // } else {
            //     return showStep(25); //FIN
            // }

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
        }   else if (currentStep === 9) {
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
        formData.append('type', 'HbB2b');
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