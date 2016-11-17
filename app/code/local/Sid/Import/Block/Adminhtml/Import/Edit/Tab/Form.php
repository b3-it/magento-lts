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
class Sid_Import_Block_Adminhtml_Import_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Add fieldset
     *
     * @return Mage_ImportExport_Block_Adminhtml_Import_Edit_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('importexport');

        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => $helper->__('Import Settings')));
         $lose = Mage::getModel('framecontract/source_attribute_contractLos');
        
         $fieldset->addField('default_los', 'select', array(
         		'name'     => "default[los]",
         		'title'    => $helper->__('Los'),
         		'label'    => $helper->__('Los'),
         		'required' => true,
         		'values'   => $lose->getOptionArray(),
         		'value' 	=> $this->getImportDefaults('los')
         ));

         $fieldset->addField('sku_prefix', 'text', array(
         		'name'     => 'default[sku_prefix]',
         		'title'    => $helper->__('Sku Prefix'),
         		'label'    => $helper->__('Sku Prefix'),
         		'value' 	=> $this->getImportDefaults('sku_prefix')
         		//'required' => true,
         
         ));
        //if (!Mage::app()->isSingleStoreMode())
        //{

        	$fieldset->addField('website', 'select', array(
            'name'     => "default[website]",
            'title'    => $helper->__('Website'),
            'label'    => $helper->__('Website'),
            'required' => true,
            'values'   => Mage::getSingleton('adminhtml/system_config_source_website')->toOptionArray(),
        			'value' 	=> $this->getImportDefaults('website')
        	 ));

    		if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){
	        	$fieldset->addField('store', 'select', array(
	            'name'     => 'default[store]',
	            'title'    => $helper->__('Store'),
	            'label'    => $helper->__('Store'),
	            'required' => true,
	            'values'   => Mage::getModel('isolation/entity_attribute_source_storegroups')->getOptionArray(),
	        	'value' 	=> $this->getImportDefaults('store')
	        	));
        	}

         $fieldset->addField('category', 'select', array(
            'name'     => 'default[category]',
            'title'    => $helper->__('Category'),
            'label'    => $helper->__('Category'),
            'required' => true,
            'values'   => $this->getCategories(),
         	'value' 	=> $this->getImportDefaults('category')
        	));

                 
        $fieldset->addField('tax_class1', 'select', array(
            'name'     => 'default[tax_class1]',
            'title'    => $helper->__('No Tax Class'),
            'label'    => $helper->__('No Tax Class'),
            'required' => true,
            'values'   => Mage::getSingleton('tax/class_source_product')->toOptionArray(),
        	'value' 	=> $this->getImportDefaults('tax_class1')
        	));

        $fieldset->addField('tax_rate2', 'text', array(
        		'name'     => 'default[tax_rate2]',
        		'title'    => $helper->__('Tax Rate for Reduced Tax'),
        		'label'    => $helper->__('Tax Rate for Reduced Tax'),
        		'value' 	=> $this->getImportDefaults('tax_rate2')
        		//'required' => true,
        		 
        ));
        
        
        $fieldset->addField('tax_class2', 'select', array(
        		'name'     => 'default[tax_class2]',
        		'title'    => $helper->__('Reduced Tax Class'),
        		'label'    => $helper->__('Reduced Tax Class'),
        		'required' => true,
        		'values'   => Mage::getSingleton('tax/class_source_product')->toOptionArray(),
        		'value' 	=> $this->getImportDefaults('tax_class2')
        ));
        
        $fieldset->addField('tax_rate3', 'text', array(
        		'name'     => 'default[tax_rate3]',
        		'title'    => $helper->__('Tax Rate for Normal Tax'),
        		'label'    => $helper->__('Tax Rate for Normal Tax'),
        		'value' 	=> $this->getImportDefaults('tax_rate3')
        		//'required' => true,
              
        ));
        
        $fieldset->addField('tax_class3', 'select', array(
        		'name'     => 'default[tax_class3]',
        		'title'    => $helper->__('Normal Tax Class'),
        		'label'    => $helper->__('Normal Tax Class'),
        		'required' => true,
        		'values'   => Mage::getSingleton('tax/class_source_product')->toOptionArray(),
        		'value' 	=> $this->getImportDefaults('tax_class3')
        ));
        
      
        
        $fieldset->addField('qty', 'text', array(
        		'name'     => 'default[qty]',
        		'title'    => $helper->__('Quantity'),
        		'label'    => $helper->__('Quantity'),
        		'note'	   => $helper->__("0 = switch off Stock Inventory"),
        		'value'   => empty($this->getImportDefaults('los'))? $this->getImportDefaults('los') : '0',
        		//'required' => true,
        
        ));
        
//         $losId =  intval($this->getRequest()->getParam('los'));
//         if($losId == 0)
//         {
// 	        $fieldset->addField('fetch', 'button', array(
// 	        		'name'     => 'qty',
// 	        		'title'    => $helper->__('Fetch Data'),
// 	        		'label'    => $helper->__('Fetch Data'),
// 	        		'value'	=>$helper->__('Start'),
// 	        		'class' =>'button',
// 	        		'onclick' => "fechData('".$this->_getFetchUrl()."');"
// 	        		//'required' => true,
	        
// 	        ));
//         }


//        $form->setUseContainer(true);
//        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    
    private function getImportDefaults($key = NULL)
    {
    	$session = Mage::getSingleton("admin/session");
    	$defaults = $session->getImportDefaults();
    	if($key == null){
    		return $defaults;
    	}
    	if(isset($defaults[$key])){
    	   	return $defaults[$key];
    	}
    	
    	return "";
    }
    
    
    private function _getFetchUrl()
    {
    	return $this->getUrl('*/*/fetch');
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
