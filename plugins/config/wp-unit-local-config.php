<?php
//phpcs:disable
/**
 * Config used by wp-unit to run tests on GitHub Actions.
 *
 * @version 1.0.0
 */
$root = dirname( __DIR__, 5 );

define( 'DB_NAME', 'wp-unit' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );

define( 'ABSPATH', $root . '/wp/' );
define( 'BOOTSTRAP', $root . '/wp-unit/includes/bootstrap-no-install.php' );
define( 'WP_UNIT_DIR', $root . '/wp-unit' );
define( 'WP_TESTS_DIR', $root );
define( 'WP_CONTENT_DIR', $root . '/content' );
