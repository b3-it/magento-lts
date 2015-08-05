<?php

class Egovs_Bitv_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getHomeUrl()
	{
		return $this->_getUrl("");
	}
	
	
	public function getJumpTarget($block)
	{
		$name = $block->getNameInLayout();
		
		return "jumptarget".str_replace('.','',$name);
	}
	
}