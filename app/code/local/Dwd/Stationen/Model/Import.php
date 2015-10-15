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
 * Import model
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dwd_Stationen_Model_Import extends Mage_ImportExport_Model_Abstract
{
 
    /**
     * Entity adapter.
     *
     * @var Mage_ImportExport_Model_Import_Entity_Abstract
     */
    protected $_entityAdapter;
	const FIELD_NAME_SOURCE_FILE = 'import_file';
 

    /**
     * Create instance of entity adapter and returns it.
     *
     * @throws Mage_Core_Exception
     * @return Mage_ImportExport_Model_Import_Entity_Abstract
     */
    protected function _getEntityAdapter()
    {
        if (!$this->_entityAdapter) {
            $this->_entityAdapter = Mage::getModel('framecontract/import_entity_product');
            $this->_entityAdapter->setParameters($this->getData());
        }
        return $this->_entityAdapter;
    }

    /**
     * Returns source adapter object.
     *
     * @param string $sourceFile Full path to source file
     * @return Mage_ImportExport_Model_Import_Adapter_Abstract
     */
    protected function _getSourceAdapter($sourceFile)
    {
    	return new Dwd_Stationen_Model_Import_Adapter_Csv($sourceFile);
    }

    /**
     * Return operation result messages
     *
     * @param bool $validationResult
     * @return array
     */
    public function getOperationResultMessages($validationResult)
    {
        $messages = array();
        if ($this->getProcessedRowsCount()) {
            if (!$validationResult) {
                if ($this->getProcessedRowsCount() == $this->getInvalidRowsCount()) {
                    $messages[] = Mage::helper('importexport')->__('File is totally invalid. Please fix errors and re-upload file');
                } elseif ($this->getErrorsCount() >= $this->getErrorsLimit()) {
                    $messages[] = Mage::helper('importexport')->__('Errors limit (%d) reached. Please fix errors and re-upload file',
                        $this->getErrorsLimit()
                    );
                } else {
                    if ($this->isImportAllowed()) {
                        $messages[] = Mage::helper('importexport')->__('Please fix errors and re-upload file');
                    } else {
                        $messages[] = Mage::helper('importexport')->__('File is partially valid, but import is not possible');
                    }
                }
                // errors info
                foreach ($this->getErrors() as $errorCode => $rows) {
                    $error = $errorCode . ' '
                        . Mage::helper('importexport')->__('in rows') . ': '
                        . implode(', ', $rows);
                    $messages[] = $error;
                }
            } else {
                if ($this->isImportAllowed()) {
                    $messages[] = Mage::helper('importexport')->__('Validation finished successfully');
                } else {
                    $messages[] = Mage::helper('importexport')->__('File is valid, but import is not possible');
                }
            }
            $notices = $this->getNotices();
            if (is_array($notices)) {
                $messages = array_merge($messages, $notices);
            }
            $messages[] = Mage::helper('importexport')->__('Checked rows: %d, checked entities: %d, invalid rows: %d, total errors: %d',
                $this->getProcessedRowsCount(), $this->getProcessedEntitiesCount(),
                $this->getInvalidRowsCount(), $this->getErrorsCount()
            );
        } else {
            $messages[] = Mage::helper('importexport')->__('File does not contain data.');
        }
        return $messages;
    }

 

    /**
     * Get entity adapter errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_getEntityAdapter()->getErrorMessages();
    }

    /**
     * Returns error counter.
     *
     * @return int
     */
    public function getErrorsCount()
    {
        return $this->_getEntityAdapter()->getErrorsCount();
    }

    /**
     * Returns error limit value.
     *
     * @return int
     */
    public function getErrorsLimit()
    {
        return $this->_getEntityAdapter()->getErrorsLimit();
    }

    /**
     * Returns invalid rows count.
     *
     * @return int
     */
    public function getInvalidRowsCount()
    {
        return $this->_getEntityAdapter()->getInvalidRowsCount();
    }

    /**
     * Returns entity model noticees.
     *
     * @return array
     */
    public function getNotices()
    {
        return $this->_getEntityAdapter()->getNotices();
    }

    /**
     * Returns number of checked entities.
     *
     * @return int
     */
    public function getProcessedEntitiesCount()
    {
        return $this->_getEntityAdapter()->getProcessedEntitiesCount();
    }

    /**
     * Returns number of checked rows.
     *
     * @return int
     */
    public function getProcessedRowsCount()
    {
        return $this->_getEntityAdapter()->getProcessedRowsCount();
    }

    /**
     * Import/Export working directory (source files, result files, lock files etc.).
     *
     * @return string
     */
    public static function getWorkingDir()
    {
        return Mage::getBaseDir('var') . DS . 'importexport' . DS;
    }

    /**
     * Import source file structure to DB.
     *
     * @return bool
     */
    public function importSource($fileName)
    {
    	$result = 0;
     	$cvs = $this->_getSourceAdapter($fileName);
      	
     	$messages = $this->validateSource($cvs);
     	if (count($messages) > 0)
     	{
     		$message = implode('. ', $messages);
     		Mage::throwException($message);
     	}
     	
     	$stationen = array();
     	$collection = Mage::getModel('stationen/stationen')->getCollection();
     	foreach ($collection->getItems() as $item)
     	{
     		$stationen[$item->getStationskennung().$item->getMessnetz()] = $item;
     	}
     	
     	while($cvs->valid())
     	{
     		$line = $cvs->current();
     		foreach($line as $k =>$v)
     		{
     			$line[$k] = trim($v);
     		}
     		//nur stationen mit kennung und != '--'
     		if(isset($line['stationskennung']) && trim($line['stationskennung'])!='' && strpos($line['stationskennung'],'--') === false)
     		{
     			if(isset($line['messnetz']))
     			{
     				$mn = $line['messnetz']; 
     			}
     			else
     			{
     				$mn ='';
     			}
     				if(isset($stationen[$line['stationskennung'].$mn]))
     				{
     					$model = $stationen[$line['stationskennung'].$mn];
     				}
     				else 
     				{
     					$model = mage::getModel('stationen/stationen');
     					$stationen[$line['stationskennung'].$mn] = $model;
     				}

	     		if($this->copyFields($model,$line))
	     		{
	     			$model->save();
	     		}
     		
     			$result++;
     		}
     		$cvs->next();
     		
     	}
        return $result;
    }

    
    private function copyFields($model,$line)
    {
    	$fields = array('stationskennung','land','styp','mirakel_id','messnetz','ktyp','name','lat','lon','height','region','landkreis','gemeinde','avail_from','avail_to','status','region');
    	$change = 0;
    	
    	foreach($fields as $field)
    	{
    		if(isset($line[$field]))
    		{
	    		if($model->getData($field) != $line[$field])
	    		{
	    			$change++;
	    			$model->setData($field,$line[$field]);
	    		}
    		}
    	}
    	
    	return $change > 0;
    	
    }
    
    /**
     * Import possibility getter.
     *
     * @return bool
     */
    public function isImportAllowed()
    {
        return $this->_getEntityAdapter()->isImportAllowed();
    }

    /**
     * Import source file structure to DB.
     *
     * @return void
     */
    public function expandSource()
    {
        $writer  = Mage::getModel('importexport/export_adapter_csv', self::getWorkingDir() . "big0.csv");
        $regExps = array('last' => '/(.*?)(\d+)$/', 'middle' => '/(.*?)(\d+)(.*)$/');
        $colReg  = array(
            'sku' => 'last', 'name' => 'last', 'description' => 'last', 'short_description' => 'last',
            'url_key' => 'middle', 'meta_title' => 'last', 'meta_keyword' => 'last', 'meta_description' => 'last',
            '_links_related_sku' => 'last', '_links_crosssell_sku' => 'last', '_links_upsell_sku' => 'last',
            '_custom_option_sku' => 'middle', '_custom_option_row_sku' => 'middle', '_super_products_sku' => 'last',
            '_associated_sku' => 'last'
        );
        $size = self::DEFAULT_SIZE;

        $filename = 'catalog_product.csv';
        $filenameFormat = 'big%s.csv';
        foreach ($this->_getSourceAdapter(self::getWorkingDir() . $filename) as $row) {
            $writer->writeRow($row);
        }
        $count = self::MAX_IMPORT_CHUNKS;
        for ($i = 1; $i < $count; $i++) {
            $writer = Mage::getModel(
                'importexport/export_adapter_csv',
                self::getWorkingDir() . sprintf($filenameFormat, $i)
            );

            $adapter = $this->_getSourceAdapter(self::getWorkingDir() . sprintf($filenameFormat, $i - 1));
            foreach ($adapter as $row) {
                $writer->writeRow($row);
            }
            $adapter = $this->_getSourceAdapter(self::getWorkingDir() . sprintf($filenameFormat, $i - 1));
            foreach ($adapter as $row) {
                foreach ($colReg as $colName => $regExpType) {
                    if (!empty($row[$colName])) {
                        preg_match($regExps[$regExpType], $row[$colName], $m);

                        $row[$colName] = $m[1] . ($m[2] + $size) . ('middle' == $regExpType ? $m[3] : '');
                    }
                }
                $writer->writeRow($row);
            }
            $size *= 2;
        }
    }

    /**
     * Move uploaded file and create source adapter instance.
     *
     * @throws Mage_Core_Exception
     * @return string Source file path
     */
    public function uploadSource()
    {
        $uploader  = Mage::getModel('core/file_uploader', self::FIELD_NAME_SOURCE_FILE);
        $uploader->skipDbProcessing(true);
        $result    = $uploader->save(self::getWorkingDir());
        $extension = pathinfo($result['file'], PATHINFO_EXTENSION);

        $uploadedFile = $result['path'] . $result['file'];
        if (!$extension) {
            unlink($uploadedFile);
            Mage::throwException(Mage::helper('importexport')->__('Uploaded file has no extension'));
        }
        $sourceFile = self::getWorkingDir() . 'stationen';

        $sourceFile .= '.' . $extension;

        if(strtolower($uploadedFile) != strtolower($sourceFile)) {
            if (file_exists($sourceFile)) {
                unlink($sourceFile);
            }

            if (!@rename($uploadedFile, $sourceFile)) {
                Mage::throwException(Mage::helper('importexport')->__('Source file moving failed'));
            }
        }
       
        return $sourceFile;
    }

    /**
     * Validates source file and returns validation result.
     *
     * @param string $sourceFile Full path to source file
     * @return bool
     */
    public function validateSource($cvs)
    {
        $this->addLogComment(Mage::helper('importexport')->__('Begin data validation'));
       
        $cols = array("KENN","ALIASNAME","STAT_ID","STYP","LAT_DEC","LON_DEC","HH","VON_DATUM","BIS_DATUM","STATSTATUS","BUNDESLAND","LANDKREIS","GEMEINDE","MESSNETZ","KTYP","ISO");
        
        
        foreach ($cvs->SourceColNames as $k=>$v) 
        {
        	$cvs->SourceColNames[$k] = trim($v);
        }
        
        $dif = array_diff($cols,$cvs->SourceColNames);
        
        $messages = array();
        foreach ($dif as $d)
        {
        	$messages[] = Mage::helper('stationen')->__('Column %s is missing.',$d);
        } 
        
        while($cvs->valid())
        {
        	
        	if (!$cvs->validColCount())
        	{
        		$messages[] = Mage::helper('stationen')->__('Not enough Columns at Row %s', $cvs->Key()+2);
        	}
        	$cvs->next();
        }      
        $cvs->rewind();
        $this->addLogComment(implode('.', $messages));
        
        return $messages;
    }

    
    
}

