<?php
/**
 * Klasse für gemeinsam genutzte Methoden zur Saferpay-Kommunikation über cURL.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Curl extends Mage_Payment_Model_Method_Abstract
{
	/**
	 * Startet ein cURL - Aufruf an die übergebene URL und liefert das Response zurück
	 * 
	 * Nutzt POST zum senden der Daten
	 * 
	 * @param string  $url 	  Ziel URL
	 * @param array   $fields Parameter für POST
	 * @param boolean $Header true|false
	 * @param boolean $useSSL true|false
	 * 
	 * @return	string Response URL
	 * @throws	Exception
	 */
	public static function getResponse($url, $fields = array(), $Header = false, $useSSL = true) {
		$res = "";
		$curlError = null;
		$curlErrorNo = -1;
		try {
			$cs = curl_init($url);
			if ($useSSL) {
				curl_setopt($cs, CURLOPT_PORT, 443);
				curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, true); // ignore SSL-certificate-check - session still SSL-safe
			} else {
				curl_setopt($cs, CURLOPT_PORT, 80);
			}
			curl_setopt($cs, CURLOPT_HEADER, $Header); // no header in output
			curl_setopt($cs, CURLOPT_RETURNTRANSFER, true); // receive returned characters
			/*
			* 20110319 Frank Rochlitzer:
			* POST funktioniert besser mit vielen Parametern, bei GET kann es zu falschen URLs mit cURL führen
			* Es kann kein Array übergeben werden
			*/
			curl_setopt($cs, CURLOPT_POST, count($fields));
			$urlEnc = http_build_query($fields, null, '&');
			curl_setopt($cs, CURLOPT_POSTFIELDS, $urlEnc);
			
			/*
			 * 20120630 Frank Rochlitzer
			 * Proxy darf nicht an ePayBL Proxyausnahme gebunden sein!
			 * Saferpay hat nicht direkt mit ePayBL zu tun
			 */
			if (Mage::getStoreConfig('web/proxy/use_proxy') == true && Mage::getStoreConfig('web/proxy/use_proxy_saferpay_payments') == true) {
				$host = Mage::getStoreConfig('web/proxy/proxy_name');
				$port = 8080;
				if (strlen(Mage::getStoreConfig('web/proxy/proxy_port')) > 0) {
					$port =  Mage::getStoreConfig('web/proxy/proxy_port');
				}
				curl_setopt($cs, CURLOPT_PROXY, $host . ":" . $port);
				curl_setopt($cs, CURLOPT_HTTPPROXYTUNNEL, true);
				//$this->useProxyAndHTTPS = true;
				$user = Mage::getStoreConfig('web/proxy/proxy_user');
				if (isset($user) && (strlen($user) > 0)) {
					curl_setopt($cs, CURLOPT_PROXYUSERPWD, $user . ':' . Mage::getStoreConfig('web/proxy/proxy_user_pwd'));
				}
			}
			 
			$res = curl_exec($cs);
// 			$curlInfo = curl_getinfo($cs);
			$curlError = curl_error($cs);
			//0 = Kein Fehler
			$curlErrorNo = curl_errno($cs);
			curl_close($cs);
		}
		catch(Exception $ex) {
// 			$curlInfo = curl_getinfo($cs);
			$curlError = curl_error($cs);
			//0 = Kein Fehler
			$curlErrorNo = curl_errno($cs);
			Mage::log(sprintf('paymentbase::CURL Error: %s %s', $curlErrorNo, $curlError), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			curl_close($cs);
			Mage::logException($ex);
			return Mage::getUrl('*/*/failure');
		}

		//Muss an erster Stelle stehen
		if ($curlErrorNo !== 0 || empty($res) || (is_string($res) && strpos($res, 'ERROR:') === 0)) {
			$msg = sprintf('paymentbase::CURL Error: %s %s', $curlErrorNo, $curlError);
			if (!empty($res)) {
				$msg .= "\npaymentbase::Invalid URL:".$res;
			}
			Mage::log($msg, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::helper('paymentbase')->sendMailToAdmin($msg);
			Mage::getSingleton('checkout/session')->addError(Mage::helper('paymentbase')->__('Invalid URL - The webmaster is informed.'));
			return Mage::getUrl('*/*/failure');
		}

		return $res;
	}
}