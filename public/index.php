<?php

require __DIR__ . '/../bootstrap/start.php';

use Vortex\Config\Config;
use Vortex\Database\DB;

// Load configuration array
Config::setDirScan(__DIR__ . '/../app/config/');

// Check if the website is in maintenance mode
Config::maintenanceMode(
	Config::get('maintenance'),
	Config::get('maintenance_template')
);

$db = new DB(new Config);

// length of the session and cleanup
ini_set('session.gc_maxlifetime', Config::get('session_life'));
ini_set('session.gc_probability', 1);

// default timezone
date_default_timezone_set(Config::get('timezone'));

// save sessions to a custom folder
if(Config::get('session') === true) {
	$sessionsPath = Config::get('sessions_path');
	if (!is_dir($sessionsPath)) {
		mkdir($sessionsPath, 0775, true);
	}
	session_save_path($sessionsPath);
}

// Starting the session
session_start();

// Routes File
// Urls and locations
require __DIR__ . '/../app/routes.php';
