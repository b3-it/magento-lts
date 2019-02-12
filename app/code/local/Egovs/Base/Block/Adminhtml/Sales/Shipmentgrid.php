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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2017 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales orders grid
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Base_Block_Adminhtml_Sales_Shipmentgrid extends Mage_Adminhtml_Block_Sales_Shipment_Grid
{

    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        
        $collection = $this->getCollection();
        //add full name logic
        $collection->join(array('order'=>'sales/order'),'order_id = order.entity_id',array('order_increment_id'=>'increment_id','order_created_at'=>'created_at','shipping_address_id'=>'shipping_address_id'))
            ->join(array('adr'=>'sales/order_address'),'order.shipping_address_id = adr.entity_id',array('firstname','lastname','company','company2','company3','street', 'city','postcode'))
            ->addExpressionFieldToSelect('shipping_name',
                'CONCAT(COALESCE(firstname, ""), " ", COALESCE(lastname, ""))',
                array('firstname', 'lastname'))
            ->addExpressionFieldToSelect('shipping_company',
                'CONCAT(COALESCE(company, ""), " ", COALESCE(company2, ""), " ", COALESCE(company3, ""))',
                array('company', 'company2','company3'))
            ->addExpressionFieldToSelect('shipping_address',
                'CONCAT(COALESCE(street, ""), " ", COALESCE(city, ""), " ",COALESCE(postcode, ""))',
                array('street', 'city','postcode'))
        ;
        
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('increment_id', array(
            'header'    => Mage::helper('sales')->__('Shipment #'),
            'index'     => 'increment_id',
            'type'      => 'number',
        	'filter_index' => 'main_table.increment_id',
        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('sales')->__('Date Shipped'),
            'index'     => 'created_at',
            'type'      => 'datetime',
        	'width'     => '150px',
        	'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));

        $this->addColumn('order_increment_id', array(
            'header'    => Mage::helper('sales')->__('Order #'),
            'index'     => 'order_increment_id',
            'type'      => 'number',
        	'filter_index' => 'order.increment_id'
        ));

        $this->addColumn('order_created_at', array(
            'header'    => Mage::helper('sales')->__('Order Date'),
            'index'     => 'order_created_at',
            'type'      => 'datetime',
        	'filter_condition_callback' => array($this, '_filterCreatedAtCondition'),
        ));

     
     $this->addColumn('shipping_company', array(
          'header'    => Mage::helper('egovsbase')->__('Shipping Company'),
          'align'     =>'left',
          'index'     => 'shipping_company',
     	  'filter_condition_callback' => array($this, '_filterShippingCompanyCondition'),
      ));

      
    $this->addColumn('shipping_name', array(
          'header'    => Mage::helper('egovsbase')->__('Shipping Name'),
          'align'     =>'left',
    	  'width'     => '150px',
          'index'     => 'shipping_name',
    	  'filter_condition_callback' => array($this, '_filterShippingNameCondition'),
      ));
      
       
      $this->addColumn('shipping_address', array(
          'header'    => Mage::helper('egovsbase')->__('Shipping Address'),
          'align'     =>'left',
     	  'width'     => '150px',
          'index'     => 'shipping_address',
      	  'filter_index' => 'CONCAT(COALESCE(street, ""), " ", COALESCE(city, "")," ", COALESCE(postcode, ""))'
      ));
        $this->addColumn('total_qty', array(
            'header' => Mage::helper('sales')->__('Total Qty'),
            'index' => 'total_qty',
            'type'  => 'number',
        ));

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('sales')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('sales')->__('View'),
                        'url'     => array('base'=>'*/sales_shipment/view'),
                        'field'   => 'shipment_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));
        
        return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
    }

    public function getRowUrl($row)
    {
    	if (!Mage::getSingleton('admin/session')->isAllowed('sales/order/shipment')) {
    		return false;
    	}
    	
        return $this->getUrl('*/*/view',
            array(
                'shipment_id'=> $row->getId(),
            )
        );
    }

    /**
     * Get url of grid
     *
     * @return string
     */
    protected function _filterShippingCompanyCondition($collection, $column) {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    
    	$condition = 'CONCAT(COALESCE(company, ""), " ", COALESCE(company2, "")," ", COALESCE(company3, "")) like ?';
    	$collection->getSelect()->where($condition, "%$value%");
    
    }
    	/**
    	 *
    	 * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
    	 * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
    	 *
    	 * @return void
    	*/
    	protected function _filterShippingNameCondition($collection, $column) {
    		if (!$value = $column->getFilter()->getValue()) {
    			return;
    		}
    
    		$condition = 'CONCAT(COALESCE(firstname, ""), " ", COALESCE(lastname, "")) like ?';
    		$collection->getSelect()->where($condition, "%$value%");
    	}
    
    	/**
    	 *
    	 * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
    	 * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
    	 *
    	 * @return void
    	 */
    	protected function _filterShippingAddressCondition($collection, $column) {
    		if (!$value = $column->getFilter()->getValue()) {
    			return;
    		}
    
    		$condition = 'CONCAT(COALESCE(street, ""), " ", COALESCE(city, "")," ", COALESCE(postcode, "")) like ?';
    		$collection->getSelect()->where($condition, "%$value%");
    	}
    
    	
    	/**
    	 *
    	 * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
    	 * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
    	 *
    	 * @return void
    	 */
    	protected function _filterCreatedAtCondition($collection, $column) {
    		if (!$value = $column->getFilter()->getValue()) {
    			return;
    		}
    		
    		$col = 'main_table.created_at';
    		if($column->getId() == 'order_created_at'){
    			$col = 'order.created_at';
    		}
    		
    		if(isset( $value['from']) && isset( $value['to'])){
    			$condition = sprintf("(($col >= '%s') && ($col <= '%s'))", $value['from']->ToString('yyyy-MM-dd'),  $value['to']->ToString('yyyy-MM-dd') );
    			$collection->getSelect()->where($condition);
    		}
    		else if(isset( $value['from'])){
    			$condition = sprintf("($col >= '%s')", $value['from']->ToString('yyyy-MM-dd'));
    			$collection->getSelect()->where($condition);
    		}
    		else if(isset( $value['to'])){
    			$condition = sprintf("($col <= '%s')", $value['to']->ToString('yyyy-MM-dd'));
    			$collection->getSelect()->where($condition);
    		}
    		 
    	}
    	
    public function getGridUrl()
    {
        return $this->getUrl('*/*/*', array('_current' => true));
    }

}