<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Sitemap grid action column renderer
 *
 * @category   Mage
 * @package    Mage_Sitemap
 */
class Slpb_Extstock_Block_Adminhtml_Warning_Grid_Renderer_Package extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   	protected function _getInputValue(Varien_Object $row)
    {
    	$stock_id = $row->getData('stock_id');
		$product_id = $row->getData('product_id');
    	
    	//$gridParam = Mage::helper('extstock')->getWarningGridParamAsArray($this->getRequest()->getParams());
        /*
		$res = ceil($this->calcPackage($row));
        if($res > 0) 
        {
        	return $res;
        } 
        */  	
        return  '';
    }
    protected function _getValue(Varien_Object $row)
    {
        
        return '';//round($this->calcPackage($row),2);
    }
    
    private function calcPackage(Varien_Object $row)
    {
    	$size = intval($row->getData($this->getColumn()->getIndex()));
    	if($size > 0)
    	{
    		$qty = intval($row->getData($this->getColumn()->getIndexQty()));
    		$limit = intval($row->getData($this->getColumn()->getIndexLimit()));
    		$need = $limit - $qty;
    		return $need / $size;
    		
    	}
    	return 0;
    	
    }
 	public function _getInputValueElement(Varien_Object $row)
    {
    	$size = $row->getData($this->getColumn()->getIndex());
    	//ohne packetgr��e kann nichts ausgerechnet werden
    	if($size > 0)
    	{
    		$js = "extstockWarningGrid_massactionJsObject.getCheckboxes().each(function(b){if((b.value =='". $row->getData('id')."') ) {b.checked=true; extstockWarningGrid_massactionJsObject.setCheckbox(b)}});";
	        $htm = '<input onchange="'.$js.'" type="text" class="input-text ' . $this->getColumn()->getValidateClass() . '" name="'.( $this->getColumn()->getName() ? $this->getColumn()->getName() : $this->getColumn()->getId() ).'" value="'.$this->_getInputValue($row).'"/>';
	        $htm .= '<input type="hidden" class="input-text " name="product_keys" value="'.$row->getData('product_id').'"/>';
	        $htm .= '<input type="hidden" class="input-text " name="destination" value="'.$row->getData('stock_id').'"/>';
	        $htm .= '<input type="hidden" class="input-text " name="package" value="'.$row->getData($this->getColumn()->getIndex()).'"/>';
	        return $htm;
    	}
    	
    	return '';
    }
}
