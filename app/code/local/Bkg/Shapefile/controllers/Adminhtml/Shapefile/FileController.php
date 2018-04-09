<?php
/**
 *
* @category   	Bkg Shapefile
* @package    	Bkg_Shapefile
* @name         Bkg_Shapefile_Adminhtml_Shapefile_FileController
* @author 		Holger Kögel <h.koegel@b3-it.de>
* @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*/

class Bkg_Shapefile_Adminhtml_Shapefile_FileController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout();
		//->_setActiveMenu('serviceservice/items')
		//->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		//$this->_title(Mage::helper('adminhtml')->__('Items Manager'));
		//var_dump($this->getLayout());
		//die();
		return $this;
	}

	public function indexAction() {
	    
		$this->_initAction()
		->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		/**
		 * @var Bkg_Shapefile_Model_File $model
		 */
		$model  = Mage::getModel('bkg_shapefile/file')->load($id);
		
		Mage::register('shapefile_data', $model);
		
		$this->_initAction()
		->renderLayout();
	}

	public function newAction() {
		$this->_initAction()
		->renderLayout();
	}


	public function updateAction() {
	    if (!$this->getRequest()->isPost()) {
	        return $this->_redirect('*/*/');
	    }
	    $id     = $this->getRequest()->getParam('id');
	    /**
	     * @var Bkg_Shapefile_Model_File $model
	     */
	    $model  = Mage::getModel('bkg_shapefile/file')->load($id);
	    $model->setData($this->getRequest()->getPost());
	    $model->setData('id', $id);
	    $model->save();
	    
	    $this->_redirect('*/*/');
	}


	public function saveAction() {
	    $r = $this->getRequest();
	    if (!$r->isPost()) {
	        return $this->_redirect('*/*/');
	    }
	    if (null === $r->getParam('customer_id')) {
	        return $this->_redirect('*/*/');
	    }
	    if (null === $r->getParam('georef_id')) {
	        return $this->_redirect('*/*/');
	    }
	    /**
	     * @var Mage_Adminhtml_Model_Session $as
	     */
	    $as = Mage::getSingleton('adminhtml/session');
	    
		if (!empty($_FILES)) {
		    if (array_key_exists('shp', $_FILES)) {
		        $shp = $_FILES['shp']['tmp_name'];
		    }
		    if (array_key_exists('dbf', $_FILES)) {
		        $dbf = $_FILES['dbf']['tmp_name'];
		    }
		    if (array_key_exists('shp', $_FILES)) {
		        $shx = $_FILES['shx']['tmp_name'];
		    }
		    
		    if (empty($shp) || empty($dbf) || empty($shx)) {
		        $as->addError(Mage::helper('bkg_shapefile')->__('One of the Files missing'));
		        return $this->_redirect('*/*/');
		    }
		    try {
		    /**
		     * @var Bkg_Shapefile_Helper_Data $helper
		     */
		    $helper = Mage::helper('bkg_shapefile');
		    
		    $helper->newShapeFile($shp, $dbf, $shx, $r->getParam('name'), $r->getParam('georef_id'), $r->getParam('customer_id'));
		    } catch (\ShapeFile\ShapeFileException $e) {
		        $as->addException($e, Mage::helper('bkg_shapefile')->__('Error with shape file upload'));
		        return $this->_redirect('*/*/');
		    } catch (\Exception $e) {
		        
		        return $this->_redirect('*/*/');
		    }
		    return $this->_redirect('*/*/index');
		}

		$as->addError(Mage::helper('bkg_shapefile')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
			    /**
			     * @var Bkg_Shapefile_Model_File $model
			     */
				$model = Mage::getModel('bkg_shapefile/file');

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

	protected function _isAllowed()
	{
		return true;
		return Mage::getSingleton('admin/session')->isAllowed('');
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
