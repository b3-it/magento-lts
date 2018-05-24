<?php
 /**
  *
  * @category   	Egovs ContextHelp
  * @package    	Egovs_ContextHelp
  * @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('contexthelpGrid');
      $this->setDefaultSort('contexthelp_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('contexthelp/contexthelp')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('contexthelp')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('contexthelp')->__('Title'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'title',
      ));
      $this->addColumn('category_id', array(
          'header'    => Mage::helper('contexthelp')->__('Category'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'category_id',
      ));
    
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('contexthelp')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('contexthelp')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('contexthelp')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('contexthelp')->__('XML'));
    $this->addExportType('*/*/exportExcel', Mage::helper('contexthelp')->__('XML (Excel)'));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('contexthelp_ids');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('contexthelp')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('contexthelp')->__('Are you sure?')
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
