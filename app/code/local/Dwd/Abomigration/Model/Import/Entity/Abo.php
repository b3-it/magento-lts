<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abomigration_Model_Import_Entity_Abo extends Mage_ImportExport_Model_Import_Entity_Product
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
    protected $_customers = null;

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

   protected $_lastSku = null;
   protected $_lastProductId = null;
   protected $_stationen = null;
   protected $_lastProductId4Periode = null;
   protected $_lastPeriodeId = null;
   //workaround zum zurückgeben der Daten
   protected $_currentrowData = null;
   
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
    protected $_particularAttributes = array();

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
    //protected $_permanentAttributes = array('vorname', 'nachname', 'email', 'strasse', 'ort', 'plz', 'land', 'ldap_user', 'passwort', 'station1', 'periode_ende','prefix','artikelnr');
    protected $_permanentAttributes = array('nachname', 'email', 'strasse', 'ort', 'plz', 'land', 'ldap_user', 'passwort', 'station1', 'periode_ende','prefix','artikelnr');

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
            $this->_saveAbos();
         
        }
       
        return true;
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

    /**
     * Set valid attribute set and product type to rows with all scopes
     * to ensure that existing products doesn't changed.
     *
     * @param array $rowData
     * @return array
     */
    protected function _prepareRowForDb(array $rowData)
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
     * Gather and save information about product entities.
     *
     * @return Mage_ImportExport_Model_Import_Entity_Product
     */
    protected function _saveAbos()
    {
        /** @var $resource Mage_ImportExport_Model_Import_Proxy_Product_Resource */
        $resource       = Mage::getModel('importexport/import_proxy_product_resource');
      
        $strftimeFormat = Varien_Date::convertZendToStrftime(Varien_Date::DATETIME_INTERNAL_FORMAT, true, true);
       

        while ($bunch = $this->_dataSourceModel->getNextBunch()) 
        {         
            foreach ($bunch as $rowNum => $rowData) {
                if (!$this->validateRow($rowData, $rowNum)) {
                    continue;
                }
                $rowData = $this->_currentrowData;
            	$abo = Mage::getModel('abomigration/abomigration');
            	
            	$abo->setData('website_id',($rowData['website_id']));
            	$abo->setData('store_id',($rowData['store_id']));
            	
            	if(isset($rowData['vorname'])){$abo->setData('firstname',($rowData['vorname']));}
            	$abo->setData('lastname',($rowData['nachname']));
            	if(isset($rowData['firma1'])){$abo->setData('company1',($rowData['firma1']));}
            	if(isset($rowData['firma2'])){$abo->setData('company2',($rowData['firma2']));}
            	$abo->setData('street',($rowData['strasse']));
            	$abo->setData('city',($rowData['ort']));
            	$abo->setData('postcode',($rowData['plz']));
            	$abo->setData('country',($rowData['land']));
            	$abo->setData('telephone',($rowData['telephone']));
            	$abo->setData('email',($rowData['email']));
            	$abo->setData('pwd',($rowData['passwort']));
            	$abo->setData('pwd_shop',($rowData['passwort']));
            	$abo->setData('pwd_ldap',($rowData['passwort']));
            	$abo->setData('username_ldap',($rowData['ldap_user']));
            	$abo->setData('station1',($rowData['station1_id']));
            	if(isset($rowData['station2_id'])){$abo->setData('station2',($rowData['station2_id']));}
            	
            	if(isset($rowData['station3_id'])){ $abo->setData('station3',($rowData['station3_id']));}
            	$abo->setData('sku',($rowData['artikelnr']));
            	$abo->setData('prefix',($rowData['prefix']));
            	
            	$abo->setData('product_id',($rowData['product_id']));
            	$abo->setData('customer_id',($rowData['customer_id']));
            	$abo->setData('address_id',($rowData['address_id']));
            	$abo->setData('period_id',($rowData['periode_id']));
        
            	
            	$abo->setData('period_end',($rowData['periode_ende']));
            	$abo->setCreatedTime(now())->setUpdateTime(now());

            	$abo->save();
            }
                
        }
        return $this;
    }

    protected function getProductId($sku)
    {
    	if($this->_lastSku == $sku)
    	{
    		return $this->_lastProductId;
    	}
    	/* @var $product Mage_Catalog_Model_Product */
    	$product = Mage::getModel('catalog/product');
    	$id = $product->getIdBySku($sku);
    	if($id)
    	{
    		$this->_lastProductId = $id;
    		$this->_lastSku = $sku;
    		return $this->_lastProductId;
    	}
    	
    	return null;
    }
    
    protected function getPeriodeId($product_id)
    {
    	
    
    	if($this->_lastProductId4Periode == $product_id)
    	{
    		return $this->_lastPeriodeId;
    	}
    	$this->_lastPeriodeId == null;
    	/* @var $product Mage_Catalog_Model_Product */
    	$collection = Mage::getModel('periode/periode')->getCollection();
    	$collection->getSelect()->where('product_id=?', $product_id);
    	
    	if(count($collection->getItems()) != 1)
    	{
    		return null;
    	}
    	
    	foreach ($collection->getItems() as $periode)
    	{
    		$this->_lastPeriodeId = $periode->getId();
    	}
    	
    	return $this->_lastPeriodeId;
    }
   

    protected function getCustomerId($email)
    {
    	$email = strtolower($email);
    	if($this->_customers == null)
    	{
    		/* @var $collection Mage_Customer_Model_Resource_Customer_Collection */
    		$collection = Mage::getModel('customer/customer')->getCollection();
    		$this->_customers = array();
    		foreach ($collection->getItems() as $customer)
    		{
    			$this->_customers[strtolower($customer->getEmail())] = $customer->getId();
    		}
    	}
    	
    	if(isset($this->_customers[$email]))
    	{
    		return $this->_customers[$email];
    	}
    	
    	return 0;
    	
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
       return self::SCOPE_NULL;
       
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
     	if (isset($this->_validatedRows[$rowNum])) { // check that row is already validated
            return !isset($this->_invalidRows[$rowNum]);
        }
        
        $this->_validatedRows[$rowNum] = true;

        
        foreach ($this->_permanentAttributes as $att)
        {
        	if(!isset($rowData[$att]) || (strlen(trim($rowData[$att])) == 0))
        	{
        		$this->addRowError($att . ' fehlt', $rowNum);
         	}
        }        
        

        $sku = $rowData['artikelnr'];
        $rowData['product_id'] =	$this->getProductId($sku);
        if($rowData['product_id'] == null)
        {
        	$this->addRowError('Produkt mit der Artikelnummer '. $sku . ' wurde nicht gefunden.', $rowNum);
        }else
        {
        	$rowData['periode_id'] = $this->getPeriodeId($rowData['product_id']);
        	if($rowData['periode_id'] == null)
        	{
        		$this->addRowError('Periode für Artikel '. $sku . ' wurde nicht gefunden oder ist nicht eindeutig.', $rowNum);
        	}
        }
       
        
        $rowData['station1_id'] = $this->getStationID($rowData['station1']);
        if($rowData['station1_id'] == 0)
        {
        	$this->addRowError('Station 1 Kenn: ' . $rowData['station1'].' nicht gefunden', $rowNum);
        }
         
        if(strlen($rowData['station2']) > 0)
        {
        	$rowData['station2_id'] = $this->getStationID($rowData['station2']);
        	if($rowData['station2_id'] == 0)
        	{
        		$this->addRowError('Station 2 Kenn: ' . $rowData['station2'].' nicht gefunden', $rowNum);
           	}
        }
         
        if(strlen($rowData['station3']) > 0)
        {
        	$rowData['station3_id'] = $this->getStationID($rowData['station3']);
        	if($rowData['station3_id'] == 0)
        	{
        		$this->addRowError('Station 3 Kenn: ' . $rowData['station3'].' nicht gefunden', $rowNum);

        	}
        }
        
        $email = $rowData['email'];
        $rowData['customer_id'] =	$this->getCustomerId($email);
        $rowData['address_id'] = 0;
        if($rowData['customer_id'] > 0)
        {
        	$rowData['address_id'] =	$this->getAddressId($rowData);
        }
        
  
        $this->_currentrowData = $rowData;

        return !isset($this->_invalidRows[$rowNum]);
    }
    
    
    
    /**
     * evt. vorhandene Adressen vergleichen und id zurückgeben
     * @param array $rowData
     * @return <mixed, NULL, multitype:>|number
     */
    protected function getAddressId($rowData)
    {
    	$addresses = Mage::getModel('customer/address')->getCollection();
    	$addresses->getSelect()->where('parent_id=?', $rowData['customer_id']);
    	$addresses->addAttributeToSelect('*');
    	$check = array('vorname'=>'firstname', 'nachname'=>'lastname', 'ort' =>'city', 'strasse' => 'street','plz'=>'postcode');
    	foreach($addresses as $adr)
    	{
    		$count = 0;
    		foreach( $check as $k=> $v)
    		{
    			if($rowData[$k] == $adr->getData($v))
    			{
    				$count++;
    			}
    		}
    		if($count == count($check))
    		{
    			return $adr->getId();
    		}
    		
    	}
    	
    	return 0;
    }
    

    private function getStationID($station)
    {
    	if($this->_stationen == null)
    	{
    		$st = Mage::getModel('stationen/stationen')->getCollection();
    		$this->_stationen = array_flip($st->getOptionArray());  		
    	}
    	
    	if(isset($this->_stationen[$station]))
    	{
    		return $this->_stationen[$station];
    	}
    	
    	return 0;
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
    	
    	//$p['product_id'] = $this->_parameters['product_id'];
    	$p['website_id'] = $this->_parameters['website'];
    	$p['store_id'] = $this->_parameters['store'];
    	//$p['_product_websites'] = Mage::getModel('core/website')->load($this->_parameters['website'])->getCode();
    	//$p['_store'] = Mage::getModel('core/store')->load($this->_parameters['store'])->getCode();
    	
	 	
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
 	
 	public function getAttributeOptions(Mage_Eav_Model_Entity_Attribute_Abstract $attribute, $indexValAttrs = array())
 	{
 		$options = array();
 	
 		if ($attribute->usesSource()) {
 			// merge global entity index value attributes
 			$indexValAttrs = array_merge($indexValAttrs, $this->_indexValueAttributes);
 	
 			// should attribute has index (option value) instead of a label?
 			$index = in_array($attribute->getAttributeCode(), $indexValAttrs) ? 'value' : 'label';
 	
 			// only default (admin) store values used
 			$attribute->setStoreId(Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
 	
 			try {
 				foreach ($attribute->getSource()->getAllOptions(false) as $option) {
 					if(!isset($option['value'])){
 						$option = array();
 						$option['value'] = "";
 					}
 					$value = is_array($option['value']) ? $option['value'] : array($option);
 					foreach ($value as $innerOption) {
 						if(!isset($innerOption['value'])){
 							$innerOption['value'] = "";
 						}
 						if(!isset($innerOption[$index])){
 							$innerOption[$index] = "";
 						}
 						if (strlen($innerOption['value'])) { // skip ' -- Please Select -- ' option
 							$options[strtolower($innerOption[$index])] = $innerOption['value'];
 						}
 					}
 				}
 			} catch (Exception $e) {
 				// ignore exceptions connected with source models
 			}
 		}
 		return $options;
 	}
    
}
