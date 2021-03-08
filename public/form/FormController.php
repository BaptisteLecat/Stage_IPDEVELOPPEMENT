<?php

use App\Model\ClientManager;
use App\Model\DNSFieldManager;
use App\Model\DNSRecordManager;
use App\Model\DomainManager;
use App\Autoloader;
use App\PdoFactory;

use App\Form\ModalDNS;
use App\Form\ModalDNSZone;
use App\Form\ModalDomain;

require_once('../../App/Autoloader.php');

class FormController
{
    private $clientManager;
    private $domainManager;
    private $DNSRecordManager;
    private $DNSFieldManager;

    private $modalDNS;
    private $modalDomain;
    private $modalDNSZone;

    private $list_client;
    private $list_DNSField;

    private $title;
    private $subTitle;
    private $success;
    private $content;
    private $errorMessage;

    function __construct()
    {
        Autoloader::register();
        PdoFactory::init();
        $this->clientManager = new ClientManager();
        $this->domainManager = new DomainManager();
        $this->DNSRecordManager = new DNSRecordManager();
        $this->DNSFieldManager = new DNSFieldManager();
        $this->setList_DNSField();

        $this->success = 1;
        $this->content = "";
        $this->errorMessage = null;
        if (isset($_SESSION["list_client"])) {
            $this->list_client = unserialize($_SESSION["list_client"]);
        } else {
            //Message d'erreur.
        }

        $this->modalDNS = new ModalDNS($this);
        $this->modalDomain = new ModalDomain($this);
        $this->modalDNSZone = new ModalDNSZone($this);
    }

    public function __sleep()
    {
        return ["modalDNS", "modalDomain", "title", "subTitle"];
    }

    public function __wakeup()
    {
        Autoloader::register();
        $this->clientManager = new ClientManager();
        $this->domainManager = new DomainManager();
        $this->DNSRecordManager = new DNSRecordManager();
        $this->DNSFieldManager = new DNSFieldManager();
        $this->list_DNSField = $this->setList_DNSField();

        $this->success = 1;
        $this->content = "";
        $this->errorMessage = null;
        if (isset($_SESSION["list_client"])) {
            $this->list_client = unserialize($_SESSION["list_client"]);
        } else {
            //Message d'erreur.
        }
    }

    private function setList_DNSField()
    {
        $this->list_DNSField = array();
        $resultLoadDNSField = $this->DNSFieldManager->loadDNSField();
        if ($resultLoadDNSField["success"]) {
            $this->list_DNSField = $resultLoadDNSField["list_DNSField"];
        }
    }

    public function getDomainManager()
    {
        return $this->domainManager;
    }

    public function getDNSRecordManager()
    {
        return $this->DNSRecordManager;
    }

    public function getList_DNSField()
    {
        return $this->list_DNSField;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubTitle()
    {
        return $this->subTitle;
    }

    public function getList_Client()
    {
        return $this->list_client;
    }

    /****************************************/
    /************DISPLAYER VIEWS************/
    /****************************************/

    public function displayForm($form = null, $idDomain = null, $idClient = null, $action = null, $formData = null)
    {
        $modal = "";
        switch ($form) {
            case 'insertDNS':
                //Définition des attributs du formulaire.
                $this->title = "Ajouter un nouveau champ DNS";
                $this->subTitle = "Formulaire de saisie d'un nouveau DNS";
                if ($idDomain != null) {
                    if ($action == "submit") {
                        if ($formData != null) {
                            $formData = json_decode($_POST["formData"], true);
                            try {
                                $this->modalDNS->submitInsertDNS($formData["subDomain"], $formData["type"], $formData["target"], $formData["priority"], $idDomain);
                                $this->setSuccess(1);
                                $this->setErrorMessage(SUCCESS_FORMINSERT);
                            } catch (Exception $e) {
                                $this->setSuccess(0);
                                $this->setErrorMessage($e->getMessage());
                            }
                        } else {
                            $this->setErrorMessage("Aucun formData n'a été transmis !");
                            $this->setSuccess(0);
                        }
                    }
                    require("../../view/form/modal-insertDNS.php");
                    require("../../view/form/modal-template.php");
                } else {
                    $this->setErrorMessage("Aucun Id de domaine n'a été transmis !");
                    $this->setSuccess(0);
                }
                break;

            case 'insertDNSZone':
                //Définition des attributs du formulaire.
                $this->title = "Ajouter une Zone DNS";
                $this->subTitle = "Formulaire de saisie d'une zone DNS";
                if ($idDomain != null) {
                    if ($action == "submit") {
                        if ($formData != null) {
                            $formData = json_decode($_POST["formData"], true);
                            try {
                                $this->modalDNSZone->submitInsertDNSZone($formData["zoneDNS"], $idDomain);
                                $this->setSuccess(1);
                                $this->setErrorMessage(SUCCESS_FORMINSERT);
                            } catch (Exception $e) {
                                $this->setSuccess(0);
                                $this->setErrorMessage($e->getMessage());
                            }
                        } else {
                            $this->setErrorMessage("Aucun formData n'a été transmis !");
                            $this->setSuccess(0);
                        }
                    }
                    require("../../view/form/modal-insertDNSZone.php");
                    require("../../view/form/modal-template.php");
                } else {
                    $this->setErrorMessage("Aucun Id de domaine n'a été transmis !");
                    $this->setSuccess(0);
                }
                break;

            case 'insertDomain':
                //Définition des attributs du formulaire.
                $this->title = "Ajouter un nouveau domaine";
                $this->subTitle = "Formulaire de saisie d'un nouveau domaine";
                if ($idClient != null) {
                    if ($action == "submit") {
                        if ($formData != null) {
                            $formData = json_decode($_POST["formData"], true);
                            try {
                                $this->modalDomain->submitInsertDomain($formData["domainName"], $formData["serverDNS"], $formData["manageDNS"], $idClient);
                                $this->setSuccess(1);
                                $this->setErrorMessage(SUCCESS_FORMINSERT);
                            } catch (Exception $e) {
                                $this->setSuccess(0);
                                $this->setErrorMessage($e->getMessage());
                            }
                        } else {
                            $this->setErrorMessage("Aucun formData n'a été transmis !");
                            $this->setSuccess(0);
                        }
                    }
                    require("../../view/form/modal-insertDomain.php");
                    require("../../view/form/modal-template.php");
                } else {
                    $this->setErrorMessage("Aucun Id de client n'a été transmis !");
                    $this->setSuccess(0);
                }
                break;

            case 'updateDomain':
                //Définition des attributs du formulaire.
                $this->title = "Modifier un domaine";
                $this->subTitle = "Formulaire de modification d'un domaine";
                if ($idDomain != null && $idClient != null) {
                    if ($action == "update") { //Autrement on affiche juste la modal
                        if ($formData != null) {
                            $formData = json_decode($_POST["formData"], true);
                            try {
                                $this->modalDomain->submitUpdateDomain($formData["domainName"], $formData["serverDNS"], $formData["manageDNS"], $idClient, $idDomain);
                                $this->setSuccess(1);
                                $this->setErrorMessage(SUCCESS_FORMUPDATE);
                            } catch (Exception $e) {
                                $this->setSuccess(0);
                                $this->setErrorMessage($e->getMessage());
                            }
                        } else {
                            $this->setErrorMessage("Aucun formData n'a été transmis !");
                            $this->setSuccess(0);
                        }
                    } else {
                        if ($action == "delete") {
                            $this->deleteDomain($idDomain);
                        }
                    }
                    require("../../view/form/modal-updateDomain.php");
                    require("../../view/form/modal-template.php");
                } else {
                    $this->setErrorMessage("Aucun Id de domain ou client n'a été transmis !");
                }
                break;

            default:
                $this->setErrorMessage("Une erreur s'est produite..");
                $this->success = 0;
                break;
        }
    }

    public function deleteDomain($idDomain)
    {
        try {
            $this->modalDomain->submitDeleteDomain($idDomain);
            $this->setSuccess(1);
            $this->setErrorMessage(SUCCESS_FORMDELETE);
        } catch (Exception $e) {
            $this->setSuccess(0);
            $this->setErrorMessage($e->getMessage());
        }
    }
}
