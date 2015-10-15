<?php

class Egovs_Base_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Liefert ein Array von aktiven Bezahlmodulen zur�ck
	 * 
	 * array(PAYMENT_CODE => PAYMENT_TITLE)
	 * 
	 * @return array
	 */
	public function getActivPaymentMethods()
	{
		$payments = Mage::getSingleton('payment/config')->getActiveMethods();
	
		$methods = array();
	
		foreach ($payments as $paymentCode=>$paymentModel) {
			$paymentTitle = Mage::getStoreConfig('payment/'.$paymentCode.'/title');
			$methods[$paymentCode] = $paymentTitle;
		}
	
		return $methods;	
	}
	
	/**
	 * Dekodiert HTML - Entities zur�ck in ihre Charakterdarstellung.
	 * 
	 * Als charset wird UTF-8 genutzt
	 * 
	 * @param string $string String
	 * 
	 * @return string
	 */
	public function htmlEntityDecode($string) {
		return html_entity_decode($string, ENT_COMPAT, 'UTF-8');
	}
	
	/**
	 * Liefert den Knoten und seine Childs als array
	 * 
	 * Diese Funktion behebt einen Bug bei dem sich gleiche Knoten überschreiben.
	 *
	 * @param Varien_Simplexml_Element $xml         XML Daten
	 * @param bool                     $isCanonical whether to ignore attributes
	 * 
	 * @return array|string
	 * 
	 * @see Varien_Simplexml_Element::_asArray
	 */
	protected function _xmlToArray($xml, $isCanonical = false) {
		$result = array();
		if (!$isCanonical) {
			// add attributes
			foreach ($xml->attributes() as $attributeName => $attribute) {
				if ($attribute) {
					$result['@'][$attributeName] = (string)$attribute;
				}
			}
		}
		// add children values
		if ($xml->hasChildren()) {
			foreach ($xml->children() as $childName => $child) {
				if (!isset($result[$childName])) {
					$result[$childName] = $this->_xmlToArray($child, $isCanonical);
				} else {
					if (!is_array($result[$childName])) {
						$result[$childName] = array($result[$childName]);
					}
					$result[$childName][] = $this->_xmlToArray($child, $isCanonical);
				}
			}
		} else {
			if (empty($result)) {
				// return as string, if nothing was found
				$result = (string) $xml;
			} else {
				// value has zero key element
				$result[0] = (string) $xml;
			}
		}
		return $result;
	}
	
	/**
	 * Liefert den Knoten und seine Childs als array
	 * 
	 * Falls die Knoten Attribute enthalten werden dieses ebenfalls ins Array übernommen.
	 * 
	 * @param Varien_Simplexml_Element $xml XML Daten
	 * 
	 * @return array
	 */
	public function xmlToArray($xml) {
		return $this->_xmlToArray($xml);
	}
	
	/**
	 * Rechnet eine Byte-Größe in eine angemessene Nutzerfreundliche Größe um
	 * 
	 * @param int    $size    Größe in Byte
	 * @param string $praefix Soll Faktor 1000 oder 1024 genutzt werden (Kilo vs Kibi)
	 * @param string $short   Kurz- oder Langdarstellung
	 * 
	 * @return string
	 * 
	 * @see http://www.selfphp.info/kochbuch/kochbuch.php?code=61
	 */
	public function binaryHumanReadable($size, $praefix=true, $short= true) {
	
		if ($praefix === true) {
			if ($short === true) {
				$norm = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
			} else {
				$norm = array(
						'Byte',
						'Kilobyte',
						'Megabyte',
						'Gigabyte',
						'Terabyte',
						'Petabyte',
						'Exabyte',
						'Zettabyte',
						'Yottabyte'
				);
			}
	
			$factor = 1000;
		} else {
			if ($short === true) {
				$norm = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB',
						'EiB', 'ZiB', 'YiB');
			} else {
				$norm = array(
						'Byte',
						'Kibibyte',
						'Mebibyte',
						'Gibibyte',
						'Tebibyte',
						'Pebibyte',
						'Exbibyte',
						'Zebibyte',
						'Yobibyte'
				);
			}
	
			$factor = 1024;
	
		}
	
		$count = count($norm) -1;
	
		$x = 0;
		while ($size >= $factor && $x < $count) {
			$size /= $factor;
			$x++;
		}
	
		$size = sprintf("%01.2f", $size) . ' ' . $norm[$x];
	
		return $size;
	}
	
	/**
	 * ermittelt die im Pfad angegeben Konfiguration der speziellen AdminEMail Adresse
	 * falls diese nicht vorhanden wird auf "'trans_email/ident_admin/email" ausgewichen
	 * @param string $path
	 * @return string Admin EMail Adresse
	 */
	public function getAdminMail($path) {
		$mail = Mage::getStoreConfig($path);
		if (strlen(trim($mail)) > 0) {
			return $mail;
		}
		$mail = Mage::getStoreConfig('trans_email/ident_admin/email');
		if (strlen(trim($mail)) > 0) {
			return $mail;
		}
		
		$mail = Mage::getStoreConfig('trans_email/ident_general/email');
		if (strlen(trim($mail)) > 0) {
			return $mail;
		}
		return "";
	}
	
	
}