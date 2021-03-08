<?php

namespace App\Form;

use Exception;

class ModalDNSZone
{
    private $list_client;
    private $controllerObject;
    private $DNSFieldObject;

    function __construct($controllerObject)
    {
        $this->controllerObject = $controllerObject;
        $this->list_client = $this->controllerObject->getList_Client();
        $this->DNSFieldObject = null;
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

    public function submitInsertDNSZone($input, $idDomain)
    {
        try {
            $domainObject = $this->getDomainObject($idDomain);
            $list_DNS = $this->spliceInput($input);
            foreach ($list_DNS as $DNS) {

                //Récupération des arguments.
                $subDomain = $DNS["args"][0];
                $type = $DNS["args"][1];
                if (count($DNS["args"]) == 4) {
                    $priority = $DNS["args"][2];
                    $target = $DNS["args"][3];
                } else {
                    $priority = null;
                    $target = $DNS["args"][2];
                }

                //Verification du sous-domaine
                $this->checkSubDomainValue($subDomain);

                //Verification du type
                foreach ($this->controllerObject->getList_DNSField() as $DNSFieldObject) {
                    if ($DNSFieldObject->getLabel() == $type) {
                        $this->DNSFieldObject = $DNSFieldObject;
                        break;
                    }
                }

                //Verification de la cible
                $this->checkTargetValue($target, $type, $priority);
                //Insertion
                $this->insertDNS($subDomain, $type, $target, $priority, $domainObject);
            }
        } catch (Exception $e) {
            if ($e->getMessage() == DNS_TYPE_UNKNOWN) {
                throw new Exception($e->getMessage());
            } else {
                throw new Exception(ERROR_SYNTAX . " - " . $e->getMessage());
            }
        }
    }

    private function spliceInput($input)
    {
        try {
            $list_DNSArg = array();
            $list_line = array();
            $list_element = array();

            $breakState = false;

            $list_line = explode("\n", $input); //Découpage ligne par ligne.

            foreach ($list_line as $line) {
                $list_element = explode(" ", $line); //Séparation par espace.
                $dns =
                    [
                        "args" => array()
                    ];
                foreach ($list_element as $element) {

                    if ($element != "") { //Récupération uniquement des mots.
                        if (strlen($element) > 0) {
                            array_push($dns["args"], $element);
                        }
                    }

                    if (count($dns["args"]) > 4) { // Doit faire moins de 4 arguments max
                        throw new Exception("ERROR_DNS_ARGUMENTS_NB");
                        $breakState = true;
                        break;
                    }
                }

                if (!$breakState) {
                    array_push($list_DNSArg, $dns);
                }
            }
        } catch (Exception $e) {
            if($e->getMessage() != "ERROR_DNS_ARGUMENTS_NB"){
                throw new Exception("ERROR_DNS_ARGUMENTS");
            }
        }
        return $list_DNSArg;
    }

    private function checkSubDomainValue($subDomain)
    {
        try {
            if (!preg_match("#^[a-z0-9_\-\.@]+$#", $subDomain)) {
                throw new Exception("xcfsdfsd");
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
                    if ($DNSFieldObject->getRegex() != null) {
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
            $this->controllerObject->getDNSRecordManager()->insertDNSRecord($subDomain, $target, $domainObject, $this->DNSFieldObject, $priority);
        } catch (Exception $e) {
            throw new Exception(ERROR_INSERT);
        }
    }
}
