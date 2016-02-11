<?php
/**
 * Source für Typ der SEPA Mandatsverwaltung
 *
 * @category	Egovs
 * @package		Egovs_SepaDebitSax
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_SepaDebitSax_Model_Adminhtml_System_Config_Source_Management extends Egovs_Paymentbase_Model_System_Config_Source_Management
{
	/**
	 * Payment Model-Klasse
	 * 
	 * @var string
	 */
	protected $_modelClassName = 'sepadebitsax/sepadebitsax';
}
