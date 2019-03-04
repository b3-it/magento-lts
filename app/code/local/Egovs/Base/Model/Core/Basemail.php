<?php
/**
 * Erweitert die Core-Mail Funktion um das Senden über SMTP, Mime-Kompatibilität und UTF-8 Kodierung
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Base_Model_Core_Basemail extends Mage_Core_Model_Abstract {

	protected $_transport = null;
	protected $_mail = null;
	protected $_lastErrorMessage = null;
	protected $_isQueue = false;
	
	protected function _initTransport() {
		$config = array();

		if (Mage::getStoreConfigFlag('system/smtp/use_ssl')) {
			$config['ssl'] = 'tls';
		}

		if (($port = Mage::getStoreConfig('system/smtp/port')) > 0) {
			$config['port'] = $port;
		} else {
			$config['port'] = 25;
		}

		$username = Mage::getStoreConfig('system/smtp/username');
		$passwd = Mage::getStoreConfig('system/smtp/password');
		if (($auth = Mage::getStoreConfig('system/smtp/auth')) != 'NONE' &&
			!empty($username) &&
			!empty($passwd)) {
			$config['auth'] = $auth;
			$config['username'] = $username;
			$config['password'] = $passwd;
		}
		
		//Client host name setzten --> Standard ist sonst localhost
		$hostName = parse_url(Mage::getBaseUrl(), PHP_URL_HOST);
		if ($hostName !== false) {
			$config['name'] = $hostName;
		}

		$mailServer = Mage::getStoreConfig('system/smtp/host');
		if (empty($mailServer)) {
			$mailServer = 'localhost';
		}

		$this->_transport = new Zend_Mail_Transport_Smtp($mailServer, $config);

		return $this;
	}

	/**
	 * Retrieve mail object instance
	 *
	 * @return Zend_Mail
	 */
	public function getMail()
	{
		if (is_null($this->_mail)) {
			$this->_initTransport();
			$this->_mail = new Zend_Mail('utf-8');
			$this->_mail->setHeaderEncoding(Zend_Mime::ENCODING_BASE64);
		}
		return $this->_mail;
	}
	
	/**
	 * Dekodiert einen nach RFC1522 kodierten string.
	 * 
	 * @param string $value
	 * @return bool|string
	 */
	protected function _decode($value)
	{
		if(!is_string($value))
			return false;
		
		if (strpos($value, '=?') === 0) {
			//Encoding entfernen
			$prefix = '=?' . $this->getMail()->getCharset() . '?B?';
			$prefixLen = strlen($prefix);
			if (stripos($value, $prefix) === 0) {
				$value = substr($value, $prefixLen);
			}
			
			if ($this->getMail()->getHeaderEncoding() === Zend_Mime::ENCODING_QUOTEDPRINTABLE) {
				$value = Zend_Mime_Decode::decodeQuotedPrintable($value);
			} else {
				$value = base64_decode($value);
			}
			return $value;
		} elseif (Zend_Mime::isPrintable($value)) {
			return $value;
		} else {
			return false;
		}
	}
	
	/**
	 * Detects the end-of-line character of a string.
	 * 
	 * @param string $str The string to check.
	 * @param string $default Default EOL (if not detected).
	 * 
	 * @return string The detected EOL, or default one.
	 */
	protected function _detectEol($str, $default=''){
		$eols = array(
				"\0x000D000A", // [UNICODE] CR+LF: CR (U+000D) followed by LF (U+000A)
				"\0x000A",     // [UNICODE] LF: Line Feed, U+000A
				"\0x000B",     // [UNICODE] VT: Vertical Tab, U+000B
				"\0x000C",     // [UNICODE] FF: Form Feed, U+000C
				"\0x000D",     // [UNICODE] CR: Carriage Return, U+000D
				"\0x0085",     // [UNICODE] NEL: Next Line, U+0085
				"\0x2028",     // [UNICODE] LS: Line Separator, U+2028
				"\0x2029",     // [UNICODE] PS: Paragraph Separator, U+2029
				"\0x0D0A",     // [ASCII] CR+LF: Windows, TOPS-10, RT-11, CP/M, MP/M, DOS, Atari TOS, OS/2, Symbian OS, Palm OS
				"\0x0A0D",     // [ASCII] LF+CR: BBC Acorn, RISC OS spooled text output.
				"\0x0A",       // [ASCII] LF: Multics, Unix, Unix-like, BeOS, Amiga, RISC OS
				"\0x0D",       // [ASCII] CR: Commodore 8-bit, BBC Acorn, TRS-80, Apple II, Mac OS <=v9, OS-9
				"\0x1E",       // [ASCII] RS: QNX (pre-POSIX)
				//"\0x76",       // [?????] NEWLINE: ZX80, ZX81 [DEPRECATED]
				"\0x15",       // [EBCDEIC] NEL: OS/390, OS/400
				"\r\n",
				"\n",
		);
		$cur_cnt = 0;
		$cur_eol = $default;
		foreach($eols as $eol){
			if(($count = mb_substr_count($str, $eol)) > $cur_cnt){
				$cur_cnt = $count;
				$cur_eol = $eol;
			}
		}
		return $cur_eol;
	}

	public function send(Zend_Mail $mail = null) {
		$this->_lastErrorMessage = null;
		if (is_null($mail)) {
			$mail = $this->getMail();
		} else {
			$this->_mail = $mail;
		}
		
		if ($mail && Mage::getStoreConfigFlag('system/smtp/mail_filter_active')) {
			$filter = Mage::getStoreConfig('system/smtp/mail_filter');
			if (!empty($filter)) {
				$filters = explode($this->_detectEol($filter), $filter);
				if (!$filters) {
					$filters = array($filter);
				}
				$headers = $mail->getHeaders();
				$recipients = $mail->getRecipients();
				$headersTo = array('To', 'Bcc', 'Cc');
				$mail->clearRecipients();
				foreach ($recipients as $recipient) {	
					$_matches = false;
					foreach ($filters as $filter) {
						if (!empty($filter)
							&& preg_match("/$filter/i", $recipient)) {
							$_matches = true;
							break;
						}
					}
					if (!$_matches) {
						Mage::log(
							sprintf('Omitting mail by filter with subject \'%s\' to %s', $this->_decode($mail->getSubject()), $recipient),
							Zend_Log::NOTICE,
							Egovs_Helper::MAIL_LOG,
							true
						);
						//Empfänger entfernen
						foreach ($headersTo as $_recp) {
							if (!isset($headers[$_recp])) {
								continue;
							}
							foreach ($headers[$_recp] as $i => $_to) {
								if (preg_match(sprintf("/%s/i", preg_quote($recipient, '/')), $_to)) {
									unset($headers[$_recp][$i]);
								}
							}
						}
					}
				}
				
				//restliche Empfänger wieder hinzufügen
				foreach ($headersTo as $_recp) {
					if (!isset($headers[$_recp])) {
						continue;
					}
					foreach ($headers[$_recp] as $_to) {
						$_email = null;
						$_name = null;
						
						if (is_array($_to) || is_bool($_to) || !is_string($_to)) {
							continue;
						}
						$_to = explode(' ', $_to);
						if (count($_to) == 1) {
							if (isset($_to[0])) {
								$_email = $_to[0];
								$_email = trim($_email, " <>");
							}
							$_name = '';
						} else {
							if (isset($_to[0])) {
								$_name = trim($_to[0]);
								$_name = empty($_name) ? '' : $_name;
							}
							if (isset($_to[1])) {
								$_email = $_to[1];
								$_email = trim($_email, " <>");
							}
						}
						if (empty($_email)) {
							continue;
						}
						
						switch ($_recp) {
							case 'To':
								$mail->addTo($_email, $_name);
								break;
							case 'Cc':
								$mail->addCc($_email, $_name);
								break;
							case 'Bcc':
								$mail->addBcc($_email, $_name);
								break;
						}
					}
				}
			}
		}
		
		$recipients = $mail->getRecipients();
		if (empty($recipients)) {
			$this->_transport = null;
			$this->_mail = null;
			return $this;
		}
		
		$mail->addHeader('MIME-Version', '1.0');
		
		/*
		 * $mail->getReturnPath() gibt $mail->_from zurück falls leer
		 * Bei Smtpversand wird Returnpath korrekt gesetzt
		 * Bei Sendmail nicht 
		 */
		if (!$mail->getReturnPath()) {
			//TODO : Returnpath aus Config!?
			$mail->setReturnPath($mail->getFrom());
		}

		try {
			if (is_null($this->_transport)) {
				$mail->send(); // Zend_Mail warning..
			} else {
				$mail->send($this->_transport); // Zend_Mail warning..
			}
			if ($mail && Mage::getStoreConfig('system/smtp/log_mails'))
				Mage::log(
						sprintf('Sending mail with subject \'%s\' to %s', $this->_decode($mail->getSubject()), implode('; ', $mail->getRecipients())),
						Zend_Log::NOTICE,
						Egovs_Helper::MAIL_LOG,
						true
				);
		} catch (Exception $e) {
			if ($mail)
				Mage::log(
						sprintf('Sending mail with subject \'%s\' to %s failed, see exception details', $this->_decode($mail->getSubject()), implode('; ', $mail->getRecipients())),
						Zend_Log::ERR,
						Mage::getStoreConfig('dev/log/exception_file')
				);
			Mage::logException($e);
			$this->_lastErrorMessage = $e->getMessage();
			if ($this->getIsQueueProcess()) {
			    throw $e;
            }
		}
		
		$this->_transport = null;
		$this->_mail = null;
		return $this;
	}
	
	public function getLastErrorMessage()
	{
		return $this->_lastErrorMessage;
	}

	public function setIsQueueProcess($isQueue = true) {
	    $this->_isQueue = $isQueue;
    }

    public function getIsQueueProcess() {
	    return $this->_isQueue;
    }
}