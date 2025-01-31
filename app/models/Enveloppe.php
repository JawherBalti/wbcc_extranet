<?php

class Enveloppe extends Model
{
    function getAllEncaissementsOP($statut, $type, $gestionnaire, $periode, $date1, $date2)
    {
        $idUser = $_SESSION['connectedUser']->idUtilisateur;
        $sql = "";

        //FILTRER PAR STATUT
        if ($statut == "enCours") {
            $sql .= " AND ( status !='Won' AND status !='Lost') ";
        } else {
            if ($statut == "clotures") {
                $sql .= " AND ( status='Won' OR status='Lost') ";
            } else {
                if ($statut == "AMO") {
                    $sql .= " AND type LIKE '%A.M.O%' ";
                } else {
                    if ($statut == "SINISTRE") {
                        $sql .= " AND type LIKE '%sinistre%' ";
                    }
                }
                // if ($statut == "attenteCloture") {
                //     $sql .= " AND status='Open' AND demandeCloture=1 ";
                // } else {
                //     if ($statut == "attenteValidation") {
                //         $sql .= " AND  (status='Open' OR status IS NULL) AND name LIKE '%X%' ";
                //     }
                // }
            }
        }
        //FILTRER PAR SITE
        if ($type != 'tous') {
            if ($type == 'me') {
                $sql .= " AND o.gestionnaire IN ($idUser) ";
            } else {
                $sql .= " AND o.gestionnaire IN (SELECT idUtilisateur FROM wbcc_utilisateur WHERE idSiteF=$type) ";
            }
        }
        //FILTRER PAR GESTIONNAIRE
        if ($gestionnaire != 'tous') {
            $sql .= " AND o.gestionnaire =$gestionnaire ";
        }
        //FILTRER PAR PERIODE
        $today = date("Y-m-d");
        if ($periode != "" && $periode != "all") {
            if ($periode == "today") {
                $sql .= " AND dateEncaissement = '$today' ";
            } else {
                if ($periode == "day") {
                    $sql .= " AND dateEncaissement = '$date1' ";
                } else {
                    $sql .= " AND   dateEncaissement >= '$date1' AND dateEncaissement <= '$date2'  ";
                }
            }
        }

        $sql = "SELECT * FROM wbcc_encaissement, wbcc_journal, wbcc_opportunity o, wbcc_utilisateur u, wbcc_contact c, wbcc_site s WHERE s.idSite = u.idSiteF AND u.idUtilisateur=o.gestionnaire AND c.idContact = u.idContactF AND idOpportunity=idOPEncaissement AND idJournalF=idJournal $sql ORDER BY idEncaissement DESC";

        $this->db->query($sql);
        $encaissements = $this->db->resultSet();
        foreach ($encaissements as $key => $enc) {
            $this->db->query("SELECT * FROM wbcc_immeuble WHERE idImmeuble =:idImmeuble LIMIT 1");
            $this->db->bind("idImmeuble", ($enc->idImmeuble != null && $enc->idImmeuble != "" ? $enc->idImmeuble : null), null);
            $im = $this->db->single();
            $enc->immeuble = $im;
        }
        return $encaissements;
    }
}
