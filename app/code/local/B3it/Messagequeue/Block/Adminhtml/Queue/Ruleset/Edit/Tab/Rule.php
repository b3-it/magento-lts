<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Rule_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Ruleset_Edit_Tab_Rule extends Mage_Adminhtml_Block_Widget_Form
{
	protected $_compare = null;
	protected $_compareModelList = null; 
	
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('b3it/messagequeue/rule.phtml');
	
	}

	
	public function getCompareOptions()
	{
		$this->_compare = array();
		$opt = Mage::getConfig()->getNode('global/b3it_messagequeue/compare')->asArray();
		
		foreach($opt as $k=>$v)
		{
			$this->_compare[$k] = Mage::helper('b3it_mq')->__($v['label']);
		}
		return $this->_compare;
	}
	
	public function getCompareInputList()
	{
		$res = array();
	
		foreach($this->getCompareModelList() as $k=>$v)
		{
			$res[$k] = $v->getFormInputHtml();
		}
		return json_encode($res);
	}
	
	public function getCompareModelList()
	{
		if($this->_compareModelList == null)
		{
			$this->_compareModelList = array();
			$opt = Mage::getConfig()->getNode('global/b3it_messagequeue/compare')->asArray();
		
			foreach($opt as $k=>$v)
			{
				$model= Mage::getModel($v['model']);
				if($model){
					$model->setLabel($v['label']);
					$this->_compareModelList[$k] = $model;
				}
			}
		}
		return $this->_compareModelList;
	}
	
	protected function _getModelByName($name)
	{
		$list = $this->getCompareModelList();
		if(isset($list[$name])){
			return $list[$name];
		}
		
		return null;
	}
	
	public function getRules()
	{
		$rules = array();
		foreach(Mage::registry('queueruleset_data')->getRules() as $item){
			$model = $this->_getModelByName($item->getCompare());
			if($model){
				$rule = $item->getData();
				
				$rule['join_text'] = $rule['join'];
				$rule['compare_source'] = $rule['source'];
				$rule['compare_source_text'] = $rule['source'];
				
				$rule['compare_operator_text'] = $rule['operator'];
				$rule['compare_operator'] = $rule['operator'];
				$rule['not_text'] = $rule['is_not']?"not":"";
				$rule['not'] = $rule['is_not'];
				
				$rule['compare_text'] = $model->getLabel();
				$rule['compare_value'] = $rule['compare_value'];
				$rule['compare_value_text'] = $model->getLabel4Value($rule['compare_value']);
			
			
			$rules[] = json_encode($rule);
			}
		}
		return $rules;
	}
	
	
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('queuerule_form', array('legend'=>Mage::helper('b3it_mq')->__(' Queue Rule information')));

      $fieldset->addField('ruleset_id', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Rule'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ruleset_id',
      ));
      $fieldset->addField('condition', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Condition'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'condition',
      ));
      $fieldset->addField('lagical_operand', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Logical Operand'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'lagical_operand',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getqueueruleData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getqueueruleData());
          Mage::getSingleton('adminhtml/session')->setqueueruleData(null);
      } elseif ( Mage::registry('queuerule_data') ) {
          $form->setValues(Mage::registry('queuerule_data')->getData());
      }
      return parent::_prepareForm();
  }
}
