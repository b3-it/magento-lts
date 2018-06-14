<?php

class Bfr_EventManager_Block_Adminhtml_ToCms_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct() {
		parent::__construct();
		 
		$this->_objectId = 'id';
		$this->_blockGroup = 'eventmanager';
		$this->_controller = 'adminhtml_toCms';
		$this->_mode = 'new';

		$this->_updateButton('save', 'label', Mage::helper('eventmanager')->__('Continue'));
		$this->removeButton('reset');
		$this->removeButton('delete');


        $this->_formInitScripts[]="
        function switchNew()
        	{
        		if(\$j('#new_category').is(':checked'))
        		{
        			\$j('#category').show();
        			\$j('#category').addClass(\"required-entry\");
        			\$j('label[for=\"category\"]').show();
                    \$j('label[for=\"parent_category\"]').html('" . Mage::helper('eventmanager')->__('Parent Category') . "');
        		}
        		else
        		{
        			\$j('#category').hide();
        			\$j('#category').removeClass(\"required-entry\");
        			\$j('label[for=\"category\"]').hide();
                    \$j('label[for=\"parent_category\"]').html('" . Mage::helper('eventmanager')->__('Category') . "');
        		}
        	}
        
        ";
	}

	protected function _prepareLayout() {
		parent::_prepareLayout();
		 
		return $this;
	}

	public function getHeaderText() {

		return Mage::helper('eventmanager')->__('New CMS Block');

	}
	
	public function getBackUrl()
	{
		return $this->getUrl('*/eventmanager_event/edit',array('id'=>$this->getRequest()->getParam('id')));
	}


}