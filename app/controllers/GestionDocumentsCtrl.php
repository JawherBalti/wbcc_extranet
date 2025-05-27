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
        // $this->jourFerieModel = $this->model('JourFerie');
    }

    public function index()
    {
        header("location:javascript://history.go(-1)");
    }

        public function indexDocuments()
    {
        $role = $_SESSION['connectedUser']->role;
        $type = "wbcc";
        $idContact = Role::connectedUser()->idUtilisateur;
        if ($role == 25) {
            $personnels = $this->userModel->getUsersBySite(($_SESSION['connectedUser'])->idSiteF, 1);
        } else {
            $personnels = $this->userModel->getUsersByType($type);
        }
        $roles = $this->roleModel->getRolesByType($type);
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
            "sites" => $sites,
            "personnels" => $personnels,
            "roles" => $roles,
            "idContact" => $idContact,
            "titre" => 'Liste des utilisateurs'
        ];
        $this->view('gestionDocuments/indexDocuments', $data);
    }
        public function repertoireCommun()
    {
        // $role = $_SESSION['connectedUser']->role;
        // $type = "wbcc";
        // $idContact = Role::connectedUser()->idUtilisateur;
        // if ($role == 25) {
        //     $personnels = $this->userModel->getUsersBySite(($_SESSION['connectedUser'])->idSiteF, 1);
        // } else {
        //     $personnels = $this->userModel->getUsersByType($type);
        // }
        // $roles = $this->roleModel->getRolesByType($type);
        // $sites = $this->siteModel->getAllSites();
        $role = $_SESSION['connectedUser']->role;
        $connectedUser = "";
        $listeContableGestionnaire = [];
        if($role == 1) {
            $gestionnaires = $this->userModel->getUserByRole("GESTIONNAIRE");
            $comptables = $this->userModel->getUserByRole("COMPTABLE");
            $listeContableGestionnaire = array_merge($gestionnaires, $comptables);
        } else {
            $connectedUser = $_SESSION["connectedUser"];
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
            "listeContableGestionnaire" => $listeContableGestionnaire,
            "repertoireCommun" => $repertoireCommun,
        ];
        $this->view('gestionDocuments/repertoireCommun', $data);
    }

    public function gererDocument() {
        if (isset($_GET)) {
            extract($_GET);
        }
        $this->view('gestionDocuments/repertoireCommun');
    }
}