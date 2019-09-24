<?php

class AtomFeed_Api_V1_Abstract {
    protected $_attributes = [];
    protected $_namespaces = [];
    protected $_children = [];

    //protected $_allowed_attributes = [];
    protected $_node_content = "";

    public function isSimple() {
        return false;
    }

    protected function _getNodeContent() {
        return $this->_node_content;
    }

    /**
     * @param string $name
     * @param string $value
     * @return AtomFeed_Api_V1_Abstract
     */
    public function addAttribute($name, $value) {
        $this->_attributes[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return AtomFeed_Api_V1_Abstract
     */
    public function addChild($name, $value) {
        if (!isset($this->_children[$name])) {
            $this->_children[$name] = [];
        }
        $this->_children[$name][] = $value;
        return $this;
    }

    public function addNamespace($key, $uri) {
        $this->_namespaces[$key] = $uri;
        return $this;
    }

    /**
     *
     * @param DOMNode $parent
     * @param string $name
     * @return DOMElement
     */
    public function buildxml(DOMNode $parent, $name, $ns = null) {
        /**
         * @var DOMDocument $doc
         */
        $doc = $parent->ownerDocument ?: $parent;
        if (is_null($ns)) {
            $node = $doc->createElement($name);
        } else {
            $node = $doc->createElementNS($ns, $name);
        }

        $parent->appendChild($node);

        // add namespaces there
        foreach ($this->_namespaces as $k => $v) {
            $node->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:'.$k, $v);
        }

        $this->_addCommonXML($node);
        return $node;
    }
    /**
     * @param DOMElement $node
     */
    protected function _addCommonXML(DOMElement $node) {
        $doc = $node->ownerDocument;

        foreach ($this->_attributes as $k => $v) {
            $node->appendChild($this->_createAttr($doc, $k, $v));
        }
        foreach ($this->_children as $name => $val) {
            if (is_array($val)) {
                foreach ($val as $child) {
                    $this->_childToNode($name, $child, $node);
                }
            } else {
                $this->_childToNode($name, $val, $node);
            }
        }
        $content = $this->_getNodeContent();
        if (!empty($content)) {
            // need to cleanup the node content
            $node->nodeValue = "";
            $node->appendChild($doc->createTextNode($content));
        }
        return $this;
    }

    /**
     *
     * @param string $name
     * @param DOMNode|AtomFeed_Api_V1_Abstract $child
     * @param DOMNode $parent
     * @return DOMNode|DOMElement
     */
    protected function _childToNode($name, $child, DOMNode $parent, $class = null) {
        /**
         * @var DOMDocument $doc
         */
        $doc = $parent->ownerDocument ?: $parent;

        if ($child instanceof DOMNode) {
            $parent->appendChild($child);
            return $child;
        } else if ($child instanceof AtomFeed_Api_V1_Abstract) {
            return $child->buildxml($parent, $name);
        } else {
            // simple child using child as text node
            $node = $doc->createElement($name);
            $node->appendChild($doc->createTextNode($child));
            $parent->appendChild($node);
            return $node;
        }
    }

    /**
     *
     * @param DOMDocument $doc
     * @param string $name
     * @param string $value
     * @return DOMAttr
     */
    protected function _createAttr(DOMDocument $doc, $name, $value) {
        $attr = $doc->createAttribute($name);
        if (!is_null($value)) {
            $attr->value = $value;
        }
        return $attr;
    }

    /**
     *
     * @param AtomFeed_Api_V1_DateTime|DateTime|string|null $value
     * @return AtomFeed_Api_V1_DateTime
     */
    protected function _valueToDateTime($value) {
        return $this->_valueToClass($value, AtomFeed_Api_V1_DateTime::class);
    }

    /**
     *
     * @param AtomFeed_Api_V1_Text|string|null $value
     * @return AtomFeed_Api_V1_Text
     */
    protected function _valueToText($value) {
        return $this->_valueToClass($value, AtomFeed_Api_V1_Text::class);
    }

    /**
     *
     * @param AtomFeed_Api_V1_Content|string|null $value
     * @return AtomFeed_Api_V1_Content
     */
    protected function _valueToContent($value) {
        return $this->_valueToClass($value, AtomFeed_Api_V1_Content::class);
    }

    protected function _valueToClass($value, $class) {
        if (is_null($value) || $value instanceof $class) {
            return $value;
        } else {
            return new $class($value);
        }
    }
}