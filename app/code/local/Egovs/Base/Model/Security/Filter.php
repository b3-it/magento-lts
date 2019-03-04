<?php
/**
 * Model für Barzahlungen
 *
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author		Jan Knipper <j.knipper@web.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
class Egovs_Base_Model_Security_Filter
{
	static private $_enableXMLFilter = true;
	static private $_enableSpecialCharFilter = true;

	public static function enableXMLFilter($mode) {
        	self::$_enableXMLFilter = (bool)$mode;
        	return self::$_enableXMLFilter;
	}

	public static function enableSpecialCharFilter($mode) {
        	self::$_enableSpecialCharFilter = (bool)$mode;
        	return self::$_enableSpecialCharFilter;
	}

	/**
	 * Filter function
	 */
	private static function filter(&$value, $key='') {
		if (self::$_enableSpecialCharFilter) {
			$value = str_replace(array(chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(11), chr(12), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19)), ' ', $value);
			$regex = '/(?:%E(?:2|3)%8(?:0|1)%(?:A|8|9)\w)/i';
			$value = urldecode(preg_replace($regex, null, urlencode($value)));
		}
		if (self::$_enableXMLFilter) {
			$value = strip_tags($value);
			//$value = urldecode(str_replace(array('\\', "\0", "\n", "\r", "'", '"', '\x1a', '\(', '\)'), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z', '\\\(', '\\\)'), urlencode($value)));

			/**
			 * Check if already encoded
			 */
			$value = htmlentities($value, ENT_QUOTES, 'UTF-8', false);

			$value = mb_ereg_replace("&amp;", "&", $value);

			$value = mb_ereg_replace("&szlig;", "ß", $value);
			$value = mb_ereg_replace("&ouml;", "ö", $value);
			$value = mb_ereg_replace("&uuml;", "ü", $value);
			$value = mb_ereg_replace("&auml;", "ä", $value);
			$value = mb_ereg_replace("&Ouml;", "Ö", $value);
			$value = mb_ereg_replace("&Uuml;", "Ü", $value);
			$value = mb_ereg_replace("&Auml;", "Ä", $value);

// 			$value = mb_ereg_replace("&Agrave;","À",$value);
// 			$value = mb_ereg_replace("&Aacute;","Á",$value);
// 			$value = mb_ereg_replace("&Acirc;", "Â",$value);
// 			$value = mb_ereg_replace("&Atilde;","Ã",$value);
// 			$value = mb_ereg_replace("&Auml;",  "Ä",$value);
// 			$value = mb_ereg_replace("&Aring;", "Å",$value);
			$value = mb_ereg_replace("&AElig;", "Æ",$value);
			$value = mb_ereg_replace("&Ccedil;","Ç",$value);
// 			$value = mb_ereg_replace("&Egrave;","È",$value);
// 			$value = mb_ereg_replace("&Eacute;","É",$value);
// 			$value = mb_ereg_replace("&Ecirc;", "Ê",$value);
// 			$value = mb_ereg_replace("&Euml;",  "Ë",$value);
// 			$value = mb_ereg_replace("&Igrave;","Ì",$value);
// 			$value = mb_ereg_replace("&Iacute;","Í",$value);
// 			$value = mb_ereg_replace("&Icirc;", "Î",$value);
// 			$value = mb_ereg_replace("&Iuml;",  "Ï",$value);
			$value = mb_ereg_replace("&ETH;",   "Ð",$value);
// 			$value = mb_ereg_replace("&Ntilde;","Ñ",$value);
// 			$value = mb_ereg_replace("&Ograve;","Ò",$value);
// 			$value = mb_ereg_replace("&Oacute;","Ó",$value);
// 			$value = mb_ereg_replace("&Ocirc;", "Ô",$value);
// 			$value = mb_ereg_replace("&Otilde;","Õ",$value);
// 			$value = mb_ereg_replace("&Ouml;",  "Ö",$value);
// 			$value = mb_ereg_replace("&Oslash;","Ø",$value);
// 			$value = mb_ereg_replace("&Ugrave;","Ù",$value);
// 			$value = mb_ereg_replace("&Uacute;","Ú",$value);
// 			$value = mb_ereg_replace("&Ucirc;", "Û",$value);
// 			$value = mb_ereg_replace("&Uuml;",  "Ü",$value);
// 			$value = mb_ereg_replace("&Yacute;","Ý",$value);
			$value = mb_ereg_replace("&THORN;", "Þ",$value);
// 			$value = mb_ereg_replace("&agrave;","à",$value);
// 			$value = mb_ereg_replace("&aacute;","á",$value);
// 			$value = mb_ereg_replace("&acirc;", "â",$value);
// 			$value = mb_ereg_replace("&atilde;","ã",$value);
// 			$value = mb_ereg_replace("&auml;",  "ä",$value);
// 			$value = mb_ereg_replace("&aring;", "å",$value);
			$value = mb_ereg_replace("&aelig;", "æ",$value);
			$value = mb_ereg_replace("&ccedil;","ç",$value);
// 			$value = mb_ereg_replace("&egrave;","è",$value);
// 			$value = mb_ereg_replace("&eacute;","é",$value);
// 			$value = mb_ereg_replace("&ecirc;", "ê",$value);
// 			$value = mb_ereg_replace("&euml;",  "ë",$value);
// 			$value = mb_ereg_replace("&igrave;","ì",$value);
// 			$value = mb_ereg_replace("&iacute;","í",$value);
// 			$value = mb_ereg_replace("&icirc;", "î",$value);
// 			$value = mb_ereg_replace("&iuml;",  "ï",$value);
			$value = mb_ereg_replace("&eth;",   "ð",$value);
// 			$value = mb_ereg_replace("&ntilde;","ñ",$value);
// 			$value = mb_ereg_replace("&ograve;","ò",$value);
// 			$value = mb_ereg_replace("&oacute;","ó",$value);
// 			$value = mb_ereg_replace("&ocirc;", "ô",$value);
// 			$value = mb_ereg_replace("&otilde;","õ",$value);
// 			$value = mb_ereg_replace("&ouml;",  "ö",$value);
// 			$value = mb_ereg_replace("&oslash;","ø",$value);
// 			$value = mb_ereg_replace("&ugrave;","ù",$value);
// 			$value = mb_ereg_replace("&uacute;","ú",$value);
// 			$value = mb_ereg_replace("&ucirc;", "û",$value);
// 			$value = mb_ereg_replace("&uuml;",  "ü",$value);

			$chars = array ('a', 'e', 'i', 'o', 'u', 'n', 'c', 'y');
			$entities = array ('uml', 'acute', 'circ', 'grave', 'tilde', 'slash', 'ring');

			foreach ($chars as $c) {
				foreach ($entities as $e) {
					$entity = sprintf("&%s%s;", $c, $e);
					$char = html_entity_decode($entity, ENT_QUOTES, 'UTF-8');

					$entityUpper = sprintf("&%s%s;", mb_strtoupper($c, 'UTF-8'), $e);
					$charUpper = html_entity_decode($entityUpper, ENT_QUOTES, 'UTF-8');

					if ($entity != $char) {
						$value = mb_ereg_replace($entity, $char, $value);
					}
					if ($entityUpper != $charUpper) {
						$value = mb_ereg_replace($entityUpper, $charUpper, $value);
					}
				}
			}
		}
		return $value;
	}

	/**
	 * Invokes security checkings on essential variables
	 */
	public static function start() {

		//This settings are distinct from security filter
		ini_set('error_reporting', (int) Mage::getStoreConfig('dev/debug/error_reporting'));
		ini_set('display_errors', (int) Mage::getStoreConfig('dev/debug/display_errors'));
		$file = trim(Mage::getStoreConfig('dev/debug/error_log').'');
		if(strlen($file) > 0)
		{
			ini_set('log_errors', 'On');
			ini_set('error_log', $file);
		}



		/**
		 * Return if filter is disabled in BE
		 */
		if (!Mage::getStoreConfig('dev/debug/security_filter')) return;

		/**
		 * Do some PHP settings
		 */
		/*
		ini_set('session.use_trans_sid', false);
		ini_set('session.use_cookies', true);
		ini_set('session.use_only_cookies', true);
		ini_set('session.cookie_httponly', true);
		*/
		ini_set('expose_php', false);
		ini_set('display_startup_errors', false);
		//ini_set('session.save_path', '/some/path');

		/**
		 * Send header for IE6
		 */
		if (array_key_exists('HTTP_USER_AGENT', $_SERVER) && preg_match('/\bmsie 6/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/\bopera/i', $_SERVER['HTTP_USER_AGENT'])) {
			header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
		}

		/**
   		 * Destroy session if something is wrong
		 */

		/* macht keinen Sinn da $_SESSION == null
		if (!isset($_SESSION['egovs_safe']) || !$_SESSION['egovs_safe'] || ($_SERVER['HTTP_USER_AGENT'] !== $_SESSION['egovs_browser'])) {
			session_start();
			// Löschen aller Session-Variablen.
			$_SESSION = array();

			// Falls die Session gel�scht werden soll, l�schen Sie auch das
			// Session-Cookie.
			// Achtung: Damit wird die Session gel�scht, nicht nur die Session-Daten!
			if (ini_get("session.use_cookies")) {
			    $params = session_get_cookie_params();
			    setcookie(session_name(), '', time() - 42000, $params["path"],
			        $params["domain"], $params["secure"], $params["httponly"]
			    );
			}

			session_destroy();
		}
		*/
		//session_regenerate_id(true);

		/**
		 * Filter GET, POST, COOKIE and REQUEST in frontend only
		 */
		if (!Mage::app()->getStore()->isAdmin() && Mage::getStoreConfig('dev/debug/security_filter') > 0) {
			array_walk_recursive($_POST, array("Egovs_Base_Model_Security_Filter", "filter"));
			array_walk_recursive($_GET, array("Egovs_Base_Model_Security_Filter", "filter"));
			array_walk_recursive($_COOKIE, array("Egovs_Base_Model_Security_Filter", "filter"));
			array_walk_recursive($_REQUEST, array("Egovs_Base_Model_Security_Filter", "filter"));
			Egovs_Base_Model_Security_Filter::filter($_SERVER['PHP_SELF']);
			Egovs_Base_Model_Security_Filter::filter($_SERVER['REQUEST_URI']);
			foreach ($_SERVER as $key => $value) {
				if (preg_match('/^HTTP_.*/', $key)) {
					Egovs_Base_Model_Security_Filter::filter($_SERVER[$key]);
				}
			}
		}
		$app = Mage::app()->getRequest();

	}

}
