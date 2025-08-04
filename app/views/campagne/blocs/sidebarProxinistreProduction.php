<div class="col-md-3 col-sm-12 col-xs-12">
            <div class="script-container"
                style="height:90%; padding-top: 10px; padding-left:10px; padding-right:10px; margin:20px; align-items: center;justify-content: center; border: 1px solid #36B9CC">
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
                    <a class="btn btn-warning d-flex align-items-center" onclick="showBody('Doc')"><i
                            class="fa fa-paper-plane mr-2"></i> Envoi Doc</a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-primary d-flex align-items-center" onclick="showBody('DSS')">
                        <i class="fas fa-fw fa-file mr-2"></i> DSS
                    </a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-danger d-flex align-items-center" onclick="showBody('SD')"><i
                            class="fa fa-paper-plane mr-2"></i> Signature Délégation</a>
                </div>
                <div class="mb-2">
                    <a class="btn btn-secondary d-flex align-items-center" onclick="showBody('RvRT')"><i
                            class="fa fa-paper-plane mr-2"></i>RDV Relvés Techniques</a>
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