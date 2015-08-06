<?php
/**
 * Frontend-Blockklasse für Readonly Attribute
 *
 * Mit Frontend ist nicht das Frontend des Shops gemeint!
 *
 * @category    Egovs
 * @package     Egovs_Paymentbase
 * @author      Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Customer_Edit_Renderer_Mandate extends Varien_Data_Form_Element_Text
{
	/**
	 * HTML Element auf disabled setzen
	 * 
	 * @return Varien_Data_Form_Element_Text
	 * 
	 * @see Varien_Data_Form_Element_Text::getHtml()
	 */
	public function getHtml() {
		$this->setData('disabled', 'disabled');
		$html ="";
		if(Mage::helper('paymentbase')->isModuleEnabled('Egovs_SepaDebitBund'))
		{
			$html .= '<div><a href="'.$this->getMandateDownloadUrl().'" target="_blank">'.Mage::helper('paymentbase')->__("View current mandate").'</a></div>';
		}
		if ($this->getValue()) {
			$this->setAfterElementHtml($html);
		}
        $html = parent::getHtml();
        
        return $html;
    }
    
    public function getMandateDownloadUrl() {
    	$customer = Mage::registry('current_customer');
    	return Mage::helper("adminhtml")->getUrl('*/paymentbase_mandate/link', array('_secure' => true, 'id' => $customer->getId()));
    }
   
}