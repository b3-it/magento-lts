<?php
/**
 * Products by Customer
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Pbc extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
    	parent::__construct();
    	
        $this->_headerText = Mage::helper('extreport')->__('Products by Customer');
		$this->_controller = 'sales_pbc';	//Block Pfad ohne adminhtml
		$this->_blockGroup = 'extreport'; //_controller funktioniert sonst nicht
                    
        $this->_removeButton('add');
    }
}
