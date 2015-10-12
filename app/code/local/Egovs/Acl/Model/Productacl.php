<?php
/**
 * 
 *  Erweiterte Rechte für BE Nutzer
 *  @category Egovs
 *  @package  Egovs_Acl_Model
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2015 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Acl_Model_Productacl extends Mage_Core_Model_Abstract
{
	const STATUS_ENABLED    = 1;
    const STATUS_DISABLED   = 2;
	
	
	/**
	 * test ob user ein Recht hat
	 * @param string $aAclPath
	 * @return boolean
	 */
	public function testPermission($aAclPath)
	{
		return $this->isAllowed($aAclPath);		
	}
	
	
	
	public function isAllowed($aAclPath)
	{
		return Mage::getSingleton('admin/session')->isAllowed($aAclPath);
	}
	
	
	/**
	 * Rechte abhÃ¤ngig vom Produktstatus
	 * @param $Product
	 */
	public function getProductStatusString(Mage_Catalog_Model_Product $Product)
	{
		$st = $Product->getStatus();
		if($st == self::STATUS_ENABLED) return 'enabled';
		if($st == self::STATUS_DISABLED) return 'disabled';
		
		return 'new';
	}
	
	public function getEnableStatus(){ return (int)self::STATUS_ENABLED;}
	public function getDisableStatus(){ return (int)self::STATUS_DISABLED;}
	
	
	/**
	 * testen ob für diesen controller + action besondere Rechte/Pfad existieren
	 * diese stehen in der config.xml
	 * @param string $controller
	 * @param string $action
	 * @return boolean | string (der Path)
	 */
	public function getPermissionPath($controller,$action)
	{
		$node =  Mage::getConfig()->getNode('global/egovsacl/controller_actions');
		if($node)
		{
			$path = $node->asArray();
			 
			if(is_array($path))
			{
				if(isset($path[$controller]))
				{
					if(isset($path[$controller][$action]))
					{
						return $path[$controller][$action];
					}
				}
			}
		}
		return false;
	}
	
}