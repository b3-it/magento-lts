<?php
/**
 *
 *  Persitentzobjekt für Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Blocks extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pdftemplate/blocks');
    }
    
    
    public function getBlock($ident,$data)
    {
    	$res = '';
    	$collection= $this->getCollection();
    	$collection->getSelect()->where("ident='".$ident."' AND status=".Egovs_Pdftemplate_Model_Blocks_Status::STATUS_ENABLED);
    	
    	$payment = $data->getOrder()->getPayment()->getMethod();
    	$shippment = $data->getOrder()->getShippingMethod();
    	$taxrule =  $this->getTaxRulesFromOder($data->getOrder());
    	
    	foreach ($collection->getItems() as $item)
    	{
    	
    		if((($payment == $item->getPayment() ) || ($item->getPayment() == 'all' ))
    			&& (($shippment == $item->getShipping() ) || ($item->getShipping() == 'all' ))
    			&& ((array_key_exists($item->getTaxRule(), $taxrule)) || ($item->getTaxRule() == 'all' ))    		
    			)
    		{
    			$res .= $item->getContent(). ' ';
    		}

    	}
    	
    	return $res;
    }
    
    
    private function getTaxRulesFromOder($order)
    {
    	$res = array();
    	//$collection = Mage::getModel('')
    	$id = $order->getQuoteId();
    	if($id)
    	{
	    	$collection = Mage::getModel('sales/quote_address')->getCollection();
	    	$collection->getSelect()->where('quote_id='.$id);
	    	foreach($collection->getItems() as $item)
	    	{
	    		$taxes = $item->getAppliedTaxes();
	    		if(is_array($taxes))
	    		{
		    		foreach ($taxes as $tax)
		    		{
			    		foreach($tax['rates'] as $rate )
			    		{
			    			$rule = $rate['rule_id'];
			    			$res[$rule] = $rule;
			    		}
		    		}
	    		}
	    	}
    	}
    	
    	
    	return $res;
    }
    
    
}