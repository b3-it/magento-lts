<?php
class Dwd_Stationen_ListeController extends Mage_Core_Controller_Front_Action
{
 
    
    public function rssAction()
    {
    	$block = $this->getLayout()->createBlock('stationen/catalog_product_view_rss');
    	//var_dump($block);
		//die($block->toHtml());
    	$this->getResponse()->setBody($block->toHtml());
    	return;
    }
    
    public function jsonAction()
    {
    	$block = $this->getLayout()->createBlock('stationen/catalog_product_view_json');
    	$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
    	$this->getResponse()->setBody($block->toHtml());
    	return;
    }
    
}