<div class="script-container" style="margin-top:15px; padding:10px">
    <form id="scriptForm">
        <input hidden id="contextId" name="idProspect" value="<?= $prospect ? $prospect->id : 0 ?>">

        <!-- =================================================================== -->
        <!-- ÉTAPE 1 : PRÉSENTATION DU TÉLÉOPÉRATEUR ET DE BATIRYM             -->
        <!-- =================================================================== -->

        <!-- 1.1.1 Accroche initiale (pattern interrupt moderne) -->
        <div class="step active">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Parlez debout si possible, gardez le sourire dans la voix et une énergie naturelle.</li><li>Ce sont les 10 premières secondes qui décident de la suite.</li><li>N'entamez jamais un appel par "Je ne vous dérange pas ?" ou "Est-ce que vous avez un moment ?"</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 1 :</strong>
                        <p class="text-justify" style=" font-weight: bold;">
                            Bonjour Monsieur/Madame <?= $connectedUser->prenomContact ?>, ici <?= $connectedUser->nomContact ?> à l'appareil, je vous appelle de la société BATIRYM, spécialisée en rénovation professionnelle tous corps d'État en Île-de-France.
                        </p>
                        <p class="text-justify" style=" font-weight: bold;">
                            Nous avons récemment aidé plusieurs <span style="color: #003366; font-weight: bold;"><?= $company->industry ?></span> à moderniser leurs locaux pour booster leur activité.
                        </p>
                        <p class="text-justify" style=" font-weight: bold;">
                            Est-ce que je peux vous prendre 2 minutes pour voir si cela peut aussi vous intéresser ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>🎯 Variante personnalisable selon la cible:</label>
                                <select class="form-control" name="variante_accroche" onchange="updateAccroche(this.value)">
                                    <option value="">Sélectionner...</option>
                                    <option value="commercant">🏪 Commerçant</option>
                                    <option value="restaurant">🍽️ Restaurant</option>
                                    <option value="syndic">🏢 Syndic</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="variante-text" class="alert alert-info" style="font-style: italic; color: #6699cc;">
                                <span id="variante-content">Sélectionnez une variante pour personnaliser l'accroche</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.1.2 Identification du bon interlocuteur -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Ne forcez jamais un interlocuteur non qualifié.</li><li>Votre objectif ici est d'obtenir le bon contact, pas de convaincre à tout prix.</li><li>Montrez du respect et de la souplesse.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 2 :</strong>
                        <p class="text-justify" >
                            Est-ce bien vous qui vous occupez des éventuels travaux ou rénovations dans vos locaux ? Ou devrais-je plutôt parler à un responsable, associé ou gestionnaire ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes personnalisables :</strong><br>
                            <span id="variante-interlocuteur">◆ Est-ce que vous êtes le/la décisionnaire concernant l'aménagement ou la maintenance de ce local professionnel ?<br>
                            ◆ Qui serait la personne la plus appropriée pour parler de futurs projets de travaux dans votre établissement ?</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickInterlocuteur('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="bonInterlocuteur" class="btn-check" value="oui" /></div>✅ Bon interlocuteur</button>
                    <button onclick="selectRadio(this); onClickInterlocuteur('non');" type="button" class="option-button btn btn-warning"><div class="option-circle"><input type="radio" name="bonInterlocuteur" class="btn-check" value="non" /></div>❌ Mauvais interlocuteur</button>
                </div>
            </div>
            <div class="response-options" id="correction-interlocuteur" hidden>
                <hr>
                <div class="options-container col-md-11">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="background-color: #d1ecf1; padding: 10px; border: 1px solid #bee5eb; margin: 10px 0;">
                                <p class="font-weight-bold" style="color: #0c5460;">🔄 Informations du bon interlocuteur :</p>
                                <div class="alert alert-info" style="margin: 5px 0;">En attente d'identification du décideur</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3" id="divEnvoiDoc">
                    <!-- INFOS MAIL -->

                        <div class="response-options" id="sous-question-0"
                            <?= $questScript && $questScript->responsable == 'non' ? "" : ""; ?>>
                            <div class="options-container col-md-11">
                                <div class="row col-md-12">
                                    <div class="form-group col-md-4">
                                        <label for="">Civilité: <small class="text-danger">*</small>
                                        </label>
                                        <select class="form-control" name="civiliteResponsable"
                                            id="civiliteResponsable">
                                            <option value="">--Choisir--</option>
                                            <option value="Madame"
                                                <?= isset($questScript) && isset($questScript->civiliteResponsable) && ($questScript->civiliteResponsable == 'Mme' || $questScript->civiliteResponsable == 'Madame') ? 'Selected' : '' ?>>
                                                Madame</option>
                                            <option value="Monsieur"
                                                <?= isset($questScript) && isset($questScript->civiliteResponsable) && ($questScript->civiliteResponsable == 'M' || $questScript->civiliteResponsable == 'Monsieur') ? 'Selected' : '' ?>>
                                                Monsieur</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Prénom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="prenomResponsable"
                                            name="prenomResponsable"
                                            value="<?= isset($questScript) && isset($questScript->prenomResponsable) ? $questScript->prenomResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nom: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="nomResponsable"
                                            name="nomResponsable" value="<?= isset($questScript) && isset($questScript->nomResponsable) ? $questScript->nomResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Poste: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" name="jobTitleResponsable"
                                            value="<?= isset($questScript) && isset($questScript->jobTitleResponsable) ? $questScript->jobTitleResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Téléphone: <small class="text-danger">*</small>
                                        </label>
                                        <input type="text" class="form-control" id="telResponsable"
                                            name="telResponsable" value="<?= isset($questScript) && isset($questScript->telResponsable) ? $questScript->telResponsable : ''; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Email: <small class="text-danger">*</small>
                                        </label>
                                        <input class="form-control" type="text" id="emailResponsable"
                                            name="emailResponsable"
                                            value="<?= isset($questScript) && isset($questScript->emailResponsable) ? $questScript->emailResponsable : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info btn-sm mr-2">📞 Transférer appel</button>
                            <button type="button" class="btn btn-secondary btn-sm">📝 Ajouter note et rappeler</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.1.3 Brève présentation de BATIRYM -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Votre ton doit transmettre sérénité, fiabilité et fierté.</li><li>Ne parlez pas "comme un vendeur" mais comme un expert bienveillant.</li><li>Adoptez une posture de conseil, et non de sollicitation.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 3 :</strong>
                        <p class="text-justify" style=" padding: 10px; border-left: 4px solid green;">
                            <b>BATIRYM</b> est une entreprise de <b>rénovation</b> tous corps d'État créée en <b>2011</b>, qui accompagne les <b>professionnels</b> de tous secteurs dans leurs projets d'aménagement, de réhabilitation ou de mise en conformité.
                        </p>
                        <p class="text-justify" style=" padding: 10px; border-left: 4px solid green;">
                            Nous intervenons exclusivement en <b>Île-de-France</b>, avec une équipe complète capable de gérer un chantier de A à Z – étude, devis, coordination, exécution et finitions.
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes personnalisables :</strong><br>
                            ◆ Nous avons plus de 14 ans d'expérience dans les rénovations de commerces, restaurants et bureaux.<br>
                            ◆ BATIRYM est aussi référencée pour des missions techniques plus complexes en copropriétés ou bâtiments tertiaires.
                        </div>
                        <div style="margin-top: 10px;">
                            <a href="#" onclick="openReferencesModule(); return false;" style="color: #007bff; text-decoration: underline;">
                                🔗 Accéder aux références client BATIRYM
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.2 Permission explicite de poursuivre -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Obtenir un "oui" ici, même tacite, augmente l'attention du prospect.</li><li>Ne poursuivez jamais automatiquement si vous sentez que la personne est pressée, stressée ou agacée.</li><li>Évitez "Je vous dérange ?" qui pousse naturellement au "Oui" de rejet.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>⏰ Question 4 :</strong>
                        <p class="text-justify" style="font-weight: bold;">
                            Est-ce que je peux vous prendre 2 petites minutes pour vous expliquer ce que nous faisons, et voir si cela pourrait vous être utile ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes personnalisables :</strong><br>
                            ◆ Est-ce que vous auriez 2 minutes pour que je vous expose rapidement notre démarche ?<br>
                            ◆ Je me permets de vous appeler juste pour vous faire découvrir ce que nous proposons. Est-ce que je peux vous expliquer en 2 minutes chrono ?<br>
                            ◆ Vous me dites si ce n'est pas le moment – je serai très bref, promis. Deux minutes seulement.
                        </div>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickPermission('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="permissionPoursuivre" class="btn-check" value="oui" /></div>✅ Accepte d'écouter</button>
                    <button onclick="selectRadio(this); onClickPermission('non');" type="button" class="option-button btn btn-warning"><div class="option-circle"><input type="radio" name="permissionPoursuivre" class="btn-check" value="non" /></div>❌ Hésite ou décline</button>
                </div>
            </div>
            <div class="response-options" id="div-reprogrammation" hidden>
                <hr><p class="font-weight-bold">📅 Options de reprogrammation :</p>
                <div class="options-container">
                    <button onclick="selectRadio(this); storeEngagementTag('Prospect engagé (2 min)');" type="button" class="option-button btn btn-info"><div class="option-circle"><input type="radio" name="option_reprog" value="doc_rappel" /></div>📧 Envoyer documentation + planifier rappel</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-secondary"><div class="option-circle"><input type="radio" name="option_reprog" value="rappel_seul" /></div>📞 Planifier rappel sans documentation</button>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 2 : QUALIFICATION DU PROSPECT                               -->
        <!-- =================================================================== -->

        <!-- 2.1 Questions d'exploration du besoin -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Posez une question à la fois, puis laissez le silence.</li><li>Si la personne répond "Non, rien de prévu", relancez avec une question douce.</li><li>N'interprétez pas trop vite les signaux faibles : écoutez avec attention et prenez des notes.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>🔍 Question 5 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Dites-moi, est-ce que vous avez récemment envisagé de faire des travaux dans vos locaux ? Que ce soit pour améliorer l'agencement, la mise aux normes, ou même pour rénover ?
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            📅 Depuis combien de temps occupez-vous ce local ?
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            🎯 Si vous deviez améliorer un aspect de votre établissement, lequel vous semblerait prioritaire ? (L'accueil client ? L'ambiance ? L'espace de travail ? Le confort thermique ?)
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            💬 Est-ce que vous avez déjà eu des remarques de clients, de collaborateurs ou du syndic concernant l'état des lieux ou un besoin de mise en conformité ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <label>📝 Zone de prise de notes rapide :</label>
                    </div>
                    <div class="col-md-6">
                        <div class="col-12 text-left">
                            <input type="radio" name="statut_besoin" value="besoin_detecte" id="besoin_detecte">
                            <label for="besoin_detecte">✅ Besoin détecté</label>
                        </div>
                        <div class="col-12 text-left">
                            <input type="radio" name="statut_besoin" value="projet_reflexion" id="projet_reflexion">
                            <label for="projet_reflexion">⏳ Projet en réflexion</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="col-12 text-left">
                            <input type="radio" name="statut_besoin" value="pas_besoin" id="pas_besoin">
                            <label for="pas_besoin">❌ Pas de besoin immédiat</label>
                        </div>
                        <div class="col-12 text-left">
                            <input type="radio" name="statut_besoin" value="refus_repondre" id="refus_repondre">
                            <label for="refus_repondre">🚫 Refus de répondre</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>⏰ Intention temporelle :</label>
                            <select class="form-control" name="intention_temporelle">
                                <option value="">Sélectionner...</option>
                                <option value="court_terme">Court terme</option>
                                <option value="moyen_terme">Moyen terme</option>
                                <option value="pas_de_projet">Pas de projet</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>📝 Notes détaillées :</label>
                            <textarea class="form-control" name="notes_besoin" rows="3" placeholder="Noter les éléments mentionnés par le prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions personnalisables selon le secteur -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Adaptez la question selon le secteur identifié.</li><li>Si le prospect semble embarrassé, proposez des exemples concrets d'amélioration.</li><li>Écoutez activement pour repérer les leviers d'intérêt ou d'urgence.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>🎯 Question 6 :</strong>
                        <div id="questions-secteur">
                            <p class="text-justify">Les questions seront conditionnées à la sélection du groupe métier ci-dessous.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>🏪 Groupe métier (conditionne les questions personnalisables) :</label>
                            <select class="form-control" name="groupe_metier" onchange="updateQuestionsSecteur(this.value)">
                                <option value="">Sélectionner...</option>
                                <option value="commerce">Commerce / Boutique</option>
                                <option value="restaurant">Restaurant / Métier de bouche</option>
                                <option value="liberal">Cabinet médical / Profession libérale</option>
                                <option value="syndic">Syndic / Gestionnaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_secteur" rows="3" placeholder="Noter la réponse spécifique au secteur..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2.2 Classification du prospect -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Cette séquence doit paraître naturelle, jamais inquisitrice.</li><li>La formulation neutre est essentielle : évitez "C'est vous qui payez ?", préférez "C'est vous qui pilotez ce type de projet ?"</li><li>Ne pas insister si la personne ne veut pas répondre à une des questions.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📋 Question 7 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            🏢 Pour bien orienter notre échange, puis-je vous demander rapidement le type d'activité que vous exercez ici ?
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            🚪 Et ce local, c'est un établissement ouvert au public ou un espace de travail uniquement interne ?
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            🏠 Vous êtes propriétaire, locataire ou gestionnaire pour le compte d'un tiers ?
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            👥 Est-ce que vous êtes seul décisionnaire pour ce type de projet ou vous partagez cela avec d'autres personnes ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <div class="alert alert-success" id="badge-profil-prospect" style="display: none;">
                            <strong>🏷️ Badge "Profil Prospect" :</strong> <span id="profil-prospect-details"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>🏢 Secteur d'activité (regroupement APE) :</label>
                            <select class="form-control" name="secteur_activite" onchange="updateProfilProspect()">
                                <option value="">Sélectionner...</option>
                                <option value="commerce">Commerce</option>
                                <option value="restauration">Restauration</option>
                                <option value="profession_liberale">Profession libérale</option>
                                <option value="immobilier">Immobilier</option>
                                <option value="autres">Autres</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>🚪 Type de local :</label>
                            <select class="form-control" name="type_local" onchange="updateProfilProspect()">
                                <option value="">Sélectionner...</option>
                                <option value="erp">ERP</option>
                                <option value="bureaux">Bureaux</option>
                                <option value="boutique">Boutique</option>
                                <option value="atelier">Atelier</option>
                                <option value="immeuble_residentiel">Immeuble résidentiel</option>
                                <option value="parties_communes">Parties communes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>🏠 Statut du prospect :</label>
                            <select class="form-control" name="statut_prospect" onchange="updateProfilProspect()">
                                <option value="">Sélectionner...</option>
                                <option value="proprietaire">Propriétaire</option>
                                <option value="locataire">Locataire</option>
                                <option value="gestionnaire">Gestionnaire</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>👥 Rôle décisionnaire :</label>
                            <select class="form-control" name="role_decisionnaire">
                                <option value="">Sélectionner...</option>
                                <option value="decideur_direct">Décideur direct</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 3 : ARGUMENTAIRE GÉNÉRAL DE BATIRYM                         -->
        <!-- =================================================================== -->

        <!-- 3.1 Argumentaire général -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Présentez BATIRYM comme une solution, pas comme un prestataire parmi d'autres.</li><li>Ne listez pas les services comme une brochure : racontez une histoire concrète.</li><li>Alignez votre argumentaire sur les mots utilisés par le prospect.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 8 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            BATIRYM, c'est plus de 14 ans d'expérience en rénovation tous corps d'État pour les professionnels : commerçants, restaurateurs, professions libérales, syndics…
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            On intervient exclusivement en Île-de-France, avec nos propres équipes ou partenaires référencés, sur des travaux qui vont du simple réagencement à la rénovation complète.
                        </p>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Notre force, c'est de piloter le chantier de A à Z avec un interlocuteur unique, dans le respect du budget, des délais et des normes.
                        </p>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="alert alert-info" id="argumentaire-sectoriel" style="display: none;">
                    <strong>💡 Argumentaire sectoriel suggéré :</strong> <span id="argumentaire-sectoriel-content"></span>
                </div>
            </div>
        </div>

        <!-- 3.2 Variante argumentaire personnalisée (par segment APE) -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Adaptez l'argumentaire en fonction du segment APE identifié.</li><li>Mettez en avant les bénéfices spécifiques à leur activité.</li><li>Utilisez des exemples concrets si possible.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>💡 Question 9 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Pour un [segment APE], nous comprenons que [problématique spécifique au segment] est une préoccupation majeure. C'est pourquoi BATIRYM propose des solutions adaptées pour [bénéfice spécifique 1] et [bénéfice spécifique 2].
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Exemples de variantes :</strong><br>
                            ◆ Pour un restaurant : "Nous savons que l'optimisation de l'espace et le respect des normes d'hygiène sont cruciaux. Nos rénovations visent à améliorer votre flux de travail et l'expérience client."
                            ◆ Pour un commerce : "L'attractivité de votre point de vente est essentielle. Nous créons des espaces qui attirent et fidélisent votre clientèle, augmentant ainsi votre chiffre d'affaires."
                            ◆ Pour un syndic : "La valorisation du patrimoine et la sécurité des résidents sont nos priorités. Nous réalisons des travaux de réhabilitation qui augmentent la valeur de l'immeuble et le confort des occupants."
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Notes sur l'argumentaire personnalisé :</label>
                            <textarea class="form-control" name="notes_argumentaire_personnalise" rows="3" placeholder="Noter la réaction du prospect à l'argumentaire personnalisé..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 3.3 Phrase d’impact métier -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Utilisez une phrase d'impact courte et mémorable, spécifique au métier du prospect.</li><li>Elle doit résonner avec ses préoccupations quotidiennes.</li><li>L'objectif est de créer un déclic émotionnel ou de reconnaissance.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>⚡ Question 10 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            En somme, pour un [métier du prospect], nous vous aidons à [phrase d'impact métier].
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Exemples de phrases d'impact :</strong><br>
                            ◆ Pour un restaurateur : "...transformer votre espace pour maximiser votre rentabilité et le confort de vos clients."
                            ◆ Pour un commerçant : "...créer une expérience client inoubliable qui booste vos ventes."
                            ◆ Pour un professionnel libéral : "...offrir un cadre serein et professionnel qui renforce la confiance de vos patients/clients."
                            ◆ Pour un syndic : "...valoriser votre patrimoine immobilier et assurer la tranquillité de vos copropriétaires."
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Notes sur la phrase d'impact :</label>
                            <textarea class="form-control" name="notes_phrase_impact" rows="3" placeholder="Noter la réaction du prospect à la phrase d'impact..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- =================================================================== -->
        <!-- ÉTAPE 4 : TRAITEMENT EXPRESS DES OBJECTIONS                       -->
        <!-- =================================================================== -->

        <!-- 4.1. « Je n’ai pas de besoin » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Reconnaissez l'objection sans la contredire.</li><li>Reformulez pour montrer que vous avez compris.</li><li>Proposez une perspective différente ou un bénéfice indirect.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>🚫 Question 11 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je comprends tout à fait. Beaucoup de professionnels pensent ne pas avoir de besoin immédiat. Mais souvent, un petit aménagement ou une mise aux normes peut éviter des problèmes futurs ou même améliorer l'attractivité de votre établissement. Si vous deviez anticiper un seul point, lequel serait-ce ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Même si tout est parfait aujourd'hui, avez-vous déjà pensé à l'évolution de votre activité dans les 2-3 prochaines années ?"
                            ◆ "Parfois, un simple conseil peut faire la différence. Si je pouvais vous donner une astuce pour optimiser un espace, laquelle vous intéresserait ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_pas_besoin" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.2. « J’ai déjà un prestataire » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Félicitez le prospect d'avoir déjà un prestataire.</li><li>Positionnez BATIRYM comme une alternative ou un complément.</li><li>Mettez en avant un avantage différenciant de BATIRYM.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>🤝 Question 12 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            C’est une excellente nouvelle ! C’est important d’avoir des partenaires de confiance. Nous, chez BATIRYM, nous nous distinguons par notre approche globale et notre capacité à gérer des projets complexes de A à Z avec un interlocuteur unique. Est-ce que votre prestataire actuel vous offre cette même tranquillité d’esprit sur tous les corps de métier ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Nous intervenons souvent en complément d'équipes internes ou d'autres prestataires pour des expertises spécifiques. Y a-t-il un domaine où vous pourriez avoir besoin d'un regard neuf ?"
                            ◆ "Avez-vous déjà comparé les approches ? Nous pourrions vous apporter une perspective différente sur l'optimisation de vos espaces."
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_prestataire" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.3. « Ce n’est pas le moment » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Acceptez le fait que le timing n'est pas idéal.</li><li>Proposez de planifier un rappel à un moment plus opportun.</li><li>Offrez une ressource utile en attendant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>⏰ Question 13 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je comprends tout à fait, votre temps est précieux. Dans ce cas, je vous propose de planifier un bref rappel à un moment qui vous conviendrait mieux. Ou peut-être puis-je vous envoyer une courte documentation pour que vous ayez nos informations sous la main quand le moment sera plus propice ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Quel serait le meilleur moment pour vous recontacter, dans quelques semaines ou quelques mois ?"
                            ◆ "Y a-t-il un événement ou une échéance qui pourrait rendre nos services plus pertinents pour vous à l'avenir ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_pas_moment" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.4. « Je n’ai pas de budget » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Reconnaissez la contrainte budgétaire.</li><li>Mettez en avant le retour sur investissement ou les solutions adaptées à différents budgets.</li><li>Proposez une étude de faisabilité ou un devis estimatif.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>💰 Question 14 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je comprends, le budget est un élément clé dans tout projet. Chez BATIRYM, nous proposons des solutions adaptées à différentes enveloppes, et nos rénovations sont souvent un investissement qui génère un retour, que ce soit en termes d'attractivité, de fonctionnalité ou de conformité. Seriez-vous ouvert à une étude de faisabilité pour voir ce qui est réalisable dans votre budget ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Nous pouvons vous aider à prioriser les travaux les plus impactants, même avec un budget limité. Qu'est-ce qui serait le plus urgent pour vous ?"
                            ◆ "Parfois, des aides ou subventions sont disponibles pour certains types de rénovations. Avez-vous déjà exploré cette piste ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_budget" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.5. « Je ne vous connais pas » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Reconnaissez le manque de familiarité.</li><li>Mettez en avant la réputation, l'expérience ou les références de BATIRYM.</li><li>Proposez d'envoyer des éléments de preuve (portfolio, témoignages).</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>❓ Question 15 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            C’est tout à fait normal, nous sommes une entreprise de rénovation professionnelle basée en Île-de-France depuis 2011. Nous avons réalisé de nombreux projets pour des commerçants, restaurateurs et syndics. Je peux vous envoyer quelques-unes de nos références ou un lien vers notre site web pour que vous puissiez découvrir nos réalisations. Qu’en pensez-vous ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Nous sommes fiers de notre réputation et de la satisfaction de nos clients. Avez-vous des critères spécifiques pour choisir vos prestataires ?"
                            ◆ "Notre expertise est reconnue dans le secteur. Peut-être avez-vous déjà vu certaines de nos réalisations sans le savoir ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_pas_connu" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.6. « Rappelez-moi plus tard » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Acceptez la demande de rappel.</li><li>Proposez de définir une date et une heure précises pour le rappel.</li><li>Demandez si des informations spécifiques seraient utiles d'ici là.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 16 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Bien sûr, je peux vous rappeler plus tard. Pour être sûr de vous joindre au bon moment, quelle serait la date et l'heure qui vous conviendraient le mieux ? Y a-t-il des informations que je pourrais vous envoyer d'ici là pour préparer notre prochain échange ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Avez-vous une période de la journée ou de la semaine où vous êtes plus disponible ?"
                            ◆ "Pour notre prochain échange, y a-t-il un point particulier que vous souhaiteriez que j'aborde ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_rappeler_plus_tard" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 4.7. « Ce n’est pas moi qui décide » -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Reconnaissez le rôle du prospect et demandez à être mis en relation avec le décideur.</li><li>Expliquez l'intérêt pour le décideur de parler à BATIRYM.</li><li>Proposez d'envoyer des informations que le prospect pourra transmettre.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>👥 Question 17 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je comprends parfaitement. Pourrions-nous, dans ce cas, échanger quelques instants avec la personne en charge de ces décisions ? Cela nous permettrait de bien comprendre leurs besoins et de leur proposer une solution adaptée. Ou peut-être puis-je vous envoyer des informations que vous pourrez leur transmettre ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de relance :</strong><br>
                            ◆ "Quel serait le meilleur moyen de joindre cette personne ?"
                            ◆ "Y a-t-il un moment où vous êtes tous les deux disponibles pour un bref échange ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_objection_pas_decideur" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- =================================================================== -->
        <!-- ÉTAPE 5 : CONCLUSION DE L’APPEL                                   -->
        <!-- =================================================================== -->

        <!-- 5.1. Proposer un rendez-vous qualifié (présentiel ou visio) -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Proposez un rendez-vous qualifié comme prochaine étape logique.</li><li>Mettez en avant la valeur ajoutée de ce rendez-vous pour le prospect.</li><li>Soyez flexible sur le format (présentiel ou visio).</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>🗓️ Question 18 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Pour aller plus loin et évaluer précisément comment BATIRYM peut vous accompagner, je vous propose de planifier un court rendez-vous avec l'un de nos experts. Cela peut être en visio ou dans vos locaux, selon votre préférence. Qu'en pensez-vous ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de proposition :</strong><br>
                            ◆ "Notre expert pourra vous apporter des conseils personnalisés et une estimation plus précise de votre projet."
                            ◆ "Ce rendez-vous est sans engagement et nous permettra de mieux cerner vos besoins spécifiques."
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_rdv_qualifie" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 5.2. Si refus : envoi documentation + relance programmée -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Si le prospect refuse le rendez-vous, proposez une alternative douce.</li><li>L'objectif est de maintenir le contact et de ne pas fermer la porte.</li><li>Assurez-vous d'obtenir la permission d'envoyer la documentation et de planifier la relance.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📧 Question 19 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je comprends. Dans ce cas, je peux vous envoyer une documentation complète par email pour que vous ayez toutes les informations sur BATIRYM. Et si vous le souhaitez, je peux planifier une brève relance dans quelques semaines pour voir si la situation a évolué. Qu'en dites-vous ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de proposition :</strong><br>
                            ◆ "Cela vous permettrait d'avoir nos coordonnées et de nous recontacter quand vous le souhaitez."
                            ◆ "Nous pourrions fixer un rappel dans un mois, par exemple, juste pour un point rapide."
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_refus_rdv" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 5.3. Si doute : rappel à planifier dans CRM -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Si le prospect est hésitant, proposez un rappel sans pression.</li><li>L'objectif est de ne pas le brusquer et de lui laisser le temps de la réflexion.</li><li>Obtenez une date et une heure précises pour le rappel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>📞 Question 20 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Je sens une légère hésitation, ce qui est tout à fait normal. Je vous propose de planifier un rappel téléphonique dans quelques jours, juste pour faire un point rapide et répondre à d'éventuelles questions qui pourraient émerger. Quelle date et heure vous conviendraient le mieux ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de proposition :</strong><br>
                            ◆ "Nous pourrions faire un point en fin de semaine, cela vous laisserait le temps de digérer les informations."
                            ◆ "Y a-t-il un moment où vous êtes plus disponible pour un échange de 5 minutes ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>📝 Réponse du prospect :</label>
                            <textarea class="form-control" name="reponse_doute_rappel" rows="3" placeholder="Noter la réaction du prospect..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!-- 5.4. Confirmation finale des coordonnées -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . 
'/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content" style="background-color: #f8f9fa;"><b><ul><li>Confirmez les coordonnées du prospect pour s'assurer de la bonne transmission des informations.</li><li>Soyez précis et vérifiez chaque élément.</li><li>C'est une étape cruciale pour la suite du processus.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>✅ Question 21 :</strong>
                        <p class="text-justify" style="color: black; font-weight: bold;">
                            Pour être sûr que toutes les informations vous parviennent correctement, pourriez-vous me confirmer votre adresse email et votre numéro de téléphone ?
                        </p>
                        <div style="font-style: italic; margin-top: 10px;">
                            <strong>Variantes de confirmation :</strong><br>
                            ◆ "Je voudrais juste vérifier que j'ai bien noté votre email et votre numéro."
                            ◆ "Pour l'envoi de la documentation, c'est bien à cette adresse email ?"
                        </div>
                    </div>
                </div>
            </div>
            <div class="options-container col-md-11">
                <div class="row col-md-12">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>📧 Email :</label>
                            <input type="email" class="form-control" name="email_prospect" placeholder="Confirmer l'email...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>📞 Téléphone :</label>
                            <input type="tel" class="form-control" name="telephone_prospect" placeholder="Confirmer le numéro de téléphone...">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>📝 Notes de confirmation :</label>
                            <textarea class="form-control" name="notes_confirmation_coordonnees" rows="3" placeholder="Noter les éléments confirmés..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Navigation -->
        <div class="buttons">
            <button id="prevBtn" type="button" class="btn-prev hidden" onclick="goBackScript()">⬅ Précédent</button>
            <label>Page <span id="indexPage" class="font-weight-bold">1</span></label>
            <button id="nextBtn" type="button" class="btn-next" onclick="goNext()">Suivant ➡</button>
            <button id="finishBtn" type="button" class="btn-finish hidden" onclick="finish()">✅ Terminer</button>
        </div>
    </form>
</div>

        