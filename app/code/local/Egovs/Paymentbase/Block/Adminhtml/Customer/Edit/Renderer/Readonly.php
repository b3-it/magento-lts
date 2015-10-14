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
class Egovs_Paymentbase_Block_Adminhtml_Customer_Edit_Renderer_Readonly extends Varien_Data_Form_Element_Text
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
        return parent::getHtml();
    }
}