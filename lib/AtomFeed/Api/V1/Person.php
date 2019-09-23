<?php

class AtomFeed_Api_V1_Person extends AtomFeed_Api_V1_Abstract {

    protected $_name = null;
    protected $_uri = null;
    protected $_email = null;

    public function __construct($name, $uri = null, $email = null) {
        $this->_name = $name;
        $this->_uri = $uri;
        $this->_email = $email;
    }

    /**
     * {@inheritDoc}
     * @see AtomFeed_Api_V1_Abstract::_addCommonXML()
     */
    protected function _addCommonXML(DOMElement $node)
    {
        $this->_childToNode("name", $this->_name, $node);
        if (isset($this->_uri)) {
            $this->_childToNode("uri", $this->_uri, $node);
        }
        if (isset($this->_email)) {
            $this->_childToNode("email", $this->_email, $node);
        }
        return parent::_addCommonXML($node);
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getUri() {
        return $this->_uri;
    }

    public function setUri($uri) {
        $this->_uri = $uri;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($email) {
        $this->_email = $email;
        return $this;
    }

}