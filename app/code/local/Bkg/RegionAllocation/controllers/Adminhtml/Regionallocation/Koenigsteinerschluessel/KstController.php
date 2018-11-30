<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name        Bkg_Regionallocation_Adminhtml_Regionallocation_Koenigsteinerschluessel_KstController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Adminhtml_Regionallocation_Koenigsteinerschluessel_KstController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('koenigsteinerschluesselkst/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('KoenigsteinerschluesselKst Manager'), Mage::helper('adminhtml')->__('KoenigsteinerschluesselKst Manager'));
		$this->_title(Mage::helper('adminhtml')->__('KoenigsteinerschluesselKst Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('regionallocation/koenigsteinerschluessel_kst')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('koenigsteinerschluesselkst_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('bkg_regionallocation/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('regionallocation/adminhtml_koenigsteinerschluessel_kst_edit'))
				->_addLeft($this->getLayout()->createBlock('regionallocation/adminhtml_koenigsteinerschluessel_kst_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('regionallocation')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

		


			$model = Mage::getModel('regionallocation/koenigsteinerschluessel_kst');
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('regionallocation')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_regionallocation')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_regionallocation/koenigsteinerschluesselkst');

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
        $koenigsteinerschluesselkstIds = $this->getRequest()->getParam('koenigsteinerschluesselkst_ids');
        if(!is_array($koenigsteinerschluesselkstIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($koenigsteinerschluesselkstIds as $koenigsteinerschluesselkstId) {
                    $bkg_regionallocation = Mage::getModel('bkg_regionallocation/koenigsteinerschluessel_kst')->load($koenigsteinerschluesselkstId);
                    $bkg_regionallocation->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($koenigsteinerschluesselkstIds)
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
        $koenigsteinerschluesselkstIds = $this->getRequest()->getParam('koenigsteinerschluesselkst_ids');
        if(!is_array($bkg_regionallocationIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($koenigsteinerschluesselkstIds as $koenigsteinerschluesselkstId) {
                    $koenigsteinerschluesselkst = Mage::getSingleton('bkg_regionallocation/koenigsteinerschluessel_kst')
                        ->load($koenigsteinerschluesselkstId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($koenigsteinerschluesselkstIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'koenigsteinerschluesselkst.csv';
        $content    = $this->getLayout()->createBlock('bkg_regionallocation/adminhtml_koenigsteinerschluessel_kst_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'koenigsteinerschluesselkst.xml';
        $content    = $this->getLayout()->createBlock('bkg_regionallocation/adminhtml_koenigsteinerschluessel_kst_grid')
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
