<?php
class CampagneVocalcom extends Model
{
    protected $table = 'vc_campagne_vocalcom';
    protected $associationTable = 'wbccgroup_company_campagne';

    public function getAllCampagnesVocalcom()
    {
        $this->db->query("SELECT * FROM {$this->table}");
        return $this->db->resultSet();
    }

    // Méthode pour obtenir les campagnes liées à une société
    public function getCampagnesByCompanyId($companyId)
    {
        $this->db->query("SELECT cv.* 
                         FROM {$this->table} cv
                         JOIN {$this->associationTable} cc ON cv.idCampagneVocalcom = cc.idCampagneVocalcomF
                         WHERE cc.idCompanyF = :companyId");
        $this->db->bind(':companyId', $companyId);
        return $this->db->resultSet();
    }

    // Méthode pour sauvegarder les associations de campagnes
    public function saveCampagneAssociations($companyId, $campagneIds)
    {
        try {
            // D'abord supprimer les associations existantes
            $this->db->query("DELETE FROM {$this->associationTable} WHERE idCompanyF = :companyId");
            $this->db->bind(':companyId', $companyId);
            $this->db->execute();

            // Si aucune campagne n'est sélectionnée, on arrête là
            if (empty($campagneIds)) {
                return true;
            }

            // Ensuite ajouter les nouvelles associations
            $campagneIdsArray = explode(';', $campagneIds);
            foreach ($campagneIdsArray as $campagneId) {
                if (!empty($campagneId)) {
                    $this->db->query("INSERT INTO {$this->associationTable} (idCompanyF, idCampagneVocalcomF) 
                                 VALUES (:companyId, :campagneId)");
                    $this->db->bind(':companyId', $companyId);
                    $this->db->bind(':campagneId', $campagneId);
                    $result = $this->db->execute();

                    if (!$result) {
                        // Log de l'erreur si l'insertion échoue
                        // error_log("Erreur lors de l'insertion de l'association campagne: " . print_r($this->db->errorInfo(), true));
                    }
                }
            }

            return true;
        } catch (Exception $e) {
            // Log de l'exception
            error_log("Exception dans saveCampagneAssociations: " . $e->getMessage());
            return false;
        }
    }

    // Méthode pour obtenir les IDs des campagnes associées à une société
    public function getCampagneIdsForCompany($companyId)
    {
        $this->db->query("SELECT idCampagneVocalcomF FROM {$this->associationTable} WHERE idCompanyF = :companyId");
        $this->db->bind(':companyId', $companyId);
        $results = $this->db->resultSet();

        $ids = [];
        foreach ($results as $result) {
            $ids[] = $result->idCampagneVocalcomF;
        }

        return implode(';', $ids);
    }
}
