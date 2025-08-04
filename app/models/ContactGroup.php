<?php

class ContactGroup extends Model
{

    public function saveContactInCompany($idContact, $civilite, $prenom, $nom, $tel, $email, $poste, $statut, $idCompany)
    {
        $today = date("Y-m-d H:i");
        $numeroContact = "CON" . date("dmYHis");

        if ($idContact != '0') {
            $this->db->query("UPDATE wbccgroup_contact SET 
                    prenom = :prenom, 
                    nom = :nom, 
                    tel = :tel, 
                    email = :email, 
                    dateEdition = '$today',
                    statut = :statut, 
                    poste = :poste, 
                    civilite = :civilite
                    WHERE idContact = $idContact");
        } else {
            $this->db->query("INSERT INTO wbccgroup_contact(numeroContact,prenom,nom,tel,email,statut,civilite,poste) VALUES ('$numeroContact',:prenom,:nom,:tel,:email,:statut,:civilite,:poste)");
        }
        $this->db->bind(':civilite', $civilite);
        $this->db->bind(':prenom', $prenom);
        $this->db->bind(':nom', $nom);
        $this->db->bind(':tel', $tel);
        $this->db->bind(':email', $email);
        $this->db->bind(':statut', $statut);
        $this->db->bind(':poste', $poste);
        if ($this->db->execute()) {
            if ($idCompany != null) {
                if ($idContact == '0') {
                    $this->db->query("SELECT * FROM wbccgroup_contact WHERE numeroContact = '$numeroContact'");
                    $contact = $this->db->single();
                    if ($contact) {
                        $idContact = $contact->idContact;
                    }
                }
                if ($idContact != '0') {
                    if (strtolower($poste) == 'responsable') {
                        $this->db->query("UPDATE wbccgroup_company SET idGerantF=$idContact WHERE idCompany=$idCompany");
                        $this->db->execute();
                    }
                    $this->db->query("SELECT * FROM wbccgroup_company_contact WHERE idCompanyF=$idCompany AND idContactF=$idContact");
                    $conComp = $this->db->single();
                    if ($conComp) {
                        return true;
                    } else {
                        $this->db->query("INSERT INTO wbccgroup_company_contact(idCompanyF,idContactF) VALUES($idCompany,$idContact)");
                        $this->db->execute();
                        return true;
                    }
                }
            } else {
                return true;
            }
        }
    }

    public function getAllContacts()
    {
        $this->db->query("SELECT * FROM wbccgroup_contact ORDER BY idContact DESC");
        return $this->db->resultSet();
    }


    public function getContactByCompany($id)
    {
        $this->db->query("SELECT * FROM wbccgroup_contact, wbccgroup_company_contact WHERE idContact = idContactF AND idCompanyF = $id ");
        return $this->db->resultSet();
    }

    public function getCompanyByContact($idContact)
    {
        $this->db->query("SELECT c.* FROM wbccgroup_company c JOIN wbccgroup_company_contact cc ON c.idCompany = cc.idCompanyF
            WHERE cc.idContactF = :idContact
        ");
        $this->db->bind(':idContact', $idContact);
        return $this->db->resultSet();
    }


    public function saveContact($data, $type = 'insert')
    {
        try {
            // Log détaillé des données avant traitement
            // error_log('DÉBUT ' . ($type === 'insert' ? 'INSERTION' : 'MISE À JOUR') . ' CONTACT - Données reçues: ' . print_r($data, true));

            // Vérification pour update
            if ($type === 'update') {
                $this->db->query("SELECT idContact FROM wbccgroup_contact WHERE idContact = :id");
                $this->db->bind(':id', $data['idContact']);
                $existingContact = $this->db->single();
            }

            // Choix de la requête basé sur le type
            $query = $type === 'insert'
                ? "INSERT INTO wbccgroup_contact (
                    numeroContact, prenom, nom, tel, email, adresse, codePostal, ville,  
                    dateCreation, dateEdition, auteur, idAuteur, statut, civilite,
                    departement, businessState, whatsapp, instagram, facebook, skype, linkedin
                ) VALUES (
                    :numeroContact, :prenom, :nom, :tel, :email, :adresse, :codePostal, :ville,
                    :dateCreation, :dateEdition, :auteur, :idAuteur, :statut, :civilite,
                    :departement, :region, :whatsapp, :instagram, :facebook, :skype, :linkedin
                )"
                : "UPDATE wbccgroup_contact SET 
                    prenom = :prenom, 
                    nom = :nom, 
                    tel = :tel, 
                    email = :email, 
                    adresse = :adresse, 
                    codePostal = :codePostal, 
                    ville = :ville, 
                    dateEdition = :dateEdition, 
                    auteur = :auteur, 
                    idAuteur = :idAuteur, 
                    statut = :statut, 
                    civilite = :civilite,
                    departement = :departement,
                    businessState = :region,
                    whatsapp = :whatsapp, 
                    instagram = :instagram, 
                    facebook = :facebook, 
                    skype = :skype, 
                    linkedin = :linkedin
                    WHERE idContact = :idContact";

            $this->db->query($query);

            // Préparation des bindings
            $bindings = [
                ':prenom' => $data['prenom'],
                ':nom' => $data['nom'],
                ':tel' => $data['tel1'] ?? $data['tel'], // Accepte tel1 du formulaire ou tel déjà enregistré
                ':email' => $data['email'],
                ':adresse' => $data['adresse1'] ?? $data['adresse'], // Accepte adresse1 du formulaire ou adresse déjà enregistrée
                ':codePostal' => $data['codePostal'] ?? '',
                ':ville' => $data['ville'] ?? '',
                ':dateEdition' => $data['dateEdition'],
                ':auteur' => $data['auteur'],
                ':idAuteur' => $data['idAuteur'],
                ':statut' => $data['statut'] ?? "",
                ':civilite' => $data['civilite'] ?? '',
                ':departement' => $data['departement'] ?? '',
                ':region' => $data['region'] ?? '',
                ':whatsapp' => $data['whatsapp'] ?? '',
                ':instagram' => $data['instagram'] ?? '',
                ':facebook' => $data['facebook'] ?? '',
                ':skype' => $data['skype'] ?? '',
                ':linkedin' => $data['linkedin'] ?? ''
            ];

            // Ajouts spécifiques selon le type
            if ($type === 'insert') {
                $bindings[':numeroContact'] = $data['numeroContact'];
                $bindings[':dateCreation'] = $data['dateCreation'];
            } else {
                $bindings[':idContact'] = $data['idContact'];
            }

            // error_log('Binding des paramètres: ' . print_r($bindings, true));

            // Binding des paramètres
            foreach ($bindings as $param => $value) {
                $this->db->bind($param, $value);
            }

            // Exécution de la requête
            $result = $this->db->execute();
            // error_log('Résultat de l\'exécution: ' . ($result ? 'Succès' : 'Échec'));

            if ($result) {
                $returnId = $type === 'insert'
                    ? $this->db->lastInsertId()
                    : $data['idContact'];

                // error_log($type === 'insert'
                //     ? 'Contact inséré avec succès. ID: ' . $returnId
                //     : 'Contact mis à jour avec succès. ID: ' . $returnId);

                return $returnId;
            } else {
                // error_log($type === 'insert'
                //     ? 'Échec de l\'insertion du contact.'
                //     : 'Échec de la mise à jour du contact.');
                return false;
            }
        } catch (Exception $e) {
            // error_log(($type === 'insert'
            //     ? 'Exception lors de l\'insertion'
            //     : 'Exception lors de la mise à jour') . ' du contact: ' . $e->getMessage());
            return false;
        }
    }

    public function findById($idContact)
    {
        $this->db->query("SELECT * FROM wbccgroup_contact WHERE idContact = :idContact");
        $this->db->bind(':idContact', $idContact);
        return $this->db->single();
    }

    public function findByNumero($numero)
    {
        $this->db->query("SELECT * FROM wbccgroup_contact WHERE numeroContact = '$numero'");
        return $this->db->single();
    }


    public function updateContactQualification($contactId, $qualificationLevel)
    {
        $this->db->query("UPDATE wbccgroup_contact 
                      SET qualification_level = :qualificationLevel 
                      WHERE idContact = :contactId");

        $this->db->bind(':qualificationLevel', $qualificationLevel);
        $this->db->bind(':contactId', $contactId);

        return $this->db->execute();
    }


    public function removeAssociation($contactId, $companyId)
    {
        $this->db->query("DELETE FROM wbccgroup_company_contact 
                          WHERE idContactF = :contactId AND idCompanyF = :companyId");
        $this->db->bind(':contactId', $contactId);
        $this->db->bind(':companyId', $companyId);

        return $this->db->execute();
    }

    public function linkContactToCompany($contactId, $companyId)
    {
        // Vérification de l'existence préalable de la relation
        $this->db->query("SELECT idCompanyContact FROM wbccgroup_company_contact 
                          WHERE idContactF = :contactId AND idCompanyF = :companyId");
        $this->db->bind(':contactId', $contactId);
        $this->db->bind(':companyId', $companyId);

        $existing = $this->db->single();

        if ($existing) {
            // La relation existe déjà, pas besoin de la recréer
            return true;
        }

        // Création de la relation
        $this->db->query("INSERT INTO wbccgroup_company_contact (idContactF, idCompanyF, dateAssociation) 
                         VALUES (:contactId, :companyId, NOW())");
        $this->db->bind(':contactId', $contactId);
        $this->db->bind(':companyId', $companyId);

        return $this->db->execute();
    }

    public function linkContactToTicket($contactId, $ticketSvg = null, $idTicket = null)
    {
        // Vérification de l'existence préalable de la relation
        $this->db->query("SELECT * FROM wbccgroup_ticket_contact 
                          WHERE idContactF = :contactId AND idTicketSvgF = :ticketSvg AND idTicketF=:idTicket LIMIT 1");
        $this->db->bind(':contactId', $contactId);
        $this->db->bind(':ticketSvg', $ticketSvg);
        $this->db->bind(':idTicket', $idTicket);
        $existing = $this->db->single();
        if ($existing) {
            // La relation existe déjà, pas besoin de la recréer
            return true;
        } else {
            // Création de la relation
            $this->db->query("INSERT INTO wbccgroup_ticket_contact (idContactF, idTicketSvgF, idTicketF) 
                         VALUES (:contactId, :ticketSvg, :idTicket)");
            $this->db->bind(':contactId', $contactId);
            $this->db->bind(':ticketSvg', $ticketSvg);
            $this->db->bind(':idTicket', $idTicket);

            return $this->db->execute();
        }
    }
}
