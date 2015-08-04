<?php

class Egovs_Informationservice_Block_Adminhtml_Report_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('reportGrid');
      $this->setDefaultSort('report_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('informationservice/request')->getCollection();
      $exp = new Zend_Db_Expr("(SELECT request_id, sum(cost) as sum_cost FROM ".$collection->getTable('informationservice/task')."  GROUP BY request_id) ");
      $collection->getSelect()
      	->join(array('u1'=>'admin_user'),'u1.user_id=main_table.reporter_id','user_id')
      	->join(array('close'=>$collection->getTable('informationservice/task')),'close.request_id=main_table.request_id ',array('realisierung'=>'created_time'))
      	->join(array('tcost'=>$exp),'tcost.request_id=main_table.request_id','sum_cost')
      	->join(array('tcust'=>$collection->getTable('customer/entity')),'tcust.entity_id=main_table.customer_id',array('customer_group_id'=>'group_id'))
      	->joinleft(array('product'=>$collection->getTable('catalog/product')),'result_product_id=product.entity_id',array('sku'))
      	->where('close.newstatus='.Egovs_Informationservice_Model_Status::STATUS_CLOSED);
      	//->OrWhere('main_table.status='.Egovs_Informationservice_Model_Status::STATUS_CLOSED);
      	
      	;
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {

  	 $this->addColumn('created_time', array(
          'header'    => Mage::helper('informationservice')->__('Created'),
          'align'     =>'left',
  	 	  'type'	  => 'Date',
      	  'width'     => '50px',
          'index'     => 'created_time',
  	 	  'filter_index' => 'main_table.created_time'	
      ));
      
       $this->addColumn('realisierung', array(
          'header'    => Mage::helper('informationservice')->__('Realisierung'),
          'align'     =>'left',
  	 	  'type'	  => 'Date',
      	  'width'     => '50px',
          'index'     => 'realisierung',
          'filter_index' => 'close.created_time'
      ));
  	

      $this->addColumn('title', array(
          'header'    => Mage::helper('informationservice')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
          'filter_index' => 'main_table.title'
      ));
      
      $this->addColumn('reporter_id', array(
          'header'    => Mage::helper('informationservice')->__('Reporter'),
          'align'     =>'left',
      	  'width'     => '80px',
      	'type'	=> 'options',
        'options'	=> Mage::helper('informationservice')->getUsernamesAsOptionValues(),
          'index'     => 'reporter_id',
      ));
      
     $this->addColumn('result_sku', array(
          'header'    => Mage::helper('informationservice')->__('Sku'),
          'align'     =>'left',
      	  'width'     => '80px',
          'index'     => 'sku',
     	  	
      ));

	 $this->addColumn('category_id', array(
          'header'    => Mage::helper('informationservice')->__('Category'),
          'align'     =>'left',
      	  'width'     => '80px',
	 	  'type'	  => 'options',
	 	  'options'   => Mage::helper('informationservice')->getCategoriesAsOptionValueArray(),
          'index'     => 'category_id',
      ));
      
      
     $this->addColumn('customer_group_id', array(
          'header'    => Mage::helper('informationservice')->__('Customer Group'),
          'align'     =>'left',
      	  'width'     => '80px',
	 	  'type'	  => 'options',
	 	  'options'   => Mage::getModel('customer/group')->getCollection()->toOptionHash(),
          'index'     => 'customer_group_id',
          'filter_index' => 'group_id'
      ));
      
     $this->addColumn('output_type', array(
          'header'    => Mage::helper('informationservice')->__('Answer Type'),
          'align'     =>'left',
      	  'width'     => '80px',
	 	  'type'	  => 'options',
	 	  'options'   => Mage::getModel('informationservice/requesttype')->getOutputTypesAsOptionValueArray(),
          'index'     => 'output_type',
      ));
		
      $this->addColumn('cost', array(
          'header'    => Mage::helper('informationservice')->__('Cost expected'),
          'align'     =>'left',
      	  'width'     => '80px',
      	  'type'      =>'number',	
          'index'     => 'cost',
      	  'total'	  => 'sum',
      	  'filter_index' => 'main_table.cost'	
      ));
      
     $this->addColumn('sum_cost', array(
          'header'    => Mage::helper('informationservice')->__('Real Cost'),
          'align'     =>'left',
      	  'width'     => '80px',
      	'type'=>'number',	
          'index'     => 'sum_cost',
     	  'total' =>'sum'	
      ));
      
     $this->setCountTotals(true); 
		$this->addExportType('*/*/exportCsv', Mage::helper('informationservice')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('informationservice')->__('XML'));
	  
      return parent::_prepareColumns();
  }

 	protected function _afterLoadCollection()
    {
        $totalObj = new Mage_Reports_Model_Totals();
        $this->setTotals($totalObj->countTotals($this,0,0));
    }

}