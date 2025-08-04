<div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid orange"
                    id="divBodyDoc">
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