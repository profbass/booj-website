<?php

use Blog\Models\Category as Category;

class Blog_Category_Controller extends Blog_Base_Controller {

	public function get_index($slug = FALSE)
	{
		if ($slug) {
			$this->view_arguments['data'] = Category::get_posts_in_category_by_slug($slug);
		}
		return View::make('blog::category', $this->view_arguments);
	}
}