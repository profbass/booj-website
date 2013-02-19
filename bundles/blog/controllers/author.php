<?php

use Blog\Models\Author as Author;

class Blog_Author_Controller extends Blog_Base_Controller {
    
    public function get_index()
    {
        $this->view_arguments['authors'] = Author::get_authors();
        return View::make('blog::author_list', $this->view_arguments);
    }

    public function get_author($slug = FALSE)
    {
        $this->view_arguments['data'] = Author::get_author_by_slug($slug, 4);
        return View::make('blog::author', $this->view_arguments);
    }
}