<?php

use Blog\Models\Post as Post;
use Blog\Models\Category as Category;

class Blog_Admin_Category_Controller extends Admin_Base_Controller {
    public $restful = true;

	public function __construct()
	{
		parent::__construct();
        $this->controller_alias = $this->admin_alias . '/blog/category';
        $this->view_arguments['controller_alias'] = $this->controller_alias;
	}

	public function get_index()
	{
		
		$this->view_arguments['categories'] = Category::get_categories();

		return View::make('blog::admin.category.index', $this->view_arguments);
	}

	public function get_destroy($id = FALSE)
	{
		$test = Category::remove_by_id($id);
		if ($test) {
			return Redirect::to(URL::to_action('admin::blog.category'))->with('success_message', 'Category Deleted.');
		}
		return Redirect::to(URL::to_action('admin::blog.category'))->with('error_message', 'An Error Occured.');
	}

	public function get_create()
	{
		return View::make('blog::admin.category.create', $this->view_arguments);
	}

	public function post_store()
	{
		$input = Input::all();
		
		$rules = array(
			'title' => 'required|unique:categories',
			'slug' => 'required|unique:categories',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);
		} else {
			$test = Category::store($input);
			if ($test) {
				return Redirect::to(URL::to_action('admin::blog.category'))->with('success_message', 'Category Created.');
			}
		}
		return Redirect::to(URL::to_action('admin::blog.category'))->with('error_message', 'An Error Occured.');
	}

	public function get_edit($id = FALSE)
	{
		$this->view_arguments['category'] = Category::get_by_id($id);

		return View::make('blog::admin.category.edit', $this->view_arguments);
	}

	public function post_save($id = FALSE)
	{
		$input = Input::all();
		
		$rules = array(
			'title' => 'required|unique:categories,title,' . $id,
			'slug' => 'required|unique:categories,slug,' . $id,
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);;
		} else {
			$test = Category::save_by_id($id, $input);
			if ($test) {
				return Redirect::back()->with('success_message', 'Category Saved.');
			}
		}
		return Redirect::back()->with('error_message', 'An Error Occured.');
	}
}