<?php
 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('kassenbuch_journalGrid');
      $this->setDefaultSort('kassenbuch_journal_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  protected function _prepareCollection() {
      $collection = Mage::getModel('gka_barkasse/kassenbuch_journal')->getCollection();
      $expr = new Zend_Db_Expr('(SELECT sum(id) as sum_id, sum(booking_amount) as sum_booking_amount, journal_id FROM ' . $collection->getTable('gka_barkasse/kassenbuch_journal_items') . ' GROUP BY journal_id)');

      $collection->getSelect()
          ->joinLeft(array('items' => $expr), 'items.journal_id=main_table.id', array('sum_id', 'sum_booking_amount'));

      if (Mage::helper('gka_barkasse')->isModuleEnabled('Egovs_Isolation'))
      {
          $helper = Mage::helper('isolation');
          if (!$helper->getUserIsAdmin()) {
              $views = $helper->getUserStoreViews();
              $views[] = '-1'; //damit das Array gefüllt ist
              $collection->getSelect()
                  ->join(array('cashbox' => $collection->getTable('gka_barkasse/kassenbuch_cashbox')), 'main_table.cashbox_id=cashbox.id', array())
                  ->where('cashbox.store_id IN (' . implode(',', $views) . ')');
          }
      }
      
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
//       $this->addColumn('id', array(
//           'header'    => Mage::helper('gka_barkasse')->__('ID'),
//           'align'     =>'right',
//           'width'     => '50px',
//           'index'     => 'id',
//       ));

      $this->addColumn('number', array(
          'header'    => Mage::helper('gka_barkasse')->__('Number'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'number',
      ));
      $this->addColumn('owner', array(
          'header'    => Mage::helper('gka_barkasse')->__('Owner'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'owner',
      ));
      $this->addColumn('opening', array(
          'header'    => Mage::helper('gka_barkasse')->__('Opening'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'opening',
      	'type'	=> 'datetime'
      ));
      $this->addColumn('closing', array(
          'header'    => Mage::helper('gka_barkasse')->__('Closing'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'closing',
      		'type'	=> 'datetime'
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
      
      $this->addColumn('sum_id', array(
      		'header'    => Mage::helper('gka_barkasse')->__('Deposits'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'sum_id',
      		//'type'  => 'currency',
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
      
     
      

      

      /*
      $this->addColumn('customer_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('Owner ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customer_id',
      ));
      $this->addColumn('cashbox_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('Cashbox ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'cashbox_id',
      ));
      */
      $this->addColumn('cashbox_title', array(
          'header'    => Mage::helper('gka_barkasse')->__('Cashbox'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'cashbox_title',
      ));


      $this->addColumn('status', array(
      		'header'    => Mage::helper('gka_barkasse')->__('Status'),
      		'align'     => 'left',
      		'width'     => '80px',
      		'index'     => 'status',
      		'type'      => 'options',
      		'options'   => Gka_Barkasse_Model_Kassenbuch_Journal_Status::getOptionArray()
      ));
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('gka_barkasse')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('gka_barkasse')->__('Details'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        $this->addColumn('action1',
        		array(
        				'header'    =>  Mage::helper('gka_barkasse')->__('Protokoll'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('gka_barkasse')->__('Pdf'),
        								'url'       => array('base'=> '*/*/pdf'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));

		$this->addExportType('*/*/exportCsv', Mage::helper('gka_barkasse')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('gka_barkasse')->__('XML'));

      return parent::_prepareColumns();
  }

 

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/grid', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
