<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Components_Storage_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Model_Components_Storage extends Bkg_VirtualGeo_Model_Components_Abstract
{
    protected $_component_type  = 'virtualgeo/components_storage';
    protected $_component_table = 'virtualgeo/components_storage_product';
	protected $_component_colid = 'storage_id';
}
