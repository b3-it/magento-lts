<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Import entity product model
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Framecontract_Model_Import_Entity_Product extends Mage_ImportExport_Model_Import_Entity_Product
{
    const CONFIG_KEY_PRODUCT_TYPES = 'global/importexport/import_product_types';

    /**
     * Size of bunch - part of products to save in one step.
     */
    const BUNCH_SIZE = 20;

    /**
     * Value that means all entities (e.g. websites, groups etc.)
     */
    const VALUE_ALL = 'all';

    
    public $missingImages = array();
    /**
     * Data row scopes.
     */
    const SCOPE_DEFAULT = 1;
    const SCOPE_WEBSITE = 2;
    const SCOPE_STORE   = 0;
    const SCOPE_NULL    = -1;

    /**
     * Permanent column names.
     *
     * Names that begins with underscore is not an attribute. This name convention is for
     * to avoid interference with same attribute name.
     */
    const COL_STORE    = '_store';
    const COL_ATTR_SET = '_attribute_set';
    const COL_TYPE     = '_type';
    const COL_CATEGORY = '_category';
    const COL_SKU      = 'sku';

    /**
     * Error codes.
     */
    const ERROR_INVALID_SCOPE            = 'invalidScope';
    const ERROR_INVALID_WEBSITE          = 'invalidWebsite';
    const ERROR_INVALID_STORE            = 'invalidStore';
    const ERROR_INVALID_ATTR_SET         = 'invalidAttrSet';
    const ERROR_INVALID_TYPE             = 'invalidType';
    const ERROR_INVALID_CATEGORY         = 'invalidCategory';
    const ERROR_VALUE_IS_REQUIRED        = 'isRequired';
    const ERROR_TYPE_CHANGED             = 'typeChanged';
    const ERROR_SKU_IS_EMPTY             = 'skuEmpty';
    const ERROR_NO_DEFAULT_ROW           = 'noDefaultRow';
    const ERROR_CHANGE_TYPE              = 'changeProductType';
    const ERROR_DUPLICATE_SCOPE          = 'duplicateScope';
    const ERROR_DUPLICATE_SKU            = 'duplicateSKU';
    const ERROR_CHANGE_ATTR_SET          = 'changeAttrSet';
    const ERROR_TYPE_UNSUPPORTED         = 'productTypeUnsupported';
    const ERROR_ROW_IS_ORPHAN            = 'rowIsOrphan';
    const ERROR_INVALID_TIER_PRICE_QTY   = 'invalidTierPriceOrQty';
    const ERROR_INVALID_TIER_PRICE_SITE  = 'tierPriceWebsiteInvalid';
    const ERROR_INVALID_TIER_PRICE_GROUP = 'tierPriceGroupInvalid';
    const ERROR_TIER_DATA_INCOMPLETE     = 'tierPriceDataIsIncomplete';
    const ERROR_SKU_NOT_FOUND_FOR_DELETE = 'skuNotFoundToDelete';

    const ERROR_SKU_WRONG_PRICE 		 = 'wrongPrice';
    const ERROR_SKU_WRONG_QTY	 		 = 'wrongQty';
    
    public $ImageSrcDir = null;
    
    
    
    /**
     * Pairs of attribute set ID-to-name.
     *
     * @var array
     */
    protected $_attrSetIdToName = array();

    /**
     * Pairs of attribute set name-to-ID.
     *
     * @var array
     */
    protected $_attrSetNameToId = array();

    /**
     * Categories text-path to ID hash.
     *
     * @var array
     */
    protected $_categories = array();

    /**
     * Customer groups ID-to-name.
     *
     * @var array
     */
    protected $_customerGroups = array();

    /**
     * Attributes with index (not label) value.
     *
     * @var array
     */
    protected $_indexValueAttributes = array(
        'status',
        'tax_class_id',
        'visibility',
        'enable_googlecheckout',
        'gift_message_available',
        'custom_design'
    );

    /**
     * Links attribute name-to-link type ID.
     *
     * @var array
     */
    protected $_linkNameToId = array(
        '_links_related_'   => Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED,
        '_links_crosssell_' => Mage_Catalog_Model_Product_Link::LINK_TYPE_CROSSSELL,
        '_links_upsell_'    => Mage_Catalog_Model_Product_Link::LINK_TYPE_UPSELL,
    	'_parent_'			=> Mage_Catalog_Model_Product_Link::LINK_TYPE_RELATED
    );

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::ERROR_INVALID_SCOPE            => 'Invalid value in Scope column',
        self::ERROR_INVALID_WEBSITE          => 'Invalid value in Website column (website does not exists?)',
        self::ERROR_INVALID_STORE            => 'Invalid value in Store column (store does not exists?)',
        self::ERROR_INVALID_ATTR_SET         => 'Invalid value for Attribute Set column (set does not exists?)',
        self::ERROR_INVALID_TYPE             => 'Product Type is invalid or not supported',
        self::ERROR_INVALID_CATEGORY         => 'Category does not exists',
        self::ERROR_VALUE_IS_REQUIRED        => "Required attribute '%s' has an empty value",
        self::ERROR_TYPE_CHANGED             => 'Trying to change type of existing products',
        self::ERROR_SKU_IS_EMPTY             => 'SKU is empty',
        self::ERROR_NO_DEFAULT_ROW           => 'Default values row does not exists',
        self::ERROR_CHANGE_TYPE              => 'Product type change is not allowed',
        self::ERROR_DUPLICATE_SCOPE          => 'Duplicate scope',
        self::ERROR_DUPLICATE_SKU            => 'Duplicate SKU',
        self::ERROR_CHANGE_ATTR_SET          => 'Product attribute set change is not allowed',
        self::ERROR_TYPE_UNSUPPORTED         => 'Product type is not supported',
        self::ERROR_ROW_IS_ORPHAN            => 'Orphan rows that will be skipped due default row errors',
        self::ERROR_INVALID_TIER_PRICE_QTY   => 'Tier Price data price or quantity value is invalid',
        self::ERROR_INVALID_TIER_PRICE_SITE  => 'Tier Price data website is invalid',
        self::ERROR_INVALID_TIER_PRICE_GROUP => 'Tier Price customer group ID is invalid',
        self::ERROR_TIER_DATA_INCOMPLETE     => 'Tier Price data is incomplete',
        self::ERROR_SKU_NOT_FOUND_FOR_DELETE => 'Product with specified SKU not found',
        self::ERROR_SKU_WRONG_PRICE 		 => 'Wrong Value for Price',
    	self::ERROR_SKU_WRONG_QTY	 		 => 'Wrong Value for Quantity'
    );

    /**
     * Dry-runned products information from import file.
     *
     * [SKU] => array(
     *     'type_id'        => (string) product type
     *     'attr_set_id'    => (int) product attribute set ID
     *     'entity_id'      => (int) product ID (value for new products will be set after entity save)
     *     'attr_set_code'  => (string) attribute set code
     * )
     *
     * @var array
     */
    protected $_newSku = array();

    /**
     * Existing products SKU-related information in form of array:
     *
     * [SKU] => array(
     *     'type_id'        => (string) product type
     *     'attr_set_id'    => (int) product attribute set ID
     *     'entity_id'      => (int) product ID
     *     'supported_type' => (boolean) is product type supported by current version of import module
     * )
     *
     * @var array
     */
    protected $_oldSku = array();

    /**
     * Column names that holds values with particular meaning.
     *
     * @var array
     */
    protected $_particularAttributes = array(
        '_store', '_attribute_set', '_type', '_category', '_product_websites', '_tier_price_website',
        '_tier_price_customer_group', '_tier_price_qty', '_tier_price_price', '_links_related_sku',
        '_links_related_position', '_links_crosssell_sku', '_links_crosssell_position', '_links_upsell_sku',
        '_links_upsell_position', '_custom_option_store', '_custom_option_type', '_custom_option_title',
        '_custom_option_is_required', '_custom_option_price', '_custom_option_sku', '_custom_option_max_characters',
        '_custom_option_sort_order', '_custom_option_file_extension', '_custom_option_image_size_x',
        '_custom_option_image_size_y', '_custom_option_row_title', '_custom_option_row_price',
        '_custom_option_row_sku', '_custom_option_row_sort', '_media_attribute_id', '_media_image', '_media_lable',
        '_media_position', '_media_is_disabled','_parent_sku'
    );

    /**
     * Column names that holds images files names
     *
     * @var array
     */
    protected $_imagesArrayKeys = array(
        '_media_image', 'image', 'small_image', 'thumbnail'
    );

    /**
     * Permanent entity columns.
     *
     * @var array
     */
    protected $_permanentAttributes = array(self::COL_SKU);

    /**
     * Array of supported product types as keys with appropriate model object as value.
     *
     * @var array
     */
    protected $_productTypeModels = array();

    /**
     * All stores code-ID pairs.
     *
     * @var array
     */
    protected $_storeCodeToId = array();

    /**
     * Store ID to its website stores IDs.
     *
     * @var array
     */
    protected $_storeIdToWebsiteStoreIds = array();

    /**
     * Website code-to-ID
     *
     * @var array
     */
    protected $_websiteCodeToId = array();

    /**
     * Website code to store code-to-ID pairs which it consists.
     *
     * @var array
     */
    protected $_websiteCodeToStoreIds = array();

    /**
     * Media files uploader
     *
     * @var Mage_ImportExport_Model_Import_Uploader
     */
    protected $_fileUploader;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->_initWebsites()
            ->_initStores()
            ->_initAttributeSets()
            ->_initTypeModels()
            ->_initCategories()
            ->_initSkus()
            ->_initCustomerGroups();
    }

    /**
     * Delete products.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _deleteProducts()
    {
        $productEntityTable = Mage::getModel('importexport/import_proxy_product_resource')->getEntityTable();

        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            $idToDelete = array();

            foreach ($bunch as $rowNum => $rowData) {
                if ($this->validateRow($rowData, $rowNum) && self::SCOPE_DEFAULT == $this->getRowScope($rowData)) {
                    $idToDelete[] = $this->_oldSku[$rowData[self::COL_SKU]]['entity_id'];
                }
            }
            if ($idToDelete) {
                $this->_connection->query(
                    $this->_connection->quoteInto(
                        "DELETE FROM `{$productEntityTable}` WHERE `entity_id` IN (?)", $idToDelete
                    )
                );
            }
        }
        return $this;
    }

    /**
     * Create Product entity from raw data.
     *
     * @throws Exception
     * @return bool Result of operation.
     */
    protected function _importData()
    {
        if (Mage_ImportExport_Model_Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            $this->_deleteProducts();
        } else {
            $this->_saveProducts();
            $this->_saveStockItems();
            $this->_saveLinks();
            $this->_saveCustomOptions();
            foreach ($this->_productTypeModels as $productType => $productTypeModel) {
                $productTypeModel->saveData();
            }
        }
       // Mage::dispatchEvent('catalog_product_import_finish_before', array('adapter'=>$this));
        return true;
    }

    /**
     * Initialize attribute sets code-to-id pairs.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initAttributeSets()
    {
        foreach (Mage::getResourceModel('eav/entity_attribute_set_collection')
                ->setEntityTypeFilter($this->_entityTypeId) as $attributeSet) {
            $this->_attrSetNameToId[$attributeSet->getAttributeSetName()] = $attributeSet->getId();
            $this->_attrSetIdToName[$attributeSet->getId()] = $attributeSet->getAttributeSetName();
        }
        return $this;
    }

    /**
     * Initialize categories text-path to ID hash.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initCategories()
    {
        $collection = Mage::getResourceModel('catalog/category_collection')->addNameToResult();
        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection */
        foreach ($collection as $category) {
            $structure = explode('/', $category->getPath());
            $pathSize  = count($structure);
            if ($pathSize > 2) {
                $path = array();
                for ($i = 2; $i < $pathSize; $i++) {
                    $path[] = $collection->getItemById($structure[$i])->getName();
                }
                //$this->_categories[implode('/', $path)] = $category->getId();
                $this->_categories[$category->getId()] = $category->getId();
            }
        }
        return $this;
    }

    /**
     * Initialize customer groups.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initCustomerGroups()
    {
        foreach (Mage::getResourceModel('customer/group_collection') as $customerGroup) {
            $this->_customerGroups[$customerGroup->getId()] = true;
        }
        return $this;
    }

    /**
     * Initialize existent product SKUs.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initSkus()
    {
        $columns = array('entity_id', 'type_id', 'attribute_set_id', 'sku');
        foreach (Mage::getModel('catalog/product')->getProductEntitiesInfo($columns) as $info) {
            $typeId = $info['type_id'];
            $sku = $info['sku'];
            $this->_oldSku[$sku] = array(
                'type_id'        => $typeId,
                'attr_set_id'    => $info['attribute_set_id'],
                'entity_id'      => $info['entity_id'],
                'supported_type' => isset($this->_productTypeModels[$typeId])
            );
        }
        return $this;
    }

    /**
     * Initialize stores hash.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initStores()
    {
        foreach (Mage::app()->getStores() as $store) {
            $this->_storeCodeToId[$store->getCode()] = $store->getId();
            $this->_storeIdToWebsiteStoreIds[$store->getId()] = $store->getWebsite()->getStoreIds();
        }
        return $this;
    }

    /**
     * Initialize product type models.
     *
     * @throws Exception
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initTypeModels()
    {
        $config = Mage::getConfig()->getNode(self::CONFIG_KEY_PRODUCT_TYPES)->asCanonicalArray();
        foreach ($config as $type => $typeModel) {
            if (!($model = Mage::getModel($typeModel, array($this, $type)))) {
                Mage::throwException("Entity type model '{$typeModel}' is not found");
            }
            if (! $model instanceof Mage_ImportExport_Model_Import_Entity_Product_Type_Abstract) {
                Mage::throwException(
                    Mage::helper('importexport')->__('Entity type model must be an instance of Mage_ImportExport_Model_Import_Entity_Product_Type_Abstract')
                );
            }
            if ($model->isSuitable()) {
                $this->_productTypeModels[$type] = $model;
            }
            $this->_particularAttributes = array_merge(
                $this->_particularAttributes,
                $model->getParticularAttributes()
            );
        }
        // remove doubles
        $this->_particularAttributes = array_unique($this->_particularAttributes);

        return $this;
    }

    /**
     * Initialize website values.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _initWebsites()
    {
        /** @var $website Mage_Core_Model_Website */
        foreach (Mage::app()->getWebsites() as $website) {
            $this->_websiteCodeToId[$website->getCode()] = $website->getId();
            $this->_websiteCodeToStoreIds[$website->getCode()] = array_flip($website->getStoreCodes());
        }
        return $this;
    }

    /**
     * Check product category validity.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    protected function _isProductCategoryValid(array $rowData, $rowNum)
    {
        if (!empty($rowData[self::COL_CATEGORY]) && !isset($this->_categories[$rowData[self::COL_CATEGORY]])) {
            $this->addRowError(self::ERROR_INVALID_CATEGORY, $rowNum);
            return false;
        }
        return true;
    }

    /**
     * Check product website belonging.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    protected function _isProductWebsiteValid(array $rowData, $rowNum)
    {
        if (!empty($rowData['_product_websites']) && !isset($this->_websiteCodeToId[$rowData['_product_websites']])) {
            $this->addRowError(self::ERROR_INVALID_WEBSITE, $rowNum);
            return false;
        }
        return true;
    }

    
    protected function _saveValidatedBunches()
    {
    	$source          = $this->_getSource();
    	$productDataSize = 0;
    	$bunchRows       = array();
    	$startNewBunch   = false;
    	$nextRowBackup   = array();
    	$maxDataSize = Mage::getResourceHelper('importexport')->getMaxDataSize();
    	$bunchSize = Mage::helper('importexport')->getBunchSize();
    
    	/** @var Mage_Core_Helper_Data $coreHelper */
    	$coreHelper = Mage::helper("core");
    
    	$source->rewind();
    	$this->_dataSourceModel->cleanBunches();
    	Mage::getModel('sidimport/storage')->getResource()->clear();
    	
    	
    	while ($source->valid()) {
    		
    		//if ($source->valid()) {
    			if ($this->_errorsCount >= $this->_errorsLimit) { // errors limit check
    				return;
    			}
    			$current = $source->current();
    			$rowData = $coreHelper->unEscapeCSVData($current);
    
    			$this->_processedRowsCount++;
    
    			if ($this->validateRow($rowData, $source->key())) { // add row to bunch for save
    				$rowData = $this->_prepareRowForDb($rowData);
    				
    				$storage = Mage::getModel('sidimport/storage');
    				$storage->setSku($current['sku'])
    					->setName($current['name'])
    					->setImportdata(serialize($rowData))
    					->setCreatedTime(now())
    					->setStatus(Sid_Import_Model_Status::STATUS_NEW)
    					->save();
    				
    			}
    			$source->next();
    		//}
    	}
    	return $this;
    }
    /**
     * Set valid attribute set and product type to rows with all scopes
     * to ensure that existing products doesn't changed.
     *
     * @param array $rowData
     * @return array
     */
    protected function x_prepareRowForDb(array $rowData)
    {
        $rowData = parent::_prepareRowForDb($rowData);

        static $lastSku  = null;

        if (Mage_ImportExport_Model_Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            return $rowData;
        }
        if (self::SCOPE_DEFAULT == $this->getRowScope($rowData)) {
            $lastSku = $rowData[self::COL_SKU];
        }
        if (isset($this->_oldSku[$lastSku])) {
            $rowData[self::COL_ATTR_SET] = $this->_newSku[$lastSku]['attr_set_code'];
            $rowData[self::COL_TYPE]     = $this->_newSku[$lastSku]['type_id'];
        }

        return $rowData;
    }

    /**
     * Check tier orice data validity.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return bool
     */
    protected function _isTierPriceValid(array $rowData, $rowNum)
    {
        if ((isset($rowData['_tier_price_website']) && strlen($rowData['_tier_price_website']))
                || (isset($rowData['_tier_price_customer_group']) && strlen($rowData['_tier_price_customer_group']))
                || (isset($rowData['_tier_price_qty']) && strlen($rowData['_tier_price_qty']))
                || (isset($rowData['_tier_price_price']) && strlen($rowData['_tier_price_price']))
        ) {
            if (!isset($rowData['_tier_price_website']) || !isset($rowData['_tier_price_customer_group'])
                    || !isset($rowData['_tier_price_qty']) || !isset($rowData['_tier_price_price'])
                    || !strlen($rowData['_tier_price_website']) || !strlen($rowData['_tier_price_customer_group'])
                    || !strlen($rowData['_tier_price_qty']) || !strlen($rowData['_tier_price_price'])
            ) {
                $this->addRowError(self::ERROR_TIER_DATA_INCOMPLETE, $rowNum);
                return false;
            } elseif ($rowData['_tier_price_website'] != self::VALUE_ALL
                    && !isset($this->_websiteCodeToId[$rowData['_tier_price_website']])) {
                $this->addRowError(self::ERROR_INVALID_TIER_PRICE_SITE, $rowNum);
                return false;
            } elseif ($rowData['_tier_price_customer_group'] != self::VALUE_ALL
                    && !isset($this->_customerGroups[$rowData['_tier_price_customer_group']])) {
                $this->addRowError(self::ERROR_INVALID_TIER_PRICE_GROUP, $rowNum);
                return false;
            } elseif ($rowData['_tier_price_qty'] <= 0 || $rowData['_tier_price_price'] <= 0) {
                $this->addRowError(self::ERROR_INVALID_TIER_PRICE_QTY, $rowNum);
                return false;
            }
        }
        return true;
    }

    /**
     * Custom options save.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveCustomOptions()
    {
        $productTable   = Mage::getSingleton('core/resource')->getTableName('catalog/product');
        $optionTable    = Mage::getSingleton('core/resource')->getTableName('catalog/product_option');
        $priceTable     = Mage::getSingleton('core/resource')->getTableName('catalog/product_option_price');
        $titleTable     = Mage::getSingleton('core/resource')->getTableName('catalog/product_option_title');
        $typePriceTable = Mage::getSingleton('core/resource')->getTableName('catalog/product_option_type_price');
        $typeTitleTable = Mage::getSingleton('core/resource')->getTableName('catalog/product_option_type_title');
        $typeValueTable = Mage::getSingleton('core/resource')->getTableName('catalog/product_option_type_value');
        $nextOptionId   = Mage::getResourceHelper('importexport')->getNextAutoincrement($optionTable);
        $nextValueId    = Mage::getResourceHelper('importexport')->getNextAutoincrement($typeValueTable);
        $priceIsGlobal  = Mage::helper('catalog')->isPriceGlobal();
        $type           = null;
        $typeSpecific   = array(
            'date'      => array('price', 'sku'),
            'date_time' => array('price', 'sku'),
            'time'      => array('price', 'sku'),
            'field'     => array('price', 'sku', 'max_characters'),
            'area'      => array('price', 'sku', 'max_characters'),
            //'file'      => array('price', 'sku', 'file_extension', 'image_size_x', 'image_size_y'),
            'drop_down' => true,
            'radio'     => true,
            'checkbox'  => true,
            'multiple'  => true
        );

         $collection = Mage::getModel('sidimport/storage')->getCollection();
        $rowNum = 0;
       foreach($collection as $item) 
        //while ($bunch = $this->_dataSourceModel->getNextBunch()) 
        {
            $customOptions = array(
                'product_id'    => array(),
                $optionTable    => array(),
                $priceTable     => array(),
                $titleTable     => array(),
                $typePriceTable => array(),
                $typeTitleTable => array(),
                $typeValueTable => array()
            );
            $rowData = unserialize($item->getImportdata());
            //foreach ($bunch as $rowNum => $rowData) 
            {
                if (!$this->isRowAllowedToImport($rowData, $rowNum++)) {
                    return $this;
                }
                if (self::SCOPE_DEFAULT == $this->getRowScope($rowData)) {
                    $productId = $this->_newSku[$rowData[self::COL_SKU]]['entity_id'];
                } elseif (!isset($productId)) {
                    continue;
                }
                if (!empty($rowData['_custom_option_store'])) {
                    if (!isset($this->_storeCodeToId[$rowData['_custom_option_store']])) {
                        continue;
                    }
                    $storeId = $this->_storeCodeToId[$rowData['_custom_option_store']];
                } else {
                    $storeId = Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;
                }
                if (!empty($rowData['_custom_option_type'])) { // get CO type if its specified
                    if (!isset($typeSpecific[$rowData['_custom_option_type']])) {
                        $type = null;
                        continue;
                    }
                    $type = $rowData['_custom_option_type'];
                    $rowIsMain = true;
                } else {
                    if (null === $type) {
                        continue;
                    }
                    $rowIsMain = false;
                }
                if (!isset($customOptions['product_id'][$productId])) { // for update product entity table
                    $customOptions['product_id'][$productId] = array(
                        'entity_id'        => $productId,
                        'has_options'      => 0,
                        'required_options' => 0,
                        'updated_at'       => now()
                    );
                }
                if ($rowIsMain) {
                    $solidParams = array(
                        'option_id'      => $nextOptionId,
                        'sku'            => '',
                        'max_characters' => 0,
                        'file_extension' => null,
                        'image_size_x'   => 0,
                        'image_size_y'   => 0,
                        'product_id'     => $productId,
                        'type'           => $type,
                        'is_require'     => empty($rowData['_custom_option_is_required']) ? 0 : 1,
                        'sort_order'     => empty($rowData['_custom_option_sort_order'])
                                            ? 0 : abs($rowData['_custom_option_sort_order'])
                    );

                    if (true !== $typeSpecific[$type]) { // simple option may have optional params
                        $priceTableRow = array(
                            'option_id'  => $nextOptionId,
                            'store_id'   => Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID,
                            'price'      => 0,
                            'price_type' => 'fixed'
                        );

                        foreach ($typeSpecific[$type] as $paramSuffix) {
                            if (isset($rowData['_custom_option_' . $paramSuffix])) {
                                $data = $rowData['_custom_option_' . $paramSuffix];

                                if (array_key_exists($paramSuffix, $solidParams)) {
                                    $solidParams[$paramSuffix] = $data;
                                } elseif ('price' == $paramSuffix) {
                                    if ('%' == substr($data, -1)) {
                                        $priceTableRow['price_type'] = 'percent';
                                    }
                                    $priceTableRow['price'] = (float) rtrim($data, '%');
                                }
                            }
                        }
                        $customOptions[$priceTable][] = $priceTableRow;
                    }
                    $customOptions[$optionTable][] = $solidParams;
                    $customOptions['product_id'][$productId]['has_options'] = 1;

                    if (!empty($rowData['_custom_option_is_required'])) {
                        $customOptions['product_id'][$productId]['required_options'] = 1;
                    }
                    $prevOptionId = $nextOptionId++; // increment option id, but preserve value for $typeValueTable
                }
                if ($typeSpecific[$type] === true && !empty($rowData['_custom_option_row_title'])
                        && empty($rowData['_custom_option_store'])) {
                    // complex CO option row
                    $customOptions[$typeValueTable][$prevOptionId][] = array(
                        'option_type_id' => $nextValueId,
                        'sort_order'     => empty($rowData['_custom_option_row_sort'])
                                            ? 0 : abs($rowData['_custom_option_row_sort']),
                        'sku'            => !empty($rowData['_custom_option_row_sku'])
                                            ? $rowData['_custom_option_row_sku'] : ''
                    );
                    if (!isset($customOptions[$typeTitleTable][$nextValueId][0])) { // ensure default title is set
                        $customOptions[$typeTitleTable][$nextValueId][0] = $rowData['_custom_option_row_title'];
                    }
                    $customOptions[$typeTitleTable][$nextValueId][$storeId] = $rowData['_custom_option_row_title'];

                    if (!empty($rowData['_custom_option_row_price'])) {
                        $typePriceRow = array(
                            'price'      => (float) rtrim($rowData['_custom_option_row_price'], '%'),
                            'price_type' => 'fixed'
                        );
                        if ('%' == substr($rowData['_custom_option_row_price'], -1)) {
                            $typePriceRow['price_type'] = 'percent';
                        }
                        if ($priceIsGlobal) {
                            $customOptions[$typePriceTable][$nextValueId][0] = $typePriceRow;
                        } else {
                            // ensure default price is set
                            if (!isset($customOptions[$typePriceTable][$nextValueId][0])) {
                                $customOptions[$typePriceTable][$nextValueId][0] = $typePriceRow;
                            }
                            $customOptions[$typePriceTable][$nextValueId][$storeId] = $typePriceRow;
                        }
                    }
                    $nextValueId++;
                }
                if (!empty($rowData['_custom_option_title'])) {
                    if (!isset($customOptions[$titleTable][$prevOptionId][0])) { // ensure default title is set
                        $customOptions[$titleTable][$prevOptionId][0] = $rowData['_custom_option_title'];
                    }
                    $customOptions[$titleTable][$prevOptionId][$storeId] = $rowData['_custom_option_title'];
                }
            }
            if ($this->getBehavior() != Mage_ImportExport_Model_Import::BEHAVIOR_APPEND) { // remove old data?
                $this->_connection->delete(
                    $optionTable,
                    $this->_connection->quoteInto('product_id IN (?)', array_keys($customOptions['product_id']))
                );
            }
            // if complex options does not contain values - ignore them
            foreach ($customOptions[$optionTable] as $key => $optionData) {
                if ($typeSpecific[$optionData['type']] === true
                        && !isset($customOptions[$typeValueTable][$optionData['option_id']])) {
                    unset($customOptions[$optionTable][$key], $customOptions[$titleTable][$optionData['option_id']]);
                }
            }
            if ($customOptions[$optionTable]) {
                $this->_connection->insertMultiple($optionTable, $customOptions[$optionTable]);
            } else {
                continue; // nothing to save
            }
            $titleRows = array();

            foreach ($customOptions[$titleTable] as $optionId => $storeInfo) {
                foreach ($storeInfo as $storeId => $title) {
                    $titleRows[] = array('option_id' => $optionId, 'store_id' => $storeId, 'title' => $title);
                }
            }
            if ($titleRows) {
                $this->_connection->insertOnDuplicate($titleTable, $titleRows, array('title'));
            }
            if ($customOptions[$priceTable]) {
                $this->_connection->insertOnDuplicate(
                    $priceTable,
                    $customOptions[$priceTable],
                    array('price', 'price_type')
                );
            }
            $typeValueRows = array();

            foreach ($customOptions[$typeValueTable] as $optionId => $optionInfo) {
                foreach ($optionInfo as $row) {
                    $row['option_id'] = $optionId;
                    $typeValueRows[]  = $row;
                }
            }
            if ($typeValueRows) {
                $this->_connection->insertMultiple($typeValueTable, $typeValueRows);
            }
            $optionTypePriceRows = array();
            $optionTypeTitleRows = array();

            foreach ($customOptions[$typePriceTable] as $optionTypeId => $storesData) {
                foreach ($storesData as $storeId => $row) {
                    $row['option_type_id'] = $optionTypeId;
                    $row['store_id']       = $storeId;
                    $optionTypePriceRows[] = $row;
                }
            }
            foreach ($customOptions[$typeTitleTable] as $optionTypeId => $storesData) {
                foreach ($storesData as $storeId => $title) {
                    $optionTypeTitleRows[] = array(
                        'option_type_id' => $optionTypeId,
                        'store_id'       => $storeId,
                        'title'          => $title
                    );
                }
            }
            if ($optionTypePriceRows) {
                $this->_connection->insertOnDuplicate(
                    $typePriceTable,
                    $optionTypePriceRows,
                    array('price', 'price_type')
                );
            }
            if ($optionTypeTitleRows) {
                $this->_connection->insertOnDuplicate($typeTitleTable, $optionTypeTitleRows, array('title'));
            }
            if ($customOptions['product_id']) { // update product entity table to show that product has options
                $this->_connection->insertOnDuplicate(
                    $productTable,
                    $customOptions['product_id'],
                    array('has_options', 'required_options', 'updated_at')
                );
            }
        }
        return $this;
    }

    /**
     * Gather and save information about product links.
     * Must be called after ALL products saving done.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveLinks()
    {
        $resource       = Mage::getResourceModel('catalog/product_link');
        $mainTable      = $resource->getMainTable();
        $positionAttrId = array();
        $nextLinkId     = Mage::getResourceHelper('importexport')->getNextAutoincrement($mainTable);
        $adapter = $this->_connection;

        // pre-load 'position' attributes ID for each link type once
        foreach ($this->_linkNameToId as $linkName => $linkId) {
            $select = $adapter->select()
                ->from(
                    $resource->getTable('catalog/product_link_attribute'),
                    array('id' => 'product_link_attribute_id')
                )
                ->where('link_type_id = :link_id AND product_link_attribute_code = :position');
            $bind = array(
                ':link_id' => $linkId,
                ':position' => 'position'
            );
            $positionAttrId[$linkId] = $adapter->fetchOne($select, $bind);
        }
        $collection = Mage::getModel('sidimport/storage')->getCollection();
        $rowNum = 0;
       foreach($collection as $item) {
            $productIds   = array();
            $linkRows     = array();
            $positionRows = array();

            $rowData = unserialize($item->getImportdata());
            //foreach ($bunch as $rowNum => $rowData) 
            {
                if (!$this->isRowAllowedToImport($rowData, $rowNum++)) {
                    continue;
                }
                if (self::SCOPE_DEFAULT == $this->getRowScope($rowData)) {
                    $sku = $rowData[self::COL_SKU];
                }
                foreach ($this->_linkNameToId as $linkName => $linkId) {
                    if (isset($rowData[$linkName . 'sku'])) {
                        $productId    = $this->_newSku[$sku]['entity_id'];
                        $productIds[] = $productId;
                        $linkedSku    = $rowData[$linkName . 'sku'];

                        if ((isset($this->_newSku[$linkedSku]) || isset($this->_oldSku[$linkedSku]))
                                && $linkedSku != $sku) {
                            if (isset($this->_newSku[$linkedSku])) {
                                $linkedId = $this->_newSku[$linkedSku]['entity_id'];
                            } else {
                                $linkedId = $this->_oldSku[$linkedSku]['entity_id'];
                            }
                            

                            if($linkName == '_parent_')
                            {
                            	$tmp = $productId;
                            	$productId = $linkedId;
                            	$linkedId = $tmp;
                            }
                            $linkKey = "{$productId}-{$linkedId}-{$linkId}";
                            if (!isset($linkRows[$linkKey])) {
                                $linkRows[$linkKey] = array(
                                    'link_id'           => $nextLinkId,
                                    'product_id'        => $productId,
                                    'linked_product_id' => $linkedId,
                                    'link_type_id'      => $linkId
                                );
                                if (!empty($rowData[$linkName . 'position'])) {
                                    $positionRows[] = array(
                                        'link_id'                   => $nextLinkId,
                                        'product_link_attribute_id' => $positionAttrId[$linkId],
                                        'value'                     => $rowData[$linkName . 'position']
                                    );
                                }
                                $nextLinkId++;
                            }
                        }
                    }
                }
            }
            if (Mage_ImportExport_Model_Import::BEHAVIOR_APPEND != $this->getBehavior() && $productIds) {
                $adapter->delete(
                    $mainTable,
                    $adapter->quoteInto('product_id IN (?)', array_keys($productIds))
                );
            }
            if ($linkRows) {
                $adapter->insertOnDuplicate(
                    $mainTable,
                    $linkRows,
                    array('link_id')
                );
            }
            if ($positionRows) { // process linked product positions
                $adapter->insertOnDuplicate(
                    $resource->getAttributeTypeTable('int'),
                    $positionRows,
                    array('value')
                );
            }
        }
        return $this;
    }

    /**
     * Save product attributes.
     *
     * @param array $attributesData
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProductAttributes(array $attributesData)
    {
        foreach ($attributesData as $tableName => $skuData) {
            $tableData = array();

            foreach ($skuData as $sku => $attributes) {
                $productId = $this->_newSku[$sku]['entity_id'];

                foreach ($attributes as $attributeId => $storeValues) {
                    foreach ($storeValues as $storeId => $storeValue) {
                        $tableData[] = array(
                            'entity_id'      => $productId,
                            'entity_type_id' => $this->_entityTypeId,
                            'attribute_id'   => $attributeId,
                            'store_id'       => $storeId,
                            'value'          => $storeValue
                        );
                    }
                }
            }
            $this->_connection->insertOnDuplicate($tableName, $tableData, array('value'));
        }
        return $this;
    }

    /**
     * Save product categories.
     *
     * @param array $categoriesData
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProductCategories(array $categoriesData)
    {
        static $tableName = null;

        if (!$tableName) {
            $tableName = Mage::getModel('importexport/import_proxy_product_resource')->getProductCategoryTable();
        }
        if ($categoriesData) {
            $categoriesIn = array();
            $delProductId = array();

            foreach ($categoriesData as $delSku => $categories) {
                $productId      = $this->_newSku[$delSku]['entity_id'];
                $delProductId[] = $productId;

                foreach (array_keys($categories) as $categoryId) {
                    $categoriesIn[] = array('product_id' => $productId, 'category_id' => $categoryId, 'position' => 1);
                }
            }
            if (Mage_ImportExport_Model_Import::BEHAVIOR_APPEND != $this->getBehavior()) {
                $this->_connection->delete(
                    $tableName,
                    $this->_connection->quoteInto('product_id IN (?)', $delProductId)
                );
            }
            if ($categoriesIn) {
                $this->_connection->insertOnDuplicate($tableName, $categoriesIn, array('position'));
            }
        }
        return $this;
    }

    /**
     * Update and insert data in entity table.
     *
     * @param array $entityRowsIn Row for insert
     * @param array $entityRowsUp Row for update
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProductEntity(array $entityRowsIn, array $entityRowsUp)
    {
        static $entityTable = null;

        if (!$entityTable) {
            $entityTable = Mage::getModel('importexport/import_proxy_product_resource')->getEntityTable();
        }
        if ($entityRowsUp) {
            $this->_connection->insertOnDuplicate(
                $entityTable,
                $entityRowsUp,
                array('updated_at')
            );
        }
        if ($entityRowsIn) {
            $this->_connection->insertMultiple($entityTable, $entityRowsIn);

            $newProducts = $this->_connection->fetchPairs($this->_connection->select()
                ->from($entityTable, array('sku', 'entity_id'))
                ->where('sku IN (?)', array_keys($entityRowsIn))
            );
            foreach ($newProducts as $sku => $newId) { // fill up entity_id for new products
                $this->_newSku[$sku]['entity_id'] = $newId;
            }
        }
        return $this;
    }

    
    
    
    protected function _saveProducts()
    {
    	$collection = Mage::getModel('sidimport/storage')->getCollection();
    	$ProductsArray = $collection->getItems();
    	$rowNum = 0;
    	while(count($ProductsArray) > 0 )
    	{
    		$data = array_shift($ProductsArray);
    		if($data)
    		{
    			$this->_saveProduct(unserialize($data->getImportdata()),$rowNum++);
    		}
    	}
    }
    
    /**
     * Gather and save information about product entities.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProduct($rowData, $rowNum)
    {
        /** @var $resource Mage_ImportExport_Model_Import_Proxy_Product_Resource */
        $resource       = Mage::getModel('importexport/import_proxy_product_resource');
        $priceIsGlobal  = Mage::helper('catalog')->isPriceGlobal();
        $strftimeFormat = Varien_Date::convertZendToStrftime(Varien_Date::DATETIME_INTERNAL_FORMAT, true, true);
        $productLimit   = null;
        $productsQty    = null;

     
       // while ($bunch = $this->_dataSourceModel->getNextBunch()) 
        {
            $entityRowsIn = array();
            $entityRowsUp = array();
            $attributes   = array();
            $websites     = array();
            $categories   = array();
            $tierPrices   = array();
            $mediaGallery = array();
            $uploadedGalleryFiles = array();
            $previousType = null;
            $previousAttributeSet = null;

           //foreach ($bunch as $rowNum => $rowData) {
                if (!$this->validateRow($rowData, $rowNum)) {
                 //   continue;
                }
                $rowScope = $this->getRowScope($rowData);

                if (self::SCOPE_DEFAULT == $rowScope) {
                    $rowSku = $rowData[self::COL_SKU];

                    // 1. Entity phase
                    if (isset($this->_oldSku[$rowSku])) { // existing row
                        $entityRowsUp[] = array(
                            'updated_at' => now(),
                            'entity_id'  => $this->_oldSku[$rowSku]['entity_id']
                        );
                    } else { // new row
                        if (!$productLimit || $productsQty < $productLimit) {
                            $entityRowsIn[$rowSku] = array(
                                'entity_type_id'   => $this->_entityTypeId,
                                'attribute_set_id' => $this->_newSku[$rowSku]['attr_set_id'],
                                'type_id'          => $this->_newSku[$rowSku]['type_id'],
                                'sku'              => $rowSku,
                                'created_at'       => now(),
                                'updated_at'       => now()
                            );
                            $productsQty++;
                        } else {
                            $rowSku = null; // sign for child rows to be skipped
                            $this->_rowsToSkip[$rowNum] = true;
                            continue;
                        }
                    }
                } elseif (null === $rowSku) {
                    $this->_rowsToSkip[$rowNum] = true;
                    continue; // skip rows when SKU is NULL
                } elseif (self::SCOPE_STORE == $rowScope) { // set necessary data from SCOPE_DEFAULT row
                    $rowData[self::COL_TYPE]     = $this->_newSku[$rowSku]['type_id'];
                    $rowData['attribute_set_id'] = $this->_newSku[$rowSku]['attr_set_id'];
                    $rowData[self::COL_ATTR_SET] = $this->_newSku[$rowSku]['attr_set_code'];
                }
                if (!empty($rowData['_product_websites'])) { // 2. Product-to-Website phase
                    $websites[$rowSku][$this->_websiteCodeToId[$rowData['_product_websites']]] = true;
                }
                if (!empty($rowData[self::COL_CATEGORY])) { // 3. Categories phase
                    $categories[$rowSku][$this->_categories[$rowData[self::COL_CATEGORY]]] = true;
                }
                if (!empty($rowData['_tier_price_website'])) { // 4. Tier prices phase
                    $tierPrices[$rowSku][] = array(
                        'all_groups'        => $rowData['_tier_price_customer_group'] == self::VALUE_ALL,
                        'customer_group_id' => $rowData['_tier_price_customer_group'] == self::VALUE_ALL ?
                                               0 : $rowData['_tier_price_customer_group'],
                        'qty'               => $rowData['_tier_price_qty'],
                        'value'             => $rowData['_tier_price_price'],
                        'website_id'        => self::VALUE_ALL == $rowData['_tier_price_website'] || $priceIsGlobal ?
                                               0 : $this->_websiteCodeToId[$rowData['_tier_price_website']]
                    );
                }
                foreach ($this->_imagesArrayKeys as $imageCol) {
                    if (!empty($rowData[$imageCol])) { // 5. Media gallery phase
                        if (!array_key_exists($rowData[$imageCol], $uploadedGalleryFiles)) {
                            $uploadedGalleryFiles[$rowData[$imageCol]] = $this->_uploadMediaFilesSID($rowData['image_upload_token'],$rowData[$imageCol]);
                        }
                        $rowData[$imageCol] = $uploadedGalleryFiles[$rowData[$imageCol]];
                    }
                }
                if (!empty($rowData['_media_image'])) {
                    $mediaGallery[$rowSku][] = array(
                        'attribute_id'      => $rowData['_media_attribute_id'],
                        'label'             => $rowData['_media_lable'],
                        'position'          => $rowData['_media_position'],
                        'disabled'          => $rowData['_media_is_disabled'],
                        'value'             => $rowData['_media_image']
                    );
                }
                // 6. Attributes phase
                $rowStore     = self::SCOPE_STORE == $rowScope ? $this->_storeCodeToId[$rowData[self::COL_STORE]] : 0;
                $productType  = $rowData[self::COL_TYPE];
                if(!is_null($rowData[self::COL_TYPE])) {
                    $previousType = $rowData[self::COL_TYPE];
                }
                if(!is_null($rowData[self::COL_ATTR_SET])) {
                    $previousAttributeSet = $rowData[Mage_ImportExport_Model_Import_Entity_Product::COL_ATTR_SET];
                }
                if (self::SCOPE_NULL == $rowScope) {
                    // for multiselect attributes only
                    if(!is_null($previousAttributeSet)) {
                        $rowData[Mage_ImportExport_Model_Import_Entity_Product::COL_ATTR_SET] = $previousAttributeSet;
                    }
                    if(is_null($productType) && !is_null($previousType)) {
                        $productType = $previousType;
                    }
                    if(is_null($productType)) {
                        continue;
                    }
                }
                $rowData      = $this->_productTypeModels[$productType]->prepareAttributesForSave($rowData);
                $rowData['groupscatalog2_groups'] = '-2';
                $product      = Mage::getModel('importexport/import_proxy_product', $rowData);

                foreach ($rowData as $attrCode => $attrValue) {
                    $attribute = $resource->getAttribute($attrCode);
                    if('multiselect' != $attribute->getFrontendInput()
                        && self::SCOPE_NULL == $rowScope) {
                        continue; // skip attribute processing for SCOPE_NULL rows
                    }
                    $attrId    = $attribute->getId();
                    $backModel = $attribute->getBackendModel();
                    $attrTable = $attribute->getBackend()->getTable();
                    $storeIds  = array(0);

                    if ('datetime' == $attribute->getBackendType()) {
                        $attrValue = gmstrftime($strftimeFormat, strtotime($attrValue));
                    } elseif ($backModel) {
                        $attribute->getBackend()->beforeSave($product);
                        $attrValue = $product->getData($attribute->getAttributeCode());
                    }
                    if (self::SCOPE_STORE == $rowScope) {
                        if (self::SCOPE_WEBSITE == $attribute->getIsGlobal()) {
                            // check website defaults already set
                            if (!isset($attributes[$attrTable][$rowSku][$attrId][$rowStore])) {
                                $storeIds = $this->_storeIdToWebsiteStoreIds[$rowStore];
                            }
                        } elseif (self::SCOPE_STORE == $attribute->getIsGlobal()) {
                            $storeIds = array($rowStore);
                        }
                    }
                    foreach ($storeIds as $storeId) {
                        if('multiselect' == $attribute->getFrontendInput()) {
                            if(!isset($attributes[$attrTable][$rowSku][$attrId][$storeId])) {
                                $attributes[$attrTable][$rowSku][$attrId][$storeId] = '';
                            } else {
                                $attributes[$attrTable][$rowSku][$attrId][$storeId] .= ',';
                            }
                            $attributes[$attrTable][$rowSku][$attrId][$storeId] .= $attrValue;
                        } else {
                            $attributes[$attrTable][$rowSku][$attrId][$storeId] = $attrValue;
                        }
                    }
                    $attribute->setBackendModel($backModel); // restore 'backend_model' to avoid 'default' setting
                }

            $this->_saveProductEntity($entityRowsIn, $entityRowsUp)
                ->_saveProductWebsites($websites)
                ->_saveProductCategories($categories)
                ->_saveProductTierPrices($tierPrices)
                ->_saveMediaGallery($mediaGallery)
                ->_saveProductAttributes($attributes)
                ->_logImportedProducts();
        }
        return $this;
    }

    /**
     * Save product tier prices.
     *
     * @param array $tierPriceData
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProductTierPrices(array $tierPriceData)
    {
        static $tableName = null;

        if (!$tableName) {
            $tableName = Mage::getModel('importexport/import_proxy_product_resource')
                    ->getTable('catalog/product_attribute_tier_price');
        }
        if ($tierPriceData) {
            $tierPriceIn  = array();
            $delProductId = array();

            foreach ($tierPriceData as $delSku => $tierPriceRows) {
                $productId      = $this->_newSku[$delSku]['entity_id'];
                $delProductId[] = $productId;

                foreach ($tierPriceRows as $row) {
                    $row['entity_id'] = $productId;
                    $tierPriceIn[]  = $row;
                }
            }
            if (Mage_ImportExport_Model_Import::BEHAVIOR_APPEND != $this->getBehavior()) {
                $this->_connection->delete(
                    $tableName,
                    $this->_connection->quoteInto('entity_id IN (?)', $delProductId)
                );
            }
            if ($tierPriceIn) {
                $this->_connection->insertOnDuplicate($tableName, $tierPriceIn, array('value'));
            }
        }
        return $this;
    }

    /**
     * Returns an object for upload a media files
     */
    protected function _getUploader($srcDir = null)
    {
        if (is_null($this->_fileUploader)) {
            $this->_fileUploader    = new Mage_ImportExport_Model_Import_Uploader();

            $this->_fileUploader->init();
            $path = Mage::getBaseDir('var') . DS ."import" .DS ."tmp". DS .$srcDir ;
            $this->ImageSrcDir = $path;
            if (!$this->_fileUploader->setTmpDir($path)) 
            {
            	$tmpDir     = Mage::getConfig()->getOptions()->getMediaDir() . '/import';
                if (!$this->_fileUploader->setTmpDir($tmpDir)) {
                	Mage::throwException("File directory '{$tmpDir}' is not readable.");
            	}
            }
            
            $destDir    = Mage::getConfig()->getOptions()->getMediaDir() . '/catalog/product/'.$srcDir;
            if (!is_writable($destDir)) {
            	@mkdir($destDir, 0777, true);
            }
            if (!$this->_fileUploader->setDestDir($destDir)) {
                Mage::throwException("File directory '{$destDir}' is not writable.");
            }
            
            
        }
        return $this->_fileUploader;
    }

    
    public function getUploader()
    {
    	return $this->_fileUploader;
    }
    /**
     * Uploading files into the "catalog/product" media folder.
     * Return a new file name if the same file is already exists.
     *
     * @param string $fileName
     * @return string
     */
    protected function _uploadMediaFilesSID($dir,$fileName)
    {
        try {
        	$fileName = Varien_File_Uploader::getCorrectFileName($fileName);
            $res = $this->_getUploader($dir)->move($fileName);
            return '/' . $dir . $res['file'];
            
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Save product media gallery.
     *
     * @param array $mediaGalleryData
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveMediaGallery(array $mediaGalleryData)
    {
        if (empty($mediaGalleryData)) {
            return $this;
        }

        static $mediaGalleryTableName = null;
        static $mediaValueTableName = null;
        static $productId = null;

        if (!$mediaGalleryTableName) {
            $mediaGalleryTableName = Mage::getModel('importexport/import_proxy_product_resource')
                    ->getTable('catalog/product_attribute_media_gallery');
        }

        if (!$mediaValueTableName) {
            $mediaValueTableName = Mage::getModel('importexport/import_proxy_product_resource')
                    ->getTable('catalog/product_attribute_media_gallery_value');
        }

        foreach ($mediaGalleryData as $productSku => $mediaGalleryRows) {
            $productId = $this->_newSku[$productSku]['entity_id'];
            $insertedGalleryImgs = array();

            if (Mage_ImportExport_Model_Import::BEHAVIOR_APPEND != $this->getBehavior()) {
                $this->_connection->delete(
                    $mediaGalleryTableName,
                    $this->_connection->quoteInto('entity_id IN (?)', $productId)
                );
            }

            foreach ($mediaGalleryRows as $insertValue) {

                if (!in_array($insertValue['value'], $insertedGalleryImgs)) {
                    $valueArr = array(
                        'attribute_id' => $insertValue['attribute_id'],
                        'entity_id'    => $productId,
                        'value'        => $insertValue['value']
                    );

                    $this->_connection
                            ->insertOnDuplicate($mediaGalleryTableName, $valueArr, array('entity_id'));

                    $insertedGalleryImgs[] = $insertValue['value'];
                }

                $newMediaValues = $this->_connection->fetchPairs($this->_connection->select()
                                        ->from($mediaGalleryTableName, array('value', 'value_id'))
                                        ->where('entity_id IN (?)', $productId)
                );

                if (array_key_exists($insertValue['value'], $newMediaValues)) {
                    $insertValue['value_id'] = $newMediaValues[$insertValue['value']];
                }

                $valueArr = array(
                    'value_id' => $insertValue['value_id'],
                    'store_id' => Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID,
                    'label'    => $insertValue['label'],
                    'position' => $insertValue['position'],
                    'disabled' => $insertValue['disabled']
                );

                try {
                    $this->_connection
                            ->insertOnDuplicate($mediaValueTableName, $valueArr, array('value_id'));
                } catch (Exception $e) {
                    $this->_connection->delete(
                            $mediaGalleryTableName, $this->_connection->quoteInto('value_id IN (?)', $newMediaValues)
                    );
                }
            }
        }

        return $this;
    }

    /**
     * Save product websites.
     *
     * @param array $websiteData
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveProductWebsites(array $websiteData)
    {
        static $tableName = null;

        if (!$tableName) {
            $tableName = Mage::getModel('importexport/import_proxy_product_resource')->getProductWebsiteTable();
        }
        if ($websiteData) {
            $websitesData = array();
            $delProductId = array();

            foreach ($websiteData as $delSku => $websites) {
                $productId      = $this->_newSku[$delSku]['entity_id'];
                $delProductId[] = $productId;

                foreach (array_keys($websites) as $websiteId) {
                    $websitesData[] = array(
                        'product_id' => $productId,
                        'website_id' => $websiteId
                    );
                }
            }
            if (Mage_ImportExport_Model_Import::BEHAVIOR_APPEND != $this->getBehavior()) {
                $this->_connection->delete(
                    $tableName,
                    $this->_connection->quoteInto('product_id IN (?)', $delProductId)
                );
            }
            if ($websitesData) {
                $this->_connection->insertOnDuplicate($tableName, $websitesData);
            }
        }
        return $this;
    }

    
    protected function _saveStockItems()
    {
    	$collection = Mage::getModel('sidimport/storage')->getCollection();
    	$ProductsArray = $collection->getItems();
    	$rowNum = 0;
    	while(count($ProductsArray) > 0 )
    	{
    		$data = array_shift($ProductsArray);
    		if($data)
    		{
    			$this->saveStockItem(unserialize($data->getImportdata()), $rowNum++);
    		}
    	}
    }
    
    /**
     * Stock item saving.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function saveStockItem($rowData, $rowNum)
    {
        $defaultStockData = array(
            'manage_stock'                       => 1,
            'use_config_manage_stock'            => 1,
            'qty'                                => 0,
            'min_qty'                            => 0,
            'use_config_min_qty'                 => 1,
            'min_sale_qty'                       => 1,
            'use_config_min_sale_qty'            => 1,
            'max_sale_qty'                       => 10000,
            'use_config_max_sale_qty'            => 1,
            'is_qty_decimal'                     => 0,
            'backorders'                         => 0,
            'use_config_backorders'              => 1,
            'notify_stock_qty'                   => 1,
            'use_config_notify_stock_qty'        => 1,
            'enable_qty_increments'              => 0,
            'use_config_enable_qty_inc'          => 1,
            'qty_increments'                     => 0,
            'use_config_qty_increments'          => 1,
            'is_in_stock'                        => 0,
            'low_stock_date'                     => null,
            'stock_status_changed_auto'          => 0
        );

        $entityTable = Mage::getResourceModel('cataloginventory/stock_item')->getMainTable();
        $helper      = Mage::helper('catalogInventory');

      
        
        //while ($bunch = $this->_dataSourceModel->getNextBunch()) 
        {
            $stockData = array();

            // Format bunch to stock data rows
            //foreach ($bunch as $rowNum => $rowData) 
            {
                if (!$this->isRowAllowedToImport($rowData, $rowNum)) {
                    return $this;
                }
                // only SCOPE_DEFAULT can contain stock data
                if (self::SCOPE_DEFAULT != $this->getRowScope($rowData)) {
                    continue;
                }

                $row = array_merge(
                    $defaultStockData,
                    array_intersect_key($rowData, $defaultStockData)
                );
                $row['product_id'] = $this->_newSku[$rowData[self::COL_SKU]]['entity_id'];
                $row['stock_id'] = 1;
                /** @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
                $stockItem = Mage::getModel('cataloginventory/stock_item', $row);

                if($stockItem->getQty() == 0)
                {
                	$stockItem->setData('manage_stock',false);
                	$stockItem->setData('use_config_manage_stock',false);
                	$stockItem->setData('is_in_stock',true);
                }
                
                if ($helper->isQty($this->_newSku[$rowData[self::COL_SKU]]['type_id'])) {
                    if ($stockItem->verifyNotification()) {
                        $stockItem->setLowStockDate(Mage::app()->getLocale()
                            ->date(null, null, null, false)
                            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT)
                        );
                    }
                    $stockItem->setStockStatusChangedAutomatically((int) !$stockItem->verifyStock());
                } else {
                    $stockItem->setQty(0);
                }
                
              	$stockItem->setData('is_in_stock',$stockItem->getQty() != 0);
                
                $stockData[] = $stockItem->unsetOldData()->getData();
            }

            // Insert rows
            if ($stockData) {
                $this->_connection->insertOnDuplicate($entityTable, $stockData);
            }
        }
        return $this;
    }

    /**
     * Atttribute set ID-to-name pairs getter.
     *
     * @return array
     */
    public function getAttrSetIdToName()
    {
        return $this->_attrSetIdToName;
    }

    /**
     * DB connection getter.
     *
     * @return Varien_Db_Adapter_Pdo_Mysql
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * EAV entity type code getter.
     *
     * @abstract
     * @return string
     */
    public function getEntityTypeCode()
    {
        return 'catalog_product';
    }

    /**
     * New products SKU data.
     *
     * @return array
     */
    public function getNewSku()
    {
        return $this->_newSku;
    }

    /**
     * Get next bunch of validatetd rows.
     *
     * @return array|null
     */
    public function getNextBunch()
    {
        return $this->_dataSourceModel->getNextBunch();
    }

    /**
     * Existing products SKU getter.
     *
     * @return array
     */
    public function getOldSku()
    {
        return $this->_oldSku;
    }

    /**
     * Obtain scope of the row from row data.
     *
     * @param array $rowData
     * @return int
     */
    public function getRowScope(array $rowData)
    {
        if (strlen(trim($rowData[self::COL_SKU]))) {
            return self::SCOPE_DEFAULT;
        } elseif (empty($rowData[self::COL_STORE])) {
            return self::SCOPE_NULL;
        } else {
            return self::SCOPE_STORE;
        }
    }

    /**
     * All website codes to ID getter.
     *
     * @return array
     */
    public function getWebsiteCodes()
    {
        return $this->_websiteCodeToId;
    }

    /**
     * Validate data row.
     *
     * @param array $rowData
     * @param int $rowNum
     * @return boolean
     */
    public function validateRow(array $rowData, $rowNum)
    {
        static $sku = null; // SKU is remembered through all product rows

        if (isset($this->_validatedRows[$rowNum])) { // check that row is already validated
            return !isset($this->_invalidRows[$rowNum]);
        }
        $this->_validatedRows[$rowNum] = true;

        if (isset($this->_newSku[$rowData[self::COL_SKU]])) {
            $this->addRowError(self::ERROR_DUPLICATE_SKU, $rowNum);
            return false;
        }
        $rowScope = $this->getRowScope($rowData);

        // BEHAVIOR_DELETE use specific validation logic
        if (Mage_ImportExport_Model_Import::BEHAVIOR_DELETE == $this->getBehavior()) {
            if (self::SCOPE_DEFAULT == $rowScope && !isset($this->_oldSku[$rowData[self::COL_SKU]])) {
                $this->addRowError(self::ERROR_SKU_NOT_FOUND_FOR_DELETE, $rowNum);
                return false;
            }
            return true;
        }
        // common validation
        $this->_isProductWebsiteValid($rowData, $rowNum);
        $this->_isProductCategoryValid($rowData, $rowNum);
        $this->_isTierPriceValid($rowData, $rowNum);

        if (self::SCOPE_DEFAULT == $rowScope) { // SKU is specified, row is SCOPE_DEFAULT, new product block begins
            $this->_processedEntitiesCount ++;

            $sku = $rowData[self::COL_SKU];

            if (isset($this->_oldSku[$sku])) { // can we get all necessary data from existant DB product?
                // check for supported type of existing product
                if (isset($this->_productTypeModels[$this->_oldSku[$sku]['type_id']])) {
                    $this->_newSku[$sku] = array(
                        'entity_id'     => $this->_oldSku[$sku]['entity_id'],
                        'type_id'       => $this->_oldSku[$sku]['type_id'],
                        'attr_set_id'   => $this->_oldSku[$sku]['attr_set_id'],
                        'attr_set_code' => $this->_attrSetIdToName[$this->_oldSku[$sku]['attr_set_id']]
                    );
                } else {
                    $this->addRowError(self::ERROR_TYPE_UNSUPPORTED, $rowNum);
                    $sku = false; // child rows of legacy products with unsupported types are orphans
                }
            } else { // validate new product type and attribute set
                if (!isset($rowData[self::COL_TYPE])
                    || !isset($this->_productTypeModels[$rowData[self::COL_TYPE]])
                ) {
                    $this->addRowError(self::ERROR_INVALID_TYPE, $rowNum);
                } elseif (!isset($rowData[self::COL_ATTR_SET])
                          || !isset($this->_attrSetNameToId[$rowData[self::COL_ATTR_SET]])
                ) {
                    $this->addRowError(self::ERROR_INVALID_ATTR_SET, $rowNum);
                } elseif (!isset($this->_newSku[$sku])) {
                    $this->_newSku[$sku] = array(
                        'entity_id'     => null,
                        'type_id'       => $rowData[self::COL_TYPE],
                        'attr_set_id'   => $this->_attrSetNameToId[$rowData[self::COL_ATTR_SET]],
                        'attr_set_code' => $rowData[self::COL_ATTR_SET]
                    );
                }
                if (isset($this->_invalidRows[$rowNum])) {
                    // mark SCOPE_DEFAULT row as invalid for future child rows if product not in DB already
                    $sku = false;
                }
            }
        } else {
            if (null === $sku) {
                $this->addRowError(self::ERROR_SKU_IS_EMPTY, $rowNum);
            } elseif (false === $sku) {
                $this->addRowError(self::ERROR_ROW_IS_ORPHAN, $rowNum);
            } elseif (self::SCOPE_STORE == $rowScope && !isset($this->_storeCodeToId[$rowData[self::COL_STORE]])) {
                $this->addRowError(self::ERROR_INVALID_STORE, $rowNum);
            }
        }
        
        
    	$qty = $rowData['qty'];
    	$i = intval($qty);
    	if((strpos($qty,'.') > 0) || (strpos($qty,',') > 0) || ($i < 0))
    	{
    		$this->addRowError(self::ERROR_SKU_WRONG_QTY, $rowNum);
    		/*
    	 	Mage::throwException(
                    Mage::helper('framecontract')->__("Wrong Value for Quantity: %s ", $qty)
                );*/
    	}
    	
        $price = $this->_str2num($rowData['price']);
    	if(($price < 0) || !preg_match('/^([0-9.,]+)$/',$rowData['price']))
    	{
    		$this->addRowError(self::ERROR_SKU_WRONG_PRICE, $rowNum);
    		
    	 	/*
    		Mage::throwException(
                    Mage::helper('framecontract')->__("Wrong Value for Price: %s ", $rowData['price'])
                );*/
    	}
    	//wg. tausender trennzeichen
        $rowData['price'] = $price;
        
        
        //Bilderprüfen
       
       	$path = Mage::getBaseDir('var') . DS ."import" .DS ."tmp". DS .$rowData['image_upload_token'] ;
        
       	//$filename = Varien_File_Uploader::getCorrectFileName($rowData['_media_image']);
       	
       	if(isset($rowData['image']))
       	{
	       	$filename = Varien_File_Uploader::getCorrectFileName($rowData['image']);
	       
	        $zeile = $rowNum +1; 
	        if(!$this->isvalidFile_name($filename))
	        {
	        	$this->missingImages[] = $filename." (Zeile: ".$zeile.") ist nicht gültig";
	        }
	        else if(!file_exists($path. DS .$filename))
	        {
	        	$this->missingImages[] = $filename." (Zeile: ".$zeile.") fehlt";
	        }
       	}
        
        
        if (!isset($this->_invalidRows[$rowNum])) {
            // set attribute set code into row data for followed attribute validation in type model
            $rowData[self::COL_ATTR_SET] = $this->_newSku[$sku]['attr_set_code'];

            $rowAttributesValid = $this->_productTypeModels[$this->_newSku[$sku]['type_id']]->isRowValid(
                $rowData, $rowNum, !isset($this->_oldSku[$sku])
            );
            if (!$rowAttributesValid && self::SCOPE_DEFAULT == $rowScope && !isset($this->_oldSku[$sku])) {
                $sku = false; // mark SCOPE_DEFAULT row as invalid for future child rows if product not in DB already
            }
        }
        return !isset($this->_invalidRows[$rowNum]);
    }
    
    
    
    
    private function isvalidFile_name($string){
    	if(preg_match("!^[a-zA-Z0-9-_+]+\.[a-zA-Z0-9]{3,4}+$!", $string) > 0){
    		return true;
    	}
    	return false;
    }
    

    /**
     * Get array of affected products
     *
     * @return array
     */
    public function getAffectedEntityIds()
    {
        $productIds = array();
        while ($bunch = $this->_dataSourceModel->getNextBunch()) {
            foreach ($bunch as $rowNum => $rowData) {
                if (!$this->isRowAllowedToImport($rowData, $rowNum)) {
                    continue;
                }
                if (!isset($this->_newSku[$rowData[self::COL_SKU]]['entity_id'])) {
                    continue;
                }
                $productIds[] = $this->_newSku[$rowData[self::COL_SKU]]['entity_id'];
            }
        }
        return $productIds;
    }
    
    protected function _logImportedProducts()
    {
    	foreach ($this->_newSku as $key =>$value) {
    		$msg = "sku:".$key." id:".$value['entity_id'];
    		Mage::log($msg, Zend_Log::NOTICE, "import.log");
    	}
    }
    
    public function validateData()
    {
    	$this->_getSource()->translateColNames();
    	$p = array();
    	$p['_attribute_set'] ='Default';
    	$p['_type'] = 'simple';
    	//$cat = Mage::getModel('catalog/category')->load($this->_parameters['category']);
    	//$p['_category'] = $cat->getName();
    	$p['_category'] = $this->_parameters['category'];
    	$p['_product_websites'] = Mage::getModel('core/website')->load($this->_parameters['website'])->getCode();
    	$p['_store'] = Mage::getModel('core/store')->load($this->_parameters['store'])->getCode();
    	$p['store_group'] = $p['_store'];
    	//$p['framecontract'] = Mage::getModel('framecontract/contract')->load($this->_parameters['framecontract'])->getTitle();
    	$p['framecontract_los'] = $this->_parameters['los'];
    	//$p['framecontract_los'] = Mage::getModel('framecontract/los')->load($this->_parameters['los'])->getOptionsLabel();
		$p['tax_class_id'] = $this->_parameters['tax_class'];
		$p['sku_prefix'] = $this->_parameters['sku_prefix'];
		$p['qty'] = $this->_parameters['qty'];
		$p['framecontract_qty'] = $this->_parameters['qty'];
		
		$p['image_upload_token'] = $this->_parameters['image_upload_token'];
    	
		$p['status'] = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
		$p['visibility']= Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE;
		
		$p['haushaltsstelle']="0";
		$p['objektnummer']="0";
		$p['objektnummer_mwst']="0";
		$p['href']="0";
		$p['href_mwst']="0";
		$p['buchungstext']="0";
		$p['buchungstext_mwst']="0";
		$p['groupscatalog2_groups']="NOT LOGGED IN";
		$p['generate_meta']="1";
		$p['enable_googlecheckout']="0";
		
		$p['generate_meta']="1";
		
    	$this->_getSource()->setDefaultValues($p);
    	
    	
    	
    	return parent::validateData();
    }
    

    private function _str2num($str) 
 	{ 
 		if(is_numeric($str)) return $str; 
 		if (strpos($str, '.') !== FALSE && strpos($str,    ',') !== FALSE && strpos($str, '.') < strpos($str,',')) 
 		{ 
 			$str = str_replace('.','',$str); 
 			$str = strtr($str,',','.');            
 		} 
 		else 
 		{ 
 			$str = str_replace(',','.',$str);            
 		} 
 		return (float)$str; 
 	} 
    
}
