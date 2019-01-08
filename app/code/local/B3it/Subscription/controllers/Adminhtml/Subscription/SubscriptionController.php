<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Adminhtml_SubscriptionController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Adminhtml_Subscription_SubscriptionController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('subscription/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = intval($this->getRequest()->getParam('id'));
		
		
		$collection = Mage::getModel('b3it_subscription/subscription')->getCollection();
		$collection->getSelect()
		->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id = main_table.current_orderitem_id')
		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.current_order_id',array('order_increment_id'=>'increment_id'))
		->join(array('customer'=>'customer_entity'),'order.customer_id=customer.entity_id',array('email'=>'email'))
		->joinleft(array('stationen'=>'stationen_entity'),'stationen.entity_id=orderitem.station_id',array('stationskennung'=>'stationskennung'))
		->where('subscription_id='.$id)
		;
		
		$items = $collection->getItems();
		if(count($items) > 0 )
		{
			$model = array_shift($items);
		}
		else{
			$model  = Mage::getModel('b3it_subscription/subscription')->load($id);
		}
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			
			
				
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('subscription_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('b3it_subscription/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('b3it_subscription/adminhtml_subscription_edit'))
				->_addLeft($this->getLayout()->createBlock('b3it_subscription/adminhtml_subscription_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_subscription')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			
	  			
			$model = Mage::getModel('b3it_subscription/subscription')->load($this->getRequest()->getParam('id'));
			
			if (isset($data['cancelation_period_end'])) {
				$data['cancelation_period_end'] = Mage::getModel('core/date')->gmtDate(null, Varien_Date::toTimestamp($data['cancelation_period_end']));
			}
				
			
			
			$notUse = array('start_date','stop_date');
			foreach($data as $k=>$v)
			{	
				if(!in_array($k,$notUse))
				{
					$model->setData($k,$v);
				}
			}
			
			
			
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				
				
				if(($model->getStatus() == B3it_Subscription_Model_Status::STATUS_CANCELED) && (isset($data['sendcancelmail']))){
					$this->sendCancelEmail($model);
				}
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('b3it_subscription')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_subscription')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('b3it_subscription/subscription');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $subscriptionIds = $this->getRequest()->getParam('b3it_subscription');
        if(!is_array($subscriptionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($subscriptionIds as $subscriptionId) {
                    $subscription = Mage::getModel('subscription/subscription')->load($subscriptionId);
                    $subscription->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($subscriptionIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $subscriptionIds = $this->getRequest()->getParam('b3it_subscription');
        if(!is_array($subscriptionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($subscriptionIds as $subscriptionId) {
                    $subscription = Mage::getSingleton('b3it_subscription/subscription')
                        ->load($subscriptionId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($subscriptionIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'subscription.csv';
        $content    = $this->getLayout()->createBlock('subscription/adminhtml_subscription_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'subscription.xml';
        $content    = $this->getLayout()->createBlock('subscription/adminhtml_subscription_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    
    
    private function sendCancelEmail($subscription)
    {
    	 	
    	$data=array();
    	 
    	$orderitem = Mage::getModel('sales/order_item')->load($subscription->getCurrentOrderitemId());
    	$data['item'] = $subscription;
    	$data['order'] = Mage::getModel('sales/order')->load($subscription->getFirstOrderId());
    	$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
    	$data['station'] = Mage::getModel('stationen/stationen')->load($orderitem->getStationId());
    	$customer = Mage::getModel('customer/customer')->load($data['order']->getCustomerId());
    	    	
    	Mage::helper('b3it_subscription')->sendEmail($customer->getEmail(), $customer, $data, 'b3it_subscription/email/cancel_subscription_template');
    }
    
    
    public function collectAction() {
    	B3it_Subscription_Model_Cron::collect();
    	$this->_initAction()
    	->renderLayout();
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	$fullAction = strtolower($this->getRequest()->getRequestedRouteName());
    	switch ($action) {
    		default:
    			//Es kann nicht zwischen Verkäufs- und direkten Subscriptionmenü unterschieden werden --> selber Controlleraufruf!
    			return Mage::getSingleton('admin/session')->isAllowed('sales/b3it_subscription') || Mage::getSingleton('admin/session')->isAllowed('b3it_subscription');
    			break;
    	}
    }
}