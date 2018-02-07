<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Toll_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Fees extends Mage_Adminhtml_Block_Widget
{
	
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/master/edit/tab/fees.phtml');
	}
	
	
 public function getFeesSections()
    {
    	$sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
    	return $sect;
    }
    
   
}
