<?php

use Blog\Models\Post as Post;

class Blog_Home_Controller extends Blog_Base_Controller {

    public function get_index()
    {
        $this->view_arguments['posts'] = Post::get_posts(5);
        return View::make('blog::index', $this->view_arguments);
    }
}