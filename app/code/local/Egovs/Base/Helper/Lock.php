<?php

/**
 * Class Egovs_Base_Helper_Lock
 *
 * @category  Egovs
 * @package   Egovs_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Helper_Lock extends Mage_Core_Helper_Abstract
{
    protected static $dbLockResult = array();

    protected static $dbVersion = null;

    protected static $cgiMode = null;

    /**
     * @return bool
     */
    public function isCgiMode() {
        if (static::$cgiMode === null) {
            $cgiMode = false;
            $sapiType = php_sapi_name();
            if (strtolower(substr($sapiType, 0, 3)) === 'cgi') {
                Mage::log("egovs_paymentbase::get lock in CGI mode", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
                $cgiMode = true;
            }
            static::$cgiMode = $cgiMode;
        }

        return static::$cgiMode;
    }

    public function canUseDbLock() {
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */

        if (static::$dbVersion === NULL) {
            try {
                static::$dbVersion = $adapter->fetchOne("SELECT @@version;");
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        if (version_compare(static::$dbVersion, '10.0.2', '>=') || version_compare(static::$dbVersion, '5.7.5', '>=')) {
            Mage::log("egovsbase::dbLock:DB Lock is callable...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            return true;
        }

        return false;
    }

    /**
     * Tries to obtain a lock with a name given by the string $lockKey, using a timeout of timeout seconds.
     * Returns true if the lock was obtained successfully, false if the attempt timed out (for example,
     * because another client has previously locked the name), or NULL if an error occurred
     * (such as running out of memory or the thread was killed with mysqladmin kill).
     *
     * @param     $lockKey
     * @param int $ttl
     *
     * @return bool|null
     */
    public function getDbLock($lockKey, $ttl=300) {
        $lockResult = null;
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */
        try {
            if ($this->canUseDbLock()) {
                /*
                 * Returns 1 if the lock was obtained successfully, 0 if the attempt timed out
                 * (for example, because another client has previously locked the name),
                 * or NULL if an error occurred (such as running out of memory or the thread was killed with mysqladmin kill).
                 * Requires MySQL >= 5.7.5 oder MariaDB >= 10.0.2
                 */
                $lockResult = $adapter->fetchOne("SELECT GET_LOCK(':id', $ttl) as 'lock_result';", array('id' => $lockKey));
                static::$dbLockResult[$lockKey] = (bool) $lockResult;
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $lockResult;
    }

    /**
     *
     * Checks whether the lock named $lockKey is free to use (that is, not locked).
     * Returns 1 if the lock is free (no one is using the lock), 0 if the lock is in use,
     * and NULL if an error occurs (such as an incorrect argument, like an empty string or NULL).
     * $lockKey is case insensitive.
     *
     * @param $lockKey
     *
     * @return bool|null
     */
    public function isFreeLockDb($lockKey) {
        $lockResult = null;
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */
        try {
            if ($this->canUseDbLock()) {
                $lockResult = $adapter->fetchOne("SELECT IS_FREE_LOCK(':id') as 'lock_result';", array('id' => $lockKey));
                if ($lockResult !== null) {
                    $lockResult = (bool) $lockResult;
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $lockResult;
    }

    /**
     * Releases the lock named by the string $lockKey that was obtained with GET_LOCK().
     * Returns 1 if the lock was released, 0 if the lock was not established by this thread (in which case the lock is not released),
     * and NULL if the named lock did not exist.
     * The lock does not exist if it was never obtained by a call to GET_LOCK() or if it has previously been released.
     *
     * @param $lockKey
     *
     * @return null|bool
     */
    public function releaseDbLock($lockKey) {
        $lockResult = null;

        if (!static::$dbLockResult || !isset(static::$dbLockResult[$lockKey])) {
            return $lockResult;
        }
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */
        try {
            if ($this->canUseDbLock()) {
                /*
                 * Returns 1 if the lock was obtained successfully, 0 if the attempt timed out
                 * (for example, because another client has previously locked the name),
                 * or NULL if an error occurred (such as running out of memory or the thread was killed with mysqladmin kill).
                 * Requires MySQL >= 5.7.5 oder MariaDB >= 10.0.2
                 */
                $lockResult = (bool)$adapter->fetchOne("SELECT RELEASE_LOCK(':id') as 'lock_result';", array('id' => $lockKey));
                if ($lockResult == true) {
                    unset(static::$dbLockResult[$lockKey]);
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
        }

        return $lockResult;
    }

    /**
     * Returns true if the lock was obtained, false if the lock was already obtained,
     * and NULL if the lock function did not exist.
     *
     * @param     $lockKey
     * @param int $ttl
     *
     * @return bool|null
     */
    public function getApcLock($lockKey, $ttl=300) {
        if (!$this->isCgiMode() && function_exists('apc_add') && function_exists('apc_fetch')) {
            if (apc_fetch($lockKey)) {
                return false;
            }
            return apc_add($lockKey, true, $ttl);
        }

        return null;
    }

    /**
     * @param string $lockKey
     *
     * @return bool|null
     */
    public function releaseApcLock($lockKey) {
        if (!$this->isCgiMode() && function_exists('apc_delete') && function_exists('apc_fetch') && apc_fetch($lockKey)) {
            return (bool)apc_delete($lockKey);
        }

        return null;
    }

    /**
     * Returns true if the lock was obtained, false if the lock was already obtained,
     * and NULL if the lock function did not exist.
     *
     * @param     $lockKey
     * @param int $ttl
     *
     * @return bool|null
     */
    public function getApcuLock($lockKey, $ttl=300) {
        if (!$this->isCgiMode() && function_exists('apcu_add') && function_exists('apcu_fetch')) {
            if (apcu_fetch($lockKey)) {
                return false;
            }
            return apcu_add($lockKey, true, $ttl);
        }

        return null;
    }

    /**
     * Returns true if the lock is not set, false if the lock was already obtained,
     * and NULL if the lock function did not exist or cgi mode is in use.
     *
     * @param $lockKey
     *
     * @return bool|null
     */
    public function isFreeLockApcu($lockKey) {
        if (!$this->isCgiMode() && function_exists('apcu_fetch')) {
            if (apcu_fetch($lockKey)) {
                return false;
            }
            return true;
        }

        return null;
    }

    /**
     * @param string $lockKey
     *
     * @return bool|null
     */
    public function releaseApcuLock($lockKey) {
        if (!$this->isCgiMode() && function_exists('apcu_delete') && function_exists('apcu_fetch') && apcu_fetch($lockKey)) {
            return (bool)apcu_delete($lockKey);
        }

        return null;
    }

    /**
     * Try to get a lock, returning first working lock.
     * Starts with APC than DB
     *
     * Returns true if the lock was obtained, false if the lock was already obtained,
     * and NULL if the lock function did not exist.
     *
     * @param     $lockKey
     * @param int $ttl
     *
     * @return bool|null
     */
    public function getLock($lockKey, $ttl=300) {
        $cgiMode = $this->isCgiMode();
        $lockResult = null;
        if (!$cgiMode) {
            $lockResult = $this->getApcuLock($lockKey, $ttl);
            if ($lockResult === null) {
                $lockResult = $this->getApcLock($lockKey, $ttl);
            }
        }

        if ($lockResult === null) {
            $lockResult = $this->getDbLock($lockKey, $ttl);
        }

        return $lockResult;
    }

    /**
     * Try to release a lock, returning first released lock.
     * Starts with APC than DB
     *
     * Returns 1 if the lock was released, 0 if the lock was not released,
     * and NULL if the named lock did not exist.
     *
     * @param $lockKey
     *
     * @return bool|null
     */
    public function releaseLock($lockKey) {
        $lockResult = $this->releaseDbLock($lockKey);

        if ($lockResult !== null) {
            return $lockResult;
        }
        $lockResult = $this->releaseApcLock($lockKey);
        if ($lockResult !== null) {
            return $lockResult;
        }

        return $this->releaseApcuLock($lockKey);
    }

    /**
     * Returns true if at least one lock was released
     *
     * @param $lockKey
     *
     * @return bool
     */
    public function releaseAllLocks($lockKey) {
        $lockResultDb = $this->releaseDbLock($lockKey);

        if ($lockResultDb === null) {
            //TODO Result speichern
        }
        $lockResultApc = $this->releaseApcLock($lockKey);
        if ($lockResultApc === null) {
            //TODO Result speichern
        }

        $lockResultApcu = $this->releaseApcuLock($lockKey);
        if ($lockResultApcu === null) {
            //TODO Result speichern
        }

        return $lockResultDb || $lockResultApc || $lockResultApcu;
    }
}