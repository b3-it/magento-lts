<?php

class Egovs_Base_Block_Adminhtml_Tools_Analyse_Sales_Order_Item_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_taxRules = null;

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_item_collection';
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        
       	$collection->getSelect()
       	->join(array('order'=>'sales_flat_order'),'main_table.order_id = order.entity_id',array('increment_id'=>'increment_id','orderstatus'=>'status'));
       	//->join(array('quote_adr'=>'sales_flat_quote_address'),'main_table.quote_id=quote_adr.quote_id AND length(applied_taxes) > 8',array('applied_taxes'=>'applied_taxes'));
        
        //die($collection->getSelect()->__toString());
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

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));
        
        $this->addColumn('type',
        		array(
        				'header'=> Mage::helper('catalog')->__('Type'),
        				'width' => '150px',
        				'index' => 'product_type',
        				'type'  => 'options',
        				'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        		));
        

        $this->addColumn('sku', array(
        		'header' => Mage::helper('egovsbase')->__('sku'),
        		'index' => 'sku',
        		//'width' => '100px',
        ));
        
        $this->addColumn('name', array(
        		'header' => Mage::helper('egovsbase')->__('Name'),
        		'index' => 'name',
        		//'width' => '100px',
        ));
        
        $this->addColumn('qty_ordered', array(
        		'header' => Mage::helper('egovsbase')->__('Qty'),
        		'index' => 'qty_ordered',
        		'width' => '100px',
        ));
  
        
        $this->addColumn('price', array(
        		'header' => Mage::helper('egovsbase')->__('Einzelpreis'),
        		'index' => 'price',
        		'width' => '100px',
        ));
        
        $this->addColumn('tax_percent', array(
        		'header' => Mage::helper('egovsbase')->__('Tax Percent'),
        		'index' => 'tax_percent',
        		'width' => '100px',
        ));
        
        $this->addColumn('tax_amount', array(
        		'header' => Mage::helper('egovsbase')->__('Tax Amount'),
        		'index' => 'tax_amount',
        		'width' => '100px',
        ));
        
        $this->addColumn('base_row_total_incl_tax', array(
        		'header' => Mage::helper('egovsbase')->__('Row Total'),
        		'index' => 'base_row_total_incl_tax',
        		'width' => '100px',
        ));
        

        /*
        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));

        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
        ));
*/
        /*
        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

*/       

        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'orderstatus',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));

        
        //$this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        //$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    
  

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    
}
