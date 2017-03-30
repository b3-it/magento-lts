<?php
 /**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journalitems_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journalitems_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('kassenbuch_journal_itemsGrid');
      $this->setDefaultSort('kassenbuch_journal_items_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('gka_barkasse/kassenbuch_journalitems')->getCollection();
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

      $this->addColumn('number', array(
          'header'    => Mage::helper('gka_barkasse')->__('Nubmer'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'number',
      ));
      $this->addColumn('booking_date', array(
          'header'    => Mage::helper('gka_barkasse')->__('Booking Date'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'booking_date',
      ));
      $this->addColumn('booking_amount', array(
          'header'    => Mage::helper('gka_barkasse')->__('Booking Amount'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'booking_amount',
      ));
      $this->addColumn('journal_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('Journal ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'journal_id',
      ));
      $this->addColumn('order_id', array(
          'header'    => Mage::helper('gka_barkasse')->__('Order ID'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'order_id',
      ));
      $this->addColumn('order_cancel', array(
          'header'    => Mage::helper('gka_barkasse')->__('Cancel'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'order_cancel',
      ));
      $this->addColumn('source', array(
          'header'    => Mage::helper('gka_barkasse')->__('Source'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'source',
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

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('kassenbuchjournal_items_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('gka_barkasse')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('gka_barkasse')->__('Are you sure?')
        ));

        return $this;
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
