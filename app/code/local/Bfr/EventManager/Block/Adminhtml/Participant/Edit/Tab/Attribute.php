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
class Bfr_EventManager_Block_Adminhtml_Participant_Edit_Tab_Attribute extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('participant_form', array('legend'=>Mage::helper('eventmanager')->__('Attribute information')));

      $role = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_ROLE)->getAllOption();
      $fieldset->addField('role_id', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Role'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $role,
      		'name'      => 'role_id',
      ));
      
      $job = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_JOB)->getAllOption();
      $fieldset->addField('job_id', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Job'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $job,
      		'name'      => 'job_id',
      ));
      
      $industry = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY)->getAllOptions(false);
      $fieldset->addField('industry', 'multiselect', array(
      		'label'     => Mage::helper('eventmanager')->__('industry'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $industry,
      		'name'      => 'industry',
      ));
      
      $lobby = Mage::getModel('eventmanager/lookup_model')->setTyp(Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY)->getAllOptions(false);
      $fieldset->addField('lobby', 'multiselect', array(
      		'label'     => Mage::helper('eventmanager')->__('Lobby'),
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		'values'    => $lobby,
      		'name'      => 'lobby',
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getEventManagerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventManagerData());
          Mage::getSingleton('adminhtml/session')->setEventManagerData(null);
      } elseif ( Mage::registry('participant_data') ) {
          $form->setValues(Mage::registry('participant_data')->getData());
      }
      return parent::_prepareForm();
  }
}
