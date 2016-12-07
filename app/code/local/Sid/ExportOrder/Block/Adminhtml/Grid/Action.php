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
 * Adminhtml newsletter templates grid block action item renderer
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Sid_ExportOrder_Block_Adminhtml_Grid_Action extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
	
  public function render(Varien_Object $row)
    {
  		if($this->getColumn()->getStatus() != null)
  		{
  			if($row[$this->getColumn()->getStatus()] == $this->getColumn()->getHideOn())
  			{
  				return "";
  			}
  		}
        $actions = $this->getColumn()->getActions();
        if ( empty($actions) || !is_array($actions) ) {
            return '&nbsp;';
        }

        if(sizeof($actions)==1 && !$this->getColumn()->getNoLink()) {
            foreach ($actions as $action) {
                if ( is_array($action) ) {
                    return $this->_toLinkHtml($action, $row);
                }
            }
        }

        $out = '<select class="action-select" onchange="varienGridAction.execute(this);">'
             . '<option value=""></option>';
        $i = 0;
        foreach ($actions as $action){
            $i++;
            if ( is_array($action) ) {
                $out .= $this->_toOptionHtml($action, $row);
            }
        }
        $out .= '</select>';
        return $out;
    }
	
    public function xrender(Varien_Object $row)
    {
    	$canQueue = Mage::getSingleton('admin/session')->isAllowed('admin/newsletter/template/newslettertemplatequeue');
    	
    	if($canQueue)
    	{
	        if($row->isValidForSend()) {
	            $actions[] = array(
	                'url' => $this->getUrl('*/newsletter_queue/edit', array('template_id' => $row->getId())),
	                'caption' => Mage::helper('newsletter')->__('Queue Newsletter...')
	            );
	        }
    	}

        $actions[] = array(
            'url'     => $this->getUrl('*/*/preview', array('id'=>$row->getId())),
            'popup'   => true,
            'caption' => Mage::helper('newsletter')->__('Preview')
        );

        $this->getColumn()->setActions($actions);

        return Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action::render($row);
    }
}
