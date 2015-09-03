<?php

class Slpb_Extstock_Block_Adminhtml_Stock_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      
      
      $model  = $this->getModel();
      
      $form->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('extstock')->__('Stock Titel'),
            'title'     => Mage::helper('extstock')->__('Stock Titel'),
            'required'  => true,
      		'class' => 'required-entry',
            'value'     => $model->getName(),
        ));
        
       $form->addField('addressname', 'text', array(
            'name'      => 'addressname',
            'label'     => Mage::helper('extstock')->__('Name'),
            'title'     => Mage::helper('extstock')->__('Name'),
            //'required'  => true,
            'value'     => $model->getAddressname(),
        ));
       
       $form->addField('addressname2', 'text', array(
       		'name'      => 'addressname2',
       		'label'     => Mage::helper('extstock')->__('Name 2'),
       		'title'     => Mage::helper('extstock')->__('Name 2'),
       		//'required'  => true,
       		'value'     => $model->getAddressname2(),
       ));
       
       $form->addField('street', 'text', array(
            'name'      => 'street',
            'label'     => Mage::helper('extstock')->__('Street'),
            'title'     => Mage::helper('extstock')->__('Street'),
            //'required'  => true,
            'value'     => $model->getStreet(),
        ));
      
        $form->addField('city', 'text', array(
            'name'      => 'city',
            'label'     => Mage::helper('extstock')->__('City'),
            'title'     => Mage::helper('extstock')->__('City'),
            //'required'  => true,
            'value'     => $model->getCity(),
        ));
        
       $form->addField('postcode', 'text', array(
            'name'      => 'postcode',
            'label'     => Mage::helper('extstock')->__('Postcode'),
            'title'     => Mage::helper('extstock')->__('Postcode'),
            //'required'  => true,
            'value'     => $model->getPostcode(),
        ));
        
       $form->addField('phone', 'text', array(
            'name'      => 'phone',
            'label'     => Mage::helper('extstock')->__('Phone'),
            'title'     => Mage::helper('extstock')->__('Phone'),
            //'required'  => true,
            'value'     => $model->getPhone(),
        ));
        
       $form->addField('fax', 'text', array(
            'name'      => 'fax',
            'label'     => Mage::helper('extstock')->__('Fax'),
            'title'     => Mage::helper('extstock')->__('Fax'),
            //'required'  => true,
            'value'     => $model->getFax(),
        ));
      
      $form->addField('email', 'text', array(
            'name'      => 'email',
            'label'     => Mage::helper('extstock')->__('Email'),
            'title'     => Mage::helper('extstock')->__('Email'),
            //'required'  => true,
            'value'     => $model->getEmail(),
        ));  
        
 
        
        $form->addField('delivery_hint', 'text', array(
            'name'      => 'delivery_hint',
            'label'     => Mage::helper('extstock')->__('Delivery Hint'),
            'title'     => Mage::helper('extstock')->__('Delivery Hint'),
            //'required'  => true,
            'value'     => $model->getDeliveryHint(),
        ));  

        $form->addField('delivery_note', 'text', array(
            'name'      => 'delivery_note',
            'label'     => Mage::helper('extstock')->__('Note'),
            'title'     => Mage::helper('extstock')->__('Note'),
            //'required'  => true,
            'value'     => $model->getDeliveryNote(),
        )); 
        
       $form->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('extstock')->__('Type'),
            'title'     => Mage::helper('extstock')->__('Type'),
            //'required'  => true,
       		'options'	=> Slpb_Extstock_Model_Stock::getTypeOptionsArray(),
            'value'     => $model->getType(),
        ));  
        
     $form->addField('default_order_qty', 'text', array(
            'name'      => 'default_order_qty',
            'label'     => Mage::helper('extstock')->__('Default Order Qty'),
            'title'     => Mage::helper('extstock')->__('Default Order Qty'),
            //'required'  => true,
            'value'     => $model->getDefaultOrderQty(),
        )); 

      $form->addField('default_warning_qty', 'text', array(
            'name'      => 'default_warning_qty',
            'label'     => Mage::helper('extstock')->__('Warning Qty'),
            'title'     => Mage::helper('extstock')->__('Warning Qty'),
            //'required'  => true,
            'value'     => $model->getDefaultWarningQty(),
        )); 
        
      return parent::_prepareForm();
  }
  
   public function getModel()
    {
        return Mage::registry('extstock_data');
    }
}