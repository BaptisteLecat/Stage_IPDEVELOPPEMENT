<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\Domain;
use Exception;
use PDOException;

/**
 * Allow to interact with the llx_domaines table in Database.
 * Use PdoFactory.
 */
class DomainManager extends PdoFactory
{
    /**
     * Function to load Domain from client.
     *
     * @param Client $clientObject To get the clientId value, and create the Domain objects.
     * @return Array(int) $response[success]
     */
    public function loadDomainFromClient($clientObject)
    {
        try {
            $request = PdoFactory::$pdo->prepare("SELECT id, name, server_dns, manage_dns, created_on, modified_on, deleted_on FROM llx_domaines WHERE client_id = :client_id");
            if ($request->execute(array(':client_id' => $clientObject->getId()))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        $domain = new Domain($result["id"], $result["name"], $result["server_dns"], $result["manage_dns"], $result["deleted_on"], $result["created_on"], $result["modified_on"], $clientObject);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }
    }

    /**
     * Function to load a Domain from his id.
     * Can be used to reload a Domain when it was modified. Because we need to update the created_on, modified_on and deleted_on values.
     * @param int $domainId
     * @param Client $clientObject To get the clientId value, and create the Domain objects.
     * @return Array(int) $response[success]
     */
    public function loadDomainFromDomainId($domainId, $clientObject)
    {
        try {
            $request = PdoFactory::$pdo->prepare("SELECT name, server_dns, manage_dns, created_on, modified_on, deleted_on FROM llx_domaines WHERE id = :id");
            if ($request->execute(array(':id' => $domainId))) {
                if ($request->rowCount() > 0) {
                    while ($result = $request->fetch()) {
                        $domain = new Domain($domainId, $result["name"], $result["server_dns"], $result["manage_dns"], $result["deleted_on"], $result["created_on"], $result["modified_on"], $clientObject);
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }
    }

    /**
     * Function to insert a new Domain.
     * Return the lastInsertId to identified the new object.
     * @param string $name
     * @param string $serverDNS
     * @param Tinyint $manageDNS
     * @param Client $clientObject To get the clientId value, and create the Domain objects.
     * @return Array(int, int) $response[success, insertId]
     */
    public function insertDomain($name, $serverDNS, $manageDNS, $clientObject)
    {
        $response = ["insertId" => null];

        try {
            $request = PdoFactory::$pdo->prepare("INSERT INTO llx_domaines (name, server_dns, manage_dns, client_id) VALUES (:name, :server_dns, :manage_dns, :client_id)");
            if ($request->execute(array(':name' => $name, ':server_dns' => $serverDNS, ':manage_dns' => $manageDNS, ':client_id' => $clientObject->getId()))) {
                $this->loadDomainFromDomainId(PdoFactory::$pdo->lastInsertId(), $clientObject);
                $response["insertId"] = PdoFactory::$pdo->lastInsertId();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }

        return $response;
    }

    /**
     * Function to update the Domain informations
     *
     * @param String||Tinyint $value
     * @param Domain $domainObject The Domain who have to be modified.
     * @return Array(int) $response[success]
     */
    public function updateDomain($domainName, $serverDNS, $manageDNS, $domainObject)
    {
        try {
            $request = PdoFactory::$pdo->prepare("UPDATE llx_domaines SET manage_dns = :manage_dns, server_dns = :server_dns, name = :name WHERE id = :id");
            if ($request->execute(array(':manage_dns' => $manageDNS, ':server_dns' => $serverDNS, ':name' => $domainName, ':id' => $domainObject->getId()))) {
                $this->loadDomainFromDomainId($domainObject->getId(), $domainObject->getClientObject());
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }
    }

    /**
     * Function to set the deleted_on state.
     *
     * @param Domain $domainObject The Domain who have to be Archived/Unarchived.
     * @param bool $state $state True == Archived, False == unArchived
     * @return Array(int) $response[success]
     */
    public function archiveDomain($domainObject, $state)
    {
        switch ($state) {
            case true:
                $date_deleted = date("Y-m-d H:i:s");

                try {
                    $request = PdoFactory::$pdo->prepare("UPDATE llx_domaines SET deleted_on = :deleted_on WHERE id = :id");
                    if ($request->execute(array(':deleted_on' => $date_deleted, ':id' => $domainObject->getId()))) {
                        $domainObject->setDeletedOn($date_deleted);
                    }
                } catch (Exception $e) {
                    throw new Exception($e->getMessage);
                }
                break;
            case false:
                try {
                    $request = PdoFactory::$pdo->prepare("UPDATE llx_domaines SET deleted_on = NULL WHERE id = :id");
                    if ($request->execute(array(':id' => $domainObject->getId()))) {
                        $domainObject->setDeletedOn(null);
                    }
                } catch (Exception $e) {
                    throw new Exception($e->getMessage);
                }
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Function to delete a Domain.
     *
     * @param Domain $domainObject Domain who have to be deleted.
     * @return Array(int) $response[success]
     */
    public function deleteDomain($domainObject)
    {
        try {
            $request = PdoFactory::$pdo->prepare("DELETE FROM llx_domaines WHERE id = :id");
            if ($request->execute(array(':id' => $domainObject->getId()))) {
                $domainObject->delete();
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage);
        }
    }
}
