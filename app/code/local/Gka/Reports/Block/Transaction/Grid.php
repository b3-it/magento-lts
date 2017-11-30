<?php
 /**
  *
  * @category   	Gka Reports
  * @package    	Gka_Reports
  * @name       	Gka_Reports_Block_Transaction_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Reports_Block_Transaction_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	protected function _getUrlModelClass()
	{
		return 'core/url';
	}
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('gka_transactionGrid');
      $this->setDefaultSort('real_order_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
     
  }

  protected function _prepareCollection()
  {
  	$collection = Mage::getResourceModel('sales/order_grid_collection');

  
  	$userId = intval(Mage::getSingleton('customer/session')->getCustomerId());
  	
  	$collection->getSelect()
  	->joinleft(array('payment'=>$collection->getTable('sales/order_payment')),'payment.parent_id=main_table.entity_id',array('kassenzeichen'))
   	->where('customer_id = ' . $userId)
   	->where('store_id = '. intval(Mage::app()->getStore()))
  	;
  		
  	//die($collection->getSelect()->__toString());
  	
    $this->setCollection($collection);
    return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	$this->addColumn('real_order_id', array(
  			'header'=> Mage::helper('sales')->__('Order #'),
  			'width' => '80px',
  			'type'  => 'text',
  			'index' => 'increment_id',
  	));
  	
  	$this->addColumn('kassenzeichen', array(
  			'header' => Mage::helper('sales')->__('Kassenzeichen'),
  			'index' => 'kassenzeichen',
  			'type' => 'text',
  			'width' => '100px',
  	));
  	
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
    		'total'     => 'sum',
        ));
  	
  	$this->addColumn('status', array(
  			'header' => Mage::helper('sales')->__('Status'),
  			'index' => 'status',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
  	));
  	 
  	$this->addColumn('payment_method', array(
  			'header'    => Mage::helper('sales')->__('Payment Method'),
  			'index'     => 'payment_method',
  			'type'      => 'options',
  			'width'     => '130px',
  			'options'   => Mage::helper('gka_reports')->getActivePaymentMethods(),
  	));
  	


		$this->addExportType('*/*/exportCsv', Mage::helper('gka_reports')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('gka_reports')->__('XML'));
		$this->setCountTotals(true);
      return parent::_prepareColumns();
  }

	  /**
	   * Retrieve totals
	   *
	   * @return Varien_Object
	   */
	  public function getTotals()
	  {
	  	return $this->_varTotals;
	  }

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	$params['_store'] = Mage::app()->getStore();
    	return $this->getUrl('*/*/grid', $params);

    }
    
    protected function _afterLoadCollection()
    {
    	$data = array();
    	foreach($this->getCollection() as $item)
    	{
    		foreach($this->getColumns() as $col)
    		{
    			if($col->getTotal())
    			{
    				if(!isset($data[$col->getId()])){
    					$data[$col->getId()] = $item->getData($col->getIndex());
    				}else {
    					$data[$col->getId()] += $item->getData($col->getIndex());
    				}
    			}
    		}
    	}
    	
    	foreach($data as $key=> $value)
    	{
    		$data[$key] = $value ." €";
    	}
    	
    	
    	$this->setTotals(new Varien_Object($data));
    }


}
