<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Resource_Participant_Collection
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Resource_Participant_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected $_selectCount = null;

    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/participant');
    }



    public function setSelectCountSql($select)
    {
        $this->_selectCount = clone($select);
    }



    //workaround
    //gruppierung für Export liefert falsche Ergebnisse beim Zählen
    //#3301
    public function getSelectCountSql()
    {

        if($this->_selectCount == null){
            return parent::getSelectCountSql();
        }

        $sel = $this->_select;
        $filter = $this->_isFiltersRendered;
        $this->_select = $this->_selectCount;

        $this->_renderFilters();

        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);

        $countSelect->columns('COUNT(*)');

        $this->_select = $sel;
        $this->_isFiltersRendered = $filter;
        //$sql = $countSelect->__toString();
        //die($sql);
        return $countSelect;
    }
}
