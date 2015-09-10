<?php

/**
 * 
 *  Persistenz objekt für Template Definitionen 
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Template extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('pdftemplate/template');
	}

	public function Dupicate()
	{
		$collection = Mage::getModel('pdftemplate/section')->getCollection();
		$collection->getSelect()
		->where('pdftemplate_template_id='.$this->getId())
		->order('position');

		$this->unsetData('pdftemplate_template_id')->save();

		foreach($collection->getItems() as $section)
		{
			$section->unsetData('pdftemplate_section_id');
			$section->setData('pdftemplate_template_id',$this->getId());
			$section->save();
		}

		return $this->getId();
	}

	/**
	 * Options getter
	 *
	 * @return array
	 */
	public function toOptionArray($type = null)
	{
		/* @var $collection Egovs_Pdftemplate_Model_Mysql4_Template_Collection */
		$collection = Mage::getSingleton('pdftemplate/template')->getCollection();
		$collection->addFieldToFilter('status', Egovs_Pdftemplate_Model_Status::STATUS_ENABLED);
		if ($type) {
			$collection->addFieldToFilter('type', $type);
		}
		 
		$res = array();
		 
		$res[] = array('value' => '0', 'label'=> Mage::helper('adminhtml')->__('-- Not Selected --'));
		foreach ($collection->getItems() as $item) {
			$res[] = array('value' => $item->getId(), 'label'=>$item->getTitle());
		}
		
		return $res;
	}
}