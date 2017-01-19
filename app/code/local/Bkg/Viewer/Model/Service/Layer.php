<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Layer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method string getTitle()
 *  @method setTitle(string $value)
 *  @method string getName()
 *  @method setName(string $value)
 *  @method string getAbstract()
 *  @method setAbstract(string $value)
 *  @method int getParentId()
 *  @method setParentId(int $value)
 *  @method int getServiceId()
 *  @method setServiceId(int $value)
 *  @method string getBbWest()
 *  @method setBbWest(string $value)
 *  @method string getBbEast()
 *  @method setBbEast(string $value)
 *  @method string getBbSouth()
 *  @method setBbSouth(string $value)
 *  @method string getBbNorth()
 *  @method setBbNorth(string $value)
 *  @method string getStyle()
 *  @method setStyle(string $value)
 */
class Bkg_Viewer_Model_Service_Layer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkgviewer/service_layer');
    }
}
