<?php
/**
 * Hilfsklasse für Egovs
 * Sollte nur statische Elemente enthalten!
 * 
 * 2010-03-13
 * Diese Klasse darf nicht von Mage_Core_Helper_Abstract erben (oder anderen?), da sonst die "include" Anweisung im autoload
 * fehlschlägt!
 * 
 * @category   	Egovs
 * @package		Egovs
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Helper
{
	const LOG_FILE = "egovs.log";
	const EXCEPTION_LOG_FILE = "egovs_exception.log";
	const MAIL_LOG = "egovs_mail.log";
	const CUSTOMER_LOG = "egovs_customer.log";
	const PRODUCT_LOG = "egovs_product.log";
	const BACKEND_TRACE_LOG = "egovs_backend_trace.log";
	const EXCEPTION_CODE_PUBLIC = 100000;
	
	private static $lastMem = 0;
	private static $maxMem = 0;
	private static $lastTime = 0;
	private static $startTime = 0;
	
	private static $__vcsVersion = null;
	
	
	
	/**
	 * Prüft die Verfügbarkeit der Module von denen $module abhängig ist.
	 * 
	 * @param string $module Modulename
	 * 
	 * @return boolean
	 */
	public static function dependenciesInstalled($module, $checkDataVersion = false) {
		$moduleConfigDependsNode = Mage::getConfig()->getNode('modules')->descend("$module/depends");
		/* @var $resource Mage_Core_Model_Resource_Resource */
		$resource = Mage::getResourceSingleton('core/resource');
		$dependenciesInstalled = true;
		if ($moduleConfigDependsNode) {
			foreach ($moduleConfigDependsNode->children() as $mna => $mn) {
				$resources = Mage::getConfig()->getNode('global/resources');
				if ($resources) {
					foreach ($resources->children() as $resName => $resNode) {
						$setup = (string) $resNode->descend('setup/module');
						if ($setup == $mna) {
							$version = (string) Mage::getConfig()->getModuleConfig($mna)->version;
							if (!$checkDataVersion) {
								if (version_compare($resource->getDbVersion($resName), $version, '!=')) {
									$dependenciesInstalled = false;
									break;
								}
							} else {
								if (version_compare($resource->getDataVersion($resName), $version, '!=') || version_compare($resource->getDbVersion($resName), $version, '!=')) {
									$dependenciesInstalled = false;
									break;
								}
							}								
								
							//Versionen sind gleich
							break;
						}
					}
		
					if (!$dependenciesInstalled) {
						//Bedingungen sind nicht erfüllt!
						break;
					}
				} else {
					//Keine Resourcen zum überprüfen vorhanden
					$dependenciesInstalled = false;
					break;
				}
			}
		}
		
		return $dependenciesInstalled;
	}
	
	/**
	 * Prüft die von $module abhängigen Module und verschiebt deren Installation
	 * 
	 * @param string $module Modulename
	 * 
	 * @return void
	 */
	public static function reinitAllowedModules($module) {
		if (!$module) {
			return;
		}
		$modules = Mage::getConfig()->getNode('modules')->children();
		$disallowedModules = array();
		foreach ($modules as $moduleName => $moduleNode) {
			/* @var $moduleNode Mage_Core_Model_Config_Element */
			/* Abhängigkeiten berücksichtigen */
			if ($moduleNode->descend('depends')) {
				if ($moduleNode->depends instanceof Mage_Core_Model_Config_Element) {
					$depends = false;
					foreach ($moduleNode->depends->children() as $mna => $mn) {
						if ($mna == $module || array_key_exists($mna, $disallowedModules)) {
							$depends = true;
							break;
						}
					}
					if ($depends) {
						$disallowedModules[$moduleName] = $moduleNode;
						continue;
					}
				} elseif (is_string($moduleNode->depends) && $moduleNode->depends == $module) {
					$disallowedModules[$moduleName] = $moduleNode;
					continue;
				}
			}
		
			if ($moduleName != $module) {
				Mage::getConfig()->addAllowedModules($moduleName);
			}
		}
		
		Mage::getConfig()->reinit();
	}
	
	public static function printMemUsage($label)
	{
		if(self::$lastTime == 0)
		{
			self::$lastTime = time();
			self::$startTime = time();
		}
		$mem = memory_get_usage() /1024 / 1024;
		if($mem > self::$maxMem) self::$maxMem = $mem;
		$dm = $mem - self::$lastMem;
		if($dm > 0) $sign ="+"; else $sign ="";
		$memstr = number_format($mem,2)."MB; ".$sign. number_format($dm,2)."MB; max: " . number_format(self::$maxMem,2) . "MB";
		$timestr = intval(time() - self::$lastTime) .'s; Total:'.intval(time() - self::$startTime)."s";
		file_put_contents(Mage::getBaseDir('log').DS. 'memusage.txt',$label."; ". $memstr ."; ". $timestr."\n",FILE_APPEND);
		self::$lastMem = $mem;
		self::$lastTime = time();
		 
	}
	
	public static function getVcsVersion() {
		$rev = null;
		
		if (is_null(self::$__vcsVersion)) {
			$revFile = Mage::getBaseDir() .DS.'version';
			if (file_exists($revFile)) {
				$rev = file_get_contents($revFile);
				self::$__vcsVersion = substr($rev, 0, 8);
			}
			//Höhere Priorität
            $revFile = Mage::getBaseDir() .DS.'.git'.DS.'HEAD';
			//$revFile = Mage::getBaseDir() .DS.'.git'.DS.'refs'.DS.'remotes'.DS.'origin'.DS.'master';
			if (file_exists($revFile)) {
			    $rev = file_get_contents($revFile);
                $rev = explode(':', $rev);
                if ($rev && isset($rev[1])) {
                    $revFile = trim($rev[1]);
                    $revFile = Mage::getBaseDir() .DS.'.git'.DS.$revFile;
                    if (file_exists($revFile)) {
                        $rev = file_get_contents($revFile);
                        self::$__vcsVersion = substr($rev, 0, 8).sprintf('{%s}', basename($revFile));
                    }
                }
			}
			$os = php_uname('s');
			if (strpos(strtolower($os), 'windows') !== false) {
			    return;
            }
            //Funktioniert aktuell nur mit Linux-Shell-Hooks
			//Höchste Priorität
            $revFile = Mage::getBaseDir() .DS.'version.json';
            if (file_exists($revFile)) {
                $versionInfo = file_get_contents($revFile);
                $versionInfo = json_decode($versionInfo, true);
                $rev = '';
                if (isset($versionInfo['version'])) {
                    $rev = substr($versionInfo['version'], 0, 8);
                }
                if (isset($versionInfo['branch'])) {
                    $rev .= sprintf('{%s}', $versionInfo['branch']);
                }
                self::$__vcsVersion = $rev;
            }
		}
		
		return self::$__vcsVersion;
	}
}