<?php
/**
 * Synchronisierungshelperklasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * Hier finden gemeinsam genutzte Synchronisierungen statt.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2015 B3 IT Systeme GmbH <http://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Helper_Sync_BankAccountData extends Mage_Core_Helper_Abstract
{
	const CONFIG_PATH_IMPRINT_IBAN = 'general/imprint/iban';
	const CONFIG_PATH_IMPRINT_BIC = 'general/imprint/swift';
	const CONFIG_PATH_IMPRINT_BANK_NAME = 'general/imprint/bank_name';
	const CONFIG_PATH_IMPRINT_BANK_ACCOUNT_OWNER = 'general/imprint/bank_account_owner';
	const CONFIG_PATH_IMPRINT_BANK_ACCOUNT = 'general/imprint/bank_account';
	const CONFIG_PATH_IMPRINT_BANK_BLZ = 'general/imprint/bank_code_number';
	
	const CONFIG_PATH_PAYMENT_BANK_ACCOUNT_OWNER = 'payment/%s/bankaccountholder';
	const CONFIG_PATH_PAYMENT_BANK_ACCOUNT = 'payment/%s/bankaccountnumber';
	const CONFIG_PATH_PAYMENT_BANK_BLZ = 'payment/%s/sortcode';
	const CONFIG_PATH_PAYMENT_BANK_NAME = 'payment/%s/bankname';
	const CONFIG_PATH_PAYMENT_IBAN = 'payment/%s/bankiban';
	const CONFIG_PATH_PAYMENT_BIC = 'payment/%s/bankbic';
	
	public static $AVAILABLE_PAYMENTS = array('bankpayment', 'openaccount');
	
	public function sync() {
		/* @var $_bankVerbindung Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis */
		$_bankVerbindung = Mage::helper('paymentbase')->leseBankverbindungBewirtschafter();
		
		if (!($_bankVerbindung instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_BankverbindungErgebnis)) {
			throw new Exception($this->__('No bank account information from ePayBL available'));
		}
		
		$msg = $this->__('ePayBL provides no bank account information');
		if (!isset($_bankVerbindung->bank)
			|| !isset($_bankVerbindung->bankverbindung)
		) {
			throw new Exception($msg);
		}
		
		if (!$_bankVerbindung->bankverbindung->getIban()
			||!$_bankVerbindung->bankverbindung->getBic()
			|| empty($_bankVerbindung->bankverbindung->kontoinhaber)
		) {
			throw new Exception($msg);
		}
		
		/* @var $imprint Mage_Core_Model_Config_Data */
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_IBAN, 'path')
		;
		$imprint->setValue($_bankVerbindung->bankverbindung->getIban())
			->setPath(self::CONFIG_PATH_IMPRINT_IBAN)
			->save();
		
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_BIC, 'path')
		;
		$imprint->setValue($_bankVerbindung->bankverbindung->getBic())
			->setPath(self::CONFIG_PATH_IMPRINT_BIC)
			->save();
		
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_BANK_NAME, 'path')
		;
		if (!$_bankVerbindung->bank->getBankname()) {
			$imprint->setValue($_bankVerbindung->bankverbindung->getBankname(false))
				->setPath(self::CONFIG_PATH_IMPRINT_BANK_NAME)
				->save();
		} else {
			$imprint->setValue($_bankVerbindung->bank->getBankname())
				->setPath(self::CONFIG_PATH_IMPRINT_BANK_NAME)
				->save();
		}
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_BANK_ACCOUNT_OWNER, 'path')
		;
		$imprint->setValue($_bankVerbindung->bankverbindung->kontoinhaber)
			->setPath(self::CONFIG_PATH_IMPRINT_BANK_ACCOUNT_OWNER)
			->save();
		
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_BANK_ACCOUNT, 'path')
		;
		$imprint->setValue($_bankVerbindung->bankverbindung->kontoNr)
			->setPath(self::CONFIG_PATH_IMPRINT_BANK_ACCOUNT)
			->save();
		
		$imprint = Mage::getModel('core/config_data')
			->load(self::CONFIG_PATH_IMPRINT_BANK_BLZ, 'path')
		;
		$imprint->setValue($_bankVerbindung->bankverbindung->BLZ)
			->setPath(self::CONFIG_PATH_IMPRINT_BANK_BLZ)
			->save();
		
		$configPaths = array(
				self::CONFIG_PATH_PAYMENT_BANK_ACCOUNT,
				self::CONFIG_PATH_PAYMENT_BANK_ACCOUNT_OWNER,
				self::CONFIG_PATH_PAYMENT_BANK_BLZ,
				self::CONFIG_PATH_PAYMENT_BANK_NAME,
				self::CONFIG_PATH_PAYMENT_IBAN,
				self::CONFIG_PATH_PAYMENT_BIC,
		);
		foreach (self::$AVAILABLE_PAYMENTS as $payment) {
			foreach ($configPaths as $config) {
				/* @var $data Mage_Core_Model_Config_Data */
				$data = Mage::getModel('core/config_data')
					->load(sprintf($config, $payment), 'path')
				;
				if ($data->isEmpty()) {
					continue;
				}
				
				$data->delete();
			}
		}
		
		return $this;
	}
}