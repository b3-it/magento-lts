<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Edit_Tab_Transfer extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('framecontract')->__('Transfer information')));
     
      
      $select = $fieldset->addField('transfer_type', 'select', array(
      		'label'     => Mage::helper('framecontract')->__('Type'),
      		'required'  => true,
      		'values'    => Sid_ExportOrder_Model_Type_Transfer::getTypeList(),
      		'name'      => 'transfer_type',
      		'onchange'  => 'onchangeTransferType()',
      
      ));

      $vendorId = Mage::registry('vendor_data')->getData('framecontract_vendor_id');
      $url = $this->getUrl('adminhtml/exportOrder_transfer/transferform',array('vendor'=>$vendorId));
      $select->setAfterElementHtml('
                        <script>
                        function onchangeTransferType() {
      						var type = $("transfer_type").getValue();
      						var url = "'.$url.'";
      						url = url.replace("transferform", "transferform/type/" + type);
							new Ajax.Request(url, {
							  method:\'get\',
							  onSuccess: function(transport) {
							    var response = transport.responseText || "no response text";
							    $("vendor_form_transfer_details").update(response);
							    hideUseClientCertCa();
							  },
							  onFailure: function() { alert(\'Something went wrong...\'); }
							});
                       }
      					onchangeTransferType();
                        </script>
      		
                    ');
      
      
      //$fieldset = $form->addFieldset('vendor_form_transfer_details', array('legend'=>Mage::helper('framecontract')->__('Transfer Details')));

      if ( Mage::getSingleton('adminhtml/session')->getFramecontractData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFramecontractData());
          Mage::getSingleton('adminhtml/session')->setFramecontractData(null);
      } elseif ( Mage::registry('vendor_data') ) {
          $form->setValues(Mage::registry('vendor_data')->getData());
      }
      return parent::_prepareForm();
  }
  
  protected function _afterToHtml($html)
  {
  		$html .= '<div id="vendor_form_transfer_details">';
  		return $html;
  }
  
}