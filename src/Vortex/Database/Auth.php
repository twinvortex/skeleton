<?php

namespace Vortex\Database;

/**
 * Class Auth
 * Used for client authentication and validity using database
 * @package Vortex\Database
 */
class Auth extends DB {

	/**
	 * Login and create session
	 *
	 * @param string $table
	 * @param string $email
	 * @param string $password
	 *
	 * @return bool
	 */
	public function login($table = 'users', $email = '', $password = '') {

		$email         = $this->san($email);
		$plainPassword = $password;

		$sql = "SELECT * FROM $table WHERE email='$email' LIMIT 1";
		if ($result = $this->link->query($sql)) {
			$data = $result->fetch_assoc();
			$result->free();
			if ($data && $data['email'] == $email && password_verify($plainPassword, $data['password'])) {
				if ($this->setSession($table, $data)) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Set the session values
	 *
	 * @param string $table
	 * @param array $data
	 *
	 * @return bool
	 */
	private function setSession($table = 'users', $data = []) {
		if (is_array($data)) {
			$_SESSION[ $table . '_user_id' ]  = $data['id'];
			$_SESSION[ $table . '_username' ] = $data['username'];
			$_SESSION[ $table . '_email' ]    = $data['email'];
			$_SESSION[ $table . '_password' ] = $data['password'];
			$_SESSION[ $table . '_secret' ]   = sha1($table . $data['id'] . $data['email'] . $data['password']);

			if ($table == 'users') {
				$_SESSION[ $table . '_is_active' ] = $data['is_active'];
			}

			return true;
		}

		return false;
	}


	/**
	 * Check if user is logged in
	 *
	 * @param string $table
	 *
	 * @return bool
	 */
	public function isLoggedIn($table = 'users') {

		if (isset($_SESSION[ $table . '_user_id' ]) && is_numeric($_SESSION[ $table . '_user_id' ])) {
			$email    = $this->san($_SESSION[ $table . '_email' ]);
			$password = $this->san($_SESSION[ $table . '_password' ]);

			$sql = "SELECT * FROM $table WHERE email='$email' AND `password`='$password' LIMIT 1";
			if ($result = $this->link->query($sql)) {
				$data = $result->fetch_assoc();
				if ($data && $_SESSION[ $table . '_secret' ] == sha1($table . $data['id'] . $data['email'] . $data['password'])) {
					return true;
				}
			} else {
				echo $this->link->error;
			}
		}

		return false;
	}

	/**
	 * Logout and redirect user to intended page
	 *
	 * @param string $table
	 * @param string $redirectTo
	 */
	public function logout($table = 'users', $redirectTo = '/') {
		unset($_SESSION[ $table . '_user_id' ]);
		unset($_SESSION[ $table . '_username' ]);
		unset($_SESSION[ $table . '_email' ]);
		unset($_SESSION[ $table . '_password' ]);
		unset($_SESSION[ $table . '_secret' ]);
		unset($_SESSION[ $table . '_is_active' ]);
		session_destroy();
		redirect($redirectTo);
		exit();
	}

	public function deleteSessions($table = 'users') {
		unset($_SESSION[ $table . '_user_id' ]);
		unset($_SESSION[ $table . '_username' ]);
		unset($_SESSION[ $table . '_email' ]);
		unset($_SESSION[ $table . '_password' ]);
		unset($_SESSION[ $table . '_secret' ]);
		unset($_SESSION[ $table . '_is_active' ]);
		session_destroy();
	}

	/**
	 * Return password hash
	 *
	 * @param string $password
	 *
	 * @return string
	 */
	public static function pass($password) {
		return password_hash($password, PASSWORD_DEFAULT);
	}

}
