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
class Sid_Framecontract_Model_Import_Adapter_Csv extends Mage_ImportExport_Model_Import_Adapter_Abstract
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

    //zum vermeiden von dopplungen bei crossell
    private $_LastSku = "";

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
        $this->_currentRow = $this->getLine();//fgetcsv($this->_fileHandler, null, $this->_delimiter, $this->_enclosure);

        if ($this->_currentRow) {
            $this->_currentKey = 0;
        }
        $this->translateColNames();
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
    	/*
    	$line = fgets($this->_fileHandler);
    	if($line === false) return false;
    	$line = rtrim($line);
    	$line = utf8_encode($line);
    	$line = explode($this->_delimiter, $line);
    	return $line;
    	*/
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
        foreach( $this->_colNames AS $key => $val )
        {
            switch( $val )
            {
                case 'Artikelnummer'    : $this->_colNames[$key] = 'sku';
                                          break;
                case 'Name'             : $this->_colNames[$key] = 'name';
                                          break;
                case 'Kurzbeschreibung' : $this->_colNames[$key] = 'short_description';
                                          break;
                case 'Langbeschreibung' : $this->_colNames[$key] = 'description';
                                          break;
                case 'Preis'            : $this->_colNames[$key] = 'price';
                                          break;
                case 'Gewicht'          : $this->_colNames[$key] = 'weight';
                                          break;
                case 'Menge'            : $this->_colNames[$key] = 'qty';
                                          break;
                case 'Lieferzeitraum'   : $this->_colNames[$key] = 'delivery_time';
                                          break;
                default                 : $this->_colNames[$key] = $val;
                                          break;
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
        $res = array_merge($res,$this->_defaultValues);

        $los = $res['framecontract_los'];
        
        $res['framecontract_los'] = Mage::getModel('framecontract/los')->load($res['framecontract_los'])->getOptionsLabel();

        $skuCols = array('sku','_links_crosssell_sku','_links_upsell_sku','_links_related_sku','_parent_sku');

        foreach($skuCols as $skuCol)
        {
        	if(isset($res[$skuCol])) {
        			if(strlen(trim($res[$skuCol])) > 0){
        				$res[$skuCol] = trim($this->_defaultValues['sku_prefix'].$los.'/'.$res[$skuCol]);
        			}
        	}
        }


        if($res['sku'] == $this->_LastSku){
        	$res['sku'] ='';
        }
        else
        {
        	$this->_LastSku = $res['sku'];
        }


        $res['small_image'] = $res['image'];
        $res['small_image_label'] = $res['image_label'];
        $res['thumbnail'] = $res['image'];
        $res['thumbnail_label'] = $res['image_label'];
        $res['_media_image'] = $res['image'];
        $res['_media_lable'] = $res['image_label'];
        $res['_media_position'] = 1;
        $res['_media_is_disabled'] = 0;
        $res['_media_attribute_id'] = $this->getMediaAttributeId();





        return $res;
    }

    private function getMediaAttributeId()
    {
    	if($this->_MediaAttributeId == null)
    	{
    		 $eav = Mage::getResourceModel('eav/entity_attribute');
    		 $this->_MediaAttributeId = $eav->getIdByCode('catalog_product','media_gallery');
    	}
    	return $this->_MediaAttributeId;
    }
}
