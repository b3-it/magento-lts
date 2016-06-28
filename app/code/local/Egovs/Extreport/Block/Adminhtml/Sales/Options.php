<?php
/**
 * Report sales block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Options extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
    	parent::__construct();
    	
        $this->_headerText = Mage::helper('extreport')->__('Product Options');
		$this->_controller = 'sales_options'; //Block Pfad ohne adminhtml
		$this->_blockGroup = 'extreport'; //_controller funktioniert sonst nicht
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
