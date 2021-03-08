<?php

namespace App\Form;

use Exception;

class ModalDNS
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

    private function getTypeObject($type)
    {
        foreach ($this->controllerObject->getList_DNSField() as $field) {
            if ($field->getLabel() == $type) {
                return $field;
                break;
            }
        }
    }

    public function submitInsertDNS($subDomain, $type, $target, $priority = null, $idDomain)
    {
        try {
            $domainObject = $this->getDomainObject($idDomain);
            $resultCheckSubDomain = $this->checkSubDomainValue($subDomain);
            $resultCheckTarget = $this->checkTargetValue($target, $type, $priority);

            foreach ($this->controllerObject->getList_DNSField() as $key => $DNSFieldObject) {
                if ($DNSFieldObject->getLabel() == $type) {
                    $this->DNSFieldObject = $DNSFieldObject;
                    break;
                }
            }

            $this->insertDNS($subDomain, $type, $target, $priority, $domainObject);
        } catch (Exception $e) {
            if ($e->getMessage() == DNS_TYPE_UNKNOWN) {
                throw new Exception($e->getMessage());
            } else {
                throw new Exception(ERROR_SYNTAX . " - " . $e->getMessage());
            }
        }
    }

    private function checkSubDomainValue($subDomain)
    {
        try {
            if (!preg_match("#^[a-z0-9_\-\.]+$#", $subDomain)) {
                throw new Exception(DNS_SUBDOMAIN_SYNTAX);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function checkTargetValue($target, $type, $priority = null)
    {
        $findType = false;
        try {
            foreach ($this->controllerObject->getList_DNSField() as $DNSFieldObject) {
                if ($DNSFieldObject->getLabel() == $type) {
                    if($DNSFieldObject->getRegex() != null){
                        if (preg_match($DNSFieldObject->getRegex(), $target) != 1) {
                            throw new Exception($DNSFieldObject->getExceptionMessage());
                        }
                    }

                    if ($type == "MX") {
                        if ($priority < 0 || $priority > 300) {
                            throw new Exception(DNS_MXPRIORITY_OUTRANGE);
                        }
                    }

                    $findType = true;
                    break;
                }
            }

            if (!$findType) {
                throw new Exception(DNS_TYPE_UNKNOWN);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function insertDNS($subDomain, $type, $target, $priority = null, $domainObject)
    {
        try {
            $this->controllerObject->getDNSRecordManager()->insertDNSRecord($subDomain, $target, $domainObject, $this->getTypeObject($type), $priority);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
