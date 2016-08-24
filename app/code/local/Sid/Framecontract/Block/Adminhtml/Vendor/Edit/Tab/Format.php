<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Edit_Tab_Format extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('framecontract')->__('Format information')));
     
      
      $select = $fieldset->addField('export_format', 'select', array(
      		'label'     => Mage::helper('framecontract')->__('Type'),
      		'required'  => true,
      		'values'    => Sid_ExportOrder_Model_Type_Format::getTypeList(),
      		'name'      => 'export_format',
      		'onchange'  => 'onchangeExportFormat()',
      		
      ));
      $vendorId = Mage::registry('vendor_data')->getData('framecontract_vendor_id');
      $url = $this->getUrl('adminhtml/exportOrder_format/typeform',array('vendor'=>$vendorId));
      $select->setAfterElementHtml('
                        <script>
                        function onchangeExportFormat() {
      						var type = $("export_format").getValue();
      						var url = "'.$url.'";
      						url = url.replace("typeform", "typeform/type/" + type); 
				      		new Ajax.Request(url, {
							  method:\'get\',
							  onSuccess: function(transport) {
							    var response = transport.responseText || "no response text";
							    $("vendor_form_format_details").update(response);
							  },
							  onFailure: function() { alert(\'Something went wrong...\'); }
							});
                        }
      					onchangeExportFormat();
                        </script>
                    ');
      

      $fieldset = $form->addFieldset('vendor_form_format_details', array('legend'=>Mage::helper('framecontract')->__('Format Details')));

      if ( Mage::getSingleton('adminhtml/session')->getFramecontractData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFramecontractData());
          Mage::getSingleton('adminhtml/session')->setFramecontractData(null);
      } elseif ( Mage::registry('vendor_data') ) {
          $form->setValues(Mage::registry('vendor_data')->getData());
      }
      return parent::_prepareForm();
  }
}