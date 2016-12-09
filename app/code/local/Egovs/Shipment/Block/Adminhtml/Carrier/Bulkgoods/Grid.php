<?php
/**
 * 
 *  Export der  Sperrgut tabelle 
 *  @category Egovs
 *  @package  Egovs_Shipment
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Shipment_Block_Adminhtml_Carrier_Bulkgoods_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Website filter
     *
     * @var int
     */
    protected $_websiteId;

  

    /**
     * Define grid properties
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('shippingBulkgoodsGrid');
        $this->_exportPageSize = 10000;
    }

    /**
     * Set current website
     *
     * @param int $websiteId
     * @return Mage_Adminhtml_Block_Shipping_Carrier_Tablerate_Grid
     */
    public function setWebsiteId($websiteId)
    {
        $this->_websiteId = Mage::app()->getWebsite($websiteId)->getId();
        return $this;
    }

    /**
     * Retrieve current website id
     *
     * @return int
     */
    public function getWebsiteId()
    {
        if (is_null($this->_websiteId)) {
            $this->_websiteId = Mage::app()->getWebsite()->getId();
        }
        return $this->_websiteId;
    }

    /**
     * Prepare shipping table rate collection
     *
     * @return Mage_Adminhtml_Block_Shipping_Carrier_Tablerate_Grid
     */
    protected function _prepareCollection()
    {
    
        $collection = Mage::getResourceModel('egovsshipment/carrier_bulkgoods_collection');
        $collection->setWebsiteFilter($this->getWebsiteId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare table columns
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
    	$this->addColumn('shipment_group', array(
    			'header'    => Mage::helper('egovsshipment')->__('Shipment Group'),
    			'index'     => 'shipment_group',
    			'default'   => '*',
    	));
    	
        $this->addColumn('dest_country', array(
            'header'    => Mage::helper('adminhtml')->__('Country'),
            'index'     => 'dest_country',
            'default'   => '*',
        ));

        $this->addColumn('dest_region', array(
            'header'    => Mage::helper('adminhtml')->__('Region/State'),
            'index'     => 'dest_region',
            'default'   => '*',
        ));

        $this->addColumn('qty', array(
            'header'    => Mage::helper('adminhtml')->__('Quantity'),
            'index'     => 'qty',
            
        ));

        $this->addColumn('price', array(
            'header'    => Mage::helper('adminhtml')->__('Price'),
            'index'     => 'price',
        ));

        return parent::_prepareColumns();
    }
}
