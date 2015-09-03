<?php
/**
 * Adminhtml Inwards per product
 *
 * @category   Slpb
 * @package    Slpb_Extreport
 */

class Slpb_Extstock_Block_Adminhtml_Extstock_Inwards extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
    	//Angabe des Ordners in dem das Grid liegt
        $this->_controller = 'adminhtml_extstock_inwards';
        $this->_blockGroup = 'extstock';
        $this->_headerText = Mage::helper('extreport')->__('Inwards');
        parent::__construct();  
        $this->_removeButton('add');
    }
}