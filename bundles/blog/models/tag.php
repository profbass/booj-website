<?php

namespace Blog\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Database as DB;
use \Laravel\Config as Config;

class Tag extends Eloquent {
	public static $timestamps = true;
	public static $table = 'tags';

	public static function get_tags()
	{
		return Tag::order_by('title', 'ASC')->get();
	}
	
	protected function make_slug($name) 
	{
		$name = preg_replace( '/[^a-z0-9_-]/', '', str_replace(' ', '-', strtolower(trim(trim($name)))));
		return str_replace('--', '-', $name);
	}

	public static function remove_by_id($id = FALSE)
	{
		if ($id) {
			$tag = Tag::find($id);
			if ($tag) {
				$affected = DB::table('post_tag')
					->where('tag_id', '=', $tag->id)
					->delete()
				;
				$tag->delete();
				return TRUE;
			}
		}
		return FALSE;
	}

	public static function get_by_id($id = FALSE)
	{
		if ($id) {
			$tag = Tag::find($id);
			if ($tag) {
				return $tag;
			}
		}
		return FALSE;
	}

	public static function save_by_id($id = FALSE, $data = array())
	{
		if ($id) {
			$tag = Tag::find($id);
			if ($tag) {
				$tag->title = $data['title'];
				$tag->slug = $tag->make_slug($data['slug']);
				$tag->save();
				return TRUE;
			}
		}
		return FALSE;
	}	

	public static function store($data = array())
	{
		$tag = new Tag;
		if ($tag) {
			$tag->title = $data['title'];
			$tag->slug = $tag->make_slug($data['slug']);
			$tag->save();
			return TRUE;
		}
		return FALSE;
	}

	public static function get_tag_by_slug($slug = FALSE)
	{
		$tag = array();
		if ($slug) {
			$tag = Tag::where('slug', '=', $slug)->first();
		}
		if (empty($tag)) {
			$tag = FALSE;
		}
		return $tag;
	}

	public static function get_posts_in_tag_by_slug($slug = FALSE, $count = FALSE) 
	{
		$num = $count ? $count : Config::get('Blog::blog.paging_count');
		if ($slug) {
			$tag = Tag::get_tag_by_slug($slug);
			if ($tag) {
				$posts = $tag->posts()->where('is_published', '=', 1)->order_by('created_at', 'DESC')->paginate($num);

				return array(
					'tag' => $tag,
					'posts' => $posts,
				);
			}
		}
		return FALSE;
	}

	public function posts()
	{
		return $this->has_many_and_belongs_to('Blog\Models\Post');
	}
}