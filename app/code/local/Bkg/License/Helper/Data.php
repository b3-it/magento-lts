<?php
/**
 * <Namespace> <Module>
 *
 *
 * @category   	<Namespace>
 * @package    	<Namespace>_<Module>
 * @name       	<Namespace>_<Module>_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

 /**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_License_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getLicenseFilePath($license_id)
	{
		$path = $path = Mage::getBaseDir('media') . DS .'license'.DS.$license_id;
		if(!file_exists($path))
		{
			try {
				mkdir($path,'0777',true);
			}catch(Exception $ex)
			{
				Mage::logException($ex);
				$path = null;
			}
		}
		
		return $path;
	}
}
