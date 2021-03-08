<?php

namespace App\Form;

use Exception;

class ModalDomain
{
    private $list_client;
    private $controllerObject;

    function __construct($controllerObject)
    {
        $this->controllerObject = $controllerObject;
        $this->list_client = $this->controllerObject->getList_Client();
    }

    public function getDomainObject($idDomain)
    {
        try {
            $domainObject = null;
            $breakState = false;
            foreach ($this->list_client as $client) {
                foreach ($client->getList_Domains() as $domain) {
                    if ($domain->getId() == $idDomain) {
                        $domainObject = $domain;
                        $breakState = true;
                        break;
                    }
                }

                if ($breakState) {
                    break;
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $domainObject;
    }

    public function getClientObject($idClient)
    {
        try {
            $clientObject = null;
            foreach ($this->list_client as $client) {
                if ($client->getId() == $idClient) {
                    $clientObject = $client;
                    break;
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $clientObject;
    }

    public function submitInsertDomain($domainName, $serverDNS, $manageDNS, $idClient)
    {
        try {
            $clientObject = $this->getClientObject($idClient);
            //Verification de la saisie.
            $resultCheckDomainName = $this->checkDomainNameValue($domainName);
            $resultCheckTarget = $this->checkServerDNSValue($serverDNS);
            //Insertion du domaine
            $this->insertDomain($domainName, $serverDNS, $manageDNS, $clientObject);
        } catch (Exception $e) {
            if ($e->getMessage() == DNS_TYPE_UNKNOWN) {
                throw new Exception($e->getMessage());
            } else {
                throw new Exception(ERROR_SYNTAX . " - " . $e->getMessage());
            }
        }
    }

    public function submitDeleteDomain($idDomain)
    {
        try {
            //Suppression du domaine
            $this->deleteDomain($idDomain);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function submitUpdateDomain($domainName, $serverDNS, $manageDNS, $idClient, $idDomain)
    {
        try {
            $clientObject = $this->getClientObject($idClient);
            //Verification de la saisie.
            $resultCheckDomainName = $this->checkDomainNameValue($domainName);
            $resultCheckTarget = $this->checkServerDNSValue($serverDNS);
            //Update du domaine
            $this->updateDomain($domainName, $serverDNS, $manageDNS, $idDomain);
        } catch (Exception $e) {
            if ($e->getMessage() == DNS_TYPE_UNKNOWN) {
                throw new Exception($e->getMessage());
            } else {
                throw new Exception(ERROR_SYNTAX . " - " . $e->getMessage());
            }
        }
    }

    private function checkDomainNameValue($domainName)
    {
        try {
            if (!preg_match("#\b([a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]\.){1,127}[A-Za-z]{2,63}\b#", $domainName)) {
                throw new Exception(DOMAIN_NAME_SYNTAX);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function checkServerDNSValue($serverDNS)
    {
        try {
            //IPV4
            if (preg_match("#^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$#", $serverDNS) != 1) {
                throw new Exception(DNS_SERVER_SYNTAX);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function insertDomain($domainName, $serverDNS, $manageDNS, $clientObject)
    {
        try {
            $this->controllerObject->getDomainManager()->insertDomain($domainName, $serverDNS, $manageDNS, $clientObject);
        } catch (Exception $e) {
            throw new Exception(ERROR_INSERT);
        }
    }

    private function deleteDomain($idDomain)
    {
        try {
            $this->controllerObject->getDomainManager()->deleteDomain($this->getDomainObject($idDomain));
        } catch (Exception $e) {
            throw new Exception(ERROR_DELETE);
        }
    }

    private function updateDomain($domainName, $serverDNS, $manageDNS, $idDomain)
    {
        try {
            $this->controllerObject->getDomainManager()->updateDomain($domainName, $serverDNS, $manageDNS, $this->getDomainObject($idDomain));
        } catch (Exception $e) {
            throw new Exception(ERROR_UPDATE);
        }
    }
}
