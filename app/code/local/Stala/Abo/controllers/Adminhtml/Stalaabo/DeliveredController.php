<?php

class Stala_Abo_Adminhtml_Stalaabo_DeliveredController extends Egovs_Base_Controller_Adminhtml_Abstract
{


	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('deliver/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_delivered'))
			->renderLayout();
	}


 	public function createInvoiceAction()
 	{
 		$this->createInvoice();
 	}
 	
 	public function createShippingInvoiceAction()
 	{
 		$this->createInvoice(true);
 	}


	public function createInvoice($shipping = false)
    {
        $deliverIds = $this->getRequest()->getParam('abo_deliver_id');
        if(!is_array($deliverIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else 
        {
            try {
	            $order = Mage::getModel('stalaabo/order');
	            $abo_orders = $order->setDeliverIds($deliverIds)
	            					->setPerShippingAddress($shipping)
	            	  				->createOrdersInvoices();	
	            $pdf = Mage::getModel('sales/order_pdf_invoice')->getPdf($abo_orders);	
	           
	         	if (count($abo_orders)>0) {
	                return $this->_prepareDownloadResponse('invoice'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(), 'application/pdf');
	            } else {
	                $this->_getSession()->addError($this->__('There are no printable documents related to selected orders'));
	                $this->_redirect('*/*/');
	            }
         	} 
         	catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
         $this->_redirect('*/*/index');
    }
	
    public function exportCsvAction()
    {
        $fileName   = 'deliver.csv';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_delivered_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'deliver.xml';
        $content    = $this->getLayout()->createBlock('stalaabo/adminhtml_delivered_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

	public function stornoAction() 
	{
		$id = $this->getRequest()->getParam('abo_delivered_id');
		if($id) 
		{
			try {
				$item = Mage::getModel('stalaabo/delivered')->addContractInfo()->load($id);
				$tmp = $item->getFreecopies();
				$item->setFreecopies('');
				$item->stornoShipping();

				if(strlen($tmp) > 0)
				{
					$freecopies = unserialize($tmp);
					if((is_array($freecopies)) && count($freecopies)> 0 )
					{
						$freecopy = Mage::getModel('extcustomer/freecopies');
						$freecopy->increaseFreecopies($freecopies, null, $item->getProductId(), $item->getCustomerId());
					}
				}
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully canceled'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());

			}
		}
		
		$this->_initAction()
				->_addContent($this->getLayout()->createBlock('stalaabo/adminhtml_delivered'))
				->renderLayout();
	}
 
	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('stalaabo/delivered');
				break;
		}
	}
}