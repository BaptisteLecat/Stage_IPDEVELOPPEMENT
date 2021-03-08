<div class="container_domaines">
    <div class="header_domainContainer">
        <div class="header_left">
            <h1>Vos domaines</h1>
            <h2 name="nbDomain"><?= $nbDomain; ?> domaines</h2>

        </div>
        <div class="header_right">
            <button type="button" onclick="show_modal('insertDomain')" id="btn-edit_domain" class="btn_add">Editer</button>
        </div>
    </div>

    <hr>

    <div class="liste_domaine" id='liste_domaine'>
        <?php foreach ($list_domain as $index => $domain) { ?>
            <div class="box_domaine" name="<?= $domain->getId(); ?>" id="<?= $index ?>" onclick="setSelectedDomain(this)">
                <div class="left_side">
                    <h3 name="domainName"><?= $domain->getDomainName(); ?></h3>
                    <p name="serverDNS"><?= $domain->getServerDNS(); ?></p>
                </div>
                <div class="right_side">
                    <p>Gestion DNS</p>
                    <div class="Checkbox">
                        <?php if ($domain->getManageDNS() == 1) { ?>
                            <input type="checkbox" name="manageDNS" onclick="changeCheckState(this)" checked />
                        <?php } else { ?>
                            <input type="checkbox" name="manageDNS" onclick="changeCheckState(this)" />
                        <?php } ?>
                        <div class="Checkbox-visible"></div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

</div>