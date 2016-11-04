<?php

class Egovs_Infoletter_Adminhtml_Infoletter_InjectController extends Mage_Adminhtml_Controller_action
{
	public function massaction4ordersAction()
	{
		$Ids = $this->getRequest()->getPost('order_ids');
		$issue = $this->getRequest()->getPost('queue_id');
		 
		if($Ids && is_array($Ids) && $issue)
		{
			$Ids = implode(',', $Ids);
			$custommers = array();
	
			$collection = Mage::getModel('sales/order')->getCollection();
			$collection->getSelect()
			->where('entity_id IN (?)',$Ids);
			foreach($collection->getItems() as $item)
			{
				//$custommers[$item->getCustomerId()] = $item->getCustomerId();
				$custommers[$item->getCustomerEmail()] = array('prefix'=>$item->getCustomerPrefix(),
						'firstname'=>$item->getCustomerFirstname(),
						'lastname'=>$item->getCustomerLastname(),
						'company'=>$item->getCustomerCompany());
			}
			 
			$res = $this->_addEmailToQueue(intval($issue), $custommers);
			Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
		}
		$this->_redirect('adminhtml/sales_order/');
	}
	
	
	public function massaction4orderitemsAction()
	{
		$Ids = $this->getRequest()->getPost('orderitems_ids');
		$queueId = $this->getRequest()->getPost('queue_id');
			
		if($Ids && is_array($Ids) && $queueId)
		{
			$Ids = implode(',', $Ids);
			$custommers = array();
	
			$collection = Mage::getModel('sales/order_item')->getCollection();
			$collection->getSelect()
			->join(array('order'=>$collection->getTable('sales/order')),'order.entity_id=main_table.order_id',array('customer_email','customer_company','customer_firstname','customer_lastname','customer_prefix'))
			->group('order.entity_id')
			->where('main_table.item_id IN ('.$Ids.')');
			foreach($collection->getItems() as $item)
			{
				$custommers[$item->getCustomerEmail()] = array('prefix'=>$item->getCustomerPrefix(),
						'firstname'=>$item->getCustomerFirstname(),
						'lastname'=>$item->getCustomerLastname(),
						'company'=>$item->getCustomerCompany());
			}
		
			$res = $this->_addEmailToQueue(intval($queueId), $custommers);
			Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
		}
		$this->_redirect('adminhtml/egovsbase_tools_analyse_sales_order_item');
	}
	
	public function massaction4customersAction()
	{
		$Ids = $this->getRequest()->getPost('customer');
		$issue = $this->getRequest()->getPost('queue_id');
		
		$this->_addCustomerToQueue($issue,$Ids);
		
		$this->_redirect('adminhtml/customer/');
	}
	
	
	
	private function _addCustomerToQueue($queueId,$customerIds)
	{
		$custommers = array();
		
		$Ids = $customerIds;
		if($customerIds && is_array($customerIds))
		{
			$Ids = implode(',', $customerIds);
		}
		
		
		if($Ids && $queueId)
		{
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection
			->addAttributeToSelect('firstname')
			->addAttributeToSelect('lastname')
			->addAttributeToSelect('prefix')
			->addAttributeToSelect('company')
			->getSelect()
			->where('e.entity_id IN ('.$Ids.')');
			foreach($collection->getItems() as $item)
			{
				$custommers[$item->getEmail()] = array('prefix'=>$item->getPrefix(),
						'firstname'=>$item->getFirstname(),
						'lastname'=>$item->getLastname(),
						'company'=>$item->getCompany());
			}
		
			$res = $this->_addEmailToQueue(intval($queueId), $custommers);
			Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
		}
	}
	
	
	/**
	 * Speichern der Empfänger
	 * @param int $queueId
	 * @param array $emails
	 * @return number
	 */
	private function _addEmailToQueue($queueId, $emails)
	{
		$res = 0;
		$queue =  Mage::getModel('infoletter/queue')->load($queueId);
		if($queue && ($queue->getStatus() ==  Egovs_Infoletter_Model_Status::STATUS_NEW))
		{
			$collection = Mage::getModel('infoletter/recipient')->getCollection();
			$collection->getSelect()->where("message_id=?", intval($queue->getId()));
			$exiting = array();
			foreach ($collection->getItems() as $recipient)
			{
				$exiting[] = $recipient->getEmail();
			}
			
			foreach ($emails as $email => $data)
			{
				if(!in_array($email, $exiting))
				{
					$recipient =  Mage::getModel('infoletter/recipient'); 
					$recipient->setData($data);
					$recipient->setEmail($email);
					$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_UNSEND);
					$recipient->setMessageId($queue->getId());
					$recipient->save();
					$res++;
				}
			}
			
		}
		
		return $res;
	}
	
	protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('newsletter/infoletter_queue');
    }
}