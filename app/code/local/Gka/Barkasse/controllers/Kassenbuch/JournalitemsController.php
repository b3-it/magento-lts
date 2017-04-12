<?php
  /**
   *
   * @category   	Gka Barkasse
   * @package    	Gka_Barkasse
   * @name        Gka_Barkasse_Kassenbuch_JournalitemsController
   * @author 		Holger Kögel <h.koegel@b3-it.de>
   * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
   * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
   */
class Gka_Barkasse_Kassenbuch_JournalitemsController extends Mage_Core_Controller_Front_Action
{
    protected $_customer = null;

    public function indexAction()
    {
      $this->loadLayout();
      $this->renderLayout();
    }

    public function preDispatch() {
    	parent::preDispatch();

    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }

    protected function _getCustomer()
    {
        if($this->_customer == null){
          $this->_customer = Mage::getSingleton('customer/session')->getCustomer();
        }
        return $this->_custommer;
    }
    
    public function gridAction()
    {
    	if(!$this->_validateFormKey()){
    		$this->_redirect('customer/account/logout');
    		return;
    	}
    	$this->loadLayout(false);
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('gka_barkasse/kassenbuch_journalitems_grid')->toHtml()
    			);
    }
}
