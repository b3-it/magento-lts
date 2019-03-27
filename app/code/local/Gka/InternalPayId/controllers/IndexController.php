<?php

class Gka_InternalPayId_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	$this->loadLayout();     
		$this->renderLayout();
    }
    
    

    public function preDispatch()
    {
    	parent::preDispatch();
    
    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }
    
    public function kzinfoAction()
    {
        $kz     =  ($this->getRequest()->getParam('pay_id'));
        $client     =  ($this->getRequest()->getParam('pay_client'));

    	$block = Mage::getBlockSingleton('internalpayid/catalog_product_view_price');
    	
    	$block->fetchPrice($client,$kz);
    	//return $block->renderView();
    	
    	$this->loadLayout(false);
    	$this->getResponse()->setBody($block->renderView());
    			
    	return $this;
    }
    

    
}