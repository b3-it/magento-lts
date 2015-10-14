<?php

/**
 * Formblock für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Payment_Block_Form
 */
class Egovs_BankPayment_Block_Form extends Mage_Payment_Block_Form
{
	/**
	 * Überschreibt das Template
	 * 
	 * @see Mage_Core_Block_Abstract::_construct()
	 * 
	 * @return void
	 */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('egovs/bankpayment/form.phtml');
    }
    
    public function getInfoData($field)
    {
    	if($field == 'paywithinxdays')
    	{
    		$res = $this->getMethod()->getInfoInstance()->getData($field);
    		if(!$res)
    		{
    			$res = intval(Mage::getStoreConfig('payment/bankpayment/paywithinxdays', 0));
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
    	return $this->getLayout()->createBlock(
    			$this->getMethod()->getInfoBlockType(),
    			'payment_info',
    			array ('info' => $this->getMethod()->getInfoInstance())
    	)->toHtml();
    }
}
