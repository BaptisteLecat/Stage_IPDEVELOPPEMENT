<?php

/**
 * File call in AJAX to set the value of "manageDNS" true or false when the checkbox value is activated
 */

require_once "../../../../App/Autoloader.php";

use App\Autoloader;
use App\Model\DomainManager;
use App\PdoFactory;

try {
    session_start();
    Autoloader::register();
    PdoFactory::init();

    $domainManager = new DomainManager();
    $list_client = unserialize($_SESSION["list_client"]);
    $idDomain = $_POST["idDomain"];
    $checkState = $_POST["checkState"];
    $success = 0;

    $breakState = false;
    foreach ($list_client as $client) {
        foreach ($client->getList_Domains() as $domain) {
            if ($domain->getId() == $idDomain) {
                $domainManager->updateDomain($domain->getDomainName(), $domain->getServerDNS(), $checkState, $domain);
                $success = 1;
                $breakState = true;
                break;
            }
        }
        if ($breakState) {
            break;
        }
    }

    $list_client = unserialize($_SESSION["list_client"]);
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

$response = ["success" => $success];

echo json_encode($response);
