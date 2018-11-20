<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name        Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_GeorefentityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Adminhtml_Virtualgeo_Components_GeorefController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('componentsgeoref_entity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('ComponentsGeoref_entity Manager'), Mage::helper('adminhtml')->__('ComponentsGeoref_entity Manager'));
		$this->_title(Mage::helper('adminhtml')->__('ComponentsGeoref_entity Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$store_id     =  intval($this->getRequest()->getParam('store'));
		$model  = Mage::getModel('virtualgeo/components_georef')
			->setStoreId($store_id)
			->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('componentsgeoref_entity_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('virtualgeo/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$ssw = $this->getLayout()->createBlock('adminhtml/store_switcher');
			//$ssw->setUseConfirm(0);
			
			$this->_addContent($this->getLayout()->createBlock('virtualgeo/adminhtml_components_georef_edit'))
				->_addLeft($ssw)
			;

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualgeo')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$store_id     =  intval($this->getRequest()->getParam('store'));
			

			$model = Mage::getModel('virtualgeo/components_georef');
			$model->setData($data)
				->setStoreId($store_id)
				->setId($this->getRequest()->getParam('id'));

			try {
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualgeo')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('virtualgeo')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('virtualgeo/components_georef');

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
        $componentsgeoref_entityIds = $this->getRequest()->getParam('componentsgeoref_entity_ids');
        if(!is_array($componentsgeoref_entityIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($componentsgeoref_entityIds as $componentsgeoref_entityId) {
                    $virtualgeo = Mage::getModel('virtualgeo/components_georefentity')->load($componentsgeoref_entityId);
                    $virtualgeo->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($componentsgeoref_entityIds)
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
        $componentsgeoref_entityIds = $this->getRequest()->getParam('componentsgeoref_entity_ids');
        if(!is_array($componentsgeoref_entityIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($componentsgeoref_entityIds as $componentsgeoref_entityId) {
                    $componentsgeoref_entity = Mage::getSingleton('virtualgeo/components_georefentity')
                        ->load($componentsgeoref_entityId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($componentsgeoref_entityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'componentsgeoref_entity.csv';
        $content    = $this->getLayout()->createBlock('virtualgeo/adminhtml_components_georefentity_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'componentsgeoref_entity.xml';
        $content    = $this->getLayout()->createBlock('virtualgeo/adminhtml_components_georefentity_grid')
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
