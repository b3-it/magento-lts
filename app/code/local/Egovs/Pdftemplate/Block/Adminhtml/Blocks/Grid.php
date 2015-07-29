<?php

/**
 * 
 *  Grid für alle pdf Template-Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Blocks_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('blocksGrid');
      $this->setDefaultSort('blocks_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('pdftemplate/blocks')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('pdftemplate_blocks_id', array(
          'header'    => Mage::helper('pdftemplate')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'pdftemplate_blocks_id',
      ));

     
      $this->addColumn('ident', array(
          'header'    => Mage::helper('pdftemplate')->__('Identifier'),
          'align'     =>'left',
      	  'width'     => '200px',
          'index'     => 'ident',
      ));
            
      $this->addColumn('title', array(
          'header'    => Mage::helper('pdftemplate')->__('Title'),
          'align'     =>'left',
      	  //'width'     => '100px',
          'index'     => 'title',
      ));
      

 
/*
     $groups = Mage::getModel('customer/group')->getCollection()->toOptionHash();
     $groups['-1'] = Mage::helper('paymentbase')->__('All Customer Groups');
     $this->addColumn('customer_group_id', array(
          'header'    => Mage::helper('paymentbase')->__('Customer Group'),
          //'align'     =>'right',
          'width'     => '100px',
          'index'     => 'customer_group_id',
     	  'type'      => 'options',
          'options'   => $groups
      ));
*/ 
      
      if(Mage::helper('pdftemplate')->isModuleEnabled('Egovs_Paymentbase'))
      {
	      $phash = Mage::helper('paymentbase')->getActivePaymentMethods();
	      $phash['all'] = Mage::helper('paymentbase')->__('All Payment Methods');
	      
	      
	      $this->addColumn('payment', array(
	          'header'    => Mage::helper('paymentbase')->__('Payment Method'),
	          //'align'     =>'right',
	          'width'     => '200px',
	          'index'     => 'payment',
	      	  'type'      => 'options',
	          'options'   => $phash
	      ));
      }
      
      $shipping = Mage::getModel('adminhtml/system_config_source_shipping_allowedmethods')->toOptionArray();
     
      $phash = array();
      $phash['all'] = Mage::helper('pdftemplate')->__('All Shipping Methods');
      //Leerer Eintrag wird von Magento erzeugt
      foreach ($shipping as $option) {
      	if (empty($option['label'])) {
      		continue;
      	}
      	
      	foreach ($option['value'] as $method)
      	{ 
      		$phash[$method['value']] = $method['label'];
      	}
      	
      	
      }
     
      
      $this->addColumn('shipping', array(
          'header'    => Mage::helper('pdftemplate')->__('Shipping Method'),
          //'align'     =>'right',
          'width'     => '200px',
          'index'     => 'shipping',
      	  'type'      => 'options',
          'options'   => $phash
      ));
      
      

      $tax = Mage::getModel('pdftemplate/system_config_source_taxRules');
      $taxhash['all'] = Mage::helper('pdftemplate')->__('All Tax Rules');
      foreach($tax->toOptionHashArray() as $k =>$v)
      {
      	$taxhash[$k]= $v;
      }
      //array_unshift($phash, 'all',Mage::helper('pdftemplate')->__('All Tax Rules'));
      //$phash['all'] = Mage::helper('pdftemplate')->__('All Tax Rules');
      $this->addColumn('tax_rules', array(
      		'header'    => Mage::helper('pdftemplate')->__('Tax Rules'),
      		//'align'     =>'right',
      		'width'     => '200px',
      		'index'     => 'tax_rule',
      		'type'      => 'options',
      		'options'   => $taxhash
      ));
      
      
      $this->addColumn('status', array(
          'header'    => Mage::helper('pdftemplate')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => Mage::helper('pdftemplate')->__('Enabled'),
              2 => Mage::helper('pdftemplate')->__('Disabled'),
          ),
      ));
      

      $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('pdftemplate')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('pdftemplate')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('pdftemplate')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('pdftemplate')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('blocks_id');
        $this->getMassactionBlock()->setFormFieldName('blocks');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('pdftemplate')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('pdftemplate')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('pdftemplate/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('pdftemplate')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('pdftemplate')->__('Status'),
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

}