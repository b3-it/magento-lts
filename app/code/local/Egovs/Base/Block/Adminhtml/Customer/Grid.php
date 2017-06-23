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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 * @author     Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Base_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid
{
    public function setCollection($collection)
    {
    	$collection->addAttributeToSelect('company')
    		->joinAttribute('base_company', 'customer_address/company', 'base_address', null, 'left')
	    	->joinAttribute('base_postcode', 'customer_address/postcode', 'base_address', null, 'left')
	    	->joinAttribute('base_city', 'customer_address/city', 'base_address', null, 'left')
	    	->joinAttribute('base_telephone', 'customer_address/telephone', 'base_address', null, 'left')
	    	->joinAttribute('base_region', 'customer_address/region', 'base_address', null, 'left')
	    	->joinAttribute('base_country_id', 'customer_address/country_id', 'base_address', null, 'left')
    	;
    	
    	Mage::dispatchEvent('customer_customer_collection_use_before', array('collection' => $collection));
    	
    	return parent::setCollection($collection);
    }
    
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
            'type'  => 'number',
        ));
        /*$this->addColumn('firstname', array(
            'header'    => Mage::helper('customer')->__('First Name'),
            'index'     => 'firstname'
        ));
        $this->addColumn('lastname', array(
            'header'    => Mage::helper('customer')->__('Last Name'),
            'index'     => 'lastname'
        ));*/
        $this->addColumn('name', array(
            'header'    => Mage::helper('customer')->__('Name'),
            'index'     => 'name'
        ));
        
        $this->addColumn('base_company', array(
            'header'    => Mage::helper('customer')->__('Company'),
        	'width'     => '100',
            'index'     => 'base_company'
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
            'index'     => 'base_telephone'
        ));

        $this->addColumn('base_postcode', array(
            'header'    => Mage::helper('customer')->__('ZIP'),
            'width'     => '90',
            'index'     => 'base_postcode',
        ));
        
       $this->addColumn('base_city', array(
            'header'    => Mage::helper('customer')->__('City'),
            'width'     => '100',
            'index'     => 'base_city',
        ));
        
       $this->addColumn('base_region', array(
            'header'    => Mage::helper('customer')->__('State/Province'),
            'width'     => '100',
            'index'     => 'base_region',
        ));

        $this->addColumn('base_country_id', array(
            'header'    => Mage::helper('customer')->__('Country'),
            'width'     => '100',
            'type'      => 'country',
            'index'     => 'base_country_id',
        ));

        $this->addColumn('customer_since', array(
            'header'    => Mage::helper('customer')->__('Customer Since'),
            'type'      => 'datetime',
        	'width'     => '100',
            'align'     => 'center',
            'index'     => 'created_at',
            'gmtoffset' => true
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('website_id', array(
                'header'    => Mage::helper('customer')->__('Website'),
                'align'     => 'center',
                'width'     => '80px',
                'type'      => 'options',
                'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
                'index'     => 'website_id',
            ));
        }

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customer')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customer')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

        foreach ($this->getColumns() as $column) {
        	/* @var $column Mage_Adminhtml_Block_Widget_Grid_Column */
        	if ($column->getType() && $column->getType() != "text") {
        		continue;
        	}
			if (!$column->getFilterConditionCallback()) {
        		$column->setFilterConditionCallback(array($this, '_regexFilter'));
			}

        }
        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('XML'));
        return $this;//parent::_prepareColumns();
    }
    
    protected function _regexFilter($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return $this;
    	}
    	
    	$_condition = $column->getFilter()->getValue();
    	$field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();
    	if (isset($_condition) && (strpos($_condition, "/*") !== 0 || substr($_condition, -2) != "*/")) {
    		$_condition = $column->getFilter()->getCondition();
    	} elseif (isset($_condition)) {
    		$_condition = substr($_condition, 2, strlen($_condition) - 4);
	    	$helper = Mage::getResourceHelper('core');
	    	$rlikeExpression = $helper->addLikeEscape($_condition, array('allow_symbol_mask', 'allow_string_mask'));
	    	$_condition = array('regexp' => $rlikeExpression);
    	}
    	if ($field && isset($_condition)) {
    		$collection->addFieldToFilter($field, $_condition);
    	}
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('customer');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customer')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('newsletter_subscribe', array(
             'label'    => Mage::helper('customer')->__('Subscribe to newsletter'),
             'url'      => $this->getUrl('*/*/massSubscribe')
        ));

        $this->getMassactionBlock()->addItem('newsletter_unsubscribe', array(
             'label'    => Mage::helper('customer')->__('Unsubscribe from newsletter'),
             'url'      => $this->getUrl('*/*/massUnsubscribe')
        ));

        $groups = $this->helper('customer')->getGroups()->toOptionArray();

        array_unshift($groups, array('label'=> '', 'value'=> ''));
        $this->getMassactionBlock()->addItem('assign_group', array(
             'label'        => Mage::helper('customer')->__('Assign a customer group'),
             'url'          => $this->getUrl('*/*/massAssignGroup'),
             'additional'   => array(
                'visibility'    => array(
                     'name'     => 'group',
                     'type'     => 'select',
                     'class'    => 'required-entry',
                     'label'    => Mage::helper('customer')->__('Group'),
                     'values'   => $groups
                 )
            )
        ));

        Mage::dispatchEvent('adminhtml_customer_grid_massaction_prepare_after', array('grid' => $this, 'massaction_block' =>  $this->getMassactionBlock() ));
        
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}
