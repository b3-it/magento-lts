<?php
class AtomFeed_Api_V1_DateTime extends AtomFeed_Api_V1_Abstract {

    public function isSimple() {
        return true;
    }

    public function __construct($value) {
        $this->setDateTime($value);
    }

    /**
     *
     * @var \DateTime
     */
    protected $dateTime = null;

    public function getDateTime() {
        return $this->dateTime;
    }

    /**
     *
     * @param \DateTime|string|int|null $value
     * @return AtomFeed_Api_V1_DateTime
     */
    public function setDateTime($value = null) {
        if (is_int($value)) {
            $value = new DateTime("@".$value);
        } else if (is_string($value)) {
            $value = new DateTime($value);
        }
        $this->dateTime = $value;
        return $this;
    }

    // simple content element
    protected function _getNodeContent() {
        if (is_null($this->dateTime)) {
            return "";
        }
        return $this->dateTime->format(DateTime::ATOM);
    }
}