<?php
header('Access-Control-Allow-Origin: *');

require_once "../../../app/config/config.php";
require_once "../../../app/libraries/Database.php";
require_once "../../../app/libraries/Utils.php";
require_once "../../../app/libraries/SMTP.php";
require_once "../../../app/libraries/PHPMailer.php";
require_once "../../../app/libraries/Role.php";
require_once "../../../app/libraries/Model.php";
// require_once "../../../app/models/Opportunity.php";
require_once "../../../app/models/Company.php";
require_once "../../../app/models/Contact.php";
require_once "../../../app/models/Immeuble.php";
// require_once "../../../app/models/Lot.php";
// require_once "../../../app/models/ContactGroup.php";
require_once "../../../app/models/CompanyGroup.php";

$db = new Database();

// Liste des entreprises avec qualification = 1 et ayant des campagnes associées
if (isset($_GET['action'])) {

    $action = $_GET['action'];

    if ($_GET['action'] == "saveInfosContact") {
        extract($_POST);
        $contactGroupModel = new ContactGroup();
        $res = $contactGroupModel->saveContactInCompany($idGerant, $civiliteGerant, $prenomGerant, $nomGerant, $telGerant, $emailGerant, $posteGerant, "", $idCompanyGerant);
        if ($res) {
            echo json_encode('1');
        } else {
            echo json_encode('0');
        }
    }

    //
    if ($_GET['action'] == "saveOPAndGenerateDeleg") {
        // $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $compGroupModel = new CompanyGroup();
        $companyProspect = $compGroupModel->findById($idCompanyGroup);
        $connectedUser = json_decode($connectedUser);
        //Create Company
        $compModel = new Company();
        $assurance = null;
        $company = $compModel->findByName($companyProspect->name);
        if ($company) {
        } else {
            $numeroCompany = 'COM' . date("dmYHis");

            $idCompany = $compModel->addCompany2(
                $numeroCompany,
                $companyProspect->name,
                $companyProspect->enseigne,
                $companyProspect->businessPhone,
                $companyProspect->email,
                $companyProspect->webaddress,
                $companyProspect->categorieDO,
                $companyProspect->businessLine1,
                $companyProspect->businessPostalCode,
                $companyProspect->businessState,
                $companyProspect->region,
                $companyProspect->businessCity,
                $companyProspect->businessCountryName,
                $companyProspect->numeroRCS,
                $companyProspect->villeRCS,
                $companyProspect->numeroSiret,
                $companyProspect->siccode,
                $companyProspect->industry,
                $companyProspect->numEmployees,
                $companyProspect->categorieDO,
                $companyProspect->sousCategorieDO
            );
            $company = $compModel->findById($idCompany);
        }

        if ($company != null) {
            //Create Contact Dirigeant
            //Vérifier si gerant.
            $contactModel = new Contact();
            $gerant = null;
            $interlocuteur = null;
            // if ($responsable == 'oui') 
            {
                $db->query("SELECT * FROM wbcc_contact WHERE lower(prenomContact)=lower(:prenom) AND lower(nomContact)=lower(:nom) AND telContact=:tel");
                $db->bind(":nom", $nomGerant, null);
                $db->bind(":prenom", $prenomGerant, null);
                $db->bind(":tel", $telGerant, null);
                $gerant = $db->single();
                if ($gerant) {
                    // $gerant = $contactModel->save($gerant->idContact, $civiliteGerant, $prenomGerant, $nomGerant, $telGerant, $emailSign,  $dateNaissanceSignataire, "", "", $posteGerant, "1", "Campagne Vocalcom", "", $company->idCompany, "", "", "");
                } else {
                    $gerant = $contactModel->save("0", $civiliteGerant, $prenomGerant, $nomGerant, $telGerant, $emailSign,  $dateNaissanceSignataire, "", "", $posteGerant, "1", "Campagne Vocalcom", "", $company->idCompany, "", "", "");
                }
            }

            // if ($prenomInterlocuteur != "" || $nomInterlocuteur != "" || $telInterlocuteur != "" || $emailInterlocuteur != "" || $posteInterlocuteur != "") {
            //     $db->query("SELECT * FROM wbcc_contact WHERE lower(prenomContact)=lower(:prenom) AND lower(nomContact)=lower(:nom) AND telContact=:tel");
            //     $db->bind(":nom", $nomInterlocuteur, null);
            //     $db->bind(":prenom", $prenomInterlocuteur, null);
            //     $db->bind(":tel", $telInterlocuteur, null);
            //     $interlocuteur = $db->single();
            //     if ($interlocuteur) {
            //         // $contactModel->update();
            //     } else {
            //         $interlocuteur = $contactModel->save("0", $civiliteInterlocuteur, $prenomInterlocuteur, $nomInterlocuteur, $telInterlocuteur, $emailInterlocuteur,  "", "", "", $posteInterlocuteur, "1", "Campagne Vocalcom", "", $company->idCompany, "", "", "");
            //     }
            // }


            //Create Immeuble
            $immeubleModel = new Immeuble();
            $immeuble = $immeubleModel->findImmeubleByAdresse($company->businessLine1);
            $idImmeuble = '0';
            if ($immeuble) {
                $idImmeuble = $immeuble->idImmeuble;
            } else {
                $numeroImmeuble = 'IMM' . date("dmYHis");
                $idImmeuble = $immeubleModel->addImmeuble($numeroImmeuble, "", $company->businessLine1, $company->businessPostalCode, $company->businessCity, "", "", "", "", "", "", "");
            }
            //Insert AP
            $lotModel = new Lot();
            $numeroLot = 'APP' . date("dmYHis");
            $idLot = $lotModel->addLot($numeroLot, "", $company->businessLine1, $company->businessPostalCode, $company->businessCity, "", "", $lot, $batiment, $etage, $porte, "", "", $idImmeuble);

            $opModel = new Opportunity();
            $db->query("SELECT * FROM wbcc_parametres LIMIT 1");
            $param = $db->single();
            $numero = str_pad(($param->numeroOP + 1), 4, '0', STR_PAD_LEFT);
            $name = "OP" . date("Y-m-d") . "-$numero";
            $idOP = $opModel->addOpportunity($name, $name, "", "Sinistres", "Partie privative exclusive", '0', "", $type_sinistre, '', $commentaireSinistre, '');
            $idCompanyAss = 0;
            if ($idOP != "0") {
                $db->query("UPDATE wbcc_parametres SET numeroOP=$param->numeroOP + 1");
                $db->execute();

                $db->query("UPDATE wbcc_opportunity SET status='Open',numGestionnaire='WBCC000',gestionnaire=518,idCommercial=$connectedUser->idUtilisateur, commercial='$connectedUser->fullName'");
                $db->execute();
                createHistorique("Création de l'opportunité : $name",  $connectedUser->fullName, $connectedUser->idUtilisateur, $idOP);
                createNewActivity($idOP, $name, 518, "Compte WBCC", "5770501a-425d-4f50-b66a-016c2dbb2557", $name . "-Faire signer la délégation de gestion", "", date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), "Tâche à faire", "False", 0, 1);
                createNewActivity($idOP, $name, 518, "Compte WBCC", "5770501a-425d-4f50-b66a-016c2dbb2557", $name . "-Faire la Télé-Expertise", "", date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), "Tâche à faire", "False", 0, 2);
                createNewActivity($idOP, $name, 518, "Compte WBCC", "5770501a-425d-4f50-b66a-016c2dbb2557", $name . "-Programmer le RT", "", date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), "Tâche à faire", "False", 0, 3);

                //save op-immeuble
                if ($idImmeuble != "0") {
                    $db->query("UPDATE wbcc_opportunity SET dateSinistre=:date, idImmeuble=$idImmeuble WHERE idOpportunity=$idOP");
                    $db->bind(":date", $dateSinistre == "" ? $dateApproximative : '');
                    $db->execute();
                    $db->query("INSERT INTO wbcc_opportunity_immeuble(idImmeubleF,idOpportunityF) VALUES ($idImmeuble,$idOP)");
                    $db->execute();
                }

                //save op-app
                if ($idLot != "0") {
                    //MAJ Infos Assurance Num Police & infos
                    $db->query("UPDATE wbcc_appartement SET dateDebutContrat=:dateDebut,dateFinContrat=:dateFin WHERE idApp=$idLot");
                    $db->bind(":dateDebut", $dateDebutContrat);
                    $db->bind(":dateFin", $dateFinContrat);
                    $db->execute();

                    $db->query("UPDATE wbcc_opportunity SET idAppartement=$idLot WHERE idOpportunity=$idOP");
                    $db->execute();
                    $db->query("INSERT INTO wbcc_opportunity_appartement(idAppartementF,idOpportunityF) VALUES ($idLot,$idOP)");
                    $db->execute();
                }

                //save app-con
                if ($idLot != "0" && $gerant != null) {
                    $db->query("INSERT INTO wbcc_appartement_contact(idContactF,idAppartementF) VALUES ($gerant->idContact ,$idLot)");
                    $db->execute();
                }

                //save op-contact-gerant
                if ($gerant != null) {
                    $db->query("INSERT INTO wbcc_contact_opportunity(idContactF,idOpportunityF) VALUES ($gerant->idContact ,$idOP)");

                    if ($db->execute()) {
                        $db->query("UPDATE wbcc_opportunity SET idContactClient=$gerant->idContact, nomDO =:nomDO, contactClient=:contactClient WHERE idOpportunity=$idOP");
                        $db->bind(":nomDO", $gerant->prenomContact . ' ' . $gerant->nomContact);
                        $db->bind(":contactClient", $gerant->prenomContact . ' ' . $gerant->nomContact);
                        $db->execute();
                    }
                }

                //save op-contact-interlocuteur
                // if ($interlocuteur != null) {
                //     $db->query("INSERT INTO wbcc_contact_opportunity(idContactF,idOpportunityF) VALUES ($interlocuteur->idContact ,$idOP)");
                //     $db->execute();
                // }

                //save company-opportunity
                if ($nomCieAssurance != "") {

                    $assurance = $compModel->findByName($nomCieAssurance);
                    if ($assurance) {
                        $db->query("INSERT INTO wbcc_company_opportunity(idCompanyF,idOpportunityF) VALUES ($assurance->idCompany,$idOP)");
                        $db->execute();
                        //MAJ idCompany
                        $db->query("UPDATE wbcc_opportunity SET idComMRHF=$assurance->idCompany,denominationComMRH=:name,policeMRH=:numPolice,sinistreMRH=:numSinistre WHERE idOpportunity=$idOP");
                        $db->bind(":numPolice", $numPolice);
                        $db->bind(":numSinistre", "");
                        $db->bind(":name", $nomCieAssurance);

                        $db->execute();
                    }
                }


                $db->query("INSERT INTO wbcc_company_opportunity(idCompanyF,idOpportunityF) VALUES ($company->idCompany,$idOP)");
                $db->execute();

                $opCree = $opModel->findByIdOp($idOP);

                // if ($accordRVRT == 'oui') {
                //     $tab = explode(',', $causes);
                //     $causes = implode(";", $tab);

                //     $numeroRT = 'RT' . date("dmYHis") . $idUser;
                //     $db->query("INSERT INTO wbcc_releve_technique (numeroRT, numeroOP, nature, date, numeroBatiment, adresse, codePostal, ville, codePorte, precisionComplementaire, autrePrecisionDegat, niveauEtage, partieConcernee, idOpportunityF,idAppContactF,createDate, editDate) VALUES (:numeroRT, :numeroOP, :nature,:date1, :numeroBatiment, :adresse, :codePostal, :ville, :codePorte, :precisionComplementaire, :precisionDegat, :niveauEtage, :partieConcernee, :idOpportunityF,:idAppContactF,:createDate, :editDate)");
                //     $db->bind("numeroRT", $numeroRT, null);
                //     $db->bind("numeroOP", $opCree->name, null);
                //     $db->bind("nature", $type_sinistre, null);
                //     $db->bind("date1", convertDateMysqlFormat($dateSinistre), null);
                //     $db->bind("numeroBatiment", $batiment, null);
                //     $db->bind("adresse", $adresse, null);
                //     $db->bind("codePostal", $codePostal, null);
                //     $db->bind("ville", $ville, null);
                //     $db->bind("codePorte", $porte, null);
                //     $db->bind("precisionComplementaire", $commentaireSinistre, null);
                //     $db->bind("precisionDegat", $causes, null);
                //     $db->bind("niveauEtage", $etage, null);
                //     $db->bind("partieConcernee", "Privative", null);
                //     $db->bind("idOpportunityF", $idOP, null);
                //     $db->bind("idAppContactF", "", null);
                //     $db->bind("createDate", date("Y-m-d H:i:s"), null);
                //     $db->bind("editDate", date("Y-m-d H:i:s"), null);
                //     if ($db->execute()) {
                //         echo json_encode($opInsert);
                //     }
                // }

                //Generer et signer Delegation
                $file1 = file_get_contents(URLROOT . "/public/documents/delegations/rapportDelegation.php?idOp=$idOP&checkedMRH=1&modeSignature=sans");
                $file1 = str_replace('"', "", $file1);

                $db->query("UPDATE wbcc_opportunity SET genereDelegation=1, rapportDelegation=:fileD WHERE idOpportunity=$idOP");
                $db->bind("fileD", $file1, null);
                $db->execute();

                //SAVE DOC DELEGATION
                $r = new Role();
                $delegationDoc = createDocument($idOP, $connectedUser->idUtilisateur, $connectedUser->prenomContact . ' ' . $connectedUser->nomContact, $file1, $file1, 'opportunite', "0");

                $opCree->delegationDoc = $delegationDoc;
                if ($companyProspect) {
                    $db->query("UPDATE wbccgroup_quest_b2b SET numeroOP = :name WHERE idCompanyGroupF=$companyProspect->idCompany");
                    $db->bind("name", $name, null);
                    $db->execute();
                }
                echo json_encode($opCree);
            }
        } else {
            echo json_encode("0");
        }
    }

    // if ($action == "saveScriptPartielCb") {
    //     extract($_POST);

    //     $_POST['editDate'] = date('Y-m-d H:i:s');
    //     foreach ($_POST as $key => $variable) {
    //     var_dump($key);
    //     var_dump($variable);
    //         $quest = findItemByColumn("wbccgroup_quest_campagne_cb", "idCompanyGroupF ", $idCompanyGroup);

    //         if (isset($key) && str_contains($key, "concerne") && $variable != "") {
    //             $key = 'reponse_concerne';
    //         }
    //         if (isset($key) && $key == "causes") {
    //             $key = 'causes';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }


    //         if (isset($key) && $key == "dommages") {
    //             $key = 'dommages';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }

    //         $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wbccgroup_quest_campagne_cb' AND COLUMN_NAME = '$key'");
    //         $res = $db->single()->nb;
    //         if ($res == 1) {
    //             if ($quest) {
    //                 $db->query("UPDATE wbccgroup_quest_campagne_cb SET $key=:bind$key WHERE idCompanyGroupF = $idCompanyGroup");
    //             } else {
    //                 $db->query("INSERT INTO wbccgroup_quest_campagne_cb($key,idCompanyGroupF) VALUES (:bind$key,$idCompanyGroup)");
    //             }

    //             $db->bind(":bind$key", $variable, null);
    //             $db->execute();
    //         }
    //     }
    //     //ENVOI MAIL & QUALIFICATION
    //     $response = false;
    //     if ($_POST['etapeSauvegarde'] == 'fin') {
    //         $bodyMessage = "";
    //         $destinataire = "";
    //         $subject = "";
    //         $signature  = $_POST['signatureMail'];
    //         $envoiDoc = false;
    //         $cc = [];
    //         $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
    //         $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
    //         // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
    //         //     if ($_POST['siEnvoiDoc'] == 'oui') {
    //         //         $envoiDoc = true;
    //         //         //MAIL ENVOI DOCUMENTATION  SIMPLE
    //         //         $bodyMessage = $_POST['bodyMessage'];
    //         //         $destinataire = $_POST['emailDestinataire'];
    //         //         $subject = $_POST['subject'];
    //         //     }
    //         // } else
    //         {
    //             // if ($_POST['siTravaux'] == 'oui') {
    //             //     $envoiDoc = true;
    //             //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //             //     $bodyMessage = $_POST['bodyMessage'];
    //             //     $destinataire = $_POST['emailDestinataire'];
    //             //     $subject = $_POST['subject'];
    //             // } else
    //             if (isset($_POST['siSignDeleg'])) {
    //                 if ($_POST['siSignDeleg'] == 'non') {
    //                     // if ($_POST['siEnvoiDoc'] == 'oui') {
    //                     //     $envoiDoc = true;
    //                     //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //                     //     $bodyMessage = $_POST['bodyMessage'];
    //                     //     $destinataire = $_POST['emailDestinataire'];
    //                     //     $subject = $_POST['subject'];
    //                     // }
    //                 } else {
    //                     if ($_POST['siSignDeleg'] == 'plusTard') {
    //                         $envoiDoc = true;
    //                         //generer delegation à joindre
    //                         $fichierDelegation = "";

    //                         //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
    //                         if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
    //                             $attachments[] = $fichierDelegation;
    //                             $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                             Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                             Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
    //                                             Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

    //                                             Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

    //                                             Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                             Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                             Bien cordialement,
    //                                             ";
    //                             $bodyMessage .= $signature;
    //                             $destinataire = $_POST['emailGerant'];
    //                             $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                         } else {
    //                             if ($_POST['raisonRefusSignature'] == 'documentManquant') {
    //                                 $textManquant = "";
    //                                 $attachments[] = $fichierDelegation;
    //                                 $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                 Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                 Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
    //                                                 <ul>
    //                                                     <li>Le nom de la compagnie d'assurance</li>
    //                                                     <li>Le numéro du contrat d'assurance</li>
    //                                                     <li>La date d'effet du contrat</li>
    //                                                     <li>La date d'échéance du contrat</li>
    //                                                     <li>La date du sinitre</li>
    //                                                     <li>La numéro de sinistre s'il est déjà déclaré</li>
    //                                                 </ul>
    //                                                 <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
    //                                                 Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
    //                                                 Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                 Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                 Bien cordialement,
    //                                                 ";
    //                                 $bodyMessage .= $signature;
    //                                 $destinataire = $_POST['emailGerant'];
    //                                 $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                             } else {
    //                                 if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
    //                                     $textManquant = "";
    //                                     $attachments[] = $fichierDelegation;
    //                                     $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                     Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                     Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
    //                                                     <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
    //                                                     Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
    //                                                     Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                     Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                     Bien cordialement,
    //                                                     ";
    //                                     $bodyMessage .= $signature;
    //                                     $destinataire = $_POST['emailGerant'];
    //                                     $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                 } else {
    //                                     if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
    //                                         $textManquant = "";
    //                                         $attachments[] = $fichierDelegation;
    //                                         $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                         Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                         Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
    //                                                       ...
    //                                                         <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
    //                                                         Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
    //                                                         Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                         Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                         Bien cordialement,
    //                                                         ";
    //                                         $bodyMessage .= $signature;
    //                                         $destinataire = $_POST['emailGerant'];
    //                                         $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                     } else {
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         if ($_POST['siSignDeleg'] == "non") {
    //                         } else {
    //                             if ($_POST['siSignDeleg'] == "oui") {
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if ($envoiDoc) {
    //                     $tabTo = explode(";", $destinataire);
    //                     foreach ($tabTo as $key => $value) {
    //                         if ($value != "") {
    //                             $role = new Role();
    //                             $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
    //                         }
    //                     }
    //                 }

    //                 $db->query("UPDATE wbccgroup_quest_campagne_cb SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
    //                 $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
    //                 $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
    //                 $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
    //                 $db->execute();
    //             }
    //         }
    //     }
    //     echo json_encode("1");
    // }

    // if ($action == "saveScriptPartielHbB2c") {
    //     extract($_POST);
        

    //     $_POST['editDate'] = date('Y-m-d H:i:s');
    //     foreach ($_POST as $key => $variable) {
    //         $quest = findItemByColumn("wbccgroup_quest_campagne_hb_b2c", "idCompanyGroupF ", $idCompanyGroup);

    //         if (isset($key) && str_contains($key, "concerne") && $variable != "") {
    //             $key = 'reponse_concerne';
    //         }
    //         if (isset($key) && $key == "causes") {
    //             $key = 'causes';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }


    //         if (isset($key) && $key == "dommages") {
    //             $key = 'dommages';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }

    //         $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wbccgroup_quest_campagne_hb_b2c' AND COLUMN_NAME = '$key'");
    //         $res = $db->single()->nb;
    //         if ($res == 1) {
    //             if ($quest) {
    //                 $db->query("UPDATE wbccgroup_quest_campagne_hb_b2c SET $key=:bind$key WHERE idCompanyGroupF = $idCompanyGroup");
    //             } else {
    //                 $db->query("INSERT INTO wbccgroup_quest_campagne_hb_b2c($key,idCompanyGroupF) VALUES (:bind$key,$idCompanyGroup)");
    //             }

    //             $db->bind(":bind$key", $variable, null);
    //             $db->execute();
    //         }
    //     }
    //     //ENVOI MAIL & QUALIFICATION
    //     $response = false;
    //     if ($_POST['etapeSauvegarde'] == 'fin') {
    //         $bodyMessage = "";
    //         $destinataire = "";
    //         $subject = "";
    //         $signature  = $_POST['signatureMail'];
    //         $envoiDoc = false;
    //         $cc = [];
    //         $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
    //         $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
    //         // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
    //         //     if ($_POST['siEnvoiDoc'] == 'oui') {
    //         //         $envoiDoc = true;
    //         //         //MAIL ENVOI DOCUMENTATION  SIMPLE
    //         //         $bodyMessage = $_POST['bodyMessage'];
    //         //         $destinataire = $_POST['emailDestinataire'];
    //         //         $subject = $_POST['subject'];
    //         //     }
    //         // } else
    //         {
    //             // if ($_POST['siTravaux'] == 'oui') {
    //             //     $envoiDoc = true;
    //             //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //             //     $bodyMessage = $_POST['bodyMessage'];
    //             //     $destinataire = $_POST['emailDestinataire'];
    //             //     $subject = $_POST['subject'];
    //             // } else
    //             if (isset($_POST['siSignDeleg'])) {
    //                 if ($_POST['siSignDeleg'] == 'non') {
    //                     // if ($_POST['siEnvoiDoc'] == 'oui') {
    //                     //     $envoiDoc = true;
    //                     //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //                     //     $bodyMessage = $_POST['bodyMessage'];
    //                     //     $destinataire = $_POST['emailDestinataire'];
    //                     //     $subject = $_POST['subject'];
    //                     // }
    //                 } else {
    //                     if ($_POST['siSignDeleg'] == 'plusTard') {
    //                         $envoiDoc = true;
    //                         //generer delegation à joindre
    //                         $fichierDelegation = "";

    //                         //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
    //                         if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
    //                             $attachments[] = $fichierDelegation;
    //                             $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                             Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                             Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
    //                                             Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

    //                                             Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

    //                                             Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                             Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                             Bien cordialement,
    //                                             ";
    //                             $bodyMessage .= $signature;
    //                             $destinataire = $_POST['emailGerant'];
    //                             $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                         } else {
    //                             if ($_POST['raisonRefusSignature'] == 'documentManquant') {
    //                                 $textManquant = "";
    //                                 $attachments[] = $fichierDelegation;
    //                                 $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                 Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                 Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
    //                                                 <ul>
    //                                                     <li>Le nom de la compagnie d'assurance</li>
    //                                                     <li>Le numéro du contrat d'assurance</li>
    //                                                     <li>La date d'effet du contrat</li>
    //                                                     <li>La date d'échéance du contrat</li>
    //                                                     <li>La date du sinitre</li>
    //                                                     <li>La numéro de sinistre s'il est déjà déclaré</li>
    //                                                 </ul>
    //                                                 <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
    //                                                 Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
    //                                                 Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                 Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                 Bien cordialement,
    //                                                 ";
    //                                 $bodyMessage .= $signature;
    //                                 $destinataire = $_POST['emailGerant'];
    //                                 $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                             } else {
    //                                 if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
    //                                     $textManquant = "";
    //                                     $attachments[] = $fichierDelegation;
    //                                     $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                     Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                     Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
    //                                                     <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
    //                                                     Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
    //                                                     Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                     Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                     Bien cordialement,
    //                                                     ";
    //                                     $bodyMessage .= $signature;
    //                                     $destinataire = $_POST['emailGerant'];
    //                                     $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                 } else {
    //                                     if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
    //                                         $textManquant = "";
    //                                         $attachments[] = $fichierDelegation;
    //                                         $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                         Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                         Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
    //                                                       ...
    //                                                         <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
    //                                                         Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
    //                                                         Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                         Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                         Bien cordialement,
    //                                                         ";
    //                                         $bodyMessage .= $signature;
    //                                         $destinataire = $_POST['emailGerant'];
    //                                         $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                     } else {
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         if ($_POST['siSignDeleg'] == "non") {
    //                         } else {
    //                             if ($_POST['siSignDeleg'] == "oui") {
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if ($envoiDoc) {
    //                     $tabTo = explode(";", $destinataire);
    //                     foreach ($tabTo as $key => $value) {
    //                         if ($value != "") {
    //                             $role = new Role();
    //                             $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
    //                         }
    //                     }
    //                 }

    //                 $db->query("UPDATE wbccgroup_quest_campagne_hb_b2c SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
    //                 $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
    //                 $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
    //                 $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
    //                 $db->execute();
    //             }
    //         }
    //     }
    //     echo json_encode("1");
    // }

    // if ($action == "saveScriptPartielHbB2b") {
    //     extract($_POST);
        

    //     $_POST['editDate'] = date('Y-m-d H:i:s');
    //     foreach ($_POST as $key => $variable) {
    //         var_dump($key);
    //         var_dump($variable);
    //         $quest = findItemByColumn("wbccgroup_quest_campagne_hb_b2b", "idCompanyGroupF ", $idCompanyGroup);

    //         if (isset($key) && str_contains($key, "concerne") && $variable != "") {
    //             $key = 'reponse_concerne';
    //         }
    //         if (isset($key) && $key == "causes") {
    //             $key = 'causes';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }


    //         if (isset($key) && $key == "dommages") {
    //             $key = 'dommages';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }

    //         $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wbccgroup_quest_campagne_hb_b2b' AND COLUMN_NAME = '$key'");
    //         $res = $db->single()->nb;
    //         if ($res == 1) {
    //             if ($quest) {
    //                 $db->query("UPDATE wbccgroup_quest_campagne_hb_b2b SET $key=:bind$key WHERE idCompanyGroupF = $idCompanyGroup");
    //             } else {
    //                 $db->query("INSERT INTO wbccgroup_quest_campagne_hb_b2b($key,idCompanyGroupF) VALUES (:bind$key,$idCompanyGroup)");
    //             }

    //             $db->bind(":bind$key", $variable, null);
    //             $db->execute();
    //         }
    //     }
    //     //ENVOI MAIL & QUALIFICATION
    //     $response = false;
    //     if ($_POST['etapeSauvegarde'] == 'fin') {
    //         $bodyMessage = "";
    //         $destinataire = "";
    //         $subject = "";
    //         $signature  = $_POST['signatureMail'];
    //         $envoiDoc = false;
    //         $cc = [];
    //         $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
    //         $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
    //         // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
    //         //     if ($_POST['siEnvoiDoc'] == 'oui') {
    //         //         $envoiDoc = true;
    //         //         //MAIL ENVOI DOCUMENTATION  SIMPLE
    //         //         $bodyMessage = $_POST['bodyMessage'];
    //         //         $destinataire = $_POST['emailDestinataire'];
    //         //         $subject = $_POST['subject'];
    //         //     }
    //         // } else
    //         {
    //             // if ($_POST['siTravaux'] == 'oui') {
    //             //     $envoiDoc = true;
    //             //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //             //     $bodyMessage = $_POST['bodyMessage'];
    //             //     $destinataire = $_POST['emailDestinataire'];
    //             //     $subject = $_POST['subject'];
    //             // } else
    //             if (isset($_POST['siSignDeleg'])) {
    //                 if ($_POST['siSignDeleg'] == 'non') {
    //                     // if ($_POST['siEnvoiDoc'] == 'oui') {
    //                     //     $envoiDoc = true;
    //                     //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //                     //     $bodyMessage = $_POST['bodyMessage'];
    //                     //     $destinataire = $_POST['emailDestinataire'];
    //                     //     $subject = $_POST['subject'];
    //                     // }
    //                 } else {
    //                     if ($_POST['siSignDeleg'] == 'plusTard') {
    //                         $envoiDoc = true;
    //                         //generer delegation à joindre
    //                         $fichierDelegation = "";

    //                         //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
    //                         if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
    //                             $attachments[] = $fichierDelegation;
    //                             $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                             Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                             Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
    //                                             Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

    //                                             Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

    //                                             Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                             Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                             Bien cordialement,
    //                                             ";
    //                             $bodyMessage .= $signature;
    //                             $destinataire = $_POST['emailGerant'];
    //                             $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                         } else {
    //                             if ($_POST['raisonRefusSignature'] == 'documentManquant') {
    //                                 $textManquant = "";
    //                                 $attachments[] = $fichierDelegation;
    //                                 $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                 Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                 Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
    //                                                 <ul>
    //                                                     <li>Le nom de la compagnie d'assurance</li>
    //                                                     <li>Le numéro du contrat d'assurance</li>
    //                                                     <li>La date d'effet du contrat</li>
    //                                                     <li>La date d'échéance du contrat</li>
    //                                                     <li>La date du sinitre</li>
    //                                                     <li>La numéro de sinistre s'il est déjà déclaré</li>
    //                                                 </ul>
    //                                                 <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
    //                                                 Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
    //                                                 Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                 Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                 Bien cordialement,
    //                                                 ";
    //                                 $bodyMessage .= $signature;
    //                                 $destinataire = $_POST['emailGerant'];
    //                                 $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                             } else {
    //                                 if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
    //                                     $textManquant = "";
    //                                     $attachments[] = $fichierDelegation;
    //                                     $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                     Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                     Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
    //                                                     <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
    //                                                     Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
    //                                                     Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                     Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                     Bien cordialement,
    //                                                     ";
    //                                     $bodyMessage .= $signature;
    //                                     $destinataire = $_POST['emailGerant'];
    //                                     $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                 } else {
    //                                     if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
    //                                         $textManquant = "";
    //                                         $attachments[] = $fichierDelegation;
    //                                         $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                         Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                         Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
    //                                                       ...
    //                                                         <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
    //                                                         Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
    //                                                         Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                         Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                         Bien cordialement,
    //                                                         ";
    //                                         $bodyMessage .= $signature;
    //                                         $destinataire = $_POST['emailGerant'];
    //                                         $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                     } else {
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         if ($_POST['siSignDeleg'] == "non") {
    //                         } else {
    //                             if ($_POST['siSignDeleg'] == "oui") {
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if ($envoiDoc) {
    //                     $tabTo = explode(";", $destinataire);
    //                     foreach ($tabTo as $key => $value) {
    //                         if ($value != "") {
    //                             $role = new Role();
    //                             $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
    //                         }
    //                     }
    //                 }

    //                 $db->query("UPDATE wbccgroup_quest_campagne_hb_b2b SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
    //                 $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
    //                 $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
    //                 $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
    //                 $db->execute();
    //             }
    //         }
    //     }
    //     echo json_encode("1");
    // }

    // if ($action == "saveScriptPartielBatirymB2b") {
    //     extract($_POST);
        

    //     $_POST['editDate'] = date('Y-m-d H:i:s');
    //     foreach ($_POST as $key => $variable) {
    //         var_dump($key);
    //         var_dump($variable);
    //         $quest = findItemByColumn("wbccgroup_quest_campagne_batirym_b2b", "idCompanyGroupF ", $idCompanyGroup);

    //         if (isset($key) && str_contains($key, "concerne") && $variable != "") {
    //             $key = 'reponse_concerne';
    //         }
    //         if (isset($key) && $key == "causes") {
    //             $key = 'causes';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }


    //         if (isset($key) && $key == "dommages") {
    //             $key = 'dommages';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }

    //         $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wbccgroup_quest_campagne_batirym_b2b' AND COLUMN_NAME = '$key'");
    //         $res = $db->single()->nb;
    //         if ($res == 1) {
    //             if ($quest) {
    //                 $db->query("UPDATE wbccgroup_quest_campagne_batirym_b2b SET $key=:bind$key WHERE idCompanyGroupF = $idCompanyGroup");
    //             } else {
    //                 $db->query("INSERT INTO wbccgroup_quest_campagne_batirym_b2b($key,idCompanyGroupF) VALUES (:bind$key,$idCompanyGroup)");
    //             }

    //             $db->bind(":bind$key", $variable, null);
    //             $db->execute();
    //         }
    //     }
    //     //ENVOI MAIL & QUALIFICATION
    //     $response = false;
    //     if ($_POST['etapeSauvegarde'] == 'fin') {
    //         $bodyMessage = "";
    //         $destinataire = "";
    //         $subject = "";
    //         $signature  = $_POST['signatureMail'];
    //         $envoiDoc = false;
    //         $cc = [];
    //         $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
    //         $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
    //         // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
    //         //     if ($_POST['siEnvoiDoc'] == 'oui') {
    //         //         $envoiDoc = true;
    //         //         //MAIL ENVOI DOCUMENTATION  SIMPLE
    //         //         $bodyMessage = $_POST['bodyMessage'];
    //         //         $destinataire = $_POST['emailDestinataire'];
    //         //         $subject = $_POST['subject'];
    //         //     }
    //         // } else
    //         {
    //             // if ($_POST['siTravaux'] == 'oui') {
    //             //     $envoiDoc = true;
    //             //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //             //     $bodyMessage = $_POST['bodyMessage'];
    //             //     $destinataire = $_POST['emailDestinataire'];
    //             //     $subject = $_POST['subject'];
    //             // } else
    //             if (isset($_POST['siSignDeleg'])) {
    //                 if ($_POST['siSignDeleg'] == 'non') {
    //                     // if ($_POST['siEnvoiDoc'] == 'oui') {
    //                     //     $envoiDoc = true;
    //                     //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //                     //     $bodyMessage = $_POST['bodyMessage'];
    //                     //     $destinataire = $_POST['emailDestinataire'];
    //                     //     $subject = $_POST['subject'];
    //                     // }
    //                 } else {
    //                     if ($_POST['siSignDeleg'] == 'plusTard') {
    //                         $envoiDoc = true;
    //                         //generer delegation à joindre
    //                         $fichierDelegation = "";

    //                         //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
    //                         if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
    //                             $attachments[] = $fichierDelegation;
    //                             $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                             Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                             Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
    //                                             Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

    //                                             Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

    //                                             Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                             Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                             Bien cordialement,
    //                                             ";
    //                             $bodyMessage .= $signature;
    //                             $destinataire = $_POST['emailGerant'];
    //                             $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                         } else {
    //                             if ($_POST['raisonRefusSignature'] == 'documentManquant') {
    //                                 $textManquant = "";
    //                                 $attachments[] = $fichierDelegation;
    //                                 $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                 Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                 Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
    //                                                 <ul>
    //                                                     <li>Le nom de la compagnie d'assurance</li>
    //                                                     <li>Le numéro du contrat d'assurance</li>
    //                                                     <li>La date d'effet du contrat</li>
    //                                                     <li>La date d'échéance du contrat</li>
    //                                                     <li>La date du sinitre</li>
    //                                                     <li>La numéro de sinistre s'il est déjà déclaré</li>
    //                                                 </ul>
    //                                                 <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
    //                                                 Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
    //                                                 Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                 Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                 Bien cordialement,
    //                                                 ";
    //                                 $bodyMessage .= $signature;
    //                                 $destinataire = $_POST['emailGerant'];
    //                                 $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                             } else {
    //                                 if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
    //                                     $textManquant = "";
    //                                     $attachments[] = $fichierDelegation;
    //                                     $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                     Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                     Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
    //                                                     <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
    //                                                     Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
    //                                                     Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                     Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                     Bien cordialement,
    //                                                     ";
    //                                     $bodyMessage .= $signature;
    //                                     $destinataire = $_POST['emailGerant'];
    //                                     $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                 } else {
    //                                     if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
    //                                         $textManquant = "";
    //                                         $attachments[] = $fichierDelegation;
    //                                         $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                         Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                         Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
    //                                                       ...
    //                                                         <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
    //                                                         Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
    //                                                         Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                         Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                         Bien cordialement,
    //                                                         ";
    //                                         $bodyMessage .= $signature;
    //                                         $destinataire = $_POST['emailGerant'];
    //                                         $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                     } else {
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         if ($_POST['siSignDeleg'] == "non") {
    //                         } else {
    //                             if ($_POST['siSignDeleg'] == "oui") {
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if ($envoiDoc) {
    //                     $tabTo = explode(";", $destinataire);
    //                     foreach ($tabTo as $key => $value) {
    //                         if ($value != "") {
    //                             $role = new Role();
    //                             $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
    //                         }
    //                     }
    //                 }

    //                 $db->query("UPDATE wbccgroup_quest_campagne_batirym_b2b SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
    //                 $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
    //                 $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
    //                 $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
    //                 $db->execute();
    //             }
    //         }
    //     }
    //     echo json_encode("1");
    // }

    // if ($action == "saveScriptPartielCbB2c") {
    //     extract($_POST);
        

    //     $_POST['editDate'] = date('Y-m-d H:i:s');
    //     foreach ($_POST as $key => $variable) {
    //     var_dump($key);
    //     var_dump($variable);
    //         $quest = findItemByColumn("wbccgroup_quest_campagne_cb_b2c", "idCompanyGroupF ", $idCompanyGroup);

    //         if (isset($key) && str_contains($key, "concerne") && $variable != "") {
    //             $key = 'reponse_concerne';
    //         }
    //         if (isset($key) && $key == "causes") {
    //             $key = 'causes';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }


    //         if (isset($key) && $key == "dommages") {
    //             $key = 'dommages';
    //             $tab = explode(',', $variable);
    //             $variable = implode(";", $tab);
    //         }

    //         $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'wbccgroup_quest_campagne_cb_b2c' AND COLUMN_NAME = '$key'");
    //         $res = $db->single()->nb;
    //         if ($res == 1) {
    //             if ($quest) {
    //                 $db->query("UPDATE wbccgroup_quest_campagne_cb_b2c SET $key=:bind$key WHERE idCompanyGroupF = $idCompanyGroup");
    //             } else {
    //                 $db->query("INSERT INTO wbccgroup_quest_campagne_cb_b2c($key,idCompanyGroupF) VALUES (:bind$key,$idCompanyGroup)");
    //             }

    //             $db->bind(":bind$key", $variable, null);
    //             $db->execute();
    //         }
    //     }
    //     //ENVOI MAIL & QUALIFICATION
    //     $response = false;
    //     if ($_POST['etapeSauvegarde'] == 'fin') {
    //         $bodyMessage = "";
    //         $destinataire = "";
    //         $subject = "";
    //         $signature  = $_POST['signatureMail'];
    //         $envoiDoc = false;
    //         $cc = [];
    //         $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
    //         $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
    //         // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
    //         //     if ($_POST['siEnvoiDoc'] == 'oui') {
    //         //         $envoiDoc = true;
    //         //         //MAIL ENVOI DOCUMENTATION  SIMPLE
    //         //         $bodyMessage = $_POST['bodyMessage'];
    //         //         $destinataire = $_POST['emailDestinataire'];
    //         //         $subject = $_POST['subject'];
    //         //     }
    //         // } else
    //         {
    //             // if ($_POST['siTravaux'] == 'oui') {
    //             //     $envoiDoc = true;
    //             //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //             //     $bodyMessage = $_POST['bodyMessage'];
    //             //     $destinataire = $_POST['emailDestinataire'];
    //             //     $subject = $_POST['subject'];
    //             // } else
    //             if (isset($_POST['siSignDeleg'])) {
    //                 if ($_POST['siSignDeleg'] == 'non') {
    //                     // if ($_POST['siEnvoiDoc'] == 'oui') {
    //                     //     $envoiDoc = true;
    //                     //     //MAIL ENVOI DOCUMENTATION  SIMPLE
    //                     //     $bodyMessage = $_POST['bodyMessage'];
    //                     //     $destinataire = $_POST['emailDestinataire'];
    //                     //     $subject = $_POST['subject'];
    //                     // }
    //                 } else {
    //                     if ($_POST['siSignDeleg'] == 'plusTard') {
    //                         $envoiDoc = true;
    //                         //generer delegation à joindre
    //                         $fichierDelegation = "";

    //                         //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
    //                         if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
    //                             $attachments[] = $fichierDelegation;
    //                             $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                             Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                             Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
    //                                             Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

    //                                             Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

    //                                             Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                             Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                             Bien cordialement,
    //                                             ";
    //                             $bodyMessage .= $signature;
    //                             $destinataire = $_POST['emailGerant'];
    //                             $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                         } else {
    //                             if ($_POST['raisonRefusSignature'] == 'documentManquant') {
    //                                 $textManquant = "";
    //                                 $attachments[] = $fichierDelegation;
    //                                 $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                 Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                 Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
    //                                                 <ul>
    //                                                     <li>Le nom de la compagnie d'assurance</li>
    //                                                     <li>Le numéro du contrat d'assurance</li>
    //                                                     <li>La date d'effet du contrat</li>
    //                                                     <li>La date d'échéance du contrat</li>
    //                                                     <li>La date du sinitre</li>
    //                                                     <li>La numéro de sinistre s'il est déjà déclaré</li>
    //                                                 </ul>
    //                                                 <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
    //                                                 Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
    //                                                 Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                 Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                 Bien cordialement,
    //                                                 ";
    //                                 $bodyMessage .= $signature;
    //                                 $destinataire = $_POST['emailGerant'];
    //                                 $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                             } else {
    //                                 if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
    //                                     $textManquant = "";
    //                                     $attachments[] = $fichierDelegation;
    //                                     $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                     Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                     Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
    //                                                     <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
    //                                                     Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
    //                                                     Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                     Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                     Bien cordialement,
    //                                                     ";
    //                                     $bodyMessage .= $signature;
    //                                     $destinataire = $_POST['emailGerant'];
    //                                     $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                 } else {
    //                                     if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
    //                                         $textManquant = "";
    //                                         $attachments[] = $fichierDelegation;
    //                                         $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
    //                                                         Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
    //                                                         Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
    //                                                       ...
    //                                                         <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
    //                                                         Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
    //                                                         Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
    //                                                         Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
    //                                                         Bien cordialement,
    //                                                         ";
    //                                         $bodyMessage .= $signature;
    //                                         $destinataire = $_POST['emailGerant'];
    //                                         $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
    //                                     } else {
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         if ($_POST['siSignDeleg'] == "non") {
    //                         } else {
    //                             if ($_POST['siSignDeleg'] == "oui") {
    //                             }
    //                         }
    //                     }
    //                 }

    //                 if ($envoiDoc) {
    //                     $tabTo = explode(";", $destinataire);
    //                     foreach ($tabTo as $key => $value) {
    //                         if ($value != "") {
    //                             $role = new Role();
    //                             $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
    //                         }
    //                     }
    //                 }

    //                 $db->query("UPDATE wbccgroup_quest_campagne_cb_b2c SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
    //                 $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
    //                 $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
    //                 $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
    //                 $db->execute();
    //             }
    //         }
    //     }
    //     echo json_encode("1");
    // }

    if ($action == "saveScriptPartiel") {
            extract($_POST);
        $selectedTable = '';
    
        if($_POST['type'] =='batirym') {
            $selectedTable = 'wbccgroup_quest_campagne_batirym_b2b';
        } else if($_POST['type'] =='HbB2b') {
            $selectedTable = 'wbccgroup_quest_campagne_hb_b2b';
        } else if($_POST['type'] =='HbB2c') {
            $selectedTable = 'wbccgroup_quest_campagne_hb_b2c';
        } else if($_POST['type'] =='CbB2b') {
            $selectedTable = 'wbccgroup_quest_campagne_cb';
        } else if($_POST['type'] =='CbB2c') {
            $selectedTable = 'wbccgroup_quest_campagne_cb_b2c';
        } else if($_POST['type'] =='Prox') {
            $selectedTable = 'wbccgroup_quest_campagne_proxinistre';
        }

        $_POST['editDate'] = date('Y-m-d H:i:s');
        foreach ($_POST as $key => $variable) {
            $quest = findItemByColumn($selectedTable, "idCompanyGroupF", $idCompanyGroup);

            if (isset($key) && str_contains($key, "concerne") && $variable != "") {
                $key = 'reponse_concerne';
            }
            if (isset($key) && $key == "causes") {
                $key = 'causes';
                $tab = explode(',', $variable);
                $variable = implode(";", $tab);
            }

            if (isset($key) && $key == "dommages") {
                $key = 'dommages';
                $tab = explode(',', $variable);
                $variable = implode(";", $tab);
            }

            // FIXED: Proper parameterized query for column check
            $db->query("SELECT COUNT(*) as nb FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = :table 
                    AND COLUMN_NAME = :column");
            $db->bind(":table", $selectedTable);
            $db->bind(":column", $key);
            $res = $db->single()->nb;
            
            if ($res == 1) {
                if ($quest) {
                    $db->query("UPDATE `$selectedTable` SET `$key`=:bind$key WHERE idCompanyGroupF = :id");
                    $db->bind(":id", $idCompanyGroup);
                } else {
                    $db->query("INSERT INTO `$selectedTable` (`$key`, idCompanyGroupF) VALUES (:bind$key, :id)");
                    $db->bind(":id", $idCompanyGroup);
                }

                $db->bind(":bind$key", $variable, null);
                $db->execute();
            }
        }
        //ENVOI MAIL & QUALIFICATION
        $response = false;
        if ($_POST['etapeSauvegarde'] == 'fin') {
            $bodyMessage = "";
            $destinataire = "";
            $subject = "";
            $signature  = $_POST['signatureMail'];
            $envoiDoc = false;
            $cc = [];
            $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
            $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];
            // if ($_POST['reponse_concerne'] == 'non' || (isset($_POST['reponse_concerne2']) && $_POST['reponse_concerne2'] == "non")) {
            //     if ($_POST['siEnvoiDoc'] == 'oui') {
            //         $envoiDoc = true;
            //         //MAIL ENVOI DOCUMENTATION  SIMPLE
            //         $bodyMessage = $_POST['bodyMessage'];
            //         $destinataire = $_POST['emailDestinataire'];
            //         $subject = $_POST['subject'];
            //     }
            // } else
            {
                // if ($_POST['siTravaux'] == 'oui') {
                //     $envoiDoc = true;
                //     //MAIL ENVOI DOCUMENTATION  SIMPLE
                //     $bodyMessage = $_POST['bodyMessage'];
                //     $destinataire = $_POST['emailDestinataire'];
                //     $subject = $_POST['subject'];
                // } else
                if (isset($_POST['siSignDeleg'])) {
                    if ($_POST['siSignDeleg'] == 'non') {
                        // if ($_POST['siEnvoiDoc'] == 'oui') {
                        //     $envoiDoc = true;
                        //     //MAIL ENVOI DOCUMENTATION  SIMPLE
                        //     $bodyMessage = $_POST['bodyMessage'];
                        //     $destinataire = $_POST['emailDestinataire'];
                        //     $subject = $_POST['subject'];
                        // }
                    } else {
                        if ($_POST['siSignDeleg'] == 'plusTard') {
                            $envoiDoc = true;
                            //generer delegation à joindre
                            $fichierDelegation = "";

                            //TEST TOUS LES CAS MAIL A CHARGER SELON le CONTEXTE
                            if ($_POST['raisonRefusSignature'] == 'prendreConnnaissance') {
                                $attachments[] = $fichierDelegation;
                                $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
                                                Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
                                                Comme évoqué ensemble, veuillez recevoir un exemple de la délégation et notre plaquette.<br><br>
                                                Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>

                                                Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.

                                                Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
                                                Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
                                                Bien cordialement,
                                                ";
                                $bodyMessage .= $signature;
                                $destinataire = $_POST['emailGerant'];
                                $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
                            } else {
                                if ($_POST['raisonRefusSignature'] == 'documentManquant') {
                                    $textManquant = "";
                                    $attachments[] = $fichierDelegation;
                                    $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
                                                    Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
                                                    Comme évoqué ensemble, afin de finaliser votre délégation de gestion, quelques informations complémentaires sont nécessaires tels que : <br>
                                                    <ul>
                                                        <li>Le nom de la compagnie d'assurance</li>
                                                        <li>Le numéro du contrat d'assurance</li>
                                                        <li>La date d'effet du contrat</li>
                                                        <li>La date d'échéance du contrat</li>
                                                        <li>La date du sinitre</li>
                                                        <li>La numéro de sinistre s'il est déjà déclaré</li>
                                                    </ul>
                                                    <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
    
                                                    Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
    
                                                    Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
                                                    Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
                                                    Bien cordialement,
                                                    ";
                                    $bodyMessage .= $signature;
                                    $destinataire = $_POST['emailGerant'];
                                    $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
                                } else {
                                    if ($_POST['raisonRefusSignature'] == 'signatureComplique') {
                                        $textManquant = "";
                                        $attachments[] = $fichierDelegation;
                                        $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
                                                        Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
                                                        Comme évoqué ensemble, afin de finaliser votre délégation de gestion,text à compléter  : <br>
                                                      
                                                        <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
        
                                                        Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
        
                                                        Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
                                                        Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
                                                        Bien cordialement,
                                                        ";
                                        $bodyMessage .= $signature;
                                        $destinataire = $_POST['emailGerant'];
                                        $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
                                    } else {
                                        if ($_POST['raisonRefusSignature'] == 'prefereDemander') {
                                            $textManquant = "";
                                            $attachments[] = $fichierDelegation;
                                            $bodyMessage = "<p style='text-align:justify'>Bonjour " . $_POST['civiliteGerant'] . " " . $_POST['prenomGerant'] . " " . $_POST['nomGerant'] . ",<br><br><br>
                                                            Merci encore pour notre échange et votre confiance envers Proxinistre.<br><br>
                                                            Comme évoqué ensemble, afin de finaliser votre délégation de gestion, ci-joint notre plaquette et notre délégation ... <br>
                                                          ...
                                                            <br>Nous avons donc programmé un rendez-vous téléphonique avec moi-même, votre conseiller dédié.<br><br>
            
                                                            Lors de cet échange, je vous assisterai personnellement pour compléter et signer votre délégation, et répondre à toutes vos questions éventuelles.
            
                                                            Je reste à votre disposition pour toute assistance ou précision nécessaire d'ici là.
                                                            Au plaisir de vous accompagner très prochainement dans la prise en charge complète de votre sinistre.
                                                            Bien cordialement,
                                                            ";
                                            $bodyMessage .= $signature;
                                            $destinataire = $_POST['emailGerant'];
                                            $subject = "votre délégation Proxinistre – Rendez-vous téléphonique";
                                        } else {
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($_POST['siSignDeleg'] == "non") {
                            } else {
                                if ($_POST['siSignDeleg'] == "oui") {
                                }
                            }
                        }
                    }

                    if ($envoiDoc) {
                        $tabTo = explode(";", $destinataire);
                        foreach ($tabTo as $key => $value) {
                            if ($value != "") {
                                $role = new Role();
                                $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
                            }
                        }
                    }

                    $db->query("UPDATE '$selectedTable' SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
                    $db->bind("envoiDocumentation", $envoiDoc ? 1 : 0, null);
                    $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
                    $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
                    $db->execute();
                }
            }
        }
        echo json_encode("1");
    }

    if ($_GET['action'] == "saveScriptCompany") {
        extract($_POST);
        $compGroupModel = new CompanyGroup();
        $companyProspect = $compGroupModel->findById($idCompanyGroup);
        $connectedUser = json_decode($connectedUser);

        if ($siTravaux == 'non') {
            //Create Company
            $compModel = new Company();
            $assurance = null;
            $company = findItemByValue("wbcc_company", "name", $companyProspect->name);
            if ($company) {
            } else {
                $idCompany = $compModel->addCompany2(
                    $numeroCompany,
                    $companyProspect->name,
                    $companyProspect->enseigne,
                    $companyProspect->businessPhone,
                    $companyProspect->email,
                    $companyProspect->webaddress,
                    $companyProspect->categorieDO,
                    $companyProspect->businessLine1,
                    $companyProspect->businessPostalCode,
                    $companyProspect->businessState,
                    $companyProspect->region,
                    $companyProspect->businessCity,
                    $companyProspect->businessCountryName,
                    $companyProspect->numeroRCS,
                    $companyProspect->villeRCS,
                    $companyProspect->numeroSiret,
                    $companyProspect->siccode,
                    $companyProspect->industry,
                    $companyProspect->numEmployees,
                    $companyProspect->categorieDO,
                    $companyProspect->sousCategorieDO
                );


                $company = $compModel->findById($idCompany);
            }
            $contactModel = new Contact();
            $gerant = null;
            $interlocuteur = null;
            if ($responsable == 'oui') {
                $db->query("SELECT * FROM wbcc_contact WHERE lower(prenomContact)=lower(:prenom) AND lower(nomContact)=lower(:nom) AND telContact=:tel");
                $db->bind(":nom", $nomGerant, null);
                $db->bind(":prenom", $prenomGerant, null);
                $db->bind(":tel", $telGerant, null);
                $gerant = $db->single();
                if ($gerant) {
                    //$contactModel->update();
                } else {
                    $gerant = $contactModel->save("0", $civiliteGerant, $prenomGerant, $nomGerant, $telGerant, $emailGerant,  $dateNaissanceGerant, "", "", $posteGerant, "1", "Campagne Vocalcom", "", $company->idCompany, "", "", "");
                }
            }
            if ($prenomInterlocuteur != "" || $nomInterlocuteur != "" || $telInterlocuteur != "" || $emailInterlocuteur != "" || $posteInterlocuteur != "") {
                $db->query("SELECT * FROM wbcc_contact WHERE lower(prenomContact)=lower(:prenom) AND lower(nomContact)=lower(:nom) AND telContact=:tel");
                $db->bind(":nom", $nomInterlocuteur, null);
                $db->bind(":prenom", $prenomInterlocuteur, null);
                $db->bind(":tel", $telInterlocuteur, null);
                $interlocuteur = $db->single();
                if ($interlocuteur) {
                    // $contactModel->update();
                } else {
                    $interlocuteur = $contactModel->save("0", $civiliteInterlocuteur, $prenomInterlocuteur, $nomInterlocuteur, $telInterlocuteur, $emailInterlocuteur,  "", "", "", $posteInterlocuteur, "1", "Campagne Vocalcom", "", $company->idCompany, "", "", "");
                }
            }

            //Create Immeuble
            if ($idImmeuble == "0") {
                $immeubleModel = new Immeuble();
                $immeuble = $immeubleModel->findImmeubleByAdresse($adresse);
                if ($immeuble) {
                    $idImmeuble = $immeuble->idImmeuble;
                } else {
                    $idImmeuble = $immeubleModel->addImmeuble("IMM", "", $adresse, $cp, $ville, "", "", "", "", "", "", "");
                }
            }
            if ($idApp == "0") {
                //Insert AP
                $lotModel = new Lot();
                $idApp = $lotModel->addLot("", "", $adresse, $cp, $ville, "", "", $lot, $batiment, $etage, $porte, "", $idImmeuble);
            }


            //Si concerné, travaux non effc
            if ($type_sinistre != "" && $siTravaux == "non" && $idOP == "0") {

                $opModel = new Opportunity();
                $db->query("SELECT * FROM wbcc_parametres LIMIT 1");
                $param = $db->single();
                $numero = str_pad(($param->numeroOP + 1), 4, '0', STR_PAD_LEFT);
                $name = "OP" . date("Y-m-d") . "-$numero";
                $idOP = $opModel->addOpportunity($name, $name, "", "Sinistres", "Partie privative exclusive", '0', "", $type_sinistre, '', $commentaireSinistre, '');

                $idCompanyAss = 0;
                if ($idOP != "0") {
                    $db->query("UPDATE wbcc_parametres SET numeroOP=$param->numeroOP + 1");
                    $db->execute();
                    //save op-immeuble
                    if ($idImmeuble != "0") {
                        $db->query("UPDATE wbcc_opportunity SET dateSinistre=:date, idImmeuble=$idImmeuble WHERE idOpportunity=$idOP");
                        $db->bind(":date", $dateSinistre == "" ? $dateApproximative : '');
                        $db->execute();
                        $db->query("INSERT INTO wbcc_opportunity_immeuble(idImmeubleF,idOpportunityF) VALUES ($idImmeuble,$idOP)");
                        $db->execute();
                    }

                    //save op-app
                    if ($idLot != "0") {
                        //MAJ Infos Assurance Num Police & infos
                        $db->query("UPDATE wbcc_appartement SET dateDebutContrat=:dateDebut,dateFinContrat=:dateFin WHERE idApp=$idLot");
                        $db->bind(":dateDebut", $dateDebutContrat);
                        $db->bind(":dateFin", $dateFinContrat);
                        $db->execute();

                        $db->query("UPDATE wbcc_opportunity SET idAppartement=$idLot WHERE idOpportunity=$idOP");
                        $db->execute();
                        $db->query("INSERT INTO wbcc_opportunity_appartement(idAppartementF,idOpportunityF) VALUES ($idLot,$idOP)");
                        $db->execute();
                    }

                    //save op-contact-gerant
                    if ($gerant != null) {
                        $db->query("INSERT INTO wbcc_contact_opportunity(idContactF,idOpportunityF) VALUES ($gerant->idContact ,$idOP)");
                        $db->execute();

                        $db->query("UPDATE wbcc_opportunity SET idContactClient=$gerant->idContact AND nomDO =:nomDO WHERE idOpportunity=$idOP");
                        $db->bind(":nomDO", $gerant->prenomContact . ' ' . $gerant->nomContact);
                        $db->execute();
                    }

                    //save op-contact-interlocuteur
                    if ($interlocuteur != null) {
                        $db->query("INSERT INTO wbcc_contact_opportunity(idContactF,idOpportunityF) VALUES ($interlocuteur->idContact ,$idOP)");
                        $db->execute();
                    }

                    //save company-opportunity
                    if ($idCie != null && $idCie != '0' && $idCie != "") {

                        $db->query("INSERT INTO wbcc_company_opportunity(idCompanyF,idOpportunityF) VALUES ($idCie,$idOP)");
                        $db->execute();
                        //MAJ idCompany
                        $db->query("UPDATE wbcc_opportunity SET idComMRHF=$idCie,denominationComMRH=:name,policeMRH=:numPolice,sinistreMRH=:numSinistre WHERE idOpportunity=$idOP");
                        $db->bind(":numPolice", $numPolice);
                        $db->bind(":numSinistre", $numSinistre);
                        $db->bind(":name", $nomCieAssurance);

                        $db->execute();
                    }


                    $db->query("INSERT INTO wbcc_company_opportunity(idCompanyF,idOpportunityF) VALUES ($company->idCompany,$idOP)");
                    $db->execute();

                    if ($siSignDeleg == 'non') {
                        //Creer tache signature delegation
                        //CREATE ACTIVITY
                        $dateStartActivity = new DateTime();
                        $dateEndActivity = ($dateStartActivity->modify("+2 days"))->format('Y-m-d H:i:s');

                        createNewActivity($opInsert->idOpportunity, $opInsert->name, $idUser, "$auteur", "", $opInsert->name . "-Faire signer la délégation de gestion", "", date("Y-m-d H:i:s"), $dateEndActivity, "Tâche à faire", "False", 0, 1);
                        createNewActivity($opInsert->idOpportunity, $opInsert->name, 518, "Compte WBCC", "5770501a-425d-4f50-b66a-016c2dbb2557", $opInsert->name . "-Faire la Télé-Expertise", "", date("Y-m-d H:i:s"), $dateEndActivity, "Tâche à faire", "False", 0, 2);
                        createNewActivity($opInsert->idOpportunity, $opInsert->name, $idUser, "$auteur", "", $opInsert->name . "-Programmer le RT", "", date("Y-m-d H:i:s"), $dateEndActivity, "Tâche à faire", "False", 0, 3);

                        $db->query("INSERT INTO `wbcc_historique`(`action`, `nomComplet`, `dateAction`,  `idUtilisateurF`, idOpportunityF) VALUES (:action, :nomComplet, :dateAction, :idUtilisateurF, :idOpportunityF)");
                        $db->bind("action",  "Création de l'opportunité : $opInsert->name", null);
                        $db->bind("nomComplet", $auteur, null);
                        $db->bind("idUtilisateurF", (isset($user) ? $user['idUtilisateur'] : null), null);
                        $db->bind("dateAction", date("Y-m-d H:i:s"), null);
                        $db->bind("idOpportunityF", $opInsert->idOpportunity, null);
                        $db->execute();
                    }

                    if ($dispoRT) {
                        $numeroRT = 'RT' . date("dmYHis") . $idUser;
                        $db->query("INSERT INTO wbcc_releve_technique (numeroRT, numeroOP, nature, date, numeroBatiment, adresse, codePostal, ville, codePorte, precisionComplementaire, autrePrecisionDegat, niveauEtage, partieConcernee, idOpportunityF,idAppContactF,createDate, editDate) VALUES (:numeroRT, :numeroOP, :nature,:date1, :numeroBatiment, :adresse, :codePostal, :ville, :codePorte, :precisionComplementaire, :precisionDegat, :niveauEtage, :partieConcernee, :idOpportunityF,:idAppContactF,:createDate, :editDate)");
                        $db->bind("numeroRT", $numeroRT, null);
                        $db->bind("numeroOP", $opInsert->name, null);
                        $db->bind("nature", $natureSinistre, null);
                        $db->bind("date1", convertDateMysqlFormat($dateConstatSinistre), null);
                        $db->bind("numeroBatiment", $batiment, null);
                        $db->bind("adresse", $adresse, null);
                        $db->bind("codePostal", $codePostal, null);
                        $db->bind("ville", $ville, null);
                        $db->bind("codePorte", $porte, null);
                        $db->bind("precisionComplementaire", $commentaire, null);
                        $db->bind("precisionDegat", $degat, null);
                        $db->bind("niveauEtage", $etage, null);
                        $db->bind("partieConcernee", "Privative", null);
                        $db->bind("idOpportunityF", $idOP, null);
                        $db->bind("idAppContactF", "", null);
                        $db->bind("createDate", date("Y-m-d H:i:s"), null);
                        $db->bind("editDate", date("Y-m-d H:i:s"), null);
                        if ($db->execute()) {
                            echo json_encode($opInsert);
                        }
                    }
                }
            }
        }
    }

    if ($_GET['action'] == 'envoiDocumentation') {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);

        $attachments = ["crm/PLAQUETTE_PROXINISTRE.pdf"];
        $filenames = ["PLAQUETTE_PROXINISTRE.pdf"];

        $role = new Role();
        if ($to != "") {
            $tabTo = explode(";", $to);
            $cc = [];
            $response = false;
            foreach ($tabTo as $key => $value) {
                if ($value != "") {
                    $response = $role::mailProxinistreWithFiles($value, $subject, $bodyMessage, $cc, $attachments, $filenames);
                }
            }
            if ($response) {
                $quest = findItemByColumn("wbccgroup_quest_b2b", "idCompanyGroupF ", $idCompanyGroup);
                if ($quest) {
                    $db->query("UPDATE wbccgroup_quest_b2b SET envoiDocumentation=:envoiDocumentation, dateEnvoiDocumentation=:dateEnvoiDocumentation, idAuteurEnvoiDocumentation=:idAuteurEnvoiDocumentation WHERE idCompanyGroupF = $idCompanyGroup");
                } else {
                    $db->query("INSERT INTO wbccgroup_quest_b2b(idCompanyGroupF, envoiDocumentation, idAuteurEnvoiDocumentation, dateEnvoiDocumentation ) VALUES($idCompanyGroup, :envoiDocumentation, :idAuteurEnvoiDocumentation, :dateEnvoiDocumentation)");
                }
                $db->bind("envoiDocumentation", 1, null);
                $db->bind("idAuteurEnvoiDocumentation", $idAuteur, null);
                $db->bind("dateEnvoiDocumentation", date('Y-m-d H:i:s'), null);
                $db->execute();
                echo json_encode($response);
            } else {
                echo json_encode("0");
            }
        } else {
            echo json_encode("0");
        }
    }

    if ($_GET['action'] == '') {
        $tabFiles[] = "/public/documents/campagnes/";
        $fileNames[] = 'nomFichieer';
        $cc = [];

        $body = "Bonjour prenomInter nomInter , <br><br>
                    Veuillez recevoir en PJ le document";

        $r = new Role();
        if ($emailInterlocuteur != "") {
            if ($r::mailExtranetWithFiles($emailInterlocuteur, "CAMPAGNE SINISTRE :  ", $body, $cc, $tabFiles, $fileNames)) {
            }
        }
    }

    if ($_GET['action'] == "liste") {
        // Étape 1: Récupérer les entreprises avec qualification = 1
        $db->query("SELECT * FROM wbccgroup_company cp WHERE  cp.qualification = 1");
        $companies = $db->resultSet();

        if (empty($companies)) {
            echo json_encode("0");
        } else {
            $result = [];

            // Étape 2: Pour chaque entreprise, vérifier si elle a des campagnes associées
            foreach ($companies as $company) {
                $idCompany = $company->idCompany; // Utiliser la notation d'objet

                // Vérifier si l'entreprise a des campagnes dans wbccgroup_company_campagne
                $db->query("SELECT COUNT(*) as count FROM wbccgroup_company_campagne WHERE idCompanyF = :idCompanyF");
                $db->bind(':idCompanyF', $idCompany);
                $db->execute();
                $countResult = $db->single();

                // Si des campagnes existent, récupérer les campagnes associées
                if ($countResult->count > 0) {
                    $db->query("SELECT c.*, v.* FROM wbccgroup_company_campagne c 
                                JOIN wbcc_campagne_vocalcom v ON c.idCampagneVocalcomF = v.idCampagneVocalcom 
                                WHERE c.idCompanyF = :idCompanyF");
                    $db->bind(':idCompanyF', $idCompany);
                    $campagnes = $db->resultSet();

                    // Récupérer les contacts associés à l'entreprise
                    $db->query("SELECT co.* FROM wbccgroup_company_contact cc 
                                JOIN wbccgroup_contact co ON cc.idContactF = co.idContact 
                                WHERE cc.idCompanyF = :idCompanyF");
                    $db->bind(':idCompanyF', $idCompany);
                    $contacts = $db->resultSet();

                    // Ajouter les données de l'entreprise avec ses campagnes et contacts
                    $companyData = json_decode(json_encode($company), true); // Convertir l'objet en tableau
                    $companyData['campagnes'] = $campagnes;
                    $companyData['contacts'] = $contacts;

                    $result[] = $companyData;
                }
            }

            echo json_encode($result);
        }
    }
}
