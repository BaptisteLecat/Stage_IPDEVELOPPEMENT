function displayDNSLine(list_DNSRecord) {
  var nbDNS = document.getElementsByName("nbDNSRecord")[0];
  nbDNS.id = list_DNSRecord.length;
  nbDNS.innerText = `${list_DNSRecord.length} DNS au total`;

  var html = "";

  list_DNSRecord.forEach(function (DNSRecord, index) {
    html = html.concat(`
    <tr name="${DNSRecord.id}" id="${index}">
    <td><input type="checkbox" name="select" id="${index}"></td>`);

    if (DNSRecord.deleted_on == null) {
      html = html.concat(`
                  <td>${DNSRecord.subDomain}</td>
                  <td class="td-type center">${DNSRecord.DNS_FieldObject.label}</td>`);

      switch (DNSRecord.DNS_type) {
        case "DNS_Record_MX":
          html = html.concat(`
                  <td>${DNSRecord.priority + DNSRecord.target}</td>`);
          break;

        case "DNS_Record_STANDARD":
          html = html.concat(`
                  <td>${DNSRecord.target}</td>`);
          break;

        default:
          break;
      }

      html = html.concat(`
                  <td style="text-align: center;">---</td>
                  <td class="td-button">
                    <button type="button" name="button" title="Editer" class="positive" onclick="editDNSLine(this)">Editer</button>
                    <button type="button" name="button" title="Archiver" class="negative" onclick="archiveDNSLine(this)">Archiver</button>
                  </td>
                </tr>`);

    } else {
      html = html.concat(`
                  <td class= "archived" > ${DNSRecord.subDomain}</ >
                  <td class="td-type center archived">${DNSRecord.DNS_FieldObject.label}</td>`);
      switch (DNSRecord.DNS_type) {
        case "DNS_Record_MX":
          html = html.concat(`
                  <td class="archived">${DNSRecord.priority + DNSRecord.target}</td>`);
          break;

        case "DNS_Record_STANDARD":
          html = html.concat(`
                  <td class="archived">${DNSRecord.target}</td>`);
          break;

        default:
          break;
      }

      html = html.concat(`
                  <td style="text-align: center; color: #e85a4e">${DNSRecord.timeBeforeDeleted}j</td>
                  <td class="td-button">
                    <button type="button" name="button" title="Restaurer" class="positive" onclick="restoreDNSLine(this)">Restaurer</button>
                    <button type="button" name="button" title="Supprimer" class="negative" onclick="deleteDNSLine(this)">Supprimer</button>
                  </td>
                </tr>`);
    }
  });

  document.getElementsByTagName("tbody")[0].innerHTML = html;
}

function displayEditLine(list_DNSField, columns) {
  columns[1].style.overflow = "none";
  columns[2].style.overflow = "none";
  columns[3].style.overflow = "none";
  
  columns[1].innerHTML = `<input type = "text" name = "host" value = "${arrayDNS_info["host"]}"> `;

  /*Select Input*/
  var select_HTML = `<select class="center" name = "type">`;
  list_DNSField.forEach(function (currentValue) {
    select_HTML = select_HTML.concat(`<option value="${currentValue.id}">${currentValue.label}</option>`);
  });
  select_HTML = select_HTML.concat(`</select>`);
  columns[2].innerHTML = select_HTML;
  /* ----------- */

  columns[3].innerHTML = `<input type="text" name="value" value="${arrayDNS_info["value"]}">`;
}