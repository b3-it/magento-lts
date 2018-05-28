<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Block_Adminhtml_Customer_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('customerGrid');
      $this->setDefaultSort('customer_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);    
  }

  protected function _prepareCollection()
  {
  	  $from = $this->getRequest()->getParam('from');
  	  $to =  $this->getRequest()->getParam('to');
  	  /*
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
  	  */
  	  $collection = Mage::getModel('ibewi/address')->getCollection();
  	  $collection->setSelectDates($from, $to);
  	  
  	  
  	  //die($collection->getSelect()->__toString());
  	  
  	  $this->setCollection($collection);
  	  try {
  	  	return parent::_prepareCollection();
  	  }
  	  catch(Exception $ex)
  	  {
  	  	$s = $this->getCollection()->getSelect()->__toString();
  	  	die($s);
  	  }
  	  
  	  
  	  
  	  return $this;
 
  }

  /**
   * Filter fÃ¼r Titel
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterCompanyCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}

  	$condition = "trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,''))) like ?";
  	$collection->getSelect()->where($condition, "%$value%");
  }
  
  protected function _prepareColumns()
  {
  	  $this->addColumn('ibewi_order_increment_id', array(
          'header'    => 'Bestellnummer',
          'width'     => '50px',
          'index'     => 'ibewi_order_increment_id',
  	  		'filter_index'     => 'ibewi_order_increment_id',
  	  		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
  	
      $this->addColumn('customer_id', array(
          'header'    => 'Customer ID',
          'width'     => '50px',
          'index'     => 'order_customer_id',
      		'filter_index'     => 'customer_id',
      		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
      $this->addColumn('ibewi_address_type', array(
          'header'    => 'Address Type',
          'width'     => '50px',
          'index'     => 'ibewi_address_type',
      	  'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
      $this->addColumn('customer_address_id', array(
          'header'    => 'Kundenadresse Id',
          'width'     => '50px',
          'index'     => 'real_address_id',
      	  'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      

     $this->addColumn('customer_prefix', array(
          'header'    => 'Konto_Prefix',
          'width'     => '50px',
          'index'     => 'customer_prefix',
     		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
            
     $this->addColumn('customer_firstname', array(
          'header'    =>'Konto_Vorname',
          'width'     => '50px',
          'index'     => 'customer_firstname',
     		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('customer_lastname', array(
          'header'    => 'Konto_Nachname',
          'width'     => '50px',
          'index'     => 'customer_lastname',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
     $this->addColumn('customer_company', array(
          'header'    => 'Konto_Firma',
          'width'     => '50px',
          'index'     => 'customer_company',
     		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
     //'filter_index' => "trim(concat(COALESCE(company,''),' ',COALESCE(company2,''), ' ',COALESCE(company3,'')))"
      ));
      
      
      
      $this->addColumn('invoice_address_id', array(
          'header'    => 'Bestelladresse Id',
          'width'     => '50px',
          'index'     => 'entity_id',
      	  'filter_index' => 'main_table.entity_id',
      	  'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));

      /*
     $this->addColumn('name', array(
          'header'    => Mage::helper('ibewi')->__('Name'),
          'width'     => '50px',
          'index'     => 'ebewi_name',
     'filter_index'	=> "trim(concat(COALESCE(firstname, ''),' ',COALESCE(lastname,'')))",
      ));
     */ 
    
     $this->addColumn('firstname', array(
          'header'    => 'Vorname',
          'width'     => '50px',
          'index'     => 'firstname',
     	  'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('lastname', array(
          'header'    => 'Nachname',
          'width'     => '50px',
          'index'     => 'lastname',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
     $this->addColumn('company', array(
          'header'    =>'Firma',
          'width'     => '50px',
          'index'     => 'ebewi_company',
    		'filter_condition_callback' => array($this, '_filterCompanyCondition'),
     		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('street', array(
          'header'    => 'Strasse',
          'width'     => '50px',
          'index'     => 'street',
    	  'frame_callback' =>  array($this, 'exportStreet'),
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('city', array(
          'header'    => 'Stadt',
          'width'     => '50px',
          'index'     => 'city',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('postcode', array(
          'header'    =>'PLZ',
          'width'     => '50px',
          'index'     => 'postcode',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
    $this->addColumn('country_id', array(
          'header'    => 'Land',
          'width'     => '50px',
          'index'     => 'country_id',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      

      
    $this->addColumn('vat_id', array(
          'header'    => 'Steuernummer',
          'width'     => '50px',
          'index'     => 'vat_id',
    		'renderer'	=> 'ibewi/adminhtml_widget_grid_column_renderer_plaintext'
      ));
    
    $this->addExportType('*/*/exportCsv', Mage::helper('ibewi')->__('CSV'));
	//$this->addExportType('*/*/exportXml', Mage::helper('ibewi')->__('XML'));
      
      return parent::_prepareColumns();
  }

  public function exportStreet($renderedValue, $row, $column, $isExport)
  {
  	if ($isExport)
  	{
  		$renderedValue = str_replace(array("\n","\r"),array(' ',' '), $renderedValue);
  	}
  	
  	return $renderedValue;
  }
  
  private function getDateTime($date,$add=0)
  {
  		$format = 'Y-m-d H:i:s';
        $timestamp = Mage::getModel('core/date')->gmtTimestamp($date);
  		
        $timestamp += $add *60*60;
        
  		return "'" . date($format, $timestamp) ."'";	
  		
  }
 
 	protected function x_afterLoadCollection()
    {
        foreach($this->getCollection()->getItems() as $item)
        {
        	$item->setData('customer_firstname',html_entity_decode($item->getData('customer_firstname'),ENT_QUOTES,'UTF-8'));
        	$item->setData('customer_lastname',html_entity_decode($item->getData('customer_lastname'),ENT_QUOTES,'UTF-8'));
        	$item->setData('customer_company',html_entity_decode($item->getData('customer_company'),ENT_QUOTES,'UTF-8'));
        	
        	$item->setData('firstname',html_entity_decode($item->getData('firstname'),ENT_QUOTES,'UTF-8'));
        	$item->setData('lastname',html_entity_decode($item->getData('lastname'),ENT_QUOTES,'UTF-8'));
        	$item->setData('company',html_entity_decode($item->getData('company'),ENT_QUOTES,'UTF-8'));
        	$item->setData('street',html_entity_decode($item->getData('street'),ENT_QUOTES,'UTF-8'));
        	$item->setData('city',html_entity_decode($item->getData('city'),ENT_QUOTES,'UTF-8'));
        }
    }
  
}