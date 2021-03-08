<?php

namespace App\Model;

use App\PdoFactory;
use App\Model\Entity\Client;
use \PDOException;
use \Exception;

/**
 * Allow to interact with the llx_clients table in Database.
 * Use PdoFactory.
 */
class ClientManager
{

    /**
     * Function to load the clients data from an Id.
     *
     * @param int $clientId
     * @return array() $response
     */
    public function loadClientFromId($clientId)
    {
        $response = ["clientObject" => null];
        try {
            $request = PdoFactory::$pdo->prepare("SELECT nom FROM llx_societe WHERE id = :id");
            $request->execute(array(':id' => $clientId));
            if ($request->rowCount() > 0) {
                $result = $request->fetch();
                //Instantiation of Client.
                $client = new Client($clientId, $result["name"]);
                $response["clientObject"] = $client;
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), 1);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }

        return $response;
    }

    /**
     * Function to load all the clients of llx_societe
     *
     * @return array() $response
     */
    public function loadClient()
    {
        $array_client = array();
        $response = ["list_client" => null];
        try {
            $request = PdoFactory::$pdo->prepare("SELECT rowid, nom FROM llx_societe");
            $request->execute();
            if ($request->rowCount() > 0) {
                while ($result = $request->fetch()) {
                    //Instantiation of Client.
                    $client = new Client($result["rowid"], $result["nom"]);
                    array_push($array_client, $client);
                }
                $response["list_client"] = $array_client;
            }
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), 1);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }

        return $response;
    }

    /**
     * Function to UPDATE the client Name
     *
     * @param Client $clientObject To get the clientId value.
     * @param string $value New clientName
     */
    public function updateName($clientObject, $value)
    {
        try {
            $request = PdoFactory::$pdo->prepare("UPDATE llx_clients SET name = :name WHERE id = :id");
            $request->execute(array(':name' => $value, ':id' => $clientObject->getId()));
            //Update of the name.
            $clientObject->setName($value);
            //Reload of the client, to update "modified_on" value.
            $this->loadClientFromId($clientObject->getId());
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), 1);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 1);
        }
    }
}
