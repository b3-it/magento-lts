<?php
/**
 * 
 *  @category Egovs
 *  @package  Egovs_Isolation
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Block_Adminhtml_Newsletter_Template_Grid extends Mage_Adminhtml_Block_Newsletter_Template_Grid
{
    
	/**
	 * StoreFilter für BE User
	 * @see Mage_Adminhtml_Block_Newsletter_Template_Grid::_prepareCollection()
	 */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceSingleton('newsletter/template_collection')
            ->useOnlyActual();
        
        
        $UserStoreGroups = Mage::helper('isolation')->getUserStoreGroups();
        if($UserStoreGroups)
        {
        	$UserStoreGroups = implode(',', $UserStoreGroups);
        	$collection->getSelect()
        	->where("store_group IN (" .$UserStoreGroups .")");
        	//die($collection->getSelect()->__toString());
        }

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    
}

