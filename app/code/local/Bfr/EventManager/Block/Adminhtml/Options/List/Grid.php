<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Options_List_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    protected $_event = null;

  public function __construct()
  {
      parent::__construct();
      $this->setId('eventoptionsGrid');
      $this->setDefaultSort('event_options_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }


    /**
     * @return Bfr_EventManager_Model_Event
     */
  protected function getEvent()
  {
      if($this->_event == null)
      {
          $this->_event = Mage::registry('event_data');
      }
      return $this->_event;
  }

  protected function _prepareCollection()
  {
      /** @var Bfr_EventManager_Model_Event $event */
      $event = $this->getEvent();
      $productId = $event->getProductId();
      $collection = Mage::getModel('sales/quote')->getCollection();
//      $collection->setStoreId(0);
      $collection->getSelect()
      	->join(array('quote_item'=>$collection->getTable('sales/quote_item')),'main_table.entity_id = quote_item.quote_id')
        ->where('quote_item.product_id = ? ', $productId);
      ;

      $options = $this->getEvent()->getProduct()->getOptions();
      foreach($options as $option)
      {
          $alias = 'option_'.$option->getId();
          $collection->getSelect()
              ->join(array($alias=>$collection->getTable('sales/quote_item_option')),$alias.".item_id = quote_item.item_id AND ".$alias.".code='".$alias."'",array($alias=>'value'));
      }



      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sku', array(
      		'header'    => Mage::helper('eventmanager')->__('Sku'),
      		'align'     =>'left',
      		'index'     => 'sku',
      		'width'     => '150px',
      ));
      

    $options = $this->getEvent()->getProduct()->getOptions();
    foreach($options as $option)
    {
        $alias = 'option_'.$option->getId();
        $this->addColumn($alias, array(
            'header'    => $option->getTitle(),
            //'align'     =>'left',
            'index'     => $alias,
            //'width'     => '150px',
        ));
    }


      return parent::_prepareColumns();
  }





  
 
  
  
}
