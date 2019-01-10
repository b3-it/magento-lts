<?php
/**
 * Class Egovs_Base_Helper_Data
 *
 * @category  Egovs
 * @package   Egovs_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Base_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_abbrData = array(
        'inkl.'  => 'inklusive',
        'zzgl.'  => 'zuzüglich',
        'MwSt.'  => 'Mehrwertsteuer',
        'USt.'   => 'Umsatzsteuer',
        'etc.'   => 'und so weiter',
        'etw.'   => 'etwas',
        'VIES'   => 'VAT Information Exchange System',
        'USt.ID' => 'Umsatzsteuer-ID',
        'BZSt'   => 'Bundeszentralamt für Steuern',
        'MIAS'   => 'Mehrwertsteuer-Informationsaustauschsystem',
        'EStG'   => 'Einkommensteuergesetz',
        'nom.'   => 'nominal',
        'p.a.'   => 'per annum',
        //'' => '',

        // Allgemeine Abkürzungen der Deutschen Bank
        //'ann.'   => 'annualisiert',
        //'BaFin'      => 'Bundesanstalt f&uuml;r Finanzdienstleistungsaufsicht',
        //'BDA'        => 'Bundesvereinigung der Arbeitgeberverb&auml;nde',
        //'BdB'        => 'Bundesverband deutscher Banken',
        //'BDI'        => 'Bundesverband der Deutschen Industrie',
        //'BfA'        => 'Bundesversicherungsanstalt f&uuml;r Angestellte',
        //'Bill.'      => 'Billionen',
        //'BIP'        => 'Bruttoinlandsprodukt',
        //'BIZ'        => 'Bank f&uuml;r Internationalen Zahlungsausgleich',
        //'BMF'        => 'Bundesministerium der Finanzen',
        //'BuBa'       => 'Bundesbank',
        //'DAX'        => 'Deutscher Aktienindex',
        //'DIW'        => 'Deutsches Institut f&uuml;r Wirtschaftsforschung',
        //'EBWE'       => 'Europ&auml;ische Bank f&uuml;r Wiederaufbau und Entwicklung',
        //'EG'         => 'Europ&auml;ische Gemeinschaft',
        //'EIB'        => 'Europ&auml;ische Investitionsbank',
        //'EP'         => 'Euro&auml;isches Parlament',
        //'EU'         => 'Europ&auml;ische Union',
        //'EuGH'       => 'Europ&auml;ischer Gerichtshof',
        //'EuRH'       => 'Europ&auml;ischer Rechnungshof',
        //'Eurostat'   => 'Europ&auml;isches Amt der EU',
        //'Euro-STOXX' => 'Europ&auml;ischer Aktienindex',
        //'EZB'        => 'Europ&auml;ische Zentralbank',
        //'HGB'        => 'Handelsgesetzbuch',
        //'HVPI'       => 'Handels- und Verbraucherpreisindex',
        //'H1'         => '1. Halbjahr',
        //'H2'         => '2. Halbjahr',
        //'H3'         => '3. Halbjahr',
        //'H4'         => '4. Halbjahr',
        //'Ifo'        => 'Institut f&uuml;r Wirtschaftsforschung',
        //'IfW'        => 'Institut f&uuml;r Weltwirtschaft',
        //'IWF'        => 'Internationaler W&auml;hrungsfond',
        //'Q1'         => '1. Quartal',
        //'Q2'         => '2. Quartal',
        //'Q3'         => '3. Quartal',
        //'Q4'         => '4. Quartal',
        //'WKM'        => 'Wechselkursmechanismus',
        //'WTO'        => 'Welthandelsorganisation'
    );

	/**
	 * Liefert ein Array von aktiven Bezahlmodulen zurück
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
	 * Dekodiert HTML - Entities zurück in ihre Charakterdarstellung.
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
	 * @param bool   $praefix Soll Faktor 1000 oder 1024 genutzt werden (Kilo vs Kibi)
	 * @param bool   $short   Kurz- oder Langdarstellung
	 *
	 * @return string
	 *
	 * @see http://www.selfphp.info/kochbuch/kochbuch.php?code=61
	 */
	public function binaryHumanReadable($size, $praefix = true, $short = true) {

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
				$norm = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
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
     *
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

    /**
     * Sucht nach Abkürzungen und ersetzt diese durch ein abbr-Tag
     *
     * @param $html
     * @return string
     */
    public function replaceTemplateAbbr($html)
    {
        if (empty($html)) {
            return $html;
        }

        if(stripos($html,'encoding="UTF-8"')=== false) {
            $html = '<?xml encoding="UTF-8">' . $html;
        }
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->substituteEntities = false;
        //loadHTML macht mit UTF-8 Probleme
        $useInternalErrors = libxml_use_internal_errors(true);
        if (!$dom->loadHTML($html, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED | LIBXML_NONET)) {
            $error = error_get_last();
            return $html;
        }
        $errors = "";
        foreach (libxml_get_errors() as $error) {
            /** @var \LibXMLError $error */
            // handle errors here
            //Warning: DOMDocument::loadHTML(): Unexpected end tag : a in Entity, line: 761  in D:\git\magento1.9.x\app\code\local\Egovs\Base\Helper\Data.php on line 267
            $level = "None";
            switch ($error->level) {
                case (LIBXML_ERR_FATAL):
                    $level = "Fatal";
                    break;
                case (LIBXML_ERR_ERROR):
                    $level = "Error";
                    break;
                case (LIBXML_ERR_WARNING):
                    $level = "Warning";
                    break;
            }
            $errors .= sprintf("%s: %s, line: %s\n", $level, trim($error->message), $error->line);
        }
        if (!empty($errors)) {
            $errors = "DOMDocument::loadHTML():\n" . $errors;
            Mage::log($errors, Zend_Log::INFO, Egovs_Helper::LOG_FILE);
        }

        libxml_clear_errors();
        libxml_use_internal_errors($useInternalErrors);

        $xPath = new DOMXPath($dom);
        $matched = false;
        foreach ($this->_abbrData as $key => $val) {
            $nodes = $xPath->query("//text()[normalize-space()][string-length()>0][not(parent::script)][not(parent::p)][not(parent::title)][contains(.,'$key')]");
            $abbr = $dom->createElement('abbr', $key);
            $abbr->setAttribute('title', $val);
            foreach ($nodes as $node) {
                /** @var DOMText $node */
                $pieces = explode($key, $node->textContent);
                $parent = $node->parentNode;
                //Workaround to preserve order
                $newNode = $dom->createDocumentFragment();
                $last = count($pieces)-1;
                foreach ($pieces as $i => $piece) {
                    if (empty($piece)) {
                        if ($i != $last) {
                            //Without clone only the last one is used!
                            $newNode->appendChild(clone $abbr);
                        }
                        continue;
                    }

                    $textNode = $dom->createTextNode($piece);
                    $newNode->appendChild($textNode);

                    if ($i != $last) {
                        //Without clone only the last one is used!
                        $newNode->appendChild(clone $abbr);
                    }
                }
                $parent->replaceChild($newNode, $node);
                $matched = true;
            }
        }
        if ($matched) {
            //saveHTML macht mit ENTITIES und UTF-8 Probleme
            $html = $dom->saveHTML();
        }
        return $html;
    }

    /**
     * Prüft ob die URI in der Proxy-Ausnahmeliste enthalten ist.
     *
     * @param string $uri     URI
     *
     * @return bool
     */
    public static function isUriInProxyExcludeList($uri) {
        $excludeList = null;
        try {
            $excludeList = Mage::getStoreConfig('web/proxy/exclude_list');
        } catch (Exception $e) {
            return false;
        }

        $excludeArray = explode("\n", $excludeList);

        if (empty($excludeArray) || empty($uri)) {
            return false;
        }

        foreach ($excludeArray as $exclude) {
            if (stripos($uri, trim($exclude)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if use of proxy is possible
     *
     * @param $uri
     *
     * @return bool
     */
    public static function canUseProxy($uri) {
        if (Mage::getStoreConfigFlag('web/proxy/use_proxy') && self::getProxyAddress() !== null && !self::isUriInProxyExcludeList($uri)) {
            return true;
        }

        return false;
    }

    /**
     * Get proxy hostname or ip
     *
     * @return null|string
     */
    public static function getProxyAddress() {
        $proxy = (string)Mage::getStoreConfig('web/proxy/proxy_name');
        if (empty($proxy)) {
            return null;
        }

        if (!preg_match_all('/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/', $proxy)) {
            Mage::log("proxy::Invalid proxy address: $proxy", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
            return null;
        }

        return $proxy;
    }

    /**
     * Get proxy port
     *
     * @return int
     */
    public static function getProxyPort() {
        $port = (int)Mage::getStoreConfig('web/proxy/proxy_port');
        if (empty($port) || !is_int($port)|| $port < 1 || $port > 65536) {
            return 80;
        }

        return $port;
    }

    /**
     * Get proxy user name
     *
     * @return null|string
     */
    public static function getProxyUser() {
        $user = (string)Mage::getStoreConfig('web/proxy/proxy_user');
        if (empty($user)) {
            return NULL;
        }

        return $user;
    }

    /**
     * Get proxy password
     *
     * @return null|string
     */
    public static function getProxyPassword() {
        $pwd = (string)Mage::getStoreConfig('web/proxy/proxy_user_pwd');
        if (empty($pwd)) {
            return NULL;
        }

        return $pwd;
    }
}
