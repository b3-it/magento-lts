<?php

class Dwd_ConfigurableVirtual_Block_Catalog_Product_View_Type extends Mage_Catalog_Block_Product_View_Type_Virtual
{
	public function showMap()
	{
		return $this->getProduct()->getData('show_stations_map');
	}
		
	public function showSuggestBox()
	{
		return $this->getProduct()->getData('show_stations_suggest');
	}
}
