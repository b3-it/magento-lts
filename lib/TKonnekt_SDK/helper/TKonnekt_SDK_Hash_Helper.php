<?php
/**
 * Helferklasse, die die Hash-Generierung verwaltet
 *
 * @package TKonnekt
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @version 1.0.0.0 / 2017-09-07
 */

class TKonnekt_SDK_Hash_Helper
{

    /**
     * Gibt einen HMAC Hash mit sha256-Verschlüsselung zurück, indem er ein Geheimnis und ein Array verwendet
     *
     * @param string $password
     * @param mixed[] $data to hash
     *
     * @return string generated hash
     */
    public static function getHMACSHA256Hash($password, $data) {
        $_dataString = implode('', $data);

        return self::getHMACSHA256HashString($password, $_dataString);
    }

    /**
     * Gibt einen HMAC Hash mit sha256-Verschlüsselung zurück, indem er ein Geheimnis und einen String verwendet
     *
     * @param string $password
     * @param string $data
     * 
     * @return string Hash
     */
    public static function getHMACSHA256HashString($password, $data) {
        if (function_exists('hash_hmac')) {
            return hash_hmac('SHA256', $data, $password);
        }

        throw new TKonnekt_SDK_Exception("HMAC function doesn't exist");
    }
}