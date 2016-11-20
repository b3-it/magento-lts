<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Adminhtml_Extreport_Order_ItemsController extends Mage_Adminhtml_Controller_Action
{

   
    protected function _initAction()
    {
    	$act = $this->getRequest()->getActionName();
    	if(!$act)
    		$act = 'default';
    
    	$this->loadLayout()
    	->_addBreadcrumb(Mage::helper('reports')->__('Reports'), Mage::helper('reports')->__('Reports'))
    	->_addBreadcrumb(Mage::helper('reports')->__('Sales'), Mage::helper('reports')->__('Sales'));
    	$this->initLayoutMessages('adminhtml/session');
    	return $this;
    }
    
    public function indexAction()
    {
    	$this->_initAction()
    	->_setActiveMenu('report/salesroot/order_item')
    	->_addContent($this->getLayout()->createBlock('extreport/sales_order_items'))
    	->renderLayout();
    }
    
    /**
     * Order grid
     */
    public function gridAction()
    {
        $this->loadLayout(false);
        //$this->renderLayout();
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('extreport/adminhtml_sales_order_items_grid')->toHtml()
        );
    }


}
