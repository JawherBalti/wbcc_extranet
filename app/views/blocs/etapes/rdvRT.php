<div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid grey"
                    id="divBodyRvRT">
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