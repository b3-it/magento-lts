<?php
class Egovs_Paymentbase_Model_Payplace_Api_Wsdl_Config_Element extends Mage_Api_Model_Wsdl_Config_Element
{
	/**
	 * Return attributes of all namespaces
	 *
	 * array(
	 *   namespace => array(
	 *     attribute_key => attribute_value,
	 *     ...
	 *   )
	 * )
	 *
	 * @param Varien_Simplexml_Element $source
	 * @return array
	 */
	public function getAttributes($source, $namespace = null)
	{
		$attributes = array();
		if (!is_null($namespace)) {
			$attributes[$namespace] = $source->attributes($namespace);
			return $attributes;
		}
		$namespaces = $source->getNamespaces(true);
		$attributes[''] = $source->attributes('');
		foreach ($namespaces as $key => $value) {
			if ($key == '' || $key == 'soap') {
				continue;
			}
			$attributes[$value] = $source->attributes($value);
		}
	
		/*
	 	 * http://stackoverflow.com/questions/6927567/adding-a-namespace-when-using-simplexmlelement
	 	 * http://stackoverflow.com/questions/1592665/unable-add-namespace-with-phps-simplexml
	 	 */	
		$dom = new DOMDocument();
		@$dom->loadXML($source->asXML());
		$context = $dom->documentElement;
		$xpath = new DOMXPath($dom);
		foreach( $xpath->query('namespace::*', $context) as $node ) {
			if (!$node) continue;
			$nodeName = $node->nodeName;
			$nodeName = str_replace('xmlns:', '', $nodeName);
			if ($nodeName == 'xml') continue;
			if (!isset($attributes[$node->nodeValue])) {
				$attributes[$node->nodeValue] = array("dummy" => "");
			}
		}
	
		return $attributes;
	}
}