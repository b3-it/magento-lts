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
class Gka_Reports_Block_Adminhtml_Overview_Grid extends Mage_Adminhtml_Block_Report_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('overviewBEGrid');
      $this->setDefaultSort('increment_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setDefaultLimit(100);
      //$this->setUseAjax(true);

      $this->setTemplate('egovs/extreport/grid.phtml');

      $from = date("Y-m-d", strtotime('-1 day'));
      $to = date("Y-m-d", strtotime('-0 day'));
      $locale = Mage::app()->getLocale()->getLocaleCode();
      /*
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
      */
  }

    protected function _prepareCollection() {
        parent::_prepareCollection();
        $this->getCollection()->initReport('gka_reports/overview_collection');
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


        $this->addColumn('owner', array(
            'header'    => Mage::helper('gka_barkasse')->__('Owner'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'owner',
        ));

        $this->addColumn('opening_balance', array(
            'header'    => Mage::helper('gka_barkasse')->__('Opening Balance'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'opening_balance',
            //'type'	=> 'price'
            'type'  => 'currency',
            'currency_code' => 'EUR',
        ));



        $this->addColumn('sum_booking_amount', array(
            'header'    => Mage::helper('gka_barkasse')->__('Total Taking'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'sum_booking_amount',
            'type'  => 'currency',
            'currency_code' => 'EUR',
        ));

        $this->addColumn('withdrawal', array(
            'header'    => Mage::helper('gka_barkasse')->__('Withdrawal'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'withdrawal',
            'type'  => 'currency',
            'currency_code' => 'EUR',
        ));

        $this->addColumn('closing_balance', array(
            'header'    => Mage::helper('gka_barkasse')->__('Closing Balance'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'closing_balance',
            //	'type'	=> 'price'
            'type'  => 'currency',
            'currency_code' => 'EUR',
        ));

        $this->addColumn('terminal', array(
            'header'    => Mage::helper('gka_barkasse')->__('Terminal'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'terminal',
            //	'type'	=> 'price'
            'type'  => 'currency',
            'currency_code' => 'EUR',
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
    	return $this->getUrl('*/*/*', $params);

    }



}
