<?php
/**
 *
 * @category   	Bkg Shapefile
 * @package    	Bkg_Shapefile
 * @name       	Bkg_Shapefile_Model_Shape
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Shapefile_Model_Shape extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_shapefile/shape');
    }
    
    public function setWkt($wkt) {
        $this->setShape(new Zend_Db_Expr("(ST_GeomFromText('".$wkt."'))"));
    }
}