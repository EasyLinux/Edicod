<?php
/**
 * Description of UploadFile
 *
 * @author LELIEVRE Michael
 */
class UploadFile
{
    protected $id;

    protected $blockUploadCssClass;
    protected $blockUploadStyle;

    protected $labelTxt;
    protected $labelCssClass;
    protected $labelStyle;

    protected $inputUploadCssClass;
    protected $inputUploadStyle;

    protected $uploadButtonText;
    protected $uploadButtonCssClass;
    protected $uploadButtonStyle;

    protected $blockMsgCssClass;
    protected $blockMsgStyle;

    protected $msgLoading;
    protected $imageLoading;

    protected $savePath;

    /**
     * Identifiant du composant (pour éviter les conflis lorsqu'il y'en a deux sur la même page)
     * @return string 
     */
    public function getId() {
        return $this->id;
    }

    /**
     *  Identifiant du composant (pour éviter les conflis lorsqu'il y'en a deux sur la même page)
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     *  Class associée à la div contenant la zone "Parcourir" et le bouton "Envoyé"
     * @return string
     */
    public function getBlockUploadCssClass() {
        return $this->blockUploadCssClass;
    }

    /**
     *  Class associée à la div contenant la zone "Parcourir" et le bouton "Envoyé"
     * @param string $blockUploadCssClass
     */
    public function setBlockUploadCssClass($blockUploadCssClass) {
        $this->blockUploadCssClass = $blockUploadCssClass;
    }

    /**
     * Styles associés à la div contenant la zone "Parcourir" et le bouton "Envoyé"
     * @return string
     */
    public function getBlockUploadStyle() {
        return $this->blockUploadStyle;
    }

    /**
     * Styles associés à la div contenant la zone "Parcourir" et le bouton "Envoyé"
     * @param string $blockUploadStyle
     */
    public function setBlockUploadStyle($blockUploadStyle) {
        $this->blockUploadStyle = $blockUploadStyle;
    }

    /**
     *  Label de l'input file.
     * @return string
     */
    public function getLabelTxt() {
        return $this->labelTxt;
    }

    /**
     * Label de l'input file.
     * @param string $labelTxt
     */
    public function setLabelTxt($labelTxt) {
        $this->labelTxt = $labelTxt;
    }

    /**
     * Class css associée au label de l'input file.
     * @return string
     */
    public function getLabelCssClass() {
        return $this->labelCssClass;
    }

    /**
     * Class css associée au label de l'input file.
     * @param string $labelCssClass
     */
    public function setLabelCssClass($labelCssClass) {
        $this->labelCssClass = $labelCssClass;
    }

    /**
     *  Styles css associés au label de l'input file.
     * @return string
     */
    public function getLabelStyle() {
        return $this->labelStyle;
    }

    /**
     *  Styles css associés au label de l'input file.
     * @param string $labelStyle
     */
    public function setLabelStyle($labelStyle) {
        $this->labelStyle = $labelStyle;
    }

    public function getInputUploadCssClass() {
        return $this->inputUploadCssClass;
    }

    public function setInputUploadCssClass($inputUploadCssClass) {
        $this->inputUploadCssClass = $inputUploadCssClass;
    }

    public function getInputUploadStyle() {
        return $this->inputUploadStyle;
    }

    public function setInputUploadStyle($inputUploadStyle) {
        $this->inputUploadStyle = $inputUploadStyle;
    }

    public function getUploadButtonText() {
        return $this->uploadButtonText;
    }

    public function setUploadButtonText($uploadButtonText) {
        $this->uploadButtonText = $uploadButtonText;
    }

    public function getUploadButtonCssClass() {
        return $this->uploadButtonCssClass;
    }

    public function setUploadButtonCssClass($uploadButtonCssClass) {
        $this->uploadButtonCssClass = $uploadButtonCssClass;
    }

    public function getUploadButtonStyle() {
        return $this->uploadButtonStyle;
    }

    public function setUploadButtonStyle($uploadButtonStyle) {
        $this->uploadButtonStyle = $uploadButtonStyle;
    }

    public function getBlockMsgCssClass() {
        return $this->blockMsgCssClass;
    }

    public function setBlockMsgCssClass($blockMsgCssClass) {
        $this->blockMsgCssClass = $blockMsgCssClass;
    }

    public function getBlockMsgStyle() {
        return $this->blockMsgStyle;
    }

    public function setBlockMsgStyle($blockMsgStyle) {
        $this->blockMsgStyle = $blockMsgStyle;
    }

    public function getMsgLoading() {
        return $this->msgLoading;
    }

    public function setMsgLoading($msgLoading) {
        $this->msgLoading = $msgLoading;
    }

    public function getImageLoading() {
        return $this->imageLoading;
    }

    public function setImageLoading($imageLoading) {
        $this->imageLoading = $imageLoading;
    }

    public function getSavePath() {
        return $this->savePath;
    }

    public function setSavePath($savePath) {
        $this->savePath = $savePath;
    }

    /**
     *
     * @param string $id Identifiant du composant (pour éviter les conflis lorsqu'il y'en a deux sur la même page)
     * @param string $savePath Emplacement où enregistrer le fichier.
     */
    public function __construct($id, $savePath = null)
    {
        $this->id = $id;
        $this->savePath = $savePath;

        $this->uploadButtonText = "Envoyer";
        $this->labelTxt = "Fichier : ";
        $this->msgLoading = "Envois ...";

        if($savePath == null)
        {
            $this->savePath = getcwd().DIRECTORY_SEPARATOR;
        }
        if($_FILES[$id.'-file-attach'] != null)
        {
            $this->saveFile();
        }
    }


    /**
     * Retourne le code javascript nécéssaire au fonctionnement
     * @return string
     */
    public function renderJs($id)
    {
        $id = $this->id;
        $javascript = "
        function ".$id."startUpload()
        {
            var divUpload = document.getElementById('".$id."-upload-form');
            var divMsgUpload = document.getElementById('".$id."-loading-upload-msg');
            divUpload.style.visibility = 'hidden';
            divUpload.style.display = 'none';
            divMsgUpload.style.visibility = 'visible';
            divMsgUpload.style.display = 'block';

            return true;
        }";

        /* Fonction appelée à la fin de l'upload    */
        /* Affiche un message d'erreur ou de succes */
        /* et cache la barre de chargement          */
        /********************************************/
        $javascript .= "
        function ".$id."stopUpload(success)
        {
            var result = '';
            if (success == 1)
            {
                result = '<span class=\"msg\">Le fichier a été correctement envoyé<\/span><br/><br/>';
            }
            else
            {
                result = '<span class=\"error-msg\">Une erreur c\'est produite durant l\'envois.<\/span><br/><br/>';
            }

            var divUpload = document.getElementById('".$id."-upload-form');
            var divMsgUpload = document.getElementById('".$id."-loading-upload-msg');
            divUpload.style.visibility = 'visible';
            divUpload.style.display = 'block';
            divUpload.innerHTML = result + '<span class=\"$labelCssClass\" style=\"$labelStyle\">$label</span><input name=\"".$id."-file-attach\" id=\"".$id."-file-attach\" type=\"file\" class=\"$inputUploadCssClass\" style=\"$UploadButtonStyle\" /><input type=\"submit\" name=\"".$id."-submit-attach\" class=\"$UploadButtonClass\" value=\"$UploadButtonText\" style=\"$UploadButtonStyle\" />';
            divMsgUpload.style.visibility = 'hidden';
            divMsgUpload.style.display = 'none';

            document.getElementById('".$id."-upload-form')
            return true;
        }";
        return $javascript;
    }

    /**
     * Retourn le code html du composant
     * @return string
     */
    public function render()
    {
        $id = $this->id;
        $Html = "
        <div style='float:left;margin-top:10px;' id='div-$id'>
            <form action='#' method='post' enctype='multipart/form-data' target='upload_target' onsubmit='startUpload();' >

                <div id='$id-upload-form' class='$this->blockUploadCssClass' style='$this->blockUploadStyle' >
                    <span class='$this->labelCssClass' style='$this->labelStyle'>$label</span>
                    <input name='$id-file-attach' id='$id-file-attach' type='file' class='$this->inputUploadCssClass' style='$this->inputUploadStyle' />
                    <input type='submit' name='$id-submit-attach' class='$this->UploadButtonClass' value='$this->UploadButtonText' style='$this->UploadButtonStyle' />
                </div>

                <div id='$id-loading-upload-msg' class='$this->blockMsgCssClass' style='$this->blockMsgStyle visibility:hidden;' >
                    $msgLoading
                    <img src='$this->imageLoading' />
                </div>
                <iframe id=\"upload_target\" name=\"upload_target\" src=\"#\" style=\"width:0;height:0;border:0px solid #fff;\"></iframe>
             </form>
         </div>";
        return $Html;
    }

    /**
     * Fonction à appeler lors du submit
     */
    public function saveFile()
    {
        $id = $this->id;
        $result = 0;

        $target_path = $this->savePath . basename( $_FILES[$id.'-file-attach']['name']);
        $up = @move_uploaded_file($_FILES[$id.'-file-attach']['tmp_name'], $target_path);
        if($up)
        {
            $result = 1;
        }

        sleep(1);

        echo "<script language=\"javascript\" type=\"text/javascript\">window.top.window.".$id."stopUpload(".$result.", ".$fileName .");</script>";
    }
}
?>
