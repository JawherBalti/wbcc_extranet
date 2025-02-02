<?php

class Conge extends Model
{
    //Calcul de nombre de jours de congé et exclure les weekends
    function calculDays($startDate, $endDate) {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);
    
        $businessDays = 0;
        $currentDate = clone $startDate;
    
        while ($currentDate <= $endDate) {
            $dayOfWeek = $currentDate->format('w'); // 0 (Dimanche) to 6 (Samedi)
            if ($dayOfWeek != 0 && $dayOfWeek != 6) { // Exclure weekends
                $businessDays++;
            }
            $currentDate->add(new DateInterval('P1D')); // Passer au jour suivant
        }
        return $businessDays;
    }

    public function save($id, $idUtilisateur, $idTypeConge, $motif, $statut, $dateDebutSouhaite, $dateFinSouhaite, $dateDebutPropose, $dateFinPropose, $dateDebutConge, $dateFinConge, $commentaire, $idTraiteF )
    {
        $nbrJours = $this->calculDays($dateDebutSouhaite, $dateFinSouhaite);

        // Determine if this is an insert or update
        if (empty($id)) {
            // Insert new record
            $this->db->query("INSERT INTO wbcc_demandesconge 
                                (idUtilisateurF, idTraiteF, idTypeCongeF, motif, dateDebutDeCongeSouhaite, dateFinDeCongeSouhaite, commentaire,
                                dateDebutDeCongeReelle, dateFinDeCongeReelle, statut, dateDebutDeCongePropose, dateFinDeCongePropose,
                                dateCreation, dateModification, jours) 
                                VALUES (:id_contact, :id_traite, :type_de_conge, :motif, :date_debut_souhaite, :date_fin_souhaite, 
                                :commentaire, :date_debut_reelle, :date_fin_reelle, :statut, :date_debut_propose, 
                                :date_fin_propose, :date_creation, :date_modification, :jours)");


    
            $this->db->bind(":date_creation", date("Y-m-d H:i:s"));
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
            $this->db->bind(":id_contact", $idUtilisateur ?? null);
            $this->db->bind(":id_traite", $idTraiteF ?? null);
            $this->db->bind(":type_de_conge", $idTypeConge ?? null);
            $this->db->bind(":motif", $motif ?? null);
            $this->db->bind(":date_debut_souhaite", $dateDebutSouhaite ?? null);
            $this->db->bind(":date_fin_souhaite", $dateFinSouhaite ?? null);
            $this->db->bind(":date_debut_propose", $dateDebutPropose ?? null);
            $this->db->bind(":date_fin_propose", $dateFinPropose ?? null);
            $this->db->bind(":date_debut_reelle", $dateDebutConge ?? null);
            $this->db->bind(":date_fin_reelle", $dateFinConge ?? null);
            $this->db->bind(":commentaire", $commentaire ?? null);
            $this->db->bind(":statut", $statut ?? null);
            $this->db->bind(":jours", $nbrJours ?? null);
        } else {
            // Update existing record
            $this->db->query("UPDATE wbcc_demandesconge 
                                SET dateDebutDeCongeSouhaite = :date_debut_souhaite, 
                                    dateFinDeCongeSouhaite = :date_fin_souhaite, 
                                    idTypeCongeF = :type_de_conge, 
                                    motif = :motif, 
                                    dateModification = :date_modification,
                                    jours = :jours
                                WHERE idDemande = :id");
    
            $this->db->bind(":id", $id);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
            $this->db->bind(":type_de_conge", $idTypeConge ?? null);
            $this->db->bind(":motif", $motif ?? null);
            $this->db->bind(":date_debut_souhaite", $dateDebutSouhaite ?? null);
            $this->db->bind(":date_fin_souhaite", $dateFinSouhaite ?? null);
            $this->db->bind(":jours", $nbrJours ?? null);
        }
    
        // Binding object properties and handling nulls
        if ($this->db->execute()) {
            return $id ? $id : $this->db->lastInsertId();
        } else {
            return false;
        }
    }


    public function saveDocument($numeroDocument, $nomDocument, $urlDocument, $commentaire, $source, $publie) {
        // SQL query to insert the document data into the database
        $sql = "INSERT INTO wbcc_document (numeroDocument, nomDocument, urlDocument, commentaire, createDate, source, publie) 
                VALUES (:numeroDocument, :nomDocument, :urlDocument, :commentaire, NOW(), :source, :publie)";
        
        // Prepare the query
        $this->db->query($sql);
    
        // Bind parameters to the SQL query
        $this->db->bind(':numeroDocument', $numeroDocument);
        $this->db->bind(':nomDocument', $nomDocument);
        $this->db->bind(':urlDocument', $urlDocument);
        $this->db->bind(':commentaire', $commentaire);
        $this->db->bind(':source', $source);
        $this->db->bind(':publie', $publie);
    
        // Execute the query and check if the insertion was successful
        if ($this->db->execute()) {
            // Return the last inserted ID from the database
            return $this->db->lastInsertId();
        } else {
            // Return false if the query failed
            return false;
        }
    }


    public function linkDocumentToLeaveRequest($idDocumentF, $idDemandeF) {
        $sql = "INSERT INTO wbcc_document_conge (idDocumentF, idDemandeF) 
                VALUES (:idDocumentF, :idDemandeF)";
        
        $this->db->query($sql);
        $this->db->bind(':idDocumentF', $idDocumentF);
        $this->db->bind(':idDemandeF', $idDemandeF);

        return $this->db->execute();
    }

    public function updateCongeDatePropose($id, $userId, $employeId, $commentaire, $date_debut, $date_fin, $choix) {
        $dateDebutPropose = date('Y-m-d', strtotime($date_debut));
        $dateFinPropose = date('Y-m-d', strtotime($date_fin));

        $anneeEnCours = date("Y");

        //L'employé accepte la proposition
        if($choix == "true") {
            //Obtenir le solde cumulé et restant
            $soldeCongeQuery = "SELECT soldeCumule, soldeRestant FROM wbcc_solde_conge WHERE idUtilisateurF = :idUtilisateur AND annee = $anneeEnCours";
            $this->db->query($soldeCongeQuery);
            $this->db->bind(":idUtilisateur", $employeId);
            $soldeCongeResult = $this->db->single();
            // Calculer le nombre de jours de congé
            $nbrJours = $this->calculDays($date_debut, $date_fin);
            $joursRestant = 0; //Jours à deduire du solde restant
            $joursCumule = 0; //Jours à deduire du solde cumulé


            $totalSolde = $soldeCongeResult->soldeCumule + $soldeCongeResult->soldeRestant;

            // Vérifier si la somme des deux soldes est suffisante
            if($totalSolde < $nbrJours) {
                $response['success'] = false;
                $response['message'] = "Solde insuffisant";
            } 
            // Calcul du nombre de jours à déduire de chaque solde
            else if($soldeCongeResult->soldeCumule > $nbrJours) {
                $joursRestant = 0;
                $joursCumule = $nbrJours;
            } else {
                $joursRestant = $nbrJours - $soldeCongeResult->soldeCumule;
                $joursCumule = $soldeCongeResult->soldeCumule;
            }

            $updateDateSql ="UPDATE wbcc_demandesconge 
            SET dateDebutDeCongeReelle = :date_debut_propose, 
                dateFinDeCongeReelle = :date_fin_propose,
                statut = '1',
                jours = :jours,
                joursCumule = :joursCumule,
                joursRestant = :joursRestant,
                dateModification = :date_modification 
            WHERE idDemande = :id";
            $this->db->query($updateDateSql);

            $this->db->bind(":id", $id);
            $this->db->bind(":date_debut_propose",$dateDebutPropose);
            $this->db->bind(":date_fin_propose",$dateFinPropose);
            $this->db->bind(":jours",$nbrJours);
            $this->db->bind(":joursRestant", $joursRestant);
            $this->db->bind(":joursCumule", $joursCumule);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
    
            $result = $this->db->execute();

            if ($result) {
                // Récuperer le soldeRestant et soldeCumule de wbcc_solde_conge
                $newSoldeRestant = $soldeCongeResult->soldeRestant - $joursRestant;
                $newSoldeCumule = $soldeCongeResult->soldeCumule - $joursCumule;
                
                // Update the wbcc_solde_conge table
                $updateSql = "UPDATE wbcc_solde_conge 
                        SET soldeRestant = :soldeRestant, 
                        soldeCumule = :soldeCumule 
                        WHERE idUtilisateurF = :idUtilisateur AND annee = :annee";

                $this->db->query($updateSql);

                $this->db->bind(":soldeRestant", $newSoldeRestant);
                $this->db->bind(":soldeCumule", $newSoldeCumule);
                $this->db->bind(":idUtilisateur", $employeId);
                $this->db->bind(":annee", $anneeEnCours); // Assuming you have the user ID

                $result = $this->db->execute();
            }

            // Create an associative array to represent the response
            $response = array();
        
            if ($result) {
                $response['success'] = true;
                $response['message'] = "Date mise à jour avec succès."; // Optional success message
            } else {
                $response['success'] = false;
                $response['message'] = "Erreur lors de la mise à jour du statut."; // Important error message
            }
        } //L'employé n'accepte pas la proposition 
        else if ($choix == "false") {
            $this->db->query("UPDATE wbcc_demandesconge 
            SET statut = '2',
                dateModification = :date_modification 
            WHERE idDemande = :id");

            $this->db->bind(":id", $id);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));

            $result = $this->db->execute();

            // Create an associative array to represent the response
            $response = array();
        
            if ($result) {
                $response['success'] = true;
                $response['message'] = "Date mise à jour avec succès."; // Optional success message
            } else {
                $response['success'] = false;
                $response['message'] = "Erreur lors de la mise à jour du statut."; // Important error message
            }
        } // Le responsable propose une date
        else if ($choix == "") {
            $idTraiteF = $userId;
                $this->db->query("UPDATE wbcc_demandesconge 
                SET dateDebutDeCongePropose = :date_debut_propose, 
                    dateFinDeCongePropose = :date_fin_propose,
                    commentaire = :commentaire,
                    idTraiteF = :id_traite,
                    dateModification = :date_modification 
                WHERE idDemande = :id");

                $this->db->bind(":id", $id);
                $this->db->bind(":commentaire", $commentaire);
                $this->db->bind(":id_traite", $idTraiteF);
                $this->db->bind(":date_debut_propose",$dateDebutPropose);
                $this->db->bind(":date_fin_propose",$dateFinPropose);
                $this->db->bind(":date_modification", date("Y-m-d H:i:s"));

                $result = $this->db->execute();

                // Create an associative array to represent the response
                $response = array();
            
                if ($result) {
                    $response['success'] = true;
                    $response['message'] = "Date mise à jour avec succès."; // Optional success message
                } else {
                    $response['success'] = false;
                    $response['message'] = "Erreur lors de la mise à jour du statut."; // Important error message
                }
        }
        // Encode the response array as JSON and echo it
        echo json_encode($response);
    }


    public function updateCongeStatut($id, $userId, $employeId, $statut, $statutActuel, $nbrJoursActuel, $startDate, $endDate, $commentaire) {
        $idTraiteF =$userId;
        $anneeEnCours = date('Y');
    
        $response = array(); // Tableau de réponse
    
        // Cas 1 : Statut = 2 (Refusé)
        if ($statut == '2') {
            $this->db->query("UPDATE wbcc_demandesconge 
                SET statut = :statut, 
                    idTraiteF = :id_traite,
                    commentaire = :commentaire,
                    dateModification = :date_modification 
                WHERE idDemande = :id");
    
            $this->db->bind(":id", $id);
            $this->db->bind(":id_traite", $idTraiteF);
            $this->db->bind(":statut", $statut);
            $this->db->bind(":commentaire", $commentaire);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
        }
        // Cas 2 : Statut = 1 (Approuvé)
        else if ($statut == '1') {
            //Obtenir le solde cumulé et restant
            $soldeCongeQuery = "SELECT soldeCumule, soldeRestant FROM wbcc_solde_conge WHERE idUtilisateurF = :idUtilisateur AND annee = $anneeEnCours";
            $this->db->query($soldeCongeQuery);
            $this->db->bind(":idUtilisateur", $employeId);
            $soldeCongeResult = $this->db->single();
            // Calculer le nombre de jours de congé
            $nbrJours = $this->calculDays($startDate, $endDate);
            $joursRestant = 0; //Jours à deduire du solde restant
            $joursCumule = 0; //Jours à deduire du solde cumulé


            $totalSolde = $soldeCongeResult->soldeCumule + $soldeCongeResult->soldeRestant;

            // Vérifier si la somme des deux soldes est suffisante
            if($totalSolde < $nbrJours) {
                $response['success'] = false;
                $response['message'] = "Solde insuffisant";
            } 
            // Calcul du nombre de jours à déduire de chaque solde
            else if($soldeCongeResult->soldeCumule > $nbrJours) {
                $joursRestant = 0;
                $joursCumule = $nbrJours;
            } else {
                $joursRestant = $nbrJours - $soldeCongeResult->soldeCumule;
                $joursCumule = $soldeCongeResult->soldeCumule;
            }
                $this->db->query("UPDATE wbcc_demandesconge 
                    SET statut = :statut, 
                        idTraiteF = :id_traite,
                        dateDebutDeCongeReelle = :start_date,
                        dateFinDeCongeReelle = :end_date,
                        dateModification = :date_modification,
                        jours = :jours,
                        joursCumule = :joursCumule,
                        joursRestant = :joursRestant
                    WHERE idDemande = :id");
        
                $this->db->bind(":id", $id);
                $this->db->bind(":id_traite", $idTraiteF);
                $this->db->bind(":start_date", $startDate);
                $this->db->bind(":end_date", $endDate);
                $this->db->bind(":statut", $statut);
                $this->db->bind(":jours", $nbrJours);
                $this->db->bind(":joursRestant", $joursRestant);
                $this->db->bind(":joursCumule", $joursCumule);
                $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
                
                $result = $this->db->execute();

                if ($result) {
                    // Récuperer le soldeRestant et soldeCumule de wbcc_solde_conge
                    $newSoldeRestant = $soldeCongeResult->soldeRestant - $joursRestant;
                    $newSoldeCumule = $soldeCongeResult->soldeCumule - $joursCumule;
                    
                    // Update the wbcc_solde_conge table
                    $updateSql = "UPDATE wbcc_solde_conge 
                            SET soldeRestant = :soldeRestant, 
                            soldeCumule = :soldeCumule 
                            WHERE idUtilisateurF = :idUtilisateur AND annee = :annee";

                    $this->db->query($updateSql);

                    $this->db->bind(":soldeRestant", $newSoldeRestant);
                    $this->db->bind(":soldeCumule", $newSoldeCumule);
                    $this->db->bind(":idUtilisateur", $employeId);
                    $this->db->bind(":annee", $anneeEnCours); // Assuming you have the user ID

                    $result = $this->db->execute();
                }
        }
        // Cas 3 : Statut = 3 (Annulé)
        else if ($statut == '3') {
            //Modifier le statut de congé
            $this->db->query("UPDATE wbcc_demandesconge 
            SET statut = :statut, 
                dateModification = :date_modification 
            WHERE idDemande = :id");

            $this->db->bind(":id", $id);
            $this->db->bind(":statut", $statut);
            $this->db->bind(":date_modification", date("Y-m-d H:i:s"));
            $result = $this->db->execute();
            //Si l'utilisateur annule et le statut actuel est 'approuvé', rajouter le nbr de jours au solde 
            if ($statutActuel == '1') {
                $demandeQuery = "SELECT joursCumule, joursRestant FROM wbcc_demandesconge 
                                WHERE idDemande = :id";
                $this->db->query($demandeQuery);
                $this->db->bind(":id", $id);
                $demandeQueryResult = $this->db->single();
                if($demandeQueryResult) {
                    //Récuperer les jours cumulés et restants à rajouter au solde
                    $joursCumule = $demandeQueryResult->joursCumule;
                    $joursRestant = $demandeQueryResult->joursRestant;

                    // Récuperer le soldeRestant et soldeCumule de wbcc_solde_conge
                    $sql = "SELECT soldeRestant, soldeCumule FROM wbcc_solde_conge WHERE idUtilisateurF = :idUtilisateur AND annee = :annee";
                    $this->db->query($sql);
                    $this->db->bind(":idUtilisateur", $employeId);
                    $this->db->bind(":annee", $anneeEnCours);
                    $solde = $this->db->single();

                    $soldeRestant = $solde->soldeRestant;
                    $soldeCumule = $solde->soldeCumule;
                    $newSoldeRestant = $soldeRestant + $joursRestant;
                    $newSoldeCumule = $soldeCumule + $joursCumule;

                    // Update the wbcc_solde_conge table
                    $updateSql = "UPDATE wbcc_solde_conge 
                            SET soldeRestant = :soldeRestant, 
                            soldeCumule = :soldeCumule 
                            WHERE idUtilisateurF = :idUtilisateur AND annee = :annee";

                    $this->db->query($updateSql);

                    $this->db->bind(":soldeRestant", $newSoldeRestant);
                    $this->db->bind(":soldeCumule", $newSoldeCumule);
                    $this->db->bind(":idUtilisateur", $employeId);
                    $this->db->bind(":annee", $anneeEnCours); // Assuming you have the user ID

                    $result = $this->db->execute();

                }
            }
        }
    
        $result = $this->db->execute();
    
        // Construire la réponse JSON
        if ($result) {
            $response['success'] = true;
            $response['message'] = "Statut mis à jour avec succès.";
        } else {
            $response['success'] = false;
            $response['message'] = "Erreur lors de la mise à jour du statut.";
        }
    
        // Retourner la réponse JSON
        echo json_encode($response);
    }
    

    public function getAllWithFullName($orderBy = 'idDemande') 
    {
        $this->db->query("SELECT *
                        FROM wbcc_demandesconge");
        return $this->db->resultSet();
    }

    public function getAllWithContactId($idContact = null) {
        // Base query
        $query = "SELECT dc.*, c.fullName, u.matricule
                FROM wbcc_DemandesConge dc
                JOIN wbcc_contact c ON dc.idContact = c.idContact
                LEFT JOIN wbcc_utilisateur u ON u.idContactF = c.idContact";

        // If an idContact is provided, add a WHERE clause to filter
        if ($idContact) {
            $query .= " WHERE dc.idContact = :idContact";
        }

        // Order the results by idDemande
        $query .= " ORDER BY idDemande";

        // Prepare the query
        $this->db->query($query);

        // Bind the idContact if it's set
        if ($idContact) {
            $this->db->bind(":idContact", $idContact);
        }

        // Execute and return the result set
        return $this->db->resultSet();
    }
    

    public function createConge($type, $quota, $politique) {
        $this->db->query("INSERT INTO wbcc_type_conge (type, quotas, politique, createDate, editDate) VALUES (:type, :quota, :politique, :createDate, :editDate)") ;
        $this->db->bind(":type", $type);
        $this->db->bind(":quota", $quota);
        $this->db->bind(":politique", $politique);
        $this->db->bind(":createDate", date("Y-m-d H:i:s"));
        $this->db->bind(":editDate", date("Y-m-d H:i:s"));

        return $this->db->execute();
    }

    public function updateTypeConge($id, $type, $quota, $politique) {
        $sql = "UPDATE wbcc_type_conge SET type = :type, quotas = :quota, politique = :politique, editDate = :editDate WHERE idTypeConge = :id";
        $this->db->query($sql);
        $this->db->bind(":type", $type);
        $this->db->bind(":quota", $quota);
        $this->db->bind(":politique", $politique);
        $this->db->bind(":editDate", date("Y-m-d H:i:s"));
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    public function getAllTypesConge() {
        $sql = "SELECT * FROM wbcc_type_conge ORDER BY createDate DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getTypeCongeById($id) {
        $sql = "SELECT * FROM wbcc_type_conge WHERE idTypeConge = :id;";
        $this->db->query($sql);
        $this->db->bind(":id", $id);
        return $this->db->single();
    }

    public function getCongeById($idDemande) {
        // Query to fetch conge details
        $this->db->query("SELECT 
            dc.*, 
            tc.*, 
            demandeur.fullName AS fullName,
            u.matricule, 
            u.email, 
            s.nomSite,
            traiteur.fullName AS nomTraite
            FROM wbcc_demandesconge dc
            JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
            LEFT JOIN wbcc_contact demandeur ON demandeur.idContact = u.idContactF
            LEFT JOIN wbcc_utilisateur uTraiteur ON dc.idTraiteF = uTraiteur.idUtilisateur
            LEFT JOIN wbcc_contact traiteur ON traiteur.idContact = uTraiteur.idContactF
            LEFT JOIN wbcc_site s ON s.idSite = u.idSiteF
            LEFT JOIN wbcc_type_conge tc ON dc.idTypeCongeF = tc.idTypeConge 
            WHERE dc.idDemande = :idDemande;
        ");
    
            // Bind the parameter
            $this->db->bind(":idDemande", $idDemande);
    
            // Fetch conge data
            $congeData = $this->db->single();
        
            if ($congeData) {
                // Query to fetch associated documents
                $this->db->query("SELECT 
                        wbd.urlDocument, 
                        wbd.nomDocument,
                        wbd.commentaire
                    FROM wbcc_document_conge wdc
                    JOIN wbcc_document wbd ON wdc.idDocumentF = wbd.idDocument
                    WHERE wdc.idDemandeF = :idDemande
                ");
        
                // Bind the parameter
                $this->db->bind(":idDemande", $idDemande);
        
                // Fetch all associated documents
                $documents = $this->db->resultSet();
        
                // Add the documents list to the conge data
                $congeData->documents = $documents;
        
                return $congeData;
            } else {
                return null;
            }
        }

    public function getFilteredConge($typeConge,$statut, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $idUtilisateur, $annee) {
        $sql = "SELECT dc.*, tc.*, c.fullName, u.matricule, u.jourTravail , u.horaireTravail 
        FROM wbcc_demandesconge dc
        JOIN wbcc_utilisateur u ON dc.idUtilisateurF = u.idUtilisateur
        JOIN wbcc_type_conge tc ON dc.idTypeCongeF =tc.idTypeConge
        LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
        WHERE 1=1";

        $bindParams = [];

        $joursAquisParMois = 2;

        // Apply 'statut' filter
        if ($statut == '0') {
            $sql .= " AND dc.statut = '0'";
        } elseif ($statut == '1') {
            $sql .= " AND dc.statut = '1'";
        } elseif ($statut == '2') {
            $sql .= " AND dc.statut = '2'";
        }elseif ($statut == '3') {
            $sql .= " AND dc.statut = '3'";
        }
        // Apply 'type congé' filter
        if(!empty($typeConge)) {
            $sql .= " AND dc.idTypeCongeF = $typeConge";
        }

        // Apply 'utilisateur' filter
        if (!empty($idUtilisateur)) {
            $sql .= " AND u.idUtilisateur = :idUtilisateur";
            $bindParams[':idUtilisateur'] = $idUtilisateur;
        }

        // Apply 'site' filter
        if (!empty($idSite)) {
            $sql .= " AND u.idSiteF = :idSite";
            $bindParams[':idSite'] = $idSite;
        }

        // Apply 'annee' filter
        if (!empty($annee)) {
            $sql .= " AND YEAR(dc.dateDebutDeCongeSouhaite) = :annee";
            $bindParams[':annee'] = $annee;
        }

        // Apply 'periode' filter
        switch ($periode) {
            case 'today':
                $sql .= " AND dc.dateDebutDeCongeSouhaite = :today";
                $bindParams[':today'] = date('Y-m-d');
            case '1': // 'A la date du'
                if ($dateOne) {
                    // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND dc.dateDebutDeCongeSouhaite = :dateOne";
                        $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
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
                        $sql .= " AND dc.dateDebutDeCongeSouhaite BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;
            default:
                // No period filter applied
                break;
        }

        $sql.= " ORDER BY dateCreation desc";

        $this->db->query($sql);

        foreach ($bindParams as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }
    public function batchConge() {
        $anneeEnCours = 2026;
    
        // Récupérer tous les utilisateurs
        $utilisateursQuery = "SELECT idUtilisateur FROM wbcc_utilisateur";
        $this->db->query($utilisateursQuery);
        $utilisateursResult = $this->db->resultSet();
    
        foreach ($utilisateursResult as $res) {
            $idUtilisateur = $res->idUtilisateur;
    
            // Récupérer le solde restant de l'année précédente (s'il existe)
            $anneePrecedente = $anneeEnCours - 1;
            $soldePrecedentQuery = "SELECT soldeRestant, soldeCumule FROM wbcc_solde_conge WHERE idUtilisateurF = $idUtilisateur AND annee = $anneePrecedente";
            $this->db->query($soldePrecedentQuery);
            $soldePrecedentResult = $this->db->single();
    
            // Si aucune donnée n'existe, on part sur 0
            $soldeCumule = ($soldePrecedentResult) ? $soldePrecedentResult->soldeRestant + $soldePrecedentResult->soldeCumule : 0;
    
            // Vérifier si un enregistrement existe pour l'utilisateur et l'année en cours
            $soldeQuery = "SELECT * FROM wbcc_solde_conge WHERE idUtilisateurF = $idUtilisateur AND annee = $anneeEnCours";
            $this->db->query($soldeQuery);
            $existant = $this->db->single();
    
            if ($existant) {
                // Calcul du nouveau soldeRestant en ajoutant 2, sans dépasser 22
                $nouveauSoldeRestant = $existant->soldeRestant + 2;
                if ($nouveauSoldeRestant > 22) {
                    $nouveauSoldeRestant = 22;
                }
                
                // Mettre à jour le soldeRestant avec la valeur calculée
                $updateQuery = "UPDATE wbcc_solde_conge 
                                SET soldeRestant = $nouveauSoldeRestant 
                                WHERE idUtilisateurF = $idUtilisateur AND annee = $anneeEnCours";
                $this->db->query($updateQuery);
                $this->db->execute();
            } else {
                // Insérer un nouvel enregistrement :
                // - soldeCumule est égal au soldeRestant de l'année précédente (ou 0 s'il n'existe pas)
                // - soldeRestant est fixé à 2
                $insertQuery = "INSERT INTO wbcc_solde_conge (idUtilisateurF, annee, soldeCumule, soldeRestant) 
                                VALUES ($idUtilisateur, $anneeEnCours, $soldeCumule, 2)";
                $this->db->query($insertQuery);
                $this->db->execute();
            }
        }
    }
    
    
    // public function batchConge() {
    //     $anneeEnCours = date('Y');
    
    //     $utilisateursQuery = "SELECT idUtilisateur FROM wbcc_utilisateur";
    //     $this->db->query($utilisateursQuery);
    //     $utilisateursResult = $this->db->resultSet();
    
    //     foreach ($utilisateursResult as $res) {
    //         $idUtilisateur = $res->idUtilisateur;
    
    //         // Récupérer le solde cumulé de l'année précédente
    //         $anneePrecedente = $anneeEnCours - 1;
    //         $soldePrecedentQuery = "SELECT soldeCumule FROM wbcc_solde_conge WHERE idUtilisateurF = $idUtilisateur AND annee = $anneePrecedente";
    //         $this->db->query($soldePrecedentQuery);
    //         $soldePrecedentResult = $this->db->single();
    
    //         $soldeReporte = 0;
    //         if ($soldePrecedentResult) {
    //             $soldeReporte = $soldePrecedentResult->soldeCumule;
    //         }
    
    //         // Vérifier si un enregistrement existe pour l'utilisateur et l'année en cours
    //         $soldeQuery = "SELECT * FROM wbcc_solde_conge WHERE idUtilisateurF = $idUtilisateur AND annee = $anneeEnCours";
    //         $this->db->query($soldeQuery);
    //         $exec = $this->db->single();
    
    //         if ($exec) {
    //             // Mettre à jour le solde cumulé et restant
    //             $updateQuery = "UPDATE wbcc_solde_conge SET soldeCumule = soldeCumule + 2, soldeRestant = soldeRestant + 2 WHERE idUtilisateurF = $idUtilisateur AND annee = $anneeEnCours";
    //             $this->db->query($updateQuery);
    //             $this->db->execute();
    //         } else {
    //             // Insérer un nouvel enregistrement en tenant compte du solde reporté
    //             $insertQuery = "INSERT INTO wbcc_solde_conge (idUtilisateurF, annee, soldeCumule, soldeRestant) VALUES ($idUtilisateur, $anneeEnCours, $soldeReporte + 2, 2)";
    //             $this->db->query($insertQuery);
    //             $this->db->execute();
    //         }
    //     }
    // }

    public function getSolde($idUtilisateur, $annee) {
        $anneeEnCours = date('Y');
        $sql = "";
        if(empty($annee)) {
            $sql = "SELECT * FROM wbcc_solde_conge
                    WHERE idUtilisateurF = :idUtilisateurF
                    AND annee = $anneeEnCours";
            $this->db->query($sql);
            $this->db->bind(":idUtilisateurF", $idUtilisateur);
            $result = $this->db->single();
            return $result;
        }else {
            $sql = "SELECT * FROM wbcc_solde_conge
                    WHERE idUtilisateurF = $idUtilisateur
                    AND annee = $annee";
            $this->db->query($sql);
            $result = $this->db->single();
            return $result;
        }
    }
}