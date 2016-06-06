<?php

class Egovs_EventBundle_Block_Adminhtml_Report_Options extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
    	parent::__construct();
    	
        $this->_headerText = Mage::helper('eventbundle')->__('Product Options');
		$this->_controller = 'adminhtml_report_options';
        $this->_blockGroup = 'eventbundle'; //_controller funktioniert sonst nicht
         $this->setTemplate('egovs/extreport/container.phtml');            
        $this->_removeButton('add');
    }
    
    protected function _prepareLayout()
    {
         $this->setChild('store_switcher',
            $this->getLayout()->createBlock('adminhtml/store_switcher')
                ->setUseConfirm(false)
                ->setSwitchUrl($this->getUrl('*/*/*', array('store'=>null)))
                ->setTemplate('report/store/switcher.phtml')
        );
  	
    	$this->setChild('grid', $this->getLayout()->createBlock('eventbundle/adminhtml_report_options_grid', 'sales.grid'));
        return parent::_prepareLayout();
    }

  
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
     * Check whether it is single store mode
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
