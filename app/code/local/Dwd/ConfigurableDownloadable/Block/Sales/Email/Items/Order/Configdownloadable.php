<?php

class Dwd_ConfigurableDownloadable_Block_Sales_Email_Items_Order_Configdownloadable extends Mage_Sales_Block_Order_Email_Items_Order_Default
{
	public function getPeriodeLabel()
	{
		$oi = $this->getItem();
		if ($oi->getPeriodId()!= 0)
		{
			$periode = Mage::getModel('periode/periode')->load($oi->getPeriodId());
		}
		return null;
	}
	
	public function getStationLabel()
	{
		$oi = $this->getItem();
		if ($oi->getStationId())
		{
			$station = Mage::getModel('stationen/stationen')->load($oi->getStationId());
			return $station->getName();
		}
		return null;
	}
	
	public function getFormatedPeriode() {
		$oi = $this->getItem();
		if($oi->getPeriodStart())
		{
			$ps = Mage::app()->getLocale()->date($oi->getPeriodStart(), null, null, true);
			$pe = Mage::app()->getLocale()->date($oi->getPeriodEnd(), null, null, true);
			return $ps .' - '.$pe;
		}
		return '';
		
	}
}
