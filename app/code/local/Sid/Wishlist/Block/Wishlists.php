<?php
/**
 * Block zur Auswahl eines Merkzettels
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Block_Wishlists extends Sid_Wishlist_Block_Wishlist_Abstract
{
	/**
	 * Liefert die SelectBox als HTML zurück
	 * 
	 * @return string
	 */
	public function getSelectBoxHtml() {
		
        if (!$this->isCustomerLoggedIn()) {
        	return '';
        }
        $options = array();
        $defaultId = 0;
        
        if ($this->getWishlists()) {
	        foreach ($this->getWishlists()->getItems() as $wishlist) {
	        	$options[] = array(
	        			'value'=>$wishlist->getId(),
	        			'label'=>$wishlist->getName()
	        	);
	        	
	        	if ($wishlist->getIsDefault() == 1) {
	        		$defaultId = $wishlist->getId();
	        	}
	        }
        }

        $select = $this->getLayout()->createBlock('core/html_select')
	        ->setName('wishlist_id')
	        ->setId('wishlist-select')
	        ->setClass('wishlist-select')
        ;
        
        if (isset($defaultId)) {
        	$select->setValue($defaultId)
        		->setOptions($options)
        	;
        }
        $select->addOption('add', Mage::helper('sidwishlist')->__('New Collector List'));

        return $select->getHtml();
    }
	
    /**
     * URL für Post Aktion
     * 
     * @return string
     */
	public function getPostActionUrl() {
		return $this->getUrl('*/*/addPost', array('_secure'=>true));
	}
	
	/**
	 * URL für Zurück
	 * 
	 * @return string
	 */
	public function getBackUrl() {
		return $this->getUrl('*/*/backFromAdd', array('_secure'=>true));
	}
}