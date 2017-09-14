<?php
 class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Cmspages extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('cmspagesGrid');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
  }

  protected function _prepareCollection()
  {
      $collection  = Mage::getModel('configcompare/configCompare')->getCollection();
  	  $collection->getSelect()->where("type='cms_page'");
  	  
  	  
      $collection = Mage::getModel('configcompare/cmsPages')->setStoreId($this->_getStoreId())->getCollectionDiff($collection->getItems());

      $this->setCollection($collection);
      parent::_prepareCollection();
      
      return $collection->filter();
  }

  protected function _getStoreId()
  {
  	return intval($this->getRequest()->getParam('store_id',0));
  }
  
  protected function _setFilterValues($data)
  {
  	foreach ($this->getColumns() as $columnId => $column) {
  		if (isset($data[$columnId])
  				&& (!empty($data[$columnId]) || strlen($data[$columnId]) > 0)) {
  					$this->getCollection()->addFieldToFilter($columnId , $data[$columnId]);
  					$column->getFilter()->setValue($data[$columnId]);
  				}
  	}
  	return $this;
  }
  
  protected function _prepareColumns()
  {
  	
      $this->addColumn('identifier', array(
          'header'    => Mage::helper('configcompare')->__('Identifier'),
          //'align'     =>'right',
          'width'     => '120px',
          'index'     => 'identifier',
      	
      ));
      
      $this->addColumn('Title', array(
      		'header'    => Mage::helper('configcompare')->__('Title'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'title',
      		'renderer'  => 'configcompare/adminhtml_widget_grid_column_renderer_diff'
      		 
      ));
      
      $this->addColumn('stores', array(
      		'header'    => Mage::helper('configcompare')->__('Stores'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'stores',
      		 
      ));
      
      $this->addColumn('attribute', array(
      		'header'    => Mage::helper('configcompare')->__('Attribute'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'attribute',
      		'renderer'  => 'configcompare/adminhtml_widget_grid_column_renderer_diff'
      		 
      ));
      
     
      $this->addColumn('diff', array(
      		'header'    => Mage::helper('configcompare')->__('Content'),
      	//	 'width'     => '120px',
      		'index'     => 'diff',
      		'renderer'  => 'configcompare/adminhtml_widget_grid_column_renderer_diff'
      ));
      
      return parent::_prepareColumns();
  }

  

  
 
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/cmspagesgrid');
  }

 
}