<?php
 /**
  *
  * @category   	Bfr Report
  * @package    	Bfr_Report
  * @name       	Bfr_Report_Block_Adminhtml_Export_Exported_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bfr_Report_Block_Adminhtml_Export_Exported_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('export_exportedGrid');
      $this->setDefaultSort('increment_id');
      $this->setDefaultDir('ASC');
      $filter = array('exported'=>'0');
      $this->setDefaultFilter($filter);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  	  $collection = Mage::getResourceModel('sales/order_grid_collection');

  	  $order_item_expr = new Zend_Db_Expr("(SELECT order_id, group_concat(sku  SEPARATOR ', ') as skus FROM {$collection->getTable('sales/order_item')} Group BY order_id)");
  	  
      $collection->getSelect()
      
      ->joinleft(array('export'=>$collection->getTable('bfr_report/export_exported')),'main_table.entity_id = export.order_id',array('exported_at'=>'exported_at',
      		'exported_by'=>'exported_by',
      		'exported' => new Zend_Db_Expr('(exported_at IS NOT NULL)')
      		
      ))
      ->join(array('bkz' => $collection->getTable('sales/order_payment')),
      		'main_table.entity_id = bkz.parent_id',
      		array('kassenzeichen','epaybl_capture_date'))
      ->join(array('oi'=>$order_item_expr),'oi.order_id=main_table.entity_id',array('skus'))
      ;
      $collection->setIsCustomerMode(true);
      
      //die( $collection->getSelect()->__toString());
      
      $this->setCollection($collection);
       parent::_prepareCollection();
      $order_ids = array();
      
      
      
      
      foreach($this->getCollection() as $item){
      	$order_ids[] = $item->getId();
      }
       
      Mage::register('order_ids', $order_ids);
       return $this;
  }

  protected function _prepareColumns()
  {
      $this->addColumn('increment_id', array(
          'header'    => Mage::helper('bfr_report')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'increment_id',
      ));

   
      
      $this->addColumn('kassenzeichen', array(
      		'header'    => Mage::helper('bfr_report')->__('Kassenzeichen'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'kassenzeichen',
      ));
      
      $this->addColumn('billing_name', array(
      		'header' => Mage::helper('sales')->__('Bill to Name'),
      		'index' => 'billing_name',
      ));
      

      $this->addColumn('base_grand_total', array(
      		'header' => Mage::helper('sales')->__('G.T. (Base)'),
      		'index' => 'base_grand_total',
      		'type'  => 'currency',
      		'currency' => 'base_currency_code',
      ));
      
      $this->addColumn('base_total_paid', array(
      		'header' => Mage::helper('sales')->__('Total Paid (Base)'),
      		'index' => 'base_total_paid',
      		'type'  => 'currency',
      		'currency' => 'base_currency_code',
      ));
      
      $this->addColumn('saldo', array(
      		'header' => $this->__('Balance (Base)'),
      		'index' => 'base_grand_total',
      		'index_paid' => 'base_total_paid',
      		'type' => 'currency',
      		'renderer' => 'egovsbase/adminhtml_widget_grid_column_renderer_balance',
      		'currency' => 'base_currency_code',
      		'filter_condition_callback' => array('Egovs_Extsalesorder_Helper_Data', 'filterbaseGrantTotalCondition'),
      ));
      
      $this->addColumn('payment_method', array(
      		'header'    => Mage::helper('sales')->__('Payment Method'),
      		'index'     => 'payment_method',
      		'type'      => 'options',
      		'width'     => '130px',
      		'options'   => Mage::helper('paymentbase')->getActivePaymentMethods(),
      ));
      
      $this->addColumn('skus', array(
      		'header' => Mage::helper('sales')->__('Sku'),
      		'index' => 'skus',
      ));
      
      
      $this->addColumn('status', array(
      		'header' => Mage::helper('sales')->__('Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      $this->addColumn('epaybl_capture_date', array(
      		'header' => Mage::helper('bfr_report')->__('Payment Capture Date'),
      		'index' => 'epaybl_capture_date',
      		'type' => 'datetime',
      		'width' => '100px',
      ));
      
     
      
      
     
      
      $this->addColumn('created_at', array(
      		'header' => Mage::helper('sales')->__('Purchased On'),
      		'index' => 'created_at',
      		'type' => 'datetime',
      		'width' => '100px',
      ));
      
     
      
      $this->addColumn('exported', array(
      		'header'    => Mage::helper('bfr_report')->__('Exported'),
      		'align'     =>'left',
      		'index'     => 'exported',
      		'type'      => 'options',
      		'align'     =>'left',
      		'width'     => '50px',
      		'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
      		'filter_condition_callback' => array($this, '_filterConditionExportStatus'),
      ));
      $this->addColumn('exported_at', array(
          'header'    => Mage::helper('bfr_report')->__('Exportiert Am'),
          //'align'     =>'left',
          //'width'     => '150px',
      		'type' => 'datetime',
          'index'     => 'exported_at',
      ));
      $this->addColumn('exported_by', array(
          'header'    => Mage::helper('bfr_report')->__('Exportiert Von'),
          'align'     =>'left',
          //'width'     => '50px',
          'index'     => 'exported_by',
      ));

      
      
      
       

		$this->addExportType('*/*/exportCsv', Mage::helper('bfr_report')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('bfr_report')->__('XML'));
    $this->addExportType('*/*/exportExcel', Mage::helper('bfr_report')->__('XML (Excel)'));
      return parent::_prepareColumns();
  }

  protected function _filterConditionExportStatus($collection, $column)
  {
  	$value = $column->getFilter()->getValue();
  	
  	 
  	if($value){
  		$condition = 'exported_at IS NOT NULL';
  	}else{
  		$condition = 'exported_at IS NULL';
  	}
  	if($condition){
  		$collection->getSelect()->where($condition, $value);
  	}
  }

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }

 

}
