<?php
class Dwd_ProductOnDemand_OndemandController extends Mage_Core_Controller_Front_Action
{
	public function processWesteDataAction() {
		$id = $this->getRequest()->getParam('id', 0);
		$hash = $this->getRequest()->getParam('hash', null);
		$protocol = $this->getRequest()->isSecure() ? 'https://' : 'http://';
		$webshopURL = $protocol.$this->getRequest()->getHttpHost().$this->getRequest()->getRequestUri();
		$webshopURL = substr($webshopURL, 0, strpos($webshopURL, '&') !== false ? strpos($webshopURL, '&') : count($webshopURL));
		$salt = (string) Mage::getStoreConfig('catalog/dwd_pod/salt');
		Mage::log(sprintf("pod::Weste-Hash:%s\nwebshopURL:%s", $hash, $webshopURL), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$referer = Mage::getSingleton('customer/session')->getPodReferer();
		Mage::getSingleton('customer/session')->unsetData('pod_referer');
		if (!$referer) {
			$referer = Mage::getBaseUrl();
		}
		//$hashPrefix = 'https://kunden.dwd.de/asterixep/webshop?id='.$id;
		$hashAlgo = (string) Mage::getStoreConfig('catalog/dwd_pod/hash_algorithm');
		if (!$hash || hash($hashAlgo, $salt.$webshopURL) != $hash) {
			$msg = Mage::helper('prondemand')->__('Transaction ID is incorrect');
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s\nWebshopURL:%s", $msg, $id, $hash, $webshopURL), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}

        Mage::log(sprintf("pod::Prepare call for application server... (ID:%s)", $id), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		$msg = Mage::helper('prondemand')->__('Application Server is not available');
		$transactionUrl = (string) Mage::getStoreConfig('catalog/dwd_pod/transaction_url');
		$httpClient = new Varien_Http_Client();
		/* @var $response Zend_Http_Response */
		try {
            $response = $httpClient->setUri($transactionUrl)
                ->setParameterGet(array('id' => $id))
                ->setConfig(array('timeout' => 7))
                ->request('GET');
        } catch (Exception $e) {
		    Mage::logException($e);
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            Mage::getSingleton('catalog/session')->addError($msg);
            $this->_redirectUrl($referer);
            return;
        }
		if (!$response || $response->getStatus() != 200) {
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}

        Mage::log(sprintf("pod::... call for application server finished (ID:%s)", $id), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		//XML auswerten
        Mage::log(sprintf("pod::Parsing XML... (ID:%s)", $id), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$productMetaData = null;
		$body = $response->getBody();
		$content = explode("\r\n\r\n", $body, 2);
		if (!empty($content) && count($content) == 2) {
			list($headers, $body) = $content;
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
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
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
                    Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
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
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
		$downloadInfo = $productMetaData->getNode('downloadInfo');
		if (!$downloadInfo || !$downloadInfo->hasChildren()) {
			$msg = Mage::helper('prondemand')->__('Product not available');
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('catalog/session')->addError($msg);
			$this->_redirectUrl($referer);
			return;
		}
        Mage::log(sprintf("pod::... parsing XML finished (ID:%s)", $id), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        Mage::log(sprintf("pod::All fine, preparing product to add to cart (ID:%s)", $id), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		$westeTypeId = $productMetaData->getNode()->getAttribute('westeTypId');
		$collection = Mage::getModel('catalog/product')->getCollection();
		/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
		$collection->addAttributeToFilter('pod_type_id', $westeTypeId);
		$collection->addAttributeToSelect('pod_show_reference_period');
		/* @var $product Mage_Catalog_Model_Product */
		$product = $collection->getFirstItem();
		$productUrl = $product->getProductUrl();
		$params = array();
		$params['product'] = $product->getId();
		$params['uenc'] = Mage::helper('core/url')->urlEncode($productUrl);
		$productInfo = Mage::helper('egovsbase')->xmlToArray($productInfo);
		if ($product->hasPodShowReferencePeriod() && !$product->getPodShowReferencePeriod()) {
			if (isset($productInfo['startDate'])) {
				unset($productInfo['startDate']);
			}
		}
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
		if (!($linkId > 0)) {
            $msg = Mage::helper('prondemand')->__('Product not available');
            Mage::log(sprintf("pod::%s\nID:%s\nhash:%s", $msg, $id, $hash), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            Mage::getSingleton('catalog/session')->addError($msg);
            $this->_redirectUrl($referer);
            return;
        }
		$params['links'] = array($linkId);
		$params[Mage_Core_Model_Url::FORM_KEY] = Mage::getSingleton('core/session')->getFormKey();

		$this->_forward('add', 'cart', 'checkout', $params);
        Mage::app()->getRequest()->setInternallyForwarded(true);
		//Redirect endet in Endlosschleife
		//$this->_redirect('checkout/cart/add', $params);
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

        $sendBackUrl = (bool) Mage::getStoreConfigFlag('catalog/dwd_pod/send_back_url');
		if ($sendBackUrl) {
            /* @var $urlModel Mage_Core_Model_Url */
            $urlModel = Mage::getModel('core/url');
            $backUrl = $urlModel->getUrl(
                'prondemand/ondemand/processWesteData',
                array('_secure' => Mage::app()->getRequest()->isSecure())
            );

			$url = sprintf('%s?westeTypID=%s&webshopURL=%s', $redirect, urlencode($id), urlencode($backUrl));
			Mage::log(sprintf('pod::WebshopURL:%s', $backUrl), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} else {
			$url = $redirect;
		}

		Mage::log(sprintf('pod::Weste-Request-URL:%s', $url), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$this->_redirectUrl($url);
	}
}