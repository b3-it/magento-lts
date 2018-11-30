<?php
/**
 * Adminhtml catalog product downloadable items tab links section
 *
 * @category    Dwd
 * @package     Dwd_ProductOnDemand
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 */
class Dwd_ProductOnDemand_Block_Adminhtml_Catalog_Product_Edit_Tab_Prondemand_Ondemand extends Mage_Downloadable_Block_Adminhtml_Catalog_Product_Edit_Tab_Downloadable_Links
{
	
	protected $_showReferencePeriodAttribute;
	
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
     * Retrieve default storage time
     *
     * @return int
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
    
    public function getStorageTimeNote() {
    	return $this->getStorageTimeAttribute()->getNote();
    }
    
    /**
     * Retrieve default show reference period
     *
     * @return int
     */
    public function getShowReferencePeriodDefault()
    {
    	return $this->getShowReferencePeriodAttribute()->getDefaultValue();
    }
    
    /**
     * Check exists default pod_show_reference_period
     *
     * @return bool
     */
    public function getUsedDefaultShowReferencePeriod()
    {
    	return $this->getProduct()->getAttributeDefaultValue('pod_show_reference_period') === false;
    }
    
    /**
     * Retrieve Show Reference Period Attribute object
     *
     * @return Mage_Catalog_Model_Resource_Eav_Attribute
     */
    public function getShowReferencePeriodAttribute() {
    	if (is_null($this->_showReferencePeriodAttribute)) {
    		$_attributeCode = 'pod_show_reference_period';
    
    		$this->_showReferencePeriodAttribute = Mage::getModel('eav/entity_attribute')
    			->loadByCode(Mage_Catalog_Model_Product::ENTITY, $_attributeCode)
    		;
    	}
    
    	return $this->_showReferencePeriodAttribute;
    }
    
    public function getShowReferencePeriodNote() {
    	return $this->__($this->getShowReferencePeriodAttribute()->getNote());
    }
    
    public function getShowReferencePeriodLabel() {
    	return $this->getShowReferencePeriodAttribute()->getFrontendLabel();
    }
    
    public function getShowReferencePeriodHtml()
    {
    	/* @var $src Mage_Eav_Model_Entity_Attribute_Source_Boolean */
    	$src = $this->getShowReferencePeriodAttribute()->getSource();
    	$opt = $src->getOptionArray();
    	
    	$select = $this->getLayout()->createBlock(sprintf('adminhtml/html_%s', $this->getShowReferencePeriodAttribute()->getFrontendInput()))
	    	->setData(
	    		array(
	    			'id' => $this->getShowReferencePeriodAttribute()->getAttributeCode(),
	    			'class' => 'select required-entry',
	    		)
	    	)
	    	->setTitle($this->__($this->getShowReferencePeriodLabel()))
	    	->setName(sprintf("product[%s]", $this->getShowReferencePeriodAttribute()->getAttributeCode()))
	    	->setOptions($opt)
    	;
    	$_product = $this->getProduct();
    	$select->setValue($_product->getId() ? $_product->getPodShowReferencePeriod() : $this->getShowReferencePeriodDefault());
    
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
     * @param float $value
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

    /**
     * Prepare block Layout
     *
     */
     protected function _prepareLayout()
    {
        $this->setChild(
            'upload_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')->addData(array(
                'id'      => '',
                'label'   => Mage::helper('adminhtml')->__('Upload Files'),
                'type'    => 'button',
                'onclick' => 'Downloadable.massUploadByType(\'links\');Downloadable.massUploadByType(\'linkssample\')'
            ))
        );
    }

    /**
     * Retrieve Upload button HTML
     *
     * @return string
     */
    public function getUploadButtonHtml()
    {
        return $this->getChild('upload_button')->toHtml();
    }

    /**
     * Retrive config json
     *
     * @return string
     */
    public function getConfigJson($type='links')
    {
        $this->getConfig()->setUrl(Mage::getModel('adminhtml/url')->addSessionParam()
            ->getUrl('*/downloadable_file/upload', array('type' => $type, '_secure' => true)));
        $this->getConfig()->setParams(array('form_key' => $this->getFormKey()));
        $this->getConfig()->setFileField($type);
        $this->getConfig()->setFilters(array(
            'all'    => array(
                'label' => Mage::helper('adminhtml')->__('All Files'),
                'files' => array('*.*')
            )
        ));
        $this->getConfig()->setReplaceBrowseWithRemove(true);
        $this->getConfig()->setWidth('32');
        $this->getConfig()->setHideUploadButton(true);
        return Mage::helper('core')->jsonEncode($this->getConfig()->getData());
    }

    /**
     * Retrive config object
     *
     * @return Varien_Object
     */
    public function getConfig()
    {
        if(is_null($this->_config)) {
            $this->_config = new Varien_Object();
        }

        return $this->_config;
    }
}
