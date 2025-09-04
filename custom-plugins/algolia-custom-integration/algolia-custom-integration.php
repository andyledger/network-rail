<?php 

/**
 * Plugin Name:     Algolia Custom Integration
 * Description:     Add Algolia Search feature
 * Text Domain:     algolia-custom-integration
 * Version:         1.0.0
 *
 * @package         Algolia_Custom_Integration
 */

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
  echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
  exit;
}

require_once __DIR__ . '/vendor/autoload.php';

global $algolia;

$algolia = \Algolia\AlgoliaSearch\SearchClient::create("UWXBMB9OS2", "692fe6af6cda4ebe29f612b595b2c661");

require_once __DIR__ . '/filters.php';
require_once __DIR__ . '/wp-cli-algolia.php';
require_once __DIR__ . '/admin-page.php';
require_once __DIR__ . '/actions.php';



