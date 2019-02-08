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
                static::$dbLockResult[$lockKey] = $lockResult;
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
     * Returns 1 if the lock was obtained, 0 if the lock was already obtained,
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
     * Returns 1 if the lock was obtained, 0 if the lock was already obtained,
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
     * Returns 1 if the lock was obtained, 0 if the lock was already obtained,
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

        return $this->releaseApcuLock($lockKey);;
    }
}