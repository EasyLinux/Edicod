<?php
/**
 * Description of Coordonnees
 *
 * @author Michael LELIEVRE
 */
class Coordonnees
{

    private $email;
    private $phoneNumber;
    private $address1;
    private $address2;
    private $city;
    private $zipCode;

    /**
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     *
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     *
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     *
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     *
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     *
     * @param string $email
     * @param string $phoneNumber
     * @param string $address1
     * @param string $address2
     * @param string $city
     * @param string $zipCode
     */
    function __construct($email, $phoneNumber, $address1, $address2, $city, $zipCode)
    {
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->zipCode = $zipCode;
    }
}

/**
 * Classe d'access aux données des coordonnées
 */
class CoordonneesDb
{
    /**
     * Retourne les coodonnées d'un contact.
     * @param db $Db
     * @param int $Conid
     * @return Coordonnees
     */
    public static function GetCoordonneesContact(db $Db, $conid)
    {
        $Sql = "SELECT email, phone, address1, address2, city, zip FROM contact WHERE conid=".$conid;
        $Db->Query($Sql);
        $Coordonnees = $Db->loadObject();
        return new Coordonnees($Contact->email, $Contact->phone, $Contact->address1,
                $Contact->address2, $Contact->city, $Contact->zip);
    }

    /**
     * Retourne les coordonnées d'un utilisateur
     * @param db $Db
     * @param int $uid
     * @return Coordonnees
     * 
     * @todo Déterminer quelles coordonnées utiliser si l'expéditeur n'est pas un utilisateur.
     */
    public static function GetCoordonneesUser(db $Db, $uid)
    {
        $Sql = "SELECT email, phone, address1, address2, city, zip FROM user WHERE uid=".$uid;
        $Db->Query($Sql);
        $Coordonnees = $Db->loadObject();
        return new Coordonnees($Contact->email, $Contact->phone, $Contact->address1,
                $Contact->address2, $Contact->city, $Contact->zip);
    }
}
?>
