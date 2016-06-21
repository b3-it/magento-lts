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
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Days extends Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Abstract
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('eventdayGrid');
      $this->setDefaultSort('eventday_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  
  protected function getEvent()
  {
  	return Mage::registry('event_data');
  }
  
  protected function getDynamicColumns()
  {
  		
  		
  		$res = array();
  		foreach($this->getSelections() as $item)
  		{
  			if($item->getEventRole() == Bfr_EventManager_Model_Role::STATUS_DAY){
  				$res[] = $item;
  			}
  		}
  		
  		
  		return $res;
  }
  
  
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('eventmanager/participant')->getCollection();
      $collection->getSelect()
      	//->columns(array('company'=>"TRIM(CONCAT(company,' ',company2,' ',company3))"))
      	->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"))
      	->where('event_id='.$this->getEvent()->getId());
      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  protected function _afterLoadCollection()
  {
  		foreach($this->getCollection()->getItems() as $item)
  		{
  			$soldProducts = $this->getSoldProductsIds($item->getOrderItemId());
  			foreach($this->getDynamicColumns() as $col)
  			{
  				if(in_array($col->getId(),$soldProducts)){
  					$item->setData('col_'.$col->getId(),'x');
  				}else{
  					$item->setData('col_'.$col->getId(),'o');
  				}
  			}
  		}
  		
  		return $this;
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
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
		foreach($this->getDynamicColumns() as $col)
		{
			$this->addColumn('col_'.$col->getId(), array(
					'header'    => $col->getName(),
					'align'     =>'left',
					'index'     => 'col_'.$col->getId(),
					'width'     => '100px',
					//'filter_condition_callback' => array($this, '_filterNameCondition'),
			));
		}
      



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
