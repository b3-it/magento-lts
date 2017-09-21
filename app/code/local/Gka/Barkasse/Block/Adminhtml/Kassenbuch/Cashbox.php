<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_KassenbuchCashbox
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_kassenbuch_cashbox';
    $this->_blockGroup = 'gka_barkasse';
    $this->_headerText = Mage::helper('gka_barkasse')->__('Kassenbuch Cashbox Manager');
    $this->_addButtonLabel = Mage::helper('gka_barkasse')->__('Add Item');
    parent::__construct();
  }
}
