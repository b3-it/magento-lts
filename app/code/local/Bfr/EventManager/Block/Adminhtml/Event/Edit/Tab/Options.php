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
	    $this->setCountTotals(true);
	    
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
		$collection = Mage::getModel('eventmanager/participant')->getCollection();
		$collection->getSelect()
		->joinleft(array( 'order'=>$collection->getTable('sales/order')), 'main_table.order_id = order.entity_id', array('order_increment_id'=>'increment_id','order_status'=>'status', 'created_at'));
		
		$col = null;
		$coalesce = array();

		$i = 0;
      foreach($this->getSelections() as $product){
          $i++;
      	$col = 'col_'.$i.'_'.$product->getId();
      	$coalesce[] = $col.'.product_id';
      	$collection->getSelect()
      	->joinleft(array( $col=>$collection->getTable('sales/order_item')), $col.'.order_id = order.entity_id AND '.$col.'.product_id='.$product->getId(), array($col =>'qty_ordered'));
      	
      }
      
      $coalesce[] = '0';
      
      $collection->getSelect()
      ->distinct()
      ->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"))
      ->where(new Zend_Db_Expr('coalesce('.implode(',', $coalesce).') > 0'));
      
      //verhindern das alle angezeigt werden falls zu der Option kein Produkt konfiguriert wurde
      if($col == null){
      	$collection->getSelect()->where('order.entity_id=0');
      }
      
  
      //die( $collection->getSelect()->__toString());  
      $this->setCollection($collection);
     
      parent::_prepareCollection();
      $this->_prepareTotals();
      return $this;
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
      		'index'     => 'order_increment_id',
      		'filter_index' => 'order.increment_id',
      		'filter_condition_callback' => array($this, '_filterCondition'),
      ));
      
      $this->addColumn('op_status', array(
      		'header' => Mage::helper('sales')->__('Order Status'),
      		'index' => 'order_status',
      		'type'  => 'options',
      		'width' => '70px',
      		'filter_index' => 'order.status',
      		'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));
      
      $this->addColumn('op_name', array(
          'header'    => Mage::helper('eventmanager')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      	  'filter_condition_callback' => array($this, '_filterNameCondition'),
      ));
      

      $columns = array();
      $i = 0;
		foreach($this->getSelections() as $col)
		{
            $i++;
            $colname = 'col_'.$i.'_'.$col->getId();
			$columns[] = 'op_col_'.$col->getId();
			$this->addColumn('op_col_'.$i.'_'.$col->getId(), array(
					'header'    => $col->getName(),
					'align'     =>'left',
					'index'     => $colname,
					'filter_index'     => $colname.".qty_ordered",
					'total'		=> 'sum',
					'type'      => 'number',
					//'total_label'=> 'xxx',
					'width'     => '100px',
					'filter_condition_callback' => array($this, '_filterDynamicCondition'),
			));
		}

		
		$this->setCountTotals(true);
		$this->addExportType('*/*/exportoptionsCsv', Mage::helper('eventmanager')->__('CSV'),array('optionId'=> $this->getOption()->getId(),'id'=>$this->getEvent()->getId()));
		$this->addExportType('*/*/exportoptionsXml', Mage::helper('eventmanager')->__('XML'),array('optionId'=> $this->getOption()->getId(),'id'=>$this->getEvent()->getId()));

      return parent::_prepareColumns();
  }
  
  
  protected function _prepareTotals()
  {
  	$columns = array();
  	foreach($this->getColumns() as $col)
  	{
  		if($col->getTotal()){
  			$columns[] = $col->getIndex();
  		}
  	}
  	$this->_countTotals = true;
  	$totals = new Varien_Object();
  	$fields = array();
  	foreach($columns as $column){
  		$fields[$column]    = 0;
  	}
  	
  	foreach ($this->getCollection() as $item) {
  		foreach($fields as $field=>$value){
  			$fields[$field]+= intval($item->getData($field));
  		}
  	}
  	$totals->setData($fields);
  	$this->setTotals($totals);
  	return;
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
   * 
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterDynamicCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}

  	if($column->getType() == 'number'){


        $filter = $column->getFilter()->getValue();
        $select = $this->getCollection()->getSelect();
        $index = $column->getFilterIndex();
        if(isset($filter['from']) && isset($filter['to'])){
            $select->where("{$index} >=".$filter['from']." AND {$index}<=".$filter['to'] );
        }elseif (isset($filter['from'])){
            $select->where("{$index} >=".$filter['from']);
        }elseif (isset($filter['to'])){
            $select->where("{$index}<=".$filter['to'] );
        }


        return;
    }


  	$condition = $column->getIndex().'.name like ?';
  	$collection->getSelect()->where($condition, "%$value%");
  	//die($collection->getSelect()->__toString());
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
  
  protected function _filterCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  	$filter_index = $column->getFilterIndex();
  	$condition = $filter_index." like ?";
  	$collection->getSelect()->where($condition, "%$value%");
  	//die( $collection->getSelect()->__toString());
  }
}
