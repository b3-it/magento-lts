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
     * Enthält bereits verarbeitete ID von ConfigData Objekten
     *
     * @var array
     */
    protected $_processedConfigData = array();

    /**
     * Aktuelle Quelle
     *
     * @var Object
     */
    protected $_source = null;

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
        // prevent loop
        if ($source instanceof B3it_ModelHistory_Model_History
            || $source instanceof B3it_ModelHistory_Model_Config
            || $source instanceof B3it_Modelhistory_Model_Settings) {
                return false;
            }

        /**
         * @var B3it_Modelhistory_Model_Resource_Settings_Collection $collection
         */
        $collection = Mage::getModel("b3it_modelhistory/settings")->getCollection();
        
        foreach ($collection->getItemsByColumnValue('blocked', true) as $type) {
            /**
             * @var B3it_Modelhistory_Model_Settings $type
             */
            $modelName = $type->getData('model');
            if ($source instanceof $modelName) {
                return false;
            } else if (strpos(get_class($source), $modelName) === 0) {
                return false;
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
        if (! $this->_isBackendOperation) {
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
                if (! $this->isAvailable()) {
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
        $this->_source = $source;
        
        $eventName = $observer->getEvent()->getName();

        if (strpos($eventName, 'core_config_data_') === 0) {
            // wird in _onCoreConfigDataSaveCommitAfter geloggt
            return;
        }
        if ($source instanceof Mage_Core_Model_Config_Data && ! isset($this->_processedConfigData[$source->getId()])) {
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
        
        $new = $source->isObjectNew();
        
        if ($origData === null) {
            $origData = [];
        }
        
        if ($source instanceof Mage_Customer_Model_Address && ! empty($id) && ! empty($origData)) {
            if (isset($this->_cached[$className])) {
                // Type bereits vorhanden
                $this->_cached[$className][$source->getId()] = $source->getData();
            } else {
                // Type noch nicht vorhanden -> anlegen
                $this->_cached[$className] = array(
                    $source->getId() => $source->getData()
                );
            }
        } elseif ($source instanceof Mage_Customer_Model_Address && ! empty($id) && empty($origData)) {
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
        
        if (! $source || ! isset($id) || $source->isEmpty()) {
            return;
        }
        
        // TODO : Es müssen noch einige Ausnahmen definiert werden
        if (! $this->isTraceableObject($source)) {
            return;
        }
        
        if (!$new) {
            $diff = array();
            if ($source->dataHasChangedFor('')) {
                try {
                    // $diff = array_diff_assoc($source->getData(), $source->getOrigData());
                    $diff = $this->_arrayDiff($origData, $data);
                } catch (Exception $e) {
                    Mage::log(sprintf("Error: %s, tracing stopped!", $e->getMessage()), Zend_Log::ERR);
                }
            }
    
            if (empty($diff)) {
                return;
            }
        }
        if (isset($this->_cached[$className][$source->getId()])) {
            unset($this->_cached[$className][$source->getId()]);
        }

        // remove empty keys from new data
        $result_data = $this::__myArrayFilter($data, function ($value, $key) use ($origData) {
            if ($this->_conditionalExcludeKey($key, isset($origData[$key]) ? $origData[$key] : null, $value, 0)) {
                return false;
            }

            if (empty($value) && (!isset($origData[$key]) || !empty($origData[$key]))) {
                return false;
            } else {
                return true;
            }
        });

        // filter origData
        $origData = $this::__myArrayFilter($origData, function ($value, $key) use ($result_data) {
            if (empty($value) && !isset($result_data[$key])) {
                return false;
            } else if ($this->_conditionalExcludeKey($key, $value, isset($result_data[$key]) ? $result_data[$key] : null, 0)) {
                return false;
            } else {
                return true;
            }
        });
        
        // filter variables that only did change type from string to integer
        array_walk($result_data, function (&$value, $key) use ($origData) {
            if (isset($origData[$key]) && $origData[$key] == $value) {
                $value = $origData[$key];
            }
        });

        // TODO some specifice fixing, need to expanded later for other models
        if ($source instanceof Mage_Admin_Model_User) {
            // remove some flags
            unset($result_data['page']);
            unset($result_data['limit']);

            if (!is_null($origData)) {
                $keys = array('created', 'reload_acl_flag', 'logdate', 'lognum');
                foreach ($keys as $key) {
                    if (isset($origData[$key])) {
                        $result_data[$key] = $origData[$key];
                    }
                }
            }
        } else if ($source instanceof Mage_Admin_Model_Roles) {
            unset($result_data['name']);
        }

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
        if (! $source || ! isset($id) || $source->isEmpty()) {
            return;
        }
        
        // TODO : Es müssen noch einige Ausnahmen definiert werden
        if (! $this->isTraceableObject($source)) {
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

            $old_value = json_encode($source->getData(), JSON_UNESCAPED_UNICODE);

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
        if (! $data || !$data->isValueChanged() && !$objectNew) {
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
        if (! ($observer instanceof Varien_Event_Observer) || ! $observer->hasEvent()) {
            return;
        }
        
        $this->__call(sprintf('on%s', $this->_camelize($observer->getEvent()
            ->getName())), array(
            $observer
        ));
    }

    /**
     * Liefert einen Diff zwischen zwei Arrays
     *
     * @param array $old
     *            Altes Array
     * @param array $new
     *            Neues Array
     * @param integer $level
     *            Array-level
     *            
     * @return array
     */
    protected function _arrayDiff($old, $new, $level = 0, $parentKey = null)
    {
        /*
        if ($level > 3) {
            return '';
        }
        //*/
        
        if ($old instanceof Varien_Object) {
            $old = $old->getData();
        }
        if ($new instanceof Varien_Object) {
            $new = $new->getData();
        }
        
        if (! is_array($old)) {
            $old = array();
        }
        $keysOld = array_keys($old);
        if (! is_array($new)) {
            $new = array();
        }
        $keysNew = array_keys($new);
        $keys = array_merge($keysNew, $keysOld);
        
        $res = array();
        foreach ($keys as $key) {
            if ($key != '_cache_editable_attributes') {
                $origValue = '';
                $newValue = '';
                if (isset($old[$key])) {
                    $origValue = $old[$key];
                }
                if (isset($new[$key])) {
                    $newValue = $new[$key];
                }
                //*
                //*/
                if ($origValue !== $newValue) {
                    if ((is_array($origValue) or is_object($origValue)) || (is_array($newValue) or is_object($newValue))) {
                        
                        //if ($parentKey === "media_attributes") {
                        //    var_dump([$parentKey, $key, $origValue, $newValue, $level]);
                        //    exit();
                        //}
                        $res[$key] = $this->_arrayDiff($origValue, $newValue, $level + 1, $key);
                        if (empty($res[$key])) {
                            unset($res[$key]);
                        }
                    } else {
                        $origValue = trim($origValue);
                        $newValue = trim($newValue);
                        
                        // Ausnahmen
                        if ($this->_conditionalExcludeKey($key, $origValue, $newValue, $level)) {
                            continue;
                        }

                        if (strpos($key, 'discount_quota') === 0) {
                            // Preis wieder in float umwandeln
                            $origValue = Mage::app()->getLocale()->getNumber($origValue);
                            // Auf 2 Nachkommastellen setzen
                            $origValue = Mage::app()->getStore()->roundPrice($origValue);
                        }
                        
                        // String truncation
                        if (is_string($origValue)) {
                            $origValue = $this->_truncate($origValue);
                        }
                        if (is_string($newValue)) {
                            $newValue = $this->_truncate($newValue);
                        }
                        
                        if ($origValue != $newValue) {
                            $res[$key] = sprintf("OLD: %s|NEW: %s;", $origValue, $newValue);
                        }
                    }
                }
            }
        }
        
        /*
        if ($parentKey === "productfiledescription") {
            var_dump([$parentKey, $old, $new, $level]);
            var_dump($res);
            exit();
        }
        //*/
        return $res;
    }

    protected function _conditionalExcludeKey($key, $origValue, $newValue, $level = 0)
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
            || $key == 'customer_id' && $level == 0 && empty($origValue) && ! empty($newValue) && $this->_source instanceof Mage_Customer_Model_Address
            || $key == 'store_id' && $level == 0 && empty($origValue) && ! empty($newValue) && $this->_source instanceof Mage_Customer_Model_Address
            || $key == 'original_group_id'
            || $key == 'current_password'
            || $key == 'password'
            || $key == 'new_password'
            || $key == 'password_confirmation'
            || $key == 'password_hash'
            || $key == 'form_key') {
            return true;
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

    protected function _truncate($origValue)
    {
        if (! is_string($origValue)) {
            return $origValue;
        }
        
        $len = strlen($origValue);
        $tmp = substr($origValue, 0, min($len, 250));
        if ($len > 250) {
            $tmp .= '...';
        }
        return $tmp;
    }
    

    static protected function __myArrayFilter($array, $closure) {
        if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
            return array_filter($array, $closure, ARRAY_FILTER_USE_BOTH);
        } else {
            $newData = array();
            foreach ($array as $key=>$val) {
                if (call_user_func_array($closure, array($val, $key))) {
                    $newData[$key]= $val;
                }
            }
            return($array);
        }
    }
}