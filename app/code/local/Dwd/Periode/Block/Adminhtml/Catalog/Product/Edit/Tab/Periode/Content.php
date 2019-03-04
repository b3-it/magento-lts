<?php

class Dwd_Periode_Block_Adminhtml_Catalog_Product_Edit_Tab_Periode_Content extends Mage_Adminhtml_Block_Widget
{
    private $_attributes = null;
	  private $_productInstance = null;

    public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
        $this->setTemplate('dwd/periode/catalog/product/tab/periode/content.phtml');
        $this->setId('periode_content');
    }

    public function getItems()
    {
    	$collection = Mage::getModel('periode/periode')->getCollection();
    	$collection->getSelect()->where('product_id=?', intval($this->getProductId()));
    	$store_id = $this->getStoreId();
    	if ($store_id){
    		$collection->setStoreId($store_id);
    	}
    	return $collection->getItems();
    }

    private function getProductId()
    {
    	if($this->getData('product_id')!= null)
    	{
    		return $this->getData('product_id');
    	}

    	$product = Mage::registry('product');
    	if($product)
    	{
    		return $product->getId();
    	}
    	return 0;
    }
    
    private function getStoreId()
    {
    	if($this->getData('store_id')!= null)
    	{
    		return $this->getData('store_id');
    	}
    	$product = $this->getProduct();
    	if($product){
    		$store = $product->getStore();
    		if($store){
    			return $store->getId();
    		}
    	}
    	
    	return 0;
    }

    public function getDeleteButtonHtml($id,$product_id)
    {

            $block = $this->getLayout()->createBlock('adminhtml/widget_button')
                          ->setData(array(
                                'label'   => Mage::helper('catalog')->__('Delete Row'),
                                'class'   => 'delete delete-select-row icon-btn',
                                'id'      => 'delete_periode_row_button',
                                'onclick' => "deletePeriodData($id,$product_id)"
                            ));

        return $block->toHtml();
    }

    public function getPeriodeTypeLabel($value)
    {
    	return Dwd_Periode_Model_Periode_Type::getOptionLabel($value);
    }

    public function getPeriodeUnitLabel($value)
    {
    	return Dwd_Periode_Model_Periode_Unit::getOptionLabel($value);
    }

    public function isPeriodeTypeDuration($value)
    {

    	return ($value == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION);
    }

    public function isPeriodeTypeDurationAbo($value)
    {

    	return ($value == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO);
    }

    public function formatPeriodeDate($value)
    {
    	return parent::formatDate($value,Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

    }

    public function getProduct()
    {
    	if (!$this->_productInstance) {
    		if ($product = Mage::registry('product')) {
    			$this->_productInstance = $product;
    		} else {
    			$this->_productInstance = Mage::getModel('catalog/product')->load($this->getProductId());
    		}
    	}

    	return $this->_productInstance;
    }

    public function getProductHasAboOption()
    {
    	return $this->getProduct()->getTypeId() == 'configvirtual';
    }

    public function getPrice($item)
    {

    	  $res = array();
    	  $tp = $item->getTierPrices();

    	  $res[] = "+ ". Mage::helper('core')->currency($item->getPrice(), true, false);
    	  if( count($tp->getItems()) )
    	  {
              /** @noinspection SuspiciousLoopInspection */
    	      foreach( $tp->getItems() AS $item )
    	      {

    	          $res[] = $item->getQty() . ' <small class="nobr">' . Mage::helper("catalog")->__("and above") .
    	                   '</small>  : ' . Mage::helper('core')->currency($item->getPrice(), true, false);
    	      }           
    	  }
    	  return implode('<br />', $res );
    }

    public function getJSONTierPrice($item)
    {

    	$tp = $item->getTierPrices();

    	if(count($tp->getItems()) )
    	{
    		$res = array();

            /** @noinspection SuspiciousLoopInspection */
    		foreach( $tp->getItems() AS $item )
    		{
    			$res[] = array($item->getQty(), $item->getPrice());
    		}

    	}

    	return  json_encode($res);
    }
    
    public function isAboEnabled()
    {
    	return (Mage::helper('periode')->isModuleEnabled('Dwd_Abo'));
    }
    
    public function getAboCount($periode)
    {
    	if($this->isAboEnabled())
    	{
    		$collection = Mage::getModel('dwd_abo/abo')->getCollection();
    		$collection->getSelect()
    			->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id=main_table.first_orderitem_id AND order_item.period_id='.intval($periode->getId()),array())
    			->where('main_table.status='. Dwd_Abo_Model_Status::STATUS_ACTIVE);
    		
    		return count($collection->getItems());
    		
    	}
    	return "";
    }

}
