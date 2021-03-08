function generatorDNS(event){
    if (event.target.tagName == "INPUT" || event.target.tagName == "SELECT"){
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

        document.getElementsByClassName("modal_content")[0].getElementsByTagName("textarea")[0].innerText = `${subDomain}       IN ${type}    ${priority}    ${target}`;
    }
}