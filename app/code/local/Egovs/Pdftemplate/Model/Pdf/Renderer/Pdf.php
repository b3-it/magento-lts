<?php
/**
 *
 *  Der Renderer der einzelen Teile in das eigentlichen pdf
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

set_include_path(get_include_path().PS.Mage::getBaseDir('lib').DS.'tcpdf');
//require_once(Mage::getBaseDir('lib').DS.'tcpdf'.DS.'config'.DS.'lang'.DS.'eng.php');
require_once('tcpdf.php');

class Egovs_Pdftemplate_Model_Pdf_Renderer_Pdf extends TCPDF
{
	public $HeaderSection = null;
	public $MarginalSection = null;
	public $FooterSection = null;
	private $_PagesSinceStart = 0;
	private $_ResetPagesSinceStart = false;
	
    public function __construct()
    {
			parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
			$this->setMeta();	
			//$this->SetLineWidth(0.2);
    }
    
   
    public function Header()
    {
    	
    	if($this->HeaderSection)
    	{
    		$left = intval($this->HeaderSection->getLeft());
			$top = intval($this->HeaderSection->getTop());
			$width = intval($this->HeaderSection->getWidth());
			$height = intval($this->HeaderSection->getHeight());
    		
    		
    		if(($this->HeaderSection->getOccurrence() == 0) || ($this->_PagesSinceStart == 0) )
    		{
		    	$html = $this->HeaderSection->getContent();
				
		    	try 
		    	{
					$this->writeHTMLCell($width, $height, $left, $top, $html);
		    	}
		    	catch (Exception $ex)
		    	{
		    		echo $ex->getMessage();
		    		echo "<br>";
		    		die(htmlentities($html));
		    	}
				
    		}
    		$this->theadMargins['top'] = $top + $height;
    		//$this->SetXY($this->original_lMargin, $top + $height);
    	}
    	
    	if($this->MarginalSection)
    	{
    		if(($this->MarginalSection->getOccurrence() == 0) || ($this->_PagesSinceStart == 0) )
    		{
		    	$html = $this->MarginalSection->getContent();
				$left = intval($this->MarginalSection->getLeft());
				$top = intval($this->MarginalSection->getTop());
				$width = intval($this->MarginalSection->getWidth());
				$height = intval($this->MarginalSection->getHeight());
				
				try 
				{
					$this->writeHTMLCell($width, $height, $left, $top, $html);
				}
    			catch (Exception $ex)
		    	{
		    		echo $ex->getMessage();
		    		echo "<br>";
		    		die(htmlentities($html));
		    	}
    		}
    	}
    }
    
    public function startPage($orientation='', $format='', $tocpage=false) 
    {	
    	parent::startPage($orientation, $format, $tocpage);
    	$this->_PagesSinceStart++;
    }
    
    public function ResetPagesSinceStart()
    {
    	$this->_ResetPagesSinceStart = true;
    }
    
    public function Footer()
    {
    	if($this->FooterSection)
    	{
    		if(($this->FooterSection->getOccurrence() == 0) || ($this->_PagesSinceStart == 1) )
    		{
		    	$html = $this->FooterSection->getContent();
				$left = intval($this->FooterSection->getLeft());
				$top = intval($this->FooterSection->getTop());
				$width = intval($this->FooterSection->getWidth());
				$height = intval($this->FooterSection->getHeight());
				
				
				$this->writeHTMLCell($width, $height, $left, $top, $html);
    		}
    	}
    	if($this->_ResetPagesSinceStart)
    	{
    		$this->_PagesSinceStart = 0;
    	}
    	else 
    	{
    		$this->_PagesSinceStart++;
    	}
    	
    	$this->_ResetPagesSinceStart  = false;
    }
    
    private function setMeta()
    {
    	// set document information
		//$this->SetCreator(PDF_CREATOR);
		//$this->SetAuthor('Nicola Asuni');
		//$this->SetTitle('TCPDF Example 065');
		//$this->SetSubject('TCPDF Tutorial');
		//$this->SetKeywords('TCPDF, PDF, example, test, guide');
		
		// set default header data
		//$this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 065', PDF_HEADER_STRING);
		$this->SetHeaderData(K_BLANK_IMAGE, 0, '065', PDF_HEADER_STRING);
		// set header and footer fonts
		//$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$this->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		global $l;
		$this->setLanguageArray($l);
		
		// set default font subsetting mode
		$this->setFontSubsetting(true);
		
		// Set font
		$this->SetFont('helvetica', '', 10, '', true);
		//$this->AddPage();
		
		//$this->writeHTMLCell(0, 0, '', '', '<h1>'.time().'</h1>', 0, 1, 0, true, '', true);
    }    
   
    /**
     * This method is automatically called in case of fatal error; it simply outputs the message and halts the execution. An inherited class may override it to customize the error handling but should always halt the script, or the resulting document would probably be invalid.
     * 2004-06-11 :: Nicola Asuni : changed bold tag with strong
     * @param $msg (string) The error message
     * @public
     * @since 1.0
     */
    public function Error($msg) {
    	// unset all class variables
    	$this->_destroy(true);
    	// exit program and print error
    	//die('<strong>TCPDF ERROR: </strong>'.$msg);
    	Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    	Mage::throwException($msg);
    }
    
    public function Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()) {
    	$imgData = base64_decode('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');
    	
    	if (empty($file)) {
    		$file ='@'.$imgData;
    	}
    	$res = parent::Image($file, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $ismask, $imgmask, $border, $fitbox, $hidden, $fitonpage, $alt, $altimgs);
    	
    	if($res === false)
    	{
    		$res= parent::Image('@'.$imgData, $x, $y, $w, $h, $type, $link, $align, $resize, $dpi, $palign, $ismask, $imgmask, $border, $fitbox, $hidden, $fitonpage, $alt, $altimgs);
    		Mage::log('PDF:: File not found: ' . $file, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    	}
    	return $res;
    }
    public function render()
    {
    	return $this->Output('WebShop.pdf', 'S');
    }

}