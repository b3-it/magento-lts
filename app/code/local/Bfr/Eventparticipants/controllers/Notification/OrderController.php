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

        $response = ['valid' => false, 'url' => null];

        if ($hash != null) {
            $model->load($hash, 'hash');
        }

        if ($model->hasData('id') && $model->getData('status') === '1') {
            $response['valid'] = true;
            $response['url'] = Mage::getUrl('bfr_eventparticipants/notification_order/accepted', array('hash' => $hash));
        }

        Mage::register('participationlist_agreement', $response);

        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @throws Mage_Core_Exception
     */
    public function acceptedAction()
    {
        $model = Mage::getModel('bfr_eventparticipants/notification_order');
        $hash = $this->getRequest()->getParam('hash');
        $accepted = $this->getRequest()->getParam('accept');

        if ($accepted !== 'on') {
            $this->_redirect('bfr_eventparticipants/notification_order/index', ['hash' => $hash]);
        } else {
            $response = ['valid' => false, 'url' => null];

            if ($hash != null) {
                $model->load($hash, 'hash');
            }

            if ($model->hasData('id') && $model->getData('status') === '1') {
                $response['valid'] = true;
                $model->setStatus(2);
                $model->save();
            }

            Mage::register('participationlist_agreement', $response);

            $this->loadLayout();
            $this->renderLayout();
        }
    }
}
