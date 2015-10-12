<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'framecontract';
        $this->_controller = 'adminhtml_contract';

        $this->_updateButton('save', 'label', Mage::helper('framecontract')->__('Save Contract'));
        $this->_updateButton('delete', 'label', Mage::helper('framecontract')->__('Delete Contract'));

        //if ($this->_isAllowedAction('emails'))
        {
            $this->addButton('send_notification', array(
                'label'     => Mage::helper('framecontract')->__('Send Email'),
                'onclick'   => 'confirmSetLocation(\''
                . Mage::helper('framecontract')->__('Are you sure you want to send email to vendor?')
                . '\', \'' . $this->getSendUrl() . '\')'
            ));
        }

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('contract_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'contract_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'contract_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";

        $url = $this->getUrl('*/framecontract_vendor/default');

        $this->_formScripts[] = '
        	//<![CDATA[
        	$(\'framecontract_vendor_id\').observe(\'change\', updateOperator);


        	function updateOperator() {
			        var url = "'.$url.'id/" + $(\'framecontract_vendor_id\').value;
        	    new Ajax.Request(url, {
  			                          method: \'get\',
  			                          onSuccess: function(transport) {
  			                          	    var response = Ext.util.JSON.decode(transport.responseText);
    		                          	    $(\'operator\').value = response.name;
    		                          	    $(\'order_email\').value = response.email;
  			                          }
				                      });
        	}

        	document.addEventListener(\'DOMContentLoaded\', function() {
              updateOperator();
          }, false);
        	//]]>
        	';


    }

    public function getHeaderText()
    {
        if( Mage::registry('contract_data') && Mage::registry('contract_data')->getId() ) {
            return Mage::helper('framecontract')->__("Edit Contract '%s'", $this->htmlEscape(Mage::registry('contract_data')->getTitle()));
        } else {
            return Mage::helper('framecontract')->__('Add Contract');
        }
    }

	public function getSendUrl()
    {
        return $this->getUrl('*/framecontract_transmit/send',array('id'=>Mage::registry('contract_data')->getId()));
    }

}