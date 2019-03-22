<?php
/**
 * Helferklasse, die das Senden von Daten verwaltet
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Curl_Helper
{

    /**
     * Übergibt Daten per curl an eine angegebene URL
     *
     * @param string $url Wo Daten hingesendet werden
     * @param mixed[] $params Array-Daten, die gesendet werden müssen
     *
     * @return String Body des Response
     */
    public static function submit($url, $params) {
        $_config = TKonnekt_SDK_Config::getInstance();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        $urlEnc = http_build_query($params, null, '&');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $urlEnc);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $headers = array('Content-Type: application/x-www-form-urlencoded;charset=utf-8','Expect:');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($_config->getConfig('CURLOPT_SSL_VERIFYPEER')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $_config->getConfig('CURLOPT_SSL_VERIFYPEER'));
        }

        if ($_config->getConfig('CURLOPT_CAINFO')) {
            curl_setopt($ch, CURLOPT_CAINFO, $_config->getConfig('CURLOPT_CAINFO'));
        }

        if ($_config->getConfig('CURLOPT_SSL_VERIFYHOST')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $_config->getConfig('CURLOPT_SSL_VERIFYHOST'));
        }

        if ($_config->getConfig('CURLOPT_CONNECTTIMEOUT')) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $_config->getConfig('CURLOPT_CONNECTTIMEOUT'));
        }

        // Begin Proxy
        if ($_config->getConfig('CURLOPT_PROXY') && $_config->getConfig('CURLOPT_PROXYPORT')) {
            curl_setopt($ch, CURLOPT_PROXY, $_config->getConfig('CURLOPT_PROXY'));
            curl_setopt($ch, CURLOPT_PROXYPORT, $_config->getConfig('CURLOPT_PROXYPORT'));

            if ($_config->getConfig('CURLOPT_PROXYUSERPWD')) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $_config->getConfig('CURLOPT_PROXYUSERPWD'));
            }
        }
        // End Proxy

        if ($_config->getConfig('DEBUG_MODE')) {
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

        $_result = curl_exec($ch);

        if ($_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logRequest(curl_getinfo($ch), $params);
        }
        if ($_result === false || $_config->getConfig('DEBUG_MODE')) {
            TKonnekt_SDK_Debug_Helper::getInstance()->logReply($_result, curl_error($ch));
        }

        if ($_result === false) {
            throw new Exception('cURL: submit failed.');
        }

        curl_close($ch);

        return self::__getHeaderAndBody($_result);
    }

    /**
     * Dekodiert einen Json-String und gibt ein Array zurück
     *
     * @param string $string JSON String
     *
     * @return mixed[] Array eines geparsten Json-Strings
     *
     * @throws Exception Falls string kein gültiger Json-String ist
     */
    public static function getJSONResponseToArray($string) {
        $_json = json_decode($string, true);
        if ($_json !== NULL) {
            return $_json;
        } else {
            throw new Exception('Response is not a valid json string.');
        }
    }

    /**
     * Strip Header-Ccontent
     *
     * @param string $response Server-Response
     *
     * @return mixed[] Header, Body der Serverantwort. Der Header wird als Array geparst.
     */
    private static function __getHeaderAndBody($response) {

        $header = self::http_parse_headers(substr($response, 0, strrpos($response, "\r\n\r\n")));
        $body = substr($response, strrpos($response, "\r\n\r\n") + 4);

        return array($header, $body);
    }

    /**
     * HTTP-Header parsen
     *
     * @param String $header Header
     * @return mixed[] Geparster Header
     */
    private static function http_parse_headers($header) {
        $headers = array();
        $key = '';

        foreach (explode("\n", $header) as $i => $h) {
            $h = explode(':', $h, 2);

            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } elseif (is_array($headers[$h[0]])) {
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1])));
                } else {
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1])));
                }

                $key = $h[0];
            } else {
                if (substr($h[0], 0, 1) == "\t") {
                    $headers[$key] .= "\r\n\t" . trim($h[0]);
                } elseif (!$key) {
                    $headers[0] = trim($h[0]);
                    trim($h[0]);
                }
            }
        }

        return $headers;
    }
} 