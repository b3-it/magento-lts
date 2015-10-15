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
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Product attribute edit page
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Acl_Block_Adminhtml_Catalog_Product_Attribute_Edit extends Mage_Adminhtml_Block_Catalog_Product_Attribute_Edit
{

    public function __construct()
    {
    	$canSave = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/attributes/attributes/attributesave');
    	$canDelete = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/attributes/attributes/attributedelete');
    	
    	
    	$this->_objectId = 'attribute_id';
        $this->_controller = 'catalog_product_attribute';

        Mage_Adminhtml_Block_Widget_Form_Container::__construct();

        if($this->getRequest()->getParam('popup')) {
            $this->_removeButton('back');
            $this->_addButton(
                'close',
                array(
                    'label'     => Mage::helper('catalog')->__('Close Window'),
                    'class'     => 'cancel',
                    'onclick'   => 'window.close()',
                    'level'     => -1
                )
            );
        }

        if($canSave)
        {
	        $this->_updateButton('save', 'label', Mage::helper('catalog')->__('Save Attribute'));
	        $this->_addButton(
	            'save_and_edit_button',
	            array(
	                'label'     => Mage::helper('catalog')->__('Save And Continue Edit'),
	                'onclick'   => 'saveAndContinueEdit()',
	                'class'     => 'save'
	            ),
	            100
	        );
        }
        else
        {
        	$this->_removeButton('save');
        }

        if (! Mage::registry('entity_attribute')->getIsUserDefined()) {
            $this->_removeButton('delete');
        } else {
        	if($canDelete)
        	{
            	$this->_updateButton('delete', 'label', Mage::helper('catalog')->__('Delete Attribute'));
        	}
        	else
        	{
        		 $this->_removeButton('delete');
        	}
        }
    }

 
}
