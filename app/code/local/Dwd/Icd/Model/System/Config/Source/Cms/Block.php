<?php
/**
 * Source Model für CMS Blöcke
 *
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Abstract
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_System_Config_Source_Cms_Block
{

    protected $_options;

    /**
     * Erzeugt ein Option array
     * 
     * Als value wird der Identifier der CMS Blöcke genutzt
     * 
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $collection =  Mage::getResourceModel('cms/block_collection');
        	
            foreach ($collection->getItems() as $item) {
            	$this->_options[] = array('value'=>$item->getIdentifier(), 'label'=>$item->getTitle());
            }
        	
        }
        return $this->_options;
    }

}
