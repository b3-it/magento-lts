<?php

class Sid_Framecontract_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	protected $_visibleProductIds;
	private $_CustomerGroups = null;
	
	protected $_customerGroup;

	public function __construct()
	{
		parent::__construct();
		$this->setId('customer_visible_products');
		//$this->setDefaultSort('entity_id');
		//$this->setRowClickCallback('visibleProducts.onRowClick.bind(visibleProducts)');
        //$this->setRowInitCallback('visibleProducts.onRowInit.bind(visibleProducts)');
		$this->setUseAjax(true);
	}

	protected function _addColumnFilterToCollection($column)
	{
		// Set custom filter for is visible flag
		if ($column->getId() == 'is_visible') {
			$productIds = $this->_getVisibleProductIds();
			if (empty($productIds)) {
				$productIds = 0;
			}
			if ($column->getFilter()->getValue()) {
				$this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
			}
			elseif(!empty($productIds)) {
				$this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
			}
		}
		else {
			parent::_addColumnFilterToCollection($column);
		}
		return $this;
	}

	
	protected function _getVisibleProductIds()
	{
		if (! isset($this->_visibleProductIds))
		{
			$collection = Mage::getModel('catalog/product')->getCollection()
				//->addStoreFilter($this->getRequest()->getParam('store'))
			;
			$group = $this->getRequest()->getParam('group');
			if($group)
			{
				Mage::helper('groupscatalog')->addGroupsFilterToProductCollection($collection, $group);
			}
			$this->_visibleProductIds = array();
			//die($collection->getSelect()->__toString());
			foreach ($collection as $product) $this->_visibleProductIds[] = $product->getId();
		}
		return $this->_visibleProductIds;

	}

	protected function _prepareCollection()
	{
				
		$collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect(array('name', 'sku','framecontract_los','groupscatalog_hide_group'));
		
		$eav = Mage::getResourceModel('eav/entity_attribute');
		$eav = $eav->getIdByCode('catalog_product', 'framecontract_los');
		
		
		$collection->getSelect()
			->join(array('los' => $collection->getTable('catalog/product').'_int'),'los.entity_id = e.entity_id AND los.attribute_id='.$eav,array('framecontract_los'=>'value'))
			->join(array('contract'=>$collection->getTable('framecontract/contract')),'contract.framecontract_contract_id = los.value',array('framecontract_contract_id'));

		//die($collection->getSelect()->__toString());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		
		$this->addColumn('is_visible', array(
				'header_css_class' => 'a-center',
				'type'       => 'checkbox',
				'name'       => 'is_visible',
				//'values'     => $this->_getSelectedProducts(),
				'align'      => 'center',
				'index'      => 'groupscatalog_hide_group',
				//'inline_css' => 'checkbox netzarbeiter-visible-products',
				'renderer'   => 'framecontract/adminhtml_widget_grid_column_renderer_groups',
				'row_clicked_callback' => 'visibleProducts.rowClick',
				//'checkbox_check_callback' => 'visibleProducts.boxCheck',
			));
			
		
		$this->addColumn('entity_id', array(
			'header'    => Mage::helper('catalog')->__('ID'),
			'sortable'  => true,
			'width'     => '60',
			'index'     => 'entity_id'
			));
		$this->addColumn('name', array(
			'header'    => Mage::helper('catalog')->__('Name'),
			'index'     => 'name'
			));
			
		$this->addColumn('sku', array(
			'header'    => Mage::helper('catalog')->__('SKU'),
			'width'     => '80',
			'index'     => 'sku'
			));
		/*	
		$this->addColumn('groupscatalog_hide_group', array(
			'header'    => Mage::helper('catalog')->__('groups'),
			'width'     => '80',
			'index'     => 'groupscatalog_hide_group'
			));
			
*/
			

		
		$lose = Mage::getModel('framecontract/source_attribute_contractLos');
		$ctr = ($lose->getOptionArray(false));
		
		$this->addColumn('los', array(
				'header'    => Mage::helper('framecontract')->__('Los'),
				'align'     => 'left',
				//'width'     => '150px',
				'index'     => 'framecontract_los',
				'type'      => 'options',
				'options'   => $ctr
		));

		return parent::_prepareColumns();
	}

	
	private function getCustomerGroups()
	{
		if( $this->_CustomerGroups == null)
		{
			$collection = Mage::getModel('customer/group')->getCollection();
			$this->_CustomerGroups = array();
			foreach($collection->getItems() as $item)
			{
				$this->_CustomerGroups[$item->getId()] = $item->getCustomerGroupCode();
			}
			
		}
		return $this->_CustomerGroups;
	}
	

	
	public function getGridUrl()
	{
		if( $this->getRequest()->getParam('group') == null)
		{
			return $this->getUrl('adminhtml/framecontract_product/grid', array('_current' => true));
		}
		else 
		{
			return $this->getUrl('adminhtml/framecontract_product/grid', array('_current' => true,'group' => $this->getRequest()->getParam('group')));
		}
	}

	

}