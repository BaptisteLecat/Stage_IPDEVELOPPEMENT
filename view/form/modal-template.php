<?php ob_start(); ?>
<div class="modal_mask">
  <div class="modal_container">
    <div class="modal_header">
      <h1><?= $this->getTitle(); ?></h1>
      <h2><?= $this->getSubTitle(); ?></h2>
    </div>
    <!-- Menu de la modal -->
    <?php if ($form == "insertDomain" || $form == "updateDomain") {  ?>
      <div class="modal_subHeader">
        <div name="nav-opt1" class="<?= $class = ($form == "insertDomain") ? "nav-opt nav-active" : "nav-opt" ?>">
          <h3>Insertion Domaine</h3>
        </div>
        <div name="nav-opt2" class="<?= $class = ($form == "updateDomain") ? "nav-opt nav-active" : "nav-opt" ?>">
          <h3>Modification Domaine</h3>
        </div>
      </div>
    <?php } elseif ($form == "insertDNS" || $form == "insertDNSZone") { ?>
      <div class="modal_subHeader">
        <div name="nav-opt1" class="<?= $class = ($form == "insertDNS") ? "nav-opt nav-active" : "nav-opt" ?>">
          <h3>Insertion DNS</h3>
        </div>
        <div name="nav-opt2" class="<?= $class = ($form == "insertDNSZone") ? "nav-opt nav-active" : "nav-opt" ?>">
          <h3>Insertion Zone DNS</h3>
        </div>
      </div>
    <?php } ?>
    <div class="modal_content">
      <?php if ($this->errorMessage !== null) {  ?>
        <div class="info_container">
          <?php if ($this->success == 1) { ?>
            <div class="info_content success_info">
            <?php } else { ?>
              <div class="info_content error_info">
              <?php } ?>
              <h4><?= $this->errorMessage ?></h4>
              </div>
            </div>
          <?php } ?>
          <?= $modal; ?>
        </div>
        <div class="modal_footer">
          <?php if ($form == "updateDomain") { ?>
            <div class="footer_btn-wrapper" style="width: 350px;">
            <?php } else { ?>
              <div class="footer_btn-wrapper">
              <?php } ?>
              <button onclick="cancel_modal()" class="btn-cancel">Quitter</button>
              <?php switch ($form) {
                case 'insertDNS': ?>
                  <button onclick="submitDNS_modal()" class="btn-validate">Insérer</button>
                  <?php break; ?>
                <?php
                case 'insertDNSZone': ?>
                  <button onclick="submitDNSZone_modal()" class="btn-validate">Insérer</button>
                  <?php break; ?>
                <?php
                case 'insertDomain': ?>
                  <button onclick="submitDomain_modal('insert')" class="btn-validate">Insérer</button>
                  <?php break; ?>
                <?php
                case 'updateDomain': ?>
                  <button onclick="deleteDomain_modal()" class="btn-cancel">Supprimer</button>
                  <button onclick="submitDomain_modal('update')" class="btn-validate">Modifier</button>
                  <?php break; ?>
              <?php } ?>
              </div>
            </div>
        </div>
    </div>

    <?php $this->content = ob_get_clean(); ?>