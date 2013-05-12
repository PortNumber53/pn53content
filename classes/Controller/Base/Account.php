<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date: 5/12/13
 * Time: 4:42 AM
 *
 */
 
 class Controller_Base_Account extends Controller_Base_Website
 {

	 public function action_login()
	 {

		 $email = Email::factory('Hello, World', 'This is my body, it is nice.')
			 ->to('mauriciootta@gmail.com')
			 ->from('webmailter@portnumber53.com', 'Server')
			 ->send()
		 ;
		 View::set_global('main', 'account/login');
	 }

	 public function action_sign_up()
	 {


		 View::set_global('main', 'account/sign_up');
	 }

	 public function action_reset_password()
	 {


		 View::set_global('main', 'account/reset_password');
	 }


	 public function action_reset_profile()
	 {


		 View::set_global('main', 'account/profile');
	 }

	 public function action_logout()
	 {


		 View::set_global('main', 'account/logout');
	 }

 }