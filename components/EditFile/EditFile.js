// Code Javascript

function AbortRespond()
{
    tinyMCE.execCommand('mceRemoveControl',false,'content');
    RespondWin.hide();
    //document.getElementById('RespondId').style.display = 'none';
    var parent = document.getElementById(document.getElementById('parentEditFile').value);
    parent.style.opacity = 1;
    parent.style.filter = 'alpha(opacity=10)';
}

function GetURLParams()
{
    var Html  = urlencode(tinyMCE.get('content').getContent());
    var Ddid = document.getElementById('ddid').value;
    var Did = document.getElementById('did').value;
    var Guid  = document.getElementById('RespondSender').value;
    var Conid = document.getElementById('Rconid').value;
    var Mid = document.getElementById('mid').value;
    var DocName = document.getElementById('Rname').value;
    var RObject = urlencode(htmlentities(document.getElementById('RObject').value,'ENT_QUOTES'));
    var Rreceptnum = urlencode(document.getElementById('Rreceptnum').value);
    var Description = urlencode(htmlentities(document.getElementById('description').value,'ENT_QUOTES'));
    var URL = "Ddid="+Ddid+"&Did="+Did+"&Guid="+Guid+"&Conid="+Conid+"&Mid="+Mid+"&DocName="+DocName+"&RObject="+RObject+"&Rreceptnum="+Rreceptnum+"&Content="+Html+"&Description="+Description;
    return URL;
}

function GetURLParams2()
{
    var content  = urlencode(tinyMCE.get('content').getContent());
    var ddid = document.getElementById('ddid').value;
    var did = document.getElementById('did').value;
    var RespondSender  = document.getElementById('RespondSender').value;
    var Rconid = document.getElementById('Rconid').value;
    var mid = document.getElementById('mid').value;
    var Rname = document.getElementById('Rname').value;
    var RObject = urlencode(htmlentities(document.getElementById('RObject').value,'ENT_QUOTES'));
    var Rreceptnum = urlencode(document.getElementById('Rreceptnum').value);
    var description = urlencode(htmlentities(document.getElementById('description').value,'ENT_QUOTES'));
    var URL = "ddid="+ddid+"&did="+did+"&RespondSender="+RespondSender+"&Rconid="+Rconid+"&mid="+mid+"&Rname="+Rname+"&RObject="+RObject+"&Rreceptnum="+Rreceptnum+"&content="+content+"&description="+description;
    return URL;
}

function RPreview()
{
    var Ddid = document.getElementById('ddid').value;
    var URLParams = GetURLParams();
    if ( Ddid == 0 )
    { // pas de brouillon, pour imprimer, il faut un brouillon
        URL = "/components/EditFile/EditFile.php";
        URLParams = "Option=WriteDraft&"+URLParams;
        alert(wpost(URL, URLParams));
    }
}

/* Sauvegarde le brouillon (dans la table docdraft) */
function SaveDraft()
{
    var Ddid = document.getElementById('ddid').value;
    var URLParams = GetURLParams();
    
    URL = "/components/EditFile/EditFile.php";
    URLParams = "&Option=SaveDraft&"+URLParams;
    
    if ( Ddid == 0 ) {
        URLParams = "&exist=false"+URLParams;
    }
    
    document.getElementById('ddid').value = wpost(URL, URLParams);
    /* *** SUPPRESSION DU BOUTON ENREGISTRER AVEC VALIDATION SUR LA PAGE REPONSE ***
    document.getElementById('div-save-resp-ok').style.display="";
    document.getElementById('div-save-resp-ok-gray').style.display="none";*/

    reloadListResponses();
    alert('Brouillon enregistré.');
    AbortRespond();
}

/* Créé le pdf, le sauvegarde comme un document à part entiere */
/* L'attacher au workflow? */
function SaveRespond()
{

    var URL = "/components/EditFile/EditFile.php?Option=SaveFinalRespond&";
    var URLParams = GetURLParams2();
    wpost(URL, URLParams);
    reloadListResponses();
    alert('Courrier enregistré.');
}

function ShowDraft()
{
    // Appel au fichier php de création du courrier au format PDF

    // @todo construire la page
    // @todo evaluer si brouillon (pas de vraie sauvegarde)
    // @todo lier document
    // @todo attacher au workflow


    var URL = "/components/EditFile/CreerCourrierPDF.php";
    var formulaire = document.forms["Respond"];
    formulaire.action = URL;
    formulaire.submit();

    //alert(GetXmlParams());
    //var XML = GetXmlParams();
    //Msg = wpost(URL, XML);
    // Sort le document en .pdf
    //window.open(URL+'?'+XML,"Votre document","");
    // Agir selon le workflow
    //AbortRespond();
}

function reloadListResponses()
{
    var inputDid = document.getElementById('did').value;
    var URLReloadList = "/components/FrontPage/FrontPage.php?Option=ReloadListResponses&did="+inputDid;
    var newListResponses = wget(URLReloadList);
    var divListResponses = document.getElementById('div-liste-reponses');
    divListResponses.innerHTML = newListResponses;
}


