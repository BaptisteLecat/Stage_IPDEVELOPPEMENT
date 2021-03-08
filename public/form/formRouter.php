<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../config/fr/error_conf.php");
require("../../config/fr/success_conf.php");

require_once("FormController.php");

if (!isset($_POST["controller"])) {
    if ($_POST["controller"] != null) {
        $formController = unserialize($_POST["controller"]);
    } else {
        $formController = new FormController();
    }
} else {
    $formController = new FormController();
}

if (isset($_POST["view"])) {
    switch ($_POST["view"]) {
        case 'form':
            if (isset($_POST["form"])) {
                switch ($_POST["form"]) {
                    case 'insertDNS':
                        if (isset($_POST["idDomain"])) {
                            if (isset($_POST["action"])) {
                                if (isset($_POST["formData"])) {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], null, $_POST["action"], $_POST["formData"]);
                                } else {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], null, $_POST["action"]);
                                }
                            } else {
                                $formController->displayForm($_POST["form"], $_POST["idDomain"]);
                            }
                        } else {
                            $formController->displayForm($_POST["form"]);
                        }
                        break;

                    case 'insertDNSZone':
                        if (isset($_POST["idDomain"])) {
                            if (isset($_POST["action"])) {
                                if (isset($_POST["formData"])) {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], null, $_POST["action"], $_POST["formData"]);
                                } else {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], null, $_POST["action"]);
                                }
                            } else {
                                $formController->displayForm($_POST["form"], $_POST["idDomain"]);
                            }
                        } else {
                            $formController->displayForm($_POST["form"]);
                        }
                        break;

                    case 'insertDomain':
                        if (isset($_POST["idDomain"]) && isset($_POST["idClient"])) {
                            if (isset($_POST["action"])) {
                                if (isset($_POST["formData"])) {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"], $_POST["action"], $_POST["formData"]);
                                } else {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"], $_POST["action"]);
                                }
                            } else {
                                $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"]);
                            }
                        } else {
                            $formController->displayForm($_POST["form"]);
                        }
                        break;

                    case 'updateDomain':
                        if (isset($_POST["idDomain"]) && isset($_POST["idClient"])) {
                            if (isset($_POST["action"])) {
                                if (isset($_POST["formData"])) {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"], $_POST["action"], $_POST["formData"]);
                                } else {
                                    $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"], $_POST["action"]);
                                }
                            } else {
                                $formController->displayForm($_POST["form"], $_POST["idDomain"], $_POST["idClient"]);
                            }
                        } else {
                            $formController->displayForm($_POST["form"]);
                        }
                        break;

                    default:
                        # code...
                        break;
                }
            } else {
                $formController->setErrorMessage("Aucune form n'a été transmis !");
            }
            break;

        default:
            $formController->setErrorMessage("La vue semble inconnue !");
            break;
    }
} else {
    $formController->setErrorMessage("Aucune vue n'a été transmise !");
}


$_SESSION["list_client"] = serialize($formController->getList_Client());
$response = ["success" => $formController->getSuccess(), "content" => $formController->getContent(), "errorMessage" => $formController->getErrorMessage(), "formController" => serialize($formController)];
echo json_encode($response);
