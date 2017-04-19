<?php

/**
 * 
 * @author h.koegel
 *
 */
class Gka_VirtualPayId_Block_Catalog_Product_View_Type extends Mage_Catalog_Block_Product_View_Type_Virtual
{
		public function getKzInfoUrl()
		{
			return $this->getUrl('');
		}
}
