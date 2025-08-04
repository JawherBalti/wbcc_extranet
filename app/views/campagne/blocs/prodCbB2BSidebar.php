        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="script-container"
                style="min-height:90%; padding-top: 10px; padding-left:10px; padding-right:10px; margin:20px; align-items: center;justify-content: center; border: 1px solid #36B9CC">
                <div class="mb-2">
                    <a target="_blank" class="btn btn-info d-flex align-items-center"
                        href="<?= linkTo('CompanyGroup', 'company',  $company->idCompany)  ?>">
                        <i class="fas fa-info-circle mr-2"></i> Détails
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-info d-flex align-items-center" onclick="loadNotes('modal')">
                        <i class="fas fa-fw fa-file mr-2"></i> Liste des Notes
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-info d-flex align-items-center" onclick="showBody('Doc')"><i
                            class="fa fa-paper-plane mr-2"></i> Envoi Doc</a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-secondary d-flex align-items-center" onclick="showBody('Accueil')">
                        <i class="fas fa-door-open mr-2"></i> Accueil et introduction
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-secondary d-flex align-items-center" onclick="showBody('IndisponibelRappel')">
                        <i class="fas fa-phone-slash mr-2"></i> Indisponible -Planifier un rappel
                    </a>
                </div>
                <div class="menu-section">
                    <span class="icon-label">
                        <i class="fas fa-hand-point-right"></i> Objections
                    </span>
                    <div class="menu-divider"></div>
                </div>
                <div class="mb-2">
                    <a class="btn btn-warning d-flex align-items-center" onclick="showBody('PartenaireExistant')">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Partenaire existant
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-warning d-flex align-items-center" onclick="showBody('QuelAvantages')">
                        <i class="fas fa-question fa-file mr-2"></i> Quels avantages concrets
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-warning d-flex align-items-center" onclick="showBody('PasDetemps')"><i
                            class="fa fa-clock mr-2"></i> Pas le temps de nous en occuper</a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-warning d-flex align-items-center" onclick="showBody('MefianceInconnu')"><i
                            class="fa fa-ghost mr-2"></i>Méfiance / Inconnu</a>
                </div>
                <hr>
                <div class="mb-2">
                    <a class="btn btn-info d-flex align-items-center" onclick="showBody('PresentationPartenariat')">
                        <i class="fas fa-handshake mr-2"></i> Présentation du partenariat
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-success d-flex align-items-center" onclick="showBody('RvPerso')"><i
                            class="fa fa-paper-plane mr-2"></i> RDV Responsable</a>
                </div>
                <div class="mb-2">
                    <label for="">Note</label>
                    <textarea name="noteTextCampagne" id="noteTextCampagne" cols="10" rows="10" readonly
                        class="form-control"><?= ($questScript ? $questScript->noteTextCampagne : "") ?></textarea>
                </div>
            </div>
        </div>