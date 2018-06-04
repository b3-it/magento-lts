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
           $blocks = $this->_cleanBlockIdsFromRequest(explode(',', $this->getRequest()->getParam('showblocks')));
           $id     = intval($this->getRequest()->getParam('id'));
           $model  = Mage::getModel('contexthelp/contexthelp')->load($id);

           $output = array();

           foreach($model->getBlocks() as $helpblock){
                $blockId = $helpblock->getBlockId();
                $block = Mage::getModel('cms/block')
                            ->setStoreId(Mage::app()->getStore()->getId())
                            ->load($blockId);

                if ( $block->isEmpty() || !$block->getIsActive() || in_array($blockId, $blocks) ) {
                    continue;
                }

               /* @var $helper Mage_Cms_Helper_Data */
               $helper    = Mage::helper('cms');
               $processor = $helper->getBlockTemplateProcessor();
               $output[]  = $processor->filter($block->getContent());
               $blocks[]  = $blockId;
           }

           $response = $this->getResponse();
           $response->setHeader('Cpontent-type', 'application/json');
           $response->setBody( json_encode( array('html' => implode("\n", $output), 'blocks' => implode(',', $blocks)) ) );
           $response->sendResponse();
           die;
       }

       /**
        * Parameter-IDs der Blöcke filtern
        *
        * @param  array[]   Array mit BlockIDs, welche bereits angezeigt werden
        * @return array[]
        */
       private function _cleanBlockIdsFromRequest($blockarray = array())
       {
           if ( !count($blockarray) ) {
               return;
           }

           foreach( $blockarray AS $key => $value ) {
               $blockarray[$key] = intval($value);
           }

           return $blockarray;
       }
   }
