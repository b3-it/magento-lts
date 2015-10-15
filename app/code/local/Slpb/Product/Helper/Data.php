<?php 
class Slpb_Product_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isSaxony($postcode)
	{
		$postcode = trim($postcode);
		if(preg_match('/^0/',$postcode)) {
			if(is_numeric($postcode)){
				$postcode = intval($postcode);
				if (($postcode >= 1000)&&($postcode <= 1936)) return true;
				elseif (($postcode >= 1000)&&($postcode <= 1936)) return true;
				elseif (($postcode >= 2000)&&($postcode <= 2999)) return true;
				elseif (($postcode >= 4000)&&($postcode <= 4599)) return true;
				elseif (($postcode >= 4640)&&($postcode <= 4999)) return true;
				elseif (($postcode >= 8000)&&($postcode <= 9999)) return true;
				elseif ($postcode == 7919) return true;
				elseif ($postcode == 7952) return true;
				elseif ($postcode == 7985) return true;
				else return false;
			}
		}
		return false;
	}
	
	public function getStars($product)
	{
	
		if($product == null) { return '';}
		$star = $product->getSternchen();

		if($star == null)
		{
			return '';
		}
		
		$text = '';
		for($i = 1; $i <= $star; $i++)
		{
			$text .= '*';
		}
		
		return "<span class='stars'>$text</span> ";
	}
	
	public function getShippingLink()
	{
		return '<a href="'.Mage::getUrl('') . Mage::getStoreConfig('tax/display/shippingurl').'">'
	               . $this->__('Supply Fee extra')."</a>";
	}
}