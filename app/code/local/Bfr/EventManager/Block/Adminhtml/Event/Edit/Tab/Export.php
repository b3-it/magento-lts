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
class Bfr_EventManager_Block_Adminhtml_Event_Edit_Tab_Export extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_selections = null;
	private $_options = null;
	
	private static $_count = 0;
	
	public function __construct(array $args = array())
	{
		self::$_count++;
		parent::__construct();
		
	    $this->setId('exportGrid');
	    $this->setDefaultDir('ASC');
	    $this->setSaveParametersInSession(true);
	    $this->setUseAjax(true);
	    //$this->setCountTotals(true);
	    
	}

 
	protected function getOptions()
	{
		if($this->_options == null)
		{
			$product = $this->getEvent()->getProduct();
			$optionCollection = $product->getTypeInstance(true)
			->getOptionsCollection($product);
			
			$this->_options = $optionCollection;
			
		}
		
		return $this->_options;
	}
	
	
	protected function getEvent()
	{
		return Mage::registry('event_data');
	}

	/**
	 * Filter für die Produkte die zur Option des aktuellen Tabs gehören
	 * @return multitype:unknown
	 */
	protected function getSelections($option)
	{
			$res = array();
			foreach($this->getAllSelections() as $item)
			{
				if($item->getOptionId() == $option->getId()){
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
  
  /**
   * die indivdualisierungs Optionen
   * @return object
   */
  protected function getDynamicColumns()
  {
  	$product = $this->getEvent()->getProduct();
  	$options = $product->getOptions();
  	return $options;
  }
  
  protected function _prepareCollection()
  {
  	
  	
  	$industry = new Zend_Db_Expr('(SELECT GROUP_CONCAT(l.value) as value, participant_id FROM eventmanager_participant_attribute as a
						join eventmanager_lookup as l on l.lookup_id = a.lookup_id WHERE l.typ = '.Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY.' group by participant_id)');
  	
  	$lobby = new Zend_Db_Expr('(SELECT GROUP_CONCAT(l.value) as value, participant_id FROM eventmanager_participant_attribute as a
						join eventmanager_lookup as l on l.lookup_id = a.lookup_id WHERE l.typ = '.Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY.' group by participant_id)');
  	 
  	
  	
		$collection = Mage::getModel('eventmanager/participant')->getCollection();
		$collection->getSelect()
		->joinLeft(array('order'=>$collection->getTable('sales/order')),'order.entity_id = main_table.order_id',array('order_increment_id'=>'increment_id','order_status'=>'status','created_at','base_grand_total','base_currency_code','base_total_paid'))
		->joinLeft(array('customer'=>$collection->getTable('customer/entity')),'order.customer_id = customer.entity_id',array('group_id'))
		->columns(array('company'=>"TRIM(CONCAT(company,' ',company2,' ',company3))"))
		->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"))
		->columns(array('balance'=> new Zend_Db_Expr('base_grand_total - ifnull(base_total_paid, 0)')))
		->joinLeft(array('lobbyT'=>$lobby),'lobbyT.participant_id=main_table.participant_id',array('lobby'=>'value'))
		->joinLeft(array('industryT'=>$industry),'industryT.participant_id=main_table.participant_id',array('industry'=>'value'))
		->joinLeft(array('orderitem'=>$collection->getTable('sales/order_item')),'orderitem.item_id = main_table.order_item_id')
		
		;



      $collection->getSelect()
          ->distinct()
          ->columns(array('name'=>"TRIM(CONCAT(firstname,' ',lastname))"))
//      ->where(new Zend_Db_Expr('(coalesce('.implode(',', $coalesce).') > 0) OR (event_id='.intval($this->getEvent()->getId()).')'));
          ->where('event_id='.(int)($this->getEvent()->getId()));


      $collection->setSelectCountSql($collection->getSelect());

		$col = null;
		$coalesce = array();

		$i  = 0;
		foreach($this->getOptions() as $option)
		{
	      foreach($this->getSelections($option) as $product){
	          $i++;
	      	$col = 'col_'.$i.'_'.$product->getId();
	      	$coalesce[] = $col.'.product_id';
	      	$collection->getSelect()
	      	->joinleft(array( $col=>$collection->getTable('sales/order_item')), $col.'.order_id = order.entity_id AND '.$col.'.product_id='.$product->getId(), array($col =>'qty_ordered'));
	      	
	      }
		}

      $coalesce[] = '0';


      //verhindern das alle angezeigt werden falls zu der Option kein Produkt konfiguriert wurde
      if($col == null){
      	$collection->getSelect()->where('order.entity_id=0');
      }









      // $collection->getSelect()->orWhere('event_id=?',intval($this->getEvent()->getId()));

      $this->setCollection($collection);


      parent::_prepareCollection();
      //die( $collection->getSelect()->__toString());
      //$this->_prepareTotals();
      return $this;
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
	  	$yn = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
	  	$yesno = array();
	  	foreach ($yn as $n)
	  	{
	  		$yesno[$n['value']] = $n['label'];
	  	}

      $this->addColumn('op_created_time', array(
      		'header'    => Mage::helper('eventmanager')->__('Created at'),
      		'align'     =>'left',
      		'index'     => 'created_at',
      		'filter_index'     => 'order.created_at',
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
      
      	$this->addColumn('pa_price', array(
  			'header' => Mage::helper('sales')->__('Amount'),
  			'index' => 'base_grand_total',
  			'type'  => 'price',
  			'width' => '70px',
  			'currency' => 'base_currency_code',
  			'currency_code' => 'EUR',
  	
  	));
  	
    if($this->_isExport){
      		$this->addColumn('pa_price1', array(
      				'header' => Mage::helper('sales')->__('Balance'),
      				'index' => 'balance',
      				'type'  => 'price',
      				'width' => '70px',
      				//'index_paid' => 'base_total_paid',
      				//'filter_index' => new Zend_Db_Expr('base_grand_total - ifnull(base_total_paid, 0)'),
      				//'renderer' => 'egovsbase/adminhtml_widget_grid_column_renderer_balance',
      				'type' => 'currency',
      				'currency' => 'base_currency_code',
      				//'filter_condition_callback' => array($this, '_filterBalanceCondition'),
      		));
      	}
      	else{
		  	$this->addColumn('pa_price1', array(
		  			'header' => Mage::helper('sales')->__('Balance'),
		  			'index' => 'base_grand_total',
		  			'type'  => 'price',
		  			'width' => '70px',
		  			'index_paid' => 'base_total_paid',
		  			'filter_index' => new Zend_Db_Expr('base_grand_total - ifnull(base_total_paid, 0)'),
		  			'renderer' => 'egovsbase/adminhtml_widget_grid_column_renderer_balance',
		  			'type' => 'currency',
		  			'currency' => 'base_currency_code',
		  			//'filter_condition_callback' => array($this, '_filterBalanceCondition'),
		  	));
      	}
  	
  	$groups = Mage::getResourceModel('customer/group_collection')
  	->addFieldToFilter('customer_group_id', array('gt'=> 0))
  	->load()
  	->toOptionHash();
  	
  	$this->addColumn('group', array(
  			'header'    =>  Mage::helper('customer')->__('Customergroup'),
  			'width'     =>  '100',
  			'index'     =>  'group_id',
  			'type'      =>  'options',
  			'options'   =>  $groups,
  	));
  	
  	
  	
  	$this->addColumn('pa_academic_titel', array(
  			'header'    => Mage::helper('eventmanager')->__('Academic Title'),
  			'width'     => '100px',
  			'index'     => 'academic_titel',
  			//'type'      => 'number',
  	));
  	
  	$this->addColumn('pa_position', array(
  			'header'    => Mage::helper('eventmanager')->__('Occupation'),
  			'width'     => '100px',
  			'index'     => 'position',
  			//'type'      => 'number',
  	));
  	
  	$this->addColumn('pa_vip', array(
  			'header' => Mage::helper('sales')->__('VIP'),
  			'index' => 'vip',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' => $yesno,
  	));
  	
//   	$this->addColumn('pa_name', array(
//   			'header'    => Mage::helper('eventmanager')->__('Name'),
//   			'align'     =>'left',
//   			'index'     => 'name',
//   			'filter_condition_callback' => array($this, '_filterNameCondition'),
//   	));
  	
  	$this->addColumn('pa_first', array(
  			'header'    => Mage::helper('eventmanager')->__('Firstname'),
  			'align'     =>'left',
  			'index'     => 'firstname',
  			//'filter_condition_callback' => array($this, '_filterNameCondition'),
  	));
  	
  	
  	$this->addColumn('pa_lastname', array(
  			'header'    => Mage::helper('eventmanager')->__('Lastname'),
  			'align'     =>'left',
  			'index'     => 'lastname',
  			//'filter_condition_callback' => array($this, '_filterNameCondition'),
  	));
  	
  	$this->addColumn('pa_company', array(
  			'header'    => Mage::helper('eventmanager')->__('Company'),
  			'align'     =>'left',
  			'index'     => 'company',
  			'filter_condition_callback' => array($this, '_filterCompanyCondition'),
  	));
  	
  	
  	$this->addColumn('pa_prefix', array(
  			'header'    => Mage::helper('eventmanager')->__('Prefix'),
  			'align'     =>'left',
  			'index'     => 'prefix',
  			//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
  	));
  	
  	$this->addColumn('pa_email', array(
  			'header'    => Mage::helper('eventmanager')->__('Email'),
  			'align'     =>'left',
  			'index'     => 'email',
  			'filter_index'     => 'main_table.email',
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
  	
  	$this->addColumn('pa_city', array(
  			'header'    => Mage::helper('eventmanager')->__('City'),
  			'align'     =>'left',
  			'index'     => 'city',
  			//'filter_condition_callback' => array($this, '_filterCompanyCondition'),
  	));
  	
  	$this->addColumn('pa_postcode', array(
  			'header'    => Mage::helper('eventmanager')->__('Zip'),
  			'align'     =>'left',
  			'index'     => 'postcode',
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
  	
  	
  
  	
  	
  	$this->addColumn('online_eval', array(
  			'header'    => Mage::helper('eventmanager')->__('Online Evaluation'),
  			'align'     => 'left',
  			'width'     => '80px',
  			'index'     => 'online_eval',
  			'type'      => 'options',
  			'options'   => $yesno,
  	));
  	
  	$this->addColumn('internal', array(
  			'header'    => Mage::helper('eventmanager')->__('Internal'),
  			'align'     => 'left',
  			'width'     => '80px',
  			'index'     => 'internal',
  			'type'      => 'options',
  			'options'   => $yesno,
  	));
  	
  	$this->addColumn('status', array(
  			'header'    => Mage::helper('eventmanager')->__('Participation Status'),
  			'align'     => 'left',
  			'width'     => '80px',
  			'index'     => 'status',
  			'type'      => 'options',
  			'options'   => Bfr_EventManager_Model_Status::getOptionArray(),
  	));
  	 
  	$this->addColumn('pa_note', array(
  			'header'    => Mage::helper('eventmanager')->__('Note'),
  			'align'     =>'left',
  			'index'     => 'note',
  	
  	));
      

      $columns = array();
      $i = 0;
      foreach($this->getOptions() as $option)
      {
      	foreach($this->getSelections($option) as $col)
		{
            $i++;
            $colname = 'col_'.$i.'_'.$col->getId();
			$columns[] = 'op_col_'.$col->getId();
			$this->addColumn('op_col_'.$i.'_'.$col->getId(), array(
					'header'    => $col->getName(),
					'align'     =>'left',
					'index'     => $colname,
					'total'		=> 'sum',
					'type'      => 'number',
					//'total_label'=> 'xxx',
                    'filter_index'     => $colname.".qty_ordered",
					'width'     => '100px',
					'filter_condition_callback' => array($this, '_filterDynamicCondition'),
			));
		}
      }
		
      
      
      foreach($this->getDynamicColumns() as $col)
      {
      	/* @var $col Mage_Catalog_Model_Product_Option*/
      	$values = $col->getValues();
      	if(count($values) > 0){
      		$options = array();
      		foreach($values as $value)
      		{
      			//$options[] = array('label'=>$value->getDefaultTitle(),'value'=>$value->getOptionId());
      			$options[$value->getOptionTypeId()] =$value->getDefaultTitle();
      		}
      		$this->addColumn('co_customeroption_'.$col->getOptionId(), array(
      				'header'    => $col->getDefaultTitle(),
      				'align'     =>'left',
      				'index'     => 'customeroption_'.$col->getOptionId(),
      				'width'     => '100px',
      				'type'		=> 'options',
      				'options'	=> $options,
      				'filter'	=> false
      				//'filter_condition_callback' => array($this, '_filterNameCondition'),
      		));
      			
      	}else{
      		$this->addColumn('co_customeroption_'.$col->getOptionId(), array(
      				'header'    => $col->getDefaultTitle(),
      				'align'     =>'left',
      				'index'     => 'customeroption_'.$col->getOptionId(),
      				'width'     => '100px',
      				'filter'	=> false
      				//'filter_condition_callback' => array($this, '_filterNameCondition'),
      		));
      	}
      }
      
		
		$this->addExportType('*/*/exportAllCsv', Mage::helper('eventmanager')->__('CSV'),array('id'=>$this->getEvent()->getId()));
		$this->addExportType('*/*/exportAllXml', Mage::helper('eventmanager')->__('XML'),array('id'=>$this->getEvent()->getId()));

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
  	return $this->getUrl('*/*/exportgrid', array('id'=>$this->getEvent()->getId()));
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
