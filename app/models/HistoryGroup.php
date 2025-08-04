<?php

class HistoryGroup extends Model
{
    public function save($data)
    {
        $nomComplet = $_SESSION['connectedUser']->fullName;
        $idUtilisateurF = $_SESSION['connectedUser']->idUtilisateur;

        $this->db->query("INSERT INTO wbccgroup_history(action, nomComplet, idUtilisateurF, idCompanyF) 
                    VALUES(:action, :nomComplet, :idUtilisateurF, :idCompanyF)");

        $this->db->bind(':action', $data['action']);
        $this->db->bind(':nomComplet', $nomComplet);
        $this->db->bind(':idUtilisateurF', $idUtilisateurF);
        $this->db->bind(':idCompanyF', $data['idCompanyF']);

        if ($this->db->execute()) {
            return "1";
        }
        return "0";
    }
    public function getAllHistorique()
    {
        $this->db->query("SELECT * FROM wbccgroup_history ORDER BY dateAction DESC");
        return $this->db->resultSet();
    }

    public function getHistoriqueByUser($idUser)
    {
        $this->db->query("SELECT * FROM wbccgroup_history WHERE idUtilisateurF = :idUser ORDER BY dateAction DESC");
        $this->db->bind(':idUser', $idUser);
        return $this->db->resultSet();
    }

    public function getHistoriqueByCompany($idCompany)
    {
        $this->db->query("SELECT * FROM wbccgroup_history WHERE idCompanyF = :idCompany ORDER BY dateAction DESC");
        $this->db->bind(':idCompany', $idCompany);
        return $this->db->resultSet();
    }

    public function getHistoriqueByContact($idContact)
    {
        $this->db->query("SELECT * FROM wbccgroup_history WHERE idContactF = :idContact ORDER BY dateAction DESC");
        $this->db->bind(':idContact', $idContact);
        return $this->db->resultSet();
    }
}
