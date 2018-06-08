<?php

class Bfr_EventManager_Block_Adminhtml_ToCms_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpasen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_New_Form
	 * 
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/create'),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		)
		);


        $event = Mage::getModel('eventmanager/event')->load(intval($this->getRequest()->getParam('id')));

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('localparams_form', array('legend'=>Mage::helper('eventmanager')->__('Copy To CMS')));

		$options = Mage::getModel('core/store')->getCollection()->toOptionArray();
		$fieldset->addField('event_id', 'hidden', array(
				'name'      => 'event_id',
				'value'	=> $this->getRequest()->getParam('id'),
		
		));


        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('cms')->__('Title'),
            'title'     => Mage::helper('cms')->__('Title'),
            'required'  => true,
            'value' => $event->getTitle()
        ));

        $fieldset->addField('identifier', 'text', array(
            'name'      => 'identifier',
            'label'     => Mage::helper('cms')->__('Identifier'),
            'title'     => Mage::helper('cms')->__('Identifier'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'value' => $event->getProduct()->getSku()
        ));

        $fieldset->addField('store_id', 'select', array(
            'label'     => Mage::helper('eventmanager')->__('Store'),
            //'class'     => 'required-entry',
            //'required'  => true,

            'name'      => 'store_id',
            'values'	=> $options,

        ));

        $categorys = $this->_getCategories();


        $fieldset->addField('parent_category', 'select', array(
            'label'     => Mage::helper('eventmanager')->__('Parent Category'),
            //'class'     => 'required-entry',
            //'required'  => true,

            'name'      => 'parent_category',
            'values'	=> $categorys,

        ));

        $fieldset->addField('category', 'text', array(
            'name'      => 'category',
            'label'     => Mage::helper('cms')->__('Category Name'),
            'required'  => true,

            'value' => $event->getTitle()
        ));

		return parent::_prepareForm();
	}

    protected function _getCategories($addEmpty = true)
    {
        //$tree = Mage::getResourceModel('catalog/category_tree');

        $collection = Mage::getResourceModel('catalog/category_collection');

        $collection->addAttributeToSelect('name')
            //->addLevelFilter(2)
            //->addRootLevelFilter()
            ->load();

        $options = array();

        if ($addEmpty) {
            $options[] = array(
                'label' => Mage::helper('adminhtml')->__('-- Please Select a Parent Category --'),
                'value' => ''
            );
        }
        foreach ($collection as $category) {
            if($category->getLevel() > 1)
            {
                $options[] = array(
                    'label' => $category->getName(),
                    'value' => $category->getId()
                );
            }
        }

        return $options;
    }
    
}