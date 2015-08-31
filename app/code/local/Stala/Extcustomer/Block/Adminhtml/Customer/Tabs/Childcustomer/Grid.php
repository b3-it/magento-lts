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
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Childcustomer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('childcustomerGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
    }

    protected function _prepareCollection()
    {
    	$id  = $this->getRequest()->getParam('customer_id');
		if(!$id) $id = 0;
    	
		
		
        $collection = Mage::getResourceModel('customer/customer_collection')
            ->addNameToSelect()
            ->addAttributeToSelect('email')
            ->addAttributeToSelect('created_at')
            ->addAttributeToSelect('group_id')
            ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', null, 'left')
            ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', null, 'left')
            ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', null, 'left')
            ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', null, 'left')
            ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', null, 'left')
            ->addAttributeToFilter('parent_customer_id',$id);
            
            
            $eav = Mage::getResourceModel('eav/entity_attribute');
            $billingcompany = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_company.value, ''), ' ', COALESCE(billing_customer_company2.value, ''), ' ', COALESCE(billing_customer_company3.value, ''))) as billing_company");
            //$billingcompanyBR = new Zend_Db_Expr("trim(concat(COALESCE(billing_customer_company.value, ''), '<br>', COALESCE(billing_customer_company2.value, ''), '<br>', COALESCE(billing_customer_company3.value, ''))) as billing_companyBR");
            $collection
            	->getSelect()
            	->joinleft(array('billing_customer_company'=>'customer_address_entity_varchar'),'billing_customer_company.entity_id=at_default_billing.value AND billing_customer_company.attribute_id='.$eav->getIdByCode('customer_address','company'),array())
      			->joinleft(array('billing_customer_company2'=>'customer_address_entity_varchar'),'billing_customer_company2.entity_id=at_default_billing.value AND billing_customer_company2.attribute_id='.$eav->getIdByCode('customer_address','company2'),array())	
      			->joinleft(array('billing_customer_company3'=>'customer_address_entity_varchar'),'billing_customer_company3.entity_id=at_default_billing.value AND billing_customer_company3.attribute_id='.$eav->getIdByCode('customer_address','company3'),array())	
            	->columns($billingcompany);
            	//->columns($billingcompanyBR);

//echo "<pre>"; var_dump($collection->getSelect()->__toString()); die();     
            
            
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
        ));
        /*
        $this->addColumn('firstname', array(
            'header'    => Mage::helper('customer')->__('First Name'),
            'index'     => 'firstname'
        ));
        $this->addColumn('lastname', array(
            'header'    => Mage::helper('customer')->__('Last Name'),
            'index'     => 'lastname'
        ));
        */
        
        
        $this->addColumn('billing_company', array(
            'header'    => Mage::helper('customer')->__('Company'),
            'width'     => '200',
            'index'     => 'billing_company'
        ));
        
        $this->addColumn('name', array(
            'header'    => Mage::helper('customer')->__('Name'),
            'index'     => 'name'
        ));
        

        
        $this->addColumn('email', array(
            'header'    => Mage::helper('customer')->__('Email'),
            'width'     => '150',
            'index'     => 'email'
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();

        $this->addColumn('group', array(
            'header'    =>  Mage::helper('customer')->__('Group'),
            'width'     =>  '100',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
        ));

        $this->addColumn('Telephone', array(
            'header'    => Mage::helper('customer')->__('Telephone'),
            'width'     => '100',
            'index'     => 'billing_telephone'
        ));

        $this->addColumn('billing_postcode', array(
            'header'    => Mage::helper('customer')->__('ZIP'),
            'width'     => '90',
            'index'     => 'billing_postcode',
        ));
        
        $this->addColumn('billing_city', array(
            'header'    => Mage::helper('customer')->__('City'),
            'width'     => '90',
            'index'     => 'billing_city',
        ));

 	   $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customer')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customer')->__('Edit'),
                        'url'       => array('base'=> 'adminhtml/customer/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
  
        return parent::_prepareColumns();
    }

  

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

  
}
