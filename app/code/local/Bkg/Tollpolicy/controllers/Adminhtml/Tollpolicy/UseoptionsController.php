<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name        Bkg_Tollpolicy_Adminhtml_Tollpolicy_UseoptionsentityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Adminhtml_Tollpolicy_UseoptionsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('use_options_entity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Type of Use Options Manager'), Mage::helper('adminhtml')->__('Type of Use Options Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Type of Use Options Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('bkg_tollpolicy/useoptions')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('use_options_entity_data', $model);

			$this->_initAction();
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$ssw = $this->getLayout()->createBlock('adminhtml/store_switcher');
			$this->_addContent($this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_useoptions_edit'))
				->_addLeft($this->getLayout()->createBlock($ssw));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_tollpolicy')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$store_id     =  intval($this->getRequest()->getParam('store'));

			$model = Mage::getModel('bkg_tollpolicy/useoptions');
			$model->setData($data)
			->setStoreId($store_id)
				->setId($this->getRequest()->getParam('id'));

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkg_tollpolicy')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}

				$this->_redirect('*/tollpolicy_usetype/edit',array('id' => $model->getUseTypeId() ));
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_tollpolicy')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_tollpolicy/useoptions')->load(intval($this->getRequest()->getParam('id')));

				$model->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/tollpolicy_usetype/edit',array('id' => $model->getUseTypeId()));
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $use_options_entityIds = $this->getRequest()->getParam('use_options_entity_ids');
        if(!is_array($use_options_entityIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($use_options_entityIds as $use_options_entityId) {
                    $bkg_tollpolicy = Mage::getModel('bkg_tollpolicy/useoptions')->load($use_options_entityId);
                    $bkg_tollpolicy->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($use_options_entityIds)
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
        $use_options_entityIds = $this->getRequest()->getParam('use_options_entity_ids');
        if(!is_array($bkg_tollpolicyIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($use_options_entityIds as $use_options_entityId) {
                    $use_options_entity = Mage::getSingleton('bkg_tollpolicy/useoptions')
                        ->load($use_options_entityId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($use_options_entityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'use_options_entity.csv';
        $content    = $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_useoptions_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'use_options_entity.xml';
        $content    = $this->getLayout()->createBlock('bkg_tollpolicy/adminhtml_useoptions_grid')
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
