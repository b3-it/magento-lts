<?php
 /**
  *
  * @category   	Dwd Fix
  * @package    	Dwd_Fix
  * @name       	Dwd_Fix_Block_Adminhtml_Rechnung_Rechnung_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Fix_Block_Adminhtml_Rechnung_Rechnung_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('rechnung_rechnungGrid');
      $this->setDefaultSort('rechnung_rechnung_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dwd_fix/rechnung_rechnung')->getCollection();
      $collection->getSelect()
      ->join(array('order'=>$collection->getTable('sales/order')),'order.entity_id=main_table.order_id')
      ->joinleft(array('invoice'=>$collection->getTable('sales/invoice')),'order.entity_id=invoice.order_id',array('invoice_id'=>'entity_id','invoice_increment_id'=>'increment_id'))
      ->columns(array('has_invoice'=>new Zend_Db_Expr('(SELECT IF (invoice_id > 0,1,0))')));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('dwd_fix')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('order', array(
          'header'    => Mage::helper('dwd_fix')->__('Bestellung'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'increment_id',
      ));
      
      $this->addColumn('invoice', array(
      		'header'    => Mage::helper('dwd_fix')->__('Invoice'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'invoice_increment_id',
      ));
      
      
      $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      $yesno = array();
      foreach ($yn as $n)
      {
      	$yesno[$n['value']] = $n['label'];
      }
      
      $this->addColumn('hasinvoice', array(
      		'header'    => Mage::helper('dwd_fix')->__('Rechnung vorhanden'),
      		//'align'     =>'left',
      		'width'     => '80px',
      		'index'     => 'has_invoice',
      		'type'      => 'options',
      		'options'   => $yesno,
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
      $this->addColumn('date', array(
      		'header'    => Mage::helper('dwd_fix')->__('Erstellt'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'created_at',
      		'type' => 'datetime'
      ));
      
      $this->addColumn('status', array(
      		'header' => Mage::helper('sales')->__('Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      
      
      $this->addColumn('send', array(
          'header'    => Mage::helper('dwd_fix')->__('Versendet'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'send',
      		'type' => 'datetime'
      ));

  

		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_fix')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_fix')->__('XML'));

      return parent::_prepareColumns();
  }

  

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }
    
    protected function _filterCondition($collection, $column)
    {
    	$value = $column->getFilter()->getValue();
    	if ($value === null) {
    		return;
    	}
    	 
    	$condition = intval($value);
    	if($condition == 1){
    		$collection->getSelect()->where('invoice.entity_id > 0');
    	}
    	if($condition == 0){
    		$collection->getSelect()->where('invoice.entity_id is NULL');
    	}
    }

 
}
