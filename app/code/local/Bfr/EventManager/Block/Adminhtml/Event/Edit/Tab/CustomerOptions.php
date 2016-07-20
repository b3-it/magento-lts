<?php
/**
 * Bfr EventManager
 * Anzeige der Individualisierungsoptionen
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_CustomerOptions extends Mage_Adminhtml_Block_Widget_Grid
{
	
  public function __construct()
  {
      parent::__construct();
      $this->setId('customeroptionsGrid');
      //$this->setDefaultSort('eventday_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
  }

  
  protected function getEvent()
  {
  	return Mage::registry('event_data');
  }
  
  protected function getDynamicColumns()
  {
  		$product = $this->getEvent()->getProduct();
  		$options = $product->getOptions();
  		return $options;
  }
  
  
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('eventmanager/participant')->getCollection();
      $collection->getSelect()
      ->joinLeft(array('order'=>$collection->getTable('sales/order')),'order.entity_id = main_table.order_id',array('increment_id','status'))
        ->joinLeft(array('orderitem'=>$collection->getTable('sales/order_item')),'orderitem.item_id = main_table.order_item_id')
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
  			$product_options =  $item->getProductOptions();
  			if($product_options)
  			{
  				$product_options = unserialize($product_options);
  				
  				$options = array();
  				if(isset($product_options['info_buyRequest']['options']))
  				{
  					$option = $product_options['info_buyRequest']['options'];
  				}
  				
  				
	  			foreach($this->getDynamicColumns() as $col)
	  			{	  				
	  				if(isset($option[$col->getOptionId()])){
	  					$item->setData('customeroption_'.$col->getOptionId(),$option[$col->getOptionId()]);
	  				}else{
	  					$item->setData('customeroption_'.$col->getOptionId(),false);
	  				}
	  			}
  			}
  		}
  		
  		return $this;
  }

  protected function _prepareColumns()
  {
      $this->addColumn('co_participant_id', array(
          'header'    => Mage::helper('eventmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'participant_id',
      ));

      $this->addColumn('co_created_time', array(
      		'header'    => Mage::helper('eventmanager')->__('Created at'),
      		'align'     =>'left',
      		'index'     => 'created_time',
      		'type'	=> 'Date',
      		'width'     => '100px',
      ));
      
      $this->addColumn('co_increment_id', array(
      		'header'    => Mage::helper('eventmanager')->__('Order #'),
      		'align'     =>'left',
      		'width'     => '100px',
      		'index'     => 'increment_id',
      		//'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
      $this->addColumn('co_status', array(
      		'header' => Mage::helper('sales')->__('Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      $this->addColumn('co_name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
      
		foreach($this->getDynamicColumns() as $col)
		{
			$this->addColumn('co_customeroption_'.$col->getOptionId(), array(
					'header'    => $col->getDefaultTitle(),
					'align'     =>'left',
					'index'     => 'customeroption_'.$col->getOptionId(),
					'width'     => '100px',
					//'filter_condition_callback' => array($this, '_filterNameCondition'),
			));
		}
      



		$this->addExportType('*/*/exportcustomeroptionsCsv', Mage::helper('eventmanager')->__('CSV'));
		$this->addExportType('*/*/exportcustomeroptionsXml', Mage::helper('eventmanager')->__('XML'));

      return parent::_prepareColumns();
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
  
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/customeroptionsgrid', array('id'=>$this->getEvent()->getId()));
  }
  
}
