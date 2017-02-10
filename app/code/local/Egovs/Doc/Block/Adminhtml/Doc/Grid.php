<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Block_Adminhtml_Doc_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('docGrid');
      $this->setDefaultSort('doc_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('egovs_doc/doc')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('doc_id', array(
          'header'    => Mage::helper('egovs_doc')->__('ID'),
          'align'     =>'right',
          'width'     => '20px',
          'index'     => 'doc_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('egovs_doc')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      		'width'     => '250px',
      ));

	  
      $this->addColumn('description', array(
			'header'    => Mage::helper('egovs_doc')->__('Description'),

			'index'     => 'description',
      ));
      
      
      $this->addColumn('content', array(
      		'header'    => Mage::helper('egovs_doc')->__('content'),
      		'renderer' => "egovsbase/adminhtml_widget_grid_column_renderer_shortString",
      		'length' =>	'120',
      		'index'     => 'content',
      ));
      
      
      $this->addColumn('category', array(
      		'header'    => Mage::helper('egovs_doc')->__('Category'),
      		'align'     => 'left',
      		'width'     => '100px',
      		'index'     => 'category',
      		'type'      => 'options',
      		'options'   => Egovs_Doc_Model_Category::getOptionArray()
      ));
       
      
      $this->addColumn('filename', array(
      		'header'    => Mage::helper('egovs_doc')->__('Filename'), 
      		'width'     => '250px',
      		'index'     => 'filename',
      ));
      
      $this->addColumn('editor', array(
      		'header'    => Mage::helper('egovs_doc')->__('Editor'),
      		'width'     => '150px',
      		'index'     => 'editor',
      ));
      
    
      
      
      
    $this->addColumn('update_time', array(
				'header'    => Mage::helper('egovs_doc')->__('Date'),
				'align'     =>'left',
				'index'     => 'update_time',
				'width'     => '150px',
				'type' => 'datetime'
		));
   
      
    $acl = Mage::getSingleton('acl/productacl');
    $canEdit = $acl->testPermission('admin/egovs_doc/egovs_doc_edit');
   

    if($canEdit)
    {
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('egovs_doc')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('egovs_doc')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
    }
        $this->addColumn('action1',
        		array(
        				'header'    =>  Mage::helper('egovs_doc')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('egovs_doc')->__('View'),
        								'url'       => array('base'=> '*/*/download'),
        								'field'     => 'id',
        								'target' 	=> '_blank'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('egovs_doc')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('egovs_doc')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}