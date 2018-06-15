<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Messagequeue
 * @name       	B3it_Messagequeue_Model_Queue_Processing_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Processing_Abstract extends Mage_Core_Model_Abstract
{
	
	const CONSTRUCTION_DEPEND_PATTERN = '/{{depend\s*(.*?)}}(.*?){{\/depend\s*}}/si';
	const CONSTRUCTION_IF_PATTERN = '/{{if\s*(.*?)}}(.*?)({{else}}(.*?))?{{\/if\s*}}/si';
	const CONSTRUCTION_IFEQUAL_PATTERN = '/{{ifequal\s*(.*?)}}(.*?)({{else}}(.*?))?{{\/ifequal\s*}}/si';
	const CONSTRUCTION_BLOCK_PATTERN = '/{{block\s*(.*?)}}(.*?){{\/block\s*}}/si';
	
	
	//operatoren für Vergleiche
	const OPERATOR_BOOL = "";
	const OPERATOR_NOTEQUAL = "!=";
	const OPERATOR_EQUAL = "==";
	
	public function replaceVariables($html,$data) {
		
		$html = $this->_filter($data, $html);
		$html = str_replace("\n", '', $html);
		preg_match_all("|{{(.*)}}|U", $html, $ausgabe, PREG_SET_ORDER);
	
		foreach ($ausgabe as $treffer) {
	
			//Typecast für formatierung suchen z.B. (price)12.00000
			preg_match_all("|\((.*)\)|U", $treffer[1], $cast, PREG_SET_ORDER);
			$format = "";
			if (count($cast) > 0) {
				$format = $cast[0][1];
				$treffer[1] = str_replace($cast[0][0], '', $treffer[1]);
			}
	
			$treffer[1] = str_replace('[','.',$treffer[1]);
			$treffer[1] = str_replace(']','',$treffer[1]);
			$keys = explode('.', $treffer[1]);
	
			$value = $this->_extractData($data, $keys);
				
	
			if ($value !== null) {
				if(is_array($value))
				{
					$linehtml = "";
					$parent = $treffer[1];
					preg_match_all("|{{".$parent."(.*)}}(.*){{/".$parent."}}|U",$html, $line, PREG_SET_ORDER);
					$parentline = $line[0][2];
					foreach($value as $item)
					{
						$data->setItem($item);
						$linehtml .= $this->replaceVariables($parentline,$data);
					}
					$html = str_replace($line[0][0], $linehtml, $html);
				}
				else
				{
					$html = str_replace($treffer[0], $this->_formatValue($value, $format), $html);
				}
			}
		}
	
		return $html;
	
	}
	
	protected function _formatValue($value,$format = "")
	{
		//falls keine Strasse angegeben wurde, kommt hier ein Array an: address->getStreet
		if(is_array($value)) {
			return "";
		}
	
		//objekte verwerfen ausser ZendDate mit format date
		if(($value instanceof Zend_Date) && ($format == 'date'))
		{
			return Mage::helper('core')->formatDate($value);
		}
	
		if (is_object($value)) {
			return "";
		}
		if(strlen($value) == 0) return "";
		switch ($format)
		{
			case "price": return $this->_formatPrice($value);
			case "int": return intval($value);
			case "date": return Mage::helper('core')->formatDate($value);
			case "datetime": return Mage::helper('core')->formatDate($value,Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, true);
	
		}
		if(strpos($format, 'format_') === 0)
		{
			$format = str_replace('format_', '%', $format);
			return sprintf($format,$value);
		}
		return $value;
	}
	
	
	protected function _formatPrice($value)
	{
	
		$currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
		return Mage::app()->getLocale()->currency($currency_code)->toCurrency($value, array());
	}
	
	
	
	
	protected function _filter($object, $value)
	{
		//wg. recursion
		$found = false;
		//zuerst die Blöcke einfügen
		// "depend" and "if" operands should be first
		foreach (array(
				self::CONSTRUCTION_DEPEND_PATTERN => '_dependDirective',
				//self::CONSTRUCTION_IF_PATTERN     => 'ifDirective',
				//self::CONSTRUCTION_IFEQUAL_PATTERN=> 'ifequalDirective',
		) as $pattern => $directive) {
			if (preg_match_all($pattern, $value, $constructions, PREG_SET_ORDER)) {
				foreach($constructions as $index => $construction) {
					$replacedValue = '';
					$callback = array($this, $directive);
					if(!is_callable($callback)) {
						continue;
					}
					try {
						$replacedValue = call_user_func($callback, $object, $construction);
					} catch (Exception $e) {
						throw $e;
					}
					$value = str_replace($construction[0], $replacedValue, $value);
					$found = true;
				}
			}
		}
		if($found)
		{
			return $this->_filter($object, $value);
		}
		return $value;
	}
	
	protected function _dependDirective($data, $construction)
	{
		$construction[1] = str_replace('[','.',$construction[1]);
		$construction[1] = str_replace(']','',$construction[1]);
		$keys = explode('.', $construction[1]);
		$value = $this->_extractData($data, $keys);
		if(!isset($value)) {
			return '';
		} else {
			return $construction[2];
		}
	}
	
	protected function _getConfig($store)
	{
		$config = array();
		//TCPDF unterstützt keinen leeren String als Imagepfad -> siehe Egovs_Pdftemplate_Model_Pdf_Renderer_Pdf::Image
		$config['logo'] = '';
		$image = Mage::getStoreConfig('sales/identity/logo', $store);
			
		if ($image) {
			$dir = Mage::getStoreConfig('system/filesystem/media', $store);
			$dir =  Mage::getConfig()->substDistroServerVars($dir);
			$image = $dir . '/sales/store/logo/' . $image;
			if (file_exists($image)) {
				$config['logo'] = $image;
			} else {
				Mage::log(sprintf("File '%s' doesn't exists", $image), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
				$config['logo'] =  '@' . base64_decode('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');
			}
		}
		$config['phone'] = Mage::getStoreConfig('sales/identity/phone', $store);
		$config['fax'] = Mage::getStoreConfig('sales/identity/fax', $store);
		$config['email'] = Mage::getStoreConfig('sales/identity/email', $store);
		$config['city'] = Mage::getStoreConfig('sales/identity/city', $store);
		$config['shortaddress'] = Mage::getStoreConfig('sales/identity/shortaddress', $store);
		$config['kostenstelle'] = Mage::getStoreConfig('sales/identity/kostenstelle', $store);
		$config['address'] = Mage::getStoreConfig('sales/identity/address', $store);
		$design = Mage::getDesign();
	
		$package =  Mage::getStoreConfig('design/package/name', $store);
		if(empty($package)){
			$package = null;
		}
		$design->setStore($store)
		->setArea('frontend')
		->setPackageName($package);
		$config['skinbasedir'] = $design->getSkinBaseDir();
	
		$dir = Mage::getStoreConfig('system/filesystem/media', $store);;
		$dir = realpath( Mage::getConfig()->substDistroServerVars($dir));
		$config['mediadir'] = $dir;
			
	
		return $config;
	}

	protected function _preProcessing($ruleset,$message,$data)
	{
		$results = array();
		 
		//testen ob Regel gilt:
		/** @var B3it_Messagequeue_Model_Queue_Rule $rule */
		foreach($ruleset->getRules() as $rule)
		{
			$value = $this->_getValue($rule->getSource(), $data);
			if($value)
			{
				$results[] = array('join' => $rule->getJoin(),'value'=>$this->_compareValue($value, $rule->getCompareValue(), $rule->getOperator()));
			}else{
				Mage::log('b3it MQ Value not found: ' .$rule->getSource(),Zend_Log::DEBUG);
			}
		}
	
		$res = array_shift($results);
		$res = $res['value'];
		foreach ($results as $tmp)
		{
			if($tmp['join'] == 'and'){
				$res = $res && $tmp['value'];
			}else if($tmp['join'] == 'or'){
				$res = $res || $tmp['value'];
			}
		}
	
		return $res;
	}
    
    protected function _compareValue($value, $compareTo, $operator)
    {
    	if(is_array($value))
		{
				foreach($value as $val)
				{
					if ($this->_compareValue($val, $compareTo, $operator)){
						return true;
					}
				}
				return false;
		}
		else
		{
	    	switch ($operator)
	    	{
	    		case 'eq' : return boolval($value == $compareTo);
	    		case 'neq' : return boolval($value != $compareTo);
	    		case 'lt' : return boolval($value < $compareTo);
	    		case 'gt' : return boolval($value > $compareTo);
	    	}
		}
    	
    	return false;
    }
    
    
    protected function _getValue($field,$data)
    {
    	$res = $this->_extractData($data, $keys);
    	return $res;
    }
    	
    protected function _extractData($data, $keys = array())
    {
    	if(count($keys) == 0) return null;
    	$key = array_shift($keys);
    
    	if(is_array($data))
    	{
    		if(isset($data[$key]))
    		{
    			$data = $data[$key];
    		}
    		else return null;
    	}
    	else if($data instanceof Varien_Object )
    	{
    		$tmp = $data->getData($key);
    		if($tmp === null)
    		{
    			$uckey = 'get'.uc_words($key,'');
    			$tmp = call_user_func(array($data,$uckey));
    		}
    		$data = $tmp;
    	}
    
    	if(count($keys) == 0) return $data;
    
    	return $this->_extractData($data,$keys);
    
    }
    
    protected function _processText($ruleset, $message, $data = null)
    {
    	$text = $ruleset->getTemplate();
    	if($data){
    		$text = $this->replaceVariables($text, $data);
    	}
    	$message->setContent($text);
    	
    	$text = $ruleset->getTemplateHtml();
    	if($data){
    		$text = $this->replaceVariables($text, $data);
    	}
    	$message->setContentHtml($text);
    }
    
}
