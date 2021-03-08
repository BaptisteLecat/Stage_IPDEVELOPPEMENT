<?php

use App\Model\ClientManager;
use App\Model\DNSFieldManager;
use App\Model\DNSRecordManager;
use App\Model\DomainManager;
use App\Autoloader;
use App\PdoFactory;

require_once('../App/Autoloader.php');
require_once('loader.php');

class Controller
{
    private $clientManager;
    private $domainManager;
    private $DNSRecordManager;
    private $DNSFieldManager;

    private $list_client;

    private $css_link;
    private $js_script;
    private $title;
    private $content;

    function __construct()
    {
        Autoloader::register();
        PdoFactory::init();
        $this->clientManager = new ClientManager();
        $this->domainManager = new DomainManager();
        $this->DNSRecordManager = new DNSRecordManager();
        $this->DNSFieldManager = new DNSFieldManager();

        $this->list_client = array();
        $this->list_DNSField = array();
        $this->css_link = array('home');
        $this->js_script = array('dashboard_domaine');
        $this->title = "Convertisseur Zone DNS";
        $this->content = "";
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getList_DNSField()
    {
        return $this->list_DNSField;
    }

    /****************************************/
    /****************LOADERS*****************/
    /****************************************/

    private function reloadClient()
    {
        try {
            $list_client = array();

            //Chargement en amont de la liste de tout les clients.
            $this->list_client = loadClient($this->clientManager, $this->list_client);

            foreach ($this->list_client as $client) {
                //Permet de recharger la liste de Domains et donc de DNSRecord lors de l'actualisation de la page, sans avoir de doublon.
                if ($client->getList_Domains() != null) {
                    $client->setList_Domains(array());
                }
                //Loading des données.
                loadClientDomain($client, $this->domainManager);
                $this->list_DNSField = loadDNSField($this->DNSFieldManager);
                loadClientDNSRecord($client, $this->list_DNSField, $this->DNSRecordManager);

                //Ajout du client charger dans la liste des clients.
                array_push($list_client, $client);
            }

            //Actualisation de la variable de session, avec les nouvelles données.
            $_SESSION["list_client"] = serialize($list_client);
        } catch (Exception $e) {
            throw new Exception(ERROR_LOADING);
        }
    }

    /****************************************/
    /***************HTML VIEWS***************/
    /****************************************/

    public function head()
    {
        try {
            $head = '
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <link href="' . FONT_HREF . '" rel="stylesheet">
            ';
            $head .= $this->loadcss_link();
            $head .= '<title>' . $this->getTitle() . '</title>';
            $head .= '</head>';
        } catch (Exception $e) {
            throw new Exception(ERROR_LOAD_HEAD);
        }
        return $head;
    }

    private function loadcss_link()
    {
        try {
            $html_link = "";
            foreach ($this->css_link as $css) {
                $html_link .= '<link rel="stylesheet" href="assets/css/' . $css . '.css">
            ';
            }
        } catch (Exception $e) {
            throw new Exception(ERROR_LOAD_CSS);
        }
        return $html_link;
    }

    public function loadjs_script()
    {
        try {
            $html_link = "";
            foreach ($this->js_script as $js) {
                $html_link .= '<script src="module/' . $js . '.js"></script>
            ';
            }
        } catch (Exception $e) {
            throw new Exception(ERROR_LOAD_JS);
        }
        return $html_link;
    }

    /****************************************/
    /************DISPLAYER VIEWS************/
    /****************************************/

    public function displayDashboard($action = null, $mode = null)
    {
        try{
            $this->reloadClient();

            switch ($action) {
                default:
                    //dashboard
                    $list_module = array("display", "client", "domaine", "dns");
                    $this->title = "Dashboard";
                    $this->css_link = array("home", "display", "client", "form/template", "form/insertDNS", "form/insertDNSZone", "form/insertDomain");
                    if ($mode == "client") {
                        $this->js_script = array("domain/select/selectDomain_client", "client/select/selectClient_client", "dashboard_client", "domain/display/displayDomain", "dnsRecord/display/displayEditDNS", "dnsRecord/archive/archiveDNSRecord", "../form/form_displayer", "../form/dns/form_insertDNS", "../form/domain/form_insertDomain", "../form/domain/form_updateDomain", "../form/domain/form_deleteDomain", "../form/dns/form_generatorDNS", "../form/dns/form_insertDNSZone", "dnsRecord/delete/deleteDNSRecord", "dnsRecord/update/editDNSRecord", "dnsRecord/restore/restoreDNSRecord", "domain/manageDNS/manageDNS");
                    } else {
                        $this->js_script = array("domain/select/selectDomain_domain", "client/select/selectClient_domain", "dashboard_domaine", "domain/display/displayDomain", "dnsRecord/display/displayEditDNS", "dnsRecord/archive/archiveDNSRecord", "../form/form_displayer", "../form/dns/form_insertDNS", "../form/domain/form_insertDomain", "../form/domain/form_updateDomain", "../form/domain/form_deleteDomain", "../form/dns/form_generatorDNS", "../form/dns/form_insertDNSZone", "dnsRecord/delete/deleteDNSRecord", "dnsRecord/update/editDNSRecord", "dnsRecord/restore/restoreDNSRecord", "domain/manageDNS/manageDNS");
                    }
                    require("dashboard.php");
                    break;
            }
        }catch(Exception $e){
            throw new Exception($e);
        }
    }
}
