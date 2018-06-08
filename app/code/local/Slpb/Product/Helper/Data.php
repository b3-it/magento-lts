<?php 
class Slpb_Product_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isSaxony($postcode) {

	    if (Mage::getStoreConfigFlag('checkout/cart/slpb_use_data_src_to_check_postcode')) {
	        return self::isPostcodeInSaxony($postcode);
        }

		$postcode = trim($postcode);
		if(preg_match('/^0/',$postcode)) {
			if(is_numeric($postcode)){
				$postcode = intval($postcode);
				if (($postcode >= 1000)&&($postcode <= 1936)) return true;
				elseif (($postcode >= 1000)&&($postcode <= 1936)) return true;
				elseif (($postcode >= 2000)&&($postcode <= 2999)) return true;
				elseif (($postcode >= 4000)&&($postcode <= 4599)) return true;
				elseif (($postcode >= 4640)&&($postcode <= 4889)) return true;
				elseif (($postcode >= 8000)&&($postcode <= 9999)) return true;
				elseif ($postcode == 7919) return true;
				elseif ($postcode == 7952) return true;
				elseif ($postcode == 7985) return true;
				else return false;
			}
		}
		return false;
	}
	
	public function getStars($product) {
	
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
	
	public function getShippingLink() {
		return '<a href="'.Mage::getUrl('') . Mage::getStoreConfig('tax/display/shippingurl').'">'
	               . $this->__('Supply Fee extra')."</a>";
	}

    /**
     * Prüft die PLZ gegen eine Datenquelle
     *
     * @see http://api.zippopotam.us/
     * @see http://download.geonames.org/export/zip/
     *
     * @param string $postcode PLZ
     *
     * @return boolean
     */
    public static function isPostcodeInSaxony($postcode) {
        $result = false;
        if (strlen(trim($postcode)) < 1) {
            return $result;
        }
        $path = Mage::getModuleDir('etc','Slpb_Product').DS;

        $files = array(
            'plz.csv' => array(
                'plz' => 1,
                'region_code' => 4
            ),
        );

        foreach ($files as $file => $ref) {
            $file = $path.$file;
            // Open file
            $fp = fopen($file, 'r');

            while ($data = fgetcsv($fp, 1024, "\t")) {
                if (trim($data[$ref['plz']]) == $postcode && trim($data[$ref['region_code']]) == 'SN') {
                    $result = true;
                    break;
                }
            }
            fclose($fp);

            if ($result) {
                break;
            }
        }

        return $result;
    }
}