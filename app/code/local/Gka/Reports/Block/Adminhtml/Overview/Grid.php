<?php
 /**
  *
  * @category   	Gka Reports
  * @package    	Gka_Reports
  * @name       	Gka_Reports_Block_Adminhtml_Overview_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Reports_Block_Adminhtml_Overview_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('overviewBEGrid');
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

        //$this->getCollection()->initReport('gka_reports/overview_collection');

        $collection = Mage::getResourceModel('sales/order_grid_collection');
        $eav = Mage::getResourceModel('eav/entity_attribute');

        $collection->getSelect()
            //->joinleft(array('payment' => $collection->getTable('sales/order_payment')), 'payment.parent_id=main_table.entity_id', array('kassenzeichen','method','pay_client'))
            ->joinleft(array('t1'=>$collection->getTable('customer/entity').'_varchar'), 'main_table.customer_id=t1.entity_id AND t1.attribute_id = '.intval($eav->getIdByCode('customer','company')),array('company'=>'value') )
            ->group(array('customer_id','payment_method'))
            ->columns(array('amount'=>new Zend_Db_Expr("sum(base_grand_total)")));

        ;
        //die($collection->getSelect()->__toString());
        $this->setCollection($collection);
        parent::_prepareCollection();
        $this->_afterLoadCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
//       $this->addColumn('id', array(
//           'header'    => Mage::helper('gka_barkasse')->__('ID'),
//           'align'     =>'right',
//           'width'     => '50px',
//           'index'     => 'id',
//       ));


        $this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Created At'),
            'align'     =>'left',
            'index'     => 'created_at',
            'width'		=> '150',
            'type'	=> 'date',
        ));

        $this->addColumn('store_id', array(
            'header'    => Mage::helper('sales')->__('Store'),
            'index'     => 'store_id',
            'type'      => 'store',
            'width'     => '300px',
            'store_view'=> true,
            'display_deleted' => true,
        ));

        $this->addColumn('company', array(
            'header' => Mage::helper('sales')->__('Operator'),
            'index' => 'company',
        ));


        $this->addColumn('payment_method', array(
            'header' => Mage::helper('sales')->__('Payment Method'),
            'index' => 'payment_method',
            'type' => 'options',
            'width' => '200px',
           // 'filter_index' => 'payment_method',
            'options' => Mage::helper('gka_reports')->getActivePaymentMethods(),
        ));

        $this->addColumn('amount', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'amount',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
            'filter' => false,
            'sort' => false,
            'total' => 'sum'
        ));


        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '180px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),

        ));



        $this->addExportType('*/*/exportCsv', Mage::helper('gka_reports')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('gka_reports')->__('XML'));
        $this->addExportType('*/*/exportExcel', Mage::helper('gka_reports')->__('XML (Excel)'));
        $this->setCountTotals(true);
        return parent::_prepareColumns();
    }


    public function xgetTotals() {
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
