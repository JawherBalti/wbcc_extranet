<?php
class GestionDocumentsCtrl extends Controller
{
    public function __construct()
    {
        $this->repertoireCommunModel = $this->model("RepertoireCommun");
        $this->companyModel = $this->model('Company');
        $this->siteModel = $this->model('Site');
        $this->userModel = $this->model('Utilisateur');
        // $this->equipementModel = $this->model('Equipement');
        // $this->pieceModel = $this->model('Piece');
        $this->contactModel = $this->model('Contact');
        // $this->artisanModel = $this->model('Artisan');
        $this->subventionModel = $this->model('Subvention');
        $this->critereModel = $this->model('Critere');
        $this->parametreModel = $this->model('Parametres');
        $this->pointageModel = $this->model('Pointage');
        $this->roleModel = $this->model('Roles');
        $this->projetModel = $this->model('Projet');
        $this->immeubleModel = $this->model('Immeuble');
        $this->congeModel = $this->model('Conge');
        $this->activityModel = $this->model('Activity');
        // $this->jourFerieModel = $this->model('JourFerie');
    }

    public function index()
    {
        header("location:javascript://history.go(-1)");
    }

        public function repertoireCommun()
    {
        $role = $_SESSION['connectedUser']->role;
        $connectedUser = "";
        $listeComptableGestionnaire = [];
        if($role == 1) {
            $gestionnaires = $this->userModel->getUserByRole("GESTIONNAIRE");
            $comptables = $this->userModel->getUserByRole("COMPTABLE");
            $listeComptableGestionnaire = array_merge($gestionnaires, $comptables);
        } else {
            $connectedUser = $_SESSION["connectedUser"];
            $listeComptableGestionnaire[] = $connectedUser;

        }

        $repertoireCommun = $this->repertoireCommunModel->getRepertoire();
        $data = [
            "gerepresence" => linkTo('GestionInterne', 'gerepresence'),
            "genererAvertissement" => linkTo('GestionInterne', 'genererAvertissement'),
            "gererPaie" => linkTo('GestionInterne', 'gererPaie'),
            "gererConges" => linkTo('GestionInterne', 'gererConges'),
            "tbdPresence" => linkTo('GestionInterne', 'tbdPresence'),
            "Pointer" => linkTo('GestionInterne', 'Pointer'),
            "DemanderConge" => linkTo('GestionInterne', 'DemanderConge'),
            "avertir" => linkTo('GestionInterne', 'avertir'),
            "dashbord" => linkTo('GestionInterne', 'dashbord'),
            "titre" => 'Liste des documents ouverts',
            "role" => $role,
            "connectedUser" => $connectedUser,
            "listeComptableGestionnaire" => $listeComptableGestionnaire,
            "repertoireCommun" => $repertoireCommun,
        ];
        $this->view('gestionDocuments/repertoireCommun', $data);
    }
    
    public function repertoireEmployes() {
        $role = $_SESSION['connectedUser']->role;
        $connectedUser = "";
        $listeComptableGestionnaire = [];
        if($role == 1) {
            $gestionnaires = $this->userModel->getUserByRole("GESTIONNAIRE");
            $comptables = $this->userModel->getUserByRole("COMPTABLE");
            $listeComptableGestionnaire = array_merge($gestionnaires, $comptables);
            $sites = $this->siteModel->getAllSites();

        } else {
            $connectedUser = $_SESSION["connectedUser"];
        }

        $idUtilisateur = "";
        $idSite = "";
        $statut = "";
        $periode = "";
        $dateOne = "";
        $dateDebut = "";
        $dateFin = "";

        if (isset($_GET)) {
            extract($_GET);
        }

        $activities = $this->activityModel->getActivities($statut, $idUtilisateur, $idSite, $periode, $dateOne, $dateDebut, $dateFin);
        $sites = $this->siteModel->getAllSites();
        $data = [
            "gerepresence" => linkTo('GestionInterne', 'gerepresence'),
            "genererAvertissement" => linkTo('GestionInterne', 'genererAvertissement'),
            "gererPaie" => linkTo('GestionInterne', 'gererPaie'),
            "gererConges" => linkTo('GestionInterne', 'gererConges'),
            "tbdPresence" => linkTo('GestionInterne', 'tbdPresence'),
            "Pointer" => linkTo('GestionInterne', 'Pointer'),
            "DemanderConge" => linkTo('GestionInterne', 'DemanderConge'),
            "avertir" => linkTo('GestionInterne', 'avertir'),
            "dashbord" => linkTo('GestionInterne', 'dashbord'),
            "titre" => 'Liste des tâches des employés',
            "role" => $role,
            "connectedUser" => $connectedUser,
            "listeComptableGestionnaire" => $listeComptableGestionnaire,
            "sites" => $sites,
            "statut" => $statut,
            "activities" => $activities,
        ];
        $this->view('gestionDocuments/repertoireEmployes', $data);
    }

    public function gererDocument() {
        if (isset($_GET)) {
            extract($_GET);
        }
        $this->view('gestionDocuments/repertoireCommun');
    }


   public function indexDocuments()
    {
        $where = [];
        $params = [];
        $role = $_SESSION['connectedUser']->role;
        $periode =  'today';
        $dateOne =  ''; // For single date 'A la date du'
        $dateDebut =  ''; // For 'Personnaliser'
        $dateFin = ''; // For 'Personnaliser'
        $idUtilisateur = ''; // For filtering by user

        $idUtilisateur == '' ?
        $titre = 'LISTE DES Taches DE TOUS LES UTILISATEURS' :
        $titre = 'LISTE DES Taches';
        $site = '';
        $sites = $this->siteModel->getAllSites();
        $utilisateurs = $this->userModel->getAll();

        if ($site) {
            $titre .= ' DU SITE DE ' . "'" . $site . "'";
        }

        if (!$_SESSION['connectedUser']->isAdmin) {
            $where[] = "a.idUtilisateurF = :idUtilisateurF";
            $params[':idUtilisateurF'] = $_SESSION['connectedUser']->idUtilisateur;
        }

        if (!empty($_GET['nom'])) {
            $where[] = "a.location LIKE :nom";
            $params[':nom'] = "%" . $_GET['nom'] . "%";
        }

        if (!empty($_GET['assigner'])) {
            $where[] = "c2.fullName LIKE :assigner";
            $params[':assigner'] = "%" . $_GET['assigner'] . "%";
        }
        if (!empty($_GET['site'])) {
            $where[] = "s.nomSite LIKE :site";
            $params[':site'] = "%" . $_GET['site'] . "%";
        }
                
        if (isset($_GET['etat']) && ($_GET['etat'] === '0' || $_GET['etat'] === '1')) {
            $where[] = "a.publie = :etat";
            $params[':etat'] = $_GET['etat'];
        }

        if ($periode != "" && $periode != "2" && $periode != "1" && $periode != "today") {
            $re = getPeriodDates("$periode", []);
            if (sizeof($re) != 0) {
                $dateOne = $re['startTime'];
                $dateDebut = $re['startTime'];
                $dateFin = $re['endTime'];
            }
            $titre .= " du " . date('d/m/Y', strtotime($dateDebut)) . " au " . date('d/m/Y', strtotime($dateFin));
        } else {
            if ($periode == "1") {
                $titre .= " du " . date('d/m/Y', strtotime($dateOne));
            } else {
                if ($periode == "today") {
                    $titre .= " Aujourd'hui";
                } else {
                    if ($periode == "2") {
                        $titre .= " du " . date('d/m/Y', strtotime($dateDebut)) . " au " . date('d/m/Y', strtotime($dateFin));
                    }
                }
            }
        }

      
        $Documents = $this->activityModel->getLastDocument($where, $params);
        $tachesOuvertes = $this->activityModel->countTachesOuvertes($where, $params);
        $tachesCloturees = $this->activityModel->countTachesCloturees($where, $params);
        $documentsEnAttente = $this->activityModel->countDocumentsEnAttente();
        $topUsersRaw = $this->activityModel->getTopUsersDocuments($where, $params);
        $tachesStats = [
            "ouvertes" => $this->activityModel->countTachesOuvertes($where, $params),
            "cloturees" => $this->activityModel->countTachesCloturees($where, $params),
            "attente" => $this->activityModel->countDocumentsEnAttente()
        ];
        $topUsersLabels = [];
        $topUsersCounts = [];
        
        foreach ($topUsersRaw as $row) {
          $topUsersLabels[] = $row->name;
          $topUsersCounts[] = (int) $row->total;
        }

        $documentsParSite = $this->activityModel->getDocumentsParSite($where, $params);
        $siteLabels = [];
        $siteCounts = [];
        foreach ($documentsParSite as $row) {
            $siteLabels[] = $row->site;
            $siteCounts[] = (int)$row->total;
        }

        $data = [
            "Documents" => $Documents,
            "periode" => $periode,
            "dateOne"=> $dateOne,
            "dateFin"=> $dateFin,
            "dateDebut"=> $dateDebut,
            "titre" => $titre,
            "site" => $site,
            "sites" => $sites,
            "tachesOuvertes" => $tachesOuvertes,
            "tachesCloturees" => $tachesCloturees,
            "documentsEnAttente" => $documentsEnAttente,
            "tachesStats" => $tachesStats,
            "topUsersLabels" =>$topUsersLabels,
            "topUsersCounts" =>$topUsersCounts,
            "siteLabels" => $siteLabels,
            "siteCounts" => $siteCounts,
            "utilisateurs" => $utilisateurs,
            "titre" => "Tableau"
        ];

        $this->view('gestionDocuments/indexDocuments', $data);
    }

    public function indexProjet()
    {
        $idUser = $_SESSION['connectedUser']->idUtilisateur;
        $where = [];
        $params = [];
        $periode =  'today';
        $dateOne =  ''; // For single date 'A la date du'
        $dateDebut =  ''; // For 'Personnaliser'
        $dateFin = ''; // For 'Personnaliser'
        $idUtilisateur = ''; // For filtering by user

        $idUtilisateur == '' ?
        $titre = 'LISTE DES Taches DE TOUS LES UTILISATEURS' :
        $titre = 'LISTE DES Taches';
        if (!empty($_GET['nom'])) {
            $where[] = "a.numeroActivity LIKE :nom";
            $params[':nom'] = "%" . $_GET['nom'] . "%";
        }

        if (isset($_GET['etat']) && ($_GET['etat'] === '0' || $_GET['etat'] === '1')) {
            $where[] = "a.isCleared = :etat";
            $params[':etat'] = $_GET['etat'];
        }

        if ($periode != "" && $periode != "2" && $periode != "1" && $periode != "today") {
            $re = getPeriodDates("$periode", []);
            if (sizeof($re) != 0) {
                $dateOne = $re['startTime'];
                $dateDebut = $re['startTime'];
                $dateFin = $re['endTime'];
            }
            $titre .= " du " . date('d/m/Y', strtotime($dateDebut)) . " au " . date('d/m/Y', strtotime($dateFin));
        } else {
            if ($periode == "1") {
                $titre .= " du " . date('d/m/Y', strtotime($dateOne));
            } else {
                if ($periode == "today") {
                    $titre .= " Aujourd'hui";
                } else {
                    if ($periode == "2") {
                        $titre .= " du " . date('d/m/Y', strtotime($dateDebut)) . " au " . date('d/m/Y', strtotime($dateFin));
                    }
                }
            }
        }


        $taches = $this->activityModel->getTachesUtilisateur($idUser, $where, $params);

        $data = [

            "periode" => $periode,
            "dateOne"=> $dateOne,
            "dateFin"=> $dateFin,
            "dateDebut"=> $dateDebut,
            "titre" => $titre,
"idUser" => $idUser,
            "taches" => $taches
        ];

        $this->view('gestionDocuments/repertoirePersonnel', $data);
    }
}