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
      $eav = Mage::getResourceModel('eav/entity_attribute');
      /** @var Bfr_EventManager_Model_Event $event */
      $event = $this->getEvent();
      $productId = $event->getProductId();
      $collection = Mage::getModel('sales/quote')->getCollection();
//      $collection->setStoreId(0);
      $collection->getSelect()
      	->join(array('quote_item'=>$collection->getTable('sales/quote_item')),'main_table.entity_id = quote_item.quote_id',array('sku','entity_id'=>'item_id'))
        ->joinleft(array('customer'=>$collection->getTable('customer/entity')),'main_table.customer_id = customer.entity_id',array('email'))
        ->joinleft(array('adr'=>$collection->getTable('customer/entity').'_int'),'main_table.customer_id = adr.entity_id AND adr.attribute_id='. $eav->getIdByCode('customer', 'default_billing'),array())
        ->joinleft(array('first'=>$collection->getTable('customer/address_entity').'_varchar'), 'first.entity_id = adr.value AND first.attribute_id = '. $eav->getIdByCode('customer_address', 'firstname') ,array('firstname'=>'value'))
        ->joinleft(array('last'=>$collection->getTable('customer/address_entity').'_varchar'), 'last.entity_id = adr.value AND last.attribute_id = '. $eav->getIdByCode('customer_address', 'lastname') ,array('lastname'=>'value'))
        ->joinleft(array('company'=>$collection->getTable('customer/address_entity').'_varchar'), 'company.entity_id = adr.entity_id AND company.attribute_id = '. $eav->getIdByCode('customer_address', 'company') ,array('company'=>'value'))

          ->where('quote_item.product_id = ? ', $productId);
      ;



     //die($collection->getSelect()->__toString());

      if(Mage::helper('eventmanager')->isModuleEnabled('Bfr_EventRequest')) {
          $collection->getSelect()
              ->joinleft(array('evt' => $collection->getTable('eventrequest/request')), "main_table.entity_id = evt.quote_id", array('status'));

      }
      $options = $this->getEvent()->getProduct()->getOptions();
      foreach($options as $option)
      {
          $alias = 'option_'.$option->getId();
          $collection->getSelect()
              ->join(array($alias=>$collection->getTable('sales/quote_item_option')),$alias.".item_id = quote_item.item_id AND ".$alias.".code='".$alias."'",array($alias=>'value'));
      }


//die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function  _afterLoadCollection()
  {
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
                      $value[$key] = $opt[$val]->getTitle();
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
              'index' => 'status',
              'type' => 'options',
              'options' => Bfr_EventRequest_Model_Status::getOptionArray(),
          ));
      }


      

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
                'options' => $tmp,
                //'width'     => '150px',
            ));
        }else{
            $this->addColumn($alias, array(
                'header' => $option->getTitle(),
                //'align'     =>'left',
                'index' => $alias,
                'filter.index' => $alias.".value",
                //'width'     => '150px',
            ));
        }
    }

      $this->addExportType('*/*/exportCsv', Mage::helper('eventmanager')->__('CSV'));
      $this->addExportType('*/*/exportXml', Mage::helper('eventmanager')->__('XML'));
      return parent::_prepareColumns();
  }





  
 
  
  
}
