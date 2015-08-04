<?php

class Egovs_Bitv_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getHomeUrl()
	{
		return $this->_getUrl("");
	}
}