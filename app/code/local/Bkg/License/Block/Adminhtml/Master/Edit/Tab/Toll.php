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
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Toll extends Mage_Adminhtml_Block_Widget_Form
{

	protected function x_construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/master/edit/tab/toll.phtml');
	}

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('unit_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Unit information')
		));

		$collection = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection();
		$values = array();
		$values[] = array('value'=>0,'label'=>$this->__('-- Please Select --'));
		foreach ($collection as $item)
		{
			$values[] = array('value'=>$item->getId(),'label'=>$item->getName());
		}
	
		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');

		$att = array(
				'label'     => Mage::helper('bkg_orgunit')->__('Short name'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'toll',
				'values' =>$values,
				'onchange'  => 'reloadToll()',
				'onchange_toll'  => 'reloadUse()',
				'onchange_use'  => 'reloadUseOpt()',
				'value' => array(array('value'=>1,'pos'=>20),array('value'=>2,'pos'=>10)));

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
