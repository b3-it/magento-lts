<?php

class Egovs_Extstock_Block_Adminhtml_Extstock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

	protected $_product = null;
	protected $_product_id = null;
	protected $_distributor = null;
	
	public function __construct($attributes)
	{
		parent::__construct();
		$this->setId('extstockGrid');
		$this->setDefaultSort('date_ordered');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
		if(isset( $attributes['extstock_product']))
			$this->_product = $attributes['extstock_product'];
		$product_id = $this->getRequest()->getParam('id');
		$distributor = $this->getRequest()->getParam('distributor');	

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
		$this->setCollection($collection);

		//$productid = Mage::getSingleton('adminhtml/session')->getData('extstockproduct'); 
		$productid = intval($this->_product_id);
		if(!$this->_isStockMode())
		{
			if (!is_null($productid)) {
				$collection->getSelect()->where("product_id = ?", $productid);
			} else {
				$collection->getSelect()->where("product_id IS NULL");
			}
		} else {
			//Wichtig für Redirect von extstocklist mit Filterung!!
			if (!is_null($this->_product_id)) {
				$collection->getSelect()->where("product_id = ?", $this->_product_id);
			}
			if (!is_null($this->_distributor)) {
				//Leerzeichen Rückcodieren #371
				$this->_distributor = str_ireplace("%20", " ", $this->_distributor);
				$collection->getSelect()->where("`distributor` like ?",$this->_distributor);
			}
		}	
		
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
			$this->addColumn('extstock_product', array(
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
			  'filter_condition_callback' => array($this, '_filterBestellwertCondition'),
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
		
		if(!$this->_isStockMode())
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
					
	                        'url'       => array('base'=> 'adminhtml/extstock_extstock/edit_product'),
	                        'field'     => 'id',
	                    	'popup'		=> '1'
	                    	//'onclick'  => 'superProduct.createPopup({$action['href']});return false;'
			);
		}
		else
		{
			$actions =  array(
                        'caption'   => Mage::helper('extstock')->__('Edit'),
                        'url'       => array('base'=> 'adminhtml/extstock_extstock/edit'),
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
/*
	public function getThisUrl($action)
	{
		return 'adminhtml/extstock_extstock/'.$action;
	}
	*/
	protected function _filterBestellwertCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
	
		$condition = '(quantity_ordered * price) = ?';
		$collection->getSelect()->where($condition, $value);
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
				
		if($this->_isStockMode())
		{
			return $this->getUrl('adminhtml/extstock_extstock/edit',array('id' =>$row->getId()));
		}
		
		return "";
	}

	/**
	 * Feststellen ob das Grid von der Lagerverwaltung oder Produktverwaltung
	 * aufgerufen wurde
	 * @return boolean
	 */
	protected function _isStockMode()
	{
		return !$this->getExtstockproductmode();
	}
}