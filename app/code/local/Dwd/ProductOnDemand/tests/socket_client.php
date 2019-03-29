<?php
/**
 * Created by PhpStorm.
 * User: Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * Date: 28.03.2019
 * Time: 12:00
 */
$_baseUrl = 'tls://kunden.dwd.de:443';
$errno = 0;
$errstr = null;
$context = stream_context_create(
    array(
        'ssl' => array(
            'verify_peer' => false,
            'capath' => '/etc/ssl/certs',
            'disable_compression' => true,
            'capture_session_meta' => TRUE,
            'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT,
            "honor_cipher_order"    => TRUE,
        )
    )
);
$handle = stream_socket_client($_baseUrl, $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $context);
if ($handle === false) {
    echo "Error:: $errno : $errstr\n";
    die;
}
fclose($handle);
