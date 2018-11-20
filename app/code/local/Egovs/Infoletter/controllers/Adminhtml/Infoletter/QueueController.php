<?php
/**
 * Egovs Infoletter
 *
 *
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Adminhtml_QueueController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Adminhtml_Infoletter_QueueController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('newsletter/infoletter_queue')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Newsletter'), Mage::helper('adminhtml')->__('Infoletter'))
            ->_title( Mage::helper('adminhtml')->__('Infoletter'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('infoletter/queue')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('queue_data', $model);

			$this->_initAction();

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('infoletter/adminhtml_queue_edit'))
				->_addLeft($this->getLayout()->createBlock('infoletter/adminhtml_queue_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('infoletter')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function sendAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('infoletter/queue')->load($id);
	
		if ($model->getId() || $id == 0) {
			if($model->getStatus() == Egovs_Infoletter_Model_Status::STATUS_NEW)
			{
				$model->setStatus(Egovs_Infoletter_Model_Status::STATUS_SENDING)->save();
			}
			else if($model->getStatus() == Egovs_Infoletter_Model_Status::STATUS_SENDING) 
			{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('infoletter')->__('Quote can not be send!'));
			}
			else if($model->getStatus() == Egovs_Infoletter_Model_Status::STATUS_FINISHED)
			{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('infoletter')->__('Quote has been send!'));
			}
			$this->_redirect('*/*/');
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('infoletter')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			

			$model = Mage::getModel('infoletter/queue');
			
			foreach($data as $k => $v)
			{
				if(empty($v))
				{
					unset($data[$k]);
				}
			}
			
			if(isset($data['status'])){
				$data['status'] = intval($data['status']);
			}else{
				$data['status'] = Egovs_Infoletter_Model_Status::STATUS_NEW;
			}
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('infoletter')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('infoletter')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('infoletter/queue');

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

   


    public function previewAction ()
    {
        //$this->_setTitle();
        $this->loadLayout();

        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('infoletter/queue')->load($id);
       
        $this->getLayout()->getBlock('preview_form')->setFormData($model);
        $this->renderLayout();
    }
    
    public function massDeleteRecipientAction() {
    	$blocksIds = $this->getRequest()->getParam('recipients');
    	if(!is_array($blocksIds)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    	} else {
    		try {
    			foreach ($blocksIds as $blocksId) {
    				$pdftemplate = Mage::getModel('infoletter/recipient')->load($blocksId);
    				$pdftemplate->delete();
    			}
    			Mage::getSingleton('adminhtml/session')->addSuccess(
    					Mage::helper('adminhtml')->__(
    							'Total of %d record(s) were successfully deleted', count($blocksIds)
    					)
    			);
    		} catch (Exception $e) {
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		}
    	}
    	$this->_redirect('adminhtml/infoletter_queue/edit', array('id' => $this->getRequest()->getParam('id')));
    }

    public function recipientsgridAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('infoletter/queue')->load($id);
    	Mage::register('queue_data', $model);
    	
    	
    	$this->loadLayout(false);
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('infoletter/adminhtml_queue_edit_tab_recipients_grid')->toHtml()
    	);
    }
    
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('newsletter/infoletter_queue');
    }
    
}
