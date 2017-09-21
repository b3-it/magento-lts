<?php


class Gka_UserStore_Model_Entity_Attribute_Backend_Allowedstores
    extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    /**
     * Process the attribute value before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Eav_Model_Entity_Attribute_Backend_Abstract
     */
    public function beforeSave($object)
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $data = $object->getData($attributeCode);
        

        if (!is_array($data)) {
            $data = explode(',', $data);
        }

         // I like it nice and tidy, this gives us sequential index numbers again as a side effect :)
        sort($data);

        $object->setData($attributeCode, implode(',', $data));
        return parent::beforeSave($object);
    }


    /**
     * In case the data was loaded, explode it into an array
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Eav_Model_Entity_Attribute_Backend_Abstract
     */
    public function afterLoad($object)
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $data = $object->getData($attributeCode);

        // only explode and set the value if the attribute is set on the model
        if (null !== $data && is_string($data)) {
            $data = explode(',', $data);
            $object->setData($attributeCode, $data);
        }
        return parent::afterLoad($object);
    }
}
