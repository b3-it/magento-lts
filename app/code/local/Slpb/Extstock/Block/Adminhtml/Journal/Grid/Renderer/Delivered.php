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
class Slpb_Extstock_Block_Adminhtml_Journal_Grid_Renderer_Delivered extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
   
 	public function _getInputValueElement(Varien_Object $row)
    {
    	if($row->getData('status') == Slpb_Extstock_Model_Journal::STATUS_ORDERED)
    	{
    	
        $htm = '<input type="text" class="slpb_edit_2col ' . $this->getColumn()->getValidateClass() . '" name="'.( $this->getColumn()->getName() ? $this->getColumn()->getName() : $this->getColumn()->getId() ).'" value="'. $row->getData('qty_ordered').'"/>';
        $htm .= '<input type="hidden" class="input-text " name="journal_keys" value="'.$row->getData($this->getColumn()->getIndexId()).'"/>';
      
        return $htm;
    	}
    	return $this->_getInputValue($row);
    	
    }
    
    public function render(Varien_Object $row)
    {
    	if($row->getData('status') != Slpb_Extstock_Model_Journal::STATUS_ORDERED)
    	{
    		return '<div class="slpb_col2">'. $row->getData('qty_ordered').'</div>'.$this->_getValue($row);
    	}
        if ($this->getColumn()->getEditable()) {
            $value = $row->getData('qty_ordered');//$this->_getValue($row);
            $value = $value!=''?$value:'&nbsp;';
            //$value =  $value . ( ($this->getColumn()->getEditOnly() && trim($this->_getValue($row)!='')) ? '' : '</td><td>' ) . $this->_getInputValueElement($row);
            $value =  '<div class="slpb_col2">'. $value . '</div> ' . $this->_getInputValueElement($row);
            return $value;

        }

        return $this->_getValue($row);
    }
    
    
   
    
}
