<?php
/**
 * Configurable Downloadable Product Type Instance
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @author     	Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable extends Mage_Downloadable_Model_Product_Type
{
	/**
	 * Type ID
	 * 
	 * Muss mit XML übereinstimmen!!
	 * 
	 * @var string
	 */
    const TYPE_CONFIGURABLE_DOWNLOADABLE = 'configdownloadable';
    
    
    private $_stationen = null;
    private $_reloadedProduct = null;
    
    
    /**
     * Get downloadable product links
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return array
     */
    public function getDynlinks($product = null)
    {
    	$product = $this->getProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    	if (is_null($product->getDownloadableDynlinks())) {
    		$_linkCollection = Mage::getModel('configdownloadable/link')->getCollection()
	    		->addProductToFilter($product->getId())
	    		->addTitleToResult($product->getStoreId())
	    		->addPriceToResult($product->getStore()->getWebsiteId()
	    	);
    		$linksCollectionById = array();
    		foreach ($_linkCollection as $link) {
    			/* @var Mage_Downloadable_Model_Link $link */
    
    			$link->setProduct($product);
    			$linksCollectionById[$link->getId()] = $link;
    		}
    		$product->setDownloadableDynlinks($linksCollectionById);
    	}
    	return $product->getDownloadableDynlinks();
    }
    
    /**
     * Save Product downloadable information (links and samples)
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return Mage_Downloadable_Model_Product_Type
     */
    public function save($product = null)
    {
    	$product = $this->getProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    	
    	/* Das Löschen von Links muss an das Model von Extended Link übergeben werden */
    	if ($data = $product->getDownloadableData()) {
    		if (isset($data['link'])) {
    			$_deleteItems = array();
    			$_linkedFiles = array();
    			foreach ($data['link'] as $i => $linkItem) {
    				if ($linkItem['is_delete'] == '1') {
    					if ($linkItem['link_id']) {
    						$_deleteItems[] = $linkItem['link_id'];
    						if ($linkItem['link_file_id']) {
    							if (array_key_exists($linkItem['link_file_id'], $_linkedFiles)) {
    								$_linkedFiles[$linkItem['link_file_id']] = $_linkedFiles[$linkItem['link_file_id']] + 1;
    							} else {
    								$_linkedFiles[$linkItem['link_file_id']] = 1;
    							}
    						}
    						unset($data['link'][$i]);
    					}
    				}
    			}
    			if ($_deleteItems) {
    				Mage::getResourceModel('configdownloadable/extendedlink')->deleteItems(
    					array ('delete' => $_deleteItems, 'links' => $_linkedFiles)
    				);
    				$data['link'] = array_values($data['link']);
    				$product->setDownloadableData($data);
    			}
    		}
    	}
    	parent::save($product);
    
    	$product = $this->getProduct($product);
    	$this->setProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    
    	if ($data = $product->getConfigdownloadableData()) {
    		if (isset($data['link'])) {
    			$_deleteItems = array();
    			foreach ($data['link'] as $linkItem) {
    				if ($linkItem['is_delete'] == '1') {
    					if ($linkItem['link_id']) {
    						$_deleteItems[] = $linkItem['link_id'];
    					}
    				} else {
    					$this->addLinkItem($linkItem);
    				}
    			}
    			if ($_deleteItems) {
    				Mage::getResourceModel('configdownloadable/link')->deleteItems($_deleteItems);
    			}
    			if ($this->getProduct($product)->getLinksPurchasedSeparately()) {
    				$this->getProduct($product)->setIsCustomOptionChanged();
    			}
    		}
    	}
    	
    	return $this;
    }
    
    /**
     * Erzeugt einen neuen Link-Eintrag für Downloads in der Datenbank
     * 
     * @param array  $linkItem    Daten
     * @param array  $files       Dateien
     * @param string $baseTmpPath Basispfad für Dateien
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable
     */
    public function addLinkItem($linkItem, $files = array(), $baseTmpPath = null) {
    	/* @var Mage_Catalog_Model_Product $product */
    	$product = $this->getProduct();    	
    	
    	unset($linkItem['is_delete']);
    	if (!isset($linkItem['link_id']) || empty($linkItem['link_id'])) {
    		unset($linkItem['link_id']);
    	}
    	
    	if (isset($linkItem['file'])) {
    		$files = Mage::helper('core')->jsonDecode($linkItem['file']);
    		unset($linkItem['file']);
    	}
    	$sample = array();
    	if (isset($linkItem['sample'])) {
    		$sample = $linkItem['sample'];
    		unset($linkItem['sample']);
    	}
    	$model = 'configdownloadable/link';
    	if (isset($linkItem['model'])) {
    		$model = $linkItem['model'];
    		unset ($linkItem['model']);
    	}
    			
    	$linkModel = Mage::getModel($model)
	    	->setData($linkItem)
	    	->setLinkType($linkItem['type'])
	    	->setProductId($product->getId())
	    	->setStoreId($product->getStoreId())
	    	->setWebsiteId($product->getStore()->getWebsiteId())
	    	->setProductWebsiteIds($product->getWebsiteIds())
    	;
    	if (null === $linkModel->getPrice()) {
    		$linkModel->setPrice(0);
    	}
    	if ($linkModel->getIsUnlimited()) {
    		$linkModel->setNumberOfDownloads(0);
    	}
    	$sampleFile = array();
    	if ($sample && isset($sample['type'])) {
    		if ($sample['type'] == 'url' && $sample['url'] != '') {
    			$linkModel->setSampleUrl($sample['url']);
    		}
    		$linkModel->setSampleType($sample['type']);
    		$sampleFile = Mage::helper('core')->jsonDecode($sample['file']);
    	}
    	//Wird nur vom Assigner benutzt
    	if ($linkModel->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_FILE) {
    		$replaceDuplicates = $product->getReplaceDuplicates() == 1 ? true : false;
    		$linkFileName = Mage::helper('configdownloadable/file')->copyFileFromTmpWithDispretionPath(
    				is_null($baseTmpPath) ? Mage_Downloadable_Model_Link::getBaseTmpPath() : $baseTmpPath,
    				Mage_Downloadable_Model_Link::getBasePath(),
    				$files,
    				$replaceDuplicates
    		);
    		$linkModel->setLinkFile($linkFileName);
    		
    		/* @var $linkFileItem Dwd_ConfigurableDownloadable_Model_Link_File */
    		$linkFileItem = Mage::getModel('configdownloadable/link_file')->loadByFileName($linkFileName);
    		if (!$linkFileItem->isEmpty()) {
    			$linkFileItemId = $linkFileItem->getId();
    			$linkModel->setLinkFileId($linkFileItemId);
    		} else {
    			$linkFileItem->setLinkFile($linkFileName);
    			$linkFileItem->setLinkType('file');
    		}
    		
    		//Wird schon mit setData übergeben
    		//$linkModel->setValidTo($linkItem['valid_to']);
    		
    		if ($replaceDuplicates) {
    			if ($linkFileItem->getId() < 1) {
    				$linkFileItemId = $this->_updateLinkFileItem($linkFileItem);
    				$linkModel->setLinkFileId($linkFileItemId);
    			}
    			/* @var $collection Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection */
    			$collection = Mage::getModel('configdownloadable/extendedlink')->getCollection();
    			//TODO : Durch getIdFieldName ersetzen -> collection->getIdFieldName funktioniert nicht!!!!
    			$collection->addFieldToSelect('link_id')
    						->addFieldToFilter('product_id', $linkModel->getProductId())
    						//->addFieldToFilter('link_file', $linkModel->getLinkFile())
    						->addFieldToFilter('link_file_id', $linkModel->getLinkFileId())
    						->addFieldToFilter('link_station_id', $linkModel->getLinkStationId())
    						->addFieldToFilter('data_valid_from', $linkModel->getDataValidFrom())
    						->addFieldToFilter('data_valid_to', $linkModel->getDataValidTo())
    			;
    			$itemWithId = $collection->getFirstItem();
    			if (isset($itemWithId) && !$itemWithId->isEmpty()) {
    				$linkModel->setLinkId($itemWithId->getId());
    			}
    		} else {
    			$linkFileItemId = $this->_updateLinkFileItem($linkFileItem);
    			$linkModel->setLinkFileId($linkFileItemId);
    		}
    		
    	}
    	//Wird beim anlegen dynamischer Links benutzt
    	if ($linkModel->getSampleType() == Mage_Downloadable_Helper_Download::LINK_TYPE_FILE) {
    		$linkSampleFileName = Mage::helper('configdownloadable/file')->moveFileFromTmp(
    				Mage_Downloadable_Model_Link::getBaseSampleTmpPath(),
    				Mage_Downloadable_Model_Link::getBaseSamplePath(),
    				$sampleFile
    		);
    		$linkModel->setSampleFile($linkSampleFileName);
    	}
    	$linkModel->save();
    	
    	return $this;
    }
    
    /**
     * Liefert ein Array von Perioden
     * 
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return array<Dwd_Periode_Model_Periode>
     */
    public function getPeriodes($product = null) {
    	if (!$product) {
    		$product = $this->getProduct();
    	}
    	$collection = Mage::getModel('periode/periode')->getCollection();
    	$collection->getSelect()->where('product_id=?',intval($product->getId()));
    	
    	return $collection->getItems();
    }
    
    /**
     * Verwendete Link-File-Anzahl erhöhen
     * 
     * @param string|Dwd_ConfigurableDownloadable_Model_Link_File $linkFile Name oder Instanz
     * 
     * @return int
     */
    protected function _updateLinkFileItem($linkFile) {
    	if (is_string($linkFile)) {
	    	/* @var $linkFileItem Dwd_ConfigurableDownloadable_Model_Link_File */
	    	$linkFileItem = Mage::getModel('configdownloadable/link_file')->loadByFileName($linkFile);
	    	
	    	if ($linkFileItem->isEmpty()) {
	    		$linkFileItem->setLinkFile($linkFile);
	    		$linkFileItem->setLinkType('file');
	    	}
    	} elseif ($linkFile instanceof Dwd_ConfigurableDownloadable_Model_Link_File && !$linkFile->isEmpty()) {
    		$linkFileItem = $linkFile;
    	} else {
    		Mage::throwException('Parameter missmatch. Non empty object or string expected!');
    	}
    	
    	$linkFileItem->increase()
    		->save()
    	;
    	
    	return $linkFileItem->getId();
    }
    
    /**
     * Prüft ob das Produkt konfigurierbare Angaben besitzt.<br/>
     * 
     * @param Mage_Catalog_Block_Product $product Produkt
     * 
     * @return boolean
     * 
     * @see Mage_Downloadable_Model_Product_Type::canConfigure()
     */
	public function canConfigure($product = null) {
    	$set = $this->getReloadedProduct($product)->getStationenSet() != null;
    	$periode = Mage::getModel('periode/periode')->getProductHasPeriodeOption($product->getId());
    	return $set || ($periode > 1);
    	
    }
    
    /**
     * Prüft ob das Produkt weitere Optionen benötigt.
     * 
     * @param Mage_Catalog_Block_Product $product Produkt
     * 
     * @return boolean
     * 
     * @see Mage_Downloadable_Model_Product_Type::hasRequiredOptions()
     */
    public function hasRequiredOptions($product = null) {
       	$set = $this->getReloadedProduct($product)->getStationenSet() != null;
    	$periode = Mage::getModel('periode/periode')->getProductHasPeriodeOption($product->getId());
    	return $set || ($periode > 1);
    }
    
    /**
     * Liefert Downloadable Links
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return array
     */
    public function getLinksForSale($product = null) {
    	$product = $this->getProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    	if (is_null($product->getDownloadableLinks())) {
    		$stationId = $product->getCustomOption('station_id');
    		$periodeId = $product->getCustomOption('periode_id');
    		/* @var $periodeItem Dwd_Periode_Model_Periode */
    		if (!$periodeId) {
    			$periodeItem = Dwd_Periode_Model_Periode::getNewOneDayDuration();
    		} else {
	    		$periodeItem = Mage::getModel('periode/periode')->load($periodeId->getValue());
	    		if ($periodeItem->isEmpty()) {
	    			$periodeItem = Dwd_Periode_Model_Periode::getNewOneDayDuration();
	    		}
    		}
    		
    		/* @var $_linkCollection Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection */
    		$_linkCollection = Mage::getModel('configdownloadable/extendedlink')->getCollection();
    		$_linkCollection->getSelect()->order('updated_at DESC');
    		$_linkCollection
	    		->addProductToFilter($product->getId())
	    		->addFieldToFilter('link_station_id', $stationId->getValue())
	    		->addOrder('updated_at')
	    		->addTitleToResult($product->getStoreId())
	    		->addPriceToResult($product->getStore()->getWebsiteId())
	    	;
    		if (!$periodeId) {
    			//Für Prognose darf nur das neueste Item genutzt werden
    			$_linkCollection->getSelect()->limit(1);
    			$_linkCollection->addFieldToFilter('data_valid_from', array(
    					'from'=>$periodeItem->getStartZendDate()->subDay(1)->toString(Dwd_Periode_Model_Periode::MAGENTO_DATETIME),
    					'to' => $periodeItem->getStartDate()))
    				->addFieldToFilter('data_valid_to', array('from'=>$periodeItem->getStartDate(), 'to' => $periodeItem->getEndDate()))
    			;
    		} else {
    			//Rückblicksdaten
    			$_linkCollection->addFieldToFilter('data_valid_from', array('from'=>$periodeItem->getStartDate(), 'to' => $periodeItem->getEndDate()))
    				->addFieldToFilter('data_valid_to', array('from'=>$periodeItem->getStartDate(), 'to' => $periodeItem->getEndDate()))
    			;
    		}
    		Mage::log(sprintf("getLinksForSale SQL: \n%s", $_linkCollection->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
    		$linksCollectionById = array();    		
	    	foreach ($_linkCollection as $link) {
	    		/* @var Dwd_ConfigurableDownloadable_Model_Extendedlink $link */
	    		$link->setProduct($product);
	    		$linksCollectionById[$link->getId()] = $link;
	    	}
    		
    		$product->setDownloadableLinks($linksCollectionById);
    	}
    	return $product->getDownloadableLinks();
    }
    
    /**
     * Liefert Labels der verfügbaren Perioden der Links
     *
     * @param Mage_Catalog_Model_Product $product Produkt
     *
     * @return array
     */
    public function getLinksForSaleAvailablePeriodeInformation($product = null) {
    	/* @var Mage_Catalog_Model_Product $product */
    	$product = $this->getProduct($product);
    	
    	/* @var $_linkCollection Dwd_ConfigurableDownloadable_Model_Resource_Extendedlink_Collection */
    	$_linkCollection = Mage::getModel('configdownloadable/extendedlink')->getCollection()
		    	->addProductToFilter($product->getId())
    	;
    	$_linkCollection->addFieldToSelect('periode_label')
    			->distinct(true)
    			->addFieldToFilter('link_file_id', array('notnull' => true))
    			->addFieldToFilter('periode_label', array('notnull' => true))
    	;
    	/* @var $stationId Mage_Catalog_Model_Product_Configuration_Item_Option */
    	$stationId = $product->getCustomOption('station_id');
    	if ($stationId && !$stationId->isEmpty()) {
    		$_linkCollection->addFieldToFilter('link_station_id', $stationId->getValue());
    	}
    	
    	$availablePeriodesForLinks = array();
    	foreach ($_linkCollection as $link) {
    		/* @var Dwd_ConfigurableDownloadable_Model_Extendedlink $link */
    		$label = trim($link->getPeriodeLabel());
    		if ($label && strlen($label) > 0) {
    			$availablePeriodesForLinks[] = $label;
    		}
    	}
    	
    	return $availablePeriodesForLinks;
    }
    
    /**
     * Bereitet das Produkt für den Kauf vor
     * 
     * Die verfügbaren Links werden unter Einbeziehung der Station und einer optionalen Periode ermittelt und hizugefügt.
     * Sollte keine Periode verfügbar sein, wird eine Periode mit einem Tag Gültigkeit verwendet.
     * 
     * @param Varien_Object              $buyRequest  BuyRequest
     * @param Mage_Catalog_Model_Product $product     Produkt
     * @param string                     $processMode Process Mode
     * 
     * @return string|array
     * 
     * @see Mage_Downloadable_Model_Product_Type::_prepareProduct()
     */
    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
    	$station = $buyRequest->getStation();
    	if ($station) {
    		$this->getProduct($product)->addCustomOption('station_id', $station);
    	} else {
    		return Mage::helper('stationen')->__('Please specify station.');
    	}    	
    	
    	
        $periodId = $buyRequest->getPeriode();
    	if ($periodId) {
            $this->getProduct($product)->addCustomOption('periode_id', $periodId);
            //return $result;
        } else {
        	
        	$periode = Mage::getModel('periode/periode');
        	$ids = $periode->getProductPeriodeIds($product->getId());
        	if(count($ids) > 1)
        	{
        		return Mage::helper('periode')->__('Please specify periode.');
        	}
        	else if (count($ids) == 1)
        	{
        		$periode_id = array_shift($ids);
        		$buyRequest->setPeriode($periode_id);
        		$this->getProduct($product)->addCustomOption('periode_id', $periode_id);
        	}
        }
    	
    	$linksForSale = $this->getLinksForSale($this->getProduct($product));
    	$buyRequest->setLinks(array_keys($linksForSale));
    	if (!$buyRequest->hasLinks() || count($buyRequest->getLinks()) < 1) {
    		if ($station) {
    			$msg = 'No data for this station available.';
    		} else {
    			//TODO : configdownloadable auch ohne Stations verfügbar machen!
    		}
    		$availablePeriodes = $this->getLinksForSaleAvailablePeriodeInformation($this->getProduct($product));
    		if (count($availablePeriodes) > 0) {
    			$availablePeriodes = trim(implode(', ', $availablePeriodes));
    			if (strlen($availablePeriodes) > 0) {
    				$msg = 'Data only for following periodes available: %s';
    			}
    		} else {
    			$availablePeriodes = '';
    		}
    		
    		return Mage::helper('configdownloadable')->__($msg, $availablePeriodes);
    	}
    	$this->getProduct($product)->setLinksPurchasedSeparately(true);
    	
    	$result = parent::_prepareProduct($buyRequest, $product, $processMode);

    	if (is_string($result)) {
    		return $result;
    	}   	

    	return $result;
    }

    /**
     * Liefert alle Stationen des Produktes
     * 
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return array <Dwd_Stationen_Model_Stationen>|null Liste von Stationen oder null falls kein Set konfiguiert wurde
     */
    public function getStationen($product = null) {
    	if (!$product) {
    		$product = $this->getProduct();
    	}
    	if ($this->_stationen == null) {
    		if ($product && $product->getStationenSet()) {
    			$set = Mage::getModel('stationen/set')->load($product->getStationenSet());
    			$this->_stationen = $set->getStationen();
    		}
    	}
    	return $this->_stationen;
    }
    
    public function getReloadedProduct($product) {
    	if ($this->_reloadedProduct == null) {
    		$this->_reloadedProduct = Mage::getModel('catalog/product')->load($product->getId());
    	}
    	return $this->_reloadedProduct;
    }
    
    /**
     * Prüft ob das Produkt Links zum Download besitzt
     * 
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return boolean True falls es Links gibt, sonst false
     * 
     * @see Mage_Downloadable_Model_Product_Type::hasLinks()
     */
    public function hasLinks($product = null) {    	
    	if ($this->getProduct($product)->hasData('links_exist')) {
    		return $this->getProduct($product)->getData('links_exist');
    	}

    	$product = $this->getProduct($product);
    	/* @var $product Mage_Catalog_Model_Product */
		
    	$_linkCollection = Mage::getModel('downloadable/link')->getCollection();
    	/* @var $_linkCollection Mage_Downloadable_Model_Resource_Link_Collection */
    	$_linkCollection
    		->addProductToFilter($product->getId())
    		->addFieldToSelect(Mage::getModel('downloadable/link')->getIdFieldName())
    		->getSelect()->limit(1)
    	;
    	if ($_linkCollection->count() > 0) {
    		$product->setLinksExist(true);
    	} else {
    		$product->setLinksExist(false);
    	}
    	return $product->getLinksExist();
    }
}
