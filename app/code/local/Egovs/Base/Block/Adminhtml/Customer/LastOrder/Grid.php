<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 * @author     Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Base_Block_Adminhtml_Customer_LastOrder_Grid extends Mage_Adminhtml_Block_Widget_Grid
{



    public function __construct()
    {
        parent::__construct();
        $this->setId('lastOrderGrid');
//        $this->setDefaultSort('entity_id');
//        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }


    protected function _prepareCollection()
    {
        $collection = Mage::getModel('egovsbase/customer_lastOrder')->getCollection();
        $this->setCollection($collection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }





    
    protected function  _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('customer')->__('ID'),
            'width'     => '50px',
            'index'     => 'entity_id',
           // 'filter_index' => 't1.entity_id',
            'type'  => 'number',

        ));
        $this->addColumn('firstname', array(
            'header'    => Mage::helper('customer')->__('First Name'),
            'index'     => 'firstname'
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('customer')->__('Last Name'),
            'index'     => 'lastname',
            'filter_condition_callback' => array($this, '_filterCustomerCondition')
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();

        $this->addColumn('group', array(
            'header'    =>  Mage::helper('customer')->__('Group'),
            'width'     =>  '100',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
        ));

        
        $this->addColumn('base_company', array(
            'header'    => Mage::helper('customer')->__('Company'),
        	'width'     => '100',
            'index'     => 'company'
        ));
        
        $this->addColumn('email', array(
            'header'    => Mage::helper('customer')->__('Email'),
            'width'     => '150',
            'index'     => 'email',
            'filter_index'     => 't1.email'
        ));

//        $groups = Mage::getResourceModel('customer/group_collection')
//            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
//            ->load()
//            ->toOptionHash();
//
//        $this->addColumn('group', array(
//            'header'    =>  Mage::helper('customer')->__('Group'),
//            'width'     =>  '100',
//            'index'     =>  'group_id',
//            'type'      =>  'options',
//            'options'   =>  $groups,
//        ));



        $this->addColumn('customer_since', array(
            'header'    => Mage::helper('customer')->__('Customer Since'),
            'type'      => 'datetime',
        	'width'     => '100',
            'align'     => 'center',
            'index'     => 'created_at',
            'gmtoffset' => true
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('website_id', array(
                'header'    => Mage::helper('customer')->__('Website'),
                'align'     => 'center',
                'width'     => '80px',
                'type'      => 'options',
                'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(true),
                'index'     => 'website_id',
            ));
        }


        $this->addColumn('last_order', array(
            'header'    => Mage::helper('customer')->__('Last Order'),
            'type'      => 'datetime',
            'width'     => '100',
            'align'     => 'center',
            'index'     => 'last_order',
            'gmtoffset' => true,
            'filter_index' => 'last_order',
            'filter_condition_callback' => array($this, '_filterLastOrderCondition'),
        ));

        $this->addColumn('order_count', array(
            'header'    => Mage::helper('customer')->__('Count'),
            'width'     => '50px',
            'index'     => 'order_count',
            'filter_index' => 't1.order_count',
            'type'  => 'number',
            'filter_condition_callback' => array($this, '_filterOrderCountCondition')
        ));



//        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
//        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('XML'));
        return $this;//parent::_prepareColumns();
    }
    


    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('customer');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customer')->__('Are you sure?')
        ));



        
        return $this;
    }


    protected function _afterLoadCollection() {
        //die($this->getCollection()->getSelect()->__toString());
        return parent::_afterLoadCollection(); // TODO: Change the autogenerated stub
    }


    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=> true));
    }




    /**
     * Filterkondition für Datumsfeld der Bestellung
     * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
     *
     * @return void
     */
    protected function _filterLastOrderCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $col = null;


        $col = 'DATE('.$column->getFilterIndex().')';
        if ($col == null) return $this;

        if(isset( $value['from']) && isset( $value['to'])){
            $condition = sprintf("( ($col >= '%s') && ($col <= '%s'))", $value['from']->ToString('yyyy-MM-dd'),  $value['to']->ToString('yyyy-MM-dd') );
            $collection->getSelect()->where($condition);
        }
        else if(isset( $value['from'])){
            $condition = sprintf("(($col >= '%s'))", $value['from']->ToString('yyyy-MM-dd'));
            $collection->getSelect()->where($condition);
        }
        else if(isset( $value['to'])){
            $condition = sprintf("( ($col <= '%s') OR ($col is NULL)) ", $value['to']->ToString('yyyy-MM-dd') );
            $collection->getSelect()->where($condition);
        }

        //die($collection->getSelect()->__toString());
    }

    protected function _filterCustomerCondition($collection, $column)
    {

        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $field = ( $column->getFilterIndex() ) ? $column->getFilterIndex() : $column->getIndex();


        $collection->getSelect()->where($field ." like  ?",'%'.$value.'%');

        //die($collection->getSelect()->__toString());
    }

    protected function _filterOrderCountCondition($collection, $column)
    {

        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $col = null;


        $col = $column->getFilterIndex();
        if ($col == null) return $this;

        if(isset( $value['from']) && isset( $value['to'])){
            $condition = sprintf("( ($col >= '%s') && ($col <= '%s'))", $value['from'],  $value['to'] );
            $collection->getSelect()->where($condition);
        }
        else if(isset( $value['from'])){
            $condition = sprintf("(($col >= '%s'))", $value['from']);
            $collection->getSelect()->where($condition);
        }
        else if(isset( $value['to'])){
            $condition = sprintf("( ($col <= '%s') OR ($col is NULL) )", $value['to'] );
            $collection->getSelect()->where($condition);
        }

        //die($collection->getSelect()->__toString());
    }

}
