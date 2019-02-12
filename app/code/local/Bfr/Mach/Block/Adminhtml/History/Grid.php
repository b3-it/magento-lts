<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Block_Adminhtml_History_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Block_Adminhtml_History_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('historyGrid');
      $this->setDefaultSort('history_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $filter = array('export_status'=>'0');
      $this->setDefaultFilter($filter);
  }

  
  protected function _getCollectionClass()
  {
  	return 'sales/order_grid_collection';
  }
  
  protected function _prepareCollection()
  {
  	$collection = Mage::getResourceModel($this->_getCollectionClass());
  	
  	$collection->getSelect()
  		->joinLeft(array('kopf'=>$collection->getTable('bfr_mach/history')),'kopf.order_id = main_table.entity_id AND kopf.deprecated = 0 AND kopf.export_type ='.Bfr_Mach_Model_ExportType::TYPE_KOPF, array('kopf_created_time'=> 'kopf.download_time'))
  		->joinLeft(array('pos'=>$collection->getTable('bfr_mach/history')),'pos.order_id = main_table.entity_id AND pos.deprecated = 0 AND pos.export_type ='.Bfr_Mach_Model_ExportType::TYPE_POSITION, array('pos_created_time'=> 'pos.download_time'))
  		->joinLeft(array('zuord'=>$collection->getTable('bfr_mach/history')),'zuord.order_id = main_table.entity_id AND zuord.deprecated = 0 AND zuord.export_type ='.Bfr_Mach_Model_ExportType::TYPE_ZUORDNUNG, array('zuord_created_time'=> 'zuord.download_time'))
  		->columns(new Zend_Db_Expr('IF(kopf.download_time AND zuord.download_time AND pos.download_time,1,0) AS export_status'))
  		->where('status IN (\''.Mage_Sales_Model_Order::STATE_PROCESSING.'\', \''.Mage_Sales_Model_Order::STATE_COMPLETE.'\')');
  	;
 //die($collection->getSelect()->__toString()); 	
  	$this->setCollection($collection);
  	return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	
  	$yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
  	$yesno = array();
  	foreach ($yn as $n)
  	{
  		$yesno[$n['value']] = $n['label'];
  	}
  	
        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            	'width' => '200px',
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
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
        

        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
        
        
        $this->addColumn('kopf_created', array(
        		'header' => Mage::helper('sales')->__('Kopf'),
        		'index' => 'kopf_created_time',
        		'type' => 'datetime',
        		'width' => '100px',
        		'align'     =>'left',
        		'filter_index' => 'kopf.download_time',
        		'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));
        
        $this->addColumn('pos_created', array(
        		'header' => Mage::helper('sales')->__('Pos'),
        		'index' => 'pos_created_time',
        		'type' => 'datetime',
        		'width' => '100px',
        		'align'     =>'left',
        		'filter_index' => 'pos.download_time',
        		'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));
        
        $this->addColumn('zuord_created', array(
        		'header' => Mage::helper('sales')->__('Zuordnung'),
        		'index' => 'zuord_created_time',
        		'type' => 'datetime',
        		'width' => '100px',
        		'align'     =>'left',
        		'filter_index' => 'zuord.download_time',
        		'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));
        
        
        $this->addColumn('export_status', array(
        		'header' => Mage::helper('sales')->__('Export Complete'),
        		'index' => 'export_status',
        		'type'  => 'options',
        		'width' => '70px',
        		'options' => $yesno,
        		'filter_condition_callback' => array($this, '_filterConditionExportStatus'),
        ));
        
       

      return parent::_prepareColumns();
  }

 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_id');

        $this->getMassactionBlock()->addItem('export', array(
             'label'    => Mage::helper('bfr_mach')->__('Export'),
             'url'      => $this->getUrl('*/*/export'),
            
        ));
        

        
        return $this;
    }

 
  
  protected function _filterConditionExportStatus($collection, $column) 
  {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	
  		$condition = '(kopf.download_time AND zuord.download_time AND pos.download_time) = '. $value;
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  }
  
  
  /**
   * Filterkondition für Datumsfeld der Bestellung
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterCreatedAtCondition($collection, $column) 
  {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	
  	$col = 'DATE('.$column->getFilterIndex().')';
  	if ($col == null) return $this;
  	
  	if(isset( $value['from']) && isset( $value['to'])){
  		$condition = sprintf("($col >= '%s') && ($col <= '%s'))", $value['from']->ToString('yyyy-MM-dd'),  $value['to']->ToString('yyyy-MM-dd') );
  		$collection->getSelect()->where($condition);
  	}
  	else if(isset( $value['from'])){
  		$condition = sprintf("(($col >= '%s'))", $value['from']->ToString('yyyy-MM-dd'));
  		$collection->getSelect()->where($condition);
  	}
  	else if(isset( $value['to'])){
  		$condition = sprintf("(($col <= '%s'))", $value['to']->ToString('yyyy-MM-dd') );
  		$collection->getSelect()->where($condition);
  	}
  		
  	//die($collection->getSelect()->__toString());
  }
  

}
