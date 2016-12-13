<?php
/**
 *  Persistenzklasse für Pendelliste
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 

/**
*  @method int getId()
*  @method setId(int $value)
*  @method int getTaskId()
*  @method setTaskId(int $value)
*  @method string getModel()
*  @method setModel(string $value)
*  @method string getTitle()
*  @method setTitle(string $value)
*  @method string getContent()
*  @method setContent(string $value)
*  @method int getStatus()
*  @method setStatus(int $value)
*  @method int getManuell()
*  @method setManuell(int $value)
*  @method  getCreatedTime()
*  @method setCreatedTime( $value)
*  @method  getUpdateTime()
*  @method setUpdateTime( $value)
*  @method int getStoreId()
*  @method setStoreId(int $value)
*/
class B3it_Pendelliste_Model_Pendelliste extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pendelliste/pendelliste');
    }
    
    
    public function clear()
    {
    	$this->getResource()->clear();
    }
}