<?php
/**
 * Block zur Erstellung eines Rückläufers (Spezialstorno/Gutschrift)
 * 
 * @category   	Egovs
 * @package    	Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Extsalesorder_Block_Adminhtml_Sales_Order_Creditmemo_Create extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'order_id';
        $this->_controller = 'sales_order_creditmemo';
        $this->_mode = 'create';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('save');

        $this->_addButton('submit_creditmemo', array(
            'label'     => Mage::helper('sales')->__('Submit Credit Memo'),
            'class'     => 'save submit-button',
            'onclick'   => '$(\'edit_form\').submit()',
            )
        );

    }

    /**
     * Retrieve creditmemo model instance
     *
     * @return Mage_Sales_Model_Order_Creditmemo
     */
    public function getCreditmemo()
    {
        return Mage::registry('current_creditmemo');
    }

    /**
     * Gibt den Text für den Header zurück
     * 
     * @return string
     * 
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     */
    public function getHeaderText()
    {
        if ($this->getCreditmemo()->getInvoice()) {
            $header = Mage::helper('sales')->__(
                'New Return for Invoice #%s',
                $this->escapeHtml($this->getCreditmemo()->getInvoice()->getIncrementId())
            );
        } else {
            $header = Mage::helper('sales')->__(
                'New Return for Order #%s',
                $this->escapeHtml($this->getCreditmemo()->getOrder()->getRealOrderId())
            );
        }

        return $header;
    }

    /**
     * Liefert die URL für den Zurück-Button
     * 
     * @return string
     * 
     * @see Mage_Adminhtml_Block_Widget_Form_Container::getBackUrl()
     */
    public function getBackUrl() {
        return $this->getUrl('adminhtml/extsalesorder_sales_order/view', array('order_id'=>$this->getCreditmemo()->getOrderId()));
    }
}