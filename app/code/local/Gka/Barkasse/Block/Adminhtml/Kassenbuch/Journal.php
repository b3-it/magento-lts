<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_KassenbuchJournal
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_kassenbuch_journal';
    $this->_blockGroup = 'gka_barkasse';
    $this->_headerText = Mage::helper('gka_barkasse')->__('Kassenbuch Journal');
    
    parent::__construct();
    $this->_removeButton('add');
  }
  
  

}
