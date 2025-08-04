<?php
class StatusCompany extends Model
{
    protected $tableName = 'wbcc_status_company';

    public function getAllStatus()
    {
        $this->db->query("SELECT * FROM {$this->tableName}");
        return $this->db->resultSet();
    }
}
