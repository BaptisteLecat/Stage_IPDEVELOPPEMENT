    <div class="container_affichage">
        <h1>Affichage</h1>
        <hr>

        <div class="affichage_content">
            <select name="" id="">
                <option value="1">Alphabétique</option>
                <option value="2">Inverse</option>
            </select>

            <div class="modeAffichage_container">
                <div class="modeHeader">
                    <h5>Mode d'affichage</h5>
                </div>
                <div class="modeContent">
                    <?php if ($mode == "client") { ?>
                        <button class="modeButton" onclick="window.location.href = 'index.php?view=dashboard&mode=domaine'">Domaine</button>
                        <button class="modeButton modeSelected" onclick="window.location.href = 'index.php?view=dashboard&mode=client'">Client</button>
                    <?php } else { ?>
                        <button class="modeButton modeSelected" onclick="window.location.href = 'index.php?view=dashboard&mode=domaine'">Domaine</button>
                        <button class="modeButton" onclick="window.location.href = 'index.php?view=dashboard&mode=client'">Client</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>