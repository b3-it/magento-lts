<?php
 class B3it_ConfigCompare_Block_Adminhtml_Import_Data_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('configcompareGrid');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
  }

  protected function _prepareCollection()
  {
      //$collection =Mage::getModel('core/config_data')->getCollection();
      $collection =Mage::getModel('configcompare/coreConfigData')->getCollectionDiff( Mage::registry('import_data'));

      $this->setCollection($collection);
      return parent::_prepareCollection();
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
      ));
      
      $this->addColumn('other_value', array(
      		'header'    => Mage::helper('configcompare')->__('Other value'),
      		 'width'     => '120px',
      		'index'     => 'other_value',
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
  	return $this->getUrl('*/*/grid');
  }

 
}