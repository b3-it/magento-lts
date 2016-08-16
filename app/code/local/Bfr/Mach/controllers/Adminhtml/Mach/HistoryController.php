<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Adminhtml_HistoryController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Adminhtml_Mach_HistoryController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('history/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

    
    public function exportAction()
    {
    	$orderIds = $this->getRequest()->getParam('order_id');
    	if(!is_array($orderIds)) {
    		Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    	} else {
    			$model = Mage::getModel('bfr_mach/export');
    		try {
    			
    			$model->saveData($orderIds);
    			
    		} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    			$this->_redirect('*/*/index');
    		}
    		
    	}
    	$this->_redirect('*/mach_download/index', array('lauf' => $model->getLauf()));
    }
    

}
