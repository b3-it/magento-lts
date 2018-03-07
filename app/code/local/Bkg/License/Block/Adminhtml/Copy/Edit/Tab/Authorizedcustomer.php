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
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Authorizedcustomer extends Mage_Adminhtml_Block_Widget_Form
{


	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		// Tabelle mehrspaltig
		$fieldset = $form->addFieldset('authorized_form', array(
				'legend' => Mage::helper('bkg_orgunit')->__('Authorized Customer')
		));

		$license = Mage::registry('entity_data');
		
		$field = $fieldset->addField('order_allow_all_customer', 'checkbox', array(
				'label'     => Mage::helper('bkg_license')->__('Allow order for all customers'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'order_allow_all_customer',
				'value' => $license->getData('order_allow_all_customer') == 1
		));
		
		if($license->getData('order_allow_all_customer')){
			$field->setIsChecked(1);
		}
		
        $collection = Mage::getModel('bkg_license/copy_authorizedcustomer')->getCollection();

        $collection->addCopyIdFilter($license->getId());

        $value = array();
        foreach($collection as $item)
        {
            $value[] = array('value'=>$item->getCustomerId(),'pos'=>'0');
        }

        
        $values = $this->getOrgunitCustomer();
		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$fieldset->addField('authorizedcustomer', 'ol', array(
				'label'     => Mage::helper('bkg_orgunit')->__('Authorized Customer'),
				//'class'     => 'required-entry',
				//'required'  => true,
				'name'      => 'authorizedcustomer',
				'show_up_down' => false,
				'values' =>$values,
				'value' => $value
		));
	}



	public function getOrgunitCustomer()
	{
		$collection = Mage::getModel('customer/customer')->getCollection();
		$res = array();


		foreach($collection as $item)
		{
			$res[$item->getIdentifier()] = array('label'=>$item->getEmail(), 'value'=>$item->getId());
		}


		return $res;
	}


}
