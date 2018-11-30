<?php
 class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Coredata extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('coredataGrid');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
  }

  protected function _getStoreId()
  {
  	 return intval($this->getRequest()->getParam('store_id',0));
  }
  
  protected function _prepareCollection()
  {
      //$collection =Mage::getModel('core/config_data')->getCollection();
  	  $collection =Mage::getModel('configcompare/configCompare')->getCollection();
  	  
  	  $collection->getSelect()->where("type='core_config_data'");
  	  
  	  
      $collection =Mage::getModel('configcompare/coreConfigData')
      	->setStoreId($this->_getStoreId())
      	->getCollectionDiff($collection->getItems());

      $this->setCollection($collection);
        parent::_prepareCollection();
      
      return $collection->filter();
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
  	
      $this->addColumn('path', array(
          'header'    => Mage::helper('configcompare')->__('Path'),
          //'align'     =>'right',
          'width'     => '350px',
          'index'     => 'path',
      	
      ));
      
      $this->addColumn('scope', array(
      		'header'    => Mage::helper('configcompare')->__('Scope'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'scope',
      		 
      ));
      
      $this->addColumn('store', array(
      		'header'    => Mage::helper('configcompare')->__('Scope Id'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'scope_id',
      		 
      ));
      
     
      $this->addColumn('value', array(
          'header'    => Mage::helper('configcompare')->__('Value'),
             'width'     => '120px',
             'index'     => 'value',
      		 'column_css_class'    => 'max-width-configcompare',
      ));
      
      $this->addColumn('other_value', array(
      		'header'    => Mage::helper('configcompare')->__('Other value'),
      		 'width'     => '120px',
      		'index'     => 'other_value',
      		'column_css_class'    => 'max-width-configcompare',
      ));
      
      return parent::_prepareColumns();
  }

  
 	protected function x_afterLoadCollection()
    {
    	
    	$this->setCollection(array());
        return $this;
    }
 
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/coredatagrid');
  }

 
}