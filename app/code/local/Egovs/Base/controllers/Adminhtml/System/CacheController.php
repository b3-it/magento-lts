<?php
class Egovs_Base_Adminhtml_System_CacheController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
    	$isApc = function_exists('apc_clear_cache');
    	$isZendOpCache = function_exists('opcache_reset');
    	if ($isApc || $isZendOpCache) {
	        if ( $isApc ) {
	            apc_clear_cache();
	            apc_clear_cache('user');
	            apc_clear_cache('opcode');
	
	            $this->_getSession()->addSuccess($this->__('APC Cache cleared!'));
	        }
	        
	        if ( $isZendOpCache ) {
	        	opcache_reset();
	        
	        	$this->_getSession()->addSuccess($this->__('Zend OPCache cleared!'));
	        }
    	}
    	
    	if (!$isApc && !$isZendOpCache) {
    		$this->_getSession()->addError($this->__('No Cache to clear available!'));
    	}
        $this->_redirectReferer();
    }
}