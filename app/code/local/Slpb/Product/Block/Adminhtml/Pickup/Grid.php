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
 * Adminhtml sales orders grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Product_Block_Adminhtml_Pickup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_pickup_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        //$this->setFilterVisibility(false);
    }

    protected function _prepareCollection()
    {
    	
        //TODO: add full name logic
        $collection = Mage::getResourceModel('slpbproduct/order_collection')
		->addAttributesAndFilter(true,'storepickup_storepickup');    
                
        $this->setCollection($collection);
        //die($collection->getSelect()->__toString());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased from (store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
            ));
        }

        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
        ));

 
        $this->addColumn('shipping_name', array(
            'header' => Mage::helper('sales')->__('Ship to Name'),
            'index' => 'shipping_name',
        	'filter_index' => "CONCAT(COALESCE(shipping.firstname, ''), ' ', COALESCE(shipping.lastname, ''), ' ', COALESCE(shipping.company, ''), ' ', COALESCE(shipping.company2, ''))"
       
        ));

        $store = $this->_getStore();
        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('Price'),
        	'type' => 'price',
        	'currency_code' => $store->getBaseCurrency()->getCode(),
            'index' => 'grand_total',
        ));
        
 
        $this->addColumn('missing_items', array(
            'header' => Mage::helper('sales')->__('Missing Items'),
            'index' => 'missing_items',
        	'filter'    => false,
        	'sortable' => false,
        ));
        
        $this->addColumn('action', array(
            'header'   => Mage::helper('extstock')->__('Action'),
            'filter'   => false,
            'sortable' => false,
            'width'    => '100',
            'renderer' => 'slpbproduct/pickup_renderer_deliver'
        ));
        
        
     	if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $this->addColumn('action_view',
                array(
                    'header'    => Mage::helper('sales')->__('Action'),
                    'width'     => '50px',
                    'type'      => 'action',
                    'getter'     => 'getId',
                    'actions'   => array(
                        array(
                            'caption' => Mage::helper('sales')->__('View'),
                            'url'     => array('base'=>'/*/../sales_order/view'),
                            'field'   => 'order_id',
                        	'popup' => true,
                        )
                    ),
                    'filter'    => false,
                    'sortable'  => false,
                    'index'     => 'stores',
                    'is_system' => true,
            ));
        }
        
        
        
        //$this->addRssList('rss/order/new', Mage::helper('sales')->__('New Order RSS'));

        return parent::_prepareColumns();
    }


    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    
    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
    
   public function getRowUrl($row)
    {
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('', array('order_id' => $row->getId(),'_direct'=>'admin/sales_order/view/order_id/'.$row->getId()));
        }
        return false;
    }

}
