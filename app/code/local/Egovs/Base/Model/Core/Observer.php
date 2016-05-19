<?php
class Egovs_Base_Model_Core_Observer extends Mage_Core_Model_Abstract
{
    public function onAdminhtmlBlockHtmlBefore($observer) {
        /* @var $block Mage_Adminhtml_Block_Template */
        $block = $observer->getBlock();

        if (!$block || !($block instanceof Mage_Adminhtml_Block_Template) || $block->getType() != 'adminhtml/template') {
            return;
        }

        $templateFile = $block->getTemplateFile();
        $templateFile = str_replace('.phtml', '_ml.phtml', $templateFile);
        if (file_exists(Mage::getBaseDir('design').DS.$templateFile) == false) {
            Mage::log("Multi language Template doesn't exist, please create $templateFile to support multi languages", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
            return;
        }

        $block->setTemplate(basename($templateFile));
    }
}