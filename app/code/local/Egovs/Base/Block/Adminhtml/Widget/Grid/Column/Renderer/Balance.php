<?php
/**
 * Renderer für Saldo.
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Adminhtml_Widget_Grid_Column_Renderer_Balance extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Currency
{
   /**
     * Renders grid column
     *
     * @param Varien_Object $row Zeile
     * 
     * @return string
     */
    public function render(Varien_Object $row) {
    	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
    		$bgt = $row->getData($this->getColumn()->getIndex());
    		$btp = $row->getData($this->getColumn()->getIndexPaid());
    		if (!isset($btp)) {
    			$btp = 0.0;
    		}
    		
    		$data = $btp - $bgt;
    	} else {
    		$data = $row->getData($this->getColumn()->getIndex());
    	}
    	
        if (is_numeric($data)) {
            $currencyCode = $this->_getCurrencyCode($row);

            if (!$currencyCode) {
                return $data;
            }

            $data = floatval($data) * $this->_getRate($row);
            $data = Mage::app()->getStore()->roundPrice($data);
            
          
            $price = sprintf("%f", $data);
            $price = Mage::app()->getLocale()->currency($currencyCode)->toCurrency($price);
            //bei export werden keine Tags gebraucht
            $export = $this->getColumn()->getGrid()->getIsExport();
	        if(!$export)
	        {
		            //span geht nicht!
		            if ($data >= 0) {
		            	return  "<span class=\"balanced\"> {$price}</span>";
		            } else {
		            	return  "<span class=\"unbalanced\"> {$price}</span>"; 	
		            }
		           
	        }
           
	        return $price;
            
            
            
                        
        }
    	
        return $this->getColumn()->getDefault();
    }
}