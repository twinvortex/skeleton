<?php

namespace Vortex\Config;

/**
 * Class Config
 * This class is used to get and retrieve config files and values
 *
 * @package Vortex\Config
 */
class Config {

	private static $get = [];
	private static $fileExtension = '.php';

	/**
	 * Get config values from an array of files
	 * This function is an alias of setRequire
	 *
	 * @param array $files
	 */
	public static function setFiles(array $files)
	{
		self::setRequire($files);
	}

	/**
	 * Scan a folder for config files
	 * @param $dirName
	 */
	public static function setDirScan($dirName)
	{
		$files = scandir($dirName);
		$path = $dirName;

		self::setRequire($files, $path);
	}

	/**
	 * Include list of php files
	 *
	 * @param $files
	 * @param null $path
	 */
	public static function setRequire($files, $path = null)
	{
		foreach($files as $file) {
			if(isset($path)) {
				$fileName = $path . '/' . $file;
			} else {
				$fileName = $file;
			}
			if(file_exists($fileName) && (is_file($fileName)) && ($file != '.') && ($file != '..') && (substr($file, -4) == static::$fileExtension)) {
				$array = require $fileName;
				foreach($array as $key => $value) {
					static::$get[$key] = $value;
				}
			}
		}
	}

	/**
	 * Get the value of an array from the include files
	 *
	 * @param null $first
	 * @param null $second
	 *
	 * @return mixed
	 */
	public static function get($first = null, $second = null)
	{
		if($first != null && $second != null) {
			return static::$get[$first][$second] ?? false;
		} else if($first != null && $second == null) {
			return static::$get[$first] ?? false;
		} else if($first == null && $second == null) {
			return static::$get;
		}

		return false;
	}

	/**
	 * Check if the webapp is in maintenance mode or not
	 *
	 * @param $maintenance
	 * @param $path
	 * @param string $file
	 */
	public static function maintenanceMode($maintenance, $path, $file = 'index.php')
	{
		if($maintenance == true) {
			require $path . '/' . $file;
			exit();
		}
	}

	/**
	 * This is used for checking the database if it's development or production
	 *
	 * @return bool|string
	 */
	public static function start() {
		if(static::get('stage') == 'development') {
			return 'development';
		} elseif(static::get('stage') == 'production') {
			return 'production';
		}

		return false;
	}

	/**
	 * Get all the values from the included file
	 *
	 * @return mixed
	 */
	public static function all() {
		return static::$get;
	}

	/**
	 * Return only the urls from the config files
	 *
	 * @return mixed
	 */
	public static function getUrls() {
		return static::get('urls');
	}
}
