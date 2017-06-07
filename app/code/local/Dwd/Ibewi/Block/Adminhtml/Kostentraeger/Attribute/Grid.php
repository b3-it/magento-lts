<?php
 /**
  *
  * @category   	Dwd Ibewi
  * @package    	Dwd_Ibewi
  * @name       	Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('kostentraeger_attributeGrid');
      $this->setDefaultSort('kostentraeger_attribute_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('ibewi/kostentraeger_attribute')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('ibewi')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('ibewi')->__('Title'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'title',
      ));
      $this->addColumn('value', array(
          'header'    => Mage::helper('ibewi')->__('Value'),
          //'align'     =>'left',
          //'width'     => '150px',
          'index'     => 'value',
      ));
      
      $this->addColumn('pos', array(
      		'header'    => Mage::helper('ibewi')->__('Position'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'pos',
      ));
    

//       $statuses = Mage::getSingleton('ibewi/kostentraeger_yesno')->getOptionArray();
//       $this->addColumn('status', array(
//       		'header'    => Mage::helper('ibewi')->__('Standard'),
//       		'align'     => 'left',
//       		'width'     => '80px',
//       		'index'     => 'standard',
//       		'filter_index' => 'main_table.standard',
//       		'type'      => 'options',
//       		'options'   => $statuses
      
//       ));
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('ibewi')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('ibewi')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));


      return parent::_prepareColumns();
  }

   

	public function getGridUrl($params = array())
    {
    	if (!isset($params['_current'])) {
    		$params['_current'] = true;
    	}
    	return $this->getUrl('*/*/*', $params);

    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
