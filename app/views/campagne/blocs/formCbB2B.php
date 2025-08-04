<?php
/**
 * Company Form Component
 * 
 * Variables needed:
 * - $company (object|null): Company data object
 * - $options (array): Configuration options (optional)
 *   - showStatus (bool): Show status field
 *   - showWhatsApp (bool): Show WhatsApp button
 *   - showEmailButton (bool): Show email button
 *   - showWebsiteButton (bool): Show website button
 *   - readonlyPostalCode (bool): Make postal code readonly
 *   - readonlyCity (bool): Make city readonly
 */

// Set default options if not provided
$options = $options ?? [
    'showStatus' => false,
    'showWhatsApp' => true,
    'showEmailButton' => true,
    'showWebsiteButton' => true,
    'readonlyPostalCode' => true,
    'readonlyCity' => true
];
?>

<div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC">
    <div class="container-fluid px-0">
        <div class="row">
            <!-- Nom -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Dénomination Sociale</label>
                <input type="text" name="name" class="form-control" required id="nomCompany"
                    value="<?= htmlspecialchars($company->name ?? '') ?>">
            </div>
            
            <!-- Enseigne -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Enseigne</label>
                <input type="text" name="enseigne" class="form-control" id="enseigne"
                    value="<?= htmlspecialchars($company->enseigne ?? '') ?>">
            </div>
            
            <!-- Status (HIDDEN - exactly as in original) -->
            <div class="form-group col-4 col-md-4 col-sm-4" hidden>
                <label class="font-weight-bold">Statut</label>
                <div class="input-group">
                    <input type="text" id="statusInput" name="status" class="form-control" readonly
                        value="<?= htmlspecialchars($company->category ?? '') ?>">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-red" data-toggle="modal"
                            data-target="#statusModal">
                            Charger
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Activité -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Activité</label>
                <input type="text" name="industry" class="form-control"
                    value="<?= htmlspecialchars($company->industry ?? '') ?>">
            </div>
        </div>
        
        <!-- Rest of your form remains exactly the same -->
        <div class="row">
            <!-- Téléphone -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Téléphone</label>
                <div class="input-group">
                    <input type="tel" name="businessPhone" class="form-control" id="telCompany"
                        value="<?= htmlspecialchars($company->businessPhone ?? '') ?>"
                        placeholder="Entrez le numéro de téléphone">
                    <?php if ($company && $company->businessPhone): ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success" title="WhatsApp">
                                <a target="_blank"
                                    href="https://api.whatsapp.com/send?phone=33<?= str_replace(' ', '', $company->businessPhone) ?>"
                                    style="color: #ffffff;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group col-md-4 col-4 col-sm-4">
                <label class="font-weight-bold">Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control" id="emailCompany"
                        value="<?= htmlspecialchars($company->email ?? '') ?>" placeholder="Entrez l'adresse email">
                    <?php if ($company && $company->email): ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success" title="Envoyer un email">
                                <a href="mailto:<?= htmlspecialchars($company->email) ?>" style="color: #ffffff;">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Site Web -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Site Web</label>
                <div class="input-group">
                    <input type="url" name="webaddress" class="form-control"
                        value="<?= htmlspecialchars($company->webaddress ?? '') ?>"
                        placeholder="https://www.exemple.com">
                    <?php if ($company && $company->webaddress): ?>
                        <div class="input-group-append">
                            <a href="<?= strpos($company->webaddress, 'http') === 0 ? htmlspecialchars($company->webaddress) : 'https://' . htmlspecialchars($company->webaddress) ?>"
                                target="_blank" class="btn"
                                style="background-color: #2196F3; color: #ffffff; border-radius: 5px;">
                                <i class="fas fa-globe" style="color: #ffffff;"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Adresse -->
            <div class="col-md-4 col-4 col-sm-4">
                <div class="col-md-12">
                    <label class="font-weight-bold">Adresse 1</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="businessLine1" id="businessLine1" class="form-control"
                        value="<?= htmlspecialchars($company->businessLine1 ?? '') ?>">
                </div>
            </div>

            <!-- Code Postal -->
            <div class="col-md-4 col-4 col-sm-4">
                <div class="col-md-12">
                    <label class="font-weight-bold">Code Postal</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="businessPostalCode" id="businessPostalCode"
                        class="form-control" readonly
                        value="<?= htmlspecialchars($company->businessPostalCode ?? '') ?>">
                </div>
            </div>

            <!-- Ville -->
            <div class="col-md-4 col-4 col-sm-4">
                <div class="col-md-12">
                    <label class="font-weight-bold">Ville</label>
                </div>
                <div class="col-md-12">
                    <input type="text" readonly name="businessCity" id="businessCity" class="form-control"
                        value="<?= htmlspecialchars($company->businessCity ?? '') ?>">
                </div>
            </div>
        </div>
    </div>
</div>