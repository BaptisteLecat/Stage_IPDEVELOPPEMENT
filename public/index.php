<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    if (!file_exists("../config/settings.php")) {
        throw new Exception(ERROR_FILE_SETTINGS);
    }
    require_once("../config/settings.php");

    if (!file_exists("../config/fr/error_conf.php")) {
        throw new Exception("Fichier de configuration introuvable.");
    }
    require_once("../config/fr/error_conf.php");

    if (!file_exists("../config/fr/success_conf.php")) {
        throw new Exception("Fichier de configuration introuvable.");
    }
    require_once("../config/fr/success_conf.php");

    if (DOLIBARR_ISACTIVE) {
        $res = 0;
        if (file_exists(DOLIBARR_MAIN_FROM_HTDOCS)) {
            $res = include(DOLIBARR_MAIN_FROM_HTDOCS);
        } elseif (!$res && file_exists(DOLIBARR_MAIN_FROM_CUSTOM)) {
            $res = include(DOLIBARR_MAIN_FROM_CUSTOM);
        } else {
            die("Include of main fails");
        }

        //on inclue les variables conf de Dolibarr
        include_once DOLIBARR_CONF;



        //Appel de l'affichage du HEAder de Dolibarr ( menu haut horizontal et gauche vertical)
        llxHeader('', 'Convertisseur Zone DNS', '');
    }

    require_once("controller.php");

    $controller = new Controller();

    if (isset($_GET["view"])) {
        switch ($_GET["view"]) {
            case 'dashboard':
                if (isset($_GET["action"])) {
                    if (isset($_GET["mode"])) {
                        $controller->displayDashboard($_GET["action"], $_GET["mode"]);
                    } else {
                        $controller->displayDashboard($_GET["action"]);
                    }
                } else {
                    if (isset($_GET["mode"])) {
                        $controller->displayDashboard(null, $_GET["mode"]);
                    } else {
                        $controller->displayDashboard();
                    }
                }
                break;

            default:
                $controller->displayDashboard();
                break;
        }
    } else {
        $controller->displayDashboard();
    }

    require("../view/template.php");
}catch (Exception $e) {
    throw new Exception($e);
}
