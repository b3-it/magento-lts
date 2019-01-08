<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Participant_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('participant_form', array('legend'=>Mage::helper('eventmanager')->__('Persanal information')));
      
      $events = array();
      $collection = Mage::getModel('eventmanager/event')->getCollection();
      foreach($collection as $item)
      {
      	$events[$item->getEventId()] = $item->getTitle();
      }
      
      $lock = false;
      $data = Mage::registry('participant_data');
      if($data)
      {
      	if((intval($data->getOrderId()) > 0) || (intval($data->getEventId()) > 0)){
      		$lock = true;
      		//dupliziieren wg. disabled selectbox und hidden
      		$data->setEventId1($data->getEventId());
      	}
      }
      
      
      $fieldset->addField('back_event', 'hidden', array(
      		'name'      => 'back_event',
      ));
      
      if($lock){
	      $fieldset->addField('event_id1', 'select', array(
	      		'label'     => Mage::helper('eventmanager')->__('Event'),
	      		'class'     => 'disabled',
	      		'disabled'  => true,
	      		'values'    => $events,
	      		'name'      => 'event_id1',
	      		'value' =>$data->getEventId()
	      ));
	      $fieldset->addField('event_id', 'hidden', array(
	      		'name'      => 'event_id',
	      ));
      }else 
      {
      	$fieldset->addField('event_id', 'select', array(
      			'label'     => Mage::helper('eventmanager')->__('Event'),
      			//'class'     => $lock ? 'readonly':'',
      			//'readonly'  => $lock,
      			'values'    => $events,
      			'name'      => 'event_id',
      	));
      }
      
      $fieldset->addField('prefix', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Prefix'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'prefix',
      ));
      
      $fieldset->addField('academic_titel', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Academic Title'),
      		
      		'name'      => 'academic_titel',
      ));
      
      $fieldset->addField('position', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Occupation'),
      		
      		'name'      => 'position',
      ));
      
      $fieldset->addField('firstname', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('First Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'firstname',
      ));
      
      $fieldset->addField('lastname', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Last Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'lastname',
      ));
      
      $fieldset->addField('postfix', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('postfix'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'postfix',
      ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'email',
      ));
      
      $fieldset->addField('phone', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Phone'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'phone',
      ));
      
      $fieldset->addField('company', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Company'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'company',
      ));
      
      $fieldset->addField('company2', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Company 2'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'company2',
      ));
      
      $fieldset->addField('company3', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Company 3'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'company3',
      ));

      $fieldset->addField('city', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('City'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'city',
      ));

      $fieldset->addField('street', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Street'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'street',
      ));
      
      $fieldset->addField('postcode', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Postcode'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'postcode',
      ));
      
      $fieldset->addField('country', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Country'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'country',
      ));
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('eventmanager')->__('Status'),
          'name'      => 'status',
          'values'    => Bfr_EventManager_Model_Status::getAllOptions(),
      ));



      $yesno = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      $fieldset->addField('vip', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('VIP'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $yesno,
      		'name'      => 'vip',
      ));
      
      $fieldset->addField('online_eval', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Online Evaluation'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $yesno,
      		'name'      => 'online_eval',
      ));
      
      
      $fieldset->addField('internal', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Internal'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $yesno,
      		'name'      => 'internal',
      ));
      
      $fieldset->addField('note', 'editor', array(
      		'name'      => 'note',
      		'label'     => Mage::helper('eventmanager')->__('Note'),
      		'title'     => Mage::helper('eventmanager')->__('Note'),
      		'style'     => 'width:700px; height:500px;',
      		'wysiwyg'   => false,
      		//'required'  => true,
      ));
      
     
      $form->setValues($data);
      
      return parent::_prepareForm();
  }
}
