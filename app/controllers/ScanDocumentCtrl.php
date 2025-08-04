<?php
class ScanDocumentCtrl extends Controller
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
        $this->activityModel = $this->model('Activity2');
        $this->societeModel = $this->model('Company');
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
        $listeUtilisateurs = [];
        $listeSociete = [];
        if ($role == 1) {
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
        $this->view('scanDocument/repertoireCommun', $data);
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

        $this->view('scanDocument/repertoirePersonnel', $data);
    }

    public function repertoireEmployes()
    {
        $role = $_SESSION['connectedUser']->role;
        $titre = "";
        $connectedUser = "";
        $toutesLesTaches = [];

        $idUser     = $_SESSION['connectedUser']->idUtilisateur;
        $where[]    = "a.idUtilisateurF = :me";
        $params[':me'] = $idUser;


        $userId = "";
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

        if ($role == 1) {
            $listeUtilisateurs = $this->userModel->getAll("");
            $sites = $this->siteModel->getAllSites();
            $titre = "Repertoire des employés";
            $activities = $this->activityModel->getActivities($statut, $userId, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $numero);
        } else {
            $connectedUser = $_SESSION["connectedUser"];
            $titre = "Repertoire des employés";
            $sites = [$this->siteModel->findById($_SESSION['connectedUser']->idSiteF)];
            $listeUtilisateurs = [$_SESSION['connectedUser']];
            $toutesLesTaches = $this->activityModel->getAllActivitiesForSelect($_SESSION['connectedUser']->idUtilisateur);
            $activities = $this->activityModel->getActivities($statut, $userId, $idSite, $periode, $dateOne, $dateDebut, $dateFin, $numero);
        }

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
            "periode" => $periode,
            "dateOne" => $dateOne,
            "dateDebut" => $dateDebut,
            "dateFin" => $dateFin,
            "statut" => $statut,
            "idSite" => $idSite,
            "userId" => $userId,

        ];
        $this->view('scanDocument/repertoireEmployes', $data);
    }

    public function gererDocument()
    {
        if (isset($_GET)) {
            extract($_GET);
        }
        $this->view('scanDocument/repertoireCommun');
    }


    public function tableauDeBord()
    {
        $input = $_GET ?? [];
        list($where, $params, $titreExt) = $this->activityModel->buildActivityFilters($input);

        if (!($_SESSION['connectedUser']->isAdmin ?? false)) {
            $where[]           = "a.idUtilisateurF = :me";
            $params[':me']     = $_SESSION['connectedUser']->idUtilisateur;
        }

        $documents       = $this->activityModel->getLastDocument($where, $params);
        $tachesOuvertes  = $this->activityModel->countTaches(0, $where, $params);
        $tachesCloturees = $this->activityModel->countTaches(1, $where, $params);
        $docsEnAttente   = $this->activityModel->countTaches(2, $where, $params);
        $tachesEnRetard = $this->activityModel->countTachesEnRetard($where, $params);

        $data = [
            'titre'           => 'Tableau de bord' . $titreExt,
            'Documents'       => $documents,
            'sites'           => $this->siteModel->getAllSites(),
            'tachesStats'     => [
                'ouvertes'  => $tachesOuvertes,
                'cloturees' => $tachesCloturees,
                'attente'   => $docsEnAttente,
            ],
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

        $this->view('scanDocument/tableauDeBord', $data);
    }
}
