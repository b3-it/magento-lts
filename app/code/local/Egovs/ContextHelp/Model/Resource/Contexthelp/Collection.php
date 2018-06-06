<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Model_Resource_Contexthelp_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Model_Resource_Contexthelp_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('contexthelp/contexthelp');
    }

    /**
     * Add filter by store
     *
     * @param int|Mage_Core_Model_Store $store
     * @return Egovs_ContextHelp_Model_Resource_Contexthelp_Collection
     */
    public function addStoreFilter($store)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }
        
        if (!is_array($store)) {
            $store = array($store);
        }
        
        $this->addFilter('store_ids', array('in' => $store), 'public');
        
        return $this;
    }
}
