<?php

class Egovs_Extnewsletter_Block_Adminhtml_Report_Products_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productGrid');
      $this->setDefaultSort('anzahl');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setPagerVisibility(false);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('extnewsletter/extnewsletter')->getCollection();
      $collection->getSelect()
      	->columns(array('anzahl'=>'sum(is_active)'))
      	->where('is_active = 1')
      	->group('product_id')
      	->join(array('t3'=>'eav_entity_type'),"t3.entity_type_code='catalog_product'",array())
      	->join(array('t2'=>'eav_attribute'),"attribute_code='name' and t2.entity_type_id = t3.entity_type_id",array())
      	->join(array('t1'=>'catalog_product_entity_varchar'),'t1.entity_id = main_table.product_id and t1.attribute_id=t2.attribute_id',array('name'=>'value'))
      	
      	;
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('anzahl', array(
          'header'    => Mage::helper('extnewsletter')->__('Count'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',	
          'index'     => 'anzahl',
      	  'filter' => false,	
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('extnewsletter')->__('Title'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_index' => 't1.value'	
      ));

	
  
	  
	
		//$this->addExportType('*/*/exportCsv', Mage::helper('extnewsletter')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('extnewsletter')->__('XML'));
	  
      return parent::_prepareColumns();
  }
  
  protected function x_addColumnFilterToCollection($column)
  {
  	
  	 	if ($this->getCollection()) {
           if ($column->getId() == 'anzahl') {
           		$filter = $column->getFilter()->getValue();
           		$select = $this->getCollection()->getSelect();
           		if(isset($filter['from']) && isset($filter['to'])){
           			$select->having('anzahl >='.$filter['from'].' AND anzahl<='.$filter['to'] );
           		}elseif (isset($filter['from'])){
           			$select->having('anzahl >='.$filter['from']);
           		}elseif (isset($filter['to'])){
           			$select->having('anzahl<='.$filter['to'] );
           		}	
           	
                return $this;
           }
        }
       
        return parent::_addColumnFilterToCollection($column);
  }

 

}