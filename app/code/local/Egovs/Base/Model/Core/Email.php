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
class Egovs_Base_Model_Core_Email extends Mage_Core_Model_Email
{
	
	protected $_baseMail = null;
	
	/**
	 * Get the base mail instance
	 *
	 * @return Egovs_Base_Model_Core_Basemail
	 */
	protected function _getBaseMail() {
		if (is_null($this->_baseMail)) {
			$this->_baseMail = Mage::getModel('egovsbase/core_basemail');
		}
	
		return $this->_baseMail;
	}
	
	public function send()
	{
		if (Mage::getStoreConfigFlag('system/smtp/disable')) {
			return $this;
		}
		
		$mail = $this->_getBaseMail()->getMail();
	
		if (strtolower($this->getType()) == 'html') {
			/*
			 * 28.06.2012::Frank Rochlitzer
			 * Codierung ist notwendig, da Mail sonst nicht korrekt als Multipart content gesendet wird
			 */
			$mail->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
			$mail->setBodyHtml($this->getBody());
		} else {
			$mail->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($this->getBody()), null, Zend_Mime::ENCODING_BASE64);
		}
	
		$toName = $this->getToName();
		$fromName = $this->getFromName();
		$toEmail = $this->getToEmail();
		
		if (is_array($toEmail)) {
			foreach ($toEmail as $n => $recipient) {
				if (is_int($n) || mb_stripos($n, '=?utf-8?B?') === 0) {
					continue;
				}
				
				$name = sprintf("=?utf-8?B?%s?=", base64_encode($n));
				//Alten Eintrag löschen
				unset($toEmail[$n]);
				$toEmail[$name] = $recipient;
			}
		}
		$mail->setFrom($this->getFromEmail(), empty($fromName) ? '' : '=?utf-8?B?'.base64_encode($this->getFromName()).'?=')
			->addTo($this->getToEmail(), empty($toName) ? '' : '=?utf-8?B?'.base64_encode($this->getToName()).'?=')
			->setSubject('=?utf-8?B?'.base64_encode($this->getSubject()).'?=')
		;
		
		$this->_getBaseMail()->send();
	
		return $this;
	}
}