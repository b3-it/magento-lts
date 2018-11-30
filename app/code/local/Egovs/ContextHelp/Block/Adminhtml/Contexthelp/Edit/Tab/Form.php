<?php
/**
*
* @category   	Egovs ContextHelp
* @package    	Egovs_ContextHelp
* @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tab_Form
* @author 		Holger Kögel <h.koegel@b3-it.de>
* @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*/
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Liste alles aktiven Layout-Handles
     *
     * @var Mage_Core_Model_Layout
     */
	protected $_layoutHandles = null;

	/**
	* layout handles wildcar patterns
	* diese Handels werden NICHT angezeigt!!
	* @var array
	*/
	protected $_layoutHandlePatterns = array(
		'^default$',
	);

	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$model = Mage::registry('contexthelp_data');

		$fieldset = $form->addFieldset('contexthelp_form', array('legend'=>Mage::helper('contexthelp')->__(' Contexthelp information')));

		$fieldset->addField('title', 'text', array(
			'label'     => Mage::helper('contexthelp')->__('Title'),
			'name'      => 'title',
			'value'     => $model->getTitle()
		));

		$fieldset->addField('category_id', 'select', array(
			'label'     => Mage::helper('contexthelp')->__('Category'),
			'name'      => 'category_id',
		    'options'   => Mage::getModel('contexthelp/category')->getOptions(),
			'value'     => $model->getCategoryId()
		));

        $fieldset->addField('package_theme', 'text', array(
            'label'     => Mage::helper('contexthelp')->__('Package/Theme'),
            'readonly'  => true,
            'disabled'  => true,
            'name'      => 'package_theme',
            'value'     => $model->getPackageTheme()
        ));

		/**
		 * Check is single store mode
		 */
		if (!Mage::app()->isSingleStoreMode()) {
			$field = $fieldset->addField('store_id', 'multiselect', array(
				'name'     => 'store_id[]',
				'label'    => Mage::helper('contexthelp')->__('Store'),
				'title'    => Mage::helper('contexthelp')->__('Store'),
				'required' => true,
				'disabled' => false,
				'values'   => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
				'value'    => $model->getStoreId()
			));
			$renderer = $this->getLayout()->createBlock('adminhtml/store_switcher_form_renderer_fieldset_element');
			$field->setRenderer($renderer);
		}
		else {
			$fieldset->addField('store_id', 'hidden', array(
				'name'     => 'store_id[]',
				'value'    => $model->getStoreId()
			));
		}

		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$fieldset->addField('handle', 'ol', array(
			'label'        => Mage::helper('contexthelp')->__('Handler'),
			'show_up_down' => false,
			'name'         => 'handle',
		    'values'       => $this->_getHandles(),
		    'value'        => $this->_getSelectedHandles($model),
		));


		$fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
		$fieldset->addField('block', 'ol', array(
			'label'     => Mage::helper('contexthelp')->__('Block'),
			'name'      => 'block',
		    'values'    => $this->_getCmsBlocks(),
		    'value'     => $this->_getSelectedBlocks($model),
		));

		return parent::_prepareForm();
	}
	
	/**
	 * ermitteln aller für das Layout verfügbaren Handels
	 *
	 * @return array[]
	 */
	protected function _getHandles()
	{
	    if($this->_layoutHandles == null) {
	        /* @var $helper Egovs_ContextHelp_Helper_Data */
	        $helper = Mage::helper('contexthelp');
	        $this->_layoutHandles = $helper->getAllLayoutUpdates(false, $this);
	    }
	    $res = array();
	    
	    foreach($this->_layoutHandles as $k => $v) {
	        $res[$k] = array('label' => $v, 'value' => $k);
	    }
	    return $res;
	}
	
	/**
	 * get all selected Handles
	 * 
	 * @param  $model     Egovs_ContextHelp_Model_Resource_Contexthelp_Collection
	 * @access public
	 * @return array[]
	 */
	public function _getSelectedHandles(Egovs_ContextHelp_Model_Resource_Contexthelp_Collection $model)
	{
	    $value = array();
	    foreach($model->getHandles() as $item) {
	        $value[] = array('value' => $item->getHandle());
	    }
	    
	    return $value;
	}

	/**
	 * ermitteln aller für das Layout verfügbaren CMS-Blöcke
	 *
	 * @return array[]
	 */
	protected function _getCmsBlocks()
	{
	    /* @var $helper Egovs_ContextHelp_Helper_Data */
	    $helper = Mage::helper('contexthelp');
	    return $helper->getAllAvailableBlocks();
	}
	
	/**
	 * get all selected Blocks
	 *
	 * @param  $model     Egovs_ContextHelp_Model_Resource_Contexthelp_Collection
	 * @access public
	 * @return array[]
	 */
	public function _getSelectedBlocks(Egovs_ContextHelp_Model_Resource_Contexthelp_Collection $model)
	{
		$value = array();
		foreach($model->getBlocks() as $item) {
			$value[] = array('value' => $item->getBlockId(),'pos' => $item->getPos());
		}

		return $value;
	}
}
