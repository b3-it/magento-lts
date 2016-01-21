<?php
/**
 * Klasse zur Suche von Kassenzeichen.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Search_Kassenzeichen extends Varien_Object
{
	/**
	 * Kassenzeicheninformationen laden
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
        	->where("kassenzeichen like ?", '%'.$this->getQuery().'%')
        	->orwhere("saferpay_transaction_id like ?",'%'.$this->getQuery().'%');
//die($collection->getSelect()->__toString());
        foreach ($collection->getItems() as $order) {
            $arr[] = array(
                'id'            => 'order/1/'.$order->getParentId(),
                'type'          => 'Order',
                'name'          => Mage::helper('adminhtml')->__('Order #%s', $order->getIncrementId()),
                'description'   => trim($order->getKassenzeichen().' '.$order->getSaferpayTransactionId()),
                'form_panel_title' => Mage::helper('adminhtml')->__('Order #%s (%s)', $order->getIncrementId(), $order->getBillingFirstname().' '.$order->getBillingLastname()),
                'url'           => Mage::helper('adminhtml')->getUrl('*/sales_order/view', array('order_id'=>$order->getParentId())),
            );
        }

        $this->setResults($arr);

        return $this;
    }

}

