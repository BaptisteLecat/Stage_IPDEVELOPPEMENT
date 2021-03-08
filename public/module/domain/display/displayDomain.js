function displayDomainLine(list_Newdomains) {
    var nbDomain = document.getElementsByName("nbDomain")[0];
    nbDomain.id = list_Newdomains.length;
    nbDomain.innerText = `${list_Newdomains.length} Domaine au total`;

    var html = "";

    list_Newdomains.forEach(function (domain, index) {
        html = html.concat(`
    <div class="box_domaine" name="${domain.id}" id="${index}" onclick="setSelectedDomain(this)">
                    <div class="left_side">
                        <h3>${domain.domainName}</h3>
                        <p>${domain.serverDNS}</p>
                    </div>
                    <div class="right_side">
                        <p>Gestion DNS</p>
                        <div class="Checkbox">`);
        if (domain.manageDNS == 1) {
            html = html.concat(`<input type="checkbox" onclick="changeCheckState(this)" checked />`);
        } else {
            html = html.concat(`<input type="checkbox" onclick="changeCheckState(this)" />`);
        }

        html = html.concat(`
                            <div class="Checkbox-visible"></div>
                        </div>
                    </div>
                </div>`);
    });
    document.getElementById("liste_domaine").innerHTML = html;

    /*list_domains = document
      .getElementById("liste_domaine")
      .getElementsByClassName("box_domaine");*/
    selectedDomain_index = null;
    setSelectedDomain(list_domains[0]);

    //Affichage des DNS du premier domain de la liste
    if (list_Newdomains[0] != null) {
        displayDNSLine(list_Newdomains[0].list_DNSRecords);
    }
}