<?php

class Egovs_Base_Model_Sales_Order_Pdf_Addresslabel extends Mage_Sales_Model_Order_Pdf_Abstract
{
    public function getPdf($addresses = array())
    {
        $this->_beforeGetPdf();

        $pdf = new Zend_Pdf();
        $this->_setPdf($pdf);
       
        $x = 20;
        $y = 130;
      
        foreach ($addresses as $adr) 
        {
        	if(is_array($adr))
        	{
	       		foreach ($adr as $a)
		        {
		        	
        			$page = $pdf->newPage(294,155);
        			$pdf->pages[] = $page; 
		    		$this->printAddress($page,$a,$x,$y);         
		        }
        	}
        	else
        	{
        		
        		$page = $pdf->newPage(270,140);
        		$pdf->pages[] = $page; 
        		$this->printAddress($page,$adr,$x,$y);
        	}
        }

        $this->_afterGetPdf();

        return $pdf;
    }

    
    protected function printAddress(&$page, $address, $x, $y)
    {
    	$zeile = 10;
       	
 
       	$this->_setFontRegular($page, 7);
    	$store = Mage::app()->getStore();
        $page->drawText(trim(strip_tags( Mage::getStoreConfig('sales/identity/labeladdress', $store))), $x, $y, 'UTF-8');
       	$y -= $zeile;
       
        
        $this->_setFontRegular($page, 10);
    
        $page->drawText(trim(strip_tags( Mage::getStoreConfig('sales/identity/kostenstelle', $store))), $x, $y, 'UTF-8'); 
        $page->drawText($address->getId(), $x + 180, $y, 'UTF-8'); 
        $y -= $zeile;
        $y -= $zeile;
        
        

       	$text =  trim($address->getCompany());
       	if(strlen($text) > 0)
		{
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
		$text = trim($address->getCompany2());
		if(strlen($text) > 0)
		{
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
		$text =  trim($address->getCompany3());
		if(strlen($text) > 0)
		{
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
		$text =  trim($address->getPrefix(). ' '.$address->getFirstname().' '.$address->getLastname());
		if(strlen($text) > 0)
		{
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
		$streets = $address->getStreet();
		
		foreach ($streets as $text) {
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
		$text = $address->getPostcode().' ' . $address->getCity();
		$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		
		
		$text = $address->getCountryModel()->getName();
		if($text != 'Deutschland')
		{
			$y = $this->drawTextWrap($page,$x, $y, 240, strip_tags(ltrim($text))); 
		}
		
    }
    
    
	private function drawTextWrap($page, $x, $y, $width, $text)
	{
		 $text = html_entity_decode($text,ENT_NOQUOTES,'UTF-8');
		 $this->_page = $page;
		 $xpos = 0;
		 $ypos = 0;
		 $lh = 10;
		 
		 $text = explode(' ',$text);
		 foreach($text as $s)
		 {
		 	$w = $this->getTextWidth($s.' ') / 0.35;
		 	if(($xpos + $w) > $width)
		 	{
		 		$xpos = 0;
		 		$ypos += $lh;//$this->getLineHeight();
		 		
		 	}
		 	$page->drawText($s,$x+$xpos,$y-$ypos,'UTF-8');
		 	$xpos += $w;
		 }
		 return $y - $ypos - $lh; //$this->getLineHeight();
	}
    
    
    
    /**
     * Create new page and assign to PDF object
     *
     * @param array $settings
     * @return Zend_Pdf_Page
     */
    public function newPage(array $settings = array())
    {
        if (!empty($settings) && is_string($settings)) {
            $pageSize = $settings;
        } else {
            $pageSize = !empty($settings['page_size']) ? $settings['page_size'] : Zend_Pdf_Page::SIZE_A4;
        }
        $page = $this->_getPdf()->newPage($pageSize);
        $this->_getPdf()->pages[] = $page;
        $this->y = 800;

        return $page;
    }
    
	function getTextWidth($text)
	{
		$font = $this->_page->getFont();
		$fontSize = $this->_page->getFontSize();
	
		$drawingString = iconv('UTF-8', 'UTF-16BE', $text);
	     $characters = array();
	     for ($i = 0, $iMax = strlen($drawingString); $i < $iMax; $i++) {
		         $characters[] = (ord($drawingString[$i++]) << 8) | ord
			($drawingString[$i]);
		     }
		
	     $glyphs = $font->glyphNumbersForCharacters($characters);
	     $widths = $font->widthsForGlyphs($glyphs);
	     $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) *  $fontSize;
	     return $stringWidth * 0.3527; 
	}
}