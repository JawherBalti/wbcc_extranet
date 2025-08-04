<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;
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


<div class=" col-12">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">

            <div
                style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px;     background-color: #fff; text-align: center;">
                <h2><span><i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i></span> Campagne formation B2B
                    CABINET BRUNO -
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/logo_Cabinet_Bruno.png" alt="">
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

                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez formel et professionnel dès les premières secondes, car il
                                                    s’agit d’un appel B2B. <br><br></li>
                                                <li>• Validez clairement que vous vous adressez au bon décideur pour
                                                    éviter toute perte de temps. <br><br></li>
                                                <li>• Si ce n’est pas la bonne personne, demandez poliment les
                                                    coordonnées du responsable approprié.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Bonjour, je suis <b><?= $connectedUser->fullName   ?></b>, chargé(e) de
                                        partenariats pour le <b>Cabinet Bruno</b>. <br>
                                        Puis-je parler
                                        <?= $gerant ? "à <b style='color: blue;'>$gerant->prenomContact $gerant->nomContact</b>," : "au" ?>
                                        responsable des partenariats ou des relations commerciales
                                        chez <b><?= $company->name ?></b> ?
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickResponsable('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);  onClickResponsable('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
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
                                                <?= $gerant && ($gerant->civiliteContact == 'Mme' || $gerant->civiliteContact == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= $gerant && ($gerant->civiliteContact == 'M' || $gerant->civiliteContact == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="prenomResponsable"
                                            value="<?= $gerant ? $gerant->prenomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomResponsable"
                                            name="nomResponsable" value="<?= $gerant ? $gerant->nomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleResponsable"
                                            value="<?= $gerant ? $gerant->jobTitle : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telResponsable"
                                            name="telResponsable" value="<?= $gerant ? $gerant->telContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailResponsable"
                                            name="emailResponsable"
                                            value="<?= $gerant ? $gerant->emailContact : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 1 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez clair et précis, en rappelant succinctement l'activité du
                                                    Cabinet Bruno.<br><br></li>
                                                <li>• Mettez en avant la spécialisation en copropriété pour
                                                    immédiatement situer l’intérêt potentiel pour le prospect
                                                    entreprise.<br><br></li>
                                                <li>• Évitez toute improvisation inutile; allez directement au contexte
                                                    de l’appel.<br><br></li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <p class="text-justify">
                                        Le <b>Cabinet Bruno</b> est une entreprise spécialisée dans la gestion
                                        immobilière , et
                                        particulièrement dans la gestion et l'administration des copropriétés. <br>
                                        Je vous appelle aujourd’hui dans le cadre d’une proposition de partenariat
                                        mutuellement bénéfique entre
                                        nos deux sociétés.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 2 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez clair, direct et enthousiaste en expliquant brièvement le
                                                    partenariat.<br><br></li>
                                                <li>• Insistez sur l’aspect « gagnant-gagnant » dès le départ pour
                                                    susciter un intérêt rapide du prospect.<br><br></li>
                                                <li>• Soyez attentif aux premières réactions afin d’orienter la suite de
                                                    la conversation efficacement.<br><br></li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <p>
                                        Concrètement, nous souhaitons vous proposer un <b>partenariat de prescription
                                            mutuelle</b>
                                        où nous pourrions réciproquement recommander nos services à nos clients
                                        respectifs, afin de
                                        créer ensemble de nouvelles opportunités commerciales avantageuses pour nos deux
                                        entreprises.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Étape 3 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez clairement le lien direct et concret entre les activités
                                                    des deux sociétés.<br><br></li>
                                                <li>• Montrez immédiatement la pertinence d’un partenariat pratique et
                                                    complémentaire.<br><br></li>
                                                <li>• Observez attentivement la réaction de votre interlocuteur, qui
                                                    sera déterminante pour la suite de l’appel.<br><br></li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Nous gérons actuellement un grand nombre d’immeubles et de copropriétés qui ont
                                        très
                                        régulièrement besoin de services tels que ceux que vous proposez
                                        <b><?= $company ? $company->industry : '' ?></b>. <br>
                                        Je suis convaincu(e) qu’un partenariat entre nos sociétés
                                        pourrait être extrêmement bénéfique, à la fois pour nos clients respectifs et
                                        pour développer
                                        ensemble nos activités.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 4 -->
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
                                                <li>• Soyez bref, courtois et professionnel dans votre demande.<br><br>
                                                </li>
                                                <li>• Si le responsable n'est pas disponible immédiatement, proposez
                                                    clairement et simplement une autre plage horaire.<br><br></li>
                                                <li>• Soyez flexible et arrangeant pour faciliter la prise d’un
                                                    rendez-vous ultérieur.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Auriez-vous quelques minutes à m’accorder maintenant pour que je vous présente
                                        rapidement
                                        cette opportunité, ou préférez-vous que nous fixions un rendez-vous téléphonique
                                        à un autre
                                        moment qui vous conviendrait mieux ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiDsiponible('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" <?= '' //checked('siDsiponible', 'oui', $questScript, 'checked') 
                                                                                    ?> class="btn-check"
                                            name="siDsiponible" value="oui" />
                                    </div>
                                    Disponible maintenant
                                </button>
                                <button onclick="selectRadio(this); onClickSiDsiponible('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siDsiponible" <?= '' //checked('siDsiponible', 'non', $questScript, 'checked') 
                                                                                                    ?> value="non" />
                                    </div>
                                    Rendez-vous ultérieur
                                </button>
                            </div>
                        </div>

                        <div class="response-options" id="div-prise-rdv" hidden></div>
                    </div>

                    <!-- Etape 5 :  -->
                    <div class="step">
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

                    <!-- Etape 6 : origine -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Vérifiez précisément et rapidement l’activité réelle de
                                                    l’entreprise pour assurer la pertinence du partenariat
                                                    proposé.<br><br></li>
                                                <li>• Demandez clairement la zone géographique couverte afin de cibler
                                                    précisément le potentiel de partenariat.<br><br></li>
                                                <li>• Soyez concis et précis, sans donner l’impression de questionner
                                                    trop longuement.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour nous assurer de la pertinence de notre proposition, pourriez-vous me
                                        confirmer
                                        rapidement que votre entreprise est bien spécialisée en
                                        <b><?= $company ? $company->industry : '' ?></b> ? <br>
                                        Quelle est précisément votre zone d’intervention géographique habituelle ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <label for="" style="font-weight: bold;">A- Activités:</label>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input type="radio" name="activiteRadio" id="checkGardiennage"
                                                    value="Gardiennage" onclick="functionActivite(this.value);">
                                                🛡️ gardiennage
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input type="radio" name="activiteRadio" id="checkNettoyage"
                                                    value="Nettoyage" onclick="functionActivite(this.value);">
                                                🧹 Nettoyage
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-radio">
                                                <input type="radio" name="activiteRadio" id="checkMaintenance"
                                                    value="Maintenance" onclick="functionActivite(this.value);">
                                                🛠️ Maintenance
                                                <span class="checkmark-radio"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="container-radio">
                                                <input type="radio" name="activiteRadio" id="checkAutre" value="Autres"
                                                    onclick="functionActivite(this.value);">
                                                Autres
                                                <span class="checkmark-radio"></span>
                                            </label>
                                            <input type="text" class="form-control" id="autreActivite"
                                                name="autreActivite" placeholder="Saisir..." hidden value="">
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

                    <!-- Etape 7 : origine -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Demandez cette information clairement mais de façon détendue pour
                                                    éviter toute réticence.<br><br></li>
                                                <li>• Si l’entreprise a déjà des partenariats, obtenez rapidement des
                                                    précisions sans insister lourdement.<br><br></li>
                                                <li>• Cette information vous permettra de mieux positionner votre
                                                    proposition dans la suite de l’appel.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Actuellement, avez-vous déjà mis en place des partenariats avec des acteurs du
                                        secteur
                                        immobilier tels que des syndics ou des agences, ou disposez-vous de canaux de
                                        recommandation spécifiques dans ce domaine ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiExistePartenaire('non');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siExistePartenaire"
                                            <?= checked('siExistePartenaire', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non, aucun partenariat
                                </button>
                                <button onclick="selectRadio(this); onClickSiExistePartenaire('oui');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siExistePartenaire', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siExistePartenaire" value="oui" />
                                    </div>
                                    Oui, partenariats existants
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- Etape 8 : -->
                    <!--  Objection : « Nous avons déjà des partenaires syndic/agence » -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez clairement les différenciants du Cabinet Bruno pour
                                                    rassurer le prospect sur la complémentarité possible avec ses
                                                    partenariats existants.<br><br></li>
                                                <li>• Proposez spontanément un test sans engagement pour faciliter la
                                                    prise de décision du partenaire<br><br></li>
                                                <li>• Soyez diplomate, rassurant et professionnel afin de lever cette
                                                    objection efficacement.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
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
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siExistePartenaireRep', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siExistePartenaireRep" value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siExistePartenaireRep"
                                            <?= checked('siExistePartenaireRep', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 9 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Posez cette question simplement pour évaluer directement l’intérêt
                                                    réel du prospect.<br><br></li>
                                                <li>• Soyez attentif à la réponse, car elle déterminera la suite de la
                                                    conversation.<br><br></li>
                                                <li>• Notez rapidement les éléments importants exprimés par
                                                    l’interlocuteur pour adapter précisément la proposition qui suivra.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Seriez-vous ouvert(e) à l’idée de recommander un syndic ou un gestionnaire
                                        immobilier tel que
                                        le Cabinet Bruno à vos clients ou contacts, moyennant bien entendu des avantages
                                        réciproques
                                        concrets ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiRecommenderCb('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siRecommenderCb', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siRecommenderCb" value="oui" />
                                    </div>
                                    Intéressé(e)
                                </button>
                                <button onclick="selectRadio(this); onClickSiRecommenderCb('objection');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siRecommenderCb"
                                            <?= checked('siRecommenderCb', 'objection', $questScript, 'checked') ?>
                                            value="objection" />
                                    </div>
                                    Objection
                                </button>
                                <button onclick="selectRadio(this); onClickSiRecommenderCb('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siRecommenderCb"
                                            <?= checked('siRecommenderCb', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non intéressé(e)
                                </button>
                            </div>
                        </div>



                        <div class="response-options" id="div-objections" hidden>
                            <div class="options-container">
                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <hr>
                                    <button onclick="selectRadio(this); onClickObjectionRecommanderCb(1);" type="button"
                                        class="option-button btn btn-warning">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="objectionRecommanderCb"
                                                <?= checked('objectionRecommanderCb', 'Quel avantage concret pour nous ?', $questScript, 'checked') ?>
                                                value="Quel avantage concret pour nous ?" />
                                        </div>
                                        Quel avantage concret pour nous ?
                                    </button>
                                    <br>
                                    <button onclick="selectRadio(this); onClickObjectionRecommanderCb(2);" type="button"
                                        class="option-button btn btn-warning">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="objectionRecommanderCb"
                                                <?= checked('objectionRecommanderCb', 'Nous n’avons pas le temps de nous en occuper.', $questScript, 'checked') ?>
                                                value="Nous n’avons pas le temps de nous en occuper." />
                                        </div>
                                        Nous n’avons pas le temps de nous en occuper.
                                    </button>
                                    <br>
                                    <button onclick="selectRadio(this); onClickObjectionRecommanderCb(3);" type="button"
                                        class="option-button btn btn-warning">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="objectionRecommanderCb"
                                                <?= checked('objectionRecommanderCb', 'Méfiance ou inconnu.', $questScript, 'checked') ?>
                                                value="Méfiance ou inconnu." />
                                        </div>
                                        Méfiance ou inconnu.
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Intéressé(e) -->
                        <div class="response-options" id="sous-question-7"
                            <?= $questScript && isset($questScript->siRecommenderCb) && $questScript->siRecommenderCb == 'oui' ? "" : "hidden"; ?>>
                            <div class="options-container">
                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <label class="font-weight-bold">Attentes ou Conditions:</label>
                                    <textarea name="" id="" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>


                        <div id="objection-1" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="tooltip-container btn btn-sm btn-info float-right">
                                        🧠 Consignes
                                        <div class="tooltip-content">
                                            <b>
                                                <ul>
                                                    <li>• Expliquez brièvement et clairement les avantages financiers
                                                        directs et les bénéfices indirects du partenariat.<br><br></li>
                                                    <li>• Valorisez fortement le double avantage (commission + échanges
                                                        de clients potentiels).<br><br></li>
                                                    <li>• Soyez attentif aux demandes de précisions pour adapter
                                                        précisément vos réponses suivantes.</li>
                                                </ul>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>.1 :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            L’avantage concret pour vous est double : tout d'abord, vous percevez une <b
                                                style="color: green;">commission directe</b> 💡
                                            pour chaque nouveau client recommandé signant un mandat avec nous. Ensuite,
                                            nous
                                            pratiquons systématiquement des <b style="color: green;">renvois
                                                d’ascenseur</b> 💡 en orientant activement nos
                                            copropriétaires et clients vers vos propres services dès qu’un besoin
                                            pertinent est détecté. Cette
                                            complémentarité crée ainsi des bénéfices financiers directs et des
                                            opportunités commerciales
                                            accrues pour votre entreprise.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio"
                                                <?= checked('siAccepteSuiteQuelAvantage', 'oui', $questScript, 'checked') ?>
                                                class="btn-check" name="siAccepteSuiteQuelAvantage" value="oui" />
                                        </div>
                                        Accepte le partenariat
                                    </button>
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="siAccepteSuiteQuelAvantage"
                                                <?= checked('siAccepteSuiteQuelAvantage', 'non', $questScript, 'checked') ?>
                                                value="non" />
                                        </div>
                                        Refuse le partenariat
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div id="objection-2" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="tooltip-container btn btn-sm btn-info float-right">
                                        🧠 Consignes
                                        <div class="tooltip-content">
                                            <b>
                                                <ul>
                                                    <li>• Rassurez immédiatement le partenaire potentiel en expliquant
                                                        clairement la simplicité et la rapidité du processus.<br><br>
                                                    </li>
                                                    <li>• Insistez fortement sur le fait que le Cabinet Bruno gère
                                                        l’intégralité du suivi après recommandation.<br><br></li>
                                                    <li>• Soyez attentif aux réactions pour proposer spontanément une
                                                        démonstration de la simplicité du processus.</li>
                                                </ul>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>.1 :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Je comprends parfaitement votre contrainte de temps. Sachez toutefois que
                                            nous avons conçu
                                            un <b style="color: green;">processus extrêmement simple</b> 🕒 de
                                            recommandation, qui se limite uniquement à une
                                            rapide mise en relation. Ensuite, le Cabinet Bruno assure la <b
                                                style="color: green;">prise en charge complète du suivi</b>
                                            auprès du contact recommandé. Ainsi, cela ne représentera aucune charge
                                            supplémentaire
                                            pour vous. Seriez-vous rassuré(e) par cette simplicité opérationnelle ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio"
                                                <?= checked('siAccepteSuitePasTemps', 'oui', $questScript, 'checked') ?>
                                                class="btn-check" name="siAccepteSuitePasTemps" value="oui" />
                                        </div>
                                        Oui
                                    </button>
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="siAccepteSuitePasTemps"
                                                <?= checked('siAccepteSuitePasTemps', 'non', $questScript, 'checked') ?>
                                                value="non" />
                                        </div>
                                        Non
                                    </button>
                                </div>
                            </div>
                        </div>



                        <div id="objection-3" hidden>
                            <div class="question-box ">
                                <div class="agent-icon">
                                    <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                                </div>
                                <div class="question-content">
                                    <div class="tooltip-container btn btn-sm btn-info float-right">
                                        🧠 Consignes
                                        <div class="tooltip-content">
                                            <b>
                                                <ul>
                                                    <li>• Rassurez immédiatement votre interlocuteur en proposant une
                                                        rencontre physique ou une visioconférence.<br><br></li>
                                                    <li>• Mentionnez explicitement des références sérieuses pour
                                                        renforcer votre crédibilité.<br><br></li>
                                                    <li>• Soyez calme, ouvert, et montrez-vous disponible pour établir
                                                        une relation de confiance solide.</li>
                                                </ul>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>.1 :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Je comprends totalement vos réserves. Pour établir une réelle confiance et
                                            répondre pleinement
                                            à vos interrogations, nous pourrions organiser une <b
                                                style="color: green;">rencontre en personne</b> 🤝 ou une
                                            visioconférence, au cours de laquelle nous vous présenterons des <b
                                                style="color: green;">références sérieuses</b> 🤝 ,
                                            telles que des notaires ou des agences immobilières qui collaborent déjà
                                            efficacement avec le
                                            Cabinet Bruno. Cette approche vous conviendrait-elle ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this); onClickSiRDVMefianceInconnu('oui');"
                                        type="button" class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio"
                                                <?= checked('siRDVMefianceInconnu', 'oui', $questScript, 'checked') ?>
                                                class="btn-check" name="siRDVMefianceInconnu" value="oui" />
                                        </div>
                                        Oui, Planifier rencontre
                                    </button>
                                    <button onclick="selectRadio(this); onClickSiRDVMefianceInconnu('non');"
                                        type="button" class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="siRDVMefianceInconnu"
                                                <?= checked('siRDVMefianceInconnu', 'non', $questScript, 'checked') ?>
                                                value="non" />
                                        </div>
                                        Non, pas intéressé(e)
                                    </button>
                                </div>
                            </div>

                            <!--  Planifier rencontre -->
                            <div class="response-options" id="div-prise-rdv2" hidden></div>
                        </div>
                    </div>

                    <!-- Etape 10 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Si l’interlocuteur actuel n’est pas le décideur final, obtenez
                                                    immédiatement les coordonnées complètes de la personne
                                                    responsable.<br><br></li>
                                                <li>• Soyez poli, courtois et professionnel afin que votre interlocuteur
                                                    actuel soit disposé à faciliter la mise en relation.<br><br></li>
                                                <li>• Confirmez précisément la date et l'heure du rappel éventuel.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Êtes-vous la personne décisionnaire concernant ce type de partenariat, ou
                                        pourriez-vous
                                        m’indiquer les coordonnées de la personne responsable afin que je puisse la
                                        contacter
                                        directement ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiPersonneDecisionnaire('oui');"
                                    type="button" class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siPersonneDecisionnaire', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siPersonneDecisionnaire" value="oui" />
                                    </div>
                                    Interlocuteur = Décideur final
                                </button>
                                <button onclick="selectRadio(this); onClickSiPersonneDecisionnaire('non');"
                                    type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siPersonneDecisionnaire"
                                            <?= checked('siPersonneDecisionnaire', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Autre décideur
                                </button>
                            </div>
                        </div>


                        <!-- Autre décideur -->
                        <div class="response-options" id="sous-question-8"
                            <?= $questScript && isset($questScript->siPersonneDecisionnaire) && $questScript->siPersonneDecisionnaire == 'oui' ? "" : "hidden"; ?>>
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="civiliteResponsable"
                                            id="civiliteResponsable">
                                            <option value="">--Choisir--</option>
                                            <option value="Madame"
                                                <?= $gerant && ($gerant->civiliteContact == 'Mme' || $gerant->civiliteContact == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= $gerant && ($gerant->civiliteContact == 'M' || $gerant->civiliteContact == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="prenomResponsable"
                                            value="<?= $gerant ? $gerant->prenomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomResponsable"
                                            name="nomResponsable" value="<?= $gerant ? $gerant->nomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleResponsable"
                                            value="<?= $gerant ? $gerant->jobTitle : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telResponsable"
                                            name="telResponsable" value="<?= $gerant ? $gerant->telContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailResponsable"
                                            name="emailResponsable"
                                            value="<?= $gerant ? $gerant->emailContact : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 11 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Obtenez rapidement et précisément ces deux informations clés afin
                                                    d’évaluer conrètement le potentiel du partenariat proposé.<br><br>
                                                </li>
                                                <li>• Expliquez simplement pourquoi ces informations sont importantes,
                                                    sans insister excessivement.<br><br></li>
                                                <li>• Notez soigneusement ces informations, elles seront essentielles
                                                    pour les étapes suivantes du partenariat.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin d’estimer rapidement l’intérêt de notre partenariat, pourriez-vous me
                                        préciser
                                        approximativement combien de clients vous servez actuellement en: <span
                                            id="place-regions" style="font-weight: bold;"></span>, ainsi que la
                                        typologie principale de ces clients (copropriétés, résidences, entreprises…) ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <style>

                        </style>
                        <!-- Autre décideur -->
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-12">
                                        <label for="">Nombre approximatif de clients:</label>
                                        <input type="number" class="form-control" min="0" value="0" id="nombreClients"
                                            name="nombreClients" placeholder="" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Typologie principale des clients:</label>
                                        <label class="container-checkbox">
                                            Mono propriété ( maison individuelle, pavillon)
                                            <input type="checkbox" id="categorie1"
                                                value="Mono propriété ( maison individuelle, pavillon)">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Copropriété
                                            <input type="checkbox" id="categorie2" value="Copropriété">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Zone commerciale
                                            <input type="checkbox" id="categorie3" value="Zone commerciale">
                                            <span class="checkmark-checkbox"></span>
                                        </label>

                                        <label class="container-checkbox">
                                            Autres
                                            <input type="checkbox" id="categorie4" value="Autres"
                                                onclick="functionAutreTypologie(this.checked);">
                                            <span class="checkmark-checkbox"></span>
                                        </label>
                                        <input type="text" class="form-control" id="autreTypologie"
                                            name="autreTypologie" placeholder="Saisir..." value="" hidden>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 12 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Présentez le partenariat clairement et simplement, en valorisant
                                                    immédiatement le bénéfice réciproque.<br><br></li>
                                                <li>• Insistez sur l’aspect spontané et naturel de ce type de
                                                    partenariat, sans contraintes excessives.<br><br></li>
                                                <li>• Soyez attentif à la réaction de l’interlocuteur pour adapter au
                                                    mieux la suite de votre présentation.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
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
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 13 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Insistez sur le bénéfice financier concret pour l’entreprise
                                                    partenaire.<br><br></li>
                                                <li>• Précisez clairement que la commission sera systématique dès
                                                    signature d’un mandat par un client recommandé.<br><br></li>
                                                <li>• Soyez attentif aux questions éventuelles sur les modalités
                                                    précises (montant, fréquence de paiement).</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        L’un des avantages majeurs de ce partenariat est le <b
                                            style="color: green;">nouveau revenu potentiel</b> généré pour
                                        votre entreprise : en effet, vous percevez une <b
                                            style="color: green;">commission</b> chaque fois qu’un client que vous
                                        recommandez signe effectivement un mandat avec le Cabinet Bruno.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions ou demandes spécifiques du
                                    prospect dans le champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 14 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Valorisez clairement le bénéfice qualitatif et stratégique de ce
                                                    partenariat pour l’entreprise prospectée.<br><br></li>
                                                <li>• Expliquez brièvement comment cela renforce leur crédibilité et
                                                    leur relation client.<br><br></li>
                                                <li>• Soyez attentif aux éventuelles demandes de précisions du prospect.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Ce partenariat permet également un <b style="color: green;">enrichissement de
                                            votre offre</b> auprès de vos clients
                                        existants. <br>
                                        En les proposant un syndic fiable comme le Cabinet Bruno, vous
                                        renforcez ainsi votre propre <b style="color: green;">position de conseil
                                            renforcée</b> , tout en augmentant leur
                                        satisfaction globale.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions ou demandes du prospect dans le
                                    champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 15 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Insistez sur l’aspect réciproque et équilibré du
                                                    partenariat.<br><br></li>
                                                <li>• Soulignez que le Cabinet Bruno est tout à fait disposé à
                                                    recommander activement le partenaire auprès de ses propres
                                                    clients.<br><br></li>
                                                <li>• Soyez particulièrement attentif aux réactions immédiates pour
                                                    adapter la suite du dialogue.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Par ailleurs, ce partenariat représente une réelle <b
                                            style="color: green;">opportunité de réciprocité</b>. De notre côté,
                                        le Cabinet Bruno pourra à son tour recommander activement votre entreprise et
                                        vos services
                                        auprès de ses propres clients copropriétaires, ce qui générera ainsi un
                                        véritable cercle vertueux
                                        bénéfique à nos deux activités.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les remarques du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 16 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Présentez clairement la simplicité du processus afin de rassurer
                                                    immédiatement le partenaire.<br><br></li>
                                                <li>• Insistez sur le respect strict de la confidentialité et de
                                                    l’accord préalable du prospect recommandé.<br><br></li>
                                                <li>• Restez attentif aux éventuelles questions sur les détails
                                                    pratiques.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
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
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 17 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Insistez sur l’importance accordée à la transparence et au sérieux
                                                    du suivi des recommandations.<br><br></li>
                                                <li>• Expliquez brièvement que le partenaire sera systématiquement
                                                    informé des suites données à chaque recommandation.<br><br></li>
                                                <li>• Soyez attentif aux questions éventuelles sur les modalités
                                                    précises de ce suivi.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de garantir une collaboration efficace, nous assurons une <b
                                            style="color: green;">transparence totale</b> ainsi
                                        qu’un <b style="color: green;">suivi rigoureux</b> des leads transmis. <br>
                                        Vous serez ainsi systématiquement informé(e) de
                                        l’issue donnée à chaque contact que vous nous recommandez, ce qui permet une
                                        confiance et
                                        une visibilité optimales entre nos deux entreprises.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 18 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soulignez clairement l’importance majeure accordée par le Cabinet
                                                    Bruno à la qualité du traitement des contacts recommandés.<br><br>
                                                </li>
                                                <li>• Rassurez le partenaire en expliquant que sa réputation sera
                                                    toujours protégée.<br><br></li>
                                                <li>• Soyez attentif aux éventuelles inquiétudes exprimées afin d'y
                                                    répondre immédiatement.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Sachez également que le Cabinet Bruno prend un <b
                                            style="color: green;">engagement de qualité</b> fort envers tous
                                        les clients que vous recommandez. <br>
                                        Nous garantissons un traitement sérieux, professionnel et
                                        attentif de chaque contact afin de préserver pleinement le <b
                                            style="color: green;">respect de votre réputation</b>
                                        auprès de vos clients.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réactions du prospect dans le champ
                                    "Note" à droite.</label>
                            </div>
                        </div>
                    </div>


                    <!-- Etape 19 : -->
                    <div class="step">
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

                    <!-- Etape 20 : -->
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
                                                <li>• Proposez d'aborder rapidement les formalités si le prospect
                                                    l’évoque explicitement, sans alourdir inutilement l’échange
                                                    initial.<br><br></li>
                                                <li>• Restez ouvert et souple, en indiquant que les détails précis
                                                    pourront être discutés lors d’un rendez-vous ultérieur.<br><br></li>
                                                <li>• Soyez attentif à ne pas créer de blocage : proposez toujours de
                                                    noter les demandes spécifiques pour faciliter une future négociation
                                                    détaillée.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge" style="color: red;">
                                        Si vous le souhaitez, nous pouvons aborder dès maintenant brièvement certaines
                                        formalités
                                        telles que l’accord de partenariat écrit 📝 , le pourcentage de commission
                                        envisagé 💰 ou
                                        l’éventuelle exclusivité territoriale 📍. <br>
                                        Souhaitez-vous évoquer ces points dès aujourd’hui, ou
                                        préférez-vous les discuter plus en détail lors d’un prochain rendez-vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!--  Paisir les détails des demandes du partenaire -->
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiDisponiblePoint('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siDisponiblePoint', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siDisponiblePoint" value="oui" />
                                    </div>
                                    Disponible maintenant
                                </button>
                                <button onclick="selectRadio(this); onClickSiDisponiblePoint('non');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siDisponiblePoint"
                                            <?= checked('siDisponiblePoint', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Plus tard, RDV
                                </button>
                            </div>
                        </div>
                        <div class="response-options" id="div-prise-rdv-bis" hidden></div>
                    </div>

                    <!-- Etape 21 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez particulièrement attentif aux signaux positifs tels que
                                                    l’évocation spontanée de clients précis ou situations
                                                    réelles.<br><br></li>
                                                <li>• Validez explicitement avec enthousiasme l’intérêt mutuel afin de
                                                    renforcer positivement l'engagement du partenaire potentiel.<br><br>
                                                </li>
                                                <li>• Notez précisément les détails évoqués afin de faciliter les
                                                    prochaines étapes du partenariat.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge" style="color: red;">
                                        Je constate avec plaisir que vous avez déjà en tête quelques clients
                                        potentiellement intéressés. <br>
                                        C’est un excellent point, qui indique clairement l’intérêt de notre partenariat.
                                        <br>
                                        Puis-je considérer que nous validons ensemble aujourd’hui cet intérêt mutuel
                                        pour avancer concrètement à la
                                        prochaine étape ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siValideAujourdhui', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" name="siValideAujourdhui" value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siValideAujourdhui"
                                            <?= checked('siValideAujourdhui', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 22 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Proposez clairement et directement une rencontre ou une
                                                    visioconférence afin de formaliser précisément l’accord.<br><br>
                                                </li>
                                                <li>• Précisez brièvement que cette rencontre permettra d’aborder tous
                                                    les détails du partenariat.<br><br></li>
                                                <li>• Soyez attentif à la préférence du partenaire et validez
                                                    immédiatement une date précise.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour finaliser au mieux notre partenariat et détailler précisément nos
                                        modalités, souhaitez-vous
                                        organiser une rencontre physique 📅 ou préférez-vous plutôt une visioconférence
                                        💻 ? <br>
                                        Nous pourrons alors vous présenter formellement un contrat de partenariat adapté
                                        à notre accord.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickTypeRencontre('physique');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle">
                                        <input type="radio"
                                            <?= checked('typeRencontre', 'physique', $questScript, 'checked') ?>
                                            class="btn-check" name="typeRencontre" value="physique" />
                                    </div>
                                    Rencontre physique
                                </button>
                                <button onclick="selectRadio(this); onClickTypeRencontre('Visioconférence');"
                                    type="button" class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="typeRencontre"
                                            <?= checked('typeRencontre', 'Visioconférence', $questScript, 'checked') ?>
                                            value="Visioconférence" />
                                    </div>
                                    Visioconférence
                                </button>
                                <button onclick="selectRadio(this); onClickTypeRencontre('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="typeRencontre"
                                            <?= checked('typeRencontre', 'non', $questScript, 'checked') ?>
                                            value="non" />
                                    </div>
                                    Non, refus RDV
                                </button>
                            </div>
                        </div>


                        <div class="response-options" id="bloc-prise-rdv2-bis" hidden>
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-12" id="imputLienVisioconference">
                                        <label for="">Lien visoiconférence: <small class="text-danger">*</small></label>
                                        <input type="text" class="form-control" id="lienVisioconference"
                                            name="lienVisioconference" value="">
                                    </div>
                                </div>

                                <div id="div-prise-rdv2-bis"></div>
                            </div>
                        </div>

                        <div class="question-box" hidden id="sous-menu-recap">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Soyez particulièrement attentif aux signaux positifs tels que
                                                    l’évocation spontanée de clients précis ou situations
                                                    réelles.<br><br></li>
                                                <li>• Validez explicitement avec enthousiasme l’intérêt mutuel afin de
                                                    renforcer positivement l'engagement du partenaire potentiel.<br><br>
                                                </li>
                                                <li>• Notez précisément les détails évoqués afin de faciliter les
                                                    prochaines étapes du partenariat.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span>.1 :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour récapituler brièvement, nous confirmons ensemble aujourd’hui notre volonté
                                        commune
                                        de collaborer 🤝. <br>
                                        Nous démarrerons par un premier test pratique sur quelques
                                        recommandations 📩, et nous avons convenu d’un rendez-vous <span
                                            style="font-weight: bold;" id="place-rdv"></sapn>📅. <br>
                                            Est-ce bien correct pour vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 23 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Recueillez rapidement et précisément les coordonnées
                                                    professionnelles complètes de l’interlocuteur.<br><br></li>
                                                <li>• Confirmez clairement l’envoi prévu (documentation ou proposition
                                                    écrite)<br><br></li>
                                                <li>• Rassurez le partenaire sur la rapidité et le sérieux de l’envoi de
                                                    ces documents.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de finaliser au mieux notre échange d’aujourd’hui, pourriez-vous me
                                        communiquer votre
                                        email professionnel ✉️ et votre numéro portable direct 📱 ? <br>
                                        De notre côté, le Cabinet Bruno vous transmettra rapidement une documentation
                                        complète et une proposition écrite reprenant
                                        précisément tous les termes convenus.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="civiliteResponsable"
                                            id="civiliteResponsable">
                                            <option value="">--Choisir--</option>
                                            <option value="Madame"
                                                <?= $gerant && ($gerant->civiliteContact == 'Mme' || $gerant->civiliteContact == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= $gerant && ($gerant->civiliteContact == 'M' || $gerant->civiliteContact == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="prenomResponsable"
                                            value="<?= $gerant ? $gerant->prenomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomResponsable"
                                            name="nomResponsable" value="<?= $gerant ? $gerant->nomContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleResponsable"
                                            value="<?= $gerant ? $gerant->jobTitle : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telResponsable"
                                            name="telResponsable" value="<?= $gerant ? $gerant->telContact : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailResponsable"
                                            name="emailResponsable"
                                            value="<?= $gerant ? $gerant->emailContact : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 24 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Remerciez très professionnellement votre interlocuteur, tout en
                                                    exprimant clairement votre enthousiasme à collaborer<br><br></li>
                                                <li>• Adoptez un ton cordial, formel et respectueux adapté à un contexte
                                                    B2B.<br><br></li>
                                                <li>• Assurez-vous de laisser une dernière impression très positive
                                                    avant de raccrocher.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je tiens sincèrement à vous remercier pour votre disponibilité et votre
                                        ouverture lors de cet échange. <br>
                                        Nous avons vraiment hâte de débuter cette collaboration prometteuse avec votre
                                        entreprise. <br>
                                        Le Cabinet Bruno reste entièrement à votre disposition pour tout besoin
                                        complémentaire. <br>
                                        Je vous souhaite une excellente journée, au plaisir de notre prochain contact !
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 25 : -->
                    <div class="step">
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

                    <!-- Etape 26 : -->
                    <div class="step">
                        <div class="question-box ">
                            <div class="agent-icon">
                                <img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50">
                            </div>
                            <div class="question-content">
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Message de fin quand on est à non des étaples suivantes: <br><br>

                                        Je constate avec plaisir que vous avez déjà en tête quelques clients
                                        potentiellement intéressés.
                                        C’est un excellent point, qui indique clairement l’intérêt de notre partenariat.
                                        Puis-je considérer que nous validons ensemble aujourd’hui cet intérêt mutuel
                                        pour avancer concrètement à la prochaine étape ? <br><br>

                                        Pour récapituler brièvement, nous confirmons ensemble aujourd’hui notre volonté
                                        commune de collaborer 🤝.
                                        Nous démarrerons par un premier test pratique sur quelques recommandations 📩,
                                        et nous avons convenu d’un rendez-vous à la date et l’heure précises fixées
                                        ensemble 📅.
                                        Est-ce bien correct pour vous ?


                                    </p>
                                </div>
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

function onClickResponsable(val) {
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
    if (val == "oui") {
        $("#div-prise-rdv").attr("hidden", "hidden");
        $("#divChargementDisponibilite").attr("hidden", "hidden");
        hidePlaceRdv1 = true;
        document.getElementById("div-prise-rdv").innerHTML = '';
    } else {
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
    console.log(1)
    // objetMail =
    //     `Découvrez Proxinistre : gérer votre sinistre devient très simple.`;
    // bodyMail = `<p style="text-align:justify">${`<?= $gerant ? "Bonjour $gerant->civilite $gerant->prenom $gerant->nom," : "Madame, Monsieur," ?>`}<br><br>
    //                 Merci pour notre échange très agréable d'aujourd'hui.<br><br>
    //                 Comme promis, je vous transmets en pièce jointe notre plaquette Proxinistre. Vous y découvrirez clairement comment nous simplifions totalement la gestion de votre sinistre d’assurance, en nous occupant de tout, de A à Z.<br><br>
    //                 <b>En choisissant Proxinistre, vous bénéficiez notamment de</b> :<br>
    //                 <ul>
    //                     <li>Un interlocuteur unique dédié à votre dossier.</li>
    //                     <li>Une expertise SOS Sinistre sous 24 heures.</li>
    //                     <li>Un soutien administratif et juridique complet.</li>
    //                     <li><b>0€ de coût de gestion</b> pour vous.</li>
    //                     <li>La facilitation complète des démarches liées à votre sinistre.</li>
    //                     <li>Une assistance disponible 24h/24 et 7j/7.</li>
    //                     <li>Des partenaires agréés pour des réparations rapides et garanties.</li>
    //                 </ul>
    //                 <br><br>Notre objectif est clair : <b>vous soulager et simplifier totalement vos démarches</b>, pour vous permettre de retrouver rapidement votre tranquillité d’esprit.<br><br>
                    
    //                 Je reste entièrement à votre écoute pour toute question complémentaire.<br><br>
    //                 À très bientôt,<br><br>
    //                 Bien cordialement,<br><br>
    //                  ${`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`}
    //                                         `;

    // $('#objetMailEnvoiDoc').val(objetMail)
    // $('#signatureMail').val(`<?= SIGNATURE_RELATIONCLIENT_PROXINISTRE ?>`)
    // tinyMCE.get("bodyMailEnvoiDoc").setContent(bodyMail);
    // tinyMCE.get("bodyMailEnvoiDoc").getBody().setAttribute('contenteditable', false);
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
    nextBtn.classList.toggle("hidden", (currentStep == 24 || currentStep == 25 || currentStep == 5 || currentStep ==
        26));
    // finishBtn.classList.toggle("hidden", currentStep !== steps.length - 1 && currentStep != 7);
    finishBtn.classList.toggle("hidden", (currentStep != 24 && currentStep != 25 && currentStep != 5 && currentStep !=
        26));

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

    } else if (currentStep === 4) {
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
    } else if (currentStep < steps.length - 1) {
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