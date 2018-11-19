<?php

/**
 * Class Egovs_Captcha_Block_Captcha
 *
 * @category  Egovs
 * @package   Egovs_Captcha
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Captcha_Block_Captcha extends Mage_Captcha_Block_Captcha_Zend
{
    /**
     * @var Mage_Captcha_Block_Captcha_Zend
     */
    protected $_decoratedInstance = null;

    /**
     * Internal constructor, that is called from real constructor
     *
     */
    protected function _construct()
    {
        $type = Mage::helper('egovscaptcha')->getConfigNode('type');
        try {
            $this->_decoratedInstance = $this->_getBlockInstance("egovscaptcha/$type".'Captcha');
        } catch (Exception $e) {
        }
        parent::_construct();
    }

    /**
     * Create block object instance based on block type
     *
     * @param string $block
     * @param array $attributes
     * @return Mage_Core_Block_Abstract
     */
    protected function _getBlockInstance($block, array $attributes=array())
    {
        if (is_string($block)) {
            if (strpos($block, '/')!==false) {
                if (!$block = Mage::getConfig()->getBlockClassName($block)) {
                    Mage::throwException(Mage::helper('core')->__('Invalid block type: %s', $block));
                }
            }
            if (class_exists($block, false) || mageFindClassFile($block)) {
                $block = new $block($attributes);
            }
        }
        if (!$block instanceof Mage_Core_Block_Abstract) {
            Mage::throwException(Mage::helper('core')->__('Invalid block type: %s', $block));
        }
        return $block;
    }

    /**
     * Returns template path
     *
     * @return string
     */
    public function getTemplate() {
        if ($this->_decoratedInstance === null) {
            return parent::getTemplate();
        }

        return $this->_decoratedInstance->getTemplate();
    }

    /**
     * Returns captcha model
     *
     * @return Egovs_Captcha_Model_Abstract
     */
    public function getCaptchaModel()
    {
        return Mage::helper('egovscaptcha')->getCaptcha($this->getFormId());
    }

    public function getRefreshUrl() {
        if ($this->_decoratedInstance === null) {
            return parent::getRefreshUrl();
        }

        return $this->_decoratedInstance->getRefreshUrl();
    }

    public function setFormId($formId) {
        if ($this->_decoratedInstance !== null) {
            $this->_decoratedInstance->setFormId($formId);
        }
        return parent::setFormId($formId);
    }
}