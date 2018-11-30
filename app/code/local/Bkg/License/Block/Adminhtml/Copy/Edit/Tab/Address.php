<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Address
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Address extends Mage_Adminhtml_Block_Widget_Form
{


	protected function _construct()
	{
		parent::_construct();
		//$this->setTemplate('bkg/license/copy/edit/tab/address.phtml');
	}

	public function getAddressTypes()
	{
		$result= array();
		$sect = Mage::getConfig()->getNode('bkg_license/address_type')->asArray();
		foreach($sect as $k=>$v)
		{
			$result[] = array('value'=>$k,'label'=>$this->__($v));
		}
		return $result;
	}
	
	
	public function getAddresses()
	{
		$result= array();
		$values = Mage::registry('entity_data')->getAddresses();
		foreach($values as $item)
		{
			$name = $item->getName();
			$result[] = array('value'=>$item->getId(),'label'=>$name);
		}
		return $result;
	}
	
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('address_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Address')
		));

       
        $parent = Mage::registry('entity_data');
        $value = null;
        foreach(Mage::registry('entity_data')->getAddressRelations() as $item)
        {
        	if($parent->getIsOrgunit()){
            	$value[] = json_encode(array('left_value'=>$item->getCode(),'right_value'=>$item->getOrgunitAddressId(),'db_id' => $item->getId()));
        	}else{
        		$value[] = json_encode(array('left_value'=>$item->getCode(),'right_value'=>$item->getCustomerAddressId(),'db_id' => $item->getId()));
        	}
        }

        
        
        $values = array();
		$fieldset->addType('assign','Egovs_Base_Block_Adminhtml_Widget_Form_Assign');
		$fieldset->addField('address', 'assign', array(
				'left_label'     => Mage::helper('bkg_orgunit')->__('Usage'),
				'right_label'     => Mage::helper('bkg_orgunit')->__('Address'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'address',
				'left_values' => $this->getAddressTypes(),
				'right_values' => $this->getAddresses(),
				'values' =>$values,
				'value' => $value
		));
	}


}
