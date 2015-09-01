<?php
/**
 * Configurable Downloadable Products Tab für Downloadlinks
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Configdownloadable
    extends Mage_Downloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Downloadable
{

    /**
     * Reference to product objects that is being edited
     *
     * @var Mage_Catalog_Model_Product
     */
    protected $_product = null;

    protected $_config = null;

    /**
     * Konstruktor
     * 
     * Nutzt nicht Downloadable Konstruktor!
     * 
     * @return void
     */
    public function __construct() {
    	Varien_Object::__construct();
    }
    
    /**
     * Get tab URL
     *
     * @return string
     */
//     public function getTabUrl() {
//     	return $this->getUrl('*/configdownloadable_product_edit/form', array('_current' => true));
//     }
    
    /**
     * Get tab class
     *
     * @return string
     */
    /* 
     * JavaScript-Funktionen in Tempaltes gehen nicht mit ajax
     * public function getTabClass() {
    	return 'ajax';
    } */
    
    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml() {
    	return Mage_Adminhtml_Block_Widget::_toHtml();    	
    }
}
