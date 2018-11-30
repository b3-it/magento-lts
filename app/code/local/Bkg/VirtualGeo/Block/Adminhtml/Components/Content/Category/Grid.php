<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Content_Categoryentity_Grid
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Content_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('components_content_category_Grid');
      $this->setDefaultSort('pos');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('virtualgeo/components_content_category')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('id', array(
          'header'    => Mage::helper('virtualgeo')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'id',
      ));

      $this->addColumn('pos', array(
          'header'    => Mage::helper('virtualgeo')->__('Position'),
          'align'     =>'left',
          'width'     => '100px',
          'index'     => 'pos',
      ));
      
      $this->addColumn('label', array(
      		'header'    => Mage::helper('virtualgeo')->__('Label'),
      		//'align'     =>'left',
      		//'width'     => '150px',
      		'index'     => 'label',
      ));
      
 

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('virtualgeo')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('virtualgeo')->__('Edit'),
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
