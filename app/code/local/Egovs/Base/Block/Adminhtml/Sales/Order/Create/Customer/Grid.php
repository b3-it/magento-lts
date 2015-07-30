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
 * Adminhtml sales order create block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Block_Adminhtml_Sales_Order_Create_Customer_Grid extends Mage_Adminhtml_Block_Sales_Order_Create_Customer_Grid
{

   

    protected function _prepareCollection()
    {
    	/* @var $collection Mage_Customer_Model_Resource_Customer_Collection */
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('company')
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_regione', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left')
            ->joinField('store_name', 'core/store', 'name', 'store_id=store_id', null, 'left');

        $this->setCollection($collection);

        Mage::dispatchEvent('customer_customer_collection_use_before', array('collection' => $collection));
        
        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    =>Mage::helper('sales')->__('ID'),
            'width'     =>'50px',
            'index'     =>'entity_id',
            'align'     => 'right',
        ));
        
      
        
        $this->addColumn('name', array(
            'header'    =>Mage::helper('sales')->__('Name'),
            'index'     =>'name'
        ));
        
          $this->addColumn('company', array(
            'header'    =>Mage::helper('sales')->__('Company'),
            'index'     =>'company',
            'width'     =>'200px',
        ));
        
        
        $this->addColumn('email', array(
            'header'    =>Mage::helper('sales')->__('Email'),
            'width'     =>'150px',
            'index'     =>'email'
        ));
        $this->addColumn('Telephone', array(
            'header'    =>Mage::helper('sales')->__('Telephone'),
            'width'     =>'100px',
            'index'     =>'billing_telephone'
        ));
        $this->addColumn('billing_postcode', array(
            'header'    =>Mage::helper('sales')->__('ZIP/Post Code'),
            'width'     =>'120px',
            'index'     =>'billing_postcode',
        ));
        $this->addColumn('billing_country_id', array(
            'header'    =>Mage::helper('sales')->__('Country'),
            'width'     =>'100px',
            'type'      =>'country',
            'index'     =>'billing_country_id',
        ));
        $this->addColumn('billing_regione', array(
            'header'    =>Mage::helper('sales')->__('State/Province'),
            'width'     =>'100px',
            'index'     =>'billing_regione',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_name', array(
                'header'    =>Mage::helper('sales')->__('Signed Up From'),
                'align'     => 'center',
                'index'     =>'store_name',
                'width'     =>'130px',
            ));
        }

        return parent::_prepareColumns();
    }

   
}
