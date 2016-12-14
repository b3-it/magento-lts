<?php
/**
 * Sid Report
 *
 *
 * @category   	Sid
 * @package    	Sid_Report
 * @name       	Sid_Report_Block_Adminhtml_Product_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Report_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productGrid');
      $this->setDefaultSort('product_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::helper('framecontract')->getStockStatusCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('report_product_id', array(
          'header'    => Mage::helper('sidreport')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('sidreport')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      
      $this->addColumn('sku', array(
      		'header'    => Mage::helper('sidreport')->__('Sku'),
      		'align'     =>'left',
      		'index'     => 'sku',
      ));
      
      if (!Mage::app()->isSingleStoreMode()) 
      {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Store'),
                'index'     => 'store_group',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => false,
            ));
        }
      
      $lose = Mage::getModel('framecontract/source_attribute_contractLos');
      $ctr = ($lose->getOptionArray(false));
      
      $this->addColumn('los', array(
      		'header'    => Mage::helper('framecontract')->__('Rahmenvertrag / Los'),
      		'align'     => 'left',
      		//'width'     => '150px',
      		'index'     => 'los_id',
      		'type'      => 'options',
      		'options'   => $ctr,
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
     
      $currencyCode = $this->getCurrentCurrencyCode();
      
      if(Mage::getStoreConfig('tax/calculation/price_includes_tax')){
      	$label = 'Gesamtpreis inkl. MwSt';
      }else {
      	$label = 'Gesamtpreis exkl. MwSt';
      }
      
      $this->addColumn('price', array(
      		'header'    => $label,// Mage::helper('sidreport')->__('Gesamtpreis'),
      		'align'     =>'left',
      		'index'     => 'totalprice',
      		'type'          => 'currency',
        	'currency_code' => $currencyCode,
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
      $this->addColumn('stock', array(
      		'header'    => Mage::helper('sidreport')->__('Qty Stock'),
      		'align'     =>'left',
      		'index'     => 'stock_qty',
      		'type'		=> 'number',
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
      $this->addColumn('contract', array(
      		'header'    => Mage::helper('sidreport')->__('Qty Contract'),
      		'align'     =>'left',
      		'index'     => 'contract_qty',
      		'type'		=> 'number',
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
     
      
      $this->addColumn('sold', array(
      		'header'    => Mage::helper('sidreport')->__('Qty Sold'),
      		'align'     =>'left',
      		'index'     => 'sold',
      		'type'		=> 'number',
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
      $this->addColumn('sold_p', array(
      		'header'    => Mage::helper('sidreport')->__('Qty Sold [%]'),
      		'align'     =>'left',
      		'index'     => 'sold_p',
      		'type'		=> 'number',
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));

       

		$this->addExportType('*/*/exportCsv', Mage::helper('sidreport')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sidreport')->__('XML'));

      return parent::_prepareColumns();
  }

  
  protected function _filterCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	
  	if($column->getId() == 'stock')
  	{
  		$condition = $this->_getFromToCondition('stock.qty',$value);
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  	}
  	if($column->getId() == 'contract')
  	{
  		$condition = $this->_getFromToCondition('qty.value',$value);
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  	}
  	
  	if($column->getId() == 'sold')
  	{
  		$condition = $this->_getFromToCondition('(qty.value - stock.qty)',$value);
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  	}
  	
  	if($column->getId() == 'sold_p')
  	{
  		$condition = $this->_getFromToCondition('(IF(qty.value <> 0, ((qty.value - stock.qty)/qty.value * 100), 0))',$value);
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  	}
  
  	if($column->getId() == 'los')
  	{
  		$condition = 'los.value = ?';
  		if($condition){
  			$collection->getSelect()->where($condition, $value);
  		}
  	}
  	return $this;
  	
  }
  
	private function _getFromToCondition($col,$value)
	{
		$condition = null;
		if(isset( $value['from']) && isset( $value['to'])){
			$condition = sprintf("(($col >= %s) && ($col <= %s))", $value['from'],  $value['to']);
			
		}
		else if(isset( $value['from'])){
			$condition = sprintf("($col >= %s)", $value['from']);
			
		}
		else if(isset( $value['to'])){
			$condition = sprintf("($col <= %s)", $value['to']);
			
		}
		
		return $condition;
	}
  
}
