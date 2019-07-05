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
 * Sitemap grid action column renderer
 *
 * @category   Mage
 * @package    Mage_Sitemap
 */
class Stala_Abo_Block_Adminhtml_Contract_Create_Product_Renderer_Useit extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
    	//echo "<pre>"; var_dump($row); die();
    	if($row->getMissingItems() == null)
    	{
	        $this->getColumn()->setActions(array(array(    
	        	//'onclick' => "addItem('".$row->getEntityId()."','" . $row->getName()."','" . $row->getSku()."'); return false; ",
	            'onclick' => "addItem('".$row->getEntityId()."'); return false; ",
	        	'caption' => Mage::helper('extcustomer')->__('Add To Contract'),
	        )));
	        return parent::render($row);
    	}
        return "";
    }
}