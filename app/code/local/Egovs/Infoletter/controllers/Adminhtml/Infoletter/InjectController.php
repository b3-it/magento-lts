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
			->where('entity_id IN ('.$Ids.')');
			foreach($collection->getItems() as $item)
			{
				$custommers[$item->getCustomerEmail()] = $item->getCustomerName();
			}
			 
			$res = $this->_addEmailToQueue(intval($issue), $custommers);
			Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
		}
		$this->_redirect('adminhtml/sales_order/');
	}
	
	public function massaction4customersAction()
	{
		$Ids = $this->getRequest()->getPost('customer');
		$issue = $this->getRequest()->getPost('queue_id');
		
		
		$custommers = array();
		if($Ids && is_array($Ids) && $issue)
		{
			$Ids = implode(',', $Ids);
			$collection = Mage::getModel('customer/customer')->getCollection();
			$collection->getSelect()
			->where('entity_id IN ('.$Ids.')');
			foreach($collection->getItems() as $item)
			{
				$custommers[$item->getEmail()] = $item->getName();
			}
			 
			$res = $this->_addEmailToQueue(intval($issue), $custommers);
			Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
		}
		$this->_redirect('adminhtml/customer/');
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
			$collection->getSelect()->where("message_id=".$queue->getId());
			$exiting = array();
			foreach ($collection->getItems() as $recipient)
			{
				$exiting[] = $recipient->getEmail();
			}
			
			foreach ($emails as $email => $name)
			{
				if(!array_search($email, $exiting))
				{
					$recipient =  Mage::getModel('infoletter/recipient'); 
					$recipient->setEmail($email);
					$recipient->setName($name);
					$recipient->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_UNSEND);
					$recipient->setMessageId($queue->getId());
					$recipient->save();
					$res++;
				}
			}
			
		}
		
		return $res;
	}
	
}