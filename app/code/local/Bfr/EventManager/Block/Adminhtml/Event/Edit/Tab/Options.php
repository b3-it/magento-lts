<?php
/**
 * Bfr EventManager
 * Anzeige der gekauften UnterProdukte
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Options extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_selections = null;
	
	private static $_count = 0;
	
	public function __construct(array $args = array())
	{
		self::$_count++;
		parent::__construct();
		
	    $this->setId('eventoptionGrid'.$args['option']->getId());
	    $this->setDefaultDir('ASC');
	    $this->setSaveParametersInSession(true);
	    $this->setUseAjax(true);
	    
	}

 
	
	protected function getEvent()
	{
		return Mage::registry('event_data');
	}

	/**
	 * Filter für die Produkte die zur Option des aktuellen Tabs gehören
	 * @return multitype:unknown
	 */
	protected function getSelections()
	{
			$res = array();
			foreach($this->getAllSelections() as $item)
			{
				if($item->getOptionId() == $this->getOption()->getId()){
					$res[] = $item;
				}
			}
			return $res;
	}
  
	
  /**
   * Ermitteln aller verfügbaren Unterprodukte für das Bundle 
   */
	 
  protected function getAllSelections()
  {
  	if($this->_selections == null){
	  	$product = $this->getEvent()->getProduct();
	  	{
	  		$this->_selections = $product->getTypeInstance(true)
	  		->getSelectionsCollection(
	  				$product->getTypeInstance(true)->getOptionsIds($product),
	  				$product
	  		);
	  
	  	}
  	}
  	return $this->_selections;
  }
  
  
  protected function _prepareCollection()
  {
	$collection = Mage::getModel('sales/order')->getCollection();
      
      foreach($this->getSelections() as $product){
      	$col = 'col_'.$product->getId();
      	$collection->getSelect()
      	->joinLeft(array( $col=>$collection->getTable('sales/order_item')), $col.'.order_id = main_table.entity_id AND '.$col.'.product_id='.$product->getId(), array($col =>'name'));
      }
      
      $collection->getSelect()
      ->distinct()
      ->columns(array('name'=>"TRIM(CONCAT(customer_firstname,' ',customer_lastname))"));
    //die( $collection->getSelect()->__toString());  
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
  
  
  
 
  protected function _prepareColumns()
  {

      $this->addColumn('op_created_time', array(
      		'header'    => Mage::helper('eventmanager')->__('Created at'),
      		'align'     =>'left',
      		'index'     => 'created_at',
      		'type'	=> 'Date',
      		'width'     => '100px',
      ));
      
      $this->addColumn('op_increment_id', array(
      		'header'    => Mage::helper('eventmanager')->__('Order #'),
      		'align'     =>'left',
      		'width'     => '100px',
      		'index'     => 'increment_id',
      		//'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      
      $this->addColumn('op_status', array(
      		'header' => Mage::helper('sales')->__('Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      $this->addColumn('op_name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      

		foreach($this->getSelections() as $col)
		{
			$this->addColumn('op_col_'.$col->getId(), array(
					'header'    => $col->getName(),
					'align'     =>'left',
					'index'     => 'col_'.$col->getId(),
					'width'     => '100px',
					'filter_condition_callback' => array($this, '_filterDynamicCondition'),
			));
		}

		$this->addExportType('*/*/exportoptionsCsv', Mage::helper('eventmanager')->__('CSV'),array('optionId'=> $this->getOption()->getId(),'id'=>$this->getEvent()->getId()));
		$this->addExportType('*/*/exportoptionsXml', Mage::helper('eventmanager')->__('XML'),array('optionId'=> $this->getOption()->getId(),'id'=>$this->getEvent()->getId()));

      return parent::_prepareColumns();
  }


  public function addExportType($url, $label, array $attributes = array())
  {
  	$this->_exportTypes[] = new Varien_Object(
  			array(
  					'url'   => $this->getUrl($url, $attributes),
  					'label' => $label
  			)
  	);
  	return $this;
  }
  
  
  public function getGridUrl()
  {
  	return $this->getUrl('*/*/optionsgrid', array('optionId'=> $this->getOption()->getId(),'id'=>$this->getEvent()->getId()));
  }
  

 /**
  * die Filterbedingungen für die dynymischen Spalten 
  * @param unknown $collection
  * @param unknown $column
  */
  protected function _filterDynamicCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  
  	$condition = $column->getIndex().'.name like ?';
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
