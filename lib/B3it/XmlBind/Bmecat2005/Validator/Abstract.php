<?php
abstract class  B3it_XmlBind_Bmecat2005_Validator_Abstract
{
	//die aus dem xml erzeugte Klasse
	protected $_xmlProduct = null;
	
	public function __construct($xml){
		$this->_xmlProduct = $xml;
	}
	
	public abstract function validate();
	public abstract function getMessages();
}