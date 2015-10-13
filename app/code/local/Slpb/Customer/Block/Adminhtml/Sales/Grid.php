<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Block_Adminhtml_Sales_Grid
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Block_Adminhtml_Sales_Grid extends Mage_Adminhtml_Block_Customer_Grid
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
		
		$exp = new Zend_Db_Expr('(SELECT customer_id, max(created_at) as order_date FROM '. $collection->getTable('sales/order') .' GROUP BY customer_id)');
		
		$collection->getSelect()
		->join(array('order' => $exp),'e.entity_id = order.customer_id' );
//die($collection->getSelect()->__toString());		
		
		return parent::setCollection($collection);
	}
	
	protected function  _prepareColumns()
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
		
		$this->addColumn('order_date', array(
				'header'    => Mage::helper('slpbcustomer')->__('Last Order'),
				'type'      => 'datetime',
				'width'     => '100',
				'align'     => 'center',
				'index'     => 'order_date',
				//'filterindex'     => 'order_date',
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
	

	

		return $this;//parent::_prepareColumns();
	}
	
 	protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'order_date') {
                $this->__addDateFilterExpression('order_date',$column->getFilter()->getValue());
            }
            else 
            {
            	return parent::_addColumnFilterToCollection($column);
            }
        }
        
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
	
	
	private function __addDateFilterExpression($field, $filter)
	{
		$from = null;
		$to = null;
		if (isset($filter['from'])) $from = $filter['from']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		if (isset($filter['to'])) $to = $filter['to']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		if (($to != null)&&($from != null)) {
			$this->getCollection()->getSelect()->where(" $field BETWEEN '$from' AND '$to' ");
		} elseif ($to != null) {
			$this->getCollection()->getSelect()->where(" $field < '$to' ");
		} elseif ($from != null) {
			$this->getCollection()->getSelect()->where(" $field > '$from' ");
		}
		
		//die($this->getCollection()->getSelect()->__toString());
	}
	
	
	protected function _prepareMassaction() {
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('customer');
		$this->getMassactionBlock()->setErrorText(Mage::helper('slpbcustomer')->jsQuoteEscape(Mage::helper('catalog')->__('Please select at least one customer.')));
		
		$this->getMassactionBlock()->addItem('delete', array(
				'label'    => Mage::helper('customer')->__('Delete'),
				'url'      => $this->getUrl('*/*/massDelete'),
				'confirm'  => Mage::helper('customer')->__('Are you sure?')
		));
	
		return $this;
	}
	
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=> true));
	}
	
	public function xgetRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
	}
}