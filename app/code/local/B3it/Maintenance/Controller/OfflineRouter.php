<?php
/**
 * B3it Maintenance
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Maintenance
 * @name       	B3it_Maintenance_Controller_OfflineRouter
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Maintenance_Controller_OfflineRouter extends Mage_Core_Controller_Varien_Router_Standard {
    const MAINTENANCE_OFF = 0;
	const MAINTENANCE_ON = 1;
	const MAINTENANCE_SCHEDULED = 2;
	private $cmspage = '/index/';
	
	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return void
	 */
	public function addOfflineRouter(Varien_Event_Observer $observer) {
		if (! Mage::isInstalled ())
			return;
		
		$request = Mage::app ()->getRequest ();
		$front = $observer->getEvent ()->getFront ();
		
		if ($this->__isAdmin ()) {
			return;
		}
		
		$storeCode = $request->getStoreCodeFromPath ();
		$store = Mage::app ()->getStore ($storeCode);
		
		$curOffline = Mage::getStoreConfig ( 'general/offline/lock', $store );
		$curCMS = Mage::getStoreConfig ( 'general/offline/cmspagepicker', $store );
		
		
		if ($curOffline == self::MAINTENANCE_ON) {
			$this->cmspage = $curCMS;
			$front->addRouter ( 'offline_router', $this );
		} elseif ($curOffline == self::MAINTENANCE_SCHEDULED) {
		    $curDate1 = Mage::getStoreConfig ( 'general/offline/to_date', $store );
		    $curDate2 = Mage::getStoreConfig ( 'general/offline/from_date', $store );
		    // only check curDate if needed
		    if ( !strlen($curDate1) OR !strlen($curDate2) ) {
		        return;
		    }
			$timezone = Mage::app ()->getStore ( $store )->getConfig ( Mage_Core_Model_Locale::XML_PATH_DEFAULT_TIMEZONE );
			$locale = Mage::app ()->getLocale ()->getLocaleCode (); // new Zend_Locale(Mage::getStoreConfig(Mage_Core_Model_Locale::XML_PATH_DEFAULT_LOCALE, $storeId));
			$locale = new Zend_Locale ( $locale );
			$from = new Zend_Date ( null, null, $locale );
			$to = new Zend_Date ( null, null, $locale );
			
			$format = Varien_Date::DATETIME_INTERNAL_FORMAT;
			
			if ( !is_null($curDate1) AND !is_null($curDate2) ) {
			    try {
			        $from->setDate ( $curDate2, $format );
			        $from->setTime ( $curDate2, $format );
			        $from->setTimezone ( $timezone );
			        
			        $to->setDate ( $curDate1, $format, $locale );
			        $to->setTime ( $curDate1, $format, $locale );
			        $to->setTimezone ( $timezone );
			    } catch (Exception $e) {
			        Mage::logException($e);
			        return;
			    }
			}
			else {
			    return;
			}

			$now = Mage::app ()->getLocale ()->date ( null, null, $locale, false );
			$now = $now->getTimestamp ();
			
			$from = $from->getTimestamp () + $from->getGmtOffset ();
			
			$to = $to->getTimestamp () + $to->getGmtOffset ();
			
			if (($now > $from) && ($now < $to)) {
				$this->cmspage = $curCMS;
				$front->addRouter ( 'offline_router', $this );
			}
			
			if ($now >= $to) {
				/** @var $configCol Mage_Core_Model_Resource_Config_Data_Collection */
				$configCol = Mage::getModel('core/config_data')->getCollection();
				$configCol->addFieldToFilter('path', array('like' => 'general/offline/lock'))
					->addValueFilter(self::MAINTENANCE_SCHEDULED)
				;
				
				//Erst nach Store-Daten suchen
				/** @var $config Mage_Core_Model_Config_Data */
				$scopes = array('stores', 'websites', 'default');
				foreach ($scopes as $scope) {
					foreach ($configCol as $config) {
						if ($config->getScope() == $scope) {
							if (($scope == 'stores' && $config->getScopeId() == $store->getId())
								|| ($scope == 'websites' && $config->getScopeId() == $store->getWebsiteId())
								|| ($scope == 'default' && $config->getScopeId() == 0)
							) {
							    $config->setValue(self::MAINTENANCE_OFF)->save();
								Mage::getConfig()->cleanCache();
								return;
							}
						}
					}
				}
			}
			
		}
	}
	
	private function __isAdmin() {
		$request = clone (Mage::app ()->getRequest ());
		
		$adminPath = ( string ) Mage::getConfig ()->getNode ( Mage_Adminhtml_Helper_Data::XML_PATH_CUSTOM_ADMIN_PATH );
		if (! $adminPath) {
			$adminPath = ( string ) Mage::getConfig ()->getNode ( Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME );
		}
		$pathInfo = $request->getPathInfo ();
		if (preg_match ( '#^' . $adminPath . '(\/.*)?$#', ltrim ( $pathInfo, '/' ) )) {
			return true;
		}
		
		$storeCode = $request->getStoreCodeFromPath ();
		if ($storeCode == 'admin') {
			return true;
		}
		
		$routes = $this->_collectRoutes ();
		foreach ( $routes as $route ) {
			if (preg_match ( '#^' . $route . '(\/.*)?$#', ltrim ( $request->getPathInfo (), '/' ) )) {
				return true;
			}
		}
		
		return false;
	}
	protected function _collectRoutes() {
		$configArea = 'admin';
		$useRouterName = 'admin';
		if (( string ) Mage::getConfig ()->getNode ( Mage_Adminhtml_Helper_Data::XML_PATH_USE_CUSTOM_ADMIN_PATH )) {
			$customUrl = ( string ) Mage::getConfig ()->getNode ( Mage_Adminhtml_Helper_Data::XML_PATH_CUSTOM_ADMIN_PATH );
			$xmlPath = Mage_Adminhtml_Helper_Data::XML_PATH_ADMINHTML_ROUTER_FRONTNAME;
			if (( string ) Mage::getConfig ()->getNode ( $xmlPath ) != $customUrl) {
				Mage::getConfig ()->setNode ( $xmlPath, $customUrl, true );
			}
		}
		
		$AdminModules = array ();
		$routers = array ();
		$routersConfigNode = Mage::getConfig ()->getNode ( $configArea . '/routers' );
		if ($routersConfigNode) {
			$routers = $routersConfigNode->children ();
		}
		foreach ( $routers as $routerName => $routerConfig ) {
			$use = ( string ) $routerConfig->use;
			if ($use == $useRouterName) {
				$modules = array (
						( string ) $routerConfig->args->module 
				);
				if ($routerConfig->args->modules) {
					foreach ( $routerConfig->args->modules->children () as $customModule ) {
						if (( string ) $customModule) {
							if ($before = $customModule->getAttribute ( 'before' )) {
								$position = array_search ( $before, $modules );
								if ($position === false) {
									$position = 0;
								}
								array_splice ( $modules, $position, 0, ( string ) $customModule );
							} elseif ($after = $customModule->getAttribute ( 'after' )) {
								$position = array_search ( $after, $modules );
								if ($position === false) {
									$position = count ( $modules );
								}
								array_splice ( $modules, $position + 1, 0, ( string ) $customModule );
							} else {
								$modules [] = ( string ) $customModule;
							}
						}
					}
				}
				
				$frontName = ( string ) $routerConfig->args->frontName;
				$AdminModules [$frontName] = $routerName;
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
		$request->setPathInfo ( $this->cmspage );
		$response = Mage::app ()->getResponse ();
		if ($response->canSendHeaders ()) {
			// Service Unavailable
			$response->setHeader ( 'MAINTENANCE', 1, true );
			$response->setHttpResponseCode ( 503 );
		}
		return false;
	}
}