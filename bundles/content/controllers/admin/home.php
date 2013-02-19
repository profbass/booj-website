<?php
class Content_Admin_Home_Controller extends Admin_Base_Controller {
    public $restful = true;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_index()
	{
		return View::make('content::admin.index', $this->view_arguments);
	}
}