<?php
require_once('lib/Httpful/Bootstrap.php');

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Webservice_Solr
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Webservice_Solr extends Varien_Object
{
    /** @var int */
    public $storeId = 0;

    /**
     * @param $query
     * @return \Httpful\Response|null
     */
    public function suggest($query)
    {
        try {
            $url = $this->_getUrl('suggest') . "?q=" . $query . '&wt=xml&suggest.cfq=' . $this->storeId;
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);

            $response = $request->send();
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }

        return $response;
    }

    /**
     * @param $query
     * @return \Httpful\Response|null
     */
    public function spell($query)
    {
        try {
            $url = $this->_getUrl('spell') . "?spellcheck.q=" . $query;
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);

            $response = $request->send();
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }

        return $response;
    }

    /**
     * @param $document
     * @return \Httpful\Response|null
     */
    public function addDocument($document)
    {
        try {
            $url = $this->_getUrl('update?commit=true');
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::post($url)
                ->body("<add>" . $document . "</add>")
                ->mime('text/xml');

            $response = $request->send();
            $this->setLog('recieve: ' . $response);
            return $response;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }

    /**
     * @param $q
     * @return \Httpful\Response|null
     */
    public function removeDocument($q)
    {
        try {
            $url = $this->_getUrl('update?commit=true');
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::post($url)
                ->body('<delete><query>' . $q . '</query></delete>')
                ->sendsAndExpects('text/xml');

            $response = $request->send();
            $this->setLog('recieve: ' . $response);
            return $response;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }


    /**
     * Durchführen der Suche
     * @param B3it_Solr_Model_Webservice_Output_Query $query
     * @return SimpleXMLElement
     */
    public function query(B3it_Solr_Model_Webservice_Output_Query $query)
    {
        try {
            $url = $this->_getUrl('solrSearch');
            \Httpful\Bootstrap::init();
            $url .= $query->toString();
            $request = \Httpful\Request::get($url);

            $response = $request->send();

            if ($response->code != 200) {
                Mage::throwException(sprintf("SOLR Search query=%s response=%s", $url, $response->body));
            }
            $this->setLog('recieve: ' . $response);

            $obj = json_decode($response->body);

            return $obj;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }

    /**
     * @return bool|null
     */
    public function commit()
    {
        try {
            $url = $this->_getUrl('commit');
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);
            //$this->setLog('send: ' .$url);
            $response = $request->send();
            $this->setLog('recieve: ' . $response);
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
        return true;
    }

    /**
     * @return \Httpful\Response|null
     */
    public function testConnection()
    {
        try {
            $url = $this->_getUrl('ping');
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);
            return $request->send();
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }

    /**
     * @param $method
     * @return string
     */
    protected function _getUrl($method)
    {
        $conn = $this->_getConnection();
        return sprintf("http://%s:%s/%s/%s", $conn['hostname'], $conn['port'], $conn['path'], $method);
    }

    /**
     * @return array
     */
    protected function _getConnection()
    {
        $options = array
        (
            'hostname' => Mage::getStoreConfig('solr_general/solr_connection/server_name', $this->storeId),
            'port' => Mage::getStoreConfig('solr_general/solr_connection/server_port', $this->storeId),
            'path' => Mage::getStoreConfig('solr_general/solr_connection/server_path', $this->storeId),
        );
        return $options;
    }

}
