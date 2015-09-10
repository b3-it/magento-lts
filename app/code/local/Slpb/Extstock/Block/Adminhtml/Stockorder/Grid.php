<?php

class Slpb_Extstock_Block_Adminhtml_Stockorder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('stockorderGrid');
      $this->setDefaultSort('extstock_stockorder_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('extstock/stockorder')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('extstock_stockorder_id', array(
          'header'    => Mage::helper('extstock')->__('Order ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'extstock_stockorder_id',
      ));

      $this->addColumn('user', array(
          'header'    => Mage::helper('extstock')->__('User'),
          'align'     =>'left',
          'index'     => 'user',
      ));
      
      $this->addColumn('user', array(
          'header'    => Mage::helper('extstock')->__('User'),
          'align'     =>'left',
          'index'     => 'user',
      ));
      
     $this->addColumn('date_ordered', array(
	          'header'  => Mage::helper('extstock')->__('Order Date'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'date_ordered',
			  
			));
			
	$this->addColumn('desired_date', array(
	          'header'  => Mage::helper('extstock')->__('Desired Date'),
	          'align'   =>'right',
	          'width'   => '50px',
			  'type'	=> 'date',
	          'index'   => 'desired_date',
			  
			));
			
		$stock = Mage::getModel('extstock/stock');	
		
		$this->addColumn('output_stock_id', array(
	          'header'  => Mage::helper('extstock')->__('From'),
	          'align'   =>'right',
	          'width'   => '120px',
			  'type'	=> 'options',
			  'options' => $stock->getCollection()->asOptionsArray(),
	          'index'   => 'outstock_id',
			  
			));
		$this->addColumn('input_stock_id', array(
	          'header'  => Mage::helper('extstock')->__('To'),
	          'align'   =>'right',
	          'width'   => '120px',
			  'type'	=> 'options',
			  'options' => $stock->getCollection()->asOptionsArray(),
	          'index'   => 'instock_id',
			  
			));
   
	    $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('adminhtml')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getExtstockStockorderId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('adminhtml')->__('Print'),
                        'url'       => array('base'=> '*/adminhtml_ordersheet/print'),
                        'field'     => 'lieferid'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'extstock_stockorder_id',
                //'is_system' => true,
        ));		
			
			
		
	  
      return parent::_prepareColumns();
  }

    protected function x_prepareMassaction()
    {
        $this->setMassactionIdField('stockorder_id');
        $this->getMassactionBlock()->setFormFieldName('stockorder');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('extstock')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('extstock')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('extstock/status')->getOptionArray();

  
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/adminhtml_ordersheet/index', array('lieferid' => $row->getId()));
  }

}