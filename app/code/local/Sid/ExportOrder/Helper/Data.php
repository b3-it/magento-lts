<?php
/**
 *  ExportOrder Helper
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Helper_Data extends Mage_Core_Helper_Abstract
{

		/**
	 * 
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'Max','email'=>'max@xx.de'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @param array $attachment array(array('filename'=>'xxx.txt','content'=>'abc'))
	 * @return void|Sid_ExportOrder_Helper_Data
	 */
	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0, $attachments = null)
	{
		$templateId = null;
		if(!is_numeric($template)){
			$templateId = ( Mage::getStoreConfig($template, $storeid));
		}
		if($templateId){
			$template = $templateId;
		}
		
		 
		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);
	
		$mailTemplate = Mage::getModel('core/email_template');
		/* @var $mailTemplate Mage_Core_Model_Email_Template */
			
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("framecontract/email/sender_name", $storeid);
		$sender['email'] = Mage::getStoreConfig("framecontract/email/sender_email_address", $storeid);
	
		
		if(strlen($sender['name']) < 2 ){
			$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeid);
		}
		
		if(strlen($sender['email']) < 2 ){
			$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeid);
		}
		
		if(Mage::getStoreConfig("framecontract/email/notify_owner", $storeid))
		{
			$recipients[] = $sender;
		}
		
		$emails = array();
		$names = array();
		
		foreach($recipients as $recipient)
		{
			$emails[] = $recipient['email'];
			$names[] = $recipient['name'];
		}
		
		//Dateien anhängen
		if(isset($attachments))
		{
		
			foreach($attachments as $att)
			{
				
				$attachment = $mailTemplate->getMail()->createAttachment($att['content']);
				$attachment->filename = $att['filename'];
			}
		}
		
		$mailTemplate->setReturnPath($sender['email']);
		$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
		
		try{
			$mailTemplate->sendTransactional(
					$template,
					$sender,
					$emails,
					$names,
					$data,
					$storeid
			);
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
			return false;
		}
	
		$translate->setTranslateInline(true);
	
		return $this;
	}
	
	/**
	 * eine Semahore erzeugen
	 * @param number $delta ein optionaler offset in sekunden
	 * @return mixed
	 */
	public function getSemaphor($delta = 0)
	{
		if (function_exists('microtime')) {
			return microtime(true) + ($delta);
		} else {
			return time() + $delta;
		}
	}
	
	
	
	
	
	/**
	 * Checks the observer's cron expression against time
	 *
	 * Supports $this->setCronExpr('* 0-5,10-59/5 2-10,15-25 january-june/2 mon-fri')
	 *
	 * @param Varien_Event $event
	 * @return boolean
	 */
	public function canSchedule($expr)
	{
		$e = preg_split('#\s+#', $expr, null, PREG_SPLIT_NO_EMPTY);
		if (sizeof($e)<5 || sizeof($e)>6) {
			throw Mage::exception('Sid ExportOrder', 'Invalid cron expression: '.$expr);
		}
		
		
		$d = getdate(Mage::getSingleton('core/date')->timestamp(time()));
	
		$match = $this->matchCronExpression($e[0], $d['minutes'])
		&& $this->matchCronExpression($e[1], $d['hours'])
		&& $this->matchCronExpression($e[2], $d['mday'])
		&& $this->matchCronExpression($e[3], $d['mon'])
		&& $this->matchCronExpression($e[4], $d['wday']);
	
		
		return $match;
	}
	
	public function matchCronExpression($expr, $num)
	{
		// handle ALL match
		if ($expr==='*') {
			return true;
		}
	
		// handle multiple options
		if (strpos($expr,',')!==false) {
			foreach (explode(',',$expr) as $e) {
				if ($this->matchCronExpression($e, $num)) {
					return true;
				}
			}
			return false;
		}
	
		// handle modulus
		if (strpos($expr,'/')!==false) {
			$e = explode('/', $expr);
			if (sizeof($e)!==2) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'match/modulus': ".$expr);
			}
			if (!is_numeric($e[1])) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting numeric modulus: ".$expr);
			}
			$expr = $e[0];
			$mod = $e[1];
		} else {
			$mod = 1;
		}
	
		// handle all match by modulus
		if ($expr==='*') {
			$from = 0;
			$to = 60;
		}
		// handle range
		elseif (strpos($expr,'-')!==false) {
			$e = explode('-', $expr);
			if (sizeof($e)!==2) {
				throw Mage::exception('Mage_Cron', "Invalid cron expression, expecting 'from-to' structure: ".$expr);
			}
	
			$from = $this->getNumeric($e[0]);
			$to = $this->getNumeric($e[1]);
		}
		// handle regular token
		else {
			$from = $this->getNumeric($expr);
			$to = $from;
		}
	
		if ($from===false || $to===false) {
			throw Mage::exception('Mage_Cron', "Invalid cron expression: ".$expr);
		}
	
		return ($num>=$from) && ($num<=$to) && ($num%$mod===0);
	}
	
	public function getNumeric($value)
	{
		static $data = array(
				'jan'=>1,
				'feb'=>2,
				'mar'=>3,
				'apr'=>4,
				'may'=>5,
				'jun'=>6,
				'jul'=>7,
				'aug'=>8,
				'sep'=>9,
				'oct'=>10,
				'nov'=>11,
				'dec'=>12,
	
				'sun'=>0,
				'mon'=>1,
				'tue'=>2,
				'wed'=>3,
				'thu'=>4,
				'fri'=>5,
				'sat'=>6,
		);
	
		if (is_numeric($value)) {
			return $value;
		}
	
		if (is_string($value)) {
			$value = strtolower(substr($value,0,3));
			if (isset($data[$value])) {
				return $data[$value];
			}
		}
	
		return false;
	}

    /**
     * Path with ending DS
     *
     * @return string
     */
	public function getBaseStorePathForCertificates() {
       return Mage::getBaseDir('var') . DS . 'transfer_post' . DS;
    }

    /**
     * @param string  $p12file
     * @param sring   $pwd
     * @param boolean $useCaInfo
     *
     * @return array with resulting file names ['key'] for key file and ['ca'] for CA file if exsits
     */
    public function convertPkcs12ToPem($p12file, $pwd, $useCaInfo) {
        $_certInfo = [];
        $_certStore = null;
        $_result = [];

        if (!file_exists($p12file)) {
            throw new RuntimeException($this->__("The file %s doesn't exists", $p12file));
        }
        if (!$_certStore = file_get_contents($p12file)) {
            throw new RuntimeException($this->__("Can't open certificate store"));
        }

        if (!openssl_pkcs12_read($_certStore, $_certInfo, $pwd)) {
            throw new RuntimeException($this->__("Can't parse certificate storage! Maybe the password is not correct?"));
        }
        if (!isset($_certInfo['cert'], $_certInfo['pkey'])) {
            throw new RuntimeException($this->__("Can't locate public or private key from certificate storage"));
        }

        $_pemFileName = basename($p12file);
        $_path = dirname($p12file);

        $_posOfLastDot = mb_strripos($_pemFileName, '.');
        if ($_posOfLastDot !== false) {
            $_pemFileName = mb_substr($_pemFileName, 0, $_posOfLastDot);
        }
        $_caFileName = "ca".$_pemFileName.'.crt';
        $_pemFileName .= '.cert';

        $_pkey = '';
        /**
         * Die ordnungsgemäße Ausführung dieser Funktion setzt die Installation einer gültigen openssl.cnf-Datei voraus.
         * Für Windows wichtig!
         *  PHP verwendet folgende Logik um die Konfigurationsdatei openssl.cnf zu finden:
         *  Die Umgebungsvariable OPENSSL_CONF wird, falls gesetzt, als Pfad zur Konfigurationsdatei benutzt (den Dateinamen mit eingeschlossen).
         *  Die Umgebungsvariable SSLEAY_CONF wird, falls gesetzt, als Pfad zur Konfigurationsdatei benutzt (den Dateinamen mit eingeschlossen).
         *  PHP sucht die Datei openssl.cnf an dem Ort, der bei der Kompilierung der openssl DLL als Speicherort für Zertifikate angegeben wurde. Üblicherweise ist der Standarddateiname c:\usr\local\ssl\openssl.cnf.
         *
         */
        if (!openssl_pkey_export($_certInfo['pkey'], $_pkey, $pwd)) {
            throw new RuntimeException($this->__("Can't convert private key!"));
        }

        $_data = sprintf("%s\n%s", $_pkey, $_certInfo['cert']);

        $_pemFile = $_path.DS.$_pemFileName;
        if (!file_put_contents($_pemFile, $_data)) {
            throw new RuntimeException($this->__("Can't write new client certificate file!"));
        }
        $_result['key'] = $_pemFile;

        if ($useCaInfo && isset($_certInfo['extracerts'])) {
            $_caFile = $_path.DS.$_caFileName;
            $_data = implode("\n", $_certInfo['extracerts']);
            if (!file_put_contents($_caFile, $_data)) {
                throw new RuntimeException($this->__("Can't write new CA certificate file!"));
            }
            $_result['ca'] = $_caFile;
        }

        return $_result;
    }
}