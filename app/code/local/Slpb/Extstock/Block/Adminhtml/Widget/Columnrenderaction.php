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
 * Grid column widget for rendering action grid cells
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Slpb_Extstock_Block_Adminhtml_Widget_Columnrenderaction extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{

    /**
     * Prepares action data for html render
     *
     * @param array $action
     * @param string $actionCaption
     * @param Varien_Object $row
     * @return Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
     */
    protected function _transformActionData(&$action, &$actionCaption, Varien_Object $row)
    {
        foreach ( $action as $attibute => $value ) {
            if(isset($action[$attibute]) && !is_array($action[$attibute])) {
                $this->getColumn()->setFormat($action[$attibute]);
                $action[$attibute] = parent::render($row);
            } else {
                $this->getColumn()->setFormat(null);
            }

    	    switch ($attibute) {
            	case 'caption':
            	    $actionCaption = $action['caption'];
            	    unset($action['caption']);
               		break;

            	case 'url':
            	    if(is_array($action['url'])) {
            	        $params = array($action['field']=>$this->_getValue($row));
            	        if(isset($action['url']['params'])) {
                            /** @noinspection SlowArrayOperationsInLoopInspection */
                            $params = array_merge($action['url']['params'], $params);
                	    }
                	    $action['href'] = $this->getUrl($action['url']['base'], $params);
                	    unset($action['field']);
            	    } else {
            	        $action['href'] = $action['url'];
            	    }
            	    unset($action['url']);
               		break;

            	case 'popup':
            	    $action['onclick'] = 'popWin(this.href, \'windth=800,height=700,resizable=1,scrollbars=1\');return false;';
            	    break;
            	case 'popupurl':
            	    //$action['onclick'] = 'popWin(\''.$action['href'].'\', \'width=800,height=700,resizable=1,scrollbars=1\');return false;';
            	    $action['onclick'] = 'var win = window.open(\''.$action['href'].'\', \'width=800,height=700,resizable=1,scrollbars=1\');win.focus();return false;';
            	    
            	    break;

            }
        }
        return $this;
    }
}