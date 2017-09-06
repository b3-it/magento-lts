<?php
/**
 * Adminhtml catalog product downloadable items tab links section
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Configdownloadable_Dynlinks extends Mage_Downloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Downloadable_Links
{
    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        Varien_Object::__construct();
        $this->setCanEditPrice(true);
        $this->setCanReadPrice(true);
    }

    /**
     * Get product that is being edited
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('product');
    }
    
    /**
     * Retrieve Purchased Separately Attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    public function getPurchasedSeparatelyAttribute()
    {
        if (is_null($this->_purchasedSeparatelyAttribute)) {
            $_attributeCode = 'links_purchased_separately';

            $this->_purchasedSeparatelyAttribute = Mage::getModel('eav/entity_attribute')
                ->loadByCode(Mage_Catalog_Model_Product::ENTITY, $_attributeCode);
        }

        return $this->_purchasedSeparatelyAttribute;
    }

    /**
     * Retrieve Purchased Separately HTML select
     *
     * @return string
     */
    public function getPurchasedSeparatelySelect()
    {
        $select = $this->getLayout()->createBlock('adminhtml/html_select')
            ->setName('product[links_purchased_separately]')
            ->setId('configdownloadable_link_purchase_type')
            ->setOptions(Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray())
            ->setValue($this->getProduct()->getLinksPurchasedSeparately());

        return $select->getHtml();
    }

    /**
     * Retrieve Add button HTML
     *
     * @return string
     */
    public function getAddButtonHtml()
    {
        $addButton = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('downloadable')->__('Add New Row'),
                'id'    => 'add_dynlink_item',
                'class' => 'add'
            ));
        return $addButton->toHtml();
    }

    /**
     * Retrieve default links title
     *
     * @return string
     */
    public function getLinksTitle()
    {
        return Mage::getStoreConfig(Mage_Downloadable_Model_Link::XML_PATH_LINKS_TITLE);
    }

    /**
     * Check exists defined links title
     *
     * @return bool
     */
    public function getUsedDefault()
    {
        return $this->getProduct()->getAttributeDefaultValue('links_title') === false;
    }
    
    /**
     * Retrieve default links title
     *
     * @return string
     */
    public function getStorageTime()
    {
    	return 2;//Mage::getStoreConfig(Mage_Downloadable_Model_Link::XML_PATH_LINKS_TITLE);
    }
    
    /**
     * Check exists defined links title
     *
     * @return bool
     */
    public function getUsedDefaultStorageTime()
    {
    	return $this->getProduct()->getAttributeDefaultValue('storage_time') === false;
    }
    
    /**
     * Retrieve Storage Time Attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    public function getStorageTimeAttribute() {
    	if (is_null($this->_storageTimeAttribute)) {
    		$_attributeCode = 'storage_time';
    
    		$this->_storageTimeAttribute = Mage::getModel('eav/entity_attribute')
    			->loadByCode(Mage_Catalog_Model_Product::ENTITY, $_attributeCode)
    		;
    	}
    
    	return $this->_storageTimeAttribute;
    }
    
    /**
     * Note von StorageTime-Attribut abrufen
     * 
     * @return string
     */
    public function getStorageTimeNote() {
    	return $this->getStorageTimeAttribute()->getNote();
    }
    
    /**
     * Note von ReplaceDuplicates-Attribut abrufen
     * 
     * @return string
     */
    public function getReplaceDuplicatesNote() {
    	return $this->getReplaceDuplicatesAttribute()->getNote();
    }
    
    /**
     * Replace Duplicates Attribut Object abrufen
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    public function getReplaceDuplicatesAttribute() {
    	if (is_null($this->_replaceDuplicatesAttribute)) {
    		$_attributeCode = 'replace_duplicates';
    
    		$this->_replaceDuplicatesAttribute = Mage::getModel('eav/entity_attribute')
    		->loadByCode(Mage_Catalog_Model_Product::ENTITY, $_attributeCode)
    		;
    	}
    
    	return $this->_replaceDuplicatesAttribute;
    }
    
    /**
     * Liefert eine gerenderte Select-Box
     * 
     * @return string
     */
    public function getReplaceDuplicatesSelect() {
    	if (!$this->getProduct()->hasReplaceDuplicates()) {
    		$value = false;
    	} else {
    		$value = $this->getProduct()->getReplaceDuplicates();
    	}
    	/* @var $select Mage_Core_Block_Html_Select */
    	$select = $this->getLayout()->createBlock('adminhtml/html_select')
    		->setClass('item-qty validate-digits required-entry')
	    	->setName('product[replace_duplicates]')
	    	->setId('configdownloadable_replace_duplicates')
	    	->setOptions(Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray())
	    	->setValue($value)
    	;
    
    	return $select->getHtml();
    }

    /**
     * Return true if price in website scope
     *
     * @return bool
     */
    public function getIsPriceWebsiteScope()
    {
        $scope =  (int) Mage::app()->getStore()->getConfig(Mage_Core_Model_Store::XML_PATH_PRICE_SCOPE);
        if ($scope == Mage_Core_Model_Store::PRICE_SCOPE_WEBSITE) {
            return true;
        }
        return false;
    }

    /**
     * Return array of links
     *
     * @return array
     */
    public function getLinkData()
    {
        $linkArr = array();
        $links = $this->getProduct()->getTypeInstance(true)->getDynlinks($this->getProduct());
        $priceWebsiteScope = $this->getIsPriceWebsiteScope();
        foreach ($links as $item) {
            $tmpLinkItem = array(
                'link_id' => $item->getId(),
                'title' => $item->getTitle(),
                'price' => $this->getCanReadPrice() ? $this->getPriceValue($item->getPrice()) : '',
                'number_of_downloads' => $item->getNumberOfDownloads(),
                'is_shareable' => $item->getIsShareable(),
            	'link_pattern' => $item->getLinkPattern(),
            	'link_url' => $item->getLinkUrl(),
                'link_type' => $item->getLinkType(),
                'sample_file' => $item->getSampleFile(),
                'sample_url' => $item->getSampleUrl(),
                'sample_type' => $item->getSampleType(),
                'sort_order' => $item->getSortOrder(),
            );
            $file = Mage::helper('downloadable/file')->getFilePath(
                Mage_Downloadable_Model_Link::getBasePath(), $item->getLinkFile()
            );

            if ($item->getLinkFile() && !is_file($file)) {
                Mage::helper('core/file_storage_database')->saveFileToFilesystem($file);
            }

            if ($item->getLinkFile() && is_file($file)) {
                $name = '<a href="'
                    . $this->getUrl('*/downloadable_product_edit/link', array(
                        'id' => $item->getId(),
                        '_secure' => true
                    )) . '">' . Mage::helper('downloadable/file')->getFileFromPathFile($item->getLinkFile()) . '</a>';
                $tmpLinkItem['file_save'] = array(
                    array(
                        'file' => $item->getLinkFile(),
                        'name' => $name,
                        'size' => filesize($file),
                        'status' => 'old'
                    ));
            }
            $sampleFile = Mage::helper('downloadable/file')->getFilePath(
                Mage_Downloadable_Model_Link::getBaseSamplePath(), $item->getSampleFile()
            );
            if ($item->getSampleFile() && is_file($sampleFile)) {
                $tmpLinkItem['sample_file_save'] = array(
                    array(
                        'file' => $item->getSampleFile(),
                        'name' => Mage::helper('downloadable/file')->getFileFromPathFile($item->getSampleFile()),
                        'size' => filesize($sampleFile),
                        'status' => 'old'
                    ));
            }
            if ($item->getNumberOfDownloads() == '0') {
                $tmpLinkItem['is_unlimited'] = ' checked="checked"';
            }
            if ($this->getProduct()->getStoreId() && $item->getStoreTitle()) {
                $tmpLinkItem['store_title'] = $item->getStoreTitle();
            }
            if ($this->getProduct()->getStoreId() && $priceWebsiteScope) {
                $tmpLinkItem['website_price'] = $item->getWebsitePrice();
            }
            $linkArr[] = new Varien_Object($tmpLinkItem);
        }
        return $linkArr;
    }

    /**
     * Return formated price with two digits after decimal point
     *
     * @param float $value Preis
     * 
     * @return float
     */
    public function getPriceValue($value)
    {
        return number_format($value, 2, null, '');
    }

    /**
     * Retrieve max downloads value from config
     *
     * @return int
     */
    public function getConfigMaxDownloads()
    {
        return Mage::getStoreConfig(Mage_Downloadable_Model_Link::XML_PATH_DEFAULT_DOWNLOADS_NUMBER);
    }
}
