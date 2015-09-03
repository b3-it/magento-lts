<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Egovs
 *  @package  Sid_Framecontract_Block_Adminhtml_Import_Edit_Form
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abomigration_Block_Adminhtml_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Add fieldset
     *
     * @return Mage_ImportExport_Block_Adminhtml_Import_Edit_Form
     */
    protected function _prepareForm()
    {
        $helper = Mage::helper('importexport');

        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getUrl('*/*/validate'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => $helper->__('Import Settings')));

      	
        $opts = Mage::getSingleton('adminhtml/system_config_source_store')->toOptionArray();
        array_unshift($opts, '');
        //if (!Mage::app()->isSingleStoreMode())
        //{

        $opts = Mage::getSingleton('adminhtml/system_config_source_website')->toOptionArray();
        array_unshift($opts, '');
        	$fieldset->addField('website', 'select', array(
            'name'     => 'website',
            'title'    => $helper->__('Website'),
            'label'    => $helper->__('Website'),
            'required' => true,
            'values'   => $opts
        	 ));

        	
        	$opts = Mage::getSingleton('adminhtml/system_config_source_store')->toOptionArray();
        	array_unshift($opts, '');
        	$fieldset->addField('store', 'select', array(
            'name'     => 'store',
            'title'    => $helper->__('Store'),
            'label'    => $helper->__('Store'),
            'required' => true,
            'values'   => $opts
        	));
        //}

 /*
        $fieldset->addField('product_id', 'select', array(
            'name'     => 'product_id',
            'title'    => $helper->__('Product'),
            'label'    => $helper->__('Product'),
            'required' => true,
            'values'   => Mage::getSingleton('abomigration/system_config_source_products')->toOptionArray()
        	));
*/
  
        $fieldset->addField(Mage_ImportExport_Model_Import::FIELD_NAME_SOURCE_FILE, 'file', array(
        		'name'     => Mage_ImportExport_Model_Import::FIELD_NAME_SOURCE_FILE,
        		'label'    => $helper->__('Select File to Import'),
        		'title'    => $helper->__('Select File to Import'),
        		'required' => true
        ));


        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }

	

}
