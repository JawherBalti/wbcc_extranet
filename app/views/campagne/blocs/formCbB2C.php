<?php
/**
 * Reusable contact form component
 * @param object|null $contact Contact data object
 * @param object|null $connectedUser Currently logged in user object
 */
?>

<div class="script-container" style="margin-top:15px; padding:10px">
    <div class="container-fluid px-0">
        <div class="row">
            <!-- Civilité -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Civilité</label>
                <input type="text" name="civilite" class="form-control" required
                    value="<?= isset($contact) && $contact ? htmlspecialchars($contact->civilite) : '' ?>">
            </div>

            <!-- Prénom -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Prénom</label>
                <input type="text" name="prenom" class="form-control"
                    value="<?= isset($contact) && $contact ? htmlspecialchars($contact->prenom) : '' ?>">
            </div>

            <!-- Nom -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Nom</label>
                <input type="text" name="nom" class="form-control"
                    value="<?= isset($contact) && $contact ? htmlspecialchars($contact->nom) : '' ?>">
            </div>
        </div>
        
        <div class="row">
            <!-- Téléphone -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Téléphone</label>
                <div class="input-group">
                    <input type="tel" name="businessPhone" class="form-control"
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->tel) : '' ?>"
                        placeholder="Entrez le numéro de téléphone">
                    <?php if (isset($contact) && $contact && $contact->tel): ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success" title="WhatsApp">
                                <a target="_blank"
                                    href="https://api.whatsapp.com/send?phone=33<?= str_replace(' ', '', $contact->tel) ?>"
                                    style="color: #ffffff;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Email</label>
                <div class="input-group">
                    <input type="email" name="email" class="form-control"
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->email) : '' ?>" 
                        placeholder="Entrez l'adresse email">
                    <?php if (isset($contact) && $contact && $contact->email): ?>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-success" title="Envoyer un email">
                                <a href="mailto:<?= htmlspecialchars($contact->email) ?>" style="color: #ffffff;">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Statut -->
            <div class="form-group col-4 col-md-4 col-sm-4">
                <label class="font-weight-bold">Statut</label>
                <div class="input-group">
                    <input type="text" name="statut" class="form-control"
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->statut) : '' ?>"
                        placeholder="">
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Adresse -->
            <div class="col-md-4 col-4 col-sm-4 mb-3">
                <div class="col-md-12">
                    <label class="font-weight-bold">Adresse 1</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="adresse" class="form-control"
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->adresse) : '' ?>">
                </div>
            </div>

            <!-- Code Postal -->
            <div class="col-md-4 col-4 col-sm-4 mb-3">
                <div class="col-md-12">
                    <label class="font-weight-bold">Code Postal</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="codePostal" class="form-control" readonly
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->codePostal) : '' ?>">
                </div>
            </div>

            <!-- Ville -->
            <div class="col-md-4 col-4 col-sm-4 mb-3">
                <div class="col-md-12">
                    <label class="font-weight-bold">Ville</label>
                </div>
                <div class="col-md-12">
                    <input type="text" name="ville" class="form-control" readonly
                        value="<?= isset($contact) && $contact ? htmlspecialchars($contact->ville) : '' ?>">
                </div>
            </div>
        </div>
    </div>
</div>