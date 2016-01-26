<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Block_Adminhtml_Order_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('orderGrid');
      $this->setDefaultSort('order_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $from = $this->getRequest()->getParam('from');
  	  $to =  $this->getRequest()->getParam('to');
 	  
   	  try
  	  {
	  	  $to =  $this->getDateTime($to,24);
	  	  $from =  $this->getDateTime($from);
  	  }
  	  catch (Exception $ex)
  	  {
  	  		$from = "0";
  	  		$to = "0";
  	  }
  	  
  	  
      $collection = Mage::getModel('dimdireport/invoice')->getCollection();
      
     
      $collection->getSelect()
      	->where('invoice_date >= ?', $from)
      	->where('invoice_date < ?', $to)
      	;
      	
  

 //die($collection->getSelect()->__toString());
      
 	  $this->setCollection($collection);
      return parent::_prepareCollection();
  }

 	
    
  
  
  protected function _prepareColumns()
  {
     

      $this->addColumn('order_increment_id', array(
          'header'    => Mage::helper('dimdireport')->__('Bestellnummer'),
          'align'     =>'left',
          'index'     => 'order_increment_id',
      	  //'filter_index' => 'order.increment_id'
      ));
      
      $this->addColumn('order_date', array(
          'header'    => Mage::helper('dimdireport')->__('Bestelldatum'),
          'align'     =>'left',
          'index'     => 'order_date',
      	//'filter_index' => 'order.create_at',
      	  'type'	=> 'date'
      ));

     $this->addColumn('sku', array(
          'header'    => Mage::helper('dimdireport')->__('sku'),
          'align'     =>'left',
          'index'     => 'sku',
      ));
      
     $this->addColumn('name', array(
          'header'    => Mage::helper('dimdireport')->__('Item'),
          'align'     =>'left',
          'index'     => 'name',
      ));
     
     $this->addColumn('type_id', array(
     		'header'    => Mage::helper('dimdireport')->__('Type'),
     		'align'     =>'left',
     		'index'     => 'type_id',
     		'type'  => 'options',
     		'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
     ));     
	
     $this->addColumn('fullcompany', array(
     		'header'    => Mage::helper('dimdireport')->__('Company'),
     		'align'     =>'left',
     		'index'     => 'fullcompany',
     ));
     
     $this->addColumn('fullname', array(
     		'header'    => Mage::helper('dimdireport')->__('Customer Name'),
     		'align'     =>'left',
     		'index'     => 'fullname',
     ));
     
     $this->addColumn('address', array(
     		'header'    => Mage::helper('dimdireport')->__('Address'),
     		'align'     =>'left',
     		'index'     => 'address',
     ));
     
     $countries = Mage::getModel('adminhtml/system_config_source_country')
     ->toOptionArray();
     unset($countries[0]);
     
     $ctry = array();
     foreach ($countries as $country) {
     	$ctry[$country['value']] = $country['label'];
     }
     
     $this->addColumn('country_id', array(
     		'header'    => Mage::helper('dimdireport')->__('Country'),
     		'align'     =>'left',
     		'index'     => 'country_id',
     		'type'          => 'options',
     		'options'		=> $ctry,
     ));
     
/*
      
     $this->addColumn('customer_id', array(
          'header'    => Mage::helper('dimdireport')->__('Customer#'),
          'align'     =>'left',
          'index'     => 'customer_id',
      ));
      
     $this->addColumn('billing_address_id', array(
          'header'    => Mage::helper('dimdireport')->__('Rechnungsadresse Id'),
          'align'     =>'left',
          'index'     => 'billing_address_id',
      )); 
      
     $this->addColumn('shipping_address_id', array(
          'header'    => Mage::helper('dimdireport')->__('Lieferadresse Id'),
          'align'     =>'left',
          'index'     => 'shipping_address_id',
      ));
*/     
      $this->addColumn('invoice_date', array(
          'header'    => Mage::helper('dimdireport')->__('Invoice Date'),
          'align'     =>'left',
          'index'     => 'invoice_date',
      	  //'filter_index' => 'invoice.created_at',
          'type' => 'datetime'
      ));
	
      
      
      $this->addColumn('invoice_increment_id', array(
          'header'    => Mage::helper('dimdireport')->__('Rechnungsnummer'),
          'align'     =>'left',
          'index'     => 'invoice_increment_id',
      	  //'filter_index'     => 'invoice.increment_id',
      ));
      
      $this->addColumn('qty', array(
          'header'    => Mage::helper('dimdireport')->__('Qty'),
          'align'     =>'left',
          'index'     => 'qty',
      ));
      
      
      $this->addColumn('price', array(
          'header'    => Mage::helper('dimdireport')->__('Preis'),
          'align'     =>'left',
          'index'     => 'price',
      ));
      

      $this->addColumn('row_total', array(
          'header'    => Mage::helper('dimdireport')->__('Zeile Netto'),
          'align'     =>'left',
          'index'     => 'row_total',
      ));
      
     $this->addColumn('tax_rate', array(
          'header'    => Mage::helper('dimdireport')->__('Steuersatz'),
          'align'     =>'left',
          'index'     => 'tax_percent',
      ));
      
      $this->addColumn('base_tax_amount_notnull', array(
          'header'    => Mage::helper('dimdireport')->__('Steuer'),
          'align'     =>'left',
          'index'     => 'base_tax_amount_notnull',
      ));
      
      
      $this->addColumn('price_incl_tax', array(
          'header'    => Mage::helper('dimdireport')->__('Brutto'),
          'align'     =>'left',
          'index'     => 'price_incl_tax',
      ));
      
      $this->addColumn('row_total_incl_tax', array(
          'header'    => Mage::helper('dimdireport')->__('Zeile Brutto'),
          'align'     =>'left',
          'index'     => 'row_total_incl_tax',
      ));
      
      
     $this->addColumn('kassenzeichen', array(
          'header'    => Mage::helper('dimdireport')->__('Kassenzeichen'),
          'align'     =>'left',
          'index'     => 'kassenzeichen',
      ));
     
     $payment = Mage::getModel('adminhtml/system_config_source_payment_allmethods');
     $phash = array();
     $opt = $payment->toOptionArray();
     //Leerer Eintrag wird von Magento erzeugt
     foreach ($payment->toOptionArray() as $option) {
     	if (empty($option['label'])) {
     		continue;
     	}
     	//Offline Payments sind eigenes Array und können nicht als Key verwendet werden
     	if (!is_array($option['value'])) {
     		$phash[$option['value']] = $option['label'];
     	}
     	if (is_array($option['value'])) {
     		foreach ($option['value'] as $opt) {
     			$phash[$opt['value']] = $opt['label'];
     		}
     	}
     }
    //echo '<pre>'; var_dump($phash); die();  
     
     $this->addColumn('method', array(
     		'header'    => Mage::helper('dimdireport')->__('Payment Method'),
     		'align'     =>'left',
     		'index'     => 'method',
     		'type'      => 'options',
     		'options'   => $phash
     ));
      

      
     $this->addColumn('konto', array(
          'header'    => Mage::helper('dimdireport')->__('Konto'),
          'align'     =>'left',
          'index'     => 'konto',
      ));

		
		$this->addExportType('*/*/exportCsv', Mage::helper('dimdireport')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('dimdireport')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  private function getDateTime($date,$add=0)
  {
  		$format = 'Y-m-d H:i:s';
        $timestamp = Mage::getModel('core/date')->gmtTimestamp($date);
  		
        $timestamp += $add *60*60;
        
  		return "'" . date($format, $timestamp) ."'";	
  		
  }
  
  protected function _exportCsvItem(Varien_Object $item, Varien_Io_File $adapter)
  {
  	$row = array();
  	foreach ($this->_columns as $column) {
  		if (!$column->getIsSystem()) {
  			$r = $column->getRowFieldExport($item);
  			$nl   = array("\r\n", "\n", "\r");
  			$row[] = str_replace($nl, '/', $r);
  		}
  	}
  	$adapter->streamWriteCsv($row);
  }

}