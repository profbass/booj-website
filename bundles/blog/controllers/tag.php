<?php

use Blog\Models\Tag as Tag;

class Blog_Tag_Controller extends Blog_Base_Controller {

	public function get_index($slug = FALSE)
	{
		if ($slug) {
			$this->view_arguments['data'] = Tag::get_posts_in_tag_by_slug($slug);
		}

        $this->view_arguments['tags'] = Tag::get_tags();

		return View::make('blog::tag', $this->view_arguments);
	}
}