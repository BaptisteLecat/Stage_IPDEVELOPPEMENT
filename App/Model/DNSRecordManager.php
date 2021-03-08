<?php

namespace App\Model;

use App\PdoFactory;
use \PDOException;
use \Exception;
use App\Model\Entity\{DNS_Record_MX, DNS_Record_STANDARD, DNS_Field};

/**
 * Allow to interact with the llx_dns_records table in Database.
 * Use PdoFactory.
 */
class DNSRecordManager extends PdoFactory
{
    /**
     * Function to load DNSRecord from a Domain.
     *
     * @param Domain $domainObject To get the domainId value, and create the DNSRecord objects.
     * @param List[DNSField] $list_DNSField To compare with the dns_field_id value, and find the good DNSField object for each DNSRecord.
     */
    public function loadDNSRecordFromDomain($domainObject, $list_DNSField)
    {
        try {
            $request = PdoFactory::$pdo->prepare("call select_DNS_fromDomain (:domain_id, @id, @subDomain, @target, @deleted_on, @created_on, @modified_on, @dns_field_id, @priority)");
            if ($request->execute(array(':domain_id' => $domainObject->getId()))) {
                $request = PdoFactory::$pdo->prepare("SELECT * FROM TMP_DNS");
                if ($request->execute()) {
                    if ($request->rowCount() > 0) {
                        while ($result = $request->fetch()) {
                            //Searching the DNSField object who has the same id as the DNSRecord
                            foreach ($list_DNSField as $field) {
                                if (intval($result["_dns_field_id"]) == $field->getId()) {
                                    //Instantiation of the DNSRecord.
                                    if ($result["_priority"] === null) {
                                        $DNSRecord_STANDARD = new DNS_Record_STANDARD($result["_id"], $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $field);
                                    } else {
                                        $DNSRecord_MX = new DNS_Record_MX($result["_id"], $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $field, $result["_priority"]);
                                    }
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Function to load a DNSRecord from his id.
     * Can be used to reload a DNSRecord when it was modified. Because we need to update the created_on, modified_on and deleted_on values.
     * @param int $DNSRecordId
     * @param Domain $domainObject To get the domainId value, and create the DNSRecord objects.
     * @param List[DNSField] $list_DNSField To compare with the dns_field_id value, and find the good DNSField object for each DNSRecord.
     */
    public function loadDNSRecordFromId_listField($DNSRecordId, $domainObject, $list_DNSField)
    {
        $domainObject->getList_DNSRecord(array()); //EMPTY TO REFILL.

        try {
            $request = PdoFactory::$pdo->prepare("call select_DNS_fromId (:id, @domain_id, @subDomain, @target, @deleted_on, @created_on, @modified_on, @dns_field_id, @priority)");
            if ($request->execute(array(':id' => $DNSRecordId))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        //Searching the DNSField object who has the same id as the DNSRecord
                        foreach ($list_DNSField as $field) {
                            if (intval($result["_dns_field_id"]) == $field->getId()) {
                                //Instantiation of the DNSRecord.
                                if (!isset($result["_priority"])) {
                                    $DNSRecord_STANDARD = new DNS_Record_STANDARD($DNSRecordId, $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $field);
                                } else {
                                    $DNSRecord_MX = new DNS_Record_MX($DNSRecordId, $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $field, $result["_priority"]);
                                }
                                break;
                            }
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Function to load a DNSRecord from his id.
     * Private function use to reload a DNSRecord when it was modified. Because we need to update the created_on, modified_on and deleted_on values.
     * @param int $DNSRecordId
     * @param Domain $domainObject To get the domainId value, and create the DNSRecord objects.
     * @param DNSField $DNSFieldObject With the object we don't need to browse all the DNSFieldObject list.
     */
    private function loadDNSRecordFromId_objectField($DNSRecordId, $domainObject, $DNSFieldObject)
    {
        $domainObject->getList_DNSRecord(array()); //EMPTY TO REFILL.

        try {
            $request = PdoFactory::$pdo->prepare("call select_DNS_fromId (:id, @domain_id, @subDomain, @target, @deleted_on, @created_on, @modified_on, @dns_field_id, @priority)");
            if ($request->execute(array(':id' => $DNSRecordId))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        //Comparison between the DNSField object id and the DNSRecord id.
                        if (intval($result["_dns_field_id"]) == $DNSFieldObject->getId()) {
                            //Instantiation of the DNSRecord.
                            if ($result["_priority"] === null) {
                                $DNSRecord_STANDARD = new DNS_Record_STANDARD($DNSRecordId, $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $DNSFieldObject);
                            } else {
                                $DNSRecord_MX = new DNS_Record_MX($DNSRecordId, $result["_subDomain"], $result["_target"], $result["_deleted_on"], $result["_created_on"], $result["_modified_on"], $domainObject, $DNSFieldObject, $result["_priority"]);
                            }
                            break;
                            break;
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Function to insert a new DNSRecord
     * Return the lastInsertId to identified the new object.
     * @param string $subDomain
     * @param string $target
     * @param Domain $domainObject To get the domainId target, and create the DNSRecord objects.
     * @param DNSField $DNSFieldObject With the object we don't need to browse all the DNSFieldObject list.
     * @return Array(int, int) $response[success, insertId]
     */
    public function insertDNSRecord($subDomain, $target, $domainObject, $DNSFieldObject, $priority = null)
    {
        $response["insertId"] = null;

        try {
            if ($priority == null) { //DNS STANDARD
                $request = PdoFactory::$pdo->prepare("call insert_DNS_standard(:subDomain, :target, :domain_id, :dns_field_id)");
                if ($request->execute(array(':subDomain' => $subDomain, ':target' => $target, ':domain_id' => $domainObject->getId(), ':dns_field_id' => $DNSFieldObject->getId()))) {
                    $result = $request->fetch();
                    $lastInsertId = $result["_dnsId"];
                    $request->closeCursor();
                    $this->loadDNSRecordFromId_objectField($lastInsertId, $domainObject, $DNSFieldObject);
                    $response["insertId"] = $lastInsertId;
                }
            } else { //DNS MX
                $request = PdoFactory::$pdo->prepare("call insert_DNS_mx (:subDomain, :target, :domain_id, :priority)");
                if ($request->execute(array(':subDomain' => $subDomain, ':target' => $target, ':domain_id' => $domainObject->getId(), ':priority' => $priority))) {
                    $result = $request->fetch();
                    $lastInsertId = $result["_dnsId"];
                    $request->closeCursor();
                    $this->loadDNSRecordFromId_objectField($lastInsertId, $domainObject, $DNSFieldObject);
                    $response["insertId"] = $lastInsertId;
                }
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

        return $response;
    }

    /**
     * Function to update the DNSRecord informations
     *
     * @param string $target
     * @param string[host,target] $attribute Name of the attribute who need to be modified.
     * @param DNSRecord $DNSRecordObject Object who have to be modified
     */
    public function updateDNSRecord($subDomain, $target, $dns_field_id, $DNSRecordObject, $list_DNSField)
    {
        try {
            $request = PdoFactory::$pdo->prepare("UPDATE llx_dns_records SET subDomain = :subDomain, target = :target, dns_field_id = :dns_field_id WHERE id = :id");
            if ($request->execute(array(':subDomain' => $subDomain, ':target' => $target, ':dns_field_id' => $dns_field_id, ':id' => $DNSRecordObject->getId()))) {
                $this->loadDNSRecordFromId_listField($DNSRecordObject->getId(), $DNSRecordObject->getDomainObject(), $list_DNSField);
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Function to set the deleted_on state.
     * 
     * @param DNSRecord $DNSRecordObject Object who have to be Archived/Unarchived
     * @param bool $state True == Archived, False == unArchived
     */
    public function archiveDNSRecord($DNSRecordObject, $state)
    {
        try {
            switch ($state) {
                case true:
                    $date_deleted = date("Y-m-d H:i:s", strtotime('6 day'));
                    $request = PdoFactory::$pdo->prepare("UPDATE llx_dns_records SET deleted_on = :deleted_on WHERE id = :id");
                    if ($request->execute(array(':deleted_on' => $date_deleted, ':id' => $DNSRecordObject->getId()))) {
                        $DNSRecordObject->setDeletedOn($date_deleted);
                    }
                    break;
                case false:
                    $request = PdoFactory::$pdo->prepare("UPDATE llx_dns_records SET deleted_on = NULL WHERE id = :id");
                    if ($request->execute(array(':id' => $DNSRecordObject->getId()))) {
                        $DNSRecordObject->setDeletedOn(null);
                    }
                    break;

                default:
                    # code...
                    break;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Function to delete a DNSRecord
     * @param DNSRecord $DNSRecordObject Object who have to be deleted
     */
    public function deleteDNSRecord($DNSRecordObject)
    {
        try {
            $request = PdoFactory::$pdo->prepare("DELETE FROM llx_dns_records WHERE id = :id");
            if ($request->execute(array(':id' => $DNSRecordObject->getId()))) {
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
