<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Adminhtml_ParticipantController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Adminhtml_EventManager_ParticipantController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bfr_eventmanager/eventmanager_participant')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('eventmanager/participant')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			$eventId = intval($this->getRequest()->getParam('event'));
			if($eventId > 0){
				$model->setBackEvent($eventId);
			}
			Mage::register('participant_data', $model);

			$this->_initAction();

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('eventmanager/adminhtml_participant_edit'))
				->_addLeft($this->getLayout()->createBlock('eventmanager/adminhtml_participant_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}


    public function massStatusParticipantCopyAction()
    {
        $participantIds = $this->getRequest()->getParam('participant');
        $new_event = $this->getRequest()->getParam('new_event');
        if(!is_array($participantIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else if(!$new_event) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Event'));

        } else {
            try {
                foreach($participantIds as $participantId){
                    $participant = Mage::getModel('eventmanager/participant')->load($participantId);
                    $clone = $participant->copy();
                    $clone->setEventId($new_event)->save();
                }

                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were copied', count($participantIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index',array('_current'=>true));
    }

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('eventmanager/participant');
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('eventmanager')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				$eventId = intval($model->getBackEvent());
				
				if ($this->getRequest()->getParam('back')) {
					if($eventId > 0){
						$this->_redirect('*/*/edit', array('id' => $model->getId(),'event'=>$eventId));
						return;
					}else{
						$this->_redirect('*/*/edit', array('id' => $model->getId()));
						return;
					}
				}
				
				if($eventId > 0){
					$this->_redirect('*/eventmanager_event/edit',array(
    					'id'  => $eventId,
    					'active_tab'=> 'participants_section'
    					));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('eventmanager/participant');

				$model->setId($this->getRequest()->getParam('id'))
					->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$eventId = intval($model->getBackEvent());
				
				if($eventId > 0){
					$this->_redirect('*/eventmanager_event/edit',array(
							'id'  => $eventId,
							'active_tab'=> 'participants_section'
					));
					return;
				}
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $participantIds = $this->getRequest()->getParam('participant');
        if(!is_array($participantIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($participantIds as $eventmanagerId) {
                    $eventmanager = Mage::getModel('eventmanager/participant')->load($eventmanagerId);
                    $eventmanager->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($participantIds)
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
        $participantIds = $this->getRequest()->getParam('participant');
        if(!is_array($participantIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
            	Bfr_EventManager_Model_Participant::changeStatus($participantIds, $this->getRequest()->getParam('status'));
                
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($participantIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'participant.csv';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_participant_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'participant.xml';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_participant_grid')
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
    
    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('bfr_eventmanager/eventmanager_participant');
    }
}
