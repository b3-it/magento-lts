<?php 

/**
 * @var Mage_Api2_Model_Config $config
 */
$config = Mage::getModel('api2/config');

foreach (array('framecontract_los', 'framecontract_contract', 'framecontract_vendor') as $res) {

    /**
     * @var Mage_Api2_Model_Acl_Filter_Attribute $model
     */
    $model = Mage::getModel('api2/acl_filter_attribute');
    $user = 'admin';
    $opt = Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ;

    // check if such attributes already exist for this resource
    if (false === $model->getResource()->getAllowedAttributes($user, $res, $opt)) {
        $model->setData('user_type', $user);
        $model->setData('resource_id', $res);
        $model->setData('operation', $opt);

        $attributes = implode(',', array_keys($config->getResourceAttributes($res)));
        $model->setData('allowed_attributes', $attributes);

        $model->save();
    }
}
?>