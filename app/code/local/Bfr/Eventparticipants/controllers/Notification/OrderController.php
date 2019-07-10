<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Notification_OrderController
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Notification_OrderController extends Mage_Core_Controller_Front_Action
{
    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $model = Mage::getModel('bfr_eventparticipants/notification_order');
        $hash = $this->getRequest()->getParam('hash');

        if($hash != null ){
            $model->load($hash, 'hash');
        }

        if($model->hasData('id') && $model->getData('status') === '0'){
            $model->setStatus(1);
            $model->save();
        }

        $this->loadLayout();
        $this->renderLayout();
    }
}
