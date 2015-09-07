<?php

class Slpb_Product_Block_Adminhtml_Order_Grid_Missing extends Mage_Adminhtml_Block_Widget
{
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('slpb/order/grid/missing.phtml');
	}
   
}
