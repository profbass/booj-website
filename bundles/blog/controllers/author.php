<?php

use Blog\Models\Author as Author;
use \Laravel\Config as Config;
use Blog\Models\Post as Post;

class Blog_Author_Controller extends Blog_Base_Controller {
    
    public function get_index()
    {
        $this->view_arguments['authors'] = Author::get_authors();
        return View::make('blog::author_list', $this->view_arguments);
    }

    public function get_author($slug = FALSE)
    {
        $user = Author::get_author_by_slug($slug, Config::get('Blog::blog.number_author_posts'));
        $this->view_arguments['data']['author'] = $user;
        $this->view_arguments['data']['posts'] = Post::get_posts_by_author($user->id, 4);
        return View::make('blog::author', $this->view_arguments);
    }
}