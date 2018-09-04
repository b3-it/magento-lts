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
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Edit_Tab_Items extends Mage_Adminhtml_Block_Widget_Grid
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

  protected function _prepareCollection()
  {
  	  $model = $this->_getKassenbuchjournal();
      $collection = $model->getItemsCollection();
      
      $collection->getSelect()->columns(array('externes_kassenzeichen_bool' => "IF(LENGTH(externes_kassenzeichen),1,0)"));
      
      $this->setCollection($collection);
      
      
      //die($collection->getSelect()->__toString());
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id_grid', array(
          'header'    => Mage::helper('gka_barkasse')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('number_grid', array(
          'header'    => Mage::helper('gka_barkasse')->__('Number'),
          //'align'     =>'left',
          'width'     => '100px',
          'index'     => 'number',
      ));
      
      $this->addColumn('booking_date_grid', array(
      		'header'    => Mage::helper('gka_barkasse')->__('Booking Date'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'type'		=>'datetime',
      		'index'     => 'booking_date',
      ));
      $this->addColumn('booking_amount_grid', array(
          'header'    => Mage::helper('gka_barkasse')->__('Booking Amount'),
          //'align'     =>'left',
          'width'     => '150px',
          'type'  => 'currency',
          'index'     => 'booking_amount',
          'currency_code' => 'EUR',
      ));
      
      $this->addColumn('given_amount_grid', array(
      		'header'    => Mage::helper('gka_barkasse')->__('Given Amount'),
      		//'align'     =>'left',
      		'width'     => '150px',
      		'index'     => 'given_amount',
          'type'  => 'currency',
      		'filter_index' => 'main_table.given_amount',
          'currency_code' => 'EUR',
      ));
      
      $this->addColumn('increment_id_grid', array(
          'header'    => Mage::helper('gka_barkasse')->__('Order#'),
          //'align'     =>'left',
          'width'     => '150px',
          'index'     => 'increment_id',
      ));
      
      
      $this->addColumn('pay_client_grid', array(
      		'header' => Mage::helper('sales')->__('ePayBL Client'),
      		'index' => 'pay_client',
      		'type' => 'text',
      		'width' => '100px',
      		'filter_index' => 'payment.pay_client',
      ));
      
      $this->addColumn('kassenzeichen_grid', array(
      		'header'    => Mage::helper('gka_barkasse')->__('Checkout Number'),
      		//'align'     =>'left',
      		'width'     => '150px',
      		'index'     => 'kassenzeichen',
      ));



     $this->addColumn('status_grid', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
      
      
     $this->addColumn('externes_kassenzeichen', array(
     		'header' => Mage::helper('gka_barkasse')->__('Externes Kassenzeichen'),
     		'index' => 'externes_kassenzeichen_bool',
     		'type'  => 'options',
     		'width' => '70px',
     		'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
     		 
     ));


		$this->addExportType('*/*/exportCsv', Mage::helper('gka_barkasse')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('gka_barkasse')->__('XML'));

      return parent::_prepareColumns();
  }

  public function getGridUrl($params = array())
  {
  		$id     =  intval($this->getRequest()->getParam('id'));
    	return $this->getUrl('*/*/Items', array('id'=>$id));
  
  }
  
  protected function _getKassenbuchjournal()
  {
  	$res = null;
  	if ( Mage::getSingleton('adminhtml/session')->getkassenbuchjournalData() )
  	{
  		$res = Mage::getSingleton('adminhtml/session')->getkassenbuchjournalData();
  	  
  	} elseif ( Mage::registry('kassenbuchjournal_data') ) {
  		$res = Mage::registry('kassenbuchjournal_data');
  	}
  
  	return $res;
  }

}
