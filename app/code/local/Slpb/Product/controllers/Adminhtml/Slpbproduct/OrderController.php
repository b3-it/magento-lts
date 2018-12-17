<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders controller
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Product_Adminhtml_Slpbproduct_OrderController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var array
     */
    protected $_publicActions = array('view');

    /**
     * Additional initialization
     *
     */
    protected function _construct()
    {
        $this->setUsedModuleName('Mage_Sales');
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return Mage_Adminhtml_Sales_OrderController
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('sales/order')
            ->_addBreadcrumb($this->__('Sales'), $this->__('Sales'))
            ->_addBreadcrumb($this->__('Orders'), $this->__('Orders'));
        return $this;
    }

    /**
     * Initialize order model instance
     *
     * @return Mage_Sales_Model_Order || false
     */
    protected function _initOrder()
    {
        $id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order')->load($id);

        if (!$order->getId()) {
            $this->_getSession()->addError($this->__('This order no longer exists.'));
            $this->_redirect('*/*/');
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return false;
        }
        Mage::register('sales_order', $order);
        Mage::register('current_order', $order);
        return $order;
    }

    /**
     * Orders grid
     */
    public function indexAction()
    {
        $this->_initAction()
            ->_addContent($this->getLayout()->createBlock('slpbproduct/order'))
            ->renderLayout();
    }

    /**
     * Order grid
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('slpbproduct/order_grid')->toHtml()
        );
    }

    /**
     * View order detale
     */
    public function viewAction()
    {
        if ($order = $this->_initOrder()) {
            $this->_initAction()
                ->renderLayout();
        }
    }

    /**
     * Cancel order
     */
    public function cancelAction()
    {
        if ($order = $this->_initOrder()) {
            try {
                $order->cancel()
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

 
   public function pdflabelAction()
   {
       $orderIds = $this->getRequest()->getPost('order_ids');
       $adresses = array();
       if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $adr=$order->getShippingAddress();
                $adresses[] = $adr;
            }
                    
                $pdf = Mage::getModel('slpbshipping/pdf_addresslabel')->getPdf($adresses);
                    
                return $this->_prepareDownloadResponse('addresslabel'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
          
            }
           
        
        $this->_redirect('*/*/');
    }

    public function pdfshipmentsAction(){
        $orderIds = $this->getRequest()->getPost('order_ids');
        
        $flag = false;
        if (!empty($orderIds)) {
            $_pages = [[]];
            foreach ($orderIds as $orderId) {
                $order = Mage::getModel('sales/order')->load($orderId);
                $shipments = Mage::getResourceModel('sales/order_shipment_collection')
                    ->addAttributeToSelect('*')
                    ->setOrderFilter($orderId)
                    ->load();
                if (!$shipments->getSize())
                {
                	$shipment = $this->getShippment($order);
                	$shipments->addItem($shipment);
                }
                if (count($shipments->getItems())!= 0) {
                    $flag = true;
                    if (!isset($pdf)){
                        $pdf = Mage::getModel('sales/order_pdf_shipment')->getPdf($shipments);
                    } else {
                        $pages = Mage::getModel('sales/order_pdf_shipment')->getPdf($shipments);
                        $_pages[] = $pages->pages;
                    }
                }
            }
            if (version_compare(PHP_VERSION, '5.6', '>=')) {
                $_pages = array_merge(...$_pages);
            } else {
                /* PHP below 5.6 */
                $_pages = call_user_func_array('array_merge', $_pages);
            }
            $pdf->pages = array_merge ($pdf->pages, $_pages);
            if ($flag) {
                return $this->_prepareDownloadResponse('packingslip'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
            } else {
                $this->_getSession()->addError($this->__('There are no printable documents related to selected orders'));
                $this->_redirect('*/*/');
            }
        }
        $this->_redirect('*/*/');
    }

 

   private function getShippment($order)
    {
        try {
            if ($shipment = $this->_initShipment($order)) {
                $shipment->register();

                /*
                $comment = '';
                if (!empty($data['comment_text'])) {
                    $shipment->addComment($data['comment_text'], isset($data['comment_customer_notify']));
                    $comment = $data['comment_text'];
                }

                if (!empty($data['send_email'])) {
                    $shipment->setEmailSent(true);
                }
				*/
                $this->_saveShipment($shipment);
                //$shipment->sendEmail(!empty($data['send_email']), $comment);
                //$this->_getSession()->addSuccess($this->__('Shipment was successfully created.'));
                //$this->_redirect('*/sales_order/view', array('order_id' => $shipment->getOrderId()));
                return $shipment;
            }
        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addError($this->__('Can not save shipment.'));
        }
		return null;
    }
    
    protected function _initShipment($order)
    {
       
            
            /**
             * Check order existing
             */
            if (!$order->getId()) {
                $this->_getSession()->addError($this->__('Order not longer exist.'));
                return false;
            }
            /**
             * Check shipment is available to create separate from invoice
             */
            if ($order->getForcedDoShipmentWithInvoice()) {
                $this->_getSession()->addError($this->__('Can not do shipment for order separate from invoice.'));
                return false;
            }
            /**
             * Check shipment create availability
             */
            if (!$order->canShip()) {
                $this->_getSession()->addError($this->__('Can not do shipment for order.'));
                return false;
            }

            $convertor  = Mage::getModel('sales/convert_order');
            $shipment    = $convertor->toShipment($order);
            //$savedQtys = $this->_getItemQtys();
            foreach ($order->getAllItems() as $orderItem) {
                if (!$orderItem->isDummy(true) && !$orderItem->getQtyToShip()) {
                    continue;
                }
                /*
                if ($orderItem->isDummy(true) && !$this->_needToAddDummy($orderItem, $savedQtys)) {
                    continue;
                }
                */
                if ($orderItem->getIsVirtual()) {
                    continue;
                }
                $item = $convertor->itemToShipmentItem($orderItem);
                /*
                if (isset($savedQtys[$orderItem->getId()])) {
                    if ($savedQtys[$orderItem->getId()] > 0) {
                        $qty = $savedQtys[$orderItem->getId()];
                    } else {
                        continue;
                    }
                }
                else {*/
                    if ($orderItem->isDummy(true)) {
                        $qty = 1;
                    } else {
                        $qty = $orderItem->getQtyToShip();
                    }
                //}
                $item->setQty($qty);
                $shipment->addItem($item);
            }
            /*
            if ($tracks = $this->getRequest()->getPost('tracking')) {
                foreach ($tracks as $data) {
                    $track = Mage::getModel('sales/order_shipment_track')
                    ->addData($data);
                    $shipment->addTrack($track);
                }
            }
            */
        

       // Mage::register('current_shipment', $shipment);
        return $shipment;
    }

    protected function _saveShipment($shipment)
    {
        $shipment->getOrder()->setIsInProcess(true);
        $transactionSave = Mage::getModel('core/resource_transaction')
            ->addObject($shipment)
            ->addObject($shipment->getOrder())
            ->save();

        return $this;
    }
    

    protected function _isAllowed()
    {
        if ($this->getRequest()->getActionName() == 'view') {
            return Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view');
        }
        return (Mage::getSingleton('admin/session')->isAllowed('sales/order') || Mage::getSingleton('admin/session')->isAllowed('sales/extstockorderlist'));
    }
    

}