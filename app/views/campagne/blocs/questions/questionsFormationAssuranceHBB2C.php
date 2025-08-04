<div class="script-container" style="margin-top:15px; padding:10px">
    <form id="scriptForm">
        <input hidden id="contextId" name="idProspect" value="<?= $prospect ? $prospect->id : 0 ?>">

        <!-- =================================================================== -->
        <!-- ÉTAPE 1 : INTRODUCTION DE L'APPEL (B2C)                           -->
        <!-- =================================================================== -->

        <!-- 1.1 Salutation et validation identité -->
        <div class="step active">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Commencez par une salutation chaleureuse mais professionnelle.</li><li>Vérifiez rapidement l'identité de votre interlocuteur.</li><li>Si ce n'est pas la bonne personne, obtenez les bonnes coordonnées.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">
                            Bonjour, je suis <b><?= $connectedUser->fullName ?></b>, conseiller chez <b>HB Assurance</b>. Je souhaiterais m'assurer que je m'adresse bien à <b style='color: blue;'></b>. Est-ce bien le cas ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickIdentite('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="identiteConfirmee" class="btn-check" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this); onClickIdentite('non');" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="identiteConfirmee" class="btn-check" value="non" /></div>Non</button>
                </div>
            </div>

            <div class="col-md-12 mb-3" id="correction-identite" hidden>
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
                        <div class="tooltip-content"><b><ul><li>Présentez-vous clairement et avec enthousiasme.</li><li>Soulignez l'avantage concurrentiel : indépendance et réduction des coûts.</li><li>Maintenez un ton chaleureux et rassurant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Pour me présenter rapidement, je suis <b><?= $connectedUser->fullName ?></b>, conseiller chez <b style="color: blue;">HB Assurance</b>, cabinet <b style="color: blue;">indépendant spécialiste des assurances pour particuliers</b>. Notre métier consiste à vous aider à <b style="color: blue;">réduire concrètement vos coûts d'assurance</b>, tout en optimisant vos garanties.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.3 Accroche initiale et motif de l'appel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Présentez immédiatement l'objet précis de votre appel.</li><li>Insistez sur la gratuité et l'absence d'engagement.</li><li>Soyez dynamique, positif et chaleureux.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je vous contacte dans le cadre d'une campagne entièrement gratuite d'information destinée à optimiser vos contrats d'assurance : <b style="color: green;">emprunteur 🏠</b>, <b style="color: green;">santé ❤️</b>, <b style="color: green;">prévoyance 🛡️</b>, <b style="color: green;">automobile 🚗</b> ou encore <b style="color: green;">habitation 🏡</b>. L'objectif est simplement de vous permettre de réaliser rapidement des économies tout en améliorant vos garanties.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1.4 Demande d'autorisation de poursuivre -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Vérifiez explicitement la disponibilité du prospect.</li><li>Soyez flexible en proposant un rappel si nécessaire.</li><li>Restez professionnel et respectueux du temps.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Auriez-vous quelques instants à m'accorder dès maintenant afin que je puisse vous présenter rapidement comment vous pourriez bénéficier concrètement de ces économies, ou préférez-vous que nous programmions un rappel à un autre moment plus adapté pour vous ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this); onClickSiDsiponible('oui');" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="prospectDisponible" class="btn-check" value="oui" /></div>Disponible maintenant</button>
                    <button onclick="selectRadio(this); onClickSiDsiponible('non');" type="button" class="option-button btn btn-warning"><div class="option-circle"><input type="radio" name="prospectDisponible" class="btn-check" value="non" /></div>Souhaite être rappelé</button>
                </div>
            </div>
            <div class="response-options" id="div-prise-rdv" hidden>
                <!-- Le module de prise de RDV sera injecté ici par le JS existant -->
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 2 : QUALIFICATION RAPIDE DU PARTICULIER                     -->
        <!-- =================================================================== -->
        
        <!-- 2.1 Vérification du statut du prospect -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Soyez rapide, précis et cordial.</li><li>Expliquez que ces informations sont nécessaires pour une offre adaptée.</li><li>Écoutez activement pour anticiper les besoins.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin que je puisse vous proposer rapidement une offre vraiment adaptée à votre situation, pourriez-vous simplement m'indiquer :<br>
                            • Si vous êtes propriétaire ou locataire,<br>
                            • Si vous avez un emprunt immobilier en cours,<br>
                            • Votre statut professionnel (salarié, indépendant ou retraité),<br>
                            • Et enfin, si vous êtes célibataire, en couple ou en famille avec enfants ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="form-group">
                    <label>Statut habitation:</label>
                    <select class="form-control" name="statutHabitation">
                        <option value="proprietaire">🏠 Propriétaire</option>
                        <option value="locataire">🏡 Locataire</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Statut emprunteur:</label>
                    <select class="form-control" name="statutEmprunteur">
                        <option value="emprunteur">💰 Emprunteur immobilier</option>
                        <option value="non_emprunteur">❌ Non-emprunteur</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Situation professionnelle:</label>
                    <select class="form-control" name="situationPro">
                        <option value="salarie">👔 Salarié</option>
                        <option value="independant">💼 Indépendant</option>
                        <option value="retraite">👴 Retraité</option>
                        <option value="sans_activite">❌ Sans activité</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Situation familiale:</label>
                    <select class="form-control" name="situationFamiliale">
                        <option value="celibataire">👤 Célibataire</option>
                        <option value="couple">👫 En couple</option>
                        <option value="famille">👨‍👩‍👧‍👦 Famille avec enfants</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 2.2 Identification des assurances détenues -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Validez rapidement les assurances déjà souscrites.</li><li>Posez ces questions de manière fluide.</li><li>Écoutez activement pour orienter vers les solutions adaptées.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de mieux cibler les économies possibles pour vous, pourriez-vous simplement me préciser parmi ces assurances celles que vous possédez actuellement : <b>Auto</b> 🚗, <b>Habitation</b> 🏡, <b>Santé</b> ❤️, <b>Assurance emprunteur</b> 🏠, <b>Prévoyance individuelle</b> 🛡️ ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12" id="assurancesDetenues">
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='auto' 
                                    id='auto'
                                    name='assurancesDetenues[]' 
                                    class="assurance-detenue">
                                <label>🚗 Assurance Auto</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='habitation' 
                                    id='habitation'
                                    name='assurancesDetenues[]' 
                                    class="assurance-detenue">
                                <label>🏡 Assurance Habitation</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='sante' 
                                    id='sante'
                                    name='assurancesDetenues[]' 
                                    class="assurance-detenue">
                                <label>❤️ Assurance Santé complémentaire</label>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='emprunteur' 
                                    id='emprunteur'
                                    name='assurancesDetenues[]' 
                                    class="assurance-detenue">
                                <label>🏠 Assurance Emprunteur</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='prevoyance' 
                                    id='prevoyance'
                                    name='assurancesDetenues[]' 
                                    class="assurance-detenue">
                                <label>🛡️ Assurance Prévoyance individuelle</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2.3 Niveau de satisfaction actuel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Évaluez rapidement la satisfaction pour identifier les leviers commerciaux.</li><li>Soyez attentif aux nuances exprimées.</li><li>Restez fluide et dynamique.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">De façon très rapide, pourriez-vous simplement m'indiquer votre niveau global de satisfaction concernant vos assurances actuelles, notamment au niveau :<br>
                            • Des <b>tarifs proposés</b> 💰,<br>
                            • Des <b>garanties offertes</b> 🛡️,<br>
                            • Et enfin, de la <b>qualité générale du service</b> 🤝 que vous recevez actuellement ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="form-group">
                    <label>Satisfaction Tarifs:</label>
                    <select class="form-control" name="satisfactionTarifs">
                        <option value="satisfait">😊 Satisfait</option>
                        <option value="moyen">😐 Moyen</option>
                        <option value="insatisfait">😞 Insatisfait</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Satisfaction Garanties:</label>
                    <select class="form-control" name="satisfactionGaranties">
                        <option value="satisfait">😊 Satisfait</option>
                        <option value="moyen">😐 Moyen</option>
                        <option value="insatisfait">😞 Insatisfait</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Satisfaction Qualité Service:</label>
                    <select class="form-control" name="satisfactionService">
                        <option value="satisfait">😊 Satisfait</option>
                        <option value="moyen">😐 Moyen</option>
                        <option value="insatisfait">😞 Insatisfait</option>
                    </select>
                </div>
                
                <!-- Affichage du score prospect (calculé dynamiquement) -->
                <div class="alert alert-info mt-3" id="prospect-score-container" style="display: none;">
                    <h6><i class="fas fa-chart-line"></i> Qualification automatique du prospect :</h6>
                    <div id="prospect-score-display" class="font-weight-bold"></div>
                </div>
            </div>
        </div>

        <!-- 2.4 Validation du besoin potentiel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Vérifiez précisément les besoins réels du prospect.</li><li>Écoutez activement pour identifier les opportunités prioritaires.</li><li>Soyez professionnel et dynamique.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Parmi les assurances suivantes, pourriez-vous simplement me préciser celles pour lesquelles vous pourriez être intéressé(e) par une optimisation gratuite ou un devis rapide :<br>
                            <b>Emprunteur</b> 🏠, <b>Santé</b> ❤️, <b>Prévoyance individuelle</b> 🛡️, <b>Auto</b> 🚗, <b>Habitation</b> 🏡, <b>Animaux</b> 🐕, <b>Cyberassurance</b> 💻, ou éventuellement une autre assurance spécifique ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12" id="besoinsAssurance">
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='emprunteur' 
                                    id='besoin_emprunteur'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>🏠 Assurance Emprunteur</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='sante' 
                                    id='besoin_sante'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>❤️ Assurance Santé complémentaire</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='prevoyance' 
                                    id='besoin_prevoyance'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>🛡️ Assurance Prévoyance individuelle</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='auto' 
                                    id='besoin_auto'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>🚗 Assurance Auto</label>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='habitation' 
                                    id='besoin_habitation'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>🏡 Assurance Habitation</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='animaux' 
                                    id='besoin_animaux'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>🐕 Assurance Animaux</label>
                            </div>
                            <div class='col-12 text-left'>
                                <input 
                                    type='checkbox' 
                                    value='cyber' 
                                    id='besoin_cyber'
                                    name='besoins[]' 
                                    class="besoin-assurance">
                                <label>💻 Cyberassurance individuelle</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group"><label>Autre assurance spécifique:</label><input type="text" class="form-control" name="besoin_autre"></div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 3 : PRÉSENTATION SYNTHÉTIQUE DES SERVICES                   -->
        <!-- =================================================================== -->

        <!-- 3.1 Présentation des produits -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Présentez brièvement et clairement les principales assurances.</li><li>Valorisez l'intérêt immédiat de chaque type.</li><li>Restez dynamique et professionnel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">HB Assurance propose aux particuliers une gamme complète d'assurances spécialement conçues pour optimiser vos garanties et vos coûts :<br>
                            • <b style="color: green;">L'assurance emprunteur immobilier</b> avec des économies garanties 🏠,<br>
                            • <b style="color: green;">La complémentaire santé</b> avec de meilleurs remboursements à moindre coût ❤️,<br>
                            • <b style="color: green;">Une prévoyance individuelle</b> pour protéger financièrement votre famille 🛡️,<br>
                            • <b style="color: green;">L'assurance habitation</b> aux garanties étendues et optimisées 🏡,<br>
                            • <b style="color: green;">L'assurance automobile</b> avec économies immédiates et couverture adaptée 🚗,<br>
                            • Ainsi que des <b style="color: green;">assurances spécifiques</b> comme pour vos animaux 🐕, votre mobilité électrique ⚡, ou encore une cyberassurance individuelle 💻.
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
                        <div class="tooltip-content"><b><ul><li>Présentez succinctement ces points forts.</li><li>Valorisez l'indépendance, la simplicité et la rapidité.</li><li>Soyez dynamique et rassurant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Choisir HB Assurance, c'est bénéficier immédiatement :<br>
                            • D'une <b style="color: green;">indépendance totale avec un comparatif rapide des meilleures offres du marché 🔍</b>,<br>
                            • D'une <b style="color: green;">optimisation immédiate des coûts et de garanties parfaitement adaptées 💰</b>,<br>
                            • D'un <b style="color: green;">accompagnement entièrement personnalisé par un interlocuteur unique dédié 🤝</b>,<br>
                            • Et enfin, d'une <b style="color: green;">grande simplicité et rapidité des démarches administratives ⚡</b>, aussi bien pour souscrire que pour résilier vos contrats actuels.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3.3 Orientation vers le produit spécifique -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Orientez explicitement vers le produit identifié.</li><li>Montrez que vous avez compris ses besoins spécifiques.</li><li>Maintenez l'intérêt en confirmant l'adéquation.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Compte tenu des informations que vous m'avez indiquées, je vous propose que nous passions directement à l'assurance qui correspond précisément à vos attentes et à votre situation. Permettez-moi de vous présenter rapidement comment HB Assurance peut vous apporter une solution optimale sur ce point précis.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 4 : DÉROULEMENT SPÉCIFIQUE PAR PRODUIT (EMBRANCHEMENTS)     -->
        <!-- =================================================================== -->

        <!-- 4.1 Assurance emprunteur immobilier -->
        <div class="step" id="script-emprunteur">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Posez ces questions rapidement et clairement.</li><li>Soyez attentif aux détails fournis.</li><li>Adoptez un ton professionnel et bienveillant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vérifier rapidement si vous pouvez réaliser des économies significatives sur votre assurance emprunteur, pourriez-vous simplement m'indiquer :<br>
                            • Si vous avez actuellement un emprunt immobilier en cours,<br>
                            • Quelle est la durée restante approximative de votre emprunt,<br>
                            • Le montant approximatif de votre mensualité actuelle d'assurance,<br>
                            • Et enfin, les garanties principales souscrites dans votre contrat actuel ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Emprunt immobilier en cours:</label>
                                <select class="form-control" name="emprunt_en_cours">
                                    <option value="oui">Oui</option>
                                    <option value="non">Non</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Durée restante (en années):</label>
                                <input type="number" class="form-control" name="duree_restante">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mensualité actuelle d'assurance (€):</label>
                                <input type="number" class="form-control" name="mensualite_actuelle">
                            </div>
                            <div class="form-group">
                                <label>Garanties actuelles souscrites:</label>
                                <textarea class="form-control" name="garanties_actuelles"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.2 Assurance santé complémentaire -->
        <div class="step" id="script-sante">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Recueillez rapidement ces informations spécifiques.</li><li>Soyez précis et fluide dans vos questions.</li><li>Rassurez le prospect sur l'importance de ces données.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vérifier rapidement si nous pouvons améliorer votre couverture santé tout en réduisant vos coûts, pourriez-vous m'indiquer :<br>
                            • Le nom de votre mutuelle actuelle,<br>
                            • Le type de couverture santé dont vous bénéficiez,<br>
                            • Votre niveau global de remboursements actuel,<br>
                            • Et enfin, le montant approximatif que vous payez actuellement en primes mensuelles ou annuelles ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group"><label>Nom de la mutuelle actuelle:</label><input type="text" class="form-control" name="mutuelle_actuelle"></div>
                            <div class="form-group"><label>Type de couverture santé:</label><input type="text" class="form-control" name="type_couverture"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group"><label>Niveau global de remboursements:</label><input type="text" class="form-control" name="niveau_remboursements"></div>
                            <div class="form-group"><label>Montant approximatif des primes (€/mois):</label><input type="number" class="form-control" name="prime_mensuelle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.3 Assurance prévoyance individuelle -->
        <div class="step" id="script-prevoyance">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Recueillez clairement ces informations clés.</li><li>Soyez à l'écoute active et sensible.</li><li>Adoptez un ton rassurant et professionnel.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous proposer une offre parfaitement adaptée en prévoyance individuelle (décès-invalidité, accidents vie privée), pourriez-vous simplement me préciser :<br>
                            • Votre situation familiale actuelle (célibataire, en couple, avec enfants),<br>
                            • Votre situation professionnelle (salarié, indépendant, retraité),<br>
                            • Et si vous bénéficiez déjà actuellement d'une prévoyance individuelle ou collective ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="form-group">
                    <label>Situation familiale actuelle:</label>
                    <select class="form-control" name="situation_familiale_prev">
                        <option value="celibataire">Célibataire</option>
                        <option value="couple">En couple</option>
                        <option value="famille">Famille avec enfants</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Situation professionnelle actuelle:</label>
                    <select class="form-control" name="situation_pro_prev">
                        <option value="salarie">Salarié</option>
                        <option value="independant">Indépendant</option>
                        <option value="retraite">Retraité</option>
                        <option value="sans_activite">Sans activité</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Existence d'une prévoyance actuelle:</label>
                    <select class="form-control" name="prevoyance_existante">
                        <option value="individuelle">Individuelle</option>
                        <option value="collective">Collective</option>
                        <option value="aucune">Aucune</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 4.4 Assurance habitation -->
        <div class="step" id="script-habitation">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Posez rapidement ces questions spécifiques.</li><li>Adoptez un ton clair, rassurant et professionnel.</li><li>Restez attentif aux détails fournis.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vous proposer rapidement une assurance habitation optimisée et adaptée, pourriez-vous simplement m'indiquer :<br>
                            • Si votre logement est une maison ou un appartement,<br>
                            • Si vous êtes propriétaire ou locataire,<br>
                            • Le montant approximatif de votre prime actuelle d'assurance habitation,<br>
                            • Et enfin, les principales garanties actuellement souscrites dans votre contrat ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de logement:</label>
                                <select class="form-control" name="type_logement">
                                    <option value="maison">🏠 Maison</option>
                                    <option value="appartement">🏢 Appartement</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Statut d'occupation:</label>
                                <select class="form-control" name="statut_occupation">
                                    <option value="proprietaire">🔑 Propriétaire</option>
                                    <option value="locataire">🏡 Locataire</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Montant approximatif des primes actuelles (€/an):</label>
                                <input type="number" class="form-control" name="prime_habitation">
                            </div>
                            <div class="form-group">
                                <label>Garanties principales actuellement souscrites:</label>
                                <textarea class="form-control" name="garanties_habitation"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.5 Assurance automobile -->
        <div class="step" id="script-auto">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Posez rapidement ces questions précises.</li><li>Restez attentif aux détails donnés.</li><li>Maintenez un ton professionnel, rassurant et dynamique.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Afin de vérifier rapidement les économies possibles sur votre assurance automobile, pourriez-vous simplement m'indiquer :<br>
                            • Le type exact de votre véhicule (marque, modèle, année),<br>
                            • Le type de couverture d'assurance actuelle (tiers, tous risques, intermédiaire…),<br>
                            • Et enfin, le montant approximatif des primes annuelles que vous payez actuellement ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type de véhicule (Marque, modèle, année):</label>
                                <input type="text" class="form-control" name="type_vehicule" id="type_vehicule">
                            </div>
                            <div class="form-group">
                                <label>Type de couverture actuelle:</label>
                                <select class="form-control" name="couverture_auto">
                                    <option value="tiers">🚗 Tiers</option>
                                    <option value="tous_risques">🛡️ Tous risques</option>
                                    <option value="intermediaire">⚖️ Intermédiaire</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Montant approximatif des primes annuelles (€):</label>
                                <input type="number" class="form-control" name="prime_auto">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4.6 Assurances spécifiques -->
        <div class="step" id="script-specifiques">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Recueillez rapidement ces informations spécifiques.</li><li>Adoptez un ton dynamique et empathique.</li><li>Soyez clair, rapide et précis.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Très rapidement, pour vérifier si certaines assurances spécifiques pourraient vous être utiles, pourriez-vous simplement me préciser :<br>
                            • Si vous possédez un animal domestique (chien, chat ou autre),<br>
                            • Si vous utilisez un véhicule électrique (voiture, vélo, trottinette),<br>
                            • Ou encore, si vous avez des besoins spécifiques en protection numérique personnelle (cyberassurance) ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Animal domestique:</label>
                                <select class="form-control" name="animal_domestique">
                                    <option value="non">❌ Non</option>
                                    <option value="chien">🐕 Chien</option>
                                    <option value="chat">🐱 Chat</option>
                                    <option value="autre">🐾 Autre</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Véhicule électrique:</label>
                                <select class="form-control" name="vehicule_electrique">
                                    <option value="non">❌ Non</option>
                                    <option value="voiture">🚗 Voiture électrique</option>
                                    <option value="velo">🚲 Vélo électrique</option>
                                    <option value="trottinette">🛴 Trottinette électrique</option>
                                    <option value="autre">⚡ Autre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Besoins en protection numérique:</label>
                                <select class="form-control" name="protection_numerique">
                                    <option value="non">❌ Non</option>
                                    <option value="oui">💻 Oui</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Précisions sur les besoins spécifiques:</label>
                                <textarea class="form-control" name="besoins_specifiques"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Argumentaire et proposition d'action concrète (commun à tous les produits) -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Proposez directement les prochaines étapes concrètes.</li><li>Valorisez la gratuité, la rapidité et la précision.</li><li>Encouragez immédiatement à fixer un rendez-vous.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">
                           Merci pour ces précisions. Chez HB Assurance, nous pouvons vous garantir :<br>
                           • <b style="color: green;">Une couverture spécifique parfaitement adaptée 🎯</b><br>
                           • <b style="color: green;">Des tarifs très attractifs 💰</b><br>
                           • <b style="color: green;">Une facilité et rapidité de souscription immédiate ⚡</b>
                        </p>
                        <hr>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">
                           Pour vous permettre de constater immédiatement les avantages et économies possibles, je vous propose dès maintenant un <b style="color: green;">devis personnalisé immédiat gratuit</b>, ainsi qu'un <b style="color: green;">rendez-vous rapide avec un conseiller dédié</b>. Souhaitez-vous fixer ce rendez-vous dès maintenant ?
                        </p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_devis" value="oui" /></div>Oui, fixer un RDV</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_devis" value="non" /></div>Non, pas intéressé</button>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 5 : GESTION DES OBJECTIONS COURANTES                        -->
        <!-- =================================================================== -->

        <!-- 5.2.1 Objection : « Satisfait de mon assurance actuelle » -->
        <div class="step" id="objection-satisfait-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez immédiatement la satisfaction du prospect.</li><li>Valorisez fortement la gratuité et les économies potentielles.</li><li>Soyez rassurant et respectueux.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre satisfaction actuelle. Toutefois, pour être certain que vous bénéficiez des meilleures conditions possibles, HB Assurance vous propose une <b style="color: green;">comparaison rapide et gratuite sans engagement 🔍</b>, qui pourrait révéler des <b style="color: green;">économies immédiates potentielles 💰</b> tout en conservant ou améliorant vos garanties actuelles.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Souhaitez-vous en profiter rapidement ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_comparaison_b2c" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_comparaison_b2c" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- 5.2.2 Objection : « Pas le temps, pas intéressé » -->
        <div class="step" id="objection-temps-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Respectez la contrainte de temps sans insister.</li><li>Proposez une présentation ultra-rapide.</li><li>En cas d'impossibilité, proposez une replanification.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre contrainte de temps. Je peux simplement vous présenter en <b style="color: green;">moins de 2 minutes ⏱️</b> comment réaliser rapidement des économies intéressantes sur vos assurances. Si vous préférez, nous pouvons également fixer dès maintenant un <b style="color: green;">rapide rappel 📞</b> à un moment plus opportun pour vous.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Quelle solution préférez-vous ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="solution_temps" value="2min" /></div>Présentation 2 min</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-warning"><div class="option-circle"><input type="radio" name="solution_temps" value="rappel" /></div>Programmer rappel</button>
                </div>
            </div>
        </div>

        <!-- 5.2.3 Objection : « Méfiance ou manque de confiance » -->
        <div class="step" id="objection-confiance-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez explicitement et respectueusement la méfiance.</li><li>Proposez rapidement une présentation rassurante.</li><li>Encouragez immédiatement la prise d'un rendez-vous.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre prudence, il est normal de vouloir vous assurer de notre sérieux. Je vous propose donc une <b style="color: green;">présentation rapide des références solides d'HB Assurance 📄</b>, accompagnée de <b style="color: green;">témoignages positifs de nos nombreux clients satisfaits 😊</b>. Nous pouvons également fixer dès maintenant un <b style="color: green;">rendez-vous physique ou en visioconférence 🤝</b> pour mieux répondre à vos questions.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Souhaitez-vous convenir de ce rendez-vous dès à présent ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_rdv_confiance_b2c" value="oui" /></div>Oui, fixer un RDV</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_rdv_confiance_b2c" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- 5.2.4 Objection : « Prix trop élevés ou budget limité » -->
        <div class="step" id="objection-budget-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Reconnaissez clairement la contrainte financière.</li><li>Valorisez immédiatement les économies concrètes possibles.</li><li>Mentionnez les offres promotionnelles comme avantage supplémentaire.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre préoccupation budgétaire. Sachez que chez HB Assurance, nous proposons une <b style="color: green;">comparaison rapide et gratuite des offres du marché 🔍</b>, garantissant des <b style="color: green;">économies immédiates réelles 💰</b>. De plus, nous disposons actuellement de certaines <b style="color: green;">offres promotionnelles très intéressantes 🎁</b> qui pourraient correspondre parfaitement à votre budget.</p>
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p>Seriez-vous intéressé(e) par cette comparaison rapide pour vérifier les économies possibles dès maintenant ?</p>
                    </div>
                </div>
            </div>
             <div class="response-options">
                <div class="options-container">
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-success"><div class="option-circle"><input type="radio" name="accept_comparaison_budget" value="oui" /></div>Oui</button>
                    <button onclick="selectRadio(this);" type="button" class="option-button btn btn-danger"><div class="option-circle"><input type="radio" name="accept_comparaison_budget" value="non" /></div>Non</button>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 6 : CONCLUSION ET PROCHAINES ÉTAPES                         -->
        <!-- =================================================================== -->

        <!-- 6.1 Synthèse rapide de l'appel -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Résumez clairement et précisément les points validés.</li><li>Soyez positif, enthousiaste et rassurant.</li><li>Validez explicitement avec le prospect cette synthèse.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <strong>Question <span name="numQuestionScript"></span> :</strong>
                        <p class="text-justify">Pour récapituler rapidement notre échange, vous avez exprimé votre intérêt concernant une optimisation de vos assurances. Nous avons convenu ensemble des actions concrètes suivantes : réaliser un <b style="color: blue;">devis personnalisé</b>, organiser un <b style="color: blue;">rendez-vous</b>, et vous fournir un <b style="color: blue;">comparatif gratuit</b>. Est-ce bien exact pour vous ?</p>
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
                        <div class="tooltip-content"><b><ul><li>Confirmez explicitement les actions précises convenues.</li><li>Envoyez immédiatement le devis ou l'email récapitulatif.</li><li>Mentionnez clairement la prochaine étape.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je vous confirme donc que votre <b style="color: blue;">rendez-vous est bien fixé</b>, et qu'un <b style="color: blue;">devis détaillé va vous être envoyé immédiatement par email</b>. Vous recevrez également très prochainement une <b style="color: blue;">proposition personnalisée</b> parfaitement adaptée à votre situation. Tout est bien clair pour vous ?</p>
                    </div>
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
                        <div class="tooltip-content"><b><ul><li>Vérifiez explicitement s'il reste des questions.</li><li>Fournissez clairement les coordonnées directes HB Assurance.</li><li>Assurez-vous que le prospect sait comment vous recontacter.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Avant de conclure, avez-vous d'autres questions ou des précisions que vous souhaiteriez aborder ? Je reste personnellement disponible, et vous pouvez joindre directement HB Assurance au <b style="color: blue;">[numéro direct]</b> ou par email à <b style="color: blue;">[email direct HB Assurance]</b> pour toute demande complémentaire.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6.4 Remerciements chaleureux -->
        <div class="step">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Clôturez chaleureusement et avec professionnalisme.</li><li>Remerciez sincèrement pour le temps accordé.</li><li>Maintenez un ton chaleureux et rassurant.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify"><b>Je vous remercie sincèrement pour cet échange très agréable, et pour votre confiance envers HB Assurance. Nous restons entièrement à votre écoute si vous avez la moindre question ultérieurement. Je vous souhaite une excellente journée, à très bientôt ! 👍</b></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- ÉTAPE 7 : CAS PARTICULIERS ET SCÉNARIOS SPÉCIAUX                  -->
        <!-- =================================================================== -->

        <!-- 7.1 Prospect absent -->
        <div class="step" id="scenario-absent-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Laissez un message clair, court et professionnel.</li><li>Mentionnez explicitement vos coordonnées.</li><li>Programmez immédiatement un rappel futur clair.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Bonjour, je suis <b><?= $connectedUser->fullName ?></b>, conseiller chez <b>HB Assurance</b>. Je souhaitais simplement vous présenter rapidement comment optimiser vos assurances et réaliser des économies immédiates. Vous pouvez me rappeler directement au <b style="color: blue;">[numéro HB Assurance]</b> ou par email à <b style="color: blue;">[email HB Assurance]</b>. Je vous souhaite une excellente journée, à très bientôt !</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date et heure pour prochaine tentative de rappel:</label>
                                <input type="datetime-local" class="form-control" name="rappel_programme_b2c">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7.2 Rappel entrant du prospect -->
        <div class="step" id="scenario-rappel-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Rappelez immédiatement le contexte de votre appel initial.</li><li>Qualifiez immédiatement et précisément le besoin.</li><li>Restez professionnel, chaleureux et réactif.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Bonjour, merci beaucoup pour votre rappel ! Je suis <b><?= $connectedUser->fullName ?></b>, conseiller chez <b>HB Assurance</b>. Je vous avais contacté précédemment au sujet d'une optimisation possible de vos assurances. Afin de vous répondre précisément, pourriez-vous simplement me dire quel type d'assurance vous intéresse particulièrement (emprunteur, santé, prévoyance, habitation, auto...) ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Besoin spécifique identifié:</label>
                                <input type="text" class="form-control" name="besoin_rappel_b2c">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7.3 Refus catégorique immédiat -->
        <div class="step" id="scenario-refus-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Respectez immédiatement le refus catégorique sans insistance.</li><li>Restez courtois et chaleureux malgré le refus.</li><li>Laissez explicitement les coordonnées HB Assurance.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je comprends parfaitement votre décision et vous remercie sincèrement du temps accordé. Si toutefois vos besoins évoluent à l'avenir, n'hésitez pas à nous recontacter directement chez HB Assurance au <b style="color: blue;">[numéro téléphone]</b> ou par email à <b style="color: blue;">[email HB Assurance]</b>. Je vous souhaite une excellente journée !</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7.4 Opportunité prescription inverse -->
        <div class="step" id="scenario-prescription-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Soyez attentif pour identifier rapidement toute opportunité immédiate.</li><li>Notez précisément et immédiatement le besoin identifié.</li><li>Valorisez clairement cette opportunité auprès du prospect.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify">Je constate justement que vous avez actuellement un besoin précis concernant <b style="color: green;">[nature exacte du besoin identifié]</b>. Je vous propose donc de transmettre immédiatement votre demande à notre conseiller spécialisé, qui vous recontactera très rapidement pour vous proposer une solution adaptée. Cela vous convient-il ?</p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nature précise du besoin identifié:</label>
                                <textarea class="form-control" name="besoin_prescription_b2c"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Priorité de traitement:</label>
                                <select class="form-control" name="priorite_b2c">
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

        <!-- 8.1 Suivi interne immédiat (CRM) -->
        <div class="step" id="suivi-crm-b2c">
            <div class="question-box">
                <div class="agent-icon"><img src="<?= URLROOT . '/public/img/agent.png' ?>" alt="Agent" width="50"></div>
                <div class="question-content">
                    <div class="tooltip-container btn btn-sm btn-info float-right">
                        🧠 Consignes
                        <div class="tooltip-content"><b><ul><li>Remplissez immédiatement et précisément le suivi CRM.</li><li>Programmez clairement la prochaine relance si nécessaire.</li><li>Soyez synthétique et précis dans votre résumé.</li></ul></b></div>
                    </div>
                    <div class="question-text">
                        <p class="text-justify"><b>Suivi immédiat CRM - Saisie du résultat</b></p>
                    </div>
                </div>
            </div>
            <div class="response-options col-md-11">
                <div class="options-container col-md-11">
                    <div class="row col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut appel:</label>
                                <select class="form-control" name="statut_appel_b2c">
                                    <option value="conclu_positivement">Conclu positivement</option>
                                    <option value="a_relancer">À relancer ultérieurement</option>
                                    <option value="refus_immediat">Refus immédiat</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date prévue pour prochaine relance éventuelle:</label>
                                <input type="datetime-local" class="form-control" name="date_relance_b2c">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Résumé succinct échanges:</label>
                                <textarea class="form-control" name="resume_echanges_b2c" rows="4"></textarea>
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