<?php

class Slpb_Extstock_Controller_Adminhtml_Stockorder extends Mage_Adminhtml_Controller_Action
{
	protected $_StockOrderId = 0;
	
	
	
	
	
	protected function createStockOrder($instockid,$outstockid,$desired_date,$note)
	{
		$owner = Mage::getSingleton('admin/session')->getUser();
		$stockorder = Mage::getModel('extstock/stockorder');
		$stockorder->setDateOrdered(now());
  		$stockorder->setUser($owner->getName());
  		$stockorder->setInstockId(intval($instockid));
  		$stockorder->setOutstockId(intval($outstockid));
  		$stockorder->setDesiredDate($desired_date);
  		$stockorder->setNote($note);
		$stockorder->save();
		$this->_StockOrderId = $stockorder->getId();
		return $this->_StockOrderId;
	} 
	
}