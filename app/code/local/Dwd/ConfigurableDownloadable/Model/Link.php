<?php
/**
 * Downloadable link model
 *
 * @method Dwd_ConfigurableDownloadable_Model_Resource_Link _getResource()
 * @method Dwd_ConfigurableDownloadable_Model_Resource_Link getResource()
 * @method int getProductId()
 * @method Dwd_ConfigurableDownloadable_Model_Link setProductId(int $value)
 * @method int getSortOrder()
 * @method Dwd_ConfigurableDownloadable_Model_Link setSortOrder(int $value)
 * @method int getNumberOfDownloads()
 * @method Dwd_ConfigurableDownloadable_Model_Link setNumberOfDownloads(int $value)
 * @method int getIsShareable()
 * @method Dwd_ConfigurableDownloadable_Model_Link setIsShareable(int $value)
 * @method string getLinkUrl()
 * @method Dwd_ConfigurableDownloadable_Model_Link setLinkUrl(string $value)
 * @method string getLinkFile()
 * @method Dwd_ConfigurableDownloadable_Model_Link setLinkFile(string $value)
 * @method string getLinkType()
 * @method Dwd_ConfigurableDownloadable_Model_Link setLinkType(string $value)
 * @method string getSampleUrl()
 * @method Dwd_ConfigurableDownloadable_Model_Link setSampleUrl(string $value)
 * @method string getSampleFile()
 * @method Dwd_ConfigurableDownloadable_Model_Link setSampleFile(string $value)
 * @method string getSampleType()
 * @method Dwd_ConfigurableDownloadable_Model_Link setSampleType(string $value)
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Link extends Mage_Downloadable_Model_Link
{
	const PLACEHOLDER_STATION_ID 			= "%sid";
	const PLACEHOLDER_PERIODE_YEAR 			= "%y";
	const PLACEHOLDER_PERIODE_YEAR_SHORT 	= "%yy";
	const PLACEHOLDER_PERIODE_MONTH 		= "%MM";
	const PLACEHOLDER_PERIODE_MONTH_SHORT	= "%M";
	const PLACEHOLDER_PERIODE_DAY			= "%dd";
	const PLACEHOLDER_PERIODE_DAY_SHORT		= "%d";
	
    /**
     * Initialize resource model
     * 
     * Nutzt nicht den PARENT-Konstruktor!
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/link');

        Mage_Core_Model_Abstract::_construct();
    }

    /**
     * Return link files path
     *
     * @return string
     */
    public static function getLinkDir() {
        return Mage::getBaseDir();
    }

    /**
     * Enter description here...
     *
     * @return Dwd_ConfigurableDownloadable_Model_Link
     */
    protected function _afterSave() {
        $this->getResource()->saveItemTitleAndPrice($this);
        return Mage_Core_Model_Abstract::_afterSave();
    }

    /**
     * Retrieve Base files path
     *
     * @return string
     */
    public static function getBasePath() {
        return Mage::getBaseDir('media') . DS . 'configdownloadable' . DS . 'files';
    }

    /**
     * Retrieve base sample temporary path
     *
     * @return string
     */
    public static function getBaseSampleTmpPath() {
        return Mage::getBaseDir('media') . DS . 'downloadable' . DS . 'tmp' . DS . 'link_samples';
    }

    /**
     * Retrieve base sample path
     *
     * @return string
     */
    public static function getBaseSamplePath() {
        return Mage::getBaseDir('media') . DS . 'downloadable' . DS . 'files' . DS . 'link_samples';
    }

    /**
     * Retrieve links searchable data
     *
     * @param int $productId Product ID
     * @param int $storeId   Store ID
     * 
     * @return array
     */
    public function getSearchableData($productId, $storeId)
    {
        return $this->_getResource()
            ->getSearchableData($productId, $storeId);
    }
}
