<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function getEventProducts()
	{
		$collection = Mage::getModel('catalog/product')->getCollection()
		->addAttributeToSelect('sku')
		->addAttributeToSelect('name')
		->addAttributeToFilter('type_id',Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
		
		return $collection;
	}

	public function getSignaturePath()
    {
        return  Mage::getBaseDir('var') . DS . 'signature';
    }





    /**
     *
     * @param string $template Path
     * @param array $recipient (array('name'=>'Max','email'=>'max@xx.de'))
     * @param array $data template Data
     * @param number $storeid default 0
     * @param array dateien die versendet werden sollen
     * @return void|Sid_Framecontract_Helper_Data
     */
    public function sendEmail($template, $participant, array $data , $storeId = 0, $file = null)
    {
        if(!is_numeric($template))
        {
            $templateId = Mage::getStoreConfig($template, $storeId);
        }
        //prüfen ob pfad zur config oder TemplateIdentifier
        if($templateId){
            $template = $templateId;
        }


        /** @var $mailer Egovs_Base_Model_Core_Email_Mailer */
        $mailer = Mage::getModel('egovsbase/core_email_template_mailer');
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($participant->getEmail(), trim($participant->getFirstname() . " " .$participant->getLastname()));

        $mailer->addEmailInfo($emailInfo);



        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */

        $sender = array();
        $sender['name'] = Mage::getStoreConfig("eventmanager/participation_certificate_email/sender_name", $storeId);
        $sender['email'] = Mage::getStoreConfig("eventmanager/participation_certificate_email/sender_email_address", $storeId);


        if(strlen($sender['name']) < 2 ){
            $sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeId);
        }

        if(strlen($sender['email']) < 2 ){
            $sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeId);
        }

        $mailer->setSender($sender);
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams($data);

        if ($file) {
            $mailer->setAttachment($file['content'], $file['filename']);
        }

        try {
            /** @var $emailQueue Egovs_Base_Model_Core_Email_Queue */
            $emailQueue = Mage::getModel('egovsbase/core_email_queue');
            $emailQueue->setEntityId($participant->getId())
                ->setEntityType('participant')
                ->setEventType('participation_certificate')
                ->setIsForceCheck(true);

            $mailer->setQueue($emailQueue)->send();
        } catch(Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            Mage::logException($ex);
        }

        return $this;
    }

}
