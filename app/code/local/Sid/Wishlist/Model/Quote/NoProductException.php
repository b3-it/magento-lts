<?php
/**
 * Exception für fehlendes Produkt
 * 
 * Wird beim hinzufügen von fehlenden Produkten zum Merkzettel ausgelöst.
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Quote_NoProductException extends Mage_Core_Exception
{
	protected $_refererUrl = null;

	public function getRefererUrl() {
	    return (string)$this->_refererUrl;
    }

    public function setRefererUrl($url) {
	    if (!is_string($url)) {
	        return $this;
        }

        $this->_refererUrl = $url;
        return $this;
    }
}