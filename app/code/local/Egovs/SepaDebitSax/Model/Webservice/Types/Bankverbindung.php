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
     * @param string $iban
     * @param string $bic
     * @return Egovs_SepaDebitSax_Model_Webservice_Types_Bankverbindung
     */
    public function __construct(
    		$bic = null,
    		$iban = null
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
    			$this->Bic = $args[0];
    			$this->Iban = $args[1];
    			break;
    		default:
    	}


    	parent::__construct(array('Bic' => $bic, 'Iban' => $iban));
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
    	
    	if (empty($bic) && ($iban = $this->getIban())) {
    		$bic = Egovs_Paymentbase_Helper_Data::getBlzFromIban($iban);
    		if (!$bic) {
    			return '';
    		} else {
    			return Egovs_Paymentbase_Helper_Data::getBankname($bic, true);
    		}
    	}
    	return Egovs_Paymentbase_Helper_Data::getBankname($bic);
    }
}
