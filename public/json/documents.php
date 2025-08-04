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

if (isset($_GET['action'])) {
    $db = new Database();
    $action = $_GET['action'];

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
        $historyAction = $_POST['historyAction'] ?? null;
        $idUtilisateurF = $_POST['idUtilisateurF'] ?? null;
        $fullName = $_POST['fullName'] ?? null;

        if (empty($historyAction)) {
            throw new Exception('History action is required');
        }

        // Prepare and execute query
        $db->query("INSERT INTO wbcc_historique (action, nomComplet, idUtilisateurF) 
                    VALUES (:action, :fullName, :userId)");
        
        $db->bind(':action', $historyAction);
        $db->bind(':fullName', $fullName);
        $db->bind(':userId', $idUtilisateurF);

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
    
if ($action == 'createActivity') {
    $assignePar = $_POST['assignePar'] ?? null;
    $assigneA = $_POST['assigneA'] ?? null;
    $userSelectedName = $_POST['userSelectedName'] ?? null;
    $connectedUserName = $_POST['connectedUserName'] ?? null;
    $nomDoc = $_POST['nomDoc'] ?? null;
    $newNomDoc = $_POST['newNomDoc'] ?? null;
    $urlDoc = $_POST['urlDoc'] ?? null;
    $idDocument = $_POST['idDocument'] ?? null;

    $db->query("INSERT INTO wbcc_activity(startTime, endTime, regarding, createDate, editDate, location, isDeleted, source, activityType, isMailSend, organizerGuid, organizer, idUtilisateurF, realisedBy, idRealisedBy, publie, isCleared) VALUES(NOW(), NOW(), :regarding, NOW(), NOW(), :location, :isDeleted, :source, :activityType, :isMailSend, :organizerGuid, :organizer, :idUtilisateurF, :realisedBy, :idRealisedBy, :publie, :isCleared)");

    // Bind all parameters
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

    if ($db->execute()) {
        $idActivity = $db->lastInsertId();
        $db->query("INSERT INTO wbcc_repertoire_commun_activity(idActivityF, idRepertoireF) VALUES($idActivity, $idDocument)");
        
        if ($db->execute()) {
            $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 1, urlDossier = '$urlDoc', nouveauNomDocument = '$newNomDoc' WHERE idDocument = $idDocument");
            if($db->execute()) {
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

    if($action=="deleteDocument") {
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
        try {
            // Pour cette action, on s'attend à recevoir un JSON dans le body POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed, use POST');
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if (
                !isset($data['entreprise']) ||
                !isset($data['annee']) ||
                !isset($data['service'])
            ) {
                throw new Exception('Missing parameters');
            }

            $entreprise = basename($data['entreprise']);
            $annee = basename($data['annee']);
            $service = basename($data['service']);

            $basePath = realpath("../../public/documents/repertoires");
            if ($basePath === false) {
                throw new Exception('Base directory not found');
            }

            $fullPath = $basePath . DIRECTORY_SEPARATOR . $entreprise . DIRECTORY_SEPARATOR . $annee . DIRECTORY_SEPARATOR . $service;

            if (!file_exists($fullPath)) {
                if (mkdir($fullPath, 0777, true)) {
                    echo json_encode(['success' => true, 'message' => "Répertoire créé avec succès."]);
                } else {
                    throw new Exception("Impossible de créer le répertoire.");
                }
            } else {
                echo json_encode(['success' => false, 'message' => "Le répertoire existe déjà."]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
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
            $db->query("UPDATE wbcc_activity SET idUtilisateurF = NULL, organizerGuid = NULL, organizer = NULL WHERE idActivity = :id");
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
                if ($entreprise === '.' || $entreprise === '..') { continue; }
                $entreprisePath = $basePath . DIRECTORY_SEPARATOR . $entreprise;
                if (!is_dir($entreprisePath)) { continue; }
    
                $structure[$entreprise] = [];
    
                // 2) Années
                foreach (scandir($entreprisePath) as $year) {
                    if ($year === '.' || $year === '..') { continue; }
                    $yearPath = $entreprisePath . DIRECTORY_SEPARATOR . $year;
                    if (!is_dir($yearPath)) { continue; }
    
                    $structure[$entreprise][$year] = [];
    
                    // 3) Services
                    foreach (scandir($yearPath) as $service) {
                        if ($service === '.' || $service === '..') { continue; }
                        $servicePath = $yearPath . DIRECTORY_SEPARATOR . $service;
                        if (!is_dir($servicePath)) { continue; }
    
                        // 4) Répertoires (niveau le plus profond)
                        $reps = array_values(
                            array_filter(
                                scandir($servicePath),
                                fn ($r) => $r !== '.' && $r !== '..' && is_dir("$servicePath/$r")
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
        }
        catch (Exception $e) {
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
        
        // Map DataTables columns to database columns
        $columns = [
            '', // # column
            '', // Visualiser
            '', // Réaffecter
            '', // Désassigner
            '', // Traiter
            'a.createDate',
            'rc.nomDocument',
            'rc.nouveauNomDocument',
            'a.realisedBy', // Assigné par
            'a.organizer', // Assigné À
            'rc.urlDossier',
            'a.isCleared'
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

        if(!$isAdmin) {
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
            $dateDebutFormatee = date("d/m/Y", strtotime($row->createDate));
            $isCleared = $row->isCleared;
            
            $data[] = [
                '', // Will be filled by DataTables
                '<a href="' . URLROOT . '/public/documents/repertoires/' . $row->urlDossier . '" target="_blank" type="button" class="btn btn-sm btn-icon" style="background: #e74c3c; color:white">
                    <i class="fas fa-eye"></i>
                </a>',
                $isAdmin ? '<button onclick="openTransferModal(' . $row->idActivity . ')" class="btn btn-primary" ' . ($isCleared ? 'disabled' : '') . '>
                    Réaffecter
                </button>' : '',
                '<button title="Désassigner" ' . ($isCleared ? 'disabled' : '') . ' type="button" class="btn btn-danger form-control validerBtn" onclick="openConfirmModal(' . $row->idActivity . ', ' . $row->idDocument . ', \'' . $row->urlDossier . '\')">
                    <i class="fas fa-times"></i>
                </button>',
                '<button title="Traiter" type="button" class="btn form-control btn-success" onclick="openTreatModal(' . $row->idActivity . ')" ' . ($isCleared ? 'disabled' : '') . '>
                    <i class="fas fa-check-circle"></i>
                </button>',
                $dateDebutFormatee,
                $row->nomDocument,
                $row->nouveauNomDocument,
                $row->realisedBy,
                $isAdmin ? $row->organizer : '',
                $row->urlDossier,
                $isCleared ? '<span class="badge badge-success">Traité</span>' : '<span class="badge badge-danger">Non Traité</span>'
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
        '', // Checkbox column (no database column)
        'urlDocument',
        'nomDocument', 
        'createDate',
        '' // Action column (no database column)
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
            '', // Checkbox will be rendered client-side
            '<a href="' . URLROOT . '/public/documents/repertoireCommun/' . $row->urlDocument . '" target="_blank" type="button" class="btn btn-sm btn-icon" style="background: #e74c3c; color:white">
                <i class="fas fa-eye"></i>
            </a>',
            $row->nomDocument,
            $dateFormatee,
            '<button onclick="openTransferModal(' . $row->idDocument . ')" class="btn btn-primary">
                Affecter
            </button>',
            'idDocument' => $row->idDocument // Include ID for DataTables rendering
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

if($action == "getCompanyByUserId") {
    $idUtilisateur = $_POST['idUtilisateur'] ?? null;
    $sql = "SELECT s.* FROM gestion_societe_rym s JOIN gestion_utilisateur_societe us ON s.id = us.societe_id AND us.utilisateur_id = $idUtilisateur;";
    $db->query($sql);
    $data = $db->single();
    echo json_encode(['success' => true, 'data' => $data]);
}

if($action == "getCompanies") {
    $db->query("SELECT * FROM gestion_societe_rym");
    $data = $db->resultset();
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if($action == "getFolders") {
    $idSociete = $_POST['idSociete'] ?? null;
    $idParent = isset($_POST['idParent']) && $_POST['idParent'] !== 'null' ? $_POST['idParent'] : null;
    
    if(!$idSociete) {
        echo json_encode(['success' => false, 'message' => 'Company ID required']);
        exit;
    }
    
    $db->query("SELECT id, nom FROM wbcc_repertoires 
            WHERE idSociete = $idSociete
            AND " . ($idParent ? "idParent = $idParent" : "idParent IS NULL") . "");
    
    
    $folders = $db->resultset();
    
    echo json_encode(['success' => true, 'data' => $folders]);
    exit;
}
}