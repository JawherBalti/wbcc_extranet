<?php
// Formulaire spécifique B2C pour HB Assurance
// Variables attendues : $company, $options

$showStatus = $options['showStatus'] ?? true;
$showWhatsApp = $options['showWhatsApp'] ?? false;
$isB2C = $options['isB2C'] ?? false;
?>

<div class="form-container-b2c" style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
    <h5 class="text-primary mb-3">
        <i class="fas fa-user"></i> Informations Particulier
    </h5>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="civilite">Civilité</label>
                <select class="form-control" id="civilite" name="civilite">
                    <option value="">Sélectionner...</option>
                    <option value="M." <?= ($company && $company->civilite == 'M.') ? 'selected' : '' ?>>M.</option>
                    <option value="Mme" <?= ($company && $company->civilite == 'Mme') ? 'selected' : '' ?>>Mme</option>
                    <option value="Mlle" <?= ($company && $company->civilite == 'Mlle') ? 'selected' : '' ?>>Mlle</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" class="form-control" id="nom" name="nom" 
                       value="<?= $company ? htmlspecialchars($company->nom ?? '') : '' ?>" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" class="form-control" id="prenom" name="prenom" 
                       value="<?= $company ? htmlspecialchars($company->prenom ?? '') : '' ?>" required>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="telephone">Téléphone *</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" 
                       value="<?= $company ? htmlspecialchars($company->telephone ?? '') : '' ?>" required>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?= $company ? htmlspecialchars($company->email ?? '') : '' ?>">
            </div>
        </div>
        
        <?php if ($showStatus): ?>
        <div class="col-md-4">
            <div class="form-group">
                <label for="statut">Statut</label>
                <select class="form-control" id="statut" name="statut">
                    <option value="">Sélectionner...</option>
                    <option value="PROSPECT" <?= ($company && $company->statut == 'PROSPECT') ? 'selected' : '' ?>>Prospect</option>
                    <option value="CLIENT" <?= ($company && $company->statut == 'CLIENT') ? 'selected' : '' ?>>Client</option>
                    <option value="INACTIF" <?= ($company && $company->statut == 'INACTIF') ? 'selected' : '' ?>>Inactif</option>
                </select>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="form-group">
        <label for="adresse">Adresse</label>
        <input type="text" class="form-control" id="adresse" name="adresse" 
               value="<?= $company ? htmlspecialchars($company->adresse ?? '') : '' ?>">
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="codePostal">Code Postal</label>
                <input type="text" class="form-control" id="codePostal" name="codePostal" 
                       value="<?= $company ? htmlspecialchars($company->codePostal ?? '') : '' ?>">
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="form-group">
                <label for="ville">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" 
                       value="<?= $company ? htmlspecialchars($company->ville ?? '') : '' ?>">
            </div>
        </div>
    </div>
    
    <?php if ($isB2C): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="typeLogement">Type de logement</label>
                <select class="form-control" id="typeLogement" name="typeLogement">
                    <option value="">Sélectionner...</option>
                    <option value="APPARTEMENT">Appartement</option>
                    <option value="MAISON">Maison</option>
                    <option value="STUDIO">Studio</option>
                    <option value="AUTRE">Autre</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="situationFamiliale">Situation familiale</label>
                <select class="form-control" id="situationFamiliale" name="situationFamiliale">
                    <option value="">Sélectionner...</option>
                    <option value="CELIBATAIRE">Célibataire</option>
                    <option value="MARIE">Marié(e)</option>
                    <option value="PACS">Pacsé(e)</option>
                    <option value="DIVORCE">Divorcé(e)</option>
                    <option value="VEUF">Veuf/Veuve</option>
                </select>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="form-group">
        <label for="notes">Notes</label>
        <textarea class="form-control" id="notes" name="notes" rows="3"><?= $company ? htmlspecialchars($company->notes ?? '') : '' ?></textarea>
    </div>
</div>
