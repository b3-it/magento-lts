<?php
 class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Pdfsections extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('pdfsectionsGrid');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
  }

  protected function _prepareCollection()
  {
      $collection  = Mage::getModel('configcompare/configCompare')->getCollection();
  	  $collection->getSelect()->where("type='pdf_section'");
  	  
  	  
      $collection =Mage::getModel('configcompare/pdfSections')->getCollectionDiff($collection->getItems());

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
  	
  
      
      $this->addColumn('Title', array(
      		'header'    => Mage::helper('configcompare')->__('Title'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'title',
      		'renderer'  => 'configcompare/adminhtml_widget_grid_column_renderer_diff'
      ));
      
      $this->addColumn('type', array(
      		'header'    => Mage::helper('pdftemplate')->__('Type'),
      		'align'     => 'left',
      		'width'     => '120px',
      		'index'     => 'type',
      		'type'      => 'options',
      		'options'   => Egovs_Pdftemplate_Model_Type::getOptionArray(),
      ));
    
      
      $this->addColumn('sectiontype', array(
      		'header'    => Mage::helper('pdftemplate')->__('Section Type'),
      		'align'     => 'left',
      		'width'     => '120px',
      		'index'     => 'sectiontype',
      		'type'      => 'options',
      		'options'   => Egovs_Pdftemplate_Model_Sectiontype::getOptionArray(),
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
  	return $this->getUrl('*/*/pdfsectionsgrid');
  }

 
}