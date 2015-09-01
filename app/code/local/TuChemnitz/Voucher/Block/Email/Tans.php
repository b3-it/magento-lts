<?php

class TuChemnitz_Voucher_Block_Email_Tans extends Mage_Core_Block_Abstract
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
        	$orderitem = $item['order_item'];
        	$tans = $item['tans'];
        	$html .= $orderitem->getName()." (" . $orderitem->getSku().")<br/> TAN(s): <br/>". implode('<br/>', $tans);
        	$html .= "<br/>" . $item['note'] ;
        }
        return $html;
    }
}
