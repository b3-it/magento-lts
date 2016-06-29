<?php
/**
 * 
 *  Neuer Tab mit den Stores für BE Nutzerverwaltung
 *  @category Egovs
 *  @package  Egovs_Isolation_Block_Adminhtml_Permissions_User_Edit_Tabs_Stores
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Block_Adminhtml_Permissions_User_Edit_Tabs_Store extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

	
	/**
	 * Fügt Felder zum Form hinzu
	 * 
	 * @return Mage_Adminhtml_Block_Widget_Form
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Form::_prepareForm()
	 */
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('store_form', array('legend'=>Mage::helper('isolation')->__('Stores')));
	
		$user = Mage::registry('permissions_user');
		
		$storeGroups = array();
		foreach(Mage::getModel('adminhtml/system_store')->getGroupCollection()  as $storegroup)
		{
			$storeGroups[] = array('label' => $storegroup->getName(), 'value' =>$storegroup->getId());
		}
		
		$fieldset->addField('stores', 'multiselect', array(
                'label'     => Mage::helper('isolation')->__('allowed Stores'),
//                'required'  => true,
                'name'      => 'store_groups[]',
                'values'    => $storeGroups,
		 		'value' 	=> $user->getStoreGroups()
            ));
	
		
	
		
		return parent::_prepareForm();
	}
	
	/**
	 * Return Tab Label
	 *
	 * @return string
	 */
	public function getTabLabel() {
		return Mage::helper('isolation')->__('Stores');
	}
	
	/**
	 * Return Tab Titel
	 *
	 * @return string
	 */
	public function getTabTitle() {
		return Mage::helper('isolation')->__('Stores');
	}
	
	/**
	 * Darf Tab angezeigt werden
	 *
	 * @return boolean
	 */
	public function canShowTab() {
		return true;
	}
	
	/**
	 * Ist der Tab versteckt
	 *
	 * @return boolean
	 */
	public function isHidden() {
		return false;
	}
}