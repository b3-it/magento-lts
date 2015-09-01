<?php
/**
 * Kunden Guthaben Rendererklasse für intiales Guthaben
 *
 * @category    Stala
 * @package     Stala_Extcustomer
 * @author      Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Edit_Renderer_Initialdiscount extends Varien_Data_Form_Element_Text
{
	public function getHtml() {
        $this->setData('disabled','disabled');
        if ($note = $this->getNote()) {
        	$transNote = Mage::helper('extcustomer')->__($note);
        	if (strcmp($note, $transNote) != 0)
        		$this->setNote($transNote);
        }
        return parent::getHtml();
    }
}