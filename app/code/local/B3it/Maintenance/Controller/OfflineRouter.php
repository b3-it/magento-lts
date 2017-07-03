<?php
class B3it_Maintenance_Controller_OfflineRouter extends Mage_Core_Controller_Varien_Router_Standard
{
	CONST MAINTENANCE_ON = 1;
	CONST MAINTENANCE_SCHEDULED = 2;
	
	private $cmspage = '/index/';
	
	public function addOfflineRouter(Varien_Event_Observer $observer) {	
		if (!Mage::isInstalled()) return;
		
		$request = Mage::app()->getRequest();
		$storeCode = $request->getStoreCodeFromPath();
		$front = $observer->getEvent()->getFront();
		
		
		if ($this->__isAdmin()) {
			return;
		}
		
		 
		$store = Mage::app()->getStore();
		
		
		$curOffline = Mage::getStoreConfig('general/offline/lock');
		$curDate1 = Mage::getStoreConfig('general/offline/to_date');
		$curDate2 = Mage::getStoreConfig('general/offline/from_date');
		$curCMS = Mage::getStoreConfig('general/offline/cmspagepicker');
		
		if ($curOffline == self::MAINTENANCE_ON) {
		
			$this->cmspage = $curCMS;
			$front->addRouter('offline_router', $this);
			
		} elseif ($curOffline == self::MAINTENANCE_SCHEDULED) {

			$timezone = Mage::app()->getStore($store)->getConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE);
			$locale =  Mage::app()->getLocale()->getLocaleCode();// new Zend_Locale(Mage::getStoreConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_LOCALE, $storeId));
			$locale = new Zend_Locale($locale);
			$from = new Zend_Date(null, null, $locale);
			$to = new Zend_Date(null, null, $locale);

			$format = 'YYYY-MM-dd HH:mm:ss';
			$from->setDate($curDate2, $format);
			$from->setTime($curDate2, $format);
			$from->setTimezone($timezone);
			
			$to->setDate($curDate1, $format,$locale);
			$to->setTime($curDate1, $format,$locale);
			$to->setTimezone($timezone);
			
			$now = Mage::app()->getLocale()->date(null, null, $locale, false);
			$now = $now->getTimestamp();
			
			$from = $from->getTimestamp() + $from->getGmtOffset();
			
			$to = $to->getTimestamp() + $to->getGmtOffset();
			
			if (($now > $from) && ($now <$to))
			{
				$this->cmspage = $curCMS;
				$front->addRouter('offline_router', $this);
			}
			/*
			if($now >= $to)
			{
				Mage::setStoreConfig('general/offline/lock')
			}
			*/
		}
	}
	
	
	private function __isAdmin() {
		
		
		$request = clone(Mage::app()->getRequest());
		
		$adminPath = (string)Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_CUSTOM_ADMIN_PATH);
		if (!$adminPath) {
			$adminPath = (string)Mage::getConfig()
			->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME);
		}
		$pathInfo = $request->getPathInfo();
		if (preg_match('#^' . $adminPath . '(\/.*)?$#', ltrim($pathInfo, '/'))) {
			return true;
		}
		
		$storeCode = $request->getStoreCodeFromPath();
		if($storeCode == 'admin')
		{
			return true;
		}
		
		
		
		$routes = $this->_collectRoutes('admin', 'admin');
		foreach($routes as $route)
		{
			if (preg_match('#^' . $route . '(\/.*)?$#', ltrim($request->getPathInfo(), '/'))) {
				return true;
			}
		}
		
		return false;
	} 
	
	
	
	protected function _collectRoutes() {
		$configArea = 'admin';
		$useRouterName = 'admin';
		if ((string)Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_USE_CUSTOM_ADMIN_PATH)) {
			$customUrl = (string)Mage::getConfig()->getNode(Mage_Adminhtml_Helper_Data::XML_PATH_CUSTOM_ADMIN_PATH);
			$xmlPath = Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME;
			if ((string)Mage::getConfig()->getNode($xmlPath) != $customUrl) {
				Mage::getConfig()->setNode($xmlPath, $customUrl, true);
			}
		}
		
		$AdminModules = array();
		$routers = array();
		$routersConfigNode = Mage::getConfig()->getNode($configArea.'/routers');
		if($routersConfigNode) {
			$routers = $routersConfigNode->children();
		}
		foreach ($routers as $routerName=>$routerConfig) {
			$use = (string)$routerConfig->use;
			if ($use == $useRouterName) {
				$modules = array((string)$routerConfig->args->module);
				if ($routerConfig->args->modules) {
					foreach ($routerConfig->args->modules->children() as $customModule) {
						if ((string)$customModule) {
							if ($before = $customModule->getAttribute('before')) {
								$position = array_search($before, $modules);
								if ($position === false) {
									$position = 0;
								}
								array_splice($modules, $position, 0, (string)$customModule);
							} elseif ($after = $customModule->getAttribute('after')) {
								$position = array_search($after, $modules);
								if ($position === false) {
									$position = count($modules);
								}
								array_splice($modules, $position+1, 0, (string)$customModule);
							} else {
								$modules[] = (string)$customModule;
							}
						}
					}
				}
	
				$frontName = (string)$routerConfig->args->frontName;
				$AdminModules[$frontName] = $routerName;
			}
		}
		return $AdminModules;
	}
	
	

	/**
	* Validate and Match Cms Page and modify request
	*
	* @param Zend_Controller_Request_Http $request
	* 
	* @return bool
	*/
	public function match(Zend_Controller_Request_Http $request) {
		$request->setPathInfo($this->cmspage);
		$response = Mage::app()->getResponse();
		if ($response->canSendHeaders()) {
			// Service Unavailable
			$response->setHeader('MAINTENANCE', 1, true);
			$response->setHttpResponseCode(503);
		}
		return false;
	}
}