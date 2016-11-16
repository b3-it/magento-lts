<?php
class Sid_Import_Model_RestImport
{
	
	public function importProductList($losId)
	{
		
		$products = $this->_getProductList($losId);
		/* @var $storage Sid_Import_Model_Storage */
		$storage = Mage::getModel('sidimport/storage');
		$storage->getResource()->clear();
		foreach($products as $product)
		{
			$storage->unsetData('id');
			$storage->setSku($product->sku);
			$storage->setType($product->type);
			$storage->setImportType($product->import_type);
			$storage->setPrice($product->price);
			$storage->setImportdata($product->data);
			$storage->save();
			
			
		}
	}
		
	protected function _getProductList($losId)
	{
		$url =   trim(Mage::getStoreConfig('framecontract/supplierportal/url'),'/');
		$url .= "/rest/products/{$losId}/.json";
		$client = new Varien_Http_Client($url);
		$client->setMethod(Varien_Http_Client::GET);
		
		try{
			$response = $client->request();
			if ($response->isSuccessful()) {
				$res = $response->getBody();
				$res = json_decode($res);
				$products = $res->products;
				
				return $products;
				
			}
		} catch (Exception $e) {
		}
		
		
		return array();
	}
	
}