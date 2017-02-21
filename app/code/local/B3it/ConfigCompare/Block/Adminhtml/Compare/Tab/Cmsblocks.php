<?php
 class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Cmsblocks extends Mage_Adminhtml_Block_Widget_Grid
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
      $collection  = Mage::getModel('configcompare/configcompare')->getCollection();
  	  $collection->getSelect()->where("type='cms_block'");
  	  
  	  
      $collection =Mage::getModel('configcompare/cmsBlocks')->getCollectionDiff($collection->getItems());

      $this->setCollection($collection);
      return parent::_prepareCollection();
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
  	return $this->getUrl('*/*/grid');
  }

 
}