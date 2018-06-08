<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids_Block_DosUrl
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Block_Adminhtml_Dos_Url extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_dos_url';
    $this->_blockGroup = 'b3it_ids';
    $this->_headerText = Mage::helper('b3it_ids')->__('Dos Url Manager');
    $this->_addButtonLabel = Mage::helper('b3it_ids')->__('Add Item');
    parent::__construct();
  }
}
