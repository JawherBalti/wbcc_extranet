<?php
header('Access-Control-Allow-Origin: *');
require_once "../../../app/config/config.php";
require_once "../../../app/libraries/Database.php";
require_once "../../../app/libraries/Utils.php";
require_once "../../../app/libraries/Model.php";
require_once "../../../app/models/Appel.php";

$db = new Database();
//Liste des parties privatives et communes
if (isset($_GET['action'])) {

    if ($_GET['action'] == "liste") {
        $db->query("SELECT * FROM vc_campagne_vocalcom");
        $campagnes = $db->resultSet();

        if (empty($campagnes)) {
            echo json_encode("0");
        } else {
            echo json_encode($campagnes);
        }
    }

    //DEBUT CAMPAGNE GESTION LOCATIVE PROSPECTION RHSR
    if ($_GET['action'] == "recapJournalier" && isset($_GET['DID'], $_GET['StatusGroup'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        $date = isset($_GET['date']) ? $_GET['date'] : "";
        $today = date("d-m-Y");
        // $yesterday = $date == "" ? date("Ymd", strtotime($today . "-1 days")) : date("Ymd", strtotime($date));
        $yesterday = $date == "" ? date("Ymd", strtotime($today)) : date("Ymd", strtotime($date));

        //Appels émis du jour
        $db->query("SELECT COUNT(*) as nbAppels, SUM(ap.dureeConversation) as duree FROM vc_fa_vocalcom as fa, wbcc_appel as ap  WHERE DID_CAMPAGNE = '$DID' AND DATE = '$yesterday' AND fa.STATUSGROUP = $StatusGroup AND fa.INDICE = ap.indiceAppel");
        // echo json_encode("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa  WHERE DID_CAMPAGNE = '$DID' AND DATE = '$yesterday' AND fa.STATUSGROUP = $StatusGroup");
        // die;
        $appels = $db->single();

        //Qualifications
        $statusArg = getQualificationsArgByDID($DID);
        $statusPos = getQualificationsPosByDID($DID);
        $data = [];
        foreach ($statusArg as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND DATE = '$yesterday'");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];

            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }

        foreach ($statusPos as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND DATE = '$yesterday'");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];
            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }

        $data[] = [
            "statutArg" => "Nombre Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->nbAppels),
        ];
        $data[] = [
            "statutArg" => "Durée Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->duree),
        ];

        $ret = ["recap" => $data, "date" => $yesterday];

        echo json_encode($ret);
    }

    if ($_GET['action'] == "recapJournalierAgent" && isset($_GET['DID'], $_GET['StatusGroup'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        $date = isset($_GET['date']) ? $_GET['date'] : "";
        #AGENTS
        $agents = getAgentsByCampagneJ($DID, $StatusGroup, $date);

        $today = date("d-m-Y");
        $data = [
            "agents"  => $agents,
            "date"     => $date == "" ? date("d-m-Y", strtotime($today)) : date("d-m-Y", strtotime($date))
            // "date"     => $date == "" ? date("d-m-Y", strtotime($today . "-1 days")) : date("d-m-Y", strtotime($date))
        ];
        echo json_encode($data);
    }

    if ($_GET['action'] == "recapProduction" && isset($_GET['DID'], $_GET['StatusGroup'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        #DEBUT FA
        $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID' AND fa.STATUSGROUP = $StatusGroup");
        $appels = $db->single();
        //Qualifications
        $statusArg = getQualificationsArgByDID($DID);
        $statusPos = getQualificationsPosByDID($DID);
        $data = [];
        foreach ($statusArg as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];

            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }
        foreach ($statusPos as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];
            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }

        $data[] = [
            "statutArg" => "Nombre Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->nbAppels),
        ];
        $data[] = [
            "statutArg" => "Durée Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->duree),
        ];

        echo json_encode($data);
    }

    if ($_GET['action'] == "getAgents" && isset($_GET['DID'])) {
        $DID = $_GET['DID'];
        #AGENTS
        $agents = getAgentsByCampagne($DID);

        $today = date("d-m-Y");
        $data = [
            "agents"  => $agents,
            "date"     =>  date("d-m-Y", strtotime($today . "-1 days"))
        ];
        echo json_encode($data);
    }

    if ($_GET['action'] == "recapProductionAgent" && isset($_GET['DID'], $_GET['StatusGroup'], $_GET['login'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        $login = $_GET['login'];

        $infos = getDetailAgentCampagne($DID, $StatusGroup, $login);
        echo json_encode($infos);
    }

    if ($_GET['action'] == "getQualifArg" && isset($_GET['DID'], $_GET['StatusGroup'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        #Records

        $statusArg = getQualificationsArgByDID($DID);
        $statusPos = getQualificationsPosByDID($DID);
        $data1 = [];

        $today = date("d-m-Y");
        $data1 = [
            "date"     =>  date("d-m-Y", strtotime($today . "-1 days")),
            "statusArg"         => array_merge($statusPos, $statusArg)
        ];
        echo json_encode($data1);
    }

    if ($_GET['action'] == "getEnregByQualif" && isset($_GET['DID'], $_GET['StatusCode'], $_GET['StatusDetail'])) {
        $DID = $_GET['DID'];
        $statusCode = $_GET['StatusCode'];
        $statusDetail = $_GET['StatusDetail'];

        $data1 = [];


        $db->query("SELECT * FROM vc_record_vocalcom as r, vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND INDICE=indiceAppel ");
        $res = $db->resultSet();

        $data = [
            "records" => $res
        ];
        echo json_encode($data);
    }

    if ($_GET['action'] == "getEnregistrement" && isset($_GET['DID'], $_GET['StatusGroup'])) {
        $DID = $_GET['DID'];
        $StatusGroup = $_GET['StatusGroup'];
        #Records
        $recordsCampagnePlusLongs =  getRecordsByCampagnePlusLongs($DID, $StatusGroup);
        $recordsCampagnePlusCourts =  getRecordsByCampagnePlusCourts($DID, $StatusGroup);
        $recordsCampagneHasard =  getRecordsByCampagneHasard($DID, $StatusGroup);

        $data1 = [];
        $today = date("d-m-Y");
        $data1 = [
            "date"     =>  date("d-m-Y", strtotime($today . "-1 days")),
            "recordsCampagnePlusCourts" => $recordsCampagnePlusCourts,
            "recordsCampagnePlusLongs" => $recordsCampagnePlusLongs,
            "recordsCampagneHasard" => $recordsCampagneHasard
        ];
        echo json_encode($data1);
    }

    //FIN CAMPAGNE GESTION LOCATIVE

    if ($_GET['action'] == 'save') {
        $_POST = json_decode(file_get_contents('php://input'), true);
        extract($_POST);
        $camp = findCampagneByOid($Oid);

        if ($camp) {
            $db->query("UPDATE vc_campagne_vocalcom SET Description=:description,Type=:type, State=:state,StatusGroup=:status, DBName=:dbname, DID=:DID WHERE Oid=:oid");
        } else {
            $db->query("INSERT INTO vc_campagne_vocalcom(Oid,Description,Type,State,DBName,DID,StatusGroup) VALUES (:oid, :description, :type, :state, :dbname, :DID, :status)");
        }
        $db->bind("oid", $Oid, null);
        $db->bind("description", $Description, null);
        $db->bind("type", $Type, null);
        $db->bind("state", $State, null);
        $db->bind("dbname", $DBName, null);
        $db->bind("DID", $DID, null);
        $db->bind("status", $StatusGroup, null);

        if ($db->execute()) {
            echo json_encode($camp);
        } else {
            echo json_encode("0");
        }
    }

    if ($_GET['action'] == 'saveODCalls' && isset($_GET['DID'], $_GET['date'])) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $appelModel = new Appel();
        $ok = 0;
        foreach ($_POST as $key => $appel) {

            $ok =   $appelModel->save($appel);
        }
        echo json_encode($ok);
    }

    if ($_GET['action'] == 'saveFA' && isset($_GET['DID'], $_GET['date'])) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $DID = $_GET['DID'];
        $today = date("d-m-Y");
        $now = $_GET['date'];
        // $db->query("DELETE FROM vc_fa_vocalcom WHERE DID_CAMPAGNE = '$DID' AND DATE='$now'");
        // $db->execute();
        $ok = 0;

        foreach ($_POST as $key => $appel) {
            extract($appel);

            if ($DATE == $now) {
                $db->query("SELECT * FROM vc_fa_vocalcom WHERE INDICE ='$INDICE'");
                $apBD = $db->single();
                if ($apBD) {
                    $db->query("UPDATE vc_fa_vocalcom SET DATE=:DATE,HEURE=:HEURE,ID_TV=:ID_TV,TV=:TV,STATUS=:STATUS,LIB_STATUS=:LIB_STATUS,HISTORIQUE=:HISTORIQUE,TEL=:TEL,TEL1=:TEL1,NBAPPELS=:NBAPPELS,DUREE=:DUREE,TEL_DISPLAY=:TEL_DISPLAY,DID_CAMPAGNE=:DID_CAMPAGNE,STATUSGROUP=:STATUSGROUP,DETAIL=:DETAIL,LIB_DETAIL=:LIB_DETAIL,idCompanyGroupF=:idCompany WHERE INDICE=:INDICE");
                } else {
                    $db->query("INSERT INTO vc_fa_vocalcom(INDICE,DATE,HEURE,ID_TV,TV,STATUS,LIB_STATUS,HISTORIQUE,TEL,TEL1,NBAPPELS,DUREE,TEL_DISPLAY,DID_CAMPAGNE,STATUSGROUP,DETAIL,LIB_DETAIL,idCompanyGroupF) VALUES (:INDICE,:DATE,:HEURE,:ID_TV,:TV,:STATUS,:LIB_STATUS,:HISTORIQUE,:TEL,:TEL1,:NBAPPELS,:DUREE,:TEL_DISPLAY,:DID_CAMPAGNE,:STATUSGROUP,:DETAIL,:LIB_DETAIL,:idCompany)");
                }

                $db->bind("INDICE", $INDICE, null);
                $db->bind("DATE", $DATE, null);
                $db->bind("HEURE", $HEURE, null);
                $db->bind("ID_TV", $ID_TV, null);
                $db->bind("TV", $TV, null);
                $db->bind("STATUS", $STATUS, null);
                $db->bind("STATUSGROUP", $STATUSGROUP, null);
                $db->bind("LIB_STATUS", $LIB_STATUS, null);
                $db->bind("HISTORIQUE", $HISTORIQUE, null);
                $db->bind("TEL", $TEL, null);
                $db->bind("TEL1", $TEL1, null);
                $db->bind("NBAPPELS", $NBAPPELS, null);
                $db->bind("DUREE", $DUREE, null);
                $db->bind("TEL_DISPLAY", $TEL_DISPLAY, null);
                $db->bind("DID_CAMPAGNE", $DID, null);
                $db->bind("DETAIL", $DETAIL, null);
                $db->bind("LIB_DETAIL", $LIB_DETAIL, null);
                $db->bind("idCompany", trim($idSociete), null);

                if ($db->execute()) {
                    $ok = 1;
                } else {
                    $ok = 0;
                }
            }
        }
        echo json_encode($ok);
    }

    if ($_GET['action'] == 'saveAGENT') {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $db->query("TRUNCATE vc_agent_vocalcom");
        $db->execute();
        $ok = "ko";
        foreach ($_POST as $key => $agent) {
            extract($agent);
            extract($identR);
            extract($humanR);
            $db->query("INSERT INTO vc_agent_vocalcom(Oid,FirstName,LastName,LoginName,Ident,Password,OutCampaigns,Email,WorkspaceOid) VALUES (:Oid,:FirstName,:LastName,:LoginName,:Ident,:Password,:OutCampaigns,:Email,:WorkspaceOid)");

            $db->bind("Oid", $Oid, null);
            $db->bind("FirstName", $FirstName, null);
            $db->bind("LastName", $LastName, null);
            $db->bind("LoginName", $LoginName, null);
            $db->bind("Ident", $identR['Ident1'], null);
            $db->bind("Password", $Password, null);
            $db->bind("OutCampaigns", $OutCampaigns, null);
            $db->bind("Email", $Email, null);
            $db->bind("WorkspaceOid", $WorkspaceOid, null);

            if ($db->execute()) {
                $ok = "ok";
            } else {
                $ok = "ko";
            }
        }
        echo json_encode($ok);
    }

    if ($_GET['action'] == 'saveRecord' && isset($_GET['date'])) {
        $DID = $_GET['DID'];
        $name = $_FILES["file"]["name"];
        $filepath = $_FILES["file"]["tmp_name"];
        $size = $_FILES["file"]["size"];
        $tab = explode("#", $name);
        $codeAgent = $tab[0];
        $date = $tab[1];
        $heure = $tab[2];
        $indice = explode(".", $tab[3])[0];
        $now = $_GET['date'];

        if ($date == $now) {
            $newName = str_replace("#", "_", $name);
            $appel = findAppelByIndiceAndDID($indice, $DID);

            if ($appel) {
                $info = $appel->TV;
                $statut = $appel->LIB_STATUS;

                if (!file_exists("../../recordsVocalcom/" . $newName)) {
                    if (move_uploaded_file($filepath, "../../recordsVocalcom/" . $newName)) {
                        $db->query("INSERT INTO vc_record_vocalcom(DID,date,heure,indiceAppel,codeAgent,nomFichier,tailleFichier, infoAgent, qualification) 
                                    VALUES('$DID', '$date', '$heure','$indice','$codeAgent','$newName','$size','$info','$statut') ");

                        if ($db->execute()) {
                            echo json_encode("1");
                        } else {
                            echo json_encode("0");
                        }
                    } else {
                        echo json_encode("Error move file");
                    }
                } else {
                    $db->query("UPDATE vc_record_vocalcom SET DID='$DID',date='$date',heure='$heure',indiceAppel='$indice',codeAgent='$codeAgent',nomFichier='$newName',tailleFichier='$size',infoAgent='$info', qualification='$statut' WHERE indiceAppel='$indice' AND DID='$DID' AND date='$date' AND heure='$heure'");

                    if ($db->execute()) {
                        echo json_encode("Update 1");
                    } else {
                        echo json_encode("Update 0");
                    }
                }
            } else {
                echo json_encode("Appel Not Exist" . $indice);
            }
        }
    }


    if ($_GET['action'] == 'saveQualification' && isset($_GET['statusGroup'])) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $status = $_GET['statusGroup'];

        $db->query("DELETE FROM vc_status_vocalcom WHERE StatusGroup = $status");
        $db->execute();

        $ok = "ko";
        foreach ($_POST as $key => $stat) {
            extract($stat);

            $db->query("INSERT INTO vc_status_vocalcom(Oid,StatusGroup,StatusCode,StatusDetail,StatusText,Comment,Positive,Argued,Defaut,Cost,Currency,ValidQuota,Shared) VALUES (:Oid,:StatusGroup,:StatusCode,:StatusDetail,:StatusText,:Comment,:Positive,:Argued,:Defaut,:Cost,:Currency,:ValidQuota,:Shared)");

            $db->bind("Oid", $Oid, null);
            $db->bind("StatusGroup", $StatusGroup, null);
            $db->bind("StatusCode", $StatusCode, null);
            $db->bind("StatusDetail", $StatusDetail, null);
            $db->bind("StatusText", $StatusText, null);
            $db->bind("Comment", $Comment, null);
            $db->bind("Positive", $Positive, null);
            $db->bind("Argued", $Argued, null);
            $db->bind("Defaut", $Defaut, null);
            $db->bind("Cost", $Cost, null);
            $db->bind("Currency", $Currency, null);
            $db->bind("ValidQuota", $ValidQuota, null);
            $db->bind("Shared", $Shared, null);

            if ($db->execute()) {
                $ok = "ok";
            } else {
                $ok = "ko";
            }
        }
        echo json_encode("Qualification_$ok");
    }
}


//valide
function getQualificationsArgByDID($DID)
{

    $db = new Database();
    $db->query("SELECT * FROM vc_campagne_vocalcom camp,vc_status_vocalcom stat WHERE DID ='$DID' AND camp.StatusGroup = stat.StatusGroup AND Argued='1' AND Positive='0'");
    return $db->resultSet();
}

//valide
function getQualificationsPosByDID($DID)
{

    $db = new Database();
    $db->query("SELECT * FROM vc_campagne_vocalcom camp,vc_status_vocalcom stat WHERE DID ='$DID' AND camp.StatusGroup = stat.StatusGroup AND Positive='1' AND Argued='1'");
    return $db->resultSet();
}

//valide
function findCampagneByOid($oid)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_campagne_vocalcom WHERE Oid = :oid");
    $db->bind("oid", $oid, null);
    return $db->single();
}


//valide
function findAppelByIndiceAndDID($indice, $DID)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_fa_vocalcom WHERE INDICE = :indice AND DID_CAMPAGNE = :DID");
    $db->bind("DID", $DID, null);
    $db->bind("indice", $indice, null);
    return $db->single();
}

//valide
function getAgentsByCampagneJ($DID, $StatusGroup, $date)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_agent_vocalcom WHERE OutCampaigns LIKE '%$DID%'");
    $agents = [];
    $data1 = $db->resultSet();


    foreach ($data1 as $key => $agent) {
        $today = date("d-m-Y");
        // $yesterday = $date == "" ?  date("Ymd", strtotime($today . "-1 days")) : date("d-m-Y", strtotime($date));
        $yesterday = $date == "" ?  date("Ymd", strtotime($today)) : date("d-m-Y", strtotime($date));
        $codeAgent = $agent->Ident;
        //Appels émis du jour
        $db->query("SELECT COUNT(*) as nbAppels, SUM(appel.dureeConversation) as duree FROM vc_fa_vocalcom as fa, wbcc_appel as appel  WHERE DID_CAMPAGNE = '$DID' AND DATE = '$yesterday' AND fa.STATUSGROUP = $StatusGroup AND ID_TV='$codeAgent' AND fa.INDICE=appel.indiceAppel");
        $appels = $db->single();

        //Qualifications
        $statusArg = getQualificationsArgByDID($DID);
        $statusPos = getQualificationsPosByDID($DID);
        $data = [];
        foreach ($statusArg as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(appel.dureeConversation) as duree FROM vc_fa_vocalcom as fa, wbcc_appel as appel WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND DATE = '$yesterday' AND ID_TV='$codeAgent'  AND fa.INDICE=appel.indiceAppel");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];

            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }
        foreach ($statusPos as $key => $stat) {
            $statusCode = $stat->StatusCode;
            $statusDetail = $stat->StatusDetail;
            $db->query("SELECT COUNT(*) as nbAppels, SUM(appel.dureeConversation) as duree FROM vc_fa_vocalcom as fa, wbcc_appel as appel WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND DATE = '$yesterday' AND ID_TV='$codeAgent' AND fa.INDICE=appel.indiceAppel");
            $res = $db->single();
            $data[] = [
                "statutArg" => "Nombre Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->nbAppels)
            ];
            $data[] = [
                "statutArg" => "Durée Appels " . $stat->StatusText,
                "nbAppels" => my_formatNumberEspace($res->duree)
            ];
        }

        $data[] = [
            "statutArg" => "Nombre Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->nbAppels),
        ];
        $data[] = [
            "statutArg" => "Durée Appels Emis",
            "nbAppels" => my_formatNumberEspace($appels->duree),
        ];

        $recordsPlusLongsJ = getRecordsLongsByCampagneAndAgentJ($DID, $agent->Ident, $yesterday);
        $recordsPlusCourtsJ = getRecordsCourtsByCampagneAndAgentJ($DID, $agent->Ident, $yesterday);
        $recordsHasardJ = getRecordsHasardByCampagneAndAgentJ($DID, $agent->Ident, $yesterday);

        $agents[] = [
            "agent" => $agent,
            "recordsCourtsJ" => $recordsPlusCourtsJ,
            "recordsLongsJ" => $recordsPlusLongsJ,
            "recordsHasardJ" => $recordsHasardJ,
            "statistique"   => $data
        ];
    }

    return $agents;
}

//valide
function getAgentsByCampagne($DID)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_agent_vocalcom WHERE OutCampaigns LIKE '%$DID%'");
    $agents = $db->resultSet();
    return $agents;
}

function getDetailAgentCampagne($DID, $StatusGroup, $login)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_agent_vocalcom WHERE OutCampaigns LIKE '%$DID%' AND LoginName='$login' LIMIT 1");
    $agent = $db->single();
    $today = date("d-m-Y");
    $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $login = $agent->LoginName;
    //Appels émis du jour
    $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa  WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUSGROUP = $StatusGroup AND ID_TV='$login'");
    $appels = $db->single();

    //Qualifications
    $statusArg = getQualificationsArgByDID($DID);
    $statusPos = getQualificationsPosByDID($DID);
    $data = [];
    foreach ($statusArg as $key => $stat) {
        $statusCode = $stat->StatusCode;
        $statusDetail = $stat->StatusDetail;
        $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND ID_TV='$login'");
        $res = $db->single();
        $data[] = [
            "statutArg" => "Nombre Appels " . $stat->StatusText,
            "nbAppels" => my_formatNumberEspace($res->nbAppels)
        ];

        $data[] = [
            "statutArg" => "Durée Appels " . $stat->StatusText,
            "nbAppels" => my_formatNumberEspace($res->duree)
        ];
    }
    foreach ($statusPos as $key => $stat) {
        $statusCode = $stat->StatusCode;
        $statusDetail = $stat->StatusDetail;
        $db->query("SELECT COUNT(*) as nbAppels, SUM(DUREE) as duree FROM vc_fa_vocalcom as fa WHERE DID_CAMPAGNE = '$DID'  AND fa.STATUS = $statusCode AND fa.DETAIL = $statusDetail AND ID_TV='$login'");
        $res = $db->single();
        $data[] = [
            "statutArg" => "Nombre Appels " . $stat->StatusText,
            "nbAppels" => my_formatNumberEspace($res->nbAppels)
        ];
        $data[] = [
            "statutArg" => "Durée Appels " . $stat->StatusText,
            "nbAppels" => my_formatNumberEspace($res->duree)
        ];
    }

    $data[] = [
        "statutArg" => "Nombre Appels Emis",
        "nbAppels" => my_formatNumberEspace($appels->nbAppels),
    ];
    $data[] = [
        "statutArg" => "Durée Appels Emis",
        "nbAppels" => my_formatNumberEspace($appels->duree),
    ];

    $recordsPlusLongs = getRecordsLongsByCampagneAndAgent($DID, $agent->LoginName);
    $recordsPlusCourts = getRecordsCourtsByCampagneAndAgent($DID, $agent->LoginName);
    $recordsHasard = getRecordsHasardByCampagneAndAgent($DID, $agent->LoginName);

    $agents = [
        "agent" => $agent,
        "recordsCourts" => $recordsPlusCourts,
        "recordsLongs" => $recordsPlusLongs,
        "recordsHasard" => $recordsHasard,
        "statistique"   => $data
    ];

    return $agents;
}

//valide
function getRecordsLongsByCampagneAndAgentJ($DID, $agent, $date)
{
    $db = new Database();
    // $today = date("d-m-Y");
    // $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent' AND date ='$date' ORDER BY tailleFichier DESC LIMIT 10");
    return $db->resultSet();
}

//valide
function getRecordsCourtsByCampagneAndAgentJ($DID, $agent, $date)
{
    $db = new Database();
    // $today = date("d-m-Y");
    // $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent' AND date ='$date' ORDER BY tailleFichier ASC LIMIT 10");
    return $db->resultSet();
}

//valide
function getRecordsHasardByCampagneAndAgentJ($DID, $agent)
{
    $db = new Database();
    $today = date("d-m-Y");
    $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent' AND date ='$yesterday' ORDER BY  RAND() LIMIT 10");
    return $db->resultSet();
}

//valide
function getRecordsLongsByCampagneAndAgent($DID, $agent)
{
    $db = new Database();
    $today = date("d-m-Y");
    $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent'  ORDER BY tailleFichier DESC LIMIT 10");
    return $db->resultSet();
}

//valide
function getRecordsCourtsByCampagneAndAgent($DID, $agent)
{
    $db = new Database();
    $today = date("d-m-Y");
    $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent'  ORDER BY tailleFichier ASC LIMIT 10");
    return $db->resultSet();
}

//valide
function getRecordsHasardByCampagneAndAgent($DID, $agent)
{
    $db = new Database();
    $today = date("d-m-Y");
    $yesterday =  date("Ymd", strtotime($today . "-1 days"));
    $db->query("SELECT * FROM vc_record_vocalcom  WHERE DID='$DID' AND codeAgent='$agent'  ORDER BY RAND() LIMIT 10");
    return $db->resultSet();
}


//valide
function getRecordsByCampagnePlusLongs($DID)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_record_vocalcom WHERE DID='$DID'  ORDER BY tailleFichier DESC LIMIT 10");

    return $db->resultSet();
}

//valide
function getRecordsByCampagnePlusCourts($DID)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_record_vocalcom WHERE DID='$DID' ORDER BY tailleFichier ASC LIMIT 10");

    return $db->resultSet();
}

function getRecordsByCampagneHasard($DID)
{
    $db = new Database();
    $db->query("SELECT * FROM vc_record_vocalcom WHERE DID='$DID' ORDER BY RAND() LIMIT 10");

    return $db->resultSet();
}
