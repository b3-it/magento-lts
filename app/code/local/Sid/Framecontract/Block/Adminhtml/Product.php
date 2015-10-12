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
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog manage products block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Framecontract_Block_Adminhtml_Product extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Set template
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('sid/framecontract/product.phtml');
        $group = $this->getRequest()->getParam('group');
        if($group)
        {
        $this->_addButton('save', array(
	            'label'   => Mage::helper('catalog')->__('Save'),
	            'onclick' => "save()",
	            'class'   => 'save'
	        ));
        }
    }

    /**
     * Prepare button and grid
     *
     * @return Mage_Adminhtml_Block_Catalog_Product
     */
    protected function _prepareLayout()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('framecontract/adminhtml_product_grid', 'product.grid'));
        $this->setChild('group', $this->getLayout()->createBlock('framecontract/adminhtml_product_customergroups', 'product.group'));
        return parent::_prepareLayout();
    }

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    public function getCustomerGroupsHtml()
    {
    	return $this->getChildHtml('group');
    }
    
    public function getSaveUrl()
    {
    	$group = $this->getRequest()->getParam('group');
        if($group)
        {
    		return $this->getUrl('*/*/save',array('group'=>$group));
        }
        return '#';
    }
    
	public function getFormKey()
    {
        return Mage::getSingleton('core/session')->getFormKey();
    }
    
    public function getGroupId()
    {
    	return $this->getRequest()->getParam('group');
    }
    
}
