<?php

use Blog\Models\Post as Post;
use \Laravel\Config as Config;

class Blog_Home_Controller extends Blog_Base_Controller {

    public function get_index()
    {
        $this->view_arguments['posts'] = Post::get_posts(Config::get('Blog::blog.homepage_post_count'));
        return View::make('blog::index', $this->view_arguments);
    }
}