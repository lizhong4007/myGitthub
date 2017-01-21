<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class MY_Controller extends CI_Controller {
	function __construct(){
		header("X-Powered-By:OS");
		parent::__construct();
	}
}