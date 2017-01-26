<?php
class Dwd_Stationen_Block_Catalog_Product_View_Map extends Dwd_Stationen_Block_Catalog_Product_View_Abstract
{
	public function getRssUrl()
	{
		return $this->getUrl('fstationen/liste/rss',array('product_id'=>$this->getProduct()->getId()));
	}
    
	
	public function getStationenPos()
	{
		$res = array();
		$list = $this->getStationsList();
		foreach($list as $station){
			//$res[] = array('name'=>$station->getName(), 'id'=>$station->getId());
			$res[$station->getId()] = $station->getName();
		}
		return json_encode($res);
	}
}