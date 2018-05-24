<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Block_Contexthelp
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contexthelp';
    $this->_blockGroup = 'contexthelp';
    $this->_headerText = Mage::helper('contexthelp')->__('Contexthelp Manager');
    $this->_addButtonLabel = Mage::helper('contexthelp')->__('Add Item');
    parent::__construct();
  }
}
