<?php

class B3it_Modelhistory_Model_Observer extends Varien_Object
{

    const TYPE_CREATED = 1;

    const TYPE_CHANGED = 2;

    const TYPE_DELETED = 3;

    /**
     * Ist das Tracing aktiviert?
     *
     * @var boolean
     */
    protected $_isEnabled = true;

    /**
     * Flag um zu prüfen ob es sich um Backend-Operationen handelt.
     *
     * @var boolean
     */
    protected $_isBackendOperation = false;

    /**
     * Enthält gecachte Einträge
     *
     * Wird benötigt um z. B. Änderungen an Adressen zu registrieren
     * Der Aufbau lauetet wie folgt:<br>
     * <pre>
     * array(
     * Type => array(ID => DATA)
     * )
     * </pre>
     *
     * @var array
     */
    protected $_cached = array();

    /**
     * @var array
     */
    protected $_class_names = null;

    /**
     * @var array
     */
    protected $_match_names = null;

    /**
     * @var array
     */
    protected $_ignored_attributes = null;

    /**
     * @var array
     */
    protected $_default_attributes = null;

    /**
     * @var array
     */
    protected $_ignored_attribute_matches = null;

    /**
     * Enthält bereits verarbeitete ID von ConfigData Objekten
     *
     * @var array
     */
    protected $_processedConfigData = array();

    /**
     * Liefert die Apache Request Headers zurück
     *
     * @return Varien_Object
     */
    protected function _getHeaders()
    {
        if (function_exists('apache_request_headers')) {
            $headers = new Varien_Object(apache_request_headers());
        } else {
            $headers = new Varien_Object();
        }

        return $headers;
    }

    /**
     * Liefert einige ausgewählte Informationen zur Backend-Session
     *
     * <ul>
     * <li>Username</li>
     * <li>Remote IP</li>
     * <li>VIA-HEADER</li>
     * <li>FORM-KEY</li>
     * </ul>
     *
     * @return Varien_Object
     */
    protected function _getSessionInformation()
    {
        $sessionInformation = new Varien_Object();

        /* @var $adminSession Mage_Admin_Model_Session */
        $adminSession = Mage::getSingleton('admin/session');

        $remoteAddr = "empty";
        $userName = "unknown";
        // only if admin/session is not empty
        if ($adminSession) {
            $validatorData = new Varien_Object($adminSession->getValidatorData());
            if ($validatorData->getRemoteAddr() != '') {
                $remoteAddr = $validatorData->getRemoteAddr();
            }
            $sessionInformation->setRemoteAddr($remoteAddr);

            if ($adminSession->getUser()) {
                $userName = $adminSession->getUser()->getUsername();
            }
        }

        $sessionInformation->setUserName($userName);
        $sessionInformation->setRemoteAddr($remoteAddr);

        $sessionInformation->setViaHeader($this->_getHeaders()->getVia());

        $sessionInformation->setSecretKey(Mage::getSingleton('adminhtml/url')->getSecretKey());

        return $sessionInformation;
    }

    /**
     * Hier müssen die Ausnahmen für bestimmte Models definiert werden
     *
     * @param Mage_Core_Model_Abstract $source
     *            Das zu Prüfende Model
     *
     * @return boolean
     */
    public function isTraceableObject($source)
    {
        // HardCoded to prevent loop
        if ($source instanceof B3it_ModelHistory_Model_History
            || $source instanceof B3it_ModelHistory_Model_Config
            || $source instanceof B3it_Modelhistory_Model_Settings) {
            return false;
        }

        // filter by full class name, that works with instanceof
        foreach ($this->_getClassNames() as $className) {
            if ($source instanceof $className) {
                return false;
            }
        }

        // need to iterate over all class names
        $objClassNames = array_values(array_merge([get_class($source)], class_parents($source)));

        foreach ($this->_getMatchNames() as $matchName) {
            foreach ($objClassNames as $className) {
                if (strpos($className, $matchName) !== false) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Ist dieses Funktion Verfügbar
     *
     * @return boolean
     */
    public function isAvailable()
    {
        if (!$this->_isBackendOperation) {
            return false;
        }

        return $this->_isEnabled;
    }

    /**
     * Prüft ob die Aktion im Backend stattfindet.
     *
     * @return void
     *
     * @see Varien_Object::_construct()
     */
    protected function _construct() {
        $session = Mage::getSingleton("admin/session");
        if ($session && !$session->isLoggedIn()) {
            return;
        }
        $this->_isBackendOperation = true;
    }

    /**
     * Erweitert die ursprüngliche Funktion um Methoden die mit 'on' beginnen!
     *
     * Alle implementierten Tracing-Event-Methoden müssen mit '_on' beginnen!
     *
     * @param string $method
     *            Name
     * @param array $args
     *            Parameter
     *
     * @return mixed
     *
     * @see Varien_Object::__call()
     */
    public function __call($method, $args)
    {

        switch (substr($method, 0, 2)) {
            case 'on':
                if (!$this->isAvailable()) {
                    return;
                }

                // Varien_Profiler::start('GETTER: '.get_class($this).'::'.$method);
                $method = '_' . $method;
                if (method_exists($this, $method) && isset($args[0])) {
                    $this->$method($args[0]);
                } else {
                    //throw new Exception("what?");
                    Mage::log(sprintf("Function '%s' doesn't exist or no data given, tracing not available!", $method, Zend_Log::ERR));
                }
                // Varien_Profiler::stop('GETTER: '.get_class($this).'::'.$method);
                return;
        }
        return parent::__call($method, $args);
    }

    /**
     * Loggt die Veränderung an Objekten
     *
     * Die Veränderungen werden in einem Diff ausgegeben
     *
     * @param Varien_Event_Observer $observer
     *            Observer
     *
     * @return void
     */
    protected function _onModelSaveAfter($observer)
    {

        /** @var Mage_Core_Model_Abstract $source */
        $source = $observer->getObject();

        $eventName = $observer->getEvent()->getName();

        if (strpos($eventName, 'core_config_data_') === 0) {
            // wird in _onCoreConfigDataSaveCommitAfter geloggt
            return;
        }
        if ($source instanceof Mage_Core_Model_Config_Data && !isset($this->_processedConfigData[$source->getId()])) {
            $this->_traceConfigData($source);
            if ($source->getId() > 0) {
                $this->_processedConfigData[$source->getId()] = true;
            }
            return;
        }

        $id = $source->getId();
        $data = $source->getData();
        $origData = $source->getOrigData();
        $className = get_class($source);

        if ($origData === null) {
            $origData = [];
        }

        // some models might reset isObjectNew before the save after is run,
        // look into origData
        $new = $source->isObjectNew() || empty($origData);

        if ($source instanceof Mage_Customer_Model_Address && !empty($id) && !empty($origData)) {
            if (isset($this->_cached[$className])) {
                // Type bereits vorhanden
                $this->_cached[$className][$source->getId()] = $source->getData();
            } else {
                // Type noch nicht vorhanden -> anlegen
                $this->_cached[$className] = array(
                    $source->getId() => $source->getData()
                );
            }
        } elseif ($source instanceof Mage_Customer_Model_Address && !empty($id) && empty($origData)) {
            if (isset($this->_cached[$className]) && isset($this->_cached[$className][$source->getId()])) {
                $origData = $this->_cached[$className][$source->getId()];
                // Objekt mit alten Daten füttern
                $tmpData = $source->getData();
                $source->setData($origData);
                // setzt $_origdata = $_data
                $source->setOrigData(null);
                // Original zurück speichern
                $source->setData($tmpData);
                // Eintrag wird nicht mehr benötigt
                unset($this->_cached[$className][$source->getId()]);
            }
        }

        if (!$source || !isset($id) || $source->isEmpty()) {
            return;
        }

        if (!$this->isTraceableObject($source)) {
            return;
        }

        $eventData = [
            'source' => $source,
            'hold' => new Varien_Object([
                'new' => $data,
                'old' => $origData
            ])
        ];

        Mage::dispatchEvent('b3it_modelhistory_model_save_diff', $eventData);

        /**
         * @var Varien_Object $hold
         */
        $hold = $eventData['hold'];
        if ($hold->hasData('abort')) {
            return;
        }

        $data = $hold->getNew();
        $origData = $hold->getOld();

        $this->_filterNewData($source, $origData, $data);

        $this->_filterOldData($source, $origData);

        if (!$new) {
            $changed = false;
            if ($source->dataHasChangedFor('')) {
                try {
                    $changed = $data != $origData;
                } catch (Exception $e) {
                    Mage::log(sprintf("Error: %s, tracing stopped!", $e->getMessage()), Zend_Log::ERR);
                }
            }

            if (empty($changed)) {
                return;
            }
        }
        if (isset($this->_cached[$className][$source->getId()])) {
            unset($this->_cached[$className][$source->getId()]);
        }

        // remove empty keys from new data
        $result_data = $data;

        ksort($result_data);
        if (!is_null($origData)) {
            ksort($origData);
            // data is equal after filter
            if ($result_data === $origData) {
                return;
            }
        }

        $sessionInformation = $this->_getSessionInformation();

        $model = Mage::getModel("b3it_modelhistory/history");

        $rev = 1;

        if (!$new) {
            /**
             * @var B3it_Modelhistory_Model_Resource_History_Collection $collection
             */
            $collection = $model->getCollection();
            $maxRevItem = $collection
            ->addFieldToFilter('model', get_class($source))
            ->addFieldToFilter('model_id', $source->getId())
            ->setPage(1,1)
            ->addAttributeToSort('rev', 'desc')->getFirstItem();

            if ($maxRevItem) {
                $rev += $maxRevItem->getData('rev');
            }
        } else {
            $origData = (object)null;
        }

        $data = array(
            'model' => get_class($source),
            'model_id' => $source->getId(),
            'ip' => $sessionInformation->getRemoteAddr(),
            'user' => $sessionInformation->getUserName(),
            'via' => $sessionInformation->getViaHeader(),
            'secret' => $sessionInformation->getSecretKey(),
            'value' => json_encode($result_data, JSON_UNESCAPED_UNICODE),
            'old_value' => json_encode($origData, JSON_UNESCAPED_UNICODE),
            'rev' => $rev,
            'date' => now(),
            'type' => $new ? self::TYPE_CREATED : self::TYPE_CHANGED
        );

        $model->setData($data)->save();
    }

    /**
     * Loggt das Löschen von Objekten
     *
     * @param Varien_Event_Observer $observer
     *            Observer
     *
     * @return void
     */
    protected function _onModelDeleteAfter($observer)
    {
        /* @var $source Mage_Core_Model_Abstract */
        $source = $observer->getObject();

        $id = $source->getId();
        if (!$source || !isset($id) || $source->isEmpty()) {
            return;
        }

        if (!$this->isTraceableObject($source)) {
            return;
        }

        $sessionInformation = $this->_getSessionInformation();

        $rev = 1;

        if ($source instanceof Mage_Core_Model_Config_Data) {
            $model = Mage::getModel("b3it_modelhistory/config");

            $old_value = $source->getValue();

            $collection = $model->getCollection();

            $maxRevItem = $collection
            ->addFieldToFilter('model_id', $source->getId())
            ->setPage(1,1)
            ->addAttributeToSort('rev', 'desc')->getFirstItem();

            if ($maxRevItem) {
                $rev += $maxRevItem->getData('rev');
                $old_value = $maxRevItem->getData('value');
            }

            $data = array(
                'path' => $source->getPath(),
                'group_id' => $source->getGroupId(),
                'store_code' => $source->getStoreCode(),
                'website_code' => $source->getWebsiteCode(),
                'scope' => $source->getScope(),
                'model_id' => $source->getId(),
                'ip' => $sessionInformation->getRemoteAddr(),
                'user' => $sessionInformation->getUserName(),
                'via' => $sessionInformation->getViaHeader(),
                'secret' => $sessionInformation->getSecretKey(),
                'value' => '',
                'old_value' => $old_value,
                'rev' => $rev,
                'date' => now(),
                'type' => self::TYPE_DELETED
            );

            $model->setData($data)->save();
        } else {
            $model = Mage::getModel("b3it_modelhistory/history");
            $collection = $model->getCollection();

            // TODO need to filter old data?
            $oldData = $source->getData();
            $this->_filterOldData($source, $oldData);
            $old_value = json_encode($oldData, JSON_UNESCAPED_UNICODE);

            $maxRevItem = $collection
            ->addFieldToFilter('model', get_class($source))
            ->addFieldToFilter('model_id', $source->getId())
            ->setPage(1,1)
            ->addAttributeToSort('rev', 'desc')->getFirstItem();

            if ($maxRevItem) {
                $rev += $maxRevItem->getData('rev');
                $old_value = $maxRevItem->getData('value');
            }

            $data = array(
                'model' => get_class($source),
                'model_id' => $source->getId(),
                'ip' => $sessionInformation->getRemoteAddr(),
                'user' => $sessionInformation->getUserName(),
                'via' => $sessionInformation->getViaHeader(),
                'rev' => $rev,
                'value' => '',
                'old_value' => $old_value,
                'secret' => $sessionInformation->getSecretKey(),
                'date' => now(),
                'type' => self::TYPE_DELETED
            );

            $model->setData($data)->save();
        }
    }


    /**
     * Loggt die Veränderung an Config-Objekten
     *
     * Die Veränderungen werden in einem Diff ausgegeben
     *
     * @param $observer Varien_Event_Observer Observer
     *
     * @return void
     */
    protected function _onCoreConfigDataSaveCommitAfter($observer) {

        /* @var $source Mage_Core_Model_Abstract */
        $source = $observer->getConfigData();

        if ($source instanceof Mage_Core_Model_Config_Data && !isset($this->_processedConfigData[$source->getId()])) {
            $this->_traceConfigData($source);
            $this->_processedConfigData[$source->getId()] = true;
            return;
        }
    }

    /**
     * Verfolgt Änderungen an der Konfiguration
     *
     * @param Mage_Core_Model_Config_Data $data
     *            Daten
     *
     * @return void
     */
    protected function _traceConfigData(Mage_Core_Model_Config_Data $data)
    {

        $objectNew = $data->isObjectNew();
        if (!$data || !$data->isValueChanged() && !$objectNew) {
            return;
        }

        if (preg_match('/\r\n|\n/', $data->getValue()) == true) {
            $old = str_replace("\r\n", "\n", $data->getOldValue());
            $new = str_replace("\r\n", "\n", $data->getValue());
            if ($old == $new) {
                return;
            }
        }

        if ($data instanceof Mage_Adminhtml_Model_System_Config_Backend_Encrypted) {
            $value = Mage::helper('core')->decrypt($data->getValue());

            if ($value == $data->getOldValue()) {
                return;
            }
        }

        $sessionInformation = $this->_getSessionInformation();

        $model = Mage::getModel("b3it_modelhistory/config");

        $rev = 1;
        // search only for model is not new
        if (!$objectNew) {
            $collection = $model->getCollection();
            $maxRevItem = $collection
            ->addFieldToFilter('model_id', $data->getId())
            ->setPage(1,1)
            ->addAttributeToSort('rev', 'desc')->getFirstItem();

            if ($maxRevItem) {
                $rev += $maxRevItem->getData('rev');
            }
        }

        $modelData = array(
            'path' => $data->getPath(),
            'group_id' => $data->getGroupId(),
            'store_code' => $data->getStoreCode(),
            'website_code' => $data->getWebsiteCode(),
            'scope' => $data->getScope(),
            'model_id' => $data->getId(),
            'ip' => $sessionInformation->getRemoteAddr(),
            'user' => $sessionInformation->getUserName(),
            'via' => $sessionInformation->getViaHeader(),
            'secret' => $sessionInformation->getSecretKey(),
            'value' => $data->getValue(),
            'old_value' => $data->getOldValue(),
            'rev' => $rev,
            'date' => now(),
            'type' => $objectNew ? self::TYPE_CREATED : self::TYPE_CHANGED
        );

        $model->setData($modelData)->save();
    }

    /**
     * Nötig da {@link Mage_Core_Model_App::__callObserverMethod} method_exists verwendet
     *
     * @param Varien_Event_Observer $observer
     *
     * @return void
     */
    public function doTrace($observer)
    {
        if (!($observer instanceof Varien_Event_Observer) || !$observer->hasEvent()) {
            return;
        }

        $this->__call(sprintf('on%s', $this->_camelize($observer->getEvent()
            ->getName())), array(
            $observer
        ));
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function onDiff($observer) {
        $source = $observer->getSource();
        $newData = $observer->getHold()->getNew();
        $oldData = $observer->getHold()->getOld();

        // some magic to generate category_ids for Product, but only category ids are set
        if ($source instanceof Mage_Catalog_Model_Product && isset($newData['category_ids'])) {
            $oldCatIds = $newData['category_ids'];

            if (isset($newData['affected_category_ids'])) {
                foreach ($newData['affected_category_ids'] as $a) {
                    if (in_array($a, $oldCatIds)) {
                        $oldCatIds = array_diff($oldCatIds, [$a]);
                    } else {
                        array_push($oldCatIds, $a);
                    }
                    sort($oldCatIds);
                }
                unset($newData['affected_category_ids']);
            }

            $oldData['category_ids'] = $oldCatIds;

            $observer->getHold()->setNew($newData);
            $observer->getHold()->setOld($oldData);
        }
    }

    /**
     *
     * @param $source
     * @param $key
     * @param $origValue
     * @param $newValue
     * @param number $level
     * @return boolean
     * @deprecated
     */
    protected function _conditionalExcludeKey($source, $key, $origValue, $newValue, $level = 0)
    {
        if (empty($newValue) && $newValue != 0 && empty($origValue) && $origValue != 0
            || strpos($key, '_cache_') === 0
            || strpos($key, '_is_formated') !== false && $newValue == true && empty($origValue)
            || strpos($key, 'use_config_') !== false && $newValue == true && empty($origValue)
            || $key == 'parent_id' && $newValue == 0 && empty($origValue) || $key == 'post_index'  // Gilt für Änderung an Adressen
            || $key == 'created_at'
            || $key == 'updated_at'
            || $key == 'is_active' && $origValue == true && empty($newValue)
            || $key == 'attribute_set_id' && $origValue == 0 && empty($newValue)
            || $key == 'is_customer_save_transaction'
            || $key == 'is_saved'
            || $key == 'is_default_billing' && $newValue == true && empty($origValue)
            || $key == 'is_default_shipping' && $newValue == true && empty($origValue)
            || $key == 'is_default_base_address' && $newValue == true && empty($origValue)
            || $key == 'customer_id' && $level == 0 && empty($origValue) && !empty($newValue) && $source instanceof Mage_Customer_Model_Address
            || $key == 'store_id' && $level == 0 && empty($origValue) && !empty($newValue) && $source instanceof Mage_Customer_Model_Address
            || $key == 'original_group_id'
            || $key == 'current_password'
            || $key == 'password'
            || $key == 'new_password'
            || $key == 'password_confirmation'
            || $key == 'password_hash'
            || $key == 'postcode_checked'
            || $key == 'can_save_custom_options'
            || $key == 'form_key') {
            return true;
        }

        if ($source instanceof Mage_Customer_Model_Customer) {
            if ($key == 'tax_class_id') {
                return true;
            }
        }

        if ($source instanceof Mage_Catalog_Model_Product) {
            if ($key == 'use_config_manage_stock') {
                return true;
            }
        }

        // exclude media_gallery stuff variables
        if ($origValue === null && $newValue === 'no_selection' && $level === 2) {
            return true;
        }

        if (strpos($key, 'tab_admin') !== false) {
            return true;
        }

        return false;
    }

    /**
     * returns names of blacklisted classes
     * @return array
     */
    protected function _getClassNames() {
        if ($this->_class_names === null) {
            $data = Mage::getConfig()->getNode('b3it_modelhistory/blacklist/names')->asArray();
            $this->_class_names = array_values($data);
        }
        return $this->_class_names;
    }

    /**
     * returns names of ignored attributes
     * class => [attributes]
     * @return array[]
     */
    protected function _getIgnoredAttributes() {
        if ($this->_ignored_attributes === null) {
            $data = Mage::getConfig()->getNode('b3it_modelhistory/ignore_attributes')->asArray();

            $result = [];

            // might need better way to combine it?
            foreach ($data as $v) {
                if (!is_array($v['attributes'])) {
                    continue;
                }
                $attrs = array_values($v['attributes']);
                if (isset($result[$v['class']])) {
                    $result[$v['class']] = array_merge($result[$v['class']], $attrs);
                } else {
                    $result[$v['class']] = $attrs;
                }
            }

            $this->_ignored_attributes = $result;
        }
        return $this->_ignored_attributes;
    }

    /**
     * returns attribute matches to be ignored
     * class => [matches]
     * @return array[]
     */
    protected function _getIgnoredAttributeMatches() {
        if ($this->_ignored_attribute_matches === null) {
            $data = Mage::getConfig()->getNode('b3it_modelhistory/ignore_attributes')->asArray();

            $result = [];
            foreach ($data as $v) {
                if (!isset($v['matches'])) {
                    continue;
                }
                $result[$v['class']] = array_values($v['matches']);
            }

            $this->_ignored_attribute_matches = $result;
        }
        return $this->_ignored_attribute_matches;
    }

    /**
     * returns default value for class => attribute
     * @return array
     */
    protected function _getDefaultAttributes() {
        if ($this->_default_attributes === null) {
            $data = Mage::getConfig()->getNode('b3it_modelhistory/default_attributes')->asArray();
            $result = [];
            foreach ($data as $v) {
                if (is_array($v['attributes'])) {
                    $attrs = [];
                    foreach ($v['attributes'] as $a) {
                        $attrs[$a['name']] = $a['value'];
                    }
                    $result[$v['class']] = $attrs;
                }
            }
            $this->_default_attributes = $result;
        }
        return $this->_default_attributes;
    }

    /**
     * returns matches for blacklisted classes
     * @return array
     */
    protected function _getMatchNames() {
        if ($this->_match_names === null) {
            $data = Mage::getConfig()->getNode('b3it_modelhistory/blacklist/matches')->asArray();
            $this->_match_names = array_values($data);
        }
        return $this->_match_names;
    }

    protected function _isKeyIgnored($source, $key) {
        $strKey = implode("/", $key);
        foreach ($this->_getIgnoredAttributes() as $klass => $attrs) {
            if (($source instanceof $klass) && in_array($strKey, $attrs)) {
                return true;
            }
        }
        foreach ($this->_getIgnoredAttributeMatches() as $klass => $matches) {
            if (($source instanceof $klass)) {
                // TODO use regex?
                foreach ($matches as $match) {
                    if (strpos($strKey, $match) !== false) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    protected function _isDefaultValue($source, $key, $value) {
        $strKey = implode("/", $key);
        foreach ($this->_getDefaultAttributes() as $klass => $attrs) {
            if ($source instanceof $klass) {
                if (isset($attrs[$strKey])) {
                    return $attrs[$strKey] == $value;
                }
            }
        }
        // in theory each empty value is treat as not set
        if (empty($value)) {
            return true;
        }
        return false;
    }

    protected function _updateOldValue($source, $parent, $key, &$oldValue, $level)
    {
        $combinedKey = array_merge($parent, [
            $key
        ]);
        // if key is ignored for source, make the value null
        if ($this->_isKeyIgnored($source, $combinedKey)) {
            $oldValue = null;
        } else if (is_array($oldValue)) {
            $this->_filterOldData($source, $oldValue, $combinedKey, $level + 1);
            if (empty($oldValue)) {
                $oldValue = null;
            }
        }
    }

    protected function _updateNewValue($source, $parent, $key, $oldValue, &$newValue, $level)
    {
        $combinedKey = array_merge($parent, [
            $key
        ]);
        if ($this->_isKeyIgnored($source, $combinedKey)) {
            $newValue = null;
        } else if (is_array($newValue)) {
            $this->_filterNewData($source, $oldValue, $newValue, $combinedKey, $level + 1);
            if (empty($newValue)) {
                $newValue = null;
            }
        } else if (!isset($oldValue)) {
            // do default check only if oldValue isn't set
            if ($this->_isDefaultValue($source, $combinedKey, $newValue)) {
                $newValue = null;
            }
        } else if ($oldValue !== $newValue && $oldValue == $newValue){
            // old value == new value but not ===, means it it nearly identical, but type did change?
            $newValue = $oldValue;
        }
    }

    protected function _filterOldData($source, &$oldData, $parent = [], $level = 0)
    {
        array_walk($oldData, function (&$innerValue, $innerKey) use ($source, $parent, $level) {
            $this->_updateOldValue($source, $parent, $innerKey, $innerValue, $level);
        });
        $oldData = array_filter($oldData, function ($innerValue) {
            return !is_null($innerValue);
        });
    }

    protected function _filterNewData($source, $oldData, &$newData, $parent = [], $level = 0)
    {
        array_walk($newData, function (&$innerValue, $innerKey) use ($source, $parent, $oldData, $level) {
            $this->_updateNewValue($source, $parent, $innerKey, is_array($oldData) && isset($oldData[$innerKey]) ? $oldData[$innerKey] : null, $innerValue, $level);
        });
        $newData = array_filter($newData, function ($innerValue) {
            return !is_null($innerValue);
        });
    }
}