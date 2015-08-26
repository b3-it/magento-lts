<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Container
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Container extends Mage_Adminhtml_Block_Widget_Container
{
	public function getRefreshExportMessage()
	{
		return Mage::helper('ibewi')->__("Date has been changed. Use \'Show Report\' Button to force reloading of new data.");
	}
}