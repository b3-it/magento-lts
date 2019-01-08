<?php
/**
 * Erweitert die Speicherfunktion
 *
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2018 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class B3it_Admin_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('admin/user', 'user_id');
    }

    public function saveAttribute(Mage_Admin_Model_User $object, $field) {
        return $this->saveAttributes($object, $field);
    }

    public function saveAttributes(Mage_Admin_Model_User $object, array $fields) {
        $writeAdapter= $this->_getWriteAdapter();

        if (!$fields || !$object) {
            return $this;
        }

        $insertData = array();
        if (!is_array($fields)) {
            $fields = array($fields);
        }

        foreach ($fields as $field) {
            if (!$object->hasData($field) || !$object->getId()) {
                continue;
            }
            $insertData[$field] = $object->getData($field);
        }
        if (empty($insertData)) {
            return $this;
        }

        $writeAdapter->update($this->getMainTable(), $insertData, array("{$object->getIdFieldName()} = ?" => $object->getId()));

        return $this;
    }
}