<?php
require_once('lib/Httpful/Bootstrap.php');

/**
 * @category    B3it
 * @package     B3it_Solr
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
            $url = $this->_getUrl('suggest') . '?q=' . $query . '&wt=xml&suggest.cfq=' . $this->storeId;
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);

            $response = $request->send();
            $this->setLog('Suggest - receive: ' . $response);
            return $response;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }

    /**
     * @param $query
     * @return \Httpful\Response|null
     */
    public function spell($query)
    {
        try {
            $url = $this->_getUrl('spell') . '?spellcheck.q=' . $query;
            \Httpful\Bootstrap::init();
            $request = \Httpful\Request::get($url);

            return $request->send();
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
    }

    /**
     * @param $document
     * @return bool
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
            $this->setLog('Add Document - request: ' . $document);
            $this->setLog('Add Document - receive: ' . $response);

            if ($response->code != 200) {
                return false;
            }
            return true;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return false;
        }
    }

    /**
     * @param $q
     * @return bool
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
            $this->setLog('Remove Document - receive: ' . $response);

            if ($response->code != 200) {
                return false;
            }
            return true;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return false;
        }
    }


    /**
     * Durchführen der Suche
     * @param B3it_Solr_Model_Webservice_Output_Query $query
     * @return SimpleXMLElement|null
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
                Mage::throwException(sprintf('SOLR Search query=%s response=%s', $url, $response->body));
            }

            $this->setLog('Query - request: ' . $url);
            $this->setLog('Query - receive: ' . $response);

            return json_decode($response->body);
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
            $response = $request->send();

            $this->setLog('Commit - request: ' . $url);
            $this->setLog('Commit - receive: ' . $response);
            return true;
        } catch (Exception $ex) {
            Mage::logException($ex);
            return null;
        }
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
        return sprintf('http://%s:%s/%s/%s', $conn['hostname'], $conn['port'], $conn['path'], $method);
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
