<?php

class Bkg_VirtualAccess_Block_Sales_Email_Items_Configvirtual extends Mage_Sales_Block_Order_Email_Items_Default
{
	public function getPeriodeLabel()
	{
		$oi = $this->getItem();
		if ($oi->getPeriodId()!= 0)
		{
			$periode = Mage::getModel('periode/periode')
				->setStoreId($this->getStoreId())
				->load($oi->getPeriodId());
			return $periode->getLabel();
		}
		return null;
	}
	
	public function getStationLabel()
	{
		$oi = $this->getItem();
		if ($oi->getStationId())
		{
			$station = Mage::getModel('stationen/stationen')
			->setStoreId($this->getStoreId())
			->load($oi->getStationId());
			return $station->getName();
		}
		return null;
	}
	
	public function getStoreId()
	{
		$oi = $this->getItem();
		return $oi->getOrder()->getStoreId();
	}
	
	public function getFormatedPeriode() {
		/*
		if(($this->getItem()->getPeriodType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION) || ($this->getItem()->getPeriodType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO))
		{
			return $this->getPeriodeLabel();
		}
		$start =  Mage::app()->getLocale()->date($this->getItem()->getPeriodStart(), null, null, true);
    	$stop  =  Mage::app()->getLocale()->date($this->getItem()->getPeriodEnd(), null, null, true);
    	return $start.' - '.$stop;
    	*/
		
		$periode = Dwd_Periode_Model_Periode::loadPeriodeByOrderItem($this->getItem());
		if($periode){
			return $periode->getFormatedText();
		}
		return "";
	}
}
