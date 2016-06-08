<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Translate_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Translate_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('translateGrid');
      $this->setDefaultSort('translate_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('eventmanager/translate')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('translate_id', array(
          'header'    => Mage::helper('eventmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'translate_id',
      ));

      $this->addColumn('source', array(
          'header'    => Mage::helper('eventmanager')->__('Source'),
          'align'     =>'left',
          'index'     => 'source',
      ));
      
      $this->addColumn('dest', array(
      		'header'    => Mage::helper('eventmanager')->__('Destination'),
      		'align'     =>'left',
      		'index'     => 'dest',
      ));


      $this->addColumn('lang_code', array(
          'header'    => Mage::helper('eventmanager')->__('Language'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'lang_code',
          'type'      => 'options',
          'options'   => Bfr_EventManager_Model_Event_Lang::getOptionArray(),
      ));
	
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('eventmanager')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eventmanager')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('eventmanager')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('eventmanager')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('translate_id');
        $this->getMassactionBlock()->setFormFieldName('translate');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('eventmanager')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('eventmanager')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('eventmanager/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('eventmanager')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('eventmanager')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
