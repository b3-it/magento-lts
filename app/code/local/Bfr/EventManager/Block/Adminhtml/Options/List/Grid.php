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
      $this->setId('event_optionsGrid');
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
      $eav = Mage::getResourceModel('eav/entity_attribute');
      /** @var Bfr_EventManager_Model_Event $event */
      $event = $this->getEvent();
      $productId = $event->getProductId();
      $collection = Mage::getResourceModel('eventmanager/sales_quote_item_collection');
      $quote = new Varien_Object();

      $collection->getSelect()
      	->join(array('quote'=>$collection->getTable('sales/quote')),'main_table.quote_id = quote.entity_id',array('entity_id'=>'entity_id'))
        ->joinleft(array('customer'=>$collection->getTable('customer/entity')),'quote.customer_id = customer.entity_id',array('email'))
        ->joinleft(array('adr'=>$collection->getTable('customer/entity').'_int'),'quote.customer_id = adr.entity_id AND adr.attribute_id='. $eav->getIdByCode('customer', 'default_billing'),array())
        ->joinleft(array('first'=>$collection->getTable('customer/address_entity').'_varchar'), 'first.entity_id = adr.value AND first.attribute_id = '. $eav->getIdByCode('customer_address', 'firstname') ,array('firstname'=>'value'))
        ->joinleft(array('last'=>$collection->getTable('customer/address_entity').'_varchar'), 'last.entity_id = adr.value AND last.attribute_id = '. $eav->getIdByCode('customer_address', 'lastname') ,array('lastname'=>'value'))
        ->joinleft(array('company'=>$collection->getTable('customer/address_entity').'_varchar'), 'company.entity_id = adr.entity_id AND company.attribute_id = '. $eav->getIdByCode('customer_address', 'company') ,array('company'=>'value'))

          ->where('main_table.product_id = ? ', $productId);
      ;



//     die($collection->getSelect()->__toString());


      $collection->getSelect()
          ->joinleft(array('order' => $collection->getTable('sales/order')), "quote.entity_id = order.quote_id", array('order_status'=>'status'));

      $statusExpr = new Zend_Db_Expr('(order.status IS NOT NULL)');

      if(Mage::helper('eventmanager')->isModuleEnabled('Bfr_EventRequest')) {
          $collection->getSelect()
              ->joinleft(array('evt' => $collection->getTable('eventrequest/request')), "quote.entity_id = evt.quote_id", array('request_status'=>'status'));
            $statusExpr = new Zend_Db_Expr('((order.status IS NOT NULL) OR (evt.status IS NOT NULL))');
      }

     // $collection->getSelect()->where($statusExpr);





      $options = $this->getEvent()->getProduct()->getOptions();
      foreach($options as $option)
      {
          $alias = 'option_'.$option->getId();
          $collection->getSelect()
              ->joinleft(array($alias=>$collection->getTable('sales/quote_item_option')),$alias.".item_id = main_table.item_id AND ".$alias.".code='".$alias."'",array($alias=>'value'));
      }


//die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function  _afterLoadCollection()
  {
//      die($this->getCollection()->getSelect()->__toString());
      $product = $this->getEvent()->getProduct();
      $options = $product->getOptions();

      foreach($options as $option)
      {
          $alias = 'option_'.$option->getId();
          /** @var $option Mage_Catalog_Model_Product_Option */
          //if(in_array($option->getId(),$optionsIds))
          foreach($this->getCollection()->getItems() as $item)
          {
              if($option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX || $option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE){
                  $opt = $option->getValuesCollection()->getItems();
                  $value = explode(',',$item->getData($alias));
                  foreach($value as $key=> $val)
                  {
                      if(isset($opt[$val])) {
                          $value[$key] = $opt[$val]->getTitle();
                      }
                  }
                  $item->setData($alias,implode(',',$value));
              }
          }

      }
  }

  protected function _prepareColumns()
  {
      $this->addColumn('sku', array(
      'header'    => Mage::helper('eventmanager')->__('Sku'),
      'align'     =>'left',
      'index'     => 'sku',
      //'width'     => '150px',
        ));

      $this->addColumn('firstname', array(
          'header'    => Mage::helper('eventmanager')->__('Firstname'),
          'align'     =>'left',
          'index'     => 'firstname',
          //'width'     => '150px',
      ));

      $this->addColumn('lastname', array(
          'header'    => Mage::helper('eventmanager')->__('Lastname'),
          'align'     =>'left',
          'index'     => 'lastname',
         // 'width'     => '150px',
      ));

      $this->addColumn('company', array(
          'header'    => Mage::helper('eventmanager')->__('Company'),
          'align'     =>'left',
          'index'     => 'company',
          //'width'     => '150px',
      ));

      $this->addColumn('email', array(
          'header'    => Mage::helper('eventmanager')->__('E-Mail'),
          'align'     =>'left',
          'index'     => 'email',
          'width'     => '150px',
      ));

      if(Mage::helper('eventmanager')->isModuleEnabled('Bfr_EventRequest')) {

          $this->addColumn('status', array(
              'header' => Mage::helper('eventmanager')->__('Status'),
              'align' => 'left',
              'width' => '80px',
              'index' => 'request_status',
              'filter_index' =>'evt.status',
              'type' => 'options',
              'options' => Bfr_EventRequest_Model_Status::getOptionArray(),
          ));
      }

      $this->addColumn('order_status', array(
          'header' => Mage::helper('eventmanager')->__('Order Status'),
          'align' => 'left',
          'width' => '80px',
          'index' => 'order_status',
          'type' => 'options',
          'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
      ));

      

    $options = $this->getEvent()->getProduct()->getOptions();
    foreach($options as $option)
    {
        $alias = 'option_' . $option->getId();
        if($option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO || $option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN ) {

            $opt = $option->getValuesCollection()->getItems();
            $tmp = array();
            foreach ($opt as $k=>$o)
            {
                $tmp[$k] = $o->getTitle();
            }

            $this->addColumn($alias, array(
                'header' => $option->getTitle(),
                //'align'     =>'left',
                'index' => $alias,
                'type'  => 'options',
                'filter_index' => $alias.'.value',
                'options' => $tmp,
                //'width'     => '150px',
            ));
        }else{
            $this->addColumn($alias, array(
                'header' => $option->getTitle(),
                //'align'     =>'left',
                'index' => $alias,
                'filter_index' => $alias.".value",
                //'width'     => '150px',
            ));
        }
    }

      $this->addExportType('*/*/exportCsv', Mage::helper('eventmanager')->__('CSV'));
      $this->addExportType('*/*/exportXml', Mage::helper('eventmanager')->__('XML'));
      return parent::_prepareColumns();
  }





  
 
  
  
}