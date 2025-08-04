<div class="script-container" style="margin-top:15px; padding:10px">
    <form id="scriptForm">
        <input hidden id="contextId" name="idCompany" value="<?= $company ? $company->idCompany : 0 ?>">

        <!-- =================================================================== -->
        <!-- ÉTAPE 1 : INTRODUCTION DE L’APPEL (B2B)                           -->
        <!-- =================================================================== -->

        <!-- 1.1 Salutation et vérification de l’interlocuteur -->
        <div class="step active">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Utilisez un ton formel, cordial et très professionnel.</li><li>Vérifiez clairement l'identité de votre interlocuteur.</li><li>Si ce n’est pas le bon décideur, obtenez ses coordonnées.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">
                            Bonjour, <b style='color: blue;'><?=  (!empty($contact) ? ' <b>' . $contact->prenom . ' ' . $contact->nom . '</b>' : '') ?></b>, je suis <b><?= $connectedUser->fullName ?></b>, conseiller commercial chez <b>HB Assurance</b>, cabinet indépendant spécialisé dans l’optimisation des assurances professionnelles. <br>
                            Pourriez-vous me confirmer que vous êtes bien la personne en charge des contrats d’assurance au sein de votre entreprise ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickResponsable('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="decideurConfirme" class="btn-check" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this); onClickResponsable('non');" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="decideurConfirme" class="btn-check" value="non" /></div>Non</button>
                </div>
            </div>
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
                                                <select name="posteGerant" ref="posteGerant" id=""
                                                    class="form-control">
                                                    <option value="">Sélectionner...</option>
                                                    <option value="Dirigeant">Dirigeant</option>
                                                    <option value="Gérant">Gérant</option>
                                                    <option value="Responsable">Responsable</option>
                                                </select>
                                            </div>
                </div>
            </div>
        </div>

        <!-- 1.2 Présentation HB Assurance -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Présentez-vous clairement et brièvement.</li><li>Soulignez la spécialisation et la couverture nationale.</li><li>Adoptez un ton professionnel, cordial et rassurant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je me présente brièvement : je suis <b><?= $connectedUser->fullName ?></b>, conseiller commercial chez <b style="color: blue;">HB Assurance</b>, cabinet <b style="color: blue;">courtier indépendant en assurances professionnelles</b>. Nous intervenons sur <b style="color: blue;">toute la France</b> pour accompagner les entreprises dans l’optimisation de leurs contrats d’assurance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.3 Objet de l’appel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Exprimez clairement l'objectif de l'appel.</li><li>Insistez sur les bénéfices concrets : coûts et garanties.</li><li>Soyez attentif aux premières réactions.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je vous appelle aujourd’hui dans le cadre d’une campagne visant à l’<b style="color: green;">optimisation des contrats d’assurance</b> des entreprises comme la vôtre. L’objectif est simple : vous permettre de réaliser une <b style="color: green;">réduction significative des coûts 💰</b>, tout en bénéficiant d’une <b style="color: green;">amélioration des garanties 🛡️</b> de vos contrats actuels.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.4 Accroche personnalisée -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Personnalisez l'accroche avec le secteur d'activité.</li><li>Insistez sur l'audit gratuit.</li><li>Soyez attentif au niveau d'intérêt.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Étant donné votre activité dans le secteur <b style="color: blue;"><?= $company ? $company->industry : '[secteur d’activité précis]' ?></b>, HB Assurance vous propose de bénéficier d’un <b style="color: green;">audit rapide ⏱️</b> et <b style="color: green;">entièrement gratuit 🎁</b> de vos assurances professionnelles actuelles. Cela vous permettra de vérifier rapidement si vous disposez des meilleures garanties possibles, au tarif le plus avantageux.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.5 Demande d’autorisation -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Vérifiez la disponibilité de l'interlocuteur.</li><li>Proposez un RDV si nécessaire.</li><li>Rassurez sur le respect de son temps.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Auriez-vous quelques minutes à m’accorder maintenant pour que je puisse vous présenter brièvement notre proposition, ou préférez-vous que nous convenions d’un rendez-vous téléphonique à un autre moment qui vous conviendrait mieux ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickSiDsiponible('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="siDsiponible" class="btn-check" value="oui" /></div>Disponible maintenant</button>
                    <button onclick="selectRadio(this); onClickSiDsiponible('non');" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="siDsiponible" class="btn-check" value="non" /></div>Rendez-vous ultérieur</button>
                </div>
            </div>
            <div class="response-options" id="div-prise-rdv6" hidden>
                <!-- Le module de prise de RDV sera injecté ici par le JS existant -->
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 2 : QUALIFICATION DU PROSPECT (B2B)                         -->
        <!-- =================================================================== -->
        
        <!-- 2.1 Confirmation activité et zone géographique -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Vérifiez rapidement l'activité et la localisation.</li><li>Soyez concis et professionnel.</li><li>Rectifiez toute information erronée.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous proposer une offre parfaitement adaptée, pourriez-vous simplement me confirmer que votre entreprise exerce bien dans le secteur <b style="color: blue;"><?= $company ? $company->industry : '[secteur d’activité présumé]' ?></b>, et que votre zone d’intervention principale est bien située sur <b style="color: blue;"><?= $company ? $company->businessLine1 : '[zone géographique présumée]' ?></b> ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="">Activité confirmée/corrigée:</label>
                            <input type="text" class="form-control" id="activiteConfirmee" name="activiteConfirmee" value="<?= $company ? $company->industry : '' ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Zone géographique confirmée/corrigée:</label>
                            <input type="text" class="form-control" id="zoneConfirmee" name="zoneConfirmee" value="<?= isset($company) && isset($company->address) ? $company->address : '' ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2.3 Situation actuelle : Contrats en cours -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Obtenez ces informations clés de façon fluide.</li><li>Notez l'assureur et l'échéance.</li><li>Évaluez le niveau de satisfaction.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous faire gagner du temps et vous présenter des solutions vraiment adaptées, pourriez-vous m’indiquer rapidement quel est votre assureur actuel, la date approximative d’échéance de vos contrats, et votre niveau global de satisfaction concernant les garanties et tarifs en vigueur ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-4">
                            <label for="">Assureur actuel:</label>
                            <input type="text" class="form-control" id="assureurActuel" name="assureurActuel">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Date d'échéance des contrats:</label>
                            <input type="date" class="form-control" id="dateEcheance" name="dateEcheance">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Niveau de satisfaction:</label>
                            <select class="form-control" id="satisfaction" name="satisfaction">
                                <option value="satisfait">Satisfait</option>
                                <option value="moyennement">Moyennement satisfait</option>
                                <option value="insatisfait">Insatisfait</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2.4 Vérification du besoin potentiel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Validez rapidement le besoin pour orienter l'argumentaire.</li><li>Proposez d'autres typologies si besoin.</li><li>Cette étape oriente la suite du script.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Très rapidement, pourriez-vous me préciser parmi les assurances suivantes celles pour lesquelles vous seriez intéressé par une optimisation ou un devis comparatif gratuit : Multirisque immeuble, Multirisque industriel, RC professionnelle, Flotte automobile, Santé collective ou éventuellement une autre assurance spécifique ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container col-md-11">
                    <div class="row col-md-12" id="typeAssuranceDDE">
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('mri', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='mri' id='mri'
                                    name='besoin[]' class="besoin">
                                <label>🏢 Multirisque Immeuble</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('mrin', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='mrin'
                                    id='mrin' name='besoin[]' class="besoin">
                                <label>🏭 Multirisque Industriel</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('rcpro', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='rcpro'
                                    id='rcpro' name='besoin[]' class="besoin">
                                <label>👨‍⚖️ Responsabilité Civile Professionnelle (RC Pro)</label>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('flotte', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='flotte'
                                    id='flotte' name='besoin[]' class="besoin">
                                <label>🚗 Assurance Flotte Automobile</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('sante', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='sante'
                                    id='sante' name='besoin[]' class="besoin">
                                <label>❤️ Santé collective / prévoyance salariés</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('Autre', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='Autre' id='autre'
                                    name='besoin[]' class="besoin">
                                <label>Autre</label>
                            </div>
                        </div>
                        <div class='col-md-12'
                            <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('Autre', explode(";", $questScript->besoin))) ?  '' : "hidden") ?>
                            id="divAutreAssurance">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <label for=''>Précisez autre type d'assurance : </label>
                                </div>
                                <div class='col-md-12'>
                                    <input value='<?= isset($questScript) && isset($questScript->besoin_autre) ? $questScript->besoin_autre : '' ?>'
                                        type='text' name='besoin_autre' class='form-control'
                                        id='besoin_autre'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 3 : PRÉSENTATION GÉNÉRALE DES SERVICES                      -->
        <!-- =================================================================== -->

        <!-- 3.1 Présentation des produits -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Présentez succinctement les produits.</li><li>Personnalisez en insistant sur les plus pertinents.</li><li>Valorisez la diversité et l'expertise.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">HB Assurance vous accompagne sur l’ensemble des assurances professionnelles essentielles, notamment :<br>
                            • 🏢 La <b>Multirisque Immeuble</b> (propriétaires professionnels, syndicats copropriétés).<br>
                            • 🏭 La <b>Multirisque Industriel</b> (industriels, ateliers, entrepôts).<br>
                            • 👨‍⚖️ La <b>Responsabilité Civile Professionnelle (RC Pro)</b> (tous secteurs).<br>
                            • Mais aussi d’autres assurances telles que les <b>Flottes Automobiles</b> 🚗 ou encore la <b>Santé collective et prévoyance professionnelle</b> ❤️.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3.2 Avantages concurrentiels -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Insistez sur les bénéfices concrets.</li><li>Mettez en avant la valeur ajoutée du courtier indépendant.</li><li>Soyez attentif aux réactions positives.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Notre démarche chez HB Assurance repose sur plusieurs avantages concrets :<br>
                            • <b style="color: green;">Expertise indépendante et comparaison immédiate des offres 🔍</b>.<br>
                            • <b style="color: green;">Économies immédiates sur vos primes et optimisation des garanties 💰</b>.<br>
                            • <b style="color: green;">Réactivité, accompagnement personnalisé et gestion simplifiée avec interlocuteur unique 🤝</b>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3.3 Transition vers le script spécifique -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Orientez explicitement vers le besoin exprimé.</li><li>Validez avec enthousiasme l’intérêt identifié.</li><li>Soyez réactif pour maintenir l’attention.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Au regard des échanges que nous venons d’avoir, je vous propose de nous concentrer directement sur l’assurance qui semble la plus pertinente pour vous. Permettez-moi de vous présenter rapidement comment nous pouvons vous accompagner concrètement sur ce point précis.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 4 : DÉROULEMENT SPÉCIFIQUE (EMBRANCHEMENTS)                 -->
        <!-- =================================================================== -->

        <!-- 4.1 Cas spécifique : Multirisque Immeuble -->
        <div class="step" id="script-mri">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Posez des questions concises et claires.</li><li>Restez attentif aux détails mentionnés.</li><li>Adaptez votre rythme au prospect.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous proposer une offre parfaitement adaptée en <b>Multirisque Immeuble</b>, pourriez-vous m’indiquer rapidement :<br>
                            • La nature du bâtiment (Bureaux / Commercial / Mixte) ?<br>
                            • Le type d’occupation (Locataires / Copropriété) ?<br>
                            • Et les principales garanties de votre assurance actuelle ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-4">
                            <label><strong>Nature du bâtiment:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_nature_batiment" id="mri_bureaux" value="Bureaux">
                                <label class="form-check-label" for="mri_bureaux">Bureaux</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_nature_batiment" id="mri_commercial" value="Commercial">
                                <label class="form-check-label" for="mri_commercial">Commercial</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_nature_batiment" id="mri_mixte" value="Mixte">
                                <label class="form-check-label" for="mri_mixte">Mixte</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_nature_batiment" id="mri_autre_nature" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mri_autre_nature">Autre</label>
                            </div>
                            <div class="form-group" id="div_mri_autre_nature" style="display: none;">
                                <input type="text" class="form-control" name="mri_autre_nature_text" placeholder="Précisez...">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Type d'occupation:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_type_occupation" id="mri_locataires" value="Locataires">
                                <label class="form-check-label" for="mri_locataires">Locataires</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_type_occupation" id="mri_copropriete" value="Copropriété">
                                <label class="form-check-label" for="mri_copropriete">Copropriété</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_type_occupation" id="mri_usage_mixte" value="Usage mixte">
                                <label class="form-check-label" for="mri_usage_mixte">Usage mixte</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_type_occupation" id="mri_autre_occupation" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mri_autre_occupation">Autre</label>
                            </div>
                            <div class="form-group" id="div_mri_autre_occupation" style="display: none;">
                                <input type="text" class="form-control" name="mri_autre_occupation_text" placeholder="Précisez...">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Garanties actuelles:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_garanties" id="mri_incendie" value="Incendie">
                                <label class="form-check-label" for="mri_incendie">Incendie</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_garanties" id="mri_vol" value="Vol">
                                <label class="form-check-label" for="mri_vol">Vol</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_garanties" id="mri_degats_eaux" value="Dégâts des eaux">
                                <label class="form-check-label" for="mri_degats_eaux">Dégâts des eaux</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_garanties" id="mri_bris_glace" value="Bris de glace">
                                <label class="form-check-label" for="mri_bris_glace">Bris de glace</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mri_garanties" id="mri_autre_garantie" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mri_autre_garantie">Autre</label>
                            </div>
                            <div class="form-group" id="div_mri_autre_garantie" style="display: none;">
                                <input type="text" class="form-control" name="mri_autre_garantie_text" placeholder="Précisez...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.2 Cas spécifique : Multirisque Industriel -->
        <div class="step" id="script-mrin">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Obtenez des informations précises sur le risque.</li><li>Montrez votre expertise du secteur industriel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Pour votre <b>Multirisque Industrielle</b>, pourriez-vous m’indiquer :<br>
                            • Le type d’activité (atelier, usine, stockage) ?<br>
                            • Les risques spécifiques couverts (bris de machines, interruption d'activité) ?
                        </p>
                    </div>
                </div>
            </div>
             <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-4">
                            <label><strong>Nature du bâtiment:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_nature_batiment" id="mrin_bureaux" value="Bureaux">
                                <label class="form-check-label" for="mrin_bureaux">Bureaux</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_nature_batiment" id="mrin_commercial" value="Commercial">
                                <label class="form-check-label" for="mrin_commercial">Commercial</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_nature_batiment" id="mrin_mixte" value="Mixte">
                                <label class="form-check-label" for="mrin_mixte">Mixte</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_nature_batiment" id="mrin_autre_nature" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mrin_autre_nature">Autre</label>
                            </div>
                            <div class="form-group" id="div_mrin_autre_nature" style="display: none;">
                                <input type="text" class="form-control" name="mrin_autre_nature_text" placeholder="Précisez...">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Type d'occupation:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_type_occupation" id="mrin_locataires" value="Locataires">
                                <label class="form-check-label" for="mrin_locataires">Locataires</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_type_occupation" id="mrin_copropriete" value="Copropriété">
                                <label class="form-check-label" for="mrin_copropriete">Copropriété</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_type_occupation" id="mrin_usage_mixte" value="Usage mixte">
                                <label class="form-check-label" for="mrin_usage_mixte">Usage mixte</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_type_occupation" id="mrin_autre_occupation" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mrin_autre_occupation">Autre</label>
                            </div>
                            <div class="form-group" id="div_mrin_autre_occupation" style="display: none;">
                                <input type="text" class="form-control" name="mrin_autre_occupation_text" placeholder="Précisez...">
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label><strong>Garanties actuelles:</strong></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_garanties" id="mrin_incendie" value="Incendie">
                                <label class="form-check-label" for="mrin_incendie">Incendie</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_garanties" id="mrin_vol" value="Vol">
                                <label class="form-check-label" for="mrin_vol">Vol</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_garanties" id="mrin_degats_eaux" value="Dégâts des eaux">
                                <label class="form-check-label" for="mrin_degats_eaux">Dégâts des eaux</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_garanties" id="mrin_bris_machines" value="Bris de machines">
                                <label class="form-check-label" for="mrin_bris_machines">Bris de machines</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="mrin_garanties" id="mrin_autre_garantie" value="Autre" onclick="onClickAssurance(this, true)">
                                <label class="form-check-label" for="mrin_autre_garantie">Autre</label>
                            </div>
                            <div class="form-group" id="div_mrin_autre_garantie" style="display: none;">
                                <input type="text" class="form-control" name="mrin_autre_garantie_text" placeholder="Précisez...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.3 Cas spécifique : RC Pro -->
        <div class="step" id="script-rcpro">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Obtenez des informations précises sur le métier.</li><li>Insistez sur l'importance de bien comprendre leur activité.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Pour votre <b>RC Professionnelle</b>, pourriez-vous m’indiquer :<br>
                            • Les risques particuliers liés à votre métier ?<br>
                            • Votre chiffre d’affaires approximatif et le nombre d’employés ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-6">
                            <label for="">Chiffre d'affaires annuel:</label>
                            <input type="number" class="form-control" id="rcpro_ca" name="rcpro_ca">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Nombre d'employés:</label>
                            <input type="number" class="form-control" id="rcpro_employes" name="rcpro_employes">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">Risques particuliers du métier:</label>
                            <textarea class="form-control" id="rcpro_risques" name="rcpro_risques" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.4 Cas spécifique : Autres assurances -->
        <div class="step" id="script-autres">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Obtenez clairement les informations précises.</li><li>Soyez concret pour démontrer votre professionnalisme.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous proposer une solution parfaitement adaptée, pourriez-vous me préciser rapidement :<br>
                            • Le nombre de véhicules pour votre <b>flotte automobile</b> ?<br>
                            • Le nombre de salariés pour la <b>santé collective</b> ?<br>
                            • S’il s’agit d’un dirigeant seul ou d’associés pour la <b>prévoyance</b> ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="form-group col-md-4">
                            <label for="">Nombre de véhicules (Flotte):</label>
                            <input type="number" class="form-control" id="autres_flotte_nb" name="autres_flotte_nb">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nombre de salariés (Santé collective):</label>
                            <input type="number" class="form-control" id="autres_sante_nb" name="autres_sante_nb">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Type de dirigeant (Prévoyance):</label>
                            <select class="form-control" id="autres_prevoyance_type" name="autres_prevoyance_type">
                                <option value="dirigeant_seul">Dirigeant seul</option>
                                <option value="associes">Associés</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Argumentaire et proposition d'aller plus loin (commun à tous les produits) -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Proposez explicitement l'étape suivante.</li><li>Valorisez la gratuité et la rapidité.</li><li>Soyez réactif pour programmer un rendez-vous.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">
                           Merci pour ces précisions. Chez HB Assurance, nous pouvons vous garantir :<br>
                           • <b style="color: green;">Une couverture sur mesure adaptée à votre activité 🎯</b><br>
                           • <b style="color: green;">Une réduction significative des coûts grâce à la mise en concurrence 💰</b><br>
                           • <b style="color: green;">Une gestion rapide et simplifiée en cas de sinistre 🤝</b>
                        </p>
                        <hr>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">
                           Pour vous permettre de juger concrètement, je vous propose de réaliser un <b style="color: green;">audit gratuit</b> de vos contrats actuels et une <b style="color: green;">comparaison immédiate</b> des offres. Souhaitez-vous que nous fixions un rendez-vous avec l'un de nos experts ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="onClickSiRDVRappel('Accept RDV');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_audit" value="oui" /></div>Oui, fixer un RDV</button>
                    <button onclick="onClickSiRDVRappel('Refus RDV');" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_audit" value="non" /></div>Non, pas intéressé</button>
                </div>
            </div>
            <div class="response-options" id="div-prise-rdv2" hidden></div>

        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 5 : GESTION DES OBJECTIONS COURANTES                        -->
        <!-- =================================================================== -->

        <!-- 5.2.1 Objection : « Satisfait de mon assureur actuel » -->
        <div class="step" id="objection-satisfait">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez la satisfaction du prospect.</li><li>Proposez une alternative sans risque et sans engagement.</li><li>Soyez rassurant et confiant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends tout à fait votre satisfaction. Toutefois, pour vous assurer que vous bénéficiez toujours des meilleures conditions, HB Assurance vous propose une <b style="color: green;">comparaison gratuite et sans engagement 🔍</b>. Cela pourrait révéler des <b style="color: green;">gains financiers potentiels 💰</b> importants sans remettre en cause la qualité de votre couverture.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Seriez-vous intéressé par cette démarche rapide et gratuite ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_comparaison" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_comparaison" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- 5.2.2 Objection : « Pas de temps » -->
        <div class="step" id="objection-temps">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez la contrainte de temps.</li><li>Insistez sur la simplicité et la prise en charge complète.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement. Sachez que nous avons mis en place un <b style="color: green;">processus simplifié et rapide ⏱️</b>, où l'intégralité des démarches est <b style="color: green;">entièrement prise en charge par notre équipe 🤝</b>. Vous n'aurez quasiment aucune intervention à réaliser.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Seriez-vous rassuré(e) par cette prise en charge complète ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_processus" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_processus" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- 5.2.3 Objection : « Budget limité » -->
        <div class="step" id="objection-budget">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez la contrainte financière.</li><li>Proposez une solution axée sur les économies potentielles.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends votre préoccupation budgétaire. C'est précisément pourquoi nous proposons une <b style="color: green;">comparaison rapide des contrats 💰</b> qui permet généralement de réaliser des <b style="color: green;">économies immédiates très significatives</b>.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Seriez-vous intéressé(e) pour que nous réalisions cette analyse gratuite ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_analyse_budget" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_analyse_budget" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- 5.2.4 Objection : « Méfiance » -->
        <div class="step" id="objection-confiance">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Respectez la méfiance et proposez une rencontre.</li><li>Insistez sur la transparence et les références.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends votre hésitation. Pour bâtir une relation de confiance, je vous propose d'organiser une <b style="color: green;">rencontre physique ou visioconférence 🤝</b>, où nous pourrons vous présenter nos <b style="color: green;">références solides et vérifiables 📄</b>.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Seriez-vous disponible pour que nous fixions ensemble un rendez-vous ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_rdv_confiance" value="oui" /></div>Oui, fixer un RDV</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_rdv_confiance" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 6 : CONCLUSION ET PROCHAINES ÉTAPES                         -->
        <!-- =================================================================== -->

        <!-- 6.1 Synthèse -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Résumez clairement les points validés.</li><li>Soyez positif et confirmez la prochaine étape.</li><li>Assurez-vous que le prospect valide la synthèse.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Pour récapituler clairement notre échange, vous avez exprimé un intérêt pour une optimisation. Nous avons convenu de réaliser un <b style="color: blue;">audit gratuit</b>, un <b style="color: blue;">devis personnalisé</b>, et d'organiser un <b style="color: blue;">rendez-vous avec notre expert</b>. Est-ce bien exact pour vous ?</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6.2 Confirmation action concrète -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Confirmez explicitement la prochaine étape.</li><li>Proposez une action concrète.</li><li>Obtenez des informations précises.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Pour bien avancer ensemble, souhaitez-vous que nous fixions dès maintenant un rendez-vous, ou préférez-vous recevoir directement un email récapitulatif ou une proposition écrite détaillée ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-primary"><div class="option-circle"><input type="radio" name="actionConcrete" value="rdv" /></div>Prise de RDV</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-info"><div class="option-circle"><input type="radio" name="actionConcrete" value="email" /></div>Envoi Email</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-secondary"><div class="option-circle"><input type="radio" name="actionConcrete" value="proposition" /></div>Proposition écrite</button>
                </div>
            </div>
        </div>

        <!-- 6.3 Recueil dernières questions -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Vérifiez s'il reste des questions.</li><li>Rassurez sur votre disponibilité.</li><li>Fournissez les coordonnées directes.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Avant de conclure, avez-vous d'autres questions ? Sachez que je reste à votre disposition. Vous pouvez également joindre HB Assurance au <b style="color: blue;">(+33) 0182831125</b> ou par email à <b style="color: blue;">contact@hbassurance.com</b>.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6.4 Remerciements -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Clôturez avec enthousiasme et sincérité.</li><li>Restez professionnel et chaleureux.</li><li>Gardez un ton positif.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify"><b>Je tiens sincèrement à vous remercier pour le temps précieux que vous m'avez accordé aujourd'hui. Nous sommes ravis à l'idée de vous accompagner dans l'optimisation de vos assurances professionnelles. Je vous souhaite une excellente journée, et à très bientôt avec HB Assurance ! 👍</b></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 7 : CAS PARTICULIERS ET SCÉNARIOS SPÉCIAUX                  -->
        <!-- =================================================================== -->

        <!-- 7.1 Absence du décideur -->
        <div class="step" id="scenario-absent">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Identifiez clairement votre interlocuteur intermédiaire.</li><li>Laissez un message clair et professionnel.</li><li>Fixez une date précise pour le rappel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Bonjour, je suis <b><?= $connectedUser->fullName ?></b>, conseiller commercial chez <b>HB Assurance</b>. J'appelais pour échanger avec <b style="color: blue;"><?=  (!empty($contact) ? ' <b>' . $contact->prenom . ' ' . $contact->nom . '</b>' : '') ?></b> au sujet de l'optimisation de vos assurances professionnelles. Pourriez-vous lui transmettre mon appel, s'il vous plaît, et me dire quand je pourrais le joindre à nouveau ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <!-- <div class="form-group"><label>Coordonnées interlocuteur intermédiaire:</label><input type="text" class="form-control" name="coord_intermediaire"></div> -->
                <div class="form-group"><label>Date et heure de rappel programmées:</label><input type="datetime-local" class="form-control" name="rappel_programme"></div>
            </div>
        </div>

        <!-- 7.2 Rappel entrant d'un prospect -->
        <div class="step" id="scenario-rappel">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Présentez immédiatement l'objet initial de votre appel.</li><li>Qualifiez immédiatement le besoin.</li><li>Soyez clair et professionnel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Bonjour, je vous remercie pour votre rappel. Je suis <b><?= $connectedUser->fullName ?></b>, conseiller chez <b>HB Assurance</b>. Je vous avais contacté initialement concernant une optimisation possible de vos contrats d'assurances professionnelles. Afin d'être précis et rapide, pourriez-vous m'indiquer brièvement quel type d'assurance pourrait vous intéresser en priorité (Multirisque immeuble, industriel, RC Pro, flotte auto, santé collective...) ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container col-md-11">
                    <div class="row col-md-12" id="typeAssuranceDDE">
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('mri', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='mri' id='mri'
                                    name='besoin[]' class="besoin">
                                <label>🏢 Multirisque Immeuble</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('mrin', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='mrin'
                                    id='mrin' name='besoin[]' class="besoin">
                                <label>🏭 Multirisque Industriel</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('rcpro', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='rcpro'
                                    id='rcpro' name='besoin[]' class="besoin">
                                <label>👨‍⚖️ Responsabilité Civile Professionnelle (RC Pro)</label>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('flotte', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='flotte'
                                    id='flotte' name='besoin[]' class="besoin">
                                <label>🚗 Assurance Flotte Automobile</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('sante', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='sante'
                                    id='sante' name='besoin[]' class="besoin">
                                <label>❤️ Santé collective / prévoyance salariés</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input
                                    <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('Autre', explode(";", $questScript->besoin))) ?  'checked' : "") ?>
                                    onchange='onClickAssurance(this,1)' type='checkbox' value='Autre' id='autre'
                                    name='besoin[]' class="besoin">
                                <label>Autre</label>
                            </div>
                        </div>
                        <div class='col-md-12'
                            <?= (isset($questScript) && isset($questScript->besoin) != "" && (in_array('Autre', explode(";", $questScript->besoin))) ?  '' : "hidden") ?>
                            id="divAutreAssurance">
                            <div class='row'>
                                <div class='col-md-12'>
                                    <label for=''>Précisez autre type d'assurance : </label>
                                </div>
                                <div class='col-md-12'>
                                    <input value='<?= isset($questScript) && isset($questScript->besoin_autre) ? $questScript->besoin_autre : '' ?>'
                                        type='text' name='besoin_autre' class='form-control'
                                        id='besoin_autre'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7.3 Refus catégorique dès premier contact -->
        <div class="step" id="scenario-refus">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Respectez immédiatement le refus sans insistance.</li><li>Restez professionnel et cordial.</li><li>Transmettez les coordonnées HB Assurance.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre position et je vous remercie sincèrement pour votre franchise et le temps que vous m'avez accordé. Si jamais vos besoins évoluent à l'avenir, n'hésitez pas à nous contacter directement chez HB Assurance au <b style="color: blue;">(+33) 0182831125</b> ou par email à <b style="color: blue;">contact@hbassurance.com</b>. Je vous souhaite une excellente journée !</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7.4 Opportunité de prescription inverse -->
        <div class="step" id="scenario-prescription">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Soyez attentif pour détecter une opportunité.</li><li>Notez immédiatement ce besoin identifié.</li><li>Valorisez cette opportunité auprès du prospect.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je constate justement que vous avez actuellement un besoin précis concernant <b style="color: green;">[nature précise du besoin identifié]</b>. Je vous propose de transmettre immédiatement votre demande à notre équipe commerciale spécialisée afin qu'elle puisse vous contacter très rapidement avec une solution adaptée. Cela vous convient-il ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Nature précise du besoin identifié:</label>
                                <textarea class="form-control" name="besoin_prescription" rows="1"></textarea>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Priorité de traitement:</label>
                                <select class="form-control" name="priorite">
                                    <option value="elevee">Élevée</option>
                                    <option value="normale">Normale</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 8 : CONTRAINTES OPÉRATIONNELLES ET RECOMMANDATIONS          -->
        <!-- =================================================================== -->

        <!-- 8.1 Suivi interne (saisie CRM) -->
        <div class="step" id="suivi-crm">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Notez précisément les résultats de l'appel.</li><li>Soyez clair et synthétique dans votre résumé.</li><li>Programmez la prochaine relance si pertinent.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify"><b>Suivi CRM - Saisie immédiate du résultat</b></p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Statut appel:</label>
                                <select class="form-control" name="statut_appel">
                                    <option value="conclu_positivement">Conclu positivement</option>
                                    <option value="a_rappeler">À rappeler</option>
                                    <option value="refus_immediat">Refus immédiat</option>
                                </select>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label>Date prévue de rappel/relance (si nécessaire):</label>
                                <input type="datetime-local" class="form-control" name="date_relance">
                            </div>
                        </div>
                        <div class='col-md-12'>
                            <div class="form-group">
                                <label>Résumé rapide des échanges:</label>
                                <textarea class="form-control" name="resume_echanges"></textarea>
                            </div>
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


<script>
    function onClickSiRDVRappel(val) {
        if (val == "Refus RDV") {
            console.log(1)
            $("#div-prise-rdv2").attr("hidden", "hidden");
            $("#divChargementDisponibilite2").attr("hidden", "hidden");
            hidePlaceRdv2 = true;
            document.getElementById("div-prise-rdv2").innerHTML = '';
        } else {
            if (hidePlaceRdv2) {
                dateRDV = "";
                document.getElementById("div-prise-rdv2").innerHTML = htmlRDV2();
                getDisponiblites2();


                $("#div-prise-rdv2").removeAttr("hidden");
                $("#divChargementDisponibilite2").removeAttr("hidden");
                hidePlaceRdv2 = false;
                hidePlaceRdv2bis = true;
            }
        }
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
</script>