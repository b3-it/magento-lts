<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name        b3it_mq_Adminhtml_Messagequeue_Email_QueueController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class b3it_mq_Adminhtml_Messagequeue_Email_QueueController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('emailqueue/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('EmailQueue Manager'), Mage::helper('adminhtml')->__('EmailQueue Manager'));
		$this->_title(Mage::helper('adminhtml')->__('EmailQueue Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('b3it_mq/email_queue')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('emailqueue_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('b3it_mq/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('b3it_mq/adminhtml_email_queue_edit'))
				->_addLeft($this->getLayout()->createBlock('b3it_mq/adminhtml_email_queue_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_mq')->__('Item does not exist'));
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


			$model = Mage::getModel('b3it_mq/email_queue');
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('b3it_mq')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_mq')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('b3it_mq/emailqueue');

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
        $emailqueueIds = $this->getRequest()->getParam('emailqueue_ids');
        if(!is_array($emailqueueIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($emailqueueIds as $emailqueueId) {
                    $b3it_mq = Mage::getModel('b3it_mq/email_queue')->load($emailqueueId);
                    $b3it_mq->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($emailqueueIds)
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
        $emailqueueIds = $this->getRequest()->getParam('emailqueue_ids');
        if(!is_array($b3it_mqIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($emailqueueIds as $emailqueueId) {
                    $emailqueue = Mage::getSingleton('b3it_mq/email_queue')
                        ->load($emailqueueId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($emailqueueIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = $this->_getFileName('csv');
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_email_queue_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->_getFileName('xml');
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_email_queue_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportExcelAction()
    {
        $fileName   = $this->_getFileName('xls');
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_email_queue_grid')
            ->getXml();

         $this->_prepareDownloadResponse($fileName,$content);
    }

    protected function _getFileName($ext = "csv")
    {
    	  $fileName   = $this->__('emailqueue');
    	$fileName .= "_".date('Y-m-d') . ".".$ext;

    	return $fileName;
    }


  
}
