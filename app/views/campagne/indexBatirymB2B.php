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

<style>
  .surface-calculator {
    font-family: 'Arial', sans-serif;
    max-width: 500px;
    margin: 20px auto;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  
  .surface-calculator h3 {
    color: #2c3e50;
    margin-top: 0;
    text-align: center;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #34495e;
  }
  
  .form-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
  }
  
  .action-btn {
    width: 100%;
    padding: 12px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
  }
  
  .action-btn:hover {
    background-color: #2980b9;
  }
  
  .resultats-container {
    margin-top: 25px;
    padding: 20px;
    background: white;
    border-radius: 8px;
    border-left: 4px solid #3498db;
  }
  
  .resultat-item {
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
  }
  
  .resultat-label {
    font-weight: 500;
  }
  
  .resultat-valeur {
    font-weight: bold;
    color: #3498db;
  }
  
  .inspiration-section {
    margin-top: 25px;
    padding-top: 15px;
    border-top: 1px dashed #ddd;
    text-align: center;
  }
  
  .inspiration-btn {
    background-color: #2ecc71;
  }
  
  .inspiration-btn:hover {
    background-color: #27ae60;
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
// include_once dirname(__FILE__) . '/../crm/blocs/boitesModal.php';
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


    <div class=" col-12">
        <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12">

            <div style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px;     background-color: #fff; text-align: center;">
                    <h2><span><i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i></span> Campagne production B2B Batirym - 
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
                                    $consignes = "<li>Parlez debout si possible, gardez le sourire dans la voix et une énergie naturelle. Ce sont les
                                                10 premières secondes qui décident de la suite.</li>
                                                <li>N’entamez jamais un appel par : « Je ne vous dérange pas ? » ou « Est-ce que vous avez un moment
                                                ? » → cela affaiblit votre posture et réduit le taux d’engagement.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                                <p class="text-justify">
                                                Bonjour Monsieur/Madame <b style="color: blue">' . $gerant->prenom . ' ' . $gerant->nom . '</b>, ici ' . $connectedUser->fullName . ' à l’appareil, je vous appelle de la société
                                                BATIRYM, spécialisée en rénovation professionnelle tous corps d’État en Île-de-France.
                                                Nous avons récemment aidé plusieurs ' . $company->industry  .' à moderniser
                                                leurs locaux pour booster leur activité.
                                                Est-ce que je peux vous prendre 2 minutes pour voir si cela peut aussi vous intéresser ?
                                                </p>';
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <!-- Etape 1 -->
                            <?php
                                $name = 'siRefus';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>
                        <!-- Etape 2  -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "<li>Ne forcez jamais un interlocuteur non qualifié. Votre objectif ici est d’obtenir le bon contact,
                                                    pas de convaincre à tout prix.</li>
                                                    <li>Montrez du respect et de la souplesse, cela vous donne plus de chances d’obtenir un nom ou
                                                    une mise en relation.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                                <p class="text-justify">
                                                Est-ce bien vous qui vous occupez des éventuels travaux ou rénovations dans vos locaux ?
                                                Ou devrais-je plutôt parler à un responsable, associé ou gestionnaire ?
                                                </p>';
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <?php
                                $name = 'prospectB2B';
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

                        <!-- Étape 3 : -->
                        <div class="step">
                            <div class="question-box ">
                                    <?php 
                                        $consignes = "<li>Votre ton doit transmettre sérénité, fiabilité et fierté. Ne parlez pas “comme un vendeur” mais
                                                    comme un expert bienveillant.</li>
                                                    <li>Adoptez une posture de conseil, et non de sollicitation.</li>";
                                        $paragraph = '<p class="text-justify">
                                            BATIRYM est une entreprise de rénovation tous corps d’État créée en 2011, qui accompagne les
                                            professionnels de tous secteurs dans leurs projets d’aménagement, de réhabilitation ou de mise
                                            en conformité.
                                            Nous intervenons exclusivement en Île-de-France, avec une équipe complète capable de gérer
                                            un chantier de A à Z – étude, devis, coordination, exécution et finitions. » 
                                            </p>';
                                                               
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                        </div>
                        

                        <!-- Etape 2 -->
                        <div class="step">
                            <div class="question-box">
                                    <?php 
                                        $consignes = "<li>Obtenir un “oui” ici, même tacite, augmente l’attention du prospect. C’est un microengagement psychologique puissant.</li>
                                                    <li>Ne poursuivez jamais automatiquement si vous sentez que la personne est pressée, stressée
                                                    ou agacée.</li>
                                                    <li>Mais ne demandez pas l’autorisation de parler en termes faibles : évitez « Je vous dérange ? »,
                                                    qui pousse naturellement au « Oui » de rejet.</li>";
                                        $paragraph = '<p class="text-justify">
                                            Est-ce que je peux vous prendre 2 petites minutes pour vous expliquer ce que nous faisons, et
                                            voir si cela pourrait vous être utile ?
                                        </p>';                 
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                    ?>
                            </div>
                            <?php
                                $name = 'siUtile';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                        </div>

                        <!-- 5. Gestion des objections courantes -->
                        <!-- 5.2.1. Objection : « Je n’ai pas le temps / Je ne suis pas intéressé » -->
                        <!-- Etape 3 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "<li>• Posez une question à la fois, puis laissez le silence. C’est souvent dans le silence que
                                                le prospect s’ouvre.</li>
                                                <li>• Si la personne répond « Non, rien de prévu », relancez avec une question douce :
                                                « Et si vous deviez changer une chose dans vos locaux, ce serait quoi en premier ? »</li>
                                                <li>• N’interprétez pas trop vite les signaux faibles : écoutez avec attention et prenez des
                                                notes.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Dites-moi, est-ce que vous avez récemment envisagé de faire des travaux dans vos locaux ?
                                            Que ce soit pour améliorer l’agencement, la mise aux normes, ou même pour rénover ? 
                                        </p>';                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>

                            <?php
                                $name = 'siTravaux';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Oui'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'non',
                                        'label' => 'Non'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>

                            <label>Depuis combien de temps occupez-vous ce local ? » (permet de détecter l’ancienneté et l’obsolescence possible)</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->dureeOccup : ''?>" type="number" class="form-control" name="dureeOccup" placeholder="Durée d'occupation du local">
                            </div>
                            <label>Si vous deviez améliorer un aspect de votre établissement, lequel vous semblerait prioritaire ? (L’accueil client ? L’ambiance ? L’espace de travail ? Le confort thermique ?)</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->amelioreLocal : ''?>" type="text" class="form-control" name="amelioreLocal" placeholder="Aspect du local à ameliorer">
                            </div>
                            <label> Est-ce que vous avez déjà eu des remarques de clients, de collaborateurs ou du syndic concernant l’état des lieux ou un besoin de mise en conformité ?</label>
                            <div class="input-group">
                                <input value="<?=isset($questScript) ? $questScript->remarquesClient : ''?>" type="text" class="form-control" name="remarquesClient" placeholder="Remarque des clients">
                            </div>
                        </div>

                        <!-- Etape 4 : origine -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                    $consignes = "<li>• Cette séquence doit paraître naturelle, jamais inquisitrice. On pose des questions par
                                                intérêt, pas par formalité.</li>
                                                <li>• La formulation neutre est essentielle : évite « C’est vous qui payez ? », préfère « C’est vous
                                                qui pilotez ce type de projet ? »</li>
                                                <li>• Écouter les mots-clés comme : « syndic », « mon bailleur », « c’est géré par le siège », « je
                                                suis associé » → autant d’indices pour classer correctement.</li>
                                                <li>• Ne pas insister si la personne ne veut pas répondre à une des questions. Passer à la suite
                                                avec souplesse.</li>";
                                    $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Pour bien orienter notre échange, puis-je vous demander rapidement le type d’activité que vous exercez ici ?
                                        </p>';                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                                    <?php
                                        $name = 'industry';
                                        $options = [
                                            [
                                                'onclick' => "setActivite(this);",
                                                'btn_class' => 'success',
                                                'value' => 'commerce',
                                                'label' => 'Commerce'
                                            ],
                                            [
                                                'onclick' => "setActivite(this);",
                                                'btn_class' => 'warning',
                                                'value' => 'restauration',
                                                'label' => 'Restauration'
                                            ],
                                            [
                                                'onclick' => "setActivite(this);",
                                                'btn_class' => 'danger',
                                                'value' => 'profession liberale',
                                                'label' => 'Profession libérale'
                                            ],
                                            [
                                                'onclick' => "setActivite(this);",
                                                'btn_class' => 'info',
                                                'value' => 'immobilier',
                                                'label' => 'Immobilier'
                                            ],
                                            [
                                                'onclick' => "setActivite(this);",
                                                'btn_class' => 'secondary',
                                                'value' => 'autres',
                                                'label' => 'Autres'
                                            ]
                                        ];
                                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                                    ?>

                                    <label>Et ce local, c’est un établissement ouvert au public ou un espace de travail uniquement interne ?</label>
                                    <?php
                                        $name = 'typeLocal';
                                        $options = [
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'success',
                                                'value' => 'ERP',
                                                'label' => 'ERP'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'warning',
                                                'value' => 'bureaux',
                                                'label' => 'Bureaux'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'danger',
                                                'value' => 'boutique',
                                                'label' => 'Boutique'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'info',
                                                'value' => 'atelier',
                                                'label' => 'Atelier'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'secondary',
                                                'value' => 'immeuble résidentiel',
                                                'label' => 'Immeuble résidentiel'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'primary',
                                                'value' => 'parties communes',
                                                'label' => 'Parties communes'
                                            ]
                                        ];
                                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                                    ?>

                                    <label>Vous êtes propriétaire, locataire ou gestionnaire pour le compte d’un tiers ?</label>
                                    <?php
                                        $name = 'statutProspect';
                                        $options = [
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'success',
                                                'value' => 'proprietaire',
                                                'label' => 'Proprietaire'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'warning',
                                                'value' => 'locataire',
                                                'label' => 'Locataire'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'danger',
                                                'value' => 'gestionnaire',
                                                'label' => 'gestionnaire'
                                            ]
                                        ];
                                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                                    ?>

                                    <label>Est-ce que vous êtes seul décisionnaire pour ce type de projet ou vous partagez cela avec d’autres personnes</label>
                                    <?php
                                        $name = 'roleDecisionnaire ';
                                        $options = [
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'success',
                                                'value' => 'decideur direct',
                                                'label' => 'Decideur direct'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'warning',
                                                'value' => 'intermédiaire',
                                                'label' => 'Intermédiaire'
                                            ],
                                            [
                                                'onclick' => "",
                                                'btn_class' => 'danger',
                                                'value' => 'autre',
                                                'label' => 'Autre'
                                            ]
                                        ];
                                        include dirname(__FILE__) . '/blocs/responseOptions.php';
                                    ?>
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
                                        $consignes = "<li>• Présentez BATIRYM comme une solution, pas comme un prestataire parmi d’autres.</li>
                                                    <li>• Ne listez pas les services comme une brochure : racontez une histoire concrète, par ex.
                                                    :« On a récemment aidé un opticien à Paris 14e à moderniser sa boutique. En 3 semaines, c’était
                                                    refait, sans perdre un jour d’ouverture. »</li>
                                                    <li>• Regardez les notes prises en 2.1 et 2.2 : alignez votre argumentaire sur les mots utilisés
                                                    par le prospect (ex. : s’il parle de bruit ou d’humidité, rebondir sur les traitements
                                                    possibles).</li>
";
                                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            BATIRYM, c’est plus de 14 ans d’expérience en rénovation tous corps d’État pour les
                                            professionnels : commerçants, restaurateurs, professions libérales, syndics…
                                            On intervient exclusivement en Île-de-France, avec nos propres équipes ou partenaires
                                            référencés, sur des travaux qui vont du simple réagencement à la rénovation complète.Notre force, c’est de piloter le chantier de A à Z avec un interlocuteur unique, dans le respect
                                            du budget, des délais et des normes.</p>";                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                            <label id="commerceText">Nous avons aidé plusieurs boutiques à moderniser leur espace de vente, à optimiser leur
                            agencement ou à **remettre leur local aux normes PMR ou sécurité incendie.</label>
                            <label id="restaurationText">Nos clients dans la restauration apprécient qu’on sache intervenir rapidement, en évitant les
                            interruptions d’activité, notamment sur les cuisines, salles, et installations techniques.</label>
                            <label id="liberaleText">Beaucoup de nos clients professionnels libéraux nous contactent pour réorganiser leurs
                            bureau id="Text"x ou valoriser l’image de leur cabinet, tout en restant ouverts pendant les travaux. </label>
                            <label id="immobilierText">Nous sommes souvent sollicités pour des chantiers de copropriété ou d’immeubles tertiaires :
                            ravalements, isolation thermique, réfection de cages d’escalier, mise en conformité des
                            installations.</label>

                            <div class="question-box mt-5">
                                <div class="question-content">
                                    <div class="question-text">
                                        <p class="text-justify" style="background-color: #e8f5e8; padding: 15px; border: 2px solid green;">
                                            <strong>🏗 Argumentaire BATIRYM :</strong><br>
                                            <b style="color: #003366;">BATIRYM, c'est plus de 14 ans d'expérience</b> en rénovation tous corps d'État pour les professionnels : commerçants, restaurateurs, professions libérales, syndics…
                                        </p>
                                        <p class="text-justify" style="background-color: #e8f5e8; padding: 15px; border: 2px solid green;">
                                            On intervient exclusivement en <b style="color: green;">🗺 Île-de-France</b>, avec nos propres équipes ou partenaires référencés, sur des travaux qui vont du simple réagencement à la rénovation complète.
                                        </p>
                                        <p class="text-justify" style="background-color: #e8f5e8; padding: 15px; border: 2px solid green;">
                                            Notre force, c'est de <b style="color: green;">🎯 piloter le chantier de A à Z</b> avec un <b style="color: green;">👤 interlocuteur unique</b>, dans le respect du budget, des délais et des normes.
                                        </p>
                                    </div>
                                </div>
                            </div>
                    </div>
                        
                        
                        <!-- Etape 6 "proprétaire" : -->
                    <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>Utilisez l’ancienneté de BATIRYM comme levier de crédibilité. Si le prospect hésite sur notre
                                                    fiabilité ou compétence :
                                                    « Nous existons depuis 2011 – ce n’est pas un hasard. C’est la constance de notre travail bien fait
                                                    qui nous permet d’être encore là aujourd’hui. »</li>";
                                        $paragraph = '<strong>Question <span name="numQuestionScript"></span> :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                        BATIRYM a été fondée en <b style="color:blue">2011</b>, cela fait plus de <b style="color:blue">14 ans</b> que nous réalisons des chantiers de
                                        rénovation tous corps d’État pour les professionnels.
                                        Cela veut dire qu’on maîtrise l’ensemble des métiers : gros œuvre, second œuvre, finition,
                                        énergie, agencement, conformité… et qu’on est capable de piloter un projet de A à Z.</p>';                            
                                        include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                        </div>
                        
                        <!-- Etape 7 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>Insistez sur la notion de simplicité et gain de temps.
                                                    « C’est souvent ce que nos clients redoutent le plus dans les travaux : devoir tout gérer euxmêmes. Nous, on fluidifie tout ça. »</li>
                                                    <li>• Bien faire comprendre la différence entre BATIRYM et une plateforme. Ici, c’est
                                                    l’entreprise qui porte le chantier, pas un agrégateur de devis.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            L’un des points les plus appréciés par nos clients, c’est qu’ils ont <b style='color:green'>un seul interlocuteur</b> dédié
                                            du début à la fin du chantier.
                                            Ils n’ont pas à courir après plusieurs artisans, à gérer des devis séparés, ou à faire la coordination
                                            : on s’en occupe. »</p>";                            
                                    include dirname(__FILE__) . '/blocs/questionContent.php';
                                ?>
                            </div>
                        </div>
                        
                        
                        <!-- Etape 8 : -->
                        <div class="step">
                            <div class="question-box ">
                                <?php 
                                        $consignes = "<li>La preuve sociale est un levier de confiance.
                                        « Si quelqu’un d’autre comme vous nous a fait confiance… pourquoi pas vous ? »</li>
                                        <li>• Préparer 3 storytelling chantiers pour chaque segment (commerce, restauration,
                                        bureau, syndic), avec avant/après.</li>
                                        <li>• Ne jamais mentir ou exagérer : les exemples doivent être réels, vérifiables si le prospect
                                        le demande.</li>";
                                        $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                                    Nos équipes interviennent avec des délais respectés, des travaux assurés en décennale, et
                                                    des réalisations conformes aux normes en vigueur.
                                                    Nous ne lançons aucun chantier sans un cadre clair, avec planning, devis validé, et conditions
                                                    garanties.<br>
                                                    o Délais tenus
                                                    o Assurance décennale
                                                    o Normes et conformité
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
                                $consignes = "<li>• Préparer 3 storytelling chantiers pour chaque segment (commerce, restauration,
                                            bureau, syndic), avec avant/après.</li>
                                            <li>• Ne jamais mentir ou exagérer : les exemples doivent être réels, vérifiables si le prospect
                                            le demande.</li>";
                                $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                            <p class='text-justify' id='textConfirmPriseEnCharge'>
                                                Nous avons accompagné plusieurs commerces et établissements professionnels dans leur
                                                rénovation : boutiques, cabinets, halls d’immeubles, restaurants…
                                                Si vous le souhaitez, je peux vous envoyer quelques exemples de chantiers récents avec photos
                                                avant/après. </p>";
                                include dirname(__FILE__) . '/blocs/questionContent.php';
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
                            $consignes = "<li>Si le prospect est basé hors IDF :
                                            « Je vous remercie, mais nous ne couvrons que l’Île-de-France. Si vous avez un site ici à gérer un
                                            jour, on sera ravis d’intervenir. »
                                            </li>";
                            
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                            BATIRYM est une entreprise régionale, ancrée en Île-de-France.
                                            On ne travaille que sur ce territoire, ce qui nous permet de garantir réactivité, connaissance du
                                            tissu local et présence rapide sur site.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            
                            ?>
                            <div class="intervention-box">
                                <h3>Départements couverts :</h3>
                                <ul class="location-list">
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Paris (75)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Seine-et-Marne (77)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Yvelines (78)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Essonne (91)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Hauts-de-Seine (92)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Seine-Saint-Denis (93)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Val-de-Marne (94)
                                    </li>
                                    <li>
                                        <svg class="location-icon" width="16" height="16" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9C5 14.25 12 22 12 22C12 22 19 14.25 19 9C19 5.13 15.87 2 12 2Z"/>
                                        </svg>
                                        Val-d'Oise (95)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Etape 19 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "Ces besoins ne sont pas toujours exprimés comme des “travaux”. Écoutez les phrases comme
                                            :
                                            « C’est trop sombre chez moi » → Parlez lumière et ambiance
                                            « Les clients tournent en rond » → Parlez fluidité du parcours
                                            « J’ai plus de passage qu’avant, mais ça rentre pas » → Parlez attirance vitrine / agencement";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Dans votre activité, les besoins de travaux sont souvent liés à l’évolution du point de vente :
                                            Refaire la vitrine pour attirer le regard, réagencer l’intérieur pour mieux mettre en avant vos
                                            produits, ou encore remettre le local aux normes d’accessibilité PMR.
                                            On intervient aussi pour améliorer l’éclairage, la circulation client, ou créer une zone de
                                            confidentialité. »
                                        </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            ?>
                            <div class="checkbox-container">
                            <div class="checkbox-item">
                                <input name="vitrine" value="vitrine" type="checkbox" id="vitrine" class="service-checkbox">
                                <label for="vitrine">Réfection ou modernisation de la vitrine / devanture commerciale</label>
                            </div>
                            
                            <div class="checkbox-item">
                                <input name="renovation" value="renovation" type="checkbox" id="renovation" class="service-checkbox">
                                <label for="renovation">Rénovation intérieure : sol, peinture, éclairage, mobilier intégré</label>
                            </div>
                            
                            <div class="checkbox-item">
                                <input name="pmr" value="pmr" type="checkbox" id="pmr" class="service-checkbox">
                                <label for="pmr">Mise en conformité accessibilité PMR</label>
                            </div>
                            
                            <div class="checkbox-item">
                                <input name="incendie" value="incendie" type="checkbox" id="incendie" class="service-checkbox">
                                <label for="incendie">Mise aux normes sécurité incendie, sortie de secours</label>
                            </div>
                            
                            <div class="checkbox-item">
                                <input name="acoustique" value="acoustique" type="checkbox" id="acoustique" class="service-checkbox">
                                <label for="acoustique">Traitement acoustique / thermique</label>
                            </div>
                            
                            <div class="checkbox-item">
                                <input name="optimisation" value="optimisation" type="checkbox" id="optimisation" class="service-checkbox">
                                <label for="optimisation">Optimisation de l'espace de vente ou du comptoir</label>
                            </div>
                            
                            <button id="submit-btn" style="display: none; margin-top: 15px; padding: 10px 20px; background: #0066cc; color: white; border: none; border-radius: 4px;">
                                Prise de RDV
                            </button>
                            </div>
                        </div>
                        

                        <!-- Etape 20 : -->
                        <div class="step">
                            <?php
                            // Main question component
                            $consignes = "Préparez votre propre punchline, celle que vous sentez naturelle pour vous. Elle doit être
                                        visuelle, imagée, inspirante.
                                        Évitez le jargon technique, parlez le langage du terrain : chiffre d’affaires, confort, image,
                                        fréquentation";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Une boutique bien pensée, agréable à visiter, claire et professionnelle augmente la
                                        fréquentation, la satisfaction client et la vente. Ce n’est pas qu’une question de peinture ou de carrelage, c’est une stratégie commerciale à part
                                        entière.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>

                            <div class="prospect-objectives">
                            <p>Sélectionnez jusqu'à 2 objectifs principaux</p>
                            
                            <div class="objective-options">
                                <div class="objective-option">
                                <input name="traffic" value="traffic" type="checkbox" id="traffic" class="objective-checkbox">
                                <label for="traffic">
                                    <span class="objective-icon">🚀</span>
                                    <span class="objective-text">Booster trafic</span>
                                </label>
                                </div>
                                
                                <div class="objective-option">
                                <input name="image" value="image" type="checkbox" id="image" class="objective-checkbox">
                                <label for="image">
                                    <span class="objective-icon">✨</span>
                                    <span class="objective-text">Améliorer image</span>
                                </label>
                                </div>
                                
                                <div class="objective-option">
                                <input name="CA" value="CA" type="checkbox" id="revenue" class="objective-checkbox">
                                <label for="revenue">
                                    <span class="objective-icon">💰</span>
                                    <span class="objective-text">Augmenter CA</span>
                                </label>
                                </div>
                                
                                <div class="objective-option">
                                <input name="moderniser" value="moderniser" type="checkbox" id="modernize" class="objective-checkbox">
                                <label for="modernize">
                                    <span class="objective-icon">🏗️</span>
                                    <span class="objective-text">Moderniser</span>
                                </label>
                                </div>
                                
                                <div class="objective-option">
                                <input name="normes" value="normes" type="checkbox" id="compliance" class="objective-checkbox">
                                <label for="compliance">
                                    <span class="objective-icon">🛡️</span>
                                    <span class="objective-text">Mettre aux normes</span>
                                </label>
                                </div>
                            </div>
                            
                            <div class="selection-counter">
                                Sélections: <span id="selected-count">0</span>/2
                            </div>
                            
                            <div id="custom-message" class="custom-message" style="display: none;"></div>
                            </div>
                        </div>


                        <!-- Etape 21 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "Montrez que BATIRYM comprend la réalité des contrôles sanitaires.
                                        « On sait que la moindre non-conformité peut entraîner une fermeture ou une amende. On ne
                                        prend aucun risque. »
                                        ";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            Pour les restaurateurs et métiers de bouche, nous intervenons souvent sur la mise aux normes
                                            des cuisines professionnelles, la création de circuits hygiène, ou encore la ventilation
                                            réglementaire.
                                            Que ce soit pour une ouverture, un contrôle sanitaire ou une modernisation, on vous accompagne
                                            avec des artisans qualifiés et une vraie connaissance des contraintes métier. »</p>";
                                                                        
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            $name = 'siInteresse';
                            $options = [
                                [
                                    'onclick' => "onClickSiRDVMefianceInconnu('oui');",
                                    'btn_class' => 'success',
                                    'value' => 'oui',
                                    'label' => 'Demander RDV technique + plan des lieux si disponible',
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
                            $consignes = "Utilisez le vocabulaire émotionnel du client final : confort, calme, lumière, chaleur, ambiance.
                                            « Vous servez une excellente cuisine, notre travail c’est que ça se voie dès l’entrée. »
                                            ";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            L’ambiance, le confort et l’image de votre établissement sont aussi importants que ce qu’il y a
                                            dans l’assiette.
                                            Une salle rénovée, chaleureuse, bien éclairée et bien agencée peut augmenter votre taux de
                                            remplissage de manière significative.
                                            Nous vous aidons à créer un espace où vos clients auront envie de revenir.<br>
                                            Phrases adaptables selon l’établissement :<br>
                                            • Café :<br>
                                            « L’ambiance du matin, c’est ce qui fidélise les habitués. On peut créer une vraie atmosphère,
                                            sans trop de budget. »<br>
                                            • Restaurant :<br>
                                            « Une salle bruyante ou sombre fait perdre des clients, même si la cuisine est bonne. Nous
                                            rééquilibrons tout ça. »<br>
                                            • Hôtel :<br>
                                            « De la réception aux couloirs, chaque détail compte dans l’expérience client. Un
                                            rafraîchissement ciblé fait souvent toute la différence. »<br>
                                            </p>";
                            
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
                                            L’une de nos grandes forces, c’est de savoir intervenir sans fermer l’établissement.
                                            Nous planifions les chantiers en période creuse, de nuit, ou par zones pour que vous puissiez
                                            continuer à accueillir vos clients.<br>
                                            • Service continu :<br>
                                            « On segmente le chantier. Salle le lundi, sanitaires le mardi, etc. Sans bloquer l’exploitation. »
                                            • Petite structure :<br>
                                            « On intervient entre 23h et 6h s’il le faut. Nos artisans sont habitués à ces contraintes. »<br>
                                            • Travaux en deux phases :<br>
                                            « On commence par la salle, puis après validation, on attaque la cuisine. Cela permet de garder
                                            le contrôle. »<br></p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
                        </div>
                        
                        <!-- Etape 24 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "Ce public est sensible à l’élégance, la discrétion, la rigueur.
                                        Adoptez un ton professionnel, posé, expert, en évitant tout vocabulaire trop “chantier” au
                                        premier abord.
                                        Insistez sur l’idée de confort et crédibilité : « Un client ne confie pas ses intérêts à quelqu’un
                                        installé dans des locaux vétustes. »";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Vos locaux, c’est la première impression que vos clients ou patients retiennent.
                                        Un bureau moderne, lumineux, bien pensé, c’est plus de sérénité pour vous, et plus de
                                        confiance pour ceux qui vous consultent.
                                        BATIRYM vous accompagne pour créer un espace à la hauteur de votre expertise.<br>
                                        • Cabinet médical / paramédical :<br>
                                        « Une salle d’attente agréable et un cabinet bien agencé, c’est souvent ce qui fait la différence
                                        dans l’expérience patient. »<br>
                                        • Bureau de conseil / notariat / avocat :<br>
                                        « Votre bureau reflète votre niveau d’exigence. On vous aide à le rendre plus fluide, plus
                                        représentatif, plus conforme à votre image. »<br>
                                        • Agence / activité tertiaire :<br>
                                        « L’ambiance et l’ergonomie influencent directement la productivité de vos équipes. On optimise
                                        votre surface et votre confort. »
                                        </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            ?>
                            <div class="surface-calculator">
                            <h3>Calculateur de gain de surface</h3>
                            
                            <div class="calculator-form">
                                <div class="form-group">
                                <label for="surface-actuelle">Surface actuelle (m²):</label>
                                <input name="surface" type="number" id="surface-actuelle" min="10" step="1" class="form-input">
                                </div>
                                
                                <div class="form-group">
                                <label for="type-commerce">Type de commerce:</label>
                                <select name="typeCommerce" id="type-commerce" class="form-input">
                                    <option value="boutique">Boutique de vêtements</option>
                                    <option value="restaurant">Restaurant/Café</option>
                                    <option value="salon">Salon de coiffure/esthétique</option>
                                    <option value="autre">Autre type de commerce</option>
                                </select>
                                </div>
                                
                                <div class="form-group">
                                <label for="mobilier-actuel">État actuel du mobilier:</label>
                                <select name="mobilierActuel" id="mobilier-actuel" class="form-input">
                                    <option value="ancien">Ancien (plus de 5 ans)</option>
                                    <option value="moyen">Moyen (3-5 ans)</option>
                                    <option value="recent">Récent (moins de 3 ans)</option>
                                </select>
                                </div>
                                
                                <button id="calculer-btn" class="action-btn">Calculer le gain potentiel</button>
                            </div>
                            
                            <div id="resultats" class="resultats-container" style="display: none;">
                                <h4>Résultats estimés</h4>
                                <div class="resultat-item">
                                <span class="resultat-label">Gain de surface estimé:</span>
                                <span id="gain-surface" class="resultat-valeur">0</span> m²
                                </div>
                                <div class="resultat-item">
                                <span class="resultat-label">Soit une augmentation de:</span>
                                <span id="pourcentage-gain" class="resultat-valeur">0</span>%
                                </div>
                                
                                <div class="inspiration-section">
                                <p>Recevez notre fiche inspiration avec des solutions adaptées à votre commerce:</p>
                                <button id="inspiration-btn" class="action-btn inspiration-btn">
                                    Envoi fiche inspiration design pro
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                        <!-- Etape 25 : -->
                        <div class="step">
                            <?php
                            // Question content component (unchanged)
                            $consignes = "Parlez de valeur d’actif même pour un cabinet modeste.
                                        « Chaque amélioration augmente la valeur de votre cabinet – pour vos clients comme pour un
                                        jour, un repreneur. »";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Votre cabinet ou votre siège, c’est aussi un patrimoine professionnel.
                                        Le valoriser, c’est renforcer votre positionnement, inspirer confiance à vos partenaires et
                                        préserver sa valeur à long terme.
                                        Nous travaillons avec de nombreux cabinets pour moderniser leurs installations sans interrompre
                                        leur activité. »<br>
                                        • Cabinet libéral indépendant :<br>
                                        « Vous avez investi dans ces murs. On vous aide à les mettre au niveau de votre image. »<br>
                                        • Cabinet locataire :<br>
                                        « Même en location, l’aménagement vous appartient. Vous vivez dedans. Et vos clients aussi. »<br>
                                        • Bureau partagé ou coworking :<br>
                                        « Optimiser les postes, rendre les espaces plus collaboratifs, c’est essentiel pour fidéliser vos
                                        utilisateurs. »
                                        </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>
        
                            <div class="valuation-module">
                                <button type="button" id="valuation-btn" class="action-btn">Valorisation immobilière / siège professionnel</button>                                
                                <div id="valuation-container" style="display: none; margin-top: 20px;">
                                    <!-- PDF Download Section -->
                                    <div class="valuation-card">
                                    <h4>Guide complet</h4>
                                    <p>Téléchargez notre fiche conseil "Augmenter la valeur de son local pro"</p>
                                    <button id="download-pdf" class="download-btn">
                                        <span class="icon">📄</span> Télécharger le PDF
                                    </button>
                                    </div>
                                    
                                    <!-- Valuation Simulator -->
                                    <div class="valuation-card">
                                    <h4>Estimation de gain de valeur</h4>
                                    <div class="form-group">
                                        <label for="property-type">Type de local:</label>
                                        <select id="property-type" class="form-input">
                                        <option value="boutique">Boutique</option>
                                        <option value="bureau">Bureau</option>
                                        <option value="commercial">Local commercial</option>
                                        <option value="mixte">Local mixte</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="property-value">Valeur actuelle (€):</label>
                                        <input type="number" id="property-value" class="form-input" min="50000" step="10000" placeholder="150000">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="renovation-level">Niveau de rénovation:</label>
                                        <select id="renovation-level" class="form-input">
                                        <option value="light">Léger (ravalement, éclairage)</option>
                                        <option value="medium">Moyen (sol, cloisonnement)</option>
                                        <option value="complete">Complet (structurel, conformité)</option>
                                        </select>
                                    </div>
                                    
                                    <button id="calculate-value" class="action-btn">Estimer la plus-value</button>
                                    
                                    <div id="valuation-result" style="display: none; margin-top: 20px; padding: 15px; background: #e8f5e9; border-radius: 5px;">
                                        <h4>Résultat de l'estimation</h4>
                                        <div class="result-row">
                                        <span>Valeur actuelle:</span>
                                        <span id="current-value">-</span>
                                        </div>
                                        <div class="result-row">
                                        <span>Plus-value estimée:</span>
                                        <span id="value-gain">-</span>
                                        </div>
                                        <div class="result-row highlight">
                                        <span>Nouvelle valeur estimée:</span>
                                        <span id="new-value">-</span>
                                        </div>
                                        <p class="disclaimer">Estimation indicative basée sur les données du marché local. Valeur non contractuelle.</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Etape 26 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = " Ne pas donner de conseil technique ou réglementaire précis au téléphone.
                                            Utilisez des phrases comme :
                                            « Nos experts se déplacent pour vous indiquer ce qui est requis, ce qui est recommandé, et ce qui
                                            peut être optimisé. »
                                            ";
                            
                            $paragraph = "<p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Aujourd’hui, les exigences réglementaires évoluent :
                                        accessibilité aux personnes à mobilité réduite, normes incendie, ventilation, traitement
                                        acoustique…
                                        Nous vous aidons à mettre vos locaux en conformité, sereinement, sans surcharge de gestion.<br>
                                        Points techniques à évoquer avec prudence :<br>
                                        • Normes PMR (accès, signalétique, sanitaires adaptés)<br>
                                        • Mise aux normes électricité / éclairage sécurité / extincteurs<br>
                                        • Traitement acoustique / confidentialité / cloisonnement phonique<br>
                                        • VMC / aération pour locaux médicaux, fermés ou en sous-sol
                                        </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';
                            ?>

                            <div class="response-options" id="div-prise-rdv6" hidden></div>

                            <div class="compliance-module">
                                <button type="button" id="compliance-request-btn" class="action-btn urgent-btn">Demande de mise en conformité</button>                                
                                <!-- Tooltip for PMR norms -->
                                <div id="pmr-tooltip" class="tooltip">
                                    <span class="tooltip-icon">ℹ️</span>
                                    <div class="tooltip-content">
                                    <h4>Synthèse des normes PMR (non contractuelle)</h4>
                                    <ul>
                                        <li>Largeur portes ≥ 0.80m</li>
                                        <li>Cheminement libre de 0.90m</li>
                                        <li>Hauteur commandes 0.90-1.30m</li>
                                        <li>Sanitaire adapté si ERP</li>
                                        <li>Contraste visuel des obstacles</li>
                                        <li>Signalétique tactile/auditive</li>
                                    </ul>
                                    <p class="disclaimer">Ces informations sont indicatives et ne remplacent pas une étude réglementaire.</p>
                                    </div>
                                </div>
                                
                                <!-- Compliance Form (hidden initially) -->
                                <div id="compliance-form" style="display: none; margin-top: 20px;">
                                    <div class="form-group">
                                    <label for="inspection-status">Situation du prospect:</label>
                                    <select id="inspection-status" class="form-input">
                                        <option value="none">Aucune inspection prévue</option>
                                        <option value="planned">Inspection en vue</option>
                                        <option value="notice">Avis de contrôle reçu</option>
                                        <option value="safety">Visite sécurité prévue</option>
                                    </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="compliance-notes">Notes supplémentaires:</label>
                                        <textarea id="compliance-notes" class="form-input" rows="3"></textarea>
                                    </div>
                                    
                                <button type="button" id="confirm-compliance" class="action-btn">Générer le RDV technique</button>                                </div>
                            </div>
                        </div>
                        
                        <!-- Etape 27 : -->
                        <div class="step">
                            <?php
                            // Question content component
                            $consignes = "Avec un syndic, il ne s’agit jamais de décider seul, mais de préparer une mise à l’ordre du jour
                                        ou de faire une proposition à l’AG. Ne parlez ni devis immédiat, ni passage en urgence, mais visite technique pour dossier
                                        préliminaire.";
                            
                            $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                        <p class='text-justify' id='textConfirmPriseEnCharge'>
                                            BATIRYM intervient régulièrement auprès de syndics pour des ravalements de façade,
                                            réfections de parties communes, réhabilitation structurelle, ou encore travaux de rénovation
                                            énergétique (ITE, menuiseries, chaufferie, etc.).
                                            Nous avons l’habitude de piloter des chantiers en milieu occupé, en respectant les contraintes
                                            des copropriétés.</p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                            // Response options component
                            $name = 'siEstimationRDV';
                            $options = [
                                
                                [
                                    'onclick' => "",
                                    'btn_class' => 'warning',
                                    'value' => 'oui',
                                    'label' => 'Plannification de visite technique',
                                    'checked' => checked('siEstimationRDV', 'oui', $questScript, 'checked')
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
                                            Nous savons que dans une copropriété, les décisions se prennent à l’Assemblée Générale.
                                            C’est pourquoi nous préparons des dossiers clairs, illustrés, avec devis détaillé, planning
                                            prévisionnel, et options chiffrées pour faciliter le vote. » </p>";
                            
                            include dirname(__FILE__) . '/blocs/questionContent.php';

                                ?>                                
                            <div class="crm-actions">
                                <h3>Actions de suivi</h3>
                                
                                <!-- AG Planned Date -->
                                <div class="form-group">
                                    <label for="ag-date">AG prévue le:</label>
                                    <input name="dateAG" type="date" id="ag-date" class="form-input">
                                </div>
                                
                                <!-- Agenda Known? -->
                                <div class="form-group">
                                    <label for="agenda-known">Ordre du jour connu?</label>
                                    <select id="agenda-known" class="form-input">
                                    <option value="oui">Oui</option>
                                    <option value="non">Non</option>
                                    <option value="partiel">Partiellement</option>
                                    </select>
                                </div>
                                
                                <!-- Technical Note Email -->
                                <div class="action-card">
                                    <h4>Note technique pour ordre du jour</h4>
                                    <p>Générer un email type pour préparer l'ordre du jour</p>
                                    <button id="generate-email" class="action-btn">Générer l'email</button>
                                    
                                    <div id="email-template" style="display: none; margin-top: 15px;">
                                    <textarea id="email-content" class="email-textarea" rows="8">
                                Objet : Note technique pour ordre du jour - [Nom de la copropriété]

                                Madame, Monsieur le Président,

                                Conformément à notre échange, vous trouverez ci-joint la note technique préparatoire à l'assemblée générale prévue le [DATE_AG].

                                Points principaux à aborder :
                                1. [Point 1]
                                2. [Point 2]
                                3. [Point 3]

                                N'hésitez pas à me contacter pour toute précision nécessaire.

                                Cordialement,
                                [Votre nom]
                                [Votre poste]
                                [Votre société]
                                    </textarea>
                                    <button id="send-email" class="action-btn">Envoyer l'email</button>
                                    </div>
                                </div>
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
                        $consignes = "Ne minimisez jamais le rôle de l’AMO, du maître d’œuvre ou de l’architecte. Le syndic y est parfois
                                    très attaché.
                                    Positionnez BATIRYM comme un exécutant de haut niveau, respectueux des processus.";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        BATIRYM peut intervenir seul ou en lien avec un AMO, un architecte ou un bureau d’études,
                                        selon la nature du projet.<br>
                                        Nous avons l’habitude de travailler en coordination, et d'assurer un suivi rigoureux, avec des
                                        comptes-rendus, des réunions de chantier et un interlocuteur unique. <br>
                                        • « Vous avez déjà un cabinet d’AMO ou de maîtrise d’œuvre ? Aucun souci, nous savons
                                        nous intégrer dans un process formalisé. »<br>
                                        • « Vous n’en avez pas ? Nous pouvons vous recommander un partenaire. Ou proposer une
                                        offre clé en main. »
                                        </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="crm-additional-fields">
                            <!-- AMO Field -->
                            <div class="form-group">
                                <label for="amo-present">AMO présent ?</label>
                                <select id="amo-present" class="form-input">
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                                <option value="recommander">À recommander</option>
                                </select>
                            </div>
                            
                            <!-- Construction Report Field -->
                            <div class="form-group">
                                <label for="chantier-report">Souhait de compte-rendu chantier régulier ?</label>
                                <select id="chantier-report" class="form-input">
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                                <option value="a-discuter">À discuter</option>
                                </select>
                            </div>
                            
                            <!-- Construction Follow-up Protocol -->
                            <div class="action-card">
                                <h4>Protocole de suivi chantier</h4>
                                <p>Générer un modèle d'email selon la typologie</p>
                                
                                <div class="form-group">
                                <label for="chantier-type">Typologie de chantier:</label>
                                <select id="chantier-type" class="form-input">
                                    <option value="ravalement">Ravalement de façade</option>
                                    <option value="toiture">Travaux de toiture</option>
                                    <option value="ascenseur">Modernisation ascenseur</option>
                                    <option value="espaces-communs">Rénovation espaces communs</option>
                                </select>
                                </div>
                                
                                <button id="generate-protocole" class="action-btn">Générer le protocole</button>
                                
                                <div id="protocole-template" style="display: none; margin-top: 15px;">
                                <textarea id="protocole-content" class="email-textarea" rows="10"></textarea>
                                <button id="send-protocole" class="action-btn">Envoyer le protocole</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Etape 33 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "Ne vous engagez jamais sur une aide garantie. Dites :
                                    « BATIRYM ne monte pas les dossiers directement, mais nous savons vous orienter vers des
                                    AMO compétents. »";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Sur les chantiers à dimension énergétique ou structurelle, nous pouvons vous orienter vers les
                                        aides possibles (ANAH, Ville, Région, prime CEE…).
                                        Nous vous mettons en lien avec des partenaires AMO qui montent les dossiers de financement.<br>
                                        Aides possibles à évoquer si besoin détecté :
                                        • Prime CEE (isolation, VMC, chauffage collectif)<br>
                                        • Subventions ANAH copropriété fragile<br>
                                        • Aides de Plaine Commune, Région IDF (copros dégradées)<br>
                                        • Accompagnement audit énergétique global<br>
                                        • ( Toujours sous réserve de conditions d’éligibilité)                          
                                    </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="energy-aid-module">
                            <!-- Energy Project Checkbox -->
                            <div class="form-group">
                                <label class="checkbox-label">
                                <input type="checkbox" id="energy-project"> 
                                <span class="checkmark"></span>
                                Projet à dominante énergétique
                                </label>
                            </div>

                            <!-- Energy Aid Module (initially hidden) -->
                            <div id="energy-aid-container" style="display: none;">
                                <div class="action-card">
                                <button id="eligible-prospect-btn" class="action-btn">
                                    Prospect potentiellement éligible aux aides
                                </button>
                                <p class="tag-info" id="crm-tag-status">Non taggé en CRM</p>
                                </div>

                                <div class="action-card">
                                <h4>Ressources AMO partenaires</h4>
                                <a style="color: black" href="#" id="amo-partners-link" class="resource-link" target="_blank">
                                    📄 Fiche AMO partenaires énergie
                                </a>
                                <button id="generate-amo-email" class="action-btn">
                                    Modèle email "Mise en relation AMO"
                                </button>
                                
                                <div id="amo-email-template" style="display: none; margin-top: 15px;">
                                    <textarea id="amo-email-content" class="email-textarea" rows="8"></textarea>
                                    <button id="send-amo-email" class="action-btn">Envoyer la demande</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 34 : -->
                    <div class="step">
                        <?php
                        // Question content component
                        $consignes = "Formulez toujours la proposition de RDV comme une évidence, non comme une faveur.
                                        Mettez en avant la valeur du rendez-vous :
                                        « C’est un moment d’échange utile, sans engagement, pour vous donner des pistes concrètes. »
                                        ";
                        
                        $paragraph = "<strong>Question <span name='numQuestionScript'></span> :</strong>
                                    <p class='text-justify' id='textConfirmPriseEnCharge'>
                                        Ce que je vous propose, c’est qu’on planifie un rendez-vous avec notre chargé de travaux pour
                                        faire le point sur votre projet.
                                        Cela peut se faire en présentiel dans vos locaux, ou bien en visio selon votre préférence.<br>
                                        • Si locaux accessibles facilement :<br>
                                        « L’idéal serait qu’on passe sur place, même rapidement, pour bien prendre la mesure. »<br>
                                        • Si pas de projet immédiat mais curiosité :<br>
                                        « On peut organiser une visio de présentation, pour vous montrer ce qu’on fait et répondre à vos
                                        questions. »<br>
                                        • Si prospect pressé :<br>
                                        « 15 à 30 minutes suffisent pour faire une évaluation rapide et voir si ça vaut la peine d’aller plus
                                        loin. »
                                        </p>";
                        
                        include dirname(__FILE__) . '/blocs/questionContent.php';
                        ?>
                        <div class="meeting-scheduler">
                            <button id="schedule-meeting-btn" class="action-btn">Proposer RDV</button>
                            
                            <div id="meeting-options-container" style="display:none;">
                                <h3>Type de rendez-vous</h3>
                                
                                <div class="meeting-options">
                                <button id="in-person-btn" class="meeting-type-btn">
                                    <span class="icon">🏢</span>
                                    Présentiel
                                </button>
                                
                                <button id="video-btn" class="meeting-type-btn">
                                    <span class="icon">🎥</span>
                                    Visio
                                </button>
                                </div>
                                
                                <!-- In-Person Meeting Form -->
                                <div id="in-person-form" class="meeting-form" style="display:none;">
                                <h4>Rendez-vous sur site</h4>
                                <div class="form-group">
                                    <label>Adresse du chantier:</label>
                                    <input type="text" id="site-address" class="form-input" value="15 Rue du Commerce" name="adresseSite">
                                </div>
                                <div class="form-group">
                                    <label>Code postal:</label>
                                    <input type="text" id="site-zip" class="form-input" value="75015" name="cpSite">
                                </div>
                                <div class="form-group">
                                    <label>Étage:</label>
                                    <input type="text" id="site-floor" class="form-input" value="2ème étage" name="etageSite">
                                </div>
                                <div class="form-group">
                                    <label>Interphone:</label>
                                    <input type="text" id="site-intercom" class="form-input" value="B25 - Digicode 4728" name="interphoneSite">
                                </div>
                                <div class="form-group">
                                    <label>Date et heure:</label>
                                    <input type="datetime-local" id="in-person-date" class="form-input" name="dateRdv">
                                </div>
                                </div>
                                
                                <!-- Video Meeting Form -->
                                <div id="video-form" class="meeting-form" style="display:none;">
                                <h4>Rendez-vous en visioconférence</h4>
                                <div class="form-group">
                                    <label>Date et heure:</label>
                                    <input type="datetime-local" id="video-date" class="form-input" name="dateRdvViseo">
                                </div>
                                <div class="form-group">
                                    <label>Lien de la réunion:</label>
                                    <input type="text" id="video-link" class="form-input" name="lienViseo">
                                </div>
                                </div>
                            </div>
                            
                            <div id="confirmation-message" style="display:none; margin-top:20px; padding:15px; background:#e8f5e9; border-radius:5px;">
                                <!-- Confirmation message will appear here -->
                            </div>
                        </div>
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

                    <!-- Etape 38 : -->
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

                                <?php
                                $name = 'plannifierDoc';
                                $options = [
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'success',
                                        'value' => 'oui',
                                        'label' => 'Envoyer documentation + planifier rappel'
                                    ],
                                    [
                                        'onclick' => "",
                                        'btn_class' => 'danger',
                                        'value' => 'rdv',
                                        'label' => 'Planifier rappel sans documentation'
                                    ]
                                ];
                                include dirname(__FILE__) . '/blocs/responseOptions.php';
                            ?>
                            <div class="response-options" id="div-prise-rdv6" hidden></div>
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
  document.addEventListener('DOMContentLoaded', function() {
    const complianceBtn = document.getElementById('compliance-request-btn');
    const complianceForm = document.getElementById('compliance-form');
    
    // Prevent default form submission behavior
    complianceBtn.addEventListener('click', function(e) {
      e.preventDefault(); // This stops the default button action
      complianceForm.style.display = complianceForm.style.display === 'none' ? 'block' : 'none';
    });
    
    // Check for urgent inspection status
    inspectionStatus.addEventListener('change', function() {
      const status = this.value;
      
      // Remove existing alert if any
      if (alertBanner) {
        alertBanner.remove();
        alertBanner = null;
      }
      
      // Create alert for urgent cases
      if (status !== 'none') {
        let alertText = '';
        switch(status) {
          case 'planned':
            alertText = 'Inspection en vue - Priorité haute';
            break;
          case 'notice':
            alertText = 'Avis de contrôle reçu - Action immédiate requise';
            break;
          case 'safety':
            alertText = 'Visite sécurité prévue - Priorité haute';
            break;
        }
        
        alertBanner = document.createElement('div');
        alertBanner.className = 'alert-banner';
        alertBanner.innerHTML = `
          <span class="icon">⚠️</span>
          <strong>ALERTE CRM:</strong> ${alertText}
        `;
        
        complianceForm.insertBefore(alertBanner, complianceForm.firstChild);
        
        // In a real CRM, this would trigger an API call
        console.log('ALERTE CRM créée:', alertText);
      }
    });
    
    // Generate technical appointment
    // Generate technical appointment - prevent default behavior
    document.getElementById('confirm-compliance').addEventListener('click', function(e) {
      e.preventDefault(); // Prevent form submission
      e.stopPropagation(); // Stop event bubbling

      const status = inspectionStatus.value;
      const notes = document.getElementById('compliance-notes').value;
      
      // Create appointment object
      const appointment = {
        type: 'technique',
        subject: 'Mise en conformité',
        priority: status === 'none' ? 'medium' : 'high',
        inspectionStatus: status,
        notes: notes,
        autoGenerated: true
      };
      
      // In a real CRM, this would create the appointment
      console.log('RDV technique généré:', appointment);
      
      // Show confirmation
      let confirmationMessage = 'RDV technique généré avec succès.';
      if (status !== 'none') {
        confirmationMessage += ' Une alerte prioritaire a été créée dans le CRM.';
      }
      
      alert(confirmationMessage);
      
      // Reset form
      complianceForm.style.display = 'none';
      inspectionStatus.value = 'none';
      document.getElementById('compliance-notes').value = '';
      
      if (alertBanner) {
        alertBanner.remove();
        alertBanner = null;
      }
      
      return false; // Additional prevention
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const valuationBtn = document.getElementById('valuation-btn');
    const valuationContainer = document.getElementById('valuation-container');
    
    // Show/hide valuation module
    valuationBtn.addEventListener('click', function(e) {
      e.preventDefault();
      valuationContainer.style.display = valuationContainer.style.display === 'none' ? 'block' : 'none';
    });
    
    // PDF Download
     document.getElementById('download-pdf').addEventListener('click', function(e) {
      e.preventDefault();
      // In a real implementation, this would link to your actual PDF
      console.log('Downloading PDF guide');
      
      // Simulate PDF download tracking
    });
    
    // Valuation Calculator
    document.getElementById('calculate-value').addEventListener('click', function(e) {
      e.preventDefault();
      const propertyType = document.getElementById('property-type').value;
      const currentValue = parseInt(document.getElementById('property-value').value);
      const renovationLevel = document.getElementById('renovation-level').value;
      
      if (!currentValue || currentValue < 50000) {
        // alert('Veuillez entrer une valeur réaliste pour votre local');
        // return;
      }
      
      // Calculate value increase based on parameters
      let multiplier = 0;
      
      switch(propertyType) {
        case 'boutique':
          multiplier = renovationLevel === 'light' ? 0.12 : 
                      renovationLevel === 'medium' ? 0.18 : 0.25;
          break;
        case 'bureau':
          multiplier = renovationLevel === 'light' ? 0.08 : 
                      renovationLevel === 'medium' ? 0.15 : 0.22;
          break;
        case 'commercial':
          multiplier = renovationLevel === 'light' ? 0.10 : 
                      renovationLevel === 'medium' ? 0.16 : 0.20;
          break;
        case 'mixte':
          multiplier = renovationLevel === 'light' ? 0.09 : 
                      renovationLevel === 'medium' ? 0.14 : 0.18;
          break;
      }
      
      const valueIncrease = Math.round(currentValue * multiplier);
      const newValue = currentValue + valueIncrease;
      
      // Display results
      document.getElementById('current-value').textContent = formatCurrency(currentValue);
      document.getElementById('value-gain').textContent = `+${formatCurrency(valueIncrease)} (${Math.round(multiplier * 100)}%)`;
      document.getElementById('new-value').textContent = formatCurrency(newValue);
      
      document.getElementById('valuation-result').style.display = 'block';
    });
    
    
    function formatCurrency(amount) {
      return new Intl.NumberFormat('fr-FR', { 
        style: 'currency', 
        currency: 'EUR',
        maximumFractionDigits: 0
      }).format(amount);
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Main elements
    const scheduleBtn = document.getElementById('schedule-meeting-btn');
    const optionsContainer = document.getElementById('meeting-options-container');
    const confirmationMessage = document.getElementById('confirmation-message');
    
    // Meeting type buttons
    const inPersonBtn = document.getElementById('in-person-btn');
    const videoBtn = document.getElementById('video-btn');
    
    // Meeting forms
    const inPersonForm = document.getElementById('in-person-form');
    const videoForm = document.getElementById('video-form');
    
    // Back buttons
    const backButtons = document.querySelectorAll('.back-btn');
    
    // Video meeting elements
    const videoSystem = document.getElementById('video-system');
    const generateLinkBtn = document.getElementById('generate-link');
    const videoLink = document.getElementById('video-link');
    
    // Open scheduler
    scheduleBtn.addEventListener('click', function(e) {
        e.preventDefault()
      optionsContainer.style.display = 'block';
      confirmationMessage.style.display = 'none';
      scheduleBtn.style.display = 'none';
      resetForms();
    });
    
    // In-person meeting selected
    inPersonBtn.addEventListener('click', function(e) {
      inPersonForm.style.display = 'block';
      videoForm.style.display = 'none';
    });
    
    // Video meeting selected
    videoBtn.addEventListener('click', function(e) {
      videoForm.style.display = 'block';
      inPersonForm.style.display = 'none';
      videoLink.value = '';
    });
    
    // Generate video link
    generateLinkBtn.addEventListener('click', function(e) {
        e.preventDefault()
      const system = videoSystem.value;
      let link = '';
      
      switch(system) {
        case 'google':
          link = 'https://meet.google.com/new?hs=181&authuser=0';
          break;
        case 'teams':
          link = 'https://teams.microsoft.com/l/meeting/new?attendees=&subject=';
          break;
        case 'zoom':
          link = 'https://zoom.us/meeting/schedule';
          break;
      }
      
      videoLink.value = link;
    });
    
    // Confirm in-person meeting
    document.getElementById('confirm-in-person').addEventListener('click', function() {
      const dateTime = document.getElementById('in-person-date').value;
      if (!dateTime) {
        alert('Veuillez sélectionner une date et heure');
        return;
      }
      
      const formattedDate = formatDateTime(dateTime);
      confirmationMessage.innerHTML = `
        <h4>✅ RDV sur site confirmé</h4>
        <p><strong>Date:</strong> ${formattedDate}</p>
        <p><strong>Adresse:</strong> ${document.getElementById('site-address').value}, ${document.getElementById('site-zip').value}</p>
        <p><strong>Détails:</strong> ${document.getElementById('site-floor').value}, ${document.getElementById('site-intercom').value}</p>
      `;
      
      showConfirmation();
    });
    
    // Confirm video meeting
    document.getElementById('confirm-video').addEventListener('click', function() {
      const dateTime = document.getElementById('video-date').value;
      if (!dateTime) {
        alert('Veuillez sélectionner une date et heure');
        return;
      }
      if (!videoLink.value) {
        alert('Veuillez générer un lien de réunion');
        return;
      }
      
      const formattedDate = formatDateTime(dateTime);
      confirmationMessage.innerHTML = `
        <h4>✅ RDV visio confirmé</h4>
        <p><strong>Date:</strong> ${formattedDate}</p>
        <p><strong>Plateforme:</strong> ${videoSystem.options[videoSystem.selectedIndex].text}</p>
        <p><strong>Lien:</strong> <a href="${videoLink.value}" target="_blank">${videoLink.value}</a></p>
      `;
      
      showConfirmation();
    });
    
    // Back buttons
    backButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        inPersonForm.style.display = 'none';
        videoForm.style.display = 'none';
      });
    });
    
    // Helper functions
    function resetForms() {
      inPersonForm.style.display = 'none';
      videoForm.style.display = 'none';
      document.getElementById('in-person-date').value = '';
      document.getElementById('video-date').value = '';
      videoLink.value = '';
    }
    
    function formatDateTime(datetimeStr) {
      if (!datetimeStr) return '';
      const date = new Date(datetimeStr);
      return date.toLocaleString('fr-FR', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
    
    function showConfirmation() {
      optionsContainer.style.display = 'none';
      confirmationMessage.style.display = 'block';
      scheduleBtn.style.display = 'inline-block';
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Energy Project Checkbox Toggle
    const energyProjectCheckbox = document.getElementById('energy-project');
    const energyAidContainer = document.getElementById('energy-aid-container');

    energyProjectCheckbox.addEventListener('change', function() {
      if(this.checked) {
        energyAidContainer.style.display = 'block';
      } else {
        energyAidContainer.style.display = 'none';
        // Reset tag status when hiding
        document.getElementById('crm-tag-status').textContent = 'Non taggé en CRM';
        document.getElementById('crm-tag-status').className = 'tag-info';
      }
    });

    // Eligible Prospect Button
    document.getElementById('eligible-prospect-btn').addEventListener('click', function(e) {
        e.preventDefault()
      // In a real CRM, this would set a tag in your system
      document.getElementById('crm-tag-status').textContent = 'Taggé "Éligible aides" en CRM';
      document.getElementById('crm-tag-status').className = 'tag-info tagged';
      console.log('Prospect marqué comme éligible aux aides dans le CRM');
    });

    // AMO Partners Link
    document.getElementById('amo-partners-link').addEventListener('click', function(e) {
      e.preventDefault();
      // In production, link to your actual AMO partners document
      console.log('Ouverture fiche AMO partenaires');
      alert('Dans une application réelle, cela ouvrirait le document des AMO partenaires');
    });

    // Generate AMO Email
    document.getElementById('generate-amo-email').addEventListener('click', function(e) {
        e.preventDefault()
      const emailTemplate = `Objet : Mise en relation AMO - Demande d'aide pour rénovation énergétique

Madame, Monsieur,

Dans le cadre des travaux de rénovation énergétique prévus au [NOM_COPROPRIETE], nous vous proposons de prendre contact avec notre partenaire AMO spécialisé :

• Structure : [NOM_AMO]
• Contact : [CONTACT_AMO]
• Téléphone : [TEL_AMO]
• Email : [EMAIL_AMO]

Cet assistant à maîtrise d'ouvrage pourra vous accompagner pour :
- Identifier les aides financières disponibles
- Optimiser votre dossier de demande de subventions
- Assurer le suivi administratif des démarches

Nous restons à votre disposition pour toute information complémentaire.

Cordialement,
[VOTRE_NOM]
[VOTRE_SOCIETE]`;

      document.getElementById('amo-email-content').value = emailTemplate;
      document.getElementById('amo-email-template').style.display = 'block';
    });

    // Send AMO Email
    document.getElementById('send-amo-email').addEventListener('click', function() {
      const emailContent = document.getElementById('amo-email-content').value;
      console.log('Email AMO à envoyer:', emailContent);
      alert('Dans une application réelle, cet email serait envoyé au prospect et à l\'AMO');
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Construction Protocol Email Templates
    const protocoleTemplates = {
      ravalement: `Objet : Protocole de suivi pour ravalement de façade - [Nom copropriété]

Madame, Monsieur le Président,

Conformément à notre échange concernant les travaux de ravalement prévus, voici le protocole de suivi que nous proposons :

1. Réunion de chantier hebdomadaire chaque [jour] à [heure]
2. Compte-rendu photo hebdomadaire
3. Point d'avancement mensuel avec le syndic
4. Procès-verbal des réunions transmis sous 48h

[AMO_PRESENT_TEXT]

Veuillez trouver ci-joint le détail du protocole. Nous restons à votre disposition pour toute modification.

Cordialement,
[Votre nom]`,
      
      toiture: `Objet : Protocole de suivi pour travaux de toiture - [Nom copropriété]

Madame, Monsieur le Président,

Pour les travaux de toiture programmés, nous établissons le protocole suivant :

1. Visite technique préalable avec l'entreprise
2. Réunion bimensuelle avec le syndic
3. Contrôle qualité des matériaux
4. Point final avant réception des travaux

[AMO_PRESENT_TEXT]
[COMPTE_RENDU_TEXT]

N'hésitez pas à nous faire part de vos observations.

Cordialement,
[Votre nom]`,
      
      ascenseur: `Objet : Protocole de suivi modernisation ascenseur - [Nom copropriété]

Madame, Monsieur le Président,

Voici le protocole proposé pour le suivi des travaux d'ascenseur :

1. Planning détaillé partagé avec résidents
2. Point technique hebdomadaire
3. Alerte immédiate en cas d'imprévu
4. Formation des gardiens à la nouvelle installation

[AMO_PRESENT_TEXT]

Nous veillerons particulièrement à limiter les nuisances sonores.

Cordialement,
[Votre nom]`,
      
      "espaces-communs": `Objet : Protocole suivi rénovation espaces communs - [Nom copropriété]

Madame, Monsieur le Président,

Pour la rénovation des espaces communs, nous proposons :

1. Validation des échantillons avant démarrage
2. Plan de circulation alternatif
3. Point quotidien avec le concierge
4. Protections renforcées des zones sensibles

[COMPTE_RENDU_TEXT]

Le planning prévisionnel sera affiché dans le hall.

Cordialement,
[Votre nom]`
    };

    // Generate Protocol Button
    document.getElementById('generate-protocole').addEventListener('click', function(e) {
        e.preventDefault()
      const chantierType = document.getElementById('chantier-type').value;
      const amoPresent = document.getElementById('amo-present').value;
      const wantsReport = document.getElementById('chantier-report').value;
      
      // Get template
      let protocole = protocoleTemplates[chantierType];
      
      // Customize AMO text
      const amoText = {
        oui: "Un assistant à maîtrise d'ouvrage (AMO) sera présent pour superviser les travaux.",
        non: "Nous recommandons la désignation d'un AMO pour un meilleur suivi.",
        recommander: "Nous pouvons vous recommander un AMO qualifié pour ce type de travaux."
      }[amoPresent];
      
      // Customize report text
      const reportText = {
        oui: "Un compte-rendu détaillé sera transmis après chaque étape importante.",
        non: "",
        "a-discuter": "Nous proposons de discuter de la fréquence des comptes-rendus selon vos besoins."
      }[wantsReport];
      
      // Replace placeholders
      protocole = protocole.replace('[AMO_PRESENT_TEXT]', amoText);
      protocole = protocole.replace('[COMPTE_RENDU_TEXT]', reportText);
      
      // Display template
      document.getElementById('protocole-content').value = protocole;
      document.getElementById('protocole-template').style.display = 'block';
    });
    
    // Send Protocol Button
    document.getElementById('send-protocole').addEventListener('click', function() {
      const protocoleContent = document.getElementById('protocole-content').value;
      console.log('Protocole à envoyer:', protocoleContent);
      alert('Protocole prêt à être envoyé. Dans une application réelle, cela serait transmis au service concerné.');
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Generate Technical Email
    const generateEmailBtn = document.getElementById('generate-email');
    const emailTemplate = document.getElementById('email-template');
    
    generateEmailBtn.addEventListener('click', function(e) {
        e.preventDefault()
      const agDate = document.getElementById('ag-date').value;
      const agendaStatus = document.getElementById('agenda-known').value;
      
      if (!agDate) {
        alert('Veuillez d\'abord saisir la date de l\'AG');
        return;
      }
      
      // Show email template
      emailTemplate.style.display = 'block';
      
      // Format date for display
      const formattedDate = new Date(agDate).toLocaleDateString('fr-FR');
      
      // Get email content and replace placeholder
      const emailContent = document.getElementById('email-content');
      emailContent.value = emailContent.value.replace('[DATE_AG]', formattedDate);
      
      // Additional customization based on agenda status
      if (agendaStatus === 'non') {
        emailContent.value += "\n\nPS: Pourriez-vous me communiquer les points principaux qui seront à l'ordre du jour?";
      }
    });
    
    // Send Email Button
    document.getElementById('send-email').addEventListener('click', function() {
      const emailContent = document.getElementById('email-content').value;
      console.log('Email à envoyer:', emailContent);
    });
    
    // Request Regulations Button
    document.getElementById('request-regulations').addEventListener('click', function(e) {
        e.preventDefault()
      const agDate = document.getElementById('ag-date').value;
      
      if (!agDate) {
        alert('Veuillez d\'abord saisir la date de l\'AG');
        return;
      }
      
      const formattedDate = new Date(agDate).toLocaleDateString('fr-FR');
      const message = `Bonjour,\n\nPourriez-vous nous faire parvenir une copie du règlement de copropriété en vue de l'AG prévue le ${formattedDate}?\n\nMerci par avance.\nCordialement`;
      
      console.log('Demande de règlement:', message);
      alert('Demande de règlement prête à être envoyée. Dans une application réelle, cela générerait une demande officielle.');
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calculerBtn = document.getElementById('calculer-btn');
    const inspirationBtn = document.getElementById('inspiration-btn');
    const resultatsContainer = document.getElementById('resultats');
    
    // Coefficients for different business types
    const coefficients = {
      boutique: { min: 0.08, max: 0.15 },
      restaurant: { min: 0.12, max: 0.20 },
      salon: { min: 0.10, max: 0.18 },
      autre: { min: 0.05, max: 0.12 }
    };
    
    // Furniture age multipliers
    const mobilierMultipliers = {
      ancien: 1.0,
      moyen: 0.7,
      recent: 0.4
    };
    
    calculerBtn.addEventListener('click', function(e) {
        e.preventDefault()
      const surfaceActuelle = parseFloat(document.getElementById('surface-actuelle').value);
      const typeCommerce = document.getElementById('type-commerce').value;
      const etatMobilier = document.getElementById('mobilier-actuel').value;
      
      if (isNaN(surfaceActuelle) || surfaceActuelle <= 0) {
        alert('Veuillez entrer une surface valide');
        return;
      }
      
      // Calculate potential gain
      const coeff = coefficients[typeCommerce];
      const multiplier = mobilierMultipliers[etatMobilier];
      
      // Random factor between min and max for variability
      const randomFactor = coeff.min + Math.random() * (coeff.max - coeff.min);
      const gainSurface = Math.round(surfaceActuelle * randomFactor * multiplier);
      const pourcentageGain = Math.round((gainSurface / surfaceActuelle) * 100);
      
      // Display results
      document.getElementById('gain-surface').textContent = gainSurface;
      document.getElementById('pourcentage-gain').textContent = pourcentageGain;
      resultatsContainer.style.display = 'block';
      
      // Scroll to results
      resultatsContainer.scrollIntoView({ behavior: 'smooth' });
    });
    
    inspirationBtn.addEventListener('click', function() {
      const surfaceActuelle = document.getElementById('surface-actuelle').value;
      const typeCommerce = document.getElementById('type-commerce').value;
      
      if (!surfaceActuelle || isNaN(surfaceActuelle)) {
        alert('Veuillez d\'abord calculer votre gain de surface');
        return;
      }
      
      // Here you would typically send this data to your server
      console.log('Demande de fiche inspiration envoyée pour:', {
        surface: surfaceActuelle,
        type: typeCommerce,
        gain: document.getElementById('gain-surface').textContent
      });
      
      // Show confirmation (in a real app, this would be after server response)
      alert('Merci ! Votre fiche inspiration design pro sera envoyée par email sous 24h.');
      
      // Reset form
      document.getElementById('calculer-btn').click();
    });
  });
</script>

<script>
  const checkboxes = document.querySelectorAll('.service-checkbox');
  const submitBtn = document.getElementById('submit-btn');
  
  function updateButtonVisibility() {
    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
    submitBtn.style.display = checkedCount >= 2 ? 'block' : 'none';
  }
  
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateButtonVisibility);
  });

  document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.objective-checkbox');
    const counter = document.getElementById('selected-count');
    const messageBox = document.getElementById('custom-message');
    const MAX_SELECTIONS = 2;
    
    console.log('Script loaded, found checkboxes:', checkboxes.length); // Debug
    
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        console.log('Checkbox changed:', this.id, this.checked); // Debug
        
        const checkedBoxes = Array.from(document.querySelectorAll('.objective-checkbox:checked'));
        const checkedCount = checkedBoxes.length;
        
        console.log('Currently checked:', checkedCount); // Debug
        
        if (checkedCount > MAX_SELECTIONS) {
          this.checked = false;
          console.log('Prevented selection - max reached'); // Debug
          return;
        }
        
        counter.textContent = checkedCount;
        
        if (checkedCount === MAX_SELECTIONS) {
          checkboxes.forEach(cb => {
            if (!cb.checked) cb.disabled = true;
          });
          console.log('Showing message for selections'); // Debug
          showCustomMessage(checkedBoxes);
        } else {
          checkboxes.forEach(cb => cb.disabled = false);
          messageBox.style.display = 'none';
        }
      });
    });

    const messages = {
      // Modernization + Compliance (Rénovation ambiance)
      'compliance,modernize': 'Ce n\'est pas juste un sol ou un mur : c\'est l\'ambiance que perçoit votre client quand il franchit la porte. Et ça, ça se rénove.',
      
      // Revenue + Modernize (Espace agencé)
      'modernize,revenue': 'Un espace bien agencé, c\'est 10 % de place gagnée, 20 % de stress en moins, et un vrai plus en chiffres de vente.',
      
      // Image + Traffic ("Wow" effect)
      'image,traffic': 'Quand un client entre et dit "Wow, c\'est beau ici", vous avez déjà gagné la moitié de la vente.',
      
      // Image + Modernize (Vitrine/First impression)
      'image,modernize': 'Aujourd\'hui, l\'image que donne votre boutique, c\'est votre premier vendeur. Si la vitrine ne donne pas envie de rentrer, la vente ne commence même pas. Nous, on vous aide à déclencher ce premier pas.',
      
      // Image + Revenue (Same as "Wow" effect)
      'image,revenue': 'Quand un client entre et dit "Wow, c\'est beau ici", vous avez déjà gagné la moitié de la vente.',
      
      // Image + Compliance (First impression)
      'compliance,image': 'Aujourd\'hui, l\'image que donne votre boutique, c\'est votre premier vendeur. Si la vitrine ne donne pas envie de rentrer, la vente ne commence même pas. Nous, on vous aide à déclencher ce premier pas.',
      
      // Traffic + Modernize (Espace agencé)
      'modernize,traffic': 'Un espace bien agencé, c\'est 10 % de place gagnée, 20 % de stress en moins, et un vrai plus en chiffres de vente.',
      
      // Default fallback
      'default': 'Vos sélections montrent une vision stratégique pour votre commerce. Nous pouvons vous aider à concrétiser ces objectifs.'
    };

    function showCustomMessage(checkedBoxes) {
      const selectedIds = checkedBoxes.map(cb => cb.id).sort().join(',');
      console.log('Selected combination:', selectedIds);
      
      messageBox.textContent = messages[selectedIds] || messages['default'];
      messageBox.style.display = 'block';
    }
  });
</script>

<script>
    let interetAssurance = ""
    let selectedActivite = ""
    function setActivite(radio) {
        const radioVal = radio.querySelector('input[type="radio"]').value
        selectedActivite = radioVal
    }

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
            $("#sous-question-8").attr("hidden", "hidden");
        } else {
            $("#sous-question-0").removeAttr("hidden");
            $("#sous-question-8").removeAttr("hidden");
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
                document.getElementById("div-prise-rdv3").innerHTML = htmlRDV2();
                document.getElementById("div-prise-rdv4").innerHTML = htmlRDV2();
                document.getElementById("div-prise-rdv5").innerHTML = htmlRDV2();
                document.getElementById("div-prise-rdv6").innerHTML = htmlRDV2();
                getDisponiblites2();


                $("#div-prise-rdv2").removeAttr("hidden");
                $("#div-prise-rdv3").removeAttr("hidden");
                $("#div-prise-rdv4").removeAttr("hidden");
                $("#div-prise-rdv5").removeAttr("hidden");
                $("#div-prise-rdv6").removeAttr("hidden");
                $("#divChargementDisponibilite2").removeAttr("hidden");
                hidePlaceRdv2 = false;
                hidePlaceRdv2bis = true;
            }
        } else {
            $("#div-prise-rdv2").attr("hidden", "hidden");
            $("#div-prise-rdv3").attr("hidden", "hidden");
            $("#div-prise-rdv3").attr("hidden", "hidden");
            $("#div-prise-rdv4").attr("hidden", "hidden");
            $("#div-prise-rdv5").attr("hidden", "hidden");
            $("#div-prise-rdv6").attr("hidden", "hidden");
            $("#divChargementDisponibilite2").attr("hidden", "hidden");
            hidePlaceRdv2 = true;
            document.getElementById("div-prise-rdv2").innerHTML = '';
            document.getElementById("div-prise-rdv3").innerHTML = '';
            document.getElementById("div-prise-rdv4").innerHTML = '';
            document.getElementById("div-prise-rdv5").innerHTML = '';
            document.getElementById("div-prise-rdv6").innerHTML = '';
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
        objetMail =
            `Découvrez Batirym : gérer votre sinistre devient très simple.`;
        bodyMail = `<p style="text-align:justify">${`<?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?>`}<br><br>
                    Merci pour notre échange très agréable d'aujourd'hui.<br><br>
                    Comme promis, je vous transmets en pièce jointe notre plaquette Batirym. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d’assurance, en nous occupant de tout, de A à Z.<br><br>
                    <b>En choisissant Batirym, vous bénéficiez notamment de</b> :<br>
                    <ul>
                        <li>Un interlocuteur unique dédié à votre dossier.</li>
                        <li>Une expertise SOS Sinistre sous 24 heures.</li>
                        <li>Un soutien administratif et juridique complet.</li>
                        <li><b>0€ de coût de gestion</b> pour vous.</li>
                        <li>La facilitation complète des démarches liées à votre sinistre.</li>
                        <li>Une assistance disponible 24h/24 et 7j/7.</li>
                        <li>Des partenaires agréés pour des réparations rapides et garanties.</li>
                    </ul>
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d’esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                     ${`<?= SIGNATURE_RELATIONCLIENT_BATIRYM ?>`}
                                            `;

        $('#objetMailEnvoiDoc').val(objetMail)
        $('#signatureMail').val(`<?= SIGNATURE_RELATIONCLIENT_BATIRYM ?>`)
        tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
        tinyMCE.get("bodyMailEnvoiDoc").getBody().setAttribute('contenteditable', false);
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
        nextBtn.classList.toggle("hidden", (currentStep == 31 || currentStep == 37 || currentStep == 38 /*|| currentStep ==
            70*/));
        // finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1 && currentStep != 7);
        finishBtn.classList.toggle("hidden", (currentStep != 31 && currentStep != 37 && currentStep != 38 /*&& currentStep !=
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
            const val = document.querySelector('input[name="siRefus"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                return showStep(1);
            } else {
                return showStep(31);
            }
        }
        if (currentStep === 1) {
            const val = document.querySelector('input[name="prospectB2B"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            if (val.value == "oui") {
                $("#sous-question-0").attr("hidden", "hidden");
                return showStep(2);
            } else {
                $("#sous-question-0").removeAttr("hidden");
                return showStep(2);
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
            const val = document.querySelector('input[name="siUtile"]:checked');
            if (!val) {
                $("#msgError").text("Veuillez sélectionner une réponse !");
                $('#errorOperation').modal('show');
                return;
            }
            console.log(val.value)
            if (val.value == "oui") {
                return showStep(4);
            }  else {
                // Fin
                return showStep(38);
            }
        }
        else if(currentStep === 5) {
            const commerceText = document.querySelector("#commerceText")
            const restaurationText = document.querySelector("#restaurationText")
            const liberaleText = document.querySelector("#liberaleText")
            const immobilierText = document.querySelector("#immobilierText")
            console.log(immobilierText)
            if(selectedActivite == "commerce"){
                commerceText.style.display = "block"
                restaurationText.style.display = "none"
                liberaleText.style.display = "none"
                immobilierText.style.display = "none"
            }
            else if(selectedActivite == "restauration"){
                commerceText.style.display = "none"
                restaurationText.style.display = "block"
                liberaleText.style.display = "none"
                immobilierText.style.display = "none"
            }
            else if(selectedActivite == "profession liberale"){
                commerceText.style.display = "none"
                restaurationText.style.display = "none"
                liberaleText.style.display = "block"
                immobilierText.style.display = "none"
            }
            else if(selectedActivite == "immobilier"){
                commerceText.style.display = "none"
                restaurationText.style.display = "none"
                liberaleText.style.display = "none"
                immobilierText.style.display = "block"
            }
            showStep(6)
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
        else if (currentStep === 19) {
            if(selectedActivite === "commerce") {
                showStep(20)
            }
            if(selectedActivite === "restauration") {
                showStep(22)
            }

            if(selectedActivite === "profession liberale") {
                showStep(25)
            }

            if(selectedActivite === "immobilier") {
                showStep(28)
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
            return showStep(35);
        }

        else if (currentStep === 24) {
            return showStep(35)
        }

        else if (currentStep === 27) {
            return showStep(35)
        }

        // else if (currentStep === 28) {
        //     const val = document.querySelector('input[name="demandeConnaissanceAutreProspect"]:checked');
        //     if (!val) {
        //         $("#msgError").text("Veuillez sélectionner une réponse !");
        //         $('#errorOperation').modal('show');
        //         return;
        //     }
        //     if (val.value == "non") {
        //         return showStep(30);
        //     }else {
        //         showStep(30)
        //     }
        // }
        
        else if (currentStep === 29) {
            return showStep(33);
        }
        
        else if (currentStep === 31) {
            return showStep(30);
        }

        else if (currentStep === 34) {
            showStep(35)
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
        formData.append('type', 'batirym');
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
// include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>