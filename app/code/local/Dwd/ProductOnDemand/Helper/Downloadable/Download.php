<?php

/**
 * Class Dwd_ProductOnDemand_Helper_Downloadable_Download
 *
 * @category  Dwd
 * @package   Dwd_ProductOnDemand
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2013 - 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ProductOnDemand_Helper_Downloadable_Download extends Mage_Downloadable_Helper_Download
{
	/**
	 * Retrieve Resource file handle (socket, file pointer etc)
	 *
	 * @return resource
	 */
	protected function _getHandle() {
		if (!$this->_resourceFile) {
			Mage::throwException(Mage::helper('downloadable')->__('Please set resource file and link type.'));
		}
	
		if (is_null($this->_handle)) {
			if ($this->_linkType == self::LINK_TYPE_URL) {
				$_redirects = 0; 
				do {
					$port = 80;
					$this->_urlHeaders = array();
					$errno = false;
					$errstr = '';
					/**
					 * Validate URL
					 */
					$urlProp = parse_url($this->_resourceFile);
					if (!isset($urlProp['scheme'])
						|| (
								strtolower($urlProp['scheme']) != 'http'
								&& strtolower($urlProp['scheme']) != 'https'
						)
					) {
						Mage::throwException(Mage::helper('downloadable')->__('Invalid download URL scheme.'));
					}
					if (!isset($urlProp['host'])) {
						Mage::throwException(Mage::helper('downloadable')->__('Invalid download URL host.'));
					}
					
					$hostname = $urlProp['host'];
					if (strtolower($urlProp['scheme']) == 'https') {
						/*
						 * 20150929::Frank Rochlitzer
						 * PHP < 5.6 unterstützt TLS > 1.0 nur über SSL Transport!
						 * Der TLS Transport untersützt nur TLSv1.0
						 * @see https://bugs.php.net/bug.php?id=65329
						 */
						if (version_compare(phpversion(), '5.6.0', '<')===true) {
							$_baseUrl = 'ssl://'.$urlProp['host'];
						} else {
							$_baseUrl = 'tls://'.$urlProp['host'];
						}
						$port = 443;
					} else {
						$_baseUrl = $urlProp['host'];
					}
		
					if (isset($urlProp['port'])) {
						$port = (int)$urlProp['port'];
					}
					
					$_baseUrl .= ":$port";
		
					$path = '/';
					if (isset($urlProp['path'])) {
						$path = $urlProp['path'];
					}
					$query = '';
					if (isset($urlProp['query'])) {
						$query = '?' . $urlProp['query'];
					}
		
					try {
						$_verifyPeer = Mage::getStoreConfigFlag('catalog/dwd_pod/verfiy_peer');
						if (strtolower($urlProp['scheme']) == 'https') {
							
							if (version_compare(phpversion(), '5.6.0', '<')===true) {
								$context = stream_context_create(
										array(
											'ssl' => array(
													'verify_peer' => $_verifyPeer,
													'capath' => Mage::getStoreConfig('catalog/dwd_pod/ca_path'),
													'disable_compression' => true,
											)
									)
								);
							} else {
								//@see https://wiki.php.net/rfc/improved-tls-defaults
                                /*
                                 * https://www.php.net/manual/de/function.stream-socket-enable-crypto.php
                                 * Constants added in PHP 5.6 :
                                    STREAM_CRYPTO_METHOD_ANY_CLIENT
                                    STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT
                                    STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT
                                    STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT
                                    STREAM_CRYPTO_METHOD_ANY_SERVER
                                    STREAM_CRYPTO_METHOD_TLSv1_0_SERVER
                                    STREAM_CRYPTO_METHOD_TLSv1_1_SERVER
                                    STREAM_CRYPTO_METHOD_TLSv1_2_SERVER

                                    Now, be careful because since PHP 5.6.7, STREAM_CRYPTO_METHOD_TLS_CLIENT (same for _SERVER) no longer means any tls version but tls 1.0 only (for "backward compatibility"...).

                                    Before PHP 5.6.7 :
                                    STREAM_CRYPTO_METHOD_SSLv23_CLIENT = STREAM_CRYPTO_METHOD_SSLv2_CLIENT|STREAM_CRYPTO_METHOD_SSLv3_CLIENT
                                    STREAM_CRYPTO_METHOD_TLS_CLIENT = STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT|STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT|STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT

                                    PHP >= 5.6.7
                                    STREAM_CRYPTO_METHOD_SSLv23_CLIENT = STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT|STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT|STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT
                                    STREAM_CRYPTO_METHOD_TLS_CLIENT = STREAM_CRYPTO_METHOD_TLSv1_0_CLIENT
                                 */
								$context = stream_context_create(
										array(
												'ssl' => array(
														'verify_peer' => $_verifyPeer,
														'capath' => Mage::getStoreConfig('catalog/dwd_pod/ca_path'),
														'disable_compression' => true,
														'capture_session_meta' => TRUE,
														'crypto_method' => STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
														"honor_cipher_order"    => TRUE,
												)
										)
								);
							}
							$this->_handle = stream_socket_client($_baseUrl, $errno, $errstr, ini_get("default_socket_timeout"), STREAM_CLIENT_CONNECT, $context);
						} else {
							$this->_handle = stream_socket_client($_baseUrl, $errno, $errstr);
						}
					} catch (Exception $e) {
						throw $e;
					}
		
					if ($this->_handle === false) {
						Mage::throwException(Mage::helper('downloadable')->__('Cannot connect to remote host, error: %s.', $errstr));
					}
		
					$headers = 'GET ' . $path . $query . ' HTTP/1.0' . "\r\n"
							. 'Host: ' . $hostname . "\r\n"
									. 'User-Agent: Magento ver/' . Mage::getVersion() . "\r\n"
											. 'Connection: close' . "\r\n"
													. "\r\n";
					fwrite($this->_handle, $headers);
		
					while (!feof($this->_handle)) {
						$str = fgets($this->_handle, 1024);
						if ($str == "\r\n") {
							break;
						}
						$match = array();
						if (preg_match('#^([^:]+): (.*)\s+$#', $str, $match)) {
							$k = strtolower($match[1]);
							if ($k == 'set-cookie') {
								continue;
							}
							else {
								$this->_urlHeaders[$k] = trim($match[2]);
							}
						}
						elseif (preg_match('#^HTTP/[0-9\.]+ (\d+) (.*)\s$#', $str, $match)) {
							$this->_urlHeaders['code'] = $match[1];
							$this->_urlHeaders['code-string'] = trim($match[2]);
						}
					}
					
					if (!isset($this->_urlHeaders['code']) || $this->_urlHeaders['code'] != 200) {
						fclose($this->_handle);
						$this->_handle = null;
					}
					
					if (isset($this->_urlHeaders['location']) && (($this->_urlHeaders['code'] >= 300 && $this->_urlHeaders['code'] <= 303) || $this->_urlHeaders['code'] == 307)) {
						$_redirects++;
						$this->_resourceFile = $this->_urlHeaders['location'];
					}
				} while (
						isset($this->_urlHeaders['code'])
						&& (
								($this->_urlHeaders['code'] >= 300
									&& $this->_urlHeaders['code'] <= 303)
								|| $this->_urlHeaders['code'] == 307
							)
						&& $_redirects < 5
				);
				
				if (!isset($this->_urlHeaders['code']) || $this->_urlHeaders['code'] != 200) {
					if (isset($this->_urlHeaders['code'])) {
						Mage::log(sprintf(
								"%sCode %s:\r\nRequest Headers:\r\n%s\r\nResponse Headers:\r\n%s",
								Mage::helper('downloadable')->__('An error occurred while getting the requested content:'),
								$this->_urlHeaders['code'],
								$headers,
								var_export($this->_urlHeaders, true)
							),
							Zend_Log::ERR,
							Egovs_Helper::EXCEPTION_LOG_FILE
						);
					}
					Mage::throwException(Mage::helper('downloadable')->__('An error occurred while getting the requested content. Please contact the store owner.'));
				}
			}
			elseif ($this->_linkType == self::LINK_TYPE_FILE) {
				$this->_handle = new Varien_Io_File();
				if (!is_file($this->_resourceFile)) {
					Mage::helper('core/file_storage_database')->saveFileToFilesystem($this->_resourceFile);
				}
				$this->_handle->open(array('path'=>Mage::getBaseDir('var')));
				if (!$this->_handle->fileExists($this->_resourceFile, true)) {
					Mage::throwException(Mage::helper('downloadable')->__('The file %s does not exist.', $this->_resourceFile));
				}
				$this->_handle->streamOpen($this->_resourceFile, 'r');
			}
			else {
				Mage::throwException(Mage::helper('downloadable')->__('Invalid download link type.'));
			}
		}
		return $this->_handle;
	}
}