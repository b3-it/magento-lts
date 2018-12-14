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
 * CSV import adapter
 *
 * @category    Mage
 * @package     Mage_ImportExport
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Dwd_Stationen_Model_Import_Adapter_Csv extends Mage_ImportExport_Model_Import_Adapter_Abstract
{
    /**
     * Field delimiter.
     *
     * @var string
     */
    protected $_delimiter = ';';

    /**
     * Field enclosure character.
     *
     * @var string
     */
    protected $_enclosure = '"';

    /**
     * Source file handler.
     *
     * @var resource
     */
    protected $_fileHandler;

    protected $_defaultValues = null;
    
    private $_MediaAttributeId = null;
    
    public $SourceColNames = array();
    
    public function setDefaultValues($values)
    {
    	$this->_defaultValues = $values;
    }
    
    /**
     * Object destructor.
     *
     * @return void
     */
    public function __destruct()
    {
        if (is_resource($this->_fileHandler)) {
            fclose($this->_fileHandler);
        }
    }

    /**
     * Method called as last step of object instance creation. Can be overrided in child classes.
     *
     * @return Mage_ImportExport_Model_Import_Adapter_Abstract
     */
    protected function _init()
    {
        $this->_fileHandler = fopen($this->_source, 'rb');
        $this->rewind();
        return $this;
    }

    /**
     * Move forward to next element
     *
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
        $this->_currentKey = $this->_currentRow ? $this->_currentKey + 1 : null;
    }

    /**
     * Rewind the Iterator to the first element.
     *
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        // rewind resource, reset column names, read first row as current
        rewind($this->_fileHandler);
        $this->_colNames =  $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
        $this->SourceColNames =  $this->_colNames;
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
		
        
        if ($this->_currentRow) {
            $this->_currentKey = 0;
        }
        
        $this->translateColNames();
    }

    
    
 	public function validColCount()
    {
        return (count($this->_colNames) == count($this->_currentRow));
    }
    
    
    
    /**
     * Seeks to a position.
     *
     * @param int $position The position to seek to.
     * @throws OutOfBoundsException
     * @return void
     */
    public function seek($position)
    {
        if ($position != $this->_currentKey) {
            if (0 == $position) {
                return $this->rewind();
            } elseif ($position > 0) {
                if ($position < $this->_currentKey) {
                    $this->rewind();
                }
                while ($this->_currentRow = $this->getLine()) {
                    if (++ $this->_currentKey == $position) {
                        return;
                    }
                }
            }
            throw new OutOfBoundsException(Mage::helper('importexport')->__('Invalid seek position'));
        }
    }
    
    private function getLine()
    {
    	$line = fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);
    	$res = array();
    	if(($line != null) && (is_array($line)))
    	{
	    	foreach($line as $key => $value)
	    	{
	    		$res[] = utf8_encode($value);
	    	}
    	}
    	return $res;
    }
    
    public function translateColNames()
    {
    
    	for($i = 0, $iMax = count($this->_colNames); $i < $iMax; $i++)
    	{
    		if(trim($this->_colNames[$i]) == 'KENN'){
    			$this->_colNames[$i] = 'stationskennung';
    		}
    		else if(trim($this->_colNames[$i]) == 'COUNTRY'){
    			$this->_colNames[$i] = 'landx';
    		}
    		else if(trim($this->_colNames[$i]) == 'ISO'){
    			$this->_colNames[$i] = 'land';
    		}
    		else if(trim($this->_colNames[$i]) == 'STYP'){
    			$this->_colNames[$i] = 'styp';
    		}
    		else if(trim($this->_colNames[$i]) == 'STAT_ID'){
    			$this->_colNames[$i] = 'mirakel_id';
    		}
    		else if(trim($this->_colNames[$i]) == 'MESSNETZ'){
    			$this->_colNames[$i] = 'messnetz';
    		}
    	    else if(trim($this->_colNames[$i]) == 'KTYP'){
    			$this->_colNames[$i] = 'ktyp';
    		}
    	    else if(trim($this->_colNames[$i]) == 'KENN'){
    			$this->_colNames[$i] = 'name';
    		}
    	    else if(trim($this->_colNames[$i]) == 'STATIONSNAME'){
    			$this->_colNames[$i] = 'name';
    		}
    	  	else if(trim($this->_colNames[$i]) == 'ALIASNAME'){
    			$this->_colNames[$i] = 'name';
    		}
    	    else if(trim($this->_colNames[$i]) == 'LAT_DEC'){
    			$this->_colNames[$i] = 'lat';
    	  	}
    	   	else if(trim($this->_colNames[$i]) == 'LON_DEC'){
    			$this->_colNames[$i] = 'lon';
    	    }
    	    else if(trim($this->_colNames[$i]) == 'HH'){
    			$this->_colNames[$i] = 'height';
    	    }
    	  	else if(trim($this->_colNames[$i]) == 'BL'){
    			$this->_colNames[$i] = 'region';
    	    }
    	   	else if(trim($this->_colNames[$i]) == 'KFZ'){
    			$this->_colNames[$i] = 'landkreis';
    	    }
    	  	else if(trim($this->_colNames[$i]) == 'GEMEINDE'){
    			$this->_colNames[$i] = 'gemeinde';
    	    }
    	  	else if(trim($this->_colNames[$i]) == 'VON_DATUM'){
    			$this->_colNames[$i] = 'avail_from';
    	    }
    	   	else if(trim($this->_colNames[$i]) == 'BIS_DATUM'){
    			$this->_colNames[$i] = 'avail_to';
    	    }
    	  	else if(trim($this->_colNames[$i]) == 'STATSTATUS'){
    			$this->_colNames[$i] = 'status';
    	    }
    	   	else if(trim($this->_colNames[$i]) == 'BUNDESLAND'){
    			$this->_colNames[$i] = 'region';
    	    }
    	   	else if(trim($this->_colNames[$i]) == 'LANDKREIS'){
    			$this->_colNames[$i] = 'landkreis';
    	    }
	    	
    	    
    	}
    }
    
    public function current()
    {
    	
        $res =  array_combine(
            $this->_colNames,
            count($this->_currentRow) != $this->_colQuantity
                    ? array_pad($this->_currentRow, $this->_colQuantity, '')
                    : $this->_currentRow
        );
        if($this->_defaultValues)
        {
        	$res = array_merge($res,$this->_defaultValues);
        }
        return $res;
    }
    
  
}
