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
 * @category   Mage
 * @package    Mage_CatalogSearch
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Autocomplete queries list
 */
class Slpb_Checkout_Block_Quick_Suggest extends Mage_Core_Block_Abstract
{
    protected $_suggestData = null;

    protected function _toHtml()
    {
        $html = '';

        if (!$this->_beforeToHtml()) {
            return $html;
        }

        $suggestData = $this->getSuggestData();
        if (!($count = count($suggestData))) {
            return $html;
        }

        $count--;

        $html = '<ul><li style="display:none"></li>';
        foreach ($suggestData as $index => $item) {
            if ($index == 0) {
                $item['row_class'] .= ' first';
            }

            if ($index == $count) {
                $item['row_class'] .= ' last';
            }

            $html .=  '<li title="'.$this->htmlEscape($item['title']).'" class="'.$item['row_class'].'" id="'.$item['id'].'">'
                . '<span class="sku">'.$item['sku'].'</span>'.$this->htmlEscape($item['title']).'</li>';
        }

        $html.= '</ul>';

        return $html;
    }

    //wird nicht mehr benötigt
    public function xxxgetSuggestData()
    {
        if (!$this->_suggestData) {
        	
            $collection = Mage::getModel('catalog/product')->getCollection();
            
            $queryText = $collection->getConnection()->quoteInto("?","%".Mage::app()->getRequest()->getParam('quicksuggest')."%");
                        
            $collection->addAttributeToFilter('name',array('like'=>str_replace("'","",$queryText)));
            $collection->addStoreFilter($this->getStore());
            $s = $collection->getSelect()
            	->orWhere("sku like ".$queryText);
            $s = $collection->getSelect()->__toString();

            $counter = 0;
            $data = array();
            foreach ($collection->getItems() as $item) {
                $_data = array(
                    'title' => $item->getName(),
                    'row_class' => (++$counter)%2?'odd':'even',
                    'sku' => $item->getSku(),
                	'id'=> $item->getId()
                );
				$data[] = $_data;
            }
            $this->_suggestData = $data;
        }
        return $this->_suggestData;
    }
    

    
/*
 *
*/
}