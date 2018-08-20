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

		$translateUrl = $this->getUrl('*/eventmanager_toCms/translate',array('store_id'=>'store_xx','product_id'=>'product_xx'));

        $this->_formInitScripts[]="
        function switchNew()
        	{
        		if(\$j('#new_category').is(':checked'))
        		{
        			
                    \$j('label[for=\"parent_category\"]').html('" . Mage::helper('eventmanager')->__('Parent Category') . "');
        		}
        		else
        		{
        			
                    \$j('label[for=\"parent_category\"]').html('" . Mage::helper('eventmanager')->__('Category') . "');
        		}
        	}
        function translateTitle()
        {
            var store = \$j('#store_id').val();
            var product = \$j('#product_id').val();
            var url = '{$translateUrl}';
            url = url.replace('product_xx',product);
            url = url.replace('store_xx',store);
            
            \$j.getJSON( url, function( data ) {
              \$j('#category').val(data['name']);
              \$j('#title').val(data['name']);
              
            });
                        
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