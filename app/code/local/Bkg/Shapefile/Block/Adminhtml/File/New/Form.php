<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Bkg Shapefile
 * @package    	Bkg_Shapefile
 * @name       	Bkg_Shapefile_Block_Adminhtml_File_New_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Shapefile_Block_Adminhtml_File_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		));


		$form->setUseContainer(true);
		$this->setForm($form);

		$fieldset = $form->addFieldset('file_form', array('legend'=>Mage::helper('bkg_shapefile')->__('Information')));
		
		// to use the accept attributes
		$fieldset->addType('file', "Bkg_Shapefile_Model_Form_File");
		
		$fieldset->addField('name', 'text', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('Name'),
		    'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'name'
		));
		
		$fieldset->addField('shp', 'file', array(
			'label'     => Mage::helper('bkg_shapefile')->__('shp'),
			//'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'shp',
		    'accept'    => ".shp"
		));
		$fieldset->addField('dbf', 'file', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('dbf'),
		    //'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'dbf',
		    'accept'    => ".dbf"
		));
		$fieldset->addField('shx', 'file', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('shx'),
		    //'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'shx',
		    'accept'    => ".shx"
		));

		/**
		 * @var Mage_Customer_Model_Resource_Customer_Collection $customer
		 */
		$customer = Mage::getModel("customer/customer")->getCollection();
		$options = array();

		foreach ($customer->getItems() as $id => $c) {
		    /**
		     * @var Mage_Customer_Model_Customer $c
		     */
		    
		    $options []= array(
		        'value' => $id,
		        'label' => $id . ": " . $c->getEmail()
		    );
		}

		$fieldset->addField('customer_id', 'select', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('Customer'),
		    'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'customer_id',
		    'values' => $options
		    
		));

		/**
		* @var Bkg_VirtualGeo_Model_Resource_Components_Georef_Collection $georef
		*/
		$georef = Mage::getModel('virtualgeo/components_georef')->getCollection();
		
		$fieldset->addField('georef_id', 'select', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('Georef'),
		    'class'     => 'required-entry',
		    'required'  => true,
		    'name'      => 'georef_id',
		    'values' => $georef->toOptionArray()
		    
		));
		
		$fieldset->addField('zIndex', 'text', array(
		    'label'     => Mage::helper('bkg_shapefile')->__('z-Index'),
		    'class'     => 'validate-number',
		    'required'  => false,
		    'name'      => 'zIndex'
		));
		return parent::_prepareForm();
	}
}