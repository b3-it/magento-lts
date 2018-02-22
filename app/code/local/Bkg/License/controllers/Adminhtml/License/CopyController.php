<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name        Bkg_License_Adminhtml_License_Copy_EntityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Adminhtml_License_CopyController extends Mage_Adminhtml_Controller_action
{



	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('copyentity/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('CopyEntity Manager'), Mage::helper('adminhtml')->__('CopyEntity Manager'));
		$this->_title(Mage::helper('adminhtml')->__('CopyEntity Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}



	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('bkg_license/copy')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('entity_data', $model);

			$this->_initAction();
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit'))
				->_addLeft($this->getLayout()->createBlock('bkg_license/adminhtml_copy_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkg_license')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_forward('edit');
	}

	public function uploadAction()
	{
		if (!empty($_FILES))
		{
			$data = $this->getRequest()->getPost();
			$license_id = $this->getRequest()->getParam('id');

			$f = $_FILES;
			$result = array();
			try
			{
				$uploader = new Varien_File_Uploader('Filedata');
				$uploader->setAllowRenameFiles(true);

				$uploader->setFilesDispersion(false);
				$uploader->setAllowCreateFolders(true);

				$file = Mage::getModel('bkg_license/copy_file');
				$path = Mage::helper('bkg_license')->getLicenseFilePath($license_id).DS.$file->getHashFilename();
				$file->setCopyId($license_id);
				$file->setOrigFilename($_FILES['Filedata']['name']);

				//$uploader->setAllowedExtensions(array('pdf')); //server-side validation of extension
				$uploadSaveResult = $uploader->save($path, $_FILES['Filedata']['name']);

				$file->save();

				$result = array(
					'filename' => $uploadSaveResult['file'],
					'download' => $this->getUrl('adminhtml/license_copy/download'  ,array('id'=>$file->getHashFilename())),
					'delete'   => $this->getUrl('adminhtml/license_copy/deletefile',array('id'=>$file->getHashFilename())),
					'created'  => now(),

					'path'     => str_replace(DS, "/", $uploadSaveResult['path']),
					'cookie'   => array(
		                'name'     => session_name(),
		                'value'    => $this->_getSession()->getSessionId(),
		                'lifetime' => $this->_getSession()->getCookieLifetime(),
		                'path'     => $this->_getSession()->getCookiePath(),
		                'domain'   => $this->_getSession()->getCookieDomain()
		            )
				);
			}
			catch(Exception $e)
			{
				Mage::log("BKG Import: ".$e->getMessage() , Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$result = array(
						'file'        => $_FILES['Filedata']['name'],
						"errorCode"   => $e->getCode() . ' (' . $_FILES['Filedata']['name'] . ')',
						"errorMsg"    => $e->getMessage(),
						"errorString" => "error"
				);
			}
			$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
		}
	}


	public function downloadAction()
	{
			$id = $this->getRequest()->getParam('id');

			$file = Mage::getModel('bkg_license/copy_file')->load($id,'hash_filename');
			$path = Mage::helper('bkg_license')->getLicenseFilePath($file->getCopyId()).DS.$file->getHashFilename();

			$content = file_get_contents($path);
			$this->_prepareDownloadResponse($file->getOrigFilename(), $content);
			return $this;
	}

	public function deletefileAction()
	{
		$id = $this->getRequest()->getParam('id');

		$file = Mage::getModel('bkg_license/copy_file')->load($id,'hash_filename');
		$path = Mage::helper('bkg_license')->getLicenseFilePath($file->getCopyId()).DS.$file->getHashFilename();

		unlink($path);
		$file->delete();

		return $this;
	}


	public function previewPdfAction()
	{
		$content = null;
		if ($content = $this->getRequest()->getParam('content'))
		{
			//$content = base64_decode($content);
		}
		$id = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('bkg_license/copy')->load($id);

		$pdf = $model->previewPdf($content);
		//die($pdf);
		//$pdf = utf8_encode($pdf);
		//$pdf = base64_encode($pdf);
		$this->_prepareDownloadResponse($this->__('Preview').'.pdf', $pdf,'application/pdf');
		return $this;
	}



	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('bkg_license/copy');
			$model->setData($data)
			->setId($this->getRequest()->getParam('id'));

			try {
				if($model->getIsOrgUnit())
				{
					$model->unsetData('customer_id');
				}else{
					$model->unsetData('orgunit_id');
				}

				$model->save();
				//$this->_saveCustomerGroup($data,$model);
				$this->_saveFees($data,$model);
				$this->_saveProduct($data,$model);
				$this->_saveAgreements($data,$model);
				$this->_saveToll($data,$model);

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkg_license')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}

				if ($this->getRequest()->getParam('createPdf')) {
					$model->createPdfFile();
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}

				if ($this->getRequest()->getParam('processTemplate')) {
					$model->processTemplate()->save();
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
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkg_license/copyentity');

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
        $copyentityIds = $this->getRequest()->getParam('copyentity_ids');
        if(!is_array($copyentityIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($copyentityIds as $copyentityId) {
                    $bkg_license = Mage::getModel('bkg_license/copy')->load($copyentityId);
                    $bkg_license->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($copyentityIds)
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
        $copyentityIds = $this->getRequest()->getParam('copyentity_ids');
        if(!is_array($bkg_licenseIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($copyentityIds as $copyentityId) {
                    $copyentity = Mage::getSingleton('bkg_license/copy')
                        ->load($copyentityId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($copyentityIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function exportCsvAction()
    {
        $fileName   = 'copyentity.csv';
        $content    = $this->getLayout()->createBlock('bkg_license/adminhtml_copy_entity_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'copyentity.xml';
        $content    = $this->getLayout()->createBlock('bkg_license/adminhtml_copy_entity_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _saveProduct($data,$model)
    {
        if(!isset($data['product']))
        {
            return $this;
        }
    	$groups = $data['product'];
    	$collection = Mage::getModel('bkg_license/copy_product')->getCollection();
    	$collection->addCopyIdFilter(intval($model->getId()));

    	$items = array();
    	foreach($collection as $item)
    	{
    		if(in_array($item->getProductId(),$groups)) {
    			$items[$item->getProductId()] = $item;
    		}else{
    			$item->delete();
    		}
    	}

    	foreach($groups as $group)
    	{
    		if(isset($items[$group])){
    			$item = $items[$group];
    		}else{
    			$item = Mage::getModel('bkg_license/copy_product');
    		}

    		$item->setCopyId(intval($model->getId()));
    		$item->setProductId($group);
    		$item->save();
    	}

    }

    protected function _saveAgreements($data,$model)
    {

        if(!isset($data['agreement']))
        {
            return $this;
        }

    	$groups = array();
    	$tmp = $data['agreement'];

    	foreach($tmp['value'] as $k=>$v)
    	{
    		$groups[] = array('value'=>$v,'pos'=>$tmp['pos'][$k],'delete'=>$tmp['delete'][$k]);
    	}

    	$collection = Mage::getModel('bkg_license/copy_agreement')->getCollection();
    	$collection->addCopyIdFilter(intval($model->getId()));

    	$items = array();
    	foreach($collection as $item)
    	{
    		$items[$item->getIdentifier()] = $item;
    	}

    	foreach($groups as $group)
    	{
    		if((count($items) > 0) && (isset($items[$group['value']]))){
    			$item = $items[$group['value']];
    		}else{
    			$item = Mage::getModel('bkg_license/copy_agreement');
    		}

    		$item->setCopyId(intval($model->getId()));
    		$item->setIdentifier($group['value']);
    		$item->setPos($group['pos']);


    		if($group['delete'])
    		{
    			$item->delete();
    		}else{
    			$item->save();
    		}
    	}

    }

    protected function _saveToll($data,$model)
    {
        if(!isset($data['toll']))
        {
            return $this;
        }
    	$groups = array();
    	$tmp = $data['toll'];

    	foreach($tmp['value'] as $k=>$v)
    	{
    		$groups[] = array('value'=>$v,'pos'=>$tmp['pos'][$k],'delete'=>$tmp['delete'][$k]);
    	}

    	$collection = Mage::getModel('bkg_license/copy_toll')->getCollection();
    	$collection->addCopyIdFilter(intval($model->getId()));

    	$items = array();
    	foreach($collection as $item)
    	{
    		$items[$item->getUseoptionId()] = $item;
    	}

    	foreach($groups as $group)
    	{
    		if((count($items) > 0) && (isset($items[$group['value']]))){
    			$item = $items[$group['value']];
    		}else{
    			$item = Mage::getModel('bkg_license/copy_toll');
    		}

    		$item->setCopyId(intval($model->getId()));
    		$item->setUseoptionId($group['value']);
    		$item->setPos($group['pos']);


    		if($group['delete'])
    		{
    			$item->delete();
    		}else{
    			$item->save();
    		}
    	}

    }

    protected function _saveFees($data,$model)
    {
        if(!isset($data['fees']))
        {
            return $this;
        }
    	$fees = $data['fees'];

    	$collection = Mage::getModel('bkg_license/copy_fee')->getCollection();
    	$collection->getSelect()->where('copy_id ='. intval($model->getId()));

    	$items = array();
    	foreach($collection as $item)
    	{
    		$items[$item->getFeeCode()] = $item;
    	}

    	foreach($fees as $key =>$fee)
    	{
    		if(isset($items[$key])){
    			$item = $items[$key];
    		}else{
    			$item = Mage::getModel('bkg_license/copy_fee');
    		}

    		$fee['id'] = $item->getId();
    		$item->setData($fee);
    		$item->setCopyId(intval($model->getId()));
    		$item->setFeeCode($key);
    		$item->save();
    	}


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
