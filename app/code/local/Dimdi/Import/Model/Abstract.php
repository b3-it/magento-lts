<?php

class Dimdi_Import_Model_Abstract
{
    private $_conn = null;
    const STORE_ID = 1;
   	public $_TAX_CLASS = array();
    
   
    
    public function __construct() 
    {
    	//die Steuerklassen
	    /* osc
	    1,"MwSt_19_nur_DE","Mehrwertsteuer (19%)"
		2,"MwSt_7_nur_DE","Mehrwertsteuer (7%)"
		3,"MwSt_19_Ausland","Mehrwertsteuer (19%) Ausland"
		4,"MwSt_7_Ausland","Mehrwertsteuer (7%) Ausland"
		5,"MwSt_7_Alle","Mehrwertsteuer (7%) Ausland"
		6,"MwSt_19_Alle","Mehrwertsteuer (19%) Ausland"
		*/
    	/* magento
			1, 'Umsatzsteuerpflichtige Güter voller Satz', 'PRODUCT'
			2, 'Umsatzsteuerpflichtige Güter ermäßigter Satz', 'PRODUCT'
			3, 'Mehrwertsteuerpflichtige Kunden', 'CUSTOMER'
			4, 'Versand mit Mehrwertsteuer', 'PRODUCT'
			5, 'Güter ohne Mehrwertsteuer', 'PRODUCT'
			6, 'Mehrwertsteuerbefreite Kunden', 'CUSTOMER'
    	 */
    	$this->_TAX_CLASS[1] = 1;
    	$this->_TAX_CLASS[2] = 2;
    	$this->_TAX_CLASS[3] = 1;
    	$this->_TAX_CLASS[4] = 2;
    	$this->_TAX_CLASS[5] = 2;
    	$this->_TAX_CLASS[6] = 1;
    }
    
    
    public function umlaute($string)
    {
    	$umlaute = array("/ä/","/ö/","/ü/","/Ä/","/Ö/","/Ü/","/ß/");
		$replace = array("ae","oe","ue","Ae","Oe","Ue","ss"); 
		return preg_replace($umlaute, $replace, $string);  
    }
 
}
    
