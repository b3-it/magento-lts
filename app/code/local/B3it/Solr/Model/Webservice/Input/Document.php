<?php

/**
 *
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Webservice_Input_Document
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Webservice_Input_Document
{
    /**
     * @var array
     */
    protected $_fields = [];

    /**
     * @param $key
     * @param $value
     */
    public function addField($key, $value)
    {
        // Xml encoding of special characters
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        $this->_fields[] = ['key' => $key, 'value' => $value];
    }

    /**
     * @return string
     */
    public function toXml()
    {
        $res = [];
        $res[] = "<doc>";

        foreach ($this->_fields as $field) {
            $res[] = sprintf('<field name="%s">%s</field>', $field['key'], $field['value']);
        }

        $res[] = "</doc>";
        return implode('', $res);
    }
}
