<?php

/**
 * Code html du modèle contenant des clés de la forme {keyname} qui seront évaluées par la suite.
 */
class PdfHtmlTemplate
{
    private $content;
    private $listeParametres;

    /**
     *  Retourne le code html du template.
     * @param boolean $replaceVar True pour retourner le contenu avec les clés évaluées.
     */
    public function getContent($replaceVar)
    {
        $returnContent = $this->content;
        if($replaceVar)
        {
            foreach ($this->listeParametres as $param)
            {
                $returnContent = str_replace($param->getKey(), $param->getValue(), $returnContent);
            }
        }
        return $returnContent;
    }

    /**
     * 
     * @param string $content Code html.
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

   /**
     * Code html d'un modèle qui servira à créer un pdf.
     * @param array $listeParametres Liste de TemplateParam à insérer dans le texte.
     */
    public function  __construct($content, $listeParametres)
    {
        $this->content = $content;
        $this->listeParametres = $listeParametres;
    }
}

/**
 * Variable à insérer dans le texte du pdf.
 */
class TemplateParam
{
    private $key;
    private $value;

    /**
     *
     * @param string $key Clé à remplacer dans le texte du template
     * @param string $value Valeur par laquelle sera remplacé la clé
     */
    public function  __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setvalue($value)
    {
        $this->value = $value;
    }

    public function getvalue()
    {
        return $this->value;
    }
}
?>
