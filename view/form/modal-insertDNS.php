<?php ob_start(); ?>

<?php $domainObject = $this->modalDNS->getDomainObject($idDomain); ?>

<form action="">
    <div class="form-domain">
        <h6>Sous-domaine</h6>
        <div class="domain-input_container">
            <input type="text" name="sub-domain" autocomplete="off" required>
            <input type="text" name="domain" id="<?= $domainObject->getId(); ?>" value="<?= $domainObject->domainFormatForm(); ?>" disabled>
        </div>
    </div>
    <div class="form-type">
        <h6>Type</h6>
        <select name="type-selector">
            <?php foreach ($this->list_DNSField as $key => $DNSField) { ?>
                <option value="<?= $key ?>"><?= $DNSField->getLabel(); ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-priority">
    </div>
    <div class="form-target">
        <h6>Cible</h6>
        <input type="text" name="target" autocomplete="off" required>
    </div>
    <div class="generate-field_container">
        <h6>Le champ généré est le suivant :</h6>
        <textarea name="generate-field" cols="30" rows="10" disabled></textarea>
    </div>
</form>

<?php $modal = ob_get_clean(); ?>