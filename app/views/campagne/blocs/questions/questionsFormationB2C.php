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