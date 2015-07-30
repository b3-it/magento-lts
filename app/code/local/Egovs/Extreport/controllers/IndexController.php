<?php
/**
 * Wird benötigt um Sessiontimeout bei der Verwendung von Ajax korrekt zu behandeln.
 * Siehe dazu Ticket #219 im Trac
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 * @see Mage_Adminhtml_IndexController
 */
class Egovs_Extreport_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function deniedJsonAction()
    {
        $this->getResponse()->setBody($this->_getDeniedJson());
    }

    protected function _getDeniedJson()
    {
        return Zend_Json::encode(
            array(
                'ajaxExpired'  => 1,
                'ajaxRedirect' => $this->getUrl('adminhtml/index/login')
            )
        );
    }

    public function deniedIframeAction()
    {
        $this->getResponse()->setBody($this->_getDeniedIframe());
    }

    protected function _getDeniedIframe()
    {
        return '<script type="text/javascript">parent.window.location = \''.$this->getUrl('adminhtml/index/login').'\';</script>';
    }
}