<?php
 class B3it_ConfigCompare_Block_Adminhtml_Compare_Tab_Emailtemplates extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('emailtemplatesGrid');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      $this->setNoFilterMassactionColumn(true);
  }

  protected function _prepareCollection()
  {
      $collection  = Mage::getModel('configcompare/configcompare')->getCollection();
  	  $collection->getSelect()->where("type='email_template'");
  	  
  	  
      $collection =Mage::getModel('configcompare/emailTemplates')->getCollectionDiff($collection->getItems());

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
  	
      $this->addColumn('template_code', array(
          'header'    => Mage::helper('configcompare')->__('Identifier'),
          //'align'     =>'right',
          'width'     => '120px',
          'index'     => 'template_code',
      	
      ));
      
      $this->addColumn('attribute', array(
      		'header'    => Mage::helper('configcompare')->__('Attribute'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'attribute',
      		'renderer'  => 'configcompare/adminhtml_widget_grid_column_renderer_diff'
     
      ));
      
      $this->addColumn('template_subject', array(
      		'header'    => Mage::helper('configcompare')->__('Subject'),
      		//'align'     =>'right',
      		'width'     => '120px',
      		'index'     => 'template_subject',
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
  	return $this->getUrl('*/*/emailtemplatesgrid');
  }

 
}