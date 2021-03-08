<?php 

ini_set('display_errors', '1');

require_once "../App/Autoloader.php";

use App\Autoloader;
use App\Model\{ClientManager, DNSFieldManager, DNSRecordManager, DomainManager};
use App\Model\Entity\ {Client, DNS_Field, DNS_Record, Domain};

Autoloader::register();


/**
 * Batterie de test concernant le ClientManager
 */


$test_ClientManager = null;
$clientManager = new ClientManager();
//$client = new Client(1, "Microsoft", "25/89/4445", "54/85/1254");


/* TEST - LoadClientFormId() */
$test_ClientManager = $clientManager->loadClient();
//$test_ClientManager = $clientManager->loadClientFromId(1);
//$test_ClientManager = $clientManager->loadClientFromId(2);
//$test_ClientManager = $clientManager->loadClientFromId(3);
//$test_ClientManager = $clientManager->loadClientFromId("a");
//TEST - BDD = Null
//$test_ClientManager = $clientManager->loadClientFromId(1);

/* TEST - UpdateName() */
//$test_ClientManager = $clientManager->updateName($client, $client->getName());


echo '<pre>';
var_dump($test_ClientManager["success"]);
echo '</pre>';



/**
 * Batterie de test concernant le DomainManager
 */

 /*
$test_DomainManager = null;
$domainManager = new DomainManager();
$client = new Client(1, "Microsoft", "25/89/4445", "54/85/1254");
*/

//$test_DomainManager = $domainManager->loadDomainFromClient($client);
//$test_DomainManager = $domainManager->loadDomainFromDomainId(16, $client); 
//$test_DomainManager = $domainManager->insertDomain("newDomain", "154.856.55.2", 1, $client);
//$test_DomainManager = $domainManager->updateDomain("modifDomain", "manage_dns", $client->getList_Domains()[0]);
//$test_DomainManager = $domainManager->updateDomain("modifDomain", "manghfghage_dns", $client->getList_Domains()[0]);
//$test_DomainManager = $domainManager->archiveDomain($client->getList_Domains()[0]);
//$test_DomainManager = $domainManager->deleteDomain($client->getList_Domains()[0]);
/*
echo '<pre>';
var_dump($test_DomainManager);
var_dump($client->getList_Domains());
echo '</pre>';*/


/**
 * Batterie de test concernant le DNSFieldManager
 */

 /*
 $test_DNSFieldManager = null;
 $DNSFieldManager = new DNSFieldManager();
 
 $test_DNSFieldManager = $DNSFieldManager->loadDNSField();
*/

/*
 echo '<pre>';
 var_dump($test_DNSFieldManager);
 echo '</pre>';
*/

/**
 * Batterie de test concernant le DNSRecordManager
 */

 /*
 $test_DNSRecordManager = null;
 $DNSRecordManager = new DNSRecordManager();
*/

 //$test_DNSRecordManager = $DNSRecordManager->loadDNSRecordFromDomain($client->getList_Domains()[0], $test_DNSFieldManager["list_DNSField"]);
 //$test_DNSRecordManager = $DNSRecordManager->loadDNSRecordFromId_listField(182, $client->getList_Domains()[0], $test_DNSFieldManager["list_DNSField"]);
 //$test_DNSRecordManager = $DNSRecordManager->loadDNSRecordFromId_objectField(182, $client->getList_Domains()[0], $test_DNSFieldManager["list_DNSField"][1]);
 //$test_DNSRecordManager = $DNSRecordManager->insertDNSRecord("unhost", "unevalue", $client->getList_Domains()[0], $test_DNSFieldManager["list_DNSField"][6]);
 //$test_DNSRecordManager = $DNSRecordManager->updateDNSRecord("hello-aurevoir.com", "value", $client->getList_Domains()[0]->getList_DNSRecord()[0]);
 //$test_DNSRecordManager = $DNSRecordManager->archiveDNSRecord($client->getList_Domains()[0]->getList_DNSRecord()[0], true);
 //$test_DNSRecordManager = $DNSRecordManager->deleteDNSRecord($client->getList_Domains()[0]->getList_DNSRecord()[0]);

 /*
 echo '<pre>';
 var_dump($test_DNSRecordManager);
 foreach($client->getList_Domains() as $domain){
     var_dump($domain->getList_DNSRecord());
 }
 echo '</pre>';
 */
?>