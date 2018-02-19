<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_File
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_File extends Mage_Adminhtml_Block_Widget
{
	protected $_values = null;
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/copy/edit/tab/file.phtml');
	}
	

   
}
