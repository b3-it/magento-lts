<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Result_Page extends Mage_Core_Block_Template
{
    /** @var Mage_Cms_Block_Page */
    protected $_entity;

    /**
     * @return Mage_Core_Block_Abstract
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @param int $id
     */
    public function loadEntityById($id)
    {
        $this->_entity = Mage::getModel('cms/page')->load($id);
    }

    /**
     * @return Mage_Cms_Block_Page
     */
    public function getPage()
    {
        return $this->_entity;
    }

    /**
     * @param Mage_Cms_Block_Page $entity
     * @return $this
     */
    public function setPage($entity)
    {
        $this->_entity = $entity;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageUrl()
    {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . $this->_entity->getData('identifier');
    }

    /**
     * @param $content
     * @return string
     */
    public function getPreview($content)
    {
        $content = strip_tags($content, /** @lang text */ '<h1><h2><h3><p>');
        $wrap = wordwrap($content, 300, '<!--break-page-->', false);
        $content = strstr($wrap, '<!--break-page-->', true);
        return $content . '...';
    }
}
