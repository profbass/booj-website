<?php

use Blog\Models\Post as Post;
use Blog\Models\Category as Category;
use Blog\Models\Tag as Tag;
use Blog\Models\Author as Author;
use Content\Models\Menuitem as Menuitem;
use \Laravel\Config as Config;

class Blog_Base_Controller extends Controller {
    public $restful = true;
    public $layout = 'layouts.main';
    public $action_urls = array();
    public $controller_alias = '';
    public $view_arguments = array();

    public function __construct()
    {
        parent::__construct();

        $base = Config::get('Blog::blog.blog_url');
        $domain = Config::get('Blog::blog.domain');

        $this->action_urls =  $this->view_arguments['action_urls'] = array(
            'domain' => $domain,
            'blog' => $base,
            'author' => $base . '/authors',
            'tag' => $base . '/categories',
            'category' => $base . '/categories',
            'subscribe' => $base . '/subscribe',
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://twitter.com/',
            'google_plus' => 'https://plus.google.com/',
        );

        $this->controller_alias =  $this->view_arguments['controller_alias'] = $base;
        
        $this->view_arguments['current_uri'] = Request::uri();
        $this->view_arguments['page_data'] = Menuitem::get_page_by_uri(str_replace('/', '', $base));
        $this->view_arguments['popular_authors'] = Author::get_most_popular(Config::get('Blog::blog.number_popular_authors'));
        $this->view_arguments['popular'] = Post::get_most_popular_posts(Config::get('Blog::blog.number_popular_posts'));
        $this->view_arguments['categories'] = Category::get_categories();
        // $this->view_arguments['tags'] = Tag::get_tags();

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