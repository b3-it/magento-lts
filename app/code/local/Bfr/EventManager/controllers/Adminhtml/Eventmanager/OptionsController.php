<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Adminhtml_EventController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Adminhtml_Eventmanager_OptionsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bfr_eventmanager/eventmanager_options')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_title(Mage::helper('eventmanager')->__('Event Options'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('eventmanager/event')->load($id);

		if ($model->getId() || $id == 0) {


			Mage::register('event_data', $model);

			$this->_initAction();


			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('eventmanager/adminhtml_options_list'));
//				->_addLeft($this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}




    



    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('bfr_eventmanager/eventmanager_event');
    }
}
