<?php
/**
 *
 *  Klasse für Vorschau Templates zum Erzeugen von pdf's
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Pdf_Preview extends Egovs_Pdftemplate_Model_Pdf_Abstract
{

	protected $_storeId = 0;
	
	public function preparePdf($invoices = array()) {
		if (is_array($invoices) && !empty($invoices)) {
			$invoices = $invoices[0];
		}
		if (!($invoices instanceof Egovs_Paymentbase_Model_Sepa_Mandate_Abstract) || empty($invoices)) {
			//Mage::throwException(Mage::helper('paymentbase')->__('No mandate instance available to create PDF document!'));
		}


		$this->_Order = $invoices->getOrder();


		$taxInfo = $this->_Order->getFullTaxInfo();

		$this->_Order->setTaxInfo($taxInfo);
		$this->_Order->setTaxInfoArray($this->getTaxInfoArray($this->_Order));


		/* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate_Abstract */
		$mandate = $invoices;


		$mandate->setConfig($this->getConfig($this->_storeId));
		$mandate->setImprint($this->getImprint($this->_storeId));
		$mandate->setEPayblConfig($this->getEPayblConfig($this->_storeId));
		$this->LoadTemplate($mandate);

		$this->_Pdf->addPage();

		$this->RenderAddress($mandate,$this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_ADDRESS]);
		$this->RenderTable($mandate, $this->_TemplateSections[Egovs_Pdftemplate_Model_Sectiontype::TYPE_BODY]);
		$this->_Pdf->lastPage();
		$this->_Pdf->ResetPagesSinceStart();

		return $this;
	}

	public function load($id,$storeId = null)
	{
		$this->_storeId = intval($storeId);
		$this->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW;
		$pdf = parent::getPdf($this->generateData($id));

		$pdf->render();
		//$pdf->save('c:\\test.pdf');
	}


	private function generateData($templateId)
	{
		$order = Mage::getModel('sales/order');
		$order->setStoreId($this->_storeId);
		//$order->setCustomerId(1);
		//$order->setPaymentInfo("Zahlunsdetails");

		$payment = new Mage_Sales_Model_Order_Payment();
		$payment->setMethod('openaccount');




		$order->setPayment($payment);
		$order->setShippingMethod('freeshipping_freeshipping');
		$invoice = new Varien_Object();
		$invoice->setTemplateId($templateId);
		$invoice->setConfig($this->getConfig($this->_storeId));
		$invoice->setImprint($this->getImprint($order->getStoreId()));
		$invoice->setOrder($order);

		$adr = new Mage_Sales_Model_Order_Address();
		$adr->setFirstname('Max');
		$adr->setLastname('Mustermann');
		$adr->setCompany('Maxfirma');
		$adr->setStreet('Baumalle 122');
		$adr->setCity('Waldstadt');
		$adr->setPostcode('00815');
		$invoice->setBillingAddress($adr);
		$invoice->setShippingAddress($adr);
		$order->setBillingAddress($adr);
		$order->setShippingAddress($adr);

		$items = array();
		for($i = 0; $i < 20; $i++)
		{

			$item = new Varien_Object();
			$item->setSku('sku_'.$i);
			$item->setQty('1');
			$item->setPrice('30');
			$item->setBaseRowTotal('30');
			$item->setName('Produkt - mit einem langen Namen in der Farbe "FREUNDLICHES Mausgrau"');
			$item->setOrderItem(new Varien_Object());


			$items[] = $item;
		}


		$invoice->setAllItems($items);
		$invoice->setSubtotal(123456.99);
		$invoice->setData('shipping_amount',156.99);
		$invoice->setTaxAmount(6.99);
		$invoice->setGrandTotal(155556.99);

		//$data[] = $invoice;

		$adr = new Varien_Object();
		$adr->setCompany('Maxfirma');
		$adr->setStreet('Baumalle 122');
		$adr->setCity('Waldstadt');
		$adr->setZip('00815');
		$adr->setHousenumber('27');
		$adr->setPostofficeBox('Box12434');
		$adr->setCountry('Deutschland');
$invoice->setAdressData($adr);


		$invoice->setReference();
$invoice->setAccountholderFullName("Max Mustermann");
		$invoice->setAccountholderName("Max");
		$invoice->setAccountholderSurname("Mustermann");
		$invoice->setAccountholderAddress($adr);

		$bank = new Varien_Object();
		$bank->setIban('12345677');
		$bank->setBic('AAAAAAa');
$bank->setBankName('Spa&szlig;bank');
		//$invoice->setBankingAccount($bank);

$invoice->setDebitorFullName("Maxi Mustermann");
		$invoice->setDebitorName("Maxi");
		$invoice->setDebitorSurname("Mustermann");
		$invoice->setDebitorAddress($adr);

$wert  = FALSE;
$wert1 = ( ($wert == TRUE) ? 'X' : '' );
$wert2 = ( ($wert == TRUE) ? 'X' : '' );
$depend = new Varien_Object();
$depend->setSinglePayment($wert1);
$depend->setMultiPayment($wert2);
$invoice->setDependend($depend);



/////////////////////////
/*
$invoice = Mage::getModel('paymentbase/sepa_mandate');

$invoice->getAdapteeMandate();
$invoice->setSurname('Kögel');
$invoice->setAccountholderDiffers(false);
$ba = $invoice->getBankingAccount();
$ba->setBic('bic');
$ba->setIban('Iban');
$invoice->setBankingAccount($ba);
*/
$data = array();
$data[] = $invoice;

		return $data;
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
		else if(is_string($data))
		{
			if(strlen($data) > intval($key))
			{
				$data = substr($data, intval($key),1);
			}
			else return "&nbsp;";
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
		else if(is_object($data))
		{
			$uckey = 'get'.uc_words($key,'');
			$tmp = call_user_func(array($data,$uckey));
			if(!$tmp) return '';
			$data = $tmp;

		}

		if(count($keys) == 0) return $data;

		return $this->extractData($data,$keys);

	}

}