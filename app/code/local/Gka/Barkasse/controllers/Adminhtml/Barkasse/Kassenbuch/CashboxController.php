<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name        Gka_Barkasse_Adminhtml_Barkasse_Kassenbuch_CashboxController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Adminhtml_Barkasse_Kassenbuch_CashboxController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('gkabarkasse/cashbox')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('KassenbuchCashbox Manager'), Mage::helper('adminhtml')->__('KassenbuchCashbox Manager'));
		$this->_title(Mage::helper('adminhtml')->__('KassenbuchCashbox Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

            if($model->getId()) {
                $this->_storeIsolation($model->getStoreId());
            }

			Mage::register('kassenbuchcashbox_data', $model);
			$this->_initAction();
			

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_cashbox_edit'))
				->_addLeft($this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_cashbox_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('gka_barkasse/kassenbuch_cashbox');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			if($model->getId()) {
                $this->_storeIsolation($model->getStoreId());
            }

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				/** @var $customer Mage_Customer_Model_Customer */ 
				$customer = Mage::getModel('customer/customer')->load($model->getCustomerId());
				if($customer->getId())
				{
					$model->setCustomer($customer->getName());
				}
				
				
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gka_barkasse')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('gka_barkasse/kassenbuchcashbox');

                $model  = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->load($id);

                $this->_storeIsolation($model->getStoreId());
                $model->delete();

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
        $kassenbuchcashboxIds = $this->getRequest()->getParam('kassenbuchcashbox');
        if(!is_array($gka_barkasseIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($gka_barkasseIds as $gka_barkasseId) {
                    $gka_barkasse = Mage::getModel('gka_barkasse/kassenbuchcashbox')->load($gka_barkasseId);
                    $gka_barkasse->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($gka_barkasseIds)
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
        $kassenbuchcashboxIds = $this->getRequest()->getParam('kassenbuchcashbox');
        if(!is_array($gka_barkasseIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($kassenbuchcashboxIds as $kassenbuchcashboxId) {
                    $kassenbuchcashbox = Mage::getSingleton('gka_barkasse/kassenbuchcashbox')
                        ->load($gka_barkasseId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($gka_barkasseIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'kassenbuchcashbox.csv';
        $content    = $this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuchcashbox_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'kassenbuchcashbox.xml';
        $content    = $this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuchcashbox_grid')
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
    
    protected function _isAllowed()
    {
    	$res =  Mage::getSingleton('admin/session')->isAllowed('admin/gkabarkasse/gkabarkasse_kassenbuch_cashbox');
    	return $res;
    }


    protected function _storeIsolation($storeId)
    {
        if(Mage::helper('gka_barkasse')->isModuleEnabled('Egovs_Isolation'))
        {
            if (!Mage::helper('isolation')->getUserIsAdmin()) {
                $stores = Mage::helper('isolation')->getUserStoreViews();
                if (!in_array($storeId, $stores)) {
                    die(Mage::helper('isolation')->__('Denied'));
                }
            }
        }
    }

}
