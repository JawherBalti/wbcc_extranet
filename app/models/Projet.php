<?php

class Projet extends Model
{
    public function getProjets()
    {
        $this->db->query("SELECT * FROM wbcc_projet");
        $res = $this->db->resultSet();
        return $res;
    }

    public function findProjetByColumnValue($column, $value)
    {
        $this->db->query("SELECT * FROM wbcc_projet WHERE $column = :value LIMIT 1");
        $this->db->bind("value", $value);
        $res = $this->db->single();
        return $res;
    }
    
    public function saveProjet($idProjet, $nomProjet, $descriptionProjet, $idImmeuble, $idApp) {
        if (empty($idApp)) {
            $idApp = NULL;
        }
        if (empty($idImmeuble)) {
            $idImmeuble = NULL;
        }

        if ($idProjet != null && $idProjet != "" && $idProjet != "0") {
            $this->db->query("UPDATE wbcc_projet SET nomProjet=:nomProjet, descriptionProjet=:descriptionProjet, idImmeuble=:idImmeuble, idApp=:idApp WHERE idProjet=:idProjet");
            $this->db->bind("idProjet", $idProjet);

        } else {
            $this->db->query("INSERT INTO wbcc_projet(nomProjet, descriptionProjet, idImmeuble, idApp, createDate) VALUES (:nomProjet, :descriptionProjet, :idImmeuble, :idApp, :createDate)");
            $this->db->bind("createDate", date("Y-m-d H:i:s"));
        }
        $this->db->bind("nomProjet", $nomProjet);
        $this->db->bind("descriptionProjet", $descriptionProjet);
        $this->db->bind("idImmeuble", $idImmeuble);
        $this->db->bind("idApp", $idApp);
        if ($this->db->execute()) {
            $artisan = false;
            if ($idProjet != null && $idProjet != "" && $idProjet != "0") {
                $artisan =  $this->findProjetByColumnValue("idProjet", $idProjet);
            }else{
                $artisan =  $this->findProjetByColumnValue("nomProjet", $nomProjet);
            }
            return $artisan;
        } else {
            return false;
        }
    }

    public function saveSubvention($idSubvention, $titreSubvention, $natureTravaux, $natureAide,  $montantSubvention, $taux, $idOrganisme, $idUser)
    {
        $numero = "SUB" . date("dmYHis") . $idUser;
        if ($idSubvention != null && $idSubvention != "" && $idSubvention != "0") {
            $this->db->query("UPDATE wbcc_subvention SET titreSubvention=:titreSubvention, montantSubvention=:montantSubvention, taux=:taux, natureTravaux=:natureTravaux, natureAide=:natureAide, editDate=:editDate, idAuteur=:idAuteur, idOrganisme=:idOrganisme WHERE idSubvention=:idSubvention ");
            $this->db->bind("idSubvention", $idSubvention);
        } else {
            $this->db->query("INSERT INTO wbcc_subvention(numeroSubvention, titreSubvention, montantSubvention, taux, natureTravaux, natureAide,createDate, editDate, idAuteur, idOrganisme) VALUES (:numeroSubvention, :titreSubvention, :montantSubvention, :taux, :natureTravaux, :natureAide, :createDate, :editDate, :idAuteur, :idOrganisme)");
            $this->db->bind("createDate", date("Y-m-d H:i:s"));
            $this->db->bind("numeroSubvention", $numero);
        }
        $this->db->bind("titreSubvention", $titreSubvention);
        $this->db->bind("montantSubvention", $montantSubvention);
        $this->db->bind("taux", $taux);
        $this->db->bind("natureTravaux", $natureTravaux);
        $this->db->bind("natureAide", $natureAide);
        $this->db->bind("editDate",  date("Y-m-d H:i:s"));
        $this->db->bind("idAuteur",  $idUser);
        $this->db->bind("idOrganisme",  $idOrganisme);
        if ($this->db->execute()) {
            $artisan = false;
            if ($idSubvention != null && $idSubvention != "" && $idSubvention != "0") {
                $artisan =  $this->findSubventionByColumnValue("idSubvention", $idSubvention);
            } else {
                $artisan =  $this->findSubventionByColumnValue("numeroSubvention", $numero);
            }
            return $artisan;
        } else {
            return false;
        }
    }

    public function getDocumentsRequisByIdSubvention($id)
    {
        $this->db->query("SELECT * FROM wbcc_document_requis d, wbcc_document_requis_subvention ds WHERE d.idDocumentRequis = ds.idDocumentRequisF  AND ds.idSubventionF = $id");
        $res = $this->db->resultSet();
        return $res;
    }

    public function getDocumentsRequisNotInSubvention($id)
    {
        $this->db->query("SELECT * FROM wbcc_document_requis WHERE idDocumentRequis NOT IN ( SELECT d.idDocumentRequis FROM wbcc_document_requis d, wbcc_document_requis_subvention ds WHERE d.idDocumentRequis = ds.idDocumentRequisF  AND ds.idSubventionF = $id)");
        $res = $this->db->resultSet();
        return $res;
    }

    public function getDocumentsRequis()
    {
        $this->db->query("SELECT * FROM wbcc_document_requis ");
        $res = $this->db->resultSet();
        return $res;
    }
}