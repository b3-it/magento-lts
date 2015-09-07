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
			->_setActiveMenu('queue/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

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

			$this->loadLayout();
			$this->_setActiveMenu('infoletter/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

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

			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {
					/* Starting upload */
					$uploader = new Varien_File_Uploader('filename');

					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);

					// Set the file upload mode
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);

					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );

				} catch (Exception $e) {

		        }

		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}


			$model = Mage::getModel('infoletter/queue');
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

    public function massDeleteAction() {
        $queueIds = $this->getRequest()->getParam('queue');
        if(!is_array($infoletterIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($infoletterIds as $infoletterId) {
                    $infoletter = Mage::getModel('infoletter/queue')->load($infoletterId);
                    $infoletter->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($infoletterIds)
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
        $queueIds = $this->getRequest()->getParam('queue');
        if(!is_array($infoletterIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($queueIds as $queueId) {
                    $queue = Mage::getSingleton('infoletter/queue')
                        ->load($infoletterId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($infoletterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'queue.csv';
        $content    = $this->getLayout()->createBlock('infoletter/adminhtml_queue_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'queue.xml';
        $content    = $this->getLayout()->createBlock('infoletter/adminhtml_queue_grid')
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
}
