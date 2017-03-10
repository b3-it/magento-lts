<?php
class Egovs_Base_Model_Core_Email_Template extends Mage_Core_Model_Email_Template
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
	
	/**
	 * Retrieve mail object instance
	 *
	 * @return Zend_Mail
	 */
	public function getMail()
	{
		if (is_null($this->_mail)) {
			$this->_mail = $this->_getBaseMail()->getMail();
		}
		
		return $this->_mail; 
	}
	
	/**
	 * Entfernt mögliche Kommentare aus dem Templatetext
	 * 
	 * Core Bug behoben: #1136 (ZVM521)
	 * 
	 * @return Egovs_Base_Model_Core_Email_Template
	 * 
	 * @see Mage_Core_Model_Abstract::load()
	 * @see Mage_Core_Model_Email_Template::loadDefault()
	 */
	public function load($id , $field = null) {
		parent::load($id);
		
		$templateText = $this->getTemplateText();
		
		if (preg_match('/<!--@subject\s*(.*?)\s*@-->/u', $templateText, $matches)) {
			$this->setTemplateSubject($matches[1]);
			$templateText = str_replace($matches[0], '', $templateText);
		}
		
		if (preg_match('/<!--@vars\s*((?:.)*?)\s*@-->/us', $templateText, $matches)) {
			$this->setData('orig_template_variables', str_replace("\n", '', $matches[1]));
			$templateText = str_replace($matches[0], '', $templateText);
		}
		
		if (preg_match('/<!--@styles\s*(.*?)\s*@-->/s', $templateText, $matches)) {
			$this->setTemplateStyles($matches[1]);
			$templateText = str_replace($matches[0], '', $templateText);
		}
		
		/**
		 * Remove comment lines
		 */
		$templateText = preg_replace('#\{\*.*\*\}#suU', '', $templateText);
		/**
		 * Remove empty lines from beginning
		 */
		$templateText = preg_replace('/^\n+|^[\t\s]*\n+/','',$templateText);
		
		$this->setTemplateText($templateText);
		
		return $this;
	}

	/**
     * Send mail to recipient
     *
     * @param array|string      $email     E-mail(s)
     * @param array|string|null $name      receiver name(s)
     * @param array             $variables template variables
     * 
     * @return  boolean
     **/
	public function send($email, $name=null, array $variables = array())
	{
		if(!$this->getTemplateSubject())
		{
			$this->setTemplateSubject(Mage::app()->getStore()->getName());
		}
		if (!$this->isValidForSend()) {
			if (!Mage::getStoreConfigFlag('system/smtp/disable'))
			{
				$msg = sprintf('This letter cannot be sent. Sendername: %s, Senderemail: %s, Subject: %s', $this->getSenderName(), $this->getSenderEmail(), $this->getTemplateSubject());
            	Mage::logException(new Exception($msg)); 
			}
            return false;
        }

        $emails = array_values(is_array($email) ? $email : array($email));
        $names = is_array($name) ? $name : (array)$name;
        $names = array_values($names);
        foreach ($emails as $key => $em) {
            if (!isset($names[$key])) {
                $names[$key] = substr($em, 0, strpos($em, '@'));
            }
        }

        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);
        $variables['now'] = date('d.m.Y');

// 		ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
// 		ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));



		$this->setUseAbsoluteLinks(true);
		$text = $this->getProcessedTemplate($variables, true);
		$subject = $this->getProcessedTemplateSubject($variables);

		
		
		$setReturnPath = Mage::getStoreConfig(Mage_Core_Model_Email_Template::XML_PATH_SENDING_SET_RETURN_PATH);
		switch ($setReturnPath) {
			case 1:
				$returnPathEmail = $this->getSenderEmail();
				break;
			case 2:
				$returnPathEmail = Mage::getStoreConfig(Mage_Core_Model_Email_Template::XML_PATH_SENDING_RETURN_PATH_EMAIL);
				break;
			default:
				$returnPathEmail = null;
				break;
		}
		
		if ($this->hasQueue() && $this->getQueue() instanceof Mage_Core_Model_Email_Queue) {
			/** @var $emailQueue Mage_Core_Model_Email_Queue */
			$emailQueue = $this->getQueue();
			$emailQueue->setMessageBody($text);
			$emailQueue->setMessageParameters(array(
					'subject'           => $subject,
					'return_path_email' => $returnPathEmail,
					'is_plain'          => $this->isPlain(),
					'from_email'        => $this->getSenderEmail(),
					'from_name'         => $this->getSenderName(),
					'reply_to'          => $this->getMail()->getReplyTo(),
					'return_to'         => $this->getMail()->getReturnPath(),
			))
			->addRecipients($emails, $names, Mage_Core_Model_Email_Queue::EMAIL_TYPE_TO)
			->addRecipients($this->_bccEmails, array(), Mage_Core_Model_Email_Queue::EMAIL_TYPE_BCC);
			$emailQueue->addMessageToQueue();
		
			return true;
		}
		
		
		$mail = $this->getMail();
		$adr = $this->_normalizeNamesEmail($emails, $names);
		if (count($adr) > 1) {
			foreach ($adr as $emailOne) {
				$mail->addTo($emailOne['email'], empty($emailOne['name']) ? '' : '=?utf-8?B?'.base64_encode($emailOne['name']).'?=');
			}
		} else {
			$mail->addTo($adr[0]['email'], empty($adr[0]['name']) ? '' : '=?utf-8?B?'.base64_encode($adr[0]['name']).'?=');
		}
		
		/*
         * 20111220:Frank Rochitzer
         * Mails werden jetzt als Multipart-Content versendet
         * @see http://www.magentocommerce.com/boards/viewthread/25075/P15/
         * Kommentar von: _wookie_ (2010-06-14)
         */
        if ($this->isPlain()) {
        	/*
        	 * Zend_Mime::ENCODING_QUOTEDPRINTABLE ist der Default-Wert,
        	 * dieser darf nach RFC1521 aber nur ASCII enthalten!
        	 */
            $mail->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($text), null, Zend_Mime::ENCODING_BASE64);
        } else {
        	$boundary = '--END_OF_HTML_MAIL';
        	$boundaryLocation = strpos($text, $boundary);
        	if ($boundaryLocation) {
        		$shtml = substr($text, 0, $boundaryLocation);
        		$stext = str_replace($boundary, '', substr($text, $boundaryLocation));
        		$stext = trim(strip_tags($stext));
        		$mail->setBodyText(Mage::helper('egovsbase')->htmlEntityDecode($stext), null, Zend_Mime::ENCODING_BASE64);
        		$mail->setBodyHTML($shtml);
        	} else {
        		/*
        		 * 28.06.2012::Frank Rochlitzer 
        		 * Codierung ist notwendig, da Mail sonst nicht korrekt als Multipart content gesendet wird
        		 */
        		$mail->setBodyText(Mage::helper('egovsbase')->__('This mail is in HTML format, please use an HTML ready mail client.'), null, Zend_Mime::ENCODING_BASE64);
        		$mail->setBodyHTML($text);
        	}
        }

		$mail->setSubject('=?utf-8?B?'.base64_encode($this->getProcessedTemplateSubject($variables)).'?=');
		$mail->setFrom($this->getSenderEmail(), '=?utf-8?B?'.base64_encode($this->getSenderName()).'?=');

		try {
			$this->_getBaseMail()->send();
			
			$this->_mail = null;
		}
		catch (Exception $e) {
			Mage::logException($e);
			return false;
		}

		return true;
	}
	
	/**
	 * Normalisiert E-Mail und Namen
	 * 
	 * @param string $email E-Mailadresse
	 * @param string $name  Name
	 * 
	 * @return array
	 */
	protected function _normalizeNamesEmail($email, $name) {
		$res = array();

		$e = array();
		if (is_array($email)) {
			foreach ($email as $em) {
				$e[] = $em;
			}
		} else {
			$e[] = $email;
		}	
	
		$n = array();
		if (is_array($name)) {
			foreach ($name as $na) {
				$n[] = $na;
			}
		} else {
			$n[] = $name;
		}	
				
		$cn = count($n);
		$ce = count($e);
		
		$m = max($cn, $ce);
		$email = "";
		$name = "";
		
		for ($i = 0; $i < $m; $i++) {
			if ($i < $ce) {
				$email = $e[$i];
			}
			if ($i < $cn) {
				$name = $n[$i];
			}
			$res[] = array("name" => $name,"email" => $email);
		}
		
		return $res;
	}
	
	protected function _applyInlineCss($html) {
		try {
			// Check to see if the {{inlinecss file=""}} directive set a CSS file to inline
			$inlineCssFile = $this->getInlineCssFile();
			// Only run Emogrify if HTML exists
			if (strlen($html) && $inlineCssFile) {
				$cssToInline = $this->_getCssFileContent($inlineCssFile);
				$emogrifier = new Pelago\Emogrifier();
				$emogrifier->setHtml($html);
				$emogrifier->setCss($cssToInline);
				// Don't parse inline <style> tags, since existing tag is intentionally for no-inline styles
				$emogrifier->disableInlineStyleAttributesParsing();
		
				$processedHtml = $emogrifier->emogrify();
			} elseif (strlen($html)) {
				if (preg_match('/<!--@styles\s*(.*?)\s*@-->/s', $html, $matches)) {
					$this->setTemplateStyles($matches[1]);
					$html = str_replace($matches[0], '', $html);
					$this->setTemplateText($html);
				}
				
				//Styles in HEAD einfügen
				if ($this->getTemplateStyles()) {
					$dom = new DOMDocument();
					if ($dom->loadHTML($this->getTemplateText())) {
						$domElements = $dom->getElementsByTagName('head');
						$head = null;
						if ($domElements && $domElements->length > 0) {
							$head = $domElements->item(0);
						} else {
							$domElements = $dom->getElementsByTagName('html');
							if ($domElements && $domElements->length > 0) {
								$head = $dom->createElement('head');
								$body = $dom->getElementsByTagName('body');
								if ($body && $body->length > 0) {
									$body = $body->item(0);
								} else {
									$body = null;
								}
								$head = $domElements->item(0)->insertBefore($head, $body);
							}
						}
				
						if ($head) {
							$style = $dom->createElement('style', $this->getTemplateStyles());
							$style->setAttribute('type', 'text/css');
							$head->appendChild($style);
							$html = $dom->saveHTML();
						}
					}
				}
				$processedHtml = $html;
			} else {
				$processedHtml = $html;
			}
		} catch (Exception $e) {
			$processedHtml = '{CSS inlining error: ' . $e->getMessage() . '}' . PHP_EOL . $html;
		}
		return $processedHtml;
	}
}