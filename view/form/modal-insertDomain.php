<?php ob_start(); ?>
<form action="">
    <div class="form-client">
        <h6>Client</h6>
        <select name="client-selector" value="3">
            <?php foreach ($this->list_client as $key => $client) { ?>
                <?php if ($client->getId() == $idClient) { ?>
                    <option selected value="<?= $key ?>"><?= $client->getName(); ?></option>
                <?php } else { ?>
                    <option value="<?= $key ?>"><?= $client->getName(); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class="form-domainName">
        <h6>Nom de domaine</h6>
        <div class="domainName-input_container">
            <input type="text" id="domainName" autocomplete="off" value="<?php if (isset($formData["domainName"])) {
                                                                                echo ($formData["domainName"]);
                                                                            } ?>" required>
        </div>
    </div>
    <div class="form-serverDNS">
        <h6>Serveur DNS</h6>
        <div class="serverDNS-input_container">
            <input type="text" autocomplete="off" name="serverDNS">
        </div>
    </div>
    <div class="form-manageDNS">
        <h6>Gestion DNS</h6>
        <div class="form_checkbox">
            <input type="checkbox" name="manageDNS" value="1" onclick="changeCheckState(this)" checked>
            <div class="form_checkbox-visible"></div>
        </div>
    </div>
</form>

<?php $modal = ob_get_clean(); ?>