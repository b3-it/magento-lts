<?php
/**
 * Sid Import
 *
 *
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import_Model_Storage
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
*  @method int getId()
*  @method setId(int $value)
*  @method int getTask()
*  @method setTask(int $value)
*  @method string getName()
*  @method setName(string $value)
*  @method string getSku()
*  @method setSku(string $value)
*  @method int getStatus()
*  @method setStatus(int $value)
*  @method string getImportdata()
*  @method setImportdata(string $value)
*  @method  getCreatedTime()
*  @method setCreatedTime( $value)
*  @method  getUpdateTime()
*  @method setUpdateTime( $value)
*  @method int getLosId()
*  @method setLosId(int $value)
*  @method string getType()
*  @method setType(string $value)
*  @method string getImportType()
*  @method setImportType(string $value)
*  @method  getPrice()
*  @method setPrice( $value)
*  @method  getUploadTime()
*  @method setUploadTime( $value)
*/

class Sid_Import_Model_Storage extends Mage_Core_Model_Abstract
{
	
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidimport/storage');
    }
}
