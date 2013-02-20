<?php

use Admin\Models\User as User;

class Admin_MyAccount_Controller extends Admin_Base_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->controller_alias = $this->admin_alias . '/myaccount';
        $this->view_arguments['controller_alias'] = $this->controller_alias;
	}

	public function get_index()
	{
		$this->view_arguments['user'] = User::get_user_by_id(Auth::user()->id);
		return View::make('admin::my_account.index', $this->view_arguments);
	}

	public function post_change_password($id = FALSE)
	{
		$input = Input::all();
		
		$rules = array(
			'password' => 'required',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);
		} else {
			$test = User::update_user_password($id, $input);
			if ($test) {
				return Redirect::back()->with('success_message', 'User updated.');
			} else {
				return Redirect::back()->with_input()->with('error_message', 'Error Occured');
			}	
		}	
	}
}