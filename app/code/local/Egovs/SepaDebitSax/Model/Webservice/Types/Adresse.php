<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Adresse originally named WSAdresse
 * Documentation : Mandatsdaten, ohne das eigentliche Mandat: id: DB-Id der MV
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Adresse 
extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
implements Egovs_Paymentbase_Model_Sepa_Mandate_Interface_Address
{
	
	
	protected function _getParamLength($name) {
		switch ($name) {
			case 'land':
				$length = 3;
				break;
			case 'hausNr':
			case 'postfach':
			case 'PLZ':
				$length = 10;
				break;
			case 'ort':
				$length = 22;
				break;
			case 'strasse':
				$length = 100;
				break;
			default:
				$length = 100;
		}
	
		return $length;
	}
	
	
    /**
     * The Strasse
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Strasse;
    /**
     * The Plz
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Plz;
    /**
     * The Stadt
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Stadt;
    /**
     * The Land
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Land;
    /**
     * The Postfach
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Postfach;
    /**
     * Constructor method for WSAdresse
     * @see parent::__construct()
     * @param string $_strasse
     * @param string $_plz
     * @param string $_stadt
     * @param string $_land
     * @param string $_postfach
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Adresse
     */
    public function __construct($_strasse = null,$_plz = null,$_stadt=null,$_land=null,$_postfach=null)
    {
        parent::__construct(array('Strasse'=>$_strasse,'Plz'=>$_plz,'Stadt'=>$_stadt,'Land'=>$_land,'Postfach'=>$_postfach),false);
    }
    
    /**
     * Get Strasse value
     * @return string
     */
    public function getStrasse()
    {
        return $this->Strasse;
    }
    /**
     * Set Strasse value
     * @param string $_strasse the Strasse
     * @return string
     */
    public function setStrasse($_strasse)
    {
    	$this->Strasse = $_strasse;
        return $this;
    }
    
    public function setPlz($value)
    {
    	$this->Plz = $value;
    	return $this;
    }
    
    public function setStadt($value)
    {
    	$this->Stadt = $value;
    	return $this;
    }
    
    public function setPostfach($value)
    {
    	$this->Postfach = $value;
    	return $this;
    }
    
    public function setLand($value)
    {
    	$this->Land = $value;
    	return $this;
    }
  
    
    /**
     * Get Plz value
     * @return string
     */
    public function getZip()
    {
        return $this->Plz;
    }
    /**
     * Set Plz value
     * @param string $_plz the Plz
     * @return string
     */
    public function setZip($_plz)
    {
        return ($this->Plz = $_plz);
    }
    /**
     * Get Stadt value
     * @return string
     */
    public function getCity()
    {
        return $this->Stadt;
    }
    /**
     * Set Stadt value
     * @param string $_stadt the Stadt
     * @return string
     */
    public function setCity($_stadt)
    {
        return ($this->Stadt = $_stadt);
    }
    /**
     * Get Land value
     * @return string
     */
    public function getCountry()
    {
        return $this->Land;
    }
    /**
     * Set Land value
     * @param string $_land the Land
     * @return string
     */
    public function setCountry($_land)
    {
        return ($this->Land = $_land);
    }
    /**
     * Get Postfach value
     * @return string
     */
    public function getPostofficeBox()
    {
        return $this->Postfach;
    }
    /**
     * Set Postfach value
     * @param string $_postfach the Postfach
     * @return string
     */
    public function setPostofficeBox($_postfach)
    {
        return ($this->Postfach = $_postfach);
    }

    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
    
    
    public function getStreet($withHouseNr = true)
    {
    	return $this->getStrasse();
    }
    public function getHousenumber()
    {
    	$hn = mb_substr($this->getStrasse(), mb_strrpos($this->getStrasse(), " ")+1);
    	return "";
    }
   
    public function setStreet($street)
    {
    	$this->setStrasse($street);
    	return $this;
    }
    
    
    
    
    
    public function setHousenumber($number)
    {
    	return $this;
    }
    
  
    
}
