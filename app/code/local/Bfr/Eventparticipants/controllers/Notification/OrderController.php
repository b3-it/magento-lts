<?php
  /**
   *
   * @category   	Bfr Eventparticipants
   * @package    	Bfr_Eventparticipants
   * @name        Bfr_Eventparticipants_Notification_OrderController
   * @author 		Holger Kögel <h.koegel@b3-it.de>
   * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
   * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
   */
class Bfr_Eventparticipants_Notification_OrderController extends Mage_Core_Controller_Front_Action
{
    protected $_customer = null;

    public function indexAction()
    {
      $id     =  intval($this->getRequest()->getParam('id'));
      $model  = Mage::getModel('bfr_eventparticipants/notification_order')->load($id);

      if ($model->getId() || $id == 0)
      {
        Mage::register('notificationorder_data', $model);
      }else{
        Mage::getSingleton('core/session')->addError($this->__('Internal Error'));
        Mage::log('bfr_eventparticipants/notification_order not found ID:'.$id);
        $this->_redirect('customer/account');
        return;
      }


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
}
