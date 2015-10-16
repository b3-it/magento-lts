<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten originally named WSMandatsdaten
 * Documentation : Mandatsdaten, ohne das eigentliche Mandat: id: DB-Id der MV
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
{
    /**
     * The Mandatsreferenz
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Mandatsreferenz;
    /**
     * The KreditorGlaeubigerId
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $KreditorGlaeubigerId;
    /**
     * Constructor method for WSMandatsdaten
     * @see parent::__construct()
     * @param string $_mandatsreferenz
     * @param string $_kreditorGlaeubigerId
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten
     */
    public function __construct($_mandatsreferenz,$_kreditorGlaeubigerId)
    {
        parent::__construct(array('Mandatsreferenz'=>$_mandatsreferenz,'KreditorGlaeubigerId'=>$_kreditorGlaeubigerId),false);
    }
    
    protected function _construct() {
    	parent::_construct();
    	//Muss nach getAdapteeMandate aufgerufen werden!
    	
    }
   
    
  
    
    /**
     * Get Mandatsreferenz value
     * @return string
     */
    public function getMandatsreferenz()
    {
        return $this->Mandatsreferenz;
    }
    /**
     * Set Mandatsreferenz value
     * @param string $_mandatsreferenz the Mandatsreferenz
     * @return string
     */
    public function setMandatsreferenz($_mandatsreferenz)
    {
        return ($this->Mandatsreferenz = $_mandatsreferenz);
    }
    /**
     * Get KreditorGlaeubigerId value
     * @return string
     */
    public function getKreditorGlaeubigerId()
    {
        return $this->KreditorGlaeubigerId;
    }
    /**
     * Set KreditorGlaeubigerId value
     * @param string $_kreditorGlaeubigerId the KreditorGlaeubigerId
     * @return string
     */
    public function setKreditorGlaeubigerId($_kreditorGlaeubigerId)
    {
        return ($this->KreditorGlaeubigerId = $_kreditorGlaeubigerId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Mandatsdaten
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
