<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name        b3it_mq_Adminhtml_Messagequeue_Queue_RulesetController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Adminhtml_Messagequeue_Queue_RulesetController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('queueruleset/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('QueueRuleset Manager'), Mage::helper('adminhtml')->__('QueueRuleset Manager'));
		$this->_title(Mage::helper('adminhtml')->__('QueueRuleset Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('b3it_mq/queue_ruleset')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('queueruleset_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('b3it_mq/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('b3it_mq/adminhtml_queue_ruleset_edit'))
				->_addLeft($this->getLayout()->createBlock('b3it_mq/adminhtml_queue_ruleset_edit_tabs'));

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
			$model = Mage::getModel('b3it_mq/queue_ruleset');
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
				$this->_saveRuleset($data, $model);
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
	
	
	protected function _saveRuleset($data, $ruleset)
	{
		if (empty($data)) {
			$data = array();
		}
		
		if(!isset($data['ruleset'])){
			return;
		}
	
		$data = $data['ruleset'];
		foreach($data as $key => $item)
		{	
			$model = Mage::getModel('b3it_mq/queue_rule');
			if(isset($item['id']) && !empty($item['id'])){
				$model->load($item['id']);
	
				if($item['deleted']  ){
					$model->delete();
					continue;
				}
			}else {
                unset($item['id']);
            }
			$model->setData($item);
			$model->setRulesetId($ruleset->getId());
			$model->save();
		}
	
	
	}
	
	

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('b3it_mq/queueruleset');

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
        $queuerulesetIds = $this->getRequest()->getParam('queueruleset_ids');
        if(!is_array($queuerulesetIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($queuerulesetIds as $queuerulesetId) {
                    $b3it_mq = Mage::getModel('b3it_mq/queue_ruleset')->load($queuerulesetId);
                    $b3it_mq->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($queuerulesetIds)
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
        $queuerulesetIds = $this->getRequest()->getParam('queueruleset_ids');
        if(!is_array($b3it_mqIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($queuerulesetIds as $queuerulesetId) {
                    $queueruleset = Mage::getSingleton('b3it_mq/queue_ruleset')
                        ->load($queuerulesetId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($queuerulesetIds))
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
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_queue_ruleset_grid')
            ->getCsv();

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportXmlAction()
    {
        $fileName   = $this->_getFileName('xml');
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_queue_ruleset_grid')
            ->getExcel($fileName);

        $this->_prepareDownloadResponse($fileName,$content);
    }

    public function exportExcelAction()
    {
        $fileName   = $this->_getFileName('xls');
        $content    = $this->getLayout()->createBlock('b3it_mq/adminhtml_queue_ruleset_grid')
            ->getXml();

         $this->_prepareDownloadResponse($fileName,$content);
    }

    protected function _getFileName($ext = "csv")
    {
    	  $fileName   = $this->__('queueruleset');
    	$fileName .= "_".date('Y-m-d') . ".".$ext;

    	return $fileName;
    }


  
}
