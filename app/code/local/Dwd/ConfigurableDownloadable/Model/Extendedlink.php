<?php
/**
 * Downloadable link model
 *
 * @method Dwd_ConfigurableDownloadable_Model_Link setCreatedAt(string $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setUpdatedAt(string $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setDataValidFrom(string $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setDataValidTo(string $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setValidTo(string $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setLinkFileId(int $value)
 * @method Dwd_ConfigurableDownloadable_Model_Link setLinkStationId(int $value)
 * @method int getLinkFileId(int $value)
 * @method int getLinkStationId(int $value)
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Extendedlink extends Mage_Downloadable_Model_Link
{
    /**
     * Initialize resource model
     * 
     * Nutzt nicht den PARENT-Konstruktor!
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/extendedlink');

        Mage_Core_Model_Abstract::_construct();
    }
}
