<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Model_Contexthelp
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Model_Contexthelp extends Mage_Core_Model_Abstract
{
	protected $_blocks = null;
	protected $_handles = null;
	protected $_storeids = null;

    public function _construct()
    {
        parent::_construct();
        $this->_init('contexthelp/contexthelp');
    }

    protected function _beforeSave()
	{
		if( Mage::app()->getRequest()->getParam('store_id') ) {
			$this->setData('store_ids', implode( ',', Mage::app()->getRequest()->getParam('store_id') ) );
			$this->_storeids = $this->getData('store_ids');
		}

		return parent::_beforeSave();
	}

	protected function _afterLoad()
	{
		if ( $this->getData('store_ids') ) {
			$this->_storeids = explode( ',', $this->getData('store_ids') );
		}
		return parent::_afterLoad();
	}

	public function getStoreId()
	{
		if($this->_storeids == null) {
			$this->_storeids = explode( ',', $this->getData('store_ids') );
		}

		return $this->_storeids;
	}

    public function getBlocks()
    {
    	if($this->_blocks == null){
    		$collection = Mage::getModel('contexthelp/contexthelpblock')->getCollection();
    		$collection->getSelect()->where('parent_id=?',intval($this->getId()))->order('pos');
    		$this->_blocks = $collection->getItems();
    	}

    	return $this->_blocks;
    }
    public function getHandles()
    {
    	if($this->_handles == null){
    		$collection = Mage::getModel('contexthelp/contexthelphandle')->getCollection();
    		$collection->getSelect()->where('parent_id=?',intval($this->getId()));
    		$this->_handles = $collection->getItems();
    	}

    	return $this->_handles;
    }
}
