<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Orderitem
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Orderitem extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_orderitem';
    $this->_blockGroup = 'dwd_icd';
    $this->_headerText = Mage::helper('dwd_icd')->__('ICD Order Items');
    $this->_addButtonLabel = Mage::helper('dwd_icd')->__('Add Item');
    parent::__construct();
    
    $debug = (bool) Mage::getStoreConfigFlag('dwd_icd/debug/is_debug');   
    //if (!$debug)
     { $this->_removeButton('add');}
  }
}