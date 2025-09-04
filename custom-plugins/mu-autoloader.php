<?php
/*
Plugin Name: Network Rail Must Use Plugins
Description: Functionality for the theme
Version: 1.0
Author: Carlos Ortiz


 * This file is for loading all mu-plugins within subfolders
 * where the PHP file name is exactly like the directory name + .php.
 *
 * Example: /mu-tools/mu-tools.php
 */


// require autoload from composer inside the theme
require_once __DIR__ . '/../vendor/autoload.php';

$dirs = glob(dirname(__FILE__) . '/*' , GLOB_ONLYDIR);

foreach($dirs as $dir) {
    if(file_exists($dir . DIRECTORY_SEPARATOR . basename($dir) . ".php")) {
        require($dir . DIRECTORY_SEPARATOR . basename($dir) . ".php");
    }
}