<?php
/**
 * Contenu principal du formulaire pour Proxinistre B2B
 */
?>

<div class=" col-12">
    <div class="row">
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div
                style="margin-top:15px; padding:10px; border: 1px solid #36B9CC; border-radius: 20px; background-color: #fff; text-align: center;">
                <h2><span><i class="fas fa-fw fa-scroll" style="color: #c00000;"></i></span> CAMPAGNE PRODUCTION B2B
                    PROXINISTRE
                    <img style="height: 38px;" src="<?= URLROOT ?>/public/img/Logo-SOSINISTRE-by-PROXINISTRE.png"
                        alt="">
                </h2>
            </div>
            <div class="script-container" style="margin-top:15px; padding:10px; border: 1px solid #36B9CC">
                <div class="container-fluid px-0">
                    <div class="row">
                        <!-- Nom -->
                        <div class="form-group col-4 col-md-4 col-sm-4  ">
                            <label class="font-weight-bold">Dénomination Sociale</label>
                            <input type="text" name="name" class="form-control" required id="nomCompany"
                                value="<?= $company ? $company->name : '' ?>">
                        </div>
                        <!-- Enseigne -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Enseigne</label>
                            <input type="text" name="enseigne" class="form-control" id="enseigne"
                                value="<?= $company ? $company->enseigne : '' ?>">
                        </div>
                        <!-- Status -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 " hidden>
                            <label class="font-weight-bold">Statut</label>
                            <div class="input-group">
                                <input type="text" id="statusInput" name="status" class="form-control" readonly
                                    value="<?= $company ? $company->category : '' ?>">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-red" data-toggle="modal"
                                        data-target="#statusModal">
                                        Charger
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Activité -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Activité</label>
                            <input type="text" name="industry" class="form-control"
                                value="<?= $company ? $company->industry : '' ?>">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Téléphone -->
                        <div class="form-group   col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Téléphone</label>
                            <div class="input-group">
                                <input type="tel" name="businessPhone" class="form-control" id="telCompany"
                                    value="<?= $company ? $company->businessPhone : '' ?>"
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
                        <div class="form-group col-md-4  col-4 col-sm-4 ">
                            <label class="font-weight-bold">Email</label>
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" id="emailCompany"
                                    value="<?= $company ? $company->email : '' ?>" placeholder="Entrez l'adresse email">
                                <?php if ($company && $company->email): ?>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-success" title="Envoyer un email">
                                        <a href="mailto:<?= $company->email ?>" style="color: #ffffff;">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Site Web -->
                        <div class="form-group  col-4 col-md-4 col-sm-4 ">
                            <label class="font-weight-bold">Site Web</label>
                            <div class="input-group">
                                <input type="url" name="webaddress" class="form-control"
                                    value="<?= $company ? $company->webaddress : '' ?>"
                                    placeholder="https://www.exemple.com">
                                <?php if ($company && $company->webaddress): ?>
                                <div class="input-group-append">
                                    <a href="<?= strpos($company->webaddress, 'http') === 0 ? $company->webaddress : 'https://' . $company->webaddress ?>"
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
                        <div class="col-md-4  col-4 col-sm-4 ">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Adresse 1</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="businessLine1" id="businessLine1" class="form-control"
                                    value="<?= $company ? $company->businessLine1 : '' ?>">
                            </div>
                        </div>

                        <!-- Code Postal -->
                        <div class="col-md-4  col-4 col-sm-4 ">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Code Postal</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" name="businessPostalCode" id="businessPostalCode"
                                    class="form-control" readonly
                                    value="<?= $company ? $company->businessPostalCode : '' ?>">
                            </div>
                        </div>

                        <!-- Ville -->
                        <div class="col-md-4  col-4 col-sm-4 ">
                            <div class="col-md-12">
                                <label class="font-weight-bold">Ville</label>
                            </div>
                            <div class="col-md-12">
                                <input type="text" readonly name="businessCity" id="businessCity" class="form-control"
                                    value="<?= $company ? $company->businessCity : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Include du contenu du formulaire principal -->
            <?php include_once dirname(__FILE__) . '/blocs/formulaireProxinistreB2B.php'; ?>
        </div>

        <!-- Include de la sidebar -->
        <?php include_once dirname(__FILE__) . '/blocs/sidebarProxinistreB2B.php'; ?>
    </div>
</div>
