<?php

class Egovs_Informationservice_Adminhtml_Informationservice_ProductController extends Mage_Adminhtml_Controller_Action
{


	public function createAction() {
		$data = $this->getRequest()->getPost();
		$res = "<h4>Master Product not found</h4>";
		if($data)
		{
			if ( ((int)$data['result_master']) != 0) {
				$product = Mage::getModel('catalog/product')->load($data['result_master']);
				$stockitem = $product->getStockItem();
				$sku = $product->getSku();
				$newProduct = $product->duplicate();
				$product = Mage::getModel('catalog/product')->load($newProduct->getId());
				$product->setUrlKey($sku.'-'.time());
        		$product->setSku($sku.'-'.time());
        		
        		if(strlen($data['result_titel']) > 1){
        			$product->setName($data['result_titel']);
        		}
        		
        		if(strlen($data['result_price']) > 0)
        		{
        			$price = str_replace(",", ".", $data['result_price']) + 0;
        			$product->setData('price',$price);
        		}
        		$product->setData('infoservice_is_master_product','0');
        		$product->setData('status',Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        		$product->save();

        		
        		$product->getStockItem()
        			->setData('manage_stock',$stockitem['manage_stock'])
        			->setData('use_config_manage_stock',$stockitem['use_config_manage_stock'])
        			->setData('stock_status_changed_automatically',$stockitem['stock_status_changed_automatically'])
        			->save();
        		
				
        		$urlModel = Mage::getModel('core/url')->setStore('default');
        		$res = "<div class=\"hor-scroll\">
                <table cellspacing=\"0\" class=\"form-list\">
            <tbody>
                <tr>
        <td colspan=\"3\" class=\"hidden\">
        <input id=\"result_product_id\" name=\"request[result_product_id]\" value=\"".$product->getId()."\" type=\"hidden\"/></td>
		 </tr>
		<tr>
        <td class=\"label\"><label for=\"result_product_name\">Product Name</label></td>
	    <td class=\"value\"><span id=\"result_product_url\"><input id=\"result_product_name\" name=\"result_product_name\" value=\"".$product->getName()."\" readonly=\"1\" disabled=\"disabled\" type=\"text\" class=\" input-text\"/></span></td>
	    <td id=\"note_result_product_name\"><small>&nbsp;</small></td>

    	</tr>
		<tr>
        <td class=\"label\"><label for=\"result_product_url\">Product Url</label></td>
    <td class=\"value\">".$urlModel->getUrl($product -> getUrlPath(),array('_current'=>false))."</td>
    <td id=\"note_result_product_url\"><small>&nbsp;</small></td>
    </tr>
            </tbody>
        </table>
            </div>
        		";
        		
        	
			}
			
		}
		
		$this->getResponse()
    	 	->setBody($res);
	}

	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('informationservice/request');
				break;
		}
	}
}