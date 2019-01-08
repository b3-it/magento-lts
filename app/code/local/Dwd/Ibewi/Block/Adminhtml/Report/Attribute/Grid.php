<?php
 /**
  *
  * @category   	Dwd Ibewi
  * @package    	Dwd_Ibewi
  * @name       	Dwd_Ibewi_Block_Adminhtml_Report_Attribute_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Ibewi_Block_Adminhtml_Report_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	private $__HHcollection = null;
	
	
	  public function __construct()
	  {
	      parent::__construct();
	      $this->setId('report_attributeGrid');
	      $this->setDefaultSort('report_attribute_id');
	      $this->setDefaultDir('ASC');
	      $this->setSaveParametersInSession(true);
	  }
	  
	  
	  

	  
	
	  protected function _prepareCollection()
	  {
	  		$store = $this->_getStore();
	  	  /** @var $collection Dwd_Ibewi_Model_Mysql4_Report_Attribute_Collection */ 
	      $collection = Mage::getModel('ibewi/report_attribute')->getCollection();
	      //$collection->addAttributeToSelect('*');
	      

	      $bewirtschafter = new Zend_Db_Expr("'".Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')."' as bewirtschafter");
	      $konto = new Zend_Db_Expr("'".Mage::helper('ibewi')->getConfigValue('konto1')."' as konto");
	      $collection->getSelect()
	      ->columns($bewirtschafter)
	      ->columns($konto);
	     //die( $collection->getSelect()->__toString());
	      $collection->addAttributeToSelect('objektnummer')
	      	->addAttributeToSelect('objektnummer_mwst')
	      	->addAttributeToSelect('haushaltsstelle')
	      	->addAttributeToSelect('ibewi_maszeinheit')
	      	->addAttributeToSelect('kostenstelle')
	      	->addAttributeToSelect('kostentraeger')
	      	->addAttributeToSelect('tax_class_id');
	      	
	      	
	      
	      
	      if ($store->getId()) {
	      	//$collection->setStoreId($store->getId());
	      	$adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
	      	$collection->addStoreFilter($store);
	      	$collection->joinAttribute(
	      			'name',
	      			'catalog_product/name',
	      			'entity_id',
	      			null,
	      			'inner',
	      			$adminStore
	      			);
	      	$collection->joinAttribute(
	      			'custom_name',
	      			'catalog_product/name',
	      			'entity_id',
	      			null,
	      			'inner',
	      			$store->getId()
	      			);
	      	$collection->joinAttribute(
	      			'status',
	      			'catalog_product/status',
	      			'entity_id',
	      			null,
	      			'inner',
	      			$store->getId()
	      			);
	      	$collection->joinAttribute(
	      			'visibility',
	      			'catalog_product/visibility',
	      			'entity_id',
	      			null,
	      			'inner',
	      			$store->getId()
	      			);
	      	$collection->joinAttribute(
	      			'price',
	      			'catalog_product/price',
	      			'entity_id',
	      			null,
	      			'left',
	      			$store->getId()
	      			);
	      }
	      else {
	      	$collection->addAttributeToSelect('price');
	      	$collection->addAttributeToSelect('name');
	      	$collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
	      	$collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
	      }
	      
	      $this->setCollection($collection);
	      return parent::_prepareCollection();
	  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('ibewi')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));
      
      $this->addColumn('name', array(
      		'header'    => Mage::helper('ibewi')->__('Name'),
      		//'align'     =>'right',
      		//'width'     => '50px',
      		'index'     => 'name',
      ));
      
      $this->addColumn('sku', array(
      		'header'    => Mage::helper('ibewi')->__('Sku'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'sku',
      ));
      
      
      
      
      $this->addColumn('tax_class', 
      		array(
      				'header' => Mage::helper('tax')->__('Product Tax Class'),
      				//'sortable'  => false,
      				'align' =>'left',
      				'index' => 'tax_class_id',
      				//'filter_index' => 'ptc.product_tax_class_id',
      				'type'    => 'options',
      				'show_missing_option_values' => true,
      				'options' => Mage::getModel('tax/class')->getCollection()
      				->setClassTypeFilter(Mage_Tax_Model_Class::TAX_CLASS_TYPE_PRODUCT)->toOptionHash(),
      		
      ));
      
      $masz = $this->__getMaszeinheitOptionarray();
      $this->addColumn('ibewi_maszeinheit', array(
      		'header'    => Mage::helper('ibewi')->__('IBEWI-Maßeinheit'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'ibewi_maszeinheit',
      		'type'  => 'options',
      		'options' => $masz,
      ));
      
      
      $kst = $this->__getKostenstelleOptionarray();
      
      $this->addColumn('kostenstelle', array(
      		'header'    => Mage::helper('ibewi')->__('Kostenstelle'),
      		//'align'     =>'right',
      		//'width'     => '50px',
      		'index'     => 'kostenstelle',
      		'type'  => 'options',
      		'options' => $kst,
      ));
      
      $kstt = $this->__getKostenträgerOptionarray();
      $this->addColumn('kostentraeger', array(
      		'header'    => Mage::helper('ibewi')->__('Kostentraeger'),
      		//'align'     =>'right',
      		//'width'     => '50px',
      		'index'     => 'kostentraeger',
      		'type'  => 'options',
      		'options' => $kstt,
      ));
      
      
      $hh = $this->__getHHParmOptionarray(Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE);
      
      $this->addColumn('haushaltsstelle', array(
      		'header'    => Mage::helper('ibewi')->__('Haushaltsstelle'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'haushaltsstelle',
      		'type'  => 'options',
      		'options' => $hh,
      ));
      
      $obj = $this->__getHHParmOptionarray(Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER);
      $this->addColumn('objektnummer', array(
      		'header'    => Mage::helper('ibewi')->__('Objektnummer'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'objektnummer',
      		'type'  => 'options',
      		'options' => $obj,
      ));
      
      $objmwst = $this->__getHHParmOptionarray(Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST);
      $this->addColumn('objektnummer_mwst', array(
      		'header'    => Mage::helper('ibewi')->__('Objektnummer Mwst'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'objektnummer_mwst',
      		'type'  => 'options',
      		'options' => $objmwst,
      ));

     
      $this->addColumn('bewirtschafter', array(
      		'header'    => Mage::helper('ibewi')->__('Bewirtschafter'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'bewirtschafter',
      		'filter'    => false,
      		'sortable'  => false
      ));
      
      $this->addColumn('konto', array(
      		'header'    => Mage::helper('ibewi')->__('BuKa-Schlüssel'),
      		//'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'konto',
      		'filter'    => false,
      		'sortable'  => false
      ));
      
      $store = $this->_getStore();
      $this->addColumn('price',
      		array(
      				'header'=> Mage::helper('catalog')->__('Price'),
      				'type'  => 'price',
      				'currency_code' => $store->getBaseCurrency()->getCode(),
      				'index' => 'price',
      		));
      $this->addColumn('type',
      		array(
      				'header'=> Mage::helper('catalog')->__('Type'),
      				'width' => '60px',
      				'index' => 'type_id',
      				'type'  => 'options',
      				'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
      		));
      
      $this->addColumn('status',
      		array(
      				'header'=> Mage::helper('catalog')->__('Status'),
      				'width' => '70px',
      				'index' => 'status',
      				'type'  => 'options',
      				'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
      		));
      
      $this->addColumn('visibility',
      		array(
      				'header'=> Mage::helper('catalog')->__('Visibility'),
      				'width' => '70px',
      				'index' => 'visibility',
      				'type'  => 'options',
      				'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
      		));
 
		$this->addExportType('*/*/exportCsv', Mage::helper('ibewi')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('ibewi')->__('XML'));

      return parent::_prepareColumns();
  }

   
	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }


  
  protected function _getStore()
  {
  	$storeId = (int) $this->getRequest()->getParam('store', 0);
  	return Mage::app()->getStore($storeId);
  }

  
  private function __getHHParmOptionarray($type)
  {
  	 
  	if ($this->__HHcollection == null){
  		$this->__HHcollection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
  	}
  	 
  	 
  	$res = array();
  	foreach($this->__HHcollection as $hh)
  	{
  		if($hh->getType() == $type)
  		{
  			$res[$hh->getId()] = $hh->getValue();
  			//$res[$hh->getId()] = $hh->getTitle();
  		}
  	}
  	 
  	return $res;
  }
  
  
  private function __getKostenstelleOptionarray()
  {
  		$config    = Mage::getModel('eav/config');
  		$attribute = $config->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'kostenstelle');
  		$values    = $attribute->setStoreId(0)->getSource()->getAllOptions();
  
  		$res = array();
  		foreach($values as $value)
  		{
  			$res[$value['value']] = $value['label'];
  		}
  		
  		return $res;
  		
  }
  
  private function __getKostenträgerOptionarray()
  {
  	$collection = Mage::getModel('ibewi/kostentraeger_attribute')->getCollection();
  	$res = array();
  	foreach($collection->getItems() as $item)
  	{
  		$res[$item->getValue()] =$item->getValue();
  	}
  
  	return $res;
  
  }
  
  private function __getMaszeinheitOptionarray()
  {
  	$einheiten = Mage::getConfig()->getNode('global/ibewi/einheiten')->asArray();
  	$res = array();
  	foreach($einheiten as $k=>$v)
  	{
  		$res[$k] =$k;
  	}
  
  	return $res;
  
  }
  
 
  
  
}
