<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Import edit form block
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Framecontract_Block_Adminhtml_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Add fieldset
     *
     * @return Mage_ImportExport_Block_Adminhtml_Import_Edit_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('importexport');

        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/validate'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset1', array('legend' => $helper->__('Image Import Settings')));

        $fieldset->addField('image_upload', 'text', array(
         		'name'     => 'image_upload',
        		'label'    => $helper->__('Select Image Archive File to Import'),
        		'title'    => $helper->__('Select Image Archive File to Import'),
        		'required' => false
        ));

        $form->getElement('image_upload')->setRenderer(
        		$this->getLayout()->createBlock('framecontract/adminhtml_import_uploader')
        );


        $fieldset = $form->addFieldset('base_fieldset', array('legend' => $helper->__('Import Settings')));

        $fieldset->addField('behavior', 'select', array(
            'name'     => 'behavior',
            'title'    => $helper->__('Import Behavior'),
            'label'    => $helper->__('Import Behavior'),
            'required' => true,
            'values'   => Mage::getModel('importexport/source_import_behavior')->toOptionArray()
        ));
/*
         $contracts = Mage::getModel('framecontract/source_attribute_contracts');
         $fieldset->addField('framecontract', 'select', array(
            'name'     => 'framecontract',
            'title'    => $helper->__('Framework Contract'),
            'label'    => $helper->__('Framework Contract'),
            'required' => true,
            'values'   => $contracts->getOptionArray()
        ));
         
    */     
         $lose = Mage::getModel('framecontract/source_attribute_contractLos');
        
         $fieldset->addField('los', 'select', array(
         		'name'     => 'los',
         		'title'    => $helper->__('Los'),
         		'label'    => $helper->__('Los'),
         		'required' => true,
         		'values'   => $lose->getOptionArray()
         ));

        //if (!Mage::app()->isSingleStoreMode())
        //{

        	$fieldset->addField('website', 'select', array(
            'name'     => 'website',
            'title'    => $helper->__('Website'),
            'label'    => $helper->__('Website'),
            'required' => true,
            'values'   => Mage::getSingleton('adminhtml/system_config_source_website')->toOptionArray()
        	 ));

        	if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){
	        	$fieldset->addField('store', 'select', array(
	            'name'     => 'store',
	            'title'    => $helper->__('Store'),
	            'label'    => $helper->__('Store'),
	            'required' => true,
	            'values'   => Mage::getModel('isolation/entity_attribute_source_storegroups')->getOptionArray()
	        	));
        	}

         $fieldset->addField('category', 'select', array(
            'name'     => 'category',
            'title'    => $helper->__('Category'),
            'label'    => $helper->__('Category'),
            'required' => true,
            'values'   => $this->getCategories()
        	));

        $fieldset->addField('tax_class', 'select', array(
            'name'     => 'tax_class',
            'title'    => $helper->__('Tax'),
            'label'    => $helper->__('Tax'),
            'required' => true,
            'values'   => Mage::getSingleton('tax/class_source_product')->toOptionArray()
        	));

        $fieldset->addField('sku_prefix', 'text', array(
            'name'     => 'sku_prefix',
            'title'    => $helper->__('Sku Prefix'),
            'label'    => $helper->__('Sku Prefix'),
            //'required' => true,

        	));
        
        $fieldset->addField('qty', 'text', array(
        		'name'     => 'qty',
        		'title'    => $helper->__('Quantity'),
        		'label'    => $helper->__('Quantity'),
        		'note'	   => $helper->__("0 = switch off Stock Inventory"),
        		'value'	=>'0',
        		//'required' => true,
        
        ));
      	/*
        $fieldset->addField('buchungstext', 'text', array(
            'name'     => 'buchungstext',
            'title'    => $helper->__('Buchungstext'),
            'label'    => $helper->__('Buchungstext'),
            'required' => true,

        	));
        $fieldset->addField('buchungstext_mwst', 'text', array(
            'name'     => 'buchungstext_mwst',
            'title'    => $helper->__('Buchungstext MwSt'),
            'label'    => $helper->__('Buchungstext MwSt'),
            'required' => true,

        	));
       $fieldset->addField('haushaltsstelle', 'text', array(
            'name'     => 'haushaltsstelle',
            'title'    => $helper->__('Haushaltsstelle'),
            'label'    => $helper->__('Haushaltsstelle'),
            'required' => true,

        	));
       $fieldset->addField('href', 'text', array(
            'name'     => 'href',
            'title'    => $helper->__('Href'),
            'label'    => $helper->__('Href'),
            'required' => true,

        	));

       $fieldset->addField('href_mwst', 'text', array(
            'name'     => 'href_mwst',
            'title'    => $helper->__('Href MwSt'),
            'label'    => $helper->__('Href MwSt'),
            'required' => true,

        	));
      */
        $fieldset->addField(Mage_ImportExport_Model_Import::FIELD_NAME_SOURCE_FILE, 'file', array(
        		'name'     => Mage_ImportExport_Model_Import::FIELD_NAME_SOURCE_FILE,
        		'label'    => $helper->__('Select File to Import'),
        		'title'    => $helper->__('Select File to Import'),
        		'required' => true
        ));


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

	private function getCategories($addEmpty = true)
    {
        //$tree = Mage::getResourceModel('catalog/category_tree');

        $collection = Mage::getResourceModel('catalog/category_collection');

        $collection->addAttributeToSelect('name')
        	//->addLevelFilter(2)
        	//->addRootLevelFilter()
            ->load();

        $options = array();

        if ($addEmpty) {
            $options[] = array(
                'label' => Mage::helper('adminhtml')->__('-- Please Select a Category --'),
                'value' => ''
            );
        }
        foreach ($collection as $category) {
        	if($category->getLevel() > 1)
        	{
	            $options[] = array(
	               'label' => $category->getName(),
	               'value' => $category->getId()
	            );
        	}
        }

        return $options;
    }

}
