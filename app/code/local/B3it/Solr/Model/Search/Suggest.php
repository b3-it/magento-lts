<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Search_Suggest
{
    /**
     * @param $query
     * @return false|string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function query($query)
    {
        /** @var B3it_Solr_Model_Webservice_Solr $solr */
        $solr = Mage::getModel('b3it_solr/webservice_solr');
        $solr->storeId = Mage::app()->getStore()->getId();
        $result = $solr->suggest($query);
        $suggest = array();
        $res = array();

        $lst = $result->body->lst;
        if (isset($lst[1])) {
            $arr = $lst[1]->lst->lst->arr;
            if ($arr->lst)
                foreach ($arr->lst as $a) {
                    $suggest[] = (string)$a->str[0];
                }
        }

        foreach ($suggest as $sug) {
            $res[] = array($sug);
        }

        return json_encode($res);
    }

    /**
     * @param $q
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSecuredQuery($q)
    {
        $q = mb_substr($q, 0, Mage::getStoreConfig('solr_general/search_options/max_query_length', Mage::app()->getStore()->getId()));
        $q = strip_tags(html_entity_decode($q));
        $q = addcslashes($q, '+-!(){}[]^"~*?:\\/|&');
        return urlencode($q);
    }
}
