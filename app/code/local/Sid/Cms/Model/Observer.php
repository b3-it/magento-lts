<?php
/**
 * Sid Cms
 *
 *
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Model_Observer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Model_Observer extends Varien_Object
{
    /**
     *
     * @param Varien_Event_Observer $observer
     */
    public function onAdminhtmlCmsPageEditTabMainPrepareForm($observer)
		{
			$form = $observer->getForm();
			$fieldset = $form->getElement('base_fieldset');
			
			$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
			$fieldset->addField('activate_time', 'date', array(
	      		'label'     => Mage::helper('sidcms')->__('Activate this Page at'),
	      		'name'      => 'activate_time',
	      		'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
	      		'image'  => Mage::getDesign()->getSkinUrl('images/grid-cal.gif'),
	      		'format'       => $dateFormatIso,
	      		'time' => 	true,
				'class'     => 'validate-datetime'
      		));
			
			$fieldset->addField('deactivate_time', 'date', array(
					'label'     => Mage::helper('sidcms')->__('Deactivate this Page at'),
					'name'      => 'deactivate_time',
					'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
					'image'  => Mage::getDesign()->getSkinUrl('images/grid-cal.gif'),
					'format'       => $dateFormatIso,
					'time' => 	true,
					'class'     => 'validate-datetime'
			));
			
			 $fieldset->addField('customergroups_show', 'multiselect', array(
      		'label'     => Mage::helper('sidcms')->__('Show to Customer Groups'),
      		//'required'  => true,
      		'values'    => $this->_getCustomerGroup(),
      		'name'      => 'customergroups_show',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      		));

		}
		
		private function _getCustomerGroup()
		{
			$collection = Mage::getResourceModel('customer/group_collection')->load();
		
			$res = array();
			
			$res[] = array('value'=>'-1','label'=> Mage::helper('sidcms')->__('All Customer Groups'));
			foreach($collection as $item){
				$res[] = array('value'=>$item->getId(),'label'=>$item->getCustomerGroupCode());
			}
			
			return $res;
		}
		
		/**
		 * das Kundengruppen Array serialisieren 
		 * 
		 * @param Varien_Event_Observer $observer
		 */
		public function onCmsPageSaveBefore($observer)
		{
			$page = $observer->getDataObject();	
			$show = $page->getData('customergroups_show');
			if(is_array($show)){
				$show = implode(',', $show);
			}else if (empty($show)) {
				$show ="-1";
			}
			$page->setData('customergroups_show', $show);
			
		}
		
		/**
		 * 
		 * @param Varien_Event_Observer $observer
		 */
		public function onCmsPageSaveAfter($observer)
		{
			$page = $observer->getDataObject();
			$send = $page->getSend();
			if($send && ($send['mode'] != Sid_Cms_Model_SendMode::MODE_NONE ))
			{
				$customers = array();
				if(isset($send['customergroup']))
				{
					$groups = $send['customergroup'];
					if(count($groups) > 0){
						
						
						$collection = Mage::getModel('customer/customer')->getCollection();
						$collection
							->addAttributeToSelect('firstname')
							->addAttributeToSelect('lastname')
							->addAttributeToSelect('prefix')
							->addAttributeToSelect('company');
						
						//All Customer Groups = -1
						if(array_search('-1', $groups) === false){
							$groups= implode(',', $groups);
							$collection->getSelect()->where('group_id IN(?)',$groups);
						}
							
							
						$customers = $collection->getItems();
					}
				}
				$model = Mage::getModel('infoletter/queue');
				$model->setData($send);
				if($send['mode'] == Sid_Cms_Model_SendMode::MODE_NOW){
					$model->setStatus(Egovs_Infoletter_Model_Status::STATUS_SENDING);
				}else{
					$model->setStatus(Egovs_Infoletter_Model_Status::STATUS_NEW);
				}
				$model	->setCreatedAt(now())
						->save();
				
				foreach($customers as $customer){
					Mage::getModel('infoletter/recipient')
						->createByCustomer($customer,$model->getId())
						->setStatus(Egovs_Infoletter_Model_Recipientstatus::STATUS_UNSEND)
						->save();
				}
				
			}
				
		}
		
		/**
		 * das Kundengruppen Array deserialisieren
		 * 
		 * @param Varien_Event_Observer $observer
		 */
		public function onCmsPageLoadAfter($observer)
		{
			$page = $observer->getDataObject();
			$show = $page->getData('customergroups_show');
			if(!is_array($show)){
				if(strlen(trim($show)) > 0){
					$show = explode(',',$show);
				}else{
					$show = array(-1);
				}
				$page->setData('customergroups_show',$show);
			}
				
		}

}
