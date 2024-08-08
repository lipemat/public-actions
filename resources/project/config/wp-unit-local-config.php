<?php
/**
 * Config used by wp-unit to run tests on GitHub Actions.
 *
 * @version 2.0.0
 */

$root = dirname( __DIR__, 2 );

define( 'DB_NAME', 'wp-unit' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );

define( 'WP_UNIT_DIR', $root . '/wp-unit' );
