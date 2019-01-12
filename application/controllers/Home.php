<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index()
	{
		// Insert page title into the variables array
		$variables['pageSubTitle'] = 'Home';

		// Load header and navbar views
		$this->load->view('page_structure/header', $variables);
		$this->load->view('page_structure/navbar');
		
		// Load the main page view
		$this->load->view('home');

		// Load footer view
		$this->load->view('page_structure/footer');
	}
}
