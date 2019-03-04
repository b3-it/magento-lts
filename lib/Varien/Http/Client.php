<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Varien
 * @package     Varien_Http
 * @copyright  Copyright (c) 2006-2018 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Varien HTTP Client
 *
 * @category   Varien
 * @package    Varien_Http
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Varien_Http_Client extends Zend_Http_Client
{
    /**
     * Internal flag to allow decoding of request body
     *
     * @var bool
     */
    protected $_urlEncodeBody = true;

    public function __construct($uri = null, $config = null)
    {
        $this->config['useragent'] = 'Varien_Http_Client';

        parent::__construct($uri, $config);
    }

    protected function _trySetCurlAdapter()
    {
        if (extension_loaded('curl')) {
            $this->setAdapter(new Varien_Http_Adapter_Curl());
        }
        return $this;
    }

    public function request($method = null)
    {
        $this->_trySetCurlAdapter();
        return parent::request($method);
    }

    /**
     * Change value of internal flag to disable/enable custom prepare functionality
     *
     * @param bool $flag
     * @return Varien_Http_Client
     */
    public function setUrlEncodeBody($flag)
    {
        $this->_urlEncodeBody = $flag;
        return $this;
    }

    /**
     * Adding custom functionality to decode data after
     * standard prepare functionality
     *
     * @return string
     */
    protected function _prepareBody()
    {
        $body = parent::_prepareBody();

        if (!$this->_urlEncodeBody && $body) {
            $body = urldecode($body);
            $this->setHeaders('Content-length', strlen($body));
        }

        return $body;
    }
    
    
    public function setConfig($config = array()) {
    	try {
    
    		$uri = $this->getUri(true);
    		if(!$uri) {$uri = "";}
    
    		if ((Mage::getStoreConfig('web/proxy/use_proxy') == 1) && !($this->getExcludeProxy($uri)))
    		{
    			//Sobald der Proxy-Host konfiguriert wurde, darf der Rest nicht �berschrieben werden
    			if (!array_key_exists('proxy_host', $config)) {
    				Mage::log('Proxy is enabled but not manual set, using default settings...', Zend_Log::DEBUG);
    				$config['adapter'] = 'Zend_Http_Client_Adapter_Proxy';
    				$this->setAdapter($config['adapter']);
    
    				$config['proxy_host'] = Mage::getStoreConfig('web/proxy/proxy_name');
    				$config['proxy_port'] = Mage::getStoreConfig('web/proxy/proxy_port');
    
    				//Proxy settings für cUrl
    				$config['proxy'] = sprintf('%s%s', $config['proxy_host'], isset($config['proxy_port']) ? ':'.$config['proxy_port'] : '');
    				$user = Mage::getStoreConfig('web/proxy/proxy_user');
    				if (!empty($user)) {
    					$config['proxy_user'] = $user;
    				}
    				$pass = Mage::getStoreConfig('web/proxy/proxy_user_pwd');
    				if (!empty($pass)) {
    					$config['proxy_pass'] = $pass;
    				}
    			}
    		}
    	} catch (Exception $e) {
    		Mage::logException($e);
    	}
    	 
    	 
    	 
    	return parent::setConfig($config);
    }
    
    
    public function getExcludeProxy($uri)
    {
    	$excludeList = null;
    	try {
    		$excludeList = Mage::getStoreConfig('web/proxy/exclude_list');
    	} catch (Exception $e) {
    		return false;
    	}
    	 
    	$excludeArray = explode("\n", $excludeList);
    	 
    	if (empty($excludeArray) || empty($uri)) {
    		return false;
    	}
    	 
    	$match = false;
    	foreach ($excludeArray as $exclude) {
    		if (stripos($uri, trim($exclude)) !== false) {
    			$match = true;
    			break;
    		}
    	}
    	 
    	return $match;
    	 
    }
    
    public function setUri($uri) {
    	parent::setUri($uri);
    	 
    	$uri = $this->getUri(true);
    	 
    	$this->_checkForProxyExcludes($uri, $this->config);
    	 
    	//Config auch in Adapter neu setzen
    	$this->setConfig($this->config);
    	 
    	return $this;
    }
    
    protected function _checkForProxyExcludes($uri, &$config = null) {
    	try {
    		Egovs_Paymentbase_Helper_Data::checkForProxyExcludes($uri, $config);
    	} catch (Exception $e) {
    	}
    	 
    	return $this;
    }
}
