<?php

class Pointage extends Model
{

    function timeStringToMinutes($timeStr) {

        $parts = explode(':', $timeStr);
        
        if (count($parts) < 2 || count($parts) > 3) {
            return;
        }
        
        $hours = trim($parts[0]);
        $minutes = trim($parts[1]);
        
        if (!ctype_digit($hours) || !ctype_digit($minutes)) {
            return;
        }
        
        $hours = intval($hours);
        $minutes = intval($minutes);
        
        if ($hours < 0 || $hours > 23 || $minutes < 0 || $minutes > 59) {
            return;
        }
        
        return ($hours * 60) + $minutes;
    }

    function calculerDifferenceHeures($heure1, $heure2) {
        // Vérification des valeurs d'entrée
        if (empty($heure1) || empty($heure2)) {
            return "0 minutes"; // Si une des heures est vide
        }
    
        // Vérifiez le format des heures (ajout d'un format optionnel pour inclure les secondes)
        if (!preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $heure1) || !preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $heure2)) {
            return "Format invalide"; // Format incorrect
        }
    
        // Découpez les heures, minutes et secondes
        $parts1 = explode(':', $heure1);
        $parts2 = explode(':', $heure2);
    
        // Ajoutez les secondes par défaut si elles ne sont pas spécifiées
        $heures1 = (int)$parts1[0];
        $minutes1 = (int)$parts1[1];
        $secondes1 = isset($parts1[2]) ? (int)$parts1[2] : 0;
    
        $heures2 = (int)$parts2[0];
        $minutes2 = (int)$parts2[1];
        $secondes2 = isset($parts2[2]) ? (int)$parts2[2] : 0;
    
        // Conversion en secondes totales
        $totalSecondes1 = $heures1 * 3600 + $minutes1 * 60 + $secondes1;
        $totalSecondes2 = $heures2 * 3600 + $minutes2 * 60 + $secondes2;
    
        // Calcul de la différence en secondes
        $differenceEnSecondes = $totalSecondes1 - $totalSecondes2;
    
        // Si aucune différence
        if ($differenceEnSecondes === 0) {
            return "-";
        }
    
        // Calcul des heures et minutes
        $signe = $differenceEnSecondes < 0 ? "+" : "-";
        $differenceAbsolue = abs($differenceEnSecondes);
    
        // Convertir en heures, minutes et secondes
        $heures = floor($differenceAbsolue / 3600);
        $minutes = floor(($differenceAbsolue % 3600) / 60);
    
        // Retourne le résultat formaté
        return "{$signe}{$heures} heures {$minutes} minutes";
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

    public function getFilteredPointage($Motifjustification, $etat, $site, $periode, $dateOne, $dateDebut, $dateFin, $matricule, $idUtilisateur)
    {

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
            $sql .= " AND u.idSiteF = :site";
            $bindParams[':site'] =  $site; // Use wildcards for LIKE
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

        function getPeriodDateRange($periode)
        {
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
        if (!empty($idUser)) {
            $sql .= " AND p.idUserF = :idUtilisateur";
            $bindParams[':idUtilisateur'] = $idUser;
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
        if ($adminData && ($adminData->role == 25)) {
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


    //************************************************* */
    public function generatePDFInfo() {
        require_once '../../public/libs/vendor2/autoload.php'; // Ensure Mpdf is included
        require_once "../../app/libraries/Role.php";

        setlocale(LC_TIME, 'fr_FR.utf8', 'fr_FR', 'french'); // Set locale to French

        // Fetch all users
        $utilisateursQuery = "SELECT idUtilisateur, email, idContactF, role, idSiteF FROM wbcc_utilisateur";
        $this->db->query($utilisateursQuery);
        $utilisateursResults = $this->db->resultSet();
        
        // Set the year and previous month
        $currentYear = date("Y");
        $previousMonth = date('n', strtotime('last month'));

        //Obtenir le nom du mois
        $dateObj = DateTime::createFromFormat('!m', $previousMonth);
        $monthName = utf8_encode(strftime('%B', $dateObj->getTimestamp()));

        // Iterate through each user
        foreach ($utilisateursResults as $utilisateur) {
            $mpdf = new \Mpdf\Mpdf([
                'in_charset' => 'UTF-8', // Ensure input is treated as UTF-8
                'default_font' => 'dejavusans', // Use a font that supports UTF-8 characters
            ]);
            $email = $utilisateur->email;
            $role = $utilisateur->role;
            $idUtilisateur = $utilisateur->idUtilisateur;
            $idContactF = $utilisateur->idContactF;
        
            //ADMIN
            if ($role == '1' || $role == '2') {
                // Obtenir tous les sites
                $sitesQuery = "SELECT nomSite FROM wbcc_site";
                $this->db->query($sitesQuery);
                $sitesResults = $this->db->resultSet();
                foreach ($sitesResults as $index => $site) {
                    $nomSite1 = $site->nomSite;
                    // Obtenir tous les pointages du mois précedent du site
                    $pointageMoisQuery = "SELECT  p.*, c.fullName, 
                    SUM(p.nbMinuteRetard) AS totalMinutesRetard, 
                    COUNT(CASE WHEN p.heureDebutPointage IS NULL THEN 1 END) AS totalJoursAbsence
                    FROM wbcc_pointage p
                    INNER JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
                    INNER JOIN wbcc_contact c ON u.idContactF = c.idContact
                    WHERE p.adressePointage LIKE :nomSite 
                        AND MONTH(p.datePointage) = :previousMonth 
                        AND YEAR(p.datePointage) = :currentYear
                    GROUP BY p.idUserF";

                    $this->db->query($pointageMoisQuery);

                    $this->db->bind(':nomSite', '%' . $nomSite1 . '%'); // Using LIKE for partial match
                    $this->db->bind(':previousMonth', $previousMonth);
                    $this->db->bind(':currentYear', $currentYear);

                    $pointageMoisResults = $this->db->resultSet();
                
                    // Ajouter les données des pointages au pdf
                    if (!empty($pointageMoisResults)) {
                        $mpdf->WriteHTML("<h2>Pointages du site de $nomSite1</h2>");
                        $mpdf->WriteHTML("<table border='1' cellpadding='5' cellspacing='0'>");
                        $mpdf->WriteHTML("<tr><th>#</th><th>Nom</th><th>Total des minutes de retard</th><th>Total des jours d'absence</th></tr>");                            $totalMinutesRetard = 0; // Total minutes de retard
                        $totalJoursAbsence = 0; // Total jours d'absence

                        foreach ($pointageMoisResults as $index => $pointage) {
                            // Calcul minutes retard
                            $totalMinutesRetard += $pointage->nbMinuteRetard;
                
                            // Count calcul jours absence
                            if ($pointage->heureDebutPointage === null) {
                                $totalJoursAbsence++;
                            }
                            $mpdf->WriteHTML("<tr>");
                            $mpdf->WriteHTML("<td>" . ($index + 1) . "</td>");
                            $mpdf->WriteHTML("<td>{$pointage->fullName}</td>");
                            $mpdf->WriteHTML("<td>{$pointage->totalMinutesRetard}</td>");
                            $mpdf->WriteHTML("<td>{$pointage->totalJoursAbsence}</td>");
                            $mpdf->WriteHTML("</tr>");
                        }
                        $mpdf->WriteHTML("</table>");
                        } else {
                            $mpdf->WriteHTML("<h2>Pointages du site de $nomSite1</h2>");
                            $mpdf->WriteHTML("<p>Pas de pointages trouvés</p>");
                        }
                    $mpdf->AddPage();
                }
                $pdfFilePath = './' . date('dmYhis') . 'user_pointage_report.pdf';

                $filesList = array();
                $fileNamesList = array();
                $filesList[] = $pdfFilePath;
                $fileNamesList[] = date('dmYhis') . 'user_pointage_report.pdf';
                // Output the PDF
                //$mpdf->Output($pdfFilePath, 'F'); // 'D' forces download

                //Envoyer un email
                $emailSent = Role::mailExtranetWithFiles($email, "Pointages du mois", "body", EMAIL_CODIR, $filesList, $fileNamesList);
                if ($emailSent) {
                    echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
                } else {
                    echo json_encode(0);
                }
            } 
            //MANAGER DU SITE
            elseif($role==34) {
                $idSite = $utilisateur->idSiteF;
                $siteQuery = "SELECT nomSite FROM wbcc_site WHERE idSite=$idSite";
                $this->db->query($siteQuery);
                $siteResult = $this->db->single();

                $nomSite = $siteResult->nomSite;

                    // Obtenir tous les pointages du mois précedent du site
                    $pointageMoisQuery = "SELECT  p.*, c.fullName, 
                    SUM(p.nbMinuteRetard) AS totalMinutesRetard, 
                    COUNT(CASE WHEN p.heureDebutPointage IS NULL THEN 1 END) AS totalJoursAbsence
                    FROM wbcc_pointage p
                    INNER JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
                    INNER JOIN wbcc_contact c ON u.idContactF = c.idContact
                    WHERE p.adressePointage LIKE :nomSite 
                        AND MONTH(p.datePointage) = :previousMonth 
                        AND YEAR(p.datePointage) = :currentYear
                    GROUP BY p.idUserF";

                $this->db->query($pointageMoisQuery);

                $this->db->bind(':nomSite', '%' . $nomSite . '%');
                $this->db->bind(':previousMonth', $previousMonth);
                $this->db->bind(':currentYear', $currentYear);

                $pointageMoisResults = $this->db->resultSet();
                // Ajouter pointage au PDF
                if (!empty($pointageMoisResults)) {
                    $mpdf->WriteHTML("<h2>Pointages du site de $nomSite</h2>");
                    $mpdf->WriteHTML("<table border='1' cellpadding='5' cellspacing='0'>");
                    $mpdf->WriteHTML("<tr><th>#</th><th>Nom</th><th>Total des minutes de retard</th><th>Total des jours d'absence</th></tr>");                            $totalMinutesRetard = 0; // Total minutes de retard
                    
                    $totalJoursAbsence = 0; // Total jours d'absence

                    foreach ($pointageMoisResults as $index => $pointage) {
                        // Calcul minutes de retard
                        $totalMinutesRetard += $pointage->nbMinuteRetard;
                
                        // Calcul jours d'absence
                        if ($pointage->heureDebutPointage === null) {
                            $totalJoursAbsence++;
                        }
                        $mpdf->WriteHTML("<tr>");
                        $mpdf->WriteHTML("<td>" . ($index + 1) . "</td>");
                        $mpdf->WriteHTML("<td>{$pointage->fullName}</td>");
                        $mpdf->WriteHTML("<td>{$pointage->totalMinutesRetard}</td>");
                        $mpdf->WriteHTML("<td>{$pointage->totalJoursAbsence}</td>");                            
                        $mpdf->WriteHTML("</tr>");
                    }
                    $mpdf->WriteHTML("</table>");
                    } else {
                        $mpdf->WriteHTML("<h2>Pointages du site de $nomSite</h2>");
                        $mpdf->WriteHTML("<p>Pas de pointages trouvés</p>");
                    }
                    $pdfFilePath = './' . date('dmYhis') . 'user_pointage_report.pdf';

                    $filesList = array();
                    $fileNamesList = array();
                    $filesList[] = $pdfFilePath;
                    $fileNamesList[] = date('dmYhis') . 'user_pointage_report.pdf';
                    // Output the PDF
                    //$mpdf->Output($pdfFilePath, 'F'); // 'D' forces download

                    $emailSent = Role::mailExtranetWithFiles($email, "Pointages du mois", "body", EMAIL_CODIR, $filesList, $fileNamesList);
                    if ($emailSent) {
                        echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
                    } else {
                        echo json_encode(0);
                    }
                }
                //EMPLOYE 
            else {
                // Obtenir le nom de l'employé
                $fullNameQuery = "SELECT fullName From wbcc_contact WHERE idContact=$idContactF";
                $this->db->query($fullNameQuery);
                $fullNameResult = $this->db->single();
                // Obtenir tous les pointages du mois précedent du site
                $pointageMoisQuery = "SELECT * FROM wbcc_pointage WHERE idUserF=$idUtilisateur AND MONTH(datePointage)=$previousMonth AND YEAR(datePointage)=$currentYear";
                $this->db->query($pointageMoisQuery);
                $pointageMoisResults = $this->db->resultSet();

                $totalMinutesRetard = 0; // Total minutes de retard
                $totalJoursAbsence = 0; // Total jours d'absence

                // Ajouter pointage au PDF
                if (!empty($pointageMoisResults)) {
                    $mpdf->WriteHTML("<h2>Pointages du mois de $monthName pour $fullNameResult->fullName</h2>");
                    foreach ($pointageMoisResults as $index => $pointage) {
                        // Calcul minutes de retard
                        $totalMinutesRetard += $pointage->nbMinuteRetard;

                        // Calcul jours absence
                        if ($pointage->heureDebutPointage === null) {
                            $totalJoursAbsence++;
                        }   
                    }
                    $mpdf->WriteHTML("<h3>Résumé</h3>");
                    $mpdf->WriteHTML("<p>Total des minutes de retard cumulés : $totalMinutesRetard minutes</p>");
                    $mpdf->WriteHTML("<p>Total des jours d'absence : $totalJoursAbsence jours</p>");
                    $mpdf->WriteHTML("<table border='1' cellpadding='5' cellspacing='0'>");
                    $mpdf->WriteHTML("<tr><th>#</th><th>Date</th><th>Heure Début</th><th>Heure d'arrivée</th><th>Statut d'arrivée</th><th>Nb Min. Retard</th><th>Justif. d'arrivée</th><th>Heure Fin</th><th>Heure de Départ</th><th>Statut de Départ</th><th>Nb Min. Départ</th><th>Justif. Départ</th><th>Mention Départ</th><th>Justif. d'absence</th><th>Mention d'absence</th></tr>");
                    foreach ($pointageMoisResults as $index => $pointage) {                     
                        $displayIndex = intval($index) + 1;

                        $mpdf->WriteHTML("<tr>");
                        $mpdf->WriteHTML("<td>{$displayIndex}</td>");
                        $mpdf->WriteHTML("<td>{$pointage->datePointage}</td>");
                        $pointage->heureDebutJour !== null ? $mpdf->WriteHTML("<td>{$pointage->heureDebutJour}</td>") : $mpdf->WriteHTML("<td>-</td>");
                        $pointage->heureDebutPointage !== null ? $mpdf->WriteHTML("<td>{$pointage->heureDebutPointage }</td>") : $mpdf->WriteHTML("<td>-</td>");
                        
                        if ($pointage->heureDebutPointage === null) {
                            $mpdf->WriteHTML("<td><span class='badge badge-danger'>Absent</span></td>");
                        } else if (
                            timeStringToMinutes($pointage->heureDebutJour)
                            >= timeStringToMinutes($pointage->heureDebutPointage)
                        ) {
                            $mpdf->WriteHTML("<td><span class='badge badge-success'>À l'heure</span></td>");
                        } else {
                            if ($pointage->retard == "1") {
                                $mpdf->WriteHTML("<td><span class='badge badge-warning'>Retard</span></td>");
                            } else {
                                $etat = "-";
                            }
                        }

                        if(timeStringToMinutes($pointage->heureDebutPointage) - timeStringToMinutes($pointage->heureDebutJour) > 0) {
                            $nbMinRetard = calculerDifferenceHeures($pointage->heureDebutJour, $pointage->heureDebutPointage);

                            // $nbMinRetard = timeStringToMinutes($pointage->heureDebutPointage) - timeStringToMinutes($pointage->heureDebutJour);
                            $mpdf->WriteHTML("<td>$nbMinRetard</td>");
                        }else {
                            $mpdf->WriteHTML("<td>-</td>");
                        }

                        if (timeStringToMinutes($pointage->heureDebutJour) >= timeStringToMinutes($pointage->heureDebutPointage)) {
                            $mpdf->WriteHTML("<td>-</td>");
                        } elseif ($pointage->motifRetard) {
                            $mpdf->WriteHTML("<th>Justifié</td>");
                        } else {
                            if ($pointage->retard == "1") {
                                $mpdf->WriteHTML("<td>Injustifié</td>");
                            } else {
                                $mpdf->WriteHTML("<td>-</td>");
                            }
                        }
                        
                        $pointage->heureFinJour !== null ? $mpdf->WriteHTML("<td>{$pointage->heureFinJour}</td>") : $mpdf->WriteHTML("<td>-</td>");
                        $pointage->heureFinPointage !== null ? $mpdf->WriteHTML("<td>{$pointage->heureFinPointage}</td>") : $mpdf->WriteHTML("<td>-</td>");


                        if ($pointage->absent == 1) {
                            $mpdf->WriteHTML("<td><span class='badge badge-danger'>Absent</span></td>");
                        } else {
                            $difference = calculerDifferenceHeures($pointage->heureFinJour, $pointage->heureFinPointage);
                            if ($difference === "-") {
                                $mpdf->WriteHTML("<td><span class='badge badge-success'>À l'heure</span></td>");
                            } elseif (strpos($difference, '-') === 0) {
                                $mpdf->WriteHTML("<td><span class='badge badge-warning'>Avant l'heure</span></td>");
                            } elseif (strpos($difference, '+') === 0) {
                                $mpdf->WriteHTML("<td><span class='badge badge-primary'>Après l'heure</span></td>");
                            } else {
                                $mpdf->WriteHTML("<td>-</td>");
                            }
                        }

                        if($pointage->heureFinPointage == null) {
                            $mpdf->WriteHTML("<td>-</td>");
                        } else {
                            $nbMinDepartRetard = calculerDifferenceHeures($pointage->heureFinJour, $pointage->heureFinPointage);
                            $mpdf->WriteHTML("<td>$nbMinDepartRetard</td>");
                        }

                        if (timeStringToMinutes($pointage->heureFinJour) <= timeStringToMinutes($pointage->heureFinPointage) || $pointage->heureFinPointage == null) {
                            $mpdf->WriteHTML("<td>-</td>");                            
                        } elseif ($pointage->motifRetardDepart) {
                            $mpdf->WriteHTML("<td>Justifié</td>");                            
                        } else {
                            if ($difference == "-") {
                                $mpdf->WriteHTML("<td>Injustifié</td>");                            
                            } else {
                                $mpdf->WriteHTML("<td>-</td>");                            
                            }
                        }

                        if ($pointage->absent === 1 || calculerDifferenceHeures($pointage->heureFinJour, $pointage->heureFinPointage) === "-" || $pointage->heureFinPointage == null) {
                            $mpdf->WriteHTML("<td>-</td>");                            
                        } elseif ($pointage->resultatTraiteDepart == 'Accepté') {
                            $mpdf->WriteHTML("<td><span class='badge badge-success'>Accepté</span></td>");                            
                        } elseif ($pointage->resultatTraiteDepart == 'Refusé') {
                            $mpdf->WriteHTML("<td><span class='badge badge-danger'>Refusé</span></td>");                            
                        } else {
                            if ($difference == "-") {
                                $mpdf->WriteHTML("<td><span class='badge badge-error'>Non Traité</span></td>");                            
                            } else {
                                $mpdf->WriteHTML("<td>-</td>");                            
                            }
                        }

                        if ($pointage->absent == 0) {
                            $mpdf->WriteHTML("<td>-</td>");                            
                        } elseif ($pointage->motifAbsent != null) {
                            $mpdf->WriteHTML("<td>Justifié</td>");                            
                        } else {
                            $mpdf->WriteHTML("<td>Injustifié</td>");                            
                        }

                        if ($pointage->resultatTraiteAbsent === null) {
                            if ($pointage->absent == 0) {
                                $mpdf->WriteHTML("<td>-</td>");                            
                            } else {
                                $mpdf->WriteHTML("<td><span class='badge badge-error'>Non Traité</span></td>");                            
                            }
                        } elseif ($pointage->resultatTraiteAbsent === 'Accepté') {
                            $mpdf->WriteHTML("<td><span class='badge badge-success'>Accepté</span></td>");                            

                        } else {
                            $mpdf->WriteHTML("<td><span class='badge badge-danger'>Refusé</span></td>");                            
                        }
                        $mpdf->WriteHTML("</tr>");
                    }
                    $mpdf->WriteHTML("</table>");
                } else {
                    $mpdf->WriteHTML("<h2>Pointages du mois de $monthName pour $fullNameResult->fullName</h2>");
                    $mpdf->WriteHTML("<p>Pas de pointages trouvés</p>");
                }
                // Add a page break after each user's data
                // $mpdf->AddPage();
                $pdfFilePath = './' . date('dmYhis') . $idUtilisateur . 'user_pointage_report.pdf';

                $filesList = array();
                $fileNamesList = array();
                $filesList[] = $pdfFilePath;
                $fileNamesList[] = date('dmYhis') . $idUtilisateur . 'user_pointage_report.pdf';
                // Output PDF
                //$mpdf->Output($pdfFilePath, 'F'); // 'D' forces download

                $emailSent = Role::mailExtranetWithFiles($email, "Pointages du mois", "body", EMAIL_CODIR, $filesList, $fileNamesList);
                if ($emailSent) {
                    echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
                } else {
                    echo json_encode(0);
                }
            }
        }
    }
}