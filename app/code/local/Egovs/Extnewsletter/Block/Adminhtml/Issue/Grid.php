<?php

class Egovs_Extnewsletter_Block_Adminhtml_Issue_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('issueGrid');
      $this->setDefaultSort('issue_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('extnewsletter/issue')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('extnewsletter')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'extnewsletter_issue_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('extnewsletter')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      $yesno = array();
      foreach ($yn as $n)
      {
      	$yesno[$n['value']] = $n['label'];
      }
      
      $this->addColumn('remove_subscriber_after_send', array(
      		'header'    => Mage::helper('extnewsletter')->__('Remove subscriber after send'),
      		'align'     =>'left',
      		'index'     => 'remove_subscriber_after_send',
      		'type' 		=> 'options',
      		'options'	=> $yesno,
      		'width'		=> '150'
      ));

	  
      $this->addColumn('remarks', array(
			'header'    => Mage::helper('extnewsletter')->__('Remarks'),
			'width'     => '150px',
			'index'     => 'remarks',
      ));
      
      $opt = Mage::getModel('core/store')->getCollection()->toOptionHash();
      $opt[0] = Mage::helper('extnewsletter')->__('All');
      $this->addColumn('store_id', array(
			'header'    => Mage::helper('extnewsletter')->__('Store'),
			'width'     => '150px',
			'index'     => 'store_id',
      		'type'	=>'options',
      		'options' => $opt,
      ));
	  
	
		//$this->addExportType('*/*/exportCsv', Mage::helper('extnewsletter')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('extnewsletter')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function x_prepareMassaction()
    {
        $this->setMassactionIdField('issue_id');
        $this->getMassactionBlock()->setFormFieldName('issue');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('extnewsletter')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('extnewsletter')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('extnewsletter/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('extnewsletter')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('extnewsletter')->__('Status'),
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