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
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Viewer_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function fetchData($url)
	{
		$ch = curl_init();
		
		// Follow any Location headers
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_ENCODING ,"");
		//curl_setopt($ch, CURLOPT_GET, 1);
		
// 		if(!empty($this->getUser())){
// 			$this->setLog('setze Username: '. $this->getUser());
// 			curl_setopt($ch,CURLOPT_PROXYUSERPWD,$this->getUser().':'.$this->getPwd());
// 		}
		
		$output = curl_exec($ch);
		
			
		if(curl_error($ch))
		{
			throw new Exception(curl_error($ch));
		}
			
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			
		if ($http_status !=200)
		{
			throw new Exception("HTTP Status: " . $http_status ." ".$output);
		}
			
		$curl_errno= curl_errno($ch);
		if($curl_errno > 0)
		{
			throw new Exception('Curl Error: '.curl_strerror($curl_errno));
		}
				
		curl_close($ch);
		return $output;
	}
	
	public function getWMSDir()
	{
		$dir = Mage::getBaseDir('media') . DS .'wms';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		return $dir;
	}
	
	//eine Liste mit Version für WMS ermitteln
	public function getAvailableVersions()
	{
			//if (is_null($options))
			//{
				$options = array();
// 				$options[] = array(
// 						'label' =>'',
// 						'value' =>''
// 				);
		
				$options[""] = $this->__("-- Please Select --");
				$einheiten = Mage::getConfig()->getNode('global/wms/versions')->asArray();
				 
				if(is_array($einheiten))
				{
		
					foreach($einheiten as $v)
					{
						$options[$v[0]] = $v['@']['type'] . " " . $v[0];
					}
				}
			//}
			return $options;
	}
}
