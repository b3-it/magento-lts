<?php
/**
 * @category    Egovs
 * @package     Egovs_ContextHelp
 * @copyright  Copyright (c) 2018 B3-IT Systeme GmbH (http://www.b3-it.de)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_ContextHelp_Model_Observer extends Varien_Object
{
    /**
     *
     * @return void
     *
     * @see Varien_Object::_construct()
     */
    public function _construct() {
        //Zend_Debug::dump('Start');
    }
    
    /**
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function onWidgetSaveAfter(Varien_Event_Observer $observer) {
        $_postData = Mage::app()->getRequest()->getPost('widget_instance');
        $_widget = $observer->getObject();

        $this->_deleteUrlByWidgetId( $_widget->getInstanceId() );
        
        echo '<pre>';
        print_r($_postData);
        print_r($_widget);
        
        die;
    }

    /**
     * 
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function onWidgetDeleteAfter(Varien_Event_Observer $observer) {
        //Zend_Debug::dump('Delete');
    }
    
    private function _deleteUrlByWidgetId($widgetId) {
        $widgetId = intval($widgetId);
        
        if ( !$widgetId ) {
            return;
        }
        
        Zend_Debug::dump($widgetId);
    }
}