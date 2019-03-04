<?php
/**
 * Klasse für LieferAdressen an der ePayBL
 * 
 * @property string(15)  $anrede      Anrede (Optional)
 * @property string(10)  $PLZ		  10 Zeichen
 * @property string(3)   $land		  Land gemäß ISO 3166-1
 * @property string(100) $ort		  Ort
 * @property string(10)  $hausNr      Hausnummer (Optional)
 * @property string(10)  $postfach    Postfach (Optional)
 * @property string(100) $strasse 	  Straße (Optional)
 * @property string(27)  $nachname    Nachname (Optional)
 * @property string(27)  $vorname     Vorname (Optional)
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Webservice_Types_LieferAdresse extends Egovs_Paymentbase_Model_Webservice_Types_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @param string $strasse  Straße
	 * @param string $land     Land
	 * @param string $PLZ      Postleitzahl
	 * @param string $ort      Ort
	 * @param string $hausNr   Hausnummer
	 * @param string $postfach Postfach
	 * 
	 * @return void
	 */
	public function __construct(
			$strasse = null,
			$land = null,
			$PLZ = null,
			$ort = null,
			$hausNr = null,
			$postfach = null) {
		    	
    	if ($strasse != null)
        	$this->strasse = $strasse;
        if ($hausNr != null)
           $this->hausNr = $hausNr;
        if ($hausNr != null)
           $this->postfach = $postfach;
        $this->land = $land;
        $this->PLZ = $PLZ;
        $this->ort = $ort;
        
        parent::__construct();
	}
	
	/**
	 * Liefert die Längenbeschränkungen der Werte
	 *
	 * Längenbeschränkungen:<br/>
	 * <ul>
	 *  <li>land = 3</li>
	 *  <li>hausNr = 10</li>
	 *  <li>postfach = 10</li>
	 *  <li>PLZ = 10</li>
	 *  <li>vorname = 27</li>
	 *  <li>nachname = 27</li>
	 *  <li>Ort = 100</li>
	 *  <li>Strasse = 100</li>
	 *  <li><strong>default</strong> = 1000</li>
	 * </ul>
	 *
	 * @param string $name Parametername
	 *
	 * @return int
	 *
	 * @see Egovs_Paymentbase_Model_Webservice_Types_Abstract::_getParamLength()
	 */
	protected function _getParamLength($name) {
		switch ($name) {
			case 'land':
				$length = 3;
				break;
			case 'hausNr':
			case 'postfach':
			case 'PLZ':
				$length = 10;
				break;
			case 'vorname':
			case 'nachname':
				$length = 27;
				break;
			case 'ort':
			case 'strasse':
				$length = 100;
				break;
			default:
				$length = 1000;
		}
		
		return $length;
	}
}