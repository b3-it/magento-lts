<?php
class Egovs_Maintenance_Controller_OfflineRouter extends Mage_Core_Controller_Varien_Router_Standard
{
	private $cmspage = '/index/';
	
	public function addOfflineRouter(Varien_Event_Observer $observer) {	
		$request = Mage::app()->getRequest();
		$storeCode = $request->getStoreCodeFromPath();
		//return;
		$front = $observer->getEvent()->getFront();
		
		
		if($this->isAdmin()){
			return;
		}
		
		 
		$store = Mage::app()->getStore();
		
		
	 	//if ($module !== "admin") 
	 	{
			$curOffline = Mage::getStoreConfig('general/offline/lock');
			$curDate1 = Mage::getStoreConfig('general/offline/to_date');
			$curDate2 = Mage::getStoreConfig('general/offline/from_date');
			$curCMS = Mage::getStoreConfig('general/offline/cmspagepicker');
			
			if ($curOffline == 1) {			// YES
			
				$this->cmspage = $curCMS;
				$front->addRouter('offline_router', $this);
				
			}
			elseif ($curOffline == 2) {	// Scheduled

				$now = Mage::app()->getLocale()->date(null, null, null, false);
				$now = $now->getTimestamp() + $now->getGmtOffset();
				$from = Mage::app()->getLocale()->date($curDate2, null, null, true);
				$from = $from->getTimestamp() + $from->getGmtOffset();
				$to = Mage::app()->getLocale()->date($curDate1, null, null, true);
				$to = $to->getTimestamp() + $to->getGmtOffset();
				
				if(($now > $from) && ($now <$to))
				{
					$this->cmspage = $curCMS;
					$front->addRouter('offline_router', $this);
				}
				
			}	
		}
	}
	
	
	private function isAdmin()
	{
		
		
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
	
	
	
	public function _collectRoutes()
	{
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
						// Remove bei Magento-Patch [Trac 1842]
						//if ($customModule) {
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
	* @return bool
	*/
	public function match(Zend_Controller_Request_Http $request)
	{
		$request->setPathInfo($this->cmspage);
		return false;
	}
}