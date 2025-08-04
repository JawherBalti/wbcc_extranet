<?php

class ActivityGroup extends Model
{
    public function getAllActivities()
    {
        $this->db->query("SELECT * FROM wbccgroup_activity");
        return $this->db->resultSet();
    }

    public function getAllCompanies()
    {
        $this->db->query("SELECT DISTINCT c.* FROM wbccgroup_company c 
                        JOIN wbccgroup_company_activity ca ON c.idCompany = ca.idCompanyF 
                        ORDER BY c.nomCompany ASC");
        return $this->db->resultSet();
    }

    public function getAllContacts()
    {
        $this->db->query("SELECT DISTINCT c.* FROM wbccgroup_contact c 
                        JOIN wbccgroup_contact_activity ca ON c.idContact = ca.idContactF 
                        ORDER BY c.nomContact ASC");
        return $this->db->resultSet();
    }

    public function findByCode($code)
    {
        $this->db->query("SELECT * FROM wbccgroup_activity_db WHERE codeActivity = $code LIMIT 1");
        return $this->db->single();
    }

    public function getActivities($type = '')
    {
        try {
            switch ($type) {
                case 'AFaire':
                    $this->db->query("
                        SELECT * FROM wbccgroup_activity 
                        WHERE isCleared = 'False' 
                        AND realisedBy IS NULL 
                        AND isDeleted = 0 
                        AND publie = 1
                        ORDER BY startTime DESC
                    ");
                    break;

                case 'EnCours':
                    $this->db->query("
                        SELECT * FROM wbccgroup_activity 
                        WHERE isCleared = 'False' 
                        AND realisedBy IS NOT NULL 
                        AND isDeleted = 0 
                        AND publie = 1
                        ORDER BY startTime DESC
                    ");
                    break;

                case 'Realisees':
                    $this->db->query("
                        SELECT * FROM wbccgroup_activity 
                        WHERE isCleared = 'True' 
                        AND realisedBy IS NOT NULL 
                        AND isDeleted = 0 
                        AND publie = 1
                        ORDER BY endTime DESC
                    ");
                    break;

                default:
                    $this->db->query("
                        SELECT * FROM wbccgroup_activity 
                        WHERE isDeleted = 0 
                        AND publie = 1
                        ORDER BY startTime DESC
                    ");
            }

            // Fetch and return results
            $results = $this->db->resultSet();

            // Debugging
            // error_log("Results for $type: " . json_encode($results));

            return $results;
        } catch (Exception $e) {
            // Log any database errors
            // error_log("Error in getActivities: " . $e->getMessage());
            return [];
        }
    }

    public function getAllActivityTypes()
    {
        $this->db->query("SELECT codeActivity, libelleActivity FROM wbccgroup_activity_db WHERE etatActivity = 1 ORDER BY priorite ASC");
        return $this->db->resultSet();
    }

    public function findActivityByCompany($codeTache, $idCompany)
    {
        $this->db->query("SELECT * FROM  wbccgroup_company_activity ca, wbcc_activity a WHERE a.idActivity=ca.idActivityF AND codeActivity = $codeTache AND idOpportunityF = $idCompany  Limit 1 ");
        $data =  $this->db->single();
        return $data;
    }

    public function findActivityByContact($codeTache, $idContact)
    {
        $this->db->query("SELECT * FROM  wbccgroup_contact_activity ca, wbcc_activity a WHERE a.idActivity=ca.idActivityF AND codeActivity = $codeTache AND idCompanyF = $idContact  Limit 1 ");
        $data =  $this->db->single();
        return $data;
    }

    public function getActivitiesByCompany($idCompany)
    {
        $this->db->query("SELECT a.* 
                      FROM wbccgroup_company_activity ca 
                      JOIN wbccgroup_activity a ON a.idActivity = ca.idActivityF 
                      WHERE ca.idCompanyF = :idCompany 
                      ORDER BY a.idActivity DESC");

        $this->db->bind(':idCompany', $idCompany);

        return $this->db->resultSet();
    }

    public function getActivitiesByContact($idContact)
    {
        $this->db->query("SELECT a.* 
                      FROM wbccgroup_contact_activity ca 
                      JOIN wbccgroup_activity a ON a.idActivity = ca.idActivityF  
                      WHERE ca.idContactF = :idContact 
                      ORDER BY a.idActivity DESC");

        $this->db->bind(':idContact', $idContact);

        return $this->db->resultSet();
    }

    public function findActivityById($idActivity)
    {
        $this->db->query("SELECT * FROM wbccgroup_activity a WHERE idActivity = $idActivity  Limit 1 ");
        $data =  $this->db->single();
        return $data;
    }

    public function getActivitiesDB($onOP = "", $columnOrder = "priorite", $typeOrder = "DESC")
    {
        $req = "";
        if ($onOP != "") {
            $req .= " WHERE usedByOP= $onOP ";
        }

        $this->db->query("SELECT * FROM wbccgroup_activity_db  $req   ORDER BY $columnOrder $typeOrder");
        return $this->db->resultSet();
    }

    public function getFilteredActivities($filters = [])
    {
        $user = $filters['user'] ?? '';
        $realisedBy = $filters['realisedBy'] ?? '';
        $periode = $filters['periode'] ?? '';
        $date1 = $filters['date1'] ?? '';
        $date2 = $filters['date2'] ?? '';
        $type = $filters['type'] ?? '';
        $rechercheRapide = $filters['rechercheRapide'] ?? '';
        $site = $filters['site'] ?? '';
        $entityType = $filters['entityType'] ?? 'company';  // 'company', 'contact', ou 'all'

        // Construction de la requête de base avec filtrage par type d'entité
        if ($entityType == 'company') {
            // Seulement les activités liées aux sociétés (mais pas aux contacts)
            $query = "SELECT DISTINCT a.* FROM wbccgroup_activity a , wbccgroup_company_activity ca  WHERE a.idActivity= ca.idActivityF ";
        } else if ($entityType == 'contact') {
            // Seulement les activités liées aux contacts (mais pas aux sociétés)
            $query = "SELECT DISTINCT a.* FROM wbccgroup_activity a , wbccgroup_contact_activity ca  WHERE a.idActivity= ca.idActivityF ";
        } else {
            // Toutes les activités sans distinction
            $query = "SELECT DISTINCT a.* FROM wbccgroup_activity a WHERE 1";
        }

        // Filtre par site si spécifié et différent de "tous"
        if (!empty($site) && $site != 'tous') {
            // On suppose que les utilisateurs ont un champ idSite
            // Adaptez cette partie selon votre structure de base de données
            $query .= " AND a.idRealisedBy IN (SELECT idUtilisateur FROM wbcc_utilisateur WHERE idSiteF = " . intval($site) . ")";
        }

        // Filtre par gestionnaire
        if (!empty($realisedBy) && $realisedBy != 'tous') {
            $query .= " AND a.idRealisedBy = " . intval($realisedBy);
        }

        $columnDate = "a.startTime";
        // Filtre par type
        if (!empty($type)) {
            switch ($type) {
                case 'aFaire':
                    $query .= " AND a.isCleared = 'False' AND a.realisedBy IS NULL";
                    break;
                case 'termine':
                    $columnDate = "a.editDate";
                    $query .= " AND a.isCleared = 'True'";
                    break;
                case 'retard':
                    $query .= " AND a.isCleared = 'False' AND a.startTime < NOW()";
                    break;
            }
        }

        // Filtre par période
        if (!empty($periode) && $periode != 'all') {
            $today = date('Y-m-d');
            switch ($periode) {
                case 'today':
                    $query .= " AND DATE($columnDate) = '$today'";
                    break;
                case 'semaine':
                    $weekStart = date('Y-m-d', strtotime('monday this week'));
                    $weekEnd = date('Y-m-d', strtotime('sunday this week'));
                    $query .= " AND DATE($columnDate) BETWEEN '$weekStart' AND '$weekEnd'";
                    break;
                case 'mois':
                    $monthStart = date('Y-m-01');
                    $monthEnd = date('Y-m-t');
                    $query .= " AND DATE($columnDate) BETWEEN '$monthStart' AND '$monthEnd'";
                    break;
                case 'trimestre':
                    $quarter = ceil(date('n') / 3);
                    $startMonth = (($quarter - 1) * 3) + 1;
                    $endMonth = $quarter * 3;
                    $year = date('Y');
                    $quarterStart = date('Y-m-d', strtotime("$year-$startMonth-01"));
                    $quarterEnd = date('Y-m-t', strtotime("$year-$endMonth-01"));
                    $query .= " AND DATE($columnDate) BETWEEN '$quarterStart' AND '$quarterEnd'";
                    break;
                case 'semestre':
                    $semester = ceil(date('n') / 6);
                    $startMonth = (($semester - 1) * 6) + 1;
                    $endMonth = $semester * 6;
                    $year = date('Y');
                    $semesterStart = date('Y-m-d', strtotime("$year-$startMonth-01"));
                    $semesterEnd = date('Y-m-t', strtotime("$year-$endMonth-01"));
                    $query .= " AND DATE($columnDate) BETWEEN '$semesterStart' AND '$semesterEnd'";
                    break;
                case 'annuel':
                    $yearStart = date('Y-01-01');
                    $yearEnd = date('Y-12-31');
                    $query .= " AND DATE($columnDate) BETWEEN '$yearStart' AND '$yearEnd'";
                    break;
                case 'day':
                    if (!empty($date1)) {
                        $query .= " AND DATE($columnDate) = '$date1'";
                    }
                    break;
                case 'perso':
                    if (!empty($date1) && !empty($date2)) {
                        $query .= " AND DATE($columnDate) BETWEEN '$date1' AND '$date2'";
                    } else if (!empty($date1)) {
                        $query .= " AND DATE($columnDate) >= '$date1'";
                    } else if (!empty($date2)) {
                        $query .= " AND DATE($columnDate) <= '$date2'";
                    }
                    break;
            }
        }

        // Filtre par code d'activité
        if (!empty($rechercheRapide) && $rechercheRapide !== 'Tous') {
            $query .= " AND a.codeActivity = " . intval($rechercheRapide);
        }

        // Ordre
        $query .= " ORDER BY $columnDate DESC";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getCompanyIdForActivity($idActivity)
    {
        $this->db->query("SELECT idCompanyF FROM wbccgroup_company_activity WHERE idActivityF = :idActivity LIMIT 1");
        $this->db->bind(':idActivity', $idActivity);
        $result = $this->db->single();
        return $result ? $result->idCompanyF : null;
    }
}
