<?php
/**
 * Klasse zur Suche von Sepa Mandaten.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Search_Sepa extends Varien_Object
{
	/**
	 * Sepamandate laden
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
        	->join(array('payment'=>'sales_flat_order_payment'), 'payment.parent_id=main_table.entity_id')
        	->where("sepa_mandate_id like ?",'%'.$this->getQuery().'%');
//die($collection->getSelect()->__toString());
        foreach ($collection->getItems() as $order) {
            $arr[] = array(
                'id'            => 'order/1/'.$order->getParentId(),
                'type'          => Mage::helper('adminhtml')->__('Order'),
                'name'          => Mage::helper('adminhtml')->__('Order #%s', $order->getIncrementId()),
                'description'   => $order->getSepaMandateId(),
                'form_panel_title' => Mage::helper('adminhtml')->__('Order #%s (%s)', $order->getIncrementId(), $order->getBillingFirstname().' '.$order->getBillingLastname()),
                'url'           => Mage::helper('adminhtml')->getUrl('*/sales_order/view', array('order_id'=>$order->getParentId())),
            );
        }

        
        /* @var $collection Egovs_Paymentbase_Model_Mysql4_Sepa_Mandate_History_Collection */
        $collection = Mage::getResourceModel('paymentbase/sepa_mandate_history_collection');
        $collection->getSelect()
        ->join(array('customer'=>'customer_entity'), 'customer.entity_id=main_table.customer_id',array('email'))
        ->distinct()
        ->where("sepa_mandate_id like ?",'%'.$this->getQuery().'%');
        //die($collection->getSelect()->__toString());
        foreach ($collection->getItems() as $history) {
        	$arr[] = array(
        			'id'            => 'customer/'.$history->getCustomerId(),
        			'type'          => Mage::helper('adminhtml')->__('Customer'),
        			'name'          => $history->getEmail(),
        			'description'   => $history->getSepaMandateId(),
        			'form_panel_title' =>"Title",// Mage::helper('adminhtml')->__('Order #%s (%s)', $order->getIncrementId(), $order->getBillingFirstname().' '.$order->getBillingLastname()),
        			'url'           => Mage::helper('adminhtml')->getUrl('*/customer/edit', array('id'=>$history->getCustomerId())),
        	);
        }
        
        
        
        
        
        
        $this->setResults($arr);

        return $this;
    }

}

