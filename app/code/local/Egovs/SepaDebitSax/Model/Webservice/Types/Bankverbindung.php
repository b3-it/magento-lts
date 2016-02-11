<?php
/**
 * File for class Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
/**
 * This class stands for Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung originally named WSBankverbindung
 * Documentation : Mandatsdaten, ohne das eigentliche Mandat: id: DB-Id der MV
 * Meta informations extracted from the WSDL
 * - from schema : ../sepatest2.mandatsverwaltungWS.wsdl
 * @package SepaMv
 * @subpackage Structs
 * @date 2014-03-12
 * @author Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @version 0.9.0.0
 */
class Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung extends Egovs_SepaDebitSax_Model_Webservice_WsdlClass
implements Egovs_Paymentbase_Model_Sepa_Bankaccount
{
	
	
	
    /**
     * The Iban
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Iban;
    /**
     * The Bic
     * Meta informations extracted from the WSDL
     * - maxOccurs : 1
     * - minOccurs : 1
     * @var string
     */
    public $Bic;
    /**
     * Constructor method for WSBankverbindung
     * @see parent::__construct()
     * @param string $_iban
     * @param string $_bic
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function xxxx__construct($_iban,$_bic)
    {
        parent::__construct(array('Iban'=>$_iban,'Bic'=>$_bic),false);
    }
    
    
    public function Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung(
    		$blz = null,
    		$kontoNr = null
    ) {
    	$args = func_get_args();
    	Mage::log(sprintf("%s called...", __METHOD__), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    	switch (count($args)) {
    		case 1:
    			if (is_array($args[0])) {
    				foreach ($args[0] as $k => $v) {
    					$this->$k = $v;
    				}
    			}
    			break;
    		case 2:
    			$this->BLZ = $args[0];
    			$this->kontoNr = $args[1];
    			break;
    		default:
    	}
    
    
    	//parent::Egovs_Paymentbase_Model_Webservice_Types_Abstract();
    }
    /**
     * Get Iban value
     * @return string
     */
    public function getIban()
    {
        return $this->Iban;
    }
    /**
     * Set Iban value
     * @param string $_iban the Iban
     * @return string
     */
    public function setIban($_iban)
    {
        return ($this->Iban = $_iban);
    }
    /**
     * Get Bic value
     * @return string
     */
    public function getBic()
    {
        return $this->Bic;
    }
    /**
     * Set Bic value
     * @param string $_bic the Bic
     * @return string
     */
    public function setBic($_bic)
    {
        return ($this->Bic = $_bic);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @uses Egovs_SepaDebitSax_Model_Webservice_WsdlClass::__set_state()
     * @param array $_array the exported values
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
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
    
    public function getBankname($bic) {
    	if (!$bic) {
    		$bic = $this->getBic();
    	}
    	return Egovs_Paymentbase_Model_SepaDebit::getBankname($bic);
    }
}
