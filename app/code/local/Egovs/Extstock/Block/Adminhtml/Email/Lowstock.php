<?php

class Egovs_Extstock_Block_Adminhtml_Email_Lowstock extends Mage_Core_Block_Abstract
{
    /**
     * Prepare Content HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        $items = $this->getItems();
        $html = '';
        //var_dump($items); die();
        foreach($items as $item)
        {
        	$sku = $item->getSku();
        	$qty = $item->getQty();
        	$name = $item->getName();
        	
        	$html .= $name." (" . $sku .") Qty: ". $qty ."<br/>";
        }
        return $html;
    }
}
