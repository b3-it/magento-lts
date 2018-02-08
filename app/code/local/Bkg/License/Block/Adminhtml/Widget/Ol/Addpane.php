<?php
/**
 * 
 *  Anzeige einer Liste von Einträgen mit Position 
 *  @category Egovs
 *  @package  Egovs_Base_Adminhtml_Widget_Form_Toll
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Widget_Ol_Addpane extends Mage_Adminhtml_Block_Widget
{
	
	protected function _construct($attributes = array())
	{
		parent::_construct();
		$this->setTemplate('bkg/license/widget/form/ol/addpane.phtml');
		$this->setData($attributes);
	}
	
   public function getTollSelectHtml()
   {
   		$res = array();
   		$collection = Mage::getModel('bkg_tollpolicy/toll')->getCollection();
   		
   		$res[] = "<select>";
   		foreach($collection as $item)
   		{
   			$res[] = '<option value="'.$item->getId().'">'  . $item->getName() ."</option>";
   		}
   		$res[] = "<select>";
   		return  implode(' ', $res);

   }
    
}