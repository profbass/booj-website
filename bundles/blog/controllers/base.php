<?php

use Blog\Models\Post as Post;
use Blog\Models\Category as Category;
use Blog\Models\Tag as Tag;
use Blog\Models\Author as Author;
use Content\Models\Menuitem as Menuitem;

class Blog_Base_Controller extends Controller {
    public $restful = true;
    public $layout = 'layouts.main';
    public $action_urls = array();
    public $controller_alias = '';
    public $view_arguments = array();

    public function __construct()
    {
        parent::__construct();
        $this->action_urls =  $this->view_arguments['action_urls'] = array(
            'domain' => 'http://www.booj.com',
            'blog' => '/blog',
            'author' => '/blog/authors',
            'tag' => '/blog/tags',
            'category' => '/blog/categories',
            'subscribe' => '/blog/subscribe',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'google_plus' => 'https://plus.google.com/',
        );

        $this->controller_alias =  $this->view_arguments['controller_alias'] = '/blog';
        
        $this->view_arguments['current_uri'] = Request::uri();
        $this->view_arguments['page_data'] = Menuitem::get_page_by_uri('blog');
        $this->view_arguments['popular_authors'] = Author::get_most_popular(5);
        $this->view_arguments['popular'] = Post::get_most_popular_posts();
        $this->view_arguments['categories'] = Category::get_categories();
    }
    
    /**
     * Catch-all method for requests that can't be matched.
     *
     * @param  string    $method
     * @param  array     $parameters
     * @return Response
     */
    public function __call($method, $parameters)
    {
        return Response::error('404');
    }
}