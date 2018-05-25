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
	
	protected $_layoutHandles = null;
  
	
	/**
	 * layout handles wildcar patterns
	 *
	 * @var array
	 */
	protected $_layoutHandlePatterns = array(
			'^default$',
			'^catalog_category_*',
			'^catalog_product_*',
			'^PRODUCT_*'
	);
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      
      
      $model = Mage::registry('contexthelp_data');
      
      $fieldset = $form->addFieldset('contexthelp_form', array('legend'=>Mage::helper('contexthelp')->__(' Contexthelp information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('contexthelp')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      		'value' => $model->getTitle()
      ));
      


      $opt= Mage::getModel('contexthelp/category')->getOptions();     	
      
      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('contexthelp')->__('Category'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'category_id',
      		'options' => $opt,
      		'value' => $model->getCategoryId()
      ));
    

      
      

      $value = array();
      foreach($model->getHandles() as $item)
      {
      	$value[] = array('value'=>$item->getHandle());
      }
      
      $values = $this->_getHandles();
      $fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
      $fieldset->addField('handle', 'ol', array(
      		'label'     => Mage::helper('contexthelp')->__('Handler'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'show_up_down' =>false,
      		'name'      => 'handle',
      		'values' =>$values,
      		'value' => $value
      ));
      
      
      $value = array();
      foreach($model->getBlocks() as $item)
      {
      	$value[] = array('value'=>$item->getBlockId(),'pos'=>$item->getPos());
      }
      
      $values = $this->_getCmsBlocks();
      $fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
      $fieldset->addField('block', 'ol', array(
      		'label'     => Mage::helper('contexthelp')->__('Block'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'block',
      		'values' =>$values,
      		'value' => $value
      ));
      
     
/*

      if ( Mage::getSingleton('adminhtml/session')->getcontexthelpData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcontexthelpData());
          Mage::getSingleton('adminhtml/session')->setcontexthelpData(null);
      } elseif ( Mage::registry('contexthelp_data') ) {
          $form->setValues(Mage::registry('contexthelp_data')->getData());
      }
      */
      return parent::_prepareForm();
  }
  
  
  protected function _getCmsBlocks()
  {
  	$collection = Mage::getModel('cms/block')->getCollection();
  	$res = array();
  
  
  	foreach($collection as $item)
  	{
  		$res[$item->getIdentifier()] = array('label'=>$item->getTitle(), 'value'=>$item->getId());
  	}
  	return $res;
  }
  
  /**
   * Getter
   *
   * @return string
   */
  protected function _getArea()
  {
  	if (!$this->_getData('area')) {
  		return Mage_Core_Model_Design_Package::DEFAULT_AREA;
  	}
  	return $this->_getData('area');
  }
  
  /**
   * Getter
   *
   * @return string
   */
  protected function _getPackage()
  {
  	if (!$this->_getData('package')) {
  		return Mage_Core_Model_Design_Package::DEFAULT_PACKAGE;
  	}
  	return $this->_getData('package');
  }
  
  /**
   * Getter
   *
   * @return string
   */
  protected function _getTheme()
  {
  	if (!$this->_getData('theme')) {
  		return Mage_Core_Model_Design_Package::DEFAULT_THEME;
  	}
  	return $this->_getData('theme');
  }
  
  
  
  
  protected function _getHandles()
  {
  	
  	if($this->_layoutHandles == null)
  	{
  		/* @var $update Mage_Core_Model_Layout_Update */
  	 	$update = Mage::getModel('core/layout')->getUpdate();
     	$this->_layoutHandles = array();
     	
    	$this->_collectLayoutHandles($update->getFileLayoutUpdatesXml($this->_getArea(), $this->_getPackage(), $this->_getTheme()));
  	}
  	$res = array();
  
  
  	foreach($this->_layoutHandles as $k=>$v)
  	{
  		$res[$k] = array('label'=>$v, 'value'=>$k);
  	}
  	return $res;
  }
  
  protected function _collectLayoutHandles($layoutHandles)
  {
  	if ($layoutHandlesArr = $layoutHandles->xpath('/*/*/label/..')) {
  		foreach ($layoutHandlesArr as $node) {
  			if ($this->_filterLayoutHandle($node->getName())) {
  				$helper = Mage::helper(Mage_Core_Model_Layout::findTranslationModuleName($node));
  				$this->_layoutHandles[$node->getName()] = $this->helper('core')->jsQuoteEscape(
  						$helper->__((string)$node->label)
  						);
  			}
  		}
  		asort($this->_layoutHandles, SORT_STRING);
  	}
  }
  
  /**
   * Getter
   *
   * @return array
   */
  public function getLayoutHandlePatterns()
  {
  	return $this->_layoutHandlePatterns;
  }
  
  /**
   * Check if given layout handle allowed (do not match not allowed patterns)
   *
   * @param string $layoutHandle
   * @return boolean
   */
  protected function _filterLayoutHandle($layoutHandle)
  {
  	$wildCard = '/('.implode(')|(', $this->getLayoutHandlePatterns()).')/';
  	if (preg_match($wildCard, $layoutHandle)) {
  		return false;
  	}
  	return true;
  }
  
}
