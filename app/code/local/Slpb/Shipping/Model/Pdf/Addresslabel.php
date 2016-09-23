<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Sales
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Sales Order Shipment PDF model
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Shipping_Model_Pdf_Addresslabel extends Mage_Sales_Model_Order_Pdf_Abstract
{
    public function getPdf($addresses = array())
    {
        $this->_beforeGetPdf();
        //$this->_initRenderer('shipment');

        $pdf = new Zend_Pdf();
        $this->_setPdf($pdf);
       
        
        $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $pdf->pages[] = $page;
        $x = 20;
        $y = 820;
        foreach ($addresses as $adr) {
           
    		$this->printAddress($page,$adr,$x,$y);
    		
    		$y -= 50;
			          
        }

        $this->_afterGetPdf();

        return $pdf;
    }

    
    protected function printAddress(&$page, $address, $x, $y)
    {
    	$zeile = 10;
       	$this->_setFontRegular($page);
		$shippingAddress = $address->format('pdf');

		$text = $address->getPrefix(). ' '.$address->getFirstname().' '.$address->getLastname();
		$page->drawText(strip_tags(ltrim($text)), $x, $y, 'UTF-8'); $y -= $zeile;
		
		$text = $address->getStreet;
		$page->drawText(strip_tags(ltrim($text)), $x, $y, 'UTF-8'); $y -= $zeile;
		
		$text = $address->getPostcode().' ' . $address->getCity();
		$page->drawText(strip_tags(ltrim($text)), $x, $y, 'UTF-8'); $y -= $zeile;
		
		$text = $address->getCountryModel()->getName();
		$page->drawText(strip_tags(ltrim($text)), $x, $y, 'UTF-8'); $y -= $zeile;
	
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
        $page = $this->_getPdf()->newPage(Zend_Pdf_Page::SIZE_A4);
        $this->_setFontRegular($this->_page,7);
        $this->_getPdf()->pages[] = $page;
        $this->y = 800;

 

        return $page;
    }
}