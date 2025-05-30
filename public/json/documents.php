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
    $urlDoc = $_POST['urlDoc'] ?? null;
    $idDocument = $_POST['idDocument'] ?? null;

    $db->query("INSERT INTO wbcc_activity(startTime, endTime, regarding, createDate, editDate, location, isDeleted, source, activityType, isMailSend, organizerGuid, organizer, idUtilisateurF, realisedBy, idRealisedBy, publie, isCleared, urlDocument) VALUES(NOW(), NOW(), :regarding, NOW(), NOW(), :location, :isDeleted, :source, :activityType, :isMailSend, :organizerGuid, :organizer, :idUtilisateurF, :realisedBy, :idRealisedBy, :publie, :isCleared, :urlDocument)");

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
    $db->bind(':urlDocument', $urlDoc);

    if ($db->execute()) {
        $idActivity = $db->lastInsertId();
        $db->query("INSERT INTO wbcc_repertoire_commun_activity(idActivityF, idRepertoireF) VALUES($idActivity, $idDocument)");
        
        if ($db->execute()) {
            $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 1, urlDossier = '$urlDoc' WHERE idDocument = $idDocument");
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
    if ($_POST['assigneA'] === "FAIL_TEST_USER") {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Simulated error']);
        exit;
    }
    // Retrieve POST data
    $idActivity = $_POST['idActivity'] ?? null;
    $assignePar = $_POST['assignePar'] ?? null;
    $assigneA = $_POST['assigneA'] ?? null;
    $userSelectedName = $_POST['userSelectedName'] ?? null;
    $connectedUserName = $_POST['connectedUserName'] ?? null;
    $urlDoc = $_POST['urlDoc'] ?? null;

    $db->query("UPDATE wbcc_activity SET editDate = NOW(), organizerGuid = :organizerGuid, organizer = :organizer, idUtilisateurF = :idUtilisateurF, realisedBy = :realisedBy, idRealisedBy = :idRealisedBy, urlDocument = :urlDocument WHERE idActivity = :idActivity");
    // Bind all parameters
    $db->bind(':organizerGuid', $userSelectedName);
    $db->bind(':organizer', $userSelectedName);
    $db->bind(':idUtilisateurF', $assigneA);
    $db->bind(':realisedBy', $connectedUserName);
    $db->bind(':idRealisedBy', $assignePar);
    $db->bind(':urlDocument', $urlDoc);
    $db->bind(':idActivity', $idActivity);

    if ($db->execute()) {
        echo json_encode(['success' => true, 'message' => 'Activity created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create activity.']);
    }
    exit;
}
    
if ($action == 'getUser') {
    $userId = $_POST['userId'] ?? null;
    
    // Validate user ID
    if (!$userId || !is_numeric($userId)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Invalid user ID']);
        exit;
    }
    
    // Sanitize the input
    $userId = intval($userId);
    
    try {
        // Execute query
        $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = (SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :userId)");
        $db->bind(':userId', $userId);
        $data = $db->single();
        
        // Check if data was found
        if (empty($data)) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'User not found']);
            exit;
        }
        
        // Ensure fullName exists in the result
if (!isset($data->fullName)) {  // Changed from $data['fullName']
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Invalid user data format']);
    exit;
}
        
        // Success response
        header('Content-Type: application/json');
echo json_encode([
    'success' => true, 
    'message' => [
        'fullName' => $data->fullName  // Changed from $data['fullName']
    ]
]);
        exit;
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
        exit;
    }
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

// if ($action === 'desassocier') {
//     $idActivity = $_POST['idActivity'] ?? null;
//     $nomDoc = $_POST['nomDoc'] ?? null;
//     $urlDoc = $_POST['urlDoc'] ?? null;
//     $docPath = $_POST['docPath'] ?? null;
//     $createDate = $_POST['createDate'] ?? null;
//     // Vérifier que la tâche existe
//     $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
//     $db->bind(':id', $idActivity);
//     $exists = $db->single();

//     if (!$exists) {
//         echo json_encode(['success' => false, 'message' => 'Tâche introuvable.']);
//         exit;
//     }

//     // Mettre à jour la tâche : supprimer l'affectation
//     $db->query("INSERT INTO wbcc_repertoire_commun(nomDocument, urlDocument, createDate, editDate, source, publie, isDeleted) VALUES ('$nomDoc', '$urlDoc', '$createDate', NOW(), 'EXTRANET', 1,0)");
//     $db->query("UPDATE wbcc_activity SET idUtilisateurF = NULL WHERE idActivity = :id");
//     $db->bind(':id', $idActivity);
//     $updated = $db->execute();

//     if ($updated) {
//         echo json_encode(['success' => true, 'message' => 'Tâche désassociée avec succès.']);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Erreur lors de la désassociation.']);
//     }
//     exit;
// }


if ($action === 'createDirectory') {
        try {
            // Pour cette action, on s'attend à recevoir un JSON dans le body POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Method not allowed, use POST');
            }

            $data = json_decode(file_get_contents("php://input"), true);

            if (
                !isset($data['idUtilisateur']) ||
                !isset($data['entreprise']) ||
                !isset($data['annee']) ||
                !isset($data['service'])
            ) {
                throw new Exception('Missing parameters');
            }

            $userId = basename($data['idUtilisateur']);
            $entreprise = basename($data['entreprise']);
            $annee = basename($data['annee']);
            $service = basename($data['service']);

            $basePath = realpath("../../public/documents/repertoires");
            if ($basePath === false) {
                throw new Exception('Base directory not found');
            }

            $fullPath = $basePath . DIRECTORY_SEPARATOR . $entreprise . DIRECTORY_SEPARATOR . $annee . DIRECTORY_SEPARATOR . $service . DIRECTORY_SEPARATOR . $userId;

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

    // if ($action === 'desassocier') {
    //     $idActivity = $_POST['idActivity'] ?? null;
    //     $idDocument = $_POST['idDocument'] ?? null;
    //     $docUrl = $_POST['docUrl'] ?? null;
    //     // Vérifier que la tâche existe
    //     $db->query("SELECT idActivity FROM wbcc_activity WHERE idActivity = :id");
    //     $db->bind(':id', $idActivity);
    //     $exists = $db->single();

    //     if (!$exists) {
    //         echo json_encode(['success' => false, 'message' => 'Tâche introuvable.']);
    //         exit;
    //     }

    //     // Mettre à jour la tâche : supprimer l'affectation
    //     $db->query("DELETE FROM wbcc_repertoire_commun_activity WHERE idActivityF = $idActivity AND idRepertoireF = $idDocument");
    //     if($db->execute()) {
    //         $db->query("UPDATE wbcc_activity SET idUtilisateurF = NULL, organizerGuid = NULL, organizer = NULL WHERE idActivity = $idActivity");
    //         if ($db->execute()) {
    //             $db->query("UPDATE wbcc_repertoire_commun SET isDeleted = 0 WHERE idDocument = $idDocument");
    //             if($db->execute()) {
    //                 //copy document from $docUrl to rootFolder/public/documents/repertoireCommun
    //             } else {
    //                 echo json_encode(['success' => false, 'message' => 'Erreur lors de la désassociation.']);
    //             }
    //         } else {
    //             echo json_encode(['success' => false, 'message' => 'Erreur lors de la désassociation.']);
    //         }
    //     }
    //      else {
    //         echo json_encode(['success' => false, 'message' => 'Erreur lors de la désassociation.']);
    //     }
    //     exit;
    // }

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

    if ($action === 'traiter') {
        $idActivity = $_POST['idActivity'] ?? null;

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
        $db->query("UPDATE wbcc_activity SET isCleared = 1, endTime = NOW() WHERE idActivity = :id");
        $db->bind(':id', $idActivity);
        $updated = $db->execute();

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Tâche traitée avec succès.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors du traitement.']);
        }

        exit;
    }
    if ($action === 'getAvailableUsers') {
        // Vérification des paramètres requis
        $entreprise = isset($_GET['entreprise']) ? basename($_GET['entreprise']) : null;
        $annee = isset($_GET['annee']) ? basename($_GET['annee']) : null;
        $service = isset($_GET['service']) ? basename($_GET['service']) : null;

        if (!$entreprise || !$annee || !$service) {
            throw new Exception("Paramètres requis manquants : entreprise, année, service.");
        }

        $basePath = realpath("../../public/documents/repertoires");
        $fullPath = $basePath . DIRECTORY_SEPARATOR . $entreprise . DIRECTORY_SEPARATOR . $annee . DIRECTORY_SEPARATOR . $service;

        if (!is_dir($fullPath)) {
            echo json_encode([]); // Aucun dossier trouvé, retourner vide
            exit;
        }

        // Récupérer les utilisateurs actifs
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

    if ($action === 'getDirectoryStructure') {
        $basePath = realpath("../../public/documents/repertoires");

        if (!$basePath || !is_dir($basePath)) {
            throw new Exception("Chemin de base invalide.");
        }

        $structure = [];
        $entreprises = array_filter(scandir($basePath), function ($e) use ($basePath) {
            return $e !== '.' && $e !== '..' && is_dir($basePath . '/' . $e);
        });

        foreach ($entreprises as $entreprise) {
            $yearsPath = $basePath . '/' . $entreprise;
            $years = array_filter(scandir($yearsPath), fn($y) => is_dir("$yearsPath/$y") && $y !== '.' && $y !== '..');

            $structure[$entreprise] = [];
            foreach ($years as $year) {
                $servicesPath = "$yearsPath/$year";
                $services = array_filter(scandir($servicesPath), fn($s) => is_dir("$servicesPath/$s") && $s !== '.' && $s !== '..');
                $structure[$entreprise][$year] = array_values($services);
            }
        }

        echo json_encode($structure);
        exit;
    }

}