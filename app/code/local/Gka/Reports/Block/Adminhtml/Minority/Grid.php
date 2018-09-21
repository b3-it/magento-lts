<?php
 /**
  *
  * @category   	Gka Reports
  * @package    	Gka_Reports
  * @name       	Gka_Reports_Block_Adminhtml_Minority_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Reports_Block_Adminhtml_Minority_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('minorityBEGrid');
      //$this->setDefaultSort('increment_id');
      //$this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setDefaultLimit(100);
      $this->setUseAjax(true);


      $from = date("Y-m-d", strtotime('-1 day'));
      $to = date("Y-m-d", strtotime('-0 day'));
      $locale = Mage::app()->getLocale()->getLocaleCode();

      $this->setDefaultFilter(array(
          "created_at"=>array(
              'from'=> new Zend_Date($from, null, $locale),
              'to'=> new Zend_Date($to, null, $locale),
              'locale' => $locale,
              'orig_to' => Mage::helper('core')->formatDate($to),
              'orig_from' => Mage::helper('core')->formatDate($from),
              'datetime' => true
          )

      ));

  }

    protected function _prepareCollection() {
        $collection = Mage::getModel('sales/order_item')->getCollection();

        $eav = Mage::getResourceModel('eav/entity_attribute');
        ;

        $collection->getSelect()
            ->join(array('torder' => $collection->getTable('sales/order_grid')), 'torder.entity_id = main_table.order_id',array('status','order_currency_code','payment_method'))
            ->joinleft(array('product'=>$collection->getTable("catalog/product")."_varchar"),'product.entity_id=main_table.product_id AND product.attribute_id='.intval($eav->getIdByCode('catalog_product','minority_interest')),array('minority_interest'=>'value') )
            ->joinleft(array('product_name'=>$collection->getTable("catalog/product")."_varchar"),'product_name.entity_id=main_table.product_id AND product_name.attribute_id='.intval($eav->getIdByCode('catalog_product','name')),array('product_name'=>'value') )
            ->joinleft(array('t1'=>$collection->getTable('customer/entity').'_varchar'), 'torder.customer_id=t1.entity_id AND t1.attribute_id = '.intval($eav->getIdByCode('customer','company')),array('company'=>'value') )
            ->columns(array('sum_total'=>'sum(base_row_total)'))
            ->group(array('main_table.store_id', 'customer_id', 'product_id'))
            ->where('parent_item_id is not null')
            ->where( new Zend_Db_Expr("(torder.status='complete') OR (torder.status='complete')"))
        //    ->where('main_table.store_id = ' . intval(Mage::app()->getStore()->getId()))
        ;


        if(Mage::helper('gka_reports')->isModuleEnabled('Egovs_Isolation'))
        {
            $helper = Mage::helper('isolation');
            if(!$helper->getUserIsAdmin()) {
                $storeGroups = $helper->getUserStoreGroups();
                if(($storeGroups) && (count($storeGroups) > 0)) {
                    $storeGroups = implode(',', $storeGroups);
                }else{
                    $storeGroups[] = '-1';
                }
                $collection->getSelect()->where("store_group in ({$storeGroups})");
            }

        }


        //die($collection->getSelect()->__toString());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Created At'),
            'align'     =>'left',
            'index'     => 'created_at',
            'filter_index' => 'main_table.created_at',
            'width'		=> '150',
            'type'	=> 'date',
        ));


        $this->addColumn('store_id', array(
            'header'    => Mage::helper('sales')->__('Store'),
            'index'     => 'store_id',
            'type'      => 'store',
            'width'     => '400px',
            'store_view'=> true,
            'display_deleted' => true,
        ));

        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Users'),
            'index' => 'company',
            'filter_index' => 't1.value'
        ));

        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('SKU'),
            'index' => 'sku',
            //'filter_index' => 't1.value'
        ));

        $this->addColumn('product_name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'index' => 'product_name',
            //'filter_index' => 't1.value'
        ));

        $this->addColumn('payment_method', array(
            'header'    => Mage::helper('sales')->__('Payment Method Name'),
            'index'     => 'payment_method',
            'type'      => 'options',
            'options'       => Mage::helper('payment')->getPaymentMethodList(true),
            'option_groups' => Mage::helper('payment')->getPaymentMethodList(true, true, true),
        ));

        $this->addColumn('sum_total', array(
            'header' => Mage::helper('sales')->__('Amount'),
            'index' => 'sum_total',
            'type' => 'currency',
            'currency' => 'order_currency_code',
            'total' => 'sum',
        ));

        $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
        $yesno = array();
        foreach ($yn as $n)
        {
            $yesno[$n['value']] = $n['label'];
        }

        $this->addColumn('minority_interest', array(
            'header' => Mage::helper('sales')->__('Minority Interest'),
            'index' => 'minority_interest',
            'type'  => 'options',
            'width' => '70px',
            'filter_index' => 'product.value',
            'options' => $yesno,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('gka_reports')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('gka_reports')->__('XML'));
        $this->addExportType('*/*/exportExcel', Mage::helper('gka_reports')->__('XML (Excel)'));
        $this->setCountTotals(true);
        return parent::_prepareColumns();
    }


    public function getTotals() {
        return $this->_varTotals;
    }


    protected function _afterLoadCollection() {
        $data = array();
        foreach ($this->getCollection() as $item) {
            foreach ($this->getColumns() as $col) {
                if ($col->getTotal()) {
                    if (!isset($data[$col->getId()])) {
                        $data[$col->getId()] = $item->getData($col->getIndex());
                    } else {
                        $data[$col->getId()] += $item->getData($col->getIndex());
                    }
                }
            }
        }

        $helper = Mage::helper('core');
        foreach ($data as $key => $value) {
            $data[$key] = $helper->currency($value, true, false);
        }


        $this->setTotals(new Varien_Object($data));
    }


	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/grid', $params);

    }



}
