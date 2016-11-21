<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Import controller
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Framecontract_Adminhtml_Framecontract_ImportController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Custom constructor.
     *
     * @return void
     */
    protected function _construct()
    {
        // Define module dependent translate
        $this->setUsedModuleName('Mage_ImportExport');
    }

    /**
     * Initialize layout.
     *
     * @return Mage_ImportExport_Adminhtml_ImportController
     */
    protected function _initAction()
    {
    	 $this->_title($this->__('Import/Export'))
            ->loadLayout()
            ->_setActiveMenu('system/importexport');

        return $this;
    }

    /**
     * Check access (in the ACL) for current user.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/convert/framcontract_import');
    }

    /**
     * Index action.
     *
     * @return void
     */
    public function indexAction()
    {
        $maxUploadSize = Mage::helper('importexport')->getMaxUploadSize();
        $this->_getSession()->addNotice(
            $this->__('Total size of uploadable files must not exceed %s', $maxUploadSize)
        );
        $this->_initAction()
            ->_title($this->__('Import'))
            ->_addBreadcrumb($this->__('Import'), $this->__('Import'));

        $this->renderLayout();
    }

    /**
     * Start import process action.
     *
     * @return void
     */
    public function startAction()
    {
        $data = $this->getRequest()->getPost();
        
       
        
        
        if ($data) {
            $this->loadLayout(false);

            /** @var $resultBlock Mage_ImportExport_Block_Adminhtml_Import_Frame_Result */
            $resultBlock = $this->getLayout()->getBlock('import.frame.result');

            $importModel = Mage::getModel('framecontract/import');
           
            try {
            	if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){
            		$storeGroups = Mage::helper('isolation')->getUserStoreGroups();
            		if(($storeGroups) && (count($storeGroups) > 0))
            		{
            			$store = $data['store'];
            			if(array_search($store, $storeGroups) === false){
            				throw new Exception('Access denied!');
            			}
            		}
            	}
            	
            	
                $importModel->importSource();
                $importModel->invalidateIndex();
                $resultBlock->addAction('show', 'import_validation_container')
                    ->addAction('innerHTML', 'import_validation_container_header', $this->__('Status'));
            } catch (Exception $e) {
                $resultBlock->addError($e->getMessage());
                $this->renderLayout();
                return;
            }
            $resultBlock->addAction('hide', array('edit_form', 'upload_button', 'messages'))
                ->addSuccess($this->__('Import successfully done.'));
            $this->renderLayout();
        } else {
            $this->_redirect('*/*/index');
        }
    }

    /**
     * Validate uploaded files action.
     *
     * @return void
     */
    public function validateAction()
    {
    	//setlocale(LC_ALL, "de_DE.UTF-8");
        $data = $this->getRequest()->getPost();
        if ($data) {
            $this->loadLayout(false);
            /** @var $resultBlock Mage_ImportExport_Block_Adminhtml_Import_Frame_Result */
            $resultBlock = $this->getLayout()->getBlock('import.frame.result');
            // common actions
            $resultBlock->addAction('show', 'import_validation_container')
                ->addAction('clear', array(
                    Mage_ImportExport_Model_Import::FIELD_NAME_SOURCE_FILE,
                    Mage_ImportExport_Model_Import::FIELD_NAME_IMG_ARCHIVE_FILE)
                );

            try {
                /** @var $import Mage_ImportExport_Model_Import */
                $import = Mage::getModel('framecontract/import');
                $data['entity']='catalog_product';
                $validationResult = $import->validateSource($import->setData($data)->uploadSource());

                if (!$import->getProcessedRowsCount()) {
                    $resultBlock->addError($this->__('File does not contain data. Please upload another one'));
                } else {
                    if (!$validationResult) {
                        if ($import->getProcessedRowsCount() == $import->getInvalidRowsCount()) {
                            $resultBlock->addNotice(
                                $this->__('File is totally invalid. Please fix errors and re-upload file')
                            );
                        } elseif ($import->getErrorsCount() >= $import->getErrorsLimit()) {
                            $resultBlock->addNotice(
                                $this->__(
                                    'Errors limit (%d) reached. Please fix errors and re-upload file',
                                    $import->getErrorsLimit()
                                )
                            );
                        } else {
                            if ($import->isImportAllowed()) {
                                $resultBlock->addNotice(
                                    $this->__('Please fix errors and re-upload file or simply press "Import" button to skip rows with errors'),
                                    true
                                );
                            } else {
                                $resultBlock->addNotice(
                                    $this->__('File is partially valid, but import is not possible'), false
                                );
                            }
                        }
                        // errors info
                        foreach ($import->getErrors() as $errorCode => $rows) {
                            $error = $errorCode . ' ' . $this->__('in rows:') . ' ' . implode(', ', $rows);
                            $resultBlock->addError($error);
                        }
                    } else {
                        if ($import->isImportAllowed()) {
                        	if($import->hasMissingImages())
                        	{
                        		$resultBlock->addNotice($import->getMissingImages());
                        	}
                            $resultBlock->addSuccess(
                                $this->__('File is valid! To start import process press "Import" button'), true
                            );
                        } else {
                            $resultBlock->addError(
                                $this->__('File is valid, but import is not possible'), false
                            );
                        }
                    }
                    $resultBlock->addNotice($import->getNotices());
                    $resultBlock->addNotice(
                        $this->__(
                            'Checked rows: %d, checked entities: %d, invalid rows: %d, total errors: %d',
                            $import->getProcessedRowsCount(), $import->getProcessedEntitiesCount(),
                            $import->getInvalidRowsCount(), $import->getErrorsCount()
                        )
                    );
                }
            } catch (Exception $e) {
                $resultBlock->addNotice($this->__('Please fix errors and re-upload file'))
                    ->addError($e->getMessage());
            }
            $this->renderLayout();
        } elseif ($this->getRequest()->isPost() && empty($_FILES)) {
            $this->loadLayout(false);
            $resultBlock = $this->getLayout()->getBlock('import.frame.result');
            $resultBlock->addError($this->__('File was not uploaded'));
            $this->renderLayout();
        } else {
            $this->_getSession()->addError($this->__('Data is invalid or file is not uploaded'));
            $this->_redirect('*/*/index');
        }
    }



    public function xuploadAction()
    {
    	$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($_REQUEST));
    }

    public function uploadAction()
    {
    	if (!empty($_FILES))
    	{
    		$data = $this->getRequest()->getPost();
    		$f = $_FILES;
    		$result = array();
    		try
    		{
    			$uploader = new Varien_File_Uploader("Filedata");
    			$uploader->setAllowRenameFiles(true);

    			$uploader->setFilesDispersion(false);
    			$uploader->setAllowCreateFolders(true);

    			$path = Mage::getBaseDir('var') . DS ."import" .DS ."tmp". DS .$data['token'] ;

    			//$uploader->setAllowedExtensions(array('pdf')); //server-side validation of extension
    			$uploadSaveResult = $uploader->save($path, $_FILES['Filedata']['name']);

    			$result = $uploadSaveResult['file'];
    		}
    		catch(Exception $e)
    		{
    			Mage::log("SID Import: ".$e->getMessage() , Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
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
}
