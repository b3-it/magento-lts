<?php

class Egovs_Extnewsletter_Block_Adminhtml_Report_Issues_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('issueGrid');
      $this->setDefaultSort('issue_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setPagerVisibility(false);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('extnewsletter/issue')->getCollection();
      $collection->getSelect()
      	->join(array('t1'=>$collection->getTable('extnewsletter/issuesubscriber')),'t1.issue_id=main_table.extnewsletter_issue_id and t1.is_active=1',array('anzahl'=>'count(is_active)'))
      	->group('main_table.extnewsletter_issue_id');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('anzahl', array(
          'header'    => Mage::helper('extnewsletter')->__('Count'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'anzahl',
      	  'filter'	  => false,
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('extnewsletter')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  
      $this->addColumn('remarks', array(
			'header'    => Mage::helper('extnewsletter')->__('Remarks'),
			'width'     => '150px',
			'index'     => 'remarks',
      ));
      
      $opt = Mage::getModel('core/store')->getCollection()->toOptionHash();
      $opt[0] = Mage::helper('extnewsletter')->__('All');
      $this->addColumn('store_id', array(
			'header'    => Mage::helper('extnewsletter')->__('Store'),
			'width'     => '150px',
			'index'     => 'store_id',
      		'type'	=>'options',
      		'options' => $opt,
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