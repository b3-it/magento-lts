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
class Sid_Wishlist_Block_Overview extends Sid_Wishlist_Block_Wishlist_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	
		$this->getWishlists()
			->setOrder('created_at', 'desc')
		;
	
		Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('root')->setHeaderTitle(Mage::helper('sidwishlist')->__('My Collector Lists'));
	}
	
	/**
	 * Layout vorbereiten
	 * 
	 * @return Sid_Wishlist_Block_Overview
	 * @see Mage_Core_Block_Abstract::_prepareLayout()
	 */
	protected function _prepareLayout() {
		parent::_prepareLayout();
	
		$pager = $this->getLayout()->createBlock('page/html_pager', 'sid.collector.list.pager')
			->setCollection($this->getWishlists());
		$this->setChild('pager', $pager);
// 		$this->getWishlists()->loadData();
		return $this;
	}
	
	/**
	 * Liefert den Pager als HTML
	 * 
	 * @return string
	 */
	public function getPagerHtml() {
		return $this->getChildHtml('pager');
	}
	
	/**
	 * Liefert die URL für die Ansicht
	 * 
	 * @param Sid_Wishlist_Model_Quote $list Merkzettel
	 * 
	 * @return string
	 */
	public function getViewUrl($list) {
		return $this->getUrl('*/*/view', array('id' => $list->getId()));
	}
	
	/**
	 * Liefert die URL zum Löschen
	 *
	 * @param Sid_Wishlist_Model_Quote $list Merkzettel
	 *
	 * @return string
	 */
	public function getDeleteUrl($list) {
		return $this->getUrl('*/*/delete', array('id' => $list->getId()));
	}
	
	/**
	 * Liefert die URL für Zurück
	 * 
	 * @return string
	 */
	public function getBackUrl() {
		return $this->getUrl('customer/account/');
	}
}