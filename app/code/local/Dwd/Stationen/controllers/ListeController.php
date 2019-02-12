<?php
class Dwd_Stationen_ListeController extends Mage_Core_Controller_Front_Action
{
 
    
    public function rssAction()
    {
    	$block = $this->getLayout()->createBlock('stationen/catalog_product_view_rss');
    	//var_dump($block);
		//die($block->toHtml());
    	$this->getResponse()->setBody($block->toHtml());
    }
    
    public function jsonAction()
    {
        /**
         * @var Dwd_Stationen_Helper_Data $helper
         */
        $helper = Mage::helper("stationen");

        $data = $helper->getStationenGeoJson($this->getProduct());

    	$this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
    	$this->getResponse()->setBody(json_encode($data));
    }
    
    protected function getProduct()
    {
        $id = $this->getRequest()->getParam('product_id');
        if($id)
        {
            return Mage::getModel('catalog/product')->load($id);
        }
    }

    protected function getCategoryId()
    {
        return  $this->getRequest()->getParam('category_id');
    }

}