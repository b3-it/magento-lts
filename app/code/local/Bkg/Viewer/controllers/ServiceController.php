<?php

class Bkg_Viewer_ServiceController extends Mage_Core_Controller_Front_Action
{
    public function serviceAction() {
        $model = $this->_getService();
        
        $helper = Mage::helper('bkgviewer');
        
        $path = $helper->getWMSDir().DS.$model->getTileSystemWithCRS()->getFilename();
        $this->_getXml($path);
    }
    
  
    
    protected function _getXml($path) {
        $contents = file_get_contents($path);
        
        // check if file has xml declaration, if not add it
        $xmlDecl = "<?xml";
        
        if (strncmp($contents, $xmlDecl, strlen($xmlDecl)) !== 0) {
            $contents = "<?xml version='1.0' encoding='UTF-8' ?>\n".$contents;
        }
        
        // set response type to xml
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/xml',true);
        $this->getResponse()->setBody($contents);
    }
    
    /**
     * @return Bkg_Viewer_Model_Composit_Composit
     */
    protected function _getService() {
        $params = $this->getRequest()->getParams();
        
        $id = $params['id'];
        
        $model = Mage::getModel('bkgviewer/service_service');
        
        $model->load($id);
        return $model;
    }
}