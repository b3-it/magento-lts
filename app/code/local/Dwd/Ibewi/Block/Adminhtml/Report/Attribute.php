<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Block_ReportAttribute
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Report_Attribute extends Mage_Adminhtml_Block_Widget_Container //Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    //$this->_controller = 'adminhtml_report_attribute';
   // $this->_blockGroup = 'ibewi';
    $this->_headerText = Mage::helper('ibewi')->__('Report Kontierung');
    
    parent::__construct();
    $this->setTemplate('dwd/ibewi/report/attribute.phtml');
  }
  
  
  
  /**
   * Prepare button and grid
   *
   * @return Mage_Adminhtml_Block_Catalog_Product
   */
  protected function _prepareLayout()
  {
  	$this->setChild('grid', $this->getLayout()->createBlock('ibewi/adminhtml_report_attribute_grid', 'kontierung.grid'));
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
