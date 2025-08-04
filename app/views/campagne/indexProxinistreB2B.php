<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;
function checked($field, $value, $object, $action)
{
    return $object && $object->$field == $value ? $action : '';
}
?>


<style>
.stepDSS,
.stepSD,
.stepRvRT,
.stepRvPerso {
    display: none;
}

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

<!-- les modal pour D de Documentation -->
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
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div
                style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px;     background-color: #fff; text-align: center;">
                <h2><span><i class="fas fa-fw fa-scroll" style="color: #c00000;"></i></span> CAMPAGNE PRODUCTION B2B
                    PROXINISTRE
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/Logo-SOSINISTRE-by-PROXINISTRE.png"
                        alt="">
                </h2>
            </div>
            <?=
                include dirname(__FILE__) . '/blocs/formCbB2B.php';
            ?>

            <form id="scriptForm">
                <input hidden id="contextId" name="idCompanyGroup" value="<?= $company ? $company->idCompany : 0 ?>">
                <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC"
                    id="divBodyAccueil">
                    <div class="mb-5 mt-5">
                        <div class="question-box mb-5 mt-5">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify">Bonjour, je suis <b>
                                            <?= $connectedUser->fullName   ?>
                                        </b> de la
                                        société
                                        SOS Sinistre, spécialisée dans la gestion des sinistres immobiliers. <br> J'ai
                                        une
                                        information importante à porter à votre connaissance. <br>Est-ce que je suis
                                        bien
                                        avec
                                        la société <b>
                                            <?= $company->name ?>
                                        </b> ?</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <option <?= $contact && $contact->civilite == "Monsieur" ? 'selected' : '' ?>
                                            value="Monsieur">Monsieur</option>
                                        <option <?= $contact && $contact->civilite == "Madame" ? 'selected' : '' ?>
                                            value="Madame">Madame</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prénom</label>
                                    <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                        id="prenomGerant" value="<?= $contact ? $contact->prenom : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nom</label>
                                    <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                        id="nomGerant" value="<?= $contact ? $contact->nom : '' ?>">
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="emailGerant" ref="emailGerant"
                                        value="<?= $contact ? $contact->email : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Téléphone</label>
                                    <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                        value="<?= $contact ? $contact->tel : '' ?>">
                                </div>
                                <!-- <div class="form-group col-md-4">
                                    <label for="">Poste</label>
                                    <select name="posteGerant" ref="posteGerant" id="" class="form-control">
                                        <option value="responsable">Responsable</option>
                                    </select>
                                </div> -->
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
                    <div class="stepDSS active">
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
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check" name="siSignDeleg"
                                            value="oui" <?= checked('siSignDeleg', 'oui', $questScript, 'checked') ?> />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="siSignDeleg"
                                            <?= checked('siSignDeleg', 'plusTard', $questScript, 'checked') ?>
                                            class="btn-check" value="plusTard" />
                                    </div>
                                    Plus Tard
                                </button>
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('siSignDeleg', 'non', $questScript, 'checked') ?>
                                            name="siSignDeleg" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
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
                                                    <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                    value="Monsieur">Monsieur</option>
                                                <option
                                                    <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                    value="Madame">Madame</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Prénom <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="prenomGerant"
                                                ref="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Nom <small class="text-danger">*</small></label>
                                            <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                                value="<?= $gerant ? $gerant->nom : '' ?>">
                                        </div>
                                    </div>

                                    <div class="row col-md-12">
                                        <div class="form-group col-md-4">
                                            <label for="">Email</label>
                                            <input type="email" class="form-control" name="emailGerant"
                                                ref="emailGerant" value="<?= $gerant ? $gerant->email : '' ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Téléphone</label>
                                            <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                                value="<?= $gerant ? $gerant->tel : '' ?>">
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
                                                value="<?= $company->businessLine1 ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Code Postal <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="cp" id="cP"
                                                value="<?= $company->businessPostalCode ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Ville <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="ville" id="ville"
                                                value="<?= $company->businessCity ?>">
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
                                                name="dateDebutContrat" id="dateDebutContrat" value="
                            <?= ($questScript ? $questScript->dateDebutContrat : "") ?>"
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
                                                    <?= ($questScript && $questScript->siDeclarerSinistre == "Non") ? "" : "checked" ?>><label
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
                    <div class="buttons">
                        <button id="prevBtnSD" type="button" class="btn-prev hidden" onclick="goBackScript('SD')">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPageSD" class="font-weight-bold"></span></label>
                        <button id="nextBtnSD" type="button" class="btn-next" onclick="goNext('SD')">Suivant
                            ➡</button>
                        <button id="finishBtnSD" type="button" class="btn-finish hidden" onclick="finish('SD')">✅
                            Terminer</button>
                    </div>

                </div>
                <div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid grey"
                    id="divBodyRvRT" hidden>
                    <!-- Etape 0 : RT 1 -->
                    <div class="stepRvRT active">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Nous allons organiser un rendez-vous avec notre expert
                                        interne
                                        pour effectuer un relevé technique directement sur place. Il prendra les mesures
                                        et
                                        établira un rapport détaillé à transmettre à votre assureur, afin de faciliter
                                        la
                                        prise en charge de votre dossier. Quand seriez-vous disponible pour ce
                                        rendez-vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('accordRVRT', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="accordRVRT" id="respOui" value="oui" /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('accordRVRT', 'non', $questScript, 'checked') ?>
                                            name="accordRVRT" id="respNon" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="stepRvRT">
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
                                            value="<?= $gerant ? $gerant->email : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone</label>
                                        <input type="text" class="form-control" name="telGerant" ref="telGerant"
                                            value="<?= $gerant ? $gerant->tel : '' ?>">
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
                    </div>

                    <div class="stepRvRT">
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
                                                value="<?= $company->businessLine1 ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Code Postal <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="cp" id="cP"
                                                value="<?= $company->businessPostalCode ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Ville <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="text" name="ville" id="ville"
                                                value="<?= $company->businessCity ?>">
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

                    <!-- Etape 3  : PRISE DE RDV RT-->
                    <div class="stepRvRT">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Je vous propose la date suivante :
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="col-md-12">
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">1. Veuillez selectionner la
                                            plage
                                            de
                                            disponibilité pour le sinistré</span>
                                    </div>
                                    <div class="row mt-2 mb-2 ml-2">
                                        <div class="col-md-12 row">
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: #d3ff78;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>
                                                        <?= $rv ? "Même Date & Même Heure" : "RV à moins de 30min" ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: lightblue;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>
                                                        <?= $rv ? "Même Date mais Heure différente" : "Disponible Mi-Journée" ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 row">
                                                <div class="col-md-3" style="background-color: #FF4C4C;">

                                                </div>
                                                <div class="col-md-9">
                                                    <span>Expert Sans RDV</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="divTabDisponibilite">

                                    </div>
                                    <div>
                                        <div
                                            class="offset-2 col-md-8 pagination pagination-sm row text-center mb-3 mt-1">
                                            <div class="pull-left page-item col-md-6 p-0 m-0">
                                                <div id="btnPrecedentRDV">
                                                    <a type="button" class="text-center btn"
                                                        style="background-color: grey;color:white"
                                                        onclick="onClickPrecedentRDV('')">Dispos Prec. << </a>
                                                </div>
                                            </div>
                                            <div id="btnSuivantRDV" class="pull-right page-item col-md-6 p-0 m-0"><a
                                                    type="button" class="text-center btn"
                                                    style="background-color: grey;color:white"
                                                    onclick="onClickSuivantRDV('')">>>
                                                    Dispos Suiv.</a></div>
                                        </div>
                                    </div>
                                    <div class="row mt-2" id="divTabHoraire">


                                    </div>
                                    <div class=" row mt-5 text-center">
                                        <h4 class="text-center font-weight-bold" id="INFO_RDV"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 4  : PRISE DE RDV RT-->
                    <div class="stepRvRT">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>FIN RDV RT :</strong>
                                    <p id="textClotureRvRT">
                                        Je vous remercie et vous souhaite une bonne fin de journée!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Navigation sd -->
                    <div class="buttons">
                        <button id="prevBtnRvRT" type="button" class="btn-prev hidden" onclick="goBackScript('RvRT')">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPageRvRT" class="font-weight-bold"></span></label>
                        <button id="nextBtnRvRT" type="button" class="btn-next" onclick="goNext('RvRT')">Suivant
                            ➡</button>
                        <button id="finishBtnRvRT" type="button" class="btn-finish hidden" onclick="finish('RvRT')">✅
                            Terminer</button>
                    </div>
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
                                <div class="col-md-12">
                                    <div class="font-weight-bold">
                                        <span class="text-center text-danger">1. Veuillez selectionner la plage de
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
                                        value="<?= $company->businessLine1 . ' ' . $company->businessPostalCode . ' ' . $company->businessCity ?>"
                                        id="adresseImm">
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
                    <div class="buttons">
                        <button id="prevBtnRvPerso" type="button" class="btn-prev hidden"
                            onclick="goBackScript('RvPerso')">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPageRvPerso" class="font-weight-bold"></span></label>
                        <button id="nextBtnRvPerso" type="button" class="btn-next" onclick="goNext('RvPerso')">Suivant
                            ➡</button>
                        <button id="finishBtnRvPerso" type="button" class="btn-finish hidden"
                            onclick="finish('RvPerso')">✅
                            Terminer</button>
                    </div>
                </div>
            </form>
        </div>

       <?=
            include dirname(__FILE__) . '/blocs/prodProxSidebar.php';
        ?>
    </div>
</div>

<script>
function loadNotes(type) {
    console.log('loadNotes B2C appelée avec type:', type);
    
    if (type === 'modal') {
        // Vérifier que jQuery est disponible
        if (typeof $ === 'undefined') {
            alert('jQuery n\'est pas disponible');
            return;
        }
        
        // Charger les notes via AJAX et afficher dans le modal
        $.ajax({
            url: `<?= URLROOT ?>/public/json/campagneSociete.php?action=loadNotes`,
            type: 'POST',
            data: {
                idCompanyGroup: $('#contextId').val(),
                contextType: $('#contextType').val()
            },
            dataType: "JSON",
            beforeSend: function() {
                console.log('Chargement des notes...');
                // Afficher un message de chargement si possible
                if ($('#loadingModal').length > 0) {
                    $("#msgLoading").text("Chargement des notes...");
                    $('#loadingModal').modal('show');
                }
            },
            success: function(response) {
                console.log('Réponse reçue:', response);
                
                // Cacher le modal de chargement
                if ($('#loadingModal').length > 0) {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 500);
                }

                // Vider le tableau des notes
                $('#dataTable20 tbody').empty();
                
                if (response && response.notes && response.notes.length > 0) {
                    // Remplir le tableau avec les notes
                    response.notes.forEach(function(note, index) {
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewNote(${note.id})" data-toggle="tooltip" title="Voir le détail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                                <td style="max-width: 300px; word-wrap: break-word;">
                                    ${note.content ? note.content.substring(0, 100) + (note.content.length > 100 ? '...' : '') : 'Aucun contenu'}
                                </td>
                                <td>${note.date ? formatDate(note.date) : 'Non définie'}</td>
                                <td>${note.auteur || 'Non défini'}</td>
                            </tr>
                        `;
                        $('#dataTable20 tbody').append(row);
                    });
                } else {
                    // Aucune note trouvée
                    $('#dataTable20 tbody').append(`
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="fas fa-sticky-note"></i> Aucune note disponible
                            </td>
                        </tr>
                    `);
                }

                // Afficher le modal
                $('#modalListNotes').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Erreur AJAX:', error, xhr.responseText);
                
                // Cacher le modal de chargement
                if ($('#loadingModal').length > 0) {
                    setTimeout(() => {
                        $('#loadingModal').modal('hide');
                    }, 500);
                }
                
                // Afficher l'erreur
                if ($('#errorOperation').length > 0) {
                    $("#msgError").text("Impossible de charger les notes ! Erreur: " + error);
                    $('#errorOperation').modal('show');
                } else {
                    alert("Impossible de charger les notes ! Erreur: " + error);
                }
            }
        });
    }
}
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

function getInfoMail() {
console.log('1')
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


function saveScriptPartiel(etape) {
    getInfoMail()
    let form = document.getElementById('scriptForm');
    const formData = new FormData(form);
    let causes = formData.getAll('cause[]');
    let dommages = formData.getAll('dommages[]');
    let noteTextCampagne = tinyMCE.get("noteTextCampagne").getContent()
    formData.append('type', 'Prox');
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
</script>

<?php
include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>