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
 * Adminhtml sales order create block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_Abo_Block_Adminhtml_Contract_Create_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
   
        parent::__construct();
        $this->setId('abo_contract_create_product_grid');
        //$this->setRowClickCallback('order.selectCustomer.bind(order)');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
    }

 
   protected function _prepareCollection()
    {

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('type_id')
			->addAttributeToSelect('price')
			->addAttributeToFilter('is_abo_base_product','1');

//die($collection->getSelect()->__toString());
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }
    	


    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
            'header'    =>Mage::helper('sales')->__('ID'),
            'width'     =>'50px',
            'index'     =>'entity_id',
            'align'     => 'right',
        ));
        $this->addColumn('name', array(
            'header'    =>Mage::helper('sales')->__('Name'),
            'index'     =>'name'
        ));
        
        $this->addColumn('sku', array(
            'header'    =>Mage::helper('sales')->__('sku'),
        	'width'     =>'150px',
            'index'     =>'sku'
        ));
  

         $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('catalog')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
            	'renderer' => 'adminhtml/stalaabo_contract_create_product_renderer_useit',
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        

        return parent::_prepareColumns();
    }

 
    public function getGridUrl()
    {
    	 return $this->getUrl('*/*/productgrid');
    }

}
