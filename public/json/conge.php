<?php
header('Access-Control-Allow-Origin: *');

require_once "../../app/config/config.php";
require_once "../../app/libraries/Database.php";
require_once "../../app/libraries/Model.php"; // Correct path to Model.php
require_once "../../app/models/Conge.php";
$db = new Database();
$conge = new Conge();


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    // Fetch a leave request by ID
    if ($action == 'findById') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to get leave request details along with employee information
            $db->query("SELECT dc.*, c.fullName, u.matricule
                        FROM wbcc_demandesConge dc
                        JOIN wbcc_contact c ON dc.idContact = c.idContact
                        LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                        WHERE dc.idDemande = :id");

            // Bind the leave request ID
            $db->bind(":id", $id);

            // Fetch the data
            $result = $db->single();

            // Check if the leave request exists
            if ($result) {
                echo json_encode($result);
            } else {
                // Return an error message if no record is found
                echo json_encode(['error' => 'Aucune demande de congé trouvée avec cet ID.']);
            }
        } else {
            echo json_encode("Missing ID parameter");
        }
    }
    if ($action == 'updateDate') {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $updateField = ''; // This will hold which field to update (dateDebutReelle or dateFinReelle)
    
            // Check which date we are updating
            if (isset($_POST['dateDebutReelle'])) {
                $updateField = 'dateDebutDeCongeReelle';
                $dateToUpdate = $_POST['dateDebutReelle'];
            } elseif (isset($_POST['dateFinReelle'])) {
                $updateField = 'dateFinDeCongeReelle';
                $dateToUpdate = $_POST['dateFinReelle'];
            } else {
                echo json_encode("Missing date parameter");
                exit;
            }
    
            // Update query with dynamic field
            $query = "UPDATE wbcc_demandesConge SET $updateField = :dateToUpdate WHERE idDemande = :id";
            $db->query($query);
            $db->bind(':dateToUpdate', $dateToUpdate);
            $db->bind(':id', $id);
            $updateResult = $db->execute();
    
            // Return the appropriate JSON response
            if ($updateResult) {
                echo json_encode("Date updated successfully");
            } else {
                echo json_encode("Error updating date");
            }
        } else {
            echo json_encode("Missing parameters");
        }
    }
    
    if ($action == 'getAllCongeByIdContact') {
        if (isset($_GET['idContact'])) {
            $idContact = $_GET['idContact'];

            // Query to get all leave requests for a specific contact
            $db->query("SELECT dc.*, c.fullName, u.matricule
                        FROM wbcc_demandesConge dc
                        JOIN wbcc_contact c ON dc.idContact = c.idContact
                        LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact
                        WHERE dc.idContact = :idContact");

            // Bind the contact ID
            $db->bind(":idContact", $idContact);

            // Fetch the data
            $result = $db->resultSet();

            // Check if any leave requests exist
            if ($result) {
                echo json_encode($result);
            } else {
                // Return an error message if no record is found
                echo json_encode(['error' => 'Aucune demande de congé trouvée pour cet ID de contact.']);
            }
        } else {
            echo json_encode("Missing idContact parameter");
        }
    }

   
     // Update the status of a leave request
     if ($action == 'updateStatus') {
        if (isset($_POST['idDemande']) && isset($_POST['statut']) && isset($_POST['commentaire'])) {
            $idDemande = $_POST['idDemande'];
            $statut = $_POST['statut'];
            $commentaire = $_POST['commentaire'];
    
            // Prepare the SQL statement to update both statut and commentaire
            $query = "UPDATE wbcc_demandesConge 
                    SET statut = :statut, 
                        commentaire = :commentaire, 
                        dateModification = :dateModification 
                    WHERE idDemande = :idDemande";
    
            $db->query($query);
            $db->bind(':statut', $statut);
            $db->bind(':commentaire', $commentaire);
            $db->bind(':dateModification', date('Y-m-d H:i:s')); // Current timestamp
            $db->bind(':idDemande', $idDemande);
            
            // Use execute() for an UPDATE query
            $updateResult = $db->execute();
    
            if ($updateResult) {
                echo json_encode(['success' => true, 'message' => 'Status and note updated successfully']);
            } else {
                echo json_encode(['success' => false, 'error' => 'Error updating status and note']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Missing parameters']);
        }
    }
    
        
    if ($action == 'filterConges') {

        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
        $dateDemande = isset($_POST['dateDemande']) ? $_POST['dateDemande'] : '';
        $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // Pour "A la date du"
        $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // Pour "Personnaliser"
        $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // Pour "Personnaliser"
        $userid = isset($_POST['userid']) ? $_POST['userid'] : '';
    
        // Requête SQL de base
        $sql = "SELECT d.*
                FROM wbcc_demandesConge d
                WHERE d.idContact = :userid";
    
        // Tableau pour stocker les paramètres à lier
        $bindParams = [':userid' => $userid];
    
        // Ajouter des filtres en fonction des entrées utilisateur
        if (!empty($typeConge)) {
            $sql .= " AND d.typeConge = :typeConge";
            $bindParams[':typeConge'] = $typeConge;
        }
    
        if ($statut !== '') {
            // Assurez-vous que le statut est soit '0', '1', soit '2'
          
                $sql .= " AND d.statut = :statut";
                $bindParams[':statut'] = $statut;
        
        }
    
        // Appliquer le filtre "période"
        switch ($dateDemande) {
            case 'today':
                $sql .= " AND d.dateDebutDeCongeSouhaite = :today";
                $bindParams[':today'] = date('Y-m-d');
                break;
    
            case '1': // "A la date du"
                if ($dateOne) {
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite = :dateOne";
                        $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateOne']);
                        exit;
                    }
                }
                break;
    
            case '2': // "Personnaliser"
                if ($dateDebut && $dateFin) {
                    $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                    $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                    if ($dateDebutFormatted && $dateFinFormatted) {
                        $sql .= " AND d.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
    
            default:
                // Aucun filtre de période appliqué
                break;
        }
    
        // Préparer et exécuter la requête
        $db->query($sql);
    
        // Lier dynamiquement les paramètres
        foreach ($bindParams as $param => $value) {
            $db->bind($param, $value);
        }
    
        // Récupérer les données filtrées
        $results = $db->resultset();
    
        // Sortir les résultats au format JSON
        echo json_encode($results);
    }
    if ($action == 'filterCongesAdmin') {
        $typeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : '';
        $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
       
        $dateDemande = isset($_POST['dateDemande']) ? $_POST['dateDemande'] : '';
        $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // Pour "A la date du"
        $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // Pour "Personnaliser"
        $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // Pour "Personnaliser"
        $idUtilisateur = isset($_POST['contact']) ? $_POST['contact'] : ''; // For filtering by user
          $sql = "SELECT d.* , c.fullName, u.matricule
                FROM wbcc_demandesConge d
                JOIN wbcc_contact c ON c.idContact = d.idContact
               LEFT   JOIN wbcc_utilisateur u ON c.idContact = u.idContactF

             WHERE 1=1";
     
     $bindParams = [];
             // Ajouter des filtres en fonction des entrées utilisateur
             if (!empty($typeConge)) {
                $sql .= " AND d.typeConge = :typeConge";
                $bindParams[':typeConge'] = $typeConge;
            }
        
            if ($statut !== '') {
                // Assurez-vous que le statut est soit '0', '1', soit '2'
              
                    $sql .= " AND d.statut = :statut";
                    $bindParams[':statut'] = $statut;
            
            }
            if (!empty($idUtilisateur)) {
                $sql .= " AND c.idContact = :idUtilisateur";
                $bindParams[':idUtilisateur'] = $idUtilisateur;
            }
            // Appliquer le filtre "période"
            switch ($dateDemande) {
                case 'today':
                    $sql .= " AND d.dateDebutDeCongeSouhaite = :today";
                    $bindParams[':today'] = date('Y-m-d');
                    break;
        
                case '1': // "A la date du"
                    if ($dateOne) {
                        $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                        if ($dateOneFormatted) {
                            $sql .= " AND d.dateDebutDeCongeSouhaite = :dateOne";
                            $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                        } else {
                            echo json_encode(['error' => 'Invalid date format for dateOne']);
                            exit;
                        }
                    }
                    break;
        
                case '2': // "Personnaliser"
                    if ($dateDebut && $dateFin) {
                        $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                        $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                        if ($dateDebutFormatted && $dateFinFormatted) {
                            $sql .= " AND d.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                            $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                            $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                        } else {
                            echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                            exit;
                        }
                    }
                    break;
        
                default:
                    // Aucun filtre de période appliqué
                    break;
            }
        
            // Préparer et exécuter la requête
            $db->query($sql);
        
            // Lier dynamiquement les paramètres
            foreach ($bindParams as $param => $value) {
                $db->bind($param, $value);
            }
        
            // Récupérer les données filtrées
            $results = $db->resultset();
        
            // Sortir les résultats au format JSON
            echo json_encode($results);
    }

    if ($action == 'saveConge') {
        // Sanitize and initialize the form inputs
        $congeId = isset($_POST['congeId']) ? $_POST['congeId'] : '';
        $idTypeConge = isset($_POST['typeConge']) ? $_POST['typeConge'] : ''; 
        $motif = isset($_POST['motif']) ? $_POST['motif'] : '';
        $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
        $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
        $statut = "0"; // Default status
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
        $nomDocuments = isset($_POST['nomDocument']) ? $_POST['nomDocument'] : [];
        $comments = isset($_POST['comments']) ? $_POST['comments'] : [];
    
        // Check if required fields are not empty
        if (!empty($idTypeConge) && !empty($startDate) && !empty($endDate) && !empty($userId)) {
            // Save or update the conge
            $congeId = $conge->save($congeId, $userId, $idTypeConge, $motif, $statut, $startDate, $endDate, null, null, null, null, null, null);
    
            if ($congeId) { // Check if the save/update was successful
                // Handle file uploads only if it's a new conge (no ID provided)
                if (isset($_FILES['attachments']) && count($_FILES['attachments']['name']) > 0) {
                    $uploadDir = "../documents/conge/justification/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
    
                    $errorMessages = [];
                    $successCount = 0;
    
                    for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
                        if ($_FILES['attachments']['error'][$i] == UPLOAD_ERR_OK) {
                            $uploadedFile = $_FILES['attachments']['tmp_name'][$i];
                            $originalFileName = $_FILES['attachments']['name'][$i];
                            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    
                            // Validate file extension
                            if (!in_array($fileExtension, ['pdf', 'mp4', 'jpg', 'jpeg', 'png'])) {
                                $errorMessages[] = "Unsupported file type for $originalFileName";
                                continue;
                            }
    
                            // Generate document name
                            $numeroDocument = "DOC" . date('dmYHis') . $congeId . $i;
                            $nomDocumentSanitized = preg_replace('/[^a-zA-Z0-9.-]/', '', $nomDocuments[$i] ?? "Unnamed_Document_$i");
                            $dateNow = date('YmdHis');
                            $urlDocument = 'Pj_' . $congeId . '' . $nomDocumentSanitized . '' . $dateNow . '.' . $fileExtension;
    
                            // Move the uploaded file to the desired directory
                            if (move_uploaded_file($uploadedFile, $uploadDir . $urlDocument)) {
                                // Save the document and return its ID
                                $documentId = $conge->saveDocument($numeroDocument, $nomDocuments[$i] ?? "Unnamed_Document_$i", $urlDocument, $comments[$i] ?? null, 'EXTRANET', 1);
    
                                if ($documentId) {
                                    if ($conge->linkDocumentToLeaveRequest($documentId, $congeId)) {
                                        $successCount++;
                                    } else {
                                        $errorMessages[] = "Failed to link document $originalFileName.";
                                    }
                                } else {
                                    $errorMessages[] = "Failed to save document $originalFileName.";
                                }
                            } else {
                                $errorMessages[] = "Failed to move uploaded file $originalFileName.";
                            }
                        } else {
                            $errorMessages[] = "Error uploading file $i: " . $_FILES['attachments']['error'][$i];
                        }
                    }
    
                    if (!empty($errorMessages)) {
                        echo json_encode("0");
                        return;
                    }
                }
    
                // Return the correct success message based on whether it's an insert or update
                echo json_encode(['success' => true, 'message' => $congeId ? 'Demande de congé mise à jour avec succès.' : 'Demande de congé enregistrée avec succès.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la sauvegarde de la demande de congé.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
        }
    }

    //*************************************************************************************************** */
    if ($action == 'updateCongeStatut') {
        $inputData = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $congeId = $inputData['congeId'] ?? null;
        $statut = $inputData['statut'] ?? null;
        $statutActuel = $inputData['statutActuel'] ?? null;
        $nbrJoursActuel = $inputData['nbrJoursActuel'] ?? null;
        $userId = $inputData['userId'] ?? null;
        $employeId = $inputData['employeId'] ?? null;
        $startDate = $inputData['startDate'] ?? null;
        $endDate = $inputData['endDate'] ?? null;
        $commentaire = $inputData['commentaire'] ?? null;
        $conge->updateCongeStatut($congeId, $userId, $employeId, $statut, $statutActuel, $nbrJoursActuel, $startDate, $endDate, $commentaire);
    }

    if ($action == 'updateCongeDatePropose') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $congeId = isset($data['congeId']) ? $data['congeId'] : '';
        $employeId = isset($data['employeId']) ? $data['employeId'] : '';
        $userId = isset($data['userId']) ? $data['userId'] : '';
        $commentaire = isset($data['commentaire']) ? $data['commentaire'] : '';
        $startDate = isset($data['startDate']) ? $data['startDate'] : '';
        $endDate = isset($data['endDate']) ? $data['endDate'] : '';
        $choix = isset($data['choix']) ? $data['choix'] : '';
        $conge->updateCongeDatePropose($congeId, $userId, $employeId, $commentaire, $startDate, $endDate, $choix);
    }

    // if ($action == 'updateCongeDatePropose') {
    //     $congeId = isset($_POST['congeId']) ? $_POST['congeId'] : '';
    //     $employeId = isset($_POST['employeId']) ? $_POST['employeId'] : '';
    //     $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
    //     $commentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';
    //     $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    //     $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
    //     $choix = isset($_POST['choix']) ? $_POST['choix'] : '';
    //     $conge->updateCongeDatePropose($congeId, $userId, $employeId, $commentaire, $startDate, $endDate, $choix);
    // }

    if ($action == 'saveTypeConge') {
        // Récupération des données entrantes (JSON ou POST)
        $inputData = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
        // Extraction des données du formulaire
        $typeConge = $inputData['typeConge'] ?? '';
        $quotaConge = $inputData['quotaConge'] ?? '';
        $politique = $inputData['politique'] ?? '';
    
        // Validation des champs requis
        if (!empty($typeConge) && !empty($quotaConge)) {
            // Appel de la méthode createConge
            $result = $conge->createConge($typeConge, $quotaConge, $politique);
    
            if ($result) {
                $response = ['success' => true, 'message' => 'Type de congé ajouté avec succès.'];
            } else {
                $response = ['success' => false, 'message' => 'Erreur lors de l\'ajout du type de congé.'];
            }
        } else {
            $response = ['success' => false, 'message' => 'Tous les champs obligatoires doivent être remplis.'];
        }
    
        // Envoi de la réponse JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    if ($action == 'updateTypeConge') {
        // Retrieve form data sent via AJAX
        $congeId = isset($_POST['congeId']) ? $_POST['congeId'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $quota = isset($_POST['quota']) ? $_POST['quota'] : '';
        $politique = isset($_POST['politique']) ? $_POST['politique'] : '';
        // Validate required fields
        if (!empty($type) && !empty($quota)) {
            $conge->updateTypeConge($congeId, $type, $quota, $politique);
        } else {
            echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs requis.']);
        }
    }


    if ($action == 'getTypeCongeById') {
        $idTypeConge = $_POST['idTypeConge'] ?? json_decode(file_get_contents('php://input'), true)['idTypeConge'] ?? null;
        if ($idTypeConge) {
            $typeConge = $conge->getTypeCongeById($idTypeConge);
            echo json_encode($typeConge ?: "0");
            exit;
        }
    }

    if ($action == 'getCongeById') {
        $idDemande = $_POST['idDemande'] ?? json_decode(file_get_contents('php://input'), true)['idDemande'] ?? null;
        if ($idDemande) {
            $congesListe = $conge->getCongeById($idDemande);
            echo json_encode($congesListe ?: "0");
        }
    }


    if ($action == 'getAllWithidUser') {
        // Retrieve $idUser from POST or GET data
        $idUser = $_POST['idUser'] ?? $_GET['idUser'] ?? null;

        // Check if $idUser is set
        if ($idUser) {
            $db->query("
            SELECT dc.*, tc.type
            FROM wbcc_demandesConge dc
            JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
            JOIN wbcc_type_conge tc ON dc.idTypeCongeF = tc.idTypeConge
            WHERE dc.idUtilisateurF = :idUser
            ORDER BY dc.dateCreation DESC
           ");
            // Bind the user ID
            $db->bind(':idUser', $idUser);

            // Execute the query and get results
            $results = $db->resultSet();

          
            // Return results as JSON or an error message if no results
            if ($results) {
                echo json_encode($results);
            } else {
                echo json_encode("0");
            }
        } else {
            // Return error if $idUser is not provided
            echo json_encode(['error' => 'idUser is required.']);
        }
    }
    if ($action == 'getTypeConge') {
       
        $db->query("
            SELECT tc.*
            FROM wbcc_type_conge tc
        ");
    
        $results = $db->resultSet();
        if ($results) {
            echo json_encode($results);
        } else {
            echo json_encode("0");
        }
    }

    if($action == "batchConge") {
        $conge->batchConge();
    }
}
?>
