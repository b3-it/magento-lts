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
}