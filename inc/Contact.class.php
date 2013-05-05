<?php
require_once 'Coordonnees.class.php';
/**
 * Description of Contact
 *
 * @author Michael LELIEVRE
 */
class Contact
{
    private $id;
    private $valid;
    private $company;
    private $name;
    private $givenName;
    private $coordonnees;

    function __construct()
    {
    }

    function Construct($id, $valid, $company, $name, $givenName, Coordonnees $coordonnees)
    {
        $this->id = $id;
        $this->valid = $valid;
        $this->company = $company;
        $this->name = $name;
        $this->givenName = $givenName;
        $this->coordonnees = $coordonnees;
    }

    /**
     * Retourne les coordonnées du contact
     * @return Coordonnees
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    public function setCoordonnees(Coordonnees $coordonnees)
    {
        $this->coordonnees = $coordonnees;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Retourne le nom de famille du contact.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Retourne le prénom du contact.
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getValid()
    {
        return $this->valid;
    }

    public function setValid($valid)
    {
        $this->valid = $valid;
    }

    

    
    /**
     * Retourne les coordonnees de l'expéditeur.
     * @param db $Db
     * @param int $id
     * @param string $SenderType Chaîne de caractères représentant le type de l'expéditeur.
     * "U" pour un utilisateur "G" pour un Service.
     * @return Contact
     */
    public static function GetContactById($Db,$Id)
    {
      $Sql = "SELECT * FROM contact WHERE conid=$Id;";
      $Db->Query($Sql);
      return( $Db->loadObject() );
    }
    
}

class ContactsDb
{
    /**
     * Retourne un contact en fonction de son identifiant.
     * @param db $Db
     * @param int $id
     * @return Contact
     */
    public static function getContactById(db $Db, $id)
    {
        $Sql = "SELECT * FROM contact WHERE conid=".$id;
        $Db->Query($Sql);
        $Contact = $Db->loadObject();
        return new Contact($Contact->conid, $Contact->valid, $Contact->company, $Contact->name,
                $Contact->given_name, new Coordonnees($Contact->email, $Contact->phone, $Contact->address1,
                $Contact->address2, $Contact->city, $Contact->zip));
    }

    /**
     * Retourne les coordonnees de l'expéditeur.
     * @param db $Db
     * @param int $id
     * @param string $SenderType Chaîne de caractères représentant le type de l'expéditeur.
     * "U" pour un utilisateur "G" pour un Service.
     * @return Contact
     */
    public static function getSenderById(db $Db, $id, $SenderType)
    {
        if($SenderType == "U") // Si l'expediteur est un utilisateur
        {
            return self::getUserInfosExpe($Db, $id);
        }
        else
        {
            return self::getUserInfosExpe($Db, $id);
            //return $this->getServiceInfosExpe($Db, $id);
        }
    }

    private static function getUserInfosExpe(db $Db, $id)
    {
        $Sql = "SELECT * FROM user WHERE uid=".$id;
        $Db->Query($Sql);
        $Contact = $Db->loadObject();
        $Raisoc = $Db->GetParamValue("Raisoc");
        return new Contact($Contact->conid, $Contact->valid, $Raisoc, $Contact->name,
                $Contact->given_name, new Coordonnees($Contact->email, $Contact->phone, $Contact->address1,
                $Contact->address2, $Contact->city, $Contact->zip));
    }

    private static function getServiceInfosExpe(db $Db, $id)
    {
        // Infos non connues pour l'instant
    }
    

    
}
?>
