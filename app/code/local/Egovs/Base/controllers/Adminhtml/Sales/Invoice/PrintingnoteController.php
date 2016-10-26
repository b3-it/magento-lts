<?php

class Egovs_Base_Adminhtml_Sales_Invoice_PrintingnoteController extends Mage_Adminhtml_Controller_Action
{

	
	public function saveAction() {
		
		$id     = $this->getRequest()->getParam('order_id');
		$model  = Mage::getModel('sales/order')->load($id);

		if ($model->getId()) 
		{
			$model->setData('printnote1', $this->getRequest()->getParam('printnote1'));
			$model->setData('printnote2', $this->getRequest()->getParam('printnote2'));
			$model->save();	
		}
 
	}
	
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/printingnote');
	}
}