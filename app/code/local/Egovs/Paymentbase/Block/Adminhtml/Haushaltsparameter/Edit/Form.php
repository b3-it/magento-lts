<?php
/**
 * Form-Block zum bearbeiten von Haushaltsparametern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpassen
	 *
	 * @return Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Edit_Form
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
			)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('haushaltsparameter_form', array('legend'=>Mage::helper('paymentbase')->__('Haushaltsparameter')));

		$fieldset->addField('title', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Title'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'title',
		));

		$fieldset->addField('value', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Value'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'value',
		));


		$types = Mage::getModel('paymentbase/haushaltsparameter_type');
		$fieldset->addField('type', 'select', array(
				'label'     => Mage::helper('paymentbase')->__('Type'),
				'name'      => 'type',
				'values'    => $types->getOptionHashArray()
		));

		if ( Mage::getSingleton('adminhtml/session')->getPaymentbaseData() ) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getPaymentbaseData());
			Mage::getSingleton('adminhtml/session')->setPaymentbaseData(null);
		} elseif ( Mage::registry('haushaltsparameter_data') ) {
			$form->setValues(Mage::registry('haushaltsparameter_data')->getData());
		}

		/*
		 if((Mage::registry('haushaltsparameter_data')->getType() == Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER)
		 		|| (Mage::registry('haushaltsparameter_data')->getType() == Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST))
			*/
		{
			$fieldset->addField('hhstelle', 'multiselect', array(
					'label'     => Mage::helper('paymentbase')->__('Haushaltsstelle'),
					'name'      => 'hhstellen',
					'value'		=> $this->_getSelectedHHStellen(),
					'values'    => $this->_getHHStellen(),
					'note'	=>Mage::helper('paymentbase')->__('For Objektnumber an Objektnumber Mwst only.')

			));

		}

		return parent::_prepareForm();
	}


	/**
	 * Verfügbare Haushaltsstellen ermitteln
	 *
	 * @return array
	 */
	protected function _getHHStellen() {
		$collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
		$collection->getSelect()->where('type = '. Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE);

		$res = array();
		foreach ($collection->getItems() as $item) {
			$res[] = array('value' => $item->getId(), 'label' => $item->getTitle());
		}
		return $res;
	}

	/**
	 * Ausgewählte Haushaltsstellen errmitteln
	 *
	 * @return array
	 */
	protected function _getSelectedHHStellen() {
		if (!Mage::registry('haushaltsparameter_data')->getId()) {
			return array();
		}
		$collection = Mage::getModel('paymentbase/haushaltsparameter_objektnummerhhstelle')->getCollection();
		$collection->getSelect()->where('objektnummer='.Mage::registry('haushaltsparameter_data')->getId());

		$res = array();
		foreach ($collection->getItems() as $item) {
			$res[] = $item->getHhstelle();
		}
		return $res;

	}
}