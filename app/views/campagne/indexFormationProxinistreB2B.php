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

<div class=" col-12">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div
                style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px;     background-color: #fff; text-align: center;">
                <h2><span><i class="fas fa-fw fa-scroll" style="color: #c00000;"></i></span> CAMPAGNE FORMATION B2B
                    PROXINISTRE
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/Logo-SOSINISTRE-by-PROXINISTRE.png"
                        alt="">
                </h2>
            </div>
            <div class="script-container" style="margin-top:15px; padding:10px">
                <div class="container-fluid px-0">
                    <div class="row">
                        <!-- Nom -->
                        <div class="form-group col-4 col-md-4 col-sm-4  ">
                            <label class="font-weight-bold">Dénomination Sociale</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= $company ? $company->name : '' ?>">
                        </div>

                        <!-- Enseigne -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Enseigne</label>
                            <input type="text" name="enseigne" class="form-control"
                                value="<?= $company ? $company->enseigne : '' ?>">
                        </div>
                        <!-- Status -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 " hidden>
                            <label class="font-weight-bold">Statut</label>
                            <div class="input-group">
                                <input type="text" id="statusInput" name="status" class="form-control" readonly
                                    value="<?= $company ? $company->category : '' ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-red" data-toggle="modal"
                                        data-target="#statusModal">
                                        Charger
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Activité -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Activité</label>
                            <input type="text" name="enseigne" class="form-control"
                                value="<?= $company ? $company->industry : '' ?>">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Téléphone -->
                        <div class="form-group   col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Téléphone</label>
                            <div class="input-group">
                                <input type="tel" name="businessPhone" class="form-control"
                                    value="<?= $company ? $company->businessPhone : '' ?>"
                                    placeholder="Entrez le numéro de téléphone">
                                <?php if ($company && $company->businessPhone): ?>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" title="WhatsApp">
                                        <a target="_blank"
                                            href="https://api.whatsapp.com/send?phone=33<?= str_replace(' ', '', $company->businessPhone) ?>"
                                            style="color: #ffffff;">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-group col-md-4  col-4 col-sm-4 ">
                            <label class="font-weight-bold">Email</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control"
                                    value="<?= $company ? $company->email : '' ?>" placeholder="Entrez l'adresse email">
                                <?php if ($company && $company->email): ?>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" title="Envoyer un email">
                                        <a href="mailto:<?= $company->email ?>" style="color: #ffffff;">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Site Web -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Site Web</label>
                            <div class="input-group">
                                <input type="url" name="webaddress" class="form-control"
                                    value="<?= $company ? $company->webaddress : '' ?>"
                                    placeholder="https://www.exemple.com">
                                <?php if ($company && $company->webaddress): ?>
                                <div class="input-group-append">
                                    <a href="<?= strpos($company->webaddress, 'http') === 0 ? $company->webaddress : 'https://' . $company->webaddress ?>"
                                        target="_blank" class="btn"
                                        style="background-color: #2196F3; color: #ffffff; border-radius: 5px;">
                                        <i class="fas fa-globe" style="color: #ffffff;"></i>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Adresse -->
                        <div class="col-md-4  col-4 col-sm-4  mb-3">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Adresse 1</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="businessLine1" id="businessLine1" class="form-control"
                                    value="<?= $company ? $company->businessLine1 : '' ?>">
                            </div>
                        </div>

                        <!-- Code Postal -->
                        <div class="col-md-4  col-4 col-sm-4  mb-3">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Code Postal</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="businessPostalCode" id="businessPostalCode"
                                    class="form-control" readonly
                                    value="<?= $company ? $company->businessPostalCode : '' ?>">
                            </div>
                        </div>

                        <!-- Ville -->
                        <div class="col-md-4  col-4 col-sm-4  mb-3">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Ville</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" readonly name="businessCity" class="form-control"
                                    value="<?= $company ? $company->businessCity : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="script-container" style="margin-top:15px; padding:10px">
                <form id="scriptForm">
                    <input hidden id="contextId" name="idCompanyGroup"
                        value="<?= $company ? $company->idCompany : 0 ?>">

                    <!-- Étape 0 : Presentation -->
                    <div class="step active">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Bonjour, je suis <b>
                                            <?= $connectedUser->fullName   ?>
                                        </b> de la
                                        société
                                        SOS Sinistre, spécialisée dans la gestion des sinistres immobiliers. <br> J'ai
                                        une
                                        information importante à porter à votre connaissance. <br>Est-ce que je parle
                                        bien
                                        avec
                                        le
                                        responsable de <b>
                                            <?= !empty($company) ? $company->name : '' ?>
                                        </b> ?</p>
                                </div>
                            </div>

                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable" class="btn-check" value="hesite"
                                            <?= checked('responsable', 'hesite', $questScript, 'checked') ?> />
                                    </div>
                                    Plus de précisions
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 1 : Oui Resp -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Merci . Je suis chargé de vous informer que les commerçants
                                        bénéficient désormais d'une assistance totalement gratuite pour la
                                        gestion
                                        de leurs sinistres immobiliers (dégât des eaux, incendie, bris de glace,
                                        effraction
                                        avec
                                        dommages matériels, etc.). <br> Est-ce un sujet qui vous concerne aujourd'hui ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="reponse_concerne" value="oui" ref="reponse_concerne"
                                            <?= checked('reponse_concerne', 'oui', $questScript, 'checked') ?> /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" ref="reponse_concerne"
                                            <?= checked('reponse_concerne', 'non', $questScript, 'checked') ?>
                                            name="reponse_concerne" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2 : Oui Concerne -->
                    <div class="step">
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

                    <!-- Etape 3 Question Reparation -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">Est-ce que les travaux
                                        d'embellissement ou de remise en état
                                        ont
                                        déjà été réalisés ?</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siTravaux', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siTravaux" value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siTravaux"
                                            <?= checked('siTravaux', 'non', $questScript, 'checked') ?> value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 4 DATE DU SINISTRE -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Je vais recupérer des informations rapidement<br>Quelle est
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
                    <div class="step">
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
                    <div class="step">
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
                    <div class="step">
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


                    <!-- Etape 8 : INFOS ASSURANCE -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Avez-vous déclaré ce sinistre à votre assureur</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button
                                    onclick="selectRadio(this);showSousQuestion('4-1',false);showSousQuestion('4-2',true);"
                                    type="button" data-value="Oui" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="siDeclarerSinistre" id="respOui" value="oui"
                                            <?= checked('siDeclarerSinistre', 'oui', $questScript, 'checked') ?> />
                                    </div>
                                    Oui
                                </button>
                                <button
                                    onclick="selectRadio(this);showSousQuestion('4-1',true);showSousQuestion('4-2',false);"
                                    type="button" data-value="Oui" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('siDeclarerSinistre', 'non', $questScript, 'checked') ?>
                                            name="siDeclarerSinistre" id="respNon" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                        <!-- Si Non déclaré -->
                        <div id="sous-question-4-1"
                            <?= $questScript && $questScript->siDeclarerSinistre == 'non' ? '' : 'hidden' ?>>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>-a :</strong>
                                        <p class="text-justify">Vous n'avez pas encore déclaré ce sinistre à votre
                                            assurance
                                            ?
                                            Très
                                            bien, je vous propose de le faire directement pour vous dès maintenant, de
                                            façon
                                            totalement gratuite. <br>Nous gérons pour vous toute la procédure, de la
                                            déclaration
                                            à
                                            la réparation finale, en coordonnant directement les échanges avec l'expert
                                            mandaté
                                            et
                                            en assurant rapidement les travaux nécessaires, sans frais à avancer, sauf
                                            la
                                            franchise
                                            éventuelle. C'est exactement comme le modèle utilisé par Carglass : vous ne
                                            vous
                                            occupez
                                            de rien et nous nous chargeons de tout.<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Si  déclaré -->
                        <div id="sous-question-4-2"
                            <?= $questScript && $questScript->siDeclarerSinistre == 'oui' ? '' : 'hidden' ?>>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>-a :</strong>
                                        <p class="text-justify">Vous avez déjà déclaré ce sinistre à votre assureur,
                                            c'est
                                            noté.
                                            Je
                                            vais juste vérifier quelques points importants avec vous. Votre compagnie
                                            vous
                                            a-t-elle
                                            informé de son intention de mandater son expert pour venir expertiser et
                                            évaluer
                                            votre
                                            sinistre ?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button
                                        onclick="selectRadio(this);showSousQuestion('4-2-1',true);showSousQuestion('4-2-2',false);"
                                        type="button" data-value="Oui" class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio" class="btn-check"
                                                name="repSiMandatExpert" id="respOui"
                                                <?= checked('repSiMandatExpert', 'oui', $questScript, 'checked') ?>
                                                value="oui" /></div>
                                        Oui
                                    </button>
                                    <button
                                        onclick="selectRadio(this);showSousQuestion('4-2-1',false);showSousQuestion('4-2-2',true);"
                                        type="button" data-value="Oui" class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check"
                                                <?= checked('repSiMandatExpert', 'non', $questScript, 'checked') ?>
                                                name="repSiMandatExpert" id="respNon" value="non" />
                                        </div>
                                        Non
                                    </button>
                                </div>
                            </div>

                            <!-- Si oui expert mandaté -->
                            <div id="sous-question-4-2-1"
                                <?= $questScript && $questScript->repSiMandatExpert == 'oui' ? '' : 'hidden' ?>>
                                <div class="question-box ">
                                    <div class="agent-icon">
                                        <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                    </div>
                                    <div class="question-content">
                                        <div class="question-text">
                                            <strong>Question <span name="numQuestionScript"></span>-b :</strong>
                                            <p class="text-justify">Est-ce que l'expert mandaté par votre assurance est
                                                déjà
                                                venu
                                                constater les dommages ?</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="response-options">
                                    <div class="options-container">
                                        <button onclick="selectRadio(this);showSousQuestion('4-2-1-1',true);"
                                            type="button" data-value="Oui" class="option-button btn btn-success">
                                            <div class="option-circle"><input type="radio" class="btn-check"
                                                    name="repSiExpertVenu" id="respOui" value="oui"
                                                    <?= checked('repSiExpertVenu', 'oui', $questScript, 'checked') ?> />
                                            </div>
                                            Oui
                                        </button>
                                        <button onclick="selectRadio(this);showSousQuestion('4-2-1-1',false);"
                                            type="button" data-value="Oui" class="option-button btn btn-danger">
                                            <div class="option-circle">
                                                <input type="radio" class="btn-check" name="repSiExpertVenu"
                                                    <?= checked('repSiExpertVenu', 'non', $questScript, 'checked') ?>
                                                    id="respNon" value="non" />
                                            </div>
                                            Non
                                        </button>
                                    </div>
                                </div>
                                <!-- Si oui constatExpert -->
                                <div id="sous-question-4-2-1-1"
                                    <?= $questScript && $questScript->repSiExpertVenu == 'oui' ? '' : 'hidden' ?>>
                                    <div class="question-box ">
                                        <div class="agent-icon">
                                            <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                        </div>
                                        <div class="question-content">
                                            <div class="question-text">
                                                <strong>Question <span name="numQuestionScript"></span>-c :</strong>
                                                <p class="text-justify">Est-ce que votre assurance vous a déjà proposé
                                                    une
                                                    indemnisation
                                                    pour couvrir les dommages matériels que vous avez subis ?</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="response-options">
                                        <div class="options-container">
                                            <button onclick="selectRadio(this);showSousQuestion('4-2-1-2',true);"
                                                type="button" data-value="Oui" class="option-button btn btn-success">
                                                <div class="option-circle"><input type="radio" class="btn-check"
                                                        name="repSiIndemProp" id="respOui" value="oui"
                                                        <?= checked('repSiIndemProp', 'oui', $questScript, 'checked') ?> />
                                                </div>
                                                Oui
                                            </button>
                                            <button onclick="selectRadio(this);showSousQuestion('4-2-1-2',false);"
                                                type="button" data-value="Oui" class="option-button btn btn-danger">
                                                <div class="option-circle">
                                                    <input type="radio" class="btn-check" name="repSiIndemProp"
                                                        <?= checked('repSiIndemProp', 'non', $questScript, 'checked') ?>
                                                        id="respNon" value="non" />
                                                </div>
                                                Non
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Si oui indemnisation -->
                                    <div id="sous-question-4-2-1-2"
                                        <?= $questScript && $questScript->repSiIndemProp == 'oui' ? '' : 'hidden' ?>>
                                        <div class="question-box ">
                                            <div class="agent-icon">
                                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent"
                                                    width="50">
                                            </div>
                                            <div class="question-content">
                                                <div class="question-text">
                                                    <strong>Question <span name="numQuestionScript"></span>-d :</strong>
                                                    <p class="text-justify">Avez-vous perçu l’indemnité ?</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="response-options">
                                            <div class="options-container">
                                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                                    class="option-button btn btn-success">
                                                    <div class="option-circle"><input type="radio" class="btn-check"
                                                            name="indemnisationRecu"
                                                            <?= checked('indemnisationRecu', 'oui', $questScript, 'checked') ?>
                                                            id="respOui" value="oui" /></div>
                                                    Oui
                                                </button>
                                                <button onclick="selectRadio(this)" type="button" data-value="Oui"
                                                    class="option-button btn btn-danger">
                                                    <div class="option-circle">
                                                        <input type="radio" class="btn-check"
                                                            <?= checked('indemnisationRecu', 'non', $questScript, 'checked') ?>
                                                            name="indemnisationRecu" id="respNon" value="non" />
                                                    </div>
                                                    Non
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Si Non expert mandaté -->
                            <div id="sous-question-4-2-2"
                                <?= $questScript && $questScript->repSiMandatExpert == 'non' ? '' : 'hidden' ?>>
                                <div class="question-box ">
                                    <div class="agent-icon">
                                        <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                    </div>
                                    <div class="question-content">
                                        <div class="question-text">
                                            <strong>Question <span name="numQuestionScript"></span>-b :</strong>
                                            <p class="text-justify">D'accord, nous allons pouvoir rapidement vous
                                                accompagner sur ce point afin de préparer au mieux votre dossier et
                                                défendre
                                                efficacement vos intérêts. Notre démarche consistera à contacter votre
                                                assureur pour vérifier l'état d'avancement de votre dossier, et si
                                                nécessaire, assurer votre représentation en cas d’expertise diligentée
                                                par
                                                votre compagnie.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SIGNATURE DELEGATION -->
                    <!-- Etape 9 : QUESTION DELEGATION-->
                    <div class="step">
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
                    <!-- Etape 10 : DELEGATION 1 -->
                    <div class="step">
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
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomSignataire"
                                            name="prenomSignataire"
                                            value="<?= $gerant ? $gerant->prenom : ($questScript ? $questScript->prenomSignataire : "") ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomSignataire" name="nomSignataire"
                                            value="<?= $gerant ? $gerant->nom : ($questScript ? $questScript->nomSignataire : "") ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Date Naissance <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="date" name="dateNaissanceSignataire"
                                            max="<?= date('Y-m-d', strtotime('18 years ago')) ?>" id="dateNaissance"
                                            value="<?= $gerant ? $gerant->dateNaissance : ($questScript ? $questScript->dateNaissanceSignataire : "") ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 11 : DELEGATION 2 : Adresse -->
                    <div class="step">
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

                    <!-- Etape 12 : DELEGATION 3 -->
                    <div class="step">
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

                    <!-- Etape 13 : DELEGATION 4 -->
                    <div class="step">
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
                            <?= "" ?>" onchange="onChangeDateDebutContrat()">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div>
                                            <label for="">Date Fin Contrat <small class="text-danger">*</small></label>
                                        </div>
                                        <div>
                                            <input class="form-control" type="date" name="dateFinContrat"
                                                id="dateFinContrat" value="<?= "" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 14 : DELEGATION 5 - Envoi Code -->
                    <div class="step">
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
                                            <input type="text" name="emailSign" id="emailSign" class="form-control"
                                                value="<?= $gerant ? $gerant->email : "" ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div>
                                            <label for="">Téléphone <small class="text-danger">*</small>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="text" name="telSign" id="telSign" class="form-control"
                                                value="<?= $gerant ? $gerant->tel : "" ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 15 : DELEGATION 6 - Confirm Code -->
                    <div class="step">
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
                    <!-- Etape 16 : DELEGATION 1 - Demander raison hesitation -->
                    <div class="step">
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

                    <!-- Étape 17 cloture Script -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>FIN DU SCRIPT :</strong>
                                    <p id="textCloture">
                                        Je vous remercie et vous souhaite une bonne fin de journée.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options" id="reponseDoc">
                            <div class="options-container">
                                <button
                                    onclick="selectRadio(this);showSousQuestion('17-1',true);showSousQuestion('17-2',false);"
                                    type="button" data-value="Oui" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check" name="siEnvoiDoc"
                                            <?= checked('siEnvoiDoc', 'oui', $questScript, 'checked') ?> value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button
                                    onclick="selectRadio(this);showSousQuestion('17-1',false);showSousQuestion('17-2',true);"
                                    type="button" data-value="Oui" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siEnvoiDoc" value="non"
                                            <?= checked('siEnvoiDoc', 'non', $questScript, 'checked') ?> />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>

                        <!-- Si Oui Envoi Documentation -->
                        <div id="sous-question-17-1" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content col-md-11">
                                    <div class="col-md-12 mb-3" id="divEnvoiDoc" hidden>
                                        <!-- INFOS MAIL -->
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
                                                <label for="">Prénom</label>
                                                <input type="text" class="form-control" name="prenomGerant"
                                                    ref="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
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
                                                <select readonly name="posteGerant" ref="posteGerant" id=""
                                                    class="form-control">
                                                    <option value="responsable">Responsable</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <p class="text-justify">Parfait, je vous adresse immédiatement notre
                                            documentation par mail. N'hésitez pas à nous recontacter en cas de besoin.
                                            Excellente journée ! <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="sous-question-17-2" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="question-text">
                                        <p class="text-justify">Très bien, je prends note. Nous restons disponibles si
                                            jamais vous avez besoin d'assistance à l'avenir. Je vous souhaite une
                                            agréable journée !<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PRISE DE RDV RT -->
                    <!-- Etape 18 : RT 1 -->
                    <div class="step">
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

                    <!-- Etape 19 : PRISE DE RDV RT-->
                    <div class="step">
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
                                    <div class="row mt-2" id="divTabHoraire">


                                    </div>
                                    <div class=" row mt-5 text-center">
                                        <h4 class="text-center font-weight-bold" id="INFO_RDV"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 20 : Plus de précisions -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify"> Bien sûr, je vous explique rapidement : SOS Sinistre est
                                        spécialisée dans
                                        l'accompagnement et la gestion des
                                        sinistres immobiliers comme les dégâts des eaux, les incendies ou les bris de
                                        glace,
                                        de manière
                                        totalement
                                        gratuite pour le sinistré. Nous intervenons de la déclaration à la réparation,
                                        sans
                                        avance de
                                        frais de votre
                                        part, en facilitant toutes les démarches administratives avec votre assurance et
                                        en
                                        faisant
                                        effectuer les
                                        travaux par des professionnels. Etes vous le responsable ?</p>
                                </div>
                            </div>

                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" name="confirmResponsable"
                                            class="btn-check" value="oui"
                                            <?= checked('confirmResponsable', 'oui', $questScript, 'checked') ?> />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="confirmResponsable"
                                            <?= checked('confirmResponsable', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 21 : Non pas responsable -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Serait-il possible de me mettre en relation avec le
                                        responsable
                                        ?
                                        J'ai une information importante concernant la gestion des sinistres immobiliers
                                        qui
                                        pourrait l'intéresser directement.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" name="dispoResp" value="dispo"
                                            <?= checked('dispoResp', 'dispo', $questScript, 'checked') ?>
                                            class="btn-check">
                                    </div>
                                    Responsable Dispo
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="dispoResp" value="indispo" class="btn-check"
                                            <?= checked('dispoResp', 'indispo', $questScript, 'checked') ?> />
                                    </div>
                                    Responsable Indispo
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="dispoResp" value="refus" class="btn-check"
                                            <?= checked('dispoResp', 'refus', $questScript, 'checked') ?> />
                                    </div>
                                    Refus Transfert
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 22  : SI Sinistre -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Très bien, puisque le responsable n’est pas disponible pour
                                        le
                                        moment, nous allons donc poursuivre ensemble. Justement, pourriez-vous me dire
                                        si
                                        votre établissement subit actuellement un sinistre ? Est-ce un sujet dont vous
                                        avez
                                        connaissance ou dont vous pourriez me parler directement ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="reponse_concerne2" value="oui" ref="reponse_concerne2"
                                            <?= checked('reponse_concerne2', 'oui', $questScript, 'checked') ?> /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="reponse_concerne2"
                                            ref="reponse_concerne2"
                                            <?= checked('reponse_concerne2', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 23 Si Responsable Sinistre -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Comme je ne pourrai pas être mis en relation avec le
                                        responsable, savez-vous s'il
                                        actuellement un sinistre en cours dans votre établissement ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="siSinistreEnCours" value="oui"
                                            <?= checked('siSinistreEnCours', 'oui', $questScript, 'checked') ?> /></div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('siSinistreEnCours', 'je ne sais pas', $questScript, 'checked') ?>
                                            name="siSinistreEnCours" value="je ne sais pas" />
                                    </div>
                                    Je ne sais pas
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check"
                                            <?= checked('siSinistreEnCours', 'non', $questScript, 'checked') ?>
                                            name="siSinistreEnCours" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 24: Si Coordonnées Responsable -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Je comprends tout à fait. Afin de clarifier ce point
                                        directement
                                        avec votre responsable, je vous propose d'organiser ensemble un bref entretien
                                        téléphonique. Pourriez-vous me transmettre ses coordonnées afin de fixer ce
                                        rendez-vous à un moment qui lui conviendra ? </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="siRvTelResponsable" value="oui"
                                            <?= checked('siRvTelResponsable', 'oui', $questScript, 'checked') ?> />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siRvTelResponsable"
                                            value="refusAvecDoc"
                                            <?= checked('siRvTelResponsable', 'refusAvecDoc', $questScript, 'checked') ?> />
                                    </div>
                                    Refus, avec Envoi Documentation
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siRvTelResponsable"
                                            value="refusSansDoc"
                                            <?= checked('siRvTelResponsable', 'refusSansDoc', $questScript, 'checked') ?> />
                                    </div>
                                    Refus, sans Envoi Documentation
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 25 Form Interlocuteur -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Avant de poursuivre, je vais simplement noter vos
                                        coordonnées
                                        afin que nous puissions rester facilement en contact et vous tenir informé(e) de
                                        l’évolution de votre dossier. Pourriez-vous me préciser votre nom, prénom,
                                        fonction
                                        ou poste dans l'établissement, numéro de téléphone direct et adresse email, s’il
                                        vous plaît ?</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body col-md-11" style="margin-left: 95px; margin-bottom: 10px;">
                            <input type="hidden" class="form-control" name="idInterlocuteur" value="0">
                            <input type="hidden" class="form-control" name="idCompanyInterlocuteur"
                                value="<?= $company ? $company->idCompany : '0' ?>">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Civilité</label>
                                    <select name="civiliteInterlocuteur" id="" class="form-control">
                                        <option value="">....</option>
                                        <option value="Monsieur">Monsieur</option>
                                        <option value="Madame">Madame</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prénom</label>
                                    <input type="text" class="form-control" name="prenomInterlocuteur" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nom</label>
                                    <input type="text" class="form-control" name="nomInterlocuteur" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="emailInterlocuteur" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Téléphone</label>
                                    <input type="text" class="form-control" name="telInterlocuteur" value="">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Poste</label>
                                    <select name="posteInterlocuteur" id="" class="form-control">
                                        <option value="">...</option>
                                        <option value="gérant">Gérant</option>
                                        <option value="secretaire">Secretaire</option>
                                        <option value="Directeur Technique">Directeur Technique</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 26 Demande Si interlocuteur habile  -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">Afin que nous puissions intervenir efficacement et
                                        gratuitement dans la gestion complète de votre sinistre auprès de votre
                                        assurance, nous allons devoir valider ensemble une délégation. Cette délégation
                                        nous permet simplement de vous représenter officiellement auprès de votre
                                        assureur pour défendre vos intérêts, sans frais et sans aucun engagement
                                        financier de votre part.<br>
                                        Êtes-vous personnellement habilité(e) à valider cette délégation au nom de votre
                                        établissement ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" class="btn-check"
                                            name="reponse_sihabile_signature" value="oui"
                                            <?= checked('reponse_sihabile_signature', 'oui', $questScript, 'checked') ?> />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-info">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="reponse_sihabile_signature"
                                            <?= checked('reponse_sihabile_signature', 'ouiResponsable', $questScript, 'checked') ?>
                                            value="ouiResponsable" />
                                    </div>
                                    Oui avec Consultation
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="reponse_sihabile_signature"
                                            <?= checked('reponse_sihabile_signature', 'refus', $questScript, 'checked') ?>
                                            value="refus" />
                                    </div>
                                    Habilité mais Refus
                                </button>
                                <button onclick="selectRadio(this)" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="reponse_sihabile_signature"
                                            <?= checked('reponse_sihabile_signature', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 27 PROGRAMMER RDV PERSO -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textPropositionHesitationSignature">Demande des
                                        raisons précises</p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <button onclick="selectRadio(this);showSousQuestion('16-1',true);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" name="siRdvPerso" value="oui"
                                            <?= checked('siRdvPerso', 'oui', $questScript, 'checked') ?>
                                            class="btn-check">
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);showSousQuestion('16-1',false);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="siRdvPerso" value="non" class="btn-check"
                                            <?= checked('siRdvPerso', 'non', $questScript, 'checked') ?> />
                                    </div>
                                    Non
                                </button>

                                <!-- SI OUI RDV PERSO -->
                                <div class="row col-md-12 ml-0" id="sous-question-16-1" hidden>
                                    PRENDRE COORDONNES UN RDV PERSO TELEPHONIQUE POUR REPRENDRE LA CONVERSATION PLUS
                                    TARD
                                    <div class="col-md-12 mb-3">
                                        <!-- INFOS MAIL -->
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-4">
                                                <label for="">Civilité</label>
                                                <select ref="civiliteGerant" name="civiliteGerant" id=""
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
                                                <label for="">Prénom</label>
                                                <input type="text" class="form-control" name="prenomGerant"
                                                    ref="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
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
                                                <select readonly name="posteGerant" ref="posteGerant" id=""
                                                    class="form-control">
                                                    <option value="responsable">Responsable</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Etape 28: Si Coordonnées Responsable -->
                    <div class="step">
                        <div class="question-box">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textCoordonneesResponsable">Très bien, je vais noter les
                                        coordonnées complètes de votre responsable pour fixer ce rendez-vous.
                                        Pouvez-vous me donner son nom, prénom, sa fonction exacte dans l’établissement,
                                        son numéro de téléphone direct ainsi que son adresse email, s’il vous plaît ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row mt-2">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité</label>
                                        <select name="civiliteGerant" id="" class="form-control">
                                            <option value="">....</option>
                                            <option <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                                value="Monsieur">Monsieur</option>
                                            <option <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                                value="Madame">Madame</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom</label>
                                        <input type="text" class="form-control" name="prenomGerant"
                                            value="<?= $gerant ? $gerant->prenom : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom</label>
                                        <input type="text" class="form-control" name="nomGerant"
                                            value="<?= $gerant ? $gerant->nom : '' ?>">
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="form-group col-md-4">
                                        <label for="">Email</label>
                                        <input type="email" class="form-control" name="emailGerant"
                                            value="<?= $gerant ? $gerant->email : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone</label>
                                        <input type="text" class="form-control" name="telGerant"
                                            value="<?= $gerant ? $gerant->tel : '' ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste</label>
                                        <select readonly name="posteGerant" id="" class="form-control">
                                            <option value="Responsable">Responsable</option>
                                            <option value="Gérant">Gérant</option>
                                            <option value="Dirigeant">Dirigeant</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                PRISE DE RDV PERSO POUR LE RESPONSABLE
                            </div>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <div class="buttons">
                        <button id="prevBtn" type="button" class="btn-prev hidden" onclick="goBackScript()">⬅
                            Précédent</button>
                        <label for="">Page <span id="indexPage" class="font-weight-bold"></span></label>
                        <button id="nextBtn" type="button" class="btn-next" onclick="goNext()">Suivant ➡</button>
                        <button id="finishBtn" type="button" class="btn-finish hidden" onclick="finish()">✅
                            Terminer</button>
                    </div>
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


//ASSISTANT TE
let numPageTE = 0;
let nbPageTE = 4;

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
                console.log(response);
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
    objetMail =
        `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    bodyMail = `<p style="text-align:justify">${`<?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?>`}<br><br>
                    Merci pour notre échange très agréable d'aujourd'hui.<br><br>
                    Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d’assurance, en nous occupant de tout, de A à Z.<br><br>
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
                    <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d’esprit.<br><br>
                    
                    Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
                    À très bientôt,<br><br>
                    Bien cordialement,<br><br>
                     ${`<?php SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`}
                                            `;

    $('#objetMailEnvoiDoc').val(objetMail)
    $('#signatureMail').val(`<?php SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`)
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
    nextBtn.classList.toggle("hidden", currentStep == 17);
    // finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1 && currentStep != 7);
    finishBtn.classList.toggle("hidden", currentStep != 17);

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

function goBackScript() {
    if (history.length === 0) return;
    pageIndex--;
    steps[currentStep].classList.remove("active");
    currentStep = history.pop();
    steps[currentStep].classList.add("active");
    updateButtons();
}


function goNext() {
    // logiques conditionnelles selon étape
    if (document.querySelector('input[name="siTravaux"]:checked') != null && document.querySelector(
            'input[name="siTravaux"]:checked').value == "oui") {
        document.getElementById('textCloture').innerHTML =
            "Merci pour ces précisions. Dans la mesure où vos travaux ont déjà été réalisés, nous ne pouvons malheureusement plus intervenir gratuitement sur votre dossier. Toutefois, souhaitez-vous recevoir notre documentation afin de conserver nos coordonnées pour toute éventuelle assistance future ?";
        $("#reponseDoc").removeAttr("hidden");
        $("#divEnvoiDoc").removeAttr("hidden");

    } else {

        $('#reponseDoc').attr("hidden", "hidden");
        $('#divEnvoiDoc').attr("hidden", "hidden");
    }
    $("#sous-question-17-2").attr("hidden", "hidden");
    $("#sous-question-17-1").attr("hidden", "hidden");
    if (currentStep === 0) {
        const val = document.querySelector('input[name="responsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            siInterlocuteur = false;
            return showStep(1);
        } else {
            siInterlocuteur = true;
            if (val.value == "hesite") return showStep(20);
            if (val.value == "non") return showStep(21);
        }

    }

    if (currentStep == 1) {
        const val = document.querySelector('input[name="reponse_concerne"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            return showStep(2);
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email  pour vous envoyer une documentation  ?";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep === 2) {
        const val = document.querySelector('#typeSinistre');
        if (val.value == "") {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value != "") return showStep(3);
    }

    if (currentStep === 3) {
        const val = document.querySelector('input[name="siTravaux"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") {
            document.querySelector('input[name="siEnvoiDoc"]:checked').value = 'oui'
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value == "non") {
            if (siInterlocuteur) {
                return showStep(25);
            } else {
                return showStep(4);
            }

        }
    }

    if (currentStep === 8) {
        if (siInterlocuteur) {
            //HABILITE INTERLOCUTEUR
            return showStep(26);
        } else {
            return showStep(9);
        }

    }

    if (currentStep === 9) {
        const val = document.querySelector('input[name="siSignDeleg"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value == "oui") return showStep(10);
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends que vous ne voulez pas signer de délégation. (RDV A PROGRAMMER POUR UN SUPERVISEUR) Puis-je avoir votre email  pour vous envoyer une documentation ?";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value == "plusTard") return showStep(16);
    }

    if (currentStep === 10) {
        if ($("#prenomSignataire").val() == "" || $("#nomSignataire").val() == "" || $("#dateNaissance").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 11) {
        if ($("#adresseImm").val() == "" || $("#cP").val() == "" || $("#ville").val() == "" || $("#etage").val() ==
            "" || $("#porte").val() == "") {
            $("#msgError").text("Veuillez compléter les informations obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 12) {
        if ($("#nomCie").val() == "") {
            $("#msgError").text("Veuillez renseigner la compagnie d'assurance !");
            $('#errorOperation').modal('show');
            return;
        }
    }

    if (currentStep === 13) {
        if ($("#numPolice").val() == "" || $("#dateDebutContrat").val() == "" || $("#dateFinContrat").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;

        }
    }

    if (currentStep == 14) {
        if ($("#emailSign").val() == "" || $("#telSign").val() == "") {
            $("#msgError").text("Veuillez compléter les obligatoires pour la délégation !");
            $('#errorOperation').modal('show');
            return;
        } else {
            //Envoyer Code pour signature
            // onClickTerminerAssistant();
        }

    }

    if (currentStep === 15) {
        // onClickValidSignature();
        return showStep(18)
    }

    if (currentStep === 16) {
        const val = document.querySelector('input[name="raisonRefusSignature"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }

        if (val.value == "prefereDemander") {
            $(`#textPropositionHesitationSignature`).text(
                "Je comprends tout à fait votre démarche. Je vais vous envoyer dès maintenant la délégation et notre documentation par mail pour que vous puissiez les présenter clairement à votre interlocuteur. Nous fixerons ensuite un rendez-vous pour finaliser ensemble, une fois votre échange réalisé"
            );
        } else {
            if (val.value == "documentManquant") {
                $(`#textPropositionHesitationSignature`).text(
                    "Oui effectivement, je note bien que certains documents vous manquent, c’est tout à fait fréquent. Je vous envoie immédiatement un mail récapitulatif très précis des éléments à préparer. Ainsi, lors de notre prochain échange, tout sera prêt pour finaliser simplement et rapidement."
                );
            } else {
                if (val.value == "signatureComplique") {
                    $(`#textPropositionHesitationSignature`).text(
                        "Je comprends parfaitement. Soyez rassuré(e), c’est très simple et sécurisé. Je vais vous envoyer immédiatement par mail un petit guide très clair qui détaille chaque étape, et nous pourrons également finaliser ensemble par téléphone lors de notre prochain rendez-vous. "
                    );
                } else {
                    if (val.value == "prendreConnaissance") {
                        $(`#textPropositionHesitationSignature`).text(
                            "C'est tout à fait normal et même recommandé. Je vous propose de vous envoyer immédiatement la délégation par mail accompagnée d’une courte présentation de nos services pour que vous puissiez en prendre connaissance tranquillement. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour finaliser ensemble, en toute sérénité."
                        );
                    } else {

                    }
                }
            }
        }
        document.querySelector('input[name="siEnvoiDoc"]:checked').value = 'oui'
        $('#sous-question-17-1').removeAttr("hidden");
        $("#reponseDoc").removeAttr("hidden");
        $("#divEnvoiDoc").removeAttr("hidden");
        return showStep(27);
    }

    if (currentStep === 18) {
        const val = document.querySelector('input[name="accordRVRT"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            this.getDisponiblites();
            return showStep(19);
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends votre hésitation. Sachez simplement que le relevé technique réalisé par notre expert permet très souvent d'accélérer le traitement par votre assureur et facilite l'indemnisation rapide. Toutefois, je respecte votre décision et vous envoie immédiatement notre documentation par mail.<br>N'hésitez pas à revenir vers nous à tout moment si vous souhaitez avancer ensemble. Très bonne journée à vous !";
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep === 19) {
        document.getElementById('textCloture').innerHTML =
            "Je vous remercie et vous souhaite une bonne fin de journée !";
        return showStep(17)
    }

    if (currentStep === 20) {
        const val = document.querySelector('input[name="confirmResponsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }

        if (val.value === "oui") {
            siInterlocuteur = false;
            return showStep(1);
        }

        if (val.value === "non") {
            siInterlocuteur = true;
            return showStep(21);
        }
    }

    if (currentStep === 21) {
        const val = document.querySelector('input[name="dispoResp"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "dispo") {
            return showStep(1);
            siInterlocuteur = false;
        } else {
            siInterlocuteur = true;
            if (val.value === "indispo") return showStep(22);
            if (val.value === "refus") return showStep(23);
        }
    }

    if (currentStep == 22) {
        const val = document.querySelector('input[name="reponse_concerne2"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(2);
        if (val.value === "non") {
            document.querySelector('input[name="siEnvoiDoc"]:checked').value = 'oui'
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email professionnel pour vous envoyer une documentation que vous pourriez transmettre au responsable ?";;
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
    }

    if (currentStep == 23) {
        const val = document.querySelector('input[name="siSinistreEnCours"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(2);
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends qu'il n'y a pas de sinistre actuellement. Puis-je avoir votre email professionnel pour vous envoyer une documentation que vous pourriez transmettre au responsable ?";
            $('#sous-question-17-1').removeAttr("hidden");
            $("#reponseDoc").removeAttr("hidden");
            $("#divEnvoiDoc").removeAttr("hidden");
            return showStep(17);
        }
        if (val.value === "je ne sais pas") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Très bien, je vais noter les coordonnées complètes de votre responsable pour fixer ce rendez-vous.<br>Pouvez-vous me donner son nom, prénom, sa fonction exacte dans l’établissement, son numéro de téléphone direct ainsi que son adresse email, s’il vous plaît ?";
            return showStep(24);
        }
    }

    if (currentStep == 24) {
        const val = document.querySelector('input[name="siRvTelResponsable"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        $('#reponseDoc').attr("hidden", "hidden");
        if (val.value === "oui") {
            document.getElementById('textCloture').innerHTML =
                "Parfait, je vous remercie. Le rendez-vous téléphonique est confirmé. Je vous adresse dès maintenant notre documentation complète par mail afin qu’il puisse en prendre connaissance avant notre échange. Merci beaucoup pour votre aide et excellente journée ! ";
            return showStep(28);
        }
        if (val.value === "refusAvecDoc") {
            document.getElementById('textCloture').innerHTML =
                "Très bien, je comprends votre décision. Je vous envoie tout de même notre documentation complète par mail afin que vous puissiez la transmettre à votre responsable pour une consultation ultérieure. Nous restons à votre disposition si besoin.";
            $('#sous-question-17-1').removeAttr("hidden");
            $('#divEnvoiDoc').removeAttr("hidden");
            return showStep(17);
        }
        if (val.value === "refusSansDoc") {
            document.getElementById('textCloture').innerHTML =
                "Je comprends et respecte votre choix. Sachez toutefois que nous restons entièrement à votre écoute si vous souhaitez nous recontacter à l’avenir. Je vous remercie pour votre disponibilité et vous souhaite une agréable journée !";
            return showStep(17);
        }

    }

    if (currentStep == 25) {
        return showStep(4)
    }


    if (currentStep == 26) {
        const val = document.querySelector('input[name="reponse_sihabile_signature"]:checked');
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") return showStep(9);
        if (val.value === "non") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Je comprends votre souhait de transférer la décision à votre responsable. Seriez-vous d’accord pour que nous prenions dès maintenant un rendez-vous téléphonique avec lui ? Cela me permettra de lui présenter directement et clairement les bénéfices de notre accompagnement gratuit. ";
            return showStep(24);
        }
        if (val.value === "ouiResponsable") {
            $(`#textPropositionHesitationSignature`).text(
                "Je comprends tout à fait votre démarche. Afin que vous puissiez facilement présenter cette délégation à votre responsable, je vous propose de vous l’envoyer immédiatement par mail accompagnée d’une courte présentation de nos services. Je vous propose également de fixer dès maintenant un rendez-vous téléphonique pour que nous puissions, après votre échange avec votre responsable, finaliser cette validation ensemble."
            );
            return showStep(27)

        };
        if (val.value === "refus") {
            document.getElementById('textCoordonneesResponsable').innerHTML =
                "Je comprends votre souhait de transférer la décision à votre responsable. Seriez-vous d’accord pour que nous prenions dès maintenant un rendez-vous téléphonique avec lui ? Cela me permettra de lui présenter directement et clairement les bénéfices de notre accompagnement gratuit. ";
            return showStep(24);
        };
    }

    if (currentStep === 27) {
        const val = document.querySelector('input[name="siRdvPerso"]:checked');
        $('#reponseDoc').attr("hidden", "hidden");
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        if (!val) {
            $("#msgError").text("Veuillez sélectionner une réponse !");
            $('#errorOperation').modal('show');
            return;
        }
        if (val.value === "oui") {
            document.getElementById('textCloture').innerHTML =
                "Parfait, je vous remercie beaucoup pour votre temps et votre confiance. Vous recevrez immédiatement un mail récapitulatif de notre entretien et de notre prochain rendez-vous téléphonique. <br>Nous restons à votre disposition si besoin. Merci de votre accueil et excellente journée ! ";
        }
        if (val.value === "non") {
            document.getElementById('textCloture').innerHTML =
                "Très bien, je comprends votre décision. Je vous envoie donc notre documentation complète accompagnée de la délégation de gestion par mail afin que vous puissiez la transmettre à votre responsable pour une consultation ultérieure. Nous restons à votre disposition si besoin. Merci de votre accueil et excellente journée ! ";
        }
        return showStep(17);
    }

    if (currentStep === 28) {
        $('#divEnvoiDoc').attr("hidden", "hidden");
        $('#sous-question-17-1').attr("hidden", "hidden");
        $('#reponseDoc').attr("hidden", "hidden");
        document.getElementById('textCloture').innerHTML =
            "Parfait, je vous remercie. Le rendez-vous téléphonique avec votre responsable est confirmé. Je vous adresse dès maintenant notre documentation complète par mail afin qu’il puisse en prendre connaissance avant notre échange. Merci beaucoup pour votre aide et excellente journée !";
        return showStep(17);
    }

    if (currentStep < steps.length - 1) {
        showStep(currentStep + 1);
    }
}


function saveScriptPartiel(etape) {
    // getInfoMail()
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
            console.log("success");
            console.log(response);

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
            console.log(response);
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
                    console.log("success");
                    console.log(response);
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
        adresseRV: $('#adresseImm').val(),
        codePostal: $('#cP').val(),
        ville: "",
        batiment: "",
        etage: "",
        libelleRV: "",
        dateRV: "<?= "" ?>",
        heureRV: "<?= "" ?>",
        source: "wbcc"
    }
    $.ajax({
        // url: `<?= URLROOT ?>/public/json/disponibilite.php?action=getDisponibilitesExpert`,
        url: `<?= URLROOT_GESTION_WBCC_CB ?>/public/json/evenement.php?action=getDisponibilitesExpert`,
        type: 'POST',
        data: JSON.stringify(post),
        dataType: "JSON",
        beforeSend: function() {
            $('#divChargementNotDisponibilite').attr("hidden", "hidden");
            $('#divChargementDisponibilite').removeAttr("hidden");
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
                    afficheBy10InTable();
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