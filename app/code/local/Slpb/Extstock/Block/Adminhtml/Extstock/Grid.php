<?php

class Slpb_Extstock_Block_Adminhtml_Extstock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	private $_product = null;
	private $_product_id = null;
	private $_distributor = null;
	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockGrid');
		$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		if(isset( $attributes['product']))
			$this->_product = $attributes['product'];
		$product_id = $this->getRequest()->getParam('product_id');
		$distributor = $this->getRequest()->getParam('distributor');	

		
		if(!$product_id)
		{
			$product_id = $this->getRequest()->getParam('id');
		}
		
		
		if ($product_id) {
			$this->_product_id = $product_id;
		}
		
		
		
		
		if ($distributor) {
			$this->_distributor = $distributor;
		}
	}

  	protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
           if ($column->getId() == 'productx') {
           		$filter = $column->getFilter()->getValue();
           		
           		//$this->getCollection()->setCategoryFilter($filter);
                //return $this;
           }
        }
        return parent::_addColumnFilterToCollection($column);
    }
	

	protected function _prepareCollection()
	{

		$collection = Mage::getResourceModel('extstock/extstock_collection');
		$collection->addFilterOnlyStockOrders();
		$this->setCollection($collection);

		//$productid = Mage::getSingleton('adminhtml/session')->getData('extstockproduct'); 
		if(!$this->_isStockMode())
		{
			if (!is_null($this->_product_id)) {
				$collection->getSelect()->where("product_id = ". intval($this->_product_id));
			} else {
				$collection->getSelect()->where("product_id IS NULL");
			}
		} else {
			//Wichtig für Redirect von extstocklist mit Filterung!!
			if (!is_null($this->_product_id)) {
				$collection->getSelect()->where("product_id = $this->_product_id");
			}
			if (!is_null($this->_distributor)) {
				//Leerzeichen Rückcodieren #371
				$this->_distributor = str_ireplace("%20", " ", $this->_distributor);
				$collection->getSelect()->where("`distributor` like '$this->_distributor' ");
			}
		}	
		//die($collection->getSelect()->__toString());		
		return parent::_prepareCollection();		
	}
	
	protected function _prepareColumns()
	{
		$store = Mage::app()->getStore();
		if($this->_isStockMode())
		{
			$this->addColumn('extstock_id', array(
	          'header'  => Mage::helper('extstock')->__('ID'),
	          'align'   =>'right',
	          'width'   => '30px',
			  'type'	=> 'text',
	          'index'   => 'extstock_id',
			  
			));
		}
		if($this->_isStockMode())
		{
			$this->addColumn('product', array(
	          'header'    => Mage::helper('extstock')->__('Product'),
	          'align'     =>'left',
	          'index'     => 'name',
			  'filter_index' => 'att.value'	
			));

			$this->addColumn('sku', array(
	          'header'	=> Mage::helper('extstock')->__('sku'),
	          'align'   =>'left',
	     	  'width'   => '50px',	
	          'index'   => 'sku',
			));
		}

		$this->addColumn('quantity_ordered', array(
          	'header'	=> Mage::helper('extstock')->__('Quantity Ordered'),
          	'align'     =>'right',
      	  	'width'     => '40px',
			'type'		=> 'number',	
          	'index'     => 'quantity_ordered',
		));


		$this->addColumn('quantity', array(
          	'header'	=> Mage::helper('extstock')->__('Avail Qty'),
          	'align'    	=>'right',
      	  	'width'    	=> '40px',
		  	'type'		=> 'number',	
          	'index'    	=> 'quantity',
		));

		if($this->_isStockMode())
		{
			$this->addColumn('bestellwert', array(
	          'header'    => Mage::helper('extstock')->__('Bestellwert'),
	      	  'type'  => 'price',
	          'currency_code' => $store->getBaseCurrency()->getCode(),
	          'align'     =>'right',
	      	  'width'     => '40px',	
	          'index'     => 'bestellwert',
			  'filter_index'=>'(quantity_ordered * price)'	
			));
	/*
			$this->addColumn('lagerwert', array(
	          'header'    => Mage::helper('extstock')->__('Lagerwert'),
	      	  'type'  => 'price',
	          'currency_code' => $store->getBaseCurrency()->getCode(),
	          'align'     =>'right',
	      	  'width'     => '40px',	
	          'index'     => 'lagerwert',
			  'filter_index'=>'(quantity * price)'	
			));*/
		}
		$this->addColumn('cost_price', array(
          'header'    => Mage::helper('extstock')->__('Cost Price'),
      	  'type'  => 'price',
          'currency_code' => $store->getBaseCurrency()->getCode(),
          'align'     =>'right',
      	  'width'     => '40px',	
          'index'     => 'price',
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
      	  	'width'     => '20px',
			'type'		=> 'date',	
          	'index'     => 'date_ordered',
			'gmtoffset' => true
		));

		$this->addColumn('date_delivered', array(
          	'header'    => Mage::helper('extstock')->__('Delivery Date'),
          	'align'     =>'left',
      	  	'width'     => '20px',
			'type'		=> 'date',	
			'index'     => 'date_delivered',
			'type'		=> 'date',
			'gmtoffset' => true
		));

		$this->addColumn('status', array(
          'header'    => Mage::helper('extstock')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
					1 => Mage::helper('extstock')->__('Ordered'),
					2 => Mage::helper('extstock')->__('Delivered'),
					),
		));
		
		$this->addColumn('store', array(
	          'header'    => Mage::helper('extstock')->__('Stock'),
	          'align'     =>'left',
	      	  'width'     => '50px',	
	          'index'     => 'stock_id',
			  'type'      => 'options',
          	  'options'   => Mage::getModel('extstock/stock')->getCollection()->asOptionsArray()
			));
	
		
		
		if($this->_isStockMode())
		{
			$this->addColumn('storage', array(
	          'header'    => Mage::helper('extstock')->__('Storage'),
	          'align'     =>'left',
	      	  'width'     => '50px',	
	          'index'     => 'storage',
			));
	
			$this->addColumn('rack', array(
	          'header'    => Mage::helper('extstock')->__('Rack'),
	          'align'     =>'left',
	      	  'width'     => '50px',	
	          'index'     => 'rack',
			));

		}
			
		if(!$this->_isStockMode())
		{
			$actions =  array(
	                        'caption'   => Mage::helper('extstock')->__('Edit'),
	                        'url'       => array('base'=> $this->getThisUrl('edit'),'mode'=>'product'),
	                        'field'     => 'id',
	                    	'popup'		=> '1'
	                    	//'onclick'  => 'superProduct.createPopup({$action['href']});return false;'
			);
		}
		else
		{
			$actions =  array(
                        'caption'   => Mage::helper('extstock')->__('Edit'),
                        'url'       => array('base'=> $this->getThisUrl('edit')),
                        'field'     => 'id',
			);
		}

		$this->addColumn('action',
		array(
                'header'    =>  Mage::helper('extstock')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array($actions),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
		));

		if($this->_isStockMode())
		{
			$this->addExportType('*/*/exportCsv', Mage::helper('extstock')->__('CSV'));
			//$this->addExportType('*/*/exportXml', Mage::helper('extstock')->__('XML'));
		}
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{

		return $this;
	}

	public function getThisUrl($action)
	{
		return 'extstock/adminhtml_extstock/'.$action;
	}
	
	/**
	 * Wichtig für Ajax
	 */ 
	public function getGridUrl()
    {
        return $this->getUrl('adminhtml/extstock_extstock/grid', array('_current'=>true));
    }

    //damit kann nicht auf die Zeile geklickt werden!
    //weil dort das popup nicht funktioniert
	public function getRowUrl($row)
	{
		
		//return "popWin('".$this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()))."', 'windth=800,height=700,resizable=1,scrollbars=1');return false;";
		
		if($this->_isStockMode())
		{
			return $this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()));
		}
		return "";
	}

	/**
	 * Feststellen ob das Grid von der Lagerverwaltung oder Produktverwaltung
	 * aufgerufen wurde
	 * @return boolean
	 */
	private function _isStockMode()
	{
		if($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode'))
		{
			if($mode == 'product') return false;
		}
		return true;
	}
}