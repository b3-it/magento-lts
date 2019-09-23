<?php

class AtomFeed_Api_V1_Link extends AtomFeed_Api_V1_Abstract {

    protected $_href = "";
    protected $_rel = null;
    protected $_type = null;
    protected $_hreflang = null;
    protected $_title = null;
    protected $_length = null;

    public function __construct($href, $rel = null, $type = null, $hreflang = null, $title = null, $length = null) {
        $this->_href = $href;
        $this->_rel = $rel;
        $this->_type = $type;
        $this->_hreflang = $hreflang;
        $this->_title = $title;
        $this->_length = $length;
    }

    /**
     * {@inheritDoc}
     * @see AtomFeed_Api_V1_Abstract::_addCommonXML()
     */
    protected function _addCommonXML(DOMElement $node)
    {
        $doc = $node->ownerDocument;
        $node->appendChild($this->_createAttr($doc, "href", $this->_href));

        if (isset($this->_rel)) {
            $node->appendChild($this->_createAttr($doc, "rel", $this->_rel));
        }
        if (isset($this->_type)) {
            $node->appendChild($this->_createAttr($doc, "type", $this->_type));
        }
        if (isset($this->_hreflang)) {
            $node->appendChild($this->_createAttr($doc, "hreflang", $this->_hreflang));
        }
        if (isset($this->_title)) {
            $node->appendChild($this->_createAttr($doc, "title", $this->_title));
        }
        if (isset($this->_length)) {
            $node->appendChild($this->_createAttr($doc, "length", $this->_length));
        }

        return parent::_addCommonXML($node);
    }
}