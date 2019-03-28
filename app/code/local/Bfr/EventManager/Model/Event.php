<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Event
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Event extends Mage_Core_Model_Abstract
{
	private $_product = null;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/event');
    }
    
    
    public function getProduct()
    {
    	if($this->_product == null)
    	{
    		if($this->getProductId()){
    			$this->_product = Mage::getModel('catalog/product')->load($this->getProductId());
    		}
    	}
    	
    	return $this->_product;
    }

    public function getSignatureImage()
    {
        return Mage::helper('eventmanager')->getSignaturePath() . DS . $this->getSignatureFilename();
    }


    public function removeIndividualoptions()
    {
        $product = $this->getProduct();
        if($product){
            $order_items = Mage::getModel('sales/order_item')->getCollection();
            $order_items->getSelect()->where('product_id=?',(int)$product->getId());
            foreach($order_items as $item){
                $this->_removeIndividalOption($item);
            }


            $res = $this->getResource();
            $res->removeQuoteItemOptions((int)$product->getId());
        }
    }



    protected function _removeIndividalOption($item)
    {
        if( $item instanceof Mage_Sales_Model_Order_Item)
        {
            $product_options =  $item->getProductOptions();
            if($product_options) {
                //$product_options = unserialize($product_options);

                if (isset($product_options['info_buyRequest']['options'])) {
                    unset($product_options['info_buyRequest']['options']);
                    if (isset($product_options['options'])) {
                        unset($product_options['options']);
                    }
                    //$product_options = serialize($product_options);
                    $item->setProductOptions($product_options)
                         ->save();
                }
            }
        }
    }

    
}
