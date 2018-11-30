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
 * @category   Egovs
 * @package    Egovs_Search
 * @copyright  Copyright (c) 2009 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Egovs_Search_Catalog_Model_Layer_Filter_Avail extends Mage_Catalog_Model_Layer_Filter_Abstract
{
   

    /**
     * Construct attribute filter
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->_requestVar = 'avail';
    }

    /**
     * Get option text from frontend model by option id
     *
     * @param   int $optionId
     * @return  string
     */
    
   protected function _getOptionText($value)
    {
    	
    	if ($value == 'instock') return Mage::helper('egovssearch')->__('In Stock Only');
    	return Mage::helper('egovssearch')->__('All');
    }
    
    
    protected function x_getOptionText($optionId)
    {
        return Mage::helper('egovssearch')->__('In Stock Only');
    	//return $this->getAttributeModel()->getFrontend()->getOption($optionId);
    }

    /**
     * Apply attribute option filter to product collection
     *
     * @param   Zend_Controller_Request_Abstract $request
     * @param   Varien_Object $filterBlock
     * @return  Mage_Catalog_Model_Layer_Filter_Attribute
     */
    public function apply(Zend_Controller_Request_Abstract $request, $filterBlock)
    {
    	
        $filter = $request->getParam($this->_requestVar);
       
        $text = Mage::helper('egovssearch')->__('In Stock Only');//$filter; //$this->_getOptionText($filter);
        if ($filter && $text) 
        {
            $pc= $this->getLayer();
            $pc->getProductCollection()->addAvailProductFilter($filter);
            $this->getLayer()->getState()->addFilter($this->_createItem($text, $filter));
            $this->_items = array();
        }
        
        return $this;
    }

    /**
     * Get data array for building attribute filter items
     *
     * @return array
     */
    protected function _getItemsData()
    {   
    
    	 //if ($data === null) 
    	 {
           // $options = $attribute->getFrontend()->getSelectOptions();
            $optionsCount = Mage::getSingleton('searchcatalog/mysql4_availproductcount')->getCount(
                '',
                $this->_getBaseCollectionSql()
            );
    	 }
    	
    	$data = array();

    	$data[] = array('label' => Mage::helper('egovssearch')->__('In Stock Only'), 'value' => 'instock','count'=>$optionsCount);
        return $data;
    }
    
 	public function getName()
    {
    	return  Mage::helper('egovssearch')->__('Availability');
    }
    
}
