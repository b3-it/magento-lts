<?php
/**
 * AutoFileAssigner (AFA) dient zur automatischen Zuweisung von Dateien zu ausgewählten Produkten.
 *
 * @category	Dwd
 * @package		Dwd_AutoFileAssignment
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_AutoFileAssignment_Model_Assigner extends Mage_Core_Model_Abstract
{
	const XML_PATH_STORAGE              = 'catalog/dwd_afa/storage';

	const TREE_MAX_DEEPEST_LEVEL		= 5;

	const TREE_MAX_WIDTH = 10;

	const FILE_ERRORS_MAX = 20;

	/**
	 * Fehlerzähler für Dateizuordnungen
	 *
	 * @var int
	 */
	protected $_errors = 0;

	/**
	 * Gibt an ob ein Tree für das Matching mit Dateien und Patterns genutzt werden soll
	 *
	 * @var bool
	 */
	protected $_useTreeForAssignment = false;

	/**
	 * Gibt an ob der Tree bereits erzeugt wurde.
	 *
	 * @var bool
	 */
	protected $_patternTreeIsBuild = false;

	/**
	 * Gibt an ob beim Erzeugen des Trees Fehhler auftraten
	 *
	 * @var bool
	 */
	protected $_treeHasErrors = false;

	/**
	 * Tree für Patterns
	 *
	 * @var array
	 */
	protected $_patternTree = array('tree_width' => 0);

	/**
	 * Array für Patterns
	 *
	 * Alte Variante
	 *
	 * @var array
	 * @deprecated Es sollte $_patternTree genutzt werden
	 */
	protected $_patterns = array();

	/**
	 * LaufzeitProbleme behandeln;
	 */
	protected $_startTime = 0;

	/**
	 * Aktuellen Speicherverbrauch ermitteln
	 *
	 * Liefert den aktuell genutzten Speicher als String in MB
	 *
	 * @return string
	 */
	protected function _getMemoryUsage() {
		$mem = memory_get_usage() /1024 / 1024;
		$memstr = number_format($mem, 2)." MB";

		return $memstr;
	}

	/**
	 * Liefert den Maximalwert für die Tiefe des Trees
	 *
	 * @param string $pattern
	 *
	 * @return int
	 */
	protected function _getTreeMaxLevel($pattern) {
		$qMark = strpos($pattern, '?');
		$qMark = $qMark === false ? self::TREE_MAX_DEEPEST_LEVEL + 1 : $qMark + 1;
		$wMark = strpos($pattern, '*');
		$wMark = $wMark === false ? self::TREE_MAX_DEEPEST_LEVEL + 1 : $wMark + 1;
		return min($qMark, $wMark, strlen($pattern), self::TREE_MAX_DEEPEST_LEVEL);
	}

	/**
	 * Verarbeitet die Produktdaten aus der DB
	 *
	 * Es wird beim ersten Aufruf, falls Tree benutzt werden soll, ein Tree erzeugt.
	 * Schlägt das Erzeugen des Tree fehl, wird die Funktion mit false beendet.
	 * Beim nächsten Aufruf wird dann ein Mehrdimensionales Array erzeugt.
	 * Die Variante mit Tree sollte bevorzugt werden, da sie wesentlich schneller ist.
	 *
	 * @return bool True falls DB Daten erfolreich verarbeitet wurden, fals sonst.
	 */
	protected function _processDbData() {
		/*
		 * 20130313::Frank Rochlitzer
		* Aktuelle Bedingungen:
		*  - ca 2300 Stationen insgesamt vorhanden
		*  - Stationensets haben große Schnittmengen
		* Annahmen:
		*  - Anzahl Stationen >> Anzahl Produkte (Aktuell 100:1)
		*/
		Mage::log("dwdafa::Processing DB data...", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
		$_dbDataProcessingTimeStart = time();

		/* @var $productCollection Mage_Catalog_Model_Resource_Product_Collection */
		$productCollection = Mage::getResourceModel('catalog/product_collection');
		$productCollection->addAttributeToFilter('type_id', Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE)
			->addAttributeToSelect('stationen_set')
			->addAttributeToSelect('storage_time')
			->addAttributeToSelect('replace_duplicates')
		;
		$this->_patterns = array();
		$totalData = 0;
		$_buildingPatternTreeTimeStart = time();
		$_loops = 0;
		$_modulo = 1;
		$_forTimeEnd = 0;
		$_patternTimeSetEnd = 0;
		/*
		 * 20160421:: Frank Rochlitzer
		 * Referenz von $product (Zeile 329) ist in Tree sonst immer die des aktuellsten Produkts
		 * Zeile 332: $_currentTreeLevel[$finalPattern][$dynLnkId][] = array('template' => &$finalLinkItem, 'product' => &$product);
		 */
		$productList = $productCollection->getItems();
		unset($productCollection);
		foreach ($productList as &$product) {
			if (!($product instanceof Mage_Catalog_Model_Product)) {
				continue;
			}

			if (!$this->_useTreeForAssignment) {
				$this->_patterns[$product->getId()] = array('product' => $product, 'dyn_links' => array());
			}
			$dynLinks = $product->getTypeInstance()->getDynlinks($product);
			$stations = $product->getTypeInstance()->getStationen($product);
			$periodes = $product->getTypeInstance()->getPeriodes($product);

			if (empty($stations)) {
				$station = new Varien_Object();
				$station->setStationskennung('');
				$stations = array($station);
			}

			//Falls keine Periode verfügbar, so wird von Prognose mit einem Tag Gültigkeit ausgegangen
			if (empty($periodes)) {
				$periodes[] = Dwd_Periode_Model_Periode::getNewOneDayDuration();
			}

			if ($product->getStorageTime() != 0) {
				/*
				 * 20130206::Frank Rochlitzer
				* Es muss immer von aktueller Zeit ausgegangen werden und nie von den Zeiten
				* der konfigurierten Perioden. Diese könnten auch in der Vergangenheit liegen!
				*/
				//Gibt das Datum an bis wann die Datei vorgehalten wird.
				$linkItemValidTo = Dwd_Periode_Model_Periode::getNewOneDayDuration($product->getStorageTime())->getEndDate();
			}

			$stationKeys = array_keys($stations);
			$nStations = count($stationKeys);
			Mage::log(sprintf('dwdafa::Found %s stations for product ID %s', $nStations, $product->getId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			foreach ($dynLinks as $dynLink) {
				if (!($dynLink instanceof Dwd_ConfigurableDownloadable_Model_Link)) {
					continue;
				}

				if (!$this->_useTreeForAssignment) {
					$this->_patterns[$product->getId()]['dyn_links'][$dynLink->getId()] = array();
				}
				/* Unverändertes Pattern */
				$basePattern = $dynLink->getLinkPattern();
				//HK Mage::log(sprintf('dwdafa::Pattern before replace:%s', $basePattern), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

				$tmpPatterns = array();
				/* @var $periode Dwd_Periode_Model_Periode */
				foreach ($periodes as $periode) {
					//HK Mage::log(sprintf('dwdafa::Processing periode %s', $periode->getId()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

					$pattern = $basePattern;

					//Reihenfolge ist für parsen wichtig (lang -> kurz)
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_YEAR_SHORT,
							$periode->getStartZendDate()->get(Zend_Date::YEAR_SHORT),
							$pattern
					);
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_YEAR,
							$periode->getStartZendDate()->get(Zend_Date::YEAR),
							$pattern
					);
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_MONTH,
							$periode->getStartZendDate()->get(Zend_Date::MONTH),
							$pattern
					);
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_MONTH_SHORT,
							$periode->getStartZendDate()->get(Zend_Date::MONTH_SHORT),
							$pattern
					);
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_DAY,
							$periode->getStartZendDate()->get(Zend_Date::DAY),
							$pattern
					);
					$pattern = str_replace(
							Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_PERIODE_DAY_SHORT,
							$periode->getStartZendDate()->get(Zend_Date::DAY_SHORT),
							$pattern
					);

					//HK Mage::log(sprintf('dwdafa::Pattern after periode replaces:%s', $pattern), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					if (isset($tmpPatterns[$pattern])) {
						Mage::log(sprintf('dwdafa::Periode pattern already processed:%s, skipping', $pattern), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
						continue;
					}

					Mage::log(sprintf('dwdafa::Creating Template Link Item'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					/* Eine Array-Zuweisung ist immer eine Kopie */
					$linkItem = $dynLink->getData();

					unset($linkItem['link_id']);
					unset($linkItem['link_pattern']);
					unset($linkItem['product']);

					$linkItem['type'] = Mage_Downloadable_Helper_Download::LINK_TYPE_FILE;
					$linkItem['model'] = 'configdownloadable/extendedlink';
					if ($product->getStorageTime() != 0) {
						/*
						 * 20130206::Frank Rochlitzer
						* Es muss immer von aktueller Zeit ausgegangen werden und nie von den Zeiten
						* der konfigurierten Perioden. Diese könnten auch in der Vergangenheit liegen!
						*/
						//Gibt das Datum an bis wann die Datei vorgehalten wird.
						$linkItem['valid_to'] = $linkItemValidTo;
					}
					//Gibt den Zeitraum an von wann bis wann diese Daten gültig sind/waren
					$linkItem['data_valid_from'] = $periode->getStartDate();
					$linkItem['data_valid_to'] = $periode->getEndDate();
					$linkItem['periode_label'] = $periode->getLabel();

					$finalPattern = "";
					/* @var $station Dwd_Stationen_Model_Stationen */
					for ($i = 0; $i  < $nStations; $i++) {
						$station = &$stations[$stationKeys[$i]];
						//Mage::log(sprintf('dwdafa::Processing station %s', $station->getStationskennung()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						/* Original Pattern mit %sid muss erhalten bleiben */
						//HK Mage::log(sprintf('dwdafa::Pattern before station replace:%s', $pattern), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						$finalPattern = str_replace(Dwd_ConfigurableDownloadable_Model_Link::PLACEHOLDER_STATION_ID, $station->getStationskennung(), $pattern);

						//HK Mage::log(sprintf('dwdafa::Pattern after replace:%s', $finalPattern), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						if (!$this->_useTreeForAssignment && isset($this->_patterns[$product->getId()]['dyn_links'][$dynLink->getId()][$finalPattern])) {
							Mage::log(sprintf('dwdafa::Pattern already processed:%s, skipping', $finalPattern), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
							continue;
						}

						$finalLinkItem = $linkItem;

						$finalLinkItem['title'] = $station->getStationskennung();
						$finalLinkItem['link_station_id'] = $station->getId();

						$dynLnkId = $dynLink->getId();
						if (!$this->_useTreeForAssignment) {
							$this->_patterns[$product->getId()]['dyn_links'][$dynLnkId][$finalPattern] = $finalLinkItem;
						} else {
							//Tree erzeugen
							if ($this->_useTreeForAssignment && !$this->_patternTreeIsBuild && !$this->_treeHasErrors) {
								$_treeMaxLevel = $this->_getTreeMaxLevel($finalPattern);
								$_currentTreeLevel = &$this->_patternTree;
								$_forTimeStart = microtime(true);
								for ($j = 0; $j < $_treeMaxLevel; $j++) {
									$_currentWidth = $_currentTreeLevel['tree_width'];
									$_key = $finalPattern[$j];
									$_keyIsSet = isset($_currentTreeLevel[$_key]);
									if (!$_keyIsSet && $_currentWidth < self::TREE_MAX_WIDTH) {
										$_currentTreeLevel[$_key] = array('tree_width' => 0);
										$_currentTreeLevel['tree_width']++;
										$_currentTreeLevel['last_inserted'] = &$_currentTreeLevel[$_key];
										$_currentTreeLevel = &$_currentTreeLevel[$_key];
										continue;
									} else {
										//Falls schon vorhanden oder treeMaxWidth überschritten
										if ($_keyIsSet) {
											$_currentTreeLevel = &$_currentTreeLevel[$_key];
											continue;
										}
										if ($_currentWidth >= self::TREE_MAX_WIDTH) {
											if (isset($_currentTreeLevel['last_inserted'])) {
												$_currentTreeLevel = &$_currentTreeLevel['last_inserted'];
												continue;
											}
											end($_currentTreeLevel);
											$_lastInsertedKey = key($_currentTreeLevel);
											if ($_lastInsertedKey) {
												$_currentTreeLevel['last_inserted'] = &$_currentTreeLevel[$_lastInsertedKey];
												$_currentTreeLevel = &$_currentTreeLevel['last_inserted'];
											}
											continue;
										}
									}
									$this->_treeHasErrors = true;
									$this->_useTreeForAssignment = false;
									return !$this->_treeHasErrors;
								}
								$_patternTimeSet = microtime(true);
								$_forTimeEnd += ($_patternTimeSet - $_forTimeStart);
								if (!empty($_currentTreeLevel)) {
									if (!isset($_currentTreeLevel[$finalPattern])) {
										$_currentTreeLevel[$finalPattern] = array();
									}
									if (!isset($_currentTreeLevel[$finalPattern][$dynLnkId])) {
										$_currentTreeLevel[$finalPattern][$dynLnkId] = array();
									}
									$_currentTreeLevel[$finalPattern][$dynLnkId][] = array('template' => $finalLinkItem, 'product' => &$product);
								} else {
									$this->_treeHasErrors = true;
									$this->_useTreeForAssignment = false;
									return !$this->_treeHasErrors;
								}
								$_patternTimeSetEnd += (microtime(true) - $_patternTimeSet);
							}
						}
						$_loops++;
						if ($_loops % $_modulo == 0) {
							if ($_loops < 1000) {
								$_modulo = 100;
							} elseif ($_loops >= 1000 && $_loops < 10000) {
								$_modulo = 1000;
							} elseif ($_loops >= 10000 && $_loops < 100000) {
								$_modulo = 10000;
							} elseif ($_loops >= 100000 && $_loops < 1000000) {
								$_modulo = 100000;
							} elseif ($_loops >= 1000000) {
								$_modulo = 1000000;
							}
							$mem = memory_get_usage() /1024 / 1024;
							$memstr = number_format($mem, 2)." MB";
							Mage::log(sprintf("dwdafa::%s loops counted...; Memory usage: %s; Avg for loop time: %s, Avg pattern set time: %s", $_loops, $memstr, $_forTimeEnd / $_loops, $_patternTimeSetEnd  / $_loops), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						}
						$totalData++;
					}
					Mage::log(sprintf('dwdafa::Processing %s stations, pattern %s', $nStations, $pattern), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					$tmpPatterns[$pattern] = true;
				}
				unset($tmpPatterns);
			}
		}
		unset($stations);
		unset($stationKeys);
		unset($dynLinks);
		unset($periodes);

		//Falls PatternTree ohne Fehler gebaut wurde, Flag für Complete setzen
		if ($this->_useTreeForAssignment && !$this->_treeHasErrors && !$this->_patternTreeIsBuild) {
			Mage::log(sprintf("Pattern tree was build in %s seconds.", time() - $_buildingPatternTreeTimeStart), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
			$this->_patternTreeIsBuild = true;
		} elseif ($this->_useTreeForAssignment && !$this->_patternTreeIsBuild) {
			Mage::log("Pattern tree was not build without errors! Pattern tree can't be used!", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			$this->_patternTreeIsBuild = true;
		}

		Mage::log(
			sprintf(
				"dwdafa::Processed %s data entries from DB in %s seconds, current memory usage %s, processing now real files...",
				$totalData,
				(int) time() - $_dbDataProcessingTimeStart,
				$this->_getMemoryUsage()
				),
			Zend_Log::INFO,
			Egovs_Helper::LOG_FILE
		);

		return true;
	}
	/**
	 * 1. Liste von Configurable Downloads erstellen
	 * 2. Liste der dynamischen Links durchlaufen und Pro Stationseintrag und einer gefundenen Datei einen Link erstellen
	 *
	 * @throws Dwd_AutoFileAssignment_Exception
	 *
	 * @return void
	 */
	public function autoAssign() {
		$this->_startTime = (int) time();
		Mage::log(sprintf("dwdafa::Assignment started with %s memory usage...", $this->_getMemoryUsage()), Zend_Log::INFO, Egovs_Helper::LOG_FILE);
		$this->_errors = 0;
		$this->_useTreeForAssignment = Mage::getStoreConfigFlag('catalog/dwd_afa/use_tree_assignment');

		$storagePath = $this->getConfigStorage();
		if (!file_exists($storagePath)) {
            /** @noinspection MkdirRaceConditionInspection */
            if (!mkdir($storagePath, 0777, true)) {
				$message = Mage::helper('dwdafa')->__("Can't create %s directory.", $storagePath);
				Mage::helper('dwdafa')->sendMailToAdmin("dwdafa::".$message);
				Mage::throwException($message);
			}
		}

		$ioObject = new Varien_Io_File();
		$ioObject->open(array('path' => $storagePath));
		$lockFile = '.locked';
		//TODO : Lock file sollte nach bestimmten Zeitraum explizit entfernt werden!
		if ($ioObject->fileExists($lockFile)) {
			$msg = Mage::helper('dwdafa')->__('AFA Module is already running skipping.');
			Mage::helper('dwdafa')->sendMailToAdmin("dwdafa::".$msg);
			Mage::log('dwdafa::'.$msg .' File ' . $storagePath ."/". $lockFile, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			throw new Dwd_AutoFileAssignment_Exception(Mage::helper('dwdafa')->__($msg));
		}

		try {
			if (!$ioObject->streamOpen($lockFile)) {
				$msg = 'Can\'t create lock file, skipping.';
				Mage::log(Mage::helper('dwdafa')->__('dwdafa::'.$msg), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				throw new Dwd_AutoFileAssignment_Exception(Mage::helper('dwdafa')->__($msg));
			}
		} catch (Exception $e) {
			$message = "dwdafa::".Mage::helper('dwdafa')->__("Exception thrown: %s\n See log files for further information.", $e->getMessage());
			Mage::helper('dwdafa')->sendMailToAdmin($message);
			throw $e;
		}
		if (!$ioObject->streamLock()) {
			Mage::log("dwdafa::Can't get exclusive access for lock file.", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		}

		$_lastDbProcessResult = false;
		$filesToDeleteErrors = 0;
		$exceptionToThrow = null;

		for ($i = 0; $i < 2 && !($_lastDbProcessResult = $this->_processDbData()); $i++) /** @noinspection SuspiciousSemicolonInspection */;
		if (!$_lastDbProcessResult) {
			$message = "dwdafa::".Mage::helper('dwdafa')->__("Processing DB data failed, see log file for further information!");
			Mage::helper('dwdafa')->sendMailToAdmin($message);
			$exceptionToThrow = new Exception($message);
		} else {
			try {
				$filesToDeleteErrors = $this->_processPatternForAllFiles($storagePath, $this->_patterns);
			} catch (Exception $e) {
				$exceptionToThrow = $e;
			}
		}

		unset($this->_patterns);

		if ($filesToDeleteErrors) {
			$message = "dwdafa::".Mage::helper('dwdafa')->__("Exception thrown: See log files for further information.");
			Mage::helper('dwdafa')->sendMailToAdmin($message);
		}

		if (!$exceptionToThrow) {
			Mage::log("dwdafa::Processing files finished", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		} else {
			Mage::log("dwdafa::Processing files finished unsuccessfully", Zend_Log::WARN, Egovs_Helper::LOG_FILE);
		}

		if (!$ioObject->streamUnlock()) {
			Mage::log("dwdafa::Can't release exclusive access for lock file.", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		}
		if (!$ioObject->streamClose()) {
			Mage::log("dwdafa::Can't release stream for lock file.", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
		}
		if (!$ioObject->fileExists($lockFile)) {
			Mage::log("dwdafa::lockfile does not exists. (" .$lockFile.")", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
		} elseif (!$ioObject->rm($lockFile)) {
			Mage::log("dwdafa::Can't release lock. (" .$lockFile.")", Zend_Log::ERR, Egovs_Helper::LOG_FILE);
		}
		if ($filesToDeleteErrors > 0) {
			//$fileDeletionErrors > 0
			$message = Mage::helper('dwdafa')->__("Can't clean up all AFD files, %d errors occured.\nMaybe there is a problem with file access rights. We don't release the lock for AFA to avoid duplicates.", $filesToDeleteErrors);
			Mage::log(sprintf("dwdafa::%s", $message), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::helper('dwdafa')->sendMailToAdmin($message);
		}

		if ($this->_errors > 0) {
			$message = Mage::helper('dwdafa')->__("Can't set up all AFD files, %d errors occured.\nMaybe there is a problem with file access rights.", $this->_errors);
			Mage::log(sprintf("dwdafa::%s", $message), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			Mage::helper('dwdafa')->sendMailToAdmin($message);
		}
		if ($exceptionToThrow) {
			Mage::log(
				sprintf(
					"dwdafa::...Assignment aborted! Runtime was %s seconds, with %s memory in use",
					(int) time() - $this->_startTime,
					$this->_getMemoryUsage()
				),
				Zend_Log::WARN,
				Egovs_Helper::LOG_FILE
			);
			throw $exceptionToThrow;
		}
		Mage::log(
			sprintf(
				"dwdafa::...Assignment finished in %s seconds, with %s memory in use",
				(int) time() - $this->_startTime,
				$this->_getMemoryUsage()
			),
			Zend_Log::INFO,
			Egovs_Helper::LOG_FILE
		);
	}

	/**
	 * Liefert einen Pfad unterhalb von Media, höchstens jedoch Media selbst
	 *
	 * @return string
	 */
	public function getConfigStorage() {
		return Mage::helper('dwdafa')->getConfigStorage();
	}

	/**
	 * Führt das Pattern - File Matching durch
	 *
	 * @param array $currentTreeLevel
	 * @param string $fileName
	 * @param string $file
	 * @param string $root
	 *
	 * @return number
	 */
	protected function _processPatternForFile(&$currentTreeLevel, $fileName, $file, $root) {
		if (empty($currentTreeLevel)) {
			return 1;
		}

		$_treeLevelErrorsCount = 0;
		$_currentTreeLevel = &$currentTreeLevel;
		//pattern Level of tree
		foreach ($_currentTreeLevel as $pattern => $dynLnkIds) {
			if ($pattern == "tree_width" || $pattern == "last_inserted") {
				continue;
			}
			foreach ($dynLnkIds as $dynLnkId => $templates) {
				foreach ($templates as $template) {
					if (!isset($template['template']) || !isset($template['product'])) {
						$_treeLevelErrorsCount++;
						continue;
					}

					if (!fnmatch($pattern, $fileName)) {
						continue;
					}

					$product = $template['product'];
					$linkItemTemplate = $template['template'];
					/** @see Mage_Downloadable_Helper_File::moveFileFromTmp */
					$fileToAdd = array();
					//es darf nur relativer Pfad oder Datei selbst enthalten sein
					//DS hängt bereits an $root
					$fileToAdd[] = array('file' => str_replace($root, '', $file), 'status' => 'new');
					try {
						$product->getTypeInstance()->addLinkItem($linkItemTemplate, $fileToAdd, $root);
					} catch (Exception $e) {
						Mage::log(
								sprintf("dwdafa::Assignment error:\npattern:%s\nfile: %s\nroot%s\n%s",
									$pattern,
									$file,
									$root,
									$e->__toString()
								),
								Zend_Log::ERR,
								Egovs_Helper::EXCEPTION_LOG_FILE
						);
						$this->_errors++;
					}
				}
			}
		}

		return $_treeLevelErrorsCount;
	}

	/**
	 * Liefert alle Dateien einschließlich der Dateien in Unterordnern die in $this->_patterns enthalten sind als Array zurück.
	 *
	 * Diese Funktion arbeitet nicht rekursiv!
	 *
	 * Gibt ein Array mit Dateipfaden zurück
	 *
	 * @param string $root      Basis-Pfad
	 * @param array  &$patterns Patterns
	 *
	 * @return array
	 */
	protected function _processPatternForAllFiles($root, &$patterns) {
		$files  = array();
		$directories  = array();
		$lastLetter  = $root[strlen($root)-1];
		$root  = ($lastLetter == '\\' || $lastLetter == '/') ? $root : $root.DIRECTORY_SEPARATOR;
		$directories[]  = $root;
		$filesFound = array();
		$loop = 0;

		Mage::log(
			sprintf(
				"dwdafa::Collecting all available files, currently %s memory in use",
				$this->_getMemoryUsage()
			),
			Zend_Log::INFO,
			Egovs_Helper::LOG_FILE
		);
		$_collectingFilesTimeStarted = time();
		//erstmal alle Dateien nach $filesFound schreiben
		while ((sizeof($directories) > 0)&& ($loop < 50)) {
			$loop++;
			$dir  = array_pop($directories);
			if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if ($file == '.' || $file == '..' || (isset($file[0]) && $file[0] == '.')) {
						continue;
					}
					//Mage::log(Mage::helper('dwdafa')->__('Directories') ." " . var_export($directories,true), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					//Mage::log(Mage::helper('dwdafa')->__('Processing Directory') ." " . $dir.$file, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
					$file  = $dir.$file;
					if (is_dir($file)) {
						$directoryPath = $file.DIRECTORY_SEPARATOR;
						//Mage::log(Mage::helper('dwdafa')->__('Adding Directory') ." " . $directoryPath, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
						array_push($directories, $directoryPath);
					} elseif (is_file($file)) {
						$filesFound[] = $file;
					}
				}
			}
			closedir($handle);
		}
		Mage::log(
			sprintf(
				"dwdafa::...Collecting all available files in %s sec finished, currently %s memory in use",
				(int) time() - $_collectingFilesTimeStarted,
				$this->_getMemoryUsage()
			),
			Zend_Log::INFO,
			Egovs_Helper::LOG_FILE
		);

		$_fileErrorsCount = 0;
		$_fileDeletionErrors = 0;
		$_modulo = 1;
		$_fileLoops = 0;
		$_fileProcessingTime = 0;
		$_fileProcessingTimeSum = 0;

		foreach ($filesFound as $file) {
			$_fileProcessingTime = microtime(true);
			$fileName = basename($file);
			if (!$this->_patternTreeIsBuild) {
				foreach ($patterns as $productId => $pair) {
					$product = $pair['product'];
					$dynLinks = $pair['dyn_links'];
					foreach ($dynLinks as $dynLnkId => $dynLnkPattern) {
						foreach ($dynLnkPattern as $pattern => $linkItemTemplate) {
							if (!fnmatch($pattern, $fileName)) {
								continue;
							}

							/** @see Mage_Downloadable_Helper_File::moveFileFromTmp */
							$fileToAdd = array();
							//es darf nur relativer Pfad oder Datei selbst enthalten sein
							//DS hängt bereits an $root
							$fileToAdd[] = array('file' => str_replace($root, '', $file), 'status' => 'new');
							try {
								$product->getTypeInstance()->addLinkItem($linkItemTemplate, $fileToAdd, $root);
							} catch (Exception $e) {
								Mage::log(
									sprintf("dwdafa::Assignment error:\npattern:%s\nfile: %s\nroot%s\n%s",
										$pattern,
										$file,
										$root,
										$e->__toString()
									),
									Zend_Log::ERR,
									Egovs_Helper::EXCEPTION_LOG_FILE
								);
								$this->_errors++;
							}
						}
					}
				}
			}

			if ($this->_patternTreeIsBuild && !$this->_treeHasErrors) {
				$_treeMaxLevel = min(strlen($fileName), self::TREE_MAX_DEEPEST_LEVEL);
				if ($_treeMaxLevel > 0) {
					$_currentTreeLevel = &$this->_patternTree;
					$_found = false;
					$_wFound = false;
					$_treeLevelErrorsCount = 0;
					for ($i = 0; $i < $_treeMaxLevel; $i++) {
						$_key = $fileName[$i];
						$_prevTreeLevel = &$_currentTreeLevel;
						if (isset($_currentTreeLevel['?'])) {
							$_currentTreeLevel = &$_currentTreeLevel['?'];
							$_wFound = true;
							$_treeLevelErrorsCount += $this->_processPatternForFile($_currentTreeLevel, $fileName, $file, $root);
							$_currentTreeLevel = &$_prevTreeLevel;
						}
						if (isset($_currentTreeLevel['*'])) {
							$_currentTreeLevel = &$_currentTreeLevel['*'];
							$_wFound = true;
							$_treeLevelErrorsCount += $this->_processPatternForFile($_currentTreeLevel, $fileName, $file, $root);
							$_currentTreeLevel = &$_prevTreeLevel;
						}
						if (isset($_currentTreeLevel[$_key])) {
							$_currentTreeLevel = &$_currentTreeLevel[$_key];
							$_found = true;
							continue;
						} else {
							$_found = false;
							break;
						}
					}

					if ($_found && !empty($_currentTreeLevel)) {
						$_treeLevelErrorsCount += $this->_processPatternForFile($_currentTreeLevel, $fileName, $file, $root);
					}
					if (!$_found && !$_wFound) {
						//Datei nicht gefunden
						Mage::log(sprintf("No pattern matched for file %s", $file), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
						$_fileErrorsCount++;
					}

					if ($_treeLevelErrorsCount > 0 && $_fileErrorsCount < self::FILE_ERRORS_MAX) {
						Mage::log(sprintf("%s errors on tree level occured for file %s", $_treeLevelErrorsCount, $file), Zend_Log::ERR, Egovs_Helper::LOG_FILE);
						$_fileErrorsCount++;
					}
				}
			}

			//Dateien können erst nach Durchlauf aller Patterns gelöscht werden!
			try {
				$lastResult = @unlink($file);
				if (!$lastResult) {
					Mage::throwException("dwdafa::Delete Error: File ". $file );
				}
			} catch (Exception $e) {
				Mage::logException($e);
				$_fileDeletionErrors++;
			}

			$_fileProcessingTimeSum += (microtime(true) - $_fileProcessingTime);
			$_fileLoops++;
			if ($_fileLoops % $_modulo == 0) {
				if ($_fileLoops < 1000) {
					$_modulo = 100;
				} elseif ($_fileLoops >= 1000 && $_fileLoops < 10000) {
					$_modulo = 1000;
				} elseif ($_fileLoops >= 10000 && $_fileLoops < 100000) {
					$_modulo = 10000;
				} elseif ($_fileLoops >= 100000 && $_fileLoops < 1000000) {
					$_modulo = 100000;
				} elseif ($_fileLoops >= 1000000) {
					$_modulo = 1000000;
				}
				Mage::log(sprintf("dwdafa::%s file loops counted...; Memory usage: %s; Avg loop time per file: %s", $_fileLoops, $this->_getMemoryUsage(), $_fileProcessingTimeSum / $_fileLoops), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			}

			//ertmal beenden falls die Zeit zu knapp wird
			if ($this->getExecutionTimeLeft() < 10) {
				Mage::throwException("dwdafa:: ExecutionTime expired.");
			}
		}

		return $_fileDeletionErrors;
	}

	/**
	 * LaufzeitProbleme behandeln
	 *
	 * @return int
	 */
	public function getExecutionTimeLeft() {
		$maxTime = ini_get('max_execution_time');

		//0 heißt unendlich
		if ($maxTime == 0) {
			return 9999999;
		}
		$diff = (int)time() - $this->_startTime;
		$left = $maxTime - $diff;
		return $left;
	}



	/**
	 * Durchsucht den angegebenen Pfad rekursiv nach $pattern
	 *
	 * @param string $pattern Pattern
	 * @param number $flags   Flags
	 * @param string $path    Pfad
	 *
	 * @return array
	 *
	 * @deprecated Besser {@link _processPatternForAllFiles()} nutzen
	 */
	function rglob($pattern='*', $flags = 0, $path='') {
		$paths=glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
		$files=glob($path.$pattern, $flags);
		if (!is_array($files)) {
			Mage::log(sprintf("dwdafa::glob function throws error for files, check your log files.\nPattern with path:%s", $path.$pattern), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			$files = array();
		}
		if (!is_array($paths)) {
			Mage::log(sprintf('dwdafa::glob function throws error for paths, check your log files. Pattern:%s', $pattern), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			$paths = array();
		}
        /* the inner empty array covers cases when no loops were made */
		$mergedFiles = [[]];
        /** @noinspection SuspiciousLoopInspection */
        foreach ($paths as $path) {
			if (strpos($path, Mage::getBaseDir('media').DS.'downloadable') !== false) {
				continue;
			}
			$mergedFiles[] = $this->rglob($pattern, $flags, $path);
		}
		if (version_compare(PHP_VERSION, '5.6', '>=')) {
		    $mergedFiles = array_merge(...$mergedFiles);
        } else {
            /* PHP below 5.6 */
            $mergedFiles = call_user_func_array('array_merge', $mergedFiles);
        }
		$files = array_merge($files, $mergedFiles);

		return $files;
	}
}