<?php
/**
 *
 *  Ids Observer
 *  @category B3It
 *  @package  B3it_Admin_Model_Observer
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2015 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


/**
 * test mit ?test='%20OR%201=1--
 */



use IDS\Init;
use IDS\Monitor;

require_once('IDS'.DS.'Init.php');
require_once('IDS'.DS.'Monitor.php');
//require_once('tcpdf.php');

class B3it_Ids_Model_IdsComponent extends Varien_Object
{
	
	private $threshold = array(
			'log'      => 3,
			'mail'     => 9,
			'deny'     => 81
	);
	
	
	public function detect($data)
	{
		
		$init = Init::init(Mage::getBaseDir('lib').DS.'IDS' . '/Config/Config.ini.php');
		if($init)
		{
			$init->config['General']['base_path'] = Mage::getBaseDir('lib').DS.'IDS'.DS ;
			$init->config['General']['filter_path'] = Mage::getBaseDir('lib').DS.'IDS'.DS.'default_filter.xml' ;
			$init->config['General']['tmp_path'] = Mage::getBaseDir('var').DS.'ids'.DS ;
			
			$init->config['General']['use_base_path'] = false;
			
			$init->config['Caching']['caching'] = 'none';
			/*Mage_Core_Controller_Request_Http */
			$rq = $data->getRequest();
			
			$path = explode('/', trim($data->getRequest()->getPathInfo(), '/'));
			
			$request = array(
					'REQUEST' => $_REQUEST,
					'GET' => $_GET,
					'POST' => $_POST,
					'COOKIE' => $_COOKIE,
					'PATH' => $path
			);
			
			
			$ids = new Monitor($init);			
			$result = $ids->run($request);
			
			if($result)
			{
				if (!$result->isEmpty()) {
					
					//echo $result;
					$reaction = $this->react($result);
					if(isset($reaction['log'])){
						$this->log($result,$reaction);
					}
					if(isset($reaction['mail'])){
						$this->mail($result,$reaction);
					}
					if(isset($reaction['deny'])){
						
						die('Deny4You');
					}
			}	
			}
		}
			
	}
	
	
	
	private function log($result, $reaction)
	{
		
			$ip = ($_SERVER['SERVER_ADDR'] != '127.0.0.1') ?
			$_SERVER['SERVER_ADDR'] :
			(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
					$_SERVER['HTTP_X_FORWARDED_FOR'] :
					'127.0.0.1');
				
			foreach ($result as $event) {
				$data = array(
						'name'      => $event->getName(),
						'value'     => mysql_escape_string(stripslashes($event->getValue())),
						'page'      => $_SERVER['REQUEST_URI'],
						//'userid'    => $user,
						'session'   => session_id() ? session_id() : '0',
						'ip'        => $ip,
						'reaction'  => implode(', ',$reaction),
						//'impact'    => $result->getImpact()
						'impact'    => $event->getImpact()
				);
				$ids = Mage::getModel('b3it_ids/idsEvent');
				$ids->setData($data);
				$ids->save();
				foreach ($event->getFilters() as $filter) {
					$idsfilter = Mage::getModel('b3it_ids/idsEventFilter');
					$idsfilter->setEventId($ids->getId());
					$idsfilter->setDescription($filter->getDescription());
					$idsfilter->setImpact($filter->getImpact());
					$idsfilter->setTags(implode(', ', $filter->getTags()));
					$idsfilter->setRuleId($filter->getId());
					$idsfilter->save();
						
				}
			}
			
			
			if(isset($reaction['deny'])){		
				Mage::log("DENY : ".$ip,Zend_Log::ALERT,"ids.log",true);
			}
	}
	
	private function mail($result, $reaction)
	{
	
		$ip = ($_SERVER['SERVER_ADDR'] != '127.0.0.1') ?
		$_SERVER['SERVER_ADDR'] :
		(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ?
				$_SERVER['HTTP_X_FORWARDED_FOR'] :
				'127.0.0.1');
	
		
		$msg = array();
		$msg[] ="IP: ".$ip; 
		
		foreach ($result as $event) {
			$data = array(
					'name'      => $event->getName(),
					'value'     => mysql_escape_string(stripslashes($event->getValue())),
					'page'      => $_SERVER['REQUEST_URI'],
					//'userid'    => $user,
					'session'   => session_id() ? session_id() : '0',
					'ip'        => $ip,
					'reaction'  => implode(', ',$reaction),
					//'impact'    => $result->getImpact()
					'impact'    => $event->getImpact()
			);
			$msg[] = 'page' .$_SERVER['REQUEST_URI'];
			$msg[] = 'reaction' .implode(', ',$reaction);
			
			$msg = impolde(', ',$msg);
			$this->sendMailToAdmin($msg);
		}
			
			
		if(isset($reaction['deny'])){
			Mage::log("DENY : ".$ip,Zend_Log::ALERT,"ids.log",true);
		}
	}
	
	
	private function react($result)
	{
		$res = array();
	
		$impact = $result->getImpact();
		
		
		if ($impact >= $this->threshold['deny']) {
			$res['log'] = 'log';
			$res['email'] = 'email';
			$res['deny'] = 'deny';
			return $res;
		} elseif ($impact >= $this->threshold['mail']) {
			$res['log'] = 'log';
			$res['email'] = 'email';
			return $res;
		} elseif ($impact >= $this->threshold['log']) {
			$res['log'] = 'log';
			return $res;
		} 
		
		return $res;
	}
	
	public function sendMailToAdmin($body, $subject="IDS Alert") 
	{
		
			$mailTo = $this->getAdminMail();
			$mailTo = explode(';', $mailTo);
			/* @var $mail Mage_Core_Model_Email */
			$mail = Mage::getModel('core/email');
			$shopName = Mage::getStoreConfig('general/imprint/shop_name');
			$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
			$mail->setBody($body);
			$mailFrom = $this->getGeneralContact($module);
			$mail->setFromEmail($mailFrom['mail']);
			$mail->setFromName($mailFrom['name']);
			$mail->setToEmail($mailTo);
	
			
			$mail->setSubject($subject);
			try {
				$mail->send();
			}
			catch(Exception $ex) {
				$error = Mage::helper($module)->__('Unable to send email.');
	
				if (isset($ex)) {
					Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				} else {
					Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				}
	
				//TODO: Im Frontend sollte diese Meldung nicht zu sehen sein!
				//Mage::getSingleton('core/session')->addError($error);
			}
	}
	
	private function getGeneralContact() {
		/* Sender Name */
		$name = Mage::getStoreConfig('trans_email/ident_general/name');
		if (strlen($name) < 1) {
			$name = 'Shop';
		}
		/* Sender Email */
		$mail = Mage::getStoreConfig('trans_email/ident_general/email');
		if (strlen($mail) < 1) {
			$mail = 'dummy@shop.de';
		}
	
		return array('name' => $name, 'mail' => $mail);
	}
	
	private  function getAdminMail() {
		$mail = Mage::getStoreConfig('trans_email/ident_admin/email');
		if (strlen($mail) > 0) {
			return $mail;
		}
		return  Mage::getStoreConfig('trans_email/ident_support/email');
	}

}