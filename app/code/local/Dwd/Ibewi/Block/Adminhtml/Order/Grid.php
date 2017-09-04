<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Order_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
  	  
  	  
      $collection = Mage::getModel('ibewi/invoice')->getCollection();
      
     
      $collection->getSelect()
      	->where('invoice_date >= ?', $from)
      	->where('invoice_date < ?', $to)
      	;
      	
  

// die($collection->getSelect()->__toString());
      
 	  $this->setCollection($collection);
      return parent::_prepareCollection();
  }

 	
    
  
  
  protected function _prepareColumns()
  {
     
  	$this->addColumn('suffixincrementid', array(
  			'header'    => 'Bestellnummer',
  			'align'     =>'left',
  			'index'     => 'suffixincrementid',
  			//'filter_index' => 'order.increment_id'
  	));
/*
      $this->addColumn('order_increment_id', array(
          'header'    => Mage::helper('ibewi')->__('Bestellnummer'),
          'align'     =>'left',
          'index'     => 'order_increment_id',
      	  //'filter_index' => 'order.increment_id'
      ));
  */    
      $this->addColumn('order_date', array(
          'header'    => 'Bestelldatum',
          'align'     =>'left',
          'index'     => 'order_date',
      	//'filter_index' => 'order.create_at',
      	  'type'	=> 'date'
      ));

     $this->addColumn('sku', array(
          'header'    => 'Artikelnummer',
          'align'     =>'left',
          'index'     => 'sku',
      ));
      
     $this->addColumn('name', array(
          'header'    => 'Name',
          'align'     =>'left',
          'index'     => 'name',
      ));
	

      
     $this->addColumn('customer_id', array(
          'header'    => 'Kundennr.',
          'align'     =>'left',
          'index'     => 'customer_id',
      ));
      
     $this->addColumn('billing_address_id', array(
          'header'    =>'Rechnungsadresse Id',
          'align'     =>'left',
          'index'     => 'billing_address_id',
      )); 
      
     $this->addColumn('shipping_address_id', array(
          'header'    =>'Lieferadresse Id',
          'align'     =>'left',
          'index'     => 'leistungs_addresse',
      ));
     
      $this->addColumn('invoice_date', array(
          'header'    => 'Rechnungsdatum',
          'align'     =>'left',
          'index'     => 'invoice_date',
      	  //'filter_index' => 'invoice.created_at',
          'type' => 'datetime'
      ));
	
      
      
      $this->addColumn('invoice_increment_id', array(
          'header'    => 'Rechnungsnummer',
          'align'     =>'left',
          'index'     => 'invoice_increment_id',
      	  //'filter_index'     => 'invoice.increment_id',
      ));
      
      $this->addColumn('qty', array(
          'header'    =>'Menge',
          'align'     =>'left',
          'index'     => 'qty',
      ));
      
      
      $this->addColumn('price', array(
          'header'    => 'Preis',
          'align'     =>'left',
          'index'     => 'price',
      ));
      
      $this->addColumn('base_price', array(
          'header'    => 'Grundpreis',
          'align'     =>'left',
          'index'     => 'base_price',
      ));
      
      $this->addColumn('row_total', array(
          'header'    => 'Zeile Netto',
          'align'     =>'left',
          'index'     => 'row_total',
      ));
      
     $this->addColumn('tax_rate', array(
          'header'    => 'Steuersatz',
          'align'     =>'left',
          'index'     => 'tax_percent',
      ));
      
      $this->addColumn('base_tax_amount_notnull', array(
          'header'    => 'Steuer',
          'align'     =>'left',
          'index'     => 'base_tax_amount_notnull',
      ));
      
      
      $this->addColumn('price_incl_tax', array(
          'header'    =>'Brutto',
          'align'     =>'left',
          'index'     => 'price_incl_tax',
      ));
      
      $this->addColumn('row_total_incl_tax', array(
          'header'    => 'Zeile Brutto',
          'align'     =>'left',
          'index'     => 'row_total_incl_tax',
      ));
      
     $this->addColumn('ibewi_maszeinheit', array(
          'header'    =>'IBEWI Maßeinheit',
          'align'     =>'left',
          'index'     => 'ibewi_maszeinheit',
      ));
      
     $this->addColumn('kostenstelle', array(
          'header'    =>'Kostenstelle',
          'align'     =>'left',
          'index'     => 'kostenstelle',
      ));
     
     $this->addColumn('kostentraeger', array(
     		'header'    =>'Kostentraeger',
     		'align'     =>'left',
     		'index'     => 'kostentraeger',
     ));
      
     $this->addColumn('haushaltstelle', array(
          'header'    => 'Haushaltstelle',
          'align'     =>'left',
          'index'     => 'haushaltstelle',
      ));
      
     $this->addColumn('kassenzeichen', array(
          'header'    => 'Kassenzeichen',
          'align'     =>'left',
          'index'     => 'kassenzeichen',
      ));
      
      /*
     $this->addColumn('kostenstelle', array(
          'header'    => 'Kostenstelle',
          'align'     =>'left',
          'index'     => 'kostenstelle',
      ));
      */
     $this->addColumn('objektnummer', array(
          'header'    => 'Objektnummer',
          'align'     =>'left',
          'index'     => 'objektnummer',
      ));
      
      $this->addColumn('bewirtschafter', array(
          'header'    => 'Bewirtschafter',
          'align'     =>'left',
          'index'     => 'bewirtschafter',
      ));
      
     $this->addColumn('konto', array(
          'header'    => 'Konto',
          'align'     =>'left',
          'index'     => 'konto',
      ));
      
       $this->addColumn('updated_at', array(
          'header'    => 'Aktualisiert am',
          'align'     =>'left',
          'index'     => 'invoice_update',
       //'filter_index'     => 'invoice.update_at',
       	 'type' => 'datetime'
      ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('ibewi')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('ibewi')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  private function getDateTime($date,$add=0)
  {
  		$format = 'Y-m-d H:i:s';
        $timestamp = Mage::getModel('core/date')->gmtTimestamp($date);
  		
        $timestamp += $add *60*60;
        
  		return date($format, $timestamp);	
  		
  }

}