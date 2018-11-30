<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name        B3it_Subscription_Adminhtml_Subscription_PeriodController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Adminhtml_Subscription_PeriodController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('componentsformat_entity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Period_entity Manager'), Mage::helper('adminhtml')->__('Period Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Period Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$store_id     =  intval($this->getRequest()->getParam('store'));
		$model  = Mage::getModel('b3it_subscription/period')
			->setStoreId($store_id)
			->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('entity_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('b3it_subscription/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$ssw = $this->getLayout()->createBlock('adminhtml/store_switcher');
			//$ssw->setUseConfirm(0);
			$this->_addContent($this->getLayout()->createBlock('b3it_subscription/adminhtml_period_edit'))
				//->_addLeft($ssw)
			;

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_subscription')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$store_id     =  intval($this->getRequest()->getParam('store'));

			$model = Mage::getModel('b3it_subscription/period');
			$model->setData($data)
				->setStoreId($store_id)
				->setId($this->getRequest()->getParam('id'));

			try {
				

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('b3it_subscription')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('b3it_subscription')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('b3it_subscription/period');

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
        $componentsformat_entityIds = $this->getRequest()->getParam('componentsformat_entity_ids');
        if(!is_array($componentsformat_entityIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($componentsformat_entityIds as $componentsformat_entityId) {
                    $b3it_subscription = Mage::getModel('b3it_subscription/periodentity')->load($componentsformat_entityId);
                    $b3it_subscription->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($componentsformat_entityIds)
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
        $componentsformat_entityIds = $this->getRequest()->getParam('componentsformat_entity_ids');
        if(!is_array($componentsformat_entityIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($componentsformat_entityIds as $componentsformat_entityId) {
                    $componentsformat_entity = Mage::getSingleton('b3it_subscription/periodentity')
                        ->load($componentsformat_entityId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($componentsformat_entityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'componentsformat_entity.csv';
        $content    = $this->getLayout()->createBlock('b3it_subscription/adminhtml_period_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'componentsformat_entity.xml';
        $content    = $this->getLayout()->createBlock('b3it_subscription/adminhtml_period_grid')
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
