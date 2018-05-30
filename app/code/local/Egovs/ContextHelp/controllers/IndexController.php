<?php
  /**
   *
   * @category   	Egovs ContextHelp
   * @package    	Egovs_ContextHelp
   * @name          Egovs_ContextHelp_ContexthelpController
   * @author 		Holger Kögel <h.koegel@b3-it.de>
   * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
   * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
   */
   class Egovs_ContextHelp_IndexController extends Mage_Core_Controller_Front_Action
   {
       /**
        * Ajax-Abfrage für die anzuzeigenden CMS-Blöcke im Popup
        * @return string
        */
       public function indexAction()
       {
           $id    = intval($this->getRequest()->getParam('id'));
           $model = Mage::getModel('contexthelp/contexthelp')->load($id);

           $output = array();
           foreach($model->getBlocks() as $helpblock){
               $block = Mage::getModel('cms/block')
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->load($helpblock->getBlockId());

               if ($block->isEmpty() || !$block->getIsActive()) {
                   continue;
               }

               /* @var $helper Mage_Cms_Helper_Data */
               $helper    = Mage::helper('cms');
               $processor = $helper->getBlockTemplateProcessor();
               $output[]  = $processor->filter($block->getContent());
           }

           $response = $this->getResponse();
           $response->setBody(implode("\n", $output));
           $response->sendResponse();
           die;
       }
   }
