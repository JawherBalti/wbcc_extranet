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
                                        <option <?= $gerant && $gerant->civilite == "Monsieur" ? 'selected' : '' ?>
                                            value="Monsieur">Monsieur</option>
                                        <option <?= $gerant && $gerant->civilite == "Madame" ? 'selected' : '' ?>
                                            value="Madame">Madame</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Prénom</label>
                                    <input type="text" class="form-control" name="prenomGerant" ref="prenomGerant"
                                        id="prenomGerant" value="<?= $gerant ? $gerant->prenom : '' ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Nom</label>
                                    <input type="text" class="form-control" name="nomGerant" ref="nomGerant"
                                        id="nomGerant" value="<?= $gerant ? $gerant->nom : '' ?>">
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