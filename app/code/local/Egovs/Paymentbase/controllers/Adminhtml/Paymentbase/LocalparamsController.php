<?php
/**
 * Controller für Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_LocalparamsController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init
	 * 
	 * @return Egovs_Paymentbase_Adminhtml_Paymentbase_LocalparamsController
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
	 * Edit Aktion
	 *
	 * @return void
	 */
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('paymentbase/localparams')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('localparams_data', $model);

			$this->_initAction();
			$this->_addBreadcrumb(Mage::helper('paymentbase')->__('user-defined ePayment Parameter'), Mage::helper('paymentbase')->__('user-defined ePayment Parameter'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('paymentbase/adminhtml_localparams_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Param does not exist'));
			$this->_redirect('*/*/');
		}
	}

	/**
	 * Neu Aktion
	 *
	 * @return void
	 */
	public function newAction() {

		$model  = Mage::getModel('paymentbase/localparams');//->load($id);

		Mage::register('localparams_data', $model);

		$this->loadLayout();
		$this->_setActiveMenu('paymentbase/items');

		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->_addContent($this->getLayout()->createBlock('paymentbase/adminhtml_localparams_new'));
		$this->renderLayout();
	}

	/**
	 * Erzeugen von mehreren Konfigurationszeilen
	 * 
	 * @return void
	 */
	public function createAction() {
		if ($data = $this->getRequest()->getPost()) {
				
			//ermitteln welche Bezahlmetoden verwendet werden sollen
			if (isset($data['all_payments'])) {
				$payments = array('all');
			} else {
				$payments = is_array($data['payment_methods']) ? $data['payment_methods'] : array('all');
			}
				
			//ermitteln welche Kundengruppen verwendet werden sollen
			if (isset($data['all_customer_groups'])) {
				$customergroups = array(-1);
			} else {
				$customergroups = is_array($data['customer_group_ids']) ? $data['customer_group_ids'] : array(-1);
			}
				
			//Alle Nullwerte müssen entfernt werden, sonst werden nicht die Defaults aus SQL-Setup genommen!
			foreach ($data as $key => $value) {
				if (!empty($value) || (is_numeric($value) && $value == 0)) {
					continue;
				}

				switch ($key) {
					case 'upper':
						//Der SQL DEFAULT wird nur beim ersten Speichern benutzt
						$data[$key] = 99999999.99;
						break;
				}
			}
			
			$data['lower'] = Mage::app()->getLocale()->getNumber($data['lower']);
			$data['upper'] = Mage::app()->getLocale()->getNumber($data['upper']);
			foreach ($customergroups as $group) {
				$data['customer_group_id'] = $group;
				
				foreach ($payments as $payment) {
					$data['payment_method']= $payment;
					$model = Mage::getModel('paymentbase/localparams');
					$model->setData($data)
						->save()
					;
					if (!$model->testDublicates()) {
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Params are overlapping!'));
					}
					if ($model->getUpper() <= $model->getLower()) {
						Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Check Range'));
						
					}
				}
			}

			$this->_redirect('*/*/');
			return;
		}
	}

	/**
	 * Speichern Aktion
	 *
	 * @return void
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
				
			//Alle Nullwerte müssen entfernt werden, sonst werden nicht die Defaults aus SQL-Setup genommen!
			foreach ($data as $key => $value) {
				if (!empty($value) || (is_numeric($value) && $value == 0)) {
					continue;
				}

				switch ($key) {
					case 'upper':
						//Der SQL DEFAULT wird nur beim ersten Speichern benutzt
						$data[$key] = 99999999.99;
						break;
				}
			}

			$data['lower'] = Mage::app()->getLocale()->getNumber($data['lower']);
			$data['upper'] = Mage::app()->getLocale()->getNumber($data['upper']);
			
			$model = Mage::getModel('paymentbase/localparams');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));
			
			if ($model->getUpper() <= $model->getLower()) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Check Range'));
				$this->_redirect('*/*/edit', array('id' => $model->getId()));
				return;
			}
				
			try {
				if ($model->getCreatedTime() == null || $model->getUpdateTime() == null) {
					$model->setCreatedTime(now())
					->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}

				$model->save();
				if ($model->testDublicates()) {
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('paymentbase')->__('Param was successfully saved'));
				} else {
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Params are overlapping!'));
				}
				
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
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('paymentbase')->__('Unable to find Param to save'));
		$this->_redirect('*/*/');
	}

	/**
	 * Löschen Aktion
	 *
	 * @return void
	 */
	public function deleteAction() {
		if ( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('paymentbase/localparams');
					
				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Param was successfully deleted'));
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
		$localparamsIds = $this->getRequest()->getParam('localparams');
		if (!is_array($localparamsIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($localparamsIds as $localparamsId) {
					$model = Mage::getModel('paymentbase/localparams')->load($localparamsId);
					$model->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
				Mage::helper('adminhtml')->__(
				'Total of %d record(s) were successfully deleted', count($localparamsIds)
				)
				);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

	/**
	 * Export CSV Aktion
	 *
	 * @return void
	 */
	public function exportCsvAction() {
		$fileName   = 'localparams.csv';
		$content    = $this->getLayout()->createBlock('paymentbase/adminhtml_localparams_grid')
		->getCsv();

		$this->_sendUploadResponse($fileName, $content);
	}

	/**
	 * Export XML Aktion
	 *
	 * @return void
	 */
	public function exportXmlAction() {
		$fileName   = 'localparams.xml';
		$content    = $this->getLayout()->createBlock('paymentbase/adminhtml_localparams_grid')
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
				return Mage::getSingleton('admin/session')->isAllowed('system/paymentparams/paymentparams2');
				break;
		}
	}
}