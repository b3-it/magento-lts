<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Model_Koenigsteinerschluessel_Kst_value
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getKstId()
 *  @method setKstId(int $value)
 *  @method string getRegion()
 *  @method setRegion(string $value)
 *  @method  getHasTax()
 *  @method setHasTax( $value)
 *  @method  getPortion()
 *  @method setPortion( $value)
 */
class Bkg_RegionAllocation_Model_Koenigsteinerschluessel_Kstvalue extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('regionallocation/koenigsteinerschluessel_kstvalue');
    }
}
