<div class="script-container" style="margin-top:15px; padding:10px;border: 1px solid green"
                    id="divBodyRvPerso">
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

                    
                </div>