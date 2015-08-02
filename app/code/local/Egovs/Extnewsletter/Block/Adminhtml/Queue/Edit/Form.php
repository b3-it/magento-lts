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
 * Adminhtml newsletter queue edit form
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Extnewsletter_Block_Adminhtml_Queue_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_queue = null;
	
	private function getQueue()
	{
		if($this->_queue == null)
		{
			$this->_queue = Mage::getSingleton('newsletter/queue');
		}
		
		return $this->_queue;
	}
	
    protected function _prepareForm()
    {
        $queue = $this->getQueue();

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    =>  Mage::helper('newsletter')->__('Queue Information')
        ));

        $outputFormat = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);

        if($queue->getQueueStatus() == Mage_Newsletter_Model_Queue::STATUS_NEVER) {
            $fieldset->addField('date', 'date',array(
                'name'      =>    'start_at',
                'time'      =>    true,
                'format'    =>    $outputFormat,
                'label'     =>    Mage::helper('newsletter')->__('Queue Date Start'),
                'image'     =>    $this->getSkinUrl('images/grid-cal.gif')
            ));

            if (!Mage::app()->isSingleStoreMode()) {
            	if(!Mage::helper('extnewsletter')->isModuleEnabled('Egovs_Isolation'))
            	{
            		$stores = Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm();
            	}
            	else 
            	{
            		$stores = Mage::helper('isolation/store')->getStoreValuesForForm();
            	}
            	
            	
                $fieldset->addField('stores','multiselect',array(
                    'name'          => 'stores[]',
                    'label'         => Mage::helper('newsletter')->__('Subscribers From'),
                    'image'         => $this->getSkinUrl('images/grid-cal.gif'),
                    'values'        => $stores,
                    'value'         => $queue->getStores(),
                	//'onchange'       => "toogleIssue(this)",
                ));
            }
            else {
                $fieldset->addField('stores', 'hidden', array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                ));
            }
        } else {
            $fieldset->addField('date','date',array(
                'name'      => 'start_at',
                'time'      => true,
                'disabled'  => 'true',
                'format'    => $outputFormat,
                'label'     => Mage::helper('newsletter')->__('Queue Date Start'),
                'image'     => $this->getSkinUrl('images/grid-cal.gif')
            ));

            if (!Mage::app()->isSingleStoreMode()) {
                $fieldset->addField('stores','multiselect',array(
                    'name'          => 'stores[]',
                    'label'         => Mage::helper('newsletter')->__('Subscribers From'),
                    'image'         => $this->getSkinUrl('images/grid-cal.gif'),
                    'required'      => true,
                    'values'        => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(),
                    'value'         => $queue->getStores()
                ));
            }
            else {
                $fieldset->addField('stores', 'hidden', array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                ));
            }
        }

        if ($queue->getQueueStartAt()) {
            $form->getElement('date')->setValue(
                Mage::app()->getLocale()->date($queue->getQueueStartAt(), Varien_Date::DATETIME_INTERNAL_FORMAT)
            );
        }

        $fieldset->addField('subject', 'text', array(
            'name'      =>'subject',
            'label'     => Mage::helper('newsletter')->__('Subject'),
            'required'  => true,
            'value'     => ($queue->isNew() ? $queue->getTemplate()->getTemplateSubject() : $queue->getNewsletterSubject())
        ));

        $fieldset->addField('sender_name', 'text', array(
            'name'      =>'sender_name',
            'label'     => Mage::helper('newsletter')->__('Sender Name'),
            'title'     => Mage::helper('newsletter')->__('Sender Name'),
            'required'  => true,
            'value'     => ($queue->isNew() ? $queue->getTemplate()->getTemplateSenderName() : $queue->getNewsletterSenderName())
        ));

        $fieldset->addField('sender_email', 'text', array(
            'name'      =>'sender_email',
            'label'     => Mage::helper('newsletter')->__('Sender Email'),
            'title'     => Mage::helper('newsletter')->__('Sender Email'),
            'class'     => 'validate-email',
            'required'  => true,
            'value'     => ($queue->isNew() ? $queue->getTemplate()->getTemplateSenderEmail() : $queue->getNewsletterSenderEmail())
        ));


        
       $selectedProducts = Mage::getModel('extnewsletter/mysql4_queueproduct_collection')->getProductsForQueue($queue->getId());
       
       $fieldset->addField('products','multiselect',array(
                    'name'          => 'news_for_products[]',
                    'label'         => Mage::helper('newsletter')->__('send to Customer subscribe to this Product'),
                    'image'         => $this->getSkinUrl('images/grid-cal.gif'),
                    'values'        => $this->__getProducts(),
                    'value'         => $selectedProducts
          ));
          
        $fieldset->addField('isues_id','multiselect',array(
                    'name'          => 'news_for_issues[]',
                    'label'         => Mage::helper('newsletter')->__('send to Customer subscribe to this Issue'),
                    'image'         => $this->getSkinUrl('images/grid-cal.gif'),
                    'values'        => $this->__getIssues(),
                    'value'         => $this->__getSelectedIssues(),
          ));
                
        $widgetFilters = array('is_email_compatible' => 1);
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('widget_filters' => $widgetFilters));

        if ($queue->isNew()) {
            $fieldset->addField('text','editor', array(
                'name'      => 'text',
                'label'     => Mage::helper('newsletter')->__('Message'),
                'state'     => 'html',
                'required'  => true,
                'value'     => $queue->getTemplate()->getTemplateText(),
                'style'     => 'width:98%; height: 600px;',
                'config'    => $wysiwygConfig
            ));

            $fieldset->addField('styles', 'textarea', array(
                'name'          =>'styles',
                'label'         => Mage::helper('newsletter')->__('Newsletter Styles'),
                'container_id'  => 'field_newsletter_styles',
                'value'         => $queue->getTemplate()->getTemplateStyles()
            ));
        } elseif (Mage_Newsletter_Model_Queue::STATUS_NEVER != $queue->getQueueStatus()) {
            $fieldset->addField('text','textarea', array(
                'name'      =>    'text',
                'label'     =>    Mage::helper('newsletter')->__('Message'),
                'value'     =>    $queue->getNewsletterText(),
            ));

            $fieldset->addField('styles', 'textarea', array(
                'name'          =>'styles',
                'label'         => Mage::helper('newsletter')->__('Newsletter Styles'),
                'value'         => $queue->getNewsletterStyles()
            ));

            $form->getElement('text')->setDisabled('true')->setRequired(false);
            $form->getElement('styles')->setDisabled('true')->setRequired(false);
            $form->getElement('subject')->setDisabled('true')->setRequired(false);
            $form->getElement('sender_name')->setDisabled('true')->setRequired(false);
            $form->getElement('sender_email')->setDisabled('true')->setRequired(false);
            $form->getElement('stores')->setDisabled('true');
        } else {
            $fieldset->addField('text','editor', array(
                'name'      =>    'text',
                'label'     =>    Mage::helper('newsletter')->__('Message'),
                'state'     => 'html',
                'required'  => true,
                'value'     =>    $queue->getNewsletterText(),
                'style'     => 'width:98%; height: 600px;',
                'config'    => $wysiwygConfig
            ));

            $fieldset->addField('styles', 'textarea', array(
                'name'          =>'styles',
                'label'         => Mage::helper('newsletter')->__('Newsletter Styles'),
                'value'         => $queue->getNewsletterStyles(),
                'style'         => 'width:98%; height: 300px;',
            ));
        }
          
  

        $this->setForm($form);
        return parent::_prepareForm();
    }
    
    
    private function __getProducts()
    {
    	    $collection = Mage::getResourceModel('catalog/product_collection')
            	->addAttributeToSelect('sku')
            	->addAttributeToSort('name')
            	//->addAttributeToFilter('type_id', Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE);
            	->addAttributeToFilter('extnewsletter', '1');
            	
			$options = array();
           

            
            
            $items = $collection->load()->getItems();
            foreach($items as $item)
            {
            	 $options[] = array(
                'label' => $item->getData('name') .'/'.$item->getData('sku'),
                'value' => $item->getData('entity_id')
            	);
            	
            }
            
            return $options;
    }
    
   
    
    
    private function __getIssues()
    {
    	    $collection = Mage::getResourceModel('extnewsletter/issue_collection');
    	    if (!Mage::app()->isSingleStoreMode())
    	    {
          		$store = $this->getQueue()->getStores();
          		if($store){
    	    		$collection->addStoreOrAllFilter($this->getQueue()->getStores());
          		}
          		//StoreIsolation
          		if(Mage::helper('extnewsletter')->isModuleEnabled('Egovs_Isolation'))
          		{
          			$stores = Mage::helper('isolation')->getUserStoreViews();
          			if(count($stores) > 0)
          			{
          				$collection->addStoreOrAllFilter($stores);
          			}
          		}
    	    }
          	//die($collection->getSelect()->__toString());
			$options = array();
            $items = $collection->load()->getItems();
            foreach($items as $item)
            {
            	$options[] = array(
                'label' => $item->getData('title'),
                'value' => $item->getData('extnewsletter_issue_id')
            	);
            	
            }
            
            return $options;
    }
    
    private function __getSelectedIssues()
    {
    	    $id = $this->getQueue()->getId();
    	    $options = array();
    	    if($id != null)
    	    {
    	    	$collection = Mage::getResourceModel('extnewsletter/queueissue_collection');
	    	  	$collection->getSelect()->where("queue_id=". $id);
	            $items = $collection->load()->getItems();
	            foreach($items as $item)
	            {
	            	$options[] = $item->getIssueId();
	            }
    	    }
            return $options;
    }
    

    
    protected function _afterToHtml($html)
    {
    	$url = $this->getUrl('extnewsletter/adminhtml_issue/availIssuse')."?id=";
    	$html .= "<script type=\"text/javascript\">
    		function toogleIssue(obj)
    		{
    			var selected = ''; 
    			for(j = 0; j < obj.options.length; j++) 
    			{ 
    				if(obj.options[j].selected) 
    				{ 
    					selected += obj.options[j].value + ',';
    				} 
    			} 

    			var url = '".$url."'+selected
    			new Ajax.Updater('isues_id', url, { method: 'get' });
    		}
    	
    	</script>"; 
    	return $html;
    }
    
}// Class Mage_Adminhtml_Block_Newsletter_Queue_Edit_Form END
