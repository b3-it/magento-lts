<?php
 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Block_Kassenbuch_Journalitems_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	protected function _getUrlModelClass()
	{
		return 'core/url';
	}
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('kassenbuch_journalGrid');
      $this->setDefaultSort('kassenbuch_journal_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  protected function _prepareCollection()
  {
  	$userId = intval(Mage::getSingleton('customer/session')->getCustomerId());
  	$id     =  intval($this->getRequest()->getParam('id'));
  	if(!$id){
  		$id = Mage::registry('journal_id');
  	}
  	$collection = Mage::getModel('gka_barkasse/kassenbuch_journalitems')->getCollection();
  	$collection->getSelect()
  	->columns(array('externes_kassenzeichen_bool' => "IF(LENGTH(externes_kassenzeichen),1,0)"))
  	->join(array('journal'=> $collection->getTable('gka_barkasse/kassenbuch_journal')),'main_table.journal_id=journal.id',array())
  	->joinLeft(array('payment'=>'sales_flat_order_payment'), 'payment.parent_id=main_table.order_id',array('method'=>'method','kassenzeichen'=>'kassenzeichen','pay_client'=>'pay_client'))
  	->join(array('order'=> $collection->getTable('sales/order')),'main_table.order_id=order.entity_id',array('status','increment_id','externes_kassenzeichen'))
  	->where('journal.customer_id = ' . $userId)
  	->where('journal_id = ' . $id);
  	//->where('main_table.status = '.Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED);
  		
  	//die($collection->getSelect()->__toString());
  	;
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('gka_barkasse')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
          'filter_index' => 'main_table.id'
      ));

      $this->addColumn('number', array(
          'header'    => Mage::helper('gka_barkasse')->__('Number'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'number',
      	  'filter_index' => 'main_table.number'
      ));

      $this->addColumn('booking_date', array(
          'header'    => Mage::helper('gka_barkasse')->__('Date'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'booking_date',
      	  'type'	=> 'datetime'
      ));
      $this->addColumn('booking_amount', array(
          'header'    => Mage::helper('gka_barkasse')->__('Amount'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'booking_amount',
      	  'filter_index' => 'main_table.booking_amount'
      	//	'type'	=> 'datetime'
      ));
 
      $this->addColumn('increment_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('Order ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'increment_id',
      ));

      $this->addColumn('pay_client', array(
      		'header' => Mage::helper('sales')->__('ePayBL Client'),
      		'index' => 'pay_client',
      		'type' => 'text',
      		'width' => '100px',
      		'filter_index' => 'payment.pay_client',
      ));
      
      $this->addColumn('kz', array(
      		'header'    => Mage::helper('sales')->__('Kassenzeichen'),
      		'index'     => 'kassenzeichen',
      		'type'      => 'text',
      ));
      
       $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
       		'filter_index' => 'order.status'
        ));
       
       $this->addColumn('externes_kassenzeichen', array(
       		'header' => Mage::helper('gka_barkasse')->__('Externes Kassenzeichen'),
       		'index' => 'externes_kassenzeichen_bool',
       		'type'  => 'options',
       		'width' => '70px',
       		'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
       		
       ));
		$this->addExportType('*/*/exportCsv', Mage::helper('gka_barkasse')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('gka_barkasse')->__('XML'));

      return parent::_prepareColumns();
  }


	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/grid', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
