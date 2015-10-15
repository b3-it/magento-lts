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
 * @category   Egovs
 * @package    Egovs_Search
 * @copyright  Copyright (c) 2009
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Search_Model_Config_Source_Available
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
 
	
    public function getOptionText($value)
    {
    	
    	if ($value == 'instock') return Mage::helper('egovssearch')->__('In Stock Only');
    	return Mage::helper('egovssearch')->__('All');
    }

    public function toOptionArray()
    {
        return array('instock'=>Mage::helper('egovssearch')->__('In Stock Only'));
    }
    
    public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
    
	
 

}