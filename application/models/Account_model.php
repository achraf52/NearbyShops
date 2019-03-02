<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends MY_Model {
	public function __construct() {
		parent::__construct();

		// Set database table
		$this->table = 'users';
	}

	public function register($username, $password) {
		// Hash the password
		$password = pwdHash($password);

		// Place insert operation values into an array
		$data = array(
			'username' => $username,
			'password' => $password,
		);

		// Execute the insert operation into the table
		if( $this->add_new_entry($data) ) {
			// Account registered successfully
			return true;
		} else {
			// An error occured
			return false;
		}
	}

	public function login($username, $password_entered_plain) {
		// Execute the login query with provided username
		$account_data = $this->get_by_key('username', $username);
		// If an array is returned then the operation succeeded, else is failure
		if ( is_object($account_data) ) {
			// Retrieve the corresponding password of the provided username
			$password_hash_database = $account_data->password;
			// Check if the stored entered password hash and the password hash matches
			if(pwdCheck($password_entered_plain, $password_hash_database) === FALSE) {
				// Wrong password entered
				return false;
			} else {
				// Return account id
				return $account_data->id;
			}
		} else {
			// Username not found in table
			return false;
		}
	}
}