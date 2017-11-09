<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// eMail-Server in der Config korrigieren
$this->setConfigData('customer/create_account/email_domain', 'mailserver.tu-freiberg.de');


// Anpassung der Einstellungen für Kundengruppen
$default_methods = serialize(array(
    'egovs_girosolution_giropay',
    'egovs_girosolution_creditcard',
    'bankpayment'
));

$group_settings = array(
    // Spezielle Kundengruppen
    4 => array(
        'code' => 'Privatkunden DE / EU',
        'data' => array(
            'company' => 0,
            'taxvat'  => 0,
            'allowed_payment_methods' => $default_methods
        )
    ),
    5 => array(
        'code' => 'Privatkunden Drittland',
        'data' => array(
            'company' => 0,
            'taxvat'  => 0,
            'allowed_payment_methods' => $default_methods
        )
    ),
    6 => array(
        'code' => 'Geschäftskunden EU mit USt-ID',
        'data' => array(
            'company' => 1,
            'taxvat'  => 2,
            'allowed_payment_methods' => $default_methods
        )
    ),
    7 => array(
        'code' => 'Geschäftskunden EU ohne USt-ID',
        'data' => array(
            'company' => 1,
            'taxvat'  => 0,
            'allowed_payment_methods' => $default_methods
        )
    ),
    8 => array(
        'code' => 'Geschäftskunden Drittland',
        'data' => array(
            'company' => 1,
            'taxvat'  => 2,
            'allowed_payment_methods' => $default_methods
        )
    ),
    9 => array(
        'code' => 'Geschäftskunden DE',
        'data' => array(
            'company' => 1,
            'taxvat'  => 2,
            'allowed_payment_methods' => $default_methods
        )
    ),
);

/** @var Mage_Customer_Model_Resource_Group_Collection $groups */
$groups = Mage::getModel('customer/group')->getCollection();

foreach($groups AS $group) {
    $code = trim( $group->getCustomerGroupCode() );
    $id   = $group->getCustomerGroupId();
    
    if (!array_key_exists($id, $group_settings)) {
        continue;
    }
    else {
        if ( $code == $group_settings[$id]['code'] ) {
            $data = $group_settings[$id]['data'];
            $model = Mage::getModel('customer/group')->load($id);
                $model->setCompany($data['company']);
                $model->setTaxvat($data['taxvat']);
                $model->setAllowedPaymentMethods($data['allowed_payment_methods']);
            $model->save();
        }
    }
}

$installer->endSetup();
