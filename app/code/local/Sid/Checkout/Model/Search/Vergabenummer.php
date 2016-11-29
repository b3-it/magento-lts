<?php
/**
 * Klasse zur Suche von Vergabenummer.
 *
 * @category	Sid
 * @package		Sid_Checkout
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Checkout_Model_Search_Vergabenummer extends Varien_Object
{
	/**
	 * Vergabenummer laden
	 * 
	 * @return void
	 */
    public function load() {
        $arr = array();

        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        
        $collection = Mage::getResourceModel('sales/order_collection');
        $collection->getSelect()
        	->where("Vergabenummer like ?", '%'.$this->getQuery().'%');
        
//die($collection->getSelect()->__toString());
        foreach ($collection->getItems() as $order) {
            $arr[] = array(
                'id'            => 'order/1/'.$order->getId(),
                'type'          => 'Order',
                'name'          => Mage::helper('adminhtml')->__('Order #%s', $order->getIncrementId()),
                'description'   => 'Vergabenummer: '.$order->getVergabenummer(),
                'form_panel_title' => Mage::helper('adminhtml')->__('Order #%s (%s)', $order->getIncrementId(), $order->getBillingFirstname().' '.$order->getBillingLastname()),
                'url'           => Mage::helper('adminhtml')->getUrl('*/sales_order/view', array('order_id'=>$order->getId())),
            );
        }

        $this->setResults($arr);

        return $this;
    }

}

