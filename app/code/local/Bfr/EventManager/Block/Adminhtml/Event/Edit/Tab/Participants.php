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
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Participants extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('participantGrid');
      $this->setDefaultSort('participant_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  
  protected function getEvent()
  {
  	return Mage::registry('event_data');
  }
  
  protected function _prepareCollection()
  {
  	
  	$industry = new Zend_Db_Expr('(SELECT GROUP_CONCAT(l.value) as value, participant_id FROM eventmanager_participant_attribute as a
						join eventmanager_lookup as l on l.lookup_id = a.lookup_id WHERE l.typ = '.Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY.' group by participant_id)');
  		
  	$lobby = new Zend_Db_Expr('(SELECT GROUP_CONCAT(l.value) as value, participant_id FROM eventmanager_participant_attribute as a
						join eventmanager_lookup as l on l.lookup_id = a.lookup_id WHERE l.typ = '.Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY.' group by participant_id)');
  	
      $collection = Mage::getModel('eventmanager/participant')->getCollection();
      $collection->getSelect()
      ->joinLeft(array('order'=>$collection->getTable('sales/order')),'order.entity_id = main_table.order_id',array('increment_id','status'))
      	->columns(array('company'=>"TRIM(CONCAT(company,' ',company2,' ',company3))"))
      	->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"))
      	->joinLeft(array('lobbyT'=>$lobby),'lobbyT.participant_id=main_table.participant_id',array('lobby'=>'value'))
      	->joinLeft(array('industryT'=>$industry),'industryT.participant_id=main_table.participant_id',array('industry'=>'value'))
      	->where('event_id='.$this->getEvent()->getId());
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('pa_participant_id', array(
          'header'    => Mage::helper('eventmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'participant_id',
      ));

      $this->addColumn('pa_created_time', array(
      		'header'    => Mage::helper('eventmanager')->__('Created at'),
      		'align'     =>'left',
      		'index'     => 'created_time',
      		'type'	=> 'Date',
      		'width'     => '100px',
      ));
      
      $this->addColumn('pa_increment_id', array(
      		'header'    => Mage::helper('eventmanager')->__('Order #'),
      		'align'     =>'left',
      		'width'     => '100px',
      		'index'     => 'increment_id',
      		//'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
      $this->addColumn('pa_status', array(
      		'header' => Mage::helper('sales')->__('Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      
      $this->addColumn('title', array(
      		'header'    => Mage::helper('eventmanager')->__('Event'),
      		'width'     => '100px',
      		'index'     => 'title',
      		//'type'      => 'number',
      ));
      
      
      $this->addColumn('academic_titel', array(
      		'header'    => Mage::helper('eventmanager')->__('Academic Title'),
      		'width'     => '100px',
      		'index'     => 'academic_titel',
      		//'type'      => 'number',
      ));
      
      $this->addColumn('position', array(
      		'header'    => Mage::helper('eventmanager')->__('Occupation'),
      		'width'     => '100px',
      		'index'     => 'position',
      		//'type'      => 'number',
      ));
      
      $this->addColumn('pa_name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      

      
      $this->addColumn('pa_company', array(
      		'header'    => Mage::helper('eventmanager')->__('Company'),
      		'align'     =>'left',
      		'index'     => 'company',
      		'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      $this->addColumn('pa_email', array(
      		'header'    => Mage::helper('eventmanager')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      		//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      $this->addColumn('pa_phone', array(
      		'header'    => Mage::helper('eventmanager')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone',
      		//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      $this->addColumn('pa_address', array(
      		'header'    => Mage::helper('eventmanager')->__('Address'),
      		'align'     =>'left',
      		'index'     => 'street',
      		//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      
      $this->addColumn('pa_country', array(
      		'header'    => Mage::helper('eventmanager')->__('Country'),
      		'align'     =>'left',
      		'index'     => 'country',
      		//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
      ));
      
      
      $this->addColumn('pa_industry', array(
      		'header'    => Mage::helper('eventmanager')->__('Industry'),
      		'align'     =>'left',
      		'index'     => 'industry',
      		'filter_condition_callback' => array($this, '_filterIndustryCondition'),
      ));
      
      $this->addColumn('pa_lobby', array(
      		'header'    => Mage::helper('eventmanager')->__('Lobby'),
      		'align'     =>'left',
      		'index'     => 'lobby',
      		'filter_condition_callback' => array($this, '_filterLobbyCondition'),
      ));
      
      $role = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE)->getOptionArray();
      $this->addColumn('pa_role', array(
          'header'    => Mage::helper('eventmanager')->__('Role'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'role',
          'type'      => 'options',
          'options'   => $role,
      ));
      
      $job = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB)->getOptionArray();
      $this->addColumn('pa_jop', array(
      		'header'    => Mage::helper('eventmanager')->__('Job'),
      		'align'     => 'left',
      		'width'     => '80px',
      		'index'     => 'job',
      		'type'      => 'options',
      		'options'   => $job,
      ));
      

      $yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      $yesno = array();
      foreach ($yn as $n)
      {
      	$yesno[$n['value']] = $n['label'];
      }
      
      $this->addColumn('pa_internal', array(
          'header'    => Mage::helper('eventmanager')->__('Internal'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'internal',
          'type'      => 'options',
          'options'   => $yesno,
      ));
	
        $this->addColumn('pa_action',
            array(
                'header'    =>  Mage::helper('eventmanager')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('eventmanager')->__('Edit'),
                        'url'       => array('base'=> '*/eventmanager_participant/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportparticipantsCsv', Mage::helper('eventmanager')->__('CSV'));
		$this->addExportType('*/*/exportparticipantsXml', Mage::helper('eventmanager')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function x_prepareMassaction()
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
             'url'  => $this->getUrl('*/eventmanager_participant/massStatus', array('_current'=>true)),
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
      return $this->getUrl('*/eventmanager_participant/edit', array('id' => $row->getId(),
      		'event' =>$this->getEvent()->getId()));
  }
  
  public function getGridUrl()
  {
  		return $this->getUrl('*/*/participantsgrid', array('id'=>$this->getEvent()->getId()));
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
  
  /**
   * FilterIndex
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterIndustryCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	$condition = "industryT.value like ?";
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
  protected function _filterLobbyCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	$condition = "lobbyT.value like ?";
  	$collection->getSelect()->where($condition, "%$value%");
  }
}
