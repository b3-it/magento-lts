<?php

class Egovs_Informationservice_Block_Adminhtml_Request_View_Form extends Egovs_Informationservice_Block_Adminhtml_Request_Abstract_Form_Task
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(false);
      $this->setForm($form);
      $this->setIsDisabled(true);
      return parent::_prepareForm();
  }
}