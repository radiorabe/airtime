<?php

$configRun = false;
$extensions = get_loaded_extensions();
$airtimeSetup = false;

function showConfigCheckPage() {
    global $configRun;
    if (!$configRun) {
        // This will run any necessary setup we need if
        // configuration hasn't been initialized
        checkConfiguration();
    }

    require_once(CONFIG_PATH . 'config-check.php');
    die();
}

function isApiCall() {
    $path = $_SERVER['PHP_SELF'];
    return strpos($path, "api") !== false;
}

// Define application path constants
define('ROOT_PATH', dirname(__DIR__) . '/');
define('BUILD_PATH', ROOT_PATH . 'build/');
define('SETUP_PATH', BUILD_PATH . 'airtime-setup/');
define('APPLICATION_PATH', ROOT_PATH . 'application/');
define('CONFIG_PATH', APPLICATION_PATH . 'configs/');

define("AIRTIME_CONFIG_STOR", "/etc/airtime/");
define('AIRTIME_CONFIG', 'airtime.conf');

// Vendors - include this here so we can call Propel from load.php
set_include_path(ROOT_PATH . '../vendor');
if (!@include_once('propel/propel1/runtime/lib/Propel.php'))
{
    die('Error: Propel not found. Did you install Airtime\'s third-party dependencies with composer? (Check the README.)');
}

require_once(CONFIG_PATH . 'conf.php');
require_once(SETUP_PATH . 'load.php');

// This allows us to pass ?config as a parameter to any page
// and get to the config checklist.
if (array_key_exists('config', $_GET)) {
    showConfigCheckPage();
}

// If a configuration file exists, forward to our boot script
if (file_exists(AIRTIME_CONFIG_STOR . AIRTIME_CONFIG)) {
    require_once(APPLICATION_PATH . 'airtime-boot.php');
}
// Otherwise, we'll need to run our configuration setup
else {
    $airtimeSetup = true;
    require_once(SETUP_PATH . 'setup-config.php');
}
