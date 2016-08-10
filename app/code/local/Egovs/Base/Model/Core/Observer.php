<?php
/**
 * Dient für den Multilanguage-Support von zusätzlich geladenen Templates zur JavaScript-Unterstützung
 *
 * @category        Egovs_Base_Model_Core_Observer
 * @package			Egovs_Base
 * @name            Egovs_Base_Model_Core_Observer
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Base_Model_Core_Observer extends Mage_Core_Model_Abstract
{
    public function onAdminhtmlBlockHtmlBefore($observer) {
        /* @var $block Mage_Adminhtml_Block_Template */
        $block = $observer->getBlock();

        if (!$block || !($block instanceof Mage_Adminhtml_Block_Template) || $block->getType() != 'adminhtml/template') {
            return;
        }
        
        if (!$block->getParentBlock()) {
        	return;
        }
        
        $parent = $block->getParentBlock();
        //Falls KEINE der Bedingungen erfüllt ist!
        if (!($parent->getBlockAlias() == 'js'
        	|| $parent->getBlockAlias() == 'head'
        	|| $parent->getNameInLayout() == 'js'
        	|| $parent->getNameInLayout() == 'head')
        ) {
        	return;
        }

        $templateFile = $block->getTemplateFile();
        $templateFile = str_replace('.phtml', '_ml.phtml', $templateFile);
        if (file_exists(Mage::getBaseDir('design').DS.$templateFile) == false) {
            Mage::log("Multi language Template doesn't exist, please create $templateFile to support multi languages", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
            return;
        }
        //Falls Datei existiert muss nur die eigentliche Template-Angabe im Block geändert werden!
        $templateFile = $block->getTemplate();
        $templateFile = str_replace('.phtml', '_ml.phtml', $templateFile);

        $block->setTemplate($templateFile);
    }
}