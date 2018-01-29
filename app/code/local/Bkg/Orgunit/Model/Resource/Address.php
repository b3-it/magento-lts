<?php
 /**
  *
  * @category   	Bkg Orgunit
  * @package    	Bkg_Orgunit
  * @name       	Bkg_Orgunit_Model_Resource_Unit
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Orgunit_Model_Resource_Unit extends Mage_Eav_Model_Entity_Abstract
{
    public function _construct()
    {
        $resource = Mage::getSingleton('core/resource');
        $this->setType('bkg_orgunit')->setConnection(
            $resource->getConnection('customer_read'),
            $resource->getConnection('customer_write')
        );
    }

    /**
     * Retrieve default entity attributes
     *
     * @return array
     */
    protected function _getDefaultAttributes()
    {
        return array('entity_type_id', 'name');
    }

}
