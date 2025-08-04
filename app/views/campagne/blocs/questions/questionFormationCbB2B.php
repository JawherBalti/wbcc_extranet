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