<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Participant_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('participantGrid');
      $this->setDefaultSort('participant_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
  	
  	  /*
  	   * SELECT GROUP_CONCAT(value) FROM eventmanager_participant_attribute as main_table
join eventmanager_lookup as el on el.lookup_id = main_table.lookup_id
where participant_id = 1 AND el.typ = 3
  	   */	
  	
      $collection = Mage::getModel('eventmanager/participant')->getCollection();
      $collection->getSelect()
      	->join(array('event'=>$collection->getTable('eventmanager/event')), 'main_table.event_id = event.event_id',array('title'))
      	->columns(array('company'=>"TRIM(CONCAT(company,' ',company2,' ',company3))"))
      	->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"));

      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('participant_id', array(
          'header'    => Mage::helper('eventmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'participant_id',
      ));

      $this->addColumn('created_time', array(
      		'header'    => Mage::helper('eventmanager')->__('Created at'),
      		'align'     =>'left',
      		'index'     => 'created_time',
      		'type'	=> 'Date',
      		'width'     => '100px',
      ));
      
      $this->addColumn('title', array(
      		'header'    => Mage::helper('eventmanager')->__('title'),
      		'width'     => '100px',
      		'index'     => 'title',
      		//'type'      => 'number',
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
      $this->addColumn('company', array(
      		'header'    => Mage::helper('eventmanager')->__('Company'),
      		'align'     =>'left',
      		'index'     => 'company',
      		'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      $role = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE)->getOptionArray();
      $this->addColumn('role', array(
          'header'    => Mage::helper('eventmanager')->__('Role'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'role_id',
          'type'      => 'options',
          'options'   => $role,
      ));
      
      $job = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB)->getOptionArray();
      $this->addColumn('pa_jop', array(
      		'header'    => Mage::helper('eventmanager')->__('Job'),
      		'align'     => 'left',
      		'width'     => '80px',
      		'index'     => 'job_id',
      		'type'      => 'options',
      		'options'   => $job,
      ));
      

      $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      $yesno = array();
      foreach ($yn as $n)
      {
      	$yesno[$n['value']] = $n['label'];
      }
      
      $this->addColumn('internal', array(
          'header'    => Mage::helper('eventmanager')->__('Internal'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'internal',
          'type'      => 'options',
          'options'   => $yesno,
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
        $this->setMassactionIdField('participant_id');
        $this->getMassactionBlock()->setFormFieldName('participant');

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

  
  /**
   * FilterIndex
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterCompanyCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	 
  	$condition = "TRIM(CONCAT(company,' ',company2,' ',company3)) like ?";
  	$collection->getSelect()->where($condition, "%$value%");
  }
  
  /**
   * FilterIndex
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterNameCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	
  	$condition = "TRIM(CONCAT(firstname,' ',lastname)) like ?";
  	$collection->getSelect()->where($condition, "%$value%");
  }
}
