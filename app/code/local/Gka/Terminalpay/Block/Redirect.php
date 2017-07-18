<?php
/**
 * Redirectblock für Terminalpay über Saferpay
 *
 * Redirect zu Saferpay
 *
 * @category   	Gka
 * @package    	Gka_Terminalpay
 * @name       	Gka_Terminalpay_Block_Redirect
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * 
 */
class Gka_Terminalpay_Block_Redirect extends Egovs_Paymentbase_Block_Saferpay_Redirect
{
	
	/**
	 * Modulspezifischer Titel
	 * 
	 * @var string
	 */
	protected $_preTitle = 'Terminalpay';
}
