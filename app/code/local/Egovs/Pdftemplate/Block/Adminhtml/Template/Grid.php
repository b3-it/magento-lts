<?php
/**
 * 
 *  Grid für pdf Template
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('templateGrid');
      $this->setDefaultSort('template_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('pdftemplate/template')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('pdftemplate_template_id', array(
          'header'    => Mage::helper('pdftemplate')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'pdftemplate_template_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('pdftemplate')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('pdftemplate')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
      $this->addColumn('created_at', array(
      		'header'    => Mage::helper('pdftemplate')->__('Created At'),
      		'align'     =>'left',
      		'width'     => '20px',
      		'type'		=> 'datetime',
      		'index'     => 'created_at',
      		'gmtoffset' => true
      ));
      
      $this->addColumn('updated_at', array(
      		'header'    => Mage::helper('pdftemplate')->__('Updated At'),
      		'align'     =>'left',
      		'width'     => '20px',
      		'type'		=> 'datetime',
      		'index'     => 'updated_at',
      		'gmtoffset' => true
      ));

      $this->addColumn('type', array(
          'header'    => Mage::helper('pdftemplate')->__('Type'),
          'align'     => 'left',
          'width'     => '120px',
          'index'     => 'type',
          'type'      => 'options',
          'options'   => Egovs_Pdftemplate_Model_Type::getOptionArray(),
      ));
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('pdftemplate')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('pdftemplate')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('pdftemplate')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('pdftemplate')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('template_id');
        $this->getMassactionBlock()->setFormFieldName('template_id');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('pdftemplate')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('pdftemplate')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('pdftemplate/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('pdftemplate')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('pdftemplate')->__('Status'),
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