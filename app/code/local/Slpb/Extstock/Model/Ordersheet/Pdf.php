<?php

class Slpb_Extstock_Model_Ordersheet_Pdf extends Varien_Object
{
	protected $_page;
	private $_lineheight = 1.1;
	protected $_pdf = null;
	public $y =0;
	public $x =0;
	
	public function getPdf($orderSheets)
    {
        $this->_pdf = new Zend_Pdf();       
            $this->addPage();
            $collection = Mage::getResourceModel('extstock/journal_collection');
			$exp = new Zend_Db_Expr('format(qty_ordered / size.value,2)  as package ');
			$PackageSize = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'packaging_size');
			$collection->getSelect()
				   ->joinleft(array('size'=>'catalog_product_entity_varchar'),'size.entity_id = main_table.product_id AND size.attribute_id='.$PackageSize->getId(),array('size'=>'value'))
				   ->join('extstock2_stock_order','extstock2_stock_order.extstock_stockorder_id=main_table.deliveryorder_increment_id',array('desired_date'=>'desired_date','order_note'=>'note'))
				   ->columns($exp)
				   ->where('deliveryorder_increment_id=?',intval($orderSheets))
				   ->order('sku')
				   ;
            
            $this->y = $this->calcY(25);
            $this->x = $this->calcX(19);
            
            $this->_setFontRegular($this->_page);		
            $items = array_values($collection->getItems());
            
            
            
            if(count($items) > 0)
            {
            	$this->y = $this->calcY(25);
            	$this->drawDestination($items[0]->getOutputStockId());
            	$tmp_y = $this->_y;
            	$this->y = $this->calcY(25);
            	$this->drawSource($items[0]->getInputStockId());
            	
            	$this->_y = max(array($tmp_y,$this->_y));
            	$this->_y +=5;
            	$this->y -=15;
            	
            	$this->drawTextBlock(20, $this->_y + $this->getLineHeight(),180,100,$items[0]->getOrderNote());
            	
            	$this->_y +=5;
            	$this->y -=15;
            	$this->_setFontBold($this->_page);
            	$this->drawTextBlock(20, $this->_y + $this->getLineHeight(),200,100,"Lieferdatum: ".Mage::helper('core')->formatDate($items[0]->getDesiredDate()));
            	//$this->_page->drawText("Lieferdatum: ".Mage::helper('core')->formatDate($items[0]->getDesiredDate()), $this->calcX(20), $this->y, 'UTF-8');  
            	$this->drawTextBlock(120, $this->_y,200,100,"Bestelldatum: ".Mage::helper('core')->formatDate($items[0]->getDateOrdered()));
				//$this->_page->drawText("Bestelldatum: ".Mage::helper('core')->formatDate($items[0]->getDateOrdered()), $this->calcX(120), $this->y, 'UTF-8'); $this->y -=20;  
				
				
				$this->_setFontBold($this->_page);
				$this->drawTextBlock(20, $this->_y + $this->getLineHeight(),200,100,"Auftrag-Nr: ".$orderSheets);
				//$this->_page->drawText("Auftrag-Nr: ".$orderSheets, $this->calcX(20), $this->y, 'UTF-8');  $this->y -=20;
            }
            
            $this->_page->setLineColor(new Zend_Pdf_Color_GrayScale(0));
        	$this->_page->setLineWidth(0.5);
        	$this->_y +=5;
        	//$this->y -=250;
			$this->_drawHeader();
			
			$this->_setFontRegular($this->_page);
			$this->odd = true;	
            foreach ($items as $item){
                
            	if ($this->odd) {
                    $this->_page->setFillColor(new Zend_Pdf_Color_GrayScale(1));
                } else {
                    $this->_page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9));
                }
            	
        		$this->_drawItem($item);

            	if ($this->_y > 270) {
            		$this->_y = 20;
                    $this->_page = $this->newPage();
                }
            }
           // $this->insertTotals($this->_page,$invoice);
         
            $this->_setFontRegular($this->_page);
            $y = ($this->_page->getHeight() - $this->y + 20) * 0.3527;
            
            
            
        

        //$this->_afterGetPdf();

        return $this->_pdf;
    }
	
	protected function _drawHeader()
	{
			$y2 = $this->calcY($this->_y+5)+9;
			$y = $this->calcY($this->_y+5)-6;
			$this->_setFontBold($this->_page,8);
			$this->_page->setFillColor(new Zend_Pdf_Color_GrayScale(1));
			$this->_page->drawRectangle($this->calcX(19), $y2, $this->calcX(30), $y);
			$this->_page->drawRectangle($this->calcX(30), $y2, $this->calcX(42), $y);
			$this->_page->drawRectangle($this->calcX(42), $y2, $this->calcX(178), $y);
			$this->_page->drawRectangle($this->calcX(178), $y2, $this->calcX(190), $y);
			
			$this->_page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
			$this->_page->drawText("Menge", $this->calcX(20), $y+3, 'UTF-8');
			$this->_page->drawText("Art.-Nr.", $this->calcX(32), $y+3, 'UTF-8');
		 	$this->_page->drawText("Name", $this->calcX(45), $y+3, 'UTF-8');
		 	$this->_page->drawText("VPE", $this->calcX(180), $y+3, 'UTF-8'); 
		 
		 	$this->_y +=5;
	}
    
	protected function _drawItem($item)
	{
			$y2 = $this->calcY($this->_y+5)+9;
			$y = $this->calcY($this->_y+5)-6;
			$this->_page->drawRectangle($this->calcX(19), $y2, $this->calcX(30), $y);
			$this->_page->drawRectangle($this->calcX(30), $y2, $this->calcX(42), $y);
			$this->_page->drawRectangle($this->calcX(42), $y2, $this->calcX(178), $y);
			$this->_page->drawRectangle($this->calcX(178), $y2, $this->calcX(190), $y);
			$this->_page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
			$this->_page->drawText($item->getQtyOrdered(), $this->calcX(20), $y+3, 'UTF-8');
			$this->_page->drawText($item->getSku(), $this->calcX(32), $y+3, 'UTF-8');
			$name = $item->getProductname();
			if (strlen($name) > 70)
			{
				$name = substr($name, 0, 70) .'...';
			}
		 	$this->_page->drawText($name, $this->calcX(45), $y+3, 'UTF-8');	 
		 	$this->_page->drawText(number_format($item->getPackage(),2,',',''), $this->calcX(180), $y+3, 'UTF-8');
		 
		 $this->_y +=5;
	}
    
	
	
	
	
	private function drawDestination($id)
	{
		$x = 120;
		$stock = $this->getStock($id);
		$this->_setFontBold($this->_page);
		$this->_page->drawText(("Empfänger"), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		$this->_setFontRegular($this->_page);
		//$this->_page->drawText($stock->getAddressname(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		$this->drawTextBlock($x, 30,80,100,$stock->getAddressname());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getAddressname2());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getStreet());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getPostcode(). ' ' .$stock->getCity());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getPhone());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getFax());
		//$this->y -=10;
		//$this->_page->drawText($stock->getStreet() , $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPostcode(). ' ' .$stock->getCity(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPostcode(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPhone(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getFax(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getEmail(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),100,100,$stock->getEmail());
	}
    
	private function drawSource($id)
	{
		$x = 20;
		$stock = $this->getStock($id);
		$this->_setFontBold($this->_page);
		$this->_page->drawText("Absender", $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		$this->_setFontRegular($this->_page);
		//$this->_page->drawText($stock->getAddressname(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		
		//$this->_page->drawText($stock->getStreet() , $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPostcode(). ' ' .$stock->getCity(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPostcode(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getPhone(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->_page->drawText($stock->getFax(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->drawTextBlock($x, 47,100,100,$stock->getEmail());  
		$this->y -=35;
		
		$this->drawTextBlock($x, 30,80,100,$stock->getAddressname());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getAddressname2());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getStreet());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getPostcode(). ' ' .$stock->getCity());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getPhone());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),80,100,$stock->getFax());
		$this->drawTextBlock($x, $this->_y +  $this->getLineHeight(),100,100,$stock->getEmail());
		
		$this->_setFontBold($this->_page);
		//$this->_page->drawText($stock->getDeliveryHint(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		$y = $this->drawTextBlock($x, $this->_y +  40 ,180,100,$stock->getDeliveryHint());
		$this->_setFontRegular($this->_page);
		//$this->_page->drawText($stock->getDeliveryNote(), $this->calcX($x), $this->y, 'UTF-8');  $this->y -=10;
		//$this->drawTextBlock($x, $this->_y + $this->getLineHeight(),200,100,$stock->getDeliveryNote());

	}
	
	
	private function getStock($id)
	{
		$model = Mage::getModel('extstock/stock')->load($id);
		return $model;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	protected function addPage()
	{
		if($this->_pdf == null)
		{
			$pdf = new Zend_Pdf();
        	$this->_setPdf($pdf);
        	$style = new Zend_Pdf_Style();
        	$this->_setFontBold($style, 10);
		}
		 $this->_page = $this->_pdf->newPage(Zend_Pdf_Page::SIZE_A4);
         $this->_pdf->pages[] = $this->_page;
	}
	
	//alles was Kopf und Rand betrifft und 
	//auf einem Vordruck enthalten ist
	protected function insertGeneral($store)
	{
		 /* Add image */
	  	$image = Mage::getStoreConfig('sales/identity/logo', $store);
        if ($image) {
            $image = Mage::getStoreConfig('system/filesystem/media', $store) . '/sales/store/logo/' . $image;
            if (is_file($image)) {
                $image = Zend_Pdf_Image::imageWithPath($image);
                $this->_page->drawImage($image, $this->calcX(114),  $this->calcY(21), $this->calcX(198), $this->calcY(9));
            }
        }

         /* Add address */
         //$this->insertAddress($this->_page, $store);
         
        $this->_setFontBold($this->_page,18);
        $this->drawText(20,20,utf8_encode('S�chsische Landeszentrale f�r politische Bildung'));
         
         $this->insertMarginal($store);
         
         
         
	}
	
	protected function insertAdress(Mage_Sales_Model_Order_Address $address)
	{
		$this->_setFontRegular($this->_page, 9);
		$text = $address->format('pdf');
		$text = str_replace("\n",'',$text);
		$tmp = explode('|', $text);
		
		$text ='';
		foreach($tmp as $s)
		{
			$s = trim($s);
			if(strlen($s) != 0) {
				$text .= $s ."\n";
			}
		}
		//var_dump(explode("\n",$text)); die();
        $this->drawTextBlock(21,56,90,100,$text);	
        	
	}
	
	protected function insertSubject($subject)
	{
		$this->_setFontRegular($this->_page, 12);
		$font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $this->drawText(20,95,$subject);	
	}
	

	public function calcX($x)
	{
		return $x / 0.3527;
	}
	
	public function calcY($y)
	{
		return $this->_page->getHeight() - ($y / 0.3527);
	}
	
	public	function drawText($x,$y,$text,$alignRight=false)
	{
		
		$w = $this->getTextWidth($text);
		//$this->_x = $x + $w;
		if($alignRight)
		{
			$x = $x - $w;
			$this->_x = $x - $w;
		}
		$this->_page->drawText($text,$this->calcX($x),$this->calcY($y),'UTF-8');
		$this->y = $y;
	}
	
	public function getLineHeight()
	{
		$h = $this->_page->getFont()->getLineHeight()/$this->_page->getFont()->getUnitsPerEm() *  $this->_page->getFontSize();
	    return $h * 0.3527 * $this->_lineheight; 
	}
	
	
    /**
     * Create new page and assign to PDF object
     *
     * @param array $settings
     * @return Zend_Pdf_Page
     */
    public function newPage(array $settings = array())
    {
        /* Add new table head */
        $this->_page = $this->_pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        
        $this->_pdf->pages[] = $this->_page;
        $this->y = 800;

        $this->_page->setLineColor(new Zend_Pdf_Color_GrayScale(0));
        $this->_page->setLineWidth(0.5);
        $this->_drawHeader();
		$this->_setFontRegular($this->_page);
		
        return $this->_page;
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
	
	function drawTextBlock($x, $y, $width, $height, $text,$textWrap=false)
	{
		
		 $xpos = 0;
		 $ypos = 0;
		 $lines = explode("\n",$text);
 
		 foreach($lines as $line)
		 {
			 $text = explode(' ',$line);
			 foreach($text as $s)
			 {
			 	$w = $this->getTextWidth($s.' ');
			 	if(($xpos + $w) > $width){
			 		$xpos = 0;
			 		$ypos += $this->getLineHeight();
			 		
			 		if((($ypos + $y) > (($this->_page->getHeight() * 0.3527) -20)) && $textWrap) 
					 {
					 	$this->newPage();
					 	$ypos = 0;	
					 	$y = 25;
					 	$this->_setFontRegular($this->_page);
					 }
			 	}
			 	$this->_page->drawText($s,$this->calcX($x+$xpos),$this->calcY($y+$ypos),'UTF-8');
			 	$xpos += $w;
			 }
			 $xpos = 0;
			 $ypos += $this->getLineHeight();
			 if((($ypos + $y) > (($this->_page->getHeight() * 0.3527) -20)) && $textWrap) 
			{
			 	$this->newPage();
			 	$ypos = 0;
			 	$y = 25;
			 	$this->_setFontRegular($this->_page);	
			 }
		 }

		 $this->_y = $y + $ypos - $this->getLineHeight();
		 $this->_x = $x + $width;
	}
	
    protected function _setFontRegular($object, $size = 9)
    {
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA);
        $object->setFont($font, $size);
        return $font;
    }

    protected function _setFontBold($object, $size = 11)
    {
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD);
        $object->setFont($font, $size);
        return $font;
    }
    
    public function calcLineBlocks(Zend_Pdf_Page $page, array $draw, array $pageSettings = array())
    {
    	$y = 0;
        foreach ($draw as $itemsProp) {
            if (!isset($itemsProp['lines']) || !is_array($itemsProp['lines'])) {
                Mage::throwException(Mage::helper('sales')->__('Invalid draw line data. Please define "lines" array'));
            }
            $lines  = $itemsProp['lines'];
            $height = isset($itemsProp['height']) ? $itemsProp['height'] : 10;

            if (empty($itemsProp['shift'])) {
                $shift = 0;
                foreach ($lines as $line) {
                    $maxHeight = 0;
                    foreach ($line as $column) {
                        $lineSpacing = !empty($column['height']) ? $column['height'] : $height;
                        if (!is_array($column['text'])) {
                            $column['text'] = array($column['text']);
                        }
                        $top = 0;
                        foreach ($column['text'] as $part) {
                            $top += $lineSpacing;
                        }

                        $maxHeight = $top > $maxHeight ? $top : $maxHeight;
                    }
                    $shift += $maxHeight;
                }
                $itemsProp['shift'] = $shift;
            }

            /*
            if ($this->y - $itemsProp['shift'] < 15) {
                $page = $this->newPage($pageSettings);
            }
			*/
            foreach ($lines as $line) {
                $maxHeight = 0;
                foreach ($line as $column) {
                    $fontSize  = empty($column['font_size']) ? 7 : $column['font_size'];
                    if (!empty($column['font_file'])) {
                        $font = Zend_Pdf_Font::fontWithPath($column['font_file']);
                        $page->setFont($font);
                    }
                    else {
                        $fontStyle = empty($column['font']) ? 'regular' : $column['font'];
                        switch ($fontStyle) {
                            case 'bold':
                                $font = $this->_setFontBold($page, $fontSize);
                                break;
                            case 'italic':
                                $font = $this->_setFontItalic($page, $fontSize);
                                break;
                            default:
                                $font = $this->_setFontRegular($page, $fontSize);
                                break;
                        }
                    }

                    if (!is_array($column['text'])) {
                        $column['text'] = array($column['text']);
                    }

                    $lineSpacing = !empty($column['height']) ? $column['height'] : $height;
                    $top = 0;
                    foreach ($column['text'] as $part) {
                        $feed = $column['feed'];
                        $textAlign = empty($column['align']) ? 'left' : $column['align'];
                        $width = empty($column['width']) ? 0 : $column['width'];
                        switch ($textAlign) {
                            case 'right':
                                if ($width) {
                                    $feed = $this->getAlignRight($part, $feed, $width, $font, $fontSize);
                                }
                                else {
                                    $feed = $feed - $this->widthForStringUsingFontSize($part, $font, $fontSize);
                                }
                                break;
                            case 'center':
                                if ($width) {
                                    $feed = $this->getAlignCenter($part, $feed, $width, $font, $fontSize);
                                }
                                break;
                        }
                        
                        $top += $lineSpacing;
                    }

                    $maxHeight = $top > $maxHeight ? $top : $maxHeight;
                }
                
            }
        }

        return array('height' => $maxHeight, 'shift'=>$itemsProp['shift']);
    }
    
    
}