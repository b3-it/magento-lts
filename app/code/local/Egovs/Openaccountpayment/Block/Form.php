<?php
/**
 * Formblock für Zahlungen auf Rechnung
 *
 * Setzt eigenes Template
 *
 * @category   	Egovs
 * @package    	Egovs_Openaccountpayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_Openaccountpayment_Block_Form extends Mage_Payment_Block_Form
{
	/**
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Block_Abstract::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->setTemplate('egovs/openaccount/form.phtml');
	}

    /**
	 * Liefert Daten vom angegebenen Feld
	 * 
	 * @param string $field Feldname
	 * 
	 * @return string
	 * 
	 * @see Mage_Payment_Block_Form::getInfoData()
	 */
	public function getInfoData($field) {
		if ($field == 'paywithinxdays') {
			$res = $this->getMethod()->getInfoInstance()->getData($field);
			if (!$res) {
				$res = intval(Mage::getStoreConfig('payment/openaccount/paywithinxdays', 0));
			}
			return  $this->htmlEscape($res);
		}
		return $this->htmlEscape($this->getMethod()->getInfoInstance()->getData($field));
	}

	/**
	 * Bindet den Infoblock mit ein
	 * 
	 * @return string HTML
	 */
	public function getPaymentInfoHtml() {
	    
	    $infoInstance = $this->getMethod()->getInfoInstance();
	    
	    if (!$infoInstance->getMethod()) {
	        $infoInstance->setMethod('openaccount');
	    }
	    
		return $this->getLayout()->createBlock(
				$this->getMethod()->getInfoBlockType(),
				'payment_info',
				array ('info' => $infoInstance)
		)->toHtml();
	}
}
