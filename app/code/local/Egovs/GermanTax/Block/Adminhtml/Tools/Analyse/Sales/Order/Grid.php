<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Block_Adminhtml_Tools_Analyse_Sales_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_taxRules = null;
	private $_customerClass = null;
	private $_customerGroup = null;

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
        return 'sales/order_collection';
    }

    protected function _prepareCollection()
    {
    	    	
    	
    	
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
        
       	$collection->getSelect()
       	//->join(array('quote'=>'sales_flat_quote'),'main_table.entity_id = quote.order_id',array())
       	->join(array('quote_adr'=>'sales_flat_quote_address'),'main_table.quote_id=quote_adr.quote_id AND length(applied_taxes) > 8',array('applied_taxes'=>'applied_taxes'));
        
       
        
       	
       	$collection->getSelect()
       		->joinleft(array('shipping_adr'=>'sales_flat_order_address'),"main_table.entity_id=shipping_adr.parent_id AND if(is_virtual = 0,shipping_adr.address_type = 'shipping', shipping_adr.address_type = 'base_address')",
       				array('shipping_name'=>"concat_ws(' ', shipping_adr.firstname,shipping_adr.lastname, shipping_adr.company, shipping_adr.country_id, shipping_adr.taxvat)"))
       		->joinleft(array('base_adr'=>'sales_flat_order_address'),"main_table.entity_id=base_adr.parent_id AND base_adr.address_type = 'base_address'"
       				,array('base_name'=>"concat_ws(' ', base_adr.firstname,base_adr.lastname, base_adr.company, base_adr.country_id, base_adr.taxvat)"));
       	
       	
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
        	'filter_index' => 'main_table.created_at'
        ));
        


        $this->addColumn('shipping_name', array(
        		'header'    => Mage::helper('germantax')->__('Leistungsempfänger'),
        		'align'     =>'left',
        		'width'     => '150px',
        		'index'     => 'shipping_name',
        		'filter_condition_callback' => array($this, '_filterShippingNameCondition'),
        ));
        
    
        

        
        $this->addColumn('base_name', array(
        		'header'    => Mage::helper('germantax')->__('Stammadresse'),
        		'align'     =>'left',
        		'width'     => '150px',
        		'index'     => 'base_name',
        		'filter_condition_callback' => array($this, '_filterBaseNameCondition'),
        ));
        
        
  
        
        
        $this->addColumn('tax_rule', array(
        		'header' => Mage::helper('germantax')->__('Steuerregel'),
        		'index' => 'tax_rule',
        		'filter' =>false,
        		'sort' =>false,
        		//'width' => '100px',
        ));
        
        $this->addColumn('customer_tax_class', array(
        		'header' => Mage::helper('germantax')->__('Steuerregel Kundengruppe'),
        		'index' => 'customer_tax_class',
        		'filter' =>false,
        		'sort' =>false,
        		'width' => '150px',
        ));

        
        $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
        $opt = array();
        foreach ($yn as $n)
        {
        	$opt[$n['value']] = $n['label'];
        }
        
        $this->addColumn('is_virtual', array(
        		'header' => Mage::helper('sales')->__('Virtuel'),
        		'index' => 'is_virtual',
        		'type'    => 'options',
        		'width' =>60,
        		'options' =>$opt
        		
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

        
        //$this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        //$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        //$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * FilterIndex Shipping Name
     *
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     *
     * @return void
     */
    protected function _filterShippingNameCondition($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    	$table = $collection->getTable("sales/order");
    	$condition = "(concat_ws(' ', shipping_adr.firstname,shipping_adr.lastname, shipping_adr.company, shipping_adr.country_id, shipping_adr.taxvat) like ?";
    	$collection->getSelect()->where($condition, "%$value%");
    }
    
    /**
     * FilterIndex Base Name
     *
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     *
     * @return void
     */
    protected function _filterBaseNameCondition($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    	$table = $collection->getTable("sales/order");
    	$condition = "concat_ws(' ', base_adr.firstname,base_adr.lastname, base_adr.company, base_adr.country_id, base_adr.taxvat) like ?";
    	$collection->getSelect()->where($condition, "%$value%");
    }
    
    protected function _afterLoadCollection()
    {
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$applied_taxes = $item->getData('applied_taxes');
    		if(strlen($applied_taxes) > 0)
    		{
    			$applied_taxes = unserialize($applied_taxes);
    			$rule = "";
    			foreach ($applied_taxes as $applied_tax)
    			{
    				foreach ($applied_tax['rates'] as $tax)
    				{
    					//foreach ($tax as $taxrule)
    					{
    						$rule.= $this->_getTaxRuleTitle($tax['rule_id']).", ";
    					}
    				}
    				
    			}
    			
    			$item->setTaxRule($rule);

    			
    			$customerTaxGroup = $this->_getCustomerTaxClassTitle($this->_getCustomerGroup($item->getCustomerGroupId())->getTaxClassId());
    		 	$item->setCustomerTaxClass($customerTaxGroup);
    				
    		}
    		
    		
    	}
    }
    
    

    public function xxgetRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('*/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    
    private function _getTaxRuleTitle($id)
    {
    	if($this->_taxRules == null)
    	{
    		$this->_taxRules = Mage::getModel('tax/calculation_rule')->getCollection();
    	}
    	foreach ($this->_taxRules->getItems() as $rule)
    	{
    		if($rule->getId() == $id)
    		{
    			return $rule->getCode();
    		}
    	}
    	return "";
    }
    
    private function _getCustomerGroup($id)
    {
    	if($this->_customerGroup == null)
    	{
    		$this->_customerGroup = Mage::getModel('customer/group')->getCollection();
    	}
    	foreach ($this->_customerGroup->getItems() as $class)
    	{
    		if($class->getId() == $id)
    		{
    			return $class;
    		}
    	}
    	return null;
    }
    
    private function _getCustomerTaxClassTitle($id)
    {
    	if($this->_customerClass == null)
    	{
    		$this->_customerClass = Mage::getModel('tax/class')->getCollection();
    	}
    	foreach ($this->_customerClass->getItems() as $class)
    	{
    		if(($class->getId() == $id) && ($class->getClassType() == Mage_Tax_Model_Class::TAX_CLASS_TYPE_CUSTOMER))
    		{
    			return $class->getClassName();
    		}
    	}
    	return "";
    }
}
