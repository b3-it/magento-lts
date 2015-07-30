<?php
/**
 * Adminhtml Report: Verkaufte Produkte
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Quantityordered extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Initialisiert den Block-Container
	 *
	 * @return void
	 */
    public function __construct()
    {
    	parent::__construct();
    	
        $this->_headerText = Mage::helper('extreport')->__('Sold Products');
		$this->_controller = 'sales_quantityordered';
        $this->_blockGroup = 'extreport'; //_controller funktioniert sonst nicht
                    
        $this->_removeButton('add');
    }
}
