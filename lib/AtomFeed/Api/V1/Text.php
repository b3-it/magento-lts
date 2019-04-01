<?php
class AtomFeed_Api_V1_Text extends AtomFeed_Api_V1_Abstract {

    protected $_type = "text";

    protected $_body = "";

    public function __construct($body, $type = "text") {
        $this->_body = $body;
        $this->_type = $type;
    }

    /**
     * {@inheritDoc}
     * @see AtomFeed_Api_V1_Abstract::_addCommonXML()
     */
    protected function _addCommonXML(DOMElement $node) {
        $doc = $node->ownerDocument;
        $node->appendChild($this->_createAttr($doc, "type", $this->_type));

        if ($this->_type === "text") {
            $node->appendChild($doc->createTextNode($this->_body));
        } else if ($this->_type === "html") {
            $node->appendChild($doc->createCDATASection($this->_body));
        } else if ($this->_type === "xhtml") {
            $div = $doc->createElementNS("http://www.w3.org/1999/xhtml", "div");
            $frag = $doc->createDocumentFragment();
            $frag->appendXML($this->_body);
            $div->appendChild($frag);
            $node->appendChild($div);
        }

        return parent::_addCommonXML($node);
    }

    public function getBody() {
        return $this->_body;
    }
}