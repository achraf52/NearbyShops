<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Likes_model extends MY_Model {
	public function __construct() {
		parent::__construct();

		// Set database table
		$this->table = 'likes';
	}

	public function get_likes($user_id) {
		// Initialize the likes array in case there is no likes shops
		$likes = array();

		// Fetch table for the list of likes shop ids by the user
		$query = $this->get_all_entries('user_id', $user_id);

		if( is_array($query) ) {
			// Go through the query results
			foreach ($query as $object => $row) {
				// Assign each row as a shop id
				$likes[$row->id] = $row->shop_id;
			}

			// Return likes array
			return $likes;
		} else {
			// Table query failed
			return false;
		}
	}

	public function add_like($user_id, $shop_id) {
		// Check whether the user hasn't already liked this shop
		$this->db->where('user_id', $user_id);
		$row_exists = $this->get_by_key('shop_id', $shop_id);

		// If that's the case and such row doesn't exist
		if($row_exists === FALSE) {
			// Place insert operation values into an array
			$data = array(
				'user_id' => $user_id,
				'shop_id' => $shop_id,
			);

			// Execute the insert operation into the table
			return $this->add_new_entry($data);
		} else {
			// Avoid inserting duplicate
			return false;
		}
	}

	public function remove_like($user_id, $shop_id) {
		// Select the like row by user id
		$this->db->where('user_id', $user_id);

		// Delete the shop id like corresponding to that user
		return $this->delete_by_key('shop_id', $shop_id);
	}
}
