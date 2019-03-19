<?php

use Ramsey\Uuid\Uuid;

class AtomFeed_Api_V1_Feed extends AtomFeed_Api_V1_Abstract {

    const MIME_TYPE = "application/atom+xml";

    protected $_authors = [];
    protected $_contributors = [];
    protected $_categories = [];
    protected $_links = [];

    protected $_entries = [];

    protected $_id = null;
    protected $_title = "";

    /**
     * Required
     * @var DateTime|AtomFeed_Api_V1_DateTime
     */
    protected $_updated = null;

    public function addAuthor($name, $uri = null, $email = null) {
        if ($name instanceof AtomFeed_Api_V1_Person) {
            $this->_authors[] = $name;
        } else {
            $this->_authors[] = new AtomFeed_Api_V1_Person($name, $uri, $email);
        }
        return $this;
    }

    public function addContributor($name, $uri = null, $email = null) {
        if ($name instanceof AtomFeed_Api_V1_Person) {
            $this->_contributors[] = $name;
        } else {
            $this->_contributors[] = new AtomFeed_Api_V1_Person($name, $uri, $email);
        }
        return $this;
    }

    public function addCategory($term, $scheme = null, $label = null) {
        $this->_categories[] = new AtomFeed_Api_V1_Category($term, $scheme, $label);
        return $this;
    }

    public function addLink($href, $rel = null, $type = null, $hreflang = null, $title = null, $length = null) {
        if (!isset($this->_id)) {
            $this->_id = Uuid::uuid5(Uuid::NAMESPACE_URL, $href)->getUrn();
        }
        if ($href instanceof AtomFeed_Api_V1_Link) {
            $this->_links[] = $href;
        } else {
            $this->_links[] = new AtomFeed_Api_V1_Link($href, $rel, $type, $hreflang, $title, $length);
        }
        return $this;
    }

    public function addEntry($entry) {
        $this->_entries[] = $entry;
        return $this;
    }

    public function toXML() {
        $doc = new DOMDocument("1.0", "UTF-8");
        $doc->formatOutput = true;
        $this->buildxml($doc, "feed", "http://www.w3.org/2005/Atom");
        return $doc->saveXML();
    }


    /**
    * {@inheritDoc}
    * @see AtomFeed_Api_V1_Abstract::_addCommonXML()
    */
    protected function _addCommonXML(DOMElement $node)
    {
        foreach ($this->_authors as $author) {
            /**
             * @var AtomFeed_Api_V1_Person $author
             */
            $author->buildxml($node, "author");
        }
        foreach ($this->_contributors as $contributor) {
            /**
             * @var AtomFeed_Api_V1_Person $contributor
             */
            $contributor->buildxml($node, "contributor");
        }

        $this->_childToNode("id", $this->getId(), $node);

        foreach ($this->_links as $link) {
            /**
             * @var AtomFeed_Api_V1_Link $link
             */
            $link->buildxml($node, "link");
        }

        $this->_childToNode("title", $this->_title, $node);

        $this->_valueToDateTime($this->getUpdated())->buildxml($node, "updated");

        foreach ($this->_entries as $entry) {
            /**
             * @var AtomFeed_Api_V1_Entry $entry
             */
            $entry->buildxml($node, "entry");
        }
        return parent::_addCommonXML($node);
    }

    public function getUpdated() {
        if (!isset($this->_updated)) {
            $this->_updated = $this->_valueToDateTime(new DateTime());
        }
        return $this->_updated;
    }

    /**
     * @param AtomFeed_Api_V1_DateTime|DateTime|string|null $value
     * @return AtomFeed_Api_V1_Entry
     */
    public function setUpdated($value) {
        $this->_updated = $this->_valueToDateTime($value);
        return $this;
    }

    /**
     * @return string|AtomFeed_Api_V1_Text
     */
    public function getTitle() {
        return $this->_title;
    }

    /**
     *
     * @param AtomFeed_Api_V1_Text|string|null $value
     * @return AtomFeed_Api_V1_Entry
     */
    public function setTitle($value) {
        $this->_title = $this->_valueToText($value);
        return $this;
    }

    public function getId() {
        if (!isset($this->_id)) {
            $this->_id = Uuid::uuid5(Uuid::NAMESPACE_URL, $this->getTitle()->getBody())->getUrn();
        }
        return $this->_id;
    }

    public function setId($value) {
        $this->_id = $value;
    }
}