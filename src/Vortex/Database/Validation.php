<?php

namespace Vortex\Database;

use Vortex\Config\Config;

/**
 * Class Validation
 * @package Vortex\Database
 */
class Validation extends DB {

	public $errors = array();
	private $db;

	/**
	 * Connect to database and inject config dependency
	 */
	public function __construct() {
		$this->db = new DB( new Config );
	}

	/**
	 * Main validation function
	 *
	 * @param $data
	 * @param $rules
	 *
	 * @return bool
	 */
	public function validate( $data, $rules ) {
		$valid = true;

		foreach ( $rules as $fieldName => $rule ) {
			$callbacks = explode( '|', $rule );
			foreach ( $callbacks as $callback ) {
				$value = isset( $data[ $fieldName ] ) ? $data[ $fieldName ] : null;
				if ( preg_match( '/(min_length|max_length)/', $callback, $functionName ) ) {
					if ( preg_match( '/([0-9]+)/', $callback, $matches ) ) {
						$size   = (int) $matches[0];
						$method = $functionName[0];
						if ( $this->$method( $value, $size, $fieldName ) == false ) {
							$valid = false;
						}
					}
				} else if ( preg_match( '/exists\[([a-z]+)\]/', $callback, $table ) ) {
					$parts  = explode( '[', $callback );
					$method = $parts[0];
					if ( $this->$method( $value, $fieldName, $table[1] ) == false ) {
						$valid = false;
					}
				} else if ( $this->$callback( $value, $fieldName ) == false ) {
					$valid = false;
				}
			}

		}

		return $valid;
	}


	/**
	 * Check if the value is a valid email
	 *
	 * @param $value
	 * @param $fieldName
	 *
	 * @return mixed
	 */
	public function email( $value, $fieldName ) {
		$valid = filter_var( $value, FILTER_VALIDATE_EMAIL );
		if ( $valid == false ) {
			$this->setError( $fieldName, "needs to be a valid email" );
		}

		return $valid;
	}


	/**
	 * Verify if the value is required
	 *
	 * @param $value
	 * @param $fieldName
	 *
	 * @return bool
	 */
	public function required( $value, $fieldName ) {
		$valid = ! empty( $value );
		if ( $valid == false ) {
			$this->setError( $fieldName, "is required" );
		}

		return $valid;
	}

	/**
	 * The min_length of a string
	 *
	 * @param $value
	 * @param $length
	 * @param $fieldName
	 *
	 * @return bool
	 */
	public function min_length( $value, $length, $fieldName ) {
		$valid = ! empty( $value );
		if ( strlen( (string) $value ) < $length ) {
			$this->setError( $fieldName, 'needs to have at least ' . $length . ' characters' );
			$valid = false;
		}

		return $valid;
	}

	/**
	 * The max length of a string
	 *
	 * @param $value
	 * @param $length
	 * @param $fieldName
	 *
	 * @return bool
	 */
	public function max_length( $value, $length, $fieldName ) {
		$valid = ! empty( $value );
		if ( strlen( (string) $value ) > $length ) {
			$this->setError( $fieldName, 'size is too big, maximum allowed characters is ' . $length );
			$valid = false;
		}

		return $valid;
	}


	/**
	 * Validate confirm password
	 *
	 * @param $value
	 * @param $fieldName
	 *
	 * @return bool
	 */
	public function confirm_password( $value, $fieldName = null ) {
		$valid = ! empty( $value );
		if ( ! isset( $_POST['confirm_password'] ) || $value != $_POST['confirm_password'] ) {
			$this->errors[] = 'Passwords do not match';
			$valid          = false;
		}

		return $valid;
	}


	/**
	 * Check if the value, field name from form and table from database exists
	 *
	 * @param $value
	 * @param $fieldName
	 * @param $table
	 *
	 * @return bool
	 */
	public function exists( $value, $fieldName, $table ) {
		$valid     = ! empty( $value );
		$value     = $this->db->san( $value );
		$fieldName = $this->db->san( $fieldName );
		$table     = $this->db->san( $table );

		$sql = "SELECT * FROM `$table` WHERE `$fieldName`='$value' LIMIT 1";
		if ( $result = $this->db->link->query( $sql ) ) {
			if ( $result->num_rows > 0 ) {
				$this->errors[] = ucfirst( htmlentities( strip_tags( $fieldName ) ) ) . ' already exists';
				$valid          = false;
			}
		}

		return $valid;
	}

	/**
	 * Add a validation error
	 *
	 * @param $fieldName
	 * @param $message
	 */
	private function setError( $fieldName, $message ) {
		$fieldName      = str_replace( '_', ' ', $fieldName );
		$this->errors[] = 'The ' . htmlentities( strip_tags( $fieldName ) ) . ' ' . $message;
	}

}
