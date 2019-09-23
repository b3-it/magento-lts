<?php
class B3it_Maintenance_Helper_Data extends Mage_Core_Helper_Abstract {
	
	private static $CONST = array(
		"OfflineType"	=> array(
			array("value" => 0, "label" => 'No'),
			array("value" => 1, "label" => 'Yes'),
			array("value" => 2, "label" => 'Scheduled')
		)
	);
	
	public function getConstValues($id){

		$ret = self::$CONST[$id];
		
		if($id === "OfflineType"){
			foreach($ret as &$val) {
				$val["label"] = Mage::helper('b3it_maintenance')->__($val["label"]);
			}
		}

		return $ret;
	}





    /**
     * Sendet eine Mail mit $body als Inhalt an den Administrator
     *
     * @param string $body    Body der Mail
     * @param string $subject Betreff
     *
     * @return void
     */
    public function sendMailToAdmin($data, $subject="Store Offline Einstellungen geändert") {

//            $mailTo = $this->getAdminMail();
            //$mailTo = explode(';', $mailTo);
//            $mailTo = 'h.koegel@b3-it.de';
            $mailTo = 'server@b3-it.de';


            $body = "";

            foreach($data as $k=>$v) {

                if($k == 'lock'){
                    $v = B3it_Maintenance_Model_Offline::getLabel($v);
                }
                $body .= $k. ": ".$v."\n";
            }

            /* @var $mail Mage_Core_Model_Email */
            $mail = Mage::getModel('core/email');
            $shopName = Mage::getStoreConfig('general/imprint/shop_name');
            $subject.=$shopName;
            $body = sprintf("Webshop: %s\n\n%s", Mage::getBaseUrl(), $body);
            $mail->setBody($body);
            $mailFrom = $this->getGeneralContact();
            $mail->setFromEmail($mailFrom['mail']);
            $mail->setFromName($mailFrom['name']);
            $mail->setToEmail($mailTo);

            $mail->setSubject($subject);
            try {
                $mail->send();
            }
            catch(Exception $ex) {
                $error = Mage::helper('b3itadmin')->__('Unable to send email.');

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
}
