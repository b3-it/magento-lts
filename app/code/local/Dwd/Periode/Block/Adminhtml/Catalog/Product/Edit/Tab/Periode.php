<?php

class Dwd_Periode_Block_Adminhtml_Catalog_Product_Edit_Tab_Periode extends Mage_Adminhtml_Block_Widget  implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    private $_attributes = null;
    private $_product = null;
    public function __construct($attributes)
    {
    	$this->_attributes = $attributes;
        parent::__construct();
        $this->setTemplate('dwd/periode/catalog/product/tab/periode.phtml');
        //$this->setTemplate('dwd/periode/catalog/product/edit/periode.phtml');
        $this->setId('periode_settings');

    }

  	protected function _prepareLayout()
    {
    	 $this->setChild('reset_periode_row_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                 ->setData(array(
                                  'label'   => Mage::helper('periode')->__('Reset'),
                                  'class'   => 'reset',
                                  'id'      => 'reset_periode_row_button',
                                  'onclick' => 'resetData()'
                                )
                          )
        );

    	 $this->setChild('add_periode_row_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                 ->setData(array(
                                  'label'   => Mage::helper('catalog')->__('Add New Row'),
                                  'class'   => 'add add-select-row',
                                  'id'      => 'add_periode_row_button',
                                  'onclick' => 'addPeriodeData()'
                                  )
                          )
       );

        $this->setChild('periode_input_row',
        	$this->getLayout()->createBlock('periode/adminhtml_catalog_product_edit_tab_periode_input')
        	);

        $this->setChild('periode_content',
        	$this->getLayout()->createBlock('periode/adminhtml_catalog_product_edit_tab_periode_content')
        	);
        return parent::_prepareLayout();
    }


  

   protected function _getProduct()
    {
    	if (!$this->_product) {
    		$this->_product = Mage::registry('current_product');
    	}
        return $this->_product;
    }

    public function getAllButtons()
    {
        $ret = '';

        foreach( $this->getChild() AS $key => $val )
        {
            if ( $val instanceof Mage_Adminhtml_Block_Widget_Button )
            {
                $ret .= ' &nbsp; ' . str_replace(array('<span>', '</span>'), '', $this->getChildHtml($key));
            }
        }

        return $ret;
    }

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_periode_row_button');
    }

    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('delete_periode_row_button');
    }

    public function getInputHtml()
    {
        return $this->getChildHtml('periode_input_row');
    }

    public function getContentHtml()
    {
        return $this->getChildHtml('periode_content');
    }


    public function getAddRowUrl()
    {
    	return $this->getUrl('adminhtml/periode_periode/addRow');
    }

    public function getDeleteRowUrl()
    {
    	return $this->getUrl('adminhtml/periode_periode/deleteRow');
    }

      /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
    	return Mage::helper('periode')->__('Periode Settings');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
    	return "Title";
    }


    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
    	if (is_null($this->_getProduct())
    		|| $this->_getProduct()->isEmpty()
    		|| !$this->_getProduct()->getId()
    		) {
    			return false;
    		}
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
    	return false;
    }
}
