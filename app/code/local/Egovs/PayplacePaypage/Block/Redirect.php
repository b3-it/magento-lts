<?php
/**
 * Redirectblock für Kreditkarte über PayplacePaypage
 *
 * Redirect zu PayplacePaypage
 *
 * @category   	Egovs
 * @package    	Egovs_PayplacePaypage
 * @name       	Egovs_PayplacePaypage_Block_Redirect
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_PayplacePaypage_Block_Redirect extends Egovs_Paymentbase_Block_Payplace_Redirect
{
	/**
	 * Modulspezifischer Titel
	 *
	 * @var string
	 */
	protected $_preTitle = 'Kreditkarte';
}
