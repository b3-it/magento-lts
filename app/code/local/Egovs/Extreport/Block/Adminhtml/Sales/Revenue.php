<?php

/**
 * Adminhtml Report: Gewinn
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Revenue extends Mage_Adminhtml_Block_Widget_Container
{
    /**
	 * Initialisiert den Block-Container
	 * 
	 * Setzt ein eigenes Template
	 * 
	 * @return void
	 */
    public function __construct()
    {
        parent::__construct();
        
        $this->_headerText = Mage::helper('extreport')->__('Yield');
        $this->setTemplate('egovs/extreport/container.phtml');
    }

    /**
	 * Initialisiert das Layout
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Revenue
	 */
    protected function _prepareLayout()
    {
         $this->setChild('store_switcher',
            $this->getLayout()->createBlock('adminhtml/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );
    	
    	$this->setChild('grid', $this->getLayout()->createBlock('extreport/sales_revenue_grid', 'sales.grid'));
        return parent::_prepareLayout();
    }

  
    /**
     * Liefert den Store-Switcher gerendert als HTML
     * 
     * @return string
     */
    public function getStoreSwitcherHtml()
    {
        if (Mage::app()->isSingleStoreMode()) {
            return '';
        }
        return $this->getChildHtml('store_switcher');
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
