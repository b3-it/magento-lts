<?php
/**
 * Markerklasse um die Anzeige des Infoblocks beim Checkout zu überspringen
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @name       	Egovs_Paymentbase_Block_Noinfo
 * @author    	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright 	2016 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Paymentbase_Block_Adminhtml_Notifications extends Mage_Adminhtml_Block_Template
{
    /**
     * Disable the block caching for this block
     */
    protected function _construct()
    {
        parent::_construct();
        $this->addData(array('cache_lifetime' => null));
    }

    /**
     * Returns a value that indicates if some of the paymentbase settings have already been initialized.
     *
     * @return bool Flag if Setup is already initialized
     */
    public function isInitialized()
    {
    	/* @var $collection Egovs_Paymentbase_Model_Mysql4_Haushaltsparameter_Collection */
        $collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
        if ($collection->getSize() > 6) {
        	return true;
        }
        return false;
    }

    /**
     * Liefert Haushaltsparamter Management URL
     *
     * @return string URL für Haushaltsparamter Form
     */
    public function getManageUrl()
    {
        return $this->getUrl('adminhtml/paymentbase_haushaltsparameter');
    }

    /**
     * ACL Validierung vor HTML Rendering
     *
     * @return string Notification content
     */
    protected function _toHtml()
    {
        if (Mage::getSingleton('admin/session')->isAllowed('system/paymentparams/haushaltsparameter')) {
            return parent::_toHtml();
        }

        return '';
    }
}
