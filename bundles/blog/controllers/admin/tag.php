<?php

use Blog\Models\Post as Post;
use Blog\Models\Tag as Tag;

class Blog_Admin_Tag_Controller extends Admin_Base_Controller {
    public $restful = true;

	public function __construct()
	{
		parent::__construct();
        $this->controller_alias = $this->admin_alias . '/blog/tag';
        $this->view_arguments['controller_alias'] = $this->controller_alias;
	}

	public function get_index()
	{
		
		$this->view_arguments['tags'] = Tag::get_tags();

		return View::make('blog::admin.tag.index', $this->view_arguments);
	}

	public function get_destroy($id = FALSE)
	{
		$test = Tag::remove_by_id($id);
		if ($test) {
			return Redirect::to(URL::to_action('admin::blog.tag'))->with('success_message', 'Tag Deleted.');
		}
		return Redirect::to(URL::to_action('admin::blog.tag'))->with('error_message', 'An Error Occured.');
	}

	public function get_create()
	{
		return View::make('blog::admin.tag.create', $this->view_arguments);
	}

	public function post_store()
	{
		$input = Input::all();
		
		$rules = array(
			'title' => 'required|unique:tags',
			'slug' => 'required|unique:tags',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);
		} else {
			$test = Tag::store($input);
			if ($test) {
				return Redirect::to(URL::to_action('admin::blog.tag'))->with('success_message', 'Tag Created.');
			}
		}
		return Redirect::to(URL::to_action('admin::blog.tag'))->with('error_message', 'An Error Occured.');
	}

	public function get_edit($id = FALSE)
	{
		$this->view_arguments['tag'] = Tag::get_by_id($id);

		return View::make('blog::admin.tag.edit', $this->view_arguments);
	}

	public function post_save($id = FALSE)
	{
		$input = Input::all();
		
		$rules = array(
			'title' => 'required|unique:tags,title,' . $id,
			'slug' => 'required|unique:tags,slug,' . $id,
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);;
		} else {
			$test = Tag::save_by_id($id, $input);
			if ($test) {
				return Redirect::back()->with('success_message', 'Tag Saved.');
			}
		}
		return Redirect::back()->with('error_message', 'An Error Occured.');
	}
}