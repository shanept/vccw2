<?php
/**
 * {{ ansible_managed }}
 */

declare(strict_types=1);

/**
 * This is needed for cookie based authentication to encrypt password in
 * cookie.
 */
$cfg['blowfish_secret'] = '{{ pma_blowfish_secret }}';

/**
 * Servers configuration
 */
$cfg['Servers'][1] = [
    /* Authentication Type */
    'auth_type' => 'cookie',

    /* Server Parameters */
    'host' => 'localhost',
    'compress' => false,
    'AllowNoPassword' => false,
];
