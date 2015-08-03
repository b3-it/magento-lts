<?php
require_once "Mage/Adminhtml/controllers/Sales/OrderController.php";

/**
 * Adminhtml Sales Order controller
 * 
 * Wird nur noch für die Aktion "Rückläufer" im Slpb benötigt
 *
 * @category   	Egovs
 * @package    	Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Sales_OrderController
 */
class Egovs_Extsalesorder_Adminhtml_Sales_OrderController extends Mage_Adminhtml_Sales_OrderController
{
	/**
	 * Slpb Rückläufer-Action
	 * 
	 * @return void
	 */
	public function speccancelAction() {
        if ($order = $this->_initOrder()) {
            try {
                $order->cancel(true)
                    ->save();
                $this->_getSession()->addSuccess(
                    $this->__('Order was successfully cancelled.')
                );
            }
            catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addError($this->__('Order was not cancelled.'));
            }
            $this->_redirect('*/sales_order/view', array('order_id' => $order->getId()));
        }
    }
    
    /**
     * Slpb Spezial-Storno (Rückläufer)
     * 
     * Erstellt den entsprechenden Block für den Rücklauf.
     * 
     * @return void
     * 
     */
    public function speccreditmemosAction() {
    	$this->_initOrder();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('extsalesorder/adminhtml_sales_order_view_tab_creditmemos')->toHtml()
        );
    }
}