<?php

class AtomFeed_Api_V1_Category extends AtomFeed_Api_V1_Abstract {

    protected $_term = null;
    protected $_scheme = null;
    protected $_label = null;

    public function __construct($term, $scheme = null, $label = null) {
        $this->_term = $term;
        $this->_scheme = $scheme;
        $this->_label = $label;
    }

    /**
     * {@inheritDoc}
     * @see AtomFeed_Api_V1_Abstract::_addCommonXML()
     */
    protected function _addCommonXML(DOMElement $node)
    {
        $this->_childToNode("term", $this->_term, $node);
        if (isset($this->_scheme)) {
            $this->_childToNode("scheme", $this->_scheme, $node);
        }
        if (isset($this->_label)) {
            $this->_childToNode("label", $this->_label, $node);
        }
        return parent::_addCommonXML($node);
    }
}