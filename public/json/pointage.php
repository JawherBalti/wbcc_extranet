<?php
header('Access-Control-Allow-Origin: *');
require_once "../../app/config/config.php";
require_once "../../app/libraries/Database.php";
require_once "../../app/libraries/SMTP.php";
require_once "../../app/libraries/PHPMailer.php";
require_once "../../app/libraries/Role.php";
require_once "../../app/libraries/Utils.php";

if (isset($_GET['action'])) {
    $db = new Database();
    $action = $_GET['action'];

    if ($action == "getPointagePersonnel") {
        $date = "";
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $newDate = new DateTime($_GET['date']);
            $date = $newDate->format("Y-m-d");
        } else {
            $date =  date("Y-m-d");
        }
        $mois = substr($date, 0, 7);
        $annee = substr($date, 0, 4);
        $moisEnLettre = my_dateEnFrancais($date, 'm');

        $db->query("SELECT * FROM  wbcc_contact, wbcc_utilisateur, wbcc_roles WHERE idContact=idContactF AND role=idRole AND (libelleRole='Commercial' OR isCommercial = 1) AND etatUser=1");
        $datas = $db->resultSet();
        $nbVisitesTJ = 0;
        $nbSinistresObtenusTJ = 0;
        $nbAbsencesJ = 0;
        $nbRetardsJ = 0;
        $datasJ = [];
        $datasM = [];
        $nbVisitesTM = 0;
        $nbSinistresObtenusTM = 0;
        $nbAbsencesM = 0;
        $nbRetardsM = 0;
        $datasA = [];
        $nbVisitesTA = 0;
        $nbSinistresObtenusTA = 0;
        $nbAbsencesA = 0;
        $nbRetardsA = 0;
        foreach ($datas as $key => $user) {
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage = :date  LIMIT 1");
            $db->bind("date", $date, null);
            $pointage = $db->single();
            $absent = "Oui";
            $retard = "-";
            $minRetard = "-";
            $adresseProgramme = "-";
            $adressePointage = "-";
            $anomalie = "-";
            $heureDebut = "-";
            $heureFin = "-";
            $resultatTraite = "";
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$date%' ");
            $nbVisites =  sizeof($db->resultSet());
            $nbVisitesTJ +=  $nbVisites;
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$date%' AND resultatVisite='4' ");
            $nbSinistresObtenus = sizeof($db->resultSet());
            $nbSinistresObtenusTJ +=  $nbSinistresObtenus;
            if ($pointage) {

                $absent = $pointage->absent == "1" ? "Oui" : "Non";
                if ($pointage->absent == "0") {
                    $resultatTraite = $pointage->resultatTraite;
                    $retard = $pointage->retard == "1" ? "Oui" : "Non";
                    if ($retard == "Oui") {
                        $nbRetardsJ += 1;
                    }
                    $minRetard = $pointage->nbMinuteRetard < 60 ? $pointage->nbMinuteRetard : floor($pointage->nbMinuteRetard / 60) . " H " . ($pointage->nbMinuteRetard % 60) . " min";
                    $adresseProgramme =  $pointage->adresseProgramme;
                    $adressePointage =  $pointage->adressePointage;
                    $anomalie = $pointage->anomalieDebutJour == "1" ? "Oui" : "Non";
                    $heureDebut = $pointage->heureDebutPointage;
                    $heureFin = $pointage->heureFinPointage;
                } else {
                    $resultatTraite = "Absent";
                    $nbAbsencesJ += 1;
                }
            } else {
                $resultatTraite = "Pointage Non effectué";
                $nbAbsencesJ += 1;
            }
            $user->resultatTraite = $resultatTraite;
            $user->absent = $absent;
            $user->retard = $retard;
            $user->minRetard = $minRetard;
            $user->adresseProgramme = $adresseProgramme;
            $user->adressePointage = $adressePointage;
            $user->anomalie = $anomalie;
            $user->heureDebut = $heureDebut;
            $user->heureFin = $heureFin;
            $user->nbVisites = $nbVisites;
            $user->nbSinistresObtenus = $nbSinistresObtenus;
            $datasJ[] = $user;
            //Mensuel
            $obj = new stdClass();
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$mois%' ");
            $nbVisitesM =  sizeof($db->resultSet());
            $nbVisitesTM +=  $nbVisitesM;
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$mois%' AND resultatVisite='4' ");
            $nbSinistresObtenusM = sizeof($db->resultSet());
            $nbSinistresObtenusTM +=  $nbSinistresObtenusM;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$mois%' AND absent=1 ");
            $absentM = sizeof($db->resultSet());
            $nbAbsencesM +=  $absentM;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$mois%' AND retard=1 ");
            $retardM = sizeof($db->resultSet());
            $nbRetardsM +=  $retardM;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$mois%' AND anomalieDebutJour=1 ");
            $anomalieM = sizeof($db->resultSet());
            $db->query("SELECT SUM(nbMinuteRetard) as nbMin FROM `wbcc_pointage` WHERE idUserF = $user->idUtilisateur AND retard=1 AND datePointage LIKE '%$mois%' ");
            $res = $db->single();
            $minRetardM = '-';
            if ($res) {
                $minRetardM = $res->nbMin < 60 ? $res->nbMin : floor($res->nbMin / 60) . " H " . ($res->nbMin % 60) . " min";
            }
            $obj->fullName = $user->fullName;
            $obj->emailContact = $user->emailContact;
            $obj->telContact = $user->telContact;
            $obj->nbVisites = $nbVisitesM;
            $obj->nbSinistresObtenus = $nbSinistresObtenusM;
            $obj->absent = $absentM;
            $obj->retard = $retardM;
            $obj->anomalie = $anomalieM;
            $obj->minRetard = $minRetardM;
            $datasM[] = $obj;


            //ANNUEL
            $obj = new stdClass();
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$annee%' ");
            $nbVisitesA =  sizeof($db->resultSet());
            $nbVisitesTA +=  $nbVisitesA;
            $db->query("SELECT * FROM  wbcc_pap_b2c  WHERE idUserF=$user->idUtilisateur AND visiteEffectuee=1 AND dateVisite LIKE '%$annee%' AND resultatVisite='4' ");
            $nbSinistresObtenusA = sizeof($db->resultSet());
            $nbSinistresObtenusTA +=  $nbSinistresObtenusA;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$annee%' AND absent=1 ");
            $absentA = sizeof($db->resultSet());
            $nbAbsencesA +=  $absentA;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$annee%' AND retard=1 ");
            $retardA = sizeof($db->resultSet());
            $nbRetardsA +=  $retardA;
            $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage LIKE '%$annee%' AND anomalieDebutJour=1 ");
            $anomalieA = sizeof($db->resultSet());
            $db->query("SELECT SUM(nbMinuteRetard) as nbMin FROM `wbcc_pointage` WHERE idUserF = $user->idUtilisateur AND retard=1 AND datePointage LIKE '%$annee%' ");
            $res = $db->single();
            $minRetardA = '-';
            if ($res) {
                $minRetardA = $res->nbMin < 60 ? $res->nbMin : floor($res->nbMin / 60) . " H " . ($res->nbMin % 60) . " min";
            }
            $obj->fullName = $user->fullName;
            $obj->emailContact = $user->emailContact;
            $obj->telContact = $user->telContact;
            $obj->nbVisites = $nbVisitesA;
            $obj->nbSinistresObtenus = $nbSinistresObtenusA;
            $obj->absent = $absentA;
            $obj->retard = $retardA;
            $obj->anomalie = $anomalieA;
            $obj->minRetard = $minRetardA;
            $datasA[] = $obj;
        }

        $result = [
            "usersJ" => $datasJ,
            "nbVisitesJ" => $nbVisitesTJ,
            "nbSinistresObtenusJ" => $nbSinistresObtenusTJ,
            "nbAbsencesJ" => $nbAbsencesJ,
            "nbRetardsJ" => $nbRetardsJ,
            "usersM" => $datasM,
            "nbVisitesM" => $nbVisitesTM,
            "nbSinistresObtenusM" => $nbSinistresObtenusTM,
            "nbAbsencesM" => $nbAbsencesM,
            "nbRetardsM" => $nbRetardsM,
            "usersA" => $datasA,
            "nbVisitesA" => $nbVisitesTA,
            "nbSinistresObtenusA" => $nbSinistresObtenusTA,
            "nbAbsencesA" => $nbAbsencesA,
            "nbRetardsA" => $nbRetardsA,
            "mois" => $moisEnLettre
        ];
        echo json_encode($result);
    }

    //CRON FOR ABSENCE PAP AND RAPPORT
    if ($action == "getAbsenceAndGenerateRapport") {
        $db->query("SELECT * FROM  wbcc_contact, wbcc_utilisateur, wbcc_roles WHERE idContact=idContactF AND role=idRole AND (isPointageInterne=1 OR isPointageExterne = 1) AND etatUser=1");
        $datas = $db->resultSet();
        foreach ($datas as $key => $user) {
            $date = date("Y-m-d");
            // $date = date("2024-05-10");
            //SEARCH IF WORK DAY
            $jour = my_dateEnFrancais($date, 'd');
            $jours = $user->jourTravailB2C != null && $user->jourTravailB2C != "" ? explode(';', trim($user->jourTravailB2C)) : [];
            $index = array_search(ucfirst($jour), $jours);
            if ($index >= 0) {
                //SEARCH IF COMMERCIAL POINTED
                $db->query("SELECT * FROM wbcc_pointage WHERE  idUserF= $user->idUtilisateur AND datePointage = :date  LIMIT 1");
                $db->bind("date", $date, null);
                $pointage = $db->single();
                if ($pointage) {
                } else {
                    //INSERT RETARD
                    $numero =  'PNT' . date("dmYHis") . "$user->idUtilisateur$key";
                    $db->query("INSERT INTO wbcc_pointage(numeroPointage, datePointage,absent, traite, idUserF, auteur) VALUE(:numeroPointage, :datePointage, :absent,:traite, :idUser, :auteur)");
                    $db->bind("numeroPointage", $numero, null);
                    $db->bind("datePointage", $date, null);
                    $db->bind("absent", 1, null);
                    $db->bind("traite", 1, null);
                    $db->bind("idUser", $user->idUtilisateur, null);
                    $db->bind("auteur", $user->fullName, null);
                    $db->execute();
                }
            }
        }

        echo json_encode("1");
    }

    if ($action == "findPointageByDate") {
        $date = $_GET['date'];
        $idUser = $_GET['idUser'];
        $db->query("SELECT * FROM wbcc_pointage WHERE datePointage = :date AND idUserF=:idUser LIMIT 1");
        $db->bind("date", $date, null);
        $db->bind("idUser", $idUser, null);
        $data = $db->single();
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("0");
        }
    }

    if ($action == "getPointageRetardNonTraite") {
        $date = $_GET['date'];
        $db->query("SELECT * FROM wbcc_pointage, wbcc_contact, wbcc_utilisateur WHERE idContact=idContactF AND idUtilisateur=idUserF AND datePointage = :date AND traite=0 AND isPointageExterne  = 1 LIMIT 1");
        $db->bind("date", $date, null);
        $data = $db->single();
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode("0");
        }
    }

    if ($action == "savePointage") {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $numero =  'PNT' . date("dmYHis") . $idUser;
        $user = findItemByValue("wbcc_utilisateur", "idUtilisateur", $idUser);
        //GET JOUR
        $jour = explode(' ', trim($textDate))[0];
        $jours = explode(';', trim($user->jourTravailB2C));
        $heures = explode(';', trim($user->horaireTravailB2C));
        $index = array_search(ucfirst($jour), $jours);
        $heureDebut = isset($heures[$index]) ? explode('-', $heures[$index])[0] : $heurePointage;
        $anomalie = 0;
        if ($adresseEnregistre != "" && $adresseEnregistre != null) {
            if ($adresseEnregistre != $adresseProgrammee) {
                //SEARCH IF PROXIMITE
                $anomalie = 1;
            }
        } else {
            $anomalie = 1;
        }
        //CALCUL NB MINUTES RETARD
        $nbMinuteRetard = strtotime($datePointage .  ' ' . $heurePointage) - strtotime($datePointage .  ' ' . $heureDebut) - ($user->margeTravailB2C == '' || $user->margeTravailB2C == null ? 0 : $user->margeTravailB2C);
        $db->query("INSERT INTO wbcc_pointage(numeroPointage, datePointage, heureDebutPointage, adressePointage, heureDebutJour, marge,adresseProgramme, nbMinuteRetard, retard, absent, anomalieDebutJour, idUserF, auteur) VALUE(:numeroPointage, :datePointage, :heureDebutPointage, :adressePointage, :heureDebutJour, :marge, :adresseProgramme, :nbMinuteRetard, :retard, :absent, :anomalieDebutJour, :idUser, :auteur)");
        $db->bind("numeroPointage", $numero, null);
        $db->bind("datePointage", $datePointage, null);
        $db->bind("heureDebutPointage", $heurePointage, null);
        $db->bind("adressePointage", $adresseEnregistre, null);
        $db->bind("heureDebutJour", $heureDebut, null);
        $db->bind("marge", $user->margeTravailB2C, null);
        $db->bind("adresseProgramme", $adresseProgrammee, null);
        $db->bind("nbMinuteRetard", $nbMinuteRetard / 60 < 0 ? 0 : $nbMinuteRetard / 60, null);
        $db->bind("retard", $nbMinuteRetard > 0 ? 1 : 0, null);
        $db->bind("absent", 0, null);
        $db->bind("anomalieDebutJour", $anomalie, null);
        $db->bind("idUser", $idUser, null);
        $db->bind("auteur", $auteur, null);

        if ($db->execute()) {
            echo json_encode(findItemByValue("wbcc_pointage", "numeroPointage", $numero));
        } else {
            echo json_encode("0");
        }
    }

    if ($action == "saveCommentaireRetard") {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $id = $pointage['idPointage'];
        $db->query("UPDATE wbcc_pointage SET motifRetard=:commentaire WHERE idPointage=:id");
        $db->bind("commentaire", $commentaireRetard, null);
        $db->bind("id", $id, null);
        if ($db->execute()) {
            echo json_encode(findItemByValue("wbcc_pointage", "idPointage", $id));
        } else {
            echo json_encode("0");
        }
    }

    if ($action == "saveRetardTraite") {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $id = $pointage['idPointage'];
        $db->query("UPDATE wbcc_pointage SET retard=:retard,  traite=1, idTraiteF=:idTraiteF, auteurTraite=:auteurTraite, dateTraite=:dateTraite, resultatTraite=:resultatTraite   WHERE idPointage=:id");
        $db->bind("id", $id, null);
        $db->bind("retard", isset($etatRetard) ? $etatRetard : "0", null);
        $db->bind("idTraiteF", $user['idUtilisateur'], null);
        $db->bind("auteurTraite",  $user['fullName'], null);
        $db->bind("dateTraite", date("Y-m-d H:i:s"), null);
        $db->bind("resultatTraite", (isset($etatRetard) ? ($etatRetard == "0" ? "Retard Accepté" : "Retard Refusé") : "Retard accepté"), null);
        if ($db->execute()) {
            echo json_encode(findItemByValue("wbcc_pointage", "idPointage", $id));
        } else {
            echo json_encode("0");
        }
    }

    if ($action == "refuserRetard") {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $id = $pointage['idPointage'];
        $db->query("UPDATE wbcc_pointage SET retard=1, traite=1 WHERE idPointage=:id");
        $db->bind("id", $id, null);
        if ($db->execute()) {
            echo json_encode(findItemByValue("wbcc_pointage", "idPointage", $id));
        } else {
            echo json_encode("0");
        }
    }


    //DEBUT NABILA
    {


        if ($action == 'getPointageById') {
            if (isset($_POST['idPointage'])) {
                $idPointage = $_POST['idPointage'];

                // Step 1: Query to get the specific pointage details
                $db->query("SELECT wp.*, c.fullName, u.matricule, u.email, s.nomSite 
                            FROM wbcc_pointage wp
                            JOIN wbcc_utilisateur u ON wp.idUserF = u.idUtilisateur
                            LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
                            LEFT JOIN wbcc_site s ON s.idSite = u.idSiteF
                            WHERE wp.idPointage = :idPointage");

                // Bind the pointage ID
                $db->bind(":idPointage", $idPointage);

                // Fetch the pointage data
                $pointageData = $db->single();

                if ($pointageData) {
                    // Step 2: Query to get all associated urlDocument entries for the given idPointage
                    $db->query("SELECT wbp.urlDocument, wbp.nomDocument, wdp.isArrive, wbp.commentaire
                                FROM wbcc_document_pointage wdp
                                JOIN wbcc_document wbp ON wdp.idDocumentF = wbp.idDocument
                                WHERE wdp.idPointageF = :idPointage");

                    // Bind the pointage ID again for the second query
                    $db->bind(":idPointage", $idPointage);

                    // Fetch all associated urlDocument entries
                    $documents = $db->resultSet();

                    // Extract urlDocument values into a list
                    $documentList = array_map(function ($doc) {
                        return [
                            'nomDocument' => $doc->nomDocument,
                            'urlDocument' => $doc->urlDocument,
                            'isArrive' => $doc->isArrive,
                            'commentaire' => $doc->commentaire
                        ]; // Access property directly since $doc is an object
                    }, $documents);

                    // Step 3: Add the urlDocuments list to the pointage data
                    $pointageData->documents = $documentList;

                    // Step 4: Return the complete response with pointage data and the list of urlDocuments
                    echo json_encode($pointageData);
                } else {
                    // Return an error message if no pointage data is found
                    echo json_encode("0");
                }
            } else {
                echo json_encode("0");
            }
        }


        if ($action == 'getAllPointages') {
            // Retrieve the user ID from POST or GET
            $idUser = $_POST['userId'] ?? $_GET['userId'] ?? null;

            if ($idUser === null) {
                echo json_encode(['error' => 'User ID is required.']);
                exit;
            }

            // Admin check query to filter by site if needed
            $sqlAdminCheck = "
                SELECT u.idSiteF, u.isAdmin, u.role, s.adresseSite 
                FROM wbcc_utilisateur u 
                LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
                WHERE u.idUtilisateur = :userId";

            $db->query($sqlAdminCheck);
            $db->bind(':userId', $idUser);
            $adminData = $db->single();

            if ($adminData && ($adminData->role == 25 || $adminData->role == 1 || $adminData->role == 2)) {
                // If admin, filter by site
                $nomSite = $adminData->adresseSite;
                $sql = "
                    SELECT P.*, c.fullName, u.matricule, u.jourTravail, u.horaireTravail 
                    FROM wbcc_pointage P 
                    JOIN wbcc_utilisateur u ON P.idUserF = u.idUtilisateur 
                    LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF 
                    WHERE P.adresseProgramme LIKE :nomSite
                    ORDER BY P.datePointage DESC";

                $db->query($sql);
                $db->bind(':nomSite', '%' . $nomSite . '%');
            } else {
                // Non-admin query without filtering by site
                $db->query("
                    SELECT P.*, c.fullName, u.matricule, u.jourTravail, u.horaireTravail 
                    FROM wbcc_pointage P 
                    JOIN wbcc_utilisateur u ON P.idUserF = u.idUtilisateur 
                    LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF 
                    ORDER BY P.datePointage DESC");
            }

            // Execute query and fetch results
            $results = $db->resultSet();

            // Process each record to calculate daily work hours
            foreach ($results as &$pointage) {
                $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, etc.

                // Convert jourTravail and horaireTravail to arrays
                $jours = explode(';', $pointage->jourTravail);
                $horaires = explode(';', $pointage->horaireTravail);

                // Check if there is a schedule for this day
                if (isset($horaires[$jourSemaine])) {
                    list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                    $pointage->heureDebutJour = $heureDebut;
                    $pointage->heureFinJour = $heureFin;
                } else {
                    $pointage->heureDebutJour = null;
                    $pointage->heureFinJour = null;
                }
            }

            // Return results as JSON
            if ($results) {
                echo json_encode($results);
            } else {
                echo json_encode("0");
            }
        }


        if ($action == 'getAllWithidUser') {
            // Retrieve $idUser from POST or GET data
            $idUser = $_POST['idUser'] ?? $_GET['idUser'] ?? null;

            // Check if $idUser is set
            if ($idUser) {
                $db->query("
                    SELECT p.*, u.jourTravail, u.horaireTravail 
                    FROM wbcc_pointage p
                    JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
                    WHERE p.idUserF = :idUser
                    ORDER BY p.datePointage DESC
                ");

                // Bind the user ID
                $db->bind(':idUser', $idUser);

                // Execute the query and get results
                $results = $db->resultSet();

                // Process each record to calculate daily work hours
                foreach ($results as &$pointage) {
                    $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, etc.

                    // Convert jourTravail and horaireTravail to arrays
                    $jours = explode(';', $pointage->jourTravail);
                    $horaires = explode(';', $pointage->horaireTravail);

                    // Check if there is a schedule for this day
                    if (isset($horaires[$jourSemaine])) {
                        list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                        $pointage->heureDebutJour = $heureDebut;
                        $pointage->heureFinJour = $heureFin;
                    } else {
                        $pointage->heureDebutJour = null;
                        $pointage->heureFinJour = null;
                    }
                }

                // Return results as JSON or an error message if no results
                if ($results) {
                    echo json_encode($results);
                } else {
                    echo json_encode("0");
                }
            } else {
                // Return error if $idUser is not provided
                echo json_encode(['error' => 'idUser is required.']);
            }
        }

        if ($action == 'getManager') {
            // Récupérer l'ID du site depuis les paramètres GET
            $idSite = $_GET['idSite'] ?? null;

            // Log pour débogage
            // error_log("Received idSite: " . json_encode($idSite));

            // Validation de l'ID du site
            if ($idSite === null) {
                // Retourner une erreur si l'ID du site est absent
                echo json_encode("0");
                exit;
            }

            // Requête pour récupérer les responsables en fonction de l'ID du site
            $sql = "
                SELECT
                    u.idUtilisateur,
                    u.idSiteF,
                    u.isAdmin,
                    u.role,
                    s.nomSite
                FROM
                    wbcc_utilisateur u
                LEFT JOIN wbcc_site s ON
                    u.idSiteF = s.idSite
                WHERE u.role = 25 AND s.idSite = :idSite 
            ";

            // Préparer et exécuter la requête
            $db->query($sql);
            $db->bind(':idSite', $idSite);

            // Récupérer les résultats
            $results = $db->resultSet();

            // Vérifier si des résultats ont été trouvés
            if ($results) {
                // Retourner les résultats sous forme de JSON
                echo json_encode($results);
            } else {
                // Retourner "0" si aucun responsable n'est trouvé
                echo json_encode("0");
            }
        }

        if ($action == 'getManagerForAdmin') {
            // Récupérer l'ID du site depuis les paramètres GET
            $idSite = $_GET['idSite'] ?? null;

            // Log pour débogage
            // error_log("Received idSite: " . json_encode($idSite));

            // Validation de l'ID du site
            if ($idSite === null) {
                // Retourner une erreur si l'ID du site est absent
                echo json_encode("0");
                exit;
            }

            // Requête pour récupérer les responsables en fonction de l'ID du site
            $sql = "
                SELECT
                    u.idUtilisateur,
                    u.idSiteF,
                    u.isAdmin,
                    u.role,
                    s.nomSite
                FROM
                    wbcc_utilisateur u
                LEFT JOIN wbcc_site s ON
                    u.idSiteF = s.idSite
                WHERE (u.role = 1 OR u.role = 2)
            ";

            // Préparer et exécuter la requête
            $db->query($sql);

            // Récupérer les résultats
            $results = $db->resultSet();

            // Vérifier si des résultats ont été trouvés
            if ($results) {
                // Retourner les résultats sous forme de JSON
                echo json_encode($results);
            } else {
                // Retourner "0" si aucun responsable n'est trouvé
                echo json_encode("0");
            }
        }


        // if ($action == "getUsersM") {
        //     $idSite = $_POST['idSite'] ?? $_GET['idSite'] ?? null;

        //     if ($idSite !== null) {
        //         $db->query("SELECT c.idContact, u.idUtilisateur, c.fullName, u.matricule, u.photo
        //                     FROM wbcc_contact c, wbcc_utilisateur u 
        //                     WHERE u.idContactF = c.idContact AND u.idSiteF = :idSite AND u.typePointage = 'INTERNE'");
        //         $db->bind(':idSite', $idSite);
        //     } else {
        //         echo json_encode(['error' => 'idSite parameter is missing']);
        //         exit;
        //     }

        //     $data = $db->resultSet();
        //     echo json_encode($data);
        // }
        if ($action == "getDocumentByPointage") {
            // Récupérer l'ID du pointage depuis les paramètres POST ou GET
            $idPointage = $_POST['idPointage'] ?? $_GET['idPointage'] ?? null;

            if ($idPointage !== null) {
                // Étape 1: Requête pour récupérer tous les idDocumentF dans wbcc_document_pointage où isArrive == true
                $db->query("SELECT idDocumentF FROM wbcc_document_pointage WHERE idPointageF = :idPointage AND isArrive = true");
                $db->bind(':idPointage', $idPointage);
                $documentPointageData = $db->resultSet();

                if (sizeof($documentPointageData) != 0) {
                    $documentIds = array_column($documentPointageData, 'idDocumentF');

                    // Étape 2: Requête pour récupérer les détails des documents à partir de wbcc_document
                    $placeholders = implode(',', array_fill(0, count($documentIds), '?'));
                    $query = "SELECT * FROM wbcc_document WHERE idDocument IN ($placeholders)";
                    $db->query($query);

                    // Lier les valeurs des ID de document dynamiquement
                    foreach ($documentIds as $index => $idDocumentF) {
                        $db->bind($index + 1, $idDocumentF);
                    }

                    $documents = $db->resultSet();

                    // Vérifier si des documents ont été trouvés et retourner les résultats
                    if ($documents) {
                        echo json_encode($documents);
                    } else {
                        // Aucun document trouvé
                        echo json_encode("0");
                    }
                } else {
                    // Aucun document associé trouvé pour le pointage donné
                    echo json_encode("0");
                }
            } else {
                // L'ID du pointage est manquant
                echo json_encode("0");
            }
        }



        if ($action == "getDocumentByPointageDepart") {
            // Récupérer l'ID du pointage depuis les paramètres POST ou GET
            $idPointage = $_POST['idPointage'] ?? $_GET['idPointage'] ?? null;

            if ($idPointage !== null) {
                // Étape 1: Requête pour récupérer tous les idDocumentF dans wbcc_document_pointage où isArrive == false
                $db->query("SELECT idDocumentF FROM wbcc_document_pointage WHERE idPointageF = :idPointage AND isArrive = false");
                $db->bind(':idPointage', $idPointage);
                $documentPointageData = $db->resultSet();

                if (sizeof($documentPointageData) != 0) {
                    $documentIds = array_column($documentPointageData, 'idDocumentF');

                    // Étape 2: Requête pour récupérer les détails des documents à partir de wbcc_document
                    $placeholders = implode(',', array_fill(0, count($documentIds), '?'));
                    $query = "SELECT * FROM wbcc_document WHERE idDocument IN ($placeholders)";
                    $db->query($query);

                    // Lier les valeurs des ID de document dynamiquement
                    foreach ($documentIds as $index => $idDocumentF) {
                        $db->bind($index + 1, $idDocumentF);
                    }

                    $documents = $db->resultSet();

                    // Vérifier si des documents ont été trouvés et retourner les résultats
                    if ($documents) {
                        echo json_encode($documents);
                    } else {
                        // Aucun document trouvé
                        echo json_encode("0");
                    }
                } else {
                    // Aucun document associé trouvé pour le pointage donné
                    echo json_encode("0");
                }
            } else {
                // L'ID du pointage est manquant
                echo json_encode("0");
            }
        }
        if ($action == "getDocumentByPointageAbsence") {
            // Récupérer l'ID du pointage depuis les paramètres POST ou GET
            $idPointage = $_POST['idPointage'] ?? $_GET['idPointage'] ?? null;

            if ($idPointage !== null) {
                // Étape 1: Requête pour récupérer tous les idDocumentF dans wbcc_document_pointage où isArrive == false
                $db->query("SELECT idDocumentF FROM wbcc_document_pointage WHERE idPointageF = :idPointage AND isAbsent = true");
                $db->bind(':idPointage', $idPointage);
                $documentPointageData = $db->resultSet();

                if (sizeof($documentPointageData) != 0) {
                    $documentIds = array_column($documentPointageData, 'idDocumentF');

                    // Étape 2: Requête pour récupérer les détails des documents à partir de wbcc_document
                    $placeholders = implode(',', array_fill(0, count($documentIds), '?'));
                    $query = "SELECT * FROM wbcc_document WHERE idDocument IN ($placeholders)";
                    $db->query($query);

                    // Lier les valeurs des ID de document dynamiquement
                    foreach ($documentIds as $index => $idDocumentF) {
                        $db->bind($index + 1, $idDocumentF);
                    }

                    $documents = $db->resultSet();

                    // Vérifier si des documents ont été trouvés et retourner les résultats
                    if ($documents) {
                        echo json_encode($documents);
                    } else {
                        // Aucun document trouvé
                        echo json_encode("0");
                    }
                } else {
                    // Aucun document associé trouvé pour le pointage donné
                    echo json_encode("0");
                }
            } else {
                // L'ID du pointage est manquant
                echo json_encode("0");
            }
        }


        if ($action == 'updateCommentaire') {
            if (isset($_POST['idDocument']) && isset($_POST['commentaire'])) {
                // Retrieve the required parameters from the POST request
                $idDocument = $_POST['idDocument'];
                $commentaire = $_POST['commentaire'];
                $editDate = date('Y-m-d H:i:s'); // Current date and time

                // Step 1: Check if the document exists
                $db->query("SELECT idDocument FROM wbcc_document WHERE idDocument = :idDocument");
                $db->bind(":idDocument", $idDocument);
                $documentResult = $db->single();

                if ($documentResult) {
                    // Step 2: Update the commentaire and editDate fields in the wbcc_document table
                    $db->query("UPDATE wbcc_document 
                                SET commentaire = :commentaire, 
                                    editDate = :editDate 
                                WHERE idDocument = :idDocument");

                    // Bind the parameters to the query
                    $db->bind(":commentaire", $commentaire);
                    $db->bind(":editDate", $editDate);
                    $db->bind(":idDocument", $idDocument);

                    // Execute the query
                    if ($db->execute()) {
                        echo json_encode(['success' => 'Commentaire mis à jour avec succès.']);
                    } else {
                        echo json_encode("0");
                    }
                } else {
                    // Return error message if the document is not found
                    echo json_encode("0");
                }
            } else {
                // Return an error message if parameters are missing
                echo json_encode("0");
            }
        }

        if ($action == 'updatenomDocument') {
            if (isset($_POST['idDocument']) && isset($_POST['nomDocument'])) {
                $idDocument = $_POST['idDocument'];
                $nomDocument = $_POST['nomDocument'];
                $editDate = date('Y-m-d H:i:s'); // Current date and time

                // Step 1: Check if the document exists
                $db->query("SELECT idDocument FROM wbcc_document WHERE idDocument = :idDocument");
                $db->bind(":idDocument", $idDocument);
                $documentResult = $db->single();

                if ($documentResult) {
                    // Step 2: Update the nomDocument and editDate fields in the wbcc_document table
                    $db->query("UPDATE wbcc_document 
                                SET nomDocument = :nomDocument, 
                                    editDate = :editDate 
                                WHERE idDocument = :idDocument");

                    // Bind the parameters to the query
                    $db->bind(":nomDocument", $nomDocument);
                    $db->bind(":editDate", $editDate);
                    $db->bind(":idDocument", $idDocument);

                    // Execute the query
                    if ($db->execute()) {
                        echo json_encode(['success' => 'nomDocument mis à jour avec succès.']);
                    } else {
                        echo json_encode("0");
                    }
                } else {
                    echo json_encode("0");
                }
            } else {
                echo json_encode("0");
            }
        }



        if ($action == 'updateJustification') {
            if (isset($_POST['idPointage']) && isset($_POST['idTraiteF']) && isset($_POST['resultatTraite'])) {
                // Retrieve the required parameters from the POST request
                $idPointage = $_POST['idPointage'];
                $idTraiteF = $_POST['idTraiteF'];
                $resultatTraite = $_POST['resultatTraite'];
                $dateTraite = date('Y-m-d H:i:s');  // Current date and time

                // Step 1: Get idContactF from wbcc_utilisateur using idTraiteF (idUtilisateur)
                $db->query("SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :idTraiteF");
                $db->bind(":idTraiteF", $idTraiteF);
                $idContactResult = $db->single();

                if ($idContactResult) {
                    $idContactF = $idContactResult->idContactF; // Access as an object property

                    // Step 2: Get fullName from wbcc_contact using idContactF
                    $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = :idContactF");
                    $db->bind(":idContactF", $idContactF);
                    $contactResult = $db->single();

                    if ($contactResult) {
                        $auteurTraite = $contactResult->fullName; // Access as an object property

                        // Step 3: Update the wbcc_pointage table with the appropriate values
                        $db->query("UPDATE wbcc_pointage 
                                    SET traite = 1, 
                                        idTraiteF = :idTraiteF, 
                                        auteurTraite = :auteurTraite,
                                        dateTraite = :dateTraite, 
                                        resultatTraite = :resultatTraite 
                                    WHERE idPointage = :idPointage");

                        // Bind the parameters to the query
                        $db->bind(":idTraiteF", $idTraiteF);
                        $db->bind(":auteurTraite", $auteurTraite);
                        $db->bind(":dateTraite", $dateTraite);
                        $db->bind(":resultatTraite", $resultatTraite);
                        $db->bind(":idPointage", $idPointage);

                        // Execute the query
                        if ($db->execute()) {
                            echo json_encode(['success' => 'Justification mise à jour avec succès.']);
                        } else {
                            echo json_encode("0");
                        }
                    } else {
                        echo json_encode("0");
                    }
                } else {
                    echo json_encode("0");
                }
            } else {
                echo json_encode("0");
            }
        }

        if ($action == 'updateJustificationsDepart') {
            if (isset($_POST['idPointage']) && isset($_POST['idTraiteDepartF']) && isset($_POST['resultatTraiteDepart'])) {
                // Récupérer les paramètres nécessaires depuis la requête POST
                $idPointage = $_POST['idPointage'];
                $idTraiteDepartF = $_POST['idTraiteDepartF'];
                $resultatTraiteDepart = $_POST['resultatTraiteDepart'];
                $dateTraiteDepart = date('Y-m-d H:i:s');  // Date et heure actuelle

                // Step 1: Get idContactF from wbcc_utilisateur using idTraiteDepartF (idUtilisateur)
                $db->query("SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :idTraiteDepartF");
                $db->bind(":idTraiteDepartF", $idTraiteDepartF);
                $idContactResult = $db->single();

                if ($idContactResult) {
                    $idContactF = $idContactResult->idContactF; // Accéder à la propriété de l'objet

                    // Step 2: Get fullName from wbcc_contact using idContactF
                    $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = :idContactF");
                    $db->bind(":idContactF", $idContactF);
                    $contactResult = $db->single();

                    if ($contactResult) {
                        $auteurTraiteDepart = $contactResult->fullName; // Accéder à la propriété de l'objet

                        // Étape 3 : Mettre à jour la table wbcc_pointage avec les valeurs appropriées
                        $db->query("UPDATE wbcc_pointage 
                                    SET traiteDepart = 1, 
                                        idTraiteDepartF = :idTraiteDepartF, 
                                        auteurTraiteDepart = :auteurTraiteDepart,
                                        dateTraiteDepart = :dateTraiteDepart, 
                                        resultatTraiteDepart = :resultatTraiteDepart 
                                    WHERE idPointage = :idPointage");

                        // Lier les paramètres à la requête
                        $db->bind(":idTraiteDepartF", $idTraiteDepartF);
                        $db->bind(":auteurTraiteDepart", $auteurTraiteDepart);
                        $db->bind(":dateTraiteDepart", $dateTraiteDepart);
                        $db->bind(":resultatTraiteDepart", $resultatTraiteDepart);
                        $db->bind(":idPointage", $idPointage);

                        // Exécuter la requête
                        if ($db->execute()) {
                            echo json_encode(['success' => 'Justification de départ mise à jour avec succès.']);
                        } else {
                            echo json_encode("0");
                        }
                    } else {
                        echo json_encode("0");
                    }
                } else {
                    echo json_encode("0");
                }
            } else {
                echo json_encode("0");
            }
        }

        if ($action == 'MupdateJustifications') {
            // Decode the incoming JSON request body
            $input = json_decode(file_get_contents('php://input'), true);

            // Check if the JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                echo "0";  // Return 0 on JSON decoding error
                exit;
            }

            // Check if required parameters are set
            if (isset($input['idPointage'], $input['idTraiteF'], $input['resultatTraite'], $input['typeTraite'])) {
                $idPointage = $input['idPointage'];
                $idTraiteF = $input['idTraiteF'];
                $resultatTraite = $input['resultatTraite'];
                $typeTraite = $input['typeTraite'];
                $raisonRejet = $input['raison']; // Assurez-vous que le paramètre 'raison' est bien reçu
                $dateTraite = date('Y-m-d H:i:s'); // Current date and time

                // Step 1: Get idContactF from wbcc_utilisateur using idTraiteF (idUtilisateur)
                $db->query("SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :idTraiteF");
                $db->bind(":idTraiteF", $idTraiteF);
                $idContactResult = $db->single();

                if ($idContactResult) {
                    $idContactF = $idContactResult->idContactF; // Access as an object property

                    // Step 2: Get fullName from wbcc_contact using idContactF
                    $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = :idContactF");
                    $db->bind(":idContactF", $idContactF);
                    $contactResult = $db->single();

                    if ($contactResult) {
                        $auteurTraite = $contactResult->fullName; // Access as an object property

                        // Step 3: Update the wbcc_pointage table with the appropriate values
                        $db->query("UPDATE wbcc_pointage 
                                    SET traite = 1, 
                                        idTraiteF = :idTraiteF, 
                                        auteurTraite = :auteurTraite, 
                                        dateTraite = :dateTraite, 
                                        resultatTraite = :resultatTraite, 
                                        typeTraite = :typeTraite,
                                        raisonRejet = :raisonRejet
                                    WHERE idPointage = :idPointage");

                        $db->bind(":idTraiteF", $idTraiteF);
                        $db->bind(":auteurTraite", $auteurTraite);
                        $db->bind(":dateTraite", $dateTraite);
                        $db->bind(":resultatTraite", $resultatTraite);
                        $db->bind(":typeTraite", $typeTraite);
                        $db->bind(":raisonRejet", $raisonRejet); // Bind the rejection reason
                        $db->bind(":idPointage", $idPointage);

                        if ($db->execute()) {
                            echo json_encode(['success' => 'Justification mise à jour avec succès.']);
                        } else {
                            echo "0";  // Return 0 if update fails
                        }
                    } else {
                        echo "0";  // Return 0 if contact is not found
                    }
                } else {
                    echo "0";  // Return 0 if user is not found
                }
            } else {
                echo "0";  // Return 0 if required parameters are missing
            }
        }


        if ($action == 'MupdateJustificationsDepart') {
            // Decode the incoming JSON request body
            $input = json_decode(file_get_contents('php://input'), true);

            // Check if required parameters are set
            if (isset($input['idPointage'], $input['idTraiteDepartF'], $input['resultatTraiteDepart'], $input['typeTraiteDepart'])) {
                // Retrieve the required parameters from the decoded JSON
                $idPointage = $input['idPointage'];
                $idTraiteF = $input['idTraiteDepartF'];
                $resultatTraite = $input['resultatTraiteDepart'];
                $typeTraite = $input['typeTraiteDepart'];
                $raisonRejet = $input['raison']; // Assurez-vous que le paramètre 'raison' est bien reçu
                $dateTraite = date('Y-m-d H:i:s');  // Current date and time

                // Step 1: Get idContactF from wbcc_utilisateur using idTraiteF (idUtilisateur)
                $db->query("SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :idTraiteF");
                $db->bind(":idTraiteF", $idTraiteF);
                $idContactResult = $db->single();

                if ($idContactResult) {
                    $idContactF = $idContactResult->idContactF; // Access as an object property

                    // Step 2: Get fullName from wbcc_contact using idContactF
                    $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = :idContactF");
                    $db->bind(":idContactF", $idContactF);
                    $contactResult = $db->single();

                    if ($contactResult) {
                        $auteurTraite = $contactResult->fullName; // Access as an object property

                        // Step 3: Update the wbcc_pointage table with the appropriate values
                        $db->query("UPDATE wbcc_pointage 
                                    SET traiteDepart = 1, 
                                        idTraiteDepartF = :idTraiteF, 
                                        auteurTraiteDepart = :auteurTraite,
                                        dateTraiteDepart = :dateTraite, 
                                        resultatTraiteDepart = :resultatTraite,
                                        typeTraiteDepart = :typeTraite,
                                        raisonRejetDepart = :raisonRejet
                                    WHERE idPointage = :idPointage");

                        // Bind the parameters to the query
                        $db->bind(":idTraiteF", $idTraiteF);
                        $db->bind(":auteurTraite", $auteurTraite);
                        $db->bind(":dateTraite", $dateTraite);
                        $db->bind(":resultatTraite", $resultatTraite);
                        $db->bind(":typeTraite", $typeTraite);
                        $db->bind(":raisonRejet", $raisonRejet); // Bind the rejection reason
                        $db->bind(":idPointage", $idPointage);

                        // Execute the query
                        if ($db->execute()) {
                            echo json_encode(['success' => 'Justification mise à jour avec succès.']);
                        } else {
                            echo "0";  // Return 0 if update fails
                        }
                    } else {
                        echo "0";  // Return 0 if contact is not found
                    }
                } else {
                    echo "0";  // Return 0 if user is not found
                }
            } else {
                echo "0";  // Return 0 if required parameters are missing
            }
        }
        if ($action == 'MupdateJustificationsAbsence') {
            // Decode the incoming JSON request body
            $input = json_decode(file_get_contents('php://input'), true);

            // Check if required parameters are set
            if (isset($input['idPointage'], $input['idTraiteAbsentF'], $input['resultatTraiteAbsent'], $input['typeTraiteAbsent'])) {
                // Retrieve the required parameters from the decoded JSON
                $idPointage = $input['idPointage'];
                $idTraiteF = $input['idTraiteAbsentF'];
                $resultatTraite = $input['resultatTraiteAbsent'];
                $typeTraite = $input['typeTraiteAbsent'];
                $raisonRejet = $input['raison']; // Assurez-vous que le paramètre 'raison' est bien reçu
                $dateTraite = date('Y-m-d H:i:s');  // Current date and time

                // Step 1: Get idContactF from wbcc_utilisateur using idTraiteF (idUtilisateur)
                $db->query("SELECT idContactF FROM wbcc_utilisateur WHERE idUtilisateur = :idTraiteF");
                $db->bind(":idTraiteF", $idTraiteF);
                $idContactResult = $db->single();

                if ($idContactResult) {
                    $idContactF = $idContactResult->idContactF; // Access as an object property

                    // Step 2: Get fullName from wbcc_contact using idContactF
                    $db->query("SELECT fullName FROM wbcc_contact WHERE idContact = :idContactF");
                    $db->bind(":idContactF", $idContactF);
                    $contactResult = $db->single();

                    if ($contactResult) {
                        $auteurTraite = $contactResult->fullName; // Access as an object property

                        // Step 3: Update the wbcc_pointage table with the appropriate values
                        $db->query("UPDATE wbcc_pointage 
                                    SET traiteAbsent = 1, 
                                        idTraiteAbsentF = :idTraiteF, 
                                        auteurTraiteAbsent = :auteurTraite,
                                        dateTraiteAbsent = :dateTraite, 
                                        resultatTraiteAbsent = :resultatTraite,
                                        typeTraiteAbsent = :typeTraite,
                                        raisonRejetAbsence = :raisonRejet
                                    WHERE idPointage = :idPointage");

                        // Bind the parameters to the query
                        $db->bind(":idTraiteF", $idTraiteF);
                        $db->bind(":auteurTraite", $auteurTraite);
                        $db->bind(":dateTraite", $dateTraite);
                        $db->bind(":resultatTraite", $resultatTraite);
                        $db->bind(":typeTraite", $typeTraite);
                        $db->bind(":raisonRejet", $raisonRejet); // Bind the rejection reason
                        $db->bind(":idPointage", $idPointage);

                        // Execute the query
                        if ($db->execute()) {
                            echo json_encode(['success' => 'Justification mise à jour avec succès.']);
                        } else {
                            echo "0";  // Return 0 if update fails
                        }
                    } else {
                        echo "0";  // Return 0 if contact is not found
                    }
                } else {
                    echo "0";  // Return 0 if user is not found
                }
            } else {
                echo "0";  // Return 0 if required parameters are missing
            }
        }


        if ($action == 'filterPointages') {
            // Retrieve filter parameters

            $Motifjustification = isset($_POST['Motifjustification']) ? $_POST['Motifjustification'] : '';
            $etat = isset($_POST['etat']) ? $_POST['etat'] : '';
            $periode = isset($_POST['periode']) ? $_POST['periode'] : '';
            $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // For single date 'A la date du'
            $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // For 'Personnaliser'
            $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // For 'Personnaliser'
            $userid = isset($_POST['userid']) ? $_POST['userid'] : '';

            // Base query for filtering pointages with join
            $sql = "SELECT p.*, u.jourTravail, u.horaireTravail 
                FROM wbcc_pointage p
                JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur 
                WHERE p.idUserF = :userid";

            // Array to hold bind parameters
            $bindParams = [':userid' => $userid];

            // Apply 'etat' filter
            if ($etat === 'Retard') {
                $sql .= " AND p.retard = 1";
            } elseif ($etat === 'Absent') {
                $sql .= " AND p.absent = 1";
            } elseif ($etat === 'Present') {
                $sql .= " AND p.retard = 0 AND p.absent = 0";
            }

            // Apply 'Motifjustification' filter
            if ($Motifjustification === 'justifie') {
                $sql .= " AND p.resultatTraite = 'Accepté'";
            } elseif ($Motifjustification === 'injustifie') {
                $sql .= " AND p.resultatTraite = 'Refusé'";
            }

            // Apply 'periode' filter
            switch ($periode) {
                case 'today':
                    $sql .= " AND p.datePointage = :today";
                    $bindParams[':today'] = date('Y-m-d');
                    break;

                case '1': // 'A la date du'
                    if ($dateOne) {
                        // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                        $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                        if ($dateOneFormatted) {
                            $sql .= " AND p.datePointage = :dateOne";
                            $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                        } else {
                            // Handle invalid date format
                            echo json_encode(['error' => 'Invalid date format for dateOne']);
                            exit;
                        }
                    }
                    break;

                case '2': // 'Personnaliser'
                    if ($dateDebut && $dateFin) {
                        $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                        $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                        if ($dateDebutFormatted && $dateFinFormatted) {
                            $sql .= " AND p.datePointage BETWEEN :dateDebut AND :dateFin";
                            $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                            $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                        } else {
                            // Handle invalid date format
                            echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                            exit;
                        }
                    }
                    break;

                case 'semaine':
                case 'mois':
                case 'trimestre':
                case 'semestre':
                case 'annuel':
                    $dateRange = getPeriodDateRange($periode);
                    $sql .= " AND p.datePointage BETWEEN :startDate AND :endDate";
                    $bindParams[':startDate'] = $dateRange['start'];
                    $bindParams[':endDate'] = $dateRange['end'];
                    break;

                default:
                    // No period filter applied
                    break;
            }
            $sql .= " ORDER BY p.datePointage desc";
            // Prepare and execute the query
            $db->query($sql);

            // Bind the parameters dynamically
            foreach ($bindParams as $param => $value) {
                $db->bind($param, $value);
            }

            // Fetch the filtered data
            $results = $db->resultset();

            foreach ($results as &$pointage) {
                $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, ...

                // Convertir jourTravail et horaireTravail en tableaux
                $jours = explode(';', $pointage->jourTravail);
                $horaires = explode(';', $pointage->horaireTravail);

                // Vérifier que le jour de la semaine existe dans les horaires
                if (isset($horaires[$jourSemaine])) {
                    list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                    $pointage->heureDebutJour = $heureDebut;
                    $pointage->heureFinJour = $heureFin;
                } else {
                    $pointage->heureDebutJour = null;
                    $pointage->heureFinJour = null;
                }
            }

            // Sortie des résultats en JSON
            echo json_encode($results);
        }

        if ($action == 'filterPointagesAdmin') {
            // Retrieve filter parameters
            $Motifjustification = isset($_POST['Motifjustification']) ? $_POST['Motifjustification'] : '';
            $etat = isset($_POST['etat']) ? $_POST['etat'] : '';
            $site = isset($_POST['site']) ? $_POST['site'] : '';
            $periode = isset($_POST['periode']) ? $_POST['periode'] : '';
            $dateOne = isset($_POST['dateOne']) ? $_POST['dateOne'] : ''; // For single date 'A la date du'
            $dateDebut = isset($_POST['dateDebut']) ? $_POST['dateDebut'] : ''; // For 'Personnaliser'
            $dateFin = isset($_POST['dateFin']) ? $_POST['dateFin'] : ''; // For 'Personnaliser'
            $matricule = isset($_POST['matricule']) ? $_POST['matricule'] : '';
            $idUtilisateur = isset($_POST['contact']) ? $_POST['contact'] : ''; // For filtering by user


            // Base query for filtering pointages with join
            $sql = "SELECT p.*, c.fullName, u.matricule, u.jourTravail , u.horaireTravail 
                    FROM wbcc_pointage p
                    JOIN wbcc_utilisateur u ON p.idUserF = u.idUtilisateur
                    LEFT JOIN wbcc_contact c ON c.idContact = u.idContactF
                    WHERE 1=1";

            // Array to hold bind parameters
            $bindParams = [];

            // Apply 'etat' filter
            if ($etat === 'Retard') {
                $sql .= " AND p.retard = 1";
            } elseif ($etat === 'Absent') {
                $sql .= " AND p.absent = 1";
            } elseif ($etat === 'Present') {
                $sql .= " AND p.retard = 0 AND p.absent = 0";
            }

            // Apply 'Motifjustification' filter
            if ($Motifjustification === 'justifie') {
                $sql .= " AND p.resultatTraite = 'Accepté'";
            } elseif ($Motifjustification === 'injustifie') {
                $sql .= " AND p.resultatTraite = 'Refusé'";
            }
            if (!empty($matricule)) {
                $sql .= " AND u.matricule = :matricule";
                $bindParams[':matricule'] = $matricule;
            }
            if (!empty($idUtilisateur)) {
                $sql .= " AND c.idContact = :idUtilisateur";
                $bindParams[':idUtilisateur'] = $idUtilisateur;
            }

            if (!empty($site)) {
                $sql .= " AND p.adressePointage LIKE :site";
                $bindParams[':site'] = '%' . $site . '%'; // Use wildcards for LIKE
            }
            // Apply 'periode' filter
            switch ($periode) {
                case 'today':
                    $sql .= " AND p.datePointage = :today";
                    $bindParams[':today'] = date('Y-m-d');
                    break;

                case '1': // 'A la date du'
                    if ($dateOne) {
                        // Convert the date format if needed (DD-MM-YYYY to YYYY-MM-DD)
                        $dateOneFormatted = DateTime::createFromFormat('d-m-Y', $dateOne);
                        if ($dateOneFormatted) {
                            $sql .= " AND p.datePointage = :dateOne";
                            $bindParams[':dateOne'] = $dateOneFormatted->format('Y-m-d');
                        } else {
                            // Handle invalid date format
                            echo json_encode(['error' => 'Invalid date format for dateOne']);
                            exit;
                        }
                    }
                    break;

                case '2': // 'Personnaliser'
                    if ($dateDebut && $dateFin) {
                        $dateDebutFormatted = DateTime::createFromFormat('d-m-Y', $dateDebut);
                        $dateFinFormatted = DateTime::createFromFormat('d-m-Y', $dateFin);
                        if ($dateDebutFormatted && $dateFinFormatted) {
                            $sql .= " AND p.datePointage BETWEEN :dateDebut AND :dateFin";
                            $bindParams[':dateDebut'] = $dateDebutFormatted->format('Y-m-d');
                            $bindParams[':dateFin'] = $dateFinFormatted->format('Y-m-d');
                        } else {
                            // Handle invalid date format
                            echo json_encode(['error' => 'Invalid date format for dateDebut or dateFin']);
                            exit;
                        }
                    }
                    break;

                case 'semaine':
                case 'mois':
                case 'trimestre':
                case 'semestre':
                case 'annuel':
                    $dateRange = getPeriodDateRange($periode);
                    $sql .= " AND p.datePointage BETWEEN :startDate AND :endDate";
                    $bindParams[':startDate'] = $dateRange['start'];
                    $bindParams[':endDate'] = $dateRange['end'];
                    break;

                default:
                    // No period filter applied
                    break;
            }

            $sql .= " ORDER BY p.datePointage desc";

            // Prepare and execute the query
            $db->query($sql);

            // Bind the parameters dynamically
            foreach ($bindParams as $param => $value) {
                $db->bind($param, $value);
            }

            // Fetch the filtered data
            $results = $db->resultset();

            // Calculate the start and end times for each pointage
            foreach ($results as &$pointage) {
                $jourSemaine = date('N', strtotime($pointage->datePointage)) - 1; // Lundi=0, Mardi=1, etc.

                // Convert jourTravail and horaireTravail to arrays
                $jours = explode(';', $pointage->jourTravail);
                $horaires = explode(';', $pointage->horaireTravail);

                // Check if the weekday exists in horaires
                if (isset($horaires[$jourSemaine])) {
                    list($heureDebut, $heureFin) = explode('-', $horaires[$jourSemaine]);
                    $pointage->heureDebutJour = $heureDebut;
                    $pointage->heureFinJour = $heureFin;
                } else {
                    $pointage->heureDebutJour = null;
                    $pointage->heureFinJour = null;
                }
            }

            // Output the results as JSON
            echo json_encode($results);
        }

        if ($action == 'saveJustification') {
            if (isset($_POST['pointage_id'], $_POST['type'])) {
                $pointage_id = $_POST['pointage_id'];
                $motif = $_POST['motif'];
                $type = $_POST['type'];
                $nomDocuments = isset($_POST['nomDocument']) ? $_POST['nomDocument'] : [];
                $comments = isset($_POST['comments']) ? $_POST['comments'] : [];

                $errorMessages = [];
                $successCount = 0;

                $motifColumn = $type === "Arrivé" ? "motifRetard" : ($type === "Départs" ? "motifRetardDepart" : "motifAbsent");
                $isArrive = $type === "Arrivé" ? 1 : ($type === "Départs" ? 0 : null);
                $isAbsent = $type === "Absence" ? 1 : 0;

                if (isset($_POST['modify']) && $_POST['modify'] == true) {
                    $db->query("UPDATE wbcc_pointage SET $motifColumn = :motif WHERE idPointage = :idPointage");
                    $db->bind("motif", $motif);
                    $db->bind("idPointage", $pointage_id);

                    if (!$db->execute()) {
                        $errorMessages[] = "Failed to update motif: " . $db->errorInfo();
                    }
                } else {
                    if (isset($_FILES['attachments']) && count($_FILES['attachments']['name']) > 0) {
                        $uploadDir = "../documents/pointage/justification/";
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }

                        for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
                            if ($_FILES['attachments']['error'][$i] == UPLOAD_ERR_OK) {
                                $uploadedFile = $_FILES['attachments']['tmp_name'][$i];
                                $originalFileName = $_FILES['attachments']['name'][$i];
                                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                                if (!in_array($fileExtension, ['pdf', 'mp4', 'jpg', 'jpeg', 'png'])) {
                                    $errorMessages[] = "Unsupported file type for $originalFileName";
                                    continue;
                                }

                                $numeroDocument = "DOC" . date('dmYHis') . $pointage_id . $i;
                                $nomDocumentSanitized = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nomDocuments[$i] ?? "Unnamed_Document_$i");
                                $dateNow = date('YmdHis');
                                $urlDocument = 'Pj_' . $pointage_id . '_' . $nomDocumentSanitized . '_' . $dateNow . '.' . $fileExtension;

                                if (move_uploaded_file($uploadedFile, $uploadDir . $urlDocument)) {
                                    $db->query("INSERT INTO wbcc_document (numeroDocument, nomDocument, urlDocument, commentaire, createDate, source, publie) 
                                                VALUES (:numeroDocument, :nomDocument, :urlDocument, :commentaire, NOW(), :source, :publie)");
                                    $db->bind("numeroDocument", $numeroDocument);
                                    $db->bind("nomDocument", $nomDocuments[$i] ?? "Unnamed_Document_$i");
                                    $db->bind("urlDocument", $urlDocument);
                                    $db->bind("commentaire", $comments[$i] ?? null);
                                    $db->bind("source", 'EXTRANET');
                                    $db->bind("publie", 1);

                                    if (!$db->execute()) {
                                        $errorMessages[] = "Failed to save document $originalFileName: " . $db->errorInfo();
                                        continue;
                                    }

                                    $idDocument = $db->lastInsertId();

                                    $db->query("INSERT INTO wbcc_document_pointage (idDocumentF, idPointageF, isArrive, isAbsent) 
                                                VALUES (:idDocumentF, :idPointageF, :isArrive, :isAbsent)");
                                    $db->bind("idDocumentF", $idDocument);
                                    $db->bind("idPointageF", $pointage_id);
                                    $db->bind("isArrive", $isArrive);
                                    $db->bind("isAbsent", $isAbsent);

                                    if (!$db->execute()) {
                                        $errorMessages[] = "Failed to link document $originalFileName: " . $db->errorInfo();
                                        continue;
                                    }

                                    $successCount++;
                                } else {
                                    $errorMessages[] = "Failed to move uploaded file $originalFileName.";
                                }
                            } else {
                                $errorMessages[] = "Error uploading file $i: " . $_FILES['attachments']['error'][$i];
                            }
                        }
                    }

                    $db->query("UPDATE wbcc_pointage SET $motifColumn = :motif WHERE idPointage = :idPointage");
                    $db->bind("motif", $motif);
                    $db->bind("idPointage", $pointage_id);

                    if (!$db->execute()) {
                        $errorMessages[] = "Failed to update pointage motif: " . $db->errorInfo();
                    }
                }

                if (empty($errorMessages)) {
                    echo json_encode(['success' => true, 'message' => "Request processed successfully. Total uploads: $successCount"]);
                } else {
                    echo json_encode(['success' => false, 'message' => implode(", ", $errorMessages)]);
                }
            } else {
                echo json_encode("0");
            }
        }



        if ($action == 'deleteDocuments') {
            if (isset($_GET['idDocument'])) {
                $idDocument = $_GET['idDocument'];

                // Delete from wbcc_document_pointage where idDocumentF matches
                $db->query("DELETE FROM wbcc_document_pointage WHERE idDocumentF = :idDocument");
                $db->bind("idDocument", $idDocument);

                if (!$db->execute()) {
                    echo json_encode(0);  // Failure response
                    return;  // Stop further execution
                }

                // Delete from wbcc_document where idDocument matches
                $db->query("DELETE FROM wbcc_document WHERE idDocument = :idDocument");
                $db->bind("idDocument", $idDocument);

                if (!$db->execute()) {
                    echo json_encode(0);  // Failure response
                    return;  // Stop further execution
                }

                // Success response
                echo json_encode(['success' => true, 'message' => 'Document deleted successfully.']);
            } else {
                // Missing idDocument
                echo json_encode(0);  // Failure response
            }
        }

        if ($action == 'deleteDocumentsBynom') {
            if (isset($_GET['nomDocument'])) {
                // $idDocument = $_GET['nomDocument'];

                // // Delete from wbcc_document_pointage where nomDocument matches
                // $db->query("DELETE FROM wbcc_document_pointage WHERE nomDocument = :nomDocument");
                // $db->bind("nomDocument", $nomDocument);

                // if (!$db->execute()) {
                //     echo json_encode(0);  // Failure response
                //     return;  // Stop further execution
                // }

                // // Delete from wbcc_document where nomDocument matches
                // $db->query("DELETE FROM wbcc_document WHERE nomDocument = :nomDocument");
                // $db->bind("nomDocument", $nomDocument);

                // if (!$db->execute()) {
                //     echo json_encode(0);  // Failure response
                //     return;  // Stop further execution
                // }

                // Success response
                echo json_encode(['success' => true, 'message' => 'Suppression non disponible pour le moment']);
            } else {
                // Missing nomDocument
                echo json_encode(0);  // Failure response
            }
        }

        // if ($action == 'addPointage') {
        //     try {
        //         // 1. Récupérer et décoder les données entrantes
        //         $input = file_get_contents('php://input');
        //         $data = json_decode($input, true);

        //         // 2. Vérification des données requises
        //         if (!isset($data['idUser'], $data['adressePointage'])) {
        //             echo json_encode(['error' => 'Données manquantes : idUser et adressePointage requis.']);
        //             exit;
        //         }

        //         // 3. Initialisation des variables
        //         $userid = $data['idUser'];
        //         $adressePointage = $data['adressePointage'];
        //         $datePointage = date('Y-m-d');
        //         $heurePointage = date('H:i:s');

        //         $db->query("
        //             SELECT u.idSiteF, s.adresseSite 
        //             FROM wbcc_utilisateur u 
        //             LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
        //             WHERE u.idUtilisateur = :userid
        //         ");
        //         $db->bind(":userid", $userid);
        //         $userSiteData = $db->single();
        //         $adresseProgramme = $userSiteData->adresseSite;
        //         $anomalie = ($adressePointage !== $adresseProgramme) ? 1 : 0;

        //         // 4. Vérification si un pointage existe déjà pour aujourd'hui
        //         $db->query("SELECT * FROM wbcc_pointage WHERE idUserF = :userid AND datePointage = :datePointage");
        //         $db->bind(":userid", $userid);
        //         $db->bind(":datePointage", $datePointage);
        //         $existingPointage = $db->single();

        //         if ($existingPointage) {
        //             // 5. Gestion du début de pointage s'il n'existe pas encore
        //             if (empty($existingPointage->heureDebutPointage)) {
        //                 // Récupérer les jours et horaires de travail de l'utilisateur
        //                 $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
        //                 $db->bind(":userid", $userid);
        //                 $userData = $db->single();

        //                 if ($userData) {
        //                     // 6. Vérifier si c'est un jour de travail
        //                     $joursTravail = explode(';', $userData->jourTravail);
        //                     $horairesTravail = explode(';', $userData->horaireTravail);

        //                     $jourSemaine = date('N', strtotime($datePointage)); // Jour de la semaine (1 = lundi)
        //                     $heureTravailJour = $horairesTravail[$jourSemaine - 1]; // Horaire du jour actuel

        //                     if (!empty($heureTravailJour)) {
        //                         list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);

        //                         // Comparer l'heure actuelle avec l'heure de début de travail
        //                         $datetimeDebutJour = new DateTime($heureDebutJour);
        //                         $datetimePointage = new DateTime($heurePointage);

        //                         $nbMinuteRetard = 0; // Initialiser les minutes de retard
        //                         $retard = 0; // Par défaut, pas de retard

        //                         // Vérifier si l'heure de pointage dépasse l'heure de début de travail de plus de 5 minutes
        //                         if ($datetimePointage > $datetimeDebutJour) {
        //                             $interval = $datetimeDebutJour->diff($datetimePointage);
        //                             $nbMinuteRetard = ($interval->h * 60) + $interval->i;

        //                             if ($nbMinuteRetard > 5) { // Seulement si plus de 5 minutes de retard
        //                                 $retard = 1; // Marquer comme retard
        //                             }
        //                         }

        //                         // 7. Mettre à jour le pointage avec les informations
        //                         $db->query("
        //                             UPDATE wbcc_pointage
        //                             SET heureDebutPointage = :heurePointage,
        //                                 nbMinuteRetard = :nbMinuteRetard,
        //                                 adressePointage =:adressePointage,
        //                                 adresseProgramme = :adresseProgramme,
        //                                 anomalieDebutJour = :anomalie,
        //                                 retard = :retard
        //                             WHERE idUserF = :userid AND datePointage = :datePointage
        //                         ");
        //                         $db->bind(":heurePointage", $heurePointage);
        //                         $db->bind(":nbMinuteRetard", $nbMinuteRetard);
        //                         $db->bind(":adressePointage", $adressePointage);
        //                         $db->bind(":retard", $retard);
        //                         $db->bind(":adresseProgramme", $adresseProgramme);
        //                         $db->bind(":anomalie", $anomalie);
        //                         $db->bind(":userid", $userid);
        //                         $db->bind(":datePointage", $datePointage);

        //                         if ($db->execute()) {
        //                             echo json_encode([
        //                                 'success' => 'Pointage enregistré avec succès.',
        //                                 'nbMinuteRetard' => $nbMinuteRetard,
        //                                 'retard' => $retard,
        //                                 'idPointage' => $existingPointage->idPointage
        //                             ]);
        //                         } else {
        //                             echo json_encode(['error' => 'Erreur lors de la mise à jour du pointage.']);
        //                         }
        //                     } else {
        //                         echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
        //                     }

        //                 } else {
        //                     echo json_encode(['error' => 'Utilisateur introuvable.']);
        //                 }
        //             } else {
        //                 echo json_encode(['message' => 'Pointage déjà effectué pour aujourd\'hui.']);
        //             }
        //         } else {
        //             // No existing pointage: Insert a new record
        //             // Retrieve user's work schedule
        //             $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
        //             $db->bind(":userid", $userid);
        //             $userData = $db->single();

        //             if ($userData) {
        //                 // Check if it's a working day
        //                 $joursTravail = explode(';', $userData->jourTravail);
        //                 $horairesTravail = explode(';', $userData->horaireTravail);
        //                 $jourSemaine = date('N', strtotime($datePointage));
        //                 $heureTravailJour = $horairesTravail[$jourSemaine - 1];

        //                 if (!empty($heureTravailJour)) {
        //                     list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);
        //                     $datetimeDebutJour = new DateTime($heureDebutJour);
        //                     $datetimePointage = new DateTime($heurePointage);

        //                     $nbMinuteRetard = 0;
        //                     $retard = 0;

        //                     // Vérifier si l'heure de pointage dépasse l'heure de début de travail de plus de 5 minutes
        //                     if ($datetimePointage > $datetimeDebutJour) {
        //                         $interval = $datetimeDebutJour->diff($datetimePointage);
        //                         $nbMinuteRetard = ($interval->h * 60) + $interval->i;

        //                         if ($nbMinuteRetard > 5) { // Seulement si plus de 5 minutes de retard
        //                             $retard = 1; // Marquer comme retard
        //                         }
        //                     }


        //                     // Insert new pointage
        //                     $db->query("
        //                         INSERT INTO wbcc_pointage (datePointage, adressePointage, heureDebutPointage,heureDebutJour, heureFinJour,absent, retard, nbMinuteRetard,adresseProgramme,anomalieDebutJour, idUserF)
        //                         VALUES (:datePointage, :adressePointage, :heurePointage,:heureDebutJour,:heureFinJour, 0, 1, :nbMinuteRetard,:adresseProgramme,:anomalie, :userid)
        //                     ");
        //                     $db->bind(":datePointage", $datePointage);
        //                     $db->bind(":adressePointage", $adressePointage);
        //                     $db->bind(":heurePointage", $heurePointage);
        //                     $db->bind(":heureDebutJour", $heureDebutJour);
        //                     $db->bind(":heureFinJour", $heureFinJour);
        //                     $db->bind(":nbMinuteRetard", $nbMinuteRetard);
        //                     $db->bind(":adresseProgramme", $adresseProgramme);
        //                     $db->bind(":anomalie", $anomalie);
        //                     $db->bind(":userid", $userid);

        //                     if ($db->execute()) {
        //                         // Récupérer l'ID du dernier enregistrement inséré
        //                         $lastInsertedId = $db->lastInsertId();

        //                         echo json_encode([
        //                             'success' => 'Pointage ajouté avec succès.',
        //                             'retard' => $retard,
        //                             'adressePointage' => $adressePointage,
        //                             'nbMinuteRetard' => $nbMinuteRetard,
        //                             'idPointage' => $lastInsertedId // Inclure l'ID du pointage dans la réponse
        //                         ]);
        //                     } else {
        //                         echo json_encode(['error' => 'Erreur lors de l\'ajout du pointage.']);
        //                     }

        //                 } else {
        //                     echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
        //                 }
        //             } else {
        //                 echo json_encode(['error' => 'Utilisateur introuvable.']);
        //             }
        //         }
        //     } catch (Exception $e) {
        //         echo json_encode(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()]);
        //     }
        // }

        // if ($action == 'addPointageDepart') {
        //     try {
        //         // 1. Récupérer et décoder les données entrantes
        //         $input = file_get_contents('php://input');
        //         $data = json_decode($input, true);

        //         // 2. Vérification des données requises
        //         if (!isset($data['idUser'], $data['adressePointage'])) {
        //             echo json_encode(['error' => 'Données manquantes : idUser et adressePointage requis.']);
        //             exit;
        //         }

        //         // 3. Initialisation des variables
        //         $userid = $data['idUser'];
        //         $adressePointage = $data['adressePointage'];
        //         $datePointage = date('Y-m-d');
        //         $heurePointage = date('H:i:s');

        //         $db->query("
        //         SELECT u.idSiteF, s.adresseSite 
        //         FROM wbcc_utilisateur u 
        //         LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
        //         WHERE u.idUtilisateur = :userid
        //         ");
        //         $db->bind(":userid", $userid);
        //         $userSiteData = $db->single();
        //         $adresseProgramme = $userSiteData->adresseSite;
        //         $anomalie = ($adressePointage !== $adresseProgramme) ? 1 : 0;

        //         // 4. Vérification si un pointage existe déjà pour aujourd'hui
        //         $db->query("SELECT * FROM wbcc_pointage WHERE idUserF = :userid AND datePointage = :datePointage");
        //         $db->bind(":userid", $userid);
        //         $db->bind(":datePointage", $datePointage);
        //         $existingPointage = $db->single();

        //         if ($existingPointage) {
        //             // 5. Gestion du début de pointage s'il n'existe pas encore
        //             if (empty($existingPointage->heureFinPointage)) {
        //                 // Récupérer les jours et horaires de travail de l'utilisateur
        //                 $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
        //                 $db->bind(":userid", $userid);
        //                 $userData = $db->single();

        //                 if ($userData) {
        //                     // 6. Vérifier si c'est un jour de travail
        //                     $joursTravail = explode(';', $userData->jourTravail);
        //                     $horairesTravail = explode(';', $userData->horaireTravail);

        //                     $jourSemaine = date('N', strtotime($datePointage)); // Jour de la semaine (1 = lundi)
        //                     $heureTravailJour = $horairesTravail[$jourSemaine - 1]; // Horaire du jour actuel

        //                     if (!empty($heureTravailJour)) {
        //                         list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);

        //                         // Comparer l'heure actuelle avec l'heure de début de travail
        //                         $datetimeFinJour = new DateTime($heureFinJour);
        //                         $datetimePointage = new DateTime($heurePointage);

        //                         $nbMinuteDepart = 0; // Initialiser les minutes de retard


        //                         if ($datetimePointage < $datetimeFinJour) {
        //                             $interval = $datetimeFinJour->diff($datetimePointage);
        //                             $nbMinuteDepart = ($interval->h * 60) + $interval->i;

        //                         }

        //                         // 7. Mettre à jour le pointage avec les informations
        //                         $db->query("
        //                             UPDATE wbcc_pointage
        //                             SET heureFinPointage = :heurePointage,
        //                                 nbMinuteDepart = :nbMinuteDepart,
        //                                 adresseFinPointage = :adressePointage,
        //                                    adresseProgrammeFin = :adresseProgramme,
        //                                 anomalieFinJour = :anomalie

        //                             WHERE idUserF = :userid AND datePointage = :datePointage
        //                         ");
        //                         $db->bind(":heurePointage", $heurePointage);
        //                         $db->bind(":nbMinuteDepart", $nbMinuteDepart);
        //                         $db->bind(":adressePointage", $adressePointage);
        //                         $db->bind(":adresseProgramme", $adresseProgramme);
        //                         $db->bind(":anomalie", $anomalie);
        //                         $db->bind(":userid", $userid);
        //                         $db->bind(":datePointage", $datePointage);

        //                         if ($db->execute()) {
        //                             echo json_encode([
        //                                 'success' => 'Pointage enregistré avec succès.',
        //                                 'nbMinuteDepart' => $nbMinuteDepart,
        //                                 'adressePointage' => $adressePointage,
        //                                 'idPointage' => $existingPointage->idPointage
        //                             ]);
        //                         } else {
        //                             echo json_encode(['error' => 'Erreur lors de la mise à jour du pointage.']);
        //                         }
        //                     } else {
        //                         echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
        //                     }
        //                 } else {
        //                     echo json_encode(['error' => 'Utilisateur introuvable.']);
        //                 }
        //             } else {
        //                 echo json_encode(['message' => 'Pointage déjà effectué pour aujourd\'hui.']);
        //             }
        //         } else {
        //             // Insert a new pointage record if none exists
        //             $db->query("INSERT INTO wbcc_pointage (datePointage, adressePointage , idUserF, absent) 
        //             VALUES (:datePointage, :adressePointage, :userid, 1)");
        //             $db->bind(":datePointage", $datePointage);
        //             $db->bind(":adressePointage", $adressePointage);

        //             $db->bind(":userid", $userid);

        //             if ($db->execute()) {
        //                 echo json_encode(['success' => 'Nouveau pointage ajouté pour l\'utilisateur.']);
        //             } else {
        //                 echo json_encode(['error' => 'Erreur lors de la création du pointage.']);
        //             }
        //         }
        //     } catch (Exception $e) {
        //         echo json_encode(['error' => 'Une erreur s\'est produite : ' . $e->getMessage()]);
        //     }
        // }

        if ($action == 'addPointage') {
            // 1. Récupérer et décoder les données entrantes
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            // 2. Vérification des données requises
            if (!isset($data['idUser'], $data['adressePointage'], $data['typePointage'])) {
                echo json_encode(['error' => 'Données manquantes : idUser, adressePointage et typePointage requis.']);
                exit;
            }

            // 3. Initialisation des variables
            $userid = $data['idUser'];
            $adressePointage = $data['adressePointage'];
            $typePointage = $data['typePointage']; // 'arrivee' ou 'depart'
            $datePointage = date('Y-m-d');
            $heurePointage = date('H:i:s');

            $db->query("
                SELECT u.idSiteF, s.adresseSite 
                FROM wbcc_utilisateur u 
                LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite 
                WHERE u.idUtilisateur = :userid
            ");
            $db->bind(":userid", $userid);
            $userSiteData = $db->single();
            $adresseProgramme = $userSiteData->adresseSite;
            $anomalie = ($adressePointage !== $adresseProgramme) ? 1 : 0;

            // 4. Vérification si un pointage existe déjà pour aujourd'hui
            $db->query("SELECT * FROM wbcc_pointage WHERE idUserF = :userid AND datePointage = :datePointage");
            $db->bind(":userid", $userid);
            $db->bind(":datePointage", $datePointage);
            $existingPointage = $db->single();

            if ($existingPointage) {
                // 5. Gestion du pointage selon le type
                if ($typePointage == 'arrivee') {
                    if (empty($existingPointage->heureDebutPointage)) {
                        // Récupérer les jours et horaires de travail de l'utilisateur
                        $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
                        $db->bind(":userid", $userid);
                        $userData = $db->single();

                        if ($userData) {
                            // Vérifier si c'est un jour de travail
                            $joursTravail = explode(';', $userData->jourTravail);
                            $horairesTravail = explode(';', $userData->horaireTravail);

                            $jourSemaine = date('N', strtotime($datePointage));
                            $heureTravailJour = $horairesTravail[$jourSemaine - 1];

                            if (!empty($heureTravailJour)) {
                                list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);
                                $datetimeDebutJour = new DateTime($heureDebutJour);
                                $datetimePointage = new DateTime($heurePointage);

                                $nbMinuteRetard = 0;
                                $retard = 0;

                                if ($datetimePointage > $datetimeDebutJour) {
                                    $interval = $datetimeDebutJour->diff($datetimePointage);
                                    $nbMinuteRetard = ($interval->h * 60) + $interval->i;

                                    if ($nbMinuteRetard > 5) {
                                        $retard = 1;
                                    }
                                }

                                // Mettre à jour le pointage avec les informations
                                $db->query("
                                    UPDATE wbcc_pointage
                                    SET heureDebutPointage = :heurePointage,
                                        nbMinuteRetard = :nbMinuteRetard,
                                        adressePointage = :adressePointage,
                                        adresseProgramme = :adresseProgramme,
                                        anomalieDebutJour = :anomalie,
                                        retard = :retard
                                    WHERE idUserF = :userid AND datePointage = :datePointage
                                ");
                                $db->bind(":heurePointage", $heurePointage);
                                $db->bind(":nbMinuteRetard", $nbMinuteRetard);
                                $db->bind(":adressePointage", $adressePointage);
                                $db->bind(":retard", $retard);
                                $db->bind(":adresseProgramme", $adresseProgramme);
                                $db->bind(":anomalie", $anomalie);
                                $db->bind(":userid", $userid);
                                $db->bind(":datePointage", $datePointage);

                                if ($db->execute()) {
                                    echo json_encode([
                                        'success' => 'Pointage d\'arrivée enregistré avec succès.',
                                        'nbMinuteRetard' => $nbMinuteRetard,
                                        'retard' => $retard,
                                        'idPointage' => $existingPointage->idPointage,
                                        'anomalie' => $anomalie
                                    ]);
                                } else {
                                    echo json_encode(['error' => 'Erreur lors de la mise à jour du pointage.']);
                                }
                            } else {
                                echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
                            }
                        } else {
                            echo json_encode(['error' => 'Utilisateur introuvable.']);
                        }
                    } else {
                        echo json_encode(['message' => 'Pointage d\'arrivée déjà effectué pour aujourd\'hui.']);
                    }
                } elseif ($typePointage == 'depart') {
                    if (empty($existingPointage->heureFinPointage)) {
                        // Récupérer les jours et horaires de travail de l'utilisateur
                        $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
                        $db->bind(":userid", $userid);
                        $userData = $db->single();

                        if ($userData) {
                            // Vérifier si c'est un jour de travail
                            $joursTravail = explode(';', $userData->jourTravail);
                            $horairesTravail = explode(';', $userData->horaireTravail);

                            $jourSemaine = date('N', strtotime($datePointage));
                            $heureTravailJour = $horairesTravail[$jourSemaine - 1];

                            if (!empty($heureTravailJour)) {
                                list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);
                                $datetimeFinJour = new DateTime($heureFinJour);
                                $datetimePointage = new DateTime($heurePointage);

                                $nbMinuteDepart = 0;

                                if ($datetimePointage < $datetimeFinJour) {
                                    $interval = $datetimeFinJour->diff($datetimePointage);
                                    $nbMinuteDepart = ($interval->h * 60) + $interval->i;
                                }

                                // Mettre à jour le pointage avec les informations
                                $db->query("
                                    UPDATE wbcc_pointage
                                    SET heureFinPointage = :heurePointage,
                                        nbMinuteDepart = :nbMinuteDepart,
                                        adresseFinPointage = :adressePointage,
                                        adresseProgrammeFin = :adresseProgramme,
                                        anomalieFinJour = :anomalie
                                    WHERE idUserF = :userid AND datePointage = :datePointage
                                ");
                                $db->bind(":heurePointage", $heurePointage);
                                $db->bind(":nbMinuteDepart", $nbMinuteDepart);
                                $db->bind(":adressePointage", $adressePointage);
                                $db->bind(":adresseProgramme", $adresseProgramme);
                                $db->bind(":anomalie", $anomalie);
                                $db->bind(":userid", $userid);
                                $db->bind(":datePointage", $datePointage);

                                if ($db->execute()) {

                                    echo json_encode([
                                        'success' => 'Pointage de départ enregistré avec succès.',
                                        'nbMinuteDepart' => $nbMinuteDepart,
                                        'adressePointage' => $adressePointage,
                                        'idPointage' => $existingPointage->idPointage,
                                        'anomalie' => $anomalie
                                    ]);
                                } else {
                                    echo json_encode(['error' => 'Erreur lors de la mise à jour du pointage.']);
                                }
                            } else {
                                echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
                            }
                        } else {
                            echo json_encode(['error' => 'Utilisateur introuvable.']);
                        }
                    } else {
                        echo json_encode(['message' => 'Pointage de départ déjà effectué pour aujourd\'hui.']);
                    }
                }
            } else {
                // No existing pointage: Insert a new record
                $db->query("SELECT jourTravail, horaireTravail FROM wbcc_utilisateur WHERE idUtilisateur = :userid");
                $db->bind(":userid", $userid);
                $userData = $db->single();

                if ($userData) {
                    // Check if it's a working day
                    $joursTravail = explode(';', $userData->jourTravail);
                    $horairesTravail = explode(';', $userData->horaireTravail);
                    $jourSemaine = date('N', strtotime($datePointage));
                    $heureTravailJour = $horairesTravail[$jourSemaine - 1];

                    if (!empty($heureTravailJour)) {
                        list($heureDebutJour, $heureFinJour) = explode('-', $heureTravailJour);
                        $datetimePointage = new DateTime($heurePointage);

                        $nbMinuteRetard = 0;
                        $retard = 0;

                        // Determine if it's an arrival or departure pointage
                        if ($typePointage == 'arrivee') {
                            // Logic for arrival pointage
                            if ($datetimePointage > new DateTime($heureDebutJour)) {
                                $interval = (new DateTime($heureDebutJour))->diff($datetimePointage);
                                $nbMinuteRetard = ($interval->h * 60) + $interval->i; // Calculate minutes of delay
                                if ($nbMinuteRetard > 5) { // Check if delay exceeds 5 minutes
                                    $retard = 1; // Flag as late
                                }
                            }
                        } else {
                            // Logic for departure pointage
                            if ($datetimePointage < new DateTime($heureFinJour)) {
                                $interval = (new DateTime($heureFinJour))->diff($datetimePointage);
                                $nbMinuteDepart = ($interval->h * 60) + $interval->i; // Calculate early departure minutes
                            }
                        }

                        // Insert new pointage
                        $db->query("
                            INSERT INTO wbcc_pointage (datePointage, adressePointage, heureDebutPointage, heureDebutJour, heureFinJour, absent, retard, nbMinuteRetard, adresseProgramme, anomalieDebutJour, idUserF)
                            VALUES (:datePointage, :adressePointage, :heurePointage, :heureDebutJour, :heureFinJour, 0, :retard, :nbMinuteRetard, :adresseProgramme, :anomalie, :userid)
                        ");
                        $db->bind(":datePointage", $datePointage);
                        $db->bind(":adressePointage", $adressePointage);
                        $db->bind(":heurePointage", $heurePointage);
                        $db->bind(":heureDebutJour", $heureDebutJour);
                        $db->bind(":heureFinJour", $heureFinJour);
                        $db->bind(":retard", $retard);
                        $db->bind(":nbMinuteRetard", $nbMinuteRetard);
                        $db->bind(":adresseProgramme", $adresseProgramme);
                        $db->bind(":anomalie", $anomalie);
                        $db->bind(":userid", $userid);

                        if ($db->execute()) {
                            $lastInsertedId = $db->lastInsertId();
                            echo json_encode([
                                'success' => 'Pointage ajouté avec succès.',
                                'retard' => $retard,
                                'adressePointage' => $adressePointage,
                                'nbMinuteRetard' => $nbMinuteRetard,
                                'idPointage' => $lastInsertedId,
                                'anomalie' => $anomalie
                            ]);
                        } else {
                            echo json_encode(['error' => 'Erreur lors de l\'ajout du pointage.']);
                        }
                    } else {
                        echo json_encode(['error' => 'Pas d\'horaire défini pour ce jour.']);
                    }
                } else {
                    echo json_encode(['error' => 'Utilisateur introuvable.']);
                }
            }
        }



        if ($action == "sendEmail") {
            // Retrieve POST data
            $to = $_POST['to'] ?? ''; // Recipient email address
            $subject = $_POST['subject'] ?? ''; // Email subject
            $body = $_POST['body'] ?? ''; // Email body

            // Validate required parameters
            if (empty($to) || empty($subject) || empty($body)) {
                echo json_encode(0); // Return 0 on failure
                exit;
            }

            // Pass an empty array for attachments
            $tabFiles = []; // Empty array since we don't want to include any attachments

            // Call the emailFromNoReply method with empty attachments
            //$emailSent = Role::emailFromNoReply("wbcc024@wbcc.fr", [], "Test Nabila 2", "Bonjour", []);
            //$emailSent = Role::emailFromNoReply($to, [], $subject, $body, []); 
            $emailSent = Role::mailExtranetWithFiles($to, $subject, $body, EMAIL_CODIR, [], []);

            // Return a JSON response
            if ($emailSent) {
                echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
            } else {
                echo json_encode(0); // Return 0 on failure
            }
        }


        // Ajouter nouvelle notification
        if ($action == 'createNotification') {
            // Retrieve POST data
            $idUtilisateur = $_POST['idUtilisateur'] ?? null; // User ID receiving the notification
            $title = $_POST['title'] ?? ''; // Notification title
            $message = $_POST['message'] ?? ''; // Notification message
            $idPointage = $_POST['idPointage'] ?? null;

            // Validate required parameters
            if (empty($idUtilisateur) || empty($title) || empty($message)) {
                echo json_encode(0); // Return 0 on failure if parameters are missing
                exit;
            }

            // Insert notification into the database
            $db->query("INSERT INTO wbcc_notification (idUtilisateur, title, message , idPointage) VALUES (:idUtilisateur, :title, :message , :idPointage)");
            $db->bind("idUtilisateur", $idUtilisateur);
            $db->bind("title", $title);
            $db->bind("message", $message);
            $db->bind("idPointage", $idPointage);

            // Check if insertion was successful
            if ($db->execute()) {
                echo json_encode(['success' => true, 'message' => 'Notification created successfully.']);
            } else {
                echo json_encode(0); // Return 0 on failure if the notification creation fails
            }
        }

        // Update notification as "Read"
        if ($action == 'markNotificationAsRead') {
            // Retrieve POST data
            $idNotification = $_POST['idNotification'] ?? null; // Notification ID to mark as read
            $idUtilisateur = $_POST['idUtilisateur'] ?? null; // User ID to ensure that this notification belongs to them

            // Validate required parameters
            if (empty($idNotification) || empty($idUtilisateur)) {
                echo json_encode(0); // Return 0 if required fields are missing
                exit;
            }

            // Check if the notification exists and belongs to the user
            $db->query("SELECT * FROM wbcc_notification WHERE idNotification = :idNotification AND idUtilisateur = :idUtilisateur");
            $db->bind("idNotification", $idNotification);
            $db->bind("idUtilisateur", $idUtilisateur);
            $notification = $db->single();

            if ($notification) {
                // Mark the notification as read
                $db->query("UPDATE wbcc_notification SET is_read = 1 WHERE idNotification = :idNotification");
                $db->bind("idNotification", $idNotification);

                if ($db->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Notification marked as read.']);
                } else {
                    echo json_encode(0); // Return 0 if the update fails
                }
            } else {
                echo json_encode(0); // Return 0 if notification is not found or does not belong to the user
            }
        }

        // Get notifications with idUtilisateur
        if ($action == 'getNotifications') {
            // Retrieve user ID and read status from GET parameters
            $idUtilisateur = $_GET['idUtilisateur'] ?? null; // User ID
            $is_read = $_GET['is_read'] ?? null; // Filter by read status (0 for unread, 1 for read)

            if (empty($idUtilisateur)) {
                echo json_encode(0); // Return 0 if user ID is missing
                exit;
            }

            // Build the query based on whether read status is provided
            $query = "SELECT * FROM wbcc_notification WHERE idUtilisateur = :idUtilisateur ORDER BY created_at DESC";

            if ($is_read !== null) {
                $query .= " AND is_read = :is_read";
            }

            $db->query($query);
            $db->bind("idUtilisateur", $idUtilisateur);

            if ($is_read !== null) {
                $db->bind("is_read", $is_read);
            }

            $notifications = $db->resultSet();

            if ($notifications) {
                echo json_encode($notifications);
            } else {
                echo json_encode(0); // Return 0 if no notifications are found
            }
        }

        if ($action == 'supprimerDocument') {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $deleteSuccess = false;

            foreach ($_POST as $key => $document) {
                // Extract the nomDocument
                $idDocument  = $document['idDocumentF'];

                // Delete from wbcc_document_pointage
                $db->query("DELETE FROM wbcc_document_pointage WHERE idDocumentF  = :idDocumentF ");
                $db->bind("idDocumentF ", $idDocument);
                if ($db->execute()) {
                    // Delete from wbcc_document
                    $db->query("DELETE FROM wbcc_document WHERE idDocument = :idDocument");
                    $db->bind("idDocument", $idDocument);
                    if ($db->execute()) {
                        $deleteSuccess = true;
                    } else {
                        $deleteSuccess = false;
                        break;
                    }
                } else {
                    $deleteSuccess = false;
                    break;
                }
            }

            if ($deleteSuccess) {
                echo json_encode(['success' => true, 'message' => 'Document DELETE']);
            } else {
                echo json_encode(0); // Return 0 on failure
            }
        }

        if ($action == "batchPointage") {
            $currentDate = date("Y-m-d");
            $currentTime = date("H:i");
            $currentDayOfWeek = date("N"); // Numéro du jour dans la semaine (1 = lundi, 7 = dimanche)

            // Étape 1 : Récupérer les utilisateurs avec un rôle différent de 1 et 34
            $query = "
                SELECT u.idUtilisateur, u.jourTravail, u.horaireTravail, s.nomSite, s.numeroSite ,s.adresseSite
                FROM wbcc_utilisateur u
                LEFT JOIN wbcc_site s ON u.idSiteF = s.idSite
                WHERE u.role NOT IN (1, 34)
            ";
            $db->query($query);
            $utilisateurs = $db->resultSet();

            foreach ($utilisateurs as $utilisateur) {
                $idUser = $utilisateur->idUtilisateur;
                $adresseSite = $utilisateur->adresseSite;
                $joursTravail = explode(';', $utilisateur->jourTravail); // Ex: "Lundi;Mardi;Mercredi"
                $horairesTravail = explode(';', $utilisateur->horaireTravail); // Ex: "09:00-17:00;08:00-16:00"

                // Vérifier si l'utilisateur travaille aujourd'hui
                if (!isset($horairesTravail[$currentDayOfWeek - 1])) {
                    continue; // Pas d'horaire défini pour ce jour
                }

                // Extraire les heures de début et de fin pour aujourd'hui
                $horaireDuJour = $horairesTravail[$currentDayOfWeek - 1];
                list($heureDebutJour, $heureFinJour) = explode('-', $horaireDuJour);

                if ($currentTime >= "09:00" && $currentTime <= "23:59") {
                    // Étape 2 : Vérifier si un pointage existe pour aujourd'hui
                    $queryCheck = "SELECT COUNT(*) as count FROM wbcc_pointage WHERE idUserF = :idUser AND datePointage = :currentDate";
                    $db->query($queryCheck);
                    $db->bind(':idUser', $idUser);
                    $db->bind(':currentDate', $currentDate);
                    $count = $db->single()->count;

                    // Si aucun pointage n'existe pour aujourd'hui, insérer un nouveau pointage
                    if ($count == 0) {
                        // Determine status based on the current time
                        $retard = 0;
                        $absent = 0;

                        if ($currentTime >= "09:00" && $currentTime <= "18:15") {
                            $retard = 1; // Late during working hours
                        } elseif ($currentTime > "18:15" && $currentTime <= "23:59") {
                            $absent = 1; // Absent after working hours
                        }

                        $queryInsert = "
                            INSERT INTO wbcc_pointage (
                                numeroPointage, datePointage, retard, absent, idUserF, heureDebutJour, heureFinJour , adresseProgramme
                            ) VALUES (
                                NULL, :currentDate, :retard, :absent, :idUser, :heureDebutJour, :heureFinJour, :adresseSite
                            )
                        ";
                        $db->query($queryInsert);
                        $db->bind(':currentDate', $currentDate);
                        $db->bind(':retard', $retard);
                        $db->bind(':absent', $absent);
                        $db->bind(':idUser', $idUser);
                        $db->bind(':heureDebutJour', $heureDebutJour);
                        $db->bind(':heureFinJour', $heureFinJour);
                        $db->bind(':adresseSite', $adresseSite);
                        $db->execute();
                    }
                }
            }
        }
        if ($action == 'getPointageTodayByidUtilisateur') {
            // Retrieve user ID from GET parameters
            $idUtilisateur = $_GET['idUtilisateur'] ?? null; // User ID

            if (empty($idUtilisateur)) {
                echo json_encode(0); // Return 0 if user ID is missing
                exit;
            }

            // Get today's date in the format used in the database
            $dateNow = date('Y-m-d');

            // Query to get today's pointage for the given user
            $query = "SELECT * FROM wbcc_pointage 
                      WHERE idUserF = :idUtilisateur 
                      AND datePointage = :dateNow";

            $db->query($query);
            $db->bind("idUtilisateur", $idUtilisateur);
            $db->bind("dateNow", $dateNow);

            $pointage = $db->single();

            // Check if any pointage is found
            if ($pointage) {
                echo json_encode($pointage);
            } else {
                echo json_encode(0); // Return 0 if no pointage is found for today
            }
        }
    }
    //FIN NABILA

    //JAWHAR
    if ($action == 'saveJustification2') {
        if (isset($_POST['pointage_id'], $_POST['type'])) {
            $pointage_id = $_POST['pointage_id'];
            $motif = $_POST['motif'];
            $type = $_POST['type'];
            $nomDocuments = isset($_POST['nomDocument']) ? $_POST['nomDocument'] : [];
            $comments = isset($_POST['comments']) ? $_POST['comments'] : [];

            $errorMessages = [];
            $successCount = 0;

            $motifColumn = $type === "Arrivé" ? "motifRetard" : ($type === "Départs" ? "motifRetardDepart" : "motifAbsent");
            $isArrive = $type === "Arrivé" ? 1 : ($type === "Départs" ? 0 : null);
            $isAbsent = $type === "Absence" ? 1 : 0;

            if (isset($_POST['modify']) && $_POST['modify'] == true) {
                $db->query("UPDATE wbcc_pointage SET $motifColumn = :motif WHERE idPointage = :idPointage");
                $db->bind("motif", $motif);
                $db->bind("idPointage", $pointage_id);

                if (!$db->execute()) {
                    $errorMessages[] = "Failed to update motif: " . $db->errorInfo();
                }
            } else {
                if (isset($_FILES['attachments']) && count($_FILES['attachments']['name']) > 0) {
                    $uploadDir = "../documents/personnel/pointage/justificatif/";
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
                        if ($_FILES['attachments']['error'][$i] == UPLOAD_ERR_OK) {
                            $uploadedFile = $_FILES['attachments']['tmp_name'][$i];
                            $originalFileName = $_FILES['attachments']['name'][$i];
                            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

                            if (!in_array($fileExtension, ['pdf', 'mp4', 'jpg', 'jpeg', 'png'])) {
                                $errorMessages[] = "Unsupported file type for $originalFileName";
                                continue;
                            }

                            $numeroDocument = "DOC" . date('dmYHis') . $pointage_id . $i;
                            $nomDocumentSanitized = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nomDocuments[$i] ?? "Unnamed_Document_$i");
                            $dateNow = date('YmdHis');
                            $urlDocument = 'Pj_' . $pointage_id . '_' . $nomDocumentSanitized . '_' . $dateNow . '.' . $fileExtension;

                            if (move_uploaded_file($uploadedFile, $uploadDir . $urlDocument)) {
                                $db->query("INSERT INTO wbcc_document (numeroDocument, nomDocument, urlDocument, commentaire, createDate, source, publie, urlDossier) 
                                            VALUES (:numeroDocument, :nomDocument, :urlDocument, :commentaire, NOW(), :source, :publie, 'personnel/pointage/justificatif')");
                                $db->bind("numeroDocument", $numeroDocument);
                                if (gettype($nomDocuments) == "string") {
                                    $db->bind("nomDocument", $nomDocuments ?? "Unnamed_Document_$i");
                                } else {
                                    $db->bind("nomDocument", $nomDocuments[$i] ?? "Unnamed_Document_$i");
                                }
                                $db->bind("urlDocument", $urlDocument);
                                if (gettype($comments) == "string") {
                                    $db->bind("commentaire", $comments ?? null);
                                } else {
                                    $db->bind("commentaire", $comments[$i] ?? null);
                                }
                                $db->bind("source", 'EXTRANET');
                                $db->bind("publie", 0);

                                if (!$db->execute()) {
                                    $errorMessages[] = "Failed to save document $originalFileName: " . $db->errorInfo();
                                    continue;
                                }

                                $idDocument = $db->lastInsertId();

                                $db->query("INSERT INTO wbcc_document_pointage (idDocumentF, idPointageF, isArrive, isAbsent) 
                                            VALUES (:idDocumentF, :idPointageF, :isArrive, :isAbsent)");
                                $db->bind("idDocumentF", $idDocument);
                                $db->bind("idPointageF", $pointage_id);
                                $db->bind("isArrive", $isArrive);
                                $db->bind("isAbsent", $isAbsent);

                                if (!$db->execute()) {
                                    $errorMessages[] = "Failed to link document $originalFileName: " . $db->errorInfo();
                                    continue;
                                }

                                $successCount++;
                            } else {
                                $errorMessages[] = "Failed to move uploaded file $originalFileName.";
                            }
                        } else {
                            $errorMessages[] = "Error uploading file $i: " . $_FILES['attachments']['error'][$i];
                        }
                    }
                }

                $db->query("UPDATE wbcc_pointage SET $motifColumn = :motif WHERE idPointage = :idPointage");
                $db->bind("motif", $motif);
                $db->bind("idPointage", $pointage_id);

                if (!$db->execute()) {
                    $errorMessages[] = "Failed to update pointage motif: " . $db->errorInfo();
                }
            }

            if (empty($errorMessages)) {
                echo json_encode(['success' => true, 'message' => "Request processed successfully. Total uploads: $successCount"]);
            } else {
                echo json_encode(['success' => false, 'message' => implode(", ", $errorMessages)]);
            }
        } else {
            echo json_encode("0");
        }
    }
}



function findItemByValue($nomTable, $col, $value)
{
    $db = new Database();
    $db->query("SELECT * FROM $nomTable WHERE $col = :numero");
    $db->bind("numero", $value, null);
    $data = $db->single();
    return $data;
}

function getPeriodDateRange($periode)
{
    $today = date('Y-m-d');
    $startDate = '';
    $endDate = $today;

    switch ($periode) {
        case 'semaine':
            // Start date of the week (Monday)
            $startDate = date('Y-m-d', strtotime('monday this week', strtotime($today)));
            break;
        case 'mois':
            // Start date of the month
            $startDate = date('Y-m-01', strtotime($today));
            break;
        case 'trimestre':
            // Start date of the current quarter
            $currentMonth = date('n', strtotime($today)); // Get the current month
            $currentQuarter = ceil($currentMonth / 3); // Determine the current quarter (1-4)
            $startMonth = ($currentQuarter - 1) * 3 + 1; // Calculate the start month of the quarter
            $startDate = date('Y-' . sprintf('%02d', $startMonth) . '-01', strtotime($today));
            break;
        case 'semestre':
            // Start date of the current semester
            $currentMonth = date('n', strtotime($today));
            $startMonth = ($currentMonth <= 6) ? 1 : 7; // January or July depending on the semester
            $startDate = date('Y-' . sprintf('%02d', $startMonth) . '-01', strtotime($today));
            break;
        case 'annuel':
            // Start date of the year
            $startDate = date('Y-01-01', strtotime($today));
            break;
        default:
            // If no specific period is matched, set the start date as today
            $startDate = $today;
            break;
    }

    return [
        'start' => $startDate,
        'end' => $endDate
    ];
}
