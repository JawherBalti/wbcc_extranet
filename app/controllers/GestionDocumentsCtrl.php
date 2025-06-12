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
        $this->societeModel = $this->model('Societe');
        // $this->jourFerieModel = $this->model('JourFerie');
    }

    public function index()
    {
        header("location:javascript://history.go(-1)");
    }

        public function repertoireCommun() {
        $role = $_SESSION['connectedUser']->role;
        $connectedUser = "";
        $listeUtilisateurs = [];
        $listeSociete = [];
        if($role == 1) {
            $listeUtilisateurs = $this->userModel->getAll("");
            $listeSociete = $this->societeModel->getAllSociete();
        } else {
            $connectedUser = $_SESSION["connectedUser"];
            $connectedUserId = $connectedUser->idUtilisateur;
            $listeSociete = $this->societeModel->getSocieteByUserId($connectedUserId);
            $listeUtilisateurs[] = $connectedUser;
        }
        $periode = "";
        $dateOne = "";
        $dateDebut = "";
        $dateFin = "";

        if (isset($_GET)) {
            extract($_GET);
        }

        $repertoireCommun = $this->repertoireCommunModel->getRepertoire($periode, $dateOne, $dateDebut, $dateFin);
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
            "listeUtilisateurs" => $listeUtilisateurs,
            "listeSociete" => $listeSociete,
            "repertoireCommun" => $repertoireCommun,
            "periode" => $periode,
            "dateOne" => $dateOne,
            "dateDebut" => $dateDebut,
            "dateFin" => $dateFin,
        ];
        $this->view('gestionDocuments/repertoireCommun', $data);
    }

        public function repertoirePersonnel()
    {
        $input = $_GET ?? [];
        list($where, $params, $titreExt) = $this->buildActivityFilters($input);
    
        $idUser     = $_SESSION['connectedUser']->idUtilisateur;
        $where[]    = "a.idUtilisateurF = :me";
        $params[':me'] = $idUser;
    
        $data = [
            'titre'        => 'Répertoire personnel' . $titreExt,
            'toutesLesTaches' => $this->activityModel->getTachesUtilisateur($idUser, $where, $params),
            'periode'      => $input['periode']   ?? '',
            'dateOne'      => $input['dateOne']   ?? '',
            'dateDebut'    => $input['dateDebut'] ?? '',
            'dateFin'      => $input['dateFin']   ?? '',
            'etatSelected' => $input['etat']      ?? '',
            'idUser'       => $idUser,
            'Taches' => ($_SESSION['connectedUser']->isAdmin) 
                ? $this->activityModel->getAllActivitiesForSelect() 
                : $this->activityModel->getAllActivitiesForSelect($_SESSION['connectedUser']->idUtilisateur),
        ];
    
        $this->view('gestionDocuments/repertoirePersonnel', $data);
    }
    
    public function repertoireEmployes() {
        $role = $_SESSION['connectedUser']->role;
        $titre = "";
        $connectedUser = "";
        $toutesLesTaches = [];

        $idUser     = $_SESSION['connectedUser']->idUtilisateur;
        $where[]    = "a.idUtilisateurF = :me";
        $params[':me'] = $idUser;

        
        $idUtilisateur = "";
        $idSite = "";
        $statut = "";
        $periode = "";
        $dateOne = "";
        $dateDebut = "";
        $dateFin = "";
        $numero = "";

        if (isset($_GET)) {
            extract($_GET);
        }

        if($role == 1) {
            $listeUtilisateurs = $this->userModel->getAll("");
            $sites = $this->siteModel->getAllSites();
            $titre = "Repertoire des employés";
            $activities = $this->activityModel->getActivities($statut, $idUtilisateur, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $numero);
        }else if($role == 25) {
            $listeUtilisateurs =  $this->userModel->getUsersBySite($_SESSION['connectedUser']->idSiteF, 1);
        } else {
            $connectedUser = $_SESSION["connectedUser"];
            $titre = "Repertoire personnel";
            $sites= [];
            $listeUtilisateurs = [];
            $toutesLesTaches = $this->activityModel->getAllActivitiesForSelect($_SESSION['connectedUser']->idUtilisateur);
            $activities = $this->activityModel->getActivities($statut, $idUtilisateur, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $numero);
        }

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
            "titre" => $titre,
            "role" => $role,
            "connectedUser" => $connectedUser,
            "listeUtilisateurs" => $listeUtilisateurs,
            "sites" => $sites,
            "statut" => $statut,
            "activities" => $activities,
            "toutesLesTaches" => $toutesLesTaches,
            'Taches' => ($_SESSION['connectedUser']->isAdmin) 
                ? $this->activityModel->getAllActivitiesForSelect() 
                : $this->activityModel->getAllActivitiesForSelect($_SESSION['connectedUser']->idUtilisateur),
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

    public function tableauDeBord()
    {
        $input = $_GET ?? [];
        list($where, $params, $titreExt) = $this->buildActivityFilters($input);
    
        if (!($_SESSION['connectedUser']->isAdmin ?? false)) {
            $where[]           = "a.idUtilisateurF = :me";
            $params[':me']     = $_SESSION['connectedUser']->idUtilisateur;
        }
    
        $documents       = $this->activityModel->getLastDocument($where, $params);
        $tachesOuvertes  = $this->activityModel->countTaches(0, $where, $params);
        $tachesCloturees = $this->activityModel->countTaches(1, $where, $params);
        $docsEnAttente   = $this->activityModel->countDocumentsEnAttente();
        $tachesEnRetard = $this->activityModel->countTachesEnRetard($where, $params);
    
        $data = [
            'titre'           => 'Tableau de bord' . $titreExt,
            'Documents'       => $documents,
            'toutesLesTaches' => ($_SESSION['connectedUser']->isAdmin) 
                ? $this->activityModel->getAllActivitiesForSelect() 
                : $this->activityModel->getAllActivitiesForSelect($_SESSION['connectedUser']->idUtilisateur),
            'sites'           => $this->siteModel->getAllSites(),
            'tachesStats'     => [
                'ouvertes'  => $tachesOuvertes,
                'cloturees' => $tachesCloturees,
                'attente'   => $docsEnAttente,
            ],
            'tachesOuvertes'      => $tachesOuvertes,
            'tachesCloturees'     => $tachesCloturees,
            'documentsEnAttente'  => $docsEnAttente,
            'tachesEnRetard' => $tachesEnRetard,
            'topUsersLabels'  => array_column($this->activityModel->getTopUsersDocuments($where, $params), 'name'),
            'topUsersCounts'  => array_map('intval', array_column($this->activityModel->getTopUsersDocuments($where, $params), 'total')),
            'siteLabels'      => array_column($this->activityModel->getDocumentsParSite($where, $params), 'site'),
            'siteCounts'      => array_map('intval', array_column($this->activityModel->getDocumentsParSite($where, $params), 'total')),
            'periode'         => $input['periode']   ?? '',
            'dateOne'         => $input['dateOne']   ?? '',
            'dateDebut'       => $input['dateDebut'] ?? '',
            'dateFin'         => $input['dateFin']   ?? '',
            'etatSelected'    => $input['etat']      ?? '',
            'site'            => $input['site']      ?? '',
            'utilisateurs'    => ($_SESSION['connectedUser']->role == 1) ? $this->userModel->getAll() : [],
            'idUser'          => $_SESSION['connectedUser']->idUtilisateur,
        ];
    
        $this->view('gestionDocuments/tableauDeBord', $data);
    }

    private function buildActivityFilters(array $input): array
    {
        $where  = [];
        $params = [];
        $titre  = '';
    
        if (!empty($input['nom']) && $input['nom'] !== 'aucun') {
            $where[]        = "a.idActivity = :activity";
            $params[':activity'] = $input['nom'];
        }
    
        if (!empty($input['assigner'])) {
            $where[] = "a.idUtilisateurF = :assigner";
            $params[':assigner'] = $input['assigner'];
        }
    
        if (!empty($input['site'])) {
            $where[] = "a.idUtilisateurF IN (
                SELECT idUtilisateur FROM wbcc_utilisateur u
                JOIN wbcc_site s ON u.idSiteF = s.idSite
                WHERE s.nomSite LIKE :site
            )";
            $params[':site'] = "%{$input['site']}%";
            $titre .= " – site « {$input['site']} »";
        }
        
    
        if (isset($input['etat']) && in_array($input['etat'], ['0', '1'])) {
            $where[]        = "a.isCleared = :etat";
            $params[':etat'] = $input['etat'];
        }
    
        $periode   = $input['periode']   ?? '';
        $dateOne   = $input['dateOne']   ?? '';
        $dateDebut = $input['dateDebut'] ?? '';
        $dateFin   = $input['dateFin']   ?? '';
    
        if ($periode === 'today') {
            $where[] = "DATE(a.createDate) = CURDATE()";
            $titre  .= ' – aujourd’hui';
        } elseif ($periode === '1' && $dateOne) {
            $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
        
            if ($dateOneFormatted) {
                $formattedDate = $dateOneFormatted->format('Y-m-d');
                $where[] = "DATE(a.createDate) = :dateOne";
                $params[':dateOne'] = $formattedDate;
                $titre .= ' – le ' . $dateOneFormatted->format('d/m/Y');
            } else {
                error_log("Format invalide pour dateOne = $dateOne");
            }
        } elseif ($periode === '2' && $dateDebut && $dateFin) {
            $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
            $dateFinFormatted   = DateTime::createFromFormat('d-m-Y', $dateFin);
        
            if ($dateDebutFormatted && $dateFinFormatted) {
                $formattedDebut = $dateDebutFormatted->format('Y-m-d');
                $formattedFin   = $dateFinFormatted->format('Y-m-d');
                $where[] = "a.createDate BETWEEN :dateDebut AND :dateFin";
                $params[':dateDebut'] = $formattedDebut . ' 00:00:00';
                $params[':dateFin']   = $formattedFin   . ' 23:59:59';
                $titre .= ' – du ' . $dateDebutFormatted->format('d/m/Y') . ' au ' . $dateFinFormatted->format('d/m/Y');
            } else {
                error_log("Format invalide dateDebut=$dateDebut ou dateFin=$dateFin");
            }
        } elseif ($periode) {
            $p = $this->getPeriodDates($periode);
            if (isset($p['startTime'], $p['endTime'])) {
                $where[]               = "a.createDate BETWEEN :dateDebut AND :dateFin";
                $params[':dateDebut']  = $p['startTime'] . ' 00:00:00';
                $params[':dateFin']    = $p['endTime']   . ' 23:59:59';
                $titre                .= ' – du ' .
                    date('d/m/Y', strtotime($p['startTime'])) .
                    ' au ' .
                    date('d/m/Y', strtotime($p['endTime']));
            }
        }
    
        return [$where, $params, $titre];
    }

    private function getPeriodDates($periode): array
    {
        $today = new DateTimeImmutable();
        $year = (int) $today->format('Y');

        switch ($periode) {
            case 'mois':
                return [
                    'startTime' => $today->modify('first day of this month')->format('Y-m-d'),
                    'endTime'   => $today->modify('last day of this month')->format('Y-m-d'),
                ];
            case 'semaine':
                $start = $today->modify(('Monday' === $today->format('l')) ? 'this monday' : 'last monday');
                $end = $start->modify('+6 days');
                return [
                    'startTime' => $start->format('Y-m-d'),
                    'endTime'   => $end->format('Y-m-d'),
                ];
            case 'trimestre':
                $quarter = ceil($today->format('n') / 3);
                $startMonth = ($quarter - 1) * 3 + 1;
                $start = new DateTimeImmutable("$year-$startMonth-01");
                $end = $start->modify('+2 months')->modify('last day of this month');
                return [
                    'startTime' => $start->format('Y-m-d'),
                    'endTime'   => $end->format('Y-m-d'),
                ];
            case 'semestre':
                $startMonth = ($today->format('n') <= 6) ? 1 : 7;
                $start = new DateTimeImmutable("$year-$startMonth-01");
                $end = $start->modify('+5 months')->modify('last day of this month');
                return [
                    'startTime' => $start->format('Y-m-d'),
                    'endTime'   => $end->format('Y-m-d'),
                ];
            case 'annuel':
                return [
                    'startTime' => "$year-01-01",
                    'endTime'   => "$year-12-31",
                ];
            default:
                return [];
        }
    }
}