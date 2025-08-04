<?php

class Activity2 extends Model
{
    public function getActivities($statut, $idUtilisateur, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $numero)
    {
        $sql = "SELECT a.*, u.*, rc.*
            FROM wbcc_repertoire_commun_activity rca
            JOIN wbcc_activity a ON rca.idActivityF = a.idActivity
            JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
            JOIN wbcc_repertoire_commun rc ON rca.idRepertoireF = rc.idDocument
            WHERE a.isDeleted = 0";

        $idUtilisateurConnecte = $_SESSION['connectedUser']->idUtilisateur;

        // Filter by user ID
        if (!empty($idUtilisateur)) {
            $sql .= " AND a.idUtilisateurF = $idUtilisateur";
        }

        if (!$_SESSION['connectedUser']->isAdmin) {
            $sql = "SELECT 
                a.*, d.*, c2.fullName AS assignerName, s.nomSite AS siteName
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
            LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE 1=1
        ";
            $sql .= " AND a.idUtilisateurF = $idUtilisateurConnecte";

            if (!empty($numero)) {
                $sql .= " AND a.numeroActivity = $numero";
            }
        }

        // Filter by activity status
        if ($statut == '0') {
            //En attente
            $sql .= " AND a.isCleared = 0";
        } elseif ($statut == '1') {
            //Cloturé
            $sql .= " AND a.isCleared = 1";
        }
        // elseif ($statut == '2') {
        //     //En retard
        //     $sql .= " AND a.isCleared = 0 AND DATE(a.endTime) < CURRENT_DATE";
        // }
        // Filter by user site
        if (!empty($idSite)) {
            $sql .= " AND u.idSiteF = $idSite";
        }

        // Filter by time period
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

            case '1': // 'À la date du'
                if ($dateOne) {
                    $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                    if ($dateOneFormatted) {
                        $formattedDate = $dateOneFormatted->format('Y-m-d');
                        $sql .= " AND DATE(a.createDate) = '$formattedDate'";
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
                        $sql .= " AND DATE(a.createDate) BETWEEN '$formattedDateDebut' AND '$formattedDateFin'";
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

        $sql .= " ORDER BY a.createDate";

        $this->db->query($sql);
        return $this->db->resultSet();
    }


    public function getLastDocument($where = [], $params = [])
    {
        $sql = "
            SELECT 
                a.idActivity,
                a.numeroActivity,
                a.numeroActivity AS nom,
                a.createDate,
                a.startTime,
                a.realisedBy AS assigneName,
                c2.fullName AS assignerName,
                s.nomSite AS siteName,
                a.isCleared AS etatDocument,
                d.nomDocument
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
            LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE a.isDeleted = 0
        ";

        if (isset($params[':idUtilisateurF'])) {
            $where[] = "a.idUtilisateurF = :idUtilisateurF";
        }

        if (!empty($where)) {
            $sql .= " AND " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY a.createDate DESC LIMIT 5";

        $this->db->query($sql);

        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        return $this->db->resultSet();
    }



    public function countTaches($etat, $where = [], $params = [])
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact   c2 ON u2.idContactF     = c2.idContact
            LEFT JOIN wbcc_site      s  ON u2.idSiteF        = s.idSite
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE a.isDeleted = 0 AND a.isCleared = :etat
        ";
        $params[':etat'] = $etat;
        if ($where) {
            $sql .= " AND " . implode(" AND ", $where);
        }
        $this->db->query($sql);
        foreach ($params as $k => $v) {
            $this->db->bind($k, $v);
        }
        return $this->db->single()->total;
    }
    public function countDocumentsEnAttente()
    {
        $sql = "SELECT COUNT(*) AS total FROM wbcc_repertoire_commun WHERE isDeleted = 0";
        $this->db->query($sql);
        return $this->db->single()->total;
    }

    public function getUtilisateursSansDossier()
    {
        $basePath = realpath(__DIR__ . '/../../public/data');
        $sql = "
            SELECT u.idUtilisateur, c.fullName
            FROM wbcc_utilisateur u
            LEFT JOIN wbcc_contact c ON u.idContactF = c.idContact
            WHERE u.etatUser = 1
        ";
        $this->db->query($sql);
        $users = $this->db->resultSet();

        $utilisateursSansDossier = [];

        foreach ($users as $user) {
            $userDir = $basePath . DIRECTORY_SEPARATOR . $user->idUtilisateur;
            if (!is_dir($userDir)) {
                $utilisateursSansDossier[] = $user;
            }
        }

        return $utilisateursSansDossier;
    }

    public function getTopUsersDocuments($where = [], $params = [])
    {
        $sql = "
            SELECT c2.fullName AS name, COUNT(*) AS total
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
            LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
            WHERE a.isDeleted = 0
        ";

        if (!empty($where)) {
            $sql .= " AND " . implode(" AND ", $where);
        }

        $sql .= " GROUP BY c2.fullName ORDER BY total DESC";

        $this->db->query($sql);
        foreach ($params as $k => $v) {
            $this->db->bind($k, $v);
        }

        return $this->db->resultSet();
    }

    public function getDocumentsParSite($where = [], $params = [])
    {
        $sql = "
            SELECT s.nomSite AS site, COUNT(*) AS total
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u ON a.idUtilisateurF = u.idUtilisateur
            LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite
            LEFT JOIN wbcc_contact c2 ON u.idContactF = c2.idContact
            WHERE a.isDeleted = 0
        ";

        if (!empty($where)) {
            $sql .= " AND " . implode(" AND ", $where);
        }

        $sql .= " GROUP BY s.nomSite ORDER BY total DESC";

        $this->db->query($sql);
        foreach ($params as $k => $v) {
            $this->db->bind($k, $v);
        }

        return $this->db->resultSet();
    }


    public function getAllActivitiesForSelect($idUtilisateur = null)
    {
        $sql = "
            SELECT 
                a.idActivity,
                a.numeroActivity,
                d.nomDocument
            FROM wbcc_activity a
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE a.isDeleted = 0
        ";

        $params = [];
        if ($idUtilisateur !== null) {
            $sql .= " AND a.idUtilisateurF = :idUtilisateur";
            $params[':idUtilisateur'] = $idUtilisateur;
        }

        $sql .= " ORDER BY a.createDate DESC";

        $this->db->query($sql);
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        return $this->db->resultSet();
    }
    public function getTachesUtilisateur($idUtilisateur = null, $where = [], $params = [])
    {
        $sql = "SELECT 
                a.*, d.*, c2.fullName AS assignerName, s.nomSite AS siteName
            FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
            LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE a.isDeleted = 0
        ";

        if (!is_null($idUtilisateur)) {
            $sql .= " AND a.idUtilisateurF = :idUtilisateur";
            $params[':idUtilisateur'] = $idUtilisateur;
        }

        if (!empty($where)) {
            $sql .= " AND " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY a.createDate DESC";

        $this->db->query($sql);
        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        return $this->db->resultSet();
    }
    public function countTachesEnRetard($where, $params)
    {
        $query = "SELECT COUNT(*) AS total FROM wbcc_activity a
            LEFT JOIN wbcc_utilisateur u2 ON a.idUtilisateurF = u2.idUtilisateur
            LEFT JOIN wbcc_contact c2 ON u2.idContactF = c2.idContact
            LEFT JOIN wbcc_site s ON u2.idSiteF = s.idSite
            LEFT JOIN wbcc_repertoire_commun_activity rca ON a.idActivity = rca.idActivityF
            LEFT JOIN wbcc_repertoire_commun d ON rca.idRepertoireF = d.idDocument
            WHERE a.isDeleted = 0 AND a.isCleared = 0 AND DATE(a.endTime) < CURRENT_DATE";

        if (!empty($where)) {
            $query .= " AND " . implode(" AND ", $where);
        }

        $this->db->query($query);
        foreach ($params as $k => $v) {
            $this->db->bind($k, $v);
        }
        return $this->db->single()->total;
    }

    public function buildActivityFilters($filters = [])
    {
        $where = [];
        $params = [];
        $titre = "";

        if (!$_SESSION['connectedUser']->isAdmin) {
            $where[] = "a.idUtilisateurF = :me";
            $params[':me'] = $_SESSION['connectedUser']->idUtilisateur;
        }

        if (!empty($filters['idUtilisateur']) && $_SESSION['connectedUser']->isAdmin) {
            $where[] = "a.idUtilisateurF = :idUtilisateur";
            $params[':idUtilisateur'] = intval($filters['idUtilisateur']);
        }

        if (!empty($filters['statut'])) {
            switch ($filters['statut']) {
                case '0':
                    $where[] = "a.isCleared = 0 AND DATE(a.endTime) >= CURRENT_DATE";
                    break;
                case '1':
                    $where[] = "a.isCleared = 1";
                    break;
                case '2':
                    $where[] = "a.isCleared = 0 AND DATE(a.endTime) < CURRENT_DATE";
                    break;
            }
        }

        if (!empty($filters['nom'])) {
            $where[] = "a.location LIKE :nom";
            $params[':nom'] = "%" . $filters['nom'] . "%";
        }

        if (!empty($filters['assigner'])) {
            $where[] = "c2.fullName LIKE :assigner";
            $params[':assigner'] = "%" . $filters['assigner'] . "%";
        }

        if (!empty($filters['site'])) {
            $where[] = "s.nomSite LIKE :site";
            $params[':site'] = "%" . $filters['site'] . "%";
            $titre .= " DU SITE DE '" . $filters['site'] . "'";
        }

        if (!empty($filters['numero'])) {
            $where[] = "a.numeroActivity = :numero";
            $params[':numero'] = $filters['numero'];
        }

        if (!empty($filters['etat']) && in_array($filters['etat'], ['0', '1'])) {
            $where[] = "a.publie = :etat";
            $params[':etat'] = $filters['etat'];
        }

        if (!empty($filters['periode'])) {
            $periode = $filters['periode'];
            $dates = getPeriodDates($periode, $filters);

            if ($periode === "today") {
                $titre .= " Aujourd'hui";
            } elseif ($periode === "1" && isset($dates['startTime'])) {
                $titre .= " du " . date('d/m/Y', strtotime($dates['startTime']));
            } elseif (in_array($periode, ["2", "custom"]) && isset($dates['startTime'], $dates['endTime'])) {
                $titre .= " du " . date('d/m/Y', strtotime($dates['startTime'])) . " au " . date('d/m/Y', strtotime($dates['endTime']));
            }
        }

        return [$where, $params, $titre];
    }
}
