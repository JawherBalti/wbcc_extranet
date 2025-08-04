<?php
$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
    case 'getRegionsFrance':
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://geo.api.gouv.fr/regions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $regionsJson = curl_exec($ch);
        curl_close($ch);
        echo $regionsJson;
        break;

    case 'getDepartementsByCoderegion':
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://geo.api.gouv.fr/regions/$code/departements");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $depsJson = curl_exec($ch);
        curl_close($ch);
        echo $depsJson;
        break;
}
