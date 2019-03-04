<?php

/**
 *
 *  Observer zum Verarbeite der Templateinfos bei der BE Bearbeitung der  Kundengruppen 
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Model_Observer extends Mage_Core_Model_Abstract
{
	public function onCustomerGroupSaveBefore($observer)
	{
		
		$store = Mage::app()->getRequest()->getParam('store_id');
		if(!isset($store)){
			$store = 0;
		}
	

		if(		Mage::app()->getRequest()->getParam('invoice_template') == 0 ||
				Mage::app()->getRequest()->getParam('shipping_template') == 0 ||
				Mage::app()->getRequest()->getParam('creditmemo_template') == 0 )
		{
			Mage::throwException('Select PDF Templates please!');
		}
		
	
	}
	
	
	/**
	 * Nachträgliches laden der Storeabhängigen pdf-Template konfiguration
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 */
	public function onCustomerGroupLoadAfter($observer)
	{
		$store = Mage::app()->getRequest()->getParam('store');
		if(!isset($store)){
			$store = 0;
		}
		
		$customerGroup = $observer->getObject();
		
		$pdfStores = Mage::getModel('pdftemplate/customergroup_store')->loadByStore($customerGroup->getId(), $store);
		$data = $customerGroup->getData();
		$data['store_id'] = $store;
		$data['invoice_template'] = $pdfStores->getInvoiceTemplateId();
		$data['shipping_template'] = $pdfStores->getShippingTemplateId();
		$data['creditmemo_template'] = $pdfStores->getCreditmemoTemplateId();
		$customerGroup->setData($data);
		
	}
	
	
	
	public function onCustomerGroupSaveAfter($observer)
	{
		
		$store = Mage::app()->getRequest()->getParam('store_id');
		if(!isset($store)){
			$store = 0;
		}
	
		$group = $observer->getEvent()->getObject();
		$pdfStores = Mage::getModel('pdftemplate/customergroup_store')->loadByStore($group->getId(), $store);
		$pdfStores->setInvoiceTemplateId(intval(Mage::app()->getRequest()->getParam('invoice_template')));
		$pdfStores->setShippingTemplateId(intval(Mage::app()->getRequest()->getParam('shipping_template')));
		$pdfStores->setCreditmemoTemplateId(intval(Mage::app()->getRequest()->getParam('creditmemo_template')));
		$pdfStores->save();
		
	}
	
	public function afterCustomerGroupEditFormPrepare($observer)
	{
		$block = $observer->getBlock();
		if($block instanceof Mage_Adminhtml_Block_Customer_Group_Edit_Form)
		{
			$form = $block->getForm();
			$form->setMethod('post');
			
			$store = 0;
			if(!Mage::app()->isSingleStoreMode())
			{
				$layout = $block->getLayout();
				$left = $layout->getBlock('left');
				$left->append($layout->createBlock('adminhtml/store_switcher', 'store_switcher'));
				$store = Mage::app()->getRequest()->getParam('store');
				if(!isset($store)){
					$store = 0;
				}
			}
			
			//falls store == 0 alle anderen Felder deaktivieren
			if($store != 0)
			{
				$this->disableFields($block);
			}
			
			
			$fieldset = $form->addFieldset('pdftemplate_fieldset', array('legend'=> Mage::helper('pdftemplate')->__('PDF Templates')));
			
		    $pdf = Mage::getSingleton('pdftemplate/template');
	        if($pdf != null)
	        {
	        
	        	
	        	$fieldset->addField('store_id', 'hidden',
	        			array('name'  => 'store_id')
	        			);
	        	
		        $fieldset->addField('invoice_template', 'select',
		            array(
		                'name'  => 'invoice_template',
		                'label' => Mage::helper('pdftemplate')->__('Invoice PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Invoice PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray(Egovs_Pdftemplate_Model_Type::TYPE_INVOICE)
		            )
		        );
		        
		       $fieldset->addField('shipping_template', 'select',
		            array(
		                'name'  => 'shipping_template',
		                'label' => Mage::helper('pdftemplate')->__('Shipment PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Shipment PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray(Egovs_Pdftemplate_Model_Type::TYPE_DELIVERYNOTE)
		            )
		        );
		        
		        
		        $fieldset->addField('creditmemo_template', 'select',
		            array(
		                'name'  => 'creditmemo_template',
		                'label' => Mage::helper('pdftemplate')->__('Creditmemo PDF Template'),
		                'title' => Mage::helper('pdftemplate')->__('Creditmemo PDF Template'),
		                'class' => 'required-entry',
		                'required' => true,
		                'values' => $pdf->toOptionArray(Egovs_Pdftemplate_Model_Type::TYPE_CREDITMEMO)
		            )
		        );
		        
		        $customerGroup = Mage::registry('current_group');
		        $pdfStores = Mage::getModel('pdftemplate/customergroup_store')->loadByStore($customerGroup->getId(), $store);
		        $data = $customerGroup->getData();
		        $data['store_id'] = $store;
		        $data['invoice_template'] = $pdfStores->getInvoiceTemplateId();
		        $data['shipping_template'] = $pdfStores->getShippingTemplateId();
		        $data['creditmemo_template'] = $pdfStores->getCreditmemoTemplateId();
		        
	            $form->addValues($data);
	        }
			
		}
	}
	
	/**
	 * 
	 * Alle Felder /Fieldsets Verstecken und Werte in hidden Felder kopieren
	 * @param Mage_Adminhtml_Block_Customer_Group_Edit_Form $block
	 */
	private function disableFields(Mage_Adminhtml_Block_Customer_Group_Edit_Form $block)
	{
		$fieldsets = $block->getForm()->getElements();
		foreach($fieldsets as $fieldset)
		{
			$fieldset->setClass('no-display');
			$fieldset->setLegend(null);
			if($fieldset instanceof Varien_Data_Form_Element_Fieldset)
			{
				$elements = $fieldset->getElements();
				foreach($elements as $element)
				{
					if(!$element instanceof Varien_Data_Form_Element_Hidden)
					{
						if(!$element instanceof Varien_Data_Form_Element_Multiselect)
						{
							$name = $element->getName();
							//if($element->getName() == 'tax_class')
							{
								$element->setName($name.'_');
								$fieldset->addField($name, 'hidden',
		        					array('name'  => $name,
		        						  'value' => $element->getValue()
		        						)
		        					);
							}
							
						}else 
						{
							$name = str_replace('[]', '', $element->getName());
							$values = $element->getValue();
							for($i =0, $iMax = count($values); $i < $iMax; $i++)
							{
								//$values = $element->getValues();
								$element->setName($name.'_[]');
								$fieldset->addField($name.$i, 'hidden',
										array('name'  => $name.'[]',
												'value' => $values[$i]
										)
								);
	        }
						}
						$element->setRequired(false);
						$element->setClass('disabled no-display');
						$element->setDisabled(true);
						
			
		}
	}
			}
		}
	}
	
	

}

