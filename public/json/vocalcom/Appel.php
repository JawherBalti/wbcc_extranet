<?php

class Appel extends Model
{


    public function save($appel)
    {
        $appelFind = findItemByColumn("wbcc_appel", "indiceAppel", $appel['Indice']);
        $email = $appel['emailAgent'];
        $this->db->query("SELECT * FROM wbcc_contact, wbcc_utilisateur WHERE idContactF=idContact AND login='$email'");
        $auteur = $this->db->single();
        $campagne = findItemByColumn("vc_campagne_vocalcom", "DID", $appel['FirstCampaign']);
        if ($appelFind) {
            $this->db->query("UPDATE wbcc_appel SET numTelEmetteur=:numTelEmetteur,numTelRecepteur= :numTelRecepteur,dateDebutAppel= :dateDebutAppel,dateFinAppel= :dateFinAppel, auteurAppel=:auteurAppel,idAuteurAppel= :idAuteurAppel, idCampagneF=:idCampagneF,idCompanyF= :idCompanyF, idContactF=:idContactF,idOpportunityF= :idOpportunityF, sourceAppel=:sourceAppel,indiceAppel= :indiceAppel, typeAppel=:typeAppel,dureeAppel= :dureeAppel,dureeConversation= :dureeConversation,firstAgent= :firstAgent, lastAgent=:lastAgent,commentaireAppel= :commentaireAppel, nomCampagne=:nomCampagne WHERE indiceAppel =:indiceAppel");
        } else {
            // $numero = "APL_" . date('dmYHis') . $auteur ? $auteur->idUtilisateur : '';
            $numero = "APL_" . date('dmYHis');
            $this->db->query("INSERT INTO `wbcc_appel` (`numeroAppel`, `numTelEmetteur`, `numTelRecepteur`, `dateDebutAppel`, `dateFinAppel`, `auteurAppel`, `idAuteurAppel`, `idCampagneF`, `idCompanyF`, `idContactF`, `idOpportunityF`, `sourceAppel`, `indiceAppel`, `typeAppel`, `dureeAppel`, `dureeConversation`, `firstAgent`, `lastAgent`, `commentaireAppel`, nomCampagne) VALUES (:numeroAppel, :numTelEmetteur, :numTelRecepteur, :dateDebutAppel, :dateFinAppel, :auteurAppel, :idAuteurAppel, :idCampagneF, :idCompanyF, :idContactF, :idOpportunityF, :sourceAppel, :indiceAppel, :typeAppel, :dureeAppel, :dureeConversation, :firstAgent, :lastAgent, :commentaireAppel, : nomCampagne)");
            $this->db->bind("numeroAppel", $numero);
        }
        $this->db->bind("numTelEmetteur", $appel['FirstCampaign']);
        $this->db->bind("nomCampagne", $campagne ? $campagne->Description : '');
        $this->db->bind("numTelRecepteur", $appel['OutTel']);
        $this->db->bind("dateDebutAppel", $appel['CallUniversalTime']);
        $this->db->bind("dateFinAppel", $appel['CallUniversalTime']);
        $this->db->bind("auteurAppel", $auteur ? $auteur->fullName : '');
        $this->db->bind("idAuteurAppel", $auteur ? $auteur->idUtilisateur : '');
        $this->db->bind("idCampagneF", '0');
        $this->db->bind("idCompanyF", trim($appel['idSociete']));
        $this->db->bind("idContactF", '0');
        $this->db->bind("idOpportunityF", '0');
        $this->db->bind("sourceAppel", 'vocalcom');
        $this->db->bind("indiceAppel", $appel['Indice']);
        $this->db->bind("typeAppel", $appel['Description']);
        $this->db->bind("dureeAppel", $appel['Duration']);
        $this->db->bind("dureeConversation", $appel['CallDuration']);
        $this->db->bind("firstAgent", $appel['FirstAgent']);
        $this->db->bind("lastAgent", $appel['LastAgent']);
        $this->db->bind("commentaireAppel", $appel['Comments']);
        if ($this->db->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function findByID($id)
    {
        $this->db->query("SELECT * FROM wbcc_roles WHERE idRole = $id");
        return $this->db->single();
    }
}
