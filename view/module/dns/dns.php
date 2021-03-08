<div class="container_dns">

    <div class="header_dnsContainer">
        <div class="header_left">

            <h1>DNS associés</h1>
            <h2 name="nbDNSRecord" id="<?= $list_clientHaveDomain[0]->getList_Domains()[0]->nbDNSRecord() ?>"><?= $list_clientHaveDomain[0]->getList_Domains()[0]->nbDNSRecord() ?> DNS au total</h2>
        </div>
        <div class="header_right">
            <button type="button" onclick="show_modal('DNS')" id="btn-add_dns" class="btn_add">Ajouter</button>
            <button type="button" id="btn-cancel" class="cancel btn_cancel" onclick="cancelEditDNS()">Annuler</button>
            <button type="button" id="btn-validate" class="validate btn_validate" onclick="validateEditDNS()">Valider</button>
        </div>
    </div>

    <hr>
    <div class="table_container">
        <table cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="checkbox_container"><input type="checkbox" name="select-all" style="height: 16px; width: 16px;"></th>
                    <th>Domaine</th>
                    <th class="td-type center">Type</th>
                    <th>Cible</th>
                    <th class="center">Archivage</th>
                    <th style="width: 240px;"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($list_clientHaveDomain[0]->getList_Domains()[0]->getList_DNSRecord() as $index => $DNSRecord) {
                    $reflection = new \ReflectionClass($DNSRecord); //Permet d'avoir des infos sur l'objet donnée.
                ?>
                    <tr name="<?= $DNSRecord->getId(); ?>" id="<?= $index ?>">
                        <td><input type="checkbox" name="select" id="<?= $index ?>"></td>
                        <?php if ($DNSRecord->getDeletedOn() == null) { ?>

                            <td><?= $DNSRecord->getSubDomain(); ?></td>
                            <td class="td-type center"><?= $DNSRecord->getDNSFieldObject()->getLabel(); ?></td>

                            <?php if ($reflection->getShortName() == "DNS_Record_MX") { ?>
                                <td><?= $DNSRecord->getPriority() . $DNSRecord->getTarget(); ?></td>
                            <?php } else { ?>
                                <td><?= $DNSRecord->getTarget(); ?></td>
                            <?php } ?>

                            <td style="text-align: center;">---</td>
                            <td class="td-button">
                                <button type="button" name="button" title="Editer" class="positive" onclick="editDNSLine(this)">Editer</button>
                                <button type="button" name="button" title="Archiver" class="negative" onclick="archiveDNSLine(this)">Archiver</button>
                            </td>
                    </tr>
                <?php } else { ?>
                    <td class="archived"><?= $DNSRecord->getSubDomain(); ?></td>
                    <td class="td-type center archived"><?= $DNSRecord->getDNSFieldObject()->getLabel(); ?></td>

                    <?php if ($reflection->getShortName() == "DNS_Record_MX") { ?>
                        <td class="archived"><?= $DNSRecord->getPriority() . $DNSRecord->getTarget(); ?></td>
                    <?php } else { ?>
                        <td class="archived"><?= $DNSRecord->getTarget(); ?></td>
                    <?php } ?>

                    <td style="text-align: center; color: #e85a4e;"><?= $DNSRecord->timeBeforeDeleted(); ?>j</td>
                    <td class="td-button">
                        <button type="button" name="button" title="Restaurer" class="positive" onclick="restoreDNSLine(this)">Restaurer</button>
                        <button type="button" name="button" title="Supprimer" class="negative" onclick="deleteDNSLine(this)">Supprimer</button>
                    </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            </tbody>

        </table>
    </div>

</div>