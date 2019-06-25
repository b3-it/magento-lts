<?php

class Egovs_Paymentbase_Model_Sepa_Mandate_Pdf extends Egovs_Pdftemplate_Model_Pdf_Abstract
{
	protected $_callStack = array();
	
	public function push($value) {
		return array_push($this->_callStack, $value);
	}
	
	public function pop() {
		return array_pop($this->_callStack);
	}

	public function preparePdf($invoices = array()) {
		if (is_array($invoices) && !empty($invoices)) {
			$invoices = $invoices[0];
		}
		if (!($invoices instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Abstract) || empty($invoices)) {
			//Mage::throwException(Mage::helper('paymentbase')->__('No mandate instance available to create PDF document!'));
		}
		/* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate_Abstract */
		$mandate = $invoices;


		$mandate->setConfig($this->getConfig($mandate->getStoreId()));
		$mandate->setImprint($this->getImprint($mandate->getStoreId()));
		$mandate->setEPayblConfig($this->getEPayblConfig($mandate->getStoreId()));
		$this->LoadTemplate($mandate);
			
		$this->_Pdf->addPage();


		$this->RenderTable($mandate, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
		$this->_Pdf->lastPage();
		$this->_Pdf->ResetPagesSinceStart();

		return $this;
	}
	
	public function ifDirective($data, $construction) {
       $construction[1] = str_replace('[','.',$construction[1]);	
	   $construction[1] = str_replace(']','',$construction[1]);	
       $keys = explode('.', $construction[1]);
       $value = $this->extractData($data, $keys);
       if (!isset($value) || !$value) {
            if (isset($construction[3]) && isset($construction[4])) {
                return $construction[4];
            }
            return '';
        } else {
            return $construction[2];
        }
    }
    
    public function filter($object, $value)
    {
    	if (empty($value)) {
    		return $value;
    	}
    	
    	//zuerst die Blöcke einfügen
    	// "depend" and "if" operands should be first
    	foreach (array(
    			self::CONSTRUCTION_DEPEND_PATTERN => 'dependDirective',
    			//self::CONSTRUCTION_IF_PATTERN     => 'ifDirective',
    			//self::CONSTRUCTION_IFEQUAL_PATTERN=> 'ifequalDirective',
    	) as $pattern => $directive) {
    		if (preg_match_all($pattern, $value, $constructions, PREG_SET_ORDER)) {
    			foreach ($constructions as $index => $construction) {
    				$replacedValue = '';
    				$callback = array($this, $directive);
    				if (!is_callable($callback)) {
    					continue;
    				}
    				try {
    					$replacedValue = call_user_func($callback, $object, $construction);
    				} catch (Exception $e) {
    					throw $e;
    				}
    				$value = str_replace($construction[0], $replacedValue, $value);
    			}
    		}
    	}
    
    	$initPos = false;
    	$debug = '';
    	do {
    		$lastCount = count($this->_callStack);
    		//Negative lookbehind assertions funktionieren nicht korrekt in PHP 5.3.x (Getestet mit 5.3.10)
    		preg_match('/{{\/if\s*}}/si', $value, $matchIf, PREG_OFFSET_CAPTURE);
    		preg_match('/{{else}}/si', $value, $matchElse, PREG_OFFSET_CAPTURE);
    		preg_match('/{{if\s*(.*?)}}/si', $value, $construction, PREG_OFFSET_CAPTURE);
    		if (!empty($construction)
    			&& ((!empty($matchIf) && !empty($matchElse) && $construction[0][1] < $matchIf[0][1] && $construction[0][1] < $matchElse[0][1])
    				|| (!empty($matchIf) && empty($matchElse) && $construction[0][1] < $matchIf[0][1])
    				|| (empty($matchIf) && !empty($matchElse) && $construction[0][1] < $matchElse[0][1])
    				|| (empty($matchIf) && empty($matchElse))
    			)
    		) {
    			$debug = substr($value, $construction[0][1]);
    			$construction[1][0] = str_replace('[','.',$construction[1][0]);
    			$construction[1][0] = str_replace(']','',$construction[1][0]);
    			$keys = explode('.', $construction[1][0]);
    			$condv = $this->extractData($object, $keys);
    			$this->push(array('if'=>$condv, 'pos' => $construction[0][1]));
    			$value = substr_replace($value, '', $construction[0][1], strlen($construction[0][0]));
    			if ($initPos === false || $lastCount == 0) {
    				$initPos = $construction[0][1];
    			}
    			$debug = substr($value, $initPos);
    			continue;
    		}
    		
    		preg_match('/{{if\s*(.*?)}}/si', $value, $matchIf, PREG_OFFSET_CAPTURE);
    		preg_match('/{{else}}/si', $value, $construction, PREG_OFFSET_CAPTURE);
    		if (!empty($construction) && ((!empty($matchIf) && $construction[0][1] < $matchIf[0][1]) || empty($matchIf))) {
    			$cond = $this->pop();
    			if (!array_key_exists('if', $cond)) {
    				return Mage::helper('paymentbase')->__('Syntax error in PDF Template');
    			}
    			
    			$this->push($cond);
    			$this->push(array('else'=>true, 'pos' => $construction[0][1]));
    			$value = substr_replace($value, '', $construction[0][1], strlen($construction[0][0]));
    			$debug = substr($value, $initPos);
    			if (!isset($cond['if']) || !$cond['if']) {
    				$value = substr_replace($value, '', $cond['pos'], max(0, $construction[0][1]-$cond['pos']));
    				$debug = substr($value, $initPos);
    			}
    			continue;
    		}
    		 
    		preg_match('/{{if\s*(.*?)}}/si', $value, $matchIf, PREG_OFFSET_CAPTURE);
    		preg_match('/{{else}}/si', $value, $matchElse, PREG_OFFSET_CAPTURE);
    		preg_match('/{{\/if\s*}}/si', $value, $construction, PREG_OFFSET_CAPTURE);
    		if (!empty($construction)
    			&& ((!empty($matchIf) && !empty($matchElse) && $construction[0][1] < $matchIf[0][1] && $construction[0][1] < $matchElse[0][1])
    				|| (!empty($matchIf) && empty($matchElse) && $construction[0][1] < $matchIf[0][1])
    				|| (empty($matchIf) && !empty($matchElse) && $construction[0][1] < $matchElse[0][1])
    				|| (empty($matchIf) && empty($matchElse))
    				)
    		) {
    			$cond = $this->pop();
    			if (!array_key_exists('if', $cond) && !array_key_exists('else', $cond)) {
    				return Mage::helper('paymentbase')->__('Syntax error in PDF Template');
    			}
    			
    			$startPos = false;
    			$endPos = $construction[0][1]+strlen($construction[0][0]);
    			if (array_key_exists('else', $cond)) {
    				$startPos = $cond['pos'];
    			}
    			$cond = $this->pop();
    			if (!array_key_exists('if', $cond)) {
    				return Mage::helper('paymentbase')->__('Syntax error in PDF Template');
    			}
    			
    			if (!(!isset($cond['if']) || !$cond['if']) && $startPos !== false) {
    				$value = substr_replace($value, '', $startPos, max(0, $endPos-$startPos));
    				$debug = substr($value, $initPos);
    			} else {
    				$value = substr_replace($value, '', $construction[0][1], strlen($construction[0][0]));
    				$debug = substr($value, $initPos);
    			}
    			continue;
    		}
    		
    	} while (count($this->_callStack) != $lastCount);
    	
    	if (count($this->_callStack) > 0) {
    		$value = Mage::helper('paymentbase')->__('Syntax error in PDF Template');
    	}
    	return $value;
    }
    
	public function getPdf($objects = array()) {
		if (is_array($objects) && !empty($objects)) {
			$objects = $objects[0];
		}
		if (!($objects instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Interface) || empty($objects)) {
			///Mage::throwException(Mage::helper('paymentbase')->__('No mandate instance available to create PDF document!'));
		}
		return parent::getPdf(array($objects));
	}

	/**
	 * Interpretiert eine Template-Variable
	 * 
	 * Es wird versucht den Wert einer Template-Variable zu ermitteln
	 * 
	 * @param mixed $data Objektdaten
	 * @param array $keys Keys
	 * 
	 * @return string
	 * 
	 * @see Egovs_Pdftemplate_Model_Pdf_Abstract::extractData()
	 */
	protected function extractData($data, $keys = array()) {
		
		if (count($keys) == 0) {
			return null;
		}
		$key = array_shift($keys);
// 		Mage::log($key, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		if (is_array($data)) {
			if (isset($data[$key])) {
				$data = $data[$key];
			} else {
				return null;
			}
		} elseif (is_string($data)) {
			if (strlen($data) > (int)$key) {
				$data = mb_substr($data, (int)$key, 1, 'UTF-8');
			} else {
				return "&nbsp;";
			}
		} elseif ($data instanceof Varien_Object) {
			$tmp = $data->getData($key);
			if ($tmp === null) {
				$_s = strtolower($key);
				if (strpos($_s, 'is') !== 0) {
					$uckey = 'get'.uc_words($key, '');
				} else {
					$uckey = 'is'.uc_words(substr($key, 2), '');
					if (!method_exists($data, $uckey)) {
						$uckey = 'getIs'.uc_words(substr($key, 2), '');
					}
				}
				$tmp = null;
				try {
					$tmp = @$data->$uckey();
				} catch (Exception $e) {
					return '';
				}
				
			}
			$data = $tmp;
		} elseif (is_object($data)) {
			$_s = strtolower($key);
			if (strpos($_s, 'is') !== 0) {
				$uckey = 'get'.uc_words($key, '');
			} else {
				$uckey = 'is'.uc_words(substr($key, 2), '');
				if (!method_exists($data, $uckey)) {
					$uckey = 'getIs'.uc_words(substr($key, 2), '');
				}
			}
			$tmp = null;
			try {
				$tmp = @$data->$uckey();
			} catch (Exception $e) {
				return '';
			}
			if (!$tmp) {
				return '';
			}
			$data = $tmp;
		}

		if (count($keys) == 0) {
// 			Mage::log($data,Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			return $data;
		}

		return $this->extractData($data, $keys);
	}
}