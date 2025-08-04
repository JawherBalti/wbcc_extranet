<?php
$idAuteur = $_SESSION["connectedUser"]->idUtilisateur;
$auteur = $_SESSION["connectedUser"]->fullName;
$createDate = date('Y-d-m H:i:s');
$rv = false;
$rt = false;

// Initialisation des variables si elles n'existent pas
$gerant = $gerant ?? null;
$questScript = $questScript ?? null;

function checked($field, $value, $object, $action)
{
    return $object && isset($object->$field) && $object->$field == $value ? $action : '';
}

// Variables pour les blocs partagés
$imgUrl = '/public/img/logo_BATIRYM.png';
$titre = 'Campagne formation BATIRYM';
$icon = '<i class="fas fa-fw fa-scroll" style="color: #0066cc;"></i>';

?>

<!-- Include des blocs partagés -->
<?php
// Inclusion des styles
include_once dirname(__FILE__) . '/blocs/stylesFormation.php';
?>

<!-- Include des modals -->
<?php
include_once dirname(__FILE__) . '/blocs/modalsFormation.php';
include_once dirname(__FILE__) . '/../crm/blocs/boitesModal.php';
?>

<input type="hidden" id="contextType" value="<?= 'company' ?>">


<div class="col-12">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <!-- Include du bloc titre -->
            <?php
                $imgUrl = '/public/img/logo_BATIRYM.png';
                $titre = 'Campagne formation BATIRYM -';
                $icon = '<i class="fas fa-fw fa-scroll" style="color: #0066cc;"></i>';

                include_once dirname(__FILE__) .'/blocs/titre.php';
            ?>

            <!-- Include du bloc formulaire entreprise -->
            <?php
                // Set the variables before including
                $company = $company ?? null; // Your company data object or null for empty form
                $options = [
                    'showStatus' => true, // Show the status field
                    'showWhatsApp' => false // Hide WhatsApp button
                ];

                include_once dirname(__FILE__) . '/blocs/formCbB2B.php';
            ?>
            <!-- include les questions  -->
            <?php include_once dirname(__FILE__) . '/blocs/questions/questionsFormationBATIRYM.php'; ?>
            
            
            
        </div>

        <!-- Include de la sidebar pour formation -->
        <?php include_once dirname(__FILE__) . '/blocs/sidebarFormation.php'; ?>
    </div>
</div>


<?php

include_once dirname(__FILE__) . '/blocs/scriptsFormation/scriptFormationBATIRYM.php';
?>

<?php
// include_once dirname(__FILE__) . '/../crm/blocs/functionBoiteModal.php';
?>

