<?php
use Blog\Models\Post as Post;
use Blog\Libraries\DisqusAPI as DisqusAPI;

class Blog_Post_Controller extends Blog_Base_Controller {

    public function get_index($id = false)
    {
        $secret_key = 'lHncZarPi8pHQxNSqTYoKfZP1leo4rsYGxBygyxgXsy7f35sLl6QRgGyXeGEUElQ';
        $this->view_arguments['data'] = Post::get_post_from_uri($id);
        return View::make('blog::post', $this->view_arguments);
    }

    public function get_search()
    {
    	$this->view_arguments['data'] = FALSE;
        return View::make('blog::search', $this->view_arguments);
    }

    public function post_search()
    {
		$input = Input::all();
    	$this->view_arguments['data'] = Post::search_posts($input);
        return View::make('blog::search', $this->view_arguments);
    }
}