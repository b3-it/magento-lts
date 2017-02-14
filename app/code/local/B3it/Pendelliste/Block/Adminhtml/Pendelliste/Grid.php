<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Block_Adminhtml_Pendelliste_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('pendellisteGrid');
      $this->setDefaultSort('pendelliste_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('pendelliste/pendelliste')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('pendelliste')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('pendelliste')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $this->addColumn('content', array(
      		'header'    => Mage::helper('pendelliste')->__('Inhalt'),
      		'align'     =>'left',
      		'index'     => 'content',
      		//'width'     => '50px',
      ));


	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('pendelliste')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('pendelliste')->__('Import'),
                        'url'       => array('base'=> '*/*/import'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('pendelliste')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('pendelliste')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('task_id');
        $this->getMassactionBlock()->setFormFieldName('pendelliste');

       

        $statuses = Mage::getSingleton('pendelliste/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('pendelliste')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('pendelliste')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function xgetRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}