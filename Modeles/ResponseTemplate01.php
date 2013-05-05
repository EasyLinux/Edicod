<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm">
  <page_header>
    
  </page_header>
    
  <page_footer>
    <div>page [[page_cu]]/[[page_nb]]</div>    
  </page_footer>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 14px">
        <tr>
            <td style="width: 35%;">
                <div>{lastNameSend} {firstNameSend}</div>
                <div>{raisocSend}</div>
                <div>{addressSend}</div>
                <div>{zipSend} {citySend}</div>
            </td>
            <td style="width:65%;">

            </td>
        </tr>
    </table>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 14px">
        <tr>
            <td  style="width: 65%;">
                
            </td>
            <td style="width: 35%;">
                <div>{lastNameRecip} {firstNameRecip}</div>
                <div>{raisocRecip}</div>
                <div>{addressRecip}</div>
                <div>{zipRecip} {cityRecip}</div>
                <div style="margin-top: 10px;">A {citySend}, Le {dateSend}</div>
            </td>
        </tr>
    </table>

    <div id="objet" style="margin:auto;margin-top: 35px;">
        <b>Objet :</b> {object}
    </div>
    
    <div id="corps" style="margin:auto;">
      {content}
    </div>
</page>