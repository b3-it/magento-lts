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
			
			 $fieldset->addField('customergroups_hide', 'multiselect', array(
      		'label'     => Mage::helper('sidcms')->__('Hide from Customer Groups'),
      		//'required'  => true,
      		'values'    => $this->_getCustomerGroup(),
      		'name'      => 'customergroups_hide',
      		'value'	=> ''
      		//'onchange'  => 'onchangeTransferType()',
      
      		));

		}
		
		private function _getCustomerGroup()
		{
			$collection = Mage::getResourceModel('customer/group_collection')->load();
		
			$res = array();
			
			foreach($collection as $item){
				$res[] = array('value'=>$item->getId(),'label'=>$item->getCustomerGroupCode());
			}
			
			return $res;
		}
		
		/**
		 * das Kundengruppen Array serialisieren 
		 * @param unknown $observer
		 */
		public function onCmsPageSaveBefore($observer)
		{
			$page = $observer->getDataObject();	
			$hide = $page->getData('customergroups_hide');
			if(is_array($hide)){
				$hide = implode(',', $hide);
			}else{
				$hide ="";
			}
			$page->setData('customergroups_hide',$hide);
			
		}
		
		public function onCmsPageSaveAfter($observer)
		{
			$page = $observer->getDataObject();
			$send = $page->getSend();
			if($send && ($send['mode'] != Sid_Cms_Model_SendMode::MODE_NONE ))
			{
				$model = Mage::getModel('infoletter/queue');
				$model->setData($send);
				if($send['mode'] == Sid_Cms_Model_SendMode::MODE_NOW){
					$model->setStatus(Egovs_Infoletter_Model_Status::STATUS_SENDING);
				}else{
					$model->setStatus(Egovs_Infoletter_Model_Status::STATUS_NEW);
				}
				$model	->setCreatedTime(now())
						->setUpdateTime(now())
						->save();
			}
				
		}
		
		/**
		 * das Kundengruppen Array deserialisieren
		 * @param unknown $observer
		 */
		public function onCmsPageLoadAfter($observer)
		{
			$page = $observer->getDataObject();
			$hide = $page->getData('customergroups_hide');
			if(strlen(trim($hide)) > 0){
				$hide = explode(',',$hide);
			}else{
				$hide = array();
			}
			$page->setData('customergroups_hide',$hide);
				
		}

}
