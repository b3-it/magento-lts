<?php
 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('kassenbuch_cashboxGrid');
      $this->setDefaultSort('kassenbuch_cashbox_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->getCollection();

      if(Mage::helper('gka_barkasse')->isModuleEnabled('Egovs_Isolation')) {
          if (!Mage::helper('isolation')->getUserIsAdmin()) {
            $stores = Mage::helper('isolation')->getUserStoreViews();
            $collection->getSelect()->where("store_id IN (?)", $stores);
        }
      }




      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('gka_barkasse')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('gka_barkasse')->__('Title'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'title',
      ));
      $this->addColumn('customer_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('User ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customer_id',
      ));
      $this->addColumn('customer', array(
          'header'    => Mage::helper('gka_barkasse')->__('User'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'customer',
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('gka_barkasse')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('gka_barkasse')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
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
    	return $this->getUrl('*/*/*', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
