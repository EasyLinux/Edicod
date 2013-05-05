<?php
require_once 'inc/PdfHtmlTemplate.class.php';
require_once('inc/html2pdf/html2pdf.class.php');
require_once '../../inc/Contact.class.php';

/**
 * Description of ResponsePdf
 *
 * @author greg
 */
class ResponsePdf
{
    public static function ShowDraft(db $Db, $request)
    {
        try
        {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML(self::CreatePDFContent($Db, $request)->getContent(true));
            $html2pdf->Output($request["Rname"], 'I');
        }
        catch(HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
    }

    public static function SaveFinalRespond(db $Db, $request)
    {
        try
        {
            $SenderType = substr($request["RespondSender"],0,1);
            $html2pdf = new HTML2PDF('P', 'A4', 'fr');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML(self::CreatePDFContent($Db, $request)->getContent($Db, $request));
            self::SaveResp($Db, $html2pdf, $request["Rname"], $SenderType);
        }
        catch(HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
    }

    private static function CreatePDFContent($Db, $request)
    {
        $Guid  = $request["RespondSender"];
        $Conid = $request["Rconid"];
        $DocName = $request["Rname"];
        $SenderType = substr($Guid,0,1);
        $BaseURL = $_SERVER["DOCUMENT_ROOT"];
        
        // Récupération du contenu du template (A rendre un peu plus dynamique...)
        ob_start();
        include($BaseURL.'/Modeles/ResponseTemplate01.php');
        $content = ob_get_clean();

        $listeParametres = self::initParams($Db, $request, $Guid, $SenderType, $request["Rconid"]);
        $templatePdf = new PdfHtmlTemplate($content, $listeParametres);
        return $templatePdf;
        
    }

    private static function initParams(db $Db, $request, $Guid, $SenderType, $Conid)
    {
        /* Liste des paramètres pouvant être insérer dans le template du PDF.*/
        $listeParametres = array();
        $SenderId = substr($Guid, 1);

        // Infos Expéditeur
        $sender = ContactsDb::getSenderById($Db, intval($SenderId), $SenderType);
        $listeParametres[] = new TemplateParam("{raisocSend}", $sender->getCompany());
        $listeParametres[] = new TemplateParam("{addressSend}", $sender->getCoordonnees()->getAddress1());
        $listeParametres[] = new TemplateParam("{firstNameSend}", $sender->getGivenName());
        $listeParametres[] = new TemplateParam("{lastNameSend}", $sender->getName());
        $listeParametres[] = new TemplateParam("{zipSend}", $sender->getCoordonnees()->getZipCode());
        $listeParametres[] = new TemplateParam("{citySend}", $sender->getCoordonnees()->getCity());

        // Infos Destinataire
        $contact = ContactsDb::getContactById($Db, $Conid);
        $listeParametres[] = new TemplateParam("{raisocRecip}", $contact->getCompany());
        $listeParametres[] = new TemplateParam("{addressRecip}", $contact->getCoordonnees()->getAddress1());
        $listeParametres[] = new TemplateParam("{firstNameRecip}",$contact->getGivenName());
        $listeParametres[] = new TemplateParam("{lastNameRecip}", $contact->getName());
        $listeParametres[] = new TemplateParam("{zipRecip}", $contact->getCoordonnees()->getZipCode());
        $listeParametres[] = new TemplateParam("{cityRecip}", $contact->getCoordonnees()->getCity());

        $listeParametres[] = new TemplateParam("{object}", $request["RObject"]);
        $listeParametres[] = new TemplateParam("{content}", $request["content"]);
        $listeParametres[] = new TemplateParam("{dateSend}", date("d/m/y"));

        return $listeParametres;
    }

    private static function GetSavePath(db $Db, $SenderType)
    {
        if($SenderType == "U")
            $Part = "/Users/".$_SESSION["User"]["Login"].date("/Y/m");
        else
        {
            $Part = "/Services";
            foreach( $_SESSION["User"]["Groups"] as $Grp )
            {
                if( $Grp->gid == substr($Guid,1) )
                    $Part .= "/".$Grp->name;
            }
            $Part .= date("/Y/m");
        }

        $PDFPath = $_SESSION['Parameters']['AbsoluteDocuments'].$_SESSION['Parameters']['OutputPath'].$Part;
        //$PDFPath = $_SESSION['Parameters']['RelativeDocuments'].$_SESSION['Parameters']['OutputPath'].$Part;
        //return substr($PDFPath, 1);
        return $PDFPath;
    }

    private static function getRelativePath($AbsolutPath)
    {
        $relativePath = str_replace($_SESSION['Parameters']['AbsoluteDocuments'], "", $AbsolutPath);
        $relativePath = $_SESSION['Parameters']['RelativeDocuments'].$relativePath;
        return $relativePath;
    }

    /**
     * Enregistre le fichier PDF sur le serveur et son chemin d'acces dans la base de donnée
     * @param db $Db
     * @param HTML2PDF $Pdf
     * @param string $DocName
     * @param string $SenderType
     */
    private static function SaveResp(db $Db, HTML2PDF $Pdf, $DocName, $SenderType)
    {
        $PDFPath = self::GetSavePath($Db, $SenderType);
        if(!file_exists($PDFPath))
        {
          if(!mkdir($PDFPath,0777,true))
          {
            print "ERREUR: ne peut créer".$PDFPath;
            die();
          }
        }
        $i = 1;
        $oldDocName = $DocName;
        while(file_exists($PDFPath."/".$DocName))
        {
            $DocName = str_replace(".pdf", "", $oldDocName)."_".$i.".pdf";
            $i++;
        }
        $Sql = "UPDATE docdraft SET name = '".$DocName."', path = '".self::getRelativePath($PDFPath)."' WHERE ddid=".$_POST["ddid"]. ";";
        $Db->Query($Sql);
        $ret = $Pdf->Output($PDFPath."/".$DocName, "F");
    }
}
?>
