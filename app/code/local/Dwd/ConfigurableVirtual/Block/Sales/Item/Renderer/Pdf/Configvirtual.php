<?php
class Dwd_ConfigurableVirtual_Block_Sales_Item_Renderer_Pdf_Configvirtual extends Egovs_Pdftemplate_Block_Sales_Item_Renderer_Abstract
{
	
	public function getPeriodeLabel()
	{
		$oi = $this->getOrderItem();
		if ($oi->getPeriodId())
		{
			$periode = Mage::getModel('periode/periode')
			->setStoreId($this->getStoreId())
			->load($oi->getPeriodId());
		}
		return null;
	}
	
	public function getStationLabel()
	{
		$oi = $this->getOrderItem();
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
		$oi = $this->getOrderItem();
		return $oi->getOrder()->getStoreId();
	}
	
	public function getFormatedPeriode() {
		/*
		$oi = $this->getOrderItem();
		if($oi->getPeriodStart())
		{
			$ps = Mage::app()->getLocale()->date($oi->getPeriodStart(), null, null, true);
			$pe = Mage::app()->getLocale()->date($oi->getPeriodEnd(), null, null, true);
			return $ps .' - '.$pe;
		}
		return '';
		*/
		$periode = Dwd_Periode_Model_Periode::loadPeriodeByOrderItem($this->getOrderItem(), $this->getStoreId());
		if($periode){
			return $periode->getFormatedText();
		}
		return "";
		
	}
}