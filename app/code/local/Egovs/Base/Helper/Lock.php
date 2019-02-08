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

    protected function _getDbLock($lockKey, $ttl=300) {
        $lockResult = null;
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */
        try {
            if (self::$dbVersion === null) {
                self::$dbVersion = $adapter->fetchOne("SELECT @@version;");
            }
            if (version_compare(self::$dbVersion, '10.0.2', '>=') || version_compare(self::$dbVersion, '5.7.5', '>=')) {
                Mage::log("egovsbase::dbLock:DB Lock is callable...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
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
    protected function _releaseDbLock($lockKey) {
        $lockResult = null;

        if (!static::$dbLockResult || !isset(static::$dbLockResult[$lockKey])) {
            return $lockResult;
        }
        $adapter = Mage::getSingleton('core/resource')->getConnection('core_write');
        /** @var $adapter \Varien_Db_Adapter_Pdo_Mysql */
        try {
            $dbVersion = $adapter->fetchOne("SELECT @@version;");
            if (version_compare($dbVersion, '10.0.2', '>=') || version_compare($dbVersion, '5.7.5', '>=')) {
                /*
                 * Returns 1 if the lock was obtained successfully, 0 if the attempt timed out
                 * (for example, because another client has previously locked the name),
                 * or NULL if an error occurred (such as running out of memory or the thread was killed with mysqladmin kill).
                 * Requires MySQL >= 5.7.5 oder MariaDB >= 10.0.2
                 */
                $lockResult = (bool)$adapter->fetchOne("SELECT RELEASE_LOCK(':id') as 'lock_result';", array('id' => $lockKey));
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
    protected function _getApcLock($lockKey, $ttl=300) {
        if (function_exists('apc_add') && function_exists('apc_fetch')) {
            if (apc_fetch($lockKey)) {
                return false;
            }
            return apc_add($lockKey, true, $ttl);
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
    protected function _getApcuLock($lockKey, $ttl=300) {
        if (function_exists('apcu_add') && function_exists('apcu_fetch')) {
            if (apcu_fetch($lockKey)) {
                return false;
            }
            return apcu_add($lockKey, true, $ttl);
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
    public function getLock($lockKey, $ttl=300) {
        $cgiMode = false;
        $sapiType = php_sapi_name();
        if (strtolower(substr($sapiType, 0, 3)) == 'cgi') {
            Mage::log("egovs_paymentbase::get lock in CGI mode", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
            $cgiMode = true;
        }
        $lockResult = null;
        if (!$cgiMode) {
            $lockResult = $this->_getApcuLock($lockKey, $ttl);
            if ($lockResult === null) {
                $lockResult = $this->_getApcLock($lockKey, $ttl);
            }
        }

        if ($lockResult === null) {
            $lockResult = $this->_getDbLock($lockKey, $ttl);
        }

        return $lockResult;
    }

    /**
     * Returns 1 if the lock was released, 0 if the lock was not released,
     * and NULL if the named lock did not exist.
     *
     * @param $lockKey
     *
     * @return bool|null
     */
    public function releaseLock($lockKey) {
        $lockResult = $this->_releaseDbLock($lockKey);

        if ($lockResult !== null) {
            return $lockResult;
        }
        if (function_exists('apc_delete') && function_exists('apc_fetch') && apc_fetch($lockKey)) {
            return (bool)apc_delete($lockKey);
        }
        if (function_exists('apcu_delete') && function_exists('apcu_fetch') && apc_fetch($lockKey)) {
            return (bool)apcu_delete($lockKey);
        }
        return $lockResult;
    }
}