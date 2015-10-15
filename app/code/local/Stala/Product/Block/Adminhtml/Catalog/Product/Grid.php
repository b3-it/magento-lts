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
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml customer grid block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_Product_Block_Adminhtml_Catalog_Product_Grid extends Egovs_Acl_Block_Adminhtml_Catalog_Product_Grid
{


    public function setCollection($collection)
    {
        $collection->addAttributeToSelect('artikel_art');
        $collection->getSelect()->distinct();
        parent::setCollection($collection);
    }

    protected function _prepareColumns()
    {
    	$model = Mage::getSingleton('stalaproduct/nature');
    	if ($model) {
    		$options = $model->getOptionArray();

    		if (count($options) > 0) {
    			$this->addColumn('artikel_art',
    			array(
					'header'=> 'Artikel Art',
					'width' => '100px',
					'type'  => 'options',
					'index' => 'artikel_art',
					'options' =>$options,
    			));
    		}
    	}

    	parent::_prepareColumns();
    }
    
    public function getColumns()
    {
        $columns = parent::getColumns();
        $new_columns_order = array();

        foreach ($columns as $column_id => $column) {
            if ($column_id =='qty') {
                $new_columns_order[$column_id] = $column;   
                if(array_key_exists('delivery_time', $columns))
                {
                	$new_columns_order['delivery_time'] = $columns['delivery_time']; 
                }
                $new_columns_order['artikel_art'] = $columns['artikel_art'];    
            } elseif (($column_id != 'delivery_time') && ($column_id != 'artikel_art')) 
            {
                $new_columns_order[$column_id] = $column;   
            }
        }

        return $new_columns_order;
    }
    
 
}
