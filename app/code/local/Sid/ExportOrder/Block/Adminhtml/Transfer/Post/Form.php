<?php

/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *
 * @category  Sid
 * @package   Sid_ExportOrder
 * @author    Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 * @author    Holger Kögel <​h.koegel@b3-it.de>
 * @copyright Copyright (c) 2014-2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Transfer_Post_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {
        $transfer = Mage::registry('transfer');
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('vendor_form_transfer_details1', array('legend' => Mage::helper('framecontract')->__('Transfer Details')));
        $_address = $fieldset->addField('address', 'text', array(
            'label' => Mage::helper('exportorder')->__('Address'),
            'class' => 'required-entry input-text',
            'required' => true,
            'name' => 'transfer[address]',
        ));

        $_port = $fieldset->addField('port', 'text', array(
            'label' => Mage::helper('exportorder')->__('Port'),
            'class' => 'input-text',
            'name' => 'transfer[port]',
        ));

        $_user = $fieldset->addField('user', 'text', array(
            'label' => Mage::helper('exportorder')->__('Username'),
            'class' => 'input-text',
            'name' => 'transfer[user]',
        ));

        $_pwd = $fieldset->addField('pwd', 'text', array(
            'label' => Mage::helper('exportorder')->__('Password'),
            'class' => 'input-text',
            'name' => 'transfer[pwd]',
        ));

        $_clientcertAuth = $fieldset->addField('clientcert_auth', 'select', array(
            'label' => Mage::helper('exportorder')->__('Use authentication with client certificates'),
            'name' => 'transfer[clientcert_auth]',
            'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $deleteText = Mage::helper('exportorder')->__('Remove certificate');
        $_clientCertificate = $fieldset->addField('client_certificate', 'file', array(
            'label' => Mage::helper('exportorder')->__('Client Certificate'),
            'class' => $transfer->getClientCertificate() ? '' : 'required-file',
            'name' => 'client_certificate',
            'required' => $transfer->getClientCertificate() ? false : true,
            'note'     => Mage::helper('catalog')->__('Client certificate for authentication on server'),
            'after_element_html' => $transfer->getClientCertificate() ? "<span>{$transfer->getClientCertificate()}</span><span style='margin-left:3em'><input type='checkbox' name='client_certificate_delete'/><span style='margin-left:1em'>{$deleteText}</span></span>" : "",
        ));

        $_pwdClientCert = $fieldset->addField('client_certificate_pwd', 'password', array(
            'label' => Mage::helper('exportorder')->__('Password for Client Certificate'),
            'class' => 'input-text password',
            'required' => true,
            'name' => 'transfer[client_certificate_pwd]',
        ));

        $_useClientcertCa = $fieldset->addField('use_clientcert_ca', 'select', array(
            'label' => Mage::helper('exportorder')->__('Use CA information from client certificate to validate server?'),
            'name' => 'use_clientcert_ca',
            'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
            'required' => true,
        ));

        $_clientCa = $fieldset->addField('client_ca', 'file', array(
            'label' => Mage::helper('exportorder')->__('CA Certificate'),
            'class' => '',
            'name' => 'client_ca',
            'required' => false,
            'note'     => Mage::helper('catalog')->__('Optional CA to validate the server certificate'),
            'after_element_html' => $transfer->getClientCa() ? "<span>{$transfer->getClientCa()}</span><span style='margin-left:3em'><input type='checkbox' name='client_ca_delete'/><span style='margin-left:1em'>{$deleteText}</span></span>" : "",
        ));

        $fieldset->addField('check_connection', 'select', array(
            'label'     => Mage::helper('exportorder')->__('Check Connection'),
            'title'     => Mage::helper('exportorder')->__('Check Connection'),
            'name'      => 'transfer[check_connection]',
            'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray(),
        ));

        $this->setChild('form_after', $this->getLayout()
            ->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($_address->getHtmlId(), $_address->getName())
            ->addFieldMap($_port->getHtmlId(), $_port->getName())
            ->addFieldMap($_user->getHtmlId(), $_user->getName())
            ->addFieldMap($_pwd->getHtmlId(), $_pwd->getName())
            ->addFieldMap($_clientcertAuth->getHtmlId(), $_clientcertAuth->getName())
            ->addFieldMap($_clientCertificate->getHtmlId(), $_clientCertificate->getName())
            ->addFieldMap($_clientCa->getHtmlId(), $_clientCa->getName())
            ->addFieldMap($_pwdClientCert->getHtmlId(), $_pwdClientCert->getName())
            ->addFieldMap($_useClientcertCa->getHtmlId(), $_useClientcertCa->getName())
            ->addFieldDependence(
                $_clientCertificate->getName(),
                $_clientcertAuth->getName(),
                1
            )
            ->addFieldDependence(
                $_clientCa->getName(),
                $_clientcertAuth->getName(),
                1
            )
            ->addFieldDependence(
                $_pwdClientCert->getName(),
                $_clientcertAuth->getName(),
                1
            )
            ->addFieldDependence(
                $_useClientcertCa->getName(),
                $_clientcertAuth->getName(),
                1
            )
            ->addFieldDependence(
                $_clientCa->getName(),
                $_useClientcertCa->getName(),
                0
            )
        );

        $form->setValues(Mage::registry('transfer')->getData());
        //Workaround to set it to yes
        $_useClientcertCa->setValue(1);
        return parent::_prepareForm();
    }
}