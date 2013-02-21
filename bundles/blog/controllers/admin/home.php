<?php
class Blog_Admin_Home_Controller extends Admin_Base_Controller {
    public $restful = true;

	public function __construct()
	{
		parent::__construct();
	
		// only grant access to people in these groups
		$this->filter('before', 'user_in_group', array(array('Administrator', 'Super Administrator', 'Blog Author')));
	}

	public function get_index()
	{
		return View::make('blog::admin.index', $this->view_arguments);
	}
}