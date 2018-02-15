<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Toll_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Toll extends Mage_Adminhtml_Block_Widget_Form
{

	protected function x_construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/copy/edit/tab/toll.phtml');
	}

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('unit_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Type Of Use Information')
		));

		//die Einträge der ersten selectbox - Gebührenkategorien
		$collection = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection();
		$categorys = array();
		$categorys[] = array('value'=>0,'label'=>$this->__('-- Please Select --'));
		foreach ($collection as $item)
		{
			$categorys[] = array('value'=>$item->getId(),'label'=>$item->getName());
		}
	
		
		//die an der Lizenz gespeicherten Werte
		$collection = Mage::getModel('bkg_license/copy_toll')->getCollection();
		$collection->addCopyIdFilter(Mage::registry('entity_data')->getId());
			
		$value = array();
		$ids = array();
		foreach($collection as $item)
		{
			$value[] = array('value'=>$item->getUseoptionId(),'pos'=>$item->getPos());
			$ids[] = $item->getUseoptionId();
		}
		
		//die Label der Zeilen
		$values = array();
		if(count($ids) > 0)
		{
			$collection = Mage::getModel('bkg_tollpolicy/useoptions')->getCollection();
			$collection->addTollPathToSelect();
			$collection->getSelect()->where('main_table.id IN (?)',$ids);
			foreach ($collection as $item)
			{
				$values[] = array('value'=>$item->getId(),'label'=>$item->getTollPathLabel());
			}
		}
		
		
		//das Eingabeelement mit ausgetauschter Kopfzeile
		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$att = array(
				'label'     => Mage::helper('bkg_orgunit')->__('Type Of Use'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'toll',
				'values' =>$values,
				'values_cat' => $categorys,
				'onchange'  => 'reloadToll()',
				'onchange_toll'  => 'reloadUse()',
				'onchange_use'  => 'reloadUseOpt()',
				'value' => $value
				);

		$field = $fieldset->addField('toll', 'ol', $att);

		$pane = new Bkg_License_Block_Adminhtml_Widget_Ol_Addpane($att);
		$pane->addData($att);
		$field->setAddPane($pane);
	}


    public function getTollCollection()
    {
    	$collection = Mage::getModel('bkg_tollpolicy/toll')->getCollection();
    	$res = array();

    	foreach($collection as $item)
    	{
    		$res[$item->getId()] = $item->getName();
    	}

    	return $res;
    }
}
