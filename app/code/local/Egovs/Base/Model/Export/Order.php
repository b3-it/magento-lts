<?php
class Egovs_Base_Model_Export_Order
{
	
	/*
	 * 
	 * 
	 * 	$order = Mage::getModel('sales/order')->load(1);
		$model = Mage::getModel('exportorder/format_transdoc');
		$xml = $model->processOrder($order);
		echo '<pre>';
		die($xml);
		
		$xsl = new DOMDocument();
		$xsl->loadXML('<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"   xmlns:dp="http://www.datapower.com/extensions" extension-element-prefixes="dp"
				xmlns:bmecat="http://www.bmecat.org/bmecat/2005">
				<xsl:template match="/order">
				  <ORDER>
				    <xsl:apply-templates/>
				  </ORDER>
				</xsl:template>
				<dp:set-local-variable name="\'counter\'" value="0"/>
				<xsl:template match="order_items">
				  <ORDER_ITEM_LIST>
						<xsl:for-each select="order_item">
						<dp:set-local-variable name="\'counter\'" value="1"/>
				    		<ORDER_ITEM>
								<LINE_ITEM_ID><xsl:value-of select="dp:local-variable(\'counter\')"/></LINE_ITEM_ID>
									<PRODUCT_ID>
										<bmecat:SUPPLIER_PID><xsl:value-of select="sku"/></bmecat:SUPPLIER_PID>
									</PRODUCT_ID>
							</ORDER_ITEM>
						</xsl:for-each>
				  </ORDER_ITEM_LIST>
				</xsl:template>
				
				
			</xsl:stylesheet>');
		$xml = Mage::getModel('egovsbase/export_order')->OrdertoXml(1,$xsl);
		
		echo '<pre>';
		die($xml);
	 * 
	 * 
	 */
	
	
	
	public function OrderToXml($order, DOMDocument $xslt = null)
	{
		/* @var $order Mage_Sales_Model_Order */
		if( $order instanceof Mage_Sales_Model_Order){
			$order = $order;
		}
		elseif(is_numeric($order)) {
			$order = Mage::getModel('sales/order')->load(intval($order));
		}else{
			$order = null;
		}
		
		$xml = new SimpleXMLElement('<order/>');
		if($order)
		{
			$array = $order->toArray();
			array_walk_recursive($array, array($this, 'addChild'), $xml);
			
			$orderItems = $xml->addChild('order_items');
			foreach($order->getAllItems() as $item)
			{
				$orderItem = $orderItems->addChild('order_item');
				$array = $item->toArray();
				array_walk_recursive($array, array($this, 'addChild'), $orderItem);
			}
			
			$address = $xml->addChild('billing_address');
			$array = $order->getBillingAddress()->toArray();
			array_walk_recursive($array, array($this, 'addChild'), $address);
			
			if(!$order->getIsVirtual()){
				$address = $xml->addChild('shipping_address');
				$array = $order->getShippingAddress()->toArray();
				array_walk_recursive($array, array($this, 'addChild'), $address);
			}	
		}
		
		if($xslt == null)
		{
			return $xml->asXML();
		}
		
		$proc = new XSLTProcessor();
		$proc->importStyleSheet($xslt); // XSL Document importieren
		
		$xmlDoc = new DOMDocument();
		$xmlDoc->loadXML($xml->asXML());
		return $proc->transformToXML($xmlDoc);
		
		
	}
	
	function addChild($item, $key, $xml)
	{
		$xml->addChild($key,$item);
	}
}