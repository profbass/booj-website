<?php

use Blog\Models\Post as Post;
use Blog\Models\Category as Category;
use Blog\Models\Tag as Tag;
use Admin\Models\User as User;
use \Laravel\Config as Config;


class Blog_Admin_Post_Controller extends Admin_Base_Controller {
    public $restful = true;

	public function __construct()
	{
		parent::__construct();
      
		// only grant access to people in these groups
		$this->filter('before', 'user_in_group', array(array('Super User', 'Administrator', 'Blog Contributor')));

        $this->controller_alias = $this->admin_alias . '/blog/post';
        $this->view_arguments['controller_alias'] = $this->controller_alias;
	}

	public function get_index()
	{
		$this->view_arguments['blog_url'] = Config::get('Blog::blog.blog_url');
		$this->view_arguments['posts'] = Post::get_posts_for_admin();

		return View::make('blog::admin.post.index', $this->view_arguments);
	}

	public function get_destroy($id = FALSE)
	{
		$test = Post::remove_post_by_id($id);
		if ($test) {
			return Redirect::to(URL::to_action('admin::blog.post'))->with('success_message', 'Post Deleted.');
		}
		return Redirect::to(URL::to_action('admin::blog.post'))->with('error_message', 'An Error Occured.');
	}

	public function get_create()
	{
		$this->view_arguments['categories'] = Category::get_categories();
		$this->view_arguments['small_image'] = Config::get('Blog::blog.small_photo');
		$this->view_arguments['main_image'] = Config::get('Blog::blog.main_photo');
		$this->view_arguments['tags'] = Tag::get_tags();
		$this->view_arguments['users'] = Auth::user()->all();
		$this->view_arguments['curr_user_id'] = Auth::user()->id;
		
		return View::make('blog::admin.post.create', $this->view_arguments);
	}

	public function post_store()
	{
		$input = Input::all();

		$rules = array(
			'title' => 'required|unique:posts',
			'short_title' => 'required',
			'main_photo' => 'required|mimes:jpg,gif,png,jpeg',
			'small_photo' => 'required|mimes:jpg,gif,png,jpeg',
			'category_id' => 'required',
			'is_published' => 'required',
			'created_at' => 'required',
			'user_id' => 'required',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);
		} else {
			$test = Post::create_new($input);
			if ($test) {
				return Redirect::to(URL::to_action('admin::blog.post'))->with('success_message', 'Post Created.');
			}
		}
		return Redirect::to(URL::to_action('admin::blog.post'))->with('error_message', 'An Error Occured.');
	}

	public function get_edit_photos($id = FALSE)
	{
		$this->view_arguments['post'] = Post::get_by_id($id);
		$this->view_arguments['small_image'] = Config::get('Blog::blog.small_photo');
		$this->view_arguments['main_image'] = Config::get('Blog::blog.main_photo');
		return View::make('blog::admin.post.edit_photos', $this->view_arguments);
	}

	public function post_save_photos($id = FALSE)
	{
		$input = Input::all();
		
		$rules = array();

		if ($input['submit'] == 'main-photo') {
			$rules['main_photo'] = 'required|mimes:jpg,gif,png,jpeg';
		}
		if ($input['submit'] == 'small-photo') {
			$rules['small_photo'] = 'required|mimes:jpg,gif,png,jpeg';
		}

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);;
		} else {
			$test = Post::update_post_photo_by_id($id, $input['submit'], $input);
			if ($test) {
				return Redirect::back()->with('success_message', 'Photo Updated.');
			}
		}
		return Redirect::back()->with('error_message', 'An Error Occured.');
	}


	public function get_edit($id = FALSE)
	{
		$this->view_arguments['categories'] = Category::get_categories();
		$this->view_arguments['tags'] = Tag::get_tags();
		$this->view_arguments['users'] = Auth::user()->all();
		$this->view_arguments['post'] = Post::get_by_id($id);

		return View::make('blog::admin.post.edit', $this->view_arguments);
	}

	public function post_save($id = FALSE)
	{
		$input = Input::all();
		
		$rules = array(
			'title' => 'required|unique:posts,title,' . $id,
			'short_title' => 'required',
			'category_id' => 'required',
			'user_id' => 'required',
			'is_published' => 'required',
			'created_at' => 'required',
			'slug' => 'required|unique:posts,slug,' . $id,
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Redirect::back()->with_input()->with_errors($validation);;
		} else {
			$test = Post::save_post_by_id($id, $input);
			if ($test) {
				return Redirect::back()->with('success_message', 'Post Saved.');
			}
		}
		return Redirect::back()->with('error_message', 'An Error Occured.');
	}

}