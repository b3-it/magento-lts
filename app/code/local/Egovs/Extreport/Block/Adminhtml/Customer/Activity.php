<?php

/**
 * Block-Container für Benutzeraktivitäten
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Customer_Activity extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * Setzt ein eigenes Template
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->_headerText = Mage::helper('extreport')->__('Customer Activity');
        $this->setTemplate('egovs/extreport/container.phtml');
    }

    /**
     * Initialisiert das Layout
     *
     * @return Mage_Adminhtml_Block_Catalog_Product
     */
    protected function _prepareLayout()
    {    	
        $this->setChild('grid', $this->getLayout()->createBlock('extreport/customer_activity_grid', 'customer.grid'));
        return parent::_prepareLayout();
    }  

    /**
     * Render Grid
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
