<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Adminhtml_Tools_Analyse_Sales_OrderController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Orders grid
     */
    public function indexAction()
    {
        $this->_title($this->__('Sales'))->_title($this->__('Orders'));
        
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Order grid
     */
    public function gridAction()
    {
        $this->loadLayout(false);
        //$this->renderLayout();
        $this->getResponse()->setBody(
        		$this->getLayout()->createBlock('germantax/adminhtml_tools_analyse_sales_order_grid')->toHtml()
        );
    }


}
