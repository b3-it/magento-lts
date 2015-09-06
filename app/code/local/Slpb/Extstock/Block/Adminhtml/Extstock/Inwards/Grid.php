<?php

/**
 * Adminhtml total visitors
 *
 * @category   Slpb
 * @package    Slpb_Extreport
 */
class Slpb_Extstock_Block_Adminhtml_Extstock_Inwards_Grid extends Egovs_Extreport_Block_Adminhtml_AbstractReportGrid
{
	/**
     * Sub report size
     *
     * @var int
     */
    protected $_subReportSize = 0; //no limit
    
    public function __construct()
    {
        parent::__construct();
       
        $this->setId('gridInwardsExtstock');
        $this->setDefaultSort('date_delivered');
        $this->setDefaultDir('asc');
        
        //Prefix der Namen der HTML Variablen
        $this->setVarNameFilter('inwards_filter');
        
        $this->_controller = 'adminhtml_report_inwards';
        
        $this->addExportType('*/*/exportInwardsCsv', Mage::helper('reports')->__('CSV'));
        $this->addExportType('*/*/exportInwardsExcel', Mage::helper('reports')->__('Excel'));
    }
	
    protected function _prepareCollection()
    {
    	parent::_prepareCollection();
        $this->getCollection()
            ->initReport('extstock/extstock_inwards_collection');
        return $this;      
    }

    protected function _prepareColumns()
    {
    	$store = $this->_getStore();
    	
        $this->addColumn('name', array(
            'header'    => Mage::helper('extreport')->__('Product ID'),
            'sortable'  => true,
            'index'     => 'product_id',
        	'type'      => 'number'
        ));

        $this->addColumn('product', array(
	          'header'    => Mage::helper('extstock')->__('Product'),
	          'align'     =>'left',
	          'index'     => 'name',
		));

		$this->addColumn('sku', array(
          'header'	=> Mage::helper('extstock')->__('sku'),
          'align'   =>'left',
     	  'width'   => '50px',
		  'type'	=> 'number',	
          'index'   => 'sku',
		));
		
		$this->addColumn('quantity_ordered', array(
          	'header'	=> Mage::helper('extstock')->__('Quantity Ordered'),
          	'align'     =>'right',
      	  	'width'     => '40px',
			'type'		=> 'number',	
          	'index'     => 'quantity_ordered',
			'total' => 'sum',
		));


		$this->addColumn('quantity', array(
          	'header'	=> Mage::helper('extstock')->__('Avail Qty'),
          	'align'    	=>'right',
      	  	'width'    	=> '40px',
		  	'type'		=> 'number',	
          	'index'    	=> 'quantity',
			'total' 	=> 'sum',
		));

		$this->addColumn('bestellwert', array(
			'header'    => Mage::helper('extstock')->__('Bestellwert'),
      	  	'type'  	=> 'price',
          	'currency_code' => $store->getBaseCurrencyCode(),
          	'align'     =>'right',
      	  	'width'     => '40px',	
          	'index'     => 'bestellwert',
			'total' 	=> 'sum',
		));

		$this->addColumn('lagerwert', array(
			'header'    => Mage::helper('extstock')->__('Lagerwert'),
			'type'  	=> 'price',
          	'currency_code' => $store->getBaseCurrencyCode(),
          	'align'     =>'right',
      	  	'width'     => '40px',	
          	'index'     => 'lagerwert',
			'total' 	=> 'sum',
		));
		
		$this->addColumn('price', array(
			'header'    => Mage::helper('extstock')->__('Cost Price'),
      	  	'type'  	=> 'price',
          	'currency_code' => $store->getBaseCurrencyCode(),
          	'align'     =>'right',
      	  	'width'     => '40px',	
          	'index'     => 'price',
			'total' 	=> 'sum',
		));

		$this->addColumn('distributor', array(
          'header'    => Mage::helper('extstock')->__('Distributor'),
          'align'     =>'left',
      	  'width'     => '100px',	
          'index'     => 'distributor',
		));

		$this->addColumn('date_ordered', array(
          	'header'    => Mage::helper('extstock')->__('Order Date'),
          	'align'     =>'left',
      	  	'width'     => '50px',
			'type'		=> 'date',	
          	'index'     => 'date_ordered',
			'gmtoffset' => true
		));

		$this->addColumn('date_delivered', array(
          	'header'    => Mage::helper('extstock')->__('Delivery Date'),
          	'align'     =>'left',
      	  	'width'     => '50px',
			'type'		=> 'date',	
			'index'     => 'date_delivered',
			'type'		=> 'date',
			'gmtoffset' => true
		));
       
//        $this->setCountTotals(true);
		
        return parent::_prepareColumns();
    }
}