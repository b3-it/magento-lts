<?php
/**
 *
 * @category   	Bkg
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Period_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getPos()
 *  @method setPos(int $value)
 *  @method int getPeriodLength()
 *  @method setPeriodLength(int $value)
 *  @method int getRenewalOffset()
 *  @method setRenewalOffset(int $value)
 *  @method string getPeriodUnit()
 *  @method setPeriodUnit(string $value)
 *  @method int getInitialPeriodLength()
 *  @method setInitialPeriodLength(int $value)
 *  @method string getInitialPeriodUnit()
 *  @method setInitialPeriodUnit(string $value)
 */
class Bkg_License_Model_Copy_Period extends Mage_Core_Model_Abstract
{

	
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('bkg_license/copy_period');
	}
	

}
