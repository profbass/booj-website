<?php
use Blog\Models\Post as Post;
use \Laravel\Config as Config;

class Blog_Post_Controller extends Blog_Base_Controller {

    public function get_index($id = false)
    {
        $this->view_arguments['data'] = Post::get_post_from_uri($id);
        $this->view_arguments['disgus_id'] = Config::get('Blog::blog.disgus_short_name');
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