<?php
 /**
  *
  * @category   	Dwd Fix
  * @package    	Dwd_Fix
  * @name       	Dwd_Fix_Block_Adminhtml_Rechnung_Rechnung_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Fix_Block_Adminhtml_Rechnung_Rechnung_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('rechnung_rechnungGrid');
      $this->setDefaultSort('rechnung_rechnung_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('dwd_fix/rechnung_rechnung')->getCollection();
      $collection->getSelect()
      ->join(array('order'=>$collection->getTable('sales/order')),'order.entity_id=main_table.order_id');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('dwd_fix')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('invoice', array(
          'header'    => Mage::helper('dwd_fix')->__('Bestellung'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'increment_id',
      ));
      
      $this->addColumn('date', array(
      		'header'    => Mage::helper('dwd_fix')->__('Erstellt'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'created_at',
      		'type' => 'datetime'
      ));
      $this->addColumn('send', array(
          'header'    => Mage::helper('dwd_fix')->__('Versendet'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'send',
      		'type' => 'datetime'
      ));

  

		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_fix')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_fix')->__('XML'));

      return parent::_prepareColumns();
  }

  

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }

 
}
