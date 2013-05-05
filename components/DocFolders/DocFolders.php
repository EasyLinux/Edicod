<?php
/**
 * Gestion des répertoires
 *
 * @package		Composants
 * @subpackage		DocFolders
 * @access		public
 * @version		1.2
 * @author              Serge NOEL
 */
$uniqueid = 0;

/**
 * Initialisation du composant
 *
 * @ignore
 */
function ContentInit($Db, $Html)
{
    global $uniqueid;
    session_start();
    $Html->add_js_file("/js/prototype.js");
    $Html->add_js_file("/js/effects.js");
    $Html->add_js_file("/js/window.js");
    $Html->add_js_file("/js/ajax.js");
    $Html->add_js_file("/js/php.js");
    $Html->add_js_file("/js/dtree.js");

    $Html->add_js_file("/components/DocFolders/DocFolders.js");
    $Html->add_js_file("/components/FrontPage/FrontPage.js");
    $Html->add_js_file("/components/FrontPage/FrontPageEdit.js");
    $Html->add_js_file("/components/FrontPage/FrontPageEditNote.js");
    $Html->add_js_file("/components/FrontPageEdit/FrontPageEdit.js");
    $Html->add_js_file("/components/EditFile/EditFile.js");
    $Html->add_js_file("/components/EditFile/js/tinymce/jscripts/tiny_mce/tiny_mce.js");

    $Html->add_css("/css/default.css");
    $Html->add_css("/css/lighting.css");

    $Content = "";

    $Path = $_SESSION["Parameters"]["AbsoluteDocuments"] . $_SESSION["Parameters"]["StorePath"];

    $innerHTML = "
    <script type='text/javascript'>
    d = new dTree('d');
    d.icon.root = '/img/dTree/dossiers.png';
    d.icon.node = '/img/dTree/folderclose.png';
    d.add(0,-1,'Tous les dossiers',\"SetFolderActive(-1);\");\n";
    $innerHTML .= GetFolders($Db,0);
    $innerHTML .= "document.write(d);
    </script>";

    $JavaScript = "<script type='text/javascript'>
    RadioSelected=-1;
    RootPath='$Path';
    </script>";

    $Content = "
    <!-- Folders -->
    $JavaScript
    <div class='main' >
    <table border='0' cellspacing='0' cellpadding='0' width='720px'>
      <tr>
        <td class='CadreTopLeft'></td>
        <td class='CadreTop'>Dossiers virtuels</td>
        <td class='CadreTopRight'></td>
      </tr>
        <td class='CadreLeft'></td>
        <td class='CadreContent'>&nbsp;</br>
        <div style='width: 260px; height: 350px; border: 1px solid black; margin-left: 10px; overflow-y: auto; float: left'>
    $innerHTML
        </div>
        <div style='width: 400px; height: 350px; border-right: 1px solid black; border-bottom: 1px solid black; border-top: 1px solid black; overflow-y: auto; float: left' id='List'>
        </div>
        <div class='formButtons2' style='width: 670px'>
          <div class='formButtonsItemL'> <!--style='margin-left: 10px'-->
            <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='Add();' />
          </div>
          <div class='formButtonsItemL'> <!--style='margin-left: 20px'-->
            <img src='/img/Folders/FolderRen.png' class='ImgButton' alt='Supprimer' title='Renommer' onClick='Rename();' />
          </div>
          <div class='formButtonsItemL'> <!--style='margin-left: 20px'-->
            <img src='/img/Folders/FolderDel.png' class='ImgButton' alt='Supprimer' title='Supprimer' onClick='Del();' />
          </div>
          <div class='formButtonsItemR'> <!--style='margin-left: 452px'-->
            <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='DFQuit();' />
          </div>
        </div></td>
        <td class='CadreRight'></td>
      <tr>
      </tr>
        <td class='CadreBottomLeft'></td>
        <td class='CadreBottom'></td>
        <td class='CadreBottomRight'></td>
      <tr>
      </tr>
    </table>
    </div>
    <script type='text/javascript'>

    // Fenetre popup
    win = new Window('MyPop',{className: \"bluelighting\", closable:false, resizable:false, maximizable: false, minimizable:false, showEffect:Effect.Appear, hideEffect:Effect.Fade});
    win.setZIndex(10);
    </script>

    <div id='Status' class='Status'></div>
    <div id='MyPopup' style='display: none'></div>
    <div id='overlay_modal' class='overlay_bluelighting' style='position: absolute; top: 0px; left: 0px; z-index: 5; width: 100%; height: 100%; opacity: 0.6; display: none;'/></div>
    <!-- Folders -->\n";
    return $Content;
}

/**
 * Analyse les dossiers (récursif)
 * 
 * @param		object		Base de données
 * @param		int		Id parent
 */
function GetFolders($Db,$Parent)
{
    global $uniqueid;
    $Ret = "";

    $Sql = "SELECT * FROM folders WHERE parent=$Parent ORDER BY label";
    $Db->Query($Sql);
    $Reps = $Db->loadObjectList();
    foreach( $Reps as $Rep )
    {
        // Est ce une feuille ou une branche ?
        $Ret .= "d.add($Rep->fid,$Rep->parent,'$Rep->label',\"SetFolderActive(".$Rep->fid.");\");\n";
        $Sql = "SELECT * FROM folders WHERE parent=". $Rep->fid ." ;";
        $Db->Query($Sql);
        if( $Db->NumRows() > 0 )
        $Ret .= GetFolders($Db,$Rep->fid);
    }
    return $Ret;
}

/**
 * Affichage d'une sélection de répertoire
 *
 */
function DisplayDocFolders($Db)
{
    $Content = "
    <!-- DisplayDocFolders -->
    <div id='DocFolderTree' style='border: 1px solid gray; height: 355px; overflow-y: auto'>
    </div>
    <div class='formButtons' style='margin-top: 10px'>
      <img src='/img/Folders/FolderAdd.png' class='ImgButton' alt='Ajouter' title='Ajouter' onClick='AddDocFolder();'  style='margin-left: 20px'/>
      <img src='/img/Folders/Ok.png' class='ImgButton' alt='Choisir' title='Choisir' onClick='SelectDocFolder();'  style='margin-left: 460px'/>
      <img src='/img/Folders/Door.png' class='ImgButton' alt='Quitter' title='Quitter' onClick='QuitDocFolder();'  style='margin-left: 20px'/>
    </div>
    <script type='text/javascript'>
    d = new dTree('d');
    d.icon.root = '/img/dTree/dossiers.png';
    d.icon.node = '/img/dTree/folderclose.png';
    d.add(0,-1,'Tous les dossiers',\"SetFolderActive(-1);\");
    ". GetFolders($Db,0) ."
    document.getElementById('DocFolderTree').innerHTML = d;
    </script>
    <!-- DisplayDocFolders -->
    ";
    return $Content;
}




/* Partie Ajax */
session_start();
$Option = $_GET['Option'];
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
// Initialise la Bdd
$BaseURL = $_SERVER["DOCUMENT_ROOT"];
require_once("$BaseURL/inc/Db.Inc.php");
require_once("$BaseURL/inc/lib.inc.php");
$Db = new db($_SESSION['Parameters']['SqlEngine'], $_SESSION['Parameters']['SqlSvr'], $_SESSION['Parameters']['SqlBase'], 
             $_SESSION['Parameters']['SqlUsr'] , $_SESSION['Parameters']['SqlPwd']);

switch( $Option )
{
    case 'AddFolder':  // /components/DocFolders/DocFolders.php?Option=AddFolder&Id=1&Val=val
        $Parent = $_GET["Id"];
        if( $Parent == -1 )
            $Parent = 0;
        $Label = htmlentities(urldecode($_GET["Val"]),ENT_QUOTES,"UTF-8");
        $Sql = "INSERT INTO folders SET parent=$Parent, label='$Label' ;";
        $Db->Query($Sql);
        MyLog($Db,$_SESSION['User']['uid'],1,"Ajout du dossier virtuel $Label ($Parent)");
        break;

    case 'DelFolder':
        $Fid = $_GET["Id"];
        // Retrouver le nom du répertoire
        $Sql = "SELECT * FROM folders WHERE fid=$Fid ;";
        $Db->Query($Sql);
        $Rep = $Db->loadObject();
        $Label = $Rep->label;
        // Il ne doit rien contenir
        $Sql = "SELECT * FROM docfolders WHERE fid=$Fid ;";
        $Db->Query($Sql);
        if( $Db->NumRows() > 0 )
        {
            echo "<font color='red'><b>ERREUR :</b> Le dossier n'est pas vide !</font>";
            break;
        }
        // Le dossier ne doit pas être parent
        $Sql = "SELECT * FROM folders WHERE parent=$Fid ;";
        $Db->Query($Sql);
        if( $Db->NumRows() > 0 )
        {
            echo "<font color='red'><b>ERREUR :</b> Le dossier a des dossiers enfants !</font>";
            break;
        }
        $Sql = "DELETE FROM folders WHERE fid=$Fid ;";
        $Db->Query($Sql);
        MyLog($Db,$_SESSION['User']['uid'],1,"Suppression du dossier virtuel $Label");
        break;

    case 'RenFolder':
        $Fid = $_GET["Id"];
        $Sql = "SELECT * FROM folders WHERE fid=$Fid ;";
        $Db->Query($Sql);
        $Rep = $Db->loadObject();
        $OldLabel = $Rep->label;
        $Label = htmlentities(urldecode($_GET["Val"]),ENT_QUOTES,"UTF-8");
        $Sql = "UPDATE folders SET label='$Label' WHERE fid=$Fid ;";
        $Db->Query($Sql);
        MyLog($Db,$_SESSION['User']['uid'],1,"Rennomage du dossier virtuel de $OldLabel vers $Label");
        break;

    case 'GetLabel':
        $Fid = $_GET["Id"];
        $Sql = "SELECT * FROM folders WHERE fid=$Fid ;";
        $Db->Query($Sql);
        $Rep = $Db->loadObject();
        echo $Rep->label;
        break;

    case 'GetFiles':
        $Sql  = "SELECT doc.date_in, doc.object, doc.did, doc.wfsid, dfl.did, dfl.fid, fld.fid, fld.label, wfd.wfsid, wfd.guid, wfd.col";
        $Sql .= "    FROM documents doc, folders fld, docfolders dfl, wf_details wfd";
        $Sql .= "    WHERE doc.did=dfl.did";
        $Sql .= "      AND fld.fid=dfl.fid";
        $Sql .= "      AND doc.wfsid=wfd.wfsid";
        $Sql .= "      AND " . $_SESSION["User"]["Guids"];
        $Sql .= "      AND fld.fid=".$_GET["Id"];
        $Sql .= "    GROUP BY doc.object";
        $Sql .= "    ORDER BY doc.date_in DESC;";
        // print $Sql;
        $Db->Query($Sql);
        $Reps = $Db->loadObjectList();
        $Html = "<table width='100%' border='0'>\n";
        foreach( $Reps as $Rep )
        {
            if( ($_SESSION["User"]["Rigths"] >= 7) || ($Rep->col !=3) )
                $Html .= "  <tr>\n    <td width='80px'>".Date_US_To_Fr($Rep->date_in)."</td><td><a class='fp' onClick='DisplayFile(".$Rep->did.");' href='#'>".$Rep->object."</a></td>\n  </tr>\n";
            	//$Html .= "  <tr>\n    <td width='80px'>".Date_US_To_Fr($Rep->date_in)."</td><td><a class='fp' onClick='EditFile(".$Rep->did.");' href='#'>".$Rep->object."</a></td>\n  </tr>\n";
            else
                $Html .= "  <tr>\n    <td width='80px'>".Date_US_To_Fr($Rep->date_in)."</td><td><a class='fp' onClick='DisplayFile(".$Rep->did.");' href='#'>".$Rep->object."</a></td>\n  </tr>\n";
        }
        $Html .= "</table>";
        print $Html;
        break;

    case 'GetTreeLabel':
        $Parent = $_GET["Id"];
        $Msg = '';
        while( $Parent )
        {
            $Sql = "SELECT * FROM folders WHERE fid=$Parent ;";
            $Db->Query($Sql);
            $Rep = $Db->loadObject();
            $Parent = $Rep->parent;
            $Msg = $Rep->label . "/" . $Msg;
        }
        echo "/" . $Msg;
        break;

    case 'DisplayDocFolders':
        print DisplayDocFolders($Db);
        break;

    default:
        echo $Option . "" . $Path;
        echo " ";
        break;

}


?>

