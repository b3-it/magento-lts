<?php
/**
 * Configurable Downloadable Products Tab für Downloadlinks
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2016 B3 IT Systeme GmbH <https://www.b3-it.de>
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
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml() {
    	return Mage_Adminhtml_Block_Widget::_toHtml();    	
    }
}
