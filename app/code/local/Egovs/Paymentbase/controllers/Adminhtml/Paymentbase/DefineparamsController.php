<?php
/**
 * Controller zum Anlegen von Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_DefineparamsController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init
	 *
	 * @return Egovs_Paymentbase_Adminhtml_Paymentbase_DefineparamsController
	 */
	protected function _initAction() {
		$this->loadLayout();
		$this->_setActiveMenu('system');
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('System'), Mage::helper('adminhtml')->__('System'));
		$this->_addBreadcrumb(Mage::helper('paymentbase')->__('ePayment Parameter'), Mage::helper('paymentbase')->__('ePayment Parameter'));
		
		return $this;
	}
 
	/**
	 * Standard Aktion
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	/**
	 * Bearbeiten Aktion
	 *
	 * @return void
	 */
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('paymentbase/defineparams')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('defineparams_data', $model);

			$this->_initAction();

			$this->_addBreadcrumb(Mage::helper('paymentbase')->__('Define ePayment Parameter'), Mage::helper('paymentbase')->__('Define ePayment Parameter'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	/**
	 * Neu Aktion
	 *
	 * @return void
	 */
	public function newAction() {
		$this->_forward('edit');
	}
 
	/**
	 * Speichern Aktion
	 *
	 * @return void
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			
	  			
			$model = Mage::getModel('paymentbase/defineparams')->load($this->getRequest()->getParam('id'));	
			$model->setData($data);
			
			try {
				if ($model->getCreatedTime == null || $model->getUpdateTime() == null) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	/**
	 * Lösch Aktion
	 *
	 * @return void
	 */
	public function deleteAction() {
		if ( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('paymentbase/defineparams');
				 
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

	/**
	 * Massen-Lösch Aktion
	 *
	 * @return void
	 */
    public function massDeleteAction() {
        $defineparamsIds = $this->getRequest()->getParam('defineparams');
        if (!is_array($paymentbaseIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($paymentbaseIds as $paymentbaseId) {
                    $paymentbase = Mage::getModel('paymentbase/defineparams')->load($paymentbaseId);
                    $paymentbase->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($paymentbaseIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    /**
     * Massen-Status Aktion
     *
     * @return void
     */
    public function massStatusAction() {
        $defineparamsIds = $this->getRequest()->getParam('defineparams');
        if (!is_array($paymentbaseIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($defineparamsIds as $defineparamsId) {
                    $defineparams = Mage::getSingleton('paymentbase/defineparams')
                        ->load($paymentbaseId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($paymentbaseIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    /**
     * Export CSV Aktion
     *
     * @return void
     */
    public function exportCsvAction()
    {
        $fileName   = 'defineparams.csv';
        $content    = $this->getLayout()->createBlock('paymentbase/adminhtml_defineparams_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Export XML Aktion
     *
     * @return void
     */
    public function exportXmlAction()
    {
        $fileName   = 'defineparams.xml';
        $content    = $this->getLayout()->createBlock('paymentbase/adminhtml_defineparams_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Response für Upload erzeugen
     *
     * Endet mit die
     *
     * @param string $fileName    Dateiname
     * @param string $content     Inhalt
     * @param string $contentType Type
     *
     * @return void
     */
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream') {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
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
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('system/paymentparams/definepaymentparams');
    			break;
    	}
    }
}