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
 * Customer account form block
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Extnewsletter_Block_Adminhtml_Customer_Newsletter extends Mage_Adminhtml_Block_Customer_Edit_Tab_Newsletter
{

 

    public function initForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('_newsletter');
        $customer = Mage::registry('current_customer');
        $subscriber = Mage::getModel('newsletter/subscriber')->loadByCustomer($customer);
        Mage::register('subscriber', $subscriber);

        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('customer')->__('Newsletter Information')));

        $fieldset->addField('subscriptionstatus', 'label',             
	        array(
	                    'label' => Mage::helper('newsletter')->__('Status'),
	                    'name'  => 'subscription',
	        			'value'=> $subscriber->getStatusAsText()
	        )
        );
        $fieldset->addField('subscription', 'checkbox',
             array(
                    'label' => Mage::helper('customer')->__('Subscribed to Newsletter?'),
                    'name'  => 'subscription'
             )
        );
		if($subscriber->getId())
	 	{  
	        $fieldset->addField('productabo', 'label',             
		        array(
		                    'label' => Mage::helper('extnewsletter')->__('Subscribed to'),
		                    'name'  => 'productabo',
		        			'value'=> $this->getProductAboLabel($subscriber),
		        )
	        );
	 	
	        $fieldset->addField('issueabo', 'label',             
		        array(
		                    'label' => Mage::helper('extnewsletter')->__('Subscribed to'),
		                    'name'  => 'isueabo',
		        			'value'=> $this->getIssueAboLabel($subscriber),
		        )
	        );
 		}
        if ($customer->isReadonly()) {
            $form->getElement('subscription')->setReadonly(true, true);
        }

        $form->getElement('subscription')->setIsChecked($subscriber->isSubscribed());

        if($changedDate = $this->getStatusChangedDate()) {
             $fieldset->addField('change_status_date', 'label',
                 array(
                        'label' => $subscriber->isSubscribed() ? Mage::helper('customer')->__('Last date subscribed') : Mage::helper('customer')->__('Last date unsubscribed'),
                        'value' => $changedDate,
                        'bold'  => true
                 )
            );
        }


        $this->setForm($form);
        return $this;
    }

    private function getProductAboLabel($subscriber)
    {
    	if($subscriber == null) return "";
    	$items = Mage::getModel('extnewsletter/extnewsletter')->getSubscribedProductsForSubscriber($subscriber->getId());
    	$res = array();
    	foreach($items as $item)
    	{
    		if($item->getData('product_id') == 0)
    		{
    			$res[] = Mage::helper('extnewsletter')->__('general topics');
    		}
    		else
    		{
    			$res[] = $item->getData('name');
    		}
    	}
    	
    	if(count($res)== 0 ) return '--';
    	return implode('; ',$res);
    }
    
   	private function getIssueAboLabel($subscriber)
    {
    	if($subscriber == null) return "";
    	$collection = Mage::getModel('extnewsletter/issuesubscriber')->getCollection();
    	$collection->getSelect()
    		->join(array('t1'=>$collection->getTable('extnewsletter/issue')),'t1.extnewsletter_issue_id=main_table.issue_id')
    		->where('is_active=1 AND subscriber_id='.$subscriber->getId());
    	
    	$res = array();
    	foreach($collection->getItems() as $item)
    	{
			$res[] = $item->getData('title');
    	}
    	
    	if(count($res)== 0 ) return '--';
    	return implode('; ',$res);
    }
 

}
