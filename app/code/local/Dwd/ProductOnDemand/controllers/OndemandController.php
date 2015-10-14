<?php
class Dwd_ProductOnDemand_OndemandController extends Mage_Core_Controller_Front_Action
{
	public function processWesteDataAction() {
		$id = $this->getRequest()->getParam('id', 0);
		$hash = $this->getRequest()->getParam('hash', null);
		$protocol = $this->getRequest()->isSecure() ? 'https://' : 'http://';
		$hashPrefix = $protocol.$this->getRequest()->getHttpHost().$this->getRequest()->getRequestUri();
		$hashPrefix = substr($hashPrefix, 0, strpos($hashPrefix, '&') !== false ? strpos($hashPrefix, '&') : count($hashPrefix));
		$salt = (string) Mage::getStoreConfig('catalog/dwd_pod/salt');
		Mage::log(sprintf("pod::Weste-Hash:%s\nwebshopURL:%s", $hash, $hashPrefix), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$referer = Mage::getSingleton('customer/session')->getPodReferer();
		Mage::getSingleton('customer/session')->unsetData('pod_referer');
		if (!$referer) {
			$referer = Mage::getBaseUrl();
		}
		//$hashPrefix = 'https://kunden.dwd.de/asterixep/webshop?id='.$id;
		$hashAlgo = (string) Mage::getStoreConfig('catalog/dwd_pod/hash_algorithm');
		if (!$hash || hash($hashAlgo, $salt.$hashPrefix) != $hash) {
			$msg = Mage::helper('prondemand')->__('Transaction ID is incorrect');
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		
		$msg = Mage::helper('prondemand')->__('Application Server is not available');
		$transactionUrl = (string) Mage::getStoreConfig('catalog/dwd_pod/transaction_url');
		$httpClient = new Varien_Http_Client();
		/* @var $response Zend_Http_Response */
		$response = $httpClient->setUri($transactionUrl)
			->setParameterGet(array('id' => $id))
			->setConfig(array('timeout' => 5))
			->request('GET')
		;
		if (!$response || $response->getStatus() != 200) {
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		
		//XML auswerten
		$productMetaData = null;
		$body = $response->getBody();
		$contend = explode("\r\n\r\n", $body, 2);
		if (!empty($content)) {
			list($headers, $content) = $content;
			$body = $content;
		}
		try {
			$productMetaData = Mage::getModel('core/config_base', $body);
		} catch (Exception $e) {
			$productMetaData = null;
			Mage::log(sprintf("pod::%s\nBody:%s", $e->getMessage(), $response->getBody()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		
		$msg = Mage::helper('prondemand')->__('XML parsing error.');
		/* @var $productMetaData Mage_Core_Model_Config_Base */
		if (!$productMetaData || !($productMetaData instanceof Mage_Core_Model_Config_Base)) {
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		
		$status = $productMetaData->getNode('status');
		if (!$status || strtolower($status) != 'success') {
			$errors = $productMetaData->getNode('errors');
			$msg = Mage::helper('prondemand')->__('Abort by user.');
			if ($errors && $errors->hasChildren()) {
				foreach ($errors->children() as $error) {
					/* @var $error SimpleXMLElement*/
					if (!$error) {
						continue;
					}
					$errorId = null;
					if (isset($error['id'])) {
						$errorId = $error['id'];
					}
					$errorCode = null;
					if (isset($error['code'])) {
						$errorCode = $error['code'];
					}
					
					$msg = '';
					foreach ($error->children() as $name => $childNode) {
						switch (strtolower($name)) {
							case 'message' :
								$msg = (string) $childNode;
								break;
						}
					}
					$msg = sprintf('%s (ID:%s;CODE:%s)', $msg, $errorId, $errorCode);
					Mage::getSingleton('catalog/session')->addError($msg);
				}
			} else {
				Mage::getSingleton('catalog/session')->addNotice($msg);
			}
			$this->_redirectUrl($referer);
			return;
		}
		
		$productInfo = $productMetaData->getNode('productInfo');
		if (!$productInfo || !$productInfo->hasChildren()) {
			$msg = Mage::helper('prondemand')->__('Product not available');
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		$downloadInfo = $productMetaData->getNode('downloadInfo');
		if (!$downloadInfo || !$downloadInfo->hasChildren()) {
			$msg = Mage::helper('prondemand')->__('Product not available');
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		
		$westeTypeId = $productMetaData->getNode()->getAttribute('westeTypId');
		$collection = Mage::getModel('catalog/product')->getCollection();
		/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
		$collection->addAttributeToFilter('pod_type_id', $westeTypeId);
		/* @var $product Mage_Catalog_Model_Product */
		$product = $collection->getFirstItem();
		$productUrl = $product->getProductUrl();
		$params = array();
		$params['product'] = $product->getId();
		$params['uenc'] = Mage::helper('core/url')->urlEncode($productUrl);
		$productInfo = Mage::helper('egovsbase')->xmlToArray($productInfo);
		$params['product_info'] = $productInfo;
		$linkItem = array();
		$price = $productInfo['netPrice'];
		$price = Mage::app()->getLocale()->getNumber($price);
		//Original WESTE Netto Preis speichern
		$productInfo['westeNetPrice'] = $productInfo['netPrice'];
		//Preis als Zahl speichern
		$productInfo['netPrice'] = $price;
		$linkItem['price'] = $price;
		$linkItem['title'] = Mage::helper('downloadable')->__('Start Download');//$id;
		$linkItem['url'] = (string) $downloadInfo->descend('url');
		$linkItem['type'] = Mage_Downloadable_Helper_Download::LINK_TYPE_URL;
		$linkId = $product->getTypeInstance(true)->setProduct($product)->addLinkItem($linkItem);
		$params['links'] = array($linkId);
		
		$this->_forward('add', 'cart', 'checkout', $params);
	}
	
	/**
	 * Redirect zu Weste-Server
	 * 
	 * @return void
	 */
	public function redirectToWesteAction() {
		Mage::getSingleton('checkout/session')->getMessages(true);
		
		$referer = $this->_getRefererUrl();
		$availUrl = Mage::getSingleton('customer/session')->getPodAvailibilityUrl();
		
		$msg = Mage::helper('prondemand')->__('Application Server is not available');
		if (!$availUrl) {
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		
		$id = Mage::getSingleton('customer/session')->getPodTypeId();
		if (!$id) {
			$id = $this->getRequest()->getParam('westeTypeId', 0);
			$id = Mage::helper('core/url')->urlDecode($id);
		}
		
		$params = array();
		$params['branch'] = $id;
		$httpClient = new Varien_Http_Client();
		/* @var $response Zend_Http_Response */
		$response = null;
		try {
			$response = $httpClient->setUri($availUrl)
	                            ->setParameterGet($params)
	                            ->setConfig(array('timeout' => 5))
	                            ->request('GET')
			;
		} catch (Exception $httpEx) {
			Mage::logException($httpEx);
		}
		if (!$response || $response->getStatus() != 200) {
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
        $headers = $response->getHeaders();
		
		Mage::getSingleton('customer/session')->setPodReferer($referer);
		
		$redirect = Mage::getSingleton('customer/session')->getPodTargetUrl();
		if (!$redirect) {
			$redirect = $id = $this->getRequest()->getParam('redirect', null);
			$redirect = Mage::helper('core/url')->urlDecode($redirect);
		}
		
		$back = Mage::getSingleton('customer/session')->getPodBackUrl();
		if (!$back) {
			$back = $id = $this->getRequest()->getParam('back', null);
			$back = Mage::helper('core/url')->urlDecode($back);
		}
		
		$debug = (bool) Mage::getStoreConfigFlag('catalog/dwd_pod/is_debug');
		
		if ($debug) {
			$url = sprintf('%s?westeTypID=%s&webshopURL=%s', $redirect, urlencode($id), urlencode($back));
			Mage::log(sprintf('pod::webshopURL:%s', $back), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} else {
			$url = $redirect;
		}
		
		Mage::log(sprintf('pod::Weste-Request-URL:%s', $url), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$this->_redirectUrl($url);
	}
}