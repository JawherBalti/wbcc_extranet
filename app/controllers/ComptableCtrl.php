<?php

class ComptableCtrl extends Controller
{
    public function __construct()
    {

        if (isset($_SESSION["connectedUser"]) && $_SESSION["connectedUser"]->isInterne != 1) {
            $this->redirectToMethod('Home', 'index');
        }

        $this->utilisateurModel = $this->model('Utilisateur');
        $this->enveloppeModel = $this->model('Enveloppe');
        $this->siteModel = $this->model('Site');
    }

    public function indexEncaissement()
    {
        $role = $_SESSION['connectedUser']->role;
        $idSite = $_SESSION['connectedUser']->idSite;
        $idUser = $_SESSION['connectedUser']->idUtilisateur;
        $statut = "tous";
        $type = ($role == 3 || $role == 25) ? "$idSite" : "tous";
        $gestionnaire =  "tous";
        $periode = "all";
        $date1 = "";
        $date2 = "";
        if (isset($_GET)) {
            extract($_GET);
        }

        $titre = "LISTE DES ENCAISSEMENTS EFFECTUES PAR ";
        if ($type == "me") {
            $titre .= $_SESSION['connectedUser']->fullName;
            $gestionnaire =  "tous";
        } else {
            if ($gestionnaire != "tous") {
                $contact = $this->utilisateurModel->findUserById($gestionnaire);
                $titre .= "$contact->fullName POUR ";
            } else {
            }
            if ($type == "tous") {
                $titre .= " WBCC ";
            } else {
                $site = $this->siteModel->findById($type);
                $titre .= " LE SITE DE '$site->nomSite'";
            }
        }

        if ($periode != "all" && $periode != "perso" && $periode != "day" && $periode != "today") {
            $re = getPeriodDates("$periode", []);
            if (sizeof($re) != 0) {
                $date1 = $re['startDate'];
                $date2 = $re['endDate'];
            }
            $titre .= " du " . date('d/m/Y', strtotime($date1)) . " au " . date('d/m/Y', strtotime($date2));
        } else {
            if ($periode == "day") {
                $titre .= " du " . date('d/m/Y', strtotime($date1));
            } else {
                if ($periode == "today") {
                    $titre .= " Aujourd'hui";
                } else {
                    if ($periode == "perso") {
                        $titre .= " du " . date('d/m/Y', strtotime($date1)) . " au " . date('d/m/Y', strtotime($date2));
                    }
                }
            }
        }

        $encaissements = $this->enveloppeModel->getAllEncaissementsOP($statut, $type, $gestionnaire, $periode, $date1, $date2);
        $total = 0;
        foreach ($encaissements as $key => $value) {
            $total += $value->montantEncaissement;
        }

        $sites = $this->siteModel->getAllSites();
        $gestionnaires = $this->utilisateurModel->getUserByidsRoles(3, 25, "gestionnaire", ($type == "tous" || $type == "me" ? "" : $type));
        $data = [
            "sites" => $sites,
            "titre" => $titre,
            "encaissements" => $encaissements,
            "gestionnaires" => $gestionnaires,
            "total" => $total,
            "statut" => "$statut",
            "type" => $type,
            "gestionnaire" => $gestionnaire,
            "periode" => "$periode",
            "date1" => "$date1",
            "date2" => "$date2",
            "idUser" => $idUser
        ];
        $this->view('comptable/indexEncaissement', $data);
    }
}
