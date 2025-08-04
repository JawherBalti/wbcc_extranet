<?php

class CampagneCtrl extends Controller
{

    public function __construct()
    {
        $this->companyGroupModel = $this->model('CompanyGroup');
        $this->contactGroupModel = $this->model('ContactGroup');
        $this->statusModel = $this->model('StatusCompany');
        $this->historyGroupModel = $this->model('HistoryGroup');
        $this->activityGroupModel = $this->model('ActivityGroup');
        $this->companyModel = $this->model('Company');
    }

    public function index()
    {
        $data = [];
        $this->view('campagne/index', $data);
    }

    public function indexProxinistre($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];

            $this->view('campagne/indexProxinistreB2B', $data);
        }
    }

    public function indexFormationProxinistre($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $company = $this->companyGroupModel->findById($id);
            // $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $gerant = $this->contactGroupModel->findById(1);
            $questScript = $this->companyGroupModel->findQuestScript(10);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            $this->view('campagne/indexFormationProxinistreB2B', $data);
        }
    }

    public function indexProxinistreB2C($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $idContact = 1;
            $contact = $this->contactGroupModel->findById($idContact);
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "contact" => $contact,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];

            $this->view('campagne/indexProxinistreB2C', $data);
        }
    }
    
    public function indexFormationProxinistreB2C($id = '')
        {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $idContact = 1;
            $company = $this->companyGroupModel->findById($id);
            // $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $gerant = $this->contactGroupModel->findById(1);
            $contact = $this->contactGroupModel->findById($idContact);
            $questScript = $this->companyGroupModel->findQuestScript(10);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "contact" => $contact,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            $this->view('campagne/indexFormationProxinistreB2C', $data);
        }
    }

    public function indexFormationCB($id = '', $typeScript = 'b2b')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {

            $idContact = 1;
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById(1);
            $contact = $this->contactGroupModel->findById($idContact);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "contact" => $contact,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance,
            ];
            if ($typeScript == 'b2b') {
                $this->view('campagne/indexFormationCbB2B', $data);
            } elseif ($typeScript == 'b2c') {
                $this->view('campagne/indexFormationCbB2C', $data);
            }
        }
    }

    // public function indexCb($id = '')
    // {
    //     $connectedUser = Role::connectedUser();
    //     $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
    //     if ($id != null && $id != '') {
    //         # code...
    //         $company = $this->companyGroupModel->findById($id);
    //         // $gerant = $this->contactGroupModel->findById($company->idGerantF);
    //         $gerant = $this->contactGroupModel->findById(1);
    //         $questScript = $this->companyGroupModel->findQuestScriptCb(20);
    //         $typeSinistres = [
    //             'degatEaux' => 'a. Dégâts des eaux',
    //             'incendie' => 'b. Incendies',
    //             'brisGlace' => 'c. Bris de glace',
    //             'defense' => 'd. Defense Recours',
    //             'evenementClimatique' => 'e. Evènements Climatiques',
    //             'vol' => 'f. Vol, Tentative de vol',
    //             'vandalisme' => 'g. Vandalisme',
    //             'autre' => 'Autre type de sinistre'
    //         ];

    //         $data = [
    //             "connectedUser" => $connectedUser,
    //             "company" => $company,
    //             "gerant" => $gerant,
    //             "questScript" => $questScript,
    //             "typeSinistres" => $typeSinistres,
    //             "tousCieAssurance" => $tousCieAssurance
    //         ];
    //         $this->view('campagne/indexCbB2B', $data);
    //     }
    // }

    public function indexCb($id = '', $typeScript = 'b2b')
        {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $idContact = 1;
            $company = $this->companyGroupModel->findById($id);
            // $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $gerant = $this->contactGroupModel->findById(1);
            if($typeScript == 'b2b') {
                $questScript = $this->companyGroupModel->findQuestScriptCb($id);
            } else {
                $questScript = $this->companyGroupModel->findQuestScriptCbB2c($id);
            }
            $contact = $this->contactGroupModel->findById($idContact);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "contact" => $contact,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            if ($typeScript == 'b2b') {
                $this->view('campagne/indexCbB2B', $data);
            } elseif ($typeScript == 'b2c') {
                $this->view('campagne/indexCbB2C', $data);
            }
        }
    }

    public function indexHb($id = '', $typeScript = 'b2b')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $idContact = 1;
            $contact = $this->contactGroupModel->findById($idContact);
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            if($typeScript == 'b2b') {
                $questScript = $this->companyGroupModel->findQuestScriptHbB2b($id);
            }else {
                $questScript = $this->companyGroupModel->findQuestScriptHbB2c($id);
            }
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "contact" => $contact,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];

            if ($typeScript == 'b2b') {
                $this->view('campagne/indexHbB2B', $data);
            } elseif ($typeScript == 'b2c') {
                $this->view('campagne/indexHbB2C', $data);
            }
        }
    }

    // public function indexHbB2B($id = '')
    // {
    //     $connectedUser = Role::connectedUser();
    //     $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
    //     if ($id != null && $id != '') {
    //         # code...
    //         $idContact = 1;
    //         $contact = $this->contactGroupModel->findById($idContact);
    //         $company = $this->companyGroupModel->findById($id);
    //         $gerant = $this->contactGroupModel->findById($company->idGerantF);
    //         $questScript = $this->companyGroupModel->findQuestScriptHbB2b($id);
    //         $typeSinistres = [
    //             'degatEaux' => 'a. Dégâts des eaux',
    //             'incendie' => 'b. Incendies',
    //             'brisGlace' => 'c. Bris de glace',
    //             'defense' => 'd. Defense Recours',
    //             'evenementClimatique' => 'e. Evènements Climatiques',
    //             'vol' => 'f. Vol, Tentative de vol',
    //             'vandalisme' => 'g. Vandalisme',
    //             'autre' => 'Autre type de sinistre'
    //         ];

    //         $data = [
    //             "connectedUser" => $connectedUser,
    //             "contact" => $contact,
    //             "company" => $company,
    //             "gerant" => $gerant,
    //             "questScript" => $questScript,
    //             "typeSinistres" => $typeSinistres,
    //             "tousCieAssurance" => $tousCieAssurance
    //         ];

    //         $this->view('campagne/indexHbB2B', $data);
    //     }
    // }

    public function indexBatirymB2B($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            # code...
            $idContact = 1;
            $contact = $this->contactGroupModel->findById($idContact);
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScriptBatirymB2b($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "contact" => $contact,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];

            $this->view('campagne/indexBatirymB2B', $data);
        }
    }

        public function indexFormationHbB2C($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            $this->view('campagne/indexFormationHbB2C', $data);
        }
    }


    public function indexFormationHbB2B($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            $this->view('campagne/indexFormationHbB2B', $data);
        }
    }

public function indexFormationBatirymB2B($id = '')
    {
        $connectedUser = Role::connectedUser();
        $tousCieAssurance = $this->companyModel->getCompaniesByIdStatut("ASSURANCE");
        if ($id != null && $id != '') {
            $company = $this->companyGroupModel->findById($id);
            $gerant = $this->contactGroupModel->findById($company->idGerantF);
            $questScript = $this->companyGroupModel->findQuestScript($id);
            $typeSinistres = [
                'degatEaux' => 'a. Dégâts des eaux',
                'incendie' => 'b. Incendies',
                'brisGlace' => 'c. Bris de glace',
                'defense' => 'd. Defense Recours',
                'evenementClimatique' => 'e. Evènements Climatiques',
                'vol' => 'f. Vol, Tentative de vol',
                'vandalisme' => 'g. Vandalisme',
                'autre' => 'Autre type de sinistre'
            ];

            $data = [
                "connectedUser" => $connectedUser,
                "company" => $company,
                "gerant" => $gerant,
                "questScript" => $questScript,
                "typeSinistres" => $typeSinistres,
                "tousCieAssurance" => $tousCieAssurance
            ];
            $this->view('campagne/indexFormationBatirym', $data);
        }
    }



}
