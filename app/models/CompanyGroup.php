<?php

class CompanyGroup extends Model
{
    protected $tableName = 'wbccgroup_company';

    public function __construct()
    {
        parent::__construct();
    }

    public function getCompaniesNonFranchise()
    {
        $this->db->query("SELECT * FROM `wbccgroup_company` WHERE (franchise IS NULL OR franchise = '')  AND (integre IS NULL OR integre = '') ");
        return $this->db->resultSet();
    }

    public function getIndustryCompany()
    {
        $this->db->query("SELECT DISTINCT(industry) FROM `wbccgroup_company` WHERE industry IS NOT NULL && industry != ''");
        return $this->db->resultSet();
    }

    public function findQuestScript($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_proxinistre WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function findQuestScriptCb($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_cb WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function findQuestScriptCbB2c($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_cb_b2c WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function findQuestScriptHbB2c($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_hb_b2c WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function findQuestScriptHbB2b($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_hb_b2b WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function findQuestScriptBatirymB2b($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_quest_campagne_batirym_b2b WHERE idCompanyGroupF = $id");
        return $this->db->single();
    }

    public function select($col = "*"): self
    {
        $this->selectAtr = '';
        $this->selectAtr = "SELECT " . $col . "FROM " . $this->tableName;
        return $this;
    }


    public function getCategoriesDO()
    {
        $sql = "SELECT * FROM wbcc_categorie_do";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function getSubCategoriesDO($idCategorieDO = null)
    {
        if ($idCategorieDO) {
            // Récupérer les sous-catégories pour une catégorie spécifique
            $sql = "SELECT * FROM wbcc_sous_categorie_do WHERE idCategorieF = :idCategorieF";
            $this->db->query($sql);
            $this->db->bind(':idCategorieF', $idCategorieDO);
        } else {
            // Récupérer toutes les sous-catégories
            $sql = "SELECT * FROM wbcc_sous_categorie_do";
            $this->db->query($sql);
        }

        return $this->db->resultSet();
    }

    public function update(): self
    {
        $this->updateAtr = '';
        $this->updateAtr = "UPDATE " . $this->tableName;
        return $this;
    }

    public function getCompaniesByIdStatut($idStatut)
    {
        return $this->select()
            ->where("category LIKE '%$idStatut%' OR sousCategorieDO LIKE '%$idStatut%'")
            ->doQuery();
    }

    public function getAllCompanies($type = "", $orderBy = "")
    {
        $sql = "";
        if ($type != "") {
            $sql .= " WHERE qualification = $type";
        }
        if ($orderBy != "") {
            $sql .= " ORDER BY $orderBy";
        }
        $sql = "SELECT * FROM {$this->tableName} $sql";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function saveCompany(
        $numeroCompany = null,
        $name = '',
        $enseigne = '',
        $businessPhone = '',
        $email = '',
        $webaddress = '',
        $category = '',
        $businessLine1 = '',
        $businessLine2 = '',
        $businessPostalCode = '',
        $businessCity = '',
        $businessState = '',
        $region = '',
        $businessCountryName = '',
        $numeroRCS = '',
        $villeRCS = '',
        $numeroSiret = '',
        $siccode = '',
        $idAuteur = '',
        $auteur = '',
        $numEmployees = '',
        $revenue = '',
        $idCompany = null,
        $idAuteurLastEdit = null,
        $auteurLastEdit = null,
        $email2 = '',
        $industry = '',
        $metier = '',
        $anneeAffaire = '',
        $chiffreAffaire = '',
        $whatsapp = '',
        $skype = '',
        $linkedin = '',
        $facebook = '',
        $instagram = '',
        $dateCreationJuridique = '',
        $franchise = '',
        $integre = '',
        $idFederation = null,
        $idFormeJuridiqueF = null,
        $categorieDO = '',
        $sousCategorieDO = '',
        $commentaire = '',
        $description = '',
        $kbs = ''
    ) {
        // Mode de fonctionnement: ajout ou mise à jour
        $isUpdate = !empty($idCompany);
        $numeroRCS = empty($numeroRCS) && !empty($numeroSiret) && strlen($numeroSiret) >= 9 ? substr($numeroSiret, 0, 9) : $numeroRCS;

        // Vérifier que les champs obligatoires ne sont pas vides
        // if (empty($email)) {
        //     return "L'email ne peut pas être vide";
        // }

        // if (empty($numeroSiret)) {
        //     return "Le numéro SIRET ne peut pas être vide";
        // }

        // if (empty($businessPhone)) {
        //     return "Le numéro de téléphone ne peut pas être vide";
        // }

        // Vérifier si idFederation est vide ou non valide
        if (empty($idFederation)) {
            $idFederation = null;
        } else {
            // Vérifier si la fédération existe
            $this->db->query("SELECT idCompany FROM {$this->tableName} WHERE idCompany = :idFederation");
            $this->db->bind(':idFederation', $idFederation);
            if (!$this->db->single()) {
                $idFederation = null; // La fédération n'existe pas, la définir comme NULL
            }
        }

        // Vérifications d'unicité
        if ($isUpdate) {
            // Mode mise à jour : vérifier que les valeurs ne sont pas utilisées par d'autres entreprises
            // Vérifier l'unicité du numéro SIRET pour les autres entreprises
            if (!empty($numeroSiret)) {
                $this->db->query("SELECT idCompany FROM {$this->tableName} WHERE numeroSiret = :numeroSiret AND idCompany != :idCompany");
                $this->db->bind(':numeroSiret', $numeroSiret);
                $this->db->bind(':idCompany', $idCompany);
                if ($this->db->single()) {
                    return "Le numéro SIRET est déjà utilisé par une autre entreprise";
                }
            } else {
                // Vérifier l'unicité de l'email pour les autres entreprises
                if (!empty($email)) {
                    $this->db->query("SELECT idCompany FROM {$this->tableName} WHERE email = :email AND idCompany != :idCompany");
                    $this->db->bind(':email', $email);
                    $this->db->bind(':idCompany', $idCompany);
                    if ($this->db->single()) {
                        return "Email déjà utilisé par une autre entreprise";
                    }
                } else {
                    // Vérifier l'unicité du numéro de téléphone pour les autres entreprises
                    if (!empty($businessPhone)) {
                        $this->db->query("SELECT idCompany FROM {$this->tableName} WHERE businessPhone = :businessPhone AND idCompany != :idCompany");
                        $this->db->bind(':businessPhone', $businessPhone);
                        $this->db->bind(':idCompany', $idCompany);
                        if ($this->db->single()) {
                            return "Le numéro de téléphone est déjà utilisé par une autre entreprise";
                        }
                    }
                }
            }
        } else {
            // Mode ajout : vérifier que les valeurs ne sont pas déjà utilisées
            // Vérifier l'unicité du numéro SIRET
            if (!empty($numeroSiret)) {
                if (findItemByColumn($this->tableName, 'numeroSiret', $numeroSiret)) {
                    return "Le numéro SIRET est déjà utilisé";
                }
            } else {
                // Vérifier l'unicité de l'email
                if (!empty($email)) {
                    if (findItemByColumn($this->tableName, 'email', $email)) {
                        return "Email déjà utilisé";
                    }
                } else {
                    // Vérifier l'unicité du numéro de téléphone
                    if (!empty($businessPhone)) {
                        if (findItemByColumn($this->tableName, 'businessPhone', $businessPhone)) {
                            return "Le numéro de téléphone est déjà utilisé";
                        }
                    }
                }
            }
        }
        //GET REGION ET DEPARTEMENT
        // if (($businessPostalCode != null && $businessPostalCode != "") && ($region == null || $region == "" || $businessState == null || $businessState == "")) {
        //     $jsonImms = file_get_contents(URLROOT . "/public/json/geoApi.php?action=getRegionsFrance");
        //     $regions = json_decode($jsonImms, true);
        //     foreach ($regions as $key => $reg) {
        //         $jsonImms = file_get_contents(URLROOT . "/public/json/geoApi.php?action=getDepartementsByCoderegion&code=" . $reg['code']);
        //         $deps = json_decode($jsonImms, true);
        //         foreach ($deps as $key => $dep) {
        //             if (substr($businessPostalCode, 0, 2) ==  $dep['code']) {
        //                 $businessState = $dep['nom'];
        //                 $region = $reg['nom'];
        //             }
        //         }
        //     }
        // }
        // Vérifier si tous les champs de qualification sont remplis
        $hasAllFields =
            !empty($name) &&
            !empty($enseigne) &&
            !empty($businessPhone) &&
            !empty($email) &&
            !empty($categorieDO) &&
            // !empty($category) &&
            !empty($businessLine1) &&
            !empty($businessPostalCode) &&
            !empty($businessCity) &&
            // !empty($businessState) &&
            // !empty($region) &&
            // !empty($numeroRCS) &&
            !empty($numeroSiret) &&
            // !empty($villeRCS) &&
            // !empty($dateCreationJuridique)  &&
            // !empty($idFormeJuridiqueF)  &&
            // !empty($kbs) &&
            !empty($siccode) &&
            !empty($industry) &&
            !empty($metier) &&
            !empty($franchise) &&
            !empty($integre);

        // Vérifier si la société a au moins un contact associé
        $hasAssociatedContact = false;
        if ($isUpdate) {
            // Pour une mise à jour, vérifier dans la table des associations
            $this->db->query("SELECT * FROM wbccgroup_company_contact WHERE idCompanyF = :idCompany");
            $this->db->bind('idCompany', $idCompany);
            $result = $this->db->resultSet();
            $hasAssociatedContact = sizeof($result) > 0 ? true : false;
        }

        // Elle sera à 1 uniquement si tous les champs sont remplis ET qu'il y a au moins un contact associé
        $qualification = ($hasAllFields && ($hasAssociatedContact)) ? 1 : 0;
        // $qualification = ($hasAllFields) ? 1 : 0;

        // Procéder à l'insertion ou à la mise à jour
        if ($isUpdate) {
            // Mode mise à jour
            $sql = "UPDATE {$this->tableName} 
            SET name = :name, 
                enseigne = :enseigne, 
                businessPhone = :businessPhone, 
                email = :email, 
                webaddress = :webaddress, 
                category = :category,
                businessLine1 = :businessLine1, 
                businessLine2 = :businessLine2, 
                businessPostalCode = :businessPostalCode, 
                businessCity = :businessCity, 
                businessState = :businessState,
                region = :region, 
                numeroRCS = :numeroRCS, 
                villeRCS = :villeRCS, 
                numeroSiret = :numeroSiret, 
                siccode = :siccode, 
                numEmployees = :numEmployees,
                idAuteurLastEdit = :idAuteurLastEdit,
                auteurLastEdit = :auteurLastEdit,
                revenue = :revenue,
                email2 = :email2,
                industry = :industry,
                metier = :metier,
                anneeAffaire = :anneeAffaire,
                chiffreAffaire = :chiffreAffaire,
                whatsapp = :whatsapp,
                skype = :skype,
                linkedin = :linkedin,
                facebook = :facebook,
                instagram = :instagram,
                dateCreationJuridique = :dateCreationJuridique,
                  idFormeJuridiqueF = :idFormeJuridiqueF,
                franchise = :franchise,
                integre = :integre,
                categorieDO = :categorieDO,
                sousCategorieDO = :sousCategorieDO,
                commentaire = :commentaire,
                description = :description,
                kbs = :kbs,
                qualification = :qualification";

            // Ajouter le champ idFederation à la requête SQL selon qu'il est null ou non
            if ($idFederation === null) {
                $sql .= ", idFederation = NULL";
            } else {
                $sql .= ", idFederation = :idFederation";
            }

            $sql .= " WHERE idCompany = :idCompany";

            $this->db->query($sql);

            // Lier les paramètres spécifiques à la mise à jour
            $this->db->bind('idCompany', $idCompany, null);
            $this->db->bind('idAuteurLastEdit', $idAuteurLastEdit, null);
            $this->db->bind('auteurLastEdit', $auteurLastEdit, null);
        } else {
            // Mode ajout - pour un nouvel ajout, nous ne pouvons pas encore vérifier les contacts associés
            // donc qualification sera initialement à 0
            // $qualification = 0;

            $sql = "INSERT INTO {$this->tableName} (
                numeroCompany, name, enseigne, businessPhone, email, 
                webaddress, category, businessLine1, businessLine2, businessPostalCode, 
                businessCity, businessState, region, businessCountryName, 
                numeroRCS, villeRCS, numeroSiret, siccode, numEmployees,
                idAuteur, auteur, revenue, email2, industry, metier, 
                anneeAffaire, chiffreAffaire, whatsapp, skype, linkedin, 
                facebook, instagram, dateCreationJuridique, franchise, integre, idFormeJuridiqueF,
                categorieDO, sousCategorieDO, commentaire, description, kbs,
                qualification";

            // Ajouter le champ idFederation à la requête SQL selon qu'il est null ou non
            if ($idFederation !== null) {
                $sql .= ", idFederation";
            }

            $sql .= ") VALUES (
                :numeroCompany, :name, :enseigne, :businessPhone, :email,
                :webaddress, :category, :businessLine1, :businessLine2, :businessPostalCode,
                :businessCity, :businessState, :region, :businessCountryName,
                :numeroRCS, :villeRCS, :numeroSiret, :siccode, :numEmployees,
                :idAuteur, :auteur, :revenue, :email2, :industry, :metier,
                :anneeAffaire, :chiffreAffaire, :whatsapp, :skype, :linkedin,
                :facebook, :instagram, :dateCreationJuridique, :franchise, :integre, :idFormeJuridiqueF,
                :categorieDO, :sousCategorieDO, :commentaire, :description, :kbs,
                :qualification";

            // Ajouter la valeur idFederation à la requête SQL selon qu'il est null ou non
            if ($idFederation !== null) {
                $sql .= ", :idFederation";
            }

            $sql .= ")";

            $this->db->query($sql);
            // Lier les paramètres spécifiques à l'ajout
            $this->db->bind('numeroCompany', $numeroCompany, null);
            $this->db->bind('businessCountryName', $businessCountryName, null);
            $this->db->bind('idAuteur', $idAuteur, null);
            $this->db->bind('auteur', $auteur, null);
        }

        // Lier les paramètres communs
        $this->db->bind('name', $name, null);
        $this->db->bind('enseigne', $enseigne, null);
        $this->db->bind('businessPhone', $businessPhone, null);
        $this->db->bind('email', $email, null);
        $this->db->bind('webaddress', $webaddress, null);
        $this->db->bind('category', $category, null);
        $this->db->bind('businessLine1', $businessLine1, null);
        $this->db->bind('businessLine2', $businessLine2, null);
        $this->db->bind('businessPostalCode', $businessPostalCode, null);
        $this->db->bind('businessCity', $businessCity, null);
        $this->db->bind('businessState', $businessState, null);
        $this->db->bind('region', $region, null);
        $this->db->bind('numeroRCS', $numeroRCS, null);
        $this->db->bind('villeRCS', $villeRCS, null);
        $this->db->bind('numeroSiret', $numeroSiret, null);
        $this->db->bind('siccode', $siccode, null);
        $this->db->bind('numEmployees', $numEmployees != null && $numEmployees != "" ? $numEmployees : 0, null);
        $this->db->bind('revenue', $revenue, null);
        $this->db->bind('email2', $email2, null);
        $this->db->bind('industry', $industry, null);
        $this->db->bind('metier', $metier, null);
        $this->db->bind('anneeAffaire', $anneeAffaire, null);
        $this->db->bind('chiffreAffaire', $chiffreAffaire, null);
        $this->db->bind('whatsapp', $whatsapp, null);
        $this->db->bind('skype', $skype, null);
        $this->db->bind('linkedin', $linkedin, null);
        $this->db->bind('facebook', $facebook, null);
        $this->db->bind('instagram', $instagram, null);
        $this->db->bind('dateCreationJuridique', $dateCreationJuridique, null);
        $this->db->bind('franchise', $franchise, null);
        $this->db->bind('integre', $integre, null);
        $this->db->bind('idFormeJuridiqueF',  $idFormeJuridiqueF != "" && $idFormeJuridiqueF != null ? $idFormeJuridiqueF : null, null);
        $this->db->bind('categorieDO', $categorieDO, null);
        $this->db->bind('sousCategorieDO', $sousCategorieDO, null);
        $this->db->bind('commentaire', $commentaire, null);
        $this->db->bind('description', $description, null);
        $this->db->bind('kbs', $kbs, null);
        $this->db->bind('qualification', $qualification, null);

        // Lier idFederation seulement s'il n'est pas null
        if ($idFederation !== null) {
            $this->db->bind('idFederation', $idFederation, null);
        }

        // Exécuter la requête
        $result = $this->db->execute();
        if ($isUpdate) {
        } else {
            $idCompany =  findItemByColumn($this->tableName, 'numeroCompany', $numeroCompany)->idCompany;
        }
        //SI QUALIFIER => cLOTURER TACHE 1
        if ($qualification == 1) {
            closeActivityByCode(1, null, $idCompany, $auteur, "", $idAuteur, "En attente de qualification", "Tâche 'En attente de qualification' clôturée avec succés", "Tâche 'En attente de qualification' clôturée avec succés");
        }

        // Retourner le résultat approprié selon le mode
        if ($isUpdate) {
            return $result;
        } else {
            return $result ? $idCompany : 0;
        }
    }
    public function findByNumero($numeroCompany)
    {
        return findItemByColumn($this->tableName, 'numeroCompany', $numeroCompany);
    }

    public function findByName($name)
    {
        return findItemByColumn($this->tableName, 'name', $name);
    }

    public function findById($idCompany)
    {
        return findItemByColumn($this->tableName, 'idCompany', $idCompany);
    }

    public function deleteCompany($idCompany)
    {
        $this->db->query("DELETE FROM {$this->tableName} WHERE idCompany = :idCompany");
        $this->db->bind('idCompany', $idCompany, null);
        return $this->db->execute();
    }

    public function getFormesJuridiques()
    {
        $sql = "SELECT * FROM wbcc_forme_juridique ORDER BY libelleFormeJuridique";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function checkAssociation($idContact, $idCompany)
    {
        $this->db->query("SELECT idCompanyContact FROM wbccgroup_company_contact 
                      WHERE idContactF = :idContact AND idCompanyF = :idCompany");
        $this->db->bind(':idContact', $idContact);
        $this->db->bind(':idCompany', $idCompany);

        $row = $this->db->single();

        return !empty($row);
    }

    public function createAssociation($idContact, $idCompany)
    {
        // Vérifier si l'association existe déjà
        if ($this->checkAssociation($idContact, $idCompany)) {
            return true; // L'association existe déjà, on considère que c'est un succès
        }

        $this->db->query("INSERT INTO wbccgroup_company_contact (idContactF, idCompanyF, dateAssociation) 
                     VALUES (:idContact, :idCompany, NOW())");
        $this->db->bind(':idContact', $idContact);
        $this->db->bind(':idCompany', $idCompany);

        return $this->db->execute();
    }

    public function linkCompanyToTicket($contactId, $ticketSvg = null,  $idTicket = null)
    {
        // Vérification de l'existence préalable de la relation
        $this->db->query("SELECT * FROM wbccgroup_ticket_company 
                          WHERE idCompanyF = :contactId AND idTicketSvgF = :ticketSvg AND idTicketF=:idTicket  LIMIT 1");
        $this->db->bind(':contactId', $contactId);
        $this->db->bind(':ticketSvg', $ticketSvg);
        $this->db->bind(':idTicket', $idTicket);
        $existing = $this->db->single();
        if ($existing) {
            // La relation existe déjà, pas besoin de la recréer
            return true;
        } else {
            // Création de la relation
            $this->db->query("INSERT INTO wbccgroup_ticket_company (idCompanyF, idTicketSvgF, idTicketF) 
                         VALUES (:contactId, :ticketSvg, :idTicket)");
            $this->db->bind(':contactId', $contactId);
            $this->db->bind(':ticketSvg', $ticketSvg);
            $this->db->bind(':idTicket', $idTicket);
            return $this->db->execute();
        }
    }
}