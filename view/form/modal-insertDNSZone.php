<?php ob_start(); ?>

<?php $domainObject = $this->modalDNS->getDomainObject($idDomain); ?>

<form>
    <div class="form-domain">
        <h6>Domaine</h6>
        <div class="domain-input_container">
            <input type="text" name="domain" id="<?= $domainObject->getId(); ?>" value="<?= $domainObject->domainFormatForm(); ?>" disabled>
        </div>
    </div>
    <div class="dns-field_container">
        <h6>Le champ généré est le suivant :</h6>
        <textarea name="dns-field" cols="30" rows="10"></textarea>
    </div>
</form>

<?php $modal = ob_get_clean(); ?>