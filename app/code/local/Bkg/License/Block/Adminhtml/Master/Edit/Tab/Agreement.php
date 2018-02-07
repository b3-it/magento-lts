<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement extends Mage_Adminhtml_Block_Widget_Form
{
	protected function x_construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/master/edit/tab/agreement.phtml');
	}
	
	
	
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
	
		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('agreement_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Agreement information')
		));
	
		$values = $this->getCmsBlocks();
		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$fieldset->addField('shortname', 'ol', array(
				'label'     => Mage::helper('bkg_orgunit')->__('Short name'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'shortname',
				'values' =>$values,
				'value' => array(array('value'=>'footer_links','pos'=>20),array('value'=>2,'pos'=>10))
		));
	}
	
	
	
	public function getCmsBlocks()
	{
		$collection = Mage::getModel('cms/block')->getCollection();
		$res = array();
	
	
		foreach($collection as $item)
		{
			$res[$item->getIdentifier()] = array('label'=>$item->getTitle(), 'value'=>$item->getIdentifier());
		}
	
	
		return $res;
	}
   
}
