<?php
/**
 * Redirectblock für Kreditkarte über Saferpay
 *
 * Redirect zu Saferpay
 *
 * @category   	Egovs
 * @package    	Egovs_Saferpay
 * @name       	Egovs_Saferpay_Block_Redirect
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author		René Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Saferpay_Block_Redirect extends Egovs_Paymentbase_Block_Saferpay_Redirect
{
	/**
	 * Modulspezifischer Titel
	 *
	 * @var string
	 */
	protected $_preTitle = 'Kreditkarte';
}
