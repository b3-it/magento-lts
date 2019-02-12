<?php

/**
 * 
 *  Basisklasse zum Verarbeiten eines Templates zum Erzeugen von pdf's
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


class Egovs_Pdftemplate_Model_Pdf_Abstract extends Varien_Object
{
	const MODE_STANDARD = 0;
	const MODE_PREVIEW = 1;
	//const MODE_BATCH = 2;
	const MODE_EMAIL = 3;
	const MODE_DIRECT_OUTPUT = 4;
	
	const CONSTRUCTION_DEPEND_PATTERN = '/{{depend\s*(.*?)}}(.*?){{\/depend\s*}}/si';
    const CONSTRUCTION_IF_PATTERN = '/{{if\s*(.*?)}}(.*?)({{else}}(.*?))?{{\/if\s*}}/si';
    const CONSTRUCTION_IFEQUAL_PATTERN = '/{{ifequal\s*(.*?)}}(.*?)({{else}}(.*?))?{{\/ifequal\s*}}/si';
	const CONSTRUCTION_BLOCK_PATTERN = '/{{block\s*(.*?)}}(.*?){{\/block\s*}}/si';
	
	
	//operatoren für Vergleiche
	const OPERATOR_BOOL = "";
	const OPERATOR_NOTEQUAL = "!=";
	const OPERATOR_EQUAL = "==";
		
	
	protected $_Pdf = null;
	
	protected $_AdditionalItemBlocks = array();
	protected $_TemplateSections = array();
	protected $_Template = null;
	protected $_Order = null;
	protected $_Layout = null;
	
	
	public $Name = "Order.pdf";

	public $pages = array();
	public $Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_STANDARD;
	
    public function __construct()
    {
			$this->_Pdf = Mage::getModel('pdftemplate/pdf_renderer_pdf');
			
    }
    
    
    public function save($path)
    {
    	$m = $this->Mode;
    	$this->Mode = self::MODE_STANDARD;
    	$stream = $this->render();
    	$f = fopen($path, 'wb');
    	fwrite($f, $stream);
    	fclose($f);
    	$this->Mode = $m;
    }
    
    public function getPdf($objects = array())
    {
    	if(is_array($objects))
    	{
    		$this->pages = $objects;
    	}
    	else if (is_object($objects))
    	{
    		$this->pages = $objects->getItems();
    	}
    	return $this;
    }
    
	public function preparePdf($objects = array())
	{
		foreach ($objects as $object) 
		{
			//$this->PrintVariables($object);
			$this->_Order = $object->getOrder();
			
			
			$taxInfo = $this->_Order->getFullTaxInfo();       
	        
	        $this->_Order->setTaxInfo($taxInfo);
			$this->_Order->setTaxInfoArray($this->getTaxInfoArray($this->_Order));
			$this->_Order->setTotalsTaxInfoArray($this->getTotalsTaxArray($this->_Order));
			
			$this->normalize($this->_Order);
			$this->LoadTemplate($object);
			
			$this->_Pdf->addPage();
			$this->setLog("Erzeuge Pdf für ".$object->getIncrementId(). " OrderId: ". $this->_Order->getIncrementId());
			$this->RenderAddress($object,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS]);
			$this->RenderTable($object, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
			$this->_Pdf->ResetPagesSinceStart();
		}
		
		return $this;
	}
	
	protected function getTaxInfoArray($order)
	{
		$labels = Mage::getConfig()->getNode('global/pdftemplate_taxlabels/taxlabels')->asArray();
		$res = array();
		foreach ($labels AS $l)
		{
			$res[intval($l['percent'])] = array('title'=>$l['title'],'amount'=>$l['amount']);
		}
		$taxRates = $order->getFullTaxInfo();
		foreach ($taxRates as $tax)
		{
			$res[intval($tax['percent'])] = array('title'=>$tax['rates'][0]['title'],'amount'=>$tax['amount']);
		}
		return $res;
	}
	
	protected function getTotalsTaxArray($order)
	{
		$res = array();
		$vals = array();
		$taxRates = $order->getFullTaxInfo();
		foreach ($taxRates as $tax)
		{
			foreach($tax['rates'] as $rate)
			{
				$amount = $tax['amount'];
				if($amount > 0)
				{
					$vals[] = $rate['percent'];
					$res[] = array('percent'=>$rate['percent'], 'title'=>$rate['title'],'amount'=>$tax['amount']);
				}
			}
		}
		array_multisort($vals, SORT_ASC, $res);
		return $res;
	}
	
	protected function normalize($order)
	{
		/* @var $order Mage_Sales_Model_Order */
		if($order->getShippingAddress() && $order->getShippingAddress()->getCountry() )
		{
			$countryName = Mage::getModel('directory/country')->load($order->getShippingAddress()->getCountry())->getName();
			$order->getShippingAddress()->setCountryName($countryName);
		}
		if($order->getBillingAddress() && $order->getBillingAddress()->getCountry() )
		{
			$countryName = Mage::getModel('directory/country')->load($order->getBillingAddress()->getCountry())->getName();
			$order->getBillingAddress()->setCountryName($countryName);
		}
		
		if($order->getIsVirtual())
		{
			$base = null;
			foreach($order->getAddressesCollection() as $adr)
			{
			
				if($adr->getAddressType() == 'base_address')
				{
					$base = $adr;
					break;
				}
			}
			
			
			if($base)
			{
				$countryName = Mage::getModel('directory/country')->load($base->getCountry())->getName();
				$base->setCountryName($countryName);
				$order->setRecipientAddress($base);
			}
			else
			{
				$order->setRecipientAddress($order->getBillingAddress());
			}
		}
		else
		{
			$order->setRecipientAddress($order->getShippingAddress());	
		}
		
		return $this; 
	}

	public function setDefaultFont($font,$fontsize)
	{
		$font = Egovs_Pdftemplate_Model_Font::getFontName($font);
		$this->_Pdf->SetFont($font, '', $fontsize, '', true);
	}
	
	public function render()
	{
		$this->preparePdf($this->pages);
		if($this->Mode == Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW)
		{
			$this->_Pdf->Output($this->Name, 'I');
		}
		else if($this->Mode == Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_EMAIL)
		{
			return $this->_Pdf->Output($this->Name, 'S');
		}
		else if($this->Mode == Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_DIRECT_OUTPUT)
		{
			$this->_Pdf->Output($this->Name, 'D');
		}
		else 
		{
			return $this->_Pdf->Output($this->Name, 'S');
		}
	}
	
	protected function LoadTemplate($object)
	{
		$id = $object->getTemplateId();
		if ((($this->_Template == null) || ($this->_Template->getId() != $id)) && $id) {
			/* @var $col Egovs_Pdftemplate_Model_Mysql4_Section_Collection */
			$col  = Mage::getModel('pdftemplate/section')->getCollection();
			$sections = $col->getByTemplateId($id);
			if (!empty($sections)) {
				$this->_TemplateSections = $sections;
				
				
				$this->_Template = Mage::getModel('pdftemplate/template')->load($id);
				$this->setDefaultFont($this->_Template->getFont(),$this->_Template->getFontsize());
				
				$this->_Pdf->HeaderSection = $this->prepareTemplate($object, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER]);
				$this->_Pdf->MarginalSection = $this->prepareTemplate($object,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL]);
				$this->_Pdf->FooterSection = $this->prepareTemplate($object,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER]);
			} else {
				$id = false;
			}
		}
		
		if (!$id) {
			$emptySections = array();
			$emptySections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER] = Mage::getModel('pdftemplate/template',
					array(
							'content' => '<table><tr><td>'.Mage::helper('pdftemplate')->__('Error').'</td></tr></table>',
							'top' => 10,
							'left' => 20,
							'width' => 210,
							'height' => 30,							
					)
			);
			$emptySections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL] = Mage::getModel('pdftemplate/template',
					array(
							'content' => '',
							'top' => 50,
							'left' => 162,
							'width' => 0,
							'height' => 0,
					)
			);
			$emptySections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS] = Mage::getModel('pdftemplate/template',
					array(
							'content' => '',
							'top' => 50,
							'left' => 22,
							'width' => 38,
							'height' => 0,
					)
			);
			$emptySections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY] = Mage::getModel('pdftemplate/template',
					array(
							'content' => Mage::helper('pdftemplate')->__('There is no template configured for this customer group!'),
							'top' => 50,
							'left' => 22,
							'width' => 0,
							'height' => 0,
					)
			);
			$emptySections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER] = Mage::getModel('pdftemplate/template',
					array(
							'content' => '<table><tr><td>'.Mage::helper('pdftemplate')->__('Error').'</td></tr></table>',
							'top' => 285,
							'left' => 22,
							'width' => 0,
							'height' => 0,
					)
			);
			
			$this->_TemplateSections = $emptySections;
			
			$this->_Template = Mage::getModel('pdftemplate/template');
			$this->setDefaultFont($this->_Template->getFont(),$this->_Template->getFontsize());
				
			$this->_Pdf->HeaderSection = $this->prepareTemplate($object, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_HEADER]);
			$this->_Pdf->MarginalSection = $this->prepareTemplate($object,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_MARGINAL]);
			$this->_Pdf->FooterSection = $this->prepareTemplate($object,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_FOOTER]);
		}
		
	}
	
	
	protected function RenderAddress($object,$template)
	{
		$this->RenderEntity($object, $template);
		return $this;
	}
	
	protected function prepareTemplate($object,$template)
	{
		if (!$template) {
			Mage::throwException(Mage::helper('pdftemplate')->__('No template given.'));
		}
		$html = $template->getContent();
		$html = str_replace("\n", '', $html);
		$html = $this->replaceBlocks($object,$html);
		$html = $this->replaceVariables($object,$html);
		$template->setContent($html);
		return $template;
	}
	
	private function replaceBlocks($object, $html)
	{
		foreach (array(   
            self::CONSTRUCTION_BLOCK_PATTERN    => 'blockDirective',
            ) as $pattern => $directive) {
            if (preg_match_all($pattern, $html, $constructions, PREG_SET_ORDER)) {
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
                    $html = str_replace($construction[0], $replacedValue, $html);
                }
            }
        }
        return $html;
	}
	
	
    public function filter($object, $value)
    {
    	//wg. recursion
    	$found = false;
    	//zuerst die Blöcke einfügen
        // "depend" and "if" operands should be first
        foreach (array(
            self::CONSTRUCTION_DEPEND_PATTERN => 'dependDirective',
            self::CONSTRUCTION_IF_PATTERN     => 'ifDirective',
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
        	return $this->filter($object, $value);
        }
        return $value;
    }
    
    public function dependDirective($data, $construction)
    {
    	$construction[1] = str_replace('[','.',$construction[1]);	
	    $construction[1] = str_replace(']','',$construction[1]);	
    	$keys = explode('.', $construction[1]);
        $value = $this->extractData($data, $keys);
        if(!isset($value)) {
            return '';
        } else {
            return $construction[2];
        }
    }
    
 	public function blockDirective($data, $construction)
    {
    	$res = '';
    	if(isset($construction[2]))	
    	{
    		$ident = explode(',',$construction[2]);
        	foreach($ident as $id)
        	{
    			$model = Mage::getModel('pdftemplate/blocks');
    			$res .= $model->getBlock(trim($id),$data);
        	}
    	}
    	return $res;
    }

    public function ifDirective($data, $construction)
    {
       $construction[1] = str_replace('[','.',$construction[1]);	
	   $construction[1] = str_replace(']','',$construction[1]);

	   $expr = $construction[1];
	   
	   $operator = self::OPERATOR_BOOL;
	   if (strpos($expr, self::OPERATOR_EQUAL) !== false){
	   		$operator = self::OPERATOR_EQUAL;
	   }
	   if (strpos($expr, self::OPERATOR_NOTEQUAL) !== false){
	   		$operator = self::OPERATOR_NOTEQUAL;
	   }
   
	   if($operator != self::OPERATOR_BOOL){   
       		$keys = explode($operator, $construction[1]);
       		$value = $this->extractData($data, explode('.', $keys[0]));
	   		switch ($operator)
	   		{
	   			case self::OPERATOR_EQUAL: $flag = ($value == $keys[1]); break;
	   			case self::OPERATOR_NOTEQUAL: $flag = ($value != $keys[1]); break;
	   		}
	   }
	   else 
	   {
	   		
	   		$value = $this->extractData($data, explode('.', $construction[1]));
	   		$flag = isset($value);
	   }
       
       if(!$flag) {
            if (isset($construction[3]) && isset($construction[4])) {
                return $construction[4];
            }
            return '';
        } else {
            return $construction[2];
        }
    }
    
    public function ifequalDirective($data, $construction)
    {
      
        /**
         * Check if the construct i wellformed
         */
        $equal = explode(' ', $construction[1]);
        if (count($equal) === 2){
            /**
             * Retrieve both variables for equality check
             */
            $var_a = array_shift($equal);
            $var_a = str_replace('[','.',$var_a);	
	   		$var_a = str_replace(']','',$var_a);	
       		$keys = explode('.', $var_a);
       		$var_a = $this->extractData($data, $keys);
            $var_b = array_shift($equal);
           
            if($var_a == '' OR $var_b == '' OR $var_a != $var_b) {
                /**
                 * We have verified that the equality don't match
                 * so we return the text between {{else}} ... {{/if}}
                 */
                if (isset($construction[3]) && isset($construction[4])) {
                    return $construction[4];
                }
                return '';
            } else {
                /**
                 * We have verified the equality
                 * so we return the text between {{ifequal data.foo data.bar}} ... {{else}}
                 */
                return $construction[2];
            }
        } else {
            /**
             * If the construct is malformed return ''
             */
            return '';
        }
    }
	
 
    
    /**
     * Einlesen der Blöcke für individuelle Produktoptionen
     * @param Varien_Object $orderItem
     * @return string:
     */
    protected function getAdditionalItemInfoBlock($item)
    {
    	$this->loadLayout('pdftemplate_pdf_item_renderer');
    	$block = $this->getLayout()->getBlock('pdftemplate_pdf_item_renderer');
    	if ($block)
    	{
	    	$itemBlock = $block->getItemRenderer($this->_getItemType($item), $this->getLayout());
	    	if($itemBlock)
	    	{
	    		$itemBlock->setItem($item);
	    		return $itemBlock->toHtml();
	    	}
    	}
   	
    	return '';
    }

    
    public function getLayout()
    {
    	if($this->_Layout == null)
    	{
    		$this->_Layout = Mage::getModel('core/layout');
    		//$this->_Layout->setArea('frontend');
    	}
    	return $this->_Layout;
    }
    
    /**
     * Load layout by handles(s)
     *
     * @param   string $handles
     * @param   string $cacheId
     * @param   boolean $generateBlocks
     * @return  Mage_Core_Controller_Varien_Action
     */
    public function loadLayout($handles=null, $generateBlocks=true, $generateXml=true)
    {
    	// if handles were specified in arguments load them first
    	if (false!==$handles && ''!==$handles) {
    		$this->getLayout()->getUpdate()->addHandle($handles ? $handles : 'default');
    	}
    
    	// add default layout handles for this action
    	$this->addActionLayoutHandles();
    
    	$this->getLayout()->getUpdate()->load();
    
    	$this->getLayout()->generateXml();
    	
    	$this->getLayout()->generateBlocks();
    	
    
    	return $this;
    }
    
    public function addActionLayoutHandles()
    {
    	$update = $this->getLayout()->getUpdate();
    
    	// load store handle
    	$update->addHandle('STORE_'.Mage::app()->getStore()->getCode());
    
    	// load theme handle
    	$package = Mage::getSingleton('core/design_package');
    	$update->addHandle(
    			'THEME_'.$package->getArea().'_'.$package->getPackageName().'_'.$package->getTheme('layout')
    	);
    
    
    	return $this;
    }
    
   
    
    
    
    
    

    
    
    /**
     * Return product type for quote/order item
     *
     * @param Varien_Object $item
     * @return string
     */
    protected function _getItemType(Varien_Object $item)
    {
    	if ($item->getOrderItem()) {
    		$type = $item->getOrderItem()->getProductType();
    	} elseif ($item instanceof Mage_Sales_Model_Quote_Address_Item) {
    		$type = $item->getQuoteItem()->getProductType();
    	} else {
    		$type = $item->getProductType();
    	}
    	return $type;
    }
    
    /**
     * Get item row html
     *
     * @param   Varien_Object $item
     * @return  string
     */
    public function getItemPdf(Varien_Object $item)
    {
    	$type = $this->_getItemType($item);
    
    	$block = $this->getItemRenderer($type)
    	->setItem($item);
    	return $block->toHtml();
    }
    
    
    /**
     * Rendert die einzelen Items in einer Schleife
     * 
     * @param Varien_Object                             $object       die Rechnung/Gutschrift/Lieferung
     * @param Egovs_Pdftemplate_Model_Template          $template     das Template
     * @return Egovs_Pdftemplate_Model_Pdf_Abstract
     */
	protected function RenderTable($object,$template)
	{
		$html = $template->getContent();
		$html = str_replace("\n", '', $html);
		$html = $this->replaceBlocks($object,$html);
		$left = intval($template->getLeft());
		$top = intval($template->getTop());
		$width = intval($template->getWidth());
		$height = intval($template->getHeight());
		
		//preg_match_all("|{{items}}(.*){{items}}|U",$html, $line, PREG_SET_ORDER);
		preg_match_all("|{{items(.*)}}(.*){{items}}|U",$html, $line, PREG_SET_ORDER);

		$showChilds = (count($line) > 0 ) && ((trim($line[0][1]) == 'include_childs') ||  (trim($line[0][1]) == 'include_children'));
		
		$linehtml ="";
		$odd = true;
		if (count($line) == 1) {
			
			$pos = 0;
			$childpos = 0;
			$items = $object->getAllItems();
			if (!$items) {
				$items = array();
			}
			$parentline = $line[0][2];
			
			foreach ($items as $item) {
				/*@var $item Mage_Sales_Model_Order_Invoice_Item */
				$oi = $item->getOrderItem();
				if($oi != null)
				{
					$item->setProductType($oi->getProductType());
					
					$item->setIsChild($oi->getParentItem()!= null);
	                if ($oi->getParentItem()) {
	                   if(!$showChilds){
	                   		continue;
	                   }
	                   $childpos++;
	                }else
	                {
	                	$pos++;
	                	$childpos = 0;
	                }
				}
                
                $item->setPosition($pos);
				$item->setChildPosition($childpos);
                
                if($odd) { $item->setOdd(true);}
                $odd = ! $odd;
                $additional = $this->getAdditionalItemInfoBlock($item);
                $item->setAdditionalItemData($additional);

                $linehtml .= $this->replaceVariables($item,$parentline);
                
			}
			
			$html = str_replace($line[0][0], $linehtml, $html);
		}
		
		
		$html = $this->replaceVariables($object,$html);
		
		//try 
		{
			$this->_Pdf->writeHTMLCell($width, $height, $left, $top, $html,0,'J',0);
		}
    	//catch (Exception $ex)
    	{
    		//$ex->setMessage($ex->getMessage()." " .htmlentities($html));
    		//Mage::logException($ex);
    	}
    	
    	
		$this->_Pdf->lastPage();
		return $this;
	}
	
	protected function RenderEntity($data,$template)
	{
		$html = $template->getContent();
		$html = str_replace("\n", '', $html);
		$html = $this->replaceBlocks($data,$html);
		$html = $this->replaceVariables($data,$html);
		$left = intval($template->getLeft());
		$top = intval($template->getTop());
		$width = intval($template->getWidth());
		$height = intval($template->getHeight());
		
		try 
		{
			$this->_Pdf->writeHTMLCell($width, $height, $left, $top, $html);
		}
		catch (Exception $ex)
    	{
    		//$ex->setMessage($ex->getMessage()." " .htmlentities($html));
    		//Mage::logException($ex);
    	}
	}
	
	
	protected function replaceVariables($data, $html) {
		$html = $this->filter($data, $html);
		
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
			//$value = $data->getData($treffer[1]);
			$value = $this->extractData($data, $keys);
			if (!($this->Mode == Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW) && $value === null) $value = "";
				
			if ($value !== null) {
				$html = str_replace($treffer[0], $this->formatValue($value, $format), $html);
			}
		}

		return $html;

	}
	
	protected function formatValue($value,$format = "")
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
		if($this->_Order)
		{
			return $this->_Order->formatPrice($value);
		}
		$currency_code = Mage::app()->getStore()->getCurrentCurrencyCode();
		return Mage::app()->getLocale()->currency($currency_code)->toCurrency($value, array());
	}
	
	
	protected function extractData($data, $keys = array())
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
		
		return $this->extractData($data,$keys);
		
	}
	
	
   	protected function getConfig($store)
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
    
    
    protected function getImprint($store)
    {  
    	$imprint = Mage::getStoreConfig('general/imprint', $store);

    	return $imprint;
    }
    
    protected function getEPayblConfig($store)
    {
    	$imprint = Mage::getStoreConfig('payment_services/paymentbase', $store);
    	return $imprint;
    }
    
    protected function getSepaDebitBund($store)
    {
    	$imprint = Mage::getStoreConfig('payment/sepadebitbund', $store);
    	return $imprint;
    }
    
    protected function getSepaDebitSax($store)
    {
    	$imprint = Mage::getStoreConfig('payment/sepadebitsax', $store);
    	return $imprint;
    }
    
    
    private function PrintVariables($object)
    {
		$this->PrintVariable($object,'');
    	$this->PrintVariable($object->getOrder(),'order.');
    	$this->PrintVariable($object->getShippingAddress(),'shipping_address.');
    	$this->PrintVariable($object->getBillingAddress(),'billing_address.');
    	$this->PrintVariable($this->getConfig(0),'config.');
    	
    	$items = $object->getAllItems();
    	$item =$items[0];
    	$this->PrintVariable($item->getData(),'innerhalb von {{items}}: ');
		die();
    }
    
    private function PrintVariable($object,$name)
    {
    	if(is_array($object))
    	{
    		$data = $object;
    	}
    	else
    	{
    		$data = $object->getData();

    	}
    	foreach ($data as $key => $value) 
    	{
    		echo $name.$key."<br>";
    	}
    }
    
    
    
    
}