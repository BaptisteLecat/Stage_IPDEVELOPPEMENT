<div class="container_client">

    <h1>Vos Clients</h1>
    <h2><?= count($this->list_client); ?> Clients</h2>
    <div class="search_container">
        <input type="search" name="" id="" placeholder="Recherchez un client..">
        <button><img src="assets/icons/search.png" alt="search"></button>
    </div>
    <hr>

    <div class="liste_client" id='liste_client'>

        <?php foreach ($this->list_client as $index => $client) { ?>
            <div class="box_client" name="<?= $client->getId(); ?>" id="<?= $index ?>" onclick="<?= $onclick_function ?>">
                <div class="left_side">
                    <h3 title="<?= $client->getName(); ?>"><?= $client->getName(); ?></h3>
                    <p><?= $client->nbDomain(); ?> domaines</p>
                </div>
                <div class="right_side">
                    <p><?= $client->nbDNSRecord(); ?> DNS</p>
                </div>
            </div>
        <?php } ?>

    </div>

</div>