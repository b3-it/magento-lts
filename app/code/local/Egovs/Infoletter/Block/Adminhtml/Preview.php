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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml newsletter template preview block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Infoletter_Block_Adminhtml_Preview extends Mage_Adminhtml_Block_Widget
{

		
    protected function _toHtml()
    {
        
    	$model = new Varien_Object();
    	$model->setCustomerFirstname('Maxi');
    	$model->setCustomerLastname('Mustermann');
    	$model->setCustomerCompany('Musterfirma');
    	$model->setCustomerPrefix('Frau');
    	
       
        
/*
        $template->emulateDesign($storeId);
        $templateProcessed = $template->getProcessedTemplate($vars, true);
        $template->revertDesign();
*/
        
        $queue = $this->getFormData();
        $text = $queue->getProcessedMessageBody($model->getData());
        

        return $text;
    }

}
