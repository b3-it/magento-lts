<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Bkg_License
 * @name       	Bkg_License_IndexController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {			
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    
    public function viewAction()
    {
    	$this->loadLayout();
    	//$this->getLayout()->getBlock('head')->setTitle($this->__('My Data Access'));
		$this->renderLayout();
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


    
    public function preDispatch() {
    	parent::preDispatch();
    
    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }
    
  
}