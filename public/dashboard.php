<?php ob_start(); ?>
<main>
  <?php
  require_once("../view/module/function.php");

  $list_clientHaveDomain = clientHaveDomain($this->list_client);

  //Chargement de tout les modules.
  foreach ($list_module as $key => $module) {
    switch ($module) {
      case 'display':
        try {
          require("../view/module/display/display.php");
        } catch (Exception $e) {
          throw new Exception(ERROR_DASHBOARD_DISPLAY);
        }
        break;

      case 'client':
        try {
          $onclick_function = "";
          switch ($mode) {
            case 'domain':
              break;

            case 'client':
              $onclick_function = "setSelectedClient(this)";
              break;

            default:
              $mode = "domain";
              $list_domain = allDomain($this->list_client);
              break;
          }
          require("../view/module/client/client.php");
        } catch (Exception $e) {
          throw new Exception(ERROR_DASHBOARD_CLIENT);
        }
        break;

      case 'domaine':
        try {
          switch ($mode) {
            case 'domain':
              $nbDomain = getNbDomainAllClient($this->list_client);
              $list_domain = allDomain($this->list_client);
              break;

            case 'client':
              $nbDomain = getNbDomainFirstClient(clientHaveDomain($this->list_client));
              $list_domain = $list_clientHaveDomain[0]->getList_Domains();
              break;

            default:
              $mode = "domain";
              $nbDomain = getNbDomainAllClient($this->list_client);
              $list_domain = allDomain($this->list_client);
              break;
          }
          require("../view/module/domaine/domaine.php");
        } catch (Exception $e) {
          throw new Exception(ERROR_DASHBOARD_DOMAIN);
        }
        break;

      case 'dns':
        try {
          require("../view/module/dns/dns.php");
        } catch (Exception $e) {
          throw new Exception(ERROR_DASHBOARD_DNS);
        }
        break;

      default:
        throw new Exception(ERROR_UNDEFINED_MODULE);
        break;
    }
  }

  if (count($list_module) == 0) {
    throw new Exception(ERROR_UNDEFINED_MODULE);
  }
  ?>
</main>

<?php $this->content = ob_get_clean(); ?>