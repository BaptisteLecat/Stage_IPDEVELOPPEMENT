var idDomain = null;
var idClient = null
var controller = null;
var is_modified = false;
var type_isMX = false;

function nav_modalDomain(event) {
  var isActive = false;
  event.target.classList.forEach(element => {
    if (element == "nav-active") {
      isActive = true;
    }
  });

  if (!isActive) {
    //Option 1
    if (event.target.getAttribute("name") == "nav-opt1" || event.target.parentNode.getAttribute("name") == "nav-opt1") {
      document.getElementsByClassName("nav-opt")[1].classList.remove("nav-active");
      document.getElementsByClassName("nav-opt")[0].classList.add("nav-active");
      show_modal("insertDomain");
      //Option 2
    } else {
      if (event.target.getAttribute("name") == "nav-opt2" || event.target.parentNode.getAttribute("name") == "nav-opt2") {
        document.getElementsByClassName("nav-opt")[0].classList.remove("nav-active");
        document.getElementsByClassName("nav-opt")[1].classList.add("nav-active");
        show_modal("updateDomain");
      }
    }
  }

}


function nav_modalDNS(event) {
  var isActive = false;
  event.target.classList.forEach(element => {
    if (element == "nav-active") {
      isActive = true;
    }
  });

  if (!isActive) {
    //Option 1
    if (event.target.getAttribute("name") == "nav-opt1" || event.target.parentNode.getAttribute("name") == "nav-opt1") {
      document.getElementsByClassName("nav-opt")[1].classList.remove("nav-active");
      document.getElementsByClassName("nav-opt")[0].classList.add("nav-active");
      show_modal("DNS");
      //Option 2
    } else {
      if (event.target.getAttribute("name") == "nav-opt2" || event.target.parentNode.getAttribute("name") == "nav-opt2") {
        document.getElementsByClassName("nav-opt")[0].classList.remove("nav-active");
        document.getElementsByClassName("nav-opt")[1].classList.add("nav-active");
        show_modal("DNSZone");
      }
    }
  }

}

//Affiche la modal et charge la class controller.
function show_modal(name) {
  switch (name) {
    case "DNS":
      DNS_modal();
      break;

    case "DNSZone":
      DNSZone_modal();
      break;

    case "insertDomain":
      insertDomain_modal();
      break;

    case "updateDomain":
      updateDomain_modal();
      break;

    default:
      alert("Le formulaire n'existe pas.");
      break;
  }
}

function submitDNS_modal() {
  if (selectedDomain_index != null && idDomain != null) {
    //Récupération des valeurs du formulaire.
    var input = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("input");
    if (type_isMX == true) {
      var subDomain = input[0].value;
      var type = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("select")[0].selectedOptions[0].innerText;
      var priority = input[2].value;
      var target = input[3].value;
    } else {
      var priority = "";
      var subDomain = input[0].value;
      var type = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("select")[0].selectedOptions[0].innerText;
      var target = input[2].value;
    }

    var formData = {
      "subDomain": subDomain,
      "type": type,
      "target": target,
      "priority": priority
    };

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var res = this.response;
        //Rechargement de l'affichage des DNS.
        setSelectedDomain(document.getElementById("liste_domaine").getElementsByClassName("box_domaine")[selectedDomain_index], true);

        document.getElementsByClassName("modal_mask")[0].remove();
        document.getElementsByTagName("body")[0].innerHTML += res["content"];
        type_isMX = false;
        //Ajout d'un écouteur sur le changement du type sélectionné.
        var type = document.getElementsByName("type-selector")[0].selectedOptions[0].innerText;
        if (type == "MX") {
          displayMXPriorityInput();
        }
        document.getElementsByName("type-selector")[0].addEventListener("change", function (event) {
          if (event.target.selectedOptions[0].innerText == "MX") {
            displayMXPriorityInput();
            type_isMX = true;
          } else {
            document.getElementsByClassName("form-priority")[0].innerHTML = "";
            document.getElementsByClassName("form-priority")[0].style.margin = "0px";
            type_isMX = false;

          }
        });

        //Gestion du menu modal, ajout des listener sur les click.
        var navOpt1 = document.getElementsByClassName("nav-opt")[0];
        navOpt1.addEventListener('click', (e) => {
          if (navOpt1 !== e.target) return;
          e.preventDefault();
          nav_modalDNS(e);
        });
        var navOpt2 = document.getElementsByClassName("nav-opt")[1];
        navOpt2.addEventListener('click', (e) => {
          if (navOpt2 !== e.target) return;
          e.preventDefault();
          nav_modalDNS(e);
        });

        //Ajout d'un écouteur pour détecter une saisie et changer l'affichage du champs généré.
        document.getElementsByClassName("modal_content")[0].addEventListener('keypress', (e) => {
          generatorDNS(e);
        });

      } else if (this.readyState == 4) {
        alert("Une erreur est survenue..");
      } else if (this.statusText == "parsererror") {
        alert("Erreur Json");
      }
    };

    xhr.open("POST", "form/formRouter.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("view=form&form=insertDNS&idDomain=" + encodeURI(idDomain) + "&action=submit&formData=" + JSON.stringify(formData) + "&controller=" + encodeURI(controller));
  }
}


function submitDNSZone_modal() {
  if (selectedDomain_index != null && idDomain != null) {
    //Récupération des valeurs du formulaire.
    var textarea = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("textarea");
    var zoneDNS = textarea[0].value;

    var formData = {
      "zoneDNS": zoneDNS,
    };

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var res = this.response;
        //Rechargement de l'affichage des DNS.
        setSelectedDomain(document.getElementById("liste_domaine").getElementsByClassName("box_domaine")[selectedDomain_index], true);

        document.getElementsByClassName("modal_mask")[0].remove();
        //Réaffichage de la nouvelle modal de réponse.
        document.getElementsByTagName("body")[0].innerHTML += res["content"];

        //Gestion du menu modal, ajout des listener sur les click.
        var navOpt1 = document.getElementsByClassName("nav-opt")[0];
        navOpt1.addEventListener('click', (e) => {
          if (navOpt1 !== e.target) return;
          e.preventDefault();
          nav_modalDNS(e);
        });
        var navOpt2 = document.getElementsByClassName("nav-opt")[1];
        navOpt2.addEventListener('click', (e) => {
          if (navOpt2 !== e.target) return;
          e.preventDefault();
          nav_modalDNS(e);
        });

      } else if (this.readyState == 4) {
        alert("Une erreur est survenue..");
      } else if (this.statusText == "parsererror") {
        alert("Erreur Json");
      }
    };

    xhr.open("POST", "form/formRouter.php", true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("view=form&form=insertDNSZone&idDomain=" + encodeURI(idDomain) + "&action=submit&formData=" + JSON.stringify(formData) + "&controller=" + encodeURI(controller));
  }
}

//Permet de quitter la modal, demande confirmation si des éléments ont été saisie.
function cancel_modal() {
  if (is_modified == false) {
    document.getElementsByClassName("modal_mask")[0].remove();
    //Remise à 0 des valeurs.
    controller = null;
    is_modified = false;
    idDomain = null;
    idClient = null;
  } else {
    if (confirm("Souhaitez-vous vraiment abandonner la saisie?")) {
      document.getElementsByClassName("modal_mask")[0].remove();
      //Remise à 0 des valeurs.
      controller = null;
      is_modified = false;
      idDomain = null;
      idClient = null;
    }
  }
}

function submitDomain_modal(action) {
  //Récupération des valeurs du formulaire.
  var input = document.getElementsByClassName("modal_content")[0].getElementsByTagName("form")[0].getElementsByTagName("input");
  domainName = input[0].value;
  serverDNS = input[1].value;
  manageDNS = input[2].checked;

  var formData = {
    "domainName": domainName,
    "serverDNS": serverDNS,
    "manageDNS": manageDNS
  };

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var res = this.response;
      //Affichage du formulaire et de son résultat. 
      document.getElementsByClassName("modal_mask")[0].remove();
      document.getElementsByTagName("body")[0].innerHTML += res["content"];

      var navOpt1 = document.getElementsByClassName("nav-opt")[0];
      navOpt1.addEventListener('click', (e) => {
        if (navOpt1 !== e.target) return;
        e.preventDefault();
        nav_modalDomain(e);
      });
      var navOpt2 = document.getElementsByClassName("nav-opt")[1];
      navOpt2.addEventListener('click', (e) => {
        if (navOpt2 !== e.target) return;
        e.preventDefault();
        nav_modalDomain(e);
      });

    } else if (this.readyState == 4) {
      alert("Une erreur est survenue..");
    } else if (this.statusText == "parsererror") {
      alert("Erreur Json");
    }
  };

  xhr.open("POST", "form/formRouter.php", true);
  xhr.responseType = "json";
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (action == "insert") {
    xhr.send("view=form&form=insertDomain&idDomain=" + encodeURI(idDomain) + "&idClient=" + encodeURI(idClient) + "&action=submit&formData=" + JSON.stringify(formData) + "&controller=" + encodeURI(controller));
  } else {
    xhr.send("view=form&form=updateDomain&idDomain=" + encodeURI(idDomain) + "&idClient=" + encodeURI(idClient) + "&action=update&formData=" + JSON.stringify(formData) + "&controller=" + encodeURI(controller));
  }
}
