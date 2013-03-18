<?php

use Blog\Models\Post as Post;

class Blog_Rss_Controller extends Blog_Base_Controller {

    public function get_subscribe_email()
    {
        return View::make('blog::subscribe_email_form', $this->view_arguments);
    }

    public function post_subscribe_email()
    {
        // go do something;
        return View::make('blog::subscribe_email_form', $this->view_arguments);
    }

    public function get_feed()
    {
        $name = $_SERVER['DOCUMENT_ROOT'] . '/rss/feed.xml';

    	if (file_exists($name)) {
    		return file_get_contents($name);
    	} else {
    		return Response::error('404');
    	}
    }
}