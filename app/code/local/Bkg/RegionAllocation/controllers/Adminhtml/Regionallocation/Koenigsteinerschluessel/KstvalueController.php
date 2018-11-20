<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name        Bkg_Regionallocation_Adminhtml_Regionallocation_Koenigsteinerschluessel_KstvalueController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Adminhtml_Regionallocation_Koenigsteinerschluessel_KstvalueController extends Mage_Adminhtml_Controller_action
{

	

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$kst_id = intval($this->getRequest()->getParam('kst_id',0));
		
		$model  = Mage::getModel('regionallocation/koenigsteinerschluessel_kstvalue')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}else{
				$model->setKstId($kst_id);
			}

			Mage::register('koenigsteinerschluesselkst_value_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('bkg_regionallocation/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('regionallocation/adminhtml_koenigsteinerschluessel_kst_edit_tab_kstvalue_edit'));
				

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('regionallocation')->__('Item does not exist'));
			$this->_redirect('*/regionallocation_koenigsteinerschluessel_kst/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('regionallocation/koenigsteinerschluessel_kstvalue');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));

			try {
				

				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('regionallocation')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				
				$this->_redirect('*/regionallocation_koenigsteinerschluessel_kst/edit',array('id'=>$model->getKstId()));
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('regionallocation')->__('Unable to find item to save'));
        $this->_redirect('*/regionallocation_koenigsteinerschluessel_kstvalue/edit',array('id'=>''));
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('regionallocation/koenigsteinerschluesselkstvalue');

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

   

    public function exportCsvAction()
    {
        $fileName   = 'koenigsteinerschluesselkst_value.csv';
        $content    = $this->getLayout()->createBlock('bkg_regionallocation/adminhtml_koenigsteinerschluessel_kstvalue_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'koenigsteinerschluesselkst_value.xml';
        $content    = $this->getLayout()->createBlock('bkg_regionallocation/adminhtml_koenigsteinerschluessel_kstvalue_grid')
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
