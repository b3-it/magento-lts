<?php

class Slpb_Extstock_Block_Adminhtml_Extstock_Edit_Tab_Status extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('extstock_status', array('legend'=>Mage::helper('extstock')->__('Order Status')));
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);		 
		 
		try
		{
			$acl = Mage::getSingleton('acl/productacl');
			$canStatus = $acl->testPermission('admin/extstock/extstockorderlist/extstockstatus');
			$canInStock = $acl->testPermission('admin/extstock/extstockorderlist/instock');
		}
		catch(Exception $e)
		{
			$canStatus = true;
		}

		if($canStatus && Mage::registry('extstock_data')->getOrigData('status') != Slpb_Extstock_Helper_Data::DELIVERED)
		{
			
			$fieldset->addField('status', 'select', array(
				'label'     => Mage::helper('extstock')->__('Status'),
		        'name'      => 'status',		      	
		        'values'    => array(
					array(
						'value'     => Slpb_Extstock_Helper_Data::ORDERED,
			            'label'     => Mage::helper('extstock')->__('Ordered'),
					),
					array(
		                'value'     => Slpb_Extstock_Helper_Data::DELIVERED,
		                'label'     => Mage::helper('extstock')->__('Delivered'),
					)
				),
			));
	   
			$fieldset->addField('date_delivered', 'date', array(
				'label'     => Mage::helper('extstock')->__('Delivery Date'),
	          	'required'  => false,
	     	  	'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,//DATE_INTERNAL_FORMAT,
	          	'name'      => 'date_delivered',
	     	  	'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	     	  	'format'       => $dateFormatIso	
			));
		} else {
			$fieldset->addField('status', 'select', array(
		          'label'     => Mage::helper('extstock')->__('Status'),
		          'name'      => 'status',
				  'disabled'  => 'disabled',		      	
		          'values'    => array(
						array(
							'value'     => Slpb_Extstock_Helper_Data::ORDERED,
							'label'     => Mage::helper('extstock')->__('Ordered'),
						),
						array(
		                  	'value'     => Slpb_Extstock_Helper_Data::DELIVERED,
		                  	'label'     => Mage::helper('extstock')->__('Delivered'),
						)
					),
			));

			$fieldset->addField('date_delivered', 'date', array(
		        'label'     => Mage::helper('extstock')->__('Delivery Date'),
		        'required'  => false,
		        'disabled'  => 'disabled',	
		     	'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
		        'name'      => 'date_delivered',
		     	'image'  => $this->getSkinUrl('images/grid-cal.gif'),
		     	'format'       => $dateFormatIso	
			));			
		}
		
		if($canInStock)
		{
			$fieldset->addField('is_in_stock', 'select', array(
					'label'		=> Mage::helper('extstock')->__('Stock'),
					'required'	=> false,
					'name'		=> 'is_in_stock',
					'values'	=> array(
							array(
								'value' => 1,
								'label' => Mage::helper('extstock')->__('In stock')
							), 
							array(
								'value' => 0,
								'label' => Mage::helper('extstock')->__('Not in stock')
							)
					)
			));
		}
		else
		{
			$fieldset->addField('is_in_stock', 'select', array(
					'label'		=> Mage::helper('extstock')->__('Stock'),
					'required'	=> false,
					'disabled'  => 'disabled',
					'name'		=> 'is_in_stock',
					'values'	=> array(
							array(
								'value' => 1,
								'label' => Mage::helper('extstock')->__('In stock')
							), 
							array(
								'value' => 0,
								'label' => Mage::helper('extstock')->__('Not in stock')
							)
					)
			));	
		}

		 
		if ( Mage::getSingleton('adminhtml/session')->getExtstockData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getExtstockData());
			Mage::getSingleton('adminhtml/session')->setExtstockData(null);
		} elseif ( Mage::registry('extstock_data') ) {
			$data = Mage::registry('extstock_data')->getData();
			if (is_array($data) && array_key_exists('product_id', $data)) {
				$collection = Mage::getModel('cataloginventory/stock_item')->getCollection()
	        		->addFieldToFilter("product_id", array("eq" => $data['product_id']));
	        	if ($collection && !is_null($collection) && $collection->getSize() > 0) {
	        		//Es sollte nur ein Item drin sein
	        		$data['is_in_stock'] = $collection->getFirstItem()->getIsInStock();
	        	}
			}
			$form->setValues($data);
		}
		return parent::_prepareForm();
	}
}