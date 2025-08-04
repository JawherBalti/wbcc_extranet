<div class="col-md-3 col-sm-12 col-xs-12">
    <div class="card" style="margin-top:15px;">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-info-circle text-primary"></i> Informations
            </h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <h6 class="text-muted">Entreprise</h6>
                <p class="mb-1"><?= $company ? $company->name : 'Non définie' ?></p>
                <small class="text-muted"><?= $company ? $company->businessCity : '' ?></small>
            </div>
            
            <div class="mb-3">
                <h6 class="text-muted">Contact</h6>
                <p class="mb-1"><?= $gerant ? $gerant->prenom . ' ' . $gerant->nom : 'Non défini' ?></p>
                <small class="text-muted"><?= $gerant ? $gerant->email : '' ?></small>
            </div>

            <div class="mb-3">
                <h6 class="text-muted">Conseiller</h6>
                <p class="mb-1"><?= $auteur ?></p>
                <small class="text-muted">PROXINISTRE</small>
            </div>

            <div class="mb-3">
                <h6 class="text-muted">Date</h6>
                <small class="text-muted"><?= date('d/m/Y H:i') ?></small>
            </div>
        </div>
    </div>

    <!-- Progression -->
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-tasks text-success"></i> Progression
            </h5>
        </div>
        <div class="card-body">
            <div class="progress mb-2">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
            </div>
            <small class="text-muted" id="progressText">Étape 1 sur 6</small>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="card mt-3">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-tools text-warning"></i> Actions
            </h5>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-outline-primary btn-block mb-2" onclick="saveProgress()">
                <i class="fas fa-save"></i> Sauvegarder
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary btn-block mb-2" onclick="resetForm()">
                <i class="fas fa-undo"></i> Réinitialiser
            </button>
            <button type="button" class="btn btn-sm btn-outline-info btn-block" onclick="showHelp()">
                <i class="fas fa-question-circle"></i> Aide
            </button>
        </div>
    </div>
</div>
