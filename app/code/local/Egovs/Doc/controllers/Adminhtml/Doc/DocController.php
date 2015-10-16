<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Adminhtml_Doc_DocController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('doc/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Document Manager'), Mage::helper('adminhtml')->__('Document Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		
		$this->_initAction();
		$this->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('egovs_doc/doc')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('doc_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('egovs_doc/items');

			//$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			//$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('egovs_doc/adminhtml_doc_edit'))
				->_addLeft($this->getLayout()->createBlock('egovs_doc/adminhtml_doc_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('egovs_doc')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$id = intval($this->getRequest()->getParam('id'));
			$model = Mage::getModel('egovs_doc/doc')->load($id);
			
			
			if(isset($_FILES['upfilename']['name']) && $_FILES['upfilename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('upfilename');
					
					// Any extention would work
	           		//$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$saveAs = $model->getFileIdentId().$_FILES['upfilename']['name'] ;
					$path = Mage::getBaseDir('media') . DS . 'doc' . DS;
					$res = $uploader->save($path, $saveAs );
					if(is_array($res))
					{
						$saveAs = $res['file'];
					}
					
				} catch (Exception $e) {
		      
		        }
	        
		        $model->deleteFile();
		        //this way the name is saved in DB
	  			$model->setFilename($_FILES['upfilename']['name']);
	  			$model->setSavefilename($saveAs);
	  			
			}

			$fields = array('title','description','category','content');
			foreach ($fields as $field)
			{
				$model->setData($field,$data[$field]);
			}
			
			
			$owner = Mage::getSingleton('admin/session')->getUser();
			if($model->getOwner() == "")
			{
				$model->setOwner($owner->getUsername());
			}
			$model->setEditor($owner->getUsername());
			
			try {
				if ($model->getCreatedTime() == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('egovs_doc')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('egovs_doc')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('egovs_doc/doc');
				 
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

  public function downloadAction()
  {
  	if( $this->getRequest()->getParam('id') > 0 ) 
  	{
  		$id = intval($this->getRequest()->getParam('id'));
  		$model = Mage::getModel('egovs_doc/doc')->load($id);
  		
  		if($model->getId())
  		{
  				
  			$resource = Mage::helper('downloadable/file')->getFilePath(
                     Mage::getBaseDir('media').DS.'doc',  $model->getSavefilename()
                );
                $resourceType = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
                if($this->_processDownload($resource,$resourceType, $model->getFilename()))
                {
                	exit(0);
                }
                else 
                {
                	$this->_redirect('*/*/index');
                }
  		}
  			
  		
  		
  	}
  }
  
   protected function _processDownload($resource, $resourceType, $name)
    {
        $helper = Mage::helper('downloadable/download');
        /* @var $helper Mage_Downloadable_Helper_Download */

        $helper->setResource($resource, $resourceType);

        if(!file_exists($resource))
        {
        	Mage::getSingleton('adminhtml/session')->addError("File not found!");
        	return false;
        }
        
        
        $fileName       = $helper->getFilename();
        $contentType    = $helper->getContentType();

        $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', $contentType, true);

        if ($fileSize = $helper->getFilesize()) {
            $this->getResponse()
                ->setHeader('Content-Length', $fileSize);
        }

        if ($contentDisposition = $helper->getContentDisposition()) {
            $this->getResponse()
                ->setHeader('Content-Disposition', $contentDisposition . '; filename='.$name);
        }

        $this->getResponse()
            ->clearBody();
        $this->getResponse()
            ->sendHeaders();

        $helper->output();
        return true;
    }
  
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		case 'download':
    		case 'index':
    			return Mage::getSingleton('admin/session')->isAllowed('egovs_doc/egovs_doc_manager/view');
    		case 'delete':
    		case 'edit':
    		case 'new':
    		case 'save':
    			return Mage::getSingleton('admin/session')->isAllowed('egovs_doc/egovs_doc_manager/edit');
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('egovs_doc/egovs_doc_manager');
    	}
    }    
}