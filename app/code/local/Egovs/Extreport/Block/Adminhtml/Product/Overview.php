<?php
/**
 * Adminhtml Report: Produktüberblick
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Product_Overview extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Initialisiert den Block
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_headerText = Mage::helper('extreport')->__('Product Overview');
        $this->setTemplate('egovs/extreport/container.phtml');
    }

    /**
     * Initialisiert das Layout
     *
     * @return Egovs_Extreport_Block_Adminhtml_Product_Overview
     */
    protected function _prepareLayout()
    {
    	
    	$this->setChild('store_switcher',
            $this->getLayout()->createBlock('mage_adminhtml_block_store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl("*/*/*", array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml') //falls auskommentiert, sind nur noch Store Views anklickbar! siehe Ticket #177
        );
        
        $this->setChild('grid', $this->getLayout()->createBlock('extreport/product_overview_grid', 'product.grid'));
        return parent::_prepareLayout();
    }  

    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Prüft ob das System im Single-Store Mode operiert
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
               return false;
        }
        return true;
    }
}
