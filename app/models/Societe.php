<?php

class Societe extends Model {
    public function getAllSociete() {
        $sql = "SELECT * FROM gestion_societe_rym;";
        $this->db->query($sql);
        return $this->db->resultset();
    }

    public function getSocieteByUserId($idUtilisateur) {
        $sql = "SELECT s.* FROM gestion_societe_rym s JOIN gestion_utilisateur_societe us ON s.id = us.societe_id AND us.utilisateur_id = $idUtilisateur;";
        $this->db->query($sql);
        return $this->db->resultset();
    }
}