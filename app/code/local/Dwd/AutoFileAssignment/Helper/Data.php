<?php
/**
 * Basishelperklasse für gemeinsam genutzte Methoden des AFA
 *
 * @category	Dwd
 * @package		Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function runAfa() {
		$assigner = Mage::getSingleton('dwdafa/assigner');
		$assigner->autoAssign();
	}

	/**
	 * Clean expired quotes (cron process)
	 *
	 * @param Varien_Object $context Kontext
	 *
	 * @return Dwd_AutoFileAssignment_Helper_Data
	 */
	public function cleanExpiredDynamicLinks($context = null) {
		if (!$context) {
			$context = new Varien_Object();
		}
		/* @var $extendedLinkResource Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink */
		$extendedLinkResource = Mage::getResourceModel('configdownloadable/extendedlink');
		/* @var $extendedLinks Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection */
		$extendedLinks = Mage::getModel('configdownloadable/extendedlink')->getCollection();
		$extendedLinks->addFieldToSelect('link_id');
		$extendedLinks->addFieldToSelect('link_file_id');
		$extendedLinks->addFieldToFilter('valid_to', array('notnull' => true))
			->addFieldToFilter('valid_to', array('to'=>date("Y-m-d H:i:s", time())))
			->addFieldToFilter('link_type', 'file')
		;

		if ($context->hasExpireDynamicLinksAdditionalFilterFields()) {
			foreach ($context->getExpireDynamicLinksAdditionalFilterFields() as $field => $condition) {
				$extendedLinks->addFieldToFilter($field, $condition);
			}
		}

		$itemsToDelete = $extendedLinks->getItems();
		$linkFileItems = array();
		foreach ($itemsToDelete as $item) {
			if (array_key_exists($item->getLinkFileId(), $linkFileItems)) {
				$linkFileItems[$item->getLinkFileId()] = $linkFileItems[$item->getLinkFileId()] + 1;
			} else {
				$linkFileItems[$item->getLinkFileId()] = 1;
			}
		}
		Mage::log(sprintf('dwdafa::%s Links and %s Files to delete...', count($itemsToDelete), count($linkFileItems)), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		$items = array('delete' => array_keys($itemsToDelete), 'links' => $linkFileItems);
		$extendedLinkResource->deleteItems($items);

		//TODO Purchase müssen aktualisiert werden
		Mage::dispatchEvent('afa_clean_expired_dynamic_links_after', array('deleted' => $items['delete']));

		/* @var $linkPurchased Mage_Downloadable_Model_Resource_Link_Purchased_Item_Collection */
		$linkPurchased = Mage::getResourceModel('downloadable/link_purchased_item_collection');
		$connection = $linkPurchased->getConnection();
		$table = $linkPurchased->getMainTable();
		$select = $linkPurchased->getSelect()
					->reset(Zend_Db_Select::FROM) //Steht im Update für JOINs
					->reset(Zend_Db_Select::COLUMNS) //Muss dann als Spalte => neuer Eintrag eingetragen werden
					->from(false, array('status' => $connection->quote(Mage_Downloadable_Model_Link_Purchased_Item::LINK_STATUS_EXPIRED)))
					->where($connection->prepareSqlCondition(
							$connection->quoteIdentifier('link_id'),
							array('in' => $items['delete'])
						)
					)
		;
		$updateQuery = $connection->updateFromSelect($select, array('lp' => $linkPurchased->getMainTable()));
		Mage::log(sprintf('afa::Expired SQL:%s', $updateQuery), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$connection->query($updateQuery);

		return $this;
	}

	/**
	 * Entfernt die '.lock' Datei falls vorhanden
	 *
	 * @throws Dwd_AutoFileAssignment_Exception
	 *
	 * @return boolean
	 */
	public function unlock() {
		$storagePath = $this->getConfigStorage();
		if (!file_exists($storagePath)) {
            /** @noinspection MkdirRaceConditionInspection */
			if (!mkdir($storagePath, 0777, true)) {
				Mage::throwException(Mage::helper('dwdafa')->__("Can't create %s directory.", $storagePath));
			}
		}
		$unlock = true;

		/* @var $collection Mage_Cron_Model_Resource_Schedule_Collection */
		$collection = Mage::getResourceModel('cron/schedule_collection');
		$collection->addFieldToFilter('job_code', 'dwdafa_autoassign_files')
			->addFieldToFilter('status', Mage_Cron_Model_Schedule::STATUS_RUNNING)
		;
		if ($collection->getSize() < 1) {
			$unlock = false;
		} else {
			$collection->walk('delete');
		}

		$ioObject = new Varien_Io_File();
		$ioObject->open(array('path' => $storagePath));
		$lockFile = '.locked';

		if (!$ioObject->fileExists($lockFile)) {
			$unlock |= false;
		} else {
			if (!$ioObject->streamOpen($lockFile)) {
				$msg = 'Can\'t get lock file, skipping.';
				Mage::log(Mage::helper('dwdafa')->__('dwdassigner::'.$msg), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				throw new Dwd_AutoFileAssignment_Exception(Mage::helper('dwdafa')->__($msg));
			}
			if (!$ioObject->streamLock()) {
				$msg = "Can't get exclusive access for lock file.";
				Mage::log("dwdassigner::$msg", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				throw new Dwd_AutoFileAssignment_Exception(Mage::helper('dwdafa')->__($msg));
			}

			if (!$ioObject->streamUnlock()) {
				Mage::log("dwdassigner::Can't release exclusive access for lock file.", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			}
			if (!$ioObject->streamClose()) {
				Mage::log("dwdassigner::Can't release stream for lock file.", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			}
			if (!$ioObject->rm($lockFile)) {
				Mage::log("dwdassigner::Can't release lock.", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
			$unlock |= true;
		}

		return $unlock;
	}

	/**
	 * Liefert einen Pfad unterhalb von Media, höchstens jedoch Media selbst
	 *
	 * Alles was nicht [:alnum:]ßöäüÖÄÜ._\-\/\\\\] entspricht wird durch _ ersetzt.
	 *
	 * @return string
	 */
	public function getConfigStorage() {
		//Liefert Pfad ohne abschließendes /
		$storagePath = Mage::getBaseDir('media');
		$storageSubPath = Mage::getStoreConfig(Dwd_AutoFileAssignment_Model_Assigner::XML_PATH_STORAGE);
		$configState = Mage::app()->getRequest()->getParam('config_state');
		if (is_array($configState) && array_key_exists('catalog_dwd_afa', $configState) && $configState['catalog_dwd_afa'] == true) {
			$configGroups = Mage::app()->getRequest()->getParam('groups');
			if (array_key_exists('dwd_afa', $configGroups)) {
				$currentConfigStorage = $configGroups['dwd_afa']['fields']['storage']['value'];
				if (strcmp($storageSubPath, $currentConfigStorage) != 0) {
					$storageSubPath = $currentConfigStorage;
				}
			}
		}
		//relative Pfade entfernen
		$storageSubPath = str_ireplace(array('..'.DS, '..'), '', $storageSubPath);
		$storageSubPath = preg_replace("/[^[:alnum:].ßöäüÖÄÜ_\-\/\\\\]/u", '_', $storageSubPath);

		if ((stripos($storageSubPath, DS) === false || stripos($storageSubPath, DS) != 0) && !empty($storageSubPath)) {
			$storagePath = $storagePath.DS.$storageSubPath;
		} else {
			$storagePath = $storagePath.$storageSubPath;
		}

		return $storagePath;
	}

	/**
	 * Sendet eine Mail mit $body als Inhalt an den Administrator
	 *
	 * @param string $body    Body der Mail
	 * @param string $subject Betreff
	 * @param string $module  Modulname für Übersetzungen
	 *
	 * @return void
	 */
	public function sendMailToAdmin($body, $subject="AFA Fehler:", $module="dwdafa") {
		if (strlen($body) < 1) {
			return;
		}

		$mailTo = $this->getAdminSupportMail();
		$mailTo = explode(';', $mailTo);
		if (!$mailTo) {
			$mailTo = array();
		}
		/* @var $mail Mage_Core_Model_Email */
		$mail = Mage::getModel('core/email');
		$shopName = Mage::getStoreConfig('general/imprint/shop_name');
		$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
		$mail->setBody($body);
		$mailFrom = $this->getGeneralContact($module);
		$mail->setFromEmail($mailFrom['mail']);
		$mail->setFromName($mailFrom['name']);
		$mail->setToEmail($mailTo);

		$subject = sprintf("%s::%s", $shopName, $subject);
		$mail->setSubject($subject);
		try {
			$mail->send();
		} catch(Exception $ex) {
			$error = Mage::helper($module)->__('Unable to send email.');

			if (isset($ex)) {
				Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			} else {
				Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			}
		}
	}

	/**
	 * Gibt die Admin-Support-Mailadresse aus der Konfiguration zurück.
	 *
	 * @param string $module Name für Helper
	 *
	 * @return string
	 */
	public function getAdminSupportMail($module = "dwdafa") {
		//trans_email/ident_support/email
		$mail = Mage::getStoreConfig('catalog/dwd_afa/admin_email');
		if (strlen($mail) > 0) {
			return $mail;
		}
		return $this->getCustomerSupportMail();
	}

	/**
	 * Gibt die Kundensupport Mailadresse aus der Kkonfiguration zurück.
	 *
	 * @param string $module Name für Helper
	 *
	 * @return string
	 */
	public function getCustomerSupportMail($module = "dwdafa") {
		//trans_email/ident_support/email
		$mail = Mage::getStoreConfig('trans_email/ident_support/email');
		if (strlen($mail) > 0) {
			return $mail;
		}

		return '';
	}

	/**
	 * Liefert den Allgemeinen Kontakt des Shops als array
	 *
	 * Format:</br>
	 * array (
	 * 	name => Name
	 * 	mail => Mail
	 * )
	 *
	 * @param string $module Modulname
	 *
	 * @return array <string, string>
	 */
	public function getGeneralContact($module = "paymentbase") {
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