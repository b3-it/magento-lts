<?php
/**
 * 
 *  Ids Observer
 *  @category B3It
 *  @package  B3it_Admin_Model_Observer
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2015 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Model_Observer
{
    private $__ip = null;

	public function onFrontControllerInitBefore($observer)
	{
		if (!Mage::isInstalled()) return;
		
		if(Mage::getStoreConfig('admin/ids/enable_ids') != 1) return;
		
		$front = $observer->getFront();
		$ids = Mage::getModel('b3it_ids/idsComponent');
		$ids->detect($front);


		$dos = Mage::getModel('b3it_ids/dos_visit');
		$dos->detect($front, $this->__getIP(),$this->__getAgent());

	}

    private function __getIP()
    {
        if($this->__ip == null)
        {
            $this->__ip  = ($_SERVER['SERVER_ADDR'] != '127.0.0.1') ?
                $_SERVER['SERVER_ADDR'] :
                (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
                    $_SERVER['HTTP_X_FORWARDED_FOR'] :
                    '127.0.0.1');
        }
        return $this->__ip ;
    }

    private function __getAgent()
    {
        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            return $_SERVER['HTTP_USER_AGENT'];
        }
        return "unknown";
    }

}