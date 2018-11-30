<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Block_KostentraegerAttribute
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_kostentraeger_attribute';
    $this->_blockGroup = 'ibewi';
    $this->_headerText = Mage::helper('ibewi')->__('Cost Unit');
    $this->_addButtonLabel = Mage::helper('ibewi')->__('Add Item');
    parent::__construct();
  }
}
