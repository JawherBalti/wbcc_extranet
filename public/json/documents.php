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
        // Retrieve POST data
        $historyAction = $_POST['historyAction'] ?? null; // User ID receiving the notification
        $idUtilisateurF = $_POST['idUtilisateurF'] ?? null;
        $fullName = $_POST['fullName'] ?? null;
        // Validate required parameters
        if (empty($historyAction)) {
            echo json_encode(0); // Return 0 on failure if parameters are missing
            exit;
        }
        $db->query("INSERT INTO wbcc_historique(action, nomComplet, idUtilisateurF) 
                        VALUES('$historyAction', '$fullName', $idUtilisateurF) ");

        // Check if insertion was successful
        if ($db->execute()) {
            echo json_encode(['success' => true, 'message' => 'Notification created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create notification.']);
        }
    }
    
    if ($action == 'createActivity') {
        // Retrieve POST data
        $assignePar = $_POST['assignePar'] ?? null; // User ID receiving the notification
        $assigneA = $_POST['assigneA'] ?? null;
        // Validate required parameters
        if (empty($historyAction)) {
            echo json_encode(0); // Return 0 on failure if parameters are missing
            exit;
        }
        $db->query("INSERT INTO wbcc_Activity(organizer, idRealisedBy, opName, startTime) 
                        VALUES('$assignePar', '$idRealisedBy', now()) ");

        // Check if insertion was successful
        if ($db->execute()) {
            echo json_encode(['success' => true, 'message' => 'Notification created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create notification.']);
        }
    }
    
    if ($action == 'getUser') {
        $userId = $_POST['userId'] ?? null; // User ID receiving the notification
        $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = (SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = $userId) ");
        $data = $db->single();
        echo json_encode(['success' => true, 'message' => $data]);

    }
    
    if ($action == 'copyDocument') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            
            // Validate input
            if (empty($data['sourceUrl']) || empty($data['destinationPath'])) {
                throw new Exception('Paramètres manquants');
            }
            
            // Get absolute paths
            $sourcePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($data['sourceUrl'], PHP_URL_PATH);
            $destinationDir = $_SERVER['DOCUMENT_ROOT'] . parse_url(URLROOT, PHP_URL_PATH) . '/public/documents/repertoires/' . $data['destinationPath'];
            
            // Create destination directory if it doesn't exist
            if (!file_exists($destinationDir)) {
                mkdir($destinationDir, 0777, true);
            }
            
            // Get filename from source path
            $filename = basename($sourcePath);
            $destinationPath = $destinationDir . '/' . $filename;
            
            // Check if source file exists
            if (!file_exists($sourcePath)) {
                throw new Exception('Fichier source introuvable');
            }
            
            // MOVE the file (instead of copying)
            if (!rename($sourcePath, $destinationPath)) {
                throw new Exception('Échec du déplacement du fichier');
            }
            
            // Log the action
            $logMessage = sprintf(
                "Document %s déplacé vers %s par %s (ID: %s)",
                $filename,
                $data['destinationPath'],
                $data['userName'],
                $data['userId']
            );
            error_log($logMessage);
            
            echo json_encode(['success' => true, 'message' => 'Document déplacé avec succès']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        
        exit;
    }
}