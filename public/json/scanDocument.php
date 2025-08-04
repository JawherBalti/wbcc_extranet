<?php
header('Access-Control-Allow-Origin: *');
require_once "../../app/config/config.php";
require_once "../../app/libraries/Database.php";
require_once "../../app/libraries/SMTP.php";
require_once "../../app/libraries/PHPMailer.php";
require_once "../../app/libraries/Role.php";
require_once "../../app/libraries/Utils.php";
require_once "../../app/libraries/Model.php"; // Correct path to Model.php
require_once "../../app/models/Pointage.php";

// Add this at the top of your scanDocument.php file
require_once __DIR__ . '/../../vendor/autoload.php'; // Load Composer autoloader
use App\Libraries\DocumentPredictor;

if (isset($_GET['action'])) {
    $db = new Database();
    $action = $_GET['action'];

    if($action == "transferDocumentIA") {
        try {
            $db->query("SELECT * FROM wbcc_repertoire_commun WHERE isDeleted = 0 LIMIT 2");
            $documents = $db->resultset();

            foreach($documents as $docum) {
                $idDocument = $docum->idDocument;
                $repertoireCommun = 'public/documents/repertoireCommun/';
                $filename = $docum->urlDocument;

                
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/' . $repertoireCommun . $filename;
            $repertoiresDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/';
            
            $predictor = new DocumentPredictor();
            $result = $predictor->predictDocument($sourcePath);

            $category = $result['category'];
            $company = $result['company'];

            $role = "Administrateur";

            if($category == "administratif") {
                $role = "Manager";
            }

            if($category == "contrat" || $category == "courrier") {
                $role = "RH";
            }

            if($category == "releve") {
                $role = "Gestionnaire";
            }

            if($category == "facture" || $category =="bordereau") {
                $role = "Comptable";
            }

            //Déplacer document
                try {
                    $data = json_decode(file_get_contents('php://input'), true);

                    // Get absolute paths
                    // $sourcePath = $_SERVER['DOCUMENT_ROOT'] . $repertoireCommun . $filename;
                    $destinationDir = $repertoiresDir . $company . '/' . $category;
                    // Create destination directory if it doesn't exist
                    if (!file_exists($destinationDir)) {
                        if (!mkdir($destinationDir, 0777, true)) {
                            throw new Exception('Failed to create destination directory');
                        }
                    }
                    // Get filename from source path
                    $filename = basename($sourcePath);
                    $destinationPath = $destinationDir . '/' . $filename;

                    // Check if source file exists
                    if (!file_exists($sourcePath)) {
                        throw new Exception('Source file not found');
                    }

                    // First COPY the file (for safe rollback)
                    if (!copy($sourcePath, $destinationPath)) {
                        throw new Exception('Failed to copy file');
                    }

                    // Only DELETE original after successful copy
                    if (!unlink($sourcePath)) {
                        // If delete fails, remove the copied file to maintain consistency
                        unlink($destinationPath);
                        throw new Exception('Failed to remove original file');
                    }

                    //creation de la tache
                    if($company != "Unknown") {
                        //Sélectionner l'utilisateur avec le min d'activités
                        $db->query("SELECT u.*, c.*, COUNT(a.idActivity) AS activity_count FROM wbcc_utilisateur u
                            JOIN wbcc_roles r ON u.role = r.idRole
                            JOIN  wbcc_contact c ON u.idContactF = c.idContact
                            LEFT JOIN wbcc_activity a ON u.idUtilisateur = a.idUtilisateurF
                            WHERE r.libelleRole = :role AND u.etatUser = 1
                            GROUP BY u.idUtilisateur
                            ORDER BY activity_count ASC
                            LIMIT 1
                        ");
                        $db->bind(':role', $role);
                        $userWithLeastActivities = $db->single();

                        $rand = rand(1000, 9999);

                        $assignePar = 1;
                        $assigneA = $userWithLeastActivities->idUtilisateur;
                        $userSelectedName = $userWithLeastActivities->fullName;
                        $connectedUserName = "Système";
                        $nomDoc = $filename;
                        $newNomDoc = date("YmdHis") . $userWithLeastActivities->idUtilisateur . $rand . $filename;
                        $urlDoc = $company . '/' . $category . '/' . $filename;
                        $idDocument = $idDocument;
                        $startDate =  new DateTime();
                        
                        $startDateTime = clone $startDate; // already gives both


                        $endDateTime =  clone $startDate;
                        $endDateTime->add(new DateInterval('PT24H')); // Add 24 hours

                        $db->query("INSERT INTO wbcc_activity(startTime, endTime, regarding, createDate, editDate, location, isDeleted, source, activityType, isMailSend, organizerGuid, organizer, idUtilisateurF, realisedBy, idRealisedBy, publie, isCleared, isAuto) VALUES(:startDate, :endDate, :regarding, NOW(), NULL, :location, :isDeleted, :source, :activityType, :isMailSend, :organizerGuid, :organizer, :idUtilisateurF, :realisedBy, :idRealisedBy, :publie, :isCleared, :isAuto)");

                        // Bind all parameters
                        $db->bind(':startDate', $startDateTime->format('Y-m-d H:i:s'));
                        $db->bind(':endDate', $endDateTime->format('Y-m-d H:i:s'));
                        $db->bind(':regarding', $nomDoc);
                        $db->bind(':location', '');
                        $db->bind(':isDeleted', 0);
                        $db->bind(':source', 'EXTRANET');
                        $db->bind(':activityType', 'Tâche à faire');
                        $db->bind(':isMailSend', 0);
                        $db->bind(':organizerGuid', $userSelectedName);
                        $db->bind(':organizer', $userSelectedName);
                        $db->bind(':idUtilisateurF', $assigneA);
                        $db->bind(':realisedBy', $connectedUserName);
                        $db->bind(':idRealisedBy', $assignePar);
                        $db->bind(':publie', 0);
                        $db->bind(':isCleared', 0); // Using 1 instead of true for MySQL
                        $db->bind(':isAuto', 1); // Using 1 instead of true for MySQL

                        if ($db->execute()) {
                            $idActivity = $db->lastInsertId();
                            $db->query("INSERT INTO wbcc_repertoire_commun_activity(idActivityF, idRepertoireF) VALUES($idActivity, $idDocument)");

                            if ($db->execute()) {
                                $db->query("UPDATE wbcc_repertoire_commun SET dateAssignation = NOW(), publie = 0, isDeleted = 1, urlDossier = '$urlDoc', nouveauNomDocument = '$newNomDoc' WHERE idDocument = $idDocument");
                                if ($db->execute()) {
                                    echo json_encode(['success' => true, 'message' => 'Activity and association created successfully.']);
                                }
                            } else {
                                echo json_encode(['success' => false, 'message' => 'Activity created, but failed to associate with document.']);
                            }
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
                        }
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    if ($action === 'confirmAssignation') {
        $data = json_decode(file_get_contents('php://input'), true);
        $idActivity = $data['idActivity'] ?? null;

        if (!$idActivity) {
            echo json_encode(['success' => false, 'message' => 'ID de la tâche manquant.']);
            exit;
        }

        // Vérifier que la tâche existe
        $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
        $db->bind(':id', $idActivity);
        $exists = $db->single();

        if (!$exists) {
            echo json_encode(['success' => false, 'message' => 'Tâche introuvable.']);
            exit;
        }

        // Mettre à jour : marquer comme confirmée
        $db->query("UPDATE wbcc_activity SET isAuto = 0, editDate = NOW() WHERE idActivity = :id");
        $db->bind(':id', $idActivity);
        $updated = $db->execute();

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Assignation de tâche confirmé.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du traitement.']);
        }
        exit;
    }

    if ($action === 'refusAssignation') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $idActivity = $data['idActivity'] ?? null;
            $idDocument = $data['idDocument'] ?? null;
            $docUrl = $data['docUrl'] ?? null;

            // Validate inputs
            if (empty($idActivity) || empty($idDocument) || empty($docUrl)) {
                throw new Exception('Paramètres manquants');
            }

            // Check if activity exists
            $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
            $db->bind(':id', $idActivity);
            $exists = $db->single();

            if (!$exists) {
                throw new Exception('Tâche introuvable');
            }

            // Security check and path setup
            $docUrl = str_replace(['../', '..\\'], '', $docUrl);
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/Extranet_WBCC-FR/public/documents/repertoires/' . ltrim($docUrl, '/');
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Extranet_WBCC-FR/public/documents/repertoireCommun/';
            $filename = basename($sourcePath);
            $targetPath = $targetDir . $filename;

            // Verify source file
            if (!file_exists($sourcePath) || !is_readable($sourcePath)) {
                throw new Exception('Fichier source introuvable ou inaccessible');
            }

            // Create target directory if needed
            if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
                throw new Exception('Impossible de créer le répertoire de destination');
            }

            $allSuccess = true;
            $errorMessage = '';

            // 1. First perform all database operations
            $db->query("DELETE FROM wbcc_repertoire_commun_activity WHERE idActivityF = :idActivity AND idRepertoireF = :idDoc");
            $db->bind(':idActivity', $idActivity);
            $db->bind(':idDoc', $idDocument);
            if (!$db->execute()) {
                $allSuccess = false;
                $errorMessage = 'Erreur lors de la suppression de l\'association';
            }

            if ($allSuccess) {
                $db->query("UPDATE wbcc_activity SET isAuto = 0, editDate = NULL, idUtilisateurF = NULL, organizerGuid = NULL, organizer = NULL WHERE idActivity = :id");
                $db->bind(':id', $idActivity);
                if (!$db->execute()) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors de la mise à jour de l\'activité';
                }
            }

            if ($allSuccess) {
                $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 0 WHERE idDocument = :id");
                $db->bind(':id', $idDocument);
                if (!$db->execute()) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors de la mise à jour du répertoire';
                }
            }

            // 2. Only move the file if all database operations succeeded
            if ($allSuccess) {
                if (!rename($sourcePath, $targetPath)) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors du déplacement du fichier';

                    // Try to revert database changes if file move failed
                    // (This is a simplified approach without full transaction)
                    $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 1 WHERE idDocument = :id");
                    $db->bind(':id', $idDocument);
                    $db->execute();
                }
            }

            // Return response
            if ($allSuccess) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Désassociation réussie et fichier déplacé',
                    'newPath' => '/public/documents/repertoireCommun/' . $filename
                ]);
            } else {
                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    if ($action == "transferDocument") {
        try {
            $idDocument = filter_input(INPUT_POST, 'idDocument', FILTER_VALIDATE_INT);
            $newPath = filter_input(INPUT_POST, 'newPath', FILTER_SANITIZE_STRING);

            if (!$idDocument || !$newPath) {
                throw new Exception("Paramètres invalides");
            }

            $db = new Database();

            // 1. Get current document info
            $db->query("SELECT urlDocument FROM wbcc_repertoire_commun WHERE idDocument = :id");
            $db->bind(':id', $idDocument);
            $document = $db->single();

            if (!$document) {
                throw new Exception("Document non trouvé");
            }

            // 2. Move physical file (implement your file system logic)
            $oldPath = URLROOT . '/public/documents/repertoireCommun/' . $document->urlDocument;
            $newFullPath = URLROOT . '/public/documents/' . $newPath . '/' . basename($document->urlDocument);

            if (!rename($oldPath, $newFullPath)) {
                throw new Exception("Échec du déplacement du fichier");
            }

            // 3. Update database record
            $newUrl = $newPath . '/' . basename($document->urlDocument);
            $db->query("UPDATE wbcc_repertoire_commun SET urlDocument = :newUrl WHERE idDocument = :id");
            $db->bind(':newUrl', $newUrl);
            $db->bind(':id', $idDocument);
            $db->execute();

            echo json_encode(['success' => true]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    if ($action == 'getDocumentById') {
        $idDocument = $_POST['idDocument'] ?? null;

        $sql = "SELECT * FROM wbcc_repertoire_commun WHERE idDocument = $idDocument AND isDeleted = 0";
        $db->query($sql);
        $data = $db->single();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    if ($action == 'getActivityById') {
        $idActivity = $_POST['idActivity'] ?? null;
        $sql = "SELECT a.*, u.*, rc.*
            FROM wbcc_repertoire_commun_activity rca
            JOIN wbcc_activity a ON rca.idActivityF = a.idActivity
            JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
            JOIN wbcc_repertoire_commun rc ON rca.idRepertoireF = rc.idDocument
            WHERE a.isDeleted = 0 AND a.idActivity = $idActivity";
        $db->query($sql);
        $data = $db->single();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    if ($action == 'createHistorique') {
        header('Content-Type: application/json');

        try {
            // Retrieve and validate POST data
            $action = $_POST['historyAction'] ?? null;
            $idAuteur = $_POST['idUtilisateurF'] ?? null;
            $auteur = $_POST['fullName'] ?? null;
            $idOP = $_POST['idOp'] ?? null;

            if (empty($action)) {
                throw new Exception('History action is required');
            }

            $db->query("INSERT INTO `wbcc_historique`(`action`, `nomComplet`, `dateAction`,  `idUtilisateurF`, idOpportunityF) VALUES (:action, :nomComplet, :dateAction, :idUtilisateurF, :idOpportunityF)");
            $db->bind("action",  $action, null);
            $db->bind("nomComplet", $auteur, null);
            $db->bind("idUtilisateurF", $idAuteur, null);
            $db->bind("dateAction", date("Y-m-d H:i:s"), null);
            $db->bind("idOpportunityF", $idOP == '' ? null : $idOP, null);

            if ($db->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Historique created successfully'
                ]);
            } else {
                throw new Exception('Database execution failed');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    if($action == 'createNote') {
        $idOP = "";
        $codeActivity = "";
        $idUtilisateur =  $_POST['idUtilisateur'] ?? null;
        $idDocument = $_POST['idDocument'] ?? null;
        $auteur =  $_POST['auteur'] ?? null;
        $texte =  $_POST['texte'] ?? null;
        $rand = rand(1000, 9999);
        $numeroNote = date("YmdHis") .  $idUtilisateur . "$idOP$codeActivity" . $rand;

        $db->query("INSERT INTO wbcc_note(numeroNote, source, isPrivate, auteur, idUtilisateurF, plainText, dateNote, createDate, editDate )
        VALUES (:numeroNote, :source, :isPrivate, :auteur, :idUtilisateurF, :plainText, NOW(), NOW(), NOW())");

        $db->bind('numeroNote', $numeroNote);
        $db->bind('source', "EXTRA");
        $db->bind('isPrivate', 0);
        $db->bind('auteur', $auteur);
        $db->bind('idUtilisateurF', $idUtilisateur);
        $db->bind('plainText', $texte);

        if ($db->execute()) {
            $idNote = $db->lastInsertId();
            $db->query("INSERT INTO wbcc_repertoire_commun_note(idRepertoireF, idNoteF) VALUES($idDocument, $idNote)");
            if ($db->execute()) {
                echo json_encode(['success' => true, 'message' => 'Note and association created successfully.']);
            }  else {
                echo json_encode(['success' => false, 'message' => 'Note created, but failed to associate with document.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Note created, but failed to associate with document.']);
        }
        exit;
    }

    if($action == 'getNotesByDocumentId') {
        $idDocument = $_POST['idDocument'] ?? null;
        $db->query("SELECT n.* 
            FROM `wbcc_note` n
            JOIN `wbcc_repertoire_commun_note` rcn ON n.idNote = rcn.idNoteF
            WHERE rcn.idRepertoireF = $idDocument
            ORDER BY n.dateNote DESC
        ");

        $notes = $db->resultSet();
        echo json_encode($notes);
    }

    if ($action == 'createActivity') {
        $assignePar = $_POST['assignePar'] ?? null;
        $assigneA = $_POST['assigneA'] ?? null;
        $userSelectedName = $_POST['userSelectedName'] ?? null;
        $connectedUserName = $_POST['connectedUserName'] ?? null;
        $nomDoc = $_POST['nomDoc'] ?? null;
        $newNomDoc = $_POST['newNomDoc'] ?? null;
        $urlDoc = $_POST['urlDoc'] ?? null;
        $idDocument = $_POST['idDocument'] ?? null;
        $isConfirmOui = $_POST['isConfirmOui'] ?? null;
        $publierSelectedVal = $_POST['publierSelectedVal'] ?? null;
        $startDate = $_POST['startDate'] ?? null;
        
        $startDateTime = new DateTime($startDate);
        // Add current time to the date (keeps only date from input, adds current time)
        $currentTime = new DateTime();
        $startDateTime->setTime(
            $currentTime->format('H'),
            $currentTime->format('i'),
            $currentTime->format('s')
        );

        $endDateTime = clone $startDateTime;
        $endDateTime->add(new DateInterval('PT24H')); // Add 24 hours

        $db->query("INSERT INTO wbcc_activity(startTime, endTime, regarding, createDate, editDate, location, isDeleted, source, activityType, isMailSend, organizerGuid, organizer, idUtilisateurF, realisedBy, idRealisedBy, publie, isCleared) VALUES(:startDate, :endDate, :regarding, NOW(), NULL, :location, :isDeleted, :source, :activityType, :isMailSend, :organizerGuid, :organizer, :idUtilisateurF, :realisedBy, :idRealisedBy, :publie, :isCleared)");

        // Bind all parameters
        $db->bind(':startDate', $startDateTime->format('Y-m-d H:i:s'));
        $db->bind(':endDate', $endDateTime->format('Y-m-d H:i:s'));
        $db->bind(':regarding', $nomDoc);
        $db->bind(':location', '');
        $db->bind(':isDeleted', 0);
        $db->bind(':source', 'EXTRANET');
        $db->bind(':activityType', 'Tâche à faire');
        $db->bind(':isMailSend', 0);
        $db->bind(':organizerGuid', $userSelectedName);
        $db->bind(':organizer', $userSelectedName);
        $db->bind(':idUtilisateurF', $assigneA);
        $db->bind(':realisedBy', $connectedUserName);
        $db->bind(':idRealisedBy', $assignePar);
        $db->bind(':publie', 0);
        $db->bind(':isCleared', $isConfirmOui == 'false' ? 1 : 0); // Using 1 instead of true for MySQL

        if ($db->execute()) {
            $idActivity = $db->lastInsertId();
            $db->query("INSERT INTO wbcc_repertoire_commun_activity(idActivityF, idRepertoireF) VALUES($idActivity, $idDocument)");

            if ($db->execute()) {
                $publieVal = $publierSelectedVal == 'non' ? 0 : 1;
                $db->query("UPDATE wbcc_repertoire_commun SET dateAssignation = NOW(), publie = $publieVal, isDeleted = 1, urlDossier = '$urlDoc', nouveauNomDocument = '$newNomDoc' WHERE idDocument = $idDocument");
                if ($db->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Activity and association created successfully.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Activity created, but failed to associate with document.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
        }
        exit;
    }

    if ($action == 'updateActivity') {
        // Retrieve POST data
        $idActivity = $_POST['idActivity'] ?? null;
        $assignePar = $_POST['assignePar'] ?? null;
        $connectedUserName = $_POST['connectedUserName'] ?? null;
        $urlDoc = $_POST['urlDoc'] ?? null;

        $db->query("UPDATE wbcc_activity SET editDate = NOW(), realisedBy = :realisedBy, idRealisedBy = :idRealisedBy WHERE idActivity = :idActivity");
        // Bind all parameters
        $db->bind(':realisedBy', $connectedUserName);
        $db->bind(':idRealisedBy', $assignePar);
        $db->bind(':idActivity', $idActivity);

        if ($db->execute()) {
            $db->query("UPDATE wbcc_repertoire_commun rc
        JOIN wbcc_repertoire_commun_activity rca ON rca.idRepertoireF = rc.idDocument
        JOIN wbcc_activity a ON rca.idActivityF = a.idActivity
        SET rc.urlDossier = :newUrl, rc.editDate = NOW()
        WHERE a.idActivity = :idActivity AND a.isDeleted = 0");
            $db->bind(':newUrl', $urlDoc);
            $db->bind(':idActivity', $idActivity);


            if ($db->execute()) {
                echo json_encode(['success' => true, 'message' => 'Activity created successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
        }
        exit;
    }

    if ($action == 'updateActivityUser') {
        // Retrieve POST data
        $idActivity = $_POST['idActivity'] ?? null;
        $assignePar = $_POST['assignePar'] ?? null;
        $assigneA = $_POST['assigneA'] ?? null;
        $userSelectedName = $_POST['userSelectedName'] ?? null;
        $connectedUserName = $_POST['connectedUserName'] ?? null;

        $db->query("UPDATE wbcc_activity SET editDate = NOW(), organizerGuid = :organizerGuid, organizer = :organizer, idUtilisateurF = :idUtilisateurF, realisedBy = :realisedBy, idRealisedBy = :idRealisedBy WHERE idActivity = :idActivity");
        // Bind all parameters
        $db->bind(':organizerGuid', $userSelectedName);
        $db->bind(':organizer', $userSelectedName);
        $db->bind(':idUtilisateurF', $assigneA);
        $db->bind(':realisedBy', $connectedUserName);
        $db->bind(':idRealisedBy', $assignePar);
        $db->bind(':idActivity', $idActivity);

        if ($db->execute()) {
            echo json_encode(['success' => true, 'message' => 'Activity created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
        }
        exit;
    }

    if ($action == "deleteDocument") {
        $id = $_POST['id'] ?? null;
        $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 1 WHERE idDocument = $id");
        $db->execute();
        echo json_encode(['success' => true, 'message' => "Suppression effectuée avec succes!"]);
    }

    if ($action == 'copyDocument') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            // Validate input
            if (empty($data['sourceUrl']) || empty($data['destinationPath'])) {
                throw new Exception('Missing parameters');
            }

            // Get absolute paths
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($data['sourceUrl'], PHP_URL_PATH);
            $destinationDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/' . $data['destinationPath'];
            // Create destination directory if it doesn't exist
            if (!file_exists($destinationDir)) {
                if (!mkdir($destinationDir, 0777, true)) {
                    throw new Exception('Failed to create destination directory');
                }
            }
            // Get filename from source path
            $filename = basename($sourcePath);
            $destinationPath = $destinationDir . '/' . $filename;

            // Check if source file exists
            if (!file_exists($sourcePath)) {
                throw new Exception('Source file not found');
            }

            // First COPY the file (for safe rollback)
            if (!copy($sourcePath, $destinationPath)) {
                throw new Exception('Failed to copy file');
            }

            // Only DELETE original after successful copy
            if (!unlink($sourcePath)) {
                // If delete fails, remove the copied file to maintain consistency
                unlink($destinationPath);
                throw new Exception('Failed to remove original file');
            }

            // Return success with paths
            echo json_encode([
                'success' => true,
                'message' => 'File moved successfully',
                'originalPath' => $data['sourceUrl'],
                'newPath' => $data['destinationPath'] . '/' . $filename
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    if ($action == 'rollBackDocument') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['sourceUrl']) || empty($data['destinationPath'])) {
                throw new Exception('Missing parameters');
            }

            // Convert URLs or paths to absolute filesystem paths
            // Assuming data['sourceUrl'] and data['destinationPath'] are relative to the document root:
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/' . $data['sourceUrl'];
            $destinationDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/' . 'public/documents/repertoireCommun';
            $filename = basename($sourcePath);
            $destinationPath = $destinationDir . '/' . $filename;

            if (!file_exists($sourcePath)) {
                throw new Exception('Rollback source file not found');
            }

            if (!file_exists($destinationDir)) {
                if (!mkdir($destinationDir, 0777, true)) {
                    throw new Exception('Failed to create destination directory for rollback');
                }
            }

            if (!copy($sourcePath, $destinationPath)) {
                throw new Exception('Failed to copy file back during rollback');
            }

            if (!unlink($sourcePath)) {
                unlink($destinationPath);
                throw new Exception('Failed to remove moved file during rollback');
            }

            echo json_encode([
                'success' => true,
                'message' => 'Rollback completed successfully',
                'restoredPath' => $data['destinationPath'] . '/' . $filename
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }
    if ($action == 'rollBackDocumentEmploye') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);

            if (empty($data['sourceUrl']) || empty($data['destinationPath'])) {
                throw new Exception('Missing parameters');
            }

            // Convert URLs or paths to absolute filesystem paths
            // Assuming data['sourceUrl'] and data['destinationPath'] are relative to the document root:
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/' . $data['sourceUrl'];
            // $destinationDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/' . 'public/documents/repertoireCommun';
            $destinationDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . $data['destinationPath'];
            $fullUrl = $data['destinationPath'];

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $host = $_SERVER['HTTP_HOST'];
            $scriptDir = str_replace("/public/json", "", dirname($_SERVER['SCRIPT_NAME']));

            $baseUrl = rtrim("$protocol://$host$scriptDir", '/');

            $relativePath = str_replace($baseUrl, '', $fullUrl);

            $filename = basename($sourcePath);
            $destinationPath = $_SERVER['DOCUMENT_ROOT'] . $scriptDir . '/' . $relativePath . '/' . $filename;

            if (!file_exists($sourcePath)) {
                throw new Exception('Rollback source file not found');
            }

            if (!copy($sourcePath, $destinationPath)) {
                throw new Exception('Failed to copy file back during rollback');
            }

            if (!unlink($sourcePath)) {
                unlink($destinationPath);
                throw new Exception('Failed to remove moved file during rollback');
            }

            echo json_encode([
                'success' => true,
                'message' => 'Rollback completed successfully',
                'restoredPath' => $data['destinationPath'] . '/' . $filename
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit;
    }


    if ($action === 'createDirectory') {
        header('Content-Type: application/json');

        try {
            // Validation des données POST
            $parentId = !empty($_POST['parentId']) ? intval($_POST['parentId']) : null;
            $societeId = isset($_POST['societeId']) ? intval($_POST['societeId']) : null;
            $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';

            if (empty($societeId)) {
                throw new Exception('ID de société requis');
            }

            if (empty($nom)) {
                throw new Exception('Nom du dossier requis');
            }

            // Récupérer le nom de la société
            $db->query("SELECT nom_societe FROM gestion_societe_rym WHERE id = :id");
            $db->bind(':id', $societeId);
            $societe = $db->single();
            if (!$societe) {
                throw new Exception('Société invalide');
            }

            // Construire le chemin physique complet
            $basePath = realpath("../../public/documents/repertoires");
            if (!$basePath) {
                throw new Exception('Chemin de base introuvable');
            }

            // Initialiser le chemin avec le dossier de la société
            $fullPath = $basePath . DIRECTORY_SEPARATOR . $societe->nom_societe;

            // Créer le dossier de la société s'il n'existe pas
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0777, true)) {
                    throw new Exception('Impossible de créer le dossier de la société');
                }
            }

            // Si on a un parent, récupérer son chemin complet
            if ($parentId) {
                $db->query("WITH RECURSIVE folder_path AS (
                SELECT id, nom, idParent, CAST(nom AS CHAR(1000)) as path
                FROM wbcc_repertoire 
                WHERE id = :id
                UNION ALL
                SELECT r.id, r.nom, r.idParent, CONCAT(fp.path, '/', r.nom)
                FROM wbcc_repertoire r
                INNER JOIN folder_path fp ON fp.id = r.idParent
            )
            SELECT path FROM folder_path ORDER BY LENGTH(path) DESC LIMIT 1");
                $db->bind(':id', $parentId);
                $result = $db->single();

                if ($result) {
                    $fullPath .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $result->path);
                }
            }

            $fullPath .= DIRECTORY_SEPARATOR . $nom;

            // Créer le dossier physique
            if (!file_exists($fullPath)) {
                if (!mkdir($fullPath, 0777, true)) {
                    throw new Exception('Impossible de créer le dossier physique');
                }
            }

            // Insérer dans la base de données avec une requête qui gère explicitement NULL
            if ($parentId) {
                $db->query("INSERT INTO wbcc_repertoire (nom, idParent, idSociete) VALUES (:nom, :parentId, :societeId)");
                $db->bind(':parentId', $parentId);
            } else {
                $db->query("INSERT INTO wbcc_repertoire (nom, idParent, idSociete) VALUES (:nom, NULL, :societeId)");
            }

            $db->bind(':nom', $nom);
            $db->bind(':societeId', $societeId);

            if (!$db->execute()) {
                // Si l'insertion échoue, supprimer le dossier physique
                if (file_exists($fullPath)) {
                    rmdir($fullPath);
                }
                throw new Exception('Erreur lors de la création du répertoire en base de données');
            }

            $newId = $db->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => 'Répertoire créé avec succès',
                'id' => $newId,
                'path' => str_replace($basePath, '', $fullPath)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    if ($action === 'desassocier') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        try {
            $idActivity = $data['idActivity'] ?? null;
            $idDocument = $data['idDocument'] ?? null;
            $docUrl = $data['docUrl'] ?? null;

            // Validate inputs
            if (empty($idActivity) || empty($idDocument) || empty($docUrl)) {
                throw new Exception('Paramètres manquants');
            }

            // Check if activity exists
            $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
            $db->bind(':id', $idActivity);
            $exists = $db->single();

            if (!$exists) {
                throw new Exception('Tâche introuvable');
            }

            // Security check and path setup
            $docUrl = str_replace(['../', '..\\'], '', $docUrl);
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . '/Extranet_WBCC-FR/public/documents/repertoires/' . ltrim($docUrl, '/');
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Extranet_WBCC-FR/public/documents/repertoireCommun/';
            $filename = basename($sourcePath);
            $targetPath = $targetDir . $filename;

            // Verify source file
            if (!file_exists($sourcePath) || !is_readable($sourcePath)) {
                throw new Exception('Fichier source introuvable ou inaccessible');
            }

            // Create target directory if needed
            if (!file_exists($targetDir) && !mkdir($targetDir, 0755, true)) {
                throw new Exception('Impossible de créer le répertoire de destination');
            }

            $allSuccess = true;
            $errorMessage = '';

            // 1. First perform all database operations
            $db->query("DELETE FROM wbcc_repertoire_commun_activity WHERE idActivityF = :idActivity AND idRepertoireF = :idDoc");
            $db->bind(':idActivity', $idActivity);
            $db->bind(':idDoc', $idDocument);
            if (!$db->execute()) {
                $allSuccess = false;
                $errorMessage = 'Erreur lors de la suppression de l\'association';
            }

            if ($allSuccess) {
                $db->query("UPDATE wbcc_activity SET editDate = NULL, idUtilisateurF = NULL, organizerGuid = NULL, organizer = NULL WHERE idActivity = :id");
                $db->bind(':id', $idActivity);
                if (!$db->execute()) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors de la mise à jour de l\'activité';
                }
            }

            if ($allSuccess) {
                $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 0 WHERE idDocument = :id");
                $db->bind(':id', $idDocument);
                if (!$db->execute()) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors de la mise à jour du répertoire';
                }
            }

            // 2. Only move the file if all database operations succeeded
            if ($allSuccess) {
                if (!rename($sourcePath, $targetPath)) {
                    $allSuccess = false;
                    $errorMessage = 'Erreur lors du déplacement du fichier';

                    // Try to revert database changes if file move failed
                    // (This is a simplified approach without full transaction)
                    $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 1 WHERE idDocument = :id");
                    $db->bind(':id', $idDocument);
                    $db->execute();
                }
            }

            // Return response
            if ($allSuccess) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Désassociation réussie et fichier déplacé',
                    'newPath' => '/public/documents/repertoireCommun/' . $filename
                ]);
            } else {
                throw new Exception($errorMessage);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    if ($action === 'getAvailableUsers') {
        // Vérification des paramètres requis
        if (!isset($_GET['entreprise'], $_GET['annee'], $_GET['service'])) {
            echo json_encode([]);
            exit;
        }

        $entreprise = basename($_GET['entreprise']);
        $annee = basename($_GET['annee']);
        $service = basename($_GET['service']);

        $basePath = realpath("../../public/documents/repertoires");
        if (!$basePath) {
            echo json_encode([]);
            exit;
        }

        $pathEntreprise = $basePath . DIRECTORY_SEPARATOR . $entreprise;
        if (!is_dir($pathEntreprise)) mkdir($pathEntreprise, 0777, true);

        $pathAnnee = $pathEntreprise . DIRECTORY_SEPARATOR . $annee;
        if (!is_dir($pathAnnee)) mkdir($pathAnnee, 0777, true);

        $pathService = $pathAnnee . DIRECTORY_SEPARATOR . $service;
        if (!is_dir($pathService)) mkdir($pathService, 0777, true);

        // Ce chemin sera utilisé ensuite
        $fullPath = $pathService;


        // Si le chemin cible n'existe pas, aucun utilisateur à lister
        if (!is_dir($fullPath)) {
            echo json_encode([]);
            exit;
        }

        // Récupération de tous les utilisateurs
        $db->query("
            SELECT u.idUtilisateur, c.fullName
            FROM wbcc_utilisateur u
            INNER JOIN wbcc_contact c ON u.idContactF = c.idContact
            WHERE u.etatUser = 1
        ");
        $users = $db->resultSet();

        $availableUsers = [];

        foreach ($users as $user) {
            $userDir = $fullPath . DIRECTORY_SEPARATOR . $user->idUtilisateur;
            if (!file_exists($userDir)) {
                $availableUsers[] = [
                    'id' => $user->idUtilisateur,
                    'name' => $user->fullName
                ];
            }
        }

        echo json_encode($availableUsers);
        exit;
    }


    if ($action === 'traiter') {
        $data = json_decode(file_get_contents('php://input'), true);
        $idActivity = $data['idActivity'] ?? null;

        if (!$idActivity) {
            echo json_encode(['success' => false, 'message' => 'ID de la tâche manquant.']);
            exit;
        }

        // Vérifier que la tâche existe
        $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
        $db->bind(':id', $idActivity);
        $exists = $db->single();

        if (!$exists) {
            echo json_encode(['success' => false, 'message' => 'Tâche introuvable.']);
            exit;
        }

        // Mettre à jour : marquer comme traitée
        $db->query("UPDATE wbcc_activity SET isCleared = 1, editDate = NOW() WHERE idActivity = :id");
        $db->bind(':id', $idActivity);
        $updated = $db->execute();

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Tâche traitée avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du traitement.']);
        }
        exit;
    }




    if ($action === 'getDirectoryStructure') {
        header('Content-Type: application/json');

        try {
            $basePath = realpath('../../public/documents/repertoires');
            if ($basePath === false) {
                throw new Exception('Répertoire de base introuvable');
            }

            $structure = [];

            // 1) Entreprises
            foreach (scandir($basePath) as $entreprise) {
                if ($entreprise === '.' || $entreprise === '..') {
                    continue;
                }
                $entreprisePath = $basePath . DIRECTORY_SEPARATOR . $entreprise;
                if (!is_dir($entreprisePath)) {
                    continue;
                }

                $structure[$entreprise] = [];

                // 2) Années
                foreach (scandir($entreprisePath) as $year) {
                    if ($year === '.' || $year === '..') {
                        continue;
                    }
                    $yearPath = $entreprisePath . DIRECTORY_SEPARATOR . $year;
                    if (!is_dir($yearPath)) {
                        continue;
                    }

                    $structure[$entreprise][$year] = [];

                    // 3) Services
                    foreach (scandir($yearPath) as $service) {
                        if ($service === '.' || $service === '..') {
                            continue;
                        }
                        $servicePath = $yearPath . DIRECTORY_SEPARATOR . $service;
                        if (!is_dir($servicePath)) {
                            continue;
                        }

                        // 4) Répertoires (niveau le plus profond)
                        $reps = array_values(
                            array_filter(
                                scandir($servicePath),
                                fn($r) => $r !== '.' && $r !== '..' && is_dir("$servicePath/$r")
                            )
                        );

                        $structure[$entreprise][$year][$service] = $reps;
                    }
                }
            }

            echo json_encode($structure);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    if ($action === 'createDirectoryStructure') {
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Utilisez POST');
            }

            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['entreprise'])) {
                throw new Exception("Champ entreprise obligatoire");
            }

            // nettoyage
            $entreprise = basename($data['entreprise']);
            $annee      = !empty($data['annee'])   ? basename($data['annee'])   : null;
            $service    = !empty($data['service']) ? basename($data['service']) : null;
            $rep        = !empty($data['rep'])     ? basename($data['rep'])     : null;

            // dossier racine
            $basePath = realpath('../../public/documents/repertoires');
            if ($basePath === false) {
                throw new Exception('Répertoire racine introuvable');
            }

            /* construit chemin pas à pas :
               entreprise / année (option) / service (option) */
            $segments    = [$entreprise];
            if ($annee)   $segments[] = $annee;
            if ($service) $segments[] = $service;

            $currentPath = $basePath;
            foreach ($segments as $seg) {
                $currentPath .= DIRECTORY_SEPARATOR . $seg;
                if (!is_dir($currentPath) && !mkdir($currentPath, 0777, true)) {
                    throw new Exception("Impossible de créer $seg");
                }
            }

            /* ajoute répertoire final à n’importe quel niveau */
            if ($rep) {
                $currentPath .= DIRECTORY_SEPARATOR . $rep;
                if (!is_dir($currentPath) && !mkdir($currentPath, 0777, true)) {
                    throw new Exception("Impossible de créer $rep");
                }
            }

            $relative = str_replace($basePath . DIRECTORY_SEPARATOR, '', $currentPath);
            echo json_encode(['success' => true, 'message' => "Dossier « $relative » créé / présent"]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
    // Enable error reporting for debugging


    if ($action == "getActivitiesDataTable") {
        try {
            $db = new Database();

            // Get DataTables parameters
            $draw = filter_input(INPUT_GET, 'draw', FILTER_VALIDATE_INT) ?? 1;
            $start = filter_input(INPUT_GET, 'start', FILTER_VALIDATE_INT) ?? 0;
            $length = filter_input(INPUT_GET, 'length', FILTER_VALIDATE_INT) ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
            $orderDirection = $_GET['order'][0]['dir'] ?? 'asc';
            $today = date('Y-m-d');

            // Map DataTables columns to database columns
            $columns = [
            'DT_RowIndex', // # column (index 0)
            'idActivity',  // Visualiser (index 1)
            'idActivity',  // Réaffecter (index 2)
            'idActivity',  // Réaffecter (index 2)
            'idActivity',  // Réassigner (index 3)
            'idActivity',  // Désassigner (index 4)
            'idActivity',  // Traiter (index 5)
            'rc.createDate',  // dateImport (index 6) - Use database column name
            'rc.dateAssignation', // (index 7)
            'a.startTime',   // dateDebut (index 8)
            'a.endTime',     // dateFin (index 9)
            'a.editDate',    // dateRealisation (index 10)
            'nomDocument', // (index 11)
            'nouveauNomDocument', // (index 12)
            'realisedBy',  // (index 13)
            'organizer',   // (index 14)
            'url',         // (index 15)
            'isCleared'    // status (index 16)
        ];

            // Get filter parameters
            $userId = $_GET['userId'] ?? '';
            $connectedUserId = $_GET['connectedUserId'] ?? '';
            $statut = $_GET['statut'] ?? '';
            $idSite = $_GET['idSite'] ?? '';
            $periode = $_GET['periode'] ?? '';
            $dateOne = $_GET['dateOne'] ?? '';
            $dateDebut = $_GET['dateDebut'] ?? '';
            $dateFin = $_GET['dateFin'] ?? '';
            $isAdmin = $_GET['isAdmin'] ?? '';
            // Base query
            $sql = "SELECT a.*, u.*, rc.*
            FROM wbcc_repertoire_commun_activity rca
            JOIN wbcc_activity a ON rca.idActivityF = a.idActivity
            JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
            JOIN wbcc_repertoire_commun rc ON rca.idRepertoireF = rc.idDocument
            WHERE a.isDeleted = 0";

            // Apply other filters
            if ($isAdmin && !empty($userId)) {
                $sql .= " AND a.idUtilisateurF = $userId";
            }

            if (!$isAdmin) {
                $sql .= " AND a.idUtilisateurF = $connectedUserId";
            }

            if ($statut === '0') {
                $sql .= " AND a.isCleared = 0";
            } elseif ($statut === '1') {
                $sql .= " AND a.isCleared = 1";
            }

            if (!empty($idSite)) {
                $sql .= " AND u.idSiteF = $idSite";
            }

            // Apply time period filter
            switch ($periode) {
                case 'today':
                    $sql .= " AND DATE(a.createDate) = CURDATE()";
                    break;
                case 'semaine':
                    $sql .= " AND YEARWEEK(a.createDate, 1) = YEARWEEK(CURDATE(), 1)";
                    break;
                case 'mois':
                    $sql .= " AND YEAR(a.createDate) = YEAR(CURDATE()) AND MONTH(a.createDate) = MONTH(CURDATE())";
                    break;
                case 'annee':
                    $sql .= " AND YEAR(a.createDate) = YEAR(CURDATE())";
                    break;
                case 'trimestre':
                    $month = (int)date('m');
                    $quarter = ceil($month / 3);
                    $startMonth = ($quarter - 1) * 3 + 1;
                    $endMonth = $quarter * 3;
                    $sql .= " AND MONTH(a.createDate) BETWEEN $startMonth AND $endMonth AND YEAR(a.createDate) = YEAR(CURDATE())";
                    break;
                case 'semestre':
                    $month = (int)date('m');
                    if ($month <= 6) {
                        $sql .= " AND MONTH(a.createDate) BETWEEN 1 AND 6 AND YEAR(a.createDate) = YEAR(CURDATE())";
                    } else {
                        $sql .= " AND MONTH(a.createDate) BETWEEN 7 AND 12 AND YEAR(a.createDate) = YEAR(CURDATE())";
                    }
                    break;
                case '1': // À la date du
                    if ($dateOne) {
                        $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                        if ($dateOneFormatted) {
                            $formattedDate = $dateOneFormatted->format('Y-m-d');
                            $sql .= " AND DATE(a.createDate) = '$formattedDate'";
                        }
                    }
                    break;
                case '2': // Personnaliser
                    if ($dateDebut && $dateFin) {
                        $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                        $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                        if ($dateDebutFormatted && $dateFinFormatted) {
                            $formattedDateDebut = $dateDebutFormatted->format('Y-m-d');
                            $formattedDateFin = $dateFinFormatted->format('Y-m-d');
                            $sql .= " AND DATE(a.createDate) BETWEEN '$formattedDateDebut' AND '$formattedDateFin'";
                        }
                    }
                    break;
            }

            // Apply search filter
            if (!empty($searchValue)) {
                $sql .= " AND (rc.nomDocument LIKE :search OR 
                          rc.nouveauNomDocument LIKE :search OR 
                          rc.urlDossier LIKE :search OR 
                          c2.fullName LIKE :search OR 
                          u2.fullName LIKE :search)";
            }

            // Apply ordering
            if (isset($columns[$orderColumnIndex]) && !empty($columns[$orderColumnIndex])) {
                $orderColumn = $columns[$orderColumnIndex];
                $sql .= " ORDER BY $orderColumn $orderDirection";
            } else {
                $sql .= " ORDER BY a.createDate DESC";
            }

            // Apply pagination
            $sql .= " LIMIT $start, $length";

            // Execute query
            $db->query($sql);
            if (!empty($searchValue)) {
                $db->bind(':search', '%' . $searchValue . '%');
            }
            $result = $db->resultSet();

            // Get counts
            $db->query("SELECT FOUND_ROWS() as totalFiltered");
            $totalFiltered = $db->single()->totalFiltered;

            $db->query("SELECT COUNT(*) as total FROM wbcc_activity a WHERE a.isDeleted = 0");
            $totalRecords = $db->single()->total;

            // Prepare data
            $data = [];
            foreach ($result as $row) {
                $dateImportFormatee = date("d/m/Y", strtotime($row->createDate));
                $dateDebutFormatee = date("d/m/Y", strtotime($row->startTime));
                $dateFinFormatee = date("d/m/Y", strtotime($row->endTime));
                $dateAssignationFormatee = date("d/m/Y", strtotime($row->dateAssignation));
                $dateRealisationFormatee = ($row->isCleared == '1') ? date("d/m/Y", strtotime($row->editDate)) : '-';
                $isCleared = $row->isCleared;

                // In your getActivitiesDataTable action:
                $data[] =  [
                'DT_RowIndex' => '', // Will be filled by DataTables
                'idActivity' => $row->idActivity,
                'idDocument' => $row->idDocument,
                'urlDossier' => $row->urlDossier,
                'isCleared' => $row->isCleared,
                'dateImport' => date("d/m/Y", strtotime($row->createDate)),
                'dateAssignation' => date("d/m/Y", strtotime($row->dateAssignation)),
                'dateDebut' => date("d/m/Y", strtotime($row->startTime)),
                'dateFin' => date("d/m/Y", strtotime($row->endTime)),
                'dateRealisation' => $dateRealisationFormatee,
                'enRetard' => ($row->endTime > $today || ($row->endTime < $today && $row->isCleared) ? "Non" : "Oui"),
                'nbrJours' => isset($row->endTime) ? ($row->isCleared ? '-'
                            : (strtotime($row->endTime) < strtotime(date('Y-m-d')) && date_diff(date_create($row->endTime), date_create(date("Y-m-d")))->format("%a") > 0 ?
                            date_diff(date_create($row->endTime), date_create(date("Y-m-d")))->format("%a jours") : '-')): "-",
                'nomDocument' => $row->nomDocument,
                'nouveauNomDocument' => $row->nouveauNomDocument,
                'realisedBy' => $row->realisedBy,
                'organizer' => $isAdmin ? $row->organizer : '',
                'url' => $row->urlDossier,
                'status' => $row->isCleared,
                'isAuto' => $row->isAuto
            ];
            }

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode([
                "draw" => $draw,
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalFiltered,
                "data" => $data
            ]);
            exit;
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                "error" => $e->getMessage(),
                "trace" => $e->getTraceAsString()
            ]);
            exit;
        }
    }

    if ($action == "getRepertoireCommunDataTable") {
        $db = new Database();
        // Get DataTables parameters
        $draw = $_GET['draw'] ?? 1;
        $start = $_GET['start'] ?? 0;
        $length = $_GET['length'] ?? 10;
        $searchValue = $_GET['search']['value'] ?? '';
        $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
        $orderDirection = $_GET['order'][0]['dir'] ?? 'asc';

        // Map DataTables column index to database column
        $columns = [
            '',             // checkbox
            '',             // index
            'urlDocument',  // viewButton
            'nomDocument',  // Nom doc
            'createDate',   // sorting column
            ''              // actionButton
        ];


        // Get filter parameters
        $periode = $_GET['periode'] ?? '';
        $dateOne = $_GET['dateOne'] ?? '';
        $dateDebut = $_GET['dateDebut'] ?? '';
        $dateFin = $_GET['dateFin'] ?? '';

        // Base query
        $sql = "SELECT SQL_CALC_FOUND_ROWS idDocument, urlDocument, nomDocument, createDate FROM wbcc_repertoire_commun WHERE isDeleted = 0";

        // Apply time period filter
        switch ($periode) {
            case 'today':
                $sql .= " AND DATE(createDate) = CURDATE()";
                break;
            case 'semaine':
                $sql .= " AND YEARWEEK(createDate, 1) = YEARWEEK(CURDATE(), 1)";
                break;
            case 'mois':
                $sql .= " AND YEAR(createDate) = YEAR(CURDATE()) AND MONTH(createDate) = MONTH(CURDATE())";
                break;
            case 'annee':
                $sql .= " AND YEAR(createDate) = YEAR(CURDATE())";
                break;
            case 'trimestre':
                $month = (int)date('m');
                $quarter = ceil($month / 3);
                $startMonth = ($quarter - 1) * 3 + 1;
                $endMonth = $quarter * 3;
                $sql .= " AND MONTH(createDate) BETWEEN $startMonth AND $endMonth AND YEAR(createDate) = YEAR(CURDATE())";
                break;
            case 'semestre':
                $month = (int)date('m');
                if ($month <= 6) {
                    $sql .= " AND MONTH(createDate) BETWEEN 1 AND 6 AND YEAR(createDate) = YEAR(CURDATE())";
                } else {
                    $sql .= " AND MONTH(createDate) BETWEEN 7 AND 12 AND YEAR(createDate) = YEAR(CURDATE())";
                }
                break;
            case '1': // 'À la date du'
                if ($dateOne) {
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $formattedDate = $dateOneFormatted->format('Y-m-d');
                        $sql .= " AND DATE(createDate) = '$formattedDate'";
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateOne']);
                        exit;
                    }
                }
                break;
            case '2': // 'Personnaliser'
                if ($dateDebut && $dateFin) {
                    $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                    $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                    if ($dateDebutFormatted && $dateFinFormatted) {
                        $formattedDateDebut = $dateDebutFormatted->format('Y-m-d');
                        $formattedDateFin = $dateFinFormatted->format('Y-m-d');
                        $sql .= " AND DATE(createDate) BETWEEN '$formattedDateDebut' AND '$formattedDateFin'";
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
            default:
                // No date filter applied
                break;
        }

        // Apply search filter
        if (!empty($searchValue)) {
            $sql .= " AND (nomDocument LIKE :search OR createDate LIKE :search)";
        }

        // Apply ordering
        if (isset($columns[$orderColumnIndex]) && !empty($columns[$orderColumnIndex])) {
            $orderColumn = $columns[$orderColumnIndex];
            $sql .= " ORDER BY $orderColumn $orderDirection";
        } else {
            $sql .= " ORDER BY createDate DESC";
        }

        // Apply pagination
        $sql .= " LIMIT $start, $length";

        // Prepare and execute query
        $db->query($sql);
        if (!empty($searchValue)) {
            $db->bind(':search', '%' . $searchValue . '%');
        }
        $result = $db->resultSet();

        // Get total filtered count
        $db->query("SELECT FOUND_ROWS() as totalFiltered");
        $totalFiltered = $db->single()->totalFiltered;

        // Get total count (without filters)
        $db->query("SELECT COUNT(*) as total FROM wbcc_repertoire_commun WHERE isDeleted = 0");
        $totalRecords = $db->single()->total;

        // Prepare data
        $data = [];
        foreach ($result as $row) {
            $dateFormatee = date("d/m/Y", strtotime($row->createDate));
        $data[] = [
            "checkbox" => '', // will be rendered client-side
            "index" => '', // will be rendered client-side
            "viewButton" => '',
            "nomDocument" => $row->nomDocument,
            "createDateRaw" => $row->createDate,  // raw value used for sorting
            "createDate" => date("d/m/Y", strtotime($row->createDate)), // formatted value
            "actionButton" => '',
            "idDocument" => $row->idDocument,
            "urlDocument" => $row->urlDocument,
        ];

        }

        // JSON response
        header('Content-Type: application/json');
        echo json_encode([
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
        exit;
    }

    if ($action == "getCompanyByUserId") {
        $idUtilisateur = $_POST['idUtilisateur'] ?? null;
        $sql = "SELECT s.* FROM gestion_societe_rym s JOIN gestion_utilisateur_societe us ON s.id = us.societe_id AND us.utilisateur_id = $idUtilisateur;";
        $db->query($sql);
        $data = $db->single();
        echo json_encode(['success' => true, 'data' => $data]);
    }

    if ($action == "getCompanies") {
        $db->query("SELECT * FROM gestion_societe_rym");
        $data = $db->resultset();
        echo json_encode(['success' => true, 'data' => $data]);
        exit;
    }

    if ($action === 'getTableauDeBordDataTable') {
        $db = new Database();
        $draw = intval($_GET['draw']);
        $start = intval($_GET['start']);
        $length = intval($_GET['length']);
        $search = $_GET['search']['value'];
        $params = [];

        // Base query
        $select = "a.idActivity, a.numeroActivity as nom, a.createDate, a.startTime, 
                   c2.fullName as assignerName, d.nomDocument, s.nomSite as siteName,
                   a.isCleared as etatDocument";

        $from = "wbcc_activity a
                 LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
                 LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
                 LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
                 LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
                 LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument";

        $where = "WHERE a.isDeleted = 0";

        // Add filters
        if (!empty($_GET['etat'])) {
            if ($_GET['etat'] == '0') {
                $where .= " AND a.isCleared = 0 AND DATE(a.endTime) >= CURRENT_DATE";
            } elseif ($_GET['etat'] == '1') {
                $where .= " AND a.isCleared = 1";
            }
        }

        if (!empty($_GET['nom'])) {
            $where .= " AND a.numeroActivity = :nom";
            $params[':nom'] = $_GET['nom'];
        }

        if (!empty($_GET['assigner'])) {
            $where .= " AND a.idUtilisateurF = :assigner";
            $params[':assigner'] = $_GET['assigner'];
        }

        if (!empty($_GET['site'])) {
            $where .= " AND s.nomSite = :site";
            $params[':site'] = $_GET['site'];
        }

        // Add period filters
        if (!empty($_GET['periode'])) {
            switch ($_GET['periode']) {
                case 'today':
                    $where .= " AND DATE(a.createDate) = CURDATE()";
                    break;
                case '1':
                    if (!empty($_GET['dateOne'])) {
                        $where .= " AND DATE(a.createDate) = :dateOne";
                        $params[':dateOne'] = date('Y-m-d', strtotime($_GET['dateOne']));
                    }
                    break;
                case '2':
                    if (!empty($_GET['dateDebut']) && !empty($_GET['dateFin'])) {
                        $where .= " AND DATE(a.createDate) BETWEEN :dateDebut AND :dateFin";
                        $params[':dateDebut'] = date('Y-m-d', strtotime($_GET['dateDebut']));
                        $params[':dateFin'] = date('Y-m-d', strtotime($_GET['dateFin']));
                    }
                    break;
                    // Ajouter d'autres cas selon vos besoins
            }
        }

        // Add search
        if (!empty($search)) {
            $where .= " AND (a.numeroActivity LIKE :search 
                       OR c2.fullName LIKE :search 
                       OR d.nomDocument LIKE :search 
                       OR s.nomSite LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        // Get total records without filtering
        $db->query("SELECT COUNT(*) as total FROM $from $where");
        foreach ($params as $key => $val) {
            $db->bind($key, $val);
        }
        $totalRecords = $db->single()->total;

        // Get filtered records
        $orderColumn = isset($_GET['order'][0]['column']) ? intval($_GET['order'][0]['column']) : 0;
        $orderDir = isset($_GET['order'][0]['dir']) && strtolower($_GET['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';

        // Sécuriser l'ordre des colonnes
        $columns = ['nom', 'assignerName', 'nomDocument', 'siteName', 'createDate', 'startTime', 'startTime', 'etatDocument'];
        $orderBy = $columns[$orderColumn] ?? 'nom';

        $db->query("SELECT $select FROM $from $where ORDER BY $orderBy $orderDir LIMIT :start, :length");

        // Bind all parameters including pagination
        foreach ($params as $key => $val) {
            $db->bind($key, $val);
        }
        $db->bind(':start', $start, PDO::PARAM_INT);
        $db->bind(':length', $length, PDO::PARAM_INT);

        $result = $db->resultSet();

        // Format data for DataTables
        $data = [];
        foreach ($result as $row) {
            $data[] = [
                $row->nom,
                htmlspecialchars($row->assignerName),
                htmlspecialchars($row->nomDocument),
                htmlspecialchars($row->siteName),
                date('d/m/Y H:i', strtotime($row->createDate)),
                date('d/m/Y H:i', strtotime($row->startTime)),
                date('d/m/Y H:i', strtotime($row->startTime)),
                ($row->etatDocument == 0) ?
                    '<span class="badge badge-success">Ouvert</span>' :
                    '<span class="badge badge-danger">Clôturé</span>'
            ];
        }

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
        exit;
    }

    if ($action === 'getTableauDeBordStats') {
        try {
            header('Content-Type: application/json');

            // Construction de la requête de base avec les jointures nécessaires
            $baseQuery = "FROM wbcc_activity a 
                    LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur 
                    LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
                    LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
                    LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
                    LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument";

            // Construction des conditions WHERE
            $where = ["a.isDeleted = 0"];
            $params = [];

            // Filtres
            if (!empty($_GET['etat'])) {
                $where[] = "a.isCleared = :etat";
                $params[':etat'] = $_GET['etat'];
            }

            if (!empty($_GET['assigner'])) {
                $where[] = "a.idUtilisateurF = :assigner";
                $params[':assigner'] = $_GET['assigner'];
            }

            if (!empty($_GET['site'])) {
                $where[] = "s.nomSite = :site";
                $params[':site'] = $_GET['site'];
            }

            // Ajout des filtres de date
            if (!empty($_GET['periode'])) {
                switch ($_GET['periode']) {
                    case 'today':
                        $where[] = "DATE(a.createDate) = CURDATE()";
                        break;
                    case '1':
                        if (!empty($_GET['dateOne'])) {
                            $where[] = "DATE(a.createDate) = :dateOne";
                            $params[':dateOne'] = date('Y-m-d', strtotime($_GET['dateOne']));
                        }
                        break;
                    case '2':
                        if (!empty($_GET['dateDebut']) && !empty($_GET['dateFin'])) {
                            $where[] = "DATE(a.createDate) BETWEEN :dateDebut AND :dateFin";
                            $params[':dateDebut'] = date('Y-m-d', strtotime($_GET['dateDebut']));
                            $params[':dateFin'] = date('Y-m-d', strtotime($_GET['dateFin']));
                        }
                        break;
                }
            }

            // Ajout des filtres de date de réalisation
            if (!empty($_GET['periodeRealisation'])) {
                switch ($_GET['periodeRealisation']) {
                    case 'today':
                        $where[] = "DATE(a.editDate) = CURDATE()";
                        break;
                    case '1':
                        if (!empty($_GET['dateOneRealisation'])) {
                            $where[] = "DATE(a.editDate) = :dateOneRealisation";
                            $params[':dateOneRealisation'] = date('Y-m-d', strtotime($_GET['dateOneRealisation']));
                        }
                        break;
                    case '2':
                        if (!empty($_GET['dateDebutRealisation']) && !empty($_GET['dateFinRealisation'])) {
                            $where[] = "DATE(a.editDate) BETWEEN :dateDebutRealisation AND :dateFinRealisation";
                            $params[':dateDebutRealisation'] = date('Y-m-d', strtotime($_GET['dateDebutRealisation']));
                            $params[':dateFinRealisation'] = date('Y-m-d', strtotime($_GET['dateFinRealisation']));
                        }
                        break;
                }
            }

            $whereClause = implode(" AND ", $where);

            // Requêtes pour chaque compteur
            // 1. Documents en attente
            $db->query("SELECT COUNT(*) as total $baseQuery WHERE $whereClause AND a.isCleared = 2");
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $documentsEnAttente = $db->single()->total;

            // 2. Documents affectés
            $db->query("SELECT COUNT(*) as total $baseQuery WHERE $whereClause AND a.isCleared = 0 AND a.idUtilisateurF IS NOT NULL");
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $documentsAffectes = $db->single()->total;

            // 3. Documents traités
            $db->query("SELECT COUNT(*) as total $baseQuery WHERE $whereClause AND a.isCleared = 1");
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $documentsTraites = $db->single()->total;

            // 4. Documents en retard
            $db->query("SELECT COUNT(*) as total $baseQuery 
                       WHERE $whereClause AND a.isCleared = 0 
                       AND DATE(a.endTime) < CURRENT_DATE");
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $documentsEnRetard = $db->single()->total;

            // Construction des requêtes pour les graphiques
            $sqlTaches = "SELECT 
                SUM(CASE WHEN a.isCleared = 0 AND DATE(a.endTime) >= CURRENT_DATE THEN 1 ELSE 0 END) as ouvertes,
                SUM(CASE WHEN a.isCleared = 1 THEN 1 ELSE 0 END) as cloturees,
                SUM(CASE WHEN a.isCleared = 0 AND DATE(a.endTime) < CURRENT_DATE THEN 1 ELSE 0 END) as enretard
                FROM wbcc_activity a 
                LEFT JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
                LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
                WHERE a.isDeleted = 0";

            $sqlUsers = "SELECT c2.fullName AS name, COUNT(*) AS total 
                FROM wbcc_activity a
                LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
                LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
                LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
                WHERE a.isDeleted = 0";

            $sqlSites = "SELECT s.nomSite AS site, COUNT(*) AS total 
                FROM wbcc_activity a
                LEFT JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
                LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite
                WHERE a.isDeleted = 0";

            // Ajouter les conditions WHERE si nécessaire
            if (!empty($where)) {
                $sqlConditions = " AND " . implode(" AND ", $where);
                $sqlTaches .= $sqlConditions;
                $sqlUsers .= $sqlConditions;
                $sqlSites .= $sqlConditions;
            }

            $sqlUsers .= " GROUP BY c2.fullName ORDER BY total DESC";
            $sqlSites .= " GROUP BY s.nomSite ORDER BY total DESC";

            // Exécuter les requêtes
            $db->query($sqlTaches);
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $tachesStats = $db->single();

            $db->query($sqlUsers);
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $usersStats = $db->resultSet();

            $db->query($sqlSites);
            foreach ($params as $key => $val) {
                $db->bind($key, $val);
            }
            $sitesStats = $db->resultSet();

            // Préparer la réponse
            $data = [
                'documentsEnAttente' => $documentsEnAttente,
                'documentsAffectes' => $documentsAffectes,
                'documentsTraites' => $documentsTraites,
                'documentsEnRetard' => $documentsEnRetard,
                'tachesStats' => [
                    'ouvertes' => intval($tachesStats->ouvertes ?? 0),
                    'cloturees' => intval($tachesStats->cloturees ?? 0),
                    'attente' => intval($tachesStats->enretard ?? 0)
                ],
                'topUsersLabels' => array_column($usersStats, 'name'),
                'topUsersCounts' => array_map('intval', array_column($usersStats, 'total')),
                'siteLabels' => array_column($sitesStats, 'site'),
                'siteCounts' => array_map('intval', array_column($sitesStats, 'total'))
            ];

            echo json_encode(['success' => true, 'data' => $data]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }


    if ($action === 'getFolders') {
        header('Content-Type: application/json');
        try {
            $societeId = $_POST['idSociete'] ?? null;
            $parentId = $_POST['idParent'] ?? null;

            // Get all societies first
            $db->query("SELECT id, nom_societe as name FROM gestion_societe_rym ORDER BY nom_societe");
            $societies = $db->resultSet();

            $folders = [];
            if (!empty($parentId)) {
                // Get sub-folders of a specific folder
                $db->query("SELECT *
                       FROM wbcc_repertoire 
                       WHERE idParent = :parentId 
                       ORDER BY nom");
                $db->bind(':parentId', $parentId);
                $folders = $db->resultSet();
            } elseif (!empty($societeId)) {
                // Get root folders for a society
                $db->query("SELECT *
                       FROM wbcc_repertoire 
                       WHERE idSociete = :societeId AND (idParent IS NULL OR idParent = 0)
                       ORDER BY nom");
                $db->bind(':societeId', $societeId);
                $folders = $db->resultSet();
            }

            // Check for sub-folders for each folder
            foreach ($folders as $folder) {
                $db->query("SELECT COUNT(*) as count FROM wbcc_repertoire WHERE idParent = :id");
                $db->bind(':id', $folder->id);
                $folder->hasChildren = ($db->single()->count > 0);
            }

            echo json_encode([
                'success' => true,
                'societies' => $societies,
                'folders' => $folders
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }
}



// Fonction helper pour construire l'arborescence
function buildFolderTree($folders, $parentId = null)
{
    $branch = array();

    foreach ($folders as $folder) {
        if ($folder->idParent === $parentId) {
            $children = buildFolderTree($folders, $folder->id);
            if ($children) {
                $folder->children = $children;
            }
            $branch[] = $folder;
        }
    }

    return $branch;
}
