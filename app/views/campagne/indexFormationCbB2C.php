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
                <h2><span><i class="fas fa-fw fa-scroll" style="color: #eb7f15;"></i></span> Campagne formation B2C CABINET BRUNO - 
                <img style="height: 38px;" src="<?= URLROOT ?>/public/img/logo_Cabinet_Bruno.png" alt=""></h2>
            </div>

            <div class="script-container" style="margin-top:15px; padding:10px">
                <div class="container-fluid px-0">
                    <div class="row">
                        <!-- Nom -->
                        <div class="form-group col-4 col-md-4 col-sm-4  ">
                            <label class="font-weight-bold">Civilité</label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= $contact ? $contact->civilite : '' ?>">
                        </div>

                        <!-- Enseigne -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Prénom</label>
                            <input type="text" name="enseigne" class="form-control"
                                value="<?= $contact ? $contact->prenom : ''; ?>">
                        </div>
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Nom</label>
                            <input type="text" name="enseigne" class="form-control"
                                value="<?= $contact ? $contact->nom : ''; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Téléphone -->
                        <div class="form-group   col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Téléphone</label>
                            <div class="input-group">
                                <input type="tel" name="businessPhone" class="form-control"
                                    value="<?= $contact ? $contact->tel : ''; ?>"
                                    placeholder="Entrez le numéro de téléphone">
                                <?php if ($contact && $contact->tel): ?>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" title="WhatsApp">
                                            <a target="_blank"
                                                href="https://api.whatsapp.com/send?phone=33<?= str_replace(' ', '', $contact->tel) ?>"
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
                                    value="<?= $contact ? $contact->email : '' ?>" placeholder="Entrez l'adresse email">
                                <?php if ($contact && $contact->email): ?>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success" title="Envoyer un email">
                                            <a href="mailto:<?= $contact->email ?>" style="color: #ffffff;">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Statut</label>
                            <div class="input-group">
                                <input type="url" name="webaddress" class="form-control"
                                    value="<?= $contact ? $contact->statut : '' ?>"
                                    placeholder="">
    
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
                                    value="<?= $contact ? $contact->adresse : '' ?>">
                            </div>
                        </div>

                        <!-- Code Postal -->
                        <div class="col-md-4  col-4 col-sm-4  mb-3">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Code Postal</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="codePostal" id="codePostal"
                                    class="form-control" readonly
                                    value="<?= $contact ? $contact->codePostal : '' ?>">
                            </div>
                        </div>

                        <!-- Ville -->
                        <div class="col-md-4  col-4 col-sm-4  mb-3">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Ville</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" readonly name="ville" class="form-control"
                                    value="<?= $contact ? $contact->ville : '' ?>">
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
                                                <li>• Cette étape est cruciale pour valider rapidement que vous êtes en contact avec la bonne personne. <br><br></li>
                                                <li>• Si vous n'avez pas la bonne personne en ligne, restez courtois, demandez poliment quand le prospect sera disponible, notez l’information et terminez l’appel rapidement. <br><br></li>
                                                <li>• Soyez dynamique et souriant, votre ton donnera envie au prospect de poursuivre l'échange.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Bonjour <?= $contact ? "<b>$contact->prenom $contact->nom </b>" : "" ?>, je suis <b><?= $connectedUser->fullName ?></b>
                                        du <b>Cabinet Bruno</b>, est-ce bien à <?= $contact ? "<b >$contact->prenom $contact->nom</b>" : "" ?> que je m’adresse ?
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickProspectB2C('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('prospectB2C', 'oui', $questScript, 'checked') ?>
                                            name="prospectB2C" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);  onClickProspectB2C('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="prospectB2C"
                                            <?= checked('prospectB2C', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                        <div class="response-options" id="sous-question-0"
                            <?= $questScript && isset($questScript->prospectB2C) && $questScript->prospectB2C == 'non' ? "" : "hidden"; ?>>
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="civiliteProspect"
                                            id="civiliteProspect">
                                            <option value="">--Choisir--</option>
                                            <option value="Madame"
                                                <?= $contact && ($contact->civilite == 'Mme' || $contact->civilite == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= $contact && ($contact->civilite == 'M' || $contact->civilite == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomProspect"
                                            name="prenomProspect"
                                            value="<?= $contact ? $contact->prenom : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomProspect"
                                            name="nomProspect" value="<?= $contact ? $contact->nom : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Statut: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleProspect"
                                            value="<?= $contact ? $contact->statut : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telProspect"
                                            name="telProspect" value="<?= $contact ? $contact->tel : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailProspect"
                                            name="emailProspect"
                                            value="<?= $contact ? $contact->email : ''; ?>">
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
                                                <li>• Cette phase sert à établir clairement et professionnellement votre identité ainsi que celle du Cabinet Bruno. Votre interlocuteur doit immédiatement percevoir votre sérieux et le professionnalisme du cabinet.<br><br></li>
                                                <li>•Parlez lentement, distinctement, et avec assurance afin de susciter la confiance dès le départ.<br><br></li>
                                                <li>• Soyez prêt à répondre brièvement si le prospect vous interrompt pour demander des précisions sur votre rôle ou le Cabinet Bruno. Anticipez les objections simples (ex. : « Où êtes-vous situé exactement ? »).<br><br></li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>

                                <div class="question-text">
                                    <p class="text-justify">
                                        Je suis chargé(e) de clientèle au sein du cabinet immobilier <b>Cabinet Bruno</b>. <br>
                                        Nous sommes spécialisés en gestion de copropriétés, gestion locative et transactions
                                        immobilières sur: <?= $contact ? $contact->adresse : '' ?>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Etape 2 -->
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
                                                <li>• Cette étape permet de vérifier explicitement que le prospect est disposé à poursuivre la conversation.<br><br></li>
                                                <li>• Soyez particulièrement à l'écoute du ton employé par le prospect. En cas d’hésitation ou de réponse négative, proposez immédiatement un rappel à un moment plus approprié, sans insister<br><br></li>
                                                <li>• Une réponse positive claire indique que vous pouvez continuer directement à l'étape suivante sans délai.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify">
                                        Nous réalisons actuellement une campagne d’information pour proposer <b style="color: green;">gratuitement</b> et sans
                                        engagement des conseils personnalisés sur la gestion et la valorisation des biens immobiliers. <br>
                                        Êtes-vous disponible pour poursuivre cet échange maintenant, ou préférez-vous que je vous rappelle à un moment plus adapté ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio" <?= '' //checked('siDsiponible', 'oui', $questScript, 'checked') 
                                                                                    ?> class="btn-check"
                                            name="siDsiponible" value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siDsiponible" <?= '' //checked('siDsiponible', 'non', $questScript, 'checked') 
                                                                                                    ?> value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>

                    </div>

                    <!-- 5. Gestion des objections courantes -->
                    <!-- 5.2.1. Objection : « Je n’ai pas le temps / Je ne suis pas intéressé » -->
                    <!-- Etape 3 : -->
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
                                                <li>• Réagissez immédiatement et avec compréhension face à cette objection courante.<br><br></li>
                                                <li>• Ne montrez aucune déception ni agacement, mais proposez clairement une solution : un
                                                        rappel ultérieur ou une présentation rapide.<br><br></li>
                                                <li>• Soyez bref et souriant pour inciter positivement le prospect à accepter votre proposition.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je comprends tout à fait que vous soyez occupé(e). <br>
                                        Souhaitez-vous que je vous rappelle à un autre moment plus adapté à votre emploi du temps 📅, ou puis-je simplement prendre deux
                                        minutes maximum pour vous présenter brièvement l’essentiel ⏳ ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickSiOccupe('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siOccupe', 'oui', $questScript, 'checked') ?>
                                            name="siOccupe" class="btn-check " value="oui" />
                                    </div>
                                    Oui, Présenter brièvement
                                </button>
                                <button onclick="selectRadio(this);  onClickSiOccupe('rdv');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="siOccupe"
                                            <?= checked('siOccupe', 'rdv', $questScript, 'checked') ?>
                                            class="btn-check" value="rdv" />
                                    </div>
                                    Replanifier l'appel 
                                </button>
                                <button onclick="selectRadio(this);  onClickSiOccupe('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="siOccupe"
                                            <?= checked('siOccupe', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non, terminer 
                                </button>
                            </div>
                        </div>
                        <div class="response-options" id="div-prise-rdv" hidden></div>
                    </div>

                    <!-- Etape 4 : origine -->
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
                                                <li>• Cette question est fondamentale pour déterminer immédiatement l’orientation de votre discours.<br><br></li>
                                                <li>• Soyez attentif à la réponse, car elle conditionne entièrement le reste de l’appel.<br><br></li>
                                                <li>• En cas d’hésitation ou d'incompréhension du prospect, reformulez brièvement en précisant que cette information permet de mieux cibler les conseils immobiliers personnalisés proposés par le Cabinet Bruno.</li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de vous proposer les informations les plus pertinentes, pourriez-vous m’indiquer
                                        rapidement si vous êtes actuellement propriétaire, locataire ou dans une autre situation ?
                                    </p>
                                </div>
                            </div>
                        </div>

                        
                        <div class="response-options">
                            <div class="options-container">
                                <div class="form-group  col-12 col-md-12 col-sm-12 ">
                                    <label for="" style="font-weight: bold;">Statut du prospect:</label>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-md-3">
                                            <label class="container-checkbox">
                                                🏠 Propriétaire
                                                <input type="checkbox" id="Proprietaire" onclick="onclickStautProspect(this.value);"
                                                    value="Proprietaire" name="Proprietaire">
                                                <span class="checkmark-checkbox"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-checkbox">
                                                🔑 Locataire
                                                <input type="checkbox" id="Locataire"  onclick="onclickStautProspect(this.value);" 
                                                value="Locataire" name="Locataire">
                                                <span class="checkmark-checkbox"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="container-checkbox">
                                                ❔Autre
                                                <input type="checkbox" id="Autre" onclick="onclickStautProspect(this.value); functionStatutProspect(this.checked);" 
                                                value="Autre" name="Autre">
                                                <span class="checkmark-checkbox"></span>
                                            </label>
                                            <input type="text" class="form-control" id="statutProspect"
                                            name="statutProspect" placeholder="Saisir..." value="" hidden>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Si propriétaire -->
                        <div id="div-si-proprietaire" hidden>
                            <br>
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
                                                    <li>• Cette étape vous permet d'affiner rapidement les besoins potentiels du propriétaire pour orienter efficacement la suite de l’appel.<br><br></li>
                                                    <li>• Si le prospect semble hésitant ou donne une réponse vague, posez-lui des questions
                                                            complémentaires simples :
                                                            Exemple : « Habitez-vous vous-même dans votre bien ou est-il loué actuellement ? », «
                                                            Avez-vous un projet éventuel de vendre dans un futur proche ? »<br><br></li>
                                                    <li>• Notez clairement chaque réponse car cela conditionnera les propositions spécifiques à présenter.</li>
                                                </ul>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>.1 :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Je vous remercie. <br>
                                            Afin de mieux cibler notre échange, pouvez-vous me préciser s'il s'agit de votre
                                            résidence principale en copropriété, d’un bien que vous avez mis en location, ou si vous avez un
                                            projet de vente à court ou moyen terme ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio" class="btn-check"
                                                name="typeBienProprietaure" value="Résidence principale en copropriété" />
                                        </div>
                                        Résidence principale en copropriété 🏢
                                    </button>
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-warning">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="typeBienProprietaure"  value="Bien mis en location" />
                                        </div>
                                        Bien mis en location 📄
                                    </button>
                                    <button onclick="selectRadio(this);" type="button"
                                        class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="typeBienProprietaure"  value="Projet de vente" />
                                        </div>
                                        Projet de vente 🏷️
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        
                        <!-- Locataire » ou « Autre  -->
                        <div id="div-si-locataire-autre" hidden>
                            <br><br>
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
                                                    <li>• L’objectif est de rapidement détecter si ce prospect peut vous aider à entrer indirectement en contact avec un propriétaire ou un syndic.<br><br></li>
                                                    <li>• Si le prospect exprime une hésitation à communiquer directement ces informations, rassurez-le sur la confidentialité et l’absence totale d’engagement de sa part.<br><br></li>
                                                    <li>• Soyez particulièrement attentif à cette réponse, car elle peut ouvrir une voie indirecte très fructueuse pour un nouveau contact.</li>
                                                </ul>
                                            </b>
                                        </div>
                                    </div>
                                    <div class="question-text">
                                        <strong>Question <span name="numQuestionScript"></span>.2 :</strong>
                                        <p class="text-justify" id="textConfirmPriseEnCharge">
                                            Très bien. Auriez-vous éventuellement les coordonnées de votre propriétaire ou du syndic de
                                            votre immeuble, ou pourriez-vous me mettre en relation avec eux ?
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="response-options">
                                <div class="options-container">
                                    <button onclick="selectRadio(this); onClickSiContacBailleur('oui');" type="button"
                                        class="option-button btn btn-success">
                                        <div class="option-circle"><input type="radio"  class="btn-check"
                                                name="siContacBailleur" value="oui" />
                                        </div>
                                        Oui
                                    </button>
                                    <button onclick="selectRadio(this); onClickSiContacBailleur('non');" type="button"
                                        class="option-button btn btn-danger">
                                        <div class="option-circle">
                                            <input type="radio" class="btn-check" name="siContacBailleur"  value="non" />
                                        </div>
                                        Non
                                    </button>
                                </div>
                            </div>
                            <div class="response-options">
                                <div id="div-has-contact-bailleur" class="options-container col-md-11" hidden>
                                    <div class="form-group col-md-12">
                                        <label for="">Type bailleur: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="typebailleur"
                                            id="typebailleur" onchange="selectTypebailleur(this.value)">
                                            <option value="">--Choisir--</option>
                                            <option value="Propriétaire">Propriétaire</option>
                                            <option value="Syndic">Syndic</option>
                                        </select>
                                    </div>

                                    <div id="div-type-bailleur-proprietaire" hidden>
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
                                                <label for="">Statut: <small class="text-danger">*</small>
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

                                    <div  id="div-type-bailleur-syndic" hidden>
                                        <div class="row col-md-12">
                                            <div class="form-group col-md-6">
                                                <label for="">Dénomination Sociale: <small class="text-danger">*</small>
                                                </label>
                                                <input type="text" class="form-control" id="prenomResponsable"
                                                    name="prenomResponsable"
                                                    value="<?= $gerant ? $gerant->prenomContact : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Enseigne: <small class="text-danger">*</small>
                                                </label>
                                                <input type="text" class="form-control" id="nomResponsable"
                                                    name="nomResponsable" value="<?= $gerant ? $gerant->nomContact : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="">Téléphone: <small class="text-danger">*</small>
                                                </label>
                                                <input type="text" class="form-control" id="telResponsable"
                                                    name="telResponsable" value="<?= $gerant ? $gerant->telContact : ''; ?>">
                                            </div>
                                            <div class="form-group col-md-6">
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

                        </div>
                    
                    </div>


                    <!-- Etape 5 :"Autre profil" -->
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
                                                <li>• Cette étape est capitale pour qualifier précisément le profil du prospect : soyez
                                                    particulièrement attentif et utilisez des questions ouvertes simples.<br><br></li>
                                                <li>• N'interrompez pas le prospect lorsqu’il répond, laissez-le s'exprimer librement pour
                                                    obtenir des indices sur son statut immobilier.<br><br></li>
                                                <li>• En cas de réponse imprécise, reformulez votre question ou demandez une précision
                                                    supplémentaire de façon courtoise, sans pression.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        <b>Prospect ayant sélectionné statut "autre".</b> <br><br>
                                        Afin de vous orienter au mieux, pourriez-vous m’indiquer brièvement votre situation concernant
                                        l’immobilier : envisagez-vous un projet
                                        immobilier prochainement ? 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"  class="btn-check"
                                            name="siEnvisagerProjetImmobilier" value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" class="btn-check" name="siEnvisagerProjetImmobilier"  value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Etape 6 "proprétaire" : -->
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
                                                <li>• Confirmez rapidement et clairement l'information disponible sur l’écran avec le prospect.<br><br></li>
                                                <li>• Si la réponse est négative ou imprécise, demandez une correction simple sans insister lourdement.<br><br></li>
                                                <li>• L’objectif ici est de valider la pertinence des données pour adapter précisément votre discours dans les prochaines étapes.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Selon mes informations, vous êtes propriétaire d'un bien situé à [<?= $contact ? $contact->adresse : '' ?>]. Vous me
                                        confirmez cette information ?
                                    </p>
                                </div>
                            </div>
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
                        <div class="response-options" id="sous-question-6" hidden>
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
                                        <label for="">Statut: <small class="text-danger">*</small>
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
                    
                    <!-- Etape 7 : -->
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
                                                <li>• Présentez succinctement les trois services principaux, en adaptant votre rythme pour
                                                        laisser au prospect le temps d’assimiler les informations.<br><br></li>
                                                <li>• Soyez attentif à une éventuelle réaction immédiate du prospect (intérêt ou interrogation)
                                                        qui pourrait vous guider vers un embranchement particulier.<br><br></li>
                                                <li>• Gardez un ton enthousiaste et positif pour communiquer l'image professionnelle du
                                                    Cabinet Bruno.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour répondre efficacement à vos besoins immobiliers, le Cabinet Bruno propose trois grands
                                        types de services :  <br><br>
                                        <b>• La gestion de copropriété</b> 🏢, pour assurer la bonne administration de votre immeuble .<br><br>
                                        <b>• La gestion locative</b> 🔑, pour vous libérer totalement de la gestion quotidienne de votre bien
                                            en location . <br><br>
                                        <b>• La transaction immobilière</b> 💼, pour vous accompagner intégralement dans la vente ou
                                        l’achat de biens immobiliers .
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Etape 8 : -->
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
                                                <li>• Présentez succinctement les trois services principaux, en adaptant votre rythme pour
                                                        laisser au prospect le temps d’assimiler les informations.<br><br></li>
                                                <li>• Soyez attentif à une éventuelle réaction immédiate du prospect (intérêt ou interrogation)
                                                        qui pourrait vous guider vers un embranchement particulier.<br><br></li>
                                                <li>• Gardez un ton enthousiaste et positif pour communiquer l'image professionnelle du
                                                    Cabinet Bruno.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Nos principaux atouts sont : <br><br>
                                        <b>• Une expertise locale</b> approfondie sur toute l’Île-de-France 📍. <br><br>
                                        <b>• Une transparence totale</b> via un extranet sécurisé accessible 24h/24 📱. <br><br>
                                        <b>• Une équipe réactive</b> disponible en France et à l’étranger, garantissant efficacité et
                                            rapidité 🌐. <br><br>
                                        <b>• Des tarifs très compétitifs</b> adaptés à chaque besoin 💵.
                                    </p>
                                </div>
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
                                                <li>• Cette phrase marque la transition vers l'étape précise du script, adaptée à la situation
                                                        exacte du prospect.<br><br></li>
                                                <li>• Soyez particulièrement attentif au ton du prospect à ce stade. Si vous détectez une
                                                        hésitation, rassurez-le brièvement en lui rappelant le côté gratuit et sans engagement de
                                                        l'échange.<br><br></li>
                                                <li>• Annoncez clairement cette transition, de manière enthousiaste, pour maintenir l’intérêt
                                                    du prospect.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        En fonction des informations que vous venez de me transmettre, je vais vous présenter en détail
                                        le service du Cabinet Bruno qui correspond précisément à votre situation.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Déroulement du script par profil de prospect (embranchements) -->
                    <!-- 4.1. Cas d’un prospect propriétaire occupant en copropriété (Mandat de syndic) -->
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
                                                <li>• Soyez précis et clair dans vos questions, mais laissez le prospect répondre librement pour
                                                        qu'il exprime ses attentes ou frustrations.<br><br></li>
                                                <li>• Si le prospect hésite ou semble réticent à répondre, rassurez-le en précisant que ces
                                                    informations restent totalement confidentielles et sont uniquement destinées à adapter
                                                    précisément les conseils que vous allez lui proposer.<br><br></li>
                                                <li>• Notez précisément les réponses, car elles vous serviront à personnaliser l’offre
                                                    commerciale qui sera faite ultérieurement.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour vous proposer une offre vraiment adaptée, pourriez-vous me dire : <br><br>
                                        • Êtes-vous globalement satisfait du syndic actuel de votre copropriété ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Satisfait
                                </button>
                                <button onclick="selectRadio(this);  " type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non satisfait
                                </button>
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
                                                <li>• Soyez précis et clair dans vos questions, mais laissez le prospect répondre librement pour
                                                        qu'il exprime ses attentes ou frustrations.<br><br></li>
                                                <li>• Si le prospect hésite ou semble réticent à répondre, rassurez-le en précisant que ces
                                                    informations restent totalement confidentielles et sont uniquement destinées à adapter
                                                    précisément les conseils que vous allez lui proposer.<br><br></li>
                                                <li>• Notez précisément les réponses, car elles vous serviront à personnaliser l’offre
                                                    commerciale qui sera faite ultérieurement.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        • Connaissez-vous la date de fin de contrat de votre syndic actuel ? 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this); " type="button"
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
                                                <li>• Soyez précis et clair dans vos questions, mais laissez le prospect répondre librement pour
                                                        qu'il exprime ses attentes ou frustrations.<br><br></li>
                                                <li>• Si le prospect hésite ou semble réticent à répondre, rassurez-le en précisant que ces
                                                    informations restent totalement confidentielles et sont uniquement destinées à adapter
                                                    précisément les conseils que vous allez lui proposer.<br><br></li>
                                                <li>• Notez précisément les réponses, car elles vous serviront à personnaliser l’offre
                                                    commerciale qui sera faite ultérieurement.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        • Occupez-vous actuellement un rôle particulier au sein du conseil syndical ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                                                <li>• Soyez précis et clair dans vos questions, mais laissez le prospect répondre librement pour
                                                        qu'il exprime ses attentes ou frustrations.<br><br></li>
                                                <li>• Si le prospect hésite ou semble réticent à répondre, rassurez-le en précisant que ces
                                                    informations restent totalement confidentielles et sont uniquement destinées à adapter
                                                    précisément les conseils que vous allez lui proposer.<br><br></li>
                                                <li>• Notez précisément les réponses, car elles vous serviront à personnaliser l’offre
                                                    commerciale qui sera faite ultérieurement.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Le Cabinet Bruno bénéficie d'une solide réputation grâce à son expertise en gestion de
                                        copropriétés 🥇.  <br>
                                        Nous permettons systématiquement de réaliser des <b style="color: green;">économies</b> substantielles 💰
                                        en optimisant les charges et les contrats existants.  <br>
                                        De plus, notre gestion <b style="color: green;">transparente</b> via un extranet accessible 24h/24 et notre grande <b style="color: green;">réactivité</b> ⚡ vous assurent un suivi optimal et une
                                        tranquillité d’esprit totale.
                                    </p>
                                </div>
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
                                                <li>• Cette proposition est un moment crucial pour concrétiser l'intérêt exprimé
                                                        précédemment.<br><br></li>
                                                <li>• Insistez sur le caractère sans engagement et personnalisé des solutions proposées.<br><br></li>
                                                <li>• Soyez particulièrement attentif à la réaction du prospect pour adapter au mieux la suite
                                                        de l’échange.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de vous montrer précisément comment nous pouvons améliorer la gestion de votre
                                        copropriété, souhaitez-vous organiser un rendez-vous avec l'un de nos gestionnaires pour une
                                        offre personnalisée 🗓️, ou préférez-vous d'abord bénéficier d’une étude gratuite et sans
                                        engagement pour la reprise éventuelle de la gestion de votre immeuble 📖 ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickRdvOuEtudeGratuite('Rendez-vous gestionnaire');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('rdvOuEtudeGratuite', 'Rendez-vous gestionnaire', $questScript, 'checked') ?>
                                            name="rdvOuEtudeGratuite" class="btn-check " value="Rendez-vous gestionnaire" />
                                    </div>
                                    Rendez-vous gestionnaire 🗓️
                                </button>
                                <button onclick="selectRadio(this);  onClickRdvOuEtudeGratuite('Étude gratuite');" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="rdvOuEtudeGratuite"
                                            <?= checked('rdvOuEtudeGratuite', 'Étude gratuite', $questScript, 'checked') ?>
                                            class="btn-check" value="Étude gratuite" />
                                    </div>
                                    Étude gratuite 📖
                                </button>
                                <button onclick="selectRadio(this);  onClickRdvOuEtudeGratuite('Refus changement syndic');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="rdvOuEtudeGratuite"
                                            <?= checked('rdvOuEtudeGratuite', 'Refus changement syndic', $questScript, 'checked') ?>
                                            class="btn-check" value="Refus changement syndic" />
                                    </div>
                                    Refus changement syndic
                                </button>
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
                                                <li>• Cette proposition est un moment crucial pour concrétiser l'intérêt exprimé
                                                        précédemment.<br><br></li>
                                                <li>• Insistez sur le caractère sans engagement et personnalisé des solutions proposées.<br><br></li>
                                                <li>• Soyez particulièrement attentif à la réaction du prospect pour adapter au mieux la suite
                                                        de l’échange.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je comprends parfaitement votre position actuelle. <br>
                                        Auriez-vous connaissance d'autres copropriétés autour de vous qui rencontrent des difficultés avec leur syndic actuel, et qui
                                        pourraient être intéressées par nos services ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); onClickDemandeConnaissanceAutreProspect('oui');" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('demandeConnaissanceAutreProspect', 'oui', $questScript, 'checked') ?>
                                            name="demandeConnaissanceAutreProspect" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);  onClickDemandeConnaissanceAutreProspect('non');" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="demandeConnaissanceAutreProspect"
                                            <?= checked('demandeConnaissanceAutreProspect', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Non
                                </button>
                            </div>
                        </div>

                        <!-- Si oui, formulaire pour prendre coordonnées des copros -->
                    </div>



                    <!-- 4. Déroulement du script par profil de prospect (embranchements) -->
                    <!-- 4.2. Cas d’un prospect propriétaire bailleur (Mandat de gestion locative) -->
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
                                                <li>• Cette étape est déterminante pour comprendre précisément les besoins du prospect en
                                                        matière de gestion locative.<br><br></li>
                                                <li>• Soyez empathique et attentif aux éventuelles difficultés exprimées, car elles constituent
                                                    un point d’accroche puissant pour la suite du discours.<br><br></li>
                                                <li>• Si le prospect répond vaguement, n'hésitez pas à demander des précisions
                                                    complémentaires, de manière diplomatique et sans insistance excessive.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Gérez-vous actuellement votre bien locatif par vous-même ou faites-vous appel à une
                                        agence immobilière ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Gestion personnelle
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Agence immobilière
                                </button>
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
                                                <li>• Cette étape est déterminante pour comprendre précisément les besoins du prospect en
                                                        matière de gestion locative.<br><br></li>
                                                <li>• Soyez empathique et attentif aux éventuelles difficultés exprimées, car elles constituent
                                                    un point d’accroche puissant pour la suite du discours.<br><br></li>
                                                <li>• Si le prospect répond vaguement, n'hésitez pas à demander des précisions
                                                    complémentaires, de manière diplomatique et sans insistance excessive.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Rencontrez-vous ou avez-vous rencontré récemment des difficultés particulières dans la
                                        gestion quotidienne de votre bien ou avec vos locataires ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                                                <li>• Soulignez les bénéfices pratiques et émotionnels pour le propriétaire (gain de temps,
                                                    sérénité quotidienne).<br><br></li>
                                                <li>• Soyez rassurant et convaincant, insistez sur la simplicité du service et sur l’absence totale
                                                    de préoccupations pour le propriétaire.<br><br></li>
                                                <li>• Observez attentivement les réactions du prospect pour éventuellement insister
                                                        davantage sur l’un des bénéfices s’il montre un intérêt particulier.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Avec le service de gestion locative du Cabinet Bruno, vous bénéficiez d’une prise en charge
                                        complète : <br>
                                        • Sélection rigoureuse et sécurisée de vos locataires 🔎, <br><br>
                                        • Gestion intégrale et ponctuelle des loyers 💳, <br><br>
                                        • Maintenance régulière et suivi technique du bien 🛠️. <br><br>
                                        Vous gagnez ainsi en <b style="color: blue;">tranquillité d’esprit</b> et surtout, vous <b style="color: blue;">économisez un temps</b> précieux
                                        au quotidien.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    


                    <!-- Etape 19 : -->
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
                                                <li>• Cette étape est déterminante pour comprendre précisément les besoins du prospect en
                                                        matière de gestion locative.<br><br></li>
                                                <li>• Soyez empathique et attentif aux éventuelles difficultés exprimées, car elles constituent
                                                    un point d’accroche puissant pour la suite du discours.<br><br></li>
                                                <li>• Si le prospect répond vaguement, n'hésitez pas à demander des précisions
                                                    complémentaires, de manière diplomatique et sans insistance excessive.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Rencontrez-vous ou avez-vous rencontré récemment des difficultés particulières dans la
                                        gestion quotidienne de votre bien ou avec vos locataires ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                    </div>

                    <!-- Etape 20 : -->
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
                                                <li>• Cette étape vise à fixer concrètement un contact approfondi avec un expert.<br><br></li>
                                                <li>• Valorisez la gratuité, la rapidité et l'absence totale d'engagement pour lever toute
                                                        éventuelle réticence.<br><br></li>
                                                <li>• Proposez spontanément l’option téléphonique si le prospect hésite sur une rencontre
                                                    physique.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin d’aller plus loin et vous présenter précisément notre contrat de gestion locative ainsi qu'une
                                        évaluation gratuite de votre bien, préférez-vous organiser un entretien physique avec notre expert
                                        location 📅, ou simplement planifier un appel téléphonique rapide 📞 ?
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
                                    Aucun intérêt immédiat
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
                                                <li>• Utilisez cette étape pour tenter de saisir une autre opportunité : un futur mandat de vente
                                                        ou une recommandation indirecte.<br><br></li>
                                                <li>• Soyez diplomate et positif. Ne donnez jamais l’impression d’insister lourdement.<br><br></li>
                                                <li>• Reformulez la question clairement si le prospect hésite, en mettant en avant la simplicité
                                                    et l’absence de pression dans votre démarche.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je comprends tout à fait que ce ne soit pas le bon moment actuellement. Pensez-vous
                                        éventuellement à vendre votre bien dans un avenir proche 🏷️, ou connaissez-vous d'autres
                                        propriétaires bailleurs qui pourraient être intéressés par nos services de gestion locative 📢 ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Projet de vente potentiel 🏷️
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                     Recommandation d'autres propriétaires 📢
                                </button>
                            </div>
                        </div>

                        <!-- Si oui, formulaire pour prendre coordonnées des copros -->
                    </div>

                    <!-- 4.3. Cas d’un prospect ayant un projet de vente immobilière (Mandat de vente)
                    4.3.1. Questions spécifiques : Détails sur le projet de vente -->
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
                                                <li>• Ces questions précises sont cruciales pour déterminer la pertinence immédiate du
                                                        mandat potentiel.<br><br></li>
                                                <li>• Soyez attentif aux attentes particulières exprimées, elles constitueront un levier majeur
                                                        pour votre argumentaire.<br><br></li>
                                                <li>• En cas de refus ou de réponse imprécise, reformulez brièvement la question pour obtenir
                                                    des précisions sans exercer de pression.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Afin de mieux cibler notre accompagnement, pouvez-vous me préciser rapidement : <br><br>
                                        • À quelle échéance envisagez-vous de vendre votre bien immobilier ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                                                <li>• Ces questions précises sont cruciales pour déterminer la pertinence immédiate du
                                                        mandat potentiel.<br><br></li>
                                                <li>• Soyez attentif aux attentes particulières exprimées, elles constitueront un levier majeur
                                                        pour votre argumentaire.<br><br></li>
                                                <li>• En cas de refus ou de réponse imprécise, reformulez brièvement la question pour obtenir
                                                    des précisions sans exercer de pression.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        • Votre bien a-t-il déjà été estimé par un professionnel ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Oui
                                </button>
                                <button onclick="selectRadio(this);  " type="button"
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
                                                <li>• Ces questions précises sont cruciales pour déterminer la pertinence immédiate du
                                                        mandat potentiel.<br><br></li>
                                                <li>• Soyez attentif aux attentes particulières exprimées, elles constitueront un levier majeur
                                                        pour votre argumentaire.<br><br></li>
                                                <li>• En cas de refus ou de réponse imprécise, reformulez brièvement la question pour obtenir
                                                    des précisions sans exercer de pression.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        • Avez-vous actuellement confié votre bien à une agence immobilière ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                    </div>
                    
                    <!-- Etape 25 : -->
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
                                                <li>• Ces questions précises sont cruciales pour déterminer la pertinence immédiate du
                                                        mandat potentiel.<br><br></li>
                                                <li>• Soyez attentif aux attentes particulières exprimées, elles constitueront un levier majeur
                                                        pour votre argumentaire.<br><br></li>
                                                <li>• En cas de refus ou de réponse imprécise, reformulez brièvement la question pour obtenir
                                                    des précisions sans exercer de pression.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        • Avez-vous des attentes particulières concernant cette vente ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Oui
                                </button>
                                <button onclick="selectRadio(this);" type="button"
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
                        <!-- si oui -->
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Indiquez les réponses du
                                    prospect dans le champ "Note" à droite.</label>
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
                                <div class="tooltip-container btn btn-sm btn-info float-right">
                                    🧠 Consignes
                                    <div class="tooltip-content">
                                        <b>
                                            <ul>
                                                <li>• Mettez en avant l'expertise et la sécurité de travailler avec le Cabinet Bruno.<br><br></li>
                                                <li>• Insistez particulièrement sur le réseau d’acheteurs qualifiés pour rassurer sur la rapidité et l’efficacité de la vente.<br><br></li>
                                                <li>• Soyez rassurant et convaincant, surtout concernant l’accompagnement jusqu’à la signature, souvent perçu comme très rassurant par les vendeurs.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                       En confiant la vente de votre bien au Cabinet Bruno, vous bénéficiez :
                                        • De notre expérience confirmée en transactions immobilières 🏅,
                                        • D'un réseau solide d’acheteurs qualifiés 👥,
                                        • D'une valorisation optimale de votre bien pour maximiser son prix 📈,
                                        • Et surtout, d’un accompagnement complet et personnalisé jusqu’à la signature finale
                                        chez le notaire 🖊️. 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Etape 27 : -->
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
                                                <li>• Mettez en avant l'expertise et la sécurité de travailler avec le Cabinet Bruno.<br><br></li>
                                                <li>• Insistez particulièrement sur le réseau d’acheteurs qualifiés pour rassurer sur la rapidité et l’efficacité de la vente.<br><br></li>
                                                <li>• Soyez rassurant et convaincant, surtout concernant l’accompagnement jusqu’à la signature, souvent perçu comme très rassurant par les vendeurs.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour avancer concrètement, souhaitez-vous bénéficier immédiatement d'une estimation
                                        gratuite et sans engagement de votre bien immobilier , ou préférez-vous directement organiser
                                        un rendez-vous avec notre conseiller commercial en immobilier pour approfondir votre projet ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('siEstimationRDV', 'rdv', $questScript, 'checked') ?>
                                            name="siEstimationRDV" class="btn-check " value="rdv" />
                                    </div>
                                    Rendez-vous gestionnaire 🗓️
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-warning">
                                    <div class="option-circle">
                                        <input type="radio" name="siEstimationRDV"
                                            <?= checked('siEstimationRDV', 'oui', $questScript, 'checked') ?>
                                            class="btn-check" value="oui" />
                                    </div>
                                    Étude gratuite 📖
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="siEstimationRDV"
                                            <?= checked('siEstimationRDV', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                    Refus RDV
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- 4. Déroulement du script par profil de prospect (embranchements)
                    4.4. Cas d’un prospect locataire ou sans besoin direct identifié (Pas de mandat direct)
                    4.4.1. Cas spécifique du locataire : Proposition indirecte via le propriétaire ou la copropriété -->
                    <!-- Etape 28 : -->
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
                                                <li>• Cette étape permet d’obtenir une opportunité indirecte à travers le propriétaire ou la
                                                    copropriété du locataire.<br><br></li>
                                                <li>• Soyez très clair et rassurant sur le fait que cette demande n'engage absolument pas le
                                                    locataire lui-même.<br><br></li>
                                                <li>• Si le locataire hésite, proposez simplement de laisser vos coordonnées au propriétaire ou
                                                    au syndic.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        En tant que locataire, pensez-vous que votre propriétaire pourrait être intéressé par nos services
                                        de gestion locative 🔑, ou que votre copropriété aurait besoin d'un syndic plus réactif et
                                        transparent 🏢 ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Propriétaire intéressé
                                </button>
                                <button onclick="selectRadio(this);" type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                     Copropriété intéressée
                                </button>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Saisir les coordonnées ou informations fournies dans le champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Etape 29 : -->
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
                                                <li>• Cette étape permet d’obtenir une opportunité indirecte à travers le propriétaire ou la
                                                    copropriété du locataire.<br><br></li>
                                                <li>• Soyez très clair et rassurant sur le fait que cette demande n'engage absolument pas le
                                                    locataire lui-même.<br><br></li>
                                                <li>• Si le locataire hésite, proposez simplement de laisser vos coordonnées au propriétaire ou
                                                    au syndic.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Même si vous n’avez pas directement besoin de nos services actuellement, sachez que le
                                        Cabinet Bruno propose la gestion locative, la gestion de copropriétés et l’accompagnement dans
                                        les transactions immobilières. <br>
                                        Auriez-vous dans votre entourage quelqu'un susceptible d’être
                                        intéressé par l'un de ces services ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Oui, recommandation
                                </button>
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                     Non, aucune recommandation
                                </button>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container col-md-11">
                                <label style="font-weight: bold;">Saisir les coordonnées ou informations fournies dans le champ "Note" à droite.</label>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 30 : -->
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
                                                <li>• Terminez toujours positivement, avec une grande courtoisie et en remerciant sincèrement
                                                    le prospect pour son temps.<br><br></li>
                                                <li>• Invitez clairement le prospect à conserver précieusement les coordonnées du Cabinet
                                                        Bruno, cela pourrait générer une recommandation indirecte ultérieure.<br><br></li>
                                                <li>• Soyez bref mais chaleureux afin de laisser une très bonne impression finale.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je vous remercie sincèrement pour le temps que vous m’avez accordé. <br>
                                        N’hésitez pas à garder nos coordonnées si jamais vous-même ou votre entourage avez besoin de services immobiliers à
                                        l’avenir. <br>
                                        Le Cabinet Bruno reste à votre entière disposition. Je vous souhaite une excellente journée !
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 5.2.3. Objection : « Je n’ai pas de besoin actuellement » -->
                     <!-- • Prévoir l’affichage rapide de cette réponse dès que le téléopérateur clique sur « Alerte
                    » et sélectionne « Aucun besoin actuel ». -->
                    <!-- Etape 31 : -->
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
                                                <li>• Soyez compréhensif et respectueux du fait que le prospect n’ait pas de besoin immédiat.<br><br></li>
                                                <li>• Proposez spontanément un rappel futur, tout en sollicitant positivement une
                                                    recommandation indirecte.<br><br></li>
                                                <li>• Restez bref, courtois et souriant, afin de faciliter la recommandation éventuelle par le
                                                    prospect.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Souhaitez-vous que je vous recontacte dans quelques mois pour
                                        faire le point sur votre situation , ou auriez-vous dans votre entourage une personne
                                        susceptible d’être intéressée par nos services ?
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                     Recontact ultérieur 
                                </button>
                                <button onclick="selectRadio(this);  " type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                     Demande recommandation
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 5.2.4. Objection : « Doutes sur les honoraires ou la confiance » -->
                    <!-- Etape 32 : -->
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
                                                <li>• Rassurez immédiatement le prospect en insistant sur la transparence et les références
                                                    sérieuses du Cabinet Bruno.<br><br></li>
                                                <li>• Valorisez fortement l’option d’un essai sans engagement ou d’un rendez-vous informatif,
                                                        qui permettent de lever les doutes efficacement.<br><br></li>
                                                <li>• Soyez très empathique et calme, afin d’établir une relation de confiance avec le prospect.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je comprends totalement vos préoccupations. Le Cabinet Bruno mise précisément sur une
                                        <b>transparence totale</b> de ses tarifs et bénéficie de solides <b>références locales</b> pour vous rassurer
                                        pleinement. Pourriez-vous être intéressé(e) par un rendez-vous d’information détaillé ou
                                        préféreriez-vous débuter par un essai sans aucun engagement pour mieux juger par vousmême ? 
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="response-options">
                            <div class="options-container">
                                <button onclick="selectRadio(this); " type="button"
                                    class="option-button btn btn-success">
                                    <div class="option-circle"><input type="radio"
                                            <?= checked('responsable', 'oui', $questScript, 'checked') ?>
                                            name="responsable" class="btn-check " value="oui" />
                                    </div>
                                    Rendez-vous d’information
                                </button>
                                <button onclick="selectRadio(this);  " type="button"
                                    class="option-button btn btn-danger">
                                    <div class="option-circle">
                                        <input type="radio" name="responsable"
                                            <?= checked('responsable', 'non', $questScript, 'checked') ?>
                                            class="btn-check" value="non" />
                                    </div>
                                        Essai sans engagement
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Etape 33 : -->
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
                                                <li>• Faites cette synthèse finale clairement, calmement et lentement pour assurer la
                                                    compréhension complète du prospect.<br><br></li>
                                                <li>• Reformulez précisément et brièvement ce que le prospect a validé au cours de l’appel.<br><br></li>
                                                <li>• Assurez-vous de l'accord explicite du prospect avant de passer à la clôture.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Pour récapituler rapidement notre échange : vous avez exprimé un intérêt pour [offre choisie :
                                        mandat, gestion locative, rendez-vous, estimation gratuite, etc.] concernant votre bien
                                        immobilier. Nous allons donc procéder exactement comme convenu. Est-ce bien correct pour
                                        vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 34 : -->
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
                                                <li>• Confirmez précisément et explicitement l'action qui va être entreprise.<br><br></li>
                                                <li>• Obtenez un accord clair du prospect sur les modalités exactes (date, heure, adresse email, etc.).<br><br></li>
                                                <li>• Soyez enthousiaste et clair pour laisser une impression positive.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Nous confirmons donc ensemble [l’action validée : rendez-vous physique, visioconférence,
                                        email ou proposition écrite] pour faire avancer efficacement votre projet. Je vais organiser cela
                                        dès maintenant. C’est parfait pour vous ?
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Etape 35 : -->
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
                                                <li>• Cette étape garantit que le prospect quitte l’appel en ayant toutes les réponses nécessaires.<br><br></li>
                                                <li>• Soyez très ouvert, encouragez le prospect à poser des questions pour dissiper tout doute restant.<br><br></li>
                                                <li>• Fournissez explicitement les coordonnées et invitez chaleureusement le prospect à revenir vers vous en cas de besoin.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Avant de terminer, avez-vous des questions supplémentaires ou besoin d’une précision sur ce
                                        que nous avons vu ensemble ? N’hésitez surtout pas à revenir vers nous au numéro [numéro
                                        Cabinet Bruno] ou par email [email Cabinet Bruno], nous sommes pleinement disponibles
                                        pour vous accompagner.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Etape 36 : -->
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
                                                <li>• Remerciez chaleureusement, avec sourire et enthousiasme sincère.<br><br></li>
                                                <li>• Prenez congé de manière professionnelle et positive pour laisser une excellente impression finale.<br><br></li>
                                                <li>• Clôturez l’appel dès que vous avez terminé cette dernière phrase.
                                                </li>
                                            </ul>
                                        </b>
                                    </div>
                                </div>
                                <div class="question-text">
                                    <strong>Question <span name="numQuestionScript"></span> :</strong>
                                    <p class="text-justify" id="textConfirmPriseEnCharge">
                                        Je vous remercie chaleureusement, [Prénom du prospect], pour votre disponibilité et votre
                                        attention.  <br>
                                        Je vous souhaite une excellente journée, au plaisir de notre prochain échange. À très
                                        bientôt !
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
console.log("1")
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