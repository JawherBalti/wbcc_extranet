<?php

class RepertoireCommun extends Model
{
    public function getRepertoire() {
        $this->db->query("SELECT * FROM wbcc_repertoire_commun WHERE isDeleted = 0 ORDER BY createDate");
        return $this->db->resultSet();
    }
}