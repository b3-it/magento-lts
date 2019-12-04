<?php
/**
 * Block Renderer für verfügbare Versandstatus
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Renderer_Shipmentstate extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options
{
	/**
	 * Rendern
	 * 
	 * @param Varien_Object $row Zeile
	 * 
	 * @return string
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Options::render()
	 */
    public function render(Varien_Object $row) {
        $value = $row->getData($this->getColumn()->getIndex());

        if (intval($value) > 0 ) {
            return '<div style="color:red;">'.Mage::helper('paymentbase')->__('Not Shipped').'</div>';
        } else {
            return '<div style="color:green;">'.Mage::helper('paymentbase')->__('Shipped').'</div>';
        }
    }

    /**
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract::renderExport()
     */
    public function renderExport($row) {
        $value = $row->getData($this->getColumn()->getIndex());

        if (intval($value) > 0) {
            return Mage::helper('paymentbase')->__('Not Shipped');
        } else {
            return Mage::helper('paymentbase')->__('Shipped');
        }
    }

}
