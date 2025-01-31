<?php

class Pointage extends Model
{
    public function save()
    {
        if ($idPointage == null) {
            // Insert new record
            $this->db->query("INSERT INTO wbcc_pointage 
                            (numeroPointage, datePointage, heureDebutPointage, adressePointage, heureDebutJour, heureFinJour,
                             marge, adresseProgramme, anomalieDebutJour, nbMinuteRetard, retard, absent, motifRetard, 
                             traite, idTraiteF, auteurTraite, dateTraite, resultatTraite, heureFinPointage, 
                             adresseFinPointage, adresseProgrammeFin, anomalieFinJour, idUserF, auteur)
                            VALUES (:numeroPointage, :datePointage, :heureDebutPointage, :adressePointage, :heureDebutJour, 
                                    :marge, :adresseProgramme, :anomalieDebutJour, :nbMinuteRetard, :retard, :absent, 
                                    :motifRetard, :traite, :idTraiteF, :auteurTraite, :dateTraite, :resultatTraite, 
                                    :heureFinPointage, :adresseFinPointage, :adresseProgrammeFin, :anomalieFinJour, 
                                    :idUserF, :auteur)");

            $this->db->bind(":datePointage", date("Y-m-d H:i:s"));
        } else {
            // Update existing record
            $this->db->query("UPDATE wbcc_pointage 
                            SET numeroPointage = :numeroPointage, 
                                datePointage = :datePointage, 
                                heureDebutPointage = :heureDebutPointage, 
                                adressePointage = :adressePointage, 
                                heureDebutJour = :heureDebutJour,
                                heureFinJour = :heureFinJour, 
                                marge = :marge, 
                                adresseProgramme = :adresseProgramme, 
                                anomalieDebutJour = :anomalieDebutJour, 
                                nbMinuteRetard = :nbMinuteRetard, 
                                retard = :retard, 
                                absent = :absent, 
                                motifRetard = :motifRetard, 
                                traite = :traite, 
                                idTraiteF = :idTraiteF, 
                                auteurTraite = :auteurTraite, 
                                dateTraite = :dateTraite, 
                                resultatTraite = :resultatTraite, 
                                heureFinPointage = :heureFinPointage, 
                                adresseFinPointage = :adresseFinPointage, 
                                adresseProgrammeFin = :adresseProgrammeFin, 
                                anomalieFinJour = :anomalieFinJour, 
                                idUserF = :idUserF, 
                                auteur = :auteur 
                            WHERE idPointage = :idPointage");

            $this->db->bind(":idPointage", $this->idPointage);
        }

        // Binding object properties
        $this->db->bind(":numeroPointage", $this->numeroPointage ?? null);
        $this->db->bind(":datePointage", $this->datePointage ?? null);
        $this->db->bind(":heureDebutPointage", $this->heureDebutPointage ?? null);
        $this->db->bind(":adressePointage", $this->adressePointage ?? null);
        $this->db->bind(":heureDebutJour", $this->heureDebutJour ?? null);
        $this->db->bind(":heureFinJour", $this->heureFinJour ?? null);
        $this->db->bind(":marge", $this->marge ?? null);
        $this->db->bind(":adresseProgramme", $this->adresseProgramme ?? null);
        $this->db->bind(":anomalieDebutJour", $this->anomalieDebutJour ?? null);
        $this->db->bind(":nbMinuteRetard", $this->nbMinuteRetard ?? null);
        $this->db->bind(":retard", $this->retard ?? null);
        $this->db->bind(":absent", $this->absent ?? null);
        $this->db->bind(":motifRetard", $this->motifRetard ?? null);
        $this->db->bind(":traite", $this->traite ?? null);
        $this->db->bind(":idTraiteF", $this->idTraiteF ?? null);
        $this->db->bind(":auteurTraite", $this->auteurTraite ?? null);
        $this->db->bind(":dateTraite", $this->dateTraite ?? null);
        $this->db->bind(":resultatTraite", $this->resultatTraite ?? null);
        $this->db->bind(":heureFinPointage", $this->heureFinPointage ?? null);
        $this->db->bind(":adresseFinPointage", $this->adresseFinPointage ?? null);
        $this->db->bind(":adresseProgrammeFin", $this->adresseProgrammeFin ?? null);
        $this->db->bind(":anomalieFinJour", $this->anomalieFinJour ?? null);
        $this->db->bind(":idUserF", $this->idUserF ?? null);
        $this->db->bind(":auteur", $this->auteur ?? null);

        return $this->db->execute() ? ($this->idPointage ?? $this->db->lastInsertId()) : false;
    }

    public function findById($idPointage)
    {
        $this->db->query("SELECT * FROM wbcc_pointage WHERE idPointage = :idPointage");
        $this->db->bind(":idPointage", $idPointage);
        return $this->db->single();
    }

    public function getAll($orderBy = 'idPointage')
    {
        $this->db->query("SELECT * FROM wbcc_pointage ORDER BY $orderBy");
        return $this->db->resultSet();
    }

    public function getFilteredPointage($Motifjustification,$etat, $site, $periode, $dateOne, $dateDebut, $dateFin, $matricule, $idUtilisateur) {

        $sql = "SELECT p.*, c.fullName, u.matricule, u.jourTravail , u.horaireTravail 
        FROM wbcc_pointage p
        JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
        LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
        WHERE 1=1";

    // Array to hold bind parameters
    $bindParams = [];

    // Apply 'etat' filter
    if ($etat === 'Retard') {
        $sql .= " AND p.retard = 1";
    } elseif ($etat === 'Absent') {
        $sql .= " AND p.absent = 1";
    } elseif ($etat === 'Present') {
        $sql .= " AND p.retard = 0 AND p.absent = 0";
    }

    // Apply 'Motifjustification' filter
    if ($Motifjustification === 'justifie') {
        $sql .= " AND p.resultatTraite = 'Accepté'";
    } elseif ($Motifjustification === 'injustifie') {
        $sql .= " AND p.resultatTraite = 'Refusé'";
    }
    if (!empty($matricule)) {
        $sql .= " AND u.matricule = :matricule";
        $bindParams[':matricule'] = $matricule;
    }
    if (!empty($idUtilisateur)) {
        $sql .= " AND c.idContact = :idUtilisateur";
        $bindParams[':idUtilisateur'] = $idUtilisateur;
    }

    if (!empty($site)) {
        $sql .= " AND p.adressePointage LIKE :site";
        $bindParams[':site'] = '%' . $site . '%'; // Use wildcards for LIKE
    }
    // Apply 'periode' filter
    switch ($periode) {
        case 'today':
            $sql .= " AND p.datePointage = :today";
            $bindParams[':today'] = date('Y-m-d');
            break;

        case '1': // 'A la date du'
            if ($dateOne) {
                // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                if ($dateOneFormatted) {
                    $sql .= " AND p.datePointage = :dateOne";
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
                    $sql .= " AND p.datePointage BETWEEN :dateDebut AND :dateFin";
                    $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                    $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                } else {
                    // Handle invalid date format
                    echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                    exit;
                }
            }
            break;

        case 'semaine':
        case 'mois':
        case 'trimestre':
        case 'semestre':
        case 'annuel':
            $dateRange = getPeriodDateRange($periode);
            $sql .= " AND p.datePointage BETWEEN :startDate AND :endDate";
            $bindParams[':startDate'] = $dateRange['start'];
            $bindParams[':endDate'] = $dateRange['end'];
            break;

        default:
            // No period filter applied
            break;
    }

    $sql .= " ORDER BY p.datePointage desc";

    // Prepare and execute the query
    $this->db->query($sql);

    // Bind the parameters dynamically
    foreach ($bindParams as $param => $value) {
        $this->db->bind($param, $value);
    }

    // Fetch the filtered data
    $results = $this->db->resultset();

    // Calculate the start and end times for each pointage
    foreach ($results as &$pointage) {
        $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, etc.

        // Convert jourTravail and horaireTravail to arrays
        $jours = explode(';', $pointage->jourTravail);
        $horaires = explode(';', $pointage->horaireTravail);

        // Check if the weekday exists in horaires
        if (isset($horaires[$jourSemaine])) {
            list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
            $pointage->heureDebutJour = $heureDebut;
            $pointage->heureFinJour = $heureFin;
        } else {
            $pointage->heureDebutJour = null;
            $pointage->heureFinJour = null;
        }
    }

    // Output the results as JSON
    // echo json_encode($results);
    return $results;
}

    public function getFilteredPointageWithidUser($idUser, $Motifjustification, $etat, $periode, $dateOne, $dateDebut, $dateFin, $orderBy = 'idPointage')
    {

        function getPeriodDateRange($periode) {
            $today = date('Y-m-d');
            $startDate = '';
            $endDate = $today;
        
            switch ($periode) {
                case 'semaine':
                    // Start date of the week (Monday)
                    $startDate = date('Y-m-d', strtotime('monday this week', strtotime($today)));
                    break;
                case 'mois':
                    // Start date of the month
                    $startDate = date('Y-m-01', strtotime($today));
                    break;
                case 'trimestre':
                    // Start date of the current quarter
                    $currentMonth = date('n', strtotime($today)); // Get the current month
                    $currentQuarter = ceil($currentMonth / 3); // Determine the current quarter (1-4)
                    $startMonth = ($currentQuarter - 1) * 3 + 1; // Calculate the start month of the quarter
                    $startDate = date('Y-' . sprintf('%02d', $startMonth) . '-01', strtotime($today));
                    break;
                case 'semestre':
                    // Start date of the current semester
                    $currentMonth = date('n', strtotime($today));
                    $startMonth = ($currentMonth <= 6) ? 1 : 7; // January or July depending on the semester
                    $startDate = date('Y-' . sprintf('%02d', $startMonth) . '-01', strtotime($today));
                    break;
                case 'annuel':
                    // Start date of the year
                    $startDate = date('Y-01-01', strtotime($today));
                    break;
                default:
                    // If no specific period is matched, set the start date as today
                    $startDate = $today;
                    break;
            }
        
            return [
                'start' => $startDate,
                'end' => $endDate
            ];
        }
        
        $sql = "SELECT p.* , u.jourTravail , u.horaireTravail FROM wbcc_pointage p  
         JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
         WHERE p.idUserF = :idUser";  //ORDER BY datePointage desc
        $bindParams = [];

        // Apply 'etat' filter
        if ($etat === 'Retard') {
            $sql .= " AND p.retard = 1";
        } elseif ($etat === 'Absent') {
            $sql .= " AND p.absent = 1";
        } elseif ($etat === 'Present') {
            $sql .= " AND p.retard = 0 AND p.absent = 0";
        }

        // Apply 'Motifjustification' filter
        if ($Motifjustification === 'justifie') {
            $sql .= " AND p.resultatTraite = 'Accepté'";
        } elseif ($Motifjustification === 'injustifie') {
            $sql .= " AND p.resultatTraite = 'Refusé'";
        }
        if (!empty($matricule)) {
            $sql .= " AND u.matricule = :matricule";
            $bindParams[':matricule'] = $matricule;
        }
        if (!empty($idUtilisateur)) {
            $sql .= " AND c.idContact = :idUtilisateur";
            $bindParams[':idUtilisateur'] = $idUtilisateur;
        }

        if (!empty($site)) {
            $sql .= " AND p.adressePointage LIKE :site";
            $bindParams[':site'] = '%' . $site . '%'; // Use wildcards for LIKE
        }

        // Apply 'periode' filter
        switch ($periode) {
            case 'today':
                $sql .= " AND p.datePointage = :today";
                $bindParams[':today'] = date('Y-m-d');
                break;

            case '1': // 'A la date du'
                if ($dateOne) {
                    // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $sql .= " AND p.datePointage = :dateOne";
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
                        $sql .= " AND p.datePointage BETWEEN :dateDebut AND :dateFin";
                        $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                        $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                    } else {
                        // Handle invalid date format
                        echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                        exit;
                    }
                }
                break;

            case 'semaine':
            case 'mois':
            case 'trimestre':
            case 'semestre':
            case 'annuel':
                $dateRange = getPeriodDateRange($periode);
                $sql .= " AND p.datePointage BETWEEN :startDate AND :endDate";
                $bindParams[':startDate'] = $dateRange['start'];
                $bindParams[':endDate'] = $dateRange['end'];
                break;

            default:
                // No period filter applied
                break;
        }

        $sql .= " ORDER BY p.datePointage desc";

        $this->db->query($sql);

        // Bind the parameters dynamically
        foreach ($bindParams as $param => $value) {
            $this->db->bind($param, $value);
        }
        $this->db->bind(':idUser', $idUser);
    
        $pointages = $this->db->resultSet();
        foreach ($pointages as &$pointage) {
            // Extraire jour de la semaine
            $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, ...

            // Convertir jourTravail et horaireTravail en tableaux
            $jours = explode(';', $pointage->jourTravail);
            $horaires = explode(';', $pointage->horaireTravail);

            // Vérifier que le jour de la semaine existe dans les horaires
            if (isset($horaires[$jourSemaine])) {
                list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                $pointage->heureDebutJour = $heureDebut;
                $pointage->heureFinJour = $heureFin;
            } else {
                $pointage->heureDebutJour = null;
                $pointage->heureFinJour = null;
            }
        }

        return $pointages;
    }

    public function updateStatus($idPointage, $traite, $resultatTraite)
    {
        $this->db->query("UPDATE wbcc_pointage 
                          SET traite = :traite, 
                              resultatTraite = :resultatTraite, 
                              dateTraite = :dateTraite 
                          WHERE idPointage = :idPointage");
    
        $this->db->bind(':traite', $traite);
        $this->db->bind(':resultatTraite', $resultatTraite);
        $this->db->bind(':dateTraite', date('Y-m-d H:i:s'));
        $this->db->bind(':idPointage', $idPointage);
    
        return $this->db->execute();
    }



    public function getAllWithFullName($userId, $orderBy = 'P.idPointage')
    {
        // Check if the user is an admin and what site they belong to
        $sqlAdminCheck = "
        SELECT u.idSiteF, u.isAdmin,u.role, s.nomSite 
        FROM wbcc_utilisateur u 
        LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
        WHERE u.idUtilisateur = :userId";

        $this->db->query($sqlAdminCheck);
        $this->db->bind(':userId', $userId);
        $adminData = $this->db->single();

        // If the user is an admin, filter by the site
        if ($adminData && $adminData->isAdmin == 1 && $adminData->role == 33) {
            $nomSite = $adminData->nomSite;

            // Prepare the main query with the additional conditions
            $sql = "
            SELECT P.*, c.fullName, u.matricule, u.jourTravail, u.horaireTravail 
            FROM wbcc_pointage P 
            JOIN wbcc_utilisateur u ON P.idUserF = u.idUtilisateur 
            LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF 
            WHERE P.adressePointage LIKE :nomSite
            ORDER BY P.datePointage desc";

            $this->db->query($sql);
            $this->db->bind(':nomSite', '%' . $nomSite . '%'); // Using LIKE for partial match
        } else {
            // If the user is not an admin, fetch all without additional conditions
            $sql = "
            SELECT P.*, c.fullName, u.matricule, u.jourTravail, u.horaireTravail 
            FROM wbcc_pointage P 
            JOIN wbcc_utilisateur u ON P.idUserF = u.idUtilisateur 
            LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF 
            ORDER BY P.datePointage DESC";

            $this->db->query($sql);
        }

        // Récupérer les résultats
        $results = $this->db->resultSet();

        // Calculer les heures de début et fin pour chaque pointage
        foreach ($results as &$pointage) {
            $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, etc.

            // Convertir jourTravail et horaireTravail en tableaux
            $jours = explode(';', $pointage->jourTravail);
            $horaires = explode(';', $pointage->horaireTravail);

            // Vérifier que le jour de la semaine existe dans les horaires
            if (isset($horaires[$jourSemaine])) {
                list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                $pointage->heureDebutJour = $heureDebut;
                $pointage->heureFinJour = $heureFin;
            } else {
                $pointage->heureDebutJour = null;
                $pointage->heureFinJour = null;
            }
        }

        return $results;
    }
}