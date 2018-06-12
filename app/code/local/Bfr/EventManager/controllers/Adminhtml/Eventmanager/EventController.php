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
class Bfr_EventManager_Adminhtml_EventManager_EventController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bfr_eventmanager/eventmanager_event')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

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
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('event_data', $model);

			$this->_initAction();


			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('eventmanager/adminhtml_event_edit'))
				->_addLeft($this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('eventmanager/event');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

				
			$collection = Mage::getModel('eventmanager/event')->getCollection();
			$collection->getSelect()
				->where('event_id <>'.intval($model->getId()))
				->where('product_id ='.intval($model->getProductId()));
			if(count($collection->getItems()) > 0)
			{	
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('EventBundle is already used.'));
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
			}
				
				
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('eventmanager/event');

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
        $eventIds = $this->getRequest()->getParam('event');
        if(!is_array($eventmanagerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($eventmanagerIds as $eventmanagerId) {
                    $eventmanager = Mage::getModel('eventmanager/event')->load($eventmanagerId);
                    $eventmanager->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($eventmanagerIds)
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
        $eventIds = $this->getRequest()->getParam('event');
        if(!is_array($eventmanagerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($eventIds as $eventId) {
                    $event = Mage::getSingleton('eventmanager/event')
                        ->load($eventmanagerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($eventmanagerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massInfoletterAction()
    {

        $Ids = $this->getRequest()->getPost('participant');
        $queueId = $this->getRequest()->getPost('queue_id');

        if($Ids && is_array($Ids) && $queueId)
        {

            $custommers = array();

            $collection = Mage::getModel('eventmanager/participant')->getCollection();
            $collection->getSelect()
                ->where("main_table.participant_id IN (?)", $Ids);
            foreach($collection->getItems() as $item)
            {
                $custommers[$item->getEmail()] = array('prefix'=>$item->getPrefix(),
                    'firstname'=>$item->getFirstname(),
                    'lastname'=>$item->getLastname(),
                    'company'=>trim($item->getCompany(). " ".$item->getCompany2(). " ".$item->getCompany3())
                );
            }

            $res = Mage::getModel('infoletter/queue')->load($queueId)->addEmailToQueue($custommers);
            Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
        }
        $this->_redirect('adminhtml/eventmanager_event/edit',array('id'=>$this->getRequest()->getParam('id')));
    }

    public function exportCsvAction()
    {
        $fileName   = 'event.csv';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'event.xml';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }
    
    
    public function exportparticipantsCsvAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	 
    	$fileName   = 'participants.csv';
    	$content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_participants')
    	->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportparticipantsXmlAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	 
    	$fileName   = 'participants.xml';
    	$content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_participants')
    	->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    
    
    public function exportcustomeroptionsCsvAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	$fileName   = 'customeroptions.csv';
    	$content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_customeroptions')
    	->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportcustomeroptionsXmlAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	$fileName   = 'customeroptions.xml';
    	$content    = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_customeroptions')
    	->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportoptionsCsvAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	$option = Mage::getModel('bundle/option')->load(intval($this->getRequest()->getParam('optionId')));
    	 
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_options','',array('option'=>$option));
    	
    	$fileName   = 'options.csv';
    	$content    = $block->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportoptionsXmlAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	$option = Mage::getModel('bundle/option')->load(intval($this->getRequest()->getParam('optionId')));
    	
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_options','',array('option'=>$option));
    	
    	$fileName   = 'options.xml';
    	$content    = $block->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
    }

    
    public function exportAllCsvAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	   
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_export','');
    	 
    	$fileName   = 'eventAll.csv';
    	$content    = $block->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportAllXmlAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	 
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_export','');
    	 
    	$fileName   = 'eventAll.xml';
    	$content    = $block->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    
    public function optionsgridAction() {
    	
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	$option = Mage::getModel('bundle/option')->load(intval($this->getRequest()->getParam('optionId')));
	
    	$this->loadLayout();
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_options','',array('option'=>$option));
    	
    	$this->getResponse()->setBody($block->toHtml());

    }
    
    public function exportgridAction() {
    	 
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	 
    	
    	$this->loadLayout();
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_export','');
    	 
    	$this->getResponse()->setBody($block->toHtml());
    
    }
    
    public function participantsgridAction() {
    	
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	
    	$this->loadLayout();
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_participants');    	 
    	$this->getResponse()->setBody($block->toHtml());
    
    }
    
    public function customeroptionsgridAction() {
    	 
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('eventmanager/event')->load(intval($id));
    	Mage::register('event_data', $model);
    	 
    	$this->loadLayout();
    	$block = $this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tab_customeroptions');
    	$this->getResponse()->setBody($block->toHtml());
    
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
    
    /**
     * Massenaktion für die Telnehmerliste innerhalb der Veranstaltungverwaltung
     */
    public function massStatusParticipantAction()
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
    	$this->_redirect('*/*/edit',array('_current'=>true, 'active_tab'=> 'participants_section'));
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
        $this->_redirect('*/*/edit',array('_current'=>true, 'active_tab'=> 'participants_section'));
    }



    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('bfr_eventmanager/eventmanager_event');
    }
}
