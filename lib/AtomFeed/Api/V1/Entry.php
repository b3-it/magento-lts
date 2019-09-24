<?php

use Ramsey\Uuid\Uuid;

class AtomFeed_Api_V1_Entry extends AtomFeed_Api_V1_Abstract {

    protected $_authors = [];
    protected $_contributors = [];
    protected $_categories = [];
    protected $_links = [];

    /**
     * Required
     * @var DateTime|AtomFeed_Api_V1_DateTime
     */
    protected $_updated = null;
    protected $_published = null;

    /**
     * Required generated by title if not set
     * @var string
     */
    protected $_id = null;
    /**
     * Required
     * @var string|AtomFeed_Api_V1_Text
     */
    protected $_title = "";
    protected $_summary = null;
    protected $_content = null;

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

        if (isset($this->_content)) {
            $this->_childToNode("content", $this->_content, $node);
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

        if (isset($this->_published)) {
            $this->_valueToDateTime($this->_published)->buildxml($node, "published");
        }

        $this->_childToNode("title", $this->_title, $node);
        if (isset($this->_summary)) {
            $this->_childToNode("summary", $this->_summary, $node);
        }

        $this->_valueToDateTime($this->getUpdated())->buildxml($node, "updated");

        return parent::_addCommonXML($node);
    }

    public function getPublished() {
        return $this->_published;
    }

    /**
     * @param AtomFeed_Api_V1_DateTime|DateTime|string|null $value
     * @return AtomFeed_Api_V1_Entry
     */
    public function setPublished($value) {
        $this->_published = $this->_valueToDateTime($value);
        return $this;
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

    /**
     * @return string|AtomFeed_Api_V1_Text
     */
    public function getSummary() {
        return $this->_summary;
    }

    /**
     *
     * @param AtomFeed_Api_V1_Text|string|null $value
     * @return AtomFeed_Api_V1_Entry
     */
    public function setSummary($value) {
        $this->_summary = $this->_valueToText($value);
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

    /**
     *
     * @param AtomFeed_Api_V1_Text|string|null $value
     * @return AtomFeed_Api_V1_Entry
     */
    public function setContent($value) {
        $this->_content = $this->_valueToContent($value);
        return $this;
    }


}