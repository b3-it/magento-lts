<?php

class Bkg_Viewer_CompositController extends Mage_Core_Controller_Front_Action
{
    public function tilesystemAction() {
        $model = $this->_getComposit();
        
        $helper = Mage::helper('bkgviewer');
        
        $path = $helper->getWMSDir().DS.$model->getTileSystemWithCRS()->getFilename();
        $this->_getXml($path);
    }
    
    public function vgsystemAction() {
        $model = $this->_getComposit();
        
        $helper = Mage::helper('bkgviewer');
        
        $path = $helper->getWMSDir().DS.$model->getVgSystemWithCRS()->getFilename();
        $this->_getXml($path);
    }
    
    public function intersectionAction() {
        $model = $this->_getComposit();
        
        $data = $model->getTilesIntersection();
        
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($data));
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
    protected function _getComposit() {
        $params = $this->getRequest()->getParams();
        
        $id = $params['id'];
        
        $model = Mage::getModel('bkgviewer/composit_composit');
        
        $model->load($id);
        return $model;
    }
}