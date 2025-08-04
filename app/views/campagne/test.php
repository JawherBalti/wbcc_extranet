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