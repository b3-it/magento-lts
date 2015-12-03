<?php
class Egovs_Base_Adminhtml_System_CacheController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        if ( function_exists('apc_clear_cache') ) {
            apc_clear_cache();
            apc_clear_cache('user');
            apc_clear_cache('opcode');

            $this->_getSession()->addSuccess($this->__('APC Cache cleared!'));
        }
        else {
            $this->_getSession()->addError($this->__('APC not installed!'));
        }
        $this->_redirectReferer();
    }
}