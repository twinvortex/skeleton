<?php

namespace Vortex\Database;

use Vortex\Config\Config;

/**
 * Class DB
 * This class is used to connect to database and query data from database
 *
 * @package Vortex\Database
 */
class DB extends DBHelper {

	// a link to mysqli
	public $link;

	// configuration values
	private $config;

	// Container for database rows;
	private $data = array();

	// Container for mysqli result
	private $result;

	// Container for the query
	private $sql;

	/**
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;

		if($this->config->get('stage') == 'production') {
			$key = 'production';
		} else if($this->config->get('stage') == 'development') {
			$key = 'development';
		} else {
			exit('No stage set!');
		}

		$this->link = new \mysqli(
			$this->config->get($key, 'host'),
			$this->config->get($key, 'username'),
			$this->config->get($key, 'password'),
			$this->config->get($key, 'database')
		);

		if($this->link->connect_errno) {
			exit('Could not connect to database');
		}
	}

	/**
	 * Returns object with database entries
	 *
	 * @param $sql
	 * @return bool|object
	 */
	public function exec($sql) {

		$this->sql = $sql;
		$data = [];
		if($this->result = $this->link->query($this->sql)) {
			if($this->result->num_rows > 0) {
				while($row = $this->result->fetch_assoc()) {
					$data[] = (object) $row;
				}
				$this->result->free();
			}

			if(!empty($data))
				return (object) $data;
			else
				return false;
		} else {
			$this->showError();
		}

		return false;
	}

	/**
	 * Select one row from database
	 *
	 * @param $table
	 * @param bool $condition
	 *
	 * @return bool|object
	 */
	public function one($table, $condition = false) {
		if($condition) {
			$sql = "SELECT * FROM $table WHERE $condition LIMIT 1";
		} else {
			$sql = "SELECT * FROM $table LIMIT 1";
		}

		$this->sql = $sql;

		if($data = $this->exec($this->sql)) {
			foreach($data as $key)
				return $key;
		}

		return false;
	}

	/**
	 * Query and get total results and convert it into an object
	 * @param $sql
	 *
	 * @return bool|object
	 */
	public function query($sql) {

		$data = [];

		$results = Config::get('max_results');
		$start = $this->start();

		$this->sql = $sql . " LIMIT $start, $results";

		if($this->result = $this->link->query($this->sql)) {
			while($row = $this->result->fetch_assoc()){
				$data[] = (object) $row;
			}

			$this->result->free();

			if(!empty($data))
				return (object) $data;
			else
				return false;
		} else {
			$this->showError();
		}

		return false;
	}

	/**
	 * Count rows with custom argument
	 * @param $field
	 * @param $table
	 * @param string|null $custom
	 *
	 * @return bool|int|string|null
	 */
	public function total($field, $table, $custom = null) {

		$num = null;

		$this->sql = "SELECT COUNT('$field') AS num FROM $table $custom";
		if($this->result = $this->link->query($this->sql)) {
			$row = $this->result->fetch_assoc();
			$num = $row['num'];
			$this->result->free();
		} else {
			$this->showError();
			return false;
		}

		return $num;
	}

}
