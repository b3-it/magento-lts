<?php
/**
 *
 *  @category Egovs
 *  @package  Egovs_Captcha_Model_Observer
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @copyright Copyright (c) 2018 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Model_Observer
{
    /**
     * connect to event core_block_abstract_to_html_before
     */
    public function headBeforeHtmlforCaptcha($observer)
    {
        /**
         * @var $block Mage_Core_Block_Abstract|Mage_Page_Block_Html_Head
         */
        $block = $observer->getEvent()->getBlock();
        if ($block->getNameInLayout() !== 'head') {
            // not head
            return;
        }

        /**
         * @var $layout Mage_Core_Model_Layout
         */
        $layout = $block->getLayout();
        if (!$layout->getBlock('captcha')) {
            // doesn't has captcha block
            return;
        }

        $_type = Mage::helper('egovscaptcha')->getConfigNode('type');

        /**
         * Add CSS file to HEAD entity
         *
         * @param string $name
         * @param string $params
         * @return Mage_Page_Block_Html_Head
         */
        $block->addCss('css/' . $_type . 'captcha.css');
    }
}