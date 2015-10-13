<?php
class Dwd_ProductOnDemand_Block_Sales_Item_Renderer extends Mage_Sales_Block_Order_Item_Renderer_Default
{
	
	public function getPeriodeLabel()
	{
		$oi = $this->getOrderItem();
		if ($oi->getPeriodId())
		{
			$periode = Mage::getModel('periode/periode')->load($oi->getPeriodId());
		}
		return null;
	}
	
	public function getStationLabel()
	{
		$oi = $this->getOrderItem();
		if ($oi->getStationId())
		{
			$station = Mage::getModel('stationen/stationen')->load($oi->getStationId());
			return $station->getName();
		}
		return null;
	}
}