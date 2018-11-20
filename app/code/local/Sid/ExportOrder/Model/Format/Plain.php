<?php
/**
 * Sid ExportOrder_Format
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Format_Model_Plain
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Plain extends Sid_ExportOrder_Model_Format
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/format_plain');
    }

    /**
     * Bestellung verarbeiten und PlainText erzeugen
     * 
     * @see    Sid_ExportOrder_Model_Format::processOrder()
     * @param  Mage_Sales_Model_Order    $order
     * @access public
     * @return string
     */
    public function processOrder($order)
    {
    	$this->setLog('Erstelle plain für order: '. $order->getId() );
    	$line_separator = $this->getLineSeparator() ? $this->getLineSeparator() : "\n";
    	$item_separator = $this->getItemSeparator() ? $this->getItemSeparator() : "\t";

    	$line_separator = $this->_fitEscape($line_separator);
    	$item_separator = $this->_fitEscape($item_separator);

        $_customerAddress = $this->_addAddressInformation(
                                       $order->getBillingAddress(),
                                       $order->getCustomerEmail(),
                                       $line_separator
                                   );
        $_invoiceAddress  = $this->_addAddressInformation(
                                       $order->getBillingAddress(),
                                       $order->getBillingAddress()->getEmail(),
                                       $line_separator
                                   );

        if ( $order->getShippingAddress() ) {
            $_shippingAddress = $this->_addAddressInformation(
                                           $order->getShippingAddress(),
                                           $order->getShippingAddress()->getEmail(),
                                           $line_separator
                                       );
        }
        else {
            $_shippingAddress = '';
        }
        
        $_itemArray = array();
        $_itemArray[] = implode($item_separator, array('Artikelnummer','Bezeichnung','Menge','Preis'));
        foreach($order->getAllItems() as $item)
        {
            /* @var $item Mage_Sales_Model_Order_Item */
            if(count($item->getChildrenItems()) > 0) {
                continue;
            }

            $orderItem = array();
            $orderItem[] = $item->getProduct()->getSupplierSku() ? $item->getProduct()->getSupplierSku(): $item->getSku();
            $orderItem[] = $item->getName();
            $orderItem[] = $item->getQtyOrdered();
            $orderItem[] = $item->getPrice();
                
            $_itemArray[] = implode($item_separator,$orderItem);

            $options = $this->_getProductOptions($item);
            if(count($options) > 0){
                $_itemArray[] = implode($item_separator, $options);
            }
        }
        $_orderItems = implode($line_separator, $_itemArray);

        $template = Mage::getStoreConfig('sid_exportorder/sid_exportorder_plaintext/plaintext_template');
        $processedTemplate = str_replace(
                                 array('{{CustomerAddress}}', '{{InvoiceAddress}}', '{{ShippingAddress}}', '{{OrderItems}}'),
                                 array($_customerAddress    , $_invoiceAddress    , $_shippingAddress    , $_orderItems),
                                 $template
                             );

        Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Plaindatei erzeugt');
        
        return $processedTemplate;
        
        
/*
        $result = array();

        $result[] = '-- KUNDENADRESSE --';
        $result[] = $order->getBillingAddress()->getName();
        $result[] = $order->getBillingAddress()->getCompany();
        $result[] = $order->getBillingAddress()->getCompany2();
        $result[] = $order->getBillingAddress()->getCompany3();
        $result[] = $order->getBillingAddress()->getStreetFull();
        $result[] = $order->getBillingAddress()->getCity();
        $result[] = $order->getBillingAddress()->getPostcode();
        $result[] = 'Tel: '.$order->getBillingAddress()->getTelephone();
        $result[] = 'Fax: '.$order->getBillingAddress()->getFax();
        $result[] = 'Email:'. $order->getCustomerEmail();


        $result[] = '';
        $result[] = '';
        $result[] = '';



    	$result[] = '-- RECHNUNGSADRESSE --';
    	$result[] = $order->getBillingAddress()->getName();
    	$result[] = $order->getBillingAddress()->getCompany();
    	$result[] = $order->getBillingAddress()->getCompany2();
    	$result[] = $order->getBillingAddress()->getCompany3();
    	$result[] = $order->getBillingAddress()->getStreetFull();
    	$result[] = $order->getBillingAddress()->getCity();
    	$result[] = $order->getBillingAddress()->getPostcode();
    	$result[] = 'Tel: '.$order->getBillingAddress()->getTelephone();
    	$result[] = 'Fax: '.$order->getBillingAddress()->getFax();
    	$result[] = 'Email:'. $order->getBillingAddress()->getEmail();
        $result[] = '';
        $result[] = '';
        $result[] = '';
    	 if($order->getShippingAddress())
    	 {
	    	$result[] = '-- LIEFERADRESSE --';
	    	$result[] = $order->getShippingAddress()->getName();
	    	$result[] = $order->getShippingAddress()->getCompany();
	    	$result[] = $order->getShippingAddress()->getCompany2();
	    	$result[] = $order->getShippingAddress()->getCompany3();
	    	$result[] = $order->getShippingAddress()->getStreetFull();
	    	$result[] = $order->getShippingAddress()->getCity();
	    	$result[] = $order->getShippingAddress()->getPostcode();
	    	$result[] = 'Tel: '.$order->getShippingAddress()->getTelephone();
	    	$result[] = 'Fax: '.$order->getShippingAddress()->getFax();
	    	$result[] = 'Email:'. $order->getShippingAddress()->getEmail();
	    	if($order->getShippingAddress()->getDap()){
	    		$result[] = 'Abholort:'. $order->getShippingAddress()->getDap();
	    	}
             $result[] = '';
             $result[] = '';
             $result[] = '';
    	 }

        foreach($order->getAllItems() as $item)
        {
*/
            /* @var $item Mage_Sales_Model_Order_Item */
/*
            if(count($item->getChildrenItems()) > 0) continue;
            {
                $orderItem = array();
                $orderItem[] = $item->getProduct()->getSupplierSku() ? $item->getProduct()->getSupplierSku(): $item->getSku();
                $orderItem[] = $item->getName();
                $orderItem[] = $item->getQtyOrdered();
                $orderItem[] = $item->getPrice();
                    
                $result[] = implode($item_separator,$orderItem);
    
                $options = $this->_getProductOptions($item);
                if(count($options) > 0){
                    $result[] = implode($item_separator, $options);
                }
            }
        }

     	 Sid_ExportOrder_Model_History::createHistory($order->getId(), 'Plaindatei erzeugt');

     	 return implode($line_separator,$result);
*/
    }

    /**
     * Trennzeichen umwandeln
     * 
     * @param  string   $value
     * @return string
     * @access private
     */
    private function _fitEscape($value)
    {
    	if($value == '\\t') return "\t";
    	if($value == '\\n') return "\n";
    	if($value == '\\r') return "\r";

    	return $value;
    }

    /**
     * Adress-Ausgabe erzeugen
     *
     * @param  Mage_Sales_Model_Order_Address   $address         Address-Objekt
     * @param  string                           $email           eMail-Adresse
     * @param  string                           $separator       Separator für einzelen Zeilen
     * @access private
     * @return string
     */
    private function _addAddressInformation($address, $email, $separator)
    {
        $textResult = array();

        $textResult[] = $address->getName();
        $textResult[] = $address->getCompany();
        $textResult[] = $address->getCompany2();
        $textResult[] = $address->getCompany3();
        $textResult[] = $address->getStreetFull();
        $textResult[] = $address->getCity();
        $textResult[] = $address->getPostcode();
        $textResult[] = 'Tel: '   . $address->getTelephone();
        $textResult[] = 'Fax: '   . $address->getFax();
        $textResult[] = 'Email: ' . $email;

        if( $address->getDap() ) {
            $textResult[] = 'Abholort:'. $address->getDap();
        }

        return implode($separator, $textResult);
    }
    
    /**
     * Optionen zum Bestell-Item ermitteln
     * 
     * @param Mage_Sales_Model_Order_Item   $item
     * @return array[]
     */
    protected function _getProductOptions($item)
    {
    	$res = array();
    	if (!empty($item->getProductOptions())) {
    		$options = $item->getProductOptions();

    		if (isset($options['bundle_options'])) {
    			/** @var Mage_Catalog_Model_Product_Type_Abstract $typeInstance */
    			$typeInstance = $item->getProduct()->getTypeInstance(true);


    			$opsel = $options['info_buyRequest']['bundle_option'];

    			foreach ($options['bundle_options'] as $okey => $o) {

    				$idxs = $opsel[$okey];
    				if (!is_array($idxs)) {
    					$idxs = array($idxs);
    				}

    				/** @var Mage_Bundle_Model_Resource_Selection_Collection $selectionCollection */
    				$selectionCollection = $typeInstance->getSelectionsCollection(array($okey), $item->getProduct());
    				$selectionCollection->setSelectionIdsFilter($idxs);

    				$selidx = 0;
    				foreach ($selectionCollection as $selitem) {
    					/** @var Mage_Catalog_Model_Product $selitem */
    					$sku = $selitem->getSku();
    					// ignore base configuration object
    					if (static::endsWith($sku, ":base")) {
    						continue;
    					}

    					$osel = $o['value'][$selidx];

    					$res[] = $selitem->getSupplierSku()? $selitem->getSupplierSku() :  $selitem->getSku();
    					$res[] = $selitem->getName();
    					$res[] = $osel['qty'];
    					$res[] = $selitem->getBasePrice();

    					$selidx++;
    				}
    			}
    		} else if (isset($options['options'])) {
    			$features = $item->getProductFeatures();
    			foreach ($options['options'] as $o) {
    				$res[] = $o['label'].': '. $o['value'];

    			}
    		}
    	}
    	return $res;
    }

    /**
     * Prüfen, ob ein String mit einem bestimmten Zeichen endet
     * 
     * @param string $haystack   zu durchsuchende Zeichenkette
     * @param string $needle     zu suchendes Zeichen
     * @return boolean
     */
    private static function endsWith($haystack, $needle) {
    	// search forward starting from end minus needle length characters
    	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}
