<?php
/**
 * Adminhtml sales invoice grid
 * 
 * Da erst der Invoice Controller den Block für das Grid erstellt, ist ein Update über Layouts
 * nicht möglich (Die entsprechende Funktion wird schon vor createBlock(..) aufgerufen).
 * 
 * <strong>Die Methode über Layouts ist zu bevorzugen, falls verfügbar!</strong>
 * 
 * Es gäbe noch die Variante über Events, folgende Events kommen in Frage:
 * <ul>
 * 	<li>core_layout_block_create_after - Columns dürfen noch nicht vorhanden sein!</li>
 * </ul>
 * 
 * Die Variante über Events dürfte langsamer sein!
 * 
 * @category   	Egovs
 * @package    	Egovs_Extsalesorder
 * @name       	Egovs_Paymentbase_Block_Noinfo
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Controller_Sales_Invoice
 */

class Egovs_Extsalesorder_Block_Adminhtml_Sales_Invoice_Grid extends Mage_Adminhtml_Block_Sales_Invoice_Grid
{
	protected function _prepareColumns() {
		//Die anderen Spalten dürfen noch nicht vorhanden sein!
		$this->addColumnAfter('kassenzeichen', array(
				'header'    => Mage::helper('paymentbase')->__('Kassenzeichen #'),
				'index'     => 'kassenzeichen',
				'type'      => 'text',
				),
				'increment_id'
		);
		$this->addColumnAfter('billing_company', array(
				'header'    => Mage::helper('extsalesorder')->__('Billing Company'),
				'index'     => 'billing_company',
				'type'      => 'text',
				),
				'order_created_at'
		);
		$this->addColumnAfter('billing_address', array(
				'header'    => Mage::helper('extsalesorder')->__('Billing Address'),
				'index'     => 'billing_address',
				'type'      => 'text',
				),
				'billing_name'
		);
		$this->addColumnAfter('payment_method', array(
				'header'    => Mage::helper('sales')->__('Payment Method'),
				'index'     => 'payment_method',
				'type'      => 'options',
				'width'     => '130px',
				'options'   => Mage::helper('paymentbase')->getActivePaymentMethods(),
				),
				'billing_address'
		);
		
		return parent::_prepareColumns();
	}
}